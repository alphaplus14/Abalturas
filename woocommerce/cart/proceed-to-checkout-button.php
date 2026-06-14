<?php
/**
 * Botón continuar al pago — carrito Abalturas.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package Abalturas
 * @version 7.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="checkout-button button alt wc-forward abalturas-cart-checkout-btn<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>">
	<?php esc_html_e( 'Continuar al pago', 'abalturas' ); ?>
</a>
