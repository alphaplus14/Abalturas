<?php
/**
 * Valoraciones de producto — formulario y listado mejorados.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package Abalturas
 * @version 9.7.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews" class="woocommerce-Reviews ab-product-reviews">
	<div id="comments" class="ab-product-reviews__list">
		<h2 class="woocommerce-Reviews-title">
			<?php
			$count = $product->get_review_count();
			if ( $count && wc_review_ratings_enabled() ) {
				$reviews_title = sprintf(
					/* translators: 1: reviews count 2: product name */
					esc_html( _n( '%1$s valoración de %2$s', '%1$s valoraciones de %2$s', $count, 'abalturas' ) ),
					esc_html( $count ),
					'<span>' . get_the_title() . '</span>'
				);
				echo apply_filters( 'woocommerce_reviews_title', $reviews_title, $count, $product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				esc_html_e( 'Valoraciones', 'abalturas' );
			}
			?>
		</h2>

		<?php if ( have_comments() ) : ?>
			<ol class="commentlist">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ol>

			<?php
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination ab-product-reviews__pagination">';
				paginate_comments_links(
					apply_filters(
						'woocommerce_comment_pagination_args',
						array(
							'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
							'next_text' => is_rtl() ? '&larr;' : '&rarr;',
							'type'      => 'list',
						)
					)
				);
				echo '</nav>';
			endif;
			?>
		<?php else : ?>
			<p class="woocommerce-noreviews ab-product-reviews__empty"><?php esc_html_e( 'Aún no hay valoraciones para este producto.', 'abalturas' ); ?></p>
		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
		<div id="review_form_wrapper" class="ab-product-reviews__form-wrap">
			<div id="review_form" class="ab-product-reviews__form">
				<?php
				$commenter    = wp_get_current_commenter();
				$comment_form = array(
					'title_reply'         => have_comments()
						? esc_html__( 'Agregar otra valoración', 'abalturas' )
						: esc_html__( 'Comparta su experiencia', 'abalturas' ),
					'title_reply_to'      => esc_html__( 'Responder a %s', 'abalturas' ),
					'title_reply_before'  => '<div id="reply-title" class="comment-reply-title ab-product-reviews__form-intro" role="heading" aria-level="3"><span class="ab-product-reviews__form-eyebrow">' . esc_html__( 'Su valoración', 'abalturas' ) . '</span><span class="ab-product-reviews__form-title">',
					'title_reply_after'   => '</span><span class="ab-product-reviews__form-lead">' . esc_html__( 'Su opinión ayuda a otros equipos de compras a decidir con confianza.', 'abalturas' ) . '</span></div>',
					'comment_notes_after' => '',
					'label_submit'        => esc_html__( 'Publicar valoración', 'abalturas' ),
					'logged_in_as'        => '',
					'comment_field'       => '',
					'class_form'          => 'comment-form ab-review-form',
					'class_submit'        => 'submit ab-review-form__submit',
				);

				$name_email_required = (bool) get_option( 'require_name_email', 1 );
				$fields              = array(
					'author' => array(
						'label'        => __( 'Nombre', 'abalturas' ),
						'type'         => 'text',
						'value'        => $commenter['comment_author'],
						'required'     => $name_email_required,
						'autocomplete' => 'name',
					),
					'email'  => array(
						'label'        => __( 'Correo electrónico', 'abalturas' ),
						'type'         => 'email',
						'value'        => $commenter['comment_author_email'],
						'required'     => $name_email_required,
						'autocomplete' => 'email',
					),
				);

				$comment_form['fields'] = array();

				foreach ( $fields as $key => $field ) {
					$field_html  = '<p class="comment-form-' . esc_attr( $key ) . ' ab-review-form__field">';
					$field_html .= '<label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] );

					if ( $field['required'] ) {
						$field_html .= '&nbsp;<span class="required">*</span>';
					}

					$field_html .= '</label><input id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['type'] ) . '" autocomplete="' . esc_attr( $field['autocomplete'] ) . '" value="' . esc_attr( $field['value'] ) . '" size="30" ' . ( $field['required'] ? 'required' : '' ) . ' /></p>';

					$comment_form['fields'][ $key ] = $field_html;
				}

				$account_page_url = wc_get_page_permalink( 'myaccount' );
				if ( $account_page_url ) {
					$comment_form['must_log_in'] = '<p class="must-log-in ab-review-form__login">' . sprintf(
						esc_html__( 'Debe %1$siniciar sesión%2$s para publicar una valoración.', 'abalturas' ),
						'<a href="' . esc_url( $account_page_url ) . '">',
						'</a>'
					) . '</p>';
				}

				if ( wc_review_ratings_enabled() ) {
					$rating_required = wc_review_ratings_required();
					$comment_form['comment_field']  = '<div class="comment-form-rating ab-review-rating">';
					$comment_form['comment_field'] .= '<div class="ab-review-rating__header">';
					$comment_form['comment_field'] .= '<label for="rating" id="comment-form-rating-label" class="ab-review-field-label">';
					$comment_form['comment_field'] .= '<span class="ab-review-field-label__text">' . esc_html__( '¿Cómo calificaría este producto?', 'abalturas' ) . '</span>';
					if ( $rating_required ) {
						$comment_form['comment_field'] .= '<span class="ab-review-field-label__badge">' . esc_html__( 'Requerido', 'abalturas' ) . '</span>';
					}
					$comment_form['comment_field'] .= '</label>';
					$comment_form['comment_field'] .= '<span class="ab-review-rating__hint" id="ab-review-rating-hint" aria-live="polite">' . esc_html__( 'Toque las estrellas para calificar', 'abalturas' ) . '</span>';
					$comment_form['comment_field'] .= '</div>';
					$comment_form['comment_field'] .= '<div class="ab-review-rating__stars-wrap">';
					$comment_form['comment_field'] .= '<select name="rating" id="rating"' . ( $rating_required ? ' required' : '' ) . '>';
					$comment_form['comment_field'] .= '<option value="">' . esc_html__( 'Elija…', 'abalturas' ) . '</option>';
					$comment_form['comment_field'] .= '<option value="5">' . esc_html__( 'Excelente — 5 estrellas', 'abalturas' ) . '</option>';
					$comment_form['comment_field'] .= '<option value="4">' . esc_html__( 'Bueno — 4 estrellas', 'abalturas' ) . '</option>';
					$comment_form['comment_field'] .= '<option value="3">' . esc_html__( 'Aceptable — 3 estrellas', 'abalturas' ) . '</option>';
					$comment_form['comment_field'] .= '<option value="2">' . esc_html__( 'Regular — 2 estrellas', 'abalturas' ) . '</option>';
					$comment_form['comment_field'] .= '<option value="1">' . esc_html__( 'Deficiente — 1 estrella', 'abalturas' ) . '</option>';
					$comment_form['comment_field'] .= '</select></div></div>';
				}

				$comment_form['comment_field'] .= '<p class="comment-form-comment ab-review-form__field ab-review-form__field--comment">';
				$comment_form['comment_field'] .= '<label for="comment" class="ab-review-field-label">';
				$comment_form['comment_field'] .= '<span class="ab-review-field-label__text">' . esc_html__( 'Cuéntenos sobre el equipo', 'abalturas' ) . '</span>';
				$comment_form['comment_field'] .= '<span class="ab-review-field-label__badge">' . esc_html__( 'Requerido', 'abalturas' ) . '</span></label>';
				$comment_form['comment_field'] .= '<textarea id="comment" name="comment" rows="5" placeholder="' . esc_attr__( 'Cuéntenos su experiencia con el equipo (uso, calidad, entrega…)', 'abalturas' ) . '" required></textarea></p>';

				comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>
	<?php else : ?>
		<p class="woocommerce-verification-required ab-product-reviews__verify"><?php esc_html_e( 'Solo clientes que hayan comprado este producto pueden dejar una valoración.', 'abalturas' ); ?></p>
	<?php endif; ?>

	<div class="clear"></div>
</div>
