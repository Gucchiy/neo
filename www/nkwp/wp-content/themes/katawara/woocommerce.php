<?php
/**
 * Woocommerce Template of Katawara
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
		<?php do_action( 'katawara_mainSection_prepend' ); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php do_action( 'katawara_entry_body_before' ); ?>

			<?php woocommerce_content(); ?>

			<?php
			$args = array(
				'before'      => '<nav class="page-link"><dl><dt>Pages :</dt><dd>',
				'after'       => '</dd></dl></nav>',
				'link_before' => '<span class="page-numbers">',
				'link_after'  => '</span>',
				'echo'        => 1,
			);
			wp_link_pages( $args );
			?>

			<?php
				/**
				 * woocommerce_after_main_content hook.
				 *
				 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
				 */
				// do_action( 'woocommerce_after_main_content' );
			?>
			</article><!-- [ /#post-<?php the_ID(); ?> ] -->


		<?php do_action( 'katawara_mainSection_append' ); ?>
		</main><!-- [ /l-main-section ] -->


	<?php if ( katawara_is_subsection_display() ) : ?>
		<aside class="<?php katawara_the_class_name( 'l-side-section' ); ?>">
			<div class="l-side-section_inner">
				<?php
					/**
					 * woocommerce_sidebar hook.
					 *
					 * @hooked woocommerce_get_sidebar - 10
					 */
					do_action( 'woocommerce_sidebar' );
				?>
				<?php get_sidebar( get_post_type() ); ?>
			</div>
		</aside><!-- [ /l-side-section ] -->
	<?php endif; ?>


	</div><!-- [ /.l-container_inner  ] -->
</div><!-- [ /.l-container ] -->
<?php get_footer(); ?>
