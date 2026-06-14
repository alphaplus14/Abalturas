<?php
/**
 * Página Sobre nosotros — misión, visión y propuesta de valor (contenido desde assets/Misión.pdf).
 *
 * @package Abalturas
 */

defined( 'ABSPATH' ) || exit;

$shop_url       = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/tienda/' );
$normativa_url  = function_exists( 'abalturas_get_normativa_res4272_page_url' ) ? abalturas_get_normativa_res4272_page_url() : home_url( '/normatividad-trabajo-alturas/' );
$assets_url     = trailingslashit( get_stylesheet_directory_uri() ) . 'assets/';
$assets_dir     = trailingslashit( get_stylesheet_directory() ) . 'assets/';

$hero_img = $assets_url . 'sobrenosotros.png';
if ( ! file_exists( $assets_dir . 'sobrenosotros.png' ) ) {
	$hero_img = $assets_url . 'heroSoporte.png';
	if ( ! file_exists( $assets_dir . 'heroSoporte.png' ) ) {
		$hero_img = 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=1200&q=80';
	}
}

$mission_img = $assets_url . 'Mision.png';
if ( ! file_exists( $assets_dir . 'Mision.png' ) ) {
	$mission_img = $assets_url . 'ingenieria.png';
	if ( ! file_exists( $assets_dir . 'ingenieria.png' ) ) {
		$mission_img = 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=900&q=80';
	}
}

