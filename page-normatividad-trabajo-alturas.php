<?php
/**
 * Normatividad — alta prioridad en jerarquía WP (sin depender solo del filtro page_template).
 *
 * @package Abalturas
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/normativa', 'resolucion-4272' );
get_footer();
