<?php
/*
  customize_register
/*-------------------------------------------*/
add_action( 'customize_register', 'katawara_customize_register_woo' );
function katawara_customize_register_woo( $wp_customize ) {




	$wp_customize->add_setting(
		'katawara_woo_options[image_border_archive]',
		array(
			'default'           => false,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => array( 'VK_Helpers', 'sanitize_checkbox' ),
		)
	);
	$wp_customize->add_control(
		'katawara_woo_options[image_border_archive]',
		array(
			'label'    => __( 'Add border to item image on item list section', 'katawara' ),
			'section'  => 'woocommerce_product_images',
			'settings' => 'katawara_woo_options[image_border]',
			'type'     => 'checkbox',
			'priority' => 800,
		)
	);

}
