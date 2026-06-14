<?php
/**
 * Ficha de producto: secciones legibles (descripción en bloques).
 *
 * @package Abalturas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Limpia HTML importado (h2 vacíos, separadores) antes de trocear secciones.
 *
 * @param string $html Contenido de la descripción larga.
 */
function abalturas_clean_product_description_html( string $html ): string {
	$html = preg_replace( '/<h2[^>]*>\s*<\/h2>/i', '', $html );
	$html = preg_replace( '/<hr[^>]*>/i', '', $html );

	return trim( $html );
}

/**
 * Slug estable para anclas de sección.
 *
 * @param string $title Título visible de la sección.
 */
function abalturas_product_info_section_slug( string $title ): string {
	$slug = sanitize_title( remove_accents( wp_strip_all_tags( $title ) ) );

	return $slug !== '' ? $slug : 'seccion';
}

/**
 * Tipo visual de sección según el título (icono + variante CSS).
 *
 * @param string $title Título de la sección.
 */
function abalturas_product_info_section_variant( string $title ): string {
	$normalized = strtolower( remove_accents( wp_strip_all_tags( $title ) ) );

	if ( str_contains( $normalized, 'caracterist' ) ) {
		return 'features';
	}
	if ( str_contains( $normalized, 'especificacion' ) || str_contains( $normalized, 'ficha tecnica' ) ) {
		return 'specs';
	}
	if ( str_contains( $normalized, 'beneficio' ) || str_contains( $normalized, 'ventaja' ) ) {
		return 'benefits';
	}
	if ( str_contains( $normalized, 'aplicacion' ) || str_contains( $normalized, 'uso' ) ) {
		return 'usage';
	}
	if ( str_contains( $normalized, 'norma' ) || str_contains( $normalized, 'certific' ) ) {
		return 'compliance';
	}

	return 'overview';
}

/**
 * Divide la descripción larga en bloques según encabezados H2.
 *
 * @param string $html Contenido HTML de la descripción.
 * @return array<int, array{slug: string, title: string, body: string, variant: string}>
 */
function abalturas_parse_product_description_sections( string $html ): array {
	$html = abalturas_clean_product_description_html( $html );

	if ( $html === '' ) {
		return array();
	}

	if ( ! preg_match( '/<h2/i', $html ) ) {
		return array(
			array(
				'slug'    => 'descripcion',
				'title'   => __( 'Descripción', 'abalturas' ),
				'body'    => $html,
				'variant' => 'overview',
			),
		);
	}

	$chunks = preg_split( '/(?=<h2[^>]*>)/i', $html );
	$sections = array();

	foreach ( $chunks as $chunk ) {
		$chunk = trim( $chunk );
		if ( $chunk === '' ) {
			continue;
		}

		if ( preg_match( '/<h2[^>]*>(.*?)<\/h2>(.*)/is', $chunk, $matches ) ) {
			$title = trim( wp_strip_all_tags( $matches[1] ) );
			$body  = trim( $matches[2] );

			if ( $title === '' ) {
				continue;
			}

			$slug = abalturas_product_info_section_slug( $title );
			$sections[] = array(
				'slug'    => $slug,
				'title'   => $title,
				'body'    => $body,
				'variant' => abalturas_product_info_section_variant( $title ),
			);
			continue;
		}

		$sections[] = array(
			'slug'    => 'descripcion',
			'title'   => __( 'Descripción', 'abalturas' ),
			'body'    => $chunk,
			'variant' => 'overview',
		);
	}

	$used_slugs = array();
	foreach ( $sections as $index => $section ) {
		$base = $section['slug'];
		$suffix = 2;
		while ( isset( $used_slugs[ $section['slug'] ] ) ) {
			$section['slug'] = $base . '-' . $suffix;
			++$suffix;
		}
		$used_slugs[ $section['slug'] ] = true;
		$sections[ $index ] = $section;
	}

	return $sections;
}

/**
 * Icono SVG por variante de sección.
 *
 * @param string $variant Clave de variante.
 */
function abalturas_product_info_section_icon( string $variant ): string {
	$icons = array(
		'overview'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
		'features'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5-2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
		'specs'      => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16M4 12h10M4 17h16"/>',
		'benefits'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>',
		'usage'      => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
		'compliance' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5-2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
	);

	$path = isset( $icons[ $variant ] ) ? $icons[ $variant ] : $icons['overview'];

	return '<svg class="ab-product-info-section__icon-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">' . $path . '</svg>';
}

