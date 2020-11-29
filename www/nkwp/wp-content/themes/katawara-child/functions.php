<?php
/**
 * Functions of Katawara Child
 * 
 * @package Katawara Child
 */

/**
 * Define Theme Version
 */
$theme_opt = wp_get_theme( get_stylesheet() );
define('KATAWARA_CHILD_THEME_VERSION', $theme_opt->version );

/**
 * Enqueue Child Styles
 */
function katawara_child_enqueue_style() {
    wp_enqueue_style( 'katawara-child-style', get_theme_file_uri( 'style.css' ), array( 'katawara-design-style' ), KATAWARA_CHILD_THEME_VERSION );
}
add_action( 'wp_enqueue_scripts', 'katawara_child_enqueue_style' );

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

//ステータスが「承認済み」の時のみ WP にポストされるように変更
function custom_kintone_to_wp_kintone_data($kintone_data){
    if( strcmp( $kintone_data['record']['ステータス']['value'], '承認済み・WEB反映' ) != 0 ){
      // WPに取り込みたいスタータスではない場合、空の配列をリターンする
      return array();
    }
    
    return $kintone_data;
  }
  
  add_filter( 'kintone_to_wp_kintone_data', 'custom_kintone_to_wp_kintone_data' );
