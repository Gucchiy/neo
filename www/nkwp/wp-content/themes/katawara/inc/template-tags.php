<?php

/*
  katawara_get_the_class_name
  Sanitize
  Head logo
  Chack use post top page
  Chack post type info
  katawara_is_mobile
  Archive title
  katawara_is_layout_onecolumn
  katawara_check_color_mode
/*-------------------------------------------*/


/*
  katawara_get_the_class_name
/*-------------------------------------------*/
function katawara_get_the_class_name( $position = '' ) {
	$class_names = array(
		'l-container_inner'     => 'l-container_inner',
		'l-main-section'     => 'l-main-section l-main-section-col-two baseSection',
		'l-side-section'     => 'l-side-section l-side-section-col-two baseSection',
	);
	if ( katawara_is_layout_onecolumn() ) {
		$class_names['l-site'] = 'l-site l-site-maincol-one';
		$class_names['l-container_inner'] = 'l-container_inner l-container_inner-col-one';
		$class_names['l-main-section'] = 'l-main-section l-main-section-col-one';
		$class_names['l-side-section'] = 'l-side-section l-side-section-col-one';
		if ( katawara_is_subsection_display() ) {
			$class_names['l-main-section'] .= ' l-main-section-marginBottom-on';
		}
	} else {
		// 2 column
		$options = get_option( 'katawara_theme_options' );
		$class_names['l-container_inner'] = 'l-container_inner l-container_inner-col-two';
		$class_names['l-main-section'] = 'l-main-section l-main-section-col-two';
		$class_names['l-side-section'] = 'l-side-section l-side-section-col-two';

		// sidebar-position
		if ( isset( $options['sidebar_position'] ) && $options['sidebar_position'] === 'left' ) {
			$class_names['l-main-section'] = 'l-main-section l-main-section-col-two l-main-section-pos-right';
			$class_names['l-side-section'] = 'l-side-section l-side-section-col-two l-side-section-pos-left';
		}
	}

	if ( katawara_is_siteContent_padding_off() ) {
		$class_names['l-container_inner'] .= ' l-container_inner-paddingVertical-off';
		// $class_names['mainSection'] .= ' mainSection-marginVertical-off';
	}

	// sidebar_fix
	if ( ! katawara_is_layout_onecolumn() ) {
		if ( empty( $options['sidebar_fix'] ) ) {
			$class_names['l-side-section'] .= ' l-side-section-sidebar-fix';
		}
	}

	if ( empty( $class_names[ $position ] ) ) {
		$class_names[ $position ] = esc_attr( $position );
	}

	$class_names = apply_filters( 'katawara_get_the_class_names', $class_names, $position );

	return $class_names[ $position ];
}

function katawara_the_class_name( $position = '', $extend = array() ) {
	echo katawara_get_the_class_name( $position, $extend );
}

/*
  Chack use post top page
/*-------------------------------------------*/
function katawara_get_page_for_posts() {
	// Get post top page by setting display page.
	$page_for_posts['post_top_id'] = get_option( 'page_for_posts' );

	// Set use post top page flag.
	$page_for_posts['post_top_use'] = ( $page_for_posts['post_top_id'] ) ? true : false;

	// When use post top page that get post top page name.
	$page_for_posts['post_top_name'] = ( $page_for_posts['post_top_use'] ) ? get_the_title( $page_for_posts['post_top_id'] ) : '';

	return $page_for_posts;
}


