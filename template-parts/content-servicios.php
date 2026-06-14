<?php
/**
 * Página Servicios — galería en carrusel y secciones por servicio.
 *
 * @package Abalturas
 */

defined( 'ABSPATH' ) || exit;

$normativa_url       = function_exists( 'abalturas_get_normativa_res4272_page_url' ) ? abalturas_get_normativa_res4272_page_url() : home_url( '/normatividad-trabajo-alturas/' );
$whatsapp_technical  = function_exists( 'abalturas_get_whatsapp_url' ) ? abalturas_get_whatsapp_url( 'technical', __( 'Hola, quiero información sobre los servicios de Abalturas.', 'abalturas' ) ) : 'https://wa.me/573215607926';
$whatsapp_commercial = function_exists( 'abalturas_get_whatsapp_url' ) ? abalturas_get_whatsapp_url( 'commercial', __( 'Hola, quiero cotizar un servicio de Abalturas.', 'abalturas' ) ) : 'https://wa.me/573027782299';

$servicios_assets_url = trailingslashit( get_stylesheet_directory_uri() ) . 'assets/servicios/';
$servicios_assets_dir = trailingslashit( get_stylesheet_directory() ) . 'assets/servicios/';

/**
 * @param string $filename Nombre de archivo en assets/servicios/.
 */
$svc_media_url = static function ( string $filename ) use ( $servicios_assets_url, $servicios_assets_dir ): string {
	if ( file_exists( $servicios_assets_dir . $filename ) ) {
		return $servicios_assets_url . $filename;
	}
	return '';
};

/**
 * Imprime un carrusel de medios (imágenes o video).
 *
 * @param array<int, array<string, string>> $slides type, src, alt, tag, title, poster.
 * @param array<string, string|int>         $args   modifier, autoplay, autoplay_video, label.
 */
