<?php
/**
 * Productos relacionados — ficha de producto.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package Abalturas
 * @version 10.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) :
	if ( function_exists( 'wp_increase_content_media_count' ) ) {
		$content_media_count = wp_increase_content_media_count( 0 );
		if ( $content_media_count < wp_omit_loading_attr_threshold() ) {
			wp_increase_content_media_count( wp_omit_loading_attr_threshold() - $content_media_count );
		}
	}
	?>

	<section class="related products abalturas-related-products">

		<?php
		$heading = apply_filters(
			'woocommerce_product_related_products_heading',
			__( 'Productos relacionados', 'abalturas' )
		);

		if ( $heading ) :
			?>
			<header class="abalturas-related-products__header">
				<p class="abalturas-related-products__eyebrow">
					<?php esc_html_e( 'También te puede interesar', 'abalturas' ); ?>
				</p>
				<div class="abalturas-related-products__title-row">
					<h2 class="abalturas-related-products__title">
						<?php echo esc_html( $heading ); ?>
					</h2>
					<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="abalturas-related-products__shop-link">
							<?php esc_html_e( 'Ver tienda', 'abalturas' ); ?>
							<span aria-hidden="true">→</span>
						</a>
					<?php endif; ?>
				</div>
				<p class="abalturas-related-products__lead">
					<?php esc_html_e( 'Equipos complementarios seleccionados para este producto.', 'abalturas' ); ?>
				</p>
			</header>
		<?php endif; ?>

		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $related_products as $related_product ) : ?>

					<?php
					$post_object = get_post( $related_product->get_id() );

					setup_postdata( $GLOBALS['post'] = $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

					wc_get_template_part( 'content', 'product' );
					?>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

	</section>
	<?php
endif;

wp_reset_postdata();
