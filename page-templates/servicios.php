<?php
/**
 * Plantilla: Servicios Abalturas.
 *
 * Crear página publicada con slug `servicios`. El contenido viene del partial PHP;
 * el editor de WordPress puede quedar vacío.
 *
 * @package Abalturas
 *
 * Template Name: Servicios
 * Template Post Type: page
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/content', 'servicios' );
get_footer();
