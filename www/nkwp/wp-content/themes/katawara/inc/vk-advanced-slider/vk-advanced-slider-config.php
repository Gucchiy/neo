<?php
/**
 * VK Advanced Slider Config
 *
 * @package Katawara
 */

if ( ! class_exists( 'VK_Advanced_Slider' ) ) {

	/**
	 * Default Options
	 */
	function vk_advanced_slider_default_options() {
		$img_url = get_template_directory_uri() . '/inc/vk-advanced-slider/image/';
		$options = array(
			'top_slide_display'             => 'display',
			'top_slide_effect'              => 'fade',
			'top_slide_speed'               => 2000,
			'top_slide_image_1'             => $img_url . 'slide-img01.jpg',
			'top_slide_image_mobile_1'      => $img_url . 'slide-img-sp01.jpg',
			'top_slide_alt_1'               => '',
			'top_slide_cover_color_1'       => '#ffffff',
			'top_slide_cover_opacity_1'     => '50',
			'top_slide_url_1'               => 'https://demo.dev3.biz/katawara/',
			'top_slide_link_blank_1'        => false,
			'top_slide_text_title_1'        => 'あらゆる画面サイズに対応する高機能 WordPress テーマ',
			'top_slide_text_caption_1'      => '「Katawara」はワイドディスプレイを意識したサイドグローバルナビゲーションで、<br>無駄な余白のないスタイリッシュなデザインのWordPress テーマです。',
			'top_slide_text_btn_1'          => '詳しくはこちら',
			'top_slide_text_align_1'        => 'left',
			'top_slide_text_color_1'        => '#000000',
			'top_slide_text_shadow_use_1'   => false,
			'top_slide_text_shadow_color_1' => '',
			'top_slide_image_2'             => $img_url . 'slide-img02.jpg',
			'top_slide_image_mobile_2'      => $img_url . 'slide-img-sp02.jpg',
			'top_slide_alt_2'               => '',
			'top_slide_cover_color_2'       => '#000000',
			'top_slide_cover_opacity_2'     => '30',
			'top_slide_url_2'               => 'https://demo.dev3.biz/katawara/',
			'top_slide_link_blank_2'        => false,
			'top_slide_text_title_2'        => '初心者でも安心、ブロックエディター Gutenberg に対応',
			'top_slide_text_caption_2'      => 'htmlやcssの知識が無くてもブロックエディターGutenbergに対応しているので簡単にウェブページが作れます。<br>さらにブロック追加プラグインVK Blocksを使用すれば、便利なブロックを追加できます。',
			'top_slide_text_btn_2'          => '詳しくはこちら',
			'top_slide_text_align_2'        => 'center',
			'top_slide_text_color_2'        => '#ffffff',
			'top_slide_text_shadow_use_2'   => true,
			'top_slide_text_shadow_color_2' => '#3f3f44',
			'top_slide_image_3'             => $img_url . 'slide-img03.jpg',
			'top_slide_image_mobile_3'      => $img_url . 'slide-img-sp03.jpg',
			'top_slide_alt_3'               => '',
			'top_slide_cover_color_3'       => '#ffffff',
			'top_slide_cover_opacity_3'     => '65',
			'top_slide_url_3'               => 'https://demo.dev3.biz/katawara/',
			'top_slide_link_blank_3'        => false,
			'top_slide_text_title_3'        => '汎用性の高いシンプルなデザイン',
			'top_slide_text_caption_3'      => '業種を選ばない、汎用性の高いシンプルなデザイン。<br>コーポレートサイト、ブログ、ショップ、学校・習い事など、どのような業種にもお使いいただけます。',
			'top_slide_text_btn_3'          => '詳しくはこちら',
			'top_slide_text_align_3'        => 'left',
			'top_slide_text_color_3'        => '#000000',
			'top_slide_text_shadow_use_3'   => false,
			'top_slide_text_shadow_color_3' => '',
			'top_slide_prefix' => 'katawara_',
		);
		$options = apply_filters( 'vk_advanced_slider_default_options', $options );
		return $options;
	}
	require_once dirname( __FILE__ ) . '/package/vk-sanitize.php';
	require_once dirname( __FILE__ ) . '/package/class-vk-advanced-slider.php';
}

global $vk_advansed_slider_prefix;
$vk_advansed_slider_prefix = katawara_get_prefix_customize_panel();
