<?php
/**
 * Términos y condiciones — Abalturas (ingeniería y seguridad en alturas).
 *
 * @package Abalturas
 */

defined( 'ABSPATH' ) || exit;

$shop_url            = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/tienda/' );
$sobre_nosotros_url  = function_exists( 'abalturas_get_sobre_nosotros_page_url' ) ? abalturas_get_sobre_nosotros_page_url() : home_url( '/sobre-nosotros/' );
$politica_datos_url  = function_exists( 'abalturas_get_politica_datos_page_url' ) ? abalturas_get_politica_datos_page_url() : home_url( '/politica-datos/' );
$updated             = __( '28 de mayo de 2026', 'abalturas' );

$sections = array(
	array(
		'icon'  => 'check',
		'title' => __( 'Aceptación de los términos', 'abalturas' ),
		'text'  => __( 'Al acceder a este sitio web, solicitar cotizaciones, comprar en la tienda o contratar servicios de Abalturas, usted declara haber leído y aceptado estos términos. Si no está de acuerdo, le recomendamos no utilizar el sitio ni nuestros canales comerciales.', 'abalturas' ),
	),
	array(
		'icon'  => 'wrench',
		'title' => __( 'Servicios ofrecidos', 'abalturas' ),
		'text'  => __( 'Abalturas presta servicios de ingeniería y asesoría en protección contra caídas, suministro e instalación de sistemas colectivos e individuales, distribución de EPP, y capacitación en seguridad en alturas. Las descripciones del sitio son orientativas; alcance, plazos y condiciones específicas se definirán en cotizaciones, órdenes de servicio o contratos firmados.', 'abalturas' ),
	),
	array(
		'icon'  => 'globe',
		'title' => __( 'Uso del sitio web', 'abalturas' ),
		'text'  => __( 'El usuario se compromete a utilizar el sitio de forma lícita, sin intentar vulnerar su seguridad, copiar contenidos de manera no autorizada ni usar la información con fines fraudulentos. Abalturas puede restringir el acceso ante usos indebidos o actividades que afecten la operación del sitio o de terceros.', 'abalturas' ),
	),
	array(
		'icon'  => 'cart',
		'title' => __( 'Tienda en línea y pedidos', 'abalturas' ),
		'text'  => __( 'Los productos publicados están sujetos a disponibilidad. Un pedido en línea constituye una oferta de compra que Abalturas podrá confirmar o rechazar. Especificaciones técnicas, certificaciones y usos recomendados de EPP deben verificarse antes de la operación en altura. El cliente es responsable de seleccionar el equipo adecuado a su riesgo y normativa aplicable.', 'abalturas' ),
	),
	array(
		'icon'  => 'layers',
		'title' => __( 'Ingeniería, instalación y obra', 'abalturas' ),
		'text'  => __( 'Los diseños, memorias de cálculo, instalaciones y supervisiones se ejecutan conforme a la información suministrada por el cliente y a la normativa vigente. Cambios en obra, condiciones no informadas o intervenciones de terceros pueden afectar el cumplimiento técnico. Cualquier modificación posterior debe ser evaluada y autorizada por personal competente.', 'abalturas' ),
	),
	array(
		'icon'  => 'cap',
		'title' => __( 'Capacitación y certificación', 'abalturas' ),
		'text'  => __( 'Los cursos y talleres tienen cupos, requisitos de ingreso y reglas de asistencia definidas al momento de la inscripción. La certificación depende del cumplimiento de los criterios del programa y no sustituye las responsabilidades del empleador en el SG-SST ni la autorización para realizar trabajos en altura sin las medidas exigidas por la ley.', 'abalturas' ),
	),
	array(
		'icon'  => 'payment',
		'title' => __( 'Precios, pagos y facturación', 'abalturas' ),
		'text'  => __( 'Los precios pueden actualizarse sin previo aviso en el sitio, pero regirán los valores confirmados al aceptar la cotización o el pedido. Los impuestos aplicables se facturan conforme a la normativa colombiana. Los plazos de pago, intereses por mora y medios de pago aceptados se informarán en cada operación comercial.', 'abalturas' ),
	),
	array(
		'icon'  => 'shield',
		'title' => __( 'Garantías y limitación de responsabilidad', 'abalturas' ),
		'text'  => __( 'Los productos y servicios se prestan con las garantías legales y comerciales aplicables. Abalturas no se hace responsable por daños derivados del uso incorrecto de equipos, incumplimiento de procedimientos de seguridad, falta de inspección periódica o operaciones realizadas sin competencia certificada. El contenido del sitio no reemplaza asesoría legal ni dictamen de autoridad competente en SST.', 'abalturas' ),
	),
	array(
		'icon'  => 'document',
		'title' => __( 'Propiedad intelectual y modificaciones', 'abalturas' ),
		'text'  => __( 'Marcas, textos, imágenes, diseños y materiales del sitio son propiedad de Abalturas o de sus licenciantes. Queda prohibida su reproducción no autorizada. Podemos modificar estos términos; la versión publicada en esta página prevalecerá. El tratamiento de datos personales se rige adicionalmente por nuestra política de privacidad.', 'abalturas' ),
	),
);
?>
<style id="abalturas-terminos">
	.abalturas-terminos__card {
		display: flex;
		flex-direction: column;
		height: 100%;
		border-radius: 1rem;
		border: 1px solid rgb(226 232 240 / 0.95);
		background: #fff;
		padding: 1.35rem 1.35rem 1.5rem;
		box-shadow: 0 1px 2px rgb(15 23 42 / 0.04), 0 8px 24px rgb(15 23 42 / 0.04);
		transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
	}
	.abalturas-terminos__card:hover {
		transform: translateY(-2px);
		border-color: rgb(203 213 225 / 0.95);
		box-shadow: 0 4px 6px rgb(15 23 42 / 0.05), 0 16px 32px rgb(15 23 42 / 0.07);
	}
	.abalturas-terminos__card-icon {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 2.5rem;
		height: 2.5rem;
		border-radius: 0.65rem;
		background: rgb(26 54 93 / 0.08);
		color: #1a365d;
	}
	.abalturas-terminos__card-icon svg {
		width: 1.25rem;
		height: 1.25rem;
	}
	.abalturas-terminos__card-title {
		margin: 0.85rem 0 0;
		font-size: 1rem;
		font-weight: 700;
		line-height: 1.35;
		color: #1a202c;
	}
	.abalturas-terminos__card-text {
		margin: 0.5rem 0 0;
		font-size: 0.875rem;
		line-height: 1.65;
		color: rgb(71 85 105);
	}
	.abalturas-terminos__grid {
		display: grid;
		gap: 1rem;
		margin-top: 2rem;
	}
	@media (min-width: 640px) {
		.abalturas-terminos__grid {
			grid-template-columns: repeat(2, minmax(0, 1fr));
			gap: 1.25rem;
		}
	}
	@media (min-width: 1024px) {
		.abalturas-terminos__grid {
			grid-template-columns: repeat(3, minmax(0, 1fr));
			gap: 1.5rem;
		}
	}
