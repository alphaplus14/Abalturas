<?php
/**
 * Carrito WooCommerce — presentación premium B2B (Abalturas).
 *
 * @package Abalturas
 */

defined( 'ABSPATH' ) || exit;

/**
 * Texto mostrado cuando el envío se cotiza manualmente (sin tarifa fija).
 */
function abalturas_get_shipping_quote_label(): string {
	return (string) apply_filters( 'abalturas_shipping_quote_label', __( 'A cotizar', 'abalturas' ) );
}

/**
 * Título del recuadro informativo de envío.
 */
function abalturas_get_shipping_info_title(): string {
	return (string) apply_filters( 'abalturas_shipping_info_title', __( 'Información de envío', 'abalturas' ) );
}

/**
 * Aviso sobre cotización del costo de envío.
 */
function abalturas_get_shipping_quote_notice(): string {
	return (string) apply_filters(
		'abalturas_shipping_quote_notice',
		__( 'El costo se confirma según peso, volumen y ciudad de destino.', 'abalturas' )
	);
}

/**
 * Plazo estimado de entrega tras confirmar la compra.
 */
function abalturas_get_shipping_delivery_notice(): string {
	return (string) apply_filters(
		'abalturas_shipping_delivery_notice',
		__( 'Entrega estimada en 10 días calendario, a partir de la confirmación del pedido.', 'abalturas' )
	);
}

/**
 * Recuadro informativo de envío (carrito clásico).
 */
function abalturas_render_shipping_info_notice(): void {
	$title    = abalturas_get_shipping_info_title();
	$quote    = abalturas_get_shipping_quote_notice();
	$delivery = abalturas_get_shipping_delivery_notice();

	if ( '' === $quote && '' === $delivery ) {
		return;
	}
	?>
	<div class="abalturas-cart-shipping-info" role="note">
		<?php if ( '' !== $title ) : ?>
			<p class="abalturas-cart-shipping-info__title"><?php echo esc_html( $title ); ?></p>
		<?php endif; ?>
		<ul class="abalturas-cart-shipping-info__list">
			<?php if ( '' !== $quote ) : ?>
				<li class="abalturas-cart-shipping-info__item"><?php echo esc_html( $quote ); ?></li>
			<?php endif; ?>
			<?php if ( '' !== $delivery ) : ?>
				<li class="abalturas-cart-shipping-info__item abalturas-cart-shipping-info__item--delivery"><?php echo esc_html( $delivery ); ?></li>
			<?php endif; ?>
		</ul>
	</div>
	<?php
}

/**
 * Contexto donde el carrito calcula envío (página, checkout, AJAX y bloques Store API).
 */
function abalturas_is_cart_rate_context(): bool {
	if ( function_exists( 'is_cart' ) && is_cart() ) {
		return true;
	}
	if ( function_exists( 'is_checkout' ) && is_checkout() ) {
		return true;
	}
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return true;
	}
	if ( function_exists( 'WC' ) && WC()->is_store_api_request() ) {
		return true;
	}
	return false;
}

/**
 * Selecciona el método «envío a cotizar» (costo $0 en carrito/checkout).
 */
function abalturas_ensure_quote_shipping_method(): void {
	if ( ! function_exists( 'WC' ) || ! WC()->cart || WC()->cart->is_empty() || ! WC()->session ) {
		return;
	}

	WC()->customer->set_shipping_country( 'CO' );
	WC()->customer->set_billing_country( 'CO' );
	WC()->customer->set_calculated_shipping( true );

	WC()->cart->calculate_shipping();
	$packages = WC()->shipping()->get_packages();
	$chosen   = WC()->session->get( 'chosen_shipping_methods', array() );
	$updated  = false;

	foreach ( $packages as $i => $package ) {
		if ( empty( $package['rates'] ) ) {
			continue;
		}

		$quote_rate = 'abalturas_envio_cotizar';
		if ( ! isset( $package['rates'][ $quote_rate ] ) ) {
			$quote_rate = (string) array_key_first( $package['rates'] );
		}

		if ( empty( $chosen[ $i ] ) || $chosen[ $i ] !== $quote_rate ) {
			$chosen[ $i ] = $quote_rate;
			$updated      = true;
		}
	}

	if ( $updated ) {
		WC()->session->set( 'chosen_shipping_methods', $chosen );
	}
}

