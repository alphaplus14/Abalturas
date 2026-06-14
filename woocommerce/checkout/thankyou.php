<?php
/**
 * Pedido recibido — diseño premium Abalturas.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package Abalturas
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;

$shop_url          = function_exists( 'abalturas_get_shop_catalog_url' ) ? abalturas_get_shop_catalog_url() : home_url( '/productos/' );
$whatsapp_url      = function_exists( 'abalturas_get_whatsapp_url' )
	? abalturas_get_whatsapp_url( 'commercial', __( 'Hola, acabo de realizar un pedido en Abalturas y tengo una consulta.', 'abalturas' ) )
	: 'https://wa.me/573027782299';
$whatsapp_svg_path = 'M20.503 5.42A9.957 9.957 0 0 0 12.036 2C6.956 2 2.83 6.146 2.828 11.239c-.001 1.734.449 3.397 1.297 4.892L3 21.95l6.058-1.592a9.86 9.86 0 0 0 4.973 1.343h.005c5.079 0 9.207-4.147 9.209-9.239a9.173 9.173 0 0 0-2.743-6.943ZM12.04 18.93h-.003a8.236 8.236 0 0 1-4.226-1.166l-.303-.18-4.036 1.062 1.078-3.964-.209-.343a8.274 8.274 0 1 1 7.7 5.592Zm4.547-6.226c-.25-.129-1.477-.736-1.706-.822-.229-.086-.396-.129-.563.129-.167.259-.642.821-.786.99-.146.169-.294.188-.546.058-.251-.129-1.062-.394-2.026-1.254-.746-.673-1.254-1.502-1.403-1.757-.146-.259-.017-.394.118-.527.117-.117.259-.294.389-.446.137-.154.174-.267.274-.446.086-.208.049-.379-.026-.527-.069-.169-.564-1.353-.769-1.852-.207-.489-.418-.427-.573-.439l-.49-.013c-.168 0-.442.068-.674.323-.229.259-.881.868-.881 2.122 0 1.257.919 2.474 1.042 2.642.146.259 1.804 2.743 4.379 3.849.612.262 1.091.418 1.465.539.613.206 1.172.173 1.611.098.489-.069 1.477-.613 1.687-1.208.217-.596.217-1.104.157-1.208-.069-.086-.237-.169-.489-.297Z';
?>

<div class="ab-thankyou woocommerce-order bg-mist py-8 font-sans md:py-12 lg:py-14">

	<div class="mx-auto w-full max-w-4xl px-4 sm:px-6">

		<?php if ( $order ) : ?>

			<?php do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

			<?php if ( $order->has_status( 'failed' ) ) : ?>

				<header class="mb-8 text-center">
					<div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full border-2 border-red-300 bg-red-50" aria-hidden="true">
						<svg class="h-8 w-8 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
							<circle cx="12" cy="12" r="10"/>
							<line x1="15" y1="9" x2="9" y2="15"/>
							<line x1="9" y1="9" x2="15" y2="15"/>
						</svg>
					</div>
					<h1 class="text-2xl font-bold tracking-tight text-industrial md:text-3xl">
						<?php esc_html_e( 'No pudimos procesar tu pago', 'abalturas' ); ?>
					</h1>
					<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed mx-auto mt-3 max-w-xl text-sm leading-relaxed text-slate-600">
						<?php esc_html_e( 'El banco o la pasarela de pago rechazó la transacción. Puedes intentar pagar de nuevo o cancelar el pedido.', 'abalturas' ); ?>
					</p>
				</header>

				<div class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions flex flex-col gap-3 sm:flex-row sm:justify-center">
					<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay inline-flex min-h-[2.875rem] items-center justify-center rounded-[3px] bg-safety px-7 text-xs font-bold uppercase tracking-[0.12em] text-white no-underline shadow-sm transition hover:bg-[#de5317] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-safety">
						<?php esc_html_e( 'Pagar', 'woocommerce' ); ?>
					</a>
					<?php if ( is_user_logged_in() ) : ?>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button inline-flex min-h-[2.875rem] items-center justify-center rounded-[3px] border-2 border-industrial bg-transparent px-7 text-xs font-bold uppercase tracking-[0.12em] text-industrial no-underline transition hover:bg-industrial hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-industrial">
							<?php esc_html_e( 'Mi cuenta', 'woocommerce' ); ?>
						</a>
					<?php endif; ?>
				</div>

			<?php else : ?>

				<?php
				$customer_name   = function_exists( 'abalturas_get_thankyou_customer_name' ) ? abalturas_get_thankyou_customer_name( $order ) : __( 'cliente', 'abalturas' );
				$order_status    = $order->get_status();
				$status_label    = wc_get_order_status_name( $order_status );
				$status_classes  = function_exists( 'abalturas_get_order_status_badge_classes' ) ? abalturas_get_order_status_badge_classes( $order_status ) : 'border-slate-300 bg-slate-100 text-slate-700';
				$received_filter = apply_filters(
					'woocommerce_thankyou_order_received_text',
					esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ),
					$order
				);
				?>

				<header class="mb-8 text-center">
					<div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full border-2 border-emerald-300 bg-emerald-50 md:h-[4.5rem] md:w-[4.5rem]" aria-hidden="true">
						<svg class="h-8 w-8 text-emerald-600 md:h-9 md:w-9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
							<polyline points="20 6 9 17 4 12" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>

					<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received sr-only">
						<?php echo wp_kses_post( $received_filter ); ?>
					</p>

					<h1 class="text-2xl font-bold tracking-tight text-industrial md:text-3xl">
						<?php
						printf(
							/* translators: %s: customer first name or company */
							esc_html__( '¡Gracias por tu pedido, %s!', 'abalturas' ),
							esc_html( $customer_name )
						);
						?>
					</h1>

					<p class="mx-auto mt-2 max-w-lg text-sm leading-relaxed text-slate-600">
						<?php esc_html_e( 'Hemos recibido tu solicitud. Te enviaremos la confirmación y los detalles de seguimiento a tu correo.', 'abalturas' ); ?>
					</p>

					<span class="mt-4 inline-flex items-center rounded-full border px-3 py-1 text-xs font-bold uppercase tracking-[0.1em] <?php echo esc_attr( $status_classes ); ?>">
						<?php echo esc_html( $status_label ); ?>
					</span>
				</header>

				<?php
				$billing_email   = trim( (string) $order->get_billing_email() );
				$payment_method  = trim( wp_strip_all_tags( (string) $order->get_payment_method_title() ) );
				$summary_cell    = 'ab-thankyou-summary__cell rounded-md border px-4 py-3';
				$summary_label   = 'block text-[0.65rem] font-bold uppercase tracking-[0.12em] text-slate-500';
				$summary_value   = 'mt-1 block text-base font-semibold normal-case text-charcoal';
				?>

				<div class="mb-8 rounded-lg border border-slate-200/80 bg-white p-5 shadow-sm sm:p-6">
					<h2 class="mb-4 text-xs font-bold uppercase tracking-[0.14em] text-industrial">
						<?php esc_html_e( 'Resumen del pedido', 'abalturas' ); ?>
					</h2>

					<ul class="ab-thankyou-summary woocommerce-order-overview woocommerce-thankyou-order-details order_details m-0 grid list-none grid-cols-1 gap-4 p-0 sm:grid-cols-2">
						<li class="woocommerce-order-overview__order order <?php echo esc_attr( $summary_cell ); ?> border-slate-100 bg-mist/60">
							<span class="<?php echo esc_attr( $summary_label ); ?>">
								<?php esc_html_e( 'Número de pedido', 'abalturas' ); ?>
							</span>
							<strong class="mt-1 block text-lg font-bold normal-case text-industrial">
								<?php echo esc_html( $order->get_order_number() ); ?>
							</strong>
						</li>

						<li class="woocommerce-order-overview__date date <?php echo esc_attr( $summary_cell ); ?> border-slate-100 bg-mist/60">
							<span class="<?php echo esc_attr( $summary_label ); ?>">
								<?php esc_html_e( 'Fecha', 'woocommerce' ); ?>
							</span>
							<strong class="<?php echo esc_attr( $summary_value ); ?>">
								<?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?>
							</strong>
						</li>

						<li class="woocommerce-order-overview__email email <?php echo esc_attr( $summary_cell ); ?> border-slate-100 bg-mist/60">
							<span class="<?php echo esc_attr( $summary_label ); ?>">
								<?php esc_html_e( 'Correo electrónico', 'woocommerce' ); ?>
							</span>
							<strong class="<?php echo esc_attr( $summary_value ); ?> break-all">
								<?php echo esc_html( '' !== $billing_email ? $billing_email : '—' ); ?>
							</strong>
						</li>

						<li class="woocommerce-order-overview__total total <?php echo esc_attr( $summary_cell ); ?> border-orange-200/70 bg-orange-50/50">
							<span class="<?php echo esc_attr( $summary_label ); ?>">
								<?php esc_html_e( 'Total', 'woocommerce' ); ?>
							</span>
							<strong class="mt-1 block text-xl font-bold normal-case text-safety">
								<?php echo wp_kses_post( $order->get_formatted_order_total() ); ?>
							</strong>
						</li>

						<li class="woocommerce-order-overview__payment-method method <?php echo esc_attr( $summary_cell ); ?> border-slate-100 bg-mist/60">
							<span class="<?php echo esc_attr( $summary_label ); ?>">
								<?php esc_html_e( 'Método de pago', 'woocommerce' ); ?>
							</span>
							<strong class="<?php echo esc_attr( $summary_value ); ?>">
								<?php echo esc_html( '' !== $payment_method ? $payment_method : '—' ); ?>
							</strong>
						</li>

						<li class="woocommerce-order-overview__status status <?php echo esc_attr( $summary_cell ); ?> border-slate-100 bg-mist/60">
							<span class="<?php echo esc_attr( $summary_label ); ?>">
								<?php esc_html_e( 'Estado del pedido', 'abalturas' ); ?>
							</span>
							<strong class="mt-1 block font-semibold normal-case">
								<span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-bold uppercase tracking-[0.1em] <?php echo esc_attr( $status_classes ); ?>">
									<?php echo esc_html( $status_label ); ?>
								</span>
							</strong>
						</li>
					</ul>
				</div>

			<?php endif; ?>

			<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
			<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

			<section class="ab-thankyou__cta mt-10 rounded-lg border border-slate-200 bg-white p-5 shadow-sm sm:p-6" aria-labelledby="ab-thankyou-cta-title">
				<h2 id="ab-thankyou-cta-title" class="text-center text-base font-bold text-industrial md:text-lg">
					<?php esc_html_e( '¿Necesitas ayuda con tu pedido?', 'abalturas' ); ?>
				</h2>
				<p class="mx-auto mt-2 max-w-md text-center text-sm text-slate-600">
					<?php esc_html_e( 'Nuestro equipo comercial puede orientarte sobre plazos, envío o productos complementarios.', 'abalturas' ); ?>
				</p>
				<div class="mt-5 flex flex-col gap-3 sm:flex-row sm:justify-center">
					<a href="<?php echo esc_url( $shop_url ); ?>" class="inline-flex min-h-[2.875rem] flex-1 items-center justify-center rounded-[3px] border-2 border-industrial bg-transparent px-6 text-xs font-bold uppercase tracking-[0.12em] text-industrial no-underline transition hover:bg-industrial hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-industrial sm:max-w-xs">
						<?php esc_html_e( 'Seguir comprando', 'abalturas' ); ?>
					</a>
					<a
						href="<?php echo esc_url( $whatsapp_url ); ?>"
						class="cta-btn cta-btn--primary inline-flex min-h-[2.875rem] flex-1 sm:max-w-xs"
						target="_blank"
						rel="noopener noreferrer"
						aria-label="<?php esc_attr_e( 'Contactar por WhatsApp (se abre en nueva pestaña)', 'abalturas' ); ?>"
					>
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true">
							<path fill="currentColor" d="<?php echo esc_attr( $whatsapp_svg_path ); ?>"/>
						</svg>
						<?php esc_html_e( 'Contactar por WhatsApp', 'abalturas' ); ?>
					</a>
				</div>
			</section>

		<?php else : ?>

			<header class="mb-8 text-center">
				<div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full border-2 border-emerald-300 bg-emerald-50" aria-hidden="true">
					<svg class="h-8 w-8 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
						<polyline points="20 6 9 17 4 12" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</div>
				<?php wc_get_template( 'checkout/order-received.php', array( 'order' => false ) ); ?>
			</header>

		<?php endif; ?>

	</div>
</div>
