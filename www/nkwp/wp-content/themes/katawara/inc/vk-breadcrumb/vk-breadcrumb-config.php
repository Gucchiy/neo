<?php
if ( ! class_exists( 'VK_Breadcrumb' ) ) {
	global $vk_get_post_type;
	$vk_get_post_type = 'katawara_get_post_type';
	require get_parent_theme_file_path( '/inc/vk-breadcrumb/package/class-vk-breadcrumb.php' );


	/*
	プロジェクト毎に異なりそうな部分はここに global 変数などで書いて渡したり
	呼び出す場所毎に変動しそうなものはメソッドに引数を渡したりする

	/*
	テーマファイル内で
	VK_Breadcrumb::the_html( $args );
	のように書いて使う
	*/

}
