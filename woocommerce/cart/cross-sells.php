<?php
/**
 * Cross-sells — productos recomendados en carrito.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package Abalturas
 * @version 9.6.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! $cross_sells ) {
	return;
}
?>
<section class="cross-sells abalturas-cart-cross-sells">
	<header class="abalturas-cart-cross-sells__header">
		<p class="abalturas-cart-cross-sells__eyebrow"><?php esc_html_e( 'Complemente su pedido', 'abalturas' ); ?></p>
		<h2 class="abalturas-cart-cross-sells__title">
			<?php echo esc_html( apply_filters( 'woocommerce_product_cross_sells_products_heading', __( 'Productos recomendados', 'abalturas' ) ) ); ?>
		</h2>
	</header>

	<?php woocommerce_product_loop_start(); ?>

		<?php foreach ( $cross_sells as $cross_sell ) : ?>
			<?php
			$post_object = get_post( $cross_sell->get_id() );
			if ( ! $post_object ) {
				continue;
			}
			setup_postdata( $GLOBALS['post'] = $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found
			wc_get_template_part( 'content', 'product' );
			?>
		<?php endforeach; ?>

	<?php woocommerce_product_loop_end(); ?>
</section>
<?php
wp_reset_postdata();
