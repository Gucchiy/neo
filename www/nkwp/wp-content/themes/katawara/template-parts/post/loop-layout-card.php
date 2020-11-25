<?php
/**
 * Card Loop Template Part of Katawara
 *
 * @package katawara
 */

// Setting.
$default_options = array(
	'columns'      => array(
		'xs' => 1,
		'sm' => 2,
		'md' => 2,
		'lg' => 3,
		'xl' => 3,
	),
	'display'      => array(
		'image'    => true,
		'term'     => true,
		'excerpt'  => false,
		'date'     => true,
		'new_icon' => true,
		'button'   => true,
	),
	'new_text'     => __( 'New!!', 'katawara' ),
	'new_date'     => 7,
	'button_text'  => __( 'Read More', 'katawara' ),
	'button_align' => 'right',
);

$options = $default_options;
$options = apply_filters( 'katawara_loop_card_options', $options );
$options = wp_parse_args( $options, $default_options );

// Outer Class.
foreach ( $options['columns'] as $key => &$value ) {
	if ( 1 === $value ) {
		$value = 12;
	} elseif ( 2 === $value ) {
		$value = 6;
	} elseif ( 3 === $value ) {
		$value = 4;
	} elseif ( 4 === $value ) {
		$value = 3;
	} elseif ( 6 === $value ) {
		$value = 2;
	} else {
		$value = 4;
	}
}
unset( $value );

$outer_class = 'vk_post vk-post-postType-' . get_post_type() . ' card card-' . get_post_type();

foreach ( $options['columns'] as $key => $value ) {
	$outer_class .= ' vk_post-col-' . $key . '-' . $value;
}

$outer_class .= ' vk_post-btn-display';

// Button Align.
$button_align = '';
if ( 'left' === $options['columns'] ) {
	$button_align = 'text-left';
} elseif ( 'center' === $options['columns'] ) {
	$button_align = 'text-center';
} elseif ( 'right' === $options['columns'] ) {
	$button_align = 'text-right';
} else {
	$button_align = 'text-right';
}

// Image URL.
$image_url = '';
if ( has_post_thumbnail() ) {
	$thumbnail_id     = get_post_thumbnail_id( $post );
	$image_default_id = '';

	if ( function_exists( 'veu_package_is_enable' ) && veu_package_is_enable( 'default_thumbnail' ) ) {
		$image_option     = get_option( 'veu_defualt_thumbnail' );
		$image_default_id = ! empty( $image_option['default_thumbnail_image'] ) ? $image_option['default_thumbnail_image'] : '';
	}

	if ( ! empty( $thumbnail_id ) ) {
		$image_url = get_the_post_thumbnail_url();
	} elseif ( ! empty( $image_default_id ) ) {
		$image_object = wp_get_attachment_image_src( $image_default_id, 'large', true );
		$image_url    = $image_object[0];
	} else {
		$image_url = get_template_directory_uri() . '/inc/media-posts-bs4/package/images/no-image.png';
	}
} else {
	$image_url = get_template_directory_uri() . '/inc/media-posts-bs4/package/images/no-image.png';
}

// Display Term.
$taxonomies = get_the_taxonomies();
if ( $taxonomies ) {
	// get $meta_taxonomy name.
	// $meta_taxonomy   = key( $taxonomies );.
	// To avoid WooCommerce default tax.
	foreach ( $taxonomies as $key => $value ) {
		if ( 'product_type' !== $key ) {
			$meta_taxonomy = $key;
			break;
		}
	}

	$terms      = get_the_terms( get_the_ID(), $meta_taxonomy );
	$term_url   = get_term_link( $terms[0]->term_id, $meta_taxonomy );
	$term_name  = $terms[0]->name;
	$term_color = '';
	if ( class_exists( 'Vk_term_color' ) ) {
		$term_color = Vk_term_color::get_term_color( $terms[0]->term_id );
	}
}

// New.
$new_display = '';

$today = date_i18n( 'U' );
$entry = get_the_time( 'U' );
$kiji  = gmdate( 'U', ( $today - $entry ) ) / 86400;
if ( $options['new_date'] > $kiji ) {
	$new_display = '<span class="vk_post_title_new">' . $options['new_text'] . '</span>';
}
?>


<div id="post-<?php the_ID(); ?>" <?php post_class( $outer_class ); ?>>
	<?php if ( $options['display']['image'] ) : ?>
		<div class="vk_post_imgOuter" style="background-image:url(<?php echo esc_url( $image_url ); ?>)">
			<a href="<?php the_permalink(); ?>">
				<?php if ( $options['display']['term'] && $taxonomies ) : ?>
					<div class="card-img-overlay">
						<span class="vk_post_imgOuter_singleTermLabel" style="color:#fff;background-color:<?php echo esc_attr( $term_color ); ?>;border:none;"><?php echo esc_html( $term_name ); ?></span>
					</div>
				<?php endif; ?>
				<img src="<?php echo esc_url( $image_url ); ?>" alt="" class="vk_post_imgOuter_img card-img-top" loading="lazy">
			</a>
		</div><!-- [ /.vk_post_imgOuter ] -->
	<?php endif; ?>
	<div class="vk_post_body card-body">
		<h5 class="vk_post_title card-title">
			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
				<?php if ( $options['display']['new_icon'] ) : ?>
					<?php echo wp_kses_post( $new_display ); ?>
				<?php endif; ?>
			</a>
		</h5>
		<?php if ( $options['display']['date'] ) : ?>
			<div class="vk_post_date card-date published"><?php the_date(); ?></div>
		<?php endif; ?>
		<?php if ( $options['display']['excerpt'] ) : ?>
			<p class="vk_post_excerpt card-text"><?php the_excerpt(); ?></p>
		<?php endif; ?>
		<?php if ( $options['display']['button'] ) : ?>
			<div class="vk_post_btnOuter <?php echo esc_attr( $button_align ); ?>">
				<a class="btn btn-sm btn-primary vk_post_btn" href="<?php the_permalink(); ?>"><?php echo( esc_html( $options['button_text'] ) ); ?></a>
			</div>
		<?php endif; ?>
	</div><!-- [ /.card-body ] -->
</div>
