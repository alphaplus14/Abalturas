<?php
/**
 * Checkout Colombia — select dependiente Departamento → Ciudad.
 *
 * Blocks: el JS reemplaza el input de ciudad por un <select> nativo.
 * Clásico: WooCommerce renderiza city como select vía woocommerce_default_address_fields.
 *
 * @package Abalturas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ruta al JSON de ciudades indexado por código WooCommerce (CO-XXX).
 */
function abalturas_get_colombia_cities_json_path(): string {
	return get_stylesheet_directory() . '/assets/data/colombia-cities-by-state.json';
}

/**
 * ¿Estamos en el checkout (no página de gracias)?
 */
function abalturas_is_active_checkout(): bool {
	return function_exists( 'is_checkout' )
		&& is_checkout()
		&& ! is_wc_endpoint_url( 'order-received' );
}

/**
 * Ciudades por código de departamento WooCommerce (CO-XXX => string[]).
 *
 * @return array<string, array<int, string>>
 */
function abalturas_get_colombia_cities_by_state(): array {
	static $cache = null;

	if ( null !== $cache ) {
		return $cache;
	}

	$cache  = array();
	$path   = abalturas_get_colombia_cities_json_path();

	if ( ! is_readable( $path ) ) {
		return $cache;
	}

	$decoded = json_decode( (string) file_get_contents( $path ), true );
	if ( is_array( $decoded ) ) {
		$cache = $decoded;
	}

	return $cache;
}

/** Etiqueta en español para el distrito capital en checkout. */
add_filter(
	'woocommerce_states',
	static function ( $states ) {
		if ( isset( $states['CO']['CO-DC'] ) ) {
			$states['CO']['CO-DC'] = __( 'Bogotá D.C.', 'abalturas' );
		}

		return $states;
	},
	20
);

/**
 * Checkout clásico: campo city como select (Blocks se transforma en JS).
 */
add_filter(
	'woocommerce_default_address_fields',
	static function ( $fields ) {
		if ( ! abalturas_is_active_checkout() ) {
			return $fields;
		}

		if ( isset( $fields['city'] ) ) {
			$fields['city']['type']     = 'select';
			$fields['city']['options']  = array(
				'' => __( 'Seleccione una ciudad', 'abalturas' ),
			);
			$fields['city']['class'][]  = 'abalturas-city-select-field';
		}

		return $fields;
	},
	20
);

add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( ! abalturas_is_active_checkout() ) {
			return;
		}

		if ( ! is_readable( abalturas_get_colombia_cities_json_path() ) ) {
			return;
		}

		$js_path  = get_stylesheet_directory() . '/assets/js/checkout-colombia-cities.js';
		$css_path = get_stylesheet_directory() . '/assets/css/checkout-colombia-cities.css';

		if ( ! is_readable( $js_path ) ) {
			return;
		}

		wp_enqueue_script(
			'abalturas-checkout-colombia-cities',
			get_stylesheet_directory_uri() . '/assets/js/checkout-colombia-cities.js',
			array( 'jquery' ),
			filemtime( $js_path ),
			true
		);

		if ( is_readable( $css_path ) ) {
			wp_enqueue_style(
				'abalturas-checkout-colombia-cities',
				get_stylesheet_directory_uri() . '/assets/css/checkout-colombia-cities.css',
				array(),
				filemtime( $css_path )
			);
		}

		wp_localize_script(
			'abalturas-checkout-colombia-cities',
			'abalturasColombiaCities',
			array(
				'citiesByState' => abalturas_get_colombia_cities_by_state(),
				'country'       => 'CO',
				'prefixes'      => array( 'billing', 'shipping' ),
				'i18n'          => array(
					'cityLabel'        => __( 'Ciudad', 'abalturas' ),
					'selectDepartment' => __( 'Seleccione un departamento primero', 'abalturas' ),
					'selectCity'       => __( 'Seleccione una ciudad', 'abalturas' ),
				),
			)
		);
	},
	45
);
