<?php
/**
 * Tema Abalturas
 *
 * @package Abalturas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_stylesheet_directory() . '/inc/alpen-catalog-import.php';
require_once get_stylesheet_directory() . '/inc/woocommerce-cart.php';
require_once get_stylesheet_directory() . '/inc/woocommerce-product-info.php';
require_once get_stylesheet_directory() . '/inc/woocommerce-live-search.php';
require_once get_stylesheet_directory() . '/inc/woocommerce-colombia-cities.php';
require_once get_stylesheet_directory() . '/inc/woocommerce-thankyou.php';
require_once get_stylesheet_directory() . '/inc/woocommerce-hide-out-of-stock.php';

/**
 * Slugs de página que muestran la guía WP de la Resolución 4272/2021 (mismo contenido).
 * El contenido viene del partial PHP; si no se fuerza esta plantilla, `page.php` solo muestra editor vacío.
 */
function abalturas_normativa_res4272_page_slugs(): array {
	return array(
		'normatividad-trabajo-alturas',
		/* alternativa habitual en español (evita contenido vacío si el slug no coincide exactamente) */
		'normatividad-trabajo-en-alturas',
	);
}

/**
 * ¿Página visual actual es la normativa Res. 4272?
 */
function abalturas_is_normativa_res4272_page(): bool {
	if ( ! is_page() ) {
		return false;
	}
	$obj = get_queried_object();
	if ( ! ( $obj instanceof WP_Post ) || 'publish' !== $obj->post_status ) {
		return false;
	}
	return in_array( $obj->post_name, abalturas_normativa_res4272_page_slugs(), true );
}

/**
 * Asignar plantilla aunque en el editor WP no esté elegida («Plantilla predeterminada»).
 */
add_filter(
	'page_template',
	static function ( $template ) {
		if ( function_exists( 'abalturas_is_normativa_res4272_page' ) && abalturas_is_normativa_res4272_page() ) {
			$file = locate_template( array( 'page-templates/normativa-resolucion-4272.php' ) );
			if ( $file !== '' ) {
				return $file;
			}
		}
		if ( function_exists( 'abalturas_is_sobre_nosotros_page' ) && abalturas_is_sobre_nosotros_page() ) {
			$file = locate_template( array( 'page-templates/sobre-nosotros.php' ) );
			if ( $file !== '' ) {
				return $file;
			}
		}
		if ( function_exists( 'abalturas_is_servicios_page' ) && abalturas_is_servicios_page() ) {
			$file = locate_template( array( 'page-templates/servicios.php' ) );
			if ( $file !== '' ) {
				return $file;
			}
		}
		if ( function_exists( 'abalturas_is_politica_datos_page' ) && abalturas_is_politica_datos_page() ) {
			$file = locate_template( array( 'page-templates/politica-datos.php' ) );
			if ( $file !== '' ) {
				return $file;
			}
		}
		if ( function_exists( 'abalturas_is_terminos_condiciones_page' ) && abalturas_is_terminos_condiciones_page() ) {
			$file = locate_template( array( 'page-templates/terminos-condiciones.php' ) );
			if ( $file !== '' ) {
				return $file;
			}
		}
		return $template;
	}
);

/**
 * Permalink de la página de normativa Res. 4272/2021 (si existe página con uno de los slugs).
 * Crear página en WP con slug recomendado y publicarla; opcional seleccionar plantilla en pantalla «Plantilla».
 */
function abalturas_get_normativa_res4272_page_url(): string {
	foreach ( abalturas_normativa_res4272_page_slugs() as $slug ) {
		$page = get_page_by_path( $slug );
		if ( $page instanceof WP_Post && 'publish' === $page->post_status ) {
			return get_permalink( $page );
		}
	}
	return home_url( '/normatividad-trabajo-alturas/' );
}

/**
 * Slugs de página «Sobre nosotros».
 */
function abalturas_sobre_nosotros_page_slugs(): array {
	return array(
		'sobre-nosotros',
		'sobre-nosotros-abalturas',
	);
}

/**
 * ¿Página visual actual es Sobre nosotros?
 */
