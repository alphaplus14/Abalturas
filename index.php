<?php
/**
 * Plantilla índice (respaldo)
 *
 * @package Abalturas
 */
get_header();
?>
<main id="abalturas-main" class="w-full py-16" tabindex="-1">
	<div class="w-full">
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				?>
				<article <?php post_class( 'prose prose-neutral max-w-none' ); ?>>
					<?php the_title( '<h1>', '</h1>' ); ?>
					<?php the_content(); ?>
				</article>
				<?php
			}
		} else {
			echo '<p>' . esc_html__( 'No hay entradas.', 'abalturas' ) . '</p>';
		}
		?>
	</div>
</main>
<?php
get_footer();
