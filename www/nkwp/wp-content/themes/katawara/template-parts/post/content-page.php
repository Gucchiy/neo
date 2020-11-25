<?php
/**
 * Content Area for Page
 *
 * @package Katawara
 */

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'katawara_article_outer_class', '' ) ); ?>>

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
			do_action( 'katawara_comment_space' );
			?>
		</article>
		<?php
	}
}