add_action(
	'woocommerce_before_calculate_totals',
	static function ( $cart ) {
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			return;
		}
		if ( ! abalturas_is_cart_rate_context() ) {
			return;
		}
		abalturas_ensure_quote_shipping_method();
	},
	5
);

/** Ocultar calculadora de envío en carrito (tarifa fija nacional). */
add_filter(
	'woocommerce_shipping_show_shipping_calculator',
	static function ( $show, $index ) {
		unset( $index );
		if ( function_exists( 'is_cart' ) && is_cart() ) {
			return false;
		}
		return $show;
	},
	10,
	2
);

/**
 * Productos recomendados para el carrito (cross-sells o fallback por categoría / destacados).
 *
 * @param int $limit Máximo de productos.
 * @return WC_Product[]
 */
function abalturas_get_cart_recommended_products( int $limit = 4 ): array {
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		return array();
	}

	$limit = max( 1, min( 8, $limit ) );
	$ids   = WC()->cart->get_cross_sells();

	if ( ! empty( $ids ) ) {
		$products = array();
		foreach ( array_slice( array_unique( array_map( 'absint', $ids ) ), 0, $limit ) as $id ) {
			$product = wc_get_product( $id );
			if ( $product instanceof WC_Product && $product->is_visible() ) {
				$products[] = $product;
			}
		}
		if ( count( $products ) >= $limit ) {
			return array_slice( $products, 0, $limit );
		}
	} else {
		$products = array();
	}

	$exclude = array();
	foreach ( WC()->cart->get_cart() as $item ) {
		$exclude[] = (int) $item['product_id'];
	}
	foreach ( $products as $product ) {
		$exclude[] = $product->get_id();
	}
	$exclude = array_unique( array_filter( $exclude ) );

	$cat_ids = array();
	foreach ( WC()->cart->get_cart() as $item ) {
		$terms = get_the_terms( (int) $item['product_id'], 'product_cat' );
		if ( is_array( $terms ) ) {
			foreach ( $terms as $term ) {
				$cat_ids[] = (int) $term->term_id;
			}
		}
	}
	$cat_ids = array_unique( array_filter( $cat_ids ) );

	if ( ! empty( $cat_ids ) && count( $products ) < $limit ) {
		$query = wc_get_products(
			array(
				'status'   => 'publish',
				'limit'    => $limit - count( $products ),
				'exclude'  => $exclude,
				'category' => array_map( 'strval', array_slice( $cat_ids, 0, 6 ) ),
				'orderby'  => 'popularity',
			)
		);
		foreach ( $query as $product ) {
			if ( $product instanceof WC_Product && $product->is_visible() ) {
				$products[] = $product;
				$exclude[]  = $product->get_id();
			}
			if ( count( $products ) >= $limit ) {
				break;
			}
		}
	}

	if ( count( $products ) < $limit && function_exists( 'abalturas_get_home_featured_products' ) ) {
		foreach ( abalturas_get_home_featured_products( $limit ) as $product ) {
			if ( in_array( $product->get_id(), $exclude, true ) ) {
				continue;
			}
			$products[] = $product;
			if ( count( $products ) >= $limit ) {
				break;
			}
		}
	}

	return array_slice( $products, 0, $limit );
}

/**
 * Enlace secundario «Seguir comprando» (debajo del listado de productos).
 */
function abalturas_render_cart_continue_shopping_link(): void {
	if ( ! function_exists( 'WC' ) || ! WC()->cart || WC()->cart->is_empty() ) {
		return;
	}

	$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/tienda/' );
	?>
	<p class="abalturas-cart-continue-shopping">
		<a class="abalturas-cart-continue-shopping__link" href="<?php echo esc_url( $shop_url ); ?>">
			<span class="abalturas-cart-continue-shopping__arrow" aria-hidden="true">←</span>
			<?php esc_html_e( 'Seguir comprando', 'abalturas' ); ?>
		</a>
	</p>
	<?php
}

/**
 * URL de la página del carrito.
 */
function abalturas_get_cart_page_url(): string {
	if ( function_exists( 'wc_get_cart_url' ) ) {
		return (string) wc_get_cart_url();
	}

	return (string) home_url( '/carrito/' );
}

/**
 * HTML del panel mini-carrito (fragmentos AJAX y render inicial).
 */
