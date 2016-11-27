<?php

/**
 * Small (quarter width) single article display widget.
 */
class Huntingslow_Frame_Md extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Huntingslow_Frame_Md', // Base ID
			__('Frame (Half Strap)', 'text_domain'), // Name
			array( 'description' => 'Half-width frame.') // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	function widget( $args, $instance ) {

		// Populate the variables from the saved instance
		$shortcode = $instance['shortcode'];

		// Spit the markup
		echo $args['before_widget'];

		echo '<div class="frame-lg">';
		echo do_shortcode( $shortcode );
		echo '</div>';

		echo $args['after_widget'];
	}
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	function form( $instance ) {
		// Fill the form with saved data if it exists
		if( $instance ) {
			$shortcode = esc_attr( $instance['shortcode'] );
		} else {
			$shortcode = '';
		}  ?>

		<p>Use the full PYM.js shortcode you would use to embed the content in an article. Include square brackets.</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'shortcode' ) ); ?>"><?php _e( 'Shortcode: ', 'wp_widget_plugin' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'shortcode' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'shortcode' ) ); ?>" type="text" value="<?php echo esc_attr( $shortcode ); ?>" />
		</p>

	<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	 function update($new_instance, $old_instance) {
       $instance = $old_instance;
       // Fields
			 $instance['shortcode'] = strip_tags($new_instance['shortcode']);

      return $instance;
 }
}