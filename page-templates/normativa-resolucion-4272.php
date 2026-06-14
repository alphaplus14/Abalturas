<?php
/**
 * Plantilla: guía práctica sobre la Resolución 4272/2021 (trabajo en alturas — Colombia).
 *
 * En WordPress: crear una página publicada con slug recomendado `normatividad-trabajo-alturas`
 * (alternativa válida `normatividad-trabajo-en-alturas`). El tema fuerza esta plantilla
 * automáticamente para esos slugs incluso si en «Plantilla» deja «Predeterminada» (el contenido
 * viene de PHP en `template-parts/normativa-resolucion-4272.php`; el editor suele estar vacío).
 *
 * @package Abalturas
 *
 * Template Name: Normatividad — Resolución 4272/2021 (trabajo en alturas)
 * Template Post Type: page
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/normativa', 'resolucion-4272' );
get_footer();