function abalturas_get_header_mini_cart_panel_html(): string {
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		return abalturas_get_header_mini_cart_empty_html();
	}

	$cart = WC()->cart;
	if ( $cart->is_empty() ) {
		return abalturas_get_header_mini_cart_empty_html();
	}

	$count     = (int) $cart->get_cart_contents_count();
	$max_items = (int) apply_filters( 'abalturas_header_mini_cart_max_items', 4 );
	$items     = array_slice( $cart->get_cart(), 0, max( 1, $max_items ), true );
	$remaining = max( 0, count( $cart->get_cart() ) - count( $items ) );

	ob_start();
	?>
	<div class="abalturas-header-mini-cart__head">
		<p class="abalturas-header-mini-cart__title">
			<?php
			echo esc_html(
				sprintf(
					/* translators: %d: number of items in cart */
					_n( 'Carrito (%d artículo)', 'Carrito (%d artículos)', $count, 'abalturas' ),
					$count
				)
			);
			?>
		</p>
	</div>
	<ul class="abalturas-header-mini-cart__items" role="list">
		<?php
		foreach ( $items as $cart_item_key => $cart_item ) {
			abalturas_render_header_mini_cart_item( $cart_item_key, $cart_item );
		}
		?>
	</ul>
	<?php if ( $remaining > 0 ) : ?>
		<p class="abalturas-header-mini-cart__more">
			<?php
			echo esc_html(
				sprintf(
					/* translators: %d: additional products not shown */
					__( '+%d productos más en tu carrito', 'abalturas' ),
					$remaining
				)
			);
			?>
		</p>
	<?php endif; ?>
	<div class="abalturas-header-mini-cart__footer">
		<div class="abalturas-header-mini-cart__subtotal">
			<span class="abalturas-header-mini-cart__subtotal-label"><?php esc_html_e( 'Subtotal (sin envío)', 'abalturas' ); ?></span>
			<span class="abalturas-header-mini-cart__subtotal-value"><?php echo wp_kses_post( wc_price( $cart->get_cart_contents_total() ) ); ?></span>
		</div>
		<div class="abalturas-header-mini-cart__actions">
			<a class="abalturas-header-mini-cart__btn abalturas-header-mini-cart__btn--secondary" href="<?php echo esc_url( abalturas_get_cart_page_url() ); ?>">
				<?php esc_html_e( 'Ver carrito', 'abalturas' ); ?>
			</a>
			<a class="abalturas-header-mini-cart__btn abalturas-header-mini-cart__btn--primary" href="<?php echo esc_url( function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : home_url( '/finalizar-compra/' ) ); ?>">
				<?php esc_html_e( 'Finalizar compra', 'abalturas' ); ?>
			</a>
		</div>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * Ítem del mini-carrito.
 *
 * @param string               $cart_item_key Cart item key.
 * @param array<string, mixed> $cart_item     Cart item data.
 */
function abalturas_render_header_mini_cart_item( string $cart_item_key, array $cart_item ): void {
	$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
	if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 ) {
		return;
	}

	$product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
	$product_link = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
	$thumbnail    = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'woocommerce_thumbnail', array( 'class' => 'abalturas-header-mini-cart__thumb-img' ) ), $cart_item, $cart_item_key );
	$line_total   = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
	?>
	<li class="abalturas-header-mini-cart__item">
		<div class="abalturas-header-mini-cart__thumb">
			<?php
			if ( $product_link ) {
				echo wp_kses_post( sprintf( '<a href="%s" tabindex="-1">%s</a>', esc_url( $product_link ), $thumbnail ) );
			} else {
				echo wp_kses_post( $thumbnail );
			}
			?>
		</div>
		<div class="abalturas-header-mini-cart__meta">
			<p class="abalturas-header-mini-cart__name">
				<?php
				if ( $product_link ) {
					printf( '<a href="%s">%s</a>', esc_url( $product_link ), wp_kses_post( $product_name ) );
				} else {
					echo wp_kses_post( $product_name );
				}
				?>
			</p>
			<p class="abalturas-header-mini-cart__qty">
				<?php
				echo esc_html(
					sprintf(
						/* translators: 1: quantity, 2: unit price */
						__( '%1$s × %2$s', 'abalturas' ),
						(string) $cart_item['quantity'],
						wp_strip_all_tags( wc_price( $_product->get_price() ) )
					)
				);
				?>
			</p>
		</div>
		<div class="abalturas-header-mini-cart__line-total"><?php echo wp_kses_post( $line_total ); ?></div>
	</li>
	<?php
}

