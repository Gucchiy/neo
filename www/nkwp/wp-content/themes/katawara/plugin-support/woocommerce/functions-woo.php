<?php

require get_parent_theme_file_path( '/plugin-support/woocommerce/customize.php' );

function katawara_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'katawara_add_woocommerce_support' );

/*
  Load CSS
/*-------------------------------------------*/
function katawara_woo_css() {

	wp_enqueue_style(
		'katawara-woo-style',
		get_template_directory_uri() . '/plugin-support/woocommerce/css/woo.css',
		array( 'katawara-design-style' ),
		KATAWARA_THEME_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'katawara_woo_css' );

function katawara_add_woocommerce_css_to_editor() {
	add_editor_style( '/plugin-support/woocommerce/css/woo.css' );
}
add_action( 'after_setup_theme', 'katawara_add_woocommerce_css_to_editor' );

/*
  WidgetArea initiate
/*-------------------------------------------*/

function katawara_widgets_init_product() {
	$plugin_path = 'woocommerce/woocommerce.php';
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	if ( ! is_plugin_active( $plugin_path ) ) {
		return;
	}

	// Get post type name
	/*-------------------------------------------*/
	$post_type                = 'product';
	$woocommerce_shop_page_id = get_option( 'woocommerce_shop_page_id' );
	$label                    = get_the_title( $woocommerce_shop_page_id );
	$sidebar_description      = sprintf( __( 'This widget area appears on the %s contents page only.', 'katawara' ), $label );

	// Set post type widget area
	register_sidebar(
		array(
			'name'          => sprintf( __( 'Sidebar(%s)', 'katawara' ), $label ),
			'id'            => $post_type . '-side-widget-area',
			'description'   => $sidebar_description,
			'before_widget' => '<aside class="widget %2$s" id="%1$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget-title subSection-title">',
			'after_title'   => '</h1>',
		)
	);

}
add_action( 'widgets_init', 'katawara_widgets_init_product' );


/*
  Adding support for WooCommerce 3.0’s new gallery feature
-------------------------------------------*/
/*
https://woocommerce.wordpress.com/2017/02/28/adding-support-for-woocommerce-2-7s-new-gallery-feature-to-your-theme/
*/
add_action( 'after_setup_theme', 'katawara_woo_product_gallery_setup' );

function katawara_woo_product_gallery_setup() {
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
