<?php
/**
 * Pie del tema — CTA superpuesto + columnas claras (estilo referencia, colores Abalturas).
 *
 * @package Abalturas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/tienda/' );
$sobre_nosotros_url = function_exists( 'abalturas_get_sobre_nosotros_page_url' ) ? abalturas_get_sobre_nosotros_page_url() : home_url( '/sobre-nosotros/' );
$servicios_url      = function_exists( 'abalturas_get_servicios_page_url' ) ? abalturas_get_servicios_page_url() : home_url( '/servicios/' );
$politica_datos_url = function_exists( 'abalturas_get_politica_datos_page_url' ) ? abalturas_get_politica_datos_page_url() : home_url( '/politica-datos/' );
$terminos_condiciones_url = function_exists( 'abalturas_get_terminos_condiciones_page_url' ) ? abalturas_get_terminos_condiciones_page_url() : home_url( '/terminos-condiciones/' );

$abalturas_contact_channels = function_exists( 'abalturas_get_contact_channels' ) ? abalturas_get_contact_channels() : array();
$abalturas_whatsapp_technical_href  = function_exists( 'abalturas_get_whatsapp_url' ) ? abalturas_get_whatsapp_url( 'technical' ) : 'https://wa.me/573215607926';
$abalturas_whatsapp_commercial_href = function_exists( 'abalturas_get_whatsapp_url' ) ? abalturas_get_whatsapp_url( 'commercial' ) : 'https://wa.me/573027782299';

/**
 * Redes sociales.
 */
$abalturas_footer_social_urls = array(
	'facebook'  => 'https://www.facebook.com/abalturascol?mibextid=ZbWKwL',
	'instagram' => 'https://www.instagram.com/ab_alturas?igshid=MzRlODBiNWFlZA%3D%3D',
	'youtube'   => 'https://www.youtube.com/@abalturasensena8055/about',
	'tiktok'    => 'https://www.tiktok.com/@abalturas?_t=8fgvmhNBLpV&_r=1',
);

/**
 * @param string $maybe_url URL o cadena vacía.
 * @return string Enlace seguro; '#' si está vacío.
 */
$abalturas_footer_resolve_social_href = static function ( $maybe_url ) {
	$maybe_url = is_string( $maybe_url ) ? trim( $maybe_url ) : '';
	return $maybe_url !== '' ? $maybe_url : '#';
};

$abalturas_footer_nav_link = 'rounded-sm text-sm font-normal text-slate-700 transition-colors duration-200 hover:text-safety focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-safety';
$abalturas_footer_col_title = 'text-sm font-bold uppercase tracking-[0.08em] text-charcoal';
$brand_logo                 = abalturas_get_brand_logo();
$show_footer_cta_banner     = function_exists( 'abalturas_should_show_footer_cta_banner' ) ? abalturas_should_show_footer_cta_banner() : true;
?>
</div><!-- #abalturas-shell — pie a ancho completo -->
<footer
	id="abalturas-site-footer"
	class="<?php echo $show_footer_cta_banner ? 'abalturas-site-footer--with-cta' : 'abalturas-site-footer--no-cta-banner'; ?> mt-10 w-full bg-mist font-sans text-slate-800 antialiased"
	role="contentinfo"
