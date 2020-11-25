<?php
/**
 * Header Customize Config
 *
 * @package Katawara
 */

if ( ! class_exists( 'VK_Header_Style' ) ) {
	global $vk_header_customize_hook_style;
	$vk_header_customize_hook_style = 'katawara-design-style';

	global $vk_header_customize_prefix;
	$vk_header_customize_prefix = katawara_get_prefix_customize_panel();

	global $vk_header_selecter_array;
	$vk_header_selecter_array = array(
		'background' => '
			.l-site-header,
			.scrolled .l-site-header_global-menu,
			.p-global-menu>li>ul.sub-menu li,
			.l-site-header .btn-primary
		',
		'background_dark' => '
			.p-global-menu .acc-btn:not(.acc-btn-close),
			.p-global-menu .acc-btn-close,
			.veu_contact .contact_frame,
			.l-site-header .searchform,
			.p-global-menu li > a:hover,
			.p-global-menu li[class*="current"] > a,
			.l-site-header .menu li > a:hover,
			.l-site-header .btn-default:hover,
			.l-site-header .btn-primary:hover
		',
		'title'      => '
			.l-site-header .p-widget_title,
			.p-site-header-brand_logo a
		',
		'text'       => '
			.p-site-header-brand_description,
			.p-global-menu>li a,
			.p-global-menu>li a:hover,
			.l-site-header .p-widget ul li a,
			.l-site-header .p-widget ul li a:hover,
			.l-site-header .p-widget,
			.l-site-header .searchform .searchico,
			.l-site-header .searchform .searchico:hover,
			.l-site-header input[type=date],
			.l-site-header input[type=email],
			.l-site-header input[type=tel],
			.l-site-header input[type=text],
			.l-site-header input[type=number],
			.l-site-header select,
			.l-site-header textarea,
			.l-site-header .contact_txt_tel,
			.l-site-header .veu_postList .postList a,
			.l-site-header .btn-default
		'
		,
		// 'border'     => '.p-global-menu>li,.p-global-menu>li:last-child,.l-site-header .p-widget ul li a',
	);

	require_once dirname( __FILE__ ) . '/package/class-vk-header-style.php';
}

// .l-site-header input[type=date], input[type=email], input[type=tel], input[type=text], select, textarea {
