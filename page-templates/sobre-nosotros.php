<?php
/**
 * Plantilla: Sobre nosotros (misión y visión Abalturas).
 *
 * Crear página publicada con slug `sobre-nosotros`. El contenido viene del partial PHP;
 * el editor de WordPress puede quedar vacío.
 *
 * @package Abalturas
 *
 * Template Name: Sobre nosotros
 * Template Post Type: page
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/content', 'sobre-nosotros' );
get_footer();