</style>
<main id="abalturas-main" class="relative bg-gradient-to-b from-mist via-white to-mist/80 pb-20 pt-10 text-slate-800 md:pb-28 md:pt-14" tabindex="-1">
	<div class="w-full">

		<header class="relative overflow-hidden rounded-2xl border border-slate-200/90 bg-charcoal px-6 py-10 text-white shadow-xl sm:px-10 sm:py-12">
			<div class="pointer-events-none absolute -right-20 -top-24 h-72 w-72 rounded-full bg-safety/20 blur-3xl" aria-hidden="true"></div>
			<div class="pointer-events-none absolute -bottom-28 -left-16 h-56 w-56 rounded-full bg-industrial/35 blur-3xl" aria-hidden="true"></div>
			<div class="relative max-w-3xl space-y-4">
				<p class="text-[11px] font-bold uppercase tracking-[0.28em] text-safety"><?php esc_html_e( 'Condiciones de uso', 'abalturas' ); ?></p>
				<h1 class="text-3xl font-extrabold leading-tight tracking-tight md:text-[2.125rem]">
					<?php esc_html_e( 'Términos y condiciones', 'abalturas' ); ?>
				</h1>
				<p class="text-base leading-relaxed text-slate-200/95 md:text-lg">
					<?php esc_html_e( 'Reglas generales para el uso del sitio web, la tienda en línea y los servicios de ingeniería, suministro, instalación y capacitación en seguridad en alturas ofrecidos por Abalturas.', 'abalturas' ); ?>
				</p>
				<p class="text-sm text-white/70">
					<?php
					printf(
						/* translators: %s: last updated date */
						esc_html__( 'Última actualización: %s', 'abalturas' ),
						esc_html( $updated )
					);
					?>
				</p>
			</div>
		</header>

		<div class="mt-8 rounded-xl border border-amber-200/90 bg-amber-50 px-5 py-4 text-sm text-amber-950 shadow-sm">
			<p class="leading-relaxed">
				<strong><?php esc_html_e( 'Documento informativo.', 'abalturas' ); ?></strong>
				<?php esc_html_e( ' Estos términos establecen condiciones generales. Las operaciones comerciales pueden incluir acuerdos específicos que prevalezcan sobre lo aquí indicado. Revíselos con su asesor legal si lo requiere.', 'abalturas' ); ?>
			</p>
		</div>

		<div class="abalturas-terminos__grid">
			<?php foreach ( $sections as $section ) : ?>
			<article class="abalturas-terminos__card">
				<span class="abalturas-terminos__card-icon" aria-hidden="true">
					<?php if ( 'check' === $section['icon'] ) : ?>
					<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
					<?php elseif ( 'wrench' === $section['icon'] ) : ?>
					<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17 4.495 8.245a2.25 2.25 0 0 1 0-3.182l1.318-1.318a2.25 2.25 0 0 1 3.182 0L15.75 9.75"/></svg>
					<?php elseif ( 'globe' === $section['icon'] ) : ?>
					<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5a17.92 17.92 0 0 1-8.716-2.247m0 0A8.966 8.966 0 0 1 3 12c0-1.264.26-2.467.732-3.562"/></svg>
					<?php elseif ( 'cart' === $section['icon'] ) : ?>
					<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/></svg>
					<?php elseif ( 'layers' === $section['icon'] ) : ?>
					<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3"/></svg>
					<?php elseif ( 'cap' === $section['icon'] ) : ?>
					<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342"/></svg>
					<?php elseif ( 'payment' === $section['icon'] ) : ?>
					<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"/></svg>
					<?php elseif ( 'shield' === $section['icon'] ) : ?>
					<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
					<?php else : ?>
					<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
					<?php endif; ?>
				</span>
				<h2 class="abalturas-terminos__card-title"><?php echo esc_html( $section['title'] ); ?></h2>
				<p class="abalturas-terminos__card-text"><?php echo esc_html( $section['text'] ); ?></p>
			</article>
			<?php endforeach; ?>
		</div>

		<section class="mt-10 rounded-2xl border border-slate-200/90 bg-white px-6 py-8 text-center shadow-md sm:px-10 sm:py-10" aria-labelledby="terminos-cta-title">
			<h2 id="terminos-cta-title" class="text-lg font-extrabold text-charcoal sm:text-xl"><?php esc_html_e( '¿Tiene preguntas sobre estos términos?', 'abalturas' ); ?></h2>
			<p class="mx-auto mt-3 max-w-2xl text-sm leading-relaxed text-slate-600 sm:text-base">
				<?php esc_html_e( 'Contáctenos por los canales oficiales. También puede consultar nuestra política de tratamiento de datos personales.', 'abalturas' ); ?>
			</p>
			<div class="mt-6 flex flex-wrap items-center justify-center gap-3">
				<a href="<?php echo esc_url( $politica_datos_url ); ?>" class="inline-flex min-h-[2.875rem] items-center justify-center rounded-lg border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-charcoal transition hover:border-industrial/30 hover:text-industrial focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-industrial">
					<?php esc_html_e( 'Política de datos', 'abalturas' ); ?>
				</a>
				<a href="<?php echo esc_url( $shop_url ); ?>" class="inline-flex min-h-[2.875rem] items-center justify-center rounded-lg bg-industrial px-6 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-industrial/92 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-industrial">
					<?php esc_html_e( 'Ir a la tienda', 'abalturas' ); ?>
				</a>
			</div>
		</section>

	</div>
</main>
