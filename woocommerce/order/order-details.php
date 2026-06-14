<?php
/**
 * Detalle del pedido — tabla premium Abalturas.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package Abalturas
 * @version 10.1.0
 *
 * @var bool $show_downloads Controls whether the downloads table should be rendered.
 */

defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if ( ! $order ) {
	return;
}

$order_items        = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$downloads          = $order->get_downloadable_items();
$actions            = array_filter(
	wc_get_account_orders_actions( $order ),
	function ( $key ) {
		return 'view' !== $key;
	},
	ARRAY_FILTER_USE_KEY
);

$show_customer_details = $order->get_user_id() === get_current_user_id();

if ( $show_downloads ) {
	wc_get_template(
		'order/order-downloads.php',
		array(
			'downloads'  => $downloads,
			'show_title' => true,
		)
	);
}
?>
<section class="woocommerce-order-details mb-8">
	<?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>

	<h2 class="woocommerce-order-details__title mb-4 text-xs font-bold uppercase tracking-[0.14em] text-industrial">
		<?php esc_html_e( 'Detalle de productos', 'abalturas' ); ?>
	</h2>

	<div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
		<div class="overflow-x-auto">
			<table class="woocommerce-table woocommerce-table--order-details shop_table order_details w-full min-w-[20rem] border-collapse text-left text-sm">

				<thead>
					<tr class="bg-industrial text-white">
						<th class="woocommerce-table__product-name product-name px-4 py-3 text-xs font-bold uppercase tracking-[0.1em] text-white" scope="col">
							<?php esc_html_e( 'Producto', 'woocommerce' ); ?>
						</th>
						<th class="woocommerce-table__product-table product-total px-4 py-3 text-right text-xs font-bold uppercase tracking-[0.1em] text-white" scope="col">
							<?php esc_html_e( 'Total', 'woocommerce' ); ?>
						</th>
					</tr>
				</thead>

				<tbody class="divide-y divide-slate-100">
					<?php
					do_action( 'woocommerce_order_details_before_order_table_items', $order );

					$row_index = 0;
					foreach ( $order_items as $item_id => $item ) {
						$product = $item->get_product();

						wc_get_template(
							'order/order-details-item.php',
							array(
								'order'              => $order,
								'item_id'            => $item_id,
								'item'               => $item,
								'show_purchase_note' => $show_purchase_note,
								'purchase_note'      => $product ? $product->get_purchase_note() : '',
								'product'            => $product,
								'row_index'          => $row_index,
							)
						);
						++$row_index;
					}

					do_action( 'woocommerce_order_details_after_order_table_items', $order );
					?>
				</tbody>

				<tfoot class="border-t border-slate-200 bg-mist/40">
					<?php if ( ! empty( $actions ) ) : ?>
						<tr>
							<th class="px-4 py-4 text-left align-top text-[0.65rem] font-bold uppercase tracking-[0.12em] text-slate-500" scope="row">
								<?php esc_html_e( 'Acciones', 'woocommerce' ); ?>
							</th>
							<td class="px-4 py-4 text-right">
								<div class="flex flex-col items-stretch gap-2 sm:flex-row sm:justify-end">
									<?php
									$wp_button_class = wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '';
									foreach ( $actions as $key => $action ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
										if ( empty( $action['aria-label'] ) ) {
											/* translators: %1$s Action name, %2$s Order number. */
											$action_aria_label = sprintf( __( '%1$s order number %2$s', 'woocommerce' ), $action['name'], $order->get_order_number() );
										} else {
											$action_aria_label = $action['aria-label'];
										}

										$is_pay    = 'pay' === $key;
										$btn_class = $is_pay
											? 'inline-flex min-h-[2.75rem] items-center justify-center rounded-[3px] bg-safety px-5 text-xs font-bold uppercase tracking-[0.1em] text-white no-underline shadow-sm transition hover:bg-[#de5317] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-safety'
											: 'inline-flex min-h-[2.75rem] items-center justify-center rounded-[3px] border-2 border-industrial bg-transparent px-5 text-xs font-bold uppercase tracking-[0.1em] text-industrial no-underline transition hover:bg-industrial hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-industrial';

										echo '<a href="' . esc_url( $action['url'] ) . '" class="woocommerce-button' . esc_attr( $wp_button_class ) . ' button ' . esc_attr( sanitize_html_class( $key ) ) . ' order-actions-button ' . esc_attr( $btn_class ) . '" aria-label="' . esc_attr( $action_aria_label ) . '">' . esc_html( $action['name'] ) . '</a>';
										unset( $action_aria_label );
									}
									?>
								</div>
							</td>
						</tr>
					<?php endif; ?>

					<?php
					foreach ( $order->get_order_item_totals() as $key => $total ) {
						$is_grand_total = 'order_total' === $key;
						?>
						<tr class="<?php echo $is_grand_total ? 'border-t border-slate-200 bg-white' : ''; ?>">
							<th class="px-4 py-3 text-left text-sm font-medium text-slate-600" scope="row">
								<?php echo esc_html( $total['label'] ); ?>
							</th>
							<td class="px-4 py-3 text-right <?php echo $is_grand_total ? 'text-xl font-bold text-safety' : 'font-semibold text-charcoal'; ?>">
								<?php echo wp_kses_post( $total['value'] ); ?>
							</td>
						</tr>
						<?php
					}
					?>

					<?php if ( $order->get_customer_note() ) : ?>
						<tr>
							<th class="px-4 py-3 text-left text-sm font-medium text-slate-600" scope="row">
								<?php esc_html_e( 'Note:', 'woocommerce' ); ?>
							</th>
							<td class="px-4 py-3 text-right text-sm text-charcoal">
								<?php
								$customer_note = wc_wptexturize_order_note( $order->get_customer_note() );
								echo wp_kses( nl2br( $customer_note ), array( 'br' => array() ) );
								?>
							</td>
						</tr>
					<?php endif; ?>
				</tfoot>
			</table>
		</div>
	</div>

	<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
</section>

<?php
do_action( 'woocommerce_after_order_details', $order );

if ( $show_customer_details ) {
	wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) );
}
