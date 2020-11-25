<?php
/**
 * VK Breadcrumb
 *
 * @package katawara
 */

/**
 * VK Breadcrumb
 */
class VK_Breadcrumb {

	/**
	 * Array of Breadcrumb.
	 */
	public static function get_breadcrumb_array() {
		global $wp_query;
		global $vk_get_post_type;
		// ここで関数を呼び出さないと関数が正常に動作しない.
		$get_post_type    = call_user_func( $vk_get_post_type );
		$post_type        = $get_post_type['slug'];
		$post_type_object = get_post_type_object( $post_type );
		$show_on_front    = get_option( 'show_on_front' );
		$page_for_post    = get_option( 'page_for_posts' );
		$post_top_name    = ! empty( $page_for_post ) ? get_the_title( $page_for_post ) : '';
		$post_top_url     = isset( $page_for_post ) ? get_permalink( $page_for_post ) : '';
		$post             = $wp_query->get_queried_object();

		// HOME.
		$breadcrumb_array = array(
			array(
				'name'  => __( 'HOME', 'katawara' ),
				'id'    => 'panHome',
				'url'   => home_url(),
				'class' => 'home',
				'icon'  => 'fas fa-fw fa-home',
			),
		);

		// Second.
		if ( is_search() ) {
			if ( ! empty( get_search_query() ) ){
				$search_text =  sprintf( __( 'Search Results for : %s', 'katawara' ), get_search_query() );
			} else {
				$search_text =  __( 'Search Results', 'katawara' );
			}
			$breadcrumb_array[] = array(
				// translators: Search Title.
				'name'  => $search_text,
				'id'    => '',
				'url'   => '',
				'class' => '',
				'icon'  => '',
			);
		} elseif ( is_single() || is_page() || is_category() || is_tag() || is_tax() || is_post_type_archive() || is_date() ) {
			if ( 'post' === $post_type && 'page' === $show_on_front && $page_for_post) {
				$breadcrumb_array[] = array(
					'name'  => $post_top_name,
					'id'    => '',
					'url'   => $post_top_url,
					'class' => '',
					'icon'  => '',
				);
			} elseif ( is_post_type_archive() && ! is_date() ) {
				$breadcrumb_array[] = array(
					'name'  => get_the_archive_title( $post_type ),
					'id'    => '',
					'url'   => '',
					'class' => '',
					'icon'  => '',
				);
			} elseif ( 'post' !== $post_type && 'page' !== $post_type ) {
				$breadcrumb_array[] = array(
					'name'  => $post_type_object->label,
					'id'    => '',
					'url'   => get_post_type_archive_link( $post_type ),
					'class' => '',
					'icon'  => '',
				);
			}

			if ( is_single() || is_page() ) {
				/**
				 * Single or Page.
				 */
				// Taxonomy of Single or Page.
				$taxonomies = get_the_taxonomies();
				if ( $taxonomies ) {
					// To avoid WooCommerce default tax.
					foreach ( $taxonomies as $key => $value ) {
						if ( 'product_type' !== $key ) {
							$taxonomy = $key;
							break;
						}
					}
					$terms = get_the_terms( get_the_ID(), $taxonomy );
					// keeps only the first term (categ).
					$term = reset( $terms );
					if ( 0 !== $term->parent ) {

						// Get term ancestors info.
						$ancestors = array_reverse( get_ancestors( $term->term_id, $taxonomy ) );
						// Print loop term ancestors.
						foreach ( $ancestors as $ancestor ) {
							$pan_term           = get_term( $ancestor, $taxonomy );
							$breadcrumb_array[] = array(
								'name'  => esc_html( $pan_term->name ),
								'id'    => '',
								'url'   => get_term_link( $ancestor, $taxonomy ),
								'class' => '',
								'icon'  => '',
							);
						}
					}
					$term_url           = get_term_link( $term->term_id, $taxonomy );
					$breadcrumb_array[] = array(
						'name'  => $term->name,
						'id'    => '',
						'url'   => $term_url,
						'class' => '',
						'icon'  => '',
					);
				}

				// Parent of Page or Single.
				if ( 0 !== $post->post_parent ) {
					$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
					foreach ( $ancestors as $ancestor ) {
						$breadcrumb_array[] = array(
							'name'  => get_the_title( $ancestor ),
							'id'    => '',
							'url'   => get_permalink( $ancestor ),
							'class' => '',
							'icon'  => '',
						);
					}
				}

				// The Single or Page.
				$breadcrumb_array[] = array(
					'name'  => get_the_title(),
					'id'    => '',
					'url'   => '',
					'class' => '',
					'icon'  => '',
				);
			} elseif ( is_category() || is_tag() || is_tax() ) {
				/**
				 * Taxonomy Archive.
				 */
				$now_term        = $wp_query->queried_object->term_id;
				$now_term_parent = $wp_query->queried_object->parent;
				$now_taxonomy    = $wp_query->queried_object->taxonomy;

				if ( 0 !== $now_term_parent ) {
					// Get Ancecter Taxonomy Reverse.
					$ancestors = array_reverse( get_ancestors( $now_term, $now_taxonomy ) );
					// Parent Taxonomy.
					foreach ( $ancestors as $ancestor ) {
						$pan_term           = get_term( $ancestor, $now_taxonomy );
						$breadcrumb_array[] = array(
							'name'  => esc_html( $pan_term->name ),
							'id'    => '',
							'url'   => get_term_link( $ancestor, $now_taxonomy ),
							'class' => '',
							'icon'  => '',
						);
					}
				}

				$breadcrumb_array[] = array(
					'name'  => esc_html( single_cat_title( '', '', false ) ),
					'id'    => '',
					'url'   => '',
					'class' => '',
					'icon'  => '',
				);
			} elseif ( is_date() ) {
				$breadcrumb_array[] = array(
					'name'  => get_the_archive_title(),
					'id'    => '',
					'url'   => '',
					'class' => '',
					'icon'  => '',
				);
			}
		} elseif ( is_home() && ! is_front_page() ) {
			$breadcrumb_array[] = array(
				'name'  => $post_top_name,
				'id'    => '',
				'url'   => '',
				'class' => '',
				'icon'  => '',
			);
		} elseif ( is_author() ) {
			$breadcrumb_array[] = array(
				'name'  => get_the_archive_title(),
				'id'    => '',
				'url'   => '',
				'class' => '',
				'icon'  => '',
			);
		} elseif ( is_attachment() ) {
			$breadcrumb_array[] = array(
				'name'  => get_the_title(),
				'id'    => '',
				'url'   => '',
				'class' => '',
				'icon'  => '',
			);
		} elseif ( is_404() ) {
			$breadcrumb_array[] = array(
				'name'  => __( 'Not found', 'katawara' ),
				'id'    => '',
				'url'   => '',
				'class' => '',
				'icon'  => '',
			);
		}

		return apply_filters( 'vk_breadcrumb_array', $breadcrumb_array );
	}

