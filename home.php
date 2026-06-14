<?php
/**
 * Página de entradas: landing solo si la portada es "Últimas entradas"; en caso contrario, listado del blog.
 *
 * @package Abalturas
 */

get_header();

if ( is_front_page() && is_home() ) {
	get_template_part( 'template-parts/content', 'home' );
} else {
	?>
	<main id="abalturas-main" class="min-h-screen w-full bg-mist py-12" tabindex="-1">
		<div class="w-full">
			<header class="mb-8 border-b border-carbon/10 pb-6">
				<h1 class="text-2xl font-bold text-carbon sm:text-3xl">
					<?php
					$blog_page = get_option( 'page_for_posts' );
					if ( $blog_page ) {
						echo esc_html( get_the_title( $blog_page ) );
					} else {
						esc_html_e( 'Blog', 'abalturas' );
					}
					?>
				</h1>
			</header>
			<?php
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					?>
					<article <?php post_class( 'mb-10 rounded-lg border border-carbon/10 bg-white p-6 shadow-sm' ); ?>>
						<h2 class="text-xl font-semibold text-industrial">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<time class="mt-1 block text-sm text-carbon/60" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
							<?php echo esc_html( get_the_date() ); ?>
						</time>
						<div class="mt-4 text-sm leading-relaxed text-carbon/90 sm:text-base">
							<?php the_excerpt(); ?>
						</div>
					</article>
					<?php
				}
				the_posts_pagination(
					array(
						'class'     => 'mt-8 flex justify-center gap-2',
						'prev_text' => __( 'Anterior', 'abalturas' ),
						'next_text' => __( 'Siguiente', 'abalturas' ),
					)
				);
			} else {
				echo '<p class="text-carbon/75">' . esc_html__( 'No hay entradas.', 'abalturas' ) . '</p>';
			}
			?>
		</div>
	</main>
	<?php
}

get_footer();