/*
  Chack post type info
/*-------------------------------------------*/
function katawara_get_post_type() {
	// Check use post top page
	$page_for_posts = katawara_get_page_for_posts();

	$woocommerce_shop_page_id = get_option( 'woocommerce_shop_page_id' );

	// Get post type slug
	/*
	-------------------------------------------*/
	// When WooCommerce taxonomy archive page , get_post_type() is does not work properly
	// $postType['slug'] = get_post_type();

	global $wp_query;
	if ( is_page() ) {
		$postType['slug'] = 'page';
	} elseif ( ! empty( $wp_query->query_vars['post_type'] ) ) {

		$postType['slug'] = $wp_query->query_vars['post_type'];
		// Maybe $wp_query->query_vars['post_type'] is usually an array...
		if ( is_array( $postType['slug'] ) ) {
			$postType['slug'] = current( $postType['slug'] );
		}
	} elseif ( is_tax() ) {
		// Case of tax archive and no posts
		$taxonomy         = get_queried_object()->taxonomy;
		$postType['slug'] = get_taxonomy( $taxonomy )->object_type[0];
	} else {
		// This is necessary that when no posts.
		$postType['slug'] = 'post';
	}

	// Get custom post type name
	/*-------------------------------------------*/
	$post_type_object = get_post_type_object( $postType['slug'] );
	if ( $post_type_object ) {
		$allowed_html = array(
			'span' => array( 'class' => array() ),
			'b'    => array(),
		);
		if ( $page_for_posts['post_top_use'] && $postType['slug'] == 'post' ) {
			$postType['name'] = wp_kses( get_the_title( $page_for_posts['post_top_id'] ), $allowed_html );
		} elseif ( $woocommerce_shop_page_id && $postType['slug'] == 'product' ) {
			$postType['name'] = wp_kses( get_the_title( $woocommerce_shop_page_id ), $allowed_html );
		} else {
			$postType['name'] = esc_html( $post_type_object->labels->name );
		}
	}

	// Get custom post type archive url
	/*-------------------------------------------*/
	if ( $page_for_posts['post_top_use'] && $postType['slug'] == 'post' ) {
		$postType['url'] = esc_url( get_the_permalink( $page_for_posts['post_top_id'] ) );
	} elseif ( $woocommerce_shop_page_id && $postType['slug'] == 'product' ) {
		$postType['url'] = esc_url( get_the_permalink( $woocommerce_shop_page_id ) );
	} else {
		$postType['url'] = esc_url( get_post_type_archive_link( $postType['slug'] ) );
	}

	$postType = apply_filters( 'katawara_postType_custom', $postType );
	return $postType;
}


/*
  katawara_is_mobile
/*-------------------------------------------*/
function katawara_is_mobile() {
	$useragents = array(
		'iPhone', // iPhone
		'iPod', // iPod touch
		'Android.*Mobile', // 1.5+ Android *** Only mobile
		'Windows.*Phone', // *** Windows Phone
		'dream', // Pre 1.5 Android
		'CUPCAKE', // 1.5+ Android
		'blackberry9500', // Storm
		'blackberry9530', // Storm
		'blackberry9520', // Storm v2
		'blackberry9550', // Storm v2
		'blackberry9800', // Torch
		'webOS', // Palm Pre Experimental
		'incognito', // Other iPhone browser
		'webmate', // Other iPhone browser
	);
	$pattern    = '/' . implode( '|', $useragents ) . '/i';
	if ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
		$is_mobile = preg_match( $pattern, $_SERVER['HTTP_USER_AGENT'] );
	} else {
		$is_mobile = false;
	}
	return apply_filters( 'katawara_is_mobile', $is_mobile );
}

