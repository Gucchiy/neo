<?php
/**
 * Functions of Katawara
 *
 * @package Katawara
 */

$theme_opt = wp_get_theme( get_template() );
define( 'KATAWARA_THEME_VERSION', $theme_opt->version );
define( 'KATAWARA_SHORT_NAME', 'KTWR THEME' );

/**
 * Theme setup
 */
function katawara_theme_setup() {
	global $content_width;
	// Editor Styles.
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/common-editor.min.css' );
	// Title Tags.
	add_theme_support( 'title-tag' );
	// Post Thumbnail.
	add_theme_support( 'post-thumbnails' );
	// Align Wide.
	add_theme_support( 'align-wide' );
	// Custom Background.
	add_theme_support( 'custom-background' );
	// Admin page _ Eye catch.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 320, 180, true );
	// Custom menu.
	register_nav_menus(
		array(
			// 複数のナビゲーションメニューを登録する関数.
			// '「メニューの位置」の識別子' => 'メニューの説明の文字列'.
			'global-navigation' => 'Global Navigation',
			'footer-navigation' => 'Footer Navigation ',
		)
	);
	// Load Text Domain.
	load_theme_textdomain( 'katawara', get_template_directory() . '/languages' );

	// Set content width.
	if ( ! isset( $content_width ) ) {
		$content_width = 750;
	}

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Feed Links.
	add_theme_support( 'automatic-feed-links' );

	// WooCommerce.
	add_theme_support( 'woocommerce' );

	// Option init.
	// Save default option first time.
	// When only customize default that, Can't save default value.
	$katawara_theme_options   = get_option( 'katawara_theme_options ' );
	$katawara_default_options = katawara_default_options();
	$katawara_theme_options   = wp_parse_args( $katawara_theme_options, $katawara_default_options );

}
add_action( 'after_setup_theme', 'katawara_theme_setup' );

/*
Already add_editor_style() is used but reload css by wp_enqueue_style() reason is
use to wp_add_inline_style()
*/
function katawara_load_common_editor_css_to_gutenberg() {

	wp_enqueue_style(
		'katawara-common-editor-gutenberg',
		// If not full path that can't load in editor screen
		get_template_directory_uri() . '/assets/css/common-editor.min.css',
		array( 'wp-edit-blocks' ),
		KATAWARA_THEME_VERSION
	);
}
add_action( 'enqueue_block_editor_assets', 'katawara_load_common_editor_css_to_gutenberg' );

/**
 * Embed Card.
 */

//「コピーして埋め込み」を削除する
remove_action( 'embed_footer', 'print_embed_sharing_dialog' );

function katawara_embed_styles() {
		wp_enqueue_style('embed-content_css', get_template_directory_uri() . '/assets/css/wp-embed.min.css' );
}
add_filter('embed_head', 'katawara_embed_styles');

/**
 * Load JS.
 */
