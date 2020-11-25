<?php
/**
 * Front Page Template of Katawara
 *
 * @package katawara
 */

get_header();
do_action( 'katawara_top_slide_before' );
get_template_part( 'template-parts/slide' );
do_action( 'katawara_top_slide_after' );
?>
<div class="l-container">
	<div class="<?php katawara_the_class_name( 'l-container_inner' ); ?>">

		<main class="<?php katawara_the_class_name( 'l-main-section' ); ?>" id="main" role="main">
			<?php
			do_action( 'katawara_container_main_prepend' );

			do_action( 'katawara_home_content_top_widget_area_before' );
			if ( is_active_sidebar( 'home-content-top-widget-area' ) ) {
				dynamic_sidebar( 'home-content-top-widget-area' );
			}
			do_action( 'katawara_home_content_top_widget_area_after' );

			if ( apply_filters( 'is_katawara_home_content_display', true ) ) {
				if ( have_posts() ) {
					if ( 'page' === get_option( 'show_on_front' ) ) {
						while ( have_posts() ) {
							the_post();
							?>
							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<?php do_action( 'katawara_entry_body_before' ); ?>
									<div class="p-entry-content">
										<?php the_content(); ?>
									</div>
								<?php
								do_action( 'katawara_entry_body_after' );
								$args = array(
									'before'      => '<nav class="page-link"><dl><dt>Pages :</dt><dd>',
									'after'       => '</dd></dl></nav>',
									'link_before' => '<span class="page-numbers">',
									'link_after'  => '</span>',
									'echo'        => 1,
								);
								wp_link_pages( $args );
								?>
							</article><!-- article -->
							<?php
						}
					} else {
						?>
						<div class="postList">

							<?php
							$get_post_type = katawara_get_post_type();
							if ( apply_filters( 'is_katawara_extend_loop', false ) ) {
								do_action( 'katawara_extend_loop' );
							} else {
								echo '<div class="vk_posts vk_posts-postType-' . esc_html( get_post_type() ) . ' vk_posts-layout-card">';
								while ( have_posts() ) {
									the_post();
									get_template_part( 'template-parts/post/loop', $get_post_type['slug'] );
								}
								echo '</div>';
							}
							the_posts_pagination(
								array(
									'mid_size'  => 1,
									'prev_text' => '&laquo;',
									'next_text' => '&raquo;',
									'type'      => 'list',
									'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'katawara' ) . ' </span>',
								)
							);
							?>

						</div><!-- [ /.postList ] -->

						<?php
					} // page show on front.
				} else {
					?>
					<div class="well"><p><?php echo wp_kses_post( apply_filters( 'katawara_no_posts_text', __( 'No posts.', 'katawara' ) ) ); ?></p></div>
					<?php
				}
			}
			do_action( 'katawara_container_main_append' );
			?>
		</main>

		<?php if ( katawara_is_subsection_display() ) : ?>
			<aside class="<?php katawara_the_class_name( 'l-side-section' ); ?>">
				<div class="l-side-section_inner">
					<?php get_sidebar(); ?>
				</div>
			</aside><!-- [ /l-side-section ] -->
		<?php endif; ?>

	</div><!-- [ /.l-container_inner ] -->
</div><!-- [ /.l-container ] -->
<?php get_footer(); ?>
