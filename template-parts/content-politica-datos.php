<?php
/**
 * Política de tratamiento de datos personales — Abalturas (ingeniería y seguridad en alturas).
 *
 * @package Abalturas
 */

defined( 'ABSPATH' ) || exit;

$shop_url          = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/tienda/' );
$sobre_nosotros_url = function_exists( 'abalturas_get_sobre_nosotros_page_url' ) ? abalturas_get_sobre_nosotros_page_url() : home_url( '/sobre-nosotros/' );
$updated           = __( '28 de mayo de 2026', 'abalturas' );

$sections = array(
	array(
		'icon'  => 'building',
		'title' => __( 'Responsable del tratamiento', 'abalturas' ),
		'text'  => __( 'Abalturas, empresa dedicada a ingeniería, suministro e instalación de sistemas de protección contra caídas, distribución de EPP y capacitación en seguridad en alturas, con domicilio en Colombia, actúa como responsable del tratamiento de los datos personales recopilados a través de este sitio web, canales de contacto, cotizaciones, tienda en línea y servicios de formación.', 'abalturas' ),
	),
	array(
		'icon'  => 'database',
		'title' => __( 'Datos que podemos recopilar', 'abalturas' ),
		'text'  => __( 'Identificación y contacto (nombre, documento, cargo, empresa, teléfono, correo, ciudad); datos comerciales y de facturación; información técnica de obra o proyecto; datos de pedidos en la tienda; registros de capacitación y asistencia a cursos; y datos de navegación básicos (cookies, IP, dispositivo) cuando utiliza el sitio.', 'abalturas' ),
	),
	array(
		'icon'  => 'target',
		'title' => __( 'Finalidades del tratamiento', 'abalturas' ),
		'text'  => __( 'Atender solicitudes de asesoría, cotización e ingeniería; gestionar ventas, entregas e instalaciones; inscribir y certificar procesos de capacitación; dar soporte postventa; cumplir obligaciones legales en SST y comercio; enviar información comercial solo si usted lo autoriza; y mejorar la experiencia y seguridad del sitio web.', 'abalturas' ),
	),
	array(
		'icon'  => 'scale',
		'title' => __( 'Base legal', 'abalturas' ),
		'text'  => __( 'El tratamiento se realiza conforme a la Ley 1581 de 2012, el Decreto 1377 de 2013 y demás normas aplicables en Colombia, con fundamento en la ejecución de contratos, el cumplimiento de obligaciones legales, el interés legítimo de Abalturas en atender consultas técnicas y, cuando corresponda, su consentimiento previo, expreso e informado.', 'abalturas' ),
	),
	array(
		'icon'  => 'user',
		'title' => __( 'Derechos del titular', 'abalturas' ),
		'text'  => __( 'Usted puede conocer, actualizar, rectificar y suprimir sus datos; revocar la autorización; y presentar consultas o reclamos ante Abalturas. Responderemos dentro de los plazos legales. Si no obtiene respuesta satisfactoria, podrá acudir a la Superintendencia de Industria y Comercio (SIC).', 'abalturas' ),
	),
	array(
		'icon'  => 'lock',
		'title' => __( 'Conservación y seguridad', 'abalturas' ),
		'text'  => __( 'Conservamos los datos solo el tiempo necesario para las finalidades descritas y las exigencias legales (incluida documentación de capacitaciones y proyectos en alturas). Aplicamos medidas técnicas, administrativas y humanas razonables para proteger la información contra acceso no autorizado, pérdida o uso indebido.', 'abalturas' ),
	),
	array(
		'icon'  => 'share',
		'title' => __( 'Transferencia y encargados', 'abalturas' ),
		'text'  => __( 'Podemos compartir datos con proveedores que nos apoyan en hosting, correo, pagos, logística, plataformas de formación o herramientas de gestión, siempre bajo deber de confidencialidad. No vendemos datos personales. Toda transferencia internacional, si ocurriera, se realizará cumpliendo la normativa colombiana.', 'abalturas' ),
	),
	array(
		'icon'  => 'cookie',
		'title' => __( 'Cookies y navegación', 'abalturas' ),
		'text'  => __( 'El sitio puede usar cookies técnicas y de analítica para funcionamiento, preferencias y estadísticas agregadas. Puede configurar su navegador para limitar o bloquear cookies; algunas funciones del sitio o de la tienda podrían verse afectadas.', 'abalturas' ),
	),
	array(
		'icon'  => 'mail',
		'title' => __( 'Consultas y actualizaciones', 'abalturas' ),
		'text'  => __( 'Para ejercer sus derechos o formular consultas sobre esta política, contáctenos por los teléfonos publicados en el pie de página o por los canales oficiales de Abalturas. Podemos actualizar este documento; la versión vigente estará siempre disponible en esta página con la fecha de última modificación.', 'abalturas' ),
	),
);
?>
<style id="abalturas-politica-datos">
	.abalturas-politica-datos__card {
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
	.abalturas-politica-datos__card:hover {
		transform: translateY(-2px);
		border-color: rgb(203 213 225 / 0.95);
		box-shadow: 0 4px 6px rgb(15 23 42 / 0.05), 0 16px 32px rgb(15 23 42 / 0.07);
	}
	.abalturas-politica-datos__card-icon {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 2.5rem;
		height: 2.5rem;
		border-radius: 0.65rem;
		background: rgb(26 54 93 / 0.08);
		color: #1a365d;
	}
	.abalturas-politica-datos__card-icon svg {
		width: 1.25rem;
		height: 1.25rem;
	}
	.abalturas-politica-datos__card-title {
		margin: 0.85rem 0 0;
		font-size: 1rem;
		font-weight: 700;
		line-height: 1.35;
		color: #1a202c;
	}
	.abalturas-politica-datos__card-text {
		margin: 0.5rem 0 0;
		font-size: 0.875rem;
		line-height: 1.65;
		color: rgb(71 85 105);
	}
	.abalturas-politica-datos__grid {
		display: grid;
		gap: 1rem;
		margin-top: 2rem;
	}
	@media (min-width: 640px) {
		.abalturas-politica-datos__grid {
			grid-template-columns: repeat(2, minmax(0, 1fr));
			gap: 1.25rem;
		}
	}
	@media (min-width: 1024px) {
		.abalturas-politica-datos__grid {
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
				<p class="text-[11px] font-bold uppercase tracking-[0.28em] text-safety"><?php esc_html_e( 'Protección de datos', 'abalturas' ); ?></p>
				<h1 class="text-3xl font-extrabold leading-tight tracking-tight md:text-[2.125rem]">
					<?php esc_html_e( 'Política de tratamiento de datos personales', 'abalturas' ); ?>
				</h1>
				<p class="text-base leading-relaxed text-slate-200/95 md:text-lg">
					<?php esc_html_e( 'Transparencia sobre cómo Abalturas recopila, usa y protege la información de clientes, trabajadores en formación y visitantes del sitio, en el marco de nuestros servicios de ingeniería y seguridad en alturas.', 'abalturas' ); ?>
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
				<?php esc_html_e( ' Esta política describe prácticas generales de privacidad. No sustituye asesoría jurídica especializada ni acuerdos contractuales específicos con su empresa.', 'abalturas' ); ?>
			</p>
		</div>

		<div class="abalturas-politica-datos__grid">
			<?php foreach ( $sections as $section ) : ?>
			<article class="abalturas-politica-datos__card">
				<span class="abalturas-politica-datos__card-icon" aria-hidden="true">
					<?php if ( 'building' === $section['icon'] ) : ?>
					<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M6 21V7l6-4 6 4v14M9 21v-6h6v6"/></svg>
					<?php elseif ( 'database' === $section['icon'] ) : ?>
					<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><ellipse cx="12" cy="5" rx="9" ry="3"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 5v14c0 1.66 4.03 3 9 3s9-1.34 9-3V5M3 12c0 1.66 4.03 3 9 3s9-1.34 9-3"/></svg>
					<?php elseif ( 'target' === $section['icon'] ) : ?>
					<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v3m0 12v3M3 12h3m12 0h3M5.636 5.636l2.121 2.121m8.486 8.486 2.121 2.121M5.636 18.364l2.121-2.121m8.486-8.486 2.121-2.121"/><circle cx="12" cy="12" r="3"/></svg>
					<?php elseif ( 'scale' === $section['icon'] ) : ?>
					<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M7 8h10M9 12h6M10 16h4"/></svg>
					<?php elseif ( 'user' === $section['icon'] ) : ?>
					<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0"/></svg>
					<?php elseif ( 'lock' === $section['icon'] ) : ?>
					<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
					<?php elseif ( 'share' === $section['icon'] ) : ?>
					<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186a2.25 2.25 0 0 1 2.186 0m2.186 0a2.25 2.25 0 0 0 2.186 0m-6.558 5.364a2.25 2.25 0 1 0 0-2.186m0 2.186a2.25 2.25 0 0 1-2.186 0m2.186 0a2.25 2.25 0 0 0-2.186 0"/></svg>
					<?php elseif ( 'cookie' === $section['icon'] ) : ?>
					<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v.01M12 12v.01M12 18v.01M8 8v.01M16 8v.01M8 16v.01M16 16v.01"/><circle cx="12" cy="12" r="9"/></svg>
					<?php else : ?>
					<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>
					<?php endif; ?>
				</span>
				<h2 class="abalturas-politica-datos__card-title"><?php echo esc_html( $section['title'] ); ?></h2>
				<p class="abalturas-politica-datos__card-text"><?php echo esc_html( $section['text'] ); ?></p>
			</article>
			<?php endforeach; ?>
		</div>

		<section class="mt-10 rounded-2xl border border-slate-200/90 bg-white px-6 py-8 text-center shadow-md sm:px-10 sm:py-10" aria-labelledby="politica-datos-cta-title">
			<h2 id="politica-datos-cta-title" class="text-lg font-extrabold text-charcoal sm:text-xl"><?php esc_html_e( '¿Necesita ejercer sus derechos o tiene dudas?', 'abalturas' ); ?></h2>
			<p class="mx-auto mt-3 max-w-2xl text-sm leading-relaxed text-slate-600 sm:text-base">
				<?php esc_html_e( 'Escríbanos o llámenos por los canales oficiales de contacto. Atenderemos su solicitud conforme a la Ley 1581 de 2012.', 'abalturas' ); ?>
			</p>
			<div class="mt-6 flex flex-wrap items-center justify-center gap-3">
				<a href="<?php echo esc_url( $sobre_nosotros_url ); ?>" class="inline-flex min-h-[2.875rem] items-center justify-center rounded-lg border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-charcoal transition hover:border-industrial/30 hover:text-industrial focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-industrial">
					<?php esc_html_e( 'Conocer Abalturas', 'abalturas' ); ?>
				</a>
				<a href="<?php echo esc_url( $shop_url ); ?>" class="inline-flex min-h-[2.875rem] items-center justify-center rounded-lg bg-industrial px-6 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-industrial/92 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-industrial">
					<?php esc_html_e( 'Ir a la tienda', 'abalturas' ); ?>
				</a>
			</div>
		</section>

	</div>
</main>
