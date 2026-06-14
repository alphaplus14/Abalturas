<?php
/**
 * Pestaña Descripción — bloques por sección (H2).
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package Abalturas
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $post;

if ( ! $post instanceof WP_Post ) {
	return;
}

abalturas_render_product_description_sections( (string) $post->post_content );
