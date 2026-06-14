<?php
/**
 * URL no reconocida — evita caer en index.php con «No hay entradas» (confuso).
 *
 * @package Abalturas
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="abalturas-main" class="w-full py-16" tabindex="-1">
	<div class="w-full rounded-xl border border-slate-200 bg-white px-6 py-10 shadow-sm sm:px-10">
		<p class="text-[11px] font-bold uppercase tracking-[0.22em] text-industrial"><?php esc_html_e( 'Error 404', 'abalturas' ); ?></p>
		<h1 class="mt-2 text-2xl font-bold tracking-tight text-charcoal sm:text-3xl"><?php esc_html_e( 'Página no encontrada', 'abalturas' ); ?></h1>
		<p class="mt-4 text-[15px] leading-relaxed text-slate-700">
			<?php esc_html_e( 'Esta dirección no existe o los enlaces permanentes no están bien configurados. Si acabas de publicar una página con URL amigable, revisa Ajustes → Enlaces permanentes y pulsa «Guardar cambios».', 'abalturas' ); ?>
		</p>
		<ul class="mt-8 list-disc space-y-2 ps-5 text-sm text-slate-700">
			<li><a class="font-semibold text-industrial underline underline-offset-4 hover:text-safety" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Ir al inicio', 'abalturas' ); ?></a></li>
			<?php if ( function_exists( 'abalturas_get_normativa_res4272_page_url' ) ) : ?>
				<li><a class="font-semibold text-industrial underline underline-offset-4 hover:text-safety" href="<?php echo esc_url( abalturas_get_normativa_res4272_page_url() ); ?>"><?php esc_html_e( 'Ir a normatividad trabajo en alturas', 'abalturas' ); ?></a></li>
			<?php endif; ?>
		</ul>
	</div>
</main>
<?php
get_footer();
