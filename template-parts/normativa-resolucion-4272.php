<?php
/**
 * Contenido ficha UX: Resolución 4272/2021 (trabajo en alturas) y Resolución 0491/2020 (espacios confinados).
 *
 * Información sintetizada desde el texto oficial; no sustituye asesoría legal ni el PDF del Diario Oficial.
 *
 * @package Abalturas
 */

defined( 'ABSPATH' ) || exit;

$shop_url          = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/tienda/' );
$mnt_url           = 'https://www.mintrabajo.gov.co/';
$apc_pdf_url       = 'https://www.apccolombia.gov.co/normativa/resolucion-4272-del-27-de-diciembre-de-2021';
$sisjur_url        = 'https://www.alcaldiabogota.gov.co/sisjur/normas/Norma1.jsp?dt=S&i=120880';
$decr_1072_url     = 'https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?n=75901';
$res491_ref_url    = 'https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=115432';
?>
<style id="abalturas-normativa-anchor-offset">
	html {
		scroll-behavior: smooth;
		scroll-padding-top: calc(11.5rem + env(safe-area-inset-top, 0px));
	}
	html.admin-bar {
		scroll-padding-top: calc(11.5rem + var(--wp-admin--admin-bar--height, 32px) + env(safe-area-inset-top, 0px));
	}
	@media (min-width: 1024px) {
		html {
			scroll-padding-top: calc(13.75rem + env(safe-area-inset-top, 0px));
		}
		html.admin-bar {
			scroll-padding-top: calc(13.75rem + var(--wp-admin--admin-bar--height, 32px) + env(safe-area-inset-top, 0px));
		}
	}
	.abalturas-normativa-hub__cards {
		display: grid;
		gap: 1rem;
		margin-top: 2rem;
	}
	@media (min-width: 640px) {
		.abalturas-normativa-hub__cards {
			grid-template-columns: repeat(2, minmax(0, 1fr));
			gap: 1.25rem;
		}
	}
	.abalturas-normativa-hub__card {
		display: flex;
		flex-direction: column;
		border-radius: 1rem;
		border: 1px solid rgb(226 232 240 / 0.95);
		background: #fff;
		padding: 1.25rem 1.35rem;
		box-shadow: 0 1px 2px rgb(15 23 42 / 0.04), 0 8px 24px rgb(15 23 42 / 0.04);
		transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
	}
	.abalturas-normativa-hub__card:hover {
		transform: translateY(-2px);
		border-color: rgb(203 213 225 / 0.95);
		box-shadow: 0 4px 6px rgb(15 23 42 / 0.05), 0 16px 32px rgb(15 23 42 / 0.07);
	}
	.abalturas-normativa-hub__card-label {
		font-size: 0.6875rem;
		font-weight: 700;
		letter-spacing: 0.18em;
		text-transform: uppercase;
		color: #f56523;
	}
	.abalturas-normativa-hub__card-title {
		margin: 0.35rem 0 0;
		font-size: 1.0625rem;
		font-weight: 700;
		line-height: 1.35;
		color: #1a202c;
	}
	.abalturas-normativa-hub__card-text {
		margin: 0.5rem 0 0;
		flex: 1;
		font-size: 0.875rem;
		line-height: 1.6;
		color: rgb(71 85 105);
	}
	.abalturas-normativa-hub__card-link {
		margin-top: 1rem;
		font-size: 0.8125rem;
		font-weight: 700;
		color: #1a365d;
	}
	.abalturas-normativa-res__header {
		margin-top: 2.5rem;
	}
	.abalturas-normativa-toc {
		overflow: hidden;
		border-radius: 1rem;
		border: 1px solid rgb(226 232 240);
		background: #fff;
		box-shadow: 0 1px 2px rgb(15 23 42 / 0.04), 0 4px 16px rgb(15 23 42 / 0.05);
	}
	.abalturas-normativa-toc__head {
		padding: 1rem 1.1rem;
		border-bottom: 1px solid rgb(241 245 249);
		background: rgb(248 250 252 / 0.98);
	}
	@media (min-width: 1024px) {
		.abalturas-normativa-toc__head {
			padding: 1.05rem 1.15rem;
		}
	}
	.abalturas-normativa-toc__head-label {
		display: block;
		font-size: 0.6875rem;
		font-weight: 700;
		letter-spacing: 0.2em;
		text-transform: uppercase;
		color: rgb(100 116 139);
	}
	.abalturas-normativa-toc__head-hint {
		display: block;
		margin-top: 0.25rem;
		font-size: 0.75rem;
		font-weight: 500;
		line-height: 1.45;
		color: rgb(100 116 139);
	}
	.abalturas-normativa-toc__body {
		padding: 0.65rem;
	}
	@media (min-width: 1024px) {
		.abalturas-normativa-toc__body {
			padding: 0.75rem;
		}
	}
	.abalturas-normativa-toc__norm {
		border-radius: 0.75rem;
		border: 1px solid rgb(241 245 249);
		background: #fff;
		overflow: hidden;
	}
	.abalturas-normativa-toc__norm + .abalturas-normativa-toc__norm {
		margin-top: 0.5rem;
	}
	.abalturas-normativa-toc__norm > summary {
		display: flex;
		cursor: pointer;
		list-style: none;
		align-items: center;
		gap: 0.75rem;
		padding: 0.75rem 0.85rem;
		outline: none;
		transition: background-color 0.15s ease;
	}
	.abalturas-normativa-toc__norm > summary::-webkit-details-marker {
		display: none;
	}
	.abalturas-normativa-toc__norm > summary:hover {
		background: rgb(248 250 252);
	}
	.abalturas-normativa-toc__norm > summary:focus-visible {
		box-shadow: inset 0 0 0 2px rgb(26 54 93 / 0.35);
	}
	.abalturas-normativa-toc__norm[open] > summary {
		border-bottom: 1px solid rgb(241 245 249);
		background: rgb(248 250 252 / 0.7);
	}
	.abalturas-normativa-toc__norm-badge {
		flex-shrink: 0;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-width: 2.5rem;
		height: 2.5rem;
		border-radius: 0.625rem;
		font-size: 0.6875rem;
		font-weight: 800;
		letter-spacing: 0.02em;
	}
	.abalturas-normativa-toc__norm--4272 .abalturas-normativa-toc__norm-badge {
		background: rgb(245 101 35 / 0.12);
		color: #c05621;
	}
	.abalturas-normativa-toc__norm--0491 .abalturas-normativa-toc__norm-badge {
		background: rgb(26 54 93 / 0.1);
		color: #1a365d;
	}
	.abalturas-normativa-toc__norm-text {
		min-width: 0;
		flex: 1;
		text-align: left;
	}
	.abalturas-normativa-toc__norm-title {
		display: block;
		font-size: 0.875rem;
		font-weight: 700;
		line-height: 1.35;
		color: #1a202c;
	}
	.abalturas-normativa-toc__norm-meta {
		display: block;
		margin-top: 0.15rem;
		font-size: 0.6875rem;
		font-weight: 500;
		color: rgb(100 116 139);
	}
	.abalturas-normativa-toc__norm-chevron {
		flex-shrink: 0;
		width: 1.15rem;
		height: 1.15rem;
		color: rgb(100 116 139);
		transition: transform 0.2s ease;
	}
	.abalturas-normativa-toc__norm[open] .abalturas-normativa-toc__norm-chevron {
		transform: rotate(180deg);
	}
	.abalturas-normativa-toc__norm-panel {
		padding: 0.35rem 0.5rem 0.55rem;
	}
	.abalturas-normativa-toc__norm-intro {
		display: block;
		margin: 0.15rem 0.35rem 0.45rem;
		padding: 0.45rem 0.55rem;
		border-radius: 0.5rem;
		font-size: 0.75rem;
		font-weight: 600;
		color: #1a365d;
		background: rgb(26 54 93 / 0.05);
		transition: background-color 0.15s ease;
	}
	.abalturas-normativa-toc__norm-intro:hover {
		background: rgb(26 54 93 / 0.09);
	}
	.abalturas-normativa-toc__links {
		margin: 0;
		padding: 0;
		list-style: none;
	}
	.abalturas-normativa-toc__links li + li {
		margin-top: 0.125rem;
	}
	.abalturas-normativa-toc__link {
		display: block;
		border-radius: 0.5rem;
		padding: 0.45rem 0.55rem;
		font-size: 0.8125rem;
		line-height: 1.45;
		color: rgb(51 65 85);
		transition: background-color 0.15s ease, color 0.15s ease;
	}
	.abalturas-normativa-toc__link:hover {
		background: rgb(26 54 93 / 0.07);
		color: #1a365d;
	}
	.abalturas-normativa-toc__link:focus-visible {
		outline: 2px solid rgb(26 54 93 / 0.45);
		outline-offset: 1px;
	}
	.abalturas-normativa-toc__link.is-active,
	.abalturas-normativa-toc__norm-intro.is-active {
		background: rgb(245 101 35 / 0.1);
		color: #9c4221;
		font-weight: 600;
	}
	/* Móvil: colapsar todo el índice para ahorrar espacio */
	.abalturas-normativa-toc--mobile {
		overflow: hidden;
		border-radius: 1rem;
		border: 1px solid rgb(226 232 240);
		background: #fff;
		box-shadow: 0 1px 2px rgb(15 23 42 / 0.04), 0 4px 16px rgb(15 23 42 / 0.05);
	}
	.abalturas-normativa-toc--mobile > summary {
		display: flex;
		cursor: pointer;
		list-style: none;
		align-items: center;
		justify-content: space-between;
		gap: 0.75rem;
		padding: 0.9rem 1rem;
		background: rgb(248 250 252 / 0.98);
	}
	.abalturas-normativa-toc--mobile > summary::-webkit-details-marker {
		display: none;
	}
	.abalturas-normativa-toc--mobile[open] > summary {
		border-bottom: 1px solid rgb(241 245 249);
	}
	.abalturas-normativa-toc--mobile .abalturas-normativa-toc__mobile-chevron {
		flex-shrink: 0;
		width: 1.25rem;
		height: 1.25rem;
		color: rgb(100 116 139);
		transition: transform 0.2s ease;
	}
	.abalturas-normativa-toc--mobile[open] .abalturas-normativa-toc__mobile-chevron {
		transform: rotate(180deg);
	}
	@media (min-width: 1024px) {
		.abalturas-normativa-toc--mobile {
			display: block;
			border: 0;
			box-shadow: none;
			background: transparent;
		}
		.abalturas-normativa-toc--mobile > summary {
			display: none;
		}
		.abalturas-normativa-toc--mobile .abalturas-normativa-toc__mobile-panel {
			display: block !important;
		}
	}
	@media (max-width: 1023px) {
		.abalturas-normativa-toc--mobile .abalturas-normativa-toc {
			border: 0;
			box-shadow: none;
			border-radius: 0;
		}
		.abalturas-normativa-toc--mobile .abalturas-normativa-toc__head {
			display: none;
		}
	}
	/* Desktop: columna índice + CTA alineados por borde inferior (sin duplicar HTML) */
	@media (min-width: 1024px) {
		.abalturas-normativa-layout {
			align-items: stretch;
		}
		.abalturas-normativa-nav {
			position: static;
			align-self: stretch;
			display: flex;
			flex-direction: column;
			min-height: 100%;
			margin-bottom: 0;
		}
		.abalturas-normativa-nav .abalturas-normativa-toc--mobile {
			position: sticky;
			top: 5.75rem;
			bottom: 0;
			align-self: flex-start;
			width: 100%;
		}
	}
	@media (min-width: 1280px) {
		.abalturas-normativa-nav .abalturas-normativa-toc--mobile {
			top: 7rem;
		}
	}
