<?php
/**
 * VK Media Posts BS4 Config
 *
 * @package VK Media Posts BS4
 */

if ( ! class_exists( 'VK_MEDIA_POSTS_BS4' ) ) {

	define( 'VK_MEDIA_POSTS_BS4_URL', get_template_directory_uri() . '/inc/media-posts-bs4/package/' );
	define( 'VK_MEDIA_POSTS_BS4_DIR', dirname( __FILE__ ) );
	define( 'VK_MEDIA_POSTS_BS4_VERSION', '1.0' );

	global $system_name;
	$system_name = 'Katawara';

	global $customize_section_name;
	$customize_section_name = 'Katawara';

	global $vk_mpbs4_archive_layout_class;
	$vk_mpbs4_archive_layout_class = '.l-main-section';

	require_once dirname( __FILE__ ) . '/package/class-vk-media-posts-bs4.php';

	/**
	 * Archive Loop change
	 * アーカイブループのレイアウトを改変するかどうかの判定
	 *
	 * @param array   $post_type post type.
	 * @param boolean $flag Change layout or not.
	 */
	function katawara_is_loop_layout_change_bs4_flag_bs4( $post_type = 'post', $flag = false ) {
		$vk_post_type_archive = get_option( 'vk_post_type_archive' );
		// 指定の投稿タイプアーカイブのレイアウトに値が存在する場合.
		if ( ! empty( $vk_post_type_archive[ $post_type ]['layout'] ) ) {
			// デフォルトじゃない場合.
			if ( 'default' !== $vk_post_type_archive[ $post_type ]['layout'] ) {
				$flag = true;
			}
		}
		return $flag;
	}

	/**
	 * アーカイブループを改変するかどうかの指定
	 *
	 * @param boolean $flag Change archive loop or not.
	 */
	function katawara_is_loop_layout_change_bs4( $flag ) {
		$post_type_info = katawara_get_post_type();
		$post_type      = $post_type_info['slug'];

		if ( is_author() ) {
			$post_type = 'author';
		}

		$flag = katawara_is_loop_layout_change_bs4_flag_bs4( $post_type, $flag );
		return $flag;
	}
	add_filter( 'is_katawara_extend_loop', 'katawara_is_loop_layout_change_bs4' );

	/**
	 * ループ改変実行
	 */
	function katawara_do_loop_layout_change_bs4() {

		$vk_post_type_archive = get_option( 'vk_post_type_archive' );

		$post_type      = katawara_get_post_type();
		$post_type_slug = $post_type['slug'];
		$post_type_slug = ( is_author() ) ? 'author' : $post_type['slug'];

		$flag = katawara_is_loop_layout_change_bs4_flag_bs4( $post_type_slug );
		if ( $flag ) {

			$customize_options = $vk_post_type_archive[ $post_type_slug ];
			// Get default option.
			$customize_options_default = VK_Media_Posts_BS4::options_default();
			// Markge options.
			$options = wp_parse_args( $customize_options, $customize_options_default );

			global $wp_query;

			/*
			Lightning Pro のみ
			おそらくこの値が保存されている事はないので不具合報告がこない場合は2020年12月で削除可
			unset($options['col_xxl']);
			*/

			VK_Component_Posts::the_loop( $wp_query, $options );
		}
	}
	add_action( 'katawara_extend_loop', 'katawara_do_loop_layout_change_bs4' );

	/**
	 * アーカイブページレイアウト
	 *
	 * @param object $query WP_Query.
	 */
	function katawara_posts_per_page_custom_bs4( $query ) {

		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}

		// アーカイブの時以外は関係ないので return.
		if ( ! $query->is_archive() && ! $query->is_home() ) {
			return;
		}

		// アーカイブページの表示件数情報を取得.
		$vk_post_type_archive = get_option( 'vk_post_type_archive' );
		// Post Type
		$post_type_info = katawara_get_post_type();
		$post_type = $post_type_info['slug'];

		if ( $query->is_home() && ! $query->is_front_page() && ! empty( $vk_post_type_archive['post']['count'] ) ) {
			$query->set( 'posts_per_page', $vk_post_type_archive['post']['count'] );
		}

		// authhor archive.
		if ( $query->is_author() && ! empty( $vk_post_type_archive['author']['count'] ) ) {
			$query->set( 'posts_per_page', $vk_post_type_archive['author']['count'] );
		}

		if ( $query->is_archive() || $query->is_home() ) {

			$page_for_posts['post_top_id'] = get_option( 'page_for_posts' );

			// post_type_archive & is_date and other.
			if ( ! empty( $query->query_vars['post_type'] ) ) {
				if ( isset( $vk_post_type_archive[ $post_type ]['count'] ) ) {
					$query->set( 'posts_per_page', $vk_post_type_archive[ $post_type ]['count'] );
				}
			}

			if ( isset( $vk_post_type_archive[ $post_type ]['orderby'] ) ) {
				$query->set( 'orderby', $vk_post_type_archive[ $post_type ]['orderby'] );
			}
			if ( isset( $vk_post_type_archive[ $post_type ]['order'] ) ) {
				$query->set( 'order', $vk_post_type_archive[ $post_type ]['order'] );
			}

			// カスタム分類アーカイブ.
			if ( ! empty( $query->tax_query->queries ) ) {
				$taxonomy  = $query->tax_query->queries[0]['taxonomy'];
				$post_type = get_taxonomy( $taxonomy )->object_type[0];
				if ( ! empty( $vk_post_type_archive[ $post_type ]['count'] ) ) {
					$query->set( 'posts_per_page', $vk_post_type_archive[ $post_type ]['count'] );
				}
			}
		}

		return $query;

	}
	add_action( 'pre_get_posts', 'katawara_posts_per_page_custom_bs4' );

	// プリフィックス.
	global $vk_media_post_prefix;
	$vk_media_post_prefix = katawara_get_prefix();
}
