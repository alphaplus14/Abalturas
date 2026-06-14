<?php
/**
 * Información del producto — secciones apiladas (sin pestañas ocultas).
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package Abalturas
 * @version 9.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var array<string, array{title: string, callback: callable, priority: int}> $product_tabs
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( empty( $product_tabs ) ) {
	return;
}

global $post;
$description_html = $post instanceof WP_Post ? (string) $post->post_content : '';
?>
<div class="ab-product-info woocommerce-tabs wc-tabs-wrapper">
	<header class="ab-product-info__header">
		<p class="ab-product-info__eyebrow"><?php esc_html_e( 'Ficha técnica', 'abalturas' ); ?></p>
		<h2 class="ab-product-info__title"><?php esc_html_e( 'Información del producto', 'abalturas' ); ?></h2>
		<p class="ab-product-info__lead"><?php esc_html_e( 'Descripción, características y especificaciones organizadas para una lectura rápida.', 'abalturas' ); ?></p>
	</header>

	<?php abalturas_render_product_description_jump_nav( $description_html ); ?>

	<div class="ab-product-info__stack">
		<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
			<?php
			$tab_title = isset( $product_tab['title'] ) ? (string) $product_tab['title'] : '';
			$block_id  = 'tab-' . $key;
			?>
			<article
				class="ab-product-info__block ab-product-info__block--<?php echo esc_attr( $key ); ?> woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab"
				id="<?php echo esc_attr( $block_id ); ?>"
				aria-label="<?php echo esc_attr( wp_strip_all_tags( $tab_title ) ); ?>"
			>
				<?php if ( 'reviews' === $key ) : ?>
					<?php abalturas_render_product_reviews_block_header(); ?>
				<?php elseif ( 'description' !== $key ) : ?>
				<header class="ab-product-info__block-head">
					<h3 class="ab-product-info__block-title">
						<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab_title, $key ) ); ?>
					</h3>
				</header>
				<?php endif; ?>

				<div class="ab-product-info__block-body">
					<?php
					if ( isset( $product_tab['callback'] ) && is_callable( $product_tab['callback'] ) ) {
						call_user_func( $product_tab['callback'], $key, $product_tab );
					}
					?>
				</div>
			</article>
		<?php endforeach; ?>
	</div>

	<?php do_action( 'woocommerce_product_after_tabs' ); ?>
</div>