function abalturas_is_sobre_nosotros_page(): bool {
	if ( ! is_page() ) {
		return false;
	}
	$obj = get_queried_object();
	if ( ! ( $obj instanceof WP_Post ) || 'publish' !== $obj->post_status ) {
		return false;
	}
	return in_array( $obj->post_name, abalturas_sobre_nosotros_page_slugs(), true );
}

/**
 * Permalink de la página Sobre nosotros (si existe).
 */
function abalturas_get_sobre_nosotros_page_url(): string {
	foreach ( abalturas_sobre_nosotros_page_slugs() as $slug ) {
		$page = get_page_by_path( $slug );
		if ( $page instanceof WP_Post && 'publish' === $page->post_status ) {
			return get_permalink( $page );
		}
	}
	return home_url( '/sobre-nosotros/' );
}

/**
 * Crea la página «Sobre nosotros» una sola vez si no existe (slug sobre-nosotros).
 */
add_action(
	'init',
	static function () {
		if ( get_option( 'abalturas_sobre_nosotros_page_ready' ) ) {
			return;
		}
		foreach ( abalturas_sobre_nosotros_page_slugs() as $slug ) {
			$page = get_page_by_path( $slug );
			if ( $page instanceof WP_Post ) {
				update_option( 'abalturas_sobre_nosotros_page_ready', 1, true );
				return;
			}
		}
		$id = wp_insert_post(
			array(
				'post_title'   => __( 'Sobre nosotros', 'abalturas' ),
				'post_name'    => 'sobre-nosotros',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			),
			true
		);
		if ( ! is_wp_error( $id ) && $id > 0 ) {
			update_option( 'abalturas_sobre_nosotros_page_ready', 1, true );
		}
	},
	20
);

/**
 * Slugs de página «Servicios».
 */
function abalturas_servicios_page_slugs(): array {
	return array(
		'servicios',
	);
}

/**
 * ¿Página visual actual es Servicios?
 */
function abalturas_is_servicios_page(): bool {
	if ( ! is_page() ) {
		return false;
	}
	$obj = get_queried_object();
	if ( ! ( $obj instanceof WP_Post ) || 'publish' !== $obj->post_status ) {
		return false;
	}
	return in_array( $obj->post_name, abalturas_servicios_page_slugs(), true );
}

/**
 * Permalink de la página Servicios (si existe).
 */
function abalturas_get_servicios_page_url(): string {
	foreach ( abalturas_servicios_page_slugs() as $slug ) {
		$page = get_page_by_path( $slug );
		if ( $page instanceof WP_Post && 'publish' === $page->post_status ) {
			return get_permalink( $page );
		}
	}
	return home_url( '/servicios/' );
}

/**
 * Crea la página «Servicios» una sola vez si no existe (slug servicios).
 */
add_action(
	'init',
	static function () {
		if ( get_option( 'abalturas_servicios_page_ready' ) ) {
			return;
		}
		foreach ( abalturas_servicios_page_slugs() as $slug ) {
			$page = get_page_by_path( $slug );
			if ( $page instanceof WP_Post ) {
				update_option( 'abalturas_servicios_page_ready', 1, true );
				return;
			}
		}
		$id = wp_insert_post(
			array(
				'post_title'   => __( 'Servicios', 'abalturas' ),
				'post_name'    => 'servicios',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			),
			true
		);
		if ( ! is_wp_error( $id ) && $id > 0 ) {
			update_option( 'abalturas_servicios_page_ready', 1, true );
		}
	},
	20
);

/** CSS/JS de la página Servicios (carruseles de galería). */
add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( ! function_exists( 'abalturas_is_servicios_page' ) || ! abalturas_is_servicios_page() ) {
			return;
		}

		$css_path = get_stylesheet_directory() . '/assets/css/servicios-page.css';
		$js_path  = get_stylesheet_directory() . '/assets/js/servicios-carousel.js';

		if ( is_readable( $css_path ) ) {
			wp_enqueue_style(
				'abalturas-servicios-page',
				get_stylesheet_directory_uri() . '/assets/css/servicios-page.css',
				array( 'abalturas-tailwind' ),
				filemtime( $css_path )
			);
		}

		if ( is_readable( $js_path ) ) {
			wp_enqueue_script(
				'abalturas-servicios-carousel',
				get_stylesheet_directory_uri() . '/assets/js/servicios-carousel.js',
				array(),
				filemtime( $js_path ),
				true
			);
		}
	},
	30
);