	/**
	 * HTML of Breadcrumb.
	 *
	 * @return string
	 */
	public static function get_the_html() {
		$breadcrumb_array = self::get_breadcrumb_array();
		/**
		 * Microdata.
		 * http://schema.org/BreadcrumbList
		 */
		$microdata_li        = ' itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"';
		$microdata_li_a      = ' itemprop="item"';
		$microdata_li_a_span = ' itemprop="name"';

		$breadcrumb_html  = '<!-- [ .p-breadcrumbs ] -->';
		$breadcrumb_html .= '<ol class="p-breadcrumbs" itemtype="http://schema.org/BreadcrumbList">';

		foreach ( $breadcrumb_array as $breadcrumb ) {
			$name  = $breadcrumb['name'];
			$id    = ! empty( $breadcrumb['id'] ) ? ' id="' . $breadcrumb['id'] . '"' : '';
			$url   = ! empty( $breadcrumb['url'] ) ? $breadcrumb['url'] : '' ;
			$class = ! empty( $breadcrumb['class'] ) ? ' class="' . $breadcrumb['class'] . '"' : '';
			$icon  = ! empty( $breadcrumb['icon'] ) ? '<i class="' . $breadcrumb['icon'] . '"></i>' : '';

			if ( ! empty( $url ) ) {
				$breadcrumb_html .= '<li' . $id . ' class="p-breadcrumbs_item"' . $microdata_li . '>';
				$breadcrumb_html .= '<a' . $class . $microdata_li_a . ' href="' . $url . '">';
				$breadcrumb_html .= '<span' . $microdata_li_a_span . '>' . $icon . $name . '</span>';
				$breadcrumb_html .= '</a>';
				$breadcrumb_html .= '</li>';
			} else {
				$breadcrumb_html .= '<li' . $id . ' class="p-breadcrumbs_item">';
				$breadcrumb_html .= '<span>' . $icon . $name . '</span>';
				$breadcrumb_html .= '</li>';
			}


		}
		$breadcrumb_html .= '</ol>';
		$breadcrumb_html .= '<!-- [ /.p-breadcrumbs ] -->';

		return $breadcrumb_html;
	}

	/**
	 * Display Breadcrumb.
	 */
	public static function the_html() {
		$allowed_html = array(
			'ol'   => array(
				'id'        => array(),
				'class'     => array(),
				'itemprop'  => array(),
				'itemscope' => array(),
				'itemtype'  => array(),
			),
			'li'   => array(
				'id'        => array(),
				'class'     => array(),
				'itemprop'  => array(),
				'itemscope' => array(),
				'itemtype'  => array(),
			),
			'a'    => array(
				'id'       => array(),
				'class'    => array(),
				'href'     => array(),
				'target'   => array(),
				'itemprop' => array(),
			),
			'span' => array(
				'id'        => array(),
				'class'     => array(),
				'itemprop'  => array(),
				'itemscope' => array(),
				'itemtype'  => array(),
			),
			'i'    => array(
				'id'    => array(),
				'class' => array(),
			),
		);
		echo wp_kses( self::get_the_html(), $allowed_html );
	}
}

new VK_Breadcrumb();
