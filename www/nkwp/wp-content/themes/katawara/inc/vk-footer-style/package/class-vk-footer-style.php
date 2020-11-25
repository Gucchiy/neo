<?php
/**
 * Footer Customize
 *
 * @package Katawara
 */
if ( ! class_exists( 'VK_Footer_Style' ) ) {

	/**
	 * Footer Customize Class
	 */
	class VK_Footer_Style {

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'customize_register', array( __CLASS__, 'resister_customize' ) );
			add_action( 'wp_head', array( __CLASS__, 'enqueue_style' ), 5 );
		}

		/**
		 * Defualt Options
		 */
		public static function options() {

			$default = array(
				'footer_background_color' => '',
				'footer_title_text_color' => '',
				'footer_text_color'       => '',
				'footer_image'            => '',
				'footer_image_repeat'     => 'no-repeat',
				'footer_image_justify'    => 'default',
			);
			$options = get_option( 'vk_footer_option' );
			$options = wp_parse_args( $options, $default );
			return $options;
		}

		/**
		 * Register Customize
		 *
		 * @param \WP_Customize_Manager $wp_customize Customizer.
		 */
		public static function resister_customize( $wp_customize ) {

			global $vk_footer_customize_priority;
			if ( ! $vk_footer_customize_priority ) {
				$vk_footer_customize_priority = 540;
			}
			$priority = $vk_footer_customize_priority + 1;

			// Footer Setting Heading.
			$wp_customize->add_setting(
				'footer-setting',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				new Custom_Html_Control(
					$wp_customize,
					'footer-setting',
					array(
						'label'            => __( 'Footer Style Setting', 'katawara' ).'(Beta)',
						'section'          => 'vk_footer_option',
						'type'             => 'text',
						'custom_title_sub' => '',
						'custom_html'      => '',
						'priority'         => $priority,
					)
				)
			);

			// Footer Background Color.
			$wp_customize->add_setting(
				'vk_footer_option[footer_background_color]',
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
					'vk_footer_option[footer_background_color]',
					array(
						'label'    => __( 'Footer Background Color', 'katawara' ),
						'section'  => 'vk_footer_option',
						'settings' => 'vk_footer_option[footer_background_color]',
						'priority' => $priority,
					)
				)
			);

			// Footer Text Color.
			$wp_customize->add_setting(
				'vk_footer_option[footer_title_text_color]',
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
					'vk_footer_option[footer_title_text_color]',
					array(
						'label'    => __( 'Footer Title Text Color', 'katawara' ),
						'section'  => 'vk_footer_option',
						'settings' => 'vk_footer_option[footer_title_text_color]',
						'priority' => $priority,
					)
				)
			);

			// Footer Text Color.
			$wp_customize->add_setting(
				'vk_footer_option[footer_text_color]',
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
					'vk_footer_option[footer_text_color]',
					array(
						'label'    => __( 'Footer Text Color', 'katawara' ),
						'section'  => 'vk_footer_option',
						'settings' => 'vk_footer_option[footer_text_color]',
						'priority' => $priority,
					)
				)
			);

			// Footer Image.
			$wp_customize->add_setting(
				'vk_footer_option[footer_image]',
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
					'vk_footer_option[footer_image]',
					array(
						'label'    => __( 'Footer Image', 'katawara' ),
						'section'  => 'vk_footer_option',
						'settings' => 'vk_footer_option[footer_image]',
						'priority' => $priority,
					)
				)
			);

			// Fotter Image Repeat.
			$wp_customize->add_setting(
				'vk_footer_option[footer_image_repeat]',
				array(
					'default'           => 'no-repeat',
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => array( 'VK_Helpers', 'sanitize_choice' ),
				)
			);

			$wp_customize->add_control(
				'vk_footer_option[footer_image_repeat]',
				array(
					'label'    => __( 'Footer Image Repeat', 'katawara' ),
					'section'  => 'vk_footer_option',
					'settings' => 'vk_footer_option[footer_image_repeat]',
					'type'     => 'select',
					'choices'  => array(
						'no-repeat' => __( 'No Repeat', 'katawara' ),
						'repeat-x'  => __( 'Repeat X', 'katawara' ),
						'repeat-y'  => __( 'Repeat Y', 'katawara' ),
						'repeat'    => __( 'Repeat X and Y', 'katawara' ),
					),
					'priority' => $priority,
				)
			);

			// Fotter Image Justify.
			$wp_customize->add_setting(
				'vk_footer_option[footer_image_justify]',
				array(
					'default'           => 'default',
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => array( 'VK_Helpers', 'sanitize_choice' ),
				)
			);

			$wp_customize->add_control(
				'vk_footer_option[footer_image_justify]',
				array(
					'label'    => __( 'Footer Image Justify', 'katawara' ),
					'section'  => 'vk_footer_option',
					'settings' => 'vk_footer_option[footer_image_justify]',
					'type'     => 'select',
					'choices'  => array(
						'default'              => __( 'Default', 'katawara' ),
						'cover'                => __( 'Cover', 'katawara' ),
						'justify-bottom'       => __( 'Justify Bottpm', 'katawara' ),
						'justify-left-bottom'  => __( 'Justify Left Bottom', 'katawara' ),
						'justify-right-bottom' => __( 'Justify Right Bottom', 'katawara' ),
					),
					'priority' => $priority,
				)
			);
		}

		/**
		 * Enqueue Styles
		 */
		public static function enqueue_style() {

			$options = self::options();

			$bg_color   = $options['footer_background_color'];
			$text_color = $options['footer_text_color'];
			$title_text_color = $options['footer_title_text_color'];
			$image      = $options['footer_image'];
			$repeat     = $options['footer_image_repeat'];
			$justify    = $options['footer_image_justify'];

			$dynamic_css = '';

			if ( ! empty( $bg_color ) || ! empty( $text_color ) || ! empty( $image ) ) {
				$dynamic_css .= '.l-site-footer {';

				if ( ! empty( $bg_color ) ) {
					$dynamic_css .= 'background-color:' . $bg_color . ';';
				}

				if ( ! empty( $text_color ) ) {
					$dynamic_css .= 'color:' . $text_color . ';';
				}

				if ( ! empty( $image ) ) {

					$dynamic_css .= 'background-image:url("' . $image . '");';

					if ( ! empty( $repeat ) ) {
						if ( 'no-repeat' === $repeat ) {
							$dynamic_css .= 'background-repeat:no-repeat;';
						} elseif ( 'repeat-x' === $repeat ) {
							$dynamic_css .= 'background-repeat:repeat-x;';
						} elseif ( 'repeat-y' === $repeat ) {
							$dynamic_css .= 'background-repeat:repeat-y;';
						} elseif ( 'repeat' === $repeat ) {
							$dynamic_css .= 'background-repeat:repeat;';
						}
					}

					if ( ! empty( $justify ) ) {
						if ( 'cover' === $justify ) {
							// Cover の場合の CSS.
							$dynamic_css .= 'background-position:center;';
							$dynamic_css .= 'background-size:cover;';
						} elseif ( 'justify-bottom' === $justify ) {
							// 下揃え の場合の CSS.
							$dynamic_css .= 'background-position:bottom;';
						} elseif ( 'justify-left-bottom' === $justify ) {
							// 左下揃え の場合の CSS.
							$dynamic_css .= 'background-position:bottom left;';
						} elseif ( 'justify-right-bottom' === $justify ) {
							// 右下揃えの場合の CSS.
							$dynamic_css .= 'background-position:bottom right;';
						}
					}
				}

				$dynamic_css .= '}';

				if ( ! empty( $title_text_color ) ) {
					$dynamic_css .= '.p-widget-footer .p-widget-footer_title{';
					$dynamic_css .= 'color:' . $title_text_color . ';';
					$dynamic_css .= '}';
				}

				if ( ! empty( $text_color ) ) {
					$dynamic_css .= '.p-footer-menu li a,';
					$dynamic_css .= '.p-widget-footer .nav li a,';
					$dynamic_css .= '.p-widget-footer ul li a,';
					$dynamic_css .= '.p-widget-footer .p-widget-archive a:before,';
					$dynamic_css .= '.p-widget-footer .menu-all-pages-container ul li .sub-menu li a::before,';
					$dynamic_css .= '.p-widget.p-widget-footer a {'; // .p-widget がないと ExUnit の 投稿リストで文字色が負ける
					$dynamic_css .= 'color:' . $text_color . ';';
					$dynamic_css .= '}';
				}

				if ( $bg_color ){
					if ( class_exists( 'VK_Helpers' ) ) {
						$mode = VK_Helpers::color_mode_check( $bg_color );
						if ( $mode['mode'] === 'dark' ) {
							$dynamic_css .= ':root {
								--color-footer-border:rgba(255, 255, 255, 0.2);
							}
							.p-widget-footer .veu_postList .postList_miniThumb .postList_item,
							.p-widget-footer .p-widget-footer_title,
							.p-widget-footer .p-widget-footer_title::before,
							.p-widget-footer .p-widget-footer_title::after {
								border-color:rgba(255, 255, 255, 0.5);
							}
							';
						}
					}
				}

				global $vk_footer_customize_hook_style;
				wp_add_inline_style( $vk_footer_customize_hook_style, $dynamic_css );
			}

		}
	}
	new VK_Footer_Style();
}