/**
 * Slugs de página «Política de datos».
 */
function abalturas_politica_datos_page_slugs(): array {
	return array(
		'politica-datos',
		'politica-de-datos',
	);
}

/**
 * ¿Página visual actual es Política de datos?
 */
function abalturas_is_politica_datos_page(): bool {
	if ( ! is_page() ) {
		return false;
	}
	$obj = get_queried_object();
	if ( ! ( $obj instanceof WP_Post ) || 'publish' !== $obj->post_status ) {
		return false;
	}
	return in_array( $obj->post_name, abalturas_politica_datos_page_slugs(), true );
}

/**
 * Permalink de la página Política de datos (si existe).
 */
function abalturas_get_politica_datos_page_url(): string {
	foreach ( abalturas_politica_datos_page_slugs() as $slug ) {
		$page = get_page_by_path( $slug );
		if ( $page instanceof WP_Post && 'publish' === $page->post_status ) {
			return get_permalink( $page );
		}
	}
	return home_url( '/politica-datos/' );
}

/**
 * Crea la página «Política de datos» una sola vez si no existe.
 */
add_action(
	'init',
	static function () {
		if ( get_option( 'abalturas_politica_datos_page_ready' ) ) {
			return;
		}
		foreach ( abalturas_politica_datos_page_slugs() as $slug ) {
			$page = get_page_by_path( $slug );
			if ( $page instanceof WP_Post ) {
				update_option( 'abalturas_politica_datos_page_ready', 1, true );
				return;
			}
		}
		$id = wp_insert_post(
			array(
				'post_title'   => __( 'Política de datos', 'abalturas' ),
				'post_name'    => 'politica-datos',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			),
			true
		);
		if ( ! is_wp_error( $id ) && $id > 0 ) {
			update_option( 'abalturas_politica_datos_page_ready', 1, true );
		}
	},
	20
);

/**
 * Slugs de página «Términos y condiciones».
 */
function abalturas_terminos_condiciones_page_slugs(): array {
	return array(
		'terminos-condiciones',
		'terminos-y-condiciones',
	);
}

/**
 * ¿Página visual actual es Términos y condiciones?
 */
function abalturas_is_terminos_condiciones_page(): bool {
	if ( ! is_page() ) {
		return false;
	}
	$obj = get_queried_object();
	if ( ! ( $obj instanceof WP_Post ) || 'publish' !== $obj->post_status ) {
		return false;
	}
	return in_array( $obj->post_name, abalturas_terminos_condiciones_page_slugs(), true );
}

/**
 * Permalink de la página Términos y condiciones (si existe).
 */
function abalturas_get_terminos_condiciones_page_url(): string {
	foreach ( abalturas_terminos_condiciones_page_slugs() as $slug ) {
		$page = get_page_by_path( $slug );
		if ( $page instanceof WP_Post && 'publish' === $page->post_status ) {
			return get_permalink( $page );
		}
	}
	return home_url( '/terminos-condiciones/' );
}

/**
 * Páginas con bloque de contacto/CTA al final del contenido (evita duplicar el banner del pie).
 */
function abalturas_page_has_inline_contact_cta(): bool {
	if ( is_front_page() ) {
		return true;
	}

	$checkers = array(
		'abalturas_is_servicios_page',
		'abalturas_is_sobre_nosotros_page',
		'abalturas_is_politica_datos_page',
		'abalturas_is_terminos_condiciones_page',
	);

	foreach ( $checkers as $checker ) {
		if ( is_string( $checker ) && function_exists( $checker ) && $checker() ) {
			return true;
		}
	}

	return false;
}

/**
 * ¿Mostrar la tarjeta CTA superpuesta del pie de página?
 */
function abalturas_should_show_footer_cta_banner(): bool {
	return ! abalturas_page_has_inline_contact_cta();
}

