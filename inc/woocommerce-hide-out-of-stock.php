<?php
/**
 * Ocultar productos sin existencias en el front (catálogo, búsqueda, relacionados, URL directa).
 *
 * @package Abalturas
 */

defined( 'ABSPATH' ) || exit;

/**
 * ¿Aplicar filtro de existencias? (solo front público y búsqueda AJAX del sitio).
 */
function abalturas_should_hide_out_of_stock_on_front(): bool {
	if ( wp_doing_ajax() ) {
		$action = isset( $_REQUEST['action'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) : '';
		return 'abalturas_live_product_search' === $action;
	}

	return ! is_admin();
}

/**
 * Tax query para excluir productos marcados como agotados (product_visibility).
 *
 * @return array<int, array<string, mixed>>
 */
function abalturas_get_exclude_outofstock_tax_query(): array {
	if ( ! function_exists( 'wc_get_product_visibility_term_ids' ) ) {
		return array();
	}

	$visibility = wc_get_product_visibility_term_ids();
	if ( empty( $visibility['outofstock'] ) ) {
		return array();
	}

	return array(
		array(
			'taxonomy' => 'product_visibility',
			'field'    => 'term_taxonomy_id',
			'terms'    => array( (int) $visibility['outofstock'] ),
			'operator' => 'NOT IN',
		),
	);
}

/**
 * Añade exclusión de agotados a un tax_query existente.
 *
 * @param array<int, array<string, mixed>>|null $tax_query Tax query.
 * @return array<int, array<string, mixed>>
 */
function abalturas_merge_outofstock_tax_query( $tax_query ): array {
	$tax_query = is_array( $tax_query ) ? $tax_query : array();
	$exclude   = abalturas_get_exclude_outofstock_tax_query();

	if ( empty( $exclude ) ) {
		return $tax_query;
	}

	if ( ! empty( $tax_query ) && ! isset( $tax_query['relation'] ) ) {
		$tax_query['relation'] = 'AND';
	}

	return array_merge( $tax_query, $exclude );
}

/** Catálogo WooCommerce (tienda, categorías, etiquetas). */
add_action(
	'woocommerce_product_query',
	static function ( $query ) {
		if ( ! abalturas_should_hide_out_of_stock_on_front() ) {
			return;
		}

		$tax_query = $query->get( 'tax_query' );
		$query->set( 'tax_query', abalturas_merge_outofstock_tax_query( $tax_query ) );
	},
	20
);

/** Búsquedas y consultas WP_Query de productos fuera del loop principal de WC. */
add_action(
	'pre_get_posts',
	static function ( $query ) {
		if ( ! abalturas_should_hide_out_of_stock_on_front() ) {
			return;
		}

		if ( 'product' !== $query->get( 'post_type' ) && ! in_array( 'product', (array) $query->get( 'post_type' ), true ) ) {
			return;
		}

		$tax_query = $query->get( 'tax_query' );
		$query->set( 'tax_query', abalturas_merge_outofstock_tax_query( $tax_query ) );
	},
	20
);

/** wc_get_products() — portada, carrito recomendados, etc. */
add_filter(
	'woocommerce_product_data_store_cpt_get_products_query',
	static function ( $query_vars ) {
		if ( ! abalturas_should_hide_out_of_stock_on_front() ) {
			return $query_vars;
		}

		if ( ! empty( $query_vars['include'] ) || ! empty( $query_vars['include_variations'] ) ) {
			return $query_vars;
		}

		if ( empty( $query_vars['stock_status'] ) ) {
			$query_vars['stock_status'] = array( 'instock', 'onbackorder' );
		}

		return $query_vars;
	},
	20
);

/** Visibilidad en loops, búsqueda AJAX y widgets que usan is_visible(). */
add_filter(
	'woocommerce_product_is_visible',
	static function ( $visible, $product_id ) {
		if ( ! abalturas_should_hide_out_of_stock_on_front() || ! $visible ) {
			return $visible;
		}

		$product = wc_get_product( $product_id );
		if ( $product && ! $product->is_in_stock() ) {
			return false;
		}

		return $visible;
	},
	20,
	2
);

/** Productos relacionados en ficha. */
add_filter(
	'woocommerce_related_products',
	static function ( $related_posts ) {
		if ( ! abalturas_should_hide_out_of_stock_on_front() || empty( $related_posts ) ) {
			return $related_posts;
		}

		return array_values(
			array_filter(
				$related_posts,
				static function ( $product_id ) {
					$product = wc_get_product( $product_id );
					return $product && $product->is_in_stock();
				}
			)
		);
	},
	20
);

/** Upsells y cross-sells. */
add_filter(
	'woocommerce_product_cross_sells_products',
	static function ( $cross_sells ) {
		if ( ! abalturas_should_hide_out_of_stock_on_front() || empty( $cross_sells ) ) {
			return $cross_sells;
		}

		return array_values(
			array_filter(
				$cross_sells,
				static function ( $product ) {
					return $product instanceof WC_Product && $product->is_in_stock();
				}
			)
		);
	},
	20
);

add_filter(
	'woocommerce_product_upsell_ids',
	static function ( $upsell_ids ) {
		if ( ! abalturas_should_hide_out_of_stock_on_front() || empty( $upsell_ids ) ) {
			return $upsell_ids;
		}

		return array_values(
			array_filter(
				$upsell_ids,
				static function ( $product_id ) {
					$product = wc_get_product( $product_id );
					return $product && $product->is_in_stock();
				}
			)
		);
	},
	20
);

/** URL directa a ficha agotada → redirigir al catálogo. */
add_action(
	'template_redirect',
	static function () {
		if ( ! abalturas_should_hide_out_of_stock_on_front() ) {
			return;
		}

		if ( ! function_exists( 'is_product' ) || ! is_product() ) {
			return;
		}

		$product = wc_get_product( get_queried_object_id() );
		if ( ! $product || $product->is_in_stock() ) {
			return;
		}

		$redirect = function_exists( 'abalturas_get_shop_catalog_url' )
			? abalturas_get_shop_catalog_url()
			: ( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/productos/' ) );

		wp_safe_redirect( $redirect ? $redirect : home_url( '/' ) );
		exit;
	},
	20
);