</style>
<main id="abalturas-main" class="relative bg-gradient-to-b from-mist via-white to-mist/80 pb-20 pt-10 text-slate-800 md:pb-28 md:pt-14" tabindex="-1">
	<div class="w-full">

		<header class="relative overflow-hidden rounded-2xl border border-slate-200/90 bg-charcoal px-6 py-10 text-white shadow-xl sm:px-10 sm:py-14">
			<div class="pointer-events-none absolute -right-20 -top-24 h-[22rem] w-[22rem] rounded-full bg-safety/25 blur-3xl" aria-hidden="true"></div>
			<div class="pointer-events-none absolute -bottom-32 -left-16 h-[18rem] w-[18rem] rounded-full bg-industrial/35 blur-3xl" aria-hidden="true"></div>
			<div class="relative max-w-3xl space-y-4">
				<p class="text-[11px] font-bold uppercase tracking-[0.28em] text-safety"><?php esc_html_e( 'Normatividad', 'abalturas' ); ?></p>
				<h1 class="text-3xl font-extrabold leading-tight tracking-tight md:text-[2.125rem]">
					<?php esc_html_e( 'Guías prácticas en seguridad industrial', 'abalturas' ); ?>
				</h1>
				<p class="text-base leading-relaxed text-slate-200/95 md:text-lg">
					<?php esc_html_e( 'Resúmenes orientativos sobre trabajo en alturas (Res. 4272/2021) y espacios confinados (Res. 0491/2020) en Colombia — para empleadores, contratistas y trabajadores.', 'abalturas' ); ?>
				</p>
				<div class="mt-8 flex flex-wrap gap-3">
					<a href="<?php echo esc_url( $shop_url ); ?>" class="inline-flex items-center rounded-lg bg-safety px-5 py-2.5 text-sm font-semibold text-white shadow-md outline-none ring-offset-charcoal transition hover:bg-safety/92 focus-visible:ring-2 focus-visible:ring-safety focus-visible:ring-offset-2">
						<?php esc_html_e( 'Equipos para cumplimiento', 'abalturas' ); ?>
					</a>
					<a href="<?php echo esc_url( $mnt_url ); ?>" class="inline-flex items-center rounded-lg border border-white/35 bg-white/10 px-5 py-2.5 text-sm font-semibold backdrop-blur-sm hover:bg-white/15" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Ministerio del Trabajo', 'abalturas' ); ?> <span class="sr-only"><?php esc_html_e( '(se abre en nueva pestaña)', 'abalturas' ); ?></span>
					</a>
				</div>
			</div>
		</header>

		<div class="abalturas-normativa-hub__cards not-prose" aria-label="<?php esc_attr_e( 'Seleccionar norma', 'abalturas' ); ?>">
			<a href="#res-4272" class="abalturas-normativa-hub__card group">
				<p class="abalturas-normativa-hub__card-label"><?php esc_html_e( 'Trabajo en alturas', 'abalturas' ); ?></p>
				<p class="abalturas-normativa-hub__card-title"><?php esc_html_e( 'Resolución 4272 de 2021', 'abalturas' ); ?></p>
				<p class="abalturas-normativa-hub__card-text"><?php esc_html_e( 'Prevención y protección contra caídas, programas CPP, permisos, capacitación y EPP.', 'abalturas' ); ?></p>
				<span class="abalturas-normativa-hub__card-link group-hover:text-safety"><?php esc_html_e( 'Ver guía →', 'abalturas' ); ?></span>
			</a>
			<a href="#res-0491" class="abalturas-normativa-hub__card group">
				<p class="abalturas-normativa-hub__card-label"><?php esc_html_e( 'Espacios confinados', 'abalturas' ); ?></p>
				<p class="abalturas-normativa-hub__card-title"><?php esc_html_e( 'Resolución 0491 de 2020', 'abalturas' ); ?></p>
				<p class="abalturas-normativa-hub__card-text"><?php esc_html_e( 'Programa de gestión, permisos de entrada, atmósferas, roles, formación y emergencias.', 'abalturas' ); ?></p>
				<span class="abalturas-normativa-hub__card-link group-hover:text-safety"><?php esc_html_e( 'Ver guía →', 'abalturas' ); ?></span>
			</a>
		</div>

		<div class="mb-12 mt-8 rounded-xl border border-amber-200/90 bg-amber-50 px-5 py-4 text-sm text-amber-950 shadow-sm md:flex md:items-start md:gap-4">
			<span class="mt-0.5 hidden shrink-0 rounded-md bg-amber-200/70 px-2 py-0.5 text-xs font-bold uppercase tracking-wide md:inline-block" aria-hidden="true"><?php esc_html_e( 'Aviso', 'abalturas' ); ?></span>
			<p class="leading-relaxed">
				<strong><?php esc_html_e( 'Esta página es informativa', 'abalturas' ); ?></strong><?php esc_html_e( ' y sirve como apoyo orientativo sobre la norma. Para interpretación jurídica, diseño específico de programas SG-SST, permisos o inspección, revise el texto oficial vigente con su asesor en SST/abogado. Abalturas ofrece productos relacionados — no constituimos aval legal ni competencia ocupacional ante el Ministerio del Trabajo.', 'abalturas' ); ?>
			</p>
		</div>

		<div class="abalturas-normativa-layout lg:grid lg:grid-cols-12 lg:gap-x-10 lg:items-start xl:gap-x-12">
			<nav aria-label="<?php esc_attr_e( 'En esta página', 'abalturas' ); ?>" class="abalturas-normativa-nav mb-10 min-w-0 lg:col-span-4 lg:sticky lg:top-[5.75rem] lg:self-start xl:top-28">
				<?php
				$toc_groups = array(
					array(
						'id'       => '4272',
						'class'    => 'abalturas-normativa-toc__norm--4272',
						'anchor'   => '#res-4272',
						'badge'    => '4272',
						'title'    => __( 'Trabajo en alturas', 'abalturas' ),
						'subtitle' => __( 'Resolución de 2021', 'abalturas' ),
						'open'     => true,
						'items'    => array(
							'#concepto-trabajo-alturas' => __( 'Qué es “trabajo en alturas”', 'abalturas' ),
							'#ambito-aplicacion'          => __( 'Ámbito y actividades exceptuadas', 'abalturas' ),
							'#programa-cpp'               => __( 'Programa de prevención contra caídas', 'abalturas' ),
							'#roles-capacidad'            => __( 'Roles y formación inicial', 'abalturas' ),
							'#medidas-prevencion'         => __( 'Medidas de prevención', 'abalturas' ),
							'#permiso-chequeo'            => __( 'Permiso de trabajo', 'abalturas' ),
							'#reentrenamiento'            => __( 'Reentrenamientos', 'abalturas' ),
							'#sistemas-epp'               => __( 'Acceso, ingeniería y EPP', 'abalturas' ),
							'#obligaciones'               => __( 'Obligaciones empleador/trabajador', 'abalturas' ),
							'#vigencia-deroga'            => __( 'Vigencia y derogatorias', 'abalturas' ),
							'#fuentes'                    => __( 'Fuentes oficiales', 'abalturas' ),
						),
					),
					array(
						'id'       => '0491',
						'class'    => 'abalturas-normativa-toc__norm--0491',
						'anchor'   => '#res-0491',
						'badge'    => '0491',
						'title'    => __( 'Espacios confinados', 'abalturas' ),
						'subtitle' => __( 'Resolución de 2020', 'abalturas' ),
						'open'     => false,
						'items'    => array(
							'#ec-concepto'       => __( 'Qué es un espacio confinado', 'abalturas' ),
							'#ec-programa'       => __( 'Programa de gestión', 'abalturas' ),
							'#ec-identificacion' => __( 'Identificación y clasificación', 'abalturas' ),
							'#ec-roles'          => __( 'Roles y formación', 'abalturas' ),
							'#ec-permiso'        => __( 'Permiso de entrada', 'abalturas' ),
							'#ec-controles'      => __( 'Controles y atmósferas', 'abalturas' ),
							'#ec-emergencias'    => __( 'Emergencias y rescate', 'abalturas' ),
							'#ec-obligaciones'   => __( 'Obligaciones y ARL', 'abalturas' ),
							'#ec-fuentes'        => __( 'Fuentes oficiales', 'abalturas' ),
						),
					),
				);
				?>
				<details class="abalturas-normativa-toc--mobile group" open>
					<summary aria-controls="toc-normativa-panel">
						<span class="min-w-0 text-left">
							<span id="toc-normativa-label" class="abalturas-normativa-toc__head-label"><?php esc_html_e( 'Índice de contenidos', 'abalturas' ); ?></span>
							<span class="abalturas-normativa-toc__head-hint"><?php esc_html_e( 'Despliegue cada norma y elija la sección.', 'abalturas' ); ?></span>
						</span>
						<svg class="abalturas-normativa-toc__mobile-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
					</summary>
					<div id="toc-normativa-panel" class="abalturas-normativa-toc__mobile-panel">
						<div class="abalturas-normativa-toc lg:shadow-md lg:ring-1 lg:ring-slate-900/[0.04]">
							<div class="abalturas-normativa-toc__head hidden lg:block">
								<span class="abalturas-normativa-toc__head-label"><?php esc_html_e( 'Índice de contenidos', 'abalturas' ); ?></span>
								<span class="abalturas-normativa-toc__head-hint"><?php esc_html_e( 'Despliegue la norma que necesite y navegue por sección.', 'abalturas' ); ?></span>
							</div>
							<div class="abalturas-normativa-toc__body" aria-labelledby="toc-normativa-label">
								<?php foreach ( $toc_groups as $group ) : ?>
									<details
										class="abalturas-normativa-toc__norm <?php echo esc_attr( $group['class'] ); ?>"
										id="toc-norm-<?php echo esc_attr( $group['id'] ); ?>"
										<?php echo ! empty( $group['open'] ) ? 'open' : ''; ?>
									>
										<summary aria-controls="toc-norm-panel-<?php echo esc_attr( $group['id'] ); ?>">
											<span class="abalturas-normativa-toc__norm-badge" aria-hidden="true"><?php echo esc_html( $group['badge'] ); ?></span>
											<span class="abalturas-normativa-toc__norm-text">
												<span class="abalturas-normativa-toc__norm-title"><?php echo esc_html( $group['title'] ); ?></span>
												<span class="abalturas-normativa-toc__norm-meta">
													<?php
													echo esc_html(
														sprintf(
															/* translators: 1: resolution subtitle, 2: section count */
															__( '%1$s · %2$d secciones', 'abalturas' ),
															$group['subtitle'],
															count( $group['items'] )
														)
													);
													?>
												</span>
											</span>
											<svg class="abalturas-normativa-toc__norm-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
										</summary>
										<div id="toc-norm-panel-<?php echo esc_attr( $group['id'] ); ?>" class="abalturas-normativa-toc__norm-panel">
											<a href="<?php echo esc_url( $group['anchor'] ); ?>" class="abalturas-normativa-toc__norm-intro">
												<?php esc_html_e( 'Introducción de la norma →', 'abalturas' ); ?>
											</a>
											<ul class="abalturas-normativa-toc__links">
												<?php foreach ( $group['items'] as $href => $label ) : ?>
													<li>
														<a href="<?php echo esc_url( $href ); ?>" class="abalturas-normativa-toc__link"><?php echo esc_html( $label ); ?></a>
													</li>
												<?php endforeach; ?>
											</ul>
										</div>
									</details>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</details>
			</nav>

			<div class="prose prose-slate min-w-0 prose-headings:text-charcoal prose-a:text-industrial prose-a:no-underline hover:prose-a:underline max-w-none lg:col-span-8">

				<div id="res-4272" class="abalturas-normativa-res__header scroll-mt-28 rounded-2xl border border-slate-200/90 bg-charcoal px-6 py-8 text-white shadow-lg sm:px-8 lg:scroll-mt-32">
					<p class="not-prose text-[11px] font-bold uppercase tracking-[0.28em] text-safety"><?php esc_html_e( 'Trabajo en alturas', 'abalturas' ); ?></p>
					<h2 class="not-prose mt-2 text-2xl font-extrabold leading-tight"><?php esc_html_e( 'Resolución 4272 de 2021', 'abalturas' ); ?></h2>
					<p class="not-prose mt-3 text-sm leading-relaxed text-slate-200/95 sm:text-base"><?php esc_html_e( 'Requisitos mínimos de seguridad para prevenir caídas en Colombia.', 'abalturas' ); ?></p>
					<dl class="not-prose mt-5 grid gap-3 border-t border-white/15 pt-5 text-sm sm:grid-cols-2">
						<div><dt class="text-white/65"><?php esc_html_e( 'Expedición', 'abalturas' ); ?></dt><dd class="font-semibold">27 / 12 / 2021</dd></div>
						<div><dt class="text-white/65"><?php esc_html_e( 'Vigencia (regla general)', 'abalturas' ); ?></dt><dd class="font-semibold"><?php esc_html_e( '08/08/2022', 'abalturas' ); ?></dd></div>
					</dl>
					<a href="<?php echo esc_url( $apc_pdf_url ); ?>" class="not-prose mt-5 inline-flex items-center rounded-lg border border-white/35 bg-white/10 px-4 py-2 text-sm font-semibold backdrop-blur-sm hover:bg-white/15" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Texto de referencia (APC Colombia)', 'abalturas' ); ?>
					</a>
				</div>

				<section id="concepto-trabajo-alturas" class="mt-8 rounded-xl border border-slate-100 bg-white px-6 py-8 shadow-sm sm:px-8">
					<h2 class="!mt-0 text-xl font-bold text-charcoal sm:text-2xl"><?php esc_html_e( 'Qué es “trabajo en alturas”', 'abalturas' ); ?></h2>
					<p class="!mt-4 text-[15px] leading-relaxed text-slate-700 sm:text-base"><?php esc_html_e( 'La Resolución define el trabajo en alturas como toda actividad en que el trabajador, por suspensión o desplazamiento, está expuesto a un riesgo de caída mayor a 2 metros, medidos desde el plano de los pies al plano horizontal inferior más cercano.', 'abalturas' ); ?></p>
					<div class="not-prose mt-6 rounded-lg border border-slate-100 bg-mist px-5 py-4 text-sm leading-relaxed text-slate-700">
						<strong class="block text-charcoal"><?php esc_html_e( 'Huecos y aberturas', 'abalturas' ); ?></strong>
						<?php esc_html_e( 'También se considera hueco aquel espacio o brecha en una superficie a través del cual puede producirse caída de personas u objetos de 2 metros o más (definición de la misma norma).', 'abalturas' ); ?>
					</div>
				</section>

				<section id="ambito-aplicacion" class="mt-8 rounded-xl border border-slate-100 bg-white px-6 py-8 shadow-sm sm:px-8">
					<h2 class="!mt-0 text-xl font-bold text-charcoal sm:text-2xl"><?php esc_html_e( 'Ámbito, actividades exceptuadas y menor a 2 m', 'abalturas' ); ?></h2>
					<p class="!mt-4 text-[15px] leading-relaxed text-slate-700 sm:text-base"><?php esc_html_e( 'Aplica a empleadores, contratistas, aprendices, trabajadores y actividades económicas donde exista trabajo en alturas; también a Administradoras de Riesgos Laborales (ARL) y a centros de capacitación/entrenamiento.', 'abalturas' ); ?></p>

					<h3 class="!mt-8 text-lg font-semibold"><?php esc_html_e( 'Se exceptúan (deben igualmente gestionar riesgos)', 'abalturas' ); ?></h3>
					<ol class="!mt-3 list-decimal space-y-2 ps-6 text-[15px] leading-relaxed text-slate-700 marker:font-semibold marker:text-industrial">
						<li><?php esc_html_e( 'Atención de emergencias y rescate.', 'abalturas' ); ?></li>
						<li><?php esc_html_e( 'Operaciones militares/policiales en acciones propias del servicio.', 'abalturas' ); ?></li>
						<li><?php esc_html_e( 'Actividades deportivas, alta montaña o andinismo.', 'abalturas' ); ?></li>
						<li><?php esc_html_e( 'Actos lúdicos o artísticos.', 'abalturas' ); ?></li>
						<li><?php esc_html_e( 'Actividades sobre animales.', 'abalturas' ); ?></li>
					</ol>
					<p class="!mt-3 text-[15px] text-slate-600"><?php esc_html_e( 'Para esos casos, la norma exige proceso de identificación de peligros, valoración de riesgos e implementación de controles conforme estándares nacionales o internacionales (Parágrafo 1 del Art. 2).', 'abalturas' ); ?></p>

					<div class="not-prose mt-6 rounded-lg border border-safety/20 bg-orange-50/80 px-5 py-4 text-sm text-slate-800">
						<strong class="text-charcoal"><?php esc_html_e( 'Peligros aunque sea menos de 2 m', 'abalturas' ); ?></strong>
						<p class="mt-2 leading-relaxed"><?php esc_html_e( 'Si el análisis de riesgos del SG-SST o del coordinador de trabajo en alturas identifica obstáculos, bordes, energizaciones, punto cortante, máquinas en movimiento, etc., igualmente debe garantizarse la prevención y protección contra caídas aun cuando la altura sea inferior al umbral habitual (Parágrafo 2 del Art. 2).', 'abalturas' ); ?></p>
					</div>
				</section>

				<section id="programa-cpp" class="mt-8 rounded-xl border border-slate-100 bg-white px-6 py-8 shadow-sm sm:px-8">
					<h2 class="!mt-0 text-xl font-bold text-charcoal sm:text-2xl"><?php esc_html_e( 'Programa de prevención y protección contra caídas', 'abalturas' ); ?></h2>
					<p class="!mt-4 text-[15px] leading-relaxed text-slate-700 sm:text-base"><?php esc_html_e( 'El empleador debe integrar —dentro del SG-SST — un programa donde identifique tareas en alturas, peligros y métodos para eliminar o controlar cada riesgo aplicando primero la jerarquía de controles del Decreto 1072 de 2015 (Art. 4).', 'abalturas' ); ?></p>
					<h3 class="!mt-6 text-lg font-semibold"><?php esc_html_e( 'Contenido mínimo del programa (Art. 5)', 'abalturas' ); ?></h3>
					<details class="not-prose mt-4 rounded-lg border border-slate-200 bg-slate-50/70 open:bg-white [&_summary]:cursor-pointer [&_summary]:font-semibold [&_summary]:text-charcoal [&_summary]:outline-none [&_summary]:focus-visible:ring-2 [&_summary]:focus-visible:ring-industrial [&_summary]:rounded-lg [&_summary]:px-5 [&_summary]:py-3">
						<summary><?php esc_html_e( 'Desplegar listado oficial (literales a … o)', 'abalturas' ); ?></summary>
						<ul class="mt-4 space-y-2 border-t border-slate-200 px-5 py-5 text-[14px] leading-relaxed text-slate-700 sm:text-[15px]">
							<li><strong>a.</strong> <?php esc_html_e( 'Objetivo general y alcance.', 'abalturas' ); ?></li>
							<li><strong>b–c.</strong> <?php esc_html_e( 'Marco conceptual y legal.', 'abalturas' ); ?></li>
							<li><strong>d.</strong> <?php esc_html_e( 'Roles y responsabilidades (entre otros: administrador del programa, persona calificada, coordinador, trabajador autorizado, ayudantes y brigadas de rescate).', 'abalturas' ); ?></li>
							<li><strong>e–f.</strong> <?php esc_html_e( 'Requisitos formativos por rol y cronograma.', 'abalturas' ); ?></li>
							<li><strong>g–h.</strong> <?php esc_html_e( 'Identificación de peligros y evaluación/voloración de riesgos.', 'abalturas' ); ?></li>
							<li><strong>i.</strong> <?php esc_html_e( 'Inventario de actividades clasificadas en rutinarias y no rutinarias.', 'abalturas' ); ?></li>
							<li><strong>j–m.</strong> <?php esc_html_e( 'Procedimientos, medidas de prevención y protección y sistemas de acceso.', 'abalturas' ); ?></li>
							<li><strong>n.</strong> <?php esc_html_e( 'Procedimiento en emergencias.', 'abalturas' ); ?></li>
							<li><strong>o.</strong> <?php esc_html_e( 'Indicadores SG-SST alineados al Decreto 1072 de 2015.', 'abalturas' ); ?></li>
						</ul>
					</details>
				</section>

				<section id="roles-capacidad" class="mt-8 rounded-xl border border-slate-100 bg-white px-6 py-8 shadow-sm sm:px-8">
					<h2 class="!mt-0 text-xl font-bold text-charcoal sm:text-2xl"><?php esc_html_e( 'Roles principales y formación inicial', 'abalturas' ); ?></h2>
					<p class="!mt-4 text-[15px] leading-relaxed text-slate-700"><?php esc_html_e( 'El Artículo 6 exige registrar roles dentro del programa. La siguiente tabla sintetiza perfiles públicos conocidos como “pilares”:', 'abalturas' ); ?></p>
					<div class="not-prose mt-6 overflow-x-auto rounded-lg border border-slate-200">
						<table class="min-w-[30rem] w-full text-left text-sm">
							<thead class="bg-charcoal text-white">
								<tr>
									<th class="whitespace-normal px-4 py-3 font-semibold"><?php esc_html_e( 'Rol', 'abalturas' ); ?></th>
									<th class="whitespace-normal px-4 py-3 font-semibold"><?php esc_html_e( 'Contribución típica', 'abalturas' ); ?></th>
									<th class="whitespace-normal px-4 py-3 font-semibold"><?php esc_html_e( 'Intensidad mínima (Tabla N.º 2)', 'abalturas' ); ?></th>
								</tr>
							</thead>
							<tbody class="divide-y divide-slate-200 bg-white">
								<tr><td class="px-4 py-3 font-medium text-charcoal"><?php esc_html_e( 'Jefe de área TA', 'abalturas' ); ?></td><td class="px-4 py-3 text-slate-700"><?php esc_html_e( 'Decisiones administrativas de aplicación de la resolución cuando el riesgo es prioritario.', 'abalturas' ); ?></td><td class="px-4 py-3 text-slate-700"><?php esc_html_e( 'Mínimo 8 h.', 'abalturas' ); ?></td></tr>
								<tr class="bg-slate-50/80"><td class="px-4 py-3 font-medium text-charcoal"><?php esc_html_e( 'Trabajador autorizado', 'abalturas' ); ?></td><td class="px-4 py-3 text-slate-700"><?php esc_html_e( 'Ejecuta las labores cumpliendo medidas establecidas; incluye parte de los aprendices en programas prácticos con riesgo de caída.', 'abalturas' ); ?></td><td class="px-4 py-3 text-slate-700"><?php esc_html_e( 'Mínimo 32 h, presencial, 60% práctica.', 'abalturas' ); ?></td></tr>
								<tr><td class="px-4 py-3 font-medium text-charcoal"><?php esc_html_e( 'Coordinador de trabajo en alturas', 'abalturas' ); ?></td><td class="px-4 py-3 text-slate-700"><?php esc_html_e( 'Detecta peligros en obra y corrige contingencias antes/p durante la tarea.', 'abalturas' ); ?></td><td class="px-4 py-3 text-slate-700"><?php esc_html_e( 'Mínimo 80 h.', 'abalturas' ); ?></td></tr>
								<tr class="bg-slate-50/80"><td class="px-4 py-3 font-medium text-charcoal"><?php esc_html_e( 'Entrenador en TA', 'abalturas' ); ?></td><td class="px-4 py-3 text-slate-700"><?php esc_html_e( 'Capacita a jefes, autorizados, coordinadores u otros entrenadores.', 'abalturas' ); ?></td><td class="px-4 py-3 text-slate-700"><?php esc_html_e( 'Mínimo 130 h (submódulos de pedagogía/práctica).', 'abalturas' ); ?></td></tr>
							</tbody>
						</table>
					</div>
					<p class="!mt-4 text-[15px] leading-relaxed text-slate-600"><?php esc_html_e( 'Quienes opten pueden certificar competencia laboral mediante organismo avalado — el certificado de competencia NO sustituye el reentrenamiento para conservar categoría de “trabajador autorizado” (Art. 9). La formación inicial la deben ejecutar instituciones y esquemas descritos por la norma (p. ej. SENA, UVAe, instituciones de superior educación autorizadas, licenciados SST, etc.— Art. 11).', 'abalturas' ); ?></p>
				</section>

				<section id="medidas-prevencion" class="mt-8 rounded-xl border border-slate-100 bg-white px-6 py-8 shadow-sm sm:px-8">
					<h2 class="!mt-0 text-xl font-bold text-charcoal sm:text-2xl"><?php esc_html_e( 'Medidas de prevención destacadas', 'abalturas' ); ?></h2>
					<p class="!mt-4 text-[15px] leading-relaxed text-slate-700"><?php esc_html_e( 'Las medidas coherentes por actividad (Art 7–8); entre las colectivas se incluyen (Art. 13):', 'abalturas' ); ?></p>
					<ul class="!mt-4 space-y-2 text-[15px] leading-relaxed text-slate-700">
						<li><strong><?php esc_html_e( 'Delimitación:', 'abalturas' ); ?></strong> <?php esc_html_e( 'Zonas marcadas visiblemente día/noche (combinación amarillo/negro, vallas o similares).', 'abalturas' ); ?></li>
						<li><strong><?php esc_html_e( 'Línea de advertencia:', 'abalturas' ); ?></strong> <?php esc_html_e( 'A lo largo de lados sin baranda (≥ 1,8 m desde el borde, resistencia lateral mín., banderines < 1,8 m) con ayudante de seguridad en la superficie supervisando.', 'abalturas' ); ?></li>
						<li><strong><?php esc_html_e( 'Señalización', 'abalturas' ); ?></strong> <?php esc_html_e( 'bilingüe si hay extranjeros, demarcación completa.', 'abalturas' ); ?></li>
						<li><strong><?php esc_html_e( 'Barandas', 'abalturas' ); ?></strong> <?php esc_html_e( '(incluye tablas dimensionales sobre altura ≥ 1 m, intermedios cada 48 cm, rodapiés 9 cm … nunca usarlas como punto de arnés).', 'abalturas' ); ?></li>
					</ul>
				</section>

				<section id="permiso-chequeo" class="mt-8 rounded-xl border border-slate-100 bg-white px-6 py-8 shadow-sm sm:px-8">
					<h2 class="!mt-0 text-xl font-bold text-charcoal sm:text-2xl"><?php esc_html_e( 'Permiso de trabajo en alturas (Art. 15)', 'abalturas' ); ?></h2>
					<p class="!mt-4 text-[15px] leading-relaxed text-slate-700"><?php esc_html_e( 'Todos los trabajos deben estar planeados mediante permiso revisado por el coordinador de trabajo en alturas cuando haya zonas peligrosas sin protecciones suficientes. El formato debe incluir el nombre de los trabajadores y como mínimo los siguientes puntos:', 'abalturas' ); ?></p>
					<ol class="!mt-4 grid gap-3 text-[13.75px] leading-snug text-slate-700 sm:grid-cols-2 lg:text-[14px]">
						<?php
						$permiso_pts = array(
							__( 'Tipo de trabajo.', 'abalturas' ),
							__( 'Altura aproximada a la cual se va a desarrollar la actividad.', 'abalturas' ),
							__( 'Fecha y hora de inicio y de terminación de la tarea.', 'abalturas' ),
							__( 'Verificación de la afiliación vigente a la seguridad social.', 'abalturas' ),
							__( 'Requisitos del trabajador (requerimientos de aptitud).', 'abalturas' ),
							__( 'Descripción y procedimiento de la tarea.', 'abalturas' ),
							__( 'Sistema de prevención contra caídas.', 'abalturas' ),
							__( 'Equipos y sistema de acceso para trabajo en alturas.', 'abalturas' ),
							__( 'Verificación de los puntos de anclaje por cada trabajador.', 'abalturas' ),
							__( 'Sistemas de restricción, posicionamiento o detención de caídas a utilizar.', 'abalturas' ),
							__( 'Elementos de protección personal seleccionados por el empleador según riesgos y tarea.', 'abalturas' ),
							__( 'Herramientas para utilizar.', 'abalturas' ),
							__( 'Constancia de capacitación o certificado de competencia laboral para prevención de caídas en TA.', 'abalturas' ),
							__( 'Observaciones.', 'abalturas' ),
							__( 'Nombres, apellidos, firmas y documentos de identificación de los trabajadores.', 'abalturas' ),
							__( 'Nombre, apellido y firma de quien autoriza el trabajo.', 'abalturas' ),
							__( 'Nombre y firma de la persona responsable de activar el plan de emergencias.', 'abalturas' ),
							__( 'Nombre y firma del coordinador de trabajos en alturas (si es distinto de quien autoriza).', 'abalturas' ),
						);
						foreach ( $permiso_pts as $item ) :
							echo '<li class="flex gap-2"><span class="mt-1 h-2 w-2 shrink-0 rounded-full bg-safety"></span><span>' . esc_html( $item ) . '</span></li>';
						endforeach;
						?>
					</ol>
					<p class="!mt-4 text-sm text-slate-600"><?php esc_html_e( 'Recuerda anexos de análisis de peligros (ARO, ATS…) y lineamientos de revalidación, suspensión o cierre ante cambios significativos (turno, clima, personal, equipo). El Parágrafo 3 exige revisión firma coordinador cada evento.', 'abalturas' ); ?></p>
				</section>

				<section id="reentrenamiento" class="mt-8 rounded-xl border border-slate-100 bg-white px-6 py-8 shadow-sm sm:px-8">
					<h2 class="!mt-0 text-xl font-bold text-charcoal sm:text-2xl"><?php esc_html_e( 'Reentrenamientos obligados', 'abalturas' ); ?></h2>
					<div class="not-prose space-y-6 text-[15px] leading-relaxed text-slate-700">
						<div class="rounded-lg border border-slate-100 bg-mist px-5 py-4">
							<h3 class="text-base font-bold text-charcoal"><?php esc_html_e( 'Casos especiales por cambios (literal a)', 'abalturas' ); ?></h3>
							<p class="mt-2"><?php esc_html_e( 'Cuando cambia la actividad, procedimiento, tecnología, ingresa como nueva persona a la empresa, etc., el contratante programa reentrenamiento presencial por oferente MinTrabajo, mínimo 8 horas (20 % teoría, 80 % práctica); puede impartirla el empleador en planta usando equipamiento real cuando esté dentro de esa figura autorizada.', 'abalturas' ); ?></p>
						</div>
						<div class="rounded-lg border border-emerald-200/80 bg-emerald-50/60 px-5 py-4">
							<h3 class="text-base font-bold text-charcoal"><?php esc_html_e( 'Periodicidad rutinaria (literal b)', 'abalturas' ); ?></h3>
							<p class="mt-2"><?php esc_html_e( 'Cada trabajador certificado debe recibir una actualización mínimo cada 18 meses si siguen en misma empresa y actividad. Duración igual: 8 h (20 % / 80 %), presencial.', 'abalturas' ); ?></p>
							<ul class="mt-3 space-y-1 text-sm leading-relaxed text-slate-700">
								<li><?php esc_html_e( 'El empleador reporta trabajadores reentrenados a su ARL (nombre, documento, fecha, oferente).', 'abalturas' ); ?></li>
								<li><?php esc_html_e( 'No puede cargarse costo ni responsabilización exclusiva al trabajador (Art. programa de trabajador).', 'abalturas' ); ?></li>
								<li><?php esc_html_e( 'Las observaciones del coordinador pueden gatillar reentreno inmediato adicional.', 'abalturas' ); ?></li>
							</ul>
						</div>
						<details class="rounded-lg border border-slate-200 bg-slate-50/80">
							<summary class="cursor-pointer px-5 py-3 text-sm font-semibold text-charcoal"><?php esc_html_e( 'Contenidos mínimos del programa nivel trabajador (extracto oficial)', 'abalturas' ); ?></summary>
							<ul class="space-y-1 border-t border-slate-100 px-5 py-4 text-[13px] leading-relaxed text-slate-700 sm:text-[14px]">
								<li><?php esc_html_e( 'Peligros, medidas jerárquicas, cultura SST, trabajo en equipo con contratistas y coordinador.', 'abalturas' ); ?></li>
								<li><?php esc_html_e( 'Selección/uso mantenimiento de EPP contra caídas; plan de evacuación o rescate; trauma por suspensión.', 'abalturas' ); ?></li>
								<li><?php esc_html_e( 'Equipos elevadores/manipuladores, andamios, escaleras conforme especificaciones y permisos.', 'abalturas' ); ?></li>
								<li><?php esc_html_e( 'Interpretación fichas/manuales, inspección y “hoja de vida” de elementos certificados.', 'abalturas' ); ?></li>
							</ul>
						</details>
					</div>
				</section>

				<section id="sistemas-epp" class="mt-8 rounded-xl border border-slate-100 bg-white px-6 py-8 shadow-sm sm:px-8">
					<h2 class="!mt-0 text-xl font-bold text-charcoal sm:text-2xl"><?php esc_html_e( 'Acceso vertical, ingeniería y EPP integrado', 'abalturas' ); ?></h2>
					<h3 class="!mt-4 text-lg font-semibold"><?php esc_html_e( 'Sistemas de acceso (Art. 16)', 'abalturas' ); ?></h3>
					<p class="text-[15px] leading-relaxed text-slate-700"><?php esc_html_e( 'Todos deben estar certificados bajo estándar aplicable, con documentación en español del fabricante, inspeccionados según Decreto 1072 o fabricante y retirados si hay no conformidades. Registrar hoja de vida (marca, serial, fecha, inspección, mantenimiento). Mantener RETIE donde haya cercanías eléctricas.', 'abalturas' ); ?></p>
					<h3 class="!mt-6 text-lg font-semibold"><?php esc_html_e( 'Suspendidos / trabajo en suspensión (Art. 19)', 'abalturas' ); ?></h3>
					<p class="text-[15px] leading-relaxed text-slate-700"><?php esc_html_e( 'Los trabajos en suspensión exigen “sillas” enlazadas a argolla del arnés indicada y sistema descendente certificado, más respaldo contra caída en línea de vida/portafolio independiente. Planos inclinados >45° se tratan como suspensión.', 'abalturas' ); ?></p>
					<h3 class="!mt-6 text-lg font-semibold"><?php esc_html_e( 'Sistemas de restricción y posicionamiento (Arts. 20–21)', 'abalturas' ); ?></h3>
					<p class="text-[15px] leading-relaxed text-slate-700"><?php esc_html_e( 'Anclajes mínimos: restricción 1.000 lbf (~4.5 kN ~459 kgf) como regla rápida, posicionamiento 3.000 lbf (~13.3 kN ~1356 kgf) (o valores alternos calculados conforme texto). Mantener límitación de trayectorias y compatibilidades certificadas entre conectores, eslingas y arneses.', 'abalturas' ); ?></p>
				</section>

				<section id="obligaciones" class="mt-8 rounded-xl border border-slate-100 bg-white px-6 py-8 shadow-sm sm:px-8">
					<h2 class="!mt-0 text-xl font-bold text-charcoal sm:text-2xl"><?php esc_html_e( 'Extracto obligaciones del empleador y del trabajador (Arts. 61–62)', 'abalturas' ); ?></h2>
					<div class="not-prose mt-6 grid gap-6 md:grid-cols-2">
						<div class="rounded-xl border border-slate-100 bg-industrial/[0.04] px-5 py-5 shadow-sm">
							<h3 class="text-[15px] font-bold uppercase tracking-wide text-charcoal"><?php esc_html_e( 'Empleador — min.', 'abalturas' ); ?></h3>
							<ul class="mt-4 space-y-2 text-[14px] leading-relaxed text-slate-700">
								<li><?php esc_html_e( 'Administrador del programa y coordinador de TA formalizados', 'abalturas' ); ?></li>
								<li><?php esc_html_e( 'Contratar proveedor MinTrabajo con cargas horarias válidas sin costear al trabajador', 'abalturas' ); ?></li>
								<li><?php esc_html_e( 'ARL notificaciones y seguimiento a contratistas', 'abalturas' ); ?></li>
								<li><?php esc_html_e( 'Planes de rescate/emergencias y equipos funcionales', 'abalturas' ); ?></li>
								<li><?php esc_html_e( 'Sin exposición trabajo en altura a menores o embarazadas', 'abalturas' ); ?></li>
							</ul>
						</div>
						<div class="rounded-xl border border-slate-100 bg-slate-50/80 px-5 py-5 shadow-sm">
							<h3 class="text-[15px] font-bold uppercase tracking-wide text-charcoal"><?php esc_html_e( 'Trabajador', 'abalturas' ); ?></h3>
							<ul class="mt-4 space-y-2 text-[14px] leading-relaxed text-slate-700">
								<li><?php esc_html_e( 'Cumple procedimientos, asiste a reentrenos', 'abalturas' ); ?></li>
								<li><?php esc_html_e( 'Informa estado de salud que limite trabajo en altura', 'abalturas' ); ?></li>
								<li><?php esc_html_e( 'Usa EPP y anclajes proporcionados; reporta deterioro al coordinador', 'abalturas' ); ?></li>
								<li><?php esc_html_e( 'Conoce permiso y contingencias antes de ejecutar', 'abalturas' ); ?></li>
							</ul>
						</div>
					</div>
					<details class="not-prose mt-6 rounded-lg border border-dashed border-slate-200 bg-white px-5 py-3 text-sm [&_summary]:cursor-pointer">
						<summary class="font-semibold text-charcoal"><?php esc_html_e( 'Lista completa Art. 61 (literales del a al p)', 'abalturas' ); ?></summary>
						<ol class="mt-4 list-decimal space-y-2 ps-5 leading-relaxed text-slate-700">
							<?php
							$emps = array(
								__( 'Remitir trabajadores a evaluaciones médicas ocupacionales según norma.', 'abalturas' ),
								__( 'Incorporar al SG‑SST el programa de prevención y protección contra caídas conforme esta resolución.', 'abalturas' ),
								__( 'Nombrar y sostener administrador del programa y coordinador de trabajo en alturas.', 'abalturas' ),
								__( 'Proveer elementos y capacitación sin cargar costo al trabajador.', 'abalturas' ),
								__( 'Verificar que la formación sea con proveedor autorizado y con intensidad definida.', 'abalturas' ),
								__( 'Divulgar antes de ejecutar todas las labores TA y procedimientos asociados.', 'abalturas' ),
								__( 'Inspeccionar equipos contra caídas al menos una vez al año u otra periodicidad del fabricante.', 'abalturas' ),
								__( 'Guardar registros de revisiones y mantenimiento de equipos y sistemas TA.', 'abalturas' ),
								__( 'Desarrollar planes de prevención, preparación y respuesta ante emergencias y rescate documentados.', 'abalturas' ),
								__( 'Impedir que menores de edad o mujeres en cualquier etapa del embarazo laboren en alturas.', 'abalturas' ),
								__( 'Verificar SG‑SST y procedimientos de contratistas; solidaridad en accidentes por incumplimiento de contratistas.', 'abalturas' ),
								__( 'Exigir a proveedores de EPP información técnica y manuales en español.', 'abalturas' ),
								__( 'Asegurar que fichas/manuales sean comprendidos por trabajadores destinatarios.', 'abalturas' ),
								__( 'Constructor: planear prevención de caídas en nuevas construcciones y dotar seguridad para mantenimiento futuro.', 'abalturas' ),
								__( 'Gestionar compatibilidad de sistemas de protección; validar modificaciones ante dudas con persona calificada.', 'abalturas' ),
								__( 'Asumir costo de capacitación cuando contrata actividades TA y dar aviso conforme a obligación ante ARL.', 'abalturas' ),
							);
							foreach ( $emps as $t ) :
								echo '<li>' . esc_html( $t ) . '</li>';
							endforeach;
							?>
						</ol>
					</details>
					<details class="not-prose mt-4 rounded-lg border border-dashed border-slate-200 bg-white px-5 py-3 text-sm [&_summary]:cursor-pointer">
						<summary class="font-semibold text-charcoal"><?php esc_html_e( 'Lista completa Art. 62 (literales del a al h)', 'abalturas' ); ?></summary>
						<ol class="mt-4 list-decimal space-y-2 ps-5 leading-relaxed text-slate-700">
							<?php
							foreach (
								array(
									__( 'Asistir y aprobar capacitaciones y reentrenamientos programados por el empleador.', 'abalturas' ),
									__( 'Cumplir procedimientos de SST definidos.', 'abalturas' ),
									__( 'Informar al empleador condiciones médicas restrictivas antes de ejecutar trabajo en altura.', 'abalturas' ),
									__( 'Utilizar controles contra caídas implementados conforme esta resolución.', 'abalturas' ),
									__( 'Reportar al coordinador el deterioro o daño en sistemas de prevención o protección.', 'abalturas' ),
									__( 'Participar en la elaboración/diligenciamiento del permiso y acatar las disposiciones.', 'abalturas' ),
									__( 'Conocer peligros, controles definidos y acciones ante emergencias.', 'abalturas' ),
									__( 'Garantizar su seguridad y la de otros frente a actos u omisiones.', 'abalturas' ),
								) as $tw
							) {
								echo '<li>' . esc_html( $tw ) . '</li>';
							}
							?>
						</ol>
					</details>
				</section>

				<section id="vigencia-deroga" class="mt-8 rounded-xl border border-slate-100 bg-white px-6 py-8 shadow-sm sm:px-8">
					<h2 class="!mt-0 text-xl font-bold text-charcoal sm:text-2xl"><?php esc_html_e( 'Vigencia y derogatorias', 'abalturas' ); ?></h2>
					<p class="text-[15px] leading-relaxed text-slate-700"><?php esc_html_e( 'Los regímenes de certificados expedidos antes de la resolución conservan vigencia hasta que aplique nuevo requisito de reentrenamiento (Arts. programa + parágrafo sobre certifica previos). Art. 67: regla especial de puesta en marcha tras publicación oficial; Art 68 lista varias normas incluyendo Res. 1409/2012, 1903/2013…', 'abalturas' ); ?></p>
				</section>

				<section id="fuentes" class="mt-10 rounded-xl border border-slate-800/10 bg-white px-6 py-8 shadow-sm sm:px-8">
					<h2 class="!mt-0 text-xl font-bold text-charcoal"><?php esc_html_e( 'Fuentes oficiales y consultas adicionales', 'abalturas' ); ?></h2>
					<ul class="!mt-4 space-y-2 text-[15px]">
						<li><a class="break-all font-medium" href="<?php echo esc_url( $mnt_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $mnt_url ); ?></a> — <?php esc_html_e( 'Ministerio del Trabajo (registros DMFT)', 'abalturas' ); ?></li>
						<li><a class="break-all font-medium" href="<?php echo esc_url( $apc_pdf_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $apc_pdf_url ); ?></a> — <?php esc_html_e( 'Agencia Presidencial de Cooperación Internacional — referencia institucional y PDF.', 'abalturas' ); ?></li>
						<li><a class="break-all font-medium" href="<?php echo esc_url( $sisjur_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $sisjur_url ); ?></a> — <?php esc_html_e( 'Republicación Sisjur (consulta rápida; verificar ante DO).', 'abalturas' ); ?></li>
						<li><a class="break-all font-medium" href="<?php echo esc_url( $decr_1072_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $decr_1072_url ); ?></a> — SG-SST (Decreto 1072).</li>
					</ul>
					<p class="!mt-6 text-sm italic text-slate-600"><?php esc_html_e( 'Las secretarías jurídicas o portales republican algunos textos con carácter informativo — verifique siempre frente al Diario Oficial y soporte especializado.', 'abalturas' ); ?></p>
				</section>

				<div id="res-0491" class="abalturas-normativa-res__header scroll-mt-28 rounded-2xl border border-slate-200/90 bg-charcoal px-6 py-8 text-white shadow-lg sm:px-8 lg:scroll-mt-32">
					<p class="not-prose text-[11px] font-bold uppercase tracking-[0.28em] text-safety"><?php esc_html_e( 'Espacios confinados', 'abalturas' ); ?></p>
					<h2 class="not-prose mt-2 text-2xl font-extrabold leading-tight"><?php esc_html_e( 'Resolución 0491 de 2020', 'abalturas' ); ?></h2>
					<p class="not-prose mt-3 text-sm leading-relaxed text-slate-200/95 sm:text-base"><?php esc_html_e( 'Requisitos mínimos de seguridad para el trabajo en espacios confinados en Colombia, integrados al SG-SST (Decreto 1072).', 'abalturas' ); ?></p>
					<dl class="not-prose mt-5 grid gap-3 border-t border-white/15 pt-5 text-sm sm:grid-cols-2">
						<div><dt class="text-white/65"><?php esc_html_e( 'Expedición', 'abalturas' ); ?></dt><dd class="font-semibold">24 / 02 / 2020</dd></div>
						<div><dt class="text-white/65"><?php esc_html_e( 'Entidad', 'abalturas' ); ?></dt><dd class="font-semibold"><?php esc_html_e( 'Ministerio del Trabajo', 'abalturas' ); ?></dd></div>
					</dl>
					<a href="<?php echo esc_url( $res491_ref_url ); ?>" class="not-prose mt-5 inline-flex items-center rounded-lg border border-white/35 bg-white/10 px-4 py-2 text-sm font-semibold backdrop-blur-sm hover:bg-white/15" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Texto de referencia (Gestor Normativo)', 'abalturas' ); ?>
					</a>
				</div>

				<section id="ec-concepto" class="mt-8 rounded-xl border border-slate-100 bg-white px-6 py-8 shadow-sm sm:px-8">
					<h2 class="!mt-0 text-xl font-bold text-charcoal sm:text-2xl"><?php esc_html_e( 'Qué es un espacio confinado', 'abalturas' ); ?></h2>
					<p class="!mt-4 text-[15px] leading-relaxed text-slate-700"><?php esc_html_e( 'La Resolución 0491 define el espacio confinado como un lugar que cumple simultáneamente tres condiciones: no está diseñado para ocupación humana continua; tiene accesos y salidas limitados o restringidos; y puede acumular atmósferas peligrosas por su configuración, contenido o actividades que se desarrollen en su interior.', 'abalturas' ); ?></p>
					<div class="not-prose mt-6 rounded-lg border border-industrial/15 bg-industrial/[0.04] px-5 py-4">
						<p class="text-sm font-semibold text-charcoal"><?php esc_html_e( 'Ejemplos frecuentes en industria', 'abalturas' ); ?></p>
						<ul class="mt-3 grid gap-2 text-[14px] leading-relaxed text-slate-700 sm:grid-cols-2">
							<li><?php esc_html_e( 'Tanques, silos, calderas y recipientes a presión', 'abalturas' ); ?></li>
							<li><?php esc_html_e( 'Túneles, alcantarillas y cámaras subterráneas', 'abalturas' ); ?></li>
							<li><?php esc_html_e( 'Bóvedas, fosas sépticas y pozos de visita', 'abalturas' ); ?></li>
							<li><?php esc_html_e( 'Contenedores, ductos y tuberías de gran diámetro', 'abalturas' ); ?></li>
						</ul>
					</div>
					<p class="!mt-4 text-[15px] leading-relaxed text-slate-700"><?php esc_html_e( 'El objeto de la norma es establecer los requisitos mínimos que deben cumplir empleadores y contratistas para prevenir accidentes y enfermedades laborales asociadas al ingreso y permanencia en estos espacios.', 'abalturas' ); ?></p>
				</section>

				<section id="ec-programa" class="mt-8 rounded-xl border border-slate-100 bg-white px-6 py-8 shadow-sm sm:px-8">
					<h2 class="!mt-0 text-xl font-bold text-charcoal sm:text-2xl"><?php esc_html_e( 'Programa de gestión de espacios confinados (Arts. 7–12)', 'abalturas' ); ?></h2>
					<p class="!mt-4 text-[15px] leading-relaxed text-slate-700"><?php esc_html_e( 'Todo empleador que desarrolle o contrate trabajos en espacios confinados debe implementar un programa de gestión integrado al SG-SST. Este programa debe incluir, como mínimo:', 'abalturas' ); ?></p>
					<ul class="!mt-4 space-y-2 text-[15px] leading-relaxed text-slate-700">
						<li><strong><?php esc_html_e( 'Política y objetivos', 'abalturas' ); ?>:</strong> <?php esc_html_e( 'Compromiso visible de la dirección con la prevención en espacios confinados.', 'abalturas' ); ?></li>
						<li><strong><?php esc_html_e( 'Identificación y evaluación', 'abalturas' ); ?>:</strong> <?php esc_html_e( 'Inventario de espacios confinados y análisis de riesgos por cada uno (Art. 6).', 'abalturas' ); ?></li>
						<li><strong><?php esc_html_e( 'Procedimientos seguros', 'abalturas' ); ?>:</strong> <?php esc_html_e( 'Protocolos de entrada, trabajo, salida y emergencia documentados.', 'abalturas' ); ?></li>
						<li><strong><?php esc_html_e( 'Permisos de entrada', 'abalturas' ); ?>:</strong> <?php esc_html_e( 'Autorización formal antes de cada ingreso, con verificación de condiciones.', 'abalturas' ); ?></li>
						<li><strong><?php esc_html_e( 'Capacitación y competencias', 'abalturas' ); ?>:</strong> <?php esc_html_e( 'Formación inicial y reentrenamiento periódico para cada rol definido.', 'abalturas' ); ?></li>
						<li><strong><?php esc_html_e( 'Equipos y EPP', 'abalturas' ); ?>:</strong> <?php esc_html_e( 'Dotación, inspección y mantenimiento de equipos de medición, ventilación, comunicación y protección respiratoria.', 'abalturas' ); ?></li>
						<li><strong><?php esc_html_e( 'Plan de emergencias y rescate', 'abalturas' ); ?>:</strong> <?php esc_html_e( 'Procedimientos de respuesta, equipos de rescate y simulacros periódicos.', 'abalturas' ); ?></li>
					</ul>
					<p class="!mt-4 text-sm text-slate-600"><?php esc_html_e( 'El administrador del programa es la persona designada por el empleador para liderar la implementación, seguimiento y mejora continua del programa de gestión.', 'abalturas' ); ?></p>
				</section>

				<section id="ec-identificacion" class="mt-8 rounded-xl border border-slate-100 bg-white px-6 py-8 shadow-sm sm:px-8">
					<h2 class="!mt-0 text-xl font-bold text-charcoal sm:text-2xl"><?php esc_html_e( 'Identificación, evaluación y clasificación (Art. 6)', 'abalturas' ); ?></h2>
					<p class="!mt-4 text-[15px] leading-relaxed text-slate-700"><?php esc_html_e( 'Antes de autorizar cualquier ingreso, el empleador debe identificar todos los espacios confinados de su operación y evaluar los riesgos asociados. La evaluación considera:', 'abalturas' ); ?></p>
					<ul class="!mt-4 space-y-2 text-[15px] leading-relaxed text-slate-700">
						<li><?php esc_html_e( 'Configuración física del espacio (accesos, ventilación natural, profundidad).', 'abalturas' ); ?></li>
						<li><?php esc_html_e( 'Sustancias presentes o generadas (tóxicas, inflamables, asfixiantes).', 'abalturas' ); ?></li>
						<li><?php esc_html_e( 'Actividades previas o simultáneas que alteren la atmósfera (soldadura, limpieza química, pintura).', 'abalturas' ); ?></li>
						<li><?php esc_html_e( 'Condiciones energéticas (eléctricas, mecánicas, hidráulicas) que requieran bloqueo y etiquetado (LOTO).', 'abalturas' ); ?></li>
					</ul>
					<div class="not-prose mt-6 grid gap-4 md:grid-cols-2">
						<div class="rounded-lg border border-amber-200/80 bg-amber-50/60 px-5 py-4">
							<h3 class="text-base font-bold text-charcoal"><?php esc_html_e( 'Espacio confinado que requiere permiso', 'abalturas' ); ?></h3>
							<p class="mt-2 text-[14px] leading-relaxed text-slate-700"><?php esc_html_e( 'Todo espacio confinado donde se realicen trabajos debe contar con permiso de entrada. Los riesgos identificados determinan los controles adicionales exigidos.', 'abalturas' ); ?></p>
						</div>
						<div class="rounded-lg border border-red-200/80 bg-red-50/60 px-5 py-4">
							<h3 class="text-base font-bold text-charcoal"><?php esc_html_e( 'Espacio de ingreso restringido', 'abalturas' ); ?></h3>
							<p class="mt-2 text-[14px] leading-relaxed text-slate-700"><?php esc_html_e( 'Espacios con riesgos graves e inminentes (atmósfera IDLH, acumulación de energía) donde el ingreso solo procede con controles estrictos, ventilación forzada, monitoreo continuo y plan de rescate inmediato.', 'abalturas' ); ?></p>
						</div>
					</div>
				</section>

				<section id="ec-roles" class="mt-8 rounded-xl border border-slate-100 bg-white px-6 py-8 shadow-sm sm:px-8">
					<h2 class="!mt-0 text-xl font-bold text-charcoal sm:text-2xl"><?php esc_html_e( 'Roles, responsabilidades y formación', 'abalturas' ); ?></h2>
					<p class="!mt-4 text-[15px] leading-relaxed text-slate-700"><?php esc_html_e( 'La norma define roles con responsabilidades específicas y horas mínimas de capacitación inicial presencial:', 'abalturas' ); ?></p>
					<div class="not-prose mt-6 overflow-x-auto rounded-lg border border-slate-200">
						<table class="w-full min-w-[32rem] text-left text-[13.5px] leading-snug">
							<thead class="border-b border-slate-200 bg-slate-50 text-charcoal">
								<tr>
									<th class="whitespace-normal px-4 py-3 font-semibold"><?php esc_html_e( 'Rol', 'abalturas' ); ?></th>
									<th class="whitespace-normal px-4 py-3 font-semibold"><?php esc_html_e( 'Función principal', 'abalturas' ); ?></th>
									<th class="whitespace-normal px-4 py-3 font-semibold"><?php esc_html_e( 'Capacitación mínima', 'abalturas' ); ?></th>
								</tr>
							</thead>
							<tbody class="divide-y divide-slate-200 bg-white">
								<tr><td class="px-4 py-3 font-medium text-charcoal"><?php esc_html_e( 'Administrador del programa', 'abalturas' ); ?></td><td class="px-4 py-3 text-slate-700"><?php esc_html_e( 'Diseña, implementa y audita el programa de gestión; designa roles y verifica cumplimiento.', 'abalturas' ); ?></td><td class="px-4 py-3 text-slate-700"><?php esc_html_e( 'Mínimo 8 h.', 'abalturas' ); ?></td></tr>
								<tr class="bg-slate-50/80"><td class="px-4 py-3 font-medium text-charcoal"><?php esc_html_e( 'Supervisor de espacio confinado', 'abalturas' ); ?></td><td class="px-4 py-3 text-slate-700"><?php esc_html_e( 'Autoriza permisos, verifica condiciones previas al ingreso y coordina la operación.', 'abalturas' ); ?></td><td class="px-4 py-3 text-slate-700"><?php esc_html_e( 'Mínimo 20 h.', 'abalturas' ); ?></td></tr>
								<tr><td class="px-4 py-3 font-medium text-charcoal"><?php esc_html_e( 'Trabajador entrante', 'abalturas' ); ?></td><td class="px-4 py-3 text-slate-700"><?php esc_html_e( 'Ejecuta las labores dentro del espacio confinado cumpliendo procedimientos y EPP.', 'abalturas' ); ?></td><td class="px-4 py-3 text-slate-700"><?php esc_html_e( 'Mínimo 16 h.', 'abalturas' ); ?></td></tr>
								<tr class="bg-slate-50/80"><td class="px-4 py-3 font-medium text-charcoal"><?php esc_html_e( 'Vigía (guardián)', 'abalturas' ); ?></td><td class="px-4 py-3 text-slate-700"><?php esc_html_e( 'Permanece fuera del espacio, mantiene comunicación con entrantes y activa emergencias.', 'abalturas' ); ?></td><td class="px-4 py-3 text-slate-700"><?php esc_html_e( 'Mínimo 8 h.', 'abalturas' ); ?></td></tr>
							</tbody>
						</table>
					</div>
					<div class="not-prose mt-6 rounded-lg border border-emerald-200/80 bg-emerald-50/60 px-5 py-4">
						<h3 class="text-base font-bold text-charcoal"><?php esc_html_e( 'Reentrenamiento', 'abalturas' ); ?></h3>
						<p class="mt-2 text-[14px] leading-relaxed text-slate-700"><?php esc_html_e( 'Todos los roles deben recibir reentrenamiento al menos cada 3 años, o antes si cambian procedimientos, equipos, roles o tras un incidente relacionado con espacios confinados. El empleador conserva registros de formación y los reporta a la ARL.', 'abalturas' ); ?></p>
					</div>
				</section>

				<section id="ec-permiso" class="mt-8 rounded-xl border border-slate-100 bg-white px-6 py-8 shadow-sm sm:px-8">
					<h2 class="!mt-0 text-xl font-bold text-charcoal sm:text-2xl"><?php esc_html_e( 'Permiso de entrada a espacio confinado', 'abalturas' ); ?></h2>
					<p class="!mt-4 text-[15px] leading-relaxed text-slate-700"><?php esc_html_e( 'Ningún trabajador puede ingresar a un espacio confinado sin un permiso de entrada vigente, firmado por el supervisor autorizado. El permiso debe verificar como mínimo:', 'abalturas' ); ?></p>
					<ol class="!mt-4 grid gap-3 text-[13.75px] leading-snug text-slate-700 sm:grid-cols-2 lg:text-[14px]">
						<?php
						$ec_permiso_pts = array(
							__( 'Identificación del espacio confinado y descripción del trabajo.', 'abalturas' ),
							__( 'Fecha, hora de inicio y terminación estimada.', 'abalturas' ),
							__( 'Nombres y firmas de entrantes, vigía y supervisor.', 'abalturas' ),
							__( 'Resultados de monitoreo atmosférico (O₂, gases inflamables, tóxicos).', 'abalturas' ),
							__( 'Verificación de bloqueo y etiquetado de energías (LOTO).', 'abalturas' ),
							__( 'Equipos de ventilación, comunicación y rescate disponibles.', 'abalturas' ),
							__( 'EPP y equipos de protección respiratoria asignados.', 'abalturas' ),
							__( 'Procedimiento de emergencia y rescate comunicado al equipo.', 'abalturas' ),
							__( 'Condiciones que invalidan o suspenden el permiso.', 'abalturas' ),
							__( 'Autorización formal del supervisor de espacio confinado.', 'abalturas' ),
						);
						foreach ( $ec_permiso_pts as $item ) :
							echo '<li class="flex gap-2"><span class="mt-1 h-2 w-2 shrink-0 rounded-full bg-safety"></span><span>' . esc_html( $item ) . '</span></li>';
						endforeach;
						?>
					</ol>
					<p class="!mt-4 text-sm text-slate-600"><?php esc_html_e( 'El permiso se cancela si cambian las condiciones (lecturas atmosféricas, personal, clima, actividades adyacentes) o al finalizar la jornada. Un permiso nuevo requiere nueva verificación completa.', 'abalturas' ); ?></p>
				</section>

				<section id="ec-controles" class="mt-8 rounded-xl border border-slate-100 bg-white px-6 py-8 shadow-sm sm:px-8">
					<h2 class="!mt-0 text-xl font-bold text-charcoal sm:text-2xl"><?php esc_html_e( 'Controles atmosféricos, ventilación y EPP', 'abalturas' ); ?></h2>
					<h3 class="!mt-4 text-lg font-semibold"><?php esc_html_e( 'Monitoreo atmosférico', 'abalturas' ); ?></h3>
					<p class="text-[15px] leading-relaxed text-slate-700"><?php esc_html_e( 'Antes, durante y después del ingreso se deben medir los niveles de oxígeno (rango seguro típico: 19,5 % – 23,5 %), gases inflamables (generalmente < 10 % del LEL) y contaminantes tóxicos según TLV/TWA aplicables. El equipo de detección debe estar calibrado y operado por personal capacitado.', 'abalturas' ); ?></p>
					<h3 class="!mt-6 text-lg font-semibold"><?php esc_html_e( 'Ventilación', 'abalturas' ); ?></h3>
					<p class="text-[15px] leading-relaxed text-slate-700"><?php esc_html_e( 'Cuando la ventilación natural es insuficiente, se debe implementar ventilación forzada (extracción o insufición mecánica) para mantener atmósfera segura. La ventilación debe operar continuamente mientras haya personal dentro y hasta completar la purga posterior al trabajo.', 'abalturas' ); ?></p>
					<h3 class="!mt-6 text-lg font-semibold"><?php esc_html_e( 'Protección respiratoria y EPP', 'abalturas' ); ?></h3>
					<ul class="!mt-3 space-y-2 text-[15px] leading-relaxed text-slate-700">
						<li><?php esc_html_e( 'Arnés de cuerpo completo con línea de vida para entrantes cuando exista riesgo de caída o extracción en rescate.', 'abalturas' ); ?></li>
						<li><?php esc_html_e( 'Equipos de protección respiratoria (EPR) según evaluación: purificadores de aire, suministro de aire autónomo (SCBA) o líneas de aire.', 'abalturas' ); ?></li>
						<li><?php esc_html_e( 'Iluminación a prueba de explosión en atmósferas potencialmente inflamables.', 'abalturas' ); ?></li>
						<li><?php esc_html_e( 'Equipos de comunicación bidireccional entre entrantes y vigía.', 'abalturas' ); ?></li>
					</ul>
				</section>

				<section id="ec-emergencias" class="mt-8 rounded-xl border border-slate-100 bg-white px-6 py-8 shadow-sm sm:px-8">
					<h2 class="!mt-0 text-xl font-bold text-charcoal sm:text-2xl"><?php esc_html_e( 'Emergencias, rescate y simulacros', 'abalturas' ); ?></h2>
					<p class="!mt-4 text-[15px] leading-relaxed text-slate-700"><?php esc_html_e( 'El empleador debe contar con un plan de emergencia y rescate específico para cada espacio confinado o grupo de espacios similares. Elementos clave:', 'abalturas' ); ?></p>
					<ul class="!mt-4 space-y-2 text-[15px] leading-relaxed text-slate-700">
						<li><strong><?php esc_html_e( 'Equipo de rescate', 'abalturas' ); ?>:</strong> <?php esc_html_e( 'Personal entrenado disponible durante el trabajo; no se permite que el vigía ingrese solo al espacio.', 'abalturas' ); ?></li>
						<li><strong><?php esc_html_e( 'Equipos de rescate', 'abalturas' ); ?>:</strong> <?php esc_html_e( 'Trípodes, wenches, sistemas de extracción, EPR de rescate, botiquín y camilla cuando aplique.', 'abalturas' ); ?></li>
						<li><strong><?php esc_html_e( 'Prohibición de rescate impulsivo', 'abalturas' ); ?>:</strong> <?php esc_html_e( 'Solo personal capacitado y con EPP adecuado puede ingresar en rescate; el 60 % de víctimas en espacios confinados son rescatistas no preparados.', 'abalturas' ); ?></li>
						<li><strong><?php esc_html_e( 'Simulacros', 'abalturas' ); ?>:</strong> <?php esc_html_e( 'Ejercicios periódicos de rescate que validen tiempos de respuesta, comunicación y procedimientos.', 'abalturas' ); ?></li>
						<li><strong><?php esc_html_e( 'Coordinación externa', 'abalturas' ); ?>:</strong> <?php esc_html_e( 'Acuerdos con bomberos o servicios de emergencia cuando los recursos internos sean insuficientes.', 'abalturas' ); ?></li>
					</ul>
				</section>

				<section id="ec-obligaciones" class="mt-8 rounded-xl border border-slate-100 bg-white px-6 py-8 shadow-sm sm:px-8">
					<h2 class="!mt-0 text-xl font-bold text-charcoal sm:text-2xl"><?php esc_html_e( 'Obligaciones del empleador, trabajador y ARL', 'abalturas' ); ?></h2>
					<div class="not-prose mt-6 grid gap-6 md:grid-cols-2">
						<div class="rounded-xl border border-slate-100 bg-industrial/[0.04] px-5 py-5 shadow-sm">
							<h3 class="text-[15px] font-bold uppercase tracking-wide text-charcoal"><?php esc_html_e( 'Empleador', 'abalturas' ); ?></h3>
							<ul class="mt-4 space-y-2 text-[14px] leading-relaxed text-slate-700">
								<li><?php esc_html_e( 'Implementar y mantener el programa de gestión de espacios confinados.', 'abalturas' ); ?></li>
								<li><?php esc_html_e( 'Designar administrador, supervisores, vigías y proveer EPP sin costo al trabajador.', 'abalturas' ); ?></li>
								<li><?php esc_html_e( 'Garantizar capacitación inicial y reentrenamiento cada 3 años.', 'abalturas' ); ?></li>
								<li><?php esc_html_e( 'Proveer equipos de monitoreo, ventilación, comunicación y rescate.', 'abalturas' ); ?></li>
								<li><?php esc_html_e( 'Informar a la ARL sobre trabajos en espacios confinados y accidentes.', 'abalturas' ); ?></li>
								<li><?php esc_html_e( 'Verificar cumplimiento de contratistas y exigir permisos válidos.', 'abalturas' ); ?></li>
							</ul>
						</div>
						<div class="rounded-xl border border-slate-100 bg-slate-50/80 px-5 py-5 shadow-sm">
							<h3 class="text-[15px] font-bold uppercase tracking-wide text-charcoal"><?php esc_html_e( 'Trabajador', 'abalturas' ); ?></h3>
							<ul class="mt-4 space-y-2 text-[14px] leading-relaxed text-slate-700">
								<li><?php esc_html_e( 'Participar en capacitaciones y cumplir procedimientos autorizados.', 'abalturas' ); ?></li>
								<li><?php esc_html_e( 'Usar EPP y equipos de detección según instrucciones.', 'abalturas' ); ?></li>
								<li><?php esc_html_e( 'Mantener comunicación constante con el vigía.', 'abalturas' ); ?></li>
								<li><?php esc_html_e( 'Abandonar el espacio ante cualquier condición insegura o alarma.', 'abalturas' ); ?></li>
								<li><?php esc_html_e( 'Reportar condiciones peligrosas, incidentes y near-miss al supervisor.', 'abalturas' ); ?></li>
								<li><?php esc_html_e( 'No ingresar a espacios confinados sin permiso vigente.', 'abalturas' ); ?></li>
							</ul>
						</div>
					</div>
					<p class="!mt-6 text-[15px] leading-relaxed text-slate-700"><?php esc_html_e( 'La ARL debe asesorar en la evaluación de riesgos, verificar la implementación del programa durante visitas técnicas y acompañar la investigación de incidentes relacionados con espacios confinados.', 'abalturas' ); ?></p>
				</section>

				<section id="ec-fuentes" class="mt-10 rounded-xl border border-slate-800/10 bg-white px-6 py-8 shadow-sm sm:px-8">
					<h2 class="!mt-0 text-xl font-bold text-charcoal"><?php esc_html_e( 'Fuentes oficiales — Resolución 0491', 'abalturas' ); ?></h2>
					<ul class="!mt-4 space-y-2 text-[15px]">
						<li><a class="break-all font-medium" href="<?php echo esc_url( $res491_ref_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $res491_ref_url ); ?></a> — <?php esc_html_e( 'Gestor Normativo — Función Pública (texto completo).', 'abalturas' ); ?></li>
						<li><a class="break-all font-medium" href="<?php echo esc_url( $mnt_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $mnt_url ); ?></a> — <?php esc_html_e( 'Ministerio del Trabajo — orientaciones y registros.', 'abalturas' ); ?></li>
						<li><a class="break-all font-medium" href="<?php echo esc_url( $decr_1072_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $decr_1072_url ); ?></a> — <?php esc_html_e( 'Decreto 1072 de 2015 — SG-SST (marco integrador).', 'abalturas' ); ?></li>
					</ul>
					<p class="!mt-6 text-sm italic text-slate-600"><?php esc_html_e( 'Consulte siempre el texto oficial publicado en el Diario Oficial y valide interpretaciones con su asesor en SST.', 'abalturas' ); ?></p>
				</section>

				<section class="not-prose mt-14 rounded-2xl border border-slate-900/60 bg-charcoal px-6 py-10 text-center shadow-xl md:px-12">
					<h2 class="text-xl font-bold text-white sm:text-2xl"><?php esc_html_e( '¿Necesita equipos compatibles?', 'abalturas' ); ?></h2>
					<p class="mx-auto mt-3 max-w-2xl text-sm leading-relaxed text-slate-200 md:text-[15px]"><?php esc_html_e( 'En nuestra tienda encontrará elementos para trabajo en alturas y espacios confinados de marcas industriales avaladas. La selección debe validar compatibilidades y certificaciones con su coordinador SST.', 'abalturas' ); ?></p>
					<a href="<?php echo esc_url( $shop_url ); ?>" class="mt-8 inline-flex items-center rounded-lg bg-safety px-6 py-3 text-sm font-bold uppercase tracking-wide text-white hover:brightness-[1.05] focus-visible:outline focus-visible:ring-2 focus-visible:ring-safety"><?php esc_html_e( 'Ir a la tienda', 'abalturas' ); ?></a>
				</section>
			</div>
		</div>
	</div>