/**
 * Estado vacío del mini-carrito.
 */
function abalturas_get_header_mini_cart_empty_html(): string {
	$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/tienda/' );

	ob_start();
	?>
	<div class="abalturas-header-mini-cart__empty">
		<p class="abalturas-header-mini-cart__empty-text"><?php esc_html_e( 'Tu carrito está vacío', 'abalturas' ); ?></p>
		<a class="abalturas-header-mini-cart__btn abalturas-header-mini-cart__btn--primary" href="<?php echo esc_url( $shop_url ); ?>">
			<?php esc_html_e( 'Ver productos', 'abalturas' ); ?>
		</a>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * Mini-carrito del header (icono + panel desplegable).
 */
function abalturas_render_header_mini_cart(): void {
	if ( ! function_exists( 'WC' ) ) {
		return;
	}

	$count      = WC()->cart ? (int) WC()->cart->get_cart_contents_count() : 0;
	$cart_badge = $count > 99 ? '99+' : (string) $count;
	$badge_class = 'absolute right-1 top-1 flex h-[18px] min-w-[18px] items-center justify-center rounded-full bg-safety px-1 text-[10px] font-bold leading-none text-white ring-2 ring-white xl:right-1.5 xl:top-1.5';
	?>
	<div id="abalturas-header-mini-cart" class="abalturas-header-mini-cart">
		<button
			type="button"
			id="abalturas-header-cart-toggle"
			class="abalturas-header-mini-cart__toggle relative inline-flex items-center justify-center rounded-md p-2.5 text-slate-800 outline-none ring-offset-white hover:bg-slate-100 hover:text-industrial focus-visible:ring-2 focus-visible:ring-industrial/35 xl:p-3"
			aria-controls="abalturas-header-mini-cart-panel"
			aria-expanded="false"
			aria-haspopup="dialog"
			aria-label="<?php esc_attr_e( 'Carrito', 'abalturas' ); ?>"
		>
			<svg class="size-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
			<span id="abalturas-header-cart-badge" class="<?php echo esc_attr( $badge_class ); ?>"<?php echo $count > 0 ? '' : ' hidden'; ?>><?php echo $count > 0 ? esc_html( $cart_badge ) : ''; ?></span>
		</button>
		<div
			id="abalturas-header-mini-cart-panel"
			class="abalturas-header-mini-cart__panel"
			role="dialog"
			aria-modal="false"
			aria-label="<?php esc_attr_e( 'Vista previa del carrito', 'abalturas' ); ?>"
			hidden
		>
			<div id="abalturas-header-mini-cart-content">
				<?php echo abalturas_get_header_mini_cart_panel_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML generado con escape. ?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Botón para volver al carrito desde checkout.
 *
 * @param string $context header|sidebar|default
 */
function abalturas_render_checkout_back_to_cart_link( string $context = 'default' ): void {
	if ( ! function_exists( 'is_checkout' ) || ! is_checkout() ) {
		return;
	}

	$classes = array( 'abalturas-checkout-back-to-cart' );
	if ( in_array( $context, array( 'header', 'sidebar' ), true ) ) {
		$classes[] = 'abalturas-checkout-back-to-cart--' . $context;
	}
	?>
	<p class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<a class="abalturas-checkout-back-to-cart__btn" href="<?php echo esc_url( abalturas_get_cart_page_url() ); ?>">
			<span class="abalturas-checkout-back-to-cart__arrow" aria-hidden="true">←</span>
			<?php esc_html_e( 'Volver al carrito', 'abalturas' ); ?>
		</a>
	</p>
	<?php
}

/** Contador del carrito en el header — fragmentos AJAX clásicos. */
add_filter(
	'woocommerce_add_to_cart_fragments',
	static function ( $fragments ) {
		if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
			return $fragments;
		}

		$count = (int) WC()->cart->get_cart_contents_count();
		$badge = $count > 99 ? '99+' : (string) $count;
		$class = 'absolute right-1 top-1 flex h-[18px] min-w-[18px] items-center justify-center rounded-full bg-safety px-1 text-[10px] font-bold leading-none text-white ring-2 ring-white xl:right-1.5 xl:top-1.5';

		if ( $count > 0 ) {
			$fragments['#abalturas-header-cart-badge'] = '<span id="abalturas-header-cart-badge" class="' . esc_attr( $class ) . '">' . esc_html( $badge ) . '</span>';
		} else {
			$fragments['#abalturas-header-cart-badge'] = '<span id="abalturas-header-cart-badge" class="' . esc_attr( $class ) . '" hidden></span>';
		}

		$fragments['#abalturas-header-mini-cart-content'] = '<div id="abalturas-header-mini-cart-content">' . abalturas_get_header_mini_cart_panel_html() . '</div>';

		return $fragments;
	}
);

/** Sincronizar contador del header con bloques WooCommerce y Store API. */
add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( ! function_exists( 'WC' ) ) {
			return;
		}

		$js_path = get_stylesheet_directory() . '/assets/js/header-cart-count.js';
		if ( ! is_readable( $js_path ) ) {
			return;
		}

		wp_enqueue_script(
			'abalturas-header-cart-count',
			get_stylesheet_directory_uri() . '/assets/js/header-cart-count.js',
			array(),
			filemtime( $js_path ),
			true
		);

		$css_path = get_stylesheet_directory() . '/assets/css/header-mini-cart.css';
		if ( is_readable( $css_path ) ) {
			$mini_cart_deps = array();
			if ( wp_style_is( 'abalturas-site-brand', 'registered' ) || wp_style_is( 'abalturas-site-brand', 'enqueued' ) ) {
				$mini_cart_deps[] = 'abalturas-site-brand';
			}
			wp_enqueue_style(
				'abalturas-header-mini-cart',
				get_stylesheet_directory_uri() . '/assets/css/header-mini-cart.css',
				$mini_cart_deps,
				filemtime( $css_path )
			);
		}

		wp_localize_script(
			'abalturas-header-cart-count',
			'abalturasHeaderCart',
			array(
				'cartUrl'     => abalturas_get_cart_page_url(),
				'checkoutUrl' => function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : home_url( '/finalizar-compra/' ),
				'shopUrl'     => function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/tienda/' ),
				'maxItems'    => (int) apply_filters( 'abalturas_header_mini_cart_max_items', 4 ),
				'i18n'        => array(
					'titleSingular' => __( 'Carrito (%d artículo)', 'abalturas' ),
					'titlePlural'   => __( 'Carrito (%d artículos)', 'abalturas' ),
					'empty'         => __( 'Tu carrito está vacío', 'abalturas' ),
					'viewProducts'  => __( 'Ver productos', 'abalturas' ),
					'viewCart'      => __( 'Ver carrito', 'abalturas' ),
					'checkout'      => __( 'Finalizar compra', 'abalturas' ),
					'subtotal'      => __( 'Subtotal (sin envío)', 'abalturas' ),
					'more'          => __( '+%d productos más en tu carrito', 'abalturas' ),
					'qty'           => __( '%1$s × %2$s', 'abalturas' ),
				),
			)
		);
	},
	25
);

