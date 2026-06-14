<?php
/**
 * Apertura del loop de productos — cuadrícula responsive (tienda y relacionados).
 *
 * @package Abalturas
 * @version 9.9.9
 */

defined( 'ABSPATH' ) || exit;

$GLOBALS['woocommerce_loop']['loop'] = 0;

$cols         = wc_get_loop_prop( 'columns' );
$cols         = $cols ? absint( $cols ) : 4;
$extra_class  = '';
$is_related   = function_exists( 'abalturas_is_single_product_extra_loop' ) && abalturas_is_single_product_extra_loop();

if ( $is_related ) {
	$cols        = 4;
	$extra_class = 'abalturas-shop-grid--related';
	$grid_break  = '';
} elseif ( $cols <= 1 ) {
	$grid_break = 'grid-cols-1 gap-y-12';
} elseif ( $cols <= 2 ) {
	$grid_break = 'grid-cols-1 gap-x-10 gap-y-14 sm:grid-cols-2 sm:gap-x-11 lg:gap-x-12 lg:gap-y-16';
} elseif ( 3 === $cols ) {
	$grid_break = 'grid-cols-2 gap-x-8 gap-y-12 sm:gap-x-10 sm:gap-y-14 md:grid-cols-3 md:gap-y-14 lg:gap-x-11 lg:gap-y-16';
} else {
	$grid_break = 'grid-cols-2 gap-x-8 gap-y-12 sm:gap-x-10 sm:gap-y-14 md:grid-cols-3 md:gap-y-14 lg:grid-cols-4 lg:gap-x-11 lg:gap-y-[3.75rem] xl:gap-x-12';
}
?>
<ul class="products columns-<?php echo esc_attr( $cols ); ?> abalturas-shop-grid <?php echo esc_attr( trim( $extra_class ) ); ?> mx-auto mb-12 grid w-full list-none p-0 <?php echo esc_attr( $grid_break ); ?>">