$servicios = array(
	array(
		'icon'  => 'shield',
		'title' => __( 'Ingeniería y asesoría', 'abalturas' ),
		'text'  => __( 'Soluciones de ingeniería confiables para prevenir y proteger contra caídas en altura, con acompañamiento técnico en cada proyecto.', 'abalturas' ),
		'img'   => file_exists( $assets_dir . 'ingenieria.jpg' ) ? $assets_url . 'ingenieria.jpg' : ( file_exists( $assets_dir . 'ingenieria.png' ) ? $assets_url . 'ingenieria.png' : 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=600&q=80' ),
	),
	array(
		'icon'  => 'grid',
		'title' => __( 'Protección colectiva e individual', 'abalturas' ),
		'text'  => __( 'Venta e instalación de sistemas certificados — barandas, redes, líneas de vida, arneses y anclajes — alineados a normativas globales.', 'abalturas' ),
		'img'   => file_exists( $assets_dir . 'proteccion.png' ) ? $assets_url . 'proteccion.png' : ( file_exists( $assets_dir . 'proteccionColectiva.png' ) ? $assets_url . 'proteccionColectiva.png' : 'https://images.unsplash.com/photo-1541883234164-0f00f7e8f8d6?auto=format&fit=crop&w=600&q=80' ),
	),
	array(
		'icon'  => 'epp',
		'title' => __( 'Elementos de protección personal', 'abalturas' ),
		'text'  => __( 'Distribución de EPP especializado para trabajos en altura, con trazabilidad y orientación para elegir el equipo adecuado.', 'abalturas' ),
		'img'   => file_exists( $assets_dir . 'elementos.jpg' ) ? $assets_url . 'elementos.jpg' : ( file_exists( $assets_dir . 'proteccionIndividual.jpg' ) ? $assets_url . 'proteccionIndividual.jpg' : 'https://images.unsplash.com/photo-1581092160562-40aa08c7880a?auto=format&fit=crop&w=600&q=80' ),
	),
	array(
		'icon'  => 'cap',
		'title' => __( 'Capacitación y cultura de prevención', 'abalturas' ),
		'text'  => __( 'Formación en tareas de alto riesgo y manejo de emergencias, con enfoque lúdico y recreativo para que la seguridad se viva de forma cercana.', 'abalturas' ),
		'img'   => file_exists( $assets_dir . 'capacitacion.png' ) ? $assets_url . 'capacitacion.png' : ( file_exists( $assets_dir . 'heroSoporte.png' ) ? $assets_url . 'heroSoporte.png' : 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=600&q=80' ),
	),
);

$valores = array(
	array(
		'label' => __( 'Responsabilidad', 'abalturas' ),
		'desc'  => __( 'Compromiso total con la vida y el cumplimiento en cada intervención.', 'abalturas' ),
	),
	array(
		'label' => __( 'Respeto', 'abalturas' ),
		'desc'  => __( 'Trato humano hacia trabajadores, clientes y equipos en obra.', 'abalturas' ),
	),
	array(
		'label' => __( 'Autocuidado', 'abalturas' ),
		'desc'  => __( 'Promovemos hábitos que previenen accidentes antes de que ocurran.', 'abalturas' ),
	),
	array(
		'label' => __( 'Protección', 'abalturas' ),
		'desc'  => __( 'Sistemas y procesos diseñados para reducir el riesgo de caída.', 'abalturas' ),
	),
	array(
		'label' => __( 'Confianza', 'abalturas' ),
		'desc'  => __( 'Relaciones duraderas basadas en resultados técnicos verificables.', 'abalturas' ),
	),
	array(
		'label' => __( 'Eficacia', 'abalturas' ),
		'desc'  => __( 'Soluciones que funcionan en campo, no solo en papel.', 'abalturas' ),
	),
);

$pilares = array(
	array(
		'step'   => '01',
		'label'  => __( 'Propósito', 'abalturas' ),
		'text'   => __( 'Proteger la vida en sectores con riesgo de caída en alturas.', 'abalturas' ),
		'accent' => 'safety',
		'icon'   => 'shield',
	),
	array(
		'step'   => '02',
		'label'  => __( 'Cómo lo hacemos', 'abalturas' ),
		'text'   => __( 'Ingeniería, instalación, EPP y capacitación con enfoque humano.', 'abalturas' ),
		'accent' => 'industrial',
		'icon'   => 'layers',
	),
	array(
		'step'   => '03',
		'label'  => __( 'Meta 2030', 'abalturas' ),
		'text'   => __( 'Ser referente líder en seguridad en alturas en Colombia y la región.', 'abalturas' ),
		'accent' => 'horizon',
		'icon'   => 'target',
	),
);
?>
<style id="abalturas-about-hero">
	.abalturas-about-hero__figure {
		aspect-ratio: 16 / 10;
		min-height: 13rem;
	}
	@media (min-width: 640px) {
		.abalturas-about-hero__figure {
			aspect-ratio: 16 / 9;
			min-height: 15rem;
		}
	}
	@media (min-width: 1024px) {
		.abalturas-about-hero__figure {
			aspect-ratio: auto;
			min-height: 17.5rem;
			max-height: 22rem;
		}
	}
	.abalturas-about-hero__figure img {
		display: block;
		width: 100%;
		height: 100%;
		min-height: 100%;
		object-fit: cover;
		object-position: center 22%;
	}
	.abalturas-about-mision__figure {
		aspect-ratio: 4 / 3;
		overflow: hidden;
		border-radius: 1rem;
	}
	.abalturas-about-mision__figure img {
		display: block;
		width: 100%;
		height: 100%;
		object-fit: cover;
		object-position: center center;
	}
	.abalturas-about-mision__grid {
		align-items: start;
	}
	@media (min-width: 1024px) {
		.abalturas-about-mision__grid {
			align-items: center;
		}
	}
	.abalturas-about-mision__body p {
		text-align: justify;
		text-justify: inter-word;
		hyphens: auto;
	}
	.abalturas-about-mision__quote {
		margin-top: 2.5rem;
		border-radius: 0.75rem;
		border: 1px solid rgb(226 232 240 / 0.95);
		border-left: 4px solid #f56523;
		background: linear-gradient(135deg, rgb(26 54 93 / 0.04) 0%, rgb(247 250 252 / 0.95) 100%);
		padding: 1.25rem 1.25rem 1.25rem 1.125rem;
		box-shadow: 0 1px 2px rgb(15 23 42 / 0.04);
	}
	.abalturas-about-mision__quote-inner > p + p {
		margin-top: 0.5rem;
	}
	@media (min-width: 1024px) {
		.abalturas-about-mision__quote {
			margin-top: 3.5rem;
			padding: 1.75rem 2.25rem;
		}
		.abalturas-about-mision__quote-inner {
			display: grid;
			grid-template-columns: minmax(12rem, 15rem) 1fr;
			gap: 1.25rem 2.5rem;
			align-items: center;
		}
		.abalturas-about-mision__quote-inner > p + p {
			margin-top: 0;
			font-size: 1.0625rem;
			line-height: 1.65;
		}
	}
	.abalturas-about-servicios {
		border-top: 1px solid rgb(241 245 249);
		padding-top: 4rem;
	}
	@media (min-width: 1024px) {
		.abalturas-about-servicios {
			padding-top: 5rem;
		}
	}
	.abalturas-about-servicios__intro {
		max-width: 48rem;
		margin-left: auto;
		margin-right: auto;
		text-align: center;
	}
	.abalturas-about-servicios__grid {
		margin-top: 2.25rem;
		gap: 1.5rem;
	}
	@media (min-width: 640px) {
		.abalturas-about-servicios__grid {
			margin-top: 2.75rem;
			gap: 1.75rem;
		}
	}
	@media (min-width: 1024px) {
		.abalturas-about-servicios__grid {
			margin-top: 3rem;
			gap: 2rem;
		}
	}
	.abalturas-about-servicios__card-media {
		height: 11rem;
	}
	@media (min-width: 640px) {
		.abalturas-about-servicios__card-media {
			height: 12.5rem;
		}
	}
	@media (min-width: 1024px) {
		.abalturas-about-servicios__card-media {
			height: 13.5rem;
		}
	}
	.abalturas-about-pilares {
		background: linear-gradient(180deg, #fff 0%, rgb(247 250 252 / 0.85) 100%);
		border-bottom: 1px solid rgb(226 232 240 / 0.8);
		padding: 2.75rem 0 3rem;
	}
	@media (min-width: 640px) {
		.abalturas-about-pilares {
			padding: 3rem 0 3.25rem;
		}
	}
	.abalturas-about-pilares__inner {
		max-width: 72rem;
		margin: 0 auto;
		padding: 0 1rem;
	}
	@media (min-width: 640px) {
		.abalturas-about-pilares__inner {
			padding: 0 1.5rem;
		}
	}
	@media (min-width: 1024px) {
		.abalturas-about-pilares__inner {
			padding: 0 2rem;
		}
	}
	.abalturas-about-pilares__header {
		max-width: 36rem;
		margin: 0 auto 2rem;
		text-align: center;
	}
	@media (min-width: 640px) {
		.abalturas-about-pilares__header {
			margin-bottom: 2.25rem;
		}
	}
	.abalturas-about-pilares__grid {
		display: grid;
		gap: 1rem;
	}
	@media (min-width: 640px) {
		.abalturas-about-pilares__grid {
			grid-template-columns: repeat(3, minmax(0, 1fr));
			gap: 1.25rem;
		}
	}
	@media (min-width: 1024px) {
		.abalturas-about-pilares__grid {
			gap: 1.5rem;
		}
	}
	.abalturas-about-pilares__card {
		position: relative;
		display: flex;
		flex-direction: column;
		min-height: 100%;
		overflow: hidden;
		border-radius: 1rem;
		border: 1px solid rgb(226 232 240 / 0.95);
		background: #fff;
		padding: 1.35rem 1.35rem 1.5rem;
		box-shadow: 0 1px 2px rgb(15 23 42 / 0.04), 0 8px 24px rgb(15 23 42 / 0.04);
		transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
	}
	@media (min-width: 640px) {
		.abalturas-about-pilares__card {
			padding: 1.5rem 1.35rem 1.65rem;
		}
	}
	.abalturas-about-pilares__card:hover {
		transform: translateY(-3px);
		border-color: rgb(203 213 225 / 0.95);
		box-shadow: 0 4px 6px rgb(15 23 42 / 0.05), 0 16px 32px rgb(15 23 42 / 0.08);
	}
	.abalturas-about-pilares__card::before {
		content: "";
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		height: 3px;
		background: var(--abalturas-pilar-accent, #f56523);
	}
	.abalturas-about-pilares__card--industrial {
		--abalturas-pilar-accent: #1a365d;
	}
	.abalturas-about-pilares__card--horizon {
		--abalturas-pilar-accent: linear-gradient(90deg, #1a365d 0%, #f56523 100%);
	}
	.abalturas-about-pilares__card--horizon::before {
		background: linear-gradient(90deg, #1a365d 0%, #f56523 100%);
	}
	.abalturas-about-pilares__card-top {
		display: flex;
		align-items: flex-start;
		justify-content: space-between;
		gap: 0.75rem;
		margin-bottom: 1rem;
	}
	.abalturas-about-pilares__icon {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 2.75rem;
		height: 2.75rem;
		flex-shrink: 0;
		border-radius: 0.75rem;
		background: rgb(245 101 35 / 0.1);
		color: #f56523;
	}
	.abalturas-about-pilares__card--industrial .abalturas-about-pilares__icon {
		background: rgb(26 54 93 / 0.08);
		color: #1a365d;
	}
	.abalturas-about-pilares__card--horizon .abalturas-about-pilares__icon {
		background: linear-gradient(135deg, rgb(26 54 93 / 0.1) 0%, rgb(245 101 35 / 0.12) 100%);
		color: #1a365d;
	}
	.abalturas-about-pilares__icon svg {
		width: 1.35rem;
		height: 1.35rem;
	}
	.abalturas-about-pilares__step {
		font-size: 0.6875rem;
		font-weight: 800;
		letter-spacing: 0.14em;
		line-height: 1;
		color: rgb(148 163 184 / 0.95);
	}
	.abalturas-about-pilares__label {
		margin: 0;
		font-size: 0.6875rem;
		font-weight: 700;
		letter-spacing: 0.2em;
		text-transform: uppercase;
		color: #1a365d;
	}
	.abalturas-about-pilares__card--safety .abalturas-about-pilares__label {
		color: #f56523;
	}
	.abalturas-about-pilares__text {
		margin: 0.5rem 0 0;
		font-size: 0.9375rem;
		font-weight: 600;
		line-height: 1.55;
		color: #1a202c;
	}
	@media (min-width: 640px) {
		.abalturas-about-pilares__text {
			font-size: 1rem;
		}
	}
	.abalturas-about-pilares__card--horizon .abalturas-about-pilares__badge {
		display: inline-flex;
		margin-top: 0.875rem;
		align-items: center;
		gap: 0.35rem;
		border-radius: 9999px;
		background: rgb(26 54 93 / 0.06);
		padding: 0.25rem 0.65rem;
		font-size: 0.6875rem;
		font-weight: 700;
		letter-spacing: 0.08em;
		color: #1a365d;
	}
	.abalturas-about-pilares__badge strong {
		font-size: 0.8125rem;
		font-weight: 800;
		color: #f56523;
	}
	.abalturas-about-vision__horizon {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		flex-shrink: 0;
		border-radius: 0.75rem;
		border: 1px solid rgb(255 255 255 / 0.15);
		background: rgb(255 255 255 / 0.05);
		padding: 1.75rem 2rem;
		text-align: center;
		backdrop-filter: blur(4px);
	}
	@media (min-width: 1024px) {
		.abalturas-about-vision__horizon {
			min-width: 11rem;
			padding: 2rem 2.25rem;
		}
	}
	.abalturas-about-vision__horizon-compass {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 3rem;
		height: 3rem;
		margin-bottom: 0.75rem;
		border-radius: 9999px;
		background: rgb(245 101 35 / 0.14);
		color: #f56523;
		box-shadow: 0 0 0 1px rgb(245 101 35 / 0.22);
	}
	.abalturas-about-vision__horizon-compass svg {
		width: 1.5rem;
		height: 1.5rem;
	}
	.abalturas-about-vision__horizon-label {
		margin: 0;
		font-size: 0.625rem;
		font-weight: 700;
		letter-spacing: 0.3em;
		text-transform: uppercase;
		color: rgb(255 255 255 / 0.7);
	}
	.abalturas-about-vision__horizon-year {
		margin: 0.5rem 0 0;
		font-size: 3rem;
		font-weight: 800;
		font-variant-numeric: tabular-nums;
		line-height: 1;
		color: #f56523;
	}
	.abalturas-about-vision__horizon-text {
		margin: 0.5rem 0 0;
		max-width: 10rem;
		font-size: 0.75rem;
		line-height: 1.375;
		color: rgb(255 255 255 / 0.75);
	}
	.abalturas-about-vision__horizon-themes {
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 0.65rem;
		margin-top: 1.125rem;
		padding-top: 1rem;
		border-top: 1px solid rgb(255 255 255 / 0.12);
		width: 100%;
		max-width: 11rem;
	}
	.abalturas-about-vision__horizon-theme {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 2.25rem;
		height: 2.25rem;
		border-radius: 0.5rem;
		background: rgb(255 255 255 / 0.08);
		color: rgb(255 255 255 / 0.88);
		box-shadow: 0 0 0 1px rgb(255 255 255 / 0.1);
	}
	.abalturas-about-vision__horizon-theme svg {
		width: 1.125rem;
		height: 1.125rem;
	}
	.abalturas-about-vision__horizon-theme--accent {
		background: rgb(245 101 35 / 0.16);
		color: #f56523;
		box-shadow: 0 0 0 1px rgb(245 101 35 / 0.25);
	}

	/* Visión → CTA: separación fija entre bloque oscuro y tarjeta clara */
	.abalturas-about-vision {
		padding-top: 5rem;
	}

	.abalturas-about-closing-cta {
		margin-top: 45px;
	}

	@media (min-width: 1024px) {
		.abalturas-about-vision {
			padding-top: 6rem;
		}
	}
</style>
<main id="abalturas-main" class="relative bg-gradient-to-b from-mist via-white to-mist/80 text-slate-800" tabindex="-1">

	<!-- Hero — banda editorial clara, altura contenida -->
	<section class="border-b border-slate-200/70 bg-gradient-to-b from-mist via-white to-white pt-8 pb-10 sm:pt-10 sm:pb-12 lg:pt-12 lg:pb-14" aria-labelledby="about-hero-title">
		<div class="w-full">
			<header class="overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-lg ring-1 ring-slate-900/[0.04] lg:grid lg:grid-cols-2 lg:items-stretch">
				<figure class="abalturas-about-hero__figure relative order-1 m-0 overflow-hidden bg-slate-100 lg:order-2">
					<img
						src="<?php echo esc_url( $hero_img ); ?>"
						alt="<?php echo esc_attr__( 'Equipo Abalturas con arneses y equipos de protección en alturas', 'abalturas' ); ?>"
						width="895"
						height="1031"
						decoding="async"
						fetchpriority="high"
					/>
					<div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-industrial/10 via-transparent to-transparent lg:bg-gradient-to-l lg:from-white/20 lg:via-transparent lg:to-transparent" aria-hidden="true"></div>
				</figure>
				<div class="order-2 flex flex-col justify-center border-t border-slate-100 px-6 py-8 sm:px-9 sm:py-10 lg:order-1 lg:border-t-0 lg:border-r lg:border-slate-100 lg:py-12 lg:pl-10 lg:pr-8">
					<span class="mb-5 inline-block h-1 w-12 rounded-full bg-safety" aria-hidden="true"></span>
					<p class="text-[11px] font-bold uppercase tracking-[0.28em] text-industrial"><?php esc_html_e( 'Sobre nosotros', 'abalturas' ); ?></p>
					<h1 id="about-hero-title" class="mt-3 text-2xl font-extrabold leading-tight tracking-tight text-charcoal sm:text-3xl lg:text-[2.125rem]">
						<?php esc_html_e( 'Pasión y compromiso por la seguridad en alturas', 'abalturas' ); ?>
					</h1>
					<p class="mt-5 max-w-xl text-base leading-relaxed text-slate-600 sm:text-[1.0625rem]">
						<?php esc_html_e( 'En Abalturas protegemos la vida de quienes trabajan expuestos al riesgo de caída. Combinamos ingeniería, equipos certificados y formación para que la prevención sea real en cada obra.', 'abalturas' ); ?>
					</p>
				</div>
			</header>
		</div>
	</section>

	<!-- Propósito — pilares estratégicos -->
	<section class="abalturas-about-pilares" aria-label="<?php esc_attr_e( 'Nuestro enfoque', 'abalturas' ); ?>">
		<div class="abalturas-about-pilares__inner">
			<header class="abalturas-about-pilares__header">
				<p class="text-[11px] font-bold uppercase tracking-[0.24em] text-safety"><?php esc_html_e( 'Nuestro enfoque', 'abalturas' ); ?></p>
				<h2 class="mt-2 text-base font-semibold leading-snug text-charcoal sm:text-lg"><?php esc_html_e( 'Tres ideas que orientan cada proyecto y cada capacitación.', 'abalturas' ); ?></h2>
			</header>
			<div class="abalturas-about-pilares__grid">
				<?php foreach ( $pilares as $pilar ) : ?>
				<article class="abalturas-about-pilares__card abalturas-about-pilares__card--<?php echo esc_attr( $pilar['accent'] ); ?>">
					<div class="abalturas-about-pilares__card-top">
						<span class="abalturas-about-pilares__icon" aria-hidden="true">
							<?php if ( 'shield' === $pilar['icon'] ) : ?>
							<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
							<?php elseif ( 'layers' === $pilar['icon'] ) : ?>
							<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0l4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0l-5.571 3-5.571-3"/></svg>
							<?php else : ?>
							<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0l2.77-.693a3 3 0 011.976 0L12 15.75m-6.23-1.443A3 3 0 016 12.75V9.75m6 6v3.75m0-3.75a3 3 0 013 3v2.25M15 12.75a3 3 0 013-3V9.75m-3 3h3.75M3 3h7.5v7.5H3V3zm0 10.5h7.5v7.5H3v-7.5z"/></svg>
							<?php endif; ?>
						</span>
						<span class="abalturas-about-pilares__step"><?php echo esc_html( $pilar['step'] ); ?></span>
					</div>
					<h3 class="abalturas-about-pilares__label"><?php echo esc_html( $pilar['label'] ); ?></h3>
					<p class="abalturas-about-pilares__text"><?php echo esc_html( $pilar['text'] ); ?></p>
					<?php if ( 'horizon' === $pilar['accent'] ) : ?>
					<p class="abalturas-about-pilares__badge"><?php esc_html_e( 'Horizonte', 'abalturas' ); ?> <strong>2030</strong></p>
					<?php endif; ?>
				</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<div class="w-full py-14 sm:py-20">

		<!-- Misión -->
		<section id="mision" class="scroll-mt-28 pb-4 lg:scroll-mt-32 lg:pb-6" aria-labelledby="about-mision-title">
			<div class="abalturas-about-mision__grid grid gap-10 lg:grid-cols-2 lg:gap-14">
				<div>
					<p class="text-[11px] font-bold uppercase tracking-[0.24em] text-safety"><?php esc_html_e( 'Misión', 'abalturas' ); ?></p>
					<h2 id="about-mision-title" class="mt-3 text-2xl font-extrabold text-charcoal sm:text-3xl"><?php esc_html_e( 'Ingeniería que protege, acompañamiento que transforma', 'abalturas' ); ?></h2>
					<div class="abalturas-about-mision__body mt-6 space-y-4 text-base leading-relaxed text-slate-600">
						<p><?php esc_html_e( 'En Abalturas trabajamos con pasión y compromiso para garantizar la seguridad en los sectores económicos donde exista riesgo de caída en alturas. Nuestro propósito es proteger la vida de cada persona que realiza estas labores, ofreciendo soluciones de ingeniería confiables que aseguren la prevención y la protección.', 'abalturas' ); ?></p>
						<p><?php esc_html_e( 'A través de la asesoría especializada, la venta e instalación de sistemas de protección contra caídas colectivos e individuales, y la distribución de elementos de protección personal, acompañamos a nuestros clientes en cada paso hacia un entorno más seguro.', 'abalturas' ); ?></p>
						<p><?php esc_html_e( 'Además, brindamos capacitaciones en tareas de alto riesgo y manejo de emergencias, fomentando la conciencia y la cultura de prevención mediante la lúdica y la recreación, para que la seguridad se viva de manera cercana y significativa.', 'abalturas' ); ?></p>
					</div>
				</div>
				<figure class="abalturas-about-mision__figure relative border border-slate-200/90 shadow-xl ring-1 ring-slate-200/60">
					<img
						src="<?php echo esc_url( $mission_img ); ?>"
						alt="<?php echo esc_attr__( 'Capacitación en seguridad en alturas y normativa de rescate', 'abalturas' ); ?>"
						loading="lazy"
						width="900"
						height="675"
					/>
					<figcaption class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-charcoal/90 via-charcoal/45 to-transparent px-5 py-4 sm:px-6 sm:py-5">
						<p class="text-sm font-semibold text-white"><?php esc_html_e( 'Formación técnica con enfoque humano', 'abalturas' ); ?></p>
					</figcaption>
				</figure>
			</div>
			<blockquote class="abalturas-about-mision__quote not-italic">
				<div class="abalturas-about-mision__quote-inner">
					<p class="text-[11px] font-bold uppercase tracking-[0.18em] text-industrial"><?php esc_html_e( 'Compromiso con la vida', 'abalturas' ); ?></p>
					<p class="text-[0.9375rem] font-medium leading-relaxed text-charcoal sm:text-base">
						<?php esc_html_e( 'Nuestra misión se fundamenta en valores como la responsabilidad y el respeto, promoviendo siempre el autocuidado, la protección y la confianza de quienes depositan en nosotros su seguridad.', 'abalturas' ); ?>
					</p>
				</div>
			</blockquote>
		</section>

		<!-- Qué hacemos -->
		<section id="servicios" class="abalturas-about-servicios scroll-mt-28 lg:scroll-mt-32" aria-labelledby="about-servicios-title">
			<div class="abalturas-about-servicios__intro">
				<p class="text-[11px] font-bold uppercase tracking-[0.24em] text-safety"><?php esc_html_e( 'Qué hacemos', 'abalturas' ); ?></p>
				<h2 id="about-servicios-title" class="mt-3 text-2xl font-extrabold text-charcoal sm:text-3xl"><?php esc_html_e( 'Soluciones integrales para trabajar con confianza', 'abalturas' ); ?></h2>
				<p class="mt-4 text-base leading-relaxed text-slate-600 sm:text-lg"><?php esc_html_e( 'Desde el diseño hasta la formación en campo: un solo aliado para prevenir caídas y cumplir normativa.', 'abalturas' ); ?></p>
			</div>
			<div class="abalturas-about-servicios__grid grid sm:grid-cols-2">
				<?php foreach ( $servicios as $i => $svc ) : ?>
				<article class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-md transition hover:-translate-y-0.5 hover:shadow-lg">
					<div class="abalturas-about-servicios__card-media relative overflow-hidden">
						<img src="<?php echo esc_url( $svc['img'] ); ?>" alt="" class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]" loading="lazy" width="600" height="400"/>
						<span class="absolute bottom-4 left-4 inline-flex size-10 items-center justify-center rounded-lg bg-safety/95 text-xs font-extrabold text-white shadow" aria-hidden="true"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
					</div>
					<div class="flex flex-1 flex-col p-6 sm:p-7">
						<h3 class="text-lg font-bold text-charcoal"><?php echo esc_html( $svc['title'] ); ?></h3>
						<p class="mt-3 flex-1 text-sm leading-relaxed text-slate-600 sm:text-[0.9375rem]"><?php echo esc_html( $svc['text'] ); ?></p>
					</div>
				</article>
				<?php endforeach; ?>
			</div>
		</section>

		<!-- Valores -->
		<section id="valores" class="scroll-mt-28 pt-20 lg:scroll-mt-32" aria-labelledby="about-valores-title">
			<div class="rounded-2xl border border-slate-200/90 bg-gradient-to-br from-white to-mist/80 px-6 py-10 shadow-sm sm:px-10 sm:py-12">
				<div class="max-w-2xl">
					<p class="text-[11px] font-bold uppercase tracking-[0.24em] text-safety"><?php esc_html_e( 'Valores', 'abalturas' ); ?></p>
					<h2 id="about-valores-title" class="mt-3 text-2xl font-extrabold text-charcoal sm:text-3xl"><?php esc_html_e( 'Lo que nos guía cada día', 'abalturas' ); ?></h2>
					<p class="mt-4 text-base leading-relaxed text-slate-600"><?php esc_html_e( 'Principios compartidos por misión y visión: la base de cómo trabajamos con ustedes y con quienes operan en altura.', 'abalturas' ); ?></p>
				</div>
				<ul class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
					<?php foreach ( $valores as $valor ) : ?>
					<li class="rounded-xl border border-slate-100 bg-white px-5 py-5 shadow-sm transition hover:border-industrial/25 hover:shadow-md">
						<h3 class="flex items-center gap-2 text-base font-bold text-industrial">
							<span class="inline-block size-2 shrink-0 rounded-full bg-safety" aria-hidden="true"></span>
							<?php echo esc_html( $valor['label'] ); ?>
						</h3>
						<p class="mt-2 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $valor['desc'] ); ?></p>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</section>

		<!-- Visión 2030 -->
		<section id="vision" class="abalturas-about-vision scroll-mt-28 lg:scroll-mt-32" aria-labelledby="about-vision-title">
			<div class="relative overflow-hidden rounded-2xl bg-charcoal px-6 py-12 text-white shadow-xl sm:px-10 sm:py-14">
				<div class="pointer-events-none absolute -right-16 -top-20 h-64 w-64 rounded-full bg-safety/20 blur-3xl" aria-hidden="true"></div>
				<div class="pointer-events-none absolute -bottom-24 -left-12 h-56 w-56 rounded-full bg-industrial/40 blur-3xl" aria-hidden="true"></div>
				<div class="relative grid gap-10 lg:grid-cols-[1fr,auto] lg:items-start lg:gap-14">
					<div>
						<p class="text-[11px] font-bold uppercase tracking-[0.28em] text-safety"><?php esc_html_e( 'Visión', 'abalturas' ); ?></p>
						<h2 id="about-vision-title" class="mt-3 text-2xl font-extrabold sm:text-3xl"><?php esc_html_e( 'Hacia el 2030: liderazgo regional en seguridad en alturas', 'abalturas' ); ?></h2>
						<div class="mt-6 space-y-4 text-base leading-relaxed text-slate-200/95">
							<p><?php esc_html_e( 'En el año 2030, Abalturas será reconocida como la empresa líder en seguridad en alturas en Colombia y referente en la región, destacándose por su innovación en soluciones de ingeniería, asesoría especializada y capacitación integral.', 'abalturas' ); ?></p>
							<p><?php esc_html_e( 'Consolidaremos nuestra presencia como aliados estratégicos de las organizaciones, impulsando la cultura de prevención, protección y autocuidado mediante programas de formación, acompañamiento técnico y experiencias educativas que transformen la manera de vivir la seguridad laboral.', 'abalturas' ); ?></p>
							<p><?php esc_html_e( 'Nuestra visión se fundamenta en la responsabilidad, el respeto y la eficacia, valores que nos permitirán seguir creciendo con confianza, aportando al bienestar de los trabajadores y al desarrollo sostenible de los sectores económicos donde exista riesgo de caída en alturas.', 'abalturas' ); ?></p>
						</div>
					</div>
					<div class="abalturas-about-vision__horizon">
						<span class="abalturas-about-vision__horizon-compass" aria-hidden="true">
							<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="m14.5 9.5-5 2 2 5 5-2-2-5z"/><circle cx="12" cy="12" r="1.25" fill="currentColor" stroke="none"/></svg>
						</span>
						<p class="abalturas-about-vision__horizon-label"><?php esc_html_e( 'Horizonte', 'abalturas' ); ?></p>
						<p class="abalturas-about-vision__horizon-year" aria-label="<?php esc_attr_e( 'Año 2030', 'abalturas' ); ?>">2030</p>
						<p class="abalturas-about-vision__horizon-text"><?php esc_html_e( 'Liderazgo e innovación en seguridad en alturas', 'abalturas' ); ?></p>
						<div class="abalturas-about-vision__horizon-themes" aria-label="<?php esc_attr_e( 'Protección, ingeniería y capacitación en alturas', 'abalturas' ); ?>">
							<span class="abalturas-about-vision__horizon-theme abalturas-about-vision__horizon-theme--accent" title="<?php esc_attr_e( 'Protección contra caídas', 'abalturas' ); ?>">
								<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
							</span>
							<span class="abalturas-about-vision__horizon-theme" title="<?php esc_attr_e( 'Sistemas de protección en alturas', 'abalturas' ); ?>">
								<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 1 1.242 7.244"/></svg>
							</span>
							<span class="abalturas-about-vision__horizon-theme" title="<?php esc_attr_e( 'Capacitación y cultura de prevención', 'abalturas' ); ?>">
								<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342"/></svg>
							</span>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- CTA final -->
		<section class="abalturas-about-closing-cta rounded-2xl border border-slate-200 bg-white px-6 py-10 text-center shadow-md sm:px-10 sm:py-12" aria-labelledby="about-cta-title">
			<h2 id="about-cta-title" class="text-xl font-extrabold text-charcoal sm:text-2xl"><?php esc_html_e( '¿Listo para elevar la seguridad de su operación?', 'abalturas' ); ?></h2>
			<p class="mx-auto mt-3 max-w-xl text-base leading-relaxed text-slate-600"><?php esc_html_e( 'Conversemos sobre ingeniería, equipos o capacitación. También puede explorar normatividad y catálogo certificado.', 'abalturas' ); ?></p>
			<div class="mt-8 flex flex-wrap items-center justify-center gap-3">
				<a href="<?php echo esc_url( $shop_url ); ?>" class="inline-flex min-h-[2.875rem] items-center justify-center rounded-lg bg-industrial px-6 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-industrial/92 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-industrial">
					<?php esc_html_e( 'Ir a la tienda', 'abalturas' ); ?>
				</a>
				<a href="<?php echo esc_url( $normativa_url ); ?>" class="inline-flex min-h-[2.875rem] items-center justify-center rounded-lg border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-charcoal transition hover:border-industrial/30 hover:text-industrial focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-industrial">
					<?php esc_html_e( 'Normatividad', 'abalturas' ); ?>
				</a>
			</div>
		</section>

	</div>
</main>
