<?php
/**
 * Contenido dentro de single-product.php.
 *
 * Basado en WooCommerce/templates/content-single-product.php — `@version 3.6.0` en el core; hooks estándar conservados.
 * Abalturas: envoltorio de rejilla (galería + resumen + pestañas) con utilidades Tailwind.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package Abalturas
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( post_password_required() ) {
	echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'abalturas-single-product max-w-none', $product ); ?>>

	<?php do_action( 'woocommerce_before_single_product' ); ?>

	<div class="abalturas-product-grid">
		<div class="abalturas-product-gallery-card">
			<?php do_action( 'woocommerce_before_single_product_summary' ); ?>
		</div>

		<div class="summary entry-summary abalturas-product-summary-card">
			<?php do_action( 'woocommerce_single_product_summary' ); ?>
		</div>
	</div>

	<div class="mt-12 border-t border-slate-200/90 pt-10 lg:mt-14 lg:pt-12">
		<?php do_action( 'woocommerce_after_single_product_summary' ); ?>
	</div>

	<?php do_action( 'woocommerce_after_single_product' ); ?>

</div>
