<?php
/**
 * Direcciones del cliente — tarjetas en dos columnas.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package Abalturas
 * @version 8.7.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;

$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>
<section class="woocommerce-customer-details mb-2">

	<h2 class="mb-4 text-xs font-bold uppercase tracking-[0.14em] text-industrial">
		<?php esc_html_e( 'Direcciones', 'abalturas' ); ?>
	</h2>

	<div class="<?php echo $show_shipping ? 'grid grid-cols-1 gap-4 md:grid-cols-2' : 'grid grid-cols-1'; ?>">

		<div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-1 rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
			<div class="mb-3 flex items-center gap-3">
				<span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-industrial/20 bg-industrial/5 text-industrial" aria-hidden="true">
					<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
						<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
					</svg>
				</span>
				<h3 class="woocommerce-column__title m-0 text-sm font-bold uppercase tracking-[0.1em] text-industrial">
					<?php esc_html_e( 'Billing address', 'woocommerce' ); ?>
				</h3>
			</div>

			<address class="not-italic text-sm leading-relaxed text-charcoal">
				<?php echo wp_kses_post( $order->get_formatted_billing_address( esc_html__( 'N/A', 'woocommerce' ) ) ); ?>

				<?php if ( $order->get_billing_phone() ) : ?>
					<p class="woocommerce-customer-details--phone mt-2 text-sm text-charcoal">
						<span class="block text-[0.65rem] font-bold uppercase tracking-[0.12em] text-slate-500"><?php esc_html_e( 'Teléfono', 'abalturas' ); ?></span>
						<?php echo esc_html( $order->get_billing_phone() ); ?>
					</p>
				<?php endif; ?>

				<?php if ( $order->get_billing_email() ) : ?>
					<p class="woocommerce-customer-details--email mt-2 text-sm text-charcoal">
						<span class="block text-[0.65rem] font-bold uppercase tracking-[0.12em] text-slate-500"><?php esc_html_e( 'Correo', 'abalturas' ); ?></span>
						<?php echo esc_html( $order->get_billing_email() ); ?>
					</p>
				<?php endif; ?>

				<?php do_action( 'woocommerce_order_details_after_customer_address', 'billing', $order ); ?>
			</address>
		</div>

		<?php if ( $show_shipping ) : ?>

			<div class="woocommerce-column woocommerce-column--2 woocommerce-column--shipping-address col-2 rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
				<div class="mb-3 flex items-center gap-3">
					<span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-safety/30 bg-safety/10 text-safety" aria-hidden="true">
						<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>
						</svg>
					</span>
					<h3 class="woocommerce-column__title m-0 text-sm font-bold uppercase tracking-[0.1em] text-industrial">
						<?php esc_html_e( 'Shipping address', 'woocommerce' ); ?>
					</h3>
				</div>

				<address class="not-italic text-sm leading-relaxed text-charcoal">
					<?php echo wp_kses_post( $order->get_formatted_shipping_address( esc_html__( 'N/A', 'woocommerce' ) ) ); ?>

					<?php if ( $order->get_shipping_phone() ) : ?>
						<p class="woocommerce-customer-details--phone mt-2 text-sm text-charcoal">
							<span class="block text-[0.65rem] font-bold uppercase tracking-[0.12em] text-slate-500"><?php esc_html_e( 'Teléfono', 'abalturas' ); ?></span>
							<?php echo esc_html( $order->get_shipping_phone() ); ?>
						</p>
					<?php endif; ?>

					<?php do_action( 'woocommerce_order_details_after_customer_address', 'shipping', $order ); ?>
				</address>
			</div>

		<?php endif; ?>

	</div>

	<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>

</section>
