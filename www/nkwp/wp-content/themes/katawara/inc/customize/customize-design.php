<?php
/**
 * Design Setting
 *
 * @package Katawara
 */

/**
 * Katawara Default Options.
 */
function katawara_default_options() {
	$args = array(
		'head_logo'                  => '',
		'color_key'                  => '#845322',
		'top_default_content_hidden' => false,
		'postUpdate_hidden'          => false,
		'postAuthor_hidden'          => false,
		'sidebar_child_list_hidden'  => false,
	);
	return $args;
}

/**
 * Customize Register.
 *
 * @param \WP_Customize_Manager $wp_customize Customizer.
 */
function katawara_customize_register_design( $wp_customize ) {

	$wp_customize->add_section(
		'katawara_design',
		array(
			'title'    => katawara_get_prefix_customize_panel() . __( 'Design settings', 'katawara' ),
			'priority' => 501,
		)
	);

	// Haeder Logo.
	$wp_customize->add_setting(
		'katawara_theme_options[head_logo]',
		array(
			'default'           => '',
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'katawara_theme_options[head_logo]',
			array(
				'label'       => __( 'Header logo image', 'katawara' ),
				'section'     => 'katawara_design',
				'settings'    => 'katawara_theme_options[head_logo]',
				'description' => __( 'Recommended image size : 280*60px', 'katawara' ),
			)
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'katawara_theme_options[head_logo]',
		array(
			'selector'        => '.siteHeader_logo:not(.siteHeader_logo-trans-true)',
			'render_callback' => '',
		)
	);

	// color_key.
	$wp_customize->add_setting(
		'katawara_theme_options[color_key]',
		array(
			'default'           => '#845322;',
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'katawara_theme_options[color_key]',
			array(
				'label'    => __( 'Key color', 'katawara' ),
				'section'  => 'katawara_design',
				'settings' => 'katawara_theme_options[color_key]',
			)
		)
	);

	// Other Setting.
	$wp_customize->add_setting(
		'Others',
		array(
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		new Custom_Html_Control(
			$wp_customize,
			'Others',
			array(
				'label'            => __( 'Other Setting', 'katawara' ),
				'section'          => 'katawara_design',
				'type'             => 'text',
				'custom_title_sub' => '',
				'custom_html'      => '',
				'priority'         => 800,
			)
		)
	);
	// top_default_content_hidden.
	$wp_customize->add_setting(
		'katawara_theme_options[top_default_content_hidden]',
		array(
			'default'           => false,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => array( 'VK_Helpers', 'sanitize_checkbox' ),
		)
	);
	$wp_customize->add_control(
		'katawara_theme_options[top_default_content_hidden]',
		array(
			'label'    => __( 'Don\'t show default content(Post list or Front page) at home page', 'katawara' ),
			'section'  => 'katawara_design',
			'settings' => 'katawara_theme_options[top_default_content_hidden]',
			'type'     => 'checkbox',
			'priority' => 800,
		)
	);

	// postUpdate_hidden.
	$wp_customize->add_setting(
		'katawara_theme_options[postUpdate_hidden]',
		array(
			'default'           => false,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => array( 'VK_Helpers', 'sanitize_checkbox' ),
		)
	);
	$wp_customize->add_control(
		'katawara_theme_options[postUpdate_hidden]',
		array(
			'label'    => __( 'Hide modified date on single pages.', 'katawara' ),
			'section'  => 'katawara_design',
			'settings' => 'katawara_theme_options[postUpdate_hidden]',
			'type'     => 'checkbox',
			'priority' => 800,
		)
	);

	// postAuthor_hidden.
	$wp_customize->add_setting(
		'katawara_theme_options[postAuthor_hidden]',
		array(
			'default'           => false,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => array( 'VK_Helpers', 'sanitize_checkbox' ),
		)
	);
	$wp_customize->add_control(
		'katawara_theme_options[postAuthor_hidden]',
		array(
			'label'    => __( 'Don\'t display post author on a single page', 'katawara' ),
			'section'  => 'katawara_design',
			'settings' => 'katawara_theme_options[postAuthor_hidden]',
			'type'     => 'checkbox',
			'priority' => 800,
		)
	);

	// sidebar_child_list_hidden.
	$wp_customize->add_setting(
		'katawara_theme_options[sidebar_child_list_hidden]',
		array(
			'default'           => false,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => array( 'VK_Helpers', 'sanitize_checkbox' ),
		)
	);
	$wp_customize->add_control(
		'katawara_theme_options[sidebar_child_list_hidden]',
		array(
			'label'    => __( 'Don\'t display grandchild page of deactive page at page sidebar', 'katawara' ),
			'section'  => 'katawara_design',
			'settings' => 'katawara_theme_options[sidebar_child_list_hidden]',
			'type'     => 'checkbox',
			'priority' => 800,
		)
	);
}
add_action( 'customize_register', 'katawara_customize_register_design' );


/**
 * katawara_get_dynamic_css
 */
function katawara_get_dynamic_css() {
	$katawara_theme_options   = get_option( 'katawara_theme_options ' );
	$katawara_default_options = katawara_default_options();

	$options     = wp_parse_args( $katawara_theme_options, $katawara_default_options );
	$dynamic_css = '';

	if ( isset( $options['color_key'] ) ) {
		$color_key      = ( ! empty( $options['color_key'] ) ) ? esc_html( $options['color_key'] ) : '#845322';
		$change_rate    = 0.8;
		$color_key_dark = esc_html( VK_Helpers::color_auto_modifi( $color_key, $change_rate ) );

		$dynamic_css .= '/* katawara common custom */
		:root {
			--vk-color-key: ' . $color_key . ' ;
			--vk-color-key-dark: ' . $color_key_dark . ' ;
		}
		input[type="submit"]{ border-color: ' . $color_key_dark . ' ; background-color: ' . $color_key . ' ; }
		.comment .reply a,
		.btn-default{ color: ' . $color_key . ' ; border-color: ' . $color_key . ' ;}

		.slide .slide-text-set .btn-ghost:hover,
		.btn-default:focus,
		.btn-default:hover { border-color: ' . $color_key . ' ; background-color: ' . $color_key . ' ;}
		.wp-block-search__button:hover,
		.p-footer-menu li a:hover,
		.l-container .veu_card .childPage_list_body:hover,
		.l-container .veu_card .childPage_list_title:hover,
		.l-container .veu_sitemap ul>li>a:hover,
		.l-container .veu_pageList_ancestor .pageList a:hover,
		.veu_pageList_ancestor .current_page_item>a,
		.veu_pageList_ancestor .pageList a:hover,
		.searchform .searchico:hover,
		.p-global-menu>li a:hover,
		.veu_sitemap ul>li>a:hover{ color:' . $color_key . ' ; }

		.page-link .current,
		ul.page-numbers li span.page-numbers.current { background-color:' . $color_key . ' ; }

		.p-widget .tagcloud a:hover, .p-widget .tagcloud a:hover:before,
		.btn-outline-primary { color: ' . $color_key . ' ;  border-color:' . $color_key . ' ; }
		.btn-outline-primary:hover{ border-color:' . $color_key . ' ;}
		blockquote { border-color: ' . $color_key . ' ; }

		.widget_archive ul li>a:hover, 
		.widget_categories ul li>a:hover, 
		.widget_link_list ul li>a:hover, 
		.widget_nav_menu ul li>a:hover, 
		.widget_postlist ul li>a:hover, 
		.widget_recent_entries ul li>a:hover, 
		
		.widget_archive ul li>a:hover:before, 
		.widget_categories ul li>a:hover:before, 
		.widget_link_list ul li>a:hover:before, 
		.widget_nav_menu ul li>a:hover:before, 
		.widget_postlist ul li>a:hover:before, 
		.widget_recent_entries ul li>a:hover:before{ color: ' . $color_key . ' ;  }

		.comment .reply a:hover,
		.btn-default:focus,
		.btn-default:hover { border-color:' . $color_key . ';background-color: ' . $color_key . '; }

		.p-comments-area .nav-links a,
		.btn-primary { background-color:' . $color_key . ';border-color:' . $color_key_dark . '; }

		.p-comments-area .nav-links a:hover,
		.btn-primary:focus,
		.btn-primary:hover,
		.btn-primary:active { background-color:' . $color_key_dark . ';border-color:' . $color_key . '; }

		.btn.btn-outline-primary:active,
		.btn.btn-outline-primary:focus,
		.btn.btn-outline-primary:hover {  background-color: ' . $color_key_dark . ' ; }
		@media screen and (max-width: 1199.98px) and (min-width: 992px){
			.p-global-menu>li:before,
			.p-global-menu>li.current-menu-item:before {
				border-bottom-color:' . $color_key_dark . ' ;
			}
		}
		.p-entry_footer .p-entry_meta_data-list dt { background-color:' . $color_key . '; }
		.bbp-submit-wrapper .button.submit,
		.woocommerce a.button.alt:hover,
		.woocommerce-product-search button:hover,
		.woocommerce button.button.alt { background-color:' . $color_key_dark . ' ; }
		.bbp-submit-wrapper .button.submit:hover,
		.woocommerce a.button.alt,
		.woocommerce-product-search button,
		.woocommerce button.button.alt:hover { background-color:' . $color_key . ' ; }
		.woocommerce ul.product_list_widget li a:hover img { border-color:' . $color_key . '; }
		.l-container .veu_pageList_ancestor .current_page_item>a,
		.veu_color_txt_key { color:' . $color_key_dark . ' ; }
		.veu_color_bg_key { background-color:' . $color_key_dark . ' ; }
		.veu_color_border_key { border-color:' . $color_key_dark . ' ; }
		';
	}

	// Child list hidden.
	if ( isset( $options['sidebar_child_list_hidden'] ) && $options['sidebar_child_list_hidden'] ) {

		$dynamic_css .= '/* sidebar child menu display */
		.localNav ul ul.children	{ display:none; }
		.localNav ul li.current_page_ancestor ul.children,
		.localNav ul li.current_page_item ul.children,
		.localNav ul li.current-cat ul.children{ display:block; }';
		$dynamic_css .= '/* ExUnit widget ( child page list widget and so on ) */
		.localNavi ul.children	{ display:none; }
		.localNavi li.current_page_ancestor ul.children,
		.localNavi li.current_page_item ul.children,
		.localNavi li.current-cat ul.children{ display:block; }';
	}

	$dynamic_css = apply_filters( 'katawara_dynamic_css', $dynamic_css );

	if ( $dynamic_css ) {

		// delete br.
		$dynamic_css = str_replace( PHP_EOL, '', $dynamic_css );
		// delete tab.
		$dynamic_css = preg_replace( '/[\n\r\t]/', '', $dynamic_css );
		// multi space convert to single space.
		$dynamic_css = preg_replace( '/\s(?=\s)/', '', $dynamic_css );

		// echo '<style id="katawara-common-style-custom" type="text/css">' . $dynamic_css . '</style>';
		// wp_add_inline_style( 'katawara-design-style', $dynamic_css );

	}
	return $dynamic_css;

}

function katawara_print_dynamic_css() {
	$dynamic_css = katawara_get_dynamic_css();
	wp_add_inline_style( 'katawara-design-style', $dynamic_css );
}
add_action( 'wp_enqueue_scripts', 'katawara_print_dynamic_css' );

function katawara_print_dynamic_css_to_editor() {
	$dynamic_css = katawara_get_dynamic_css();
	wp_add_inline_style( 'katawara-common-editor-gutenberg', $dynamic_css );
}
add_action( 'enqueue_block_editor_assets', 'katawara_print_dynamic_css_to_editor' );

/**
 * 編集ショートカットボタンの位置調整（ウィジェットのショートカットボタンと重なってしまうため）
 */
function katawara_customize_preview_css_design() {
	if ( is_customize_preview() ) {
		$custom_css = '.l-side-section > .customize-partial-edit-shortcut-katawara_theme_options-sidebar_fix { left:0px; }';
		wp_add_inline_style( 'katawara-design-style', $custom_css );
	}
}
add_action( 'wp_head', 'katawara_customize_preview_css_design', 2 );
