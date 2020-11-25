<?php
/**
 * Content Area
 *
 * @package Katawara
 */

$options       = get_option( 'vk_page_header' );
$get_post_type = katawara_get_post_type();

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'katawara_article_outer_class', '' ) ); ?>>
			<?php if ( empty( $options[ 'displaytype_' . $get_post_type['slug'] ] ) || 'post_title_and_meta' !== $options[ 'displaytype_' . $get_post_type['slug'] ] ) : ?>
				<header class="<?php katawara_the_class_name( 'p-entry_header' ); ?>">
					<?php get_template_part( 'template-parts/post/meta' ); ?>
					<h1 class="p-entry_title"><?php the_title(); ?></h1>
				</header>
			<?php endif; ?>


			<?php do_action( 'katawara_entry_body_before' ); ?>
			<div class="p-entry-content">
				<?php the_content(); ?>
			</div>
			<?php do_action( 'katawara_entry_body_after' ); ?>

			<div class="<?php katawara_the_class_name( 'p-entry_footer' ); ?>">

				<?php
				$args = array(
					'before'      => '<nav class="page-link"><dl><dt>Pages :</dt><dd>',
					'after'       => '</dd></dl></nav>',
					'link_before' => '<span class="page-numbers">',
					'link_after'  => '</span>',
					'echo'        => 1,
				);
				wp_link_pages( $args );

				// Category and tax data.
				$args           = array(
					// translators: Template of Taxonomy List.
					'template'      => __( '<dl><dt>%s</dt><dd>%l</dd></dl>', 'katawara' ),
					'term_template' => '<a href="%1$s">%2$s</a>',
				);
				$taxonomies     = get_the_taxonomies( $post->ID, $args );
				$taxnomies_html = '';
				if ( $taxonomies ) {
					foreach ( $taxonomies as $key => $value ) {
						if ( 'post_tag' !== $key ) {
							$taxnomies_html .= '<div class="p-entry_meta_data-list">' . $value . '</div>';
						}
					} // foreach.
				} // if.
				$taxnomies_html = apply_filters( 'katawara_taxnomies_html', $taxnomies_html );
				echo wp_kses_post( $taxnomies_html );

				// tag list.
				$tags_list = get_the_tag_list();
				if ( $tags_list ) {
					?>
					<div class="p-entry_meta_data-list entry-tag">
						<dl>
							<dt><?php esc_html_e( 'Tags', 'katawara' ); ?></dt>
							<dd class="tagcloud"><?php echo wp_kses_post( $tags_list ); ?></dd>
						</dl>
					</div><!-- [ /.entry-tag ] -->
				<?php } ?><!-- if tags_list -->

			</div><!-- [ /.entry-footer ] -->


			<?php
			do_action( 'katawara_comment_before' );
			comments_template( '', true );
			do_action( 'katawara_comment_after' );
			?>
		</article>
		<?php
	}
}
get_template_part( 'template-parts/post/next-prev', get_post_type() );