$render_carousel = static function ( array $slides, array $args = array() ) {
	$slides = array_values(
		array_filter(
			$slides,
			static function ( $slide ) {
				return ! empty( $slide['src'] );
			}
		)
	);

	if ( empty( $slides ) ) {
		return;
	}

	$modifier          = isset( $args['modifier'] ) ? (string) $args['modifier'] : '';
	$autoplay          = isset( $args['autoplay'] ) ? (int) $args['autoplay'] : 0;
	$autoplay_inview   = isset( $args['autoplay_inview'] ) ? (int) $args['autoplay_inview'] : 0;
	$autoplay_video    = ! empty( $args['autoplay_video'] ) ? '1' : '0';
	$label             = isset( $args['label'] ) ? (string) $args['label'] : __( 'Galería de servicios', 'abalturas' );
	$single            = count( $slides ) === 1;
	$slide_count_label = (string) count( $slides );

	$classes = trim( 'ab-svc-carousel ' . $modifier );
	?>
	<div
		class="<?php echo esc_attr( $classes ); ?>"
		data-ab-servicios-carousel
		<?php echo $autoplay > 0 ? ' data-autoplay="' . esc_attr( (string) $autoplay ) . '"' : ''; ?>
		<?php echo $autoplay_inview > 0 ? ' data-autoplay-inview="' . esc_attr( (string) $autoplay_inview ) . '"' : ''; ?>
		<?php echo ' data-autoplay-video="' . esc_attr( $autoplay_video ) . '"'; ?>
		<?php echo ' data-slide-count="' . esc_attr( $slide_count_label ) . '"'; ?>
		role="region"
		aria-roledescription="<?php echo esc_attr__( 'carrusel', 'abalturas' ); ?>"
		aria-label="<?php echo esc_attr( $label ); ?>"
		tabindex="0"
	>
		<?php if ( ! $single ) : ?>
		<div class="ab-svc-carousel__chrome" aria-hidden="true">
			<?php if ( $autoplay > 0 || $autoplay_inview > 0 ) : ?>
			<div class="ab-svc-carousel__progress" data-ab-svc-progress></div>
			<?php endif; ?>
			<span class="ab-svc-carousel__counter" data-ab-svc-counter>1 / <?php echo esc_html( $slide_count_label ); ?></span>
		</div>
		<?php endif; ?>
		<div class="ab-svc-carousel__viewport">
			<div class="ab-svc-carousel__track">
				<?php foreach ( $slides as $i => $slide ) : ?>
				<figure class="ab-svc-carousel__slide" aria-hidden="<?php echo 0 === $i ? 'false' : 'true'; ?>">
					<?php if ( 'video' === ( $slide['type'] ?? 'image' ) ) : ?>
					<video
						class="ab-svc-carousel__media"
						controls
						playsinline
						preload="metadata"
						<?php echo ! empty( $slide['poster'] ) ? 'poster="' . esc_url( $slide['poster'] ) . '"' : ''; ?>
					>
						<source src="<?php echo esc_url( $slide['src'] ); ?>" type="video/mp4"/>
					</video>
					<?php else : ?>
					<img
						class="ab-svc-carousel__media"
						src="<?php echo esc_url( $slide['src'] ); ?>"
						alt="<?php echo esc_attr( $slide['alt'] ?? '' ); ?>"
						loading="<?php echo 0 === $i ? 'eager' : 'lazy'; ?>"
						decoding="async"
						width="1200"
						height="900"
					/>
					<?php endif; ?>
					<?php if ( ! empty( $slide['tag'] ) || ! empty( $slide['title'] ) ) : ?>
					<figcaption class="ab-svc-carousel__caption">
						<?php if ( ! empty( $slide['tag'] ) ) : ?>
						<span class="ab-svc-carousel__tag"><?php echo esc_html( $slide['tag'] ); ?></span>
						<?php endif; ?>
						<?php if ( ! empty( $slide['title'] ) ) : ?>
						<p class="ab-svc-carousel__title"><?php echo esc_html( $slide['title'] ); ?></p>
						<?php endif; ?>
					</figcaption>
					<?php endif; ?>
				</figure>
				<?php endforeach; ?>
			</div>
		</div>
		<?php if ( ! $single ) : ?>
		<button type="button" class="ab-svc-carousel__btn ab-svc-carousel__btn--prev" aria-label="<?php esc_attr_e( 'Anterior', 'abalturas' ); ?>">
			<svg fill="none" stroke="currentColor" stroke-width="2.25" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
		</button>
		<button type="button" class="ab-svc-carousel__btn ab-svc-carousel__btn--next" aria-label="<?php esc_attr_e( 'Siguiente', 'abalturas' ); ?>">
			<svg fill="none" stroke="currentColor" stroke-width="2.25" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
		</button>
		<div class="ab-svc-carousel__footer">
			<div class="ab-svc-carousel__dots" role="tablist" aria-label="<?php echo esc_attr__( 'Diapositivas', 'abalturas' ); ?>"></div>
		</div>
		<span class="ab-svc-carousel__live sr-only" aria-live="polite" aria-atomic="true"></span>
		<?php endif; ?>
	</div>
	<?php
};

$nav_items = array(
	array( 'id' => 'galeria', 'label' => __( 'Galería', 'abalturas' ) ),
	array( 'id' => 'proyectos', 'label' => __( 'Proyectos', 'abalturas' ) ),
	array( 'id' => 'instalacion', 'label' => __( 'Instalación', 'abalturas' ) ),
	array( 'id' => 'inspeccion', 'label' => __( 'Inspección', 'abalturas' ) ),
	array( 'id' => 'capacitaciones', 'label' => __( 'Capacitaciones', 'abalturas' ) ),
	array( 'id' => 'ingenieria', 'label' => __( 'Ingeniería', 'abalturas' ) ),
);

