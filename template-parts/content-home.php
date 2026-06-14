<?php
/**
 * Home Abalturas — layout alineado mockup industrial
 *
 * @package Abalturas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero_principal = trailingslashit( get_stylesheet_directory() ) . 'assets/hero-prinicpal.jpg';
$hero_mockup    = trailingslashit( get_stylesheet_directory() ) . 'assets/hero-mockup.png';
$stylesheet_uri = trailingslashit( get_stylesheet_directory_uri() );

if ( file_exists( $hero_principal ) ) {
	$hero_url = $stylesheet_uri . 'assets/hero-prinicpal.jpg';
} elseif ( file_exists( $hero_mockup ) ) {
	$hero_url = $stylesheet_uri . 'assets/hero-mockup.png';
} else {
	$hero_url = 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=1920&q=80';
}

$shop_link = esc_url(
	function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/tienda/' )
);
$whatsapp_technical_href = function_exists( 'abalturas_get_whatsapp_url' ) ? abalturas_get_whatsapp_url( 'technical', __( 'Hola, quiero cotizar un proyecto técnico.', 'abalturas' ) ) : 'https://wa.me/573215607926';

// URLs de la carpeta assets
$assets_url                        = trailingslashit( get_stylesheet_directory_uri() ) . 'assets/';
$assets_dir                        = trailingslashit( get_stylesheet_directory() ) . 'assets/';
$servicios_proteccion_colectiva_url  = $assets_url . 'proteccionColectiva.png';
$servicios_proteccion_individual_url = $assets_url . 'proteccionIndividual.jpg';
if ( ! file_exists( $assets_dir . 'proteccionColectiva.png' ) ) {
	$servicios_proteccion_colectiva_url = 'https://images.unsplash.com/photo-1541883234164-0f00f7e8f8d6?auto=format&fit=crop&w=800&q=80';
}
if ( ! file_exists( $assets_dir . 'proteccionIndividual.jpg' ) ) {
	$servicios_proteccion_individual_url = 'https://images.unsplash.com/photo-1581092160562-40aa08c7880a?auto=format&fit=crop&w=800&q=80';
}

$servicios_ingenieria_url = $assets_url . 'ingenieria.png';
if ( ! file_exists( $assets_dir . 'ingenieria.png' ) ) {
	$servicios_ingenieria_url = 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=800&q=80';
}

$home_category_cards = array(
	array(
		'title'       => __( 'Protección colectiva', 'abalturas' ),
		'description' => __( 'Barandas, redes y sistemas certificados para trabajo seguro en alturas.', 'abalturas' ),
		'image'       => $servicios_proteccion_colectiva_url,
		'image_alt'   => __( 'Obra con medidas de protección colectiva: andamiaje y espacio seguro', 'abalturas' ),
		'cta'         => __( 'Ver productos', 'abalturas' ),
		'href'        => $shop_link,
		'external'    => false,
	),
	array(
		'title'       => __( 'Protección individual', 'abalturas' ),
		'description' => __( 'Equipos de protección personal certificados para cada operación.', 'abalturas' ),
		'image'       => $servicios_proteccion_individual_url,
		'image_alt'   => __( 'Equipos de protección personal: arneses, máscaras y EPP en obra', 'abalturas' ),
		'cta'         => __( 'Ver productos', 'abalturas' ),
		'href'        => $shop_link,
		'external'    => false,
	),
	array(
		'title'       => __( 'Ingeniería y servicios', 'abalturas' ),
		'description' => __( 'Inspección, instalación y acompañamiento técnico especializado.', 'abalturas' ),
		'image'       => $servicios_ingenieria_url,
		'image_alt'   => __( 'Equipo de ingeniería revisando planos en obra industrial', 'abalturas' ),
		'cta'         => __( 'Conocer más', 'abalturas' ),
		'href'        => function_exists( 'abalturas_get_whatsapp_url' )
			? abalturas_get_whatsapp_url( 'technical', __( 'Hola, quiero conocer más sobre ingeniería y servicios.', 'abalturas' ) )
			: $whatsapp_technical_href,
		'external'    => true,
	),
);

$diferencial_ingenieria_img_url = $assets_url . 'heroSoporte.png';
if ( ! file_exists( $assets_dir . 'heroSoporte.png' ) ) {
	$diferencial_ingenieria_img_url = 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=900&q=80';
}

$certificaciones_logos = array(
	array( 'archivo' => 'ansi.png', 'alt' => 'ANSI', 'mas_grande' => true ),
	array( 'archivo' => 'osha.png', 'alt' => 'OSHA', 'mas_grande' => true ),
	array( 'archivo' => 'ce.png', 'alt' => __( 'Marca CE', 'abalturas' ), 'mas_pequeno' => true ),
	array( 'archivo' => 'iso.png', 'alt' => 'ISO', 'mas_pequeno' => true ),
);
?>

<main id="abalturas-main" class="abalturas-home bg-white" tabindex="-1">

	<!-- Hero: fotografía protagonista + leyenda sobre capa degradada editorial -->
	<section class="isolate relative flex min-h-[min(100svh,46rem)] flex-col justify-center overflow-hidden bg-industrial lg:min-h-[min(100svh,48rem)]" aria-labelledby="abalturas-hero-h1">
		<div class="pointer-events-none absolute inset-0" aria-hidden="true">
			<img
				src="<?php echo esc_url( $hero_url ); ?>"
				alt=""
				class="h-full w-full object-cover object-[54%_32%]"
				width="1600"
				height="2133"
				decoding="async"
				fetchpriority="high"
			/>
			<!-- Transición nav charcoal → fotografía -->
			<div class="absolute inset-x-0 top-0 z-[1] h-12 bg-gradient-to-b from-charcoal via-charcoal/25 to-transparent sm:h-14"></div>
			<!-- Luz leve en la foto antes de overlays -->
			<div class="absolute inset-0 bg-white/[0.04] mix-blend-overlay"></div>
			<!-- Contraste donde vive la copia (costado derecho abierto conserva fotografía luminosa) -->
			<div class="absolute inset-0 bg-[linear-gradient(106deg,#1A365D_0%,rgba(26,54,93,0.92)_21%,rgba(26,54,93,0.48)_43%,rgba(26,54,93,0.12)_62%,transparent_82%)]"></div>
			<!-- Ancla inferior y transición editorial hacia siguiente bloque -->
			<div class="absolute inset-0 bg-gradient-to-t from-industrial/[0.55] via-transparent to-transparent"></div>
			<!-- Viñeta global muy suave para unificar luminosidades -->
			<div class="absolute inset-0 bg-gradient-to-br from-transparent via-transparent to-black/25"></div>
		</div>

		<div class="relative z-10 w-full pb-20 pt-6 text-center text-white sm:pb-[5.75rem] sm:pt-8 xl:pb-28">
			<div class="abalturas-home__inner">
			<div class="mx-auto max-w-xl sm:max-w-[26rem] md:max-w-xl lg:mx-0 lg:max-w-xl lg:text-left xl:max-w-[28rem]">
				<div class="mb-8 flex justify-center lg:justify-start">
					<span class="inline-block rounded-sm bg-white/10 px-3 py-1 backdrop-blur-[2px]" aria-hidden="true">
						<span class="block h-[2px] w-10 bg-safety"></span>
					</span>
				</div>
				<p class="mb-6 text-[10px] font-extrabold uppercase tracking-[0.38em] text-white/92 sm:text-xs">
					<?php echo esc_html( 'Abalturas' ); ?>
				</p>
				<h1 id="abalturas-hero-h1" class="drop-shadow-[0_2px_32px_rgba(0,0,0,0.45)] text-xl font-bold uppercase leading-[1.2] tracking-wide text-white sm:text-3xl md:text-4xl md:leading-[1.12] lg:text-[2.625rem] lg:tracking-[0.035em]">
					<span class="block"><?php echo esc_html( 'Ingeniería que salva vidas:' ); ?></span>
					<span class="mt-4 block text-white/95 sm:mt-3"><?php echo esc_html( 'Protección contra caídas certificada' ); ?></span>
				</h1>
				<p class="mx-auto mt-7 max-w-md text-[0.9375rem] font-medium leading-relaxed text-white/88 sm:text-base md:text-lg lg:mx-0">
					<?php echo esc_html( 'Asesoría, venta e instalación de sistemas certificados bajo normativas globales.' ); ?>
				</p>
				<div class="mx-auto mt-11 flex flex-col items-stretch gap-4 sm:flex-row sm:flex-wrap sm:items-center sm:justify-center lg:mx-0 lg:justify-start">
					<a href="<?php echo esc_url( $whatsapp_technical_href ); ?>" class="inline-flex min-h-[3rem] min-w-[14rem] flex-1 items-center justify-center rounded-[3px] border-2 border-safety bg-safety px-7 py-3 text-center text-xs font-extrabold uppercase tracking-[0.18em] text-white shadow-[0_4px_24px_-4px_rgba(245,101,35,0.55)] outline-none ring-offset-industrial transition hover:-translate-y-0.5 hover:bg-[#de5317] hover:shadow-lg focus-visible:ring-2 focus-visible:ring-white/70 focus-visible:ring-offset-2 focus-visible:ring-offset-industrial sm:max-w-max sm:flex-initial md:min-h-[3.125rem] md:text-[13px]" target="_blank" rel="noopener noreferrer">
						<?php echo esc_html( 'Cotizar proyecto técnico' ); ?>
					</a>
					<a href="<?php echo $shop_link; ?>" class="inline-flex min-h-[3rem] min-w-[14rem] flex-1 items-center justify-center rounded-[3px] border-2 border-white/95 bg-transparent px-7 py-3 text-center text-xs font-extrabold uppercase tracking-[0.18em] text-white shadow-[inset_0_0_0_1px_rgba(255,255,255,0.06)] backdrop-blur-[1px] outline-none ring-offset-industrial transition hover:-translate-y-0.5 hover:border-white hover:bg-white/10 hover:shadow-md focus-visible:ring-2 focus-visible:ring-safety focus-visible:ring-offset-2 focus-visible:ring-offset-industrial md:min-h-[3.125rem] md:text-[13px]">
						<?php echo esc_html( 'Tienda online' ); ?>
					</a>
				</div>
			</div>
			</div>
		</div>
	</section>

	<!-- Franja certificaciones -->
	<section class="border-b border-slate-200/80 bg-white py-2 sm:py-2.5" aria-label="<?php echo esc_attr__( 'Certificaciones', 'abalturas' ); ?>">
		<div class="abalturas-home__inner flex flex-wrap items-center justify-center gap-x-10 gap-y-3.5 sm:gap-x-14 sm:gap-y-5 md:gap-x-16 lg:gap-x-20 xl:gap-x-[5.25rem]">
			<?php
			foreach ( $certificaciones_logos as $logo ) :
				$alt = isset( $logo['alt'] ) ? $logo['alt'] : '';
				$archivo = isset( $logo['archivo'] ) ? $logo['archivo'] : '';
				$mas_grande  = ! empty( $logo['mas_grande'] );
				$mas_pequeno = ! empty( $logo['mas_pequeno'] );
				if ( $mas_grande ) {
					$estilo_escala = 'transform: scale(1.25); transform-origin: center;';
				} elseif ( $mas_pequeno ) {
					$estilo_escala = 'transform: scale(0.72); transform-origin: center;';
				} else {
					$estilo_escala = '';
				}
				?>
			<!-- imagenes de certificaciones -->
			<div class="flex aspect-square w-[clamp(2.5rem,_5vw_+_1.25rem,_4.0625rem)] max-w-[65px] shrink-0 items-center justify-center overflow-hidden p-1 grayscale opacity-80 sm:p-1.5" aria-label="<?php echo esc_attr( $alt ); ?>">
				<?php if ( $archivo !== '' ) : ?>
					<img src="<?php echo esc_url( $assets_url . $archivo ); ?>" alt="<?php echo esc_attr( $alt ); ?>" class="h-full w-full object-contain object-center" style="<?php echo esc_attr( $estilo_escala ); ?>" loading="lazy" decoding="async" width="65" height="65"/>
				<?php endif; ?>
			</div>
				<?php
			endforeach;
			?>
		</div>
	</section>
	<!-- Categorías / servicios -->
	<style id="abalturas-category-cards-styles">
		.abalturas-category-cards {
			display: grid;
			grid-template-columns: minmax(0, 1fr);
			gap: 1.25rem;
		}
		@media (min-width: 768px) {
			.abalturas-category-cards {
				grid-template-columns: repeat(2, minmax(0, 1fr));
				gap: 1.125rem;
			}
		}
		@media (min-width: 1024px) {
			.abalturas-category-cards {
				grid-template-columns: repeat(3, minmax(0, 1fr));
				gap: 1.5rem;
			}
		}
		.abalturas-category-card {
			display: flex;
			flex-direction: column;
			height: 100%;
			min-height: 100%;
			overflow: hidden;
			border-radius: 0.875rem;
			border: 1px solid rgb(203 213 225 / 0.85);
			background: #fff;
			box-shadow: 0 1px 2px rgb(15 23 42 / 0.04), 0 6px 20px rgb(15 23 42 / 0.05);
			color: inherit;
			text-decoration: none;
			transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
			outline: none;
		}
		.abalturas-category-card:hover,
		.abalturas-category-card:focus-visible {
			transform: translateY(-4px) scale(1.03);
			border-color: rgb(245 101 35 / 0.35);
			box-shadow: 0 10px 28px rgb(15 23 42 / 0.1), 0 18px 40px rgb(26 54 93 / 0.1);
		}
		.abalturas-category-card:focus-visible {
			box-shadow: 0 10px 28px rgb(15 23 42 / 0.1), 0 0 0 3px rgb(245 101 35 / 0.45);
		}
		.abalturas-category-card__media {
			position: relative;
			aspect-ratio: 16 / 10;
			overflow: hidden;
			background: rgb(203 213 225 / 0.45);
		}
		@media (min-width: 640px) {
			.abalturas-category-card__media {
				aspect-ratio: 16 / 9;
			}
		}
		.abalturas-category-card__media img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			object-position: center;
			transition: transform 0.3s ease;
		}
		.abalturas-category-card:hover .abalturas-category-card__media img,
		.abalturas-category-card:focus-visible .abalturas-category-card__media img {
			transform: scale(1.05);
		}
		.abalturas-category-card__media::after {
			content: "";
			position: absolute;
			inset: 0;
			background: linear-gradient(to top, rgb(26 54 93 / 0.18), transparent 55%);
			opacity: 0;
			transition: opacity 0.3s ease;
			pointer-events: none;
		}
		.abalturas-category-card:hover .abalturas-category-card__media::after,
		.abalturas-category-card:focus-visible .abalturas-category-card__media::after {
			opacity: 1;
		}
		.abalturas-category-card__body {
			display: flex;
			flex: 1;
			flex-direction: column;
			padding: 1.15rem 1.25rem 1.35rem;
			text-align: left;
		}
		@media (min-width: 640px) {
			.abalturas-category-card__body {
				padding: 1.25rem 1.35rem 1.5rem;
			}
		}
		.abalturas-category-card__title {
			margin: 0;
			font-size: 0.8125rem;
			font-weight: 800;
			line-height: 1.35;
			letter-spacing: 0.12em;
			text-transform: uppercase;
			color: #1a202c;
		}
		@media (min-width: 640px) {
			.abalturas-category-card__title {
				font-size: 0.875rem;
			}
		}
		.abalturas-category-card__desc {
			margin: 0.65rem 0 0;
			flex: 1;
			font-size: 0.875rem;
			line-height: 1.55;
			color: rgb(71 85 105);
		}
		@media (min-width: 640px) {
			.abalturas-category-card__desc {
				font-size: 0.9375rem;
			}
		}
		.abalturas-category-card__cta {
			display: inline-flex;
			align-items: center;
			gap: 0.35rem;
			margin-top: 1.1rem;
			font-size: 0.75rem;
			font-weight: 800;
			letter-spacing: 0.1em;
			text-transform: uppercase;
			color: #1a365d;
			transition: color 0.3s ease, gap 0.3s ease;
		}
		.abalturas-category-card:hover .abalturas-category-card__cta,
		.abalturas-category-card:focus-visible .abalturas-category-card__cta {
			color: #f56523;
			gap: 0.55rem;
		}
		.abalturas-category-card__cta-badge {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			min-height: 2rem;
			padding: 0 0.75rem;
			border-radius: 0.375rem;
			border: 1.5px solid rgb(26 54 93 / 0.2);
			background: rgb(26 54 93 / 0.04);
			transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
		}
		.abalturas-category-card:hover .abalturas-category-card__cta-badge,
		.abalturas-category-card:focus-visible .abalturas-category-card__cta-badge {
			border-color: rgb(245 101 35 / 0.45);
			background: rgb(245 101 35 / 0.08);
			color: #c05621;
		}
		.abalturas-category-card__arrow {
			display: inline-flex;
			width: 1.25rem;
			height: 1.25rem;
			align-items: center;
			justify-content: center;
			border-radius: 999px;
			font-size: 0.875rem;
			line-height: 1;
			opacity: 0;
			transform: translateX(-4px);
			transition: opacity 0.3s ease, transform 0.3s ease;
		}
		.abalturas-category-card:hover .abalturas-category-card__arrow,
		.abalturas-category-card:focus-visible .abalturas-category-card__arrow {
			opacity: 1;
			transform: translateX(0);
		}
		.abalturas-category-cards__header {
			margin-bottom: 1.75rem;
			text-align: center;
		}
		@media (min-width: 1024px) {
			.abalturas-category-cards__header {
				text-align: left;
			}
		}
		.abalturas-category-cards__eyebrow {
			margin: 0;
			font-size: 0.6875rem;
			font-weight: 700;
			letter-spacing: 0.22em;
			text-transform: uppercase;
			color: #f56523;
		}
		.abalturas-category-cards__title {
			margin: 0.4rem 0 0;
			font-size: 1.375rem;
			font-weight: 800;
			line-height: 1.25;
			color: #1a202c;
		}
		@media (min-width: 640px) {
			.abalturas-category-cards__title {
				font-size: 1.5rem;
			}
		}
		.abalturas-category-cards__lead {
			margin: 0.65rem auto 0;
			max-width: 36rem;
			font-size: 0.9375rem;
			line-height: 1.55;
			color: rgb(71 85 105);
		}
		@media (min-width: 1024px) {
			.abalturas-category-cards__lead {
				margin-left: 0;
				margin-right: 0;
			}
		}
	</style>
	<section class="bg-slate-100 py-10 sm:py-14" aria-labelledby="abalturas-servicios-title">
		<div class="abalturas-home__inner">
			<header class="abalturas-category-cards__header">
				<p class="abalturas-category-cards__eyebrow"><?php esc_html_e( 'Soluciones integrales', 'abalturas' ); ?></p>
				<h2 id="abalturas-servicios-title" class="abalturas-category-cards__title"><?php esc_html_e( 'Equipos y servicios para trabajo seguro', 'abalturas' ); ?></h2>
				<p class="abalturas-category-cards__lead"><?php esc_html_e( 'Explore nuestras líneas de protección o consulte con nuestro equipo técnico para cotizar ingeniería e instalación.', 'abalturas' ); ?></p>
			</header>
			<div class="abalturas-category-cards">
				<?php foreach ( $home_category_cards as $card ) : ?>
					<a
						href="<?php echo esc_url( $card['href'] ); ?>"
						class="abalturas-category-card group"
						<?php echo ! empty( $card['external'] ) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
					>
						<div class="abalturas-category-card__media">
							<img
								src="<?php echo esc_url( $card['image'] ); ?>"
								alt="<?php echo esc_attr( $card['image_alt'] ); ?>"
								loading="lazy"
								decoding="async"
								width="800"
								height="500"
							/>
						</div>
						<div class="abalturas-category-card__body">
							<h3 class="abalturas-category-card__title"><?php echo esc_html( $card['title'] ); ?></h3>
							<p class="abalturas-category-card__desc"><?php echo esc_html( $card['description'] ); ?></p>
							<span class="abalturas-category-card__cta">
								<span class="abalturas-category-card__cta-badge"><?php echo esc_html( $card['cta'] ); ?></span>
								<span class="abalturas-category-card__arrow" aria-hidden="true">→</span>
							</span>
						</div>
						<?php if ( ! empty( $card['external'] ) ) : ?>
							<span class="sr-only"><?php esc_html_e( '(se abre en WhatsApp)', 'abalturas' ); ?></span>
						<?php endif; ?>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Productos destacados -->
	<section class="border-t border-slate-100 bg-white py-14 sm:py-20" aria-labelledby="abalturas-productos-title">
		<div class="abalturas-home__inner">
			<h2 id="abalturas-productos-title" class="text-center text-xl font-extrabold uppercase tracking-[0.2em] text-slate-900 sm:text-2xl">
				<?php echo esc_html( 'Productos destacados' ); ?>
			</h2>
			<?php
			$featured_products = function_exists( 'abalturas_get_home_featured_products' )
				? abalturas_get_home_featured_products( 4 )
				: array();

			if ( ! empty( $featured_products ) ) :
				wc_set_loop_prop( 'columns', 4 );
				$GLOBALS['woocommerce_loop']['loop'] = 0;
				?>
			<ul class="products columns-4 abalturas-shop-grid abalturas-shop-grid--home mx-auto mt-12 grid w-full list-none grid-cols-1 gap-8 p-0 sm:grid-cols-2 sm:gap-7 lg:grid-cols-4 lg:gap-6">
				<?php
				foreach ( $featured_products as $featured_product ) {
					$GLOBALS['product'] = $featured_product;
					wc_get_template_part( 'content', 'product' );
				}
				?>
			</ul>
			<p class="mt-10 text-center">
				<a href="<?php echo $shop_link; ?>" class="inline-flex min-h-[2.875rem] items-center justify-center rounded-[3px] border-2 border-industrial bg-white px-7 text-xs font-bold uppercase tracking-[0.15em] text-industrial transition hover:bg-industrial hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-industrial sm:text-[13px]">
					<?php esc_html_e( 'Ver catálogo completo', 'abalturas' ); ?>
				</a>
			</p>
				<?php
			else :
				?>
			<p class="mx-auto mt-8 max-w-md text-center text-sm leading-relaxed text-slate-600">
				<?php esc_html_e( 'Pronto verá aquí productos de nuestro catálogo. Mientras tanto, explore la tienda.', 'abalturas' ); ?>
			</p>
			<p class="mt-6 text-center">
				<a href="<?php echo $shop_link; ?>" class="inline-flex min-h-[2.875rem] items-center justify-center rounded-[3px] bg-safety px-7 text-xs font-bold uppercase tracking-[0.15em] text-white shadow hover:bg-[#de5317] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-safety sm:text-[13px]">
					<?php esc_html_e( 'Ir a la tienda', 'abalturas' ); ?>
				</a>
			</p>
				<?php
			endif;
			?>
		</div>
	</section>

	<!-- Diferencial -->
	<section class="border-t border-slate-200 bg-slate-50 py-14 sm:py-20" aria-labelledby="abalturas-diferencial-title" id="contacto">
		<div class="abalturas-home__inner">
			<div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-2 lg:gap-16">
				<div class="order-2 lg:order-1">
					<h2 id="abalturas-diferencial-title" class="text-xl font-extrabold uppercase tracking-[0.12em] text-slate-900 sm:text-2xl">
						<?php echo esc_html( 'Cumplimiento y soporte técnico', 'abalturas' ); ?>
					</h2>
					<div class="mt-8 space-y-8 text-slate-700">
						<div class="border-l-4 border-safety pl-5">
							<h3 class="text-base font-bold uppercase tracking-wide text-slate-900"><?php echo esc_html( 'Cumplimiento normativo', 'abalturas' ); ?></h3>
							<p class="mt-2 text-sm leading-relaxed text-slate-600 sm:text-base">
								<?php echo esc_html( 'Proyectos y equipos alineados con ANSI, OSHA y buenas prácticas de EPP. Documentación y trazabilidad para HSE.' ); ?>
							</p>
						</div>
						<div class="border-l-4 border-industrial pl-5">
							<h3 class="text-base font-bold uppercase tracking-wide text-slate-900"><?php echo esc_html( 'Soporte de ingeniería', 'abalturas' ); ?></h3>
							<p class="mt-2 text-sm leading-relaxed text-slate-600 sm:text-base">
								<?php echo esc_html( 'Asesoría en carga, anclajes e instalación conforme a normativa internacional.', 'abalturas' ); ?>
							</p>
						</div>
					</div>
					<a href="<?php echo esc_url( $whatsapp_technical_href ); ?>" class="mt-10 inline-flex min-h-[2.875rem] items-center justify-center rounded-[3px] bg-industrial px-7 text-xs font-bold uppercase tracking-[0.15em] text-white shadow hover:bg-[#143153] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-industrial sm:text-[13px]" target="_blank" rel="noopener noreferrer">
						<?php echo esc_html( 'Contactar equipo técnico', 'abalturas' ); ?>
					</a>
				</div>
				<div class="order-1 lg:order-2">
					<figure class="overflow-hidden rounded-xl border border-slate-200/90 shadow-lg ring-1 ring-slate-200/70">
						<img src="<?php echo esc_url( $diferencial_ingenieria_img_url ); ?>" alt="<?php echo esc_attr__( 'Servicio de ingeniería en campo', 'abalturas' ); ?>" class="aspect-[4/3] w-full object-cover" loading="lazy" width="900" height="675"/>
					</figure>
				</div>
			</div>
		</div>
	</section>

</main>
