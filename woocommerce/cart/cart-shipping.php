<?php
/**
 * Envío en totales del carrito — cotización manual Abalturas.
 *
 * @package Abalturas
 * @version 8.8.0
 */

defined( 'ABSPATH' ) || exit;

$formatted_destination    = isset( $formatted_destination ) ? $formatted_destination : WC()->countries->get_formatted_address( $package['destination'], ', ' );
$has_calculated_shipping  = ! empty( $has_calculated_shipping );
$show_shipping_calculator = ! empty( $show_shipping_calculator );
$calculator_text          = '';
$quote_label = function_exists( 'abalturas_get_shipping_quote_label' ) ? abalturas_get_shipping_quote_label() : __( 'A cotizar', 'abalturas' );
?>
<tr class="woocommerce-shipping-totals shipping abalturas-cart-shipping-row">
	<th><?php esc_html_e( 'Envío', 'abalturas' ); ?></th>
	<td data-title="<?php esc_attr_e( 'Envío', 'abalturas' ); ?>">
		<?php if ( is_cart() ) : ?>
			<?php
			$cart_rate_id = 'abalturas_envio_cotizar';
			if ( ! empty( $available_methods ) ) {
				if ( isset( $available_methods[ $cart_rate_id ] ) ) {
					$rate_id = $cart_rate_id;
				} else {
					$rate_id = (string) array_key_first( (array) $available_methods );
				}
				printf( '<input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" />', $index, esc_attr( sanitize_title( $rate_id ) ), esc_attr( $rate_id ) ); // WPCS: XSS ok.
			}
			?>
			<p class="abalturas-cart-shipping-flat">
				<span class="abalturas-cart-shipping-flat__price abalturas-cart-shipping-flat__price--quote"><?php echo esc_html( $quote_label ); ?></span>
			</p>
			<?php
			if ( function_exists( 'abalturas_render_shipping_info_notice' ) ) {
				abalturas_render_shipping_info_notice();
			}
			?>
		<?php elseif ( ! empty( $available_methods ) && is_array( $available_methods ) ) : ?>
			<ul id="shipping_method" class="woocommerce-shipping-methods">
				<?php foreach ( $available_methods as $method ) : ?>
					<li>
						<?php
						if ( 1 < count( $available_methods ) ) {
							printf( '<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" %4$s />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ), checked( $method->id, $chosen_method, false ) ); // WPCS: XSS ok.
						} else {
							printf( '<input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ) ); // WPCS: XSS ok.
						}
						printf( '<label for="shipping_method_%1$s_%2$s">%3$s</label>', $index, esc_attr( sanitize_title( $method->id ) ), wc_cart_totals_shipping_method_label( $method ) ); // WPCS: XSS ok.
						do_action( 'woocommerce_after_shipping_rate', $method, $index );
						?>
					</li>
				<?php endforeach; ?>
			</ul>
			<?php
			if ( function_exists( 'abalturas_render_shipping_info_notice' ) ) {
				abalturas_render_shipping_info_notice();
			}
			?>
		<?php elseif ( ! $has_calculated_shipping || ! $formatted_destination ) : ?>
			<span class="abalturas-cart-shipping-flat__price abalturas-cart-shipping-flat__price--quote"><?php echo esc_html( $quote_label ); ?></span>
		<?php elseif ( ! is_cart() ) : ?>
			<?php echo wp_kses_post( apply_filters( 'woocommerce_no_shipping_available_html', __( 'No hay opciones de envío disponibles.', 'woocommerce' ) ) ); ?>
		<?php else : ?>
			<?php
			echo wp_kses_post(
				apply_filters(
					'woocommerce_cart_no_shipping_available_html',
					sprintf(
						/* translators: %s: destination */
						esc_html__( 'No se encontraron opciones de envío para %s.', 'abalturas' ) . ' ',
						'<strong>' . esc_html( $formatted_destination ) . '</strong>'
					),
					$formatted_destination
				)
			);
			$calculator_text = esc_html__( 'Ingresar otra dirección', 'abalturas' );
			?>
		<?php endif; ?>

		<?php if ( $show_package_details ) : ?>
			<?php echo '<p class="woocommerce-shipping-contents"><small>' . esc_html( $package_details ) . '</small></p>'; ?>
		<?php endif; ?>

		<?php if ( $show_shipping_calculator && ! is_cart() ) : ?>
			<?php woocommerce_shipping_calculator( $calculator_text ); ?>
		<?php endif; ?>
	</td>
</tr>
