<?php
/**
 * Custom Text Control
 *
 * @package Katawara
 */

if ( ! class_exists( 'Custom_Text_Control' ) ) {
	/**
	 * Custom Text Control
	 */
	class Custom_Text_Control extends WP_Customize_Control {
		/**
		 * Custom Text
		 *
		 * @var string
		 */
		public $type = 'customtext';

		/**
		 * Description
		 *
		 * @var string
		 */
		public $description = '';

		/**
		 * Input Before
		 *
		 * @var string
		 */
		public $input_before = '';

		/**
		 * Input After
		 *
		 * @var string
		 */
		public $input_after = '';

		/**
		 * Rendering Contents
		 */
		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php $style = ( $this->input_before || $this->input_after ) ? ' style="width:50%"' : ''; ?>
				<div>
					<?php echo wp_kses_post( $this->input_before ); ?>
					<input type="text" value="<?php echo esc_attr( $this->value() ); ?>"<?php echo wp_kses_post( $style ); ?> <?php wp_kses_post( $this->link() ); ?> />
					<?php echo wp_kses_post( $this->input_after ); ?>
				</div>
				<div><?php echo wp_kses_post( $this->description ); ?></div>
			</label>
			<?php
		}
	}
}
