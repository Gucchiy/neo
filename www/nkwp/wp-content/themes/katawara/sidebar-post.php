<?php
/**
 * Sidebar Template for Post of Katawara
 *
 * @package katawara
 */

if ( is_active_sidebar( 'common-side-top-widget-area' ) ) {
	dynamic_sidebar( 'common-side-top-widget-area' );
}

// Display post type widget area.
$widdget_area_name = 'post-side-widget-area';
if ( is_active_sidebar( $widdget_area_name ) ) {
	dynamic_sidebar( $widdget_area_name );
} else {
	$post_loop = new WP_Query(
		array(
			'post_type'              => 'post',
			'posts_per_page'         => 10,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);
	if ( $post_loop->have_posts() ) :
		?>
		<aside class="p-widget p-widget-side">
			<h3 class="p-widget_title p-widget-side_title"><?php echo esc_html__( 'Recent posts', 'katawara' ); ?></h3>
			<?php
			while ( $post_loop->have_posts() ) :
				$post_loop->the_post();
				?>

				<div class="media">

					<?php if ( has_post_thumbnail() ) : ?>

						<div class="media-left postList_thumbnail">
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'thumbnail' ); ?>
							</a>
						</div>

					<?php endif; ?>

					<div class="media-body">
						<h4 class="media-heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						<div class="published entry-meta_items"><?php echo get_the_date(); ?></div>
					</div>
				</div>

			<?php endwhile; ?>
		</aside>
		<?php
	endif;
	wp_reset_postdata();
	?>

	<aside class="widget p-widget widget_categories p-widget-linklist">
		<nav class="localNav">
			<h3 class="subSection-title"><?php esc_html_e( 'Category', 'katawara' ); ?></h3>
			<ul>
				<?php wp_list_categories( 'title_li=' ); ?>
			</ul>
		</nav>
	</aside>

	<aside class="widget p-widget p-widget-subsection p-widget-archive p-widget-linklist">
		<nav class="localNav">
			<h3 class="subSection-title"><?php esc_html_e( 'Archive', 'katawara' ); ?></h3>
			<ul>
				<?php
				$args = array(
					'type'      => 'monthly',
					'post_type' => 'post',
				);
				wp_get_archives( $args );
				?>
			</ul>
		</nav>
	</aside>

	<?php
}

if ( is_active_sidebar( 'common-side-bottom-widget-area' ) ) {
	dynamic_sidebar( 'common-side-bottom-widget-area' );
}