function katawara_enqueue_script() {
	wp_enqueue_script( 'katawara-js', get_template_directory_uri() . '/assets/js/katawara.min.js', array(), KATAWARA_THEME_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'katawara_enqueue_script' );

/**
 *  Load CSS
 */
function katawara_theme_styles() {
	wp_enqueue_style( 'katawara-design-style', get_theme_file_uri( '/assets/css/style.min.css' ), array( 'wp-block-library' ), KATAWARA_THEME_VERSION );
	wp_enqueue_style( 'katawara-customize-preview', get_theme_file_uri( '/assets/css/customize-preview.min.css' ), array( 'katawara-design-style' ), KATAWARA_THEME_VERSION );
	// wp_enqueue_style( 'wp-oembed-embed', get_theme_file_uri( '/assets/css/wp-embed.min.css' ), array( 'katawara-customize-preview'), KATAWARA_THEME_VERSION );
}
add_action( 'wp_enqueue_scripts', 'katawara_theme_styles', 8, 0 );

/*
  Load woocommerce modules
/*-------------------------------------------*/
if ( class_exists( 'woocommerce' ) ) {
	require get_parent_theme_file_path( '/plugin-support/woocommerce/functions-woo.php' );
}

// Load modules.
// Theme Customizer additions.
require get_parent_theme_file_path( '/inc/customize/customize.php' );
require get_parent_theme_file_path( '/inc/customize/customize-design.php' );
// template-tag.
require get_parent_theme_file_path( '/inc/template-tags.php' );
// vk-helpers.
require get_parent_theme_file_path( '/inc/class-vk-helpers.php' );
// copyright-customizer.
require get_parent_theme_file_path( '/inc/copyright-customizer/copyright-customizer-config.php' );
// custom-field-builder.
require get_parent_theme_file_path( '/inc/custom-field-builder/custom-field-builder-config.php' );
// font-awesome.
require get_parent_theme_file_path( '/inc/font-awesome/font-awesome-config.php' );
// vk-swiper.
require get_parent_theme_file_path( '/inc/vk-swiper/vk-swiper-config.php' );
// headding-design.
require get_parent_theme_file_path( '/inc/headding-design/headding-design-config.php' );
// layout-controller.
require get_parent_theme_file_path( '/inc/layout-controller/layout-controller.php' );
// media-posts-bs4.
require get_parent_theme_file_path( '/inc/media-posts-bs4/media-posts-bs4-config.php' );
// term-color.
require get_parent_theme_file_path( '/inc/term-color/term-color-config.php' );
// tgm-plugin-activation.
require get_parent_theme_file_path( '/inc/tgm-plugin-activation/tgm-config.php' );
// vk-advanced-slider.
require get_parent_theme_file_path( '/inc/vk-advanced-slider/vk-advanced-slider-config.php' );
// vk-breadcrumb.
require get_parent_theme_file_path( '/inc/vk-breadcrumb/vk-breadcrumb-config.php' );
// vk-campaign-text.
require get_parent_theme_file_path( '/inc/vk-campaign-text/vk-campaign-text-config.php' );
// vk-components.
require get_parent_theme_file_path( '/inc/vk-components/vk-components-config.php' );
// vk-css-optimize
require get_parent_theme_file_path( '/inc/vk-css-optimize/vk-css-optimize-config.php' );
// vk-font-selector.
require get_parent_theme_file_path( '/inc/vk-font-selector/vk-font-selector-config.php' );
// vk-mobile-fix-nav.
require get_parent_theme_file_path( '/inc/vk-mobile-fix-nav/vk-mobile-fix-nav-config.php' );
// vk-mobile-nav.
require get_parent_theme_file_path( '/inc/vk-mobile-nav/vk-mobile-nav-config.php' );
// vk-page-header.
require get_parent_theme_file_path( '/inc/vk-page-header/vk-page-header-config.php' );
// widget-area-setting.
require get_parent_theme_file_path( '/inc/vk-footer-customize/vk-footer-customize-config.php' );
// vk-heqader-style.
require get_parent_theme_file_path( './inc/vk-header-style/vk-header-style-config.php' );
// vk-footer-style.
require get_parent_theme_file_path( './inc/vk-footer-style/vk-footer-style-config.php' );
// google tag manager.
require get_parent_theme_file_path( './inc/vk-google-tag-manager/vk-google-tag-manager-config.php' );
// vk-mobile-nav.
require get_parent_theme_file_path( '/inc/vk-mobile-nav/vk-mobile-nav-config.php' );
remove_action( 'after_setup_theme', array( 'Vk_Mobile_Fix_Nav', 'load_css_action' ) );

/**
 * Widget Areas
 */
function katawara_widgets_init() {
	// sidebar widget area.
	register_sidebar(
		array(
			'name'          => __( 'Header Side Widget(PC Only)', 'katawara' ),
			'id'            => 'header-side-widget',
			'before_widget' => '<section class="p-widget pc-only %2$s" id="%1$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="p-widget_title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Sidebar(Home)', 'katawara' ),
			'id'            => 'front-side-top-widget-area',
			'before_widget' => '<section class="p-widget p-widget-side %2$s" id="%1$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="p-widget_title p-widget-side_title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Sidebar(Common top)', 'katawara' ),
			'id'            => 'common-side-top-widget-area',
			'before_widget' => '<section class="p-widget p-widget-side %2$s" id="%1$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="p-widget_title p-widget-side_title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Sidebar(Common bottom)', 'katawara' ),
			'id'            => 'common-side-bottom-widget-area',
			'before_widget' => '<section class="p-widget p-widget-side %2$s" id="%1$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="p-widget_title p-widget-side_title">',
			'after_title'   => '</h3>',
		)
	);

	// Sidebar( post_type ).
	$post_types = get_post_types( array( 'public' => true ) );

	foreach ( $post_types as $widget_post_type ) {

		// Get post type name..
		$post_type_object = get_post_type_object( $widget_post_type );
		if ( $post_type_object ) {
			// Set post type name.
			$widget_post_type_name = esc_html( $post_type_object->labels->name );

			$sidebar_description = '';
			if ( 'post' === $widget_post_type ) {
				$sidebar_description = __( 'This widget area appears on the Posts page only. If you do not set any widgets in this area, this theme sets the following widgets "Recent posts", "Category", and "Archive" by default. These default widgets will be hidden, when you set any widgets. <br><br> If you installed our plugin VK All in One Expansion Unit (Free), you can use the following widgets, "VK_Recent posts",  "VK_Categories", and  "VK_archive list".', 'katawara' );
			} elseif ( 'page' === $widget_post_type ) {
				$sidebar_description = __( 'This widget area appears on the Pages page only. If you do not set any widgets in this area, this theme sets the "Child pages list widget" by default. This default widget will be hidden, when you set any widgets. <br><br> If you installed our plugin VK All in One Expansion Unit (Free), you can use the "VK_ child page list" widget for the alternative.', 'katawara' );
			} elseif ( 'attachment' === $widget_post_type ) {
				$sidebar_description = __( 'This widget area appears on the Media page only.', 'katawara' );
			} else {
				// translators: This widget area is for only the post type.
				$sidebar_description = sprintf( __( 'This widget area appears on the %s contents page only.', 'katawara' ), $widget_post_type_name );
			}

			// Set post type widget area.
			register_sidebar(
				array(
					// translators: Post Type Name.
					'name'          => sprintf( __( 'Sidebar(%s)', 'katawara' ), $widget_post_type_name ),
					'id'            => $widget_post_type . '-side-widget-area',
					'description'   => $sidebar_description,
					'before_widget' => '<section class="p-widget p-widget-side %2$s" id="%1$s">',
					'after_widget'  => '</section>',
					'before_title'  => '<h3 class="p-widget_title p-widget-side_title">',
					'after_title'   => '</h3>',
				)
			);
		} // if post_type_object.

	} // foreach.

	// Home content top widget area.
	register_sidebar(
		array(
			'name'          => __( 'Home content top', 'katawara' ),
			'id'            => 'home-content-top-widget-area',
			'before_widget' => '<div class="p-widget p-widget-main %2$s" id="%1$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="p-widget_title p-widget-main_title l-main-section_title">',
			'after_title'   => '</h2>',
		)
	);

	// footer upper widget area.
	register_sidebar(
		array(
			'name'          => __( 'Widget area of upper footer', 'katawara' ),
			'id'            => 'footer-upper-widget',
			'before_widget' => '<aside class="p-widget p-widget-footer-upper %2$s" id="%1$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="p-widget_title p-widget-footer-upper_title">',
			'after_title'   => '</h3>',
		)
	);

	// footer widget area.
	$footer_widget_area_count = 3;
	$footer_widget_area_count = apply_filters( 'katawara_footer_widget_area_count', $footer_widget_area_count );

	for ( $i = 1; $i <= $footer_widget_area_count; ) {
		register_sidebar(
			array(
				'name'          => __( 'Footer widget area ', 'katawara' ) . $i,
				'id'            => 'footer-widget-' . $i,
				'before_widget' => '<section class="p-widget p-widget-footer %2$s" id="%1$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="p-widget_title p-widget-footer_title">',
				'after_title'   => '</h3>',
			)
		);
		$i++;
	}

}
add_action( 'widgets_init', 'katawara_widgets_init' );

