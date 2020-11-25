<?php
/**
 * Header Template for Page of Katawara
 *
 * @package katawara
 */

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
} else {
	do_action( 'wp_body_open' );
}
do_action( 'katawara_header_before' );
global $katawara_theme_options;
$katawara_theme_options   = get_option( 'katawara_theme_options' );
$katawara_default_options = katawara_default_options();
$katawara_theme_options   = wp_parse_args( $katawara_theme_options, $katawara_default_options );
?>

<div class="<?php katawara_the_class_name( 'l-site' ); ?>">
	<header class="l-site-header">
		<?php do_action( 'katawara_header_prepend' ); ?>
		<div class="l-site-header_inner">
			<div class="p-site-header-brand">
				<?php
				if ( is_front_page() ) {
					$title_tag = 'h1';
				} else {
					$title_tag = 'p';
				}
				?>
				<<?php echo $title_tag; ?> class="p-site-header-brand_logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php if ( empty( $katawara_theme_options['head_logo'] ) ) : ?>
							<?php bloginfo( 'name' ); ?>
						<?php else : ?>
							<img src="<?php echo esc_url( $katawara_theme_options['head_logo'] ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
						<?php endif; ?>
					</a>
				</<?php echo $title_tag; ?>>
				<?php
				// falseと一致した場合.
				if ( false === ( '' === get_bloginfo( 'description' ) ) ) :
					?>
					<p class="p-site-header-brand_description"><?php bloginfo( 'description' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php do_action( 'katawara_header_logo_after' ); ?>
		<div class="l-site-header_global-menu">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'global-navigation',
					'container'      => 'nav',
					'menu_class'     => 'p-global-menu vk-menu-acc',
					'fallback_cb'    => '',
				)
			);
			?>
		</div>
		<div class="l-site-header_inner">
			<?php
			if ( is_active_sidebar( 'header-side-widget' ) ) {
				dynamic_sidebar( 'header-side-widget' );
			}
			?>
		</div>
		<?php do_action( 'katawara_header_append' ); ?>
	</header>
	<?php do_action( 'katawara_header_after' ); ?>
	<div class="l-site-container">
	<?php do_action( 'katawara_site-container_prepend' );