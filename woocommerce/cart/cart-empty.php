<?php
/**
 * Carrito vacío — estado premium Abalturas.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package Abalturas
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' );
?>

<div class="abalturas-cart abalturas-cart--empty">
	<header class="abalturas-cart__header">
		<p class="abalturas-cart__eyebrow"><?php esc_html_e( 'Tienda', 'abalturas' ); ?></p>
		<h1 class="abalturas-cart__title"><?php esc_html_e( 'Carrito de compras', 'abalturas' ); ?></h1>
	</header>

	<div class="abalturas-cart-empty">
		<div class="abalturas-cart-empty__icon" aria-hidden="true">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
		</div>
		<?php do_action( 'woocommerce_cart_is_empty' ); ?>
		<?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
			<p class="return-to-shop abalturas-cart-empty__actions">
				<a class="button wc-backward abalturas-cart-empty__btn<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
					<?php echo esc_html( apply_filters( 'woocommerce_return_to_shop_text', __( 'Ver catálogo de equipos', 'abalturas' ) ) ); ?>
				</a>
			</p>
		<?php endif; ?>
	</div>

	<?php
	$recommended = function_exists( 'abalturas_get_cart_recommended_products' ) ? abalturas_get_cart_recommended_products( 4 ) : array();
	if ( ! empty( $recommended ) ) :
		?>
		<div class="abalturas-cart__recommended">
			<section class="cross-sells abalturas-cart-cross-sells">
				<header class="abalturas-cart-cross-sells__header">
					<p class="abalturas-cart-cross-sells__eyebrow"><?php esc_html_e( 'Explore el catálogo', 'abalturas' ); ?></p>
					<h2 class="abalturas-cart-cross-sells__title"><?php esc_html_e( 'Productos recomendados', 'abalturas' ); ?></h2>
				</header>
				<?php
				wc_set_loop_prop( 'columns', 4 );
				woocommerce_product_loop_start();
				foreach ( $recommended as $product ) {
					$post_object = get_post( $product->get_id() );
					if ( ! $post_object ) {
						continue;
					}
					setup_postdata( $GLOBALS['post'] = $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found
					wc_get_template_part( 'content', 'product' );
				}
				woocommerce_product_loop_end();
				wp_reset_postdata();
				?>
			</section>
		</div>
	<?php endif; ?>
</div>

<?php
do_action( 'woocommerce_after_cart' );
