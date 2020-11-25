<?php
/**
 * Single Template of Katawara
 *
 * @package katawara
 */

$in_same_term   = apply_filters( 'katawara_prev_next_post_in_same_term', false );
$excluded_terms = apply_filters( 'katawara_prev_next_post_excluded_terms', '' );
$np_taxonomy    = apply_filters( 'katawara_prev_next_post_taxonomy', 'category' );
$post_previous  = get_previous_post( $in_same_term, $excluded_terms, $np_taxonomy );
$post_next      = get_next_post( $in_same_term, $excluded_terms, $np_taxonomy );
if ( $post_previous || $post_next ) {
	$options = array(
		'layout'                     => 'card-horizontal',
		'display_image'              => true,
		'display_image_overlay_term' => true,
		'display_excerpt'            => false,
		'display_date'               => true,
		'display_btn'                => false,
		'image_default_url'          => get_template_directory_uri() . '/assets/images/no-image.png',
		'overlay'                    => '',
		'body_prepend'               => '',
		'body_append'                => '',
	);
	?>

	<div class="vk_posts p-prev-next">

		<?php
		if ( $post_previous ) {
			$options['body_prepend'] = '<p class="p-prev-next_label">' . __( 'Previous article', 'katawara' ) . '</p>';
			$options['class_outer']  = 'card-sm vk_post-col-md-6';
			$options                 = apply_filters( 'katawara_next_prev_options', $options );
			VK_Component_Posts::the_view( $post_previous, $options );
		} else {
			echo '<div class="card card-noborder vk_posts vk_post-col-md-6"></div>';
		} // if post_previous.
		?>

		<?php
		if ( $post_next ) {
			$options['body_prepend'] = '<p class="p-prev-next_label">' . __( 'Next article', 'katawara' ) . '</p>';
			$options['class_outer']  = 'card-sm vk_post-col-md-6 card-horizontal-reverse p-prev-next_next';
			$options                 = apply_filters( 'katawara_next_prev_options', $options );
			VK_Component_Posts::the_view( $post_next, $options );
		} else {
			echo '<div class="card card-noborder vk_posts vk_post-col-md-6"></div>';
		} // if post_next.
		?>

	</div>
	<?php
} // if post_previous || post_next.
?>
