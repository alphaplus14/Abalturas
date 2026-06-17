<?php
/**
 * SEO técnico: robots.txt y noindex en rutas que no son contenido público.
 *
 * @package Abalturas
 */

defined( 'ABSPATH' ) || exit;

/**
 * Slug de la página «Mi cuenta» de WooCommerce (ej. mi-cuenta).
 */
function abalturas_get_myaccount_page_slug(): string {
	if ( ! function_exists( 'wc_get_page_id' ) ) {
		return 'mi-cuenta';
	}

	$page_id = (int) wc_get_page_id( 'myaccount' );
	if ( $page_id <= 0 ) {
		return 'mi-cuenta';
	}

	$slug = get_post_field( 'post_name', $page_id );
	return is_string( $slug ) && '' !== $slug ? $slug : 'mi-cuenta';
}

/**
 * Reglas Disallow/Allow para robots.txt (sin duplicar las ya presentes).
 *
 * @return string[]
 */
function abalturas_get_robots_disallow_rules(): array {
	$account_slug = abalturas_get_myaccount_page_slug();

	$rules = array(
		'Disallow: /wp-admin/',
		'Allow: /wp-admin/admin-ajax.php',
		'Disallow: /wp-includes/',
		'Disallow: /wp-content/plugins/',
		'Disallow: /wp-content/themes/',
		'Disallow: /wp-content/cache/',
		'Disallow: /wp-content/upgrade/',
		'Allow: /wp-content/uploads/',
		'Disallow: /author/',
		'Disallow: /?s=',
		'Disallow: /*?s=',
		'Disallow: /*&s=',
		'Disallow: /' . $account_slug . '/',
		'Disallow: /*?wc-ajax=',
		'Disallow: /*&wc-ajax=',
		'Disallow: /?wc-ajax=',
	);

	if ( function_exists( 'wc_get_page_id' ) ) {
		foreach ( array( 'cart', 'checkout' ) as $wc_page ) {
			$page_id = (int) wc_get_page_id( $wc_page );
			if ( $page_id > 0 ) {
				$slug = get_post_field( 'post_name', $page_id );
				if ( is_string( $slug ) && '' !== $slug ) {
					$rules[] = 'Disallow: /' . $slug . '/';
				}
			}
		}
	}

	return $rules;
}

/**
 * ¿Esta vista no debe indexarse?
 */
function abalturas_should_noindex_page(): bool {
	if ( isset( $_GET['wc-ajax'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return true;
	}

	if ( is_search() ) {
		return true;
	}

	if ( is_author() ) {
		return true;
	}

	if ( function_exists( 'is_cart' ) && is_cart() ) {
		return true;
	}

	if ( function_exists( 'is_checkout' ) && is_checkout() ) {
		return true;
	}

	if ( function_exists( 'is_account_page' ) && is_account_page() ) {
		return true;
	}

	return false;
}

/** Meta robots noindex en búsqueda, autor, cuenta, carrito y checkout. */
add_filter(
	'wp_robots',
	static function ( $robots ) {
		if ( ! abalturas_should_noindex_page() ) {
			return $robots;
		}

		$robots['noindex']   = true;
		$robots['nofollow']  = true;
		$robots['noarchive'] = true;

		return $robots;
	},
	20
);

/**
 * Archivos de autor (/author/admin/) — redirigir a inicio (evita filtrar usuarios WP).
 */
add_action(
	'template_redirect',
	static function () {
		if ( is_admin() || wp_doing_ajax() ) {
			return;
		}

		if ( is_author() ) {
			wp_safe_redirect( home_url( '/' ), 301 );
			exit;
		}
	},
	1
);

/** robots.txt */
add_filter(
	'robots_txt',
	static function ( $output, $public ) {
		if ( ! $public ) {
			return $output;
		}

		foreach ( abalturas_get_robots_disallow_rules() as $rule ) {
			if ( false === strpos( $output, $rule ) ) {
				$output .= "\n" . $rule;
			}
		}

		return $output;
	},
	20,
	2
);
