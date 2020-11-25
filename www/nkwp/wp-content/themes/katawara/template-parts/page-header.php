<?php
/**
 * Page Header Template Part of Katawara
 *
 * @package katawara
 */

// Set tag weight.
global $katawara_theme_options;
$page_for_posts = katawara_get_page_for_posts();
$get_post_type  = katawara_get_post_type();
$options        = get_option( 'vk_page_header' );

if ( is_single() && Vk_Page_Header::get_layout() === 'post_title_and_meta' ){
	$page_title_tag = 'h1';
} else if ( $page_for_posts['post_top_use'] ) {
	// Use post top page（ Archive title wrap to div ）.
	if ( is_category() || is_tag() || is_author() || is_tax() || is_single() || is_date() ) {
		$page_title_tag = 'div';
	} else {
		$page_title_tag = 'h1';
	}
	// Don't use post top（ Archive title wrap to h1 ）.
} else {
	if ( ! is_single() ) {
		$page_title_tag = 'h1';
	} else {
		$page_title_tag = 'div';
	}
}

$page_meta_html = '';
if ( is_single() && isset( $options[ 'displaytype_' . $get_post_type['slug'] ] ) && 'post_title_and_meta' === $options[ 'displaytype_' . $get_post_type['slug'] ] ) {
	$page_meta_html .= '<div class="p-entry_header">';
	$page_meta_html .= '<div class="p-entry_meta"><div class="p-entry_meta_times">';
	if ( 'product' !== get_post_type() ) {
		$page_meta_html    .= '<span class="published p-entry_meta_items p-entry_meta_posttimes">' . get_the_date() . '</span>';
		$meta_hidden_update = ( ! empty( $katawara_theme_options['postUpdate_hidden'] ) ) ? ' p-entry_meta_hidden' : '';
		$page_meta_html    .= '<span class="p-entry_meta_items p-entry_meta_updated' . $meta_hidden_update . '"><span class="updated">' . get_the_modified_date( '' ) . '</span></span>';
		$author             = get_the_author();
		if ( $author ) {
			$meta_hidden_author = ( ! empty( $katawara_theme_options['postAuthor_hidden'] ) ) ? ' p-entry_meta_hidden' : '';
			$page_meta_html    .= '<span class="vcard author p-entry_meta_items p-entry_meta_items_author' . $meta_hidden_author . '"><span class="fn">' . $author . '</span></span>';
		}
	}
	$page_meta_html .= '</div>';
	$taxonomies      = get_the_taxonomies();
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
		$meta_terms = get_the_terms( get_the_ID(), $meta_taxonomy );

		foreach ( $meta_terms as $key => $meta_term ) {
			$meta_term_url   = get_term_link( $meta_term->term_id, $meta_taxonomy );
			$meta_term_name  = $meta_term->name;
			$meta_term_color = '';
			$page_meta_html .= '<span class="p-entry_meta_items_term"><a href="' . $meta_term_url . '" class="p-entry_meta_items_term_button">' . $meta_term_name . '</a></span>';
		} // foreach.
	}
	$page_meta_html .= '</div></div>';
}

$page_header_class = 'p-page-header';
if ( is_single() && isset( $options[ 'displaytype_' . $get_post_type['slug'] ] ) ) {
	if ( 'post_title_and_meta' === $options[ 'displaytype_' . $get_post_type['slug'] ] ) {
		$page_header_class .= ' p-page-header--type--post_title_and_meta';
	}
}

// Set wrap tags.
$page_title_html_before  = '<div class="' . $page_header_class . '"><div class="l-container">' . "\n";
$page_title_html_before .= '<' . $page_title_tag . ' class="p-page-header_title">' . "\n";
$page_title_html_after   = '</' . $page_title_tag . '>' . "\n";
$page_title_html_after  .= $page_meta_html;
$page_title_html_after  .= '</div></div><!-- [ /.page-header ] -->' . "\n";

// Set display title name.
$page_title = '';

if ( is_search() ) {
	// translators: Search Result with Keyword.
			if (  ! empty( get_search_query() ) ){
				$page_title =  sprintf( __( 'Search Results for : %s', 'katawara' ), get_search_query() );
			} else {
				$page_title =  __( 'Search Results', 'katawara' );
			}
} elseif ( ! empty( $wp_query->query_vars['bbp_search'] ) ) {
	$bbp_search = esc_html( urldecode( $wp_query->query_vars['bbp_search'] ) );
	// translators: Search Result with Keyword on bbpress.
	$page_title = sprintf( __( 'Search Results for : %s', 'katawara' ), $bbp_search );
} elseif ( is_404() ) {
	// translators: Post Not Found.
	$page_title = __( 'Not found', 'katawara' );
} elseif ( is_category() || is_tag() || is_tax() || is_home() || is_author() || is_archive() ) {
	// Case of post type === post.
	if ( 'post' === $get_post_type['slug'] ) {
		// Case of use post top page.
		if ( $page_for_posts['post_top_use'] ) {
			$page_title = $page_for_posts['post_top_name'];
		} else {
			// Case of don't use post top page.
			$page_title = get_the_archive_title();
		} // if $page_for_posts post_top_use.
	} else {
		// Case of custom post type.
		$page_title = $get_post_type['name'];
	}
} elseif ( is_page() || is_attachment() ) {
	$page_title = get_the_title();
} elseif ( is_single() ) {
	if ( isset( $options[ 'displaytype_' . $get_post_type['slug'] ] ) && 'post_title_and_meta' === $options[ 'displaytype_' . $get_post_type['slug'] ] ) {
		$page_title = get_the_title();
	} elseif ( isset( $options[ 'displaytype_' . $get_post_type['slug'] ] ) && 'thumbnail' === $options[ 'displaytype_' . $get_post_type['slug'] ] ) {
		$page_title = '';
	} elseif ( 'post' === $get_post_type['slug'] ) {
		$taxonomies = get_the_taxonomies();
		if ( $taxonomies ) {
			$ph_taxonomy = key( $taxonomies );
			$taxo_cates  = get_the_terms( get_the_ID(), $ph_taxonomy );
			$page_title  = esc_html( $taxo_cates[0]->name );
		} else {
			// Case of no category.
			$page_title = $get_post_type['name'];
		}
	} else {
		$page_title = $get_post_type['name'];
	}
}
$page_title = apply_filters( 'katawara_custom_page_title', $page_title );

// Print.
$page_title_html = $page_title_html_before;
// allow tags.
$allowed_html     = array(
	'i'      => array(
		'class' => array(),
	),
	'br'     => array(),
	'strong' => array(),
);
$page_title_html .= wp_kses( $page_title, $allowed_html );
$page_title_html .= $page_title_html_after;
$page_title_html  = apply_filters( 'katawara_page_title_html', $page_title_html );
echo wp_kses_post( $page_title_html );
