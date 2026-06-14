<?php
/**
 * Totales del carrito — tarjeta resumen Abalturas.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package Abalturas
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;

$trust_items = array(
	__( 'Pago seguro', 'abalturas' ),
	__( 'Envíos a todo Colombia', 'abalturas' ),
	__( 'Facturación electrónica', 'abalturas' ),
	__( 'Asesoría técnica especializada', 'abalturas' ),
);
?>
<div class="cart_totals abalturas-cart-totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<h2 class="abalturas-cart-totals__title"><?php esc_html_e( 'Resumen del pedido', 'abalturas' ); ?></h2>

	<table cellspacing="0" class="shop_table shop_table_responsive abalturas-cart-totals__table">

		<tr class="cart-subtotal">
			<th><?php esc_html_e( 'Subtotal', 'abalturas' ); ?></th>
			<td data-title="<?php esc_attr_e( 'Subtotal', 'abalturas' ); ?>"><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<?php
			if ( in_array( $fee->name, array( __( 'Costo de envío', 'abalturas' ), __( 'Envío', 'abalturas' ) ), true ) ) {
				continue;
			}
			?>
			<tr class="fee">
				<th><?php echo esc_html( $fee->name ); ?></th>
				<td data-title="<?php echo esc_attr( $fee->name ); ?>"><?php wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php
		if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
			$taxable_address = WC()->customer->get_taxable_address();
			$estimated_text  = '';

			if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
				$estimated_text = sprintf(
					' <small>' . esc_html__( '(estimated for %s)', 'woocommerce' ) . '</small>',
					WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ]
				);
			}

			if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
				foreach ( WC()->cart->get_tax_totals() as $code => $tax ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					?>
					<tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<th><?php echo esc_html( $tax->label ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></th>
						<td data-title="<?php echo esc_attr( $tax->label ); ?>"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
					<?php
				}
			} else {
				?>
				<tr class="tax-total">
					<th><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></th>
					<td data-title="<?php echo esc_attr( WC()->countries->tax_or_vat() ); ?>"><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
				<?php
			}
		}
		?>

		<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

		<tr class="order-total">
			<th><?php esc_html_e( 'Total (sin envío)', 'abalturas' ); ?></th>
			<td data-title="<?php esc_attr_e( 'Total (sin envío)', 'abalturas' ); ?>"><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

	</table>

	<div class="wc-proceed-to-checkout abalturas-cart-totals__checkout">
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>

	<ul class="abalturas-cart-trust" aria-label="<?php esc_attr_e( 'Garantías de compra', 'abalturas' ); ?>">
		<?php foreach ( $trust_items as $item ) : ?>
			<li class="abalturas-cart-trust__item">
				<svg class="abalturas-cart-trust__icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
				<span><?php echo esc_html( $item ); ?></span>
			</li>
		<?php endforeach; ?>
	</ul>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>

<div class="abalturas-cart-mobile-bar" id="abalturas-cart-mobile-bar" hidden>
	<div class="abalturas-cart-mobile-bar__inner">
		<div class="abalturas-cart-mobile-bar__total">
			<span class="abalturas-cart-mobile-bar__label"><?php esc_html_e( 'Total estimado', 'abalturas' ); ?></span>
			<span class="abalturas-cart-mobile-bar__amount"><?php wc_cart_totals_order_total_html(); ?></span>
		</div>
		<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="abalturas-cart-mobile-bar__cta checkout-button">
			<?php esc_html_e( 'Continuar al pago', 'abalturas' ); ?>
		</a>
	</div>
</div>
