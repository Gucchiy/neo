<?php
/**
 * Loop Template Part of Katawara
 *
 * @package katawara
 */
global $katawara_theme_options;
?>
<div class="entry-meta p-entry_meta">
	<?php if ( 'product' !== get_post_type() ) { ?>
		<div class="p-entry_meta_times">
		<span class="published p-entry_meta_items p-entry_meta_posttimes"><?php the_date(); ?></span>
		<?php
		// Post update.
		$meta_hidden_update = ( ! empty( $katawara_theme_options['postUpdate_hidden'] ) ) ? ' p-entry_meta_hidden' : '';
		?>
		<span class="p-entry_meta_items p-entry_meta_updated<?php echo esc_attr( $meta_hidden_update ); ?>"><span class="updated"><?php the_modified_date( '' ); ?></span></span>

		<?php
		// Post author.
		// For post type where author does not exist.
		$author = get_the_author();
		if ( $author ) {
			$meta_hidden_author = ( ! empty( $katawara_theme_options['postAuthor_hidden'] ) ) ? ' p-entry_meta_hidden' : '';
			?>
			<span class="vcard author p-entry_meta_items p-entry_meta_items_author<?php echo esc_attr( $meta_hidden_author ); ?>"><span class="fn"><?php echo esc_html( $author ); ?></span></span></div>
			<?php
		} // if author.
	} // if not product.
	$taxonomies = get_the_taxonomies();
	if ( $taxonomies ) {
		// get $meta_taxonomy name.
		// $meta_taxonomy   = key( $taxonomies );.
		// To avoid WooCommerce default tax.
		foreach ( $taxonomies as $key => $value ) {
			if ( 'product_type' !== $key ) {
				$meta_taxonomy = $key;
				break;
			}
		}
		$terms = get_the_terms( get_the_ID(), $meta_taxonomy );

		foreach ( $terms as $meta_term ) {
			$term_url   = get_term_link( $meta_term->term_id, $meta_taxonomy );
			$term_name  = $meta_term->name;
			$term_color = '';
			// 複数のカテゴリーが出る為、見た目がよくないのでbackground-color指定はコメントアウトとechoから$term_color削除
			// if ( class_exists( 'Vk_term_color' ) ) {
			// 	$term_color = Vk_term_color::get_term_color( $meta_term->term_id );
			// 	$term_color = ( $term_color ) ? ' style="background-color:' . $term_color . ';border:none;"' : '';
			// }
			echo '<span class="entry-meta_items entry-meta_items_term"><a href="' . esc_url( $term_url ) . '" class="p-entry_meta_items_term_button">' . esc_html( $term_name ) . '</a></span>';
		}
	}
	?>
</div>
