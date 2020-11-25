<?php

/*
  customize_register
/*-------------------------------------------*/
add_action( 'customize_register', 'katawara_customize_register_layout' );
function katawara_customize_register_layout( $wp_customize ) {

	$wp_customize->add_section(
		'katawara_layout',
		array(
			'title'    => katawara_get_prefix_customize_panel() . __( 'Layout settings', 'katawara' ),
			'priority' => 503,
		// 'panel'				=> 'katawara_setting',
		)
	);
	// Add setting
	$wp_customize->add_setting(
		'katawara_column_setting',
		array(
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		new Custom_Html_Control(
			$wp_customize,
			'katawara_column_setting',
			array(
				'label'            => __( 'Main Column Setting', 'katawara' ) . ' ( ' . __( 'PC mode', 'katawara' ) . ' )',
				'section'          => 'katawara_layout',
				'type'             => 'text',
				'custom_title_sub' => '',
				'custom_html'      => '',
				// 'priority'         => 700,
			)
		)
	);

	$page_types = array(
		'front-page' => array(
			'label'       => __( 'Home page', 'katawara' ),
			'description' => '',
		),
		'search'     => array(
			'label' => __( 'Search', 'katawara' ),
		),
		'error404'   => array(
			'label' => __( '404 page', 'katawara' ),
		),
		// If cope with custom post types that like a "archive-post" "single-post".
	);

	$get_post_types = get_post_types(
		array(
			'public' => true,
		),
		'object'
	);

	foreach ( $get_post_types as $get_post_type ) {
		$archive_link = get_post_type_archive_link( $get_post_type->name );
		if ( $archive_link ) {
			$page_types = $page_types + array(
				'archive-' . $get_post_type->name => array(
					'label' => __( 'Archive Page', 'katawara' ) . ' [' . esc_html( $get_post_type->label ) . ']',
				),
			);
		}
	}

	foreach ( $get_post_types as $get_post_type ) {
		$page_types = $page_types + array(
			'single-' . $get_post_type->name => array(
				'label' => __( 'Single Page', 'katawara' ) . ' [' . esc_html( $get_post_type->label ) . ']',
			),
		);
	}

	$choices = array(
		'default'               => __( 'Unspecified', 'katawara' ),
		'col-two'               => __( '2 column', 'katawara' ),
		'col-one'               => __( '1 column', 'katawara' ),
		'col-one-no-subsection' => __( '1 column ( No sub section )', 'katawara' ),
	);
	$choices = apply_filters( 'katawara_columns_setting_choice', $choices );

	$wp_customize->selective_refresh->add_partial(
		'katawara_theme_options[layout][front-page]',
		array(
			'selector'        => '.l-main-section',
			'render_callback' => '',
		)
	);

	foreach ( $page_types as $key => $value ) {
		$wp_customize->add_setting(
			'katawara_theme_options[layout][' . $key . ']',
			array(
				'default'           => 'default',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'katawara_theme_options[layout][' . $key . ']',
			array(
				'label'    => $value['label'],
				'section'  => 'katawara_layout',
				'settings' => 'katawara_theme_options[layout][' . $key . ']',
				'type'     => 'select',
				'choices'  => $choices,
				// 'priority' => 700,
			)
		);
	}

	$wp_customize->add_setting(
		'katawara_sidebar_setting',
		array(
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		new Custom_Html_Control(
			$wp_customize,
			'katawara_sidebar_setting',
			array(
				'label'            => __( 'Sidebar Setting', 'katawara' ),
				'section'          => 'katawara_layout',
				'type'             => 'text',
				'custom_title_sub' => '',
				'custom_html'      => '',
				// 'priority'         => 700,
			)
		)
	);

	// sidebar_position
	$wp_customize->add_setting(
		'katawara_theme_options[sidebar_position]',
		array(
			'default'           => 'right',
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => array( 'VK_Helpers', 'sanitize_choice' ),
		)
	);
	$wp_customize->add_control(
		'katawara_theme_options[sidebar_position]',
		array(
			'label'    => __( 'Sidebar position ( PC mode )', 'katawara' ),
			'section'  => 'katawara_layout',
			'settings' => 'katawara_theme_options[sidebar_position]',
			'type'     => 'radio',
			'choices'  => array(
				'right' => __( 'Right', 'katawara' ),
				'left'  => __( 'Left', 'katawara' ),
			),
		)
	);

	// sidebar_fix
	$wp_customize->add_setting(
		'katawara_sidebar_fix_setting_title',
		array(
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		new Custom_Html_Control(
			$wp_customize,
			'katawara_sidebar_fix_setting_title',
			array(
				'label'            => '',
				'section'          => 'katawara_layout',
				'type'             => 'text',
				'custom_title_sub' => __( 'Sidebar fix', 'katawara' ),
				'custom_html'      => '',
			)
		)
	);
	$wp_customize->add_setting(
		'katawara_theme_options[sidebar_fix]',
		array(
			'default'           => false,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => array( 'VK_Helpers', 'sanitize_checkbox' ),
		)
	);
	$wp_customize->add_control(
		'katawara_theme_options[sidebar_fix]',
		array(
			'label'    => __( 'Don\'t fix the sidebar', 'katawara' ),
			'section'  => 'katawara_layout',
			'settings' => 'katawara_theme_options[sidebar_fix]',
			'type'     => 'checkbox',
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'katawara_theme_options[sidebar_fix]',
		array(
			'selector'        => '.l-side-section',
			'render_callback' => '',
		)
	);

}