$hero_gallery = array(
	array(
		'type'  => 'image',
		'src'   => $svc_media_url( 'supervisiones.jpeg' ),
		'alt'   => __( 'Supervisión de trabajos en fachada con plataforma suspendida', 'abalturas' ),
		'tag'   => __( 'Supervisión', 'abalturas' ),
		'title' => __( 'Acompañamiento en obra de gran altura y cumplimiento normativo.', 'abalturas' ),
	),
	array(
		'type'  => 'image',
		'src'   => $svc_media_url( 'proyecto.jpeg' ),
		'alt'   => __( 'Técnico en acceso por cuerdas en entorno industrial', 'abalturas' ),
		'tag'   => __( 'Proyectos', 'abalturas' ),
		'title' => __( 'Soluciones de protección contra caídas en infraestructura industrial.', 'abalturas' ),
	),
	array(
		'type'  => 'image',
		'src'   => $svc_media_url( 'personal.jpeg' ),
		'alt'   => __( 'Instructores con arnés y equipos de protección contra caídas', 'abalturas' ),
		'tag'   => __( 'Capacitación', 'abalturas' ),
		'title' => __( 'Formación práctica con instructores certificados y EPP real.', 'abalturas' ),
	),
	array(
		'type'  => 'image',
		'src'   => $svc_media_url( 'supervision.jpeg' ),
		'alt'   => __( 'Inspección técnica de cable de acero con equipo digital', 'abalturas' ),
		'tag'   => __( 'Inspección', 'abalturas' ),
		'title' => __( 'Evaluación documentada de líneas, cables y sistemas de anclaje.', 'abalturas' ),
	),
	array(
		'type'  => 'image',
		'src'   => $svc_media_url( 'intalacionGuias.jpeg' ),
		'alt'   => __( 'Instalación de guías y sistemas en cubierta con arnés', 'abalturas' ),
		'tag'   => __( 'Instalación', 'abalturas' ),
		'title' => __( 'Montaje seguro de sistemas en cubiertas y estructuras metálicas.', 'abalturas' ),
	),
	array(
		'type'  => 'image',
		'src'   => $svc_media_url( 'supervisionalturasena.jpeg' ),
		'alt'   => __( 'Equipo técnico ensamblando estructura metálica en centro de formación', 'abalturas' ),
		'tag'   => __( 'Capacitación', 'abalturas' ),
		'title' => __( 'Práctica supervisada en estructuras y montaje de sistemas.', 'abalturas' ),
	),
	array(
		'type'  => 'image',
		'src'   => $svc_media_url( 'ingenieria.jpeg' ),
		'alt'   => __( 'Ingeniería en sitio: revisión técnica en obra', 'abalturas' ),
		'tag'   => __( 'Ingeniería', 'abalturas' ),
		'title' => __( 'Diagnóstico y asesoría técnica en campo con equipo especializado.', 'abalturas' ),
	),
);

