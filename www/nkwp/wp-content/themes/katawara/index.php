<?php
/**
 * Index Template of Katawara
 *
 * @package katawara
 */

get_header();
// Page Header.
get_template_part( 'template-parts/page-header' );
// BreadCrumb.
do_action( 'katawara_breadcrumb_before' );
get_template_part( 'template-parts/breadcrumb' );
do_action( 'katawara_breadcrumb_after' );
?>

<div class="l-container">
	<div class="<?php katawara_the_class_name( 'l-container_inner' ); ?>">

		<main class="<?php katawara_the_class_name( 'l-main-section' ); ?>" id="main" role="main">
			<?php 
			do_action( 'katawara_container_main_prepend' );

			// Excrude to in case of filter search
			if ( ! is_search() ) {
			
			// Archive title.
			$archive_title_html = '';
			$page_for_posts     = katawara_get_page_for_posts();
			// Use post top page（ Archive title wrap to div ）.
			if ( $page_for_posts['post_top_use'] || get_post_type() !== 'post' ) {
				if ( is_year() || is_month() || is_day() || is_tag() || is_author() || is_tax() || is_category() ) { ?>
					<header class="p-archive-header">
					<h1 class="p-archive-header_title l-main-section_title">
						<?php echo wp_kses_post( get_the_archive_title() );?>
					</h1>
					<?php
						// Archive description.
						$archive_description_html = '';
						if ( is_category() || is_tax() || is_tag() ) {
							$archive_description = term_description();
							$page_number         = get_query_var( 'paged', 0 );
							if ( ! empty( $archive_description ) && 0 === $page_number ) {
								$archive_description_html = '<div class="p-archive-header_description">' . $archive_description . '</div>';
								echo wp_kses_post( apply_filters( 'katawara_main_section_archive_sescription', $archive_description_html ) );
							}
						}
					?>
					</header>
				<?php }
			}

			} // if ( ! is_search() ) {

			$get_post_type = katawara_get_post_type();

			do_action( 'katawara_loop_before' );
			?>

			<div class="<?php katawara_the_class_name( 'postList' ); ?>">

				<?php
				if ( have_posts() ) {
					if ( apply_filters( 'is_katawara_extend_loop', false ) ) {
						do_action( 'katawara_extend_loop' );
					} else {
						echo '<div class="vk_posts vk_posts-postType-' . esc_html( get_post_type() ) . ' vk_posts-layout-card">';
						while ( have_posts() ) {
							the_post();
							get_template_part( 'template-parts/post/loop', $get_post_type['slug'] );
						} // while have_posts.
						echo '</div>';
					}

					the_posts_pagination(
						array(
							'mid_size'           => 1,
							'prev_text'          => '&laquo;',
							'next_text'          => '&raquo;',
							'type'               => 'list',
							'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'katawara' ) . ' </span>',
						)
					);
				} else {
					?>
					<div class="well"><p><?php echo wp_kses_post( apply_filters( 'katawara_no_posts_text', __( 'No posts.', 'katawara' ) ) ); ?></p></div>
					<?php
				}
				?>
			</div><!-- [ /.postList ] -->
			<?php
			do_action( 'katawara_loop_after' );
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
