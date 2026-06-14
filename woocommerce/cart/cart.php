<?php
/**
 * Carrito — layout premium B2B Abalturas.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package Abalturas
 * @version 10.8.0
 */

defined( 'ABSPATH' ) || exit;

$cart_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;

do_action( 'woocommerce_before_cart' );
?>

<div class="abalturas-cart">
	<header class="abalturas-cart__header">
		<p class="abalturas-cart__eyebrow"><?php esc_html_e( 'Tienda', 'abalturas' ); ?></p>
		<h1 class="abalturas-cart__title"><?php esc_html_e( 'Carrito de compras', 'abalturas' ); ?></h1>
		<?php if ( $cart_count > 0 ) : ?>
			<p class="abalturas-cart__meta">
				<?php
				echo esc_html(
					sprintf(
						/* translators: %d: number of items in cart */
						_n( '%d producto en su pedido', '%d productos en su pedido', $cart_count, 'abalturas' ),
						$cart_count
					)
				);
				?>
			</p>
		<?php endif; ?>
	</header>

	<div class="abalturas-cart__layout">
		<div class="abalturas-cart__main">
			<form class="woocommerce-cart-form abalturas-cart__form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
				<?php do_action( 'woocommerce_before_cart_table' ); ?>

				<div class="abalturas-cart__items shop_table shop_table_responsive cart woocommerce-cart-form__contents">
					<?php do_action( 'woocommerce_before_cart_contents' ); ?>

					<?php
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
						$visible    = apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key );

						if ( ! ( $_product instanceof WC_Product ) || ! $_product->exists() || $cart_item['quantity'] <= 0 || ! $visible ) {
							continue;
						}

						$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
						$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
						$sku               = $_product->get_sku();
						$thumbnail         = apply_filters(
							'woocommerce_cart_item_thumbnail',
							$_product->get_image(
								array( 100, 100 ),
								array(
									'class' => 'abalturas-cart-item__thumb-img',
								)
							),
							$cart_item,
							$cart_item_key
						);

						if ( $_product->is_sold_individually() ) {
							$min_quantity = 1;
							$max_quantity = 1;
						} else {
							$min_quantity = 0;
							$max_quantity = $_product->get_max_purchase_quantity();
						}

						$product_quantity = woocommerce_quantity_input(
							array(
								'input_name'   => "cart[{$cart_item_key}][qty]",
								'input_value'  => $cart_item['quantity'],
								'max_value'    => $max_quantity,
								'min_value'    => $min_quantity,
								'product_name' => $product_name,
								'classes'      => array( 'input-text', 'qty', 'text', 'abalturas-cart-item__qty-input' ),
							),
							$_product,
							false
						);
						?>
						<article class="woocommerce-cart-form__cart-item abalturas-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>" data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>">
							<div class="abalturas-cart-item__media product-thumbnail">
								<?php
								if ( ! $product_permalink ) {
									echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								} else {
									printf( '<a href="%s" class="abalturas-cart-item__thumb-link">%s</a>', esc_url( $product_permalink ), $thumbnail ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								}
								?>
							</div>

							<div class="abalturas-cart-item__body product-name">
								<div class="abalturas-cart-item__head">
									<h2 class="abalturas-cart-item__title">
										<?php
										if ( ! $product_permalink ) {
											echo wp_kses_post( $product_name );
										} else {
											echo wp_kses_post(
												apply_filters(
													'woocommerce_cart_item_name',
													sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), esc_html( $_product->get_name() ) ),
													$cart_item,
													$cart_item_key
												)
											);
										}
										?>
									</h2>
									<div class="product-remove abalturas-cart-item__remove">
										<?php
										echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
											'woocommerce_cart_item_remove_link',
											sprintf(
												'<a role="button" href="%s" class="remove abalturas-cart-item__remove-btn" aria-label="%s" data-product_id="%s" data-product_sku="%s"><span aria-hidden="true">&times;</span></a>',
												esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
												esc_attr(
													sprintf(
														/* translators: %s: product name */
														__( 'Eliminar %s del carrito', 'abalturas' ),
														wp_strip_all_tags( $product_name )
													)
												),
												esc_attr( (string) $product_id ),
												esc_attr( $_product->get_sku() )
											),
											$cart_item_key
										);
										?>
									</div>
								</div>

								<?php if ( $sku ) : ?>
									<p class="abalturas-cart-item__sku">
										<span class="abalturas-cart-item__label"><?php esc_html_e( 'SKU', 'abalturas' ); ?></span>
										<span class="abalturas-cart-item__sku-value"><?php echo esc_html( $sku ); ?></span>
									</p>
								<?php endif; ?>

								<?php do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key ); ?>
								<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

								<?php
								if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
									echo wp_kses_post(
										apply_filters(
											'woocommerce_cart_item_backorder_notification',
											'<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>',
											$product_id
										)
									);
								}
								?>

								<div class="abalturas-cart-item__grid">
									<div class="abalturas-cart-item__field product-price">
										<span class="abalturas-cart-item__label"><?php esc_html_e( 'Precio unitario', 'abalturas' ); ?></span>
										<span class="abalturas-cart-item__value abalturas-cart-item__price">
											<?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										</span>
									</div>

									<div class="abalturas-cart-item__field product-quantity">
										<span class="abalturas-cart-item__label"><?php esc_html_e( 'Cantidad', 'abalturas' ); ?></span>
										<div class="abalturas-qty-stepper">
											<button type="button" class="abalturas-qty-stepper__btn" data-action="minus" aria-label="<?php esc_attr_e( 'Disminuir cantidad', 'abalturas' ); ?>">−</button>
											<?php echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
											<button type="button" class="abalturas-qty-stepper__btn" data-action="plus" aria-label="<?php esc_attr_e( 'Aumentar cantidad', 'abalturas' ); ?>">+</button>
										</div>
									</div>

									<div class="abalturas-cart-item__field abalturas-cart-item__field--subtotal product-subtotal">
										<span class="abalturas-cart-item__label"><?php esc_html_e( 'Subtotal', 'abalturas' ); ?></span>
										<span class="abalturas-cart-item__value abalturas-cart-item__subtotal">
											<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										</span>
									</div>
								</div>
							</div>
						</article>
						<?php
					}
					?>

					<?php do_action( 'woocommerce_cart_contents' ); ?>
				</div>

				<div class="abalturas-cart__actions actions">
					<?php if ( wc_coupons_enabled() ) : ?>
						<div class="coupon abalturas-cart__coupon">
							<label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label>
							<input type="text" name="coupon_code" class="input-text abalturas-cart__coupon-input" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Código de cupón', 'abalturas' ); ?>" />
							<button type="submit" class="button abalturas-cart__coupon-btn<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>">
								<?php esc_html_e( 'Aplicar cupón', 'abalturas' ); ?>
							</button>
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
					<?php endif; ?>

					<button type="submit" class="button abalturas-cart__update-btn<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>">
						<?php esc_html_e( 'Actualizar carrito', 'abalturas' ); ?>
					</button>

					<?php do_action( 'woocommerce_cart_actions' ); ?>
					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</div>

				<?php do_action( 'woocommerce_after_cart_table' ); ?>
			</form>
		</div>

		<aside class="abalturas-cart__sidebar" aria-label="<?php esc_attr_e( 'Resumen del pedido', 'abalturas' ); ?>">
			<?php woocommerce_cart_totals(); ?>
		</aside>
	</div>

	<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

	<div class="abalturas-cart__recommended">
		<?php woocommerce_cross_sell_display( 4, 4 ); ?>
		<?php
		if ( ! WC()->cart->get_cross_sells() ) {
			$recommended = abalturas_get_cart_recommended_products( 4 );
			if ( ! empty( $recommended ) ) :
				?>
				<section class="cross-sells abalturas-cart-cross-sells">
					<header class="abalturas-cart-cross-sells__header">
						<p class="abalturas-cart-cross-sells__eyebrow"><?php esc_html_e( 'Complemente su pedido', 'abalturas' ); ?></p>
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
				<?php
			endif;
		}
		?>
	</div>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