$services = array(
	array(
		'id'       => 'proyectos',
		'eyebrow'  => __( 'Diseño y ejecución', 'abalturas' ),
		'title'    => __( 'Proyectos de protección contra caídas', 'abalturas' ),
		'intro'    => __( 'Diseñamos e implementamos soluciones integrales para obras, industria y espacios confinados, alineadas a normativa colombiana e internacional.', 'abalturas' ),
		'bullets'  => array(
			__( 'Levantamiento técnico y diagnóstico de riesgo en alturas.', 'abalturas' ),
			__( 'Diseño de sistemas colectivos e individuales según el entorno de trabajo.', 'abalturas' ),
			__( 'Documentación técnica, planos y soporte para auditorías SST.', 'abalturas' ),
			__( 'Acompañamiento en obra desde la planeación hasta la puesta en marcha.', 'abalturas' ),
		),
		'gallery'  => array(
			array( 'type' => 'image', 'src' => $svc_media_url( 'proyecto.jpeg' ), 'alt' => __( 'Acceso por cuerdas en planta industrial', 'abalturas' ), 'tag' => __( 'Proyectos', 'abalturas' ), 'title' => __( 'Intervención en altura con equipos certificados.', 'abalturas' ) ),
			array( 'type' => 'image', 'src' => $svc_media_url( 'proyectoZ.jpeg' ), 'alt' => __( 'Montaje de sistema de protección contra caídas en vía pública', 'abalturas' ), 'tag' => __( 'Proyectos', 'abalturas' ), 'title' => __( 'Implementación de equipos y tripodes de rescate.', 'abalturas' ) ),
			array( 'type' => 'image', 'src' => $svc_media_url( 'ingenieria.jpeg' ), 'alt' => __( 'Equipo técnico en revisión de obra', 'abalturas' ), 'tag' => __( 'Proyectos', 'abalturas' ), 'title' => __( 'Coordinación en sitio con personal de obra.', 'abalturas' ) ),
			array( 'type' => 'image', 'src' => $svc_media_url( 'supervisioneinstalacion.jpeg' ), 'alt' => __( 'Supervisión de instalación en plataforma elevada', 'abalturas' ), 'tag' => __( 'Proyectos', 'abalturas' ), 'title' => __( 'Control de calidad durante la ejecución.', 'abalturas' ) ),
		),
		'reverse'  => false,
	),
	array(
		'id'       => 'instalacion',
		'eyebrow'  => __( 'Puesta en servicio', 'abalturas' ),
		'title'    => __( 'Instalación de sistemas certificados', 'abalturas' ),
		'intro'    => __( 'Montaje profesional de barandas, redes, líneas de vida, anclajes y equipos de protección individual, con trazabilidad y cumplimiento normativo.', 'abalturas' ),
		'bullets'  => array(
			__( 'Instalación de protección colectiva en cubiertas, fachadas y estructuras.', 'abalturas' ),
			__( 'Montaje de líneas de vida horizontales y verticales.', 'abalturas' ),
			__( 'Suministro e instalación de anclajes y conectores certificados.', 'abalturas' ),
			__( 'Entrega con acta, recomendaciones de uso y mantenimiento.', 'abalturas' ),
		),
		'gallery'  => array(
			array( 'type' => 'image', 'src' => $svc_media_url( 'instalacion.jpeg' ), 'alt' => __( 'Instalación industrial con arnés en nave', 'abalturas' ), 'tag' => __( 'Instalación', 'abalturas' ), 'title' => __( 'Trabajo seguro en estructuras industriales.', 'abalturas' ) ),
			array( 'type' => 'image', 'src' => $svc_media_url( 'instalacioneingenieria.jpeg' ), 'alt' => __( 'Instalación con acceso por cuerdas en torre', 'abalturas' ), 'tag' => __( 'Instalación', 'abalturas' ), 'title' => __( 'Acceso técnico en torres y estructuras elevadas.', 'abalturas' ) ),
			array( 'type' => 'image', 'src' => $svc_media_url( 'instlacionGuiaTecho.jpeg' ), 'alt' => __( 'Instalación de guías en cubierta metálica', 'abalturas' ), 'tag' => __( 'Instalación', 'abalturas' ), 'title' => __( 'Sistemas en cubiertas con línea de vida.', 'abalturas' ) ),
			array( 'type' => 'image', 'src' => $svc_media_url( 'intalacionGuias.jpeg' ), 'alt' => __( 'Soldadura e instalación en techo con arnés', 'abalturas' ), 'tag' => __( 'Instalación', 'abalturas' ), 'title' => __( 'Anclajes y guías en cubierta.', 'abalturas' ) ),
			array( 'type' => 'image', 'src' => $svc_media_url( 'instalaciontorre.jpeg' ), 'alt' => __( 'Montaje de estructura junto a torre de comunicaciones', 'abalturas' ), 'tag' => __( 'Instalación', 'abalturas' ), 'title' => __( 'Ensamble de componentes en sitio.', 'abalturas' ) ),
		),
		'reverse'  => true,
	),
	array(
		'id'       => 'inspeccion',
		'eyebrow'  => __( 'Cumplimiento y continuidad', 'abalturas' ),
		'title'    => __( 'Inspección y mantenimiento', 'abalturas' ),
		'intro'    => __( 'Verificamos el estado de sus sistemas y equipos para garantizar que sigan aptos, documentados y alineados a las exigencias de seguridad en alturas.', 'abalturas' ),
		'bullets'  => array(
			__( 'Inspección periódica de líneas de vida, anclajes y estructuras.', 'abalturas' ),
			__( 'Revisión de EPP: arneses, eslingas, absorbedores y conectores.', 'abalturas' ),
			__( 'Informes técnicos con hallazgos, recomendaciones y plan de acción.', 'abalturas' ),
			__( 'Apoyo para preparar auditorías y requerimientos de ARL o cliente.', 'abalturas' ),
		),
		'gallery'  => array(
			array( 'type' => 'image', 'src' => $svc_media_url( 'supervision.jpeg' ), 'alt' => __( 'Inspección digital de cable de acero', 'abalturas' ), 'tag' => __( 'Inspección', 'abalturas' ), 'title' => __( 'Evaluación técnica con registro documentado.', 'abalturas' ) ),
			array( 'type' => 'image', 'src' => $svc_media_url( 'supervisiones.jpeg' ), 'alt' => __( 'Supervisión en edificación en altura', 'abalturas' ), 'tag' => __( 'Inspección', 'abalturas' ), 'title' => __( 'Control en fachadas y trabajos suspendidos.', 'abalturas' ) ),
			array( 'type' => 'image', 'src' => $svc_media_url( 'supervisioneinstalacion.jpeg' ), 'alt' => __( 'Supervisión de montaje en plataforma', 'abalturas' ), 'tag' => __( 'Inspección', 'abalturas' ), 'title' => __( 'Verificación durante instalación de estructuras.', 'abalturas' ) ),
		),
		'reverse'  => false,
	),
	array(
		'id'       => 'capacitaciones',
		'eyebrow'  => __( 'Formación en campo', 'abalturas' ),
		'title'    => __( 'Capacitaciones en seguridad en alturas', 'abalturas' ),
		'intro'    => __( 'Programas de formación para trabajadores, supervisores y brigadas, con enfoque práctico y cultura de prevención.', 'abalturas' ),
		'bullets'  => array(
			__( 'Trabajo seguro en alturas y uso correcto de EPP.', 'abalturas' ),
			__( 'Manejo de emergencias, rescate y primeros auxilios en altura.', 'abalturas' ),
			__( 'Inducción SST y refuerzo de competencias para cuadrillas.', 'abalturas' ),
			__( 'Metodología cercana, con ejercicios prácticos y seguimiento.', 'abalturas' ),
		),
		'gallery'  => array(
			array( 'type' => 'image', 'src' => $svc_media_url( 'personal.jpeg' ), 'alt' => __( 'Instructores con equipos de protección contra caídas', 'abalturas' ), 'tag' => __( 'Capacitación', 'abalturas' ), 'title' => __( 'Instructores con experiencia en altura.', 'abalturas' ) ),
			array( 'type' => 'image', 'src' => $svc_media_url( 'supervisionalturasena.jpeg' ), 'alt' => __( 'Práctica de ensamble de estructura en formación', 'abalturas' ), 'tag' => __( 'Capacitación', 'abalturas' ), 'title' => __( 'Ejercicios supervisados en estructuras metálicas.', 'abalturas' ) ),
			array( 'type' => 'image', 'src' => $svc_media_url( 'supervisionSena.jpeg' ), 'alt' => __( 'Capacitación técnica en andamios y estructuras', 'abalturas' ), 'tag' => __( 'Capacitación', 'abalturas' ), 'title' => __( 'Formación práctica con estándares de seguridad.', 'abalturas' ) ),
			array( 'type' => 'image', 'src' => $svc_media_url( 'instalaciontorre.jpeg' ), 'alt' => __( 'Entrenamiento en sitio con torre de comunicaciones', 'abalturas' ), 'tag' => __( 'Capacitación', 'abalturas' ), 'title' => __( 'Aprendizaje en entorno real de trabajo.', 'abalturas' ) ),
		),
		'reverse'  => true,
	),
	array(
		'id'       => 'ingenieria',
		'eyebrow'  => __( 'Asesoría especializada', 'abalturas' ),
		'title'    => __( 'Ingeniería y asesoría técnica', 'abalturas' ),
		'intro'    => __( 'Acompañamos a empresas y contratistas en la toma de decisiones técnicas, selección de equipos y cumplimiento normativo en cada etapa del proyecto.', 'abalturas' ),
		'bullets'  => array(
			__( 'Asesoría en selección de sistemas y equipos certificados.', 'abalturas' ),
			__( 'Revisión de procedimientos, permisos de trabajo y matrices de riesgo.', 'abalturas' ),
			__( 'Soporte en interpretación de normatividad (Res. 4272, 0491 y estándares).', 'abalturas' ),
			__( 'Cotizaciones técnicas y acompañamiento comercial personalizado.', 'abalturas' ),
		),
		'gallery'  => array(
			array( 'type' => 'image', 'src' => $svc_media_url( 'ingenieria.jpeg' ), 'alt' => __( 'Ingeniería y revisión técnica en obra', 'abalturas' ), 'tag' => __( 'Ingeniería', 'abalturas' ), 'title' => __( 'Diagnóstico y levantamiento en sitio.', 'abalturas' ) ),
			array( 'type' => 'image', 'src' => $svc_media_url( 'instalacioneingenieria.jpeg' ), 'alt' => __( 'Ingeniería de acceso en torre', 'abalturas' ), 'tag' => __( 'Ingeniería', 'abalturas' ), 'title' => __( 'Soluciones para infraestructura elevada.', 'abalturas' ) ),
			array( 'type' => 'image', 'src' => $svc_media_url( 'proyecto.jpeg' ), 'alt' => __( 'Proyecto industrial con acceso por cuerdas', 'abalturas' ), 'tag' => __( 'Ingeniería', 'abalturas' ), 'title' => __( 'Planificación de intervenciones en altura.', 'abalturas' ) ),
		),
		'reverse'  => false,
	),
);
?>
<style id="abalturas-servicios">
	.abalturas-servicios-nav {
		display: flex;
		flex-wrap: wrap;
		gap: 0.5rem;
		margin-top: 1.75rem;
	}
	.abalturas-servicios-nav__link {
		display: inline-flex;
		align-items: center;
		min-height: 2.25rem;
		padding: 0.35rem 0.9rem;
		border-radius: 9999px;
		border: 1px solid rgb(226 232 240);
		background: #fff;
		color: #1a365d;
		font-size: 0.75rem;
		font-weight: 700;
		letter-spacing: 0.06em;
		text-transform: uppercase;
		text-decoration: none;
		transition: border-color 0.2s ease, background 0.2s ease, color 0.2s ease;
	}
	.abalturas-servicios-nav__link:hover,
	.abalturas-servicios-nav__link:focus-visible {
		border-color: rgb(245 101 35 / 0.45);
		background: rgb(245 101 35 / 0.08);
		color: #c05621;
	}
	.abalturas-servicios-section {
		scroll-margin-top: 7rem;
		padding-top: 3.5rem;
	}
	@media (min-width: 1024px) {
		.abalturas-servicios-section {
			scroll-margin-top: 8.5rem;
		}
	}
	.abalturas-servicios-section__grid {
		display: grid;
		gap: 2rem;
		align-items: center;
	}
	@media (min-width: 1024px) {
		.abalturas-servicios-section__grid {
			grid-template-columns: repeat(2, minmax(0, 1fr));
			gap: 3rem;
		}
		.abalturas-servicios-section__grid--reverse .abalturas-servicios-section__media {
			order: 2;
		}
		.abalturas-servicios-section__grid--reverse .abalturas-servicios-section__body {
			order: 1;
		}
	}
	.abalturas-servicios-section__list {
		margin: 1.25rem 0 0;
		padding: 0;
		list-style: none;
	}
	.abalturas-servicios-section__list li {
		position: relative;
		padding-left: 1.35rem;
		font-size: 0.9375rem;
		line-height: 1.6;
		color: rgb(71 85 105);
	}
	.abalturas-servicios-section__list li + li {
		margin-top: 0.65rem;
	}
	.abalturas-servicios-section__list li::before {
		content: "";
		position: absolute;
		left: 0;
		top: 0.55rem;
		width: 0.45rem;
		height: 0.45rem;
		border-radius: 9999px;
		background: #f56523;
	}
	#galeria {
		scroll-margin-top: 7rem;
	}
	@media (min-width: 1024px) {
		#galeria {
			scroll-margin-top: 8.5rem;
		}
	}