/*
  Archive title
/*-------------------------------------------*/
add_filter( 'get_the_archive_title', 'katawara_get_the_archive_title' );
function katawara_get_the_archive_title() {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = sprintf( __( 'Author: %s', 'katawara' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = get_the_date( _x( 'Y', 'yearly archives date format', 'katawara' ) );
	} elseif ( is_month() ) {
		$title = get_the_date( _x( 'F Y', 'monthly archives date format', 'katawara' ) );
	} elseif ( is_day() ) {
		$title = get_the_date( _x( 'F j, Y', 'daily archives date format', 'katawara' ) );
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	} elseif ( is_home() && ! is_front_page() ) {
		$katawara_page_for_posts = katawara_get_page_for_posts();
		$title                    = $katawara_page_for_posts['post_top_name'];
	} else {
		global $wp_query;
		// get post type
		$postType = $wp_query->query_vars['post_type'];
		if ( $postType ) {
			$title = get_post_type_object( $postType )->labels->name;
		} else {
			$title = __( 'Archives', 'katawara' );
		}
	}
	return apply_filters( 'katawara_get_the_archive_title', $title );
}

/*
  CopyRight
/*-------------------------------------------*/
function katawara_the_footerCopyRight() {

	// copyright
	/*------------------*/
	$katawara_footerCopyRight = '<p>' . sprintf( __( 'Copyright &copy; %s All Rights Reserved.', 'katawara' ), get_bloginfo( 'name' ) ) . '</p>';
	echo apply_filters( 'katawara_footerCopyRightCustom', $katawara_footerCopyRight );

	// Powered
	/*------------------*/
	$katawara_footerPowered = __( '<p>Powered by <a href="https://wordpress.org/">WordPress</a> &amp; <a href="https://vws.vektor-inc.co.jp/" target="_blank" title="Free WordPress Theme katawara"> katawara Theme</a> by Vektor,Inc. technology.</p>', 'katawara' );
	echo apply_filters( 'katawara_footerPoweredCustom', $katawara_footerPowered );

}

function katawara_get_theme_name() {
	return apply_filters( 'katawara_theme_name', 'katawara' );
}
function katawara_get_theme_name_short() {
	return apply_filters( 'katawara_get_theme_name_short', 'KTWR' );
}
function katawara_get_prefix() {
	$prefix = apply_filters( 'katawara_get_prefix', 'KTWR' );
	if ( $prefix ) {
		$prefix .= ' ';
	}
	return $prefix;
}
function katawara_get_prefix_customize_panel() {
	$prefix_customize_panel = apply_filters( 'katawara_get_prefix_customize_panel', 'Katawara' );
	if ( $prefix_customize_panel ) {
		$prefix_customize_panel .= ' ';
	}
	return $prefix_customize_panel;
}

/*
  katawara_check_color_mode
/*-------------------------------------------*/
/**
 * [katawara_check_color_mode description]
 *
 * @param  string  $input         input color code
 * @param  boolean $return_detail If false that return 'mode' only
 * @return string                 If $return_detail == false that return light ot dark
 */
function katawara_check_color_mode( $input = '#ffffff', $return_detail = false ) {
	$color['input'] = $input;
	// delete #
	$color['input'] = preg_replace( '/#/', '', $color['input'] );

	$color_len = strlen( $color['input'] );

	// Only 3 character
	if ( $color_len === 3 ) {
		$color_red   = substr( $color['input'], 0, 1 ) . substr( $color['input'], 0, 1 );
		$color_green = substr( $color['input'], 1, 1 ) . substr( $color['input'], 1, 1 );
		$color_blue  = substr( $color['input'], 2, 1 ) . substr( $color['input'], 2, 1 );
	} elseif ( $color_len === 6 ) {
		$color_red   = substr( $color['input'], 0, 2 );
		$color_green = substr( $color['input'], 2, 2 );
		$color_blue  = substr( $color['input'], 4, 2 );
	} else {
		$color_red   = 'ff';
		$color_green = 'ff';
		$color_blue  = 'ff';
	}

	// change 16 to 10 number
	$color_red           = hexdec( $color_red );
	$color_green         = hexdec( $color_green );
	$color_blue          = hexdec( $color_blue );
	$color['number_sum'] = $color_red + $color_green + $color_blue;

	$color_change_point = 765 / 2;

	if ( $color['number_sum'] > $color_change_point ) {
		$color['mode'] = 'light';
	} else {
		$color['mode'] = 'dark';
	}

	if ( $return_detail ) {
		return $color;
	} else {
		return $color['mode'];
	}
}