/**
 * WordPressのJavascriptやCSSのハンドル名をHTMLソースに表示する
 *
 * @param string $dependency dependency.
 */
function katawara_get_dependency( $dependency ) {
	$dep = '';
	if ( is_a( $dependency, '_WP_Dependency' ) ) {
		$dep .= "$dependency->handle";
		$dep .= ' [' . implode( ' ', $dependency->deps ) . ']';
		$dep .= " '$dependency->src'";
		$dep .= " '$dependency->ver'";
		$dep .= " '$dependency->args'";
		$ex   = array();
		foreach ( $dependency->extra as $e ) {
			$ex[] = is_array( $e ) ? implode( ' ', $e ) : $e;
		}
		$dep .= ' (' . implode( ' ', $ex ) . ')';
	}
	return "$dep\n";
}

/**
 * Katawara Style Ques
 */
function katawara_style_queues() {
	global $wp_styles;
	echo "<!-- WP_Dependencies for styles\n";
	foreach ( $wp_styles->queue as $val ) {
		echo esc_html( katawara_get_dependency( $wp_styles->registered[ $val ] ) );
	}
	echo "-->\n";
}
add_action( 'wp_print_styles', 'katawara_style_queues', 9999 );

/**
 * Katawara Script Ques
 */
function katawara_script_queues() {
	global $wp_scripts;
	echo "<!-- WP_Dependencies for scripts\n";
	foreach ( $wp_scripts->queue as $val ) {
		echo esc_html( katawara_get_dependency( $wp_scripts->registered[ $val ] ) );
	}
	echo "-->\n";
}
add_action( 'wp_print_scripts', 'katawara_script_queues', 9999 );

