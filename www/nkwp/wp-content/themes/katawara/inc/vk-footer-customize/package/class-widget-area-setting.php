<?php
/**
 * Widget Setting
 *
 * @package Katawara
 */

if ( ! class_exists( 'Widget_Area_Setting' ) ) {
	/**
	 * Widget_Area_Setting
	 */
	class Widget_Area_Setting {
		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'customize_register', array( __CLASS__, 'resister_customize' ) );
			add_action( 'wp_head', array( __CLASS__, 'enqueue_style' ), 5 );
			add_filter( 'katawara_footer_widget_area_count', array( __CLASS__, 'set_footter_widget_area_count' ) );
		}

		/**
		 * Customizer.
		 *
		 * @param \WP_Customize_Manager $wp_customize Customizer.
		 */
		public static function resister_customize( $wp_customize ) {
			global $vk_footer_customize_prefix;
			global $vk_footer_customize_priority;
			if ( ! $vk_footer_customize_priority ) {
				$vk_footer_customize_priority = 540;
			}
			$priority = $vk_footer_customize_priority + 2;

			// add section.
			$wp_customize->add_section(
				'vk_footer_option',
				array(
					'title'    => $vk_footer_customize_prefix . __( 'Footer settings', 'katawara' ),
					'priority' => $vk_footer_customize_priority,
				)
			);

			// Footer Upper Widget Area Heading.
			$wp_customize->add_setting(
				'footer-widget-setting',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				new Custom_Html_Control(
					$wp_customize,
					'footer-widget-setting',
					array(
						'label'            => __( 'Footer Widget Setting', 'katawara' ),
						'section'          => 'vk_footer_option',
						'type'             => 'text',
						'custom_title_sub' => '',
						'custom_html'      => '',
						'priority'         => $priority,
					)
				)
			);

			// Padding Bottom.
			$wp_customize->add_setting(
				'katawara_widget_setting[footer_upper_widget_padding_delete]',
				array(
					'default'           => false,
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => array( 'VK_Helpers', 'sanitize_choice' ),
				)
			);

			$wp_customize->add_control(
				'katawara_widget_setting[footer_upper_widget_padding_delete]',
				array(
					'label'    => __( 'Footer Upper Widget Padding', 'katawara' ),
					'section'  => 'vk_footer_option',
					'settings' => 'katawara_widget_setting[footer_upper_widget_padding_delete]',
					'type'     => 'select',
					'choices'  => array(
						false => __( 'Nothing to do', 'katawara' ),
						true  => __( 'Delete Padding', 'katawara' ),
					),
					'priority' => $priority,
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'katawara_widget_setting[footer_upper_widget_padding_delete]',
				array(
					'selector'        => '.l-site-footer-upper',
					'render_callback' => '',
				)
			);

			// Number of Footer Widget area.
			$wp_customize->add_setting(
				'katawara_widget_setting[footer_widget_area_count]',
				array(
					'default'           => 3,
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => array( 'VK_Helpers', 'sanitize_number' ),
				)
			);

			$wp_customize->add_control(
				'katawara_widget_setting[footer_widget_area_count]',
				array(
					'label'       => __( 'Footer Widget Area Count', 'katawara' ),
					'section'     => 'vk_footer_option',
					'settings'    => 'katawara_widget_setting[footer_widget_area_count]',
					'type'        => 'select',
					'choices'     => array(
						1 => __( '1 column', 'katawara' ),
						2 => __( '2 column', 'katawara' ),
						3 => __( '3 column', 'katawara' ),
						4 => __( '4 column', 'katawara' ),
						6 => __( '6 column', 'katawara' ),
					),
					'description' => __( '* If you save and reload after making changes, the number of the widget area setting panels  will increase or decrease.', 'katawara' ),
					'priority'    => $priority,
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'katawara_widget_setting[footer_widget_area_count]',
				array(
					'selector'        => '.footerWidget',
					'render_callback' => '',
				)
			);
		}

		/**
		 * Enqueue Style.
		 */
		public static function enqueue_style() {
			$options     = get_option( 'katawara_widget_setting' );
			$dynamic_css = '';
			if ( ! empty( $options['footer_upper_widget_padding_delete'] ) ) {
				$dynamic_css  = '.l-site-footer-upper{';
				$dynamic_css .= 'padding:0;';
				$dynamic_css .= '}';
			}
			wp_add_inline_style( 'katawara-design-style', $dynamic_css );
		}

		/**
		 * Footer Widget Area Count.
		 *
		 * @param int $footer_widget_area_count Footer Widget Area Count.
		 */
		public static function set_footter_widget_area_count( $footer_widget_area_count ) {
			$footer_widget_area_count = 3;
			$options                  = get_option( 'katawara_widget_setting' );
			if ( ! empty( $options['footer_widget_area_count'] ) ) {
				$footer_widget_area_count = (int) $options['footer_widget_area_count'];
			}
			return $footer_widget_area_count;
		}

	}
	new Widget_Area_Setting();
}
