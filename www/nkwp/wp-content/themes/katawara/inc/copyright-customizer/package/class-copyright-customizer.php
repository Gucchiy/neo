<?php
/*
このファイルの元ファイルは
https://github.com/vektor-inc/vektor-wp-libraries
にあります。修正の際は上記リポジトリのデータを修正してください。
*/

class Katawara_Copyright_Custom {

	private static $instance;

	private function __construct() {

	}

	public static function instance() {
		if ( isset( self::$instance ) ) {
			return self::$instance;
		}

		self::$instance = new Katawara_Copyright_Custom;
		self::$instance->run_init();

		return self::$instance;
	}

	protected function run_init() {
		add_filter( 'katawara_footerCopyRightCustom', array( $this, 'footerCopyRightCustom' ), 499, 1 );
		add_filter( 'katawara_footerPoweredCustom', array( $this, 'footerPoweredCustom' ), 499, 1 );
		add_action( 'customize_register', array( $this, 'customize_register' ) );
		add_action( 'wp_head', array( $this, 'admin_css' ), 10, 2 );
	}

	public function admin_css() {
		if ( is_customize_preview() ) {
				?>
				<style type="text/css">
				.copySection .customize-partial-edit-shortcut button { top:-30px; }
				</style>
				<?php
		}
	}
	public function customize_register( $wp_customize ) {
		global $vk_copyright_customizer_prefix;
		global $vk_copyright_customizer_priority;
		if ( ! $vk_copyright_customizer_priority ){
			$vk_copyright_customizer_priority = 900;
		}
		$wp_customize->add_section(
			'katawara_copyright_section', array(
				'title'    => $vk_copyright_customizer_prefix . __( 'Copyright Setting', 'katawara' ),
				'priority' => $vk_copyright_customizer_priority,
			)
		);

		$add_setting_array = array(
			'default'           => self::get_option(),
			'type'              => 'option',
			'capability'        => 'edit_theme_options', // 操作権限
			'sanitize_callback' => array( $this, 'sanitize_callback' ),
		);

		$wp_customize->add_setting( 'katawara_copyright', $add_setting_array );

		$wp_customize->add_control(
			'katawara_copyright',
			array(
				'label'       => $vk_copyright_customizer_prefix . __( 'Copyright Setting', 'katawara' ),
				'section'     => 'katawara_copyright_section',
				'settings'    => 'katawara_copyright',
				'type'        => 'textarea',
				'priority'    => 21,
				'description' => __( 'Please fill box to footer html text you want.', 'katawara' )
								 . '<br/>'
								 . __( 'If you fill noting, Footer will display noting.', 'katawara' ),
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'katawara_copyright', array(
				'selector'        => '.copySection',
				'render_callback' => '',
			)
		);

	}

	public static function get_option() {
		$default_copyright = 'Copyright &copy; ' . get_bloginfo( 'name' ) . ' All Rights Reserved.';
		return get_option( 'katawara_copyright', $default_copyright );
	}

	public function footerCopyRightCustom( $katawara_footerCopyRight ) {
		$katawara_copyright = self::get_option();
		if ( $katawara_copyright === null ) {
			$text = $katawara_footerCopyRight;
		} elseif ( $katawara_copyright ) {
			$text = '<p>' . wp_kses_post( self::get_option() ) . '</p>';
		} else {
			$text = '';
		}
		return $text;
	}

	public function footerPoweredCustom( $powerd ) {
		$katawara_copyright = self::get_option();
		if ( $katawara_copyright === null ) {
			$text = $powerd;
		} else {
			$text = '';
		}
		return $text;
	}

	public function sanitize_callback( $option ) {
		$option = stripslashes( $option );

		return $option;
	}

}

Katawara_Copyright_Custom::instance();