/**
 * Clase en body cuando el banner CTA del pie está activo (espacio y capas en CSS).
 */
add_filter(
	'body_class',
	static function ( $classes ) {
		if ( function_exists( 'abalturas_should_show_footer_cta_banner' ) && abalturas_should_show_footer_cta_banner() ) {
			$classes[] = 'abalturas-has-footer-cta-banner';
		}

		if ( function_exists( 'abalturas_is_servicios_page' ) && abalturas_is_servicios_page() ) {
			$classes[] = 'abalturas-page-servicios';
		}

		if ( function_exists( 'abalturas_is_sobre_nosotros_page' ) && abalturas_is_sobre_nosotros_page() ) {
			$classes[] = 'abalturas-page-sobre-nosotros';
		}

		return $classes;
	}
);

/**
 * Crea la página «Términos y condiciones» una sola vez si no existe.
 */
add_action(
	'init',
	static function () {
		if ( get_option( 'abalturas_terminos_condiciones_page_ready' ) ) {
			return;
		}
		foreach ( abalturas_terminos_condiciones_page_slugs() as $slug ) {
			$page = get_page_by_path( $slug );
			if ( $page instanceof WP_Post ) {
				update_option( 'abalturas_terminos_condiciones_page_ready', 1, true );
				return;
			}
		}
		$id = wp_insert_post(
			array(
				'post_title'   => __( 'Términos y condiciones', 'abalturas' ),
				'post_name'    => 'terminos-condiciones',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			),
			true
		);
		if ( ! is_wp_error( $id ) && $id > 0 ) {
			update_option( 'abalturas_terminos_condiciones_page_ready', 1, true );
		}
	},
	20
);

/**
 * Canales de contacto Abalturas (WhatsApp y teléfono).
 *
 * @return array<string, array{key:string,label:string,tel:string,whatsapp_digits:string,role:string,whatsapp_message:string}>
 */
function abalturas_get_contact_channels(): array {
	return array(
		'technical'  => array(
			'key'               => 'technical',
			'label'             => '+57 321 560 7926',
			'tel'               => '+573215607926',
			'whatsapp_digits'   => '573215607926',
			'role'              => __( 'Asesoría técnica', 'abalturas' ),
			'whatsapp_message'  => __( 'Hola, quiero asesoría técnica desde la web.', 'abalturas' ),
		),
		'commercial' => array(
			'key'               => 'commercial',
			'label'             => '+57 302 778 2299',
			'tel'               => '+573027782299',
			'whatsapp_digits'   => '573027782299',
			'role'              => __( 'Asesoría comercial', 'abalturas' ),
			'whatsapp_message'  => __( 'Hola, quiero asesoría comercial desde la web.', 'abalturas' ),
		),
	);
}

/**
 * URL de WhatsApp para un canal de contacto.
 *
 * @param string $channel   technical|commercial
 * @param string $message   Texto opcional (si está vacío usa el predeterminado del canal).
 */
function abalturas_get_whatsapp_url( string $channel = 'technical', string $message = '' ): string {
	$channels = abalturas_get_contact_channels();
	if ( ! isset( $channels[ $channel ] ) ) {
		$channel = 'technical';
	}
	$text = $message !== '' ? $message : $channels[ $channel ]['whatsapp_message'];
	return 'https://wa.me/' . $channels[ $channel ]['whatsapp_digits'] . '?text=' . rawurlencode( $text );
}

/**
 * Logo de marca (assets/logo.png).
 *
 * @return array{url:string,width:int,height:int,alt:string,exists:bool}
 */
function abalturas_get_brand_logo(): array {
	static $cached = null;
	if ( null !== $cached ) {
		return $cached;
	}
	$relative = 'assets/logo.png';
	$path     = get_stylesheet_directory() . '/' . $relative;
	$cached   = array(
		'url'    => trailingslashit( get_stylesheet_directory_uri() ) . $relative,
		'path'   => $path,
		'width'  => 1268,
		'height' => 666,
		'alt'    => get_bloginfo( 'name', 'display' ) ?: 'Abalturas',
		'exists' => is_readable( $path ),
	);
	return $cached;
}