/**
 * Base Active Skin
 */
function katawara_is_base_active_by_skin() {

	$base = false;

	// Base setting of skin.
	$skin = get_option( 'katawara_design_skin' );

	if ( in_array( $skin ) ) {
		$base = true;
	}
	return $base;
}

/**
 * HOME _ Default content hidden
 *
 * @param bool $flag flag.
 */
function katawara_home_content_hidden( $flag ) {
	global $katawara_theme_options;

	if ( ! empty( $katawara_theme_options['top_default_content_hidden'] ) ) {
		$flag = false;
	}
	return $flag;
}
add_filter( 'is_katawara_home_content_display', 'katawara_home_content_hidden' );



/*
  Year Artchive list 'year' and count insert to inner </a>
/*-------------------------------------------*/
function katawara_archives_link( $html ) {
	return preg_replace( '@</a>(.+?)</li>@', '\1</a></li>', $html );
}
add_filter( 'get_archives_link', 'katawara_archives_link' );

/*
  Category list count insert to inner </a>
/*-------------------------------------------*/
function katawara_list_categories( $output, $args ) {
	$output = preg_replace( '/<\/a>\s*\((\d+)\)/', ' ($1)</a>', $output );
	return $output;
}
add_filter( 'wp_list_categories', 'katawara_list_categories', 10, 2 );

/**
 * Updater
 */
require dirname( __FILE__ ) . '/inc/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://vws.vektor-inc.co.jp/wp-content/themes/lightning-pro-child-vws/updates/?action=get_metadata&slug=katawara',
	__FILE__,
	'katawara'
);
