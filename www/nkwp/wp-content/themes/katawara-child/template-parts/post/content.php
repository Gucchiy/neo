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

				<?php /*?>2020年11月2日 カスタムフィールドの値を記事本文に表示する　
				https://vws.vektor-inc.co.jp/archives/customize_tips/the_content_filter_remove<?php */?>
				<?php
				// シェアボタンのフィルターを一旦外す
				remove_filter( 'the_content', 'veu_add_sns_btns', 200, 1 );
				// 関連記事のフィルターを一旦外す
				remove_filter( 'the_content', 'veu_add_related_posts_html', 800, 1 );
				// FollowMeのフィルターを一旦外す
			remove_filter( 'the_content', 'veu_add_follow' );
			// CTAのフィルターを一旦外す
			remove_filter( 'the_content', array( 'Vk_Call_To_Action', 'content_filter' ), 100 );
			// 著者情報のフィルターを一旦外す
			remove_filter( 'the_content', 'pad_add_author' );
?>

			<?php the_content();?>

<?php /*?>★ ★ ★ ★ ★ 
ここにカスタムフィールドなど 独自に書いてください。
★ ★ ★ ★ <?php */?>
				<div class="wp-kintone">

					<?php $attachment_id = get_post_meta( $post->ID , 'attachment_01' , true ); ?>
					<?php if($attachment_id): ?>
					<?php echo wp_get_attachment_image( $attachment_id, 'medium'); ?>
					<?php endif; ?>

<?php /*?>					//preで囲んで出力<?php */?>
<?php
					echo('<pre>');
var_dump($attachment_01);
echo('</pre>');
?>					
					<?php $attachment_id = get_post_meta( $post->ID , 'attachment_02' , true ); ?>
					<?php if($attachment_id): ?>
					<?php echo wp_get_attachment_image( $attachment_id, 'medium'); ?>
					<?php endif; ?>


				<?php
					echo('<pre>');
var_dump($attachment_02);
echo('</pre>');
?>	
				</div>
				
				<?php
				if ( function_exists( 'veu_get_related_posts_html' ) ){
					echo veu_get_related_posts_html();
				}
				if ( function_exists( 'veu_get_follow_html' ) ){
					echo veu_get_follow_html();
				}
				if ( class_exists( 'Vk_Call_To_Action' ) ) {
					echo Vk_Call_To_Action::render_cta_content( Vk_Call_To_Action::is_cta_id() );
				}
				if ( function_exists( 'veu_get_sns_btns' ) ){
					echo veu_get_sns_btns();
				}
				if ( class_exists( 'Vk_Post_Author_Box' ) ) {
					echo Vk_Post_Author_Box::pad_get_author_box();
				}
				?>

				<?php
				// 再びシェアボタンのフィルター処理を追加する
				add_filter( 'the_content', 'veu_add_sns_btns', 200, 1 );
				// 再び関連記事のフィルター処理を追加する
				add_filter( 'the_content', 'veu_add_related_posts_html', 800, 1 );
				// 再びFollowMeのフィルター処理を追加する
				add_filter( 'the_content', 'veu_add_follow' );
				// 再び著者情報のフィルター処理を追加する
				add_filter( 'the_content', 'pad_add_author' );
				// 再びCTAのフィルター処理を追加する
				add_filter( 'the_content', array( 'Vk_Call_To_Action', 'content_filter' ), 100 );
				?>
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