/** CSS Tailwind compilado — generar en el tema con: npm ci && npm run build:css */
add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( is_admin() ) {
			return;
		}
		$tailwind_path = get_stylesheet_directory() . '/assets/css/tailwind.min.css';
		if ( ! is_readable( $tailwind_path ) ) {
			return;
		}
		wp_enqueue_style(
			'abalturas-tailwind',
			get_stylesheet_directory_uri() . '/assets/css/tailwind.min.css',
			array(),
			filemtime( $tailwind_path )
		);

		$brand_css = get_stylesheet_directory() . '/assets/css/site-brand.css';
		if ( is_readable( $brand_css ) ) {
			wp_enqueue_style(
				'abalturas-site-brand',
				get_stylesheet_directory_uri() . '/assets/css/site-brand.css',
				array( 'abalturas-tailwind' ),
				filemtime( $brand_css )
			);
		}

		$cta_banner_css = get_stylesheet_directory() . '/assets/css/cta-banner.css';
		if ( is_readable( $cta_banner_css ) ) {
			wp_enqueue_style(
				'abalturas-cta-banner',
				get_stylesheet_directory_uri() . '/assets/css/cta-banner.css',
				array( 'abalturas-site-brand' ),
				filemtime( $cta_banner_css )
			);
		}

		if ( is_front_page() ) {
			$home_layout_css = get_stylesheet_directory() . '/assets/css/home-layout.css';
			if ( is_readable( $home_layout_css ) ) {
				wp_enqueue_style(
					'abalturas-home-layout',
					get_stylesheet_directory_uri() . '/assets/css/home-layout.css',
					array( 'abalturas-site-brand' ),
					filemtime( $home_layout_css )
				);
			}

			$home_hero_css = get_stylesheet_directory() . '/assets/css/home-hero.css';
			if ( is_readable( $home_hero_css ) ) {
				wp_enqueue_style(
					'abalturas-home-hero',
					get_stylesheet_directory_uri() . '/assets/css/home-hero.css',
					array( 'abalturas-home-layout' ),
					filemtime( $home_hero_css )
				);
			}
		}
	},
	8
);

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'title-tag' );
		add_theme_support(
			'html5',
			array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
		);
		add_theme_support( 'post-thumbnails' );

		add_theme_support(
			'woocommerce',
			array(
				'thumbnail_image_width' => 400,
				'single_image_width'    => 1200,
				'product_grid'          => array(
					'default_rows'    => 4,
					'min_rows'        => 1,
					'max_rows'        => 9,
					'default_columns' => 4,
					'min_columns'     => 1,
					'max_columns'     => 4,
				),
			)
		);

		/*
		 * Slider + lightbox (lupa): sí.
		 * Zoom por hover (jquery.zoom): no — con el layout del tema deja el viewport en blanco
		 * aunque PhotoSwipe siga funcionando (lee data-large_image del mismo DOM).
		 */
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	},
	10
);

/**
 * Quita zoom hover aunque un plugin/tema padre haya llamado add_theme_support( 'wc-product-gallery-zoom' ).
 * Debe ejecutarse después de ese registro (prioridad alta).
 */
add_action(
	'after_setup_theme',
	static function () {
		remove_theme_support( 'wc-product-gallery-zoom' );
	},
	100
);

/** Desactivar zoom hover (jquery.zoom); PhotoSwipe sí puede estar activo sin zoom. */
add_filter(
	'woocommerce_single_product_zoom_enabled',
	'__return_false',
	999
);

/**
 * Asegura que wc_single_product_params.zoom_enabled llegue en false al JS (cachés / filtros externos).
 */
add_filter(
	'woocommerce_get_script_data',
	static function ( $params, $handle ) {
		if ( 'wc-single-product' !== $handle || ! is_array( $params ) ) {
			return $params;
		}
		if ( array_key_exists( 'zoom_enabled', $params ) ) {
			$params['zoom_enabled'] = false;
		}
		return $params;
	},
	999,
	2
);

/**
 * No cargar jquery.zoom en ficha si lo encola otro manejador residual.
 */
