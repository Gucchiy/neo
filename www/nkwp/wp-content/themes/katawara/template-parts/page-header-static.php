<div class="section p-page-header" style="background-image: url(<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>)">
	<div class="l-container">
		<div class="p-page-header_title">
			<h1 class="p-page-header_posttitle"><?php the_title(); ?></h1>
			<div class="<?php katawara_the_class_name( 'p-entry_header' ); ?>">
				<?php get_template_part( 'template-parts/post/meta' ); ?>									
			</div>
		</div>
	</div>
</div>