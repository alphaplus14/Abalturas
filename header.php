<?php
/**
 * Cabecera del tema — estilos vía Tailwind compilado (`assets/css/tailwind.min.css`, ver package.json).
 *
 * @package Abalturas
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'min-h-screen overflow-x-hidden font-sans antialiased bg-white text-slate-800' ); ?>>
<?php wp_body_open(); ?>
<a class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[120] focus:inline-block focus:rounded-md focus:bg-industrial focus:px-4 focus:py-2 focus:text-sm focus:font-semibold focus:text-white focus:shadow-md" href="#abalturas-main"><?php esc_html_e( 'Ir al contenido principal', 'abalturas' ); ?></a>
<div id="abalturas-shell" class="abalturas-site-shell mx-auto w-full">
<?php get_template_part( 'template-parts/site', 'header' ); ?>