add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( ! function_exists( 'is_product' ) || ! is_product() ) {
			return;
		}
		wp_dequeue_script( 'wc-zoom' );
		wp_dequeue_script( 'zoom' );
	},
	150
);

/**
 * Edge/Chrome pueden diferir "load" con lazy-loading; Flexslider espera dimensiones válidas ya.
 * Marca todas las <img> de la galería WC (principal + thumbnails de la línea) como eager.
 */
add_filter(
	'woocommerce_gallery_image_html_attachment_image_params',
	static function ( $params, $attachment_id, $image_size, $main_image ) {
		if ( is_admin() ) {
			return $params;
		}
		$params['loading'] = 'eager';
		if ( $main_image ) {
			$params['fetchpriority'] = 'high';
		}
		return $params;
	},
	10,
	4
);

/**
 * Imagen destacada / galería: eager + decoding sync (después de filtros del core y de WC).
 */
add_filter(
	'wp_get_attachment_image_attributes',
	static function ( $attr, $attachment = null ) {
		if ( is_admin() || ! function_exists( 'is_product' ) || ! is_product() ) {
			return $attr;
		}
		$class = isset( $attr['class'] ) ? $attr['class'] : '';
		if ( strpos( $class, 'wp-post-image' ) === false
			&& strpos( $class, 'woocommerce' ) === false
			&& strpos( $class, 'attachment-' ) === false ) {
			return $attr;
		}
		$attr['loading']  = 'eager';
		$attr['decoding'] = 'sync';
		if ( strpos( $class, 'wp-post-image' ) !== false ) {
			$attr['fetchpriority'] = 'high';
		}
		return $attr;
	},
	999,
	3
);

/**
 * Dependencias JS de la ficha: Flexslider + PhotoSwipe antes de single-product.js
 * (evita APIs undefined → galería sin init).
 */
add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( ! function_exists( 'is_product' ) || ! is_product() ) {
			return;
		}
		if ( ! ( wp_scripts() instanceof WP_Scripts ) || ! isset( wp_scripts()->registered['wc-single-product'] ) ) {
			return;
		}
		$deps   = wp_scripts()->registered['wc-single-product']->deps;
		$extras = array();
		if ( current_theme_supports( 'wc-product-gallery-zoom' ) && wp_script_is( 'wc-zoom', 'registered' ) ) {
			$extras[] = 'wc-zoom';
		}
		if ( current_theme_supports( 'wc-product-gallery-slider' ) && wp_script_is( 'wc-flexslider', 'registered' ) ) {
			$extras[] = 'wc-flexslider';
		}
		if ( current_theme_supports( 'wc-product-gallery-lightbox' ) && wp_script_is( 'wc-photoswipe-ui-default', 'registered' ) ) {
			$extras[] = 'wc-photoswipe-ui-default';
		}
		if ( array() !== $extras ) {
			wp_scripts()->registered['wc-single-product']->deps = array_values( array_unique( array_merge( $deps, $extras ) ) );
		}
	},
	25
);

/**
 * En ficha producto: sin lazy-loading nativo de WP para ningún <img> (cualquier contexto).
 * Evita [Intervention]… en Edge/Chromium y eventos load diferidos frente a Flexslider.
 */
add_filter(
	'wp_lazy_loading_enabled',
	static function ( $default, $tag_name, $context ) {
		if ( 'img' !== $tag_name || is_admin() || ! function_exists( 'is_product' ) || ! is_product() ) {
			return $default;
		}
		return false;
	},
	10,
	3
);

/** WooCommerce: quitar envoltorios por defecto (layout Tailwind en plantillas). */
add_action(
	'woocommerce_init',
	function () {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	}
);

add_filter(
	'loop_shop_columns',
	static function () {
		return 4;
	},
	20
);

add_filter(
	'loop_shop_per_page',
	static function () {
		return 24;
	},
	20
);

/** Productos relacionados / upsells: 4 ítems en una fila compacta. */
add_filter(
	'woocommerce_output_related_products_args',
	static function ( $args ) {
		$args['columns']        = 4;
		$args['posts_per_page'] = 4;
		return $args;
	}
);

