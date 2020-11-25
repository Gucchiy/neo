<?php
/**
 * Footer Customize Config
 *
 * @package Katawara
 */

if ( ! class_exists( 'VK_Footer_Style' ) ) {
	global $vk_footer_customize_hook_style;
	$vk_footer_customize_hook_style = 'katawara-design-style';

	require_once dirname( __FILE__ ) . '/package/class-vk-footer-style.php';
}