/**
 * Renderiza las secciones de descripción como tarjetas.
 *
 * @param string $html Contenido de la descripción larga.
 */
function abalturas_render_product_description_sections( string $html ): void {
	$sections = abalturas_parse_product_description_sections( $html );

	if ( empty( $sections ) ) {
		echo '<p class="ab-product-info-empty">' . esc_html__( 'Este producto aún no tiene descripción detallada.', 'abalturas' ) . '</p>';
		return;
	}

	echo '<div class="ab-product-info-sections">';

	foreach ( $sections as $section ) {
		$section_id = 'ab-product-section-' . $section['slug'];
		?>
		<section
			id="<?php echo esc_attr( $section_id ); ?>"
			class="ab-product-info-section ab-product-info-section--<?php echo esc_attr( $section['variant'] ); ?>"
			aria-labelledby="<?php echo esc_attr( $section_id ); ?>-title"
		>
			<header class="ab-product-info-section__head">
				<span class="ab-product-info-section__icon" aria-hidden="true">
					<?php echo abalturas_product_info_section_icon( $section['variant'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</span>
				<h3 id="<?php echo esc_attr( $section_id ); ?>-title" class="ab-product-info-section__title">
					<?php echo esc_html( $section['title'] ); ?>
				</h3>
			</header>
			<div class="ab-product-info-section__body entry-content">
				<?php echo apply_filters( 'the_content', $section['body'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</section>
		<?php
	}

	echo '</div>';
}

/**
 * Navegación rápida entre secciones de la descripción.
 *
 * @param string $html Contenido de la descripción larga.
 */
function abalturas_render_product_description_jump_nav( string $html ): void {
	$sections = abalturas_parse_product_description_sections( $html );

	if ( count( $sections ) < 2 ) {
		return;
	}
	?>
	<nav class="ab-product-info-jump" aria-label="<?php esc_attr_e( 'Ir a sección de la ficha', 'abalturas' ); ?>">
		<ul class="ab-product-info-jump__list">
			<?php foreach ( $sections as $section ) : ?>
			<li>
				<a class="ab-product-info-jump__link" href="#<?php echo esc_attr( 'ab-product-section-' . $section['slug'] ); ?>">
					<?php echo esc_html( $section['title'] ); ?>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
	</nav>
	<?php
}

/**
 * Cabecera del bloque de valoraciones en la ficha de producto.
 */
function abalturas_render_product_reviews_block_header(): void {
	if ( ! function_exists( 'wc_get_product' ) ) {
		return;
	}

	$product = wc_get_product( get_the_ID() );
	if ( ! $product ) {
		return;
	}

	$count      = (int) $product->get_review_count();
	$avg        = (float) $product->get_average_rating();
	$has_rating = $count > 0 && $avg > 0;
	?>
	<header class="ab-product-info__block-head ab-product-info__block-head--reviews">
		<div class="ab-product-reviews-head">
			<span class="ab-product-reviews-head__icon" aria-hidden="true">
				<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
			</span>
			<div class="ab-product-reviews-head__text">
				<h3 class="ab-product-reviews-head__title"><?php esc_html_e( 'Opiniones de clientes', 'abalturas' ); ?></h3>
				<?php if ( $has_rating ) : ?>
				<p class="ab-product-reviews-head__meta">
					<?php
					printf(
						/* translators: 1: average rating 2: review count */
						esc_html__( 'Promedio %1$s · %2$s', 'abalturas' ),
						esc_html( number_format_i18n( $avg, 1 ) ),
						esc_html(
							sprintf(
								/* translators: %d: number of reviews */
								_n( '%d valoración', '%d valoraciones', $count, 'abalturas' ),
								$count
							)
						)
					);
					?>
				</p>
				<?php else : ?>
				<p class="ab-product-reviews-head__meta"><?php esc_html_e( 'Sin valoraciones aún — comparta su experiencia', 'abalturas' ); ?></p>
				<?php endif; ?>
			</div>
			<span class="ab-product-reviews-head__badge" aria-label="<?php echo esc_attr( sprintf( _n( '%d valoración', '%d valoraciones', $count, 'abalturas' ), $count ) ); ?>">
				<?php echo esc_html( (string) $count ); ?>
			</span>
		</div>
	</header>
	<?php
}
