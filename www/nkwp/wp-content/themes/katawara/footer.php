<?php
/**
 * Footer Template for Page of Katawara
 *
 * @package katawara
 */

?>
<?php if ( is_active_sidebar( 'footer-upper-widget' ) ) : ?>
<div class="l-site-footer-upper">
	<div class="l-container ">
		<div class="row">
			<div class="col-lg-12">
			<?php dynamic_sidebar( 'footer-upper-widget' ); ?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<?php do_action( 'katawara_footer_before' ); ?>

<footer class="l-site-footer">
	<?php
	$footer_widget_area_count = 3;
	$footer_widget_area_count = apply_filters( 'katawara_footer_widget_area_count', $footer_widget_area_count );
	$footer_widget_exists     = false;
	for ( $i = 1; $i <= $footer_widget_area_count; $i++ ) {
		if ( is_active_sidebar( 'footer-widget-' . $i ) ) {
			$footer_widget_exists = true;
		}
	}
	?>
	<?php if ( true === $footer_widget_exists ) : ?>
		<div class="l-site-footer_main">
			<div class="l-container">

				<div class="row ">
					<?php
					// Area setting.
					$footer_widget_area = array(
						// Use 1 widget area.
						1 => array( 'class' => 'col-lg-12 col-sm-12' ),
						// Use 2 widget area.
						2 => array( 'class' => 'col-lg-6 col-sm-6' ),
						// Use 3 widget area.
						3 => array( 'class' => 'col-lg-4 col-sm-6' ),
						// Use 4 widget area.
						4 => array( 'class' => 'col-lg-3 col-sm-6' ),
						// Use 4 widget area.
						6 => array( 'class' => 'col-lg-2 col-sm-6' ),
					);

					// Print widget area.
					for ( $i = 1; $i <= $footer_widget_area_count; ) {
						echo '<div class="' . esc_attr( $footer_widget_area[ $footer_widget_area_count ]['class'] ) . '">';
						if ( is_active_sidebar( 'footer-widget-' . $i ) ) {
							dynamic_sidebar( 'footer-widget-' . $i );
						}
						echo '</div>';
						$i++;
					}
					?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( has_nav_menu( 'footer-navigation' ) ) : ?>

		<div class="l-site-footer_menu">
			<div class="l-container">
				<?php
				wp_nav_menu(
					array(
						'menu_class'     => 'p-footer-menu',
						'theme_location' => 'footer-navigation',
						'fallback_cb'    => '',
					)
				);
				?>
			</div>
		</div>
	<?php endif; ?>
	<div class="p-copyright">
		<div><?php katawara_the_footerCopyRight(); ?></div>
	</div>
</footer>
</div><!-- [ /.l-site-container ] -->
</div><!-- [/.l-site ] -->
<?php wp_footer(); ?>
</body>
</html>
