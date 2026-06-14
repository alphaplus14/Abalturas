<?php
/**
 * Vista archivo Tienda — catálogo de productos.
 *
 * Referencia WooCommerce/templates/archive-product.php — `@version 8.6.0`.
 * Abalturas: `get_header()` (no `shop`), `<main id="abalturas-main">` y cabecera de archivo estilizada.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package Abalturas
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

$abalturas_shop_has_products = woocommerce_product_loop();

?>

<main id="abalturas-main" class="abalturas-shop-page bg-mist min-h-[50vh]" tabindex="-1">
	<div class="abalturas-shop-page__inner w-full py-4 sm:py-5 lg:py-6">

		<?php do_action( 'woocommerce_before_main_content' ); ?>

		<header class="abalturas-shop-header border-b border-slate-200/90 pb-3 sm:pb-4 lg:text-left">
			<h1 class="abalturas-shop-header__title text-xl font-extrabold uppercase tracking-[0.1em] text-charcoal sm:text-2xl lg:text-[1.625rem]">
				<?php woocommerce_page_title(); ?>
			</h1>
			<div class="abalturas-shop-header__description prose prose-slate prose-sm mx-auto mt-2 max-w-3xl text-slate-600 lg:mx-0 [&_p:only-child]:my-0 [&_p:empty]:hidden">
				<?php do_action( 'woocommerce_archive_description' ); ?>
			</div>
		</header>

		<?php if ( $abalturas_shop_has_products ) : ?>

			<div class="abalturas-shop-toolbar flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between sm:gap-4">
				<?php woocommerce_result_count(); ?>
				<?php woocommerce_catalog_ordering(); ?>
			</div>

			<?php woocommerce_product_loop_start(); ?>

			<?php
			if ( wc_get_loop_prop( 'total' ) ) {
				while ( have_posts() ) {
					the_post();
					do_action( 'woocommerce_shop_loop' );
					wc_get_template_part( 'content', 'product' );
				}
			}
			?>

			<?php woocommerce_product_loop_end(); ?>

			<?php do_action( 'woocommerce_after_shop_loop' ); ?>

		<?php else : ?>

			<?php do_action( 'woocommerce_no_products_found' ); ?>

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_main_content' ); ?>

	</div>
</main>

<?php
get_footer();