</style>
<main id="abalturas-main" class="relative bg-gradient-to-b from-mist via-white to-mist/80 pb-20 pt-10 text-slate-800 md:pb-28 md:pt-14" tabindex="-1">

	<div class="w-full">

		<header class="relative overflow-hidden rounded-2xl border border-slate-200/90 bg-charcoal px-6 py-10 text-white shadow-xl sm:px-10 sm:py-12">
			<div class="pointer-events-none absolute -right-20 -top-24 h-72 w-72 rounded-full bg-safety/20 blur-3xl" aria-hidden="true"></div>
			<div class="pointer-events-none absolute -bottom-28 -left-16 h-56 w-56 rounded-full bg-industrial/35 blur-3xl" aria-hidden="true"></div>
			<div class="relative max-w-3xl space-y-4">
				<p class="text-[11px] font-bold uppercase tracking-[0.28em] text-safety"><?php esc_html_e( 'Abalturas', 'abalturas' ); ?></p>
				<h1 class="text-3xl font-extrabold leading-tight tracking-tight md:text-[2.125rem]">
					<?php esc_html_e( 'Servicios de ingeniería y seguridad en alturas', 'abalturas' ); ?>
				</h1>
				<p class="text-base leading-relaxed text-slate-200/95 md:text-lg">
					<?php esc_html_e( 'Proyectos, instalación, inspección, capacitaciones y asesoría técnica para prevenir caídas y cumplir normativa en Colombia.', 'abalturas' ); ?>
				</p>
			</div>
			<nav class="abalturas-servicios-nav" aria-label="<?php esc_attr_e( 'Secciones de servicios', 'abalturas' ); ?>">
				<?php foreach ( $nav_items as $item ) : ?>
				<a class="abalturas-servicios-nav__link" href="#<?php echo esc_attr( $item['id'] ); ?>">
					<?php echo esc_html( $item['label'] ); ?>
				</a>
				<?php endforeach; ?>
			</nav>
		</header>

		<section id="galeria" class="ab-svc-gallery-intro" aria-labelledby="abalturas-servicios-galeria-title">
			<h2 id="abalturas-servicios-galeria-title" class="ab-svc-gallery-intro__title">
				<?php esc_html_e( 'Nuestro trabajo en campo', 'abalturas' ); ?>
			</h2>
			<p class="ab-svc-gallery-intro__text">
				<?php esc_html_e( 'Registro real de proyectos, instalaciones, inspecciones y capacitaciones ejecutadas por el equipo Abalturas.', 'abalturas' ); ?>
			</p>
			<?php
			$render_carousel(
				$hero_gallery,
				array(
					'modifier' => 'ab-svc-carousel--hero',
					'autoplay' => 7000,
					'label'    => __( 'Galería principal de servicios', 'abalturas' ),
				)
			);
			?>
		</section>

		<?php foreach ( $services as $service ) : ?>
		<section
			id="<?php echo esc_attr( $service['id'] ); ?>"
			class="abalturas-servicios-section<?php echo $service['reverse'] ? ' abalturas-servicios-section--reverse' : ''; ?>"
			aria-labelledby="servicio-<?php echo esc_attr( $service['id'] ); ?>-title"
		>
			<div class="abalturas-servicios-section__grid<?php echo $service['reverse'] ? ' abalturas-servicios-section__grid--reverse' : ''; ?>">
				<div class="abalturas-servicios-section__media">
					<?php
					$render_carousel(
						$service['gallery'],
						array(
							'autoplay_inview' => 6500,
							'label'           => sprintf(
								/* translators: %s: service name */
								__( 'Galería: %s', 'abalturas' ),
								$service['title']
							),
						)
					);
					?>
				</div>
				<div class="abalturas-servicios-section__body">
					<p class="text-[11px] font-bold uppercase tracking-[0.24em] text-safety"><?php echo esc_html( $service['eyebrow'] ); ?></p>
					<h2 id="servicio-<?php echo esc_attr( $service['id'] ); ?>-title" class="mt-3 text-2xl font-extrabold text-charcoal sm:text-3xl">
						<?php echo esc_html( $service['title'] ); ?>
					</h2>
					<p class="mt-4 text-base leading-relaxed text-slate-600"><?php echo esc_html( $service['intro'] ); ?></p>
					<ul class="abalturas-servicios-section__list">
						<?php foreach ( $service['bullets'] as $bullet ) : ?>
						<li><?php echo esc_html( $bullet ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</section>
		<?php endforeach; ?>

		<section class="mt-14 rounded-2xl border border-slate-200/90 bg-white px-6 py-8 text-center shadow-md sm:px-10 sm:py-10" aria-labelledby="servicios-cta-title">
			<h2 id="servicios-cta-title" class="text-lg font-extrabold text-charcoal sm:text-xl">
				<?php esc_html_e( '¿Necesita cotizar un proyecto o capacitación?', 'abalturas' ); ?>
			</h2>
			<p class="mx-auto mt-3 max-w-2xl text-sm leading-relaxed text-slate-600 sm:text-base">
				<?php esc_html_e( 'Nuestro equipo técnico y comercial le orienta en la solución adecuada para su obra, industria o programa de formación.', 'abalturas' ); ?>
			</p>
			<div class="ab-servicios-cta__actions">
				<div class="ab-servicios-cta__group">
					<p class="ab-servicios-cta__label"><?php esc_html_e( 'Contacto inmediato', 'abalturas' ); ?></p>
					<a href="<?php echo esc_url( $whatsapp_technical ); ?>" class="ab-servicios-cta__btn ab-servicios-cta__btn--primary" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Asesoría técnica por WhatsApp (se abre en nueva pestaña)', 'abalturas' ); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
							<path d="M20.503 5.42A9.957 9.957 0 0 0 12.036 2C6.956 2 2.83 6.146 2.828 11.239c-.001 1.734.449 3.397 1.297 4.892L3 21.95l6.058-1.592a9.86 9.86 0 0 0 4.973 1.343h.005c5.079 0 9.207-4.147 9.209-9.239a9.173 9.173 0 0 0-2.743-6.943ZM12.04 18.93h-.003a8.236 8.236 0 0 1-4.226-1.166l-.303-.18-4.036 1.062 1.078-3.964-.209-.343a8.274 8.274 0 1 1 7.7 5.592Zm4.547-6.226c-.25-.129-1.477-.736-1.706-.822-.229-.086-.396-.129-.563.129-.167.259-.642.821-.786.99-.146.169-.294.188-.546.058-.251-.129-1.062-.394-2.026-1.254-.746-.673-1.254-1.502-1.403-1.757-.146-.259-.017-.394.118-.527.117-.117.259-.294.389-.446.137-.154.174-.267.274-.446.086-.208.049-.379-.026-.527-.069-.169-.564-1.353-.769-1.852-.207-.489-.418-.427-.573-.439l-.49-.013c-.168 0-.442.068-.674.323-.229.259-.881.868-.881 2.122 0 1.257.919 2.474 1.042 2.642.146.259 1.804 2.743 4.379 3.849.612.262 1.091.418 1.465.539.613.206 1.172.173 1.611.098.489-.069 1.477-.613 1.687-1.208.217-.596.217-1.104.157-1.208-.069-.086-.237-.169-.489-.297Z"/>
						</svg>
						<span><?php esc_html_e( 'Asesoría técnica', 'abalturas' ); ?></span>
					</a>
				</div>
				<p class="ab-servicios-cta__divider" aria-hidden="true"><?php esc_html_e( 'o', 'abalturas' ); ?></p>
				<div class="ab-servicios-cta__group">
					<p class="ab-servicios-cta__label"><?php esc_html_e( 'Más opciones', 'abalturas' ); ?></p>
					<div class="ab-servicios-cta__grid">
						<a href="<?php echo esc_url( $whatsapp_commercial ); ?>" class="ab-servicios-cta__btn ab-servicios-cta__btn--secondary" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Cotizar servicio por WhatsApp (se abre en nueva pestaña)', 'abalturas' ); ?>">
							<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true">
								<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3-13.5h1.5a2.25 2.25 0 0 1 2.25 2.25V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.75A2.25 2.25 0 0 1 6.75 4.5h1.5m3 0h3m-9 3h10.5"/>
							</svg>
							<span><?php esc_html_e( 'Cotizar servicio', 'abalturas' ); ?></span>
						</a>
						<a href="<?php echo esc_url( $normativa_url ); ?>" class="ab-servicios-cta__btn ab-servicios-cta__btn--tertiary">
							<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true">
								<path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M7 8h10M9 12h6M10 16h4"/>
							</svg>
							<span><?php esc_html_e( 'Ver normatividad', 'abalturas' ); ?></span>
						</a>
					</div>
				</div>
			</div>
		</section>

	</div>
</main>
