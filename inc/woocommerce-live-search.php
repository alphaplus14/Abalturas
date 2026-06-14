<?php
/**
 * Búsqueda predictiva de productos WooCommerce (AJAX).
 *
 * @package Abalturas
 */

defined( 'ABSPATH' ) || exit;

/**
 * IDs de productos publicados que coinciden con el término (nombre, SKU, excerpt, categoría).
 *
 * @param string $term  Texto de búsqueda (mín. 2 caracteres).
 * @param int    $limit Máximo de resultados.
 * @return int[]
 */
function abalturas_get_live_search_product_ids( string $term, int $limit = 6 ): array {
	global $wpdb;

	$term = wc_clean( wp_unslash( $term ) );
	if ( strlen( $term ) < 2 ) {
		return array();
	}

	$limit = max( 1, min( 6, $limit ) );
	$like  = '%' . $wpdb->esc_like( $term ) . '%';
	$ids   = array();

	$sku_ids = $wpdb->get_col(
		$wpdb->prepare(
			"SELECT pm.post_id FROM {$wpdb->postmeta} pm
			INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
			WHERE pm.meta_key = '_sku' AND pm.meta_value LIKE %s
			AND p.post_type = 'product' AND p.post_status = 'publish'
			LIMIT %d",
			$like,
			$limit * 3
		)
	);

	$cat_ids = $wpdb->get_col(
		$wpdb->prepare(
			"SELECT DISTINCT tr.object_id FROM {$wpdb->term_relationships} tr
			INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = 'product_cat'
			INNER JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
			INNER JOIN {$wpdb->posts} p ON tr.object_id = p.ID
			WHERE (t.name LIKE %s OR t.slug LIKE %s)
			AND p.post_type = 'product' AND p.post_status = 'publish'
			LIMIT %d",
			$like,
			$like,
			$limit * 3
		)
	);

	$text_query = new WP_Query(
		array(
			'post_type'              => 'product',
			'post_status'            => 'publish',
			'posts_per_page'         => $limit * 3,
			's'                      => $term,
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	$ids = array_merge(
		array_map( 'absint', (array) $sku_ids ),
		array_map( 'absint', (array) $cat_ids ),
		array_map( 'absint', (array) $text_query->posts )
	);

	$ids = array_values( array_unique( array_filter( $ids ) ) );

	$visible = array();
	foreach ( $ids as $product_id ) {
		$product = wc_get_product( $product_id );
		if ( $product && $product->is_visible() ) {
			$visible[] = $product_id;
		}
		if ( count( $visible ) >= $limit ) {
			break;
		}
	}

	return $visible;
}

/**
 * URL de resultados completos (formulario clásico + SEO).
 *
 * @param string $term Término buscado.
 */
function abalturas_get_product_search_url( string $term ): string {
	return add_query_arg(
		array(
			's'         => $term,
			'post_type' => 'product',
		),
		home_url( '/' )
	);
}

/**
 * Datos JSON de un producto para el dropdown.
 *
 * @param WC_Product $product Producto.
 * @return array<string, mixed>
 */
function abalturas_format_live_search_product( WC_Product $product ): array {
	$image_id  = $product->get_image_id();
	$image_url = $image_id
		? wp_get_attachment_image_url( $image_id, 'woocommerce_thumbnail' )
		: wc_placeholder_img_src( 'woocommerce_thumbnail' );

	return array(
		'id'         => $product->get_id(),
		'name'       => $product->get_name(),
		'url'        => $product->get_permalink(),
		'price_html' => wp_kses_post( $product->get_price_html() ),
		'image'      => esc_url( $image_url ? $image_url : '' ),
	);
}

/**
 * Renderiza el buscador con contenedor para dropdown AJAX.
 *
 * @param array<string, mixed> $args id, listbox_id, wrapper_class, field_class, input_class, placeholder, hidden_sm.
 */
function abalturas_render_live_product_search( array $args = array() ): void {
	if ( ! function_exists( 'WC' ) ) {
		return;
	}

	$defaults = array(
		'id'             => 'site-search-ab',
		'listbox_id'     => '',
		'wrapper_class'  => 'abalturas-live-search hidden sm:block',
		'form_class'     => 'abalturas-live-search__form',
		'field_class'    => 'abalturas-live-search__field flex min-w-[11rem] max-w-[18rem] items-center gap-2 overflow-hidden rounded-md border border-slate-300 bg-white px-2.5 py-1.5 text-slate-600 shadow-sm focus-within:border-industrial/50 focus-within:ring-2 focus-within:ring-industrial/20 xl:min-w-[13rem] xl:max-w-[22rem] xl:px-3 xl:py-2',
		'input_class'    => 'abalturas-live-search__input min-h-8 w-full min-w-0 border-0 bg-transparent text-sm font-medium text-slate-800 outline-none placeholder:text-slate-500',
		'placeholder'    => __( 'Buscar productos, marcas o categorías…', 'abalturas' ),
		'hidden_sm'      => true,
		'mobile_context' => false,
	);

	$args         = wp_parse_args( $args, $defaults );
	$listbox_id   = $args['listbox_id'] ? $args['listbox_id'] : $args['id'] . '-results';
	$search_action = esc_url( home_url( '/' ) );
	$label         = esc_attr__( 'Buscar productos', 'abalturas' );
	?>
	<div class="<?php echo esc_attr( $args['wrapper_class'] ); ?>" data-abalturas-live-search>
		<form role="search" method="get" class="<?php echo esc_attr( $args['form_class'] ); ?>" action="<?php echo $search_action; ?>">
			<label class="sr-only" for="<?php echo esc_attr( $args['id'] ); ?>"><?php echo esc_html( $label ); ?></label>
			<span class="<?php echo esc_attr( $args['field_class'] ); ?>">
				<svg class="abalturas-live-search__icon size-4 shrink-0 text-industrial xl:size-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
				<input
					id="<?php echo esc_attr( $args['id'] ); ?>"
					class="<?php echo esc_attr( $args['input_class'] ); ?>"
					type="search"
					name="s"
					value=""
					placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>"
					autocomplete="off"
					autocapitalize="off"
					spellcheck="false"
					aria-autocomplete="list"
					aria-expanded="false"
					aria-controls="<?php echo esc_attr( $listbox_id ); ?>"
					data-abalturas-live-search-input
				/>
				<input type="hidden" name="post_type" value="product" />
				<span class="abalturas-live-search__spinner" aria-hidden="true" hidden></span>
			</span>
			<div
				id="<?php echo esc_attr( $listbox_id ); ?>"
				class="abalturas-live-search__dropdown"
				role="listbox"
				aria-label="<?php echo esc_attr__( 'Resultados de productos', 'abalturas' ); ?>"
				hidden
			>
				<div class="abalturas-live-search__status" data-live-search-status hidden></div>
				<ul class="abalturas-live-search__list" data-live-search-list></ul>
				<a class="abalturas-live-search__view-all" data-live-search-view-all href="#" hidden>
					<?php esc_html_e( 'Ver todos los resultados', 'abalturas' ); ?>
				</a>
			</div>
		</form>
	</div>
	<?php
}

/**
 * Handler AJAX — búsqueda en vivo.
 */
function abalturas_ajax_live_product_search(): void {
	check_ajax_referer( 'abalturas_live_search', 'nonce' );

	$term = isset( $_GET['term'] ) ? sanitize_text_field( wp_unslash( $_GET['term'] ) ) : '';

	if ( strlen( $term ) < 2 ) {
		wp_send_json_success(
			array(
				'items'      => array(),
				'total'      => 0,
				'search_url' => abalturas_get_product_search_url( $term ),
			)
		);
	}

	$product_ids = abalturas_get_live_search_product_ids( $term, 6 );
	$items       = array();

	foreach ( $product_ids as $product_id ) {
		$product = wc_get_product( $product_id );
		if ( ! $product ) {
			continue;
		}
		$items[] = abalturas_format_live_search_product( $product );
	}

	wp_send_json_success(
		array(
			'items'      => $items,
			'total'      => count( $items ),
			'search_url' => abalturas_get_product_search_url( $term ),
		)
	);
}
add_action( 'wp_ajax_abalturas_live_product_search', 'abalturas_ajax_live_product_search' );
add_action( 'wp_ajax_nopriv_abalturas_live_product_search', 'abalturas_ajax_live_product_search' );

/** Encola assets del buscador predictivo. */
add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( is_admin() || ! function_exists( 'WC' ) ) {
			return;
		}

		$js_path  = get_stylesheet_directory() . '/assets/js/live-product-search.js';
		$css_path = get_stylesheet_directory() . '/assets/css/live-product-search.css';

		if ( ! is_readable( $js_path ) || ! is_readable( $css_path ) ) {
			return;
		}

		$deps = array();
		if ( wp_style_is( 'abalturas-site-brand', 'registered' ) || wp_style_is( 'abalturas-site-brand', 'enqueued' ) ) {
			$deps[] = 'abalturas-site-brand';
		}

		wp_enqueue_style(
			'abalturas-live-product-search',
			get_stylesheet_directory_uri() . '/assets/css/live-product-search.css',
			$deps,
			filemtime( $css_path )
		);

		wp_enqueue_script(
			'abalturas-live-product-search',
			get_stylesheet_directory_uri() . '/assets/js/live-product-search.js',
			array(),
			filemtime( $js_path ),
			true
		);

		wp_localize_script(
			'abalturas-live-product-search',
			'abalturasLiveSearch',
			array(
				'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'abalturas_live_search' ),
				'action'   => 'abalturas_live_product_search',
				'minChars' => 2,
				'debounce' => 300,
				'i18n'     => array(
					'loading'  => __( 'Buscando productos…', 'abalturas' ),
					'empty'    => __( 'No se encontraron productos', 'abalturas' ),
					'viewAll'  => __( 'Ver todos los resultados', 'abalturas' ),
					'minChars' => __( 'Escribe al menos 2 caracteres', 'abalturas' ),
				),
			)
		);
	},
	25
);
