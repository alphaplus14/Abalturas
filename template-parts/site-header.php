<?php
/**
 * Barra superior (mockup industrial)
 *
 * @package Abalturas
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shop_url      = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/tienda/' );
$normativa_url       = abalturas_get_normativa_res4272_page_url();
$sobre_nosotros_url  = abalturas_get_sobre_nosotros_page_url();
$servicios_url       = function_exists( 'abalturas_get_servicios_page_url' ) ? abalturas_get_servicios_page_url() : home_url( '/servicios/' );
$nav_is_shop         = function_exists( 'is_shop' ) && is_shop();
$nav_is_normativa    = function_exists( 'abalturas_is_normativa_res4272_page' ) && abalturas_is_normativa_res4272_page();
$nav_is_sobre        = function_exists( 'abalturas_is_sobre_nosotros_page' ) && abalturas_is_sobre_nosotros_page();
$nav_is_servicios    = function_exists( 'abalturas_is_servicios_page' ) && abalturas_is_servicios_page();
$brand_logo          = abalturas_get_brand_logo();
$whatsapp_technical  = function_exists( 'abalturas_get_whatsapp_url' ) ? abalturas_get_whatsapp_url( 'technical', __( 'Hola, necesito asesoría técnica de Abalturas.', 'abalturas' ) ) : 'https://wa.me/573215607926';
$whatsapp_commercial = function_exists( 'abalturas_get_whatsapp_url' ) ? abalturas_get_whatsapp_url( 'commercial', __( 'Hola, quiero cotizar con Abalturas.', 'abalturas' ) ) : 'https://wa.me/573027782299';

$mobile_nav_items = array(
	array(
		'href'     => $servicios_url,
		'label'    => __( 'Servicios', 'abalturas' ),
		'sub'      => __( 'Ingeniería, instalación y capacitación', 'abalturas' ),
		'current'  => $nav_is_servicios,
		'primary'  => true,
		'icon'     => 'services',
	),
	array(
		'href'     => $shop_url,
		'label'    => __( 'Productos', 'abalturas' ),
		'sub'      => __( 'Tienda de equipos certificados', 'abalturas' ),
		'current'  => $nav_is_shop,
		'primary'  => true,
		'icon'     => 'products',
	),
	array(
		'href'     => $normativa_url,
		'label'    => __( 'Normatividad', 'abalturas' ),
		'sub'      => __( 'Resolución 4272 y cumplimiento', 'abalturas' ),
		'current'  => $nav_is_normativa,
		'primary'  => false,
		'icon'     => 'compliance',
	),
	array(
		'href'     => $sobre_nosotros_url,
		'label'    => __( 'Sobre nosotros', 'abalturas' ),
		'sub'      => __( 'Experiencia en seguridad en alturas', 'abalturas' ),
		'current'  => $nav_is_sobre,
		'primary'  => false,
		'icon'     => 'about',
	),
);
?>
<header class="sticky top-0 z-40 border-b border-slate-200 bg-white shadow-sm">
	<input type="checkbox" id="mobile-nav-ab" class="peer sr-only"/>

	<div class="flex flex-col lg:gap-0">
		<!-- Barra superior: logo + utilidades -->
		<div class="abalturas-site-inner">
		<div class="relative flex w-full flex-wrap items-center justify-between gap-3 sm:gap-5 lg:flex-nowrap lg:gap-8 xl:gap-10">
		<!-- Logo -->
		<?php if ( $brand_logo['exists'] ) : ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="abalturas-site-brand group flex items-center rounded-sm no-underline ring-offset-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-industrial">
			<img
				src="<?php echo esc_url( $brand_logo['url'] ); ?>"
				width="<?php echo (int) $brand_logo['width']; ?>"
				height="<?php echo (int) $brand_logo['height']; ?>"
				alt="<?php echo esc_attr( $brand_logo['alt'] ); ?>"
				class="abalturas-brand-logo"
				decoding="async"
				fetchpriority="high"
			/>
		</a>
		<?php endif; ?>

		<!-- Acciones -->
		<div class="flex shrink-0 items-center gap-1.5 sm:gap-3">
			<?php
			if ( function_exists( 'abalturas_render_live_product_search' ) ) {
				abalturas_render_live_product_search(
					array(
						'id'            => 'site-search-ab',
						'listbox_id'    => 'site-search-ab-results',
						'wrapper_class' => 'abalturas-live-search hidden sm:block',
					)
				);
			}
			?>

			<?php
			if ( function_exists( 'abalturas_render_header_mini_cart' ) ) {
				abalturas_render_header_mini_cart();
			}
			?>

			<label for="mobile-nav-ab" id="mobile-nav-toggle-ab" aria-controls="mobile-menu-ab" aria-expanded="false" class="ab-mobile-nav__toggle inline-flex cursor-pointer items-center justify-center rounded-md p-2.5 text-slate-900 ring-offset-white hover:bg-slate-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-industrial lg:hidden xl:p-3">
				<span class="sr-only"><?php esc_html_e( 'Abrir o cerrar menú', 'abalturas' ); ?></span>
				<svg class="ab-mobile-nav__icon ab-mobile-nav__icon--open size-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h16"/></svg>
				<svg class="ab-mobile-nav__icon ab-mobile-nav__icon--close size-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 6l12 12M18 6L6 18"/></svg>
			</label>
		</div>
		</div>
		</div>

		<!-- Navegación escritorio: segunda fila, debajo de logo + herramientas -->
		<nav class="relative z-[1] hidden justify-center border-t border-white/10 bg-charcoal py-2.5 text-white lg:flex" aria-label="<?php esc_attr_e( 'Principal', 'abalturas' ); ?>">
			<div class="abalturas-site-inner flex justify-center">
			<div class="flex flex-wrap justify-center xl:flex-nowrap xl:divide-x xl:divide-white/15">
				<a
					href="<?php echo esc_url( $servicios_url ); ?>"
					class="<?php echo esc_attr( 'whitespace-nowrap px-3 py-2.5 text-[11px] font-bold uppercase tracking-wide transition xl:px-4 xl:text-xs ' . ( $nav_is_servicios ? 'text-safety' : 'text-white hover:text-safety' ) ); ?>"
					<?php echo $nav_is_servicios ? ' aria-current="page"' : ''; ?>
				><?php esc_html_e( 'Servicios', 'abalturas' ); ?></a>
				<a
					href="<?php echo esc_url( $shop_url ); ?>"
					class="<?php echo esc_attr( 'whitespace-nowrap px-3 py-2.5 text-[11px] font-bold uppercase tracking-wide transition xl:px-4 xl:text-xs ' . ( $nav_is_shop ? 'text-safety' : 'text-white hover:text-safety' ) ); ?>"
					<?php echo $nav_is_shop ? ' aria-current="page"' : ''; ?>
				><?php esc_html_e( 'Productos', 'abalturas' ); ?></a>
				<a
					href="<?php echo esc_url( $normativa_url ); ?>"
					class="<?php echo esc_attr( 'whitespace-nowrap px-3 py-2.5 text-[11px] font-bold uppercase tracking-wide transition xl:px-4 xl:text-xs ' . ( $nav_is_normativa ? 'text-safety' : 'text-white hover:text-safety' ) ); ?>"
					<?php echo $nav_is_normativa ? ' aria-current="page"' : ''; ?>
				><?php esc_html_e( 'Normatividad', 'abalturas' ); ?></a>
				<a
					href="<?php echo esc_url( $sobre_nosotros_url ); ?>"
					class="<?php echo esc_attr( 'whitespace-nowrap px-3 py-2.5 text-[11px] font-bold uppercase tracking-wide transition xl:px-4 xl:text-xs ' . ( $nav_is_sobre ? 'text-safety' : 'text-white hover:text-safety' ) ); ?>"
					<?php echo $nav_is_sobre ? ' aria-current="page"' : ''; ?>
				><?php esc_html_e( 'Sobre nosotros', 'abalturas' ); ?></a>
			</div>
			</div>
		</nav>
	</div>

	<label for="mobile-nav-ab" class="pointer-events-none fixed inset-0 z-30 bg-slate-900/35 opacity-0 transition peer-checked:pointer-events-auto peer-checked:opacity-100 lg:pointer-events-none lg:hidden lg:opacity-0" aria-hidden="true"></label>

	<nav id="mobile-menu-ab" class="ab-mobile-nav hidden peer-checked:block" aria-label="<?php esc_attr_e( 'Principal móvil', 'abalturas' ); ?>">
		<div class="ab-mobile-nav__panel">
			<div class="ab-mobile-nav__head">
				<div>
					<p class="ab-mobile-nav__eyebrow"><?php esc_html_e( 'Navegación', 'abalturas' ); ?></p>
					<p class="ab-mobile-nav__tagline"><?php esc_html_e( 'Protección contra caídas · Colombia', 'abalturas' ); ?></p>
				</div>
				<label for="mobile-nav-ab" class="ab-mobile-nav__close">
					<span class="sr-only"><?php esc_html_e( 'Cerrar menú', 'abalturas' ); ?></span>
					<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"/></svg>
				</label>
			</div>

			<?php
			if ( function_exists( 'abalturas_render_live_product_search' ) ) {
				abalturas_render_live_product_search(
					array(
						'id'             => 'site-search-mobile',
						'listbox_id'     => 'site-search-mobile-results',
						'wrapper_class'  => 'abalturas-live-search abalturas-live-search--mobile ab-mobile-nav__search',
						'form_class'     => 'abalturas-live-search__form ab-mobile-nav__search-form',
						'field_class'    => 'abalturas-live-search__field ab-mobile-nav__search-field',
						'input_class'    => 'abalturas-live-search__input ab-mobile-nav__search-input',
						'placeholder'    => __( 'Buscar productos, marcas o categorías…', 'abalturas' ),
					)
				);
			}
			?>

			<ul class="ab-mobile-nav__list">
				<?php foreach ( $mobile_nav_items as $item ) : ?>
				<li>
					<a
						href="<?php echo esc_url( $item['href'] ); ?>"
						class="ab-mobile-nav__link<?php echo $item['current'] ? ' is-current' : ''; ?><?php echo $item['primary'] ? ' ab-mobile-nav__link--primary' : ''; ?>"
						<?php echo $item['current'] ? ' aria-current="page"' : ''; ?>
					>
						<span class="ab-mobile-nav__link-icon" aria-hidden="true">
							<?php if ( 'services' === $item['icon'] ) : ?>
							<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
							<?php elseif ( 'products' === $item['icon'] ) : ?>
							<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
							<?php elseif ( 'compliance' === $item['icon'] ) : ?>
							<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
							<?php else : ?>
							<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
							<?php endif; ?>
						</span>
						<span class="ab-mobile-nav__link-text">
							<span class="ab-mobile-nav__link-label"><?php echo esc_html( $item['label'] ); ?></span>
							<span class="ab-mobile-nav__link-sub"><?php echo esc_html( $item['sub'] ); ?></span>
						</span>
						<svg class="ab-mobile-nav__link-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>

			<div class="ab-mobile-nav__cta">
				<p class="ab-mobile-nav__cta-label"><?php esc_html_e( '¿Necesita asesoría?', 'abalturas' ); ?></p>
				<div class="ab-mobile-nav__cta-actions">
					<a href="<?php echo esc_url( $whatsapp_technical ); ?>" class="ab-mobile-nav__cta-btn ab-mobile-nav__cta-btn--primary" target="_blank" rel="noopener noreferrer">
						<svg fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.503 5.42A9.957 9.957 0 0 0 12.036 2C6.956 2 2.83 6.146 2.828 11.239c-.001 1.734.449 3.397 1.297 4.892L3 21.95l6.058-1.592a9.86 9.86 0 0 0 4.973 1.343h.005c5.079 0 9.207-4.147 9.209-9.239a9.173 9.173 0 0 0-2.743-6.943ZM12.04 18.93h-.003a8.236 8.236 0 0 1-4.226-1.166l-.303-.18-4.036 1.062 1.078-3.964-.209-.343a8.274 8.274 0 1 1 7.7 5.592Zm4.547-6.226c-.25-.129-1.477-.736-1.706-.822-.229-.086-.396-.129-.563.129-.167.259-.642.821-.786.99-.146.169-.294.188-.546.058-.251-.129-1.062-.394-2.026-1.254-.746-.673-1.254-1.502-1.403-1.757-.146-.259-.017-.394.118-.527.117-.117.259-.294.389-.446.137-.154.174-.267.274-.446.086-.208.049-.379-.026-.527-.069-.169-.564-1.353-.769-1.852-.207-.489-.418-.427-.573-.439l-.49-.013c-.168 0-.442.068-.674.323-.229.259-.881.868-.881 2.122 0 1.257.919 2.474 1.042 2.642.146.259 1.804 2.743 4.379 3.849.612.262 1.091.418 1.465.539.613.206 1.172.173 1.611.098.489-.069 1.477-.613 1.687-1.208.217-.596.217-1.104.157-1.208-.069-.086-.237-.169-.489-.297Z"/></svg>
						<?php esc_html_e( 'Asesoría técnica', 'abalturas' ); ?>
					</a>
					<a href="<?php echo esc_url( $whatsapp_commercial ); ?>" class="ab-mobile-nav__cta-btn ab-mobile-nav__cta-btn--secondary" target="_blank" rel="noopener noreferrer">
						<svg fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.503 5.42A9.957 9.957 0 0 0 12.036 2C6.956 2 2.83 6.146 2.828 11.239c-.001 1.734.449 3.397 1.297 4.892L3 21.95l6.058-1.592a9.86 9.86 0 0 0 4.973 1.343h.005c5.079 0 9.207-4.147 9.209-9.239a9.173 9.173 0 0 0-2.743-6.943ZM12.04 18.93h-.003a8.236 8.236 0 0 1-4.226-1.166l-.303-.18-4.036 1.062 1.078-3.964-.209-.343a8.274 8.274 0 1 1 7.7 5.592Zm4.547-6.226c-.25-.129-1.477-.736-1.706-.822-.229-.086-.396-.129-.563.129-.167.259-.642.821-.786.99-.146.169-.294.188-.546.058-.251-.129-1.062-.394-2.026-1.254-.746-.673-1.254-1.502-1.403-1.757-.146-.259-.017-.394.118-.527.117-.117.259-.294.389-.446.137-.154.174-.267.274-.446.086-.208.049-.379-.026-.527-.069-.169-.564-1.353-.769-1.852-.207-.489-.418-.427-.573-.439l-.49-.013c-.168 0-.442.068-.674.323-.229.259-.881.868-.881 2.122 0 1.257.919 2.474 1.042 2.642.146.259 1.804 2.743 4.379 3.849.612.262 1.091.418 1.465.539.613.206 1.172.173 1.611.098.489-.069 1.477-.613 1.687-1.208.217-.596.217-1.104.157-1.208-.069-.086-.237-.169-.489-.297Z"/></svg>
						<?php esc_html_e( 'Asesoría comercial', 'abalturas' ); ?>
					</a>
				</div>
			</div>
		</div>
	</nav>
	<script>
	(function () {
		var toggle = document.getElementById( 'mobile-nav-ab' );
		var panel = document.getElementById( 'mobile-menu-ab' );
		var toggleBtn = document.getElementById( 'mobile-nav-toggle-ab' );
		if ( ! toggle || ! panel ) {
			return;
		}

		function setMenuState( open ) {
			toggle.checked = open;
			document.body.style.overflow = open ? 'hidden' : '';
			if ( toggleBtn ) {
				toggleBtn.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
			}
		}

		panel.addEventListener( 'click', function ( event ) {
			var link = event.target && event.target.closest ? event.target.closest( 'a[href]' ) : null;
			if ( link ) {
				setMenuState( false );
			}
		} );

		document.addEventListener( 'keydown', function ( event ) {
			if ( event.key === 'Escape' && toggle.checked ) {
				setMenuState( false );
			}
		} );

		toggle.addEventListener( 'change', function () {
			setMenuState( toggle.checked );
		} );

		setMenuState( false );
	})();
	</script>
</header>
