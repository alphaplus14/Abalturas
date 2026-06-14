<?php
/**
 * Paginación del catálogo — Abalturas.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package Abalturas
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

if ( $total <= 1 ) {
	return;
}

$pagination = paginate_links(
	apply_filters(
		'woocommerce_pagination_args',
		array(
			'base'      => $base,
			'format'    => $format,
			'add_args'  => false,
			'current'   => max( 1, $current ),
			'total'     => $total,
			'prev_text' => '<span class="abalturas-pagination__icon abalturas-pagination__icon--prev" aria-hidden="true"></span>',
			'next_text' => '<span class="abalturas-pagination__icon abalturas-pagination__icon--next" aria-hidden="true"></span>',
			'type'      => 'list',
			'end_size'  => 3,
			'mid_size'  => 3,
		)
	)
);

if ( ! $pagination ) {
	return;
}

$pagination = str_replace(
	'class="prev page-numbers"',
	'class="prev page-numbers" aria-label="' . esc_attr__( 'Página anterior', 'abalturas' ) . '"',
	$pagination
);
$pagination = str_replace(
	'class="next page-numbers"',
	'class="next page-numbers" aria-label="' . esc_attr__( 'Página siguiente', 'abalturas' ) . '"',
	$pagination
);
?>
<nav class="woocommerce-pagination abalturas-shop-pagination" aria-label="<?php esc_attr_e( 'Paginación de productos', 'abalturas' ); ?>">
	<?php echo $pagination; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- paginate_links output. ?>
</nav>
