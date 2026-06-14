<?php
/**
 * Miniaturas de la galería en ficha de producto.
 *
 * Basado en WooCommerce/templates/single-product/product-thumbnails.php — `@version 9.8.0`.
 * Abalturas: mostrar siempre los adjuntos de la galería si existen; el core exige imagen
 * destacada y entonces no se imprime ninguna miniatura en el DOM (Flexslider no llega a
 * generar el segundo thumb).
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     Abalturas
 * @version     9.8.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

if ( ! $product || ! $product instanceof WC_Product ) {
	return '';
}

$attachment_ids = $product->get_gallery_image_ids();

if ( ! $attachment_ids ) {
	return;
}

foreach ( $attachment_ids as $key => $attachment_id ) {
	echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', wc_get_gallery_image_html( $attachment_id, false, $key ), $attachment_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
