<?php
/**
 * Plantilla de página estática.
 * La página «Tienda» de WooCommerce debe mostrar el archivo de productos (no index.php).
 *
 * @package Abalturas
 */

defined( 'ABSPATH' ) || exit;

/*
 * Si WooCommerce trata esta URL como tienda pero WordPress eligió page/index,
 * cargamos el mismo archivo que usa el archivo oficial de la tienda.
 */
if ( function_exists( 'is_shop' ) && is_shop() ) {
	wc_get_template( 'archive-product.php' );
	return;
}

if ( function_exists( 'is_cart' ) && is_cart() ) {
	$cart_is_empty = function_exists( 'WC' ) && WC()->cart && WC()->cart->is_empty();
	$shop_link     = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/tienda/' );
	get_header();
	?>
	<main id="abalturas-main" class="abalturas-cart-page w-full<?php echo $cart_is_empty ? ' abalturas-cart-page--empty' : ''; ?>" tabindex="-1">
		<div class="abalturas-cart-page__container">
			<header class="abalturas-cart-block-header">
				<p class="abalturas-cart-block-header__eyebrow"><?php esc_html_e( 'Tienda', 'abalturas' ); ?></p>
				<h1 class="abalturas-cart-block-header__title"><?php esc_html_e( 'Carrito de compras', 'abalturas' ); ?></h1>
			</header>
			<?php
			while ( have_posts() ) {
				the_post();
				?>
				<article <?php post_class( 'abalturas-cart-page__article' ); ?>>
					<div class="entry-content<?php echo $cart_is_empty ? '' : ' abalturas-cart-entry--filled'; ?>">
						<?php the_content(); ?>
						<?php
						if ( ! $cart_is_empty && function_exists( 'abalturas_render_cart_continue_shopping_link' ) ) {
							abalturas_render_cart_continue_shopping_link();
						}
						?>
					</div>
				</article>
				<?php
			}
			if ( $cart_is_empty ) :
				?>
				<p class="abalturas-cart-block-empty-actions">
					<a class="abalturas-cart-block-empty-actions__btn" href="<?php echo esc_url( $shop_link ); ?>">
						<?php esc_html_e( 'Ver catálogo de equipos', 'abalturas' ); ?>
					</a>
				</p>
				<?php
			endif;
			?>
		</div>
	</main>
	<?php
	get_footer();
	return;
}

if ( function_exists( 'is_checkout' ) && is_checkout() ) {
	get_header();
	?>
	<main id="abalturas-main" class="abalturas-checkout-page w-full" tabindex="-1">
		<?php
		while ( have_posts() ) {
			the_post();
			?>
			<article <?php post_class( 'abalturas-checkout-page__article' ); ?>>
				<?php
				if ( function_exists( 'abalturas_render_checkout_back_to_cart_link' ) ) {
					abalturas_render_checkout_back_to_cart_link( 'header' );
				}
				?>
				<?php the_title( '<h1 class="abalturas-checkout-page__title text-charcoal">', '</h1>' ); ?>
				<div class="entry-content text-slate-700">
					<?php the_content(); ?>
				</div>
			</article>
			<?php
		}
		?>
	</main>
	<?php
	get_footer();
	return;
}

get_header();
?>
<main id="abalturas-main" class="w-full py-16" tabindex="-1">
	<?php
	while ( have_posts() ) {
		the_post();
		?>
		<article <?php post_class( 'prose prose-neutral prose-slate max-w-none' ); ?>>
			<?php the_title( '<h1 class="text-charcoal">', '</h1>' ); ?>
			<div class="entry-content text-slate-700">
				<?php the_content(); ?>
			</div>
		</article>
		<?php
	}
	?>
</main>
<?php
get_footer();
