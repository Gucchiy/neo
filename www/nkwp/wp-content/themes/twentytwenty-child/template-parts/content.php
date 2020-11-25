<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since 1.0.0
 */

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<?php

	get_template_part( 'template-parts/entry-header' );

	if ( ! is_search() ) {
		get_template_part( 'template-parts/featured-image' );
	}

	?>

	<div>
	<?php 
	// 全ページに表示 : カテゴリメニュー
	get_template_part( 'template-parts/info-course' );  
	?>
	</div>

<?php if (is_user_logged_in()) : ?>

	<div>
	<?php
	if ( is_single() ) {
	
		get_template_part( 'template-parts/navigation' );
			
	}

		// 編集
		edit_post_link();

	?>
	</div>

<?php endif;?>



	<div class="post-inner <?php echo is_page_template( 'templates/template-full-width.php' ) ? '' : 'thin'; ?> ">
		
		<div class="entry-content">

		<?php $attachment_01 = get_field( 'attachment_01' ); ?>
		<?php if ( $attachment_01 ) : ?>
			<img src="<?php echo esc_url( $attachment_01['url'] ); ?>" alt="<?php echo esc_attr( $attachment_01['alt'] ); ?>" />
		<?php endif; ?>

<?php /*?>					//preで囲んで出力<?php */?>
<?php
					echo('<pre>');
var_dump($attachment_01);
echo('</pre>');
?>	
		<?php $attachment_02 = get_field( 'attachment_02' ); ?>
		<?php if ( $attachment_02 ) : ?>
			<img src="<?php echo esc_url( $attachment_02['url'] ); ?>" alt="<?php echo esc_attr( $attachment_02['alt'] ); ?>" />
		<?php endif; ?>

<?php /*?>					//preで囲んで出力<?php */?>
<?php
					echo('<pre>');
var_dump($attachment_02);
echo('</pre>');
?>	
			
			<?php
			if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
				the_excerpt();

			} else {
				the_content( __( 'Continue reading', 'twentytwenty' ) );
			}
			?>
		</div><!-- .entry-content -->
		
	</div><!-- .post-inner -->

	<div class="section-inner">
		<?php
		wp_link_pages(
			array(
				'before'      => '<nav class="post-nav-links bg-light-background" aria-label="' . esc_attr__( 'Page', 'twentytwenty' ) . '"><span class="label">' . __( 'Pages:', 'twentytwenty' ) . '</span>',
				'after'       => '</nav>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			)
		);

		// 編集
		edit_post_link();

		// Single bottom post meta.
		twentytwenty_the_post_meta( get_the_ID(), 'single-bottom' );

		if ( is_single() ) {

			get_template_part( 'template-parts/entry-author-bio' );

		}
		?>

	</div><!-- .section-inner -->

	<div>
	<?php
	?>
	</div>

	<?php

	// 全ページに表示 : カテゴリメニュー
	get_template_part( 'template-parts/info-course-end' );

	if ( is_single() ) {

		get_template_part( 'template-parts/navigation' );

	}

	/**
	 *  Output comments wrapper if it's a post, or if comments are open,
	 * or if there's a comment number – and check for password.
	 * */
	if ( ( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
		?>

		<div class="comments-wrapper section-inner">

			<?php comments_template(); ?>

		</div><!-- .comments-wrapper -->

		<?php
	}
	?>

</article><!-- .post -->