/** Encolar CSS/JS del carrito. */
add_action(
	'wp_enqueue_scripts',
	static function () {
		$is_cart_flow = ( function_exists( 'is_cart' ) && is_cart() )
			|| ( function_exists( 'is_checkout' ) && is_checkout() );

		if ( ! $is_cart_flow ) {
			return;
		}

		$css_path = get_stylesheet_directory() . '/assets/css/woocommerce-cart.css';
		$js_path  = get_stylesheet_directory() . '/assets/js/woocommerce-cart.js';

		$deps = array();
		foreach ( array( 'woocommerce-layout', 'woocommerce-general' ) as $handle ) {
			if ( wp_style_is( $handle, 'registered' ) || wp_style_is( $handle, 'enqueued' ) ) {
				$deps[] = $handle;
			}
		}

		if ( is_readable( $css_path ) ) {
			wp_enqueue_style(
				'abalturas-wc-cart',
				get_stylesheet_directory_uri() . '/assets/css/woocommerce-cart.css',
				$deps,
				filemtime( $css_path )
			);
			wp_add_inline_style(
				'abalturas-wc-cart',
				':root { --abalturas-shipping-quote: "' . esc_attr( abalturas_get_shipping_quote_label() ) . '"; }'
			);
		}

		if ( is_readable( $js_path ) ) {
			wp_enqueue_script(
				'abalturas-wc-cart',
				get_stylesheet_directory_uri() . '/assets/js/woocommerce-cart.js',
				array( 'jquery' ),
				filemtime( $js_path ),
				true
			);
			wp_localize_script(
				'abalturas-wc-cart',
				'abalturasCart',
				array(
					'checkoutUrl'  => function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : '',
					'cartUrl'      => abalturas_get_cart_page_url(),
					'shopUrl'      => function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/tienda/' ),
					'i18n'         => array(
						'backToCart'   => __( 'Volver al carrito', 'abalturas' ),
						'continue'     => __( 'Continuar al pago', 'abalturas' ),
						'decrease'     => __( 'Disminuir cantidad', 'abalturas' ),
						'increase'     => __( 'Aumentar cantidad', 'abalturas' ),
						'keepShopping' => __( 'Seguir comprando', 'abalturas' ),
						'shipping'     => __( 'Envío', 'abalturas' ),
						'shippingQuote'=> abalturas_get_shipping_quote_label(),
						'shippingInfoTitle' => abalturas_get_shipping_info_title(),
						'shippingNote' => abalturas_get_shipping_quote_notice(),
						'shippingDelivery' => abalturas_get_shipping_delivery_notice(),
						'total'        => __( 'Total (sin envío)', 'abalturas' ),
						'summaryTitle' => __( 'Resumen del pedido', 'abalturas' ),
					),
				)
			);
		}

		if ( function_exists( 'is_cart' ) && is_cart() && is_readable( $loop_css_path = get_stylesheet_directory() . '/assets/css/woocommerce-shop-loop.css' ) ) {
			wp_enqueue_style(
				'abalturas-wc-shop-loop',
				get_stylesheet_directory_uri() . '/assets/css/woocommerce-shop-loop.css',
				$deps,
				filemtime( $loop_css_path )
			);
		}
	},
	40
);

