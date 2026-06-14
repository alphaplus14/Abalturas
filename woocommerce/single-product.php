<?php
/**
 * Plantilla de producto individual.
 *
 * Referencia WooCommerce/templates/single-product.php — `@version 1.6.4`.
 * Abalturas: `get_header()` estándar (no `shop`) y contenido dentro de `<main id="abalturas-main">`.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package Abalturas
 * @version 1.6.4
 */

defined( 'ABSPATH' ) || exit;

get_header();

?>
<main id="abalturas-main" class="border-t border-slate-200/80 bg-gradient-to-b from-white via-mist/80 to-mist" tabindex="-1">
	<div class="w-full py-10 lg:py-16">
		<?php
		while ( have_posts() ) {
			the_post();
			wc_get_template_part( 'content', 'single-product' );
		}
		?>
	</div>
</main>
<?php

get_footer();
