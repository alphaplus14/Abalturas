<?php
/**
 * Tarjeta de producto en loop (tienda archivo).
 *
 * Plantilla WooCommerce base `@version 9.4.0` introduce comprobación de visibilidad con `WC_Product::class`.
 * Abalturas: maquetación Tailwind sin los hooks estándar del loop (marcado personalizado coherente con el diseño).
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package Abalturas
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Check if the product is a valid WooCommerce product and ensure its visibility before proceeding.
if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( 'group flex min-h-0 w-full flex-col', $product ); ?>>
	<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="flex h-full min-h-0 flex-1 flex-col overflow-hidden rounded-md border border-slate-200 bg-white shadow-sm outline-none ring-offset-white transition hover:border-safety/35 hover:shadow-md focus-visible:ring-2 focus-visible:ring-safety focus-visible:ring-offset-2">
		<div class="relative flex aspect-square items-center justify-center bg-white p-3 sm:p-4">
			<?php woocommerce_show_product_loop_sale_flash(); ?>
			<?php echo woocommerce_get_product_thumbnail( 'woocommerce_thumbnail', array( 'class' => 'max-h-full max-w-full object-contain transition duration-300 group-hover:scale-[1.02]' ) ); ?>
		</div>
		<div class="abalturas-product-card-body flex flex-1 flex-col border-t border-slate-100 px-3 pb-4 pt-3 text-center sm:px-4 sm:pb-4 sm:pt-3.5">
			<h2 class="abalturas-product-card-title line-clamp-3 text-xs font-bold uppercase leading-snug tracking-wide text-slate-900 sm:text-[13px]">
				<?php echo esc_html( $product->get_name() ); ?>
			</h2>
			<div class="abalturas-product-card-price text-sm font-bold text-industrial sm:text-[15px]">
				<?php echo wp_kses_post( $product->get_price_html() ); ?>
			</div>
			<span class="abalturas-product-card-cta pointer-events-none inline-flex min-h-[2.45rem] w-full shrink-0 items-center justify-center rounded-[3px] border-2 border-safety bg-safety px-2 pb-2 pt-3 text-[10px] font-extrabold uppercase tracking-[0.12em] text-white sm:min-h-[2.6rem] sm:px-2.5 sm:text-[11px]">
				<?php esc_html_e( 'Ver ficha / Comprar', 'abalturas' ); ?>
			</span>
		</div>
	</a>
</li>
