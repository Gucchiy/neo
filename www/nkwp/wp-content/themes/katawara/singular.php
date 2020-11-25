<?php
/**
 * Single Template of Katawara
 *
 * @package katawara
 */

get_header();
if ( katawara_is_page_header_and_breadcrumb() ) {
	// Page Header.
	get_template_part( 'template-parts/page-header' );
	// BreadCrumb.
	do_action( 'katawara_breadcrumb_before' );
	get_template_part( 'template-parts/breadcrumb' );
	do_action( 'katawara_breadcrumb_after' );
}
?>

<div class="l-container">
	<div class="<?php katawara_the_class_name( 'l-container_inner' ); ?>">

		<main class="<?php katawara_the_class_name( 'l-main-section' ); ?>" id="main" role="main">
			<?php
			do_action( 'katawara_container_main_prepend' );
			get_template_part( 'template-parts/post/content', get_post_type() );
			do_action( 'katawara_container_main_append' );
			?>
		</main>

		<?php if ( katawara_is_subsection_display() ) : ?>
			<aside class="<?php katawara_the_class_name( 'l-side-section' ); ?>">
				<div class="l-side-section_inner">
					<?php get_sidebar( get_post_type() ); ?>
				</div>
			</aside><!-- [ /l-side-section ] -->
		<?php endif; ?>

	</div><!-- [ /.l-container_inner ] -->
</div><!-- [ /.l-container ] -->
<?php get_footer(); ?>