>
	<?php if ( $show_footer_cta_banner ) : ?>
	<!-- Nivel 1: CTA — alineado con #abalturas-shell -->
	<div class="abalturas-footer-cta abalturas-site-inner relative z-20 mx-auto w-full">
		<section class="abalturas-cta-banner" aria-labelledby="abalturas-footer-cta-title">
			<div class="cta-shield-bg" aria-hidden="true">
				<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
					<path d="M12 2L3 7v5c0 5.25 3.75 10.15 9 11.35C17.25 22.15 21 17.25 21 12V7L12 2z"/>
					<polyline points="9 12 11 14 15 10" stroke="#ffffff" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
			<div class="cta-content">
				<div class="cta-icon-wrap" aria-hidden="true">
					<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
						<path d="M12 2L3 7v5c0 5.25 3.75 10.15 9 11.35C17.25 22.15 21 17.25 21 12V7L12 2z"/>
						<polyline points="9 12 11 14 15 10" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</div>
				<div class="cta-text">
					<h2 class="cta-headline" id="abalturas-footer-cta-title">
						<?php echo esc_html__( '¿Su empresa cumple con la Resolución 4272?', 'abalturas' ); ?>
					</h2>
					<p class="cta-sub">
						<?php echo esc_html__( 'Asesoría certificada para trabajo en alturas · Colombia', 'abalturas' ); ?>
					</p>
				</div>
			</div>
			<div class="cta-buttons">
				<a
					href="<?php echo esc_url( $abalturas_whatsapp_technical_href ); ?>"
					class="cta-btn cta-btn--primary"
					target="_blank"
					rel="noopener noreferrer"
					aria-label="<?php esc_attr_e( 'Asesoría técnica por WhatsApp (se abre en nueva pestaña)', 'abalturas' ); ?>"
				>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true">
						<path fill="currentColor" d="M20.503 5.42A9.957 9.957 0 0 0 12.036 2C6.956 2 2.83 6.146 2.828 11.239c-.001 1.734.449 3.397 1.297 4.892L3 21.95l6.058-1.592a9.86 9.86 0 0 0 4.973 1.343h.005c5.079 0 9.207-4.147 9.209-9.239a9.173 9.173 0 0 0-2.743-6.943ZM12.04 18.93h-.003a8.236 8.236 0 0 1-4.226-1.166l-.303-.18-4.036 1.062 1.078-3.964-.209-.343a8.274 8.274 0 1 1 7.7 5.592Zm4.547-6.226c-.25-.129-1.477-.736-1.706-.822-.229-.086-.396-.129-.563.129-.167.259-.642.821-.786.99-.146.169-.294.188-.546.058-.251-.129-1.062-.394-2.026-1.254-.746-.673-1.254-1.502-1.403-1.757-.146-.259-.017-.394.118-.527.117-.117.259-.294.389-.446.137-.154.174-.267.274-.446.086-.208.049-.379-.026-.527-.069-.169-.564-1.353-.769-1.852-.207-.489-.418-.427-.573-.439l-.49-.013c-.168 0-.442.068-.674.323-.229.259-.881.868-.881 2.122 0 1.257.919 2.474 1.042 2.642.146.259 1.804 2.743 4.379 3.849.612.262 1.091.418 1.465.539.613.206 1.172.173 1.611.098.489-.069 1.477-.613 1.687-1.208.217-.596.217-1.104.157-1.208-.069-.086-.237-.169-.489-.297Z"/>
					</svg>
					<?php echo esc_html__( 'Asesoría técnica', 'abalturas' ); ?>
				</a>
				<a
					href="<?php echo esc_url( $abalturas_whatsapp_commercial_href ); ?>"
					class="cta-btn cta-btn--secondary"
					target="_blank"
					rel="noopener noreferrer"
					aria-label="<?php esc_attr_e( 'Asesoría comercial por WhatsApp (se abre en nueva pestaña)', 'abalturas' ); ?>"
				>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true">
						<path fill="currentColor" d="M20.503 5.42A9.957 9.957 0 0 0 12.036 2C6.956 2 2.83 6.146 2.828 11.239c-.001 1.734.449 3.397 1.297 4.892L3 21.95l6.058-1.592a9.86 9.86 0 0 0 4.973 1.343h.005c5.079 0 9.207-4.147 9.209-9.239a9.173 9.173 0 0 0-2.743-6.943ZM12.04 18.93h-.003a8.236 8.236 0 0 1-4.226-1.166l-.303-.18-4.036 1.062 1.078-3.964-.209-.343a8.274 8.274 0 1 1 7.7 5.592Zm4.547-6.226c-.25-.129-1.477-.736-1.706-.822-.229-.086-.396-.129-.563.129-.167.259-.642.821-.786.99-.146.169-.294.188-.546.058-.251-.129-1.062-.394-2.026-1.254-.746-.673-1.254-1.502-1.403-1.757-.146-.259-.017-.394.118-.527.117-.117.259-.294.389-.446.137-.154.174-.267.274-.446.086-.208.049-.379-.026-.527-.069-.169-.564-1.353-.769-1.852-.207-.489-.418-.427-.573-.439l-.49-.013c-.168 0-.442.068-.674.323-.229.259-.881.868-.881 2.122 0 1.257.919 2.474 1.042 2.642.146.259 1.804 2.743 4.379 3.849.612.262 1.091.418 1.465.539.613.206 1.172.173 1.611.098.489-.069 1.477-.613 1.687-1.208.217-.596.217-1.104.157-1.208-.069-.086-.237-.169-.489-.297Z"/>
					</svg>
					<?php echo esc_html__( 'Asesoría comercial', 'abalturas' ); ?>
				</a>
			</div>
		</section>
	</div>
	<?php endif; ?>

	<!-- Nivel 2: columnas sobre fondo claro -->
	<div class="abalturas-footer-columns relative z-10 <?php echo $show_footer_cta_banner ? 'pt-10 sm:pt-12 lg:pt-14' : 'pt-10 sm:pt-12 lg:pt-14'; ?>">
		<div class="abalturas-site-inner mx-auto w-full">
			<div class="abalturas-footer-grid">
				<!-- Marca + redes -->
				<div class="abalturas-footer-brand">
					<?php if ( $brand_logo['exists'] ) : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-flex rounded-md outline-none ring-offset-mist focus-visible:ring-2 focus-visible:ring-safety focus-visible:ring-offset-2">
						<img
							src="<?php echo esc_url( $brand_logo['url'] ); ?>"
							width="<?php echo (int) $brand_logo['width']; ?>"
							height="<?php echo (int) $brand_logo['height']; ?>"
							alt="<?php echo esc_attr( $brand_logo['alt'] ); ?>"
							class="abalturas-brand-logo"
							loading="lazy"
							decoding="async"
						/>
					</a>
					<?php endif; ?>
					<p class="mt-5 max-w-xs text-sm leading-relaxed text-slate-600">
						<?php echo esc_html__( 'Comprometidos con la seguridad en altura y el cumplimiento normativo internacional en cada proyecto.', 'abalturas' ); ?>
					</p>
					<ul class="mt-8 flex flex-wrap gap-3" aria-label="<?php echo esc_attr__( 'Redes sociales', 'abalturas' ); ?>">
						<li>
							<a
								href="<?php echo esc_url( $abalturas_footer_resolve_social_href( $abalturas_footer_social_urls['facebook'] ) ); ?>"
								class="inline-flex size-11 items-center justify-center rounded-xl bg-charcoal text-white transition-colors duration-200 hover:bg-safety"
								aria-label="<?php esc_attr_e( 'Facebook', 'abalturas' ); ?>"
								<?php echo $abalturas_footer_social_urls['facebook'] !== '' ? 'rel="noopener noreferrer" target="_blank"' : ''; ?>
							>
								<svg class="size-[22px] shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
							</a>
						</li>
						<li>
							<a
								href="<?php echo esc_url( $abalturas_footer_resolve_social_href( $abalturas_footer_social_urls['instagram'] ) ); ?>"
								class="inline-flex size-11 items-center justify-center rounded-xl bg-charcoal text-white transition-colors duration-200 hover:bg-safety"
								aria-label="<?php esc_attr_e( 'Instagram', 'abalturas' ); ?>"
								<?php echo $abalturas_footer_social_urls['instagram'] !== '' ? 'rel="noopener noreferrer" target="_blank"' : ''; ?>
							>
								<svg class="size-[22px] shrink-0" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.647.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
							</a>
						</li>
						<li>
							<a
								href="<?php echo esc_url( $abalturas_footer_resolve_social_href( $abalturas_footer_social_urls['youtube'] ) ); ?>"
								class="inline-flex size-11 items-center justify-center rounded-xl bg-charcoal text-white transition-colors duration-200 hover:bg-safety"
								aria-label="<?php esc_attr_e( 'YouTube', 'abalturas' ); ?>"
								<?php echo $abalturas_footer_social_urls['youtube'] !== '' ? 'rel="noopener noreferrer" target="_blank"' : ''; ?>
							>
								<svg class="size-[22px] shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M21.8 8.001a2.748 2.748 0 00-1.935-1.948C18.04 5.5 12 5.5 12 5.5s-6.04 0-7.865.553A2.748 2.748 0 002.2 8.001 28.351 28.351 0 001.5 12a28.351 28.351 0 00.7 3.999 2.748 2.748 0 001.935 1.948c1.825.553 7.865.553 7.865.553s6.04 0 7.865-.553a2.748 2.748 0 001.935-1.948A28.351 28.351 0 0022.5 12a28.351 28.351 0 00-.7-3.999zM10.05 14.65v-5.3L15.568 12l-5.518 2.65z"/></svg>
							</a>
						</li>
						<li>
							<a
								href="<?php echo esc_url( $abalturas_footer_resolve_social_href( $abalturas_footer_social_urls['tiktok'] ) ); ?>"
								class="inline-flex size-11 items-center justify-center rounded-xl bg-charcoal text-white transition-colors duration-200 hover:bg-safety"
								aria-label="<?php esc_attr_e( 'TikTok', 'abalturas' ); ?>"
								<?php echo $abalturas_footer_social_urls['tiktok'] !== '' ? 'rel="noopener noreferrer" target="_blank"' : ''; ?>
							>
								<svg class="size-[22px] shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M18.35 6.04c-.81-.52-1.37-1.35-1.55-2.29h-2.09v9.84c0 2.05-1.66 3.71-3.71 3.71S7.29 15.64 7.29 13.59s1.66-3.71 3.71-3.71c.31 0 .61.04.9.11V8.7a6.36 6.36 0 00-.9-.06 6.58 6.58 0 106.58 6.58V9.43a4.38 4.38 0 002.67-.92v-2.47z"/></svg>
							</a>
						</li>
					</ul>
				</div>

				<div class="abalturas-footer-nav-group">
					<div class="abalturas-footer-col">
					<h3 class="<?php echo esc_attr( $abalturas_footer_col_title ); ?>"><?php echo esc_html__( 'Empresa', 'abalturas' ); ?></h3>
					<ul class="abalturas-footer-links">
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="<?php echo esc_attr( $abalturas_footer_nav_link ); ?>"><?php esc_html_e( 'Inicio', 'abalturas' ); ?></a></li>
						<li><a href="<?php echo esc_url( $sobre_nosotros_url ); ?>" class="<?php echo esc_attr( $abalturas_footer_nav_link ); ?>"><?php esc_html_e( 'Sobre nosotros', 'abalturas' ); ?></a></li>
						<li><a href="<?php echo esc_url( $servicios_url ); ?>" class="<?php echo esc_attr( $abalturas_footer_nav_link ); ?>"><?php esc_html_e( 'Servicios', 'abalturas' ); ?></a></li>
					</ul>
					</div>

					<div class="abalturas-footer-col">
					<h3 class="<?php echo esc_attr( $abalturas_footer_col_title ); ?>"><?php echo esc_html__( 'Información', 'abalturas' ); ?></h3>
					<ul class="abalturas-footer-links">
						<li><a href="<?php echo esc_url( $shop_url ); ?>" class="<?php echo esc_attr( $abalturas_footer_nav_link ); ?>"><?php esc_html_e( 'Tienda online', 'abalturas' ); ?></a></li>
					</ul>
					</div>

					<div class="abalturas-footer-col">
					<h3 class="<?php echo esc_attr( $abalturas_footer_col_title ); ?>"><?php echo esc_html__( 'Normatividad', 'abalturas' ); ?></h3>
					<ul class="abalturas-footer-links">
						<li><a href="<?php echo esc_url( $politica_datos_url ); ?>" class="<?php echo esc_attr( $abalturas_footer_nav_link ); ?>"><?php esc_html_e( 'Política de datos', 'abalturas' ); ?></a></li>
						<li><a href="<?php echo esc_url( $terminos_condiciones_url ); ?>" class="<?php echo esc_attr( $abalturas_footer_nav_link ); ?>"><?php esc_html_e( 'Términos y condiciones', 'abalturas' ); ?></a></li>
					</ul>
				</div>
				</div>

				<div class="abalturas-footer-contact">
					<h3 class="<?php echo esc_attr( $abalturas_footer_col_title ); ?>"><?php echo esc_html__( 'Contacto', 'abalturas' ); ?></h3>
					<ul class="abalturas-footer-contact-list">
						<?php foreach ( $abalturas_contact_channels as $channel ) : ?>
							<li>
								<a
									class="group flex items-start gap-3 rounded-md text-sm font-semibold text-charcoal transition-colors hover:text-safety focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-safety"
									href="<?php echo esc_url( abalturas_get_whatsapp_url( $channel['key'] ) ); ?>"
									target="_blank"
									rel="noopener noreferrer"
								>
									<span class="mt-0.5 inline-flex size-9 shrink-0 items-center justify-center rounded-lg bg-white text-industrial shadow-sm ring-1 ring-slate-200/80 transition group-hover:bg-industrial group-hover:text-white group-hover:ring-industrial/30" aria-hidden="true">
										<svg class="size-[18px]" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.503 5.42A9.957 9.957 0 0 0 12.036 2C6.956 2 2.83 6.146 2.828 11.239c-.001 1.734.449 3.397 1.297 4.892L3 21.95l6.058-1.592a9.86 9.86 0 0 0 4.973 1.343h.005c5.079 0 9.207-4.147 9.209-9.239a9.173 9.173 0 0 0-2.743-6.943ZM12.04 18.93h-.003a8.236 8.236 0 0 1-4.226-1.166l-.303-.18-4.036 1.062 1.078-3.964-.209-.343a8.274 8.274 0 1 1 7.7 5.592Zm4.547-6.226c-.25-.129-1.477-.736-1.706-.822-.229-.086-.396-.129-.563.129-.167.259-.642.821-.786.99-.146.169-.294.188-.546.058-.251-.129-1.062-.394-2.026-1.254-.746-.673-1.254-1.502-1.403-1.757-.146-.259-.017-.394.118-.527.117-.117.259-.294.389-.446.137-.154.174-.267.274-.446.086-.208.049-.379-.026-.527-.069-.169-.564-1.353-.769-1.852-.207-.489-.418-.427-.573-.439l-.49-.013c-.168 0-.442.068-.674.323-.229.259-.881.868-.881 2.122 0 1.257.919 2.474 1.042 2.642.146.259 1.804 2.743 4.379 3.849.612.262 1.091.418 1.465.539.613.206 1.172.173 1.611.098.489-.069 1.477-.613 1.687-1.208.217-.596.217-1.104.157-1.208-.069-.086-.237-.169-.489-.297Z"/></svg>
									</span>
									<span class="pt-0.5 leading-snug">
										<span class="block text-[11px] font-bold uppercase tracking-[0.12em] text-slate-500 group-hover:text-safety/90"><?php echo esc_html( $channel['role'] ); ?></span>
										<span class="mt-0.5 block underline decoration-slate-300 decoration-1 underline-offset-4 group-hover:decoration-safety/60"><?php echo esc_html( $channel['label'] ); ?></span>
									</span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="abalturas-footer-legal text-center">
		<div class="abalturas-site-inner mx-auto w-full">
			<p class="text-sm font-medium text-slate-600">
				&copy; <?php echo esc_html( current_time( 'Y' ) ); ?>
				<?php echo esc_html( get_bloginfo( 'name' ) ); ?>.
				<?php echo esc_html__( 'Todos los derechos reservados.', 'abalturas' ); ?>
			</p>
			<p class="mt-2 text-sm text-slate-500">
				<?php echo esc_html__( 'Colombia · Protección contra caídas', 'abalturas' ); ?>
			</p>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
