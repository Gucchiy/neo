<?php
/**
 * Layout Controller of Katawara.
 *
 * @package Katawara
 */

/**
 * Array of Layout Taeget
 */
function katawara_layout_target_array() {
	$array = array(
		'error404' => array(
			'function' => 'is_404',
		),
		'search'   => array(
			'function' => 'is_search',
		),
	);
	return $array;
}

/**
 * Katawara Is Layout One Column
 *
 * @since Katawara 0.0.0
 * @return boolean
 */
function katawara_is_layout_onecolumn() {
	$onecolumn = false;
	$options   = get_option( 'katawara_theme_options' );
	global $wp_query;

	$array = katawara_layout_target_array();

	foreach ( $array as $key => $value ) {
		if ( call_user_func( $value['function'] ) ) {
			if ( isset( $options['layout'][ $key ] ) ) {
				if ( 'col-one' === $options['layout'][ $key ] || 'col-one-no-subsection' === $options['layout'][ $key ] ) {
					$onecolumn = true;
				}
			}
		}
	}

	// show_on_front 'page' case
	if ( is_front_page() && ! is_home() ) {
		if ( isset( $options['layout']['front-page'] ) ) {
			if ( 'col-one' === $options['layout']['front-page'] || 'col-one-no-subsection' === $options['layout']['front-page'] ) {
				$onecolumn = true;
			}
		} else {
			$page_on_front_id = get_option( 'page_on_front' );
			if ( $page_on_front_id ) {
				$template = get_post_meta( $page_on_front_id, '_wp_page_template', true );
				if ( 'page-onecolumn.php' === $template || 'page-lp.php' === $template ) {
					$onecolumn = true;
				}
			}
		}
	// show_on_front 'posts' case
	} elseif ( is_front_page() && is_home() ) {
		if ( isset( $options['layout']['front-page'] ) ) {
			if ( 'col-one' === $options['layout']['front-page'] || 'col-one-no-subsection' === $options['layout']['front-page'] ) {
				$onecolumn = true;
			} elseif ( isset( $options['layout']['archive-post'] ) ) {
				if ( 'col-one' === $options['layout']['archive-post'] || 'col-one-no-subsection' === $options['layout']['archive-post'] ) {
					$onecolumn = true;
				}
			}
		}
	} elseif ( ! is_front_page() && is_home() ) {
		if ( isset( $options['layout']['archive-post'] ) ) {
			if ( 'col-one' === $options['layout']['archive-post'] || 'col-one-no-subsection' === $options['layout']['archive-post'] ) {
				$onecolumn = true;
			}
		}
	}

	$additional_post_types = get_post_types(
		array(
			'public'   => true,
			'_builtin' => false,
		),
		'names'
	);

	/**
	 * アーカイブページの場合
	 */
	if ( is_archive() && ! is_search() ) {
		$current_post_type_info = katawara_get_post_type();
		$archive_post_types = array( 'post' ) + $additional_post_types;
		foreach ( $archive_post_types as $archive_post_type ) {
			if ( isset( $options['layout'][ 'archive-' . $archive_post_type ] ) && $current_post_type_info['slug'] === $archive_post_type ) {
				if ( 'col-one' === $options['layout'][ 'archive-' . $archive_post_type ] || 'col-one-no-subsection' === $options['layout'][ 'archive-' . $archive_post_type ] ) {
					$onecolumn = true;
				}
			}
		}
	}

	if ( is_singular() ) {
		global $post;
		$single_post_types = array( 'post', 'page' ) + $additional_post_types;
		foreach ( $single_post_types as $single_post_type ) {
			if ( isset( $options['layout'][ 'single-' . $single_post_type ] ) && get_post_type() === $single_post_type ) {
				if ( 'col-one' === $options['layout'][ 'single-' . $single_post_type ] || 'col-one-no-subsection' === $options['layout'][ 'single-' . $single_post_type ] ) {
					$onecolumn = true;
				}
			}
		}
		if ( is_page() ) {
			$template           = get_post_meta( $post->ID, '_wp_page_template', true );
			$template_onecolumn = array(
				'page-onecolumn.php',
				'page-lp.php',
			);
			if ( in_array( $template, $template_onecolumn, true ) ) {
				$onecolumn = true;
			}
		}
		if ( isset( $post->_katawara_design_setting['layout'] ) ) {
			if ( 'col-two' === $post->_katawara_design_setting['layout'] ) {
				$onecolumn = false;
			} elseif ( 'col-one-no-subsection' === $post->_katawara_design_setting['layout'] ) {
				$onecolumn = true;
			} elseif ( 'col-one' === $post->_katawara_design_setting['layout'] ) {
				$onecolumn = true;
			}
		}
	}
	return apply_filters( 'katawara_is_layout_onecolumn', $onecolumn );
}