add_filter(
	'woocommerce_upsell_display_args',
	static function ( $args ) {
		$args['columns'] = 4;
		return $args;
	}
);

/**
 * ¿Loop de productos dentro de ficha individual (relacionados, upsells)?
 */
function abalturas_is_single_product_extra_loop(): bool {
	return function_exists( 'is_product' ) && is_product() && ! is_shop() && ! is_product_taxonomy();
}

/**
 * Productos para el bloque «Productos destacados» en la portada.
 *
 * Prioriza productos marcados como destacados en WooCommerce; completa con el catálogo
 * publicado (orden de menú / título) hasta el límite indicado.
 *
 * @param int $limit Cantidad de productos (por defecto 4).
 * @return WC_Product[]
 */
function abalturas_get_home_featured_products( int $limit = 4 ): array {
	if ( ! function_exists( 'wc_get_products' ) || $limit < 1 ) {
		return array();
	}

	$featured = wc_get_products(
		array(
			'status'   => 'publish',
			'limit'    => $limit,
			'featured' => true,
			'orderby'  => 'menu_order',
			'order'    => 'ASC',
		)
	);

	$products = array_values( array_filter( $featured, static function ( $product ) {
		return is_a( $product, WC_Product::class ) && $product->is_visible();
	} ) );

	if ( count( $products ) >= $limit ) {
		return array_slice( $products, 0, $limit );
	}

	$exclude = array_map(
		static function ( WC_Product $product ) {
			return $product->get_id();
		},
		$products
	);

	$fill = wc_get_products(
		array(
			'status'  => 'publish',
			'limit'   => $limit - count( $products ),
			'exclude' => $exclude,
			'orderby' => 'menu_order',
			'order'   => 'ASC',
		)
	);

	foreach ( $fill as $product ) {
		if ( is_a( $product, WC_Product::class ) && $product->is_visible() ) {
			$products[] = $product;
		}
		if ( count( $products ) >= $limit ) {
			break;
		}
	}

	return array_slice( $products, 0, $limit );
}

/**
 * Lista de archivo: igualar alto de tarjetas (rejilla Tailwind + anular floats de WooCommerce).
 */
add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( is_admin() ) {
			return;
		}
		if ( ! function_exists( 'is_shop' ) ) {
			return;
		}
		if ( ! ( is_shop() || is_product_taxonomy() || is_product() || is_front_page() ) ) {
			return;
		}
		$css_path = get_stylesheet_directory() . '/assets/css/woocommerce-shop-loop.css';
		if ( ! is_readable( $css_path ) ) {
			return;
		}
		$deps = array();
		if ( wp_style_is( 'woocommerce-general', 'registered' ) || wp_style_is( 'woocommerce-general', 'enqueued' ) ) {
			$deps[] = 'woocommerce-general';
		}
		wp_enqueue_style(
			'abalturas-wc-shop-loop',
			get_stylesheet_directory_uri() . '/assets/css/woocommerce-shop-loop.css',
			$deps,
			filemtime( $css_path )
		);
	},
	36
);

/**
 * Evitar que WooCommerce omita archive-product.php por una plantilla de bloques no usada en este tema clásico
 * (si no, la Tienda cae en index.php y aparece «No hay entradas»).
 */
add_filter(
	'woocommerce_has_block_template',
	static function ( $has_template, $template_name ) {
		if ( 'archive-product' === $template_name ) {
			return false;
		}
		return $has_template;
	},
	10,
	2
);

/**
 * Estilos premium para ficha de producto (compatible con plantilla clásica / Elementor usa su propio layout).
 */
add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( ! function_exists( 'is_product' ) || ! is_product() ) {
			return;
		}
		$css_path = get_stylesheet_directory() . '/assets/css/woocommerce-product-premium.css';
		if ( is_readable( $css_path ) ) {
			$wc_style_deps = array();
			foreach ( array( 'woocommerce-layout', 'woocommerce-general' ) as $wc_handle ) {
				if ( wp_style_is( $wc_handle, 'registered' ) || wp_style_is( $wc_handle, 'enqueued' ) ) {
					$wc_style_deps[] = $wc_handle;
				}
			}
			wp_enqueue_style(
				'abalturas-wc-product-premium',
				get_stylesheet_directory_uri() . '/assets/css/woocommerce-product-premium.css',
				$wc_style_deps,
				filemtime( $css_path )
			);
		}
	},
	30
);