/** Título cross-sells. */
add_filter(
	'woocommerce_product_cross_sells_products_heading',
	static function () {
		return __( 'Productos recomendados', 'abalturas' );
	}
);

/** Envío a cotizar — tarifa $0 en carrito/checkout (el total no incluye envío). */
add_filter(
	'woocommerce_package_rates',
	static function ( $rates, $package ) {
		unset( $package );

		if ( ! abalturas_is_cart_rate_context() ) {
			return $rates;
		}

		if ( ! class_exists( 'WC_Shipping_Rate' ) ) {
			return $rates;
		}

		return array(
			'abalturas_envio_cotizar' => new WC_Shipping_Rate(
				'abalturas_envio_cotizar',
				__( 'Envío', 'abalturas' ),
				0,
				array(),
				'abalturas_quote',
				0
			),
		);
	},
	100,
	2
);

/** Etiqueta del método de envío en carrito clásico. */
add_filter(
	'woocommerce_cart_shipping_method_full_label',
	static function ( $label, $method ) {
		if ( is_object( $method ) && 'abalturas_envio_cotizar' === $method->get_id() ) {
			return abalturas_get_shipping_quote_label();
		}
		return $label;
	},
	10,
	2
);

/** Etiqueta del método en Store API / bloques WooCommerce. */
add_filter(
	'woocommerce_shipping_rate_label',
	static function ( $label, $rate ) {
		if ( is_object( $rate ) && method_exists( $rate, 'get_id' ) && 'abalturas_envio_cotizar' === $rate->get_id() ) {
			return __( 'Envío', 'abalturas' );
		}
		return $label;
	},
	10,
	2
);

/** Ocultar avisos promocionales de envío gratis en carrito. */
add_filter(
	'woocommerce_shipping_notices',
	static function ( $notices ) {
		if (
			( function_exists( 'is_cart' ) && is_cart() )
			|| ( function_exists( 'is_checkout' ) && is_checkout() )
		) {
			return array();
		}
		return $notices;
	}
);

/** Clase body cuando el carrito está vacío (estilos del bloque WooCommerce). */
add_filter(
	'body_class',
	static function ( $classes ) {
		if ( function_exists( 'is_cart' ) && is_cart() && function_exists( 'WC' ) && WC()->cart && WC()->cart->is_empty() ) {
			$classes[] = 'abalturas-cart-page--empty';
		}
		return $classes;
	}
);
