<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array(  ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );

// END ENQUEUE PARENT ACTION

//Publish kintone data で【下書き】保存を【公開】で保存されるように変更 
function customize_import_kintone_insert_post_status( $status ) {

	return 'publish'; // デフォルト【公開】
}

add_filter( 'import_kintone_insert_post_status', 'customize_import_kintone_insert_post_status' );
//Publish kintone data で【下書き】保存を【公開】で保存されるように変更 


//Publish kintone data でデフォルトの投稿ユーザーを設定する
function customize_import_kintone_insert_post_author( $author_id ) {

	return 3; // ユーザーID nkwp_post
}

add_filter( 'import_kintone_insert_post_author', 'customize_import_kintone_insert_post_author' );
//Publish kintone data でデフォルトの投稿ユーザーを設定する