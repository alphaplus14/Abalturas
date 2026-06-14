<?php
/**
 * Página «Pedido recibido» — helpers y assets.
 *
 * @package Abalturas
 */

defined( 'ABSPATH' ) || exit;

/**
 * ¿Estamos en la página de confirmación de pedido?
 */
function abalturas_is_thankyou_page(): bool {
	if ( ! function_exists( 'is_checkout' ) || ! is_checkout() ) {
		return false;
	}
	return function_exists( 'is_wc_endpoint_url' ) && is_wc_endpoint_url( 'order-received' );
}

/**
 * Clases Tailwind del badge según estado del pedido.
 *
 * @param string $status Slug de estado WooCommerce.
 */
function abalturas_get_order_status_badge_classes( string $status ): string {
	$map = array(
		'pending'    => 'border-amber-300 bg-amber-50 text-amber-800',
		'on-hold'    => 'border-amber-300 bg-amber-50 text-amber-800',
		'processing' => 'border-orange-300 bg-orange-50 text-orange-800',
		'completed'  => 'border-emerald-300 bg-emerald-50 text-emerald-800',
		'cancelled'  => 'border-slate-300 bg-slate-100 text-slate-600',
		'refunded'   => 'border-slate-300 bg-slate-100 text-slate-600',
		'failed'     => 'border-red-300 bg-red-50 text-red-800',
	);

	return $map[ $status ] ?? 'border-slate-300 bg-slate-100 text-slate-700';
}

/**
 * Nombre para el saludo de agradecimiento.
 *
 * @param WC_Order $order Pedido.
 */
function abalturas_get_thankyou_customer_name( WC_Order $order ): string {
	$name = trim( (string) $order->get_billing_first_name() );
	if ( '' !== $name ) {
		return $name;
	}

	$company = trim( (string) $order->get_billing_company() );
	if ( '' !== $company ) {
		return $company;
	}

	return __( 'cliente', 'abalturas' );
}

/**
 * URL del catálogo (/productos o página tienda WC).
 */
function abalturas_get_shop_catalog_url(): string {
	$shop = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '';
	if ( is_string( $shop ) && '' !== $shop ) {
		return $shop;
	}
	return home_url( '/productos/' );
}

/**
 * Estilos mínimos para anular reglas genéricas de WooCommerce en pedido recibido.
 */
add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( ! abalturas_is_thankyou_page() ) {
			return;
		}

		$css_path = get_stylesheet_directory() . '/assets/css/woocommerce-thankyou.css';
		if ( ! is_readable( $css_path ) ) {
			return;
		}

		$deps = array( 'abalturas-tailwind' );
		foreach ( array( 'woocommerce-layout', 'woocommerce-general' ) as $handle ) {
			if ( wp_style_is( $handle, 'registered' ) || wp_style_is( $handle, 'enqueued' ) ) {
				$deps[] = $handle;
			}
		}

		wp_enqueue_style(
			'abalturas-wc-thankyou',
			get_stylesheet_directory_uri() . '/assets/css/woocommerce-thankyou.css',
			$deps,
			filemtime( $css_path )
		);
	},
	35
);