/**
 * Katawara Is Subsection Display
 *
 * @since Katawara 0.0.0
 * @return boolean
 */
function katawara_is_subsection_display() {
	global $post;
	$return  = true;
	$options = get_option( 'katawara_theme_options' );

	$array = katawara_layout_target_array();

	foreach ( $array as $key => $value ) {
		if ( call_user_func( $value['function'] ) ) {
			if ( isset( $options['layout'][ $key ] ) ) {
				if ( 'col-one-no-subsection' === $options['layout'][ $key ] ) {
					$return = false;
				}
			}
		}
	}

	$additional_post_types = get_post_types(
		array(
			'public'   => true,
			'_builtin' => false,
		),
		'names'
	);
	// break and hidden.
	if ( is_front_page() && ! is_home() ) {

		if ( isset( $options['layout']['front-page'] ) && 'col-one-no-subsection' === $options['layout']['front-page'] ) {
			$return = false;
		}
		if ( is_page() ) {
			$template           = get_post_meta( $post->ID, '_wp_page_template', true );
			$template_onecolumn = array(
				'page-onecolumn.php',
				'page-lp.php',
			);
			if ( in_array( $template, $template_onecolumn, true ) ) {
				$return = false;
			}
			if ( isset( $post->_katawara_design_setting['layout'] ) ) {

				if ( 'col-one-no-subsection' === $post->_katawara_design_setting['layout'] ) {
					$return = false;
				} elseif ( 'col-two' === $post->_katawara_design_setting['layout'] ) {
					$return = true;
				} elseif ( 'col-one' === $post->_katawara_design_setting['layout'] ) {
					/* 1 column but subsection is exist */
					$return = true;
				}
			}
		}

	} elseif ( is_front_page() && is_home() ) {
		if ( isset( $options['layout']['front-page'] ) && 'col-one-no-subsection' === $options['layout']['front-page'] ) {
			$return = false;
		} elseif ( isset( $options['layout']['archive-post'] ) && 'col-one-no-subsection' === $options['layout']['archive-post'] ) {
			$return = false;
		}
	} elseif ( ! is_front_page() && is_home() ) {
		if ( isset( $options['layout']['archive-post'] ) && 'col-one-no-subsection' === $options['layout']['archive-post'] ) {
			$return = false;
		}
	} elseif ( is_archive() && ! is_search() ) {
		$current_post_type_info = katawara_get_post_type();
		$archive_post_types = array( 'post' ) + $additional_post_types;
		foreach ( $archive_post_types as $archive_post_type ) {

			if ( isset( $options['layout'][ 'archive-' . $archive_post_type ] ) && $current_post_type_info['slug'] === $archive_post_type ) {
				if ( 'col-one-no-subsection' === $options['layout'][ 'archive-' . $archive_post_type ] ) {
					$return = false;
				}
			}
		}
	} elseif ( is_singular() ) {
		$single_post_types = array( 'post', 'page' ) + $additional_post_types;
		foreach ( $single_post_types as $single_post_type ) {
			if ( isset( $options['layout'][ 'single-' . $single_post_type ] ) && get_post_type() === $single_post_type ) {
				if ( 'col-one-no-subsection' === $options['layout'][ 'single-' . $single_post_type ] ) {
					$return = false;
				}
			}
		}
		if ( is_page() ) {
			$template           = get_post_meta( $post->ID, '_wp_page_template', true );
			$template_onecolumn = array(
				'page-onecolumn.php',
				'page-lp.php',
			);
			if ( in_array( $template, $template_onecolumn, true ) ) {
				$return = false;
			}
		}
		if ( isset( $post->_katawara_design_setting['layout'] ) ) {
			if ( 'col-one-no-subsection' === $post->_katawara_design_setting['layout'] ) {
				$return = false;
			} elseif ( 'col-two' === $post->_katawara_design_setting['layout'] ) {
				$return = true;
			} elseif ( 'col-one' === $post->_katawara_design_setting['layout'] ) {
				/* 1 column but subsection is exist */
				$return = true;
			}
		}
	}
	return apply_filters( 'katawara_is_subsection_display', $return );
}

/**
 * Page header and Breadcrumb Display or hidden
 *
 * @since Katawara 0.0.0
 * @return boolean
 */
function katawara_is_page_header_and_breadcrumb() {
	$return = true;
	if ( is_singular() ) {
		global $post;

		if ( ! empty( $post->_katawara_design_setting['hidden_page_header_and_breadcrumb'] ) ) {
			$return = false;
		}
	}
	return apply_filters( 'katawara_is_page_header_and_breadcrumb', $return );
}

function katawara_is_siteContent_padding_off() {
	if ( is_singular() ) {
		global $post;
		$cf = $post->_katawara_design_setting;
		if ( ! empty( $cf['siteContent_padding'] ) ) {
			return true;
		}
	}
}