/**
 * Galería ficha producto: asegura Flexslider y single-product incluso si otro código altera los encolados.
 */
add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( ! function_exists( 'is_product' ) || ! is_product() || ! class_exists( 'WooCommerce' ) ) {
			return;
		}
		wp_enqueue_script( 'jquery' );

		if ( current_theme_supports( 'wc-product-gallery-zoom' ) && wp_script_is( 'wc-zoom', 'registered' ) ) {
			wp_enqueue_script( 'wc-zoom' );
		}
		if ( current_theme_supports( 'wc-product-gallery-slider' ) && wp_script_is( 'wc-flexslider', 'registered' ) ) {
			wp_enqueue_script( 'wc-flexslider' );
		}
		if ( current_theme_supports( 'wc-product-gallery-lightbox' ) && wp_script_is( 'wc-photoswipe-ui-default', 'registered' ) ) {
			wp_enqueue_script( 'wc-photoswipe-ui-default' );
		}
		if ( wp_script_is( 'wc-single-product', 'registered' ) ) {
			wp_enqueue_script( 'wc-single-product' );
		}

		$reviews_js = get_stylesheet_directory() . '/assets/js/product-reviews.js';
		if ( is_readable( $reviews_js ) ) {
			wp_enqueue_script(
				'abalturas-product-reviews',
				get_stylesheet_directory_uri() . '/assets/js/product-reviews.js',
				array( 'jquery', 'wc-single-product' ),
				filemtime( $reviews_js ),
				true
			);
		}
	},
	99
);

/** Galería: más miniaturas por fila en escritorio. */
add_filter(
	'woocommerce_product_thumbnails_columns',
	static function () {
		return 5;
	},
	20
);

/**
 * Badges de confianza bajo «Añadir al carrito» en la ficha de producto.
 */
function abalturas_render_product_trust_badges() {
	if ( ! function_exists( 'is_product' ) || ! is_product() ) {
		return;
	}

	$badges = array(
		array(
			'label' => __( 'Producto certificado', 'abalturas' ),
			'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3 4 7v6c0 5 3.5 8.5 8 9 4.5-.5 8-4 8-9V7l-8-4z"/><path d="m9 12 2 2 4-4"/></svg>',
		),
		array(
			'label' => __( 'Envío a toda Colombia', 'abalturas' ),
			'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18h2"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.28a1 1 0 0 0-.684-.948l-1.923-.641a1 1 0 0 1-.578-.502l-1.539-3.078A1 1 0 0 0 17.382 8H14"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>',
		),
		array(
			'label' => __( 'Garantía del fabricante', 'abalturas' ),
			'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.59 13.41 12 22 2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><circle cx="7" cy="7" r="1.25" fill="currentColor" stroke="none"/></svg>',
		),
	);
	?>
	<div class="ab-product-trust-badges" role="list" aria-label="<?php esc_attr_e( 'Garantías de compra', 'abalturas' ); ?>">
		<?php foreach ( $badges as $badge ) : ?>
			<div class="ab-product-trust-badges__item" role="listitem">
				<span class="ab-product-trust-badges__icon"><?php echo $badge['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG fijo del tema. ?></span>
				<span class="ab-product-trust-badges__text"><?php echo esc_html( $badge['label'] ); ?></span>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
}

add_action( 'woocommerce_single_product_summary', 'abalturas_render_product_trust_badges', 31 );

/**
 * Contenedor interno alrededor de la galería (before: abre · priority 20: imágenes WC · after: cierra).
 */
add_action(
	'woocommerce_before_single_product_summary',
	static function () {
		echo '<div class="abalturas-product-gallery-frame">';
	},
	19
);

add_action(
	'woocommerce_before_single_product_summary',
	static function () {
		echo '</div>';
	},
	21
);
