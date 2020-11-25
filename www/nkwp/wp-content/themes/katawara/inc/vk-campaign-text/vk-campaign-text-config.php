<?php
/**
 * VK Campaign Text Config
 *
 * @package Kastawara
 */

if ( ! class_exists( 'VK_Campaign_Text' ) ) {

	// キャンペーンテキストを挿入する位置.
	// * 後で読み込むと読み込み順の都合上反映されない.
	global $vk_campaign_text_hook_point;
	$vk_campaign_text_hook_point = array();
	// JPNSTYLE II との兼ね合いを考えるとせいぜいこれが精一杯 !?
	$vk_campaign_text_hook_point = apply_filters( 'katawara_campaign_text_hook_point', $vk_campaign_text_hook_point );

	// キャンペーンテキストの CSS を読み込む位置.
	// * 後で読み込むと読み込み順の都合上反映されない.
	global $vk_campaign_text_hook_style;
	$vk_campaign_text_hook_style = 'katawara-design-style';

	// 表示位置の配列.
	global $vk_campaign_text_display_position_array;
	$vk_campaign_text_display_position_array = array(
		'site_content_prepend' => array(
			'hookpoint' => array( 'katawara_site-container_prepend' ),
			'label'     => __( 'Right Top', 'katawara' ),
		),
		'page_header_after'    => array(
			'hookpoint' => array( 'katawara_top_slide_after', 'katawara_breadcrumb_before' ),
			'label'     => __( 'Page Header After', 'katawara' ),
		),
	);

	require_once dirname( __FILE__ ) . '/package/class-vk-campaign-text.php';
}

// なるべくLightnigの名前になるように class_exists の外でOK.
global $vk_campaign_text_prefix;
$vk_campaign_text_prefix = katawara_get_prefix_customize_panel();
