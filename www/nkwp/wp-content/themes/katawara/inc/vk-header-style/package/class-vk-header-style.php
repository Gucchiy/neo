<?php
/**
 * Header Customize
 *
 * @package Katawara
 */
if ( ! class_exists( 'VK_Header_Style' ) ) {

	/**
	 * Header Customize Class
	 */
	class VK_Header_Style {

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'customize_register', array( __CLASS__, 'resister_customize' ) );
			add_filter( 'katawara_dynamic_css', array( __CLASS__, 'additional_css' ) );
		}

		/**
		 * Defualt Options
		 */
		public static function options() {

			$default = array(
				'header_background_color' => '',
				'header_title_text_color' => '',
				'header_text_color'       => '',
			);
			$options = get_option( 'vk_header_option' );
			$options = wp_parse_args( $options, $default );
			return $options;
		}

		/**
		 * Register Customize
		 *
		 * @param \WP_Customize_Manager $wp_customize Customizer.
		 */
		public static function resister_customize( $wp_customize ) {

			global $vk_header_customize_priority;
			global $vk_header_customize_prefix;

			if ( ! $vk_header_customize_priority ) {
				$vk_header_customize_priority = 504;
			}
			$priority = $vk_header_customize_priority + 1;

			// add section.
			$wp_customize->add_section(
				'vk_header_option',
				array(
					'title'    => $vk_header_customize_prefix . __( 'Header settings', 'katawara' ),
					'priority' => $vk_header_customize_priority,
				)
			);

			// header Setting Heading.
			$wp_customize->add_setting(
				'header-setting',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				new Custom_Html_Control(
					$wp_customize,
					'header-setting',
					array(
						'label'            => __( 'Header Style Setting', 'katawara' ).'(Beta)',
						'section'          => 'vk_header_option',
						'type'             => 'text',
						'custom_title_sub' => '',
						'custom_html'      => '',
						'priority'         => $priority,
					)
				)
			);

			// header Background Color.
			$wp_customize->add_setting(
				'vk_header_option[header_background_color]',
				array(
					'default'           => null,
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'vk_header_option[header_background_color]',
					array(
						'label'    => __( 'Header Background Color', 'katawara' ),
						'section'  => 'vk_header_option',
						'settings' => 'vk_header_option[header_background_color]',
						'priority' => $priority,
					)
				)
			);

			// header Text Color.
			$wp_customize->add_setting(
				'vk_header_option[header_title_text_color]',
				array(
					'default'           => null,
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'vk_header_option[header_title_text_color]',
					array(
						'label'    => __( 'Header Title Text Color', 'katawara' ),
						'section'  => 'vk_header_option',
						'settings' => 'vk_header_option[header_title_text_color]',
						'priority' => $priority,
					)
				)
			);

			// header Text Color.
			$wp_customize->add_setting(
				'vk_header_option[header_text_color]',
				array(
					'default'           => null,
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'vk_header_option[header_text_color]',
					array(
						'label'    => __( 'Header Text Color', 'katawara' ),
						'section'  => 'vk_header_option',
						'settings' => 'vk_header_option[header_text_color]',
						'priority' => $priority,
					)
				)
			);
		}

		/**
		 * Enqueue Styles
		 */
		public static function additional_css( $dynamic_css ) {

			global $vk_header_selecter_array;
			global $vk_header_customize_hook_style;

			$options = self::options();

			$bg_color         = $options['header_background_color'];
			$bg_color_dark    = VK_Helpers::color_auto_modifi( $bg_color, 0.9 );
			$title_text_color = $options['header_title_text_color'];
			$text_color       = $options['header_text_color'];

			if ( ! empty( $bg_color ) || ! empty( $text_color ) || ! empty( $image ) ) {
				$dynamic_css .= $vk_header_selecter_array['background'] . '{';

					if ( ! empty( $bg_color ) ) {
						$dynamic_css .= 'background-color:' . $bg_color . ';';
					}

					if ( ! empty( $text_color ) ) {
						$dynamic_css .= 'color:' . $text_color . ';';
					}

				$dynamic_css .= '}';

				if ( ! empty( $bg_color_dark ) ) {
					$dynamic_css .= $vk_header_selecter_array['background_dark'] . '{';
						$dynamic_css .= 'background-color:' . $bg_color_dark . ';';
					$dynamic_css .= '}';
				}

				if ( ! empty( $title_text_color ) ) {
					$dynamic_css .= $vk_header_selecter_array['title'] . '{';
					$dynamic_css .= 'color:' . $title_text_color . ';';
					$dynamic_css .= '}';
				}

				if ( ! empty( $text_color ) ) {
					$dynamic_css .= $vk_header_selecter_array['text'] . '{';
					$dynamic_css .= 'color:' . $text_color . ';';
					$dynamic_css .= '}';
				}

				if ( $bg_color ) {
					if ( class_exists( 'VK_Helpers' ) ) {
						$mode = VK_Helpers::color_mode_check( $bg_color );
						if ( $mode['mode'] === 'dark' ) {
							$dynamic_css .= ':root {
								--color-header-border:rgba(255, 255, 255, 0.3);
							}';
							$dynamic_css .= '
							.p-global-menu>li:before,
							.p-global-menu>li.current-menu-item:before{
								border:none;
							}
							.p-global-menu .acc-btn:not(.acc-btn-close) {
								background-image : var(--vk-menu-acc-icon-open-white-bg-src);
							}
							.l-site-header .btn-default,
							.l-site-header .btn-primary{
								border-color: rgba(255, 255, 255, 0.5);
							}
							';
						}
					}
				}
			}

			return $dynamic_css;

		}
	}
	new VK_Header_Style();
}