</main>
<script>
(function () {
	var ecIds = ['ec-concepto','ec-programa','ec-identificacion','ec-roles','ec-permiso','ec-controles','ec-emergencias','ec-obligaciones','ec-fuentes'];
	var taIds = ['concepto-trabajo-alturas','ambito-aplicacion','programa-cpp','roles-capacidad','medidas-prevencion','permiso-chequeo','reentrenamiento','sistemas-epp','obligaciones','vigencia-deroga','fuentes'];
	var mobileToc = document.querySelector('.abalturas-normativa-toc--mobile');
	var norm4272 = document.getElementById('toc-norm-4272');
	var norm0491 = document.getElementById('toc-norm-0491');

	function openNorm(id) {
		if (id === '0491' && norm0491) norm0491.open = true;
		if (id === '4272' && norm4272) norm4272.open = true;
		if (mobileToc) mobileToc.open = true;
	}

	function syncFromHash() {
		var hash = (window.location.hash || '').replace('#', '');
		if (!hash) return;
		document.querySelectorAll('.abalturas-normativa-toc__link, .abalturas-normativa-toc__norm-intro').forEach(function (el) {
			el.classList.toggle('is-active', el.getAttribute('href') === '#' + hash);
		});
		if (hash === 'res-0491' || ecIds.indexOf(hash) !== -1) openNorm('0491');
		else if (hash === 'res-4272' || taIds.indexOf(hash) !== -1) openNorm('4272');
	}

	document.querySelectorAll('.abalturas-normativa-toc__link, .abalturas-normativa-toc__norm-intro, .abalturas-normativa-hub__card').forEach(function (link) {
		link.addEventListener('click', function () {
			var href = link.getAttribute('href') || '';
			if (href.indexOf('#res-0491') === 0 || href.indexOf('#ec-') === 0) openNorm('0491');
			else if (href.indexOf('#res-4272') === 0 || href.indexOf('#concepto-') === 0 || href.indexOf('#ambito-') === 0 || href.indexOf('#programa-') === 0 || href.indexOf('#roles-') === 0 || href.indexOf('#medidas-') === 0 || href.indexOf('#permiso-') === 0 || href.indexOf('#reentrenamiento') === 0 || href.indexOf('#sistemas-') === 0 || href.indexOf('#obligaciones') === 0 || href.indexOf('#vigencia-') === 0 || href === '#fuentes') openNorm('4272');
			window.setTimeout(syncFromHash, 0);
		});
	});

	window.addEventListener('hashchange', syncFromHash);
	syncFromHash();
})();
</script>
