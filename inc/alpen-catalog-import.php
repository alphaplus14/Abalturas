<?php
/**
 * Importación del catálogo Alpen desde products_parsed.json → productos WooCommerce.
 *
 * Alineado con productos cargados manualmente:
 * - SKU en MAYÚSCULAS (EXTREMO-00138-..., HM-AP090B-...)
 * - Imagen destacada desde export PDF o adjunto existente con nombre SKU
 * - Descripción técnica del catálogo + extracto corto
 *
 * @package Abalturas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * SKU al estilo WooCommerce manual del sitio.
 *
 * @param string $name Nombre del producto.
 */
function abalturas_catalog_sku_from_name( string $name ): string {
	$sku = preg_replace( '/[^a-zA-Z0-9]+/', '-', trim( $name ) );
	$sku = preg_replace( '/-+/', '-', (string) $sku );
	$sku = trim( (string) $sku, '-' );
	$sku = strtoupper( $sku );
	if ( strlen( $sku ) > 96 ) {
		$sku = substr( $sku, 0, 96 );
	}
	return $sku !== '' ? $sku : 'SKU';
}

/**
 * Busca adjunto en medios por nombre de archivo que contenga el SKU.
 *
 * @param string $sku SKU del producto.
 */
function abalturas_find_attachment_by_sku_filename( string $sku ): int {
	global $wpdb;
	if ( '' === $sku ) {
		return 0;
	}
	$like = '%' . $wpdb->esc_like( $sku ) . '%';
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
	$id = $wpdb->get_var(
		$wpdb->prepare(
			"SELECT p.ID FROM {$wpdb->posts} p
			INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
			WHERE p.post_type = 'attachment'
			AND pm.meta_key = '_wp_attached_file'
			AND pm.meta_value LIKE %s
			ORDER BY p.ID DESC
			LIMIT 1",
			$like
		)
	);
	return $id ? (int) $id : 0;
}

/**
 * Sube imagen local al producto (nombre de archivo = SKU).
 *
 * @param string $file_path Ruta absoluta al archivo.
 * @param int    $product_id ID del producto.
 * @param string $sku SKU para el nombre del archivo.
 */
function abalturas_attach_product_image_file( string $file_path, int $product_id, string $sku ): int {
	if ( ! is_readable( $file_path ) ) {
		return 0;
	}

	$existing = abalturas_find_attachment_by_sku_filename( $sku );
	if ( $existing ) {
		set_post_thumbnail( $product_id, $existing );
		return $existing;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$ext      = pathinfo( $file_path, PATHINFO_EXTENSION );
	$ext      = $ext ? strtolower( $ext ) : 'jpg';
	$tmp_name = wp_tempnam( $sku . '.' . $ext );
	if ( ! $tmp_name ) {
		return 0;
	}
	if ( ! copy( $file_path, $tmp_name ) ) {
		@unlink( $tmp_name ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
		return 0;
	}

	$file_array = array(
		'name'     => $sku . '.' . $ext,
		'tmp_name' => $tmp_name,
	);

	$attachment_id = media_handle_sideload( $file_array, $product_id );
	if ( is_wp_error( $attachment_id ) ) {
		@unlink( $tmp_name ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
		return 0;
	}

	set_post_thumbnail( $product_id, $attachment_id );
	return (int) $attachment_id;
}

/**
 * Resuelve ruta de imagen para una fila del JSON.
 *
 * @param array<string,mixed> $row Fila del catálogo.
 */
function abalturas_resolve_catalog_image_path( array $row ): string {
	$export = trailingslashit( get_stylesheet_directory() ) . 'assets/catalogoAlpen_export/';
	$sku    = isset( $row['sku'] ) ? (string) $row['sku'] : '';

	if ( ! empty( $row['image_file'] ) ) {
		$candidate = $export . ltrim( (string) $row['image_file'], '/\\' );
		if ( is_readable( $candidate ) ) {
			return $candidate;
		}
	}

	if ( '' !== $sku ) {
		foreach ( array( 'png', 'jpg', 'jpeg', 'webp' ) as $ext ) {
			$candidate = $export . $sku . '.' . $ext;
			if ( is_readable( $candidate ) ) {
				return $candidate;
			}
		}
	}

	return '';
}

/**
 * Primer párrafo usable como descripción corta.
 *
 * @param string $text Texto del catálogo.
 */
function abalturas_catalog_short_description( string $text ): string {
	$text = trim( preg_replace( '/\s+/', ' ', str_replace( array( "\r", "\n" ), ' ', $text ) ) );
	if ( '' === $text ) {
		return '';
	}
	$parts = preg_split( '/(?<=[.!?])\s+/', $text, 2 );
	$short = isset( $parts[0] ) ? trim( (string) $parts[0] ) : $text;
	if ( strlen( $short ) > 320 ) {
		$short = substr( $short, 0, 317 ) . '…';
	}
	return $short;
}

/**
 * Obtiene o crea la categoría de producto para el catálogo Alpen.
 *
 * @return int ID de término o 0 si falla.
 */
function abalturas_get_alpen_product_cat_id() {
	static $cached = null;
	if ( null !== $cached ) {
		return $cached;
	}
	$cached = 0;
	$term   = get_term_by( 'slug', 'alpen-catalogo', 'product_cat' );
	if ( $term && ! is_wp_error( $term ) ) {
		$cached = (int) $term->term_id;
		return $cached;
	}
	$result = wp_insert_term(
		'Alpen Catálogo',
		'product_cat',
		array(
			'slug'        => 'alpen-catalogo',
			'description' => __( 'Equipos importados desde el catálogo Alpen PDF.', 'abalturas' ),
		)
	);
	if ( is_wp_error( $result ) ) {
		return $cached;
	}
	$cached = (int) $result['term_id'];
	return $cached;
}

/**
 * Importa productos desde JSON (solo crea si el SKU no existe).
 *
 * @return array{created:int,skipped:int,images:int}|false
 */
function abalturas_import_alpen_catalog_products() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return false;
	}
	$path = trailingslashit( get_stylesheet_directory() ) . 'assets/catalogoAlpen_export/products_parsed.json';
	if ( ! is_readable( $path ) ) {
		return false;
	}
	$raw = file_get_contents( $path ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	if ( false === $raw ) {
		return false;
	}
	$items = json_decode( $raw, true );
	if ( ! is_array( $items ) ) {
		return false;
	}

	$made    = 0;
	$skipped = 0;
	$images  = 0;

	foreach ( $items as $row ) {
		if ( empty( $row['name'] ) ) {
			continue;
		}
		$name = wp_strip_all_tags( (string) $row['name'] );
		$sku  = ! empty( $row['sku'] ) ? strtoupper( sanitize_text_field( (string) $row['sku'] ) ) : abalturas_catalog_sku_from_name( $name );
		if ( wc_get_product_id_by_sku( $sku ) ) {
			++$skipped;
			continue;
		}
		// Evita duplicados si el lookup de WooCommerce no ve el producto recién creado.
		global $wpdb;
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$exists = (int) $wpdb->get_var(
			$wpdb->prepare(
				"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_sku' AND meta_value = %s LIMIT 1",
				$sku
			)
		);
		if ( $exists ) {
			++$skipped;
			continue;
		}

		$price = isset( $row['regular_price'] ) ? (string) $row['regular_price'] : '';
		if ( '' === $price || ! is_numeric( $price ) ) {
			continue;
		}

		$desc_raw    = isset( $row['description'] ) ? trim( (string) $row['description'] ) : '';
		$desc_html   = $desc_raw !== '' ? wpautop( esc_html( $desc_raw ) ) : '';
		$short_desc  = abalturas_catalog_short_description( $desc_raw );
		$stock       = isset( $row['stock_status'] ) ? $row['stock_status'] : 'instock';
		$valid_stock = array( 'instock', 'outofstock', 'onbackorder' );
		if ( ! in_array( $stock, $valid_stock, true ) ) {
			$stock = 'instock';
		}

		$product = new WC_Product_Simple();
		$product->set_name( $name );
		$product->set_status( 'publish' );
		$product->set_catalog_visibility( 'visible' );
		$product->set_sku( $sku );
		$product->set_regular_price( $price );
		$product->set_description( $desc_html );
		$product->set_short_description( $short_desc );
		$product->set_manage_stock( false );
		$product->set_stock_status( $stock );

		$saved_id = $product->save();
		if ( ! $saved_id ) {
			continue;
		}
		++$made;

		$image_path = abalturas_resolve_catalog_image_path( $row );
		if ( '' !== $image_path ) {
			$att = abalturas_attach_product_image_file( $image_path, $saved_id, $sku );
			if ( $att ) {
				++$images;
			}
		}
	}

	return array(
		'created' => $made,
		'skipped' => $skipped,
		'images'  => $images,
	);
}

/**
 * Primera importación automática al cargar el escritorio (una vez).
 */
function abalturas_maybe_auto_import_alpen_catalog() {
	if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}
	if ( get_option( 'abalturas_alpen_catalog_import_v1' ) ) {
		return;
	}
	$path = trailingslashit( get_stylesheet_directory() ) . 'assets/catalogoAlpen_export/products_parsed.json';
	if ( ! is_readable( $path ) ) {
		return;
	}
	$result = abalturas_import_alpen_catalog_products();
	if ( false === $result ) {
		return;
	}
	update_option(
		'abalturas_alpen_catalog_import_v1',
		array(
			'time'    => time(),
			'created' => (int) $result['created'],
			'images'  => (int) $result['images'],
		)
	);
	add_action(
		'admin_notices',
		static function () use ( $result ) {
			echo '<div class="notice notice-success is-dismissible"><p>';
			echo esc_html(
				sprintf(
					/* translators: 1: products created, 2: images attached */
					__( 'Catálogo Alpen: %1$d productos nuevos, %2$d con imagen.', 'abalturas' ),
					(int) $result['created'],
					(int) $result['images']
				)
			);
			echo '</p></div>';
		}
	);
}

add_action( 'admin_init', 'abalturas_maybe_auto_import_alpen_catalog', 5 );

/**
 * Herramientas → Importar catálogo Alpen (re-ejecutar creación de faltantes).
 */
function abalturas_register_alpen_import_tool_page() {
	add_management_page(
		__( 'Importar catálogo Alpen', 'abalturas' ),
		__( 'Importar Alpen', 'abalturas' ),
		'manage_options',
		'abalturas-import-alpen',
		'abalturas_render_alpen_import_tool_page'
	);
}

add_action( 'admin_menu', 'abalturas_register_alpen_import_tool_page' );

/**
 * Página de herramienta de importación.
 */
function abalturas_render_alpen_import_tool_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Permisos insuficientes.', 'abalturas' ) );
	}
	$ran    = false;
	$result = null;
	if ( isset( $_POST['abalturas_import_alpen'] ) && check_admin_referer( 'abalturas_import_alpen_action', 'abalturas_import_alpen_nonce' ) ) {
		$result = abalturas_import_alpen_catalog_products();
		$ran    = true;
	}
	$path = trailingslashit( get_stylesheet_directory() ) . 'assets/catalogoAlpen_export/products_parsed.json';
	$ok   = is_readable( $path );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Importar catálogo Alpen', 'abalturas' ); ?></h1>
		<p><?php esc_html_e( 'Crea productos que aún no existan (por SKU en mayúsculas). Asigna imagen del PDF exportado o adjunto existente con el mismo nombre. No sobrescribe productos ya cargados.', 'abalturas' ); ?></p>
		<?php if ( ! class_exists( 'WooCommerce' ) ) : ?>
			<div class="notice notice-error"><p><?php esc_html_e( 'WooCommerce no está activo.', 'abalturas' ); ?></p></div>
		<?php elseif ( ! $ok ) : ?>
			<div class="notice notice-warning"><p><?php esc_html_e( 'No se encuentra products_parsed.json. Ejecuta extract_catalog_pdf.py y parse_catalog_alpen.py.', 'abalturas' ); ?></p></div>
		<?php else : ?>
			<?php if ( $ran && is_array( $result ) ) : ?>
				<div class="notice notice-success"><p>
					<?php
					echo esc_html(
						sprintf(
							/* translators: 1: created, 2: skipped, 3: images */
							__( 'Importación: %1$d nuevos, %2$d omitidos (SKU existente), %3$d con imagen.', 'abalturas' ),
							(int) $result['created'],
							(int) $result['skipped'],
							(int) $result['images']
						)
					);
					?>
				</p></div>
			<?php endif; ?>
			<form method="post">
				<?php wp_nonce_field( 'abalturas_import_alpen_action', 'abalturas_import_alpen_nonce' ); ?>
				<p><button type="submit" name="abalturas_import_alpen" class="button button-primary" value="1"><?php esc_html_e( 'Importar productos faltantes', 'abalturas' ); ?></button></p>
			</form>
			<hr/>
			<p><?php esc_html_e( 'Flujo recomendado:', 'abalturas' ); ?></p>
			<ol>
				<li><code>python tools/extract_catalog_pdf.py assets/catalogoAlpen.pdf assets/catalogoAlpen_export</code></li>
				<li><code>python tools/parse_catalog_alpen.py</code></li>
				<li><?php esc_html_e( 'Importar aquí. Para imágenes de mejor calidad, sube PNG con nombre SKU (ej. HM-AP090B-....png) antes de importar.', 'abalturas' ); ?></li>
			</ol>
		<?php endif; ?>
	</div>
	<?php
}
