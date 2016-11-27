<?php

/**
 * Small (Quarter of a strap) link widget.
 */
class Huntingslow_Link_Sm extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Huntingslow_Link_Sm', // Base ID
			__('Quarter Strap Link', 'text_domain'), // Name
			array( 'description' => 'Text link that occupies a quarter of a strap. E.g. Callout or tip off box.') // Args
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
	  $link_title = $instance['link_title'];
    $link_URL = $instance['link_URL'];
    $link_text = $instance['link_text'];
    $link_color = $instance['link_color'];

		echo $args['before_widget']; ?>
    <div class="link-sm">
			<a href="<?php echo esc_url( $link_URL ); ?>">
				<h3 class="link-sm__title"><?php echo esc_html( $link_title ); ?></h3>
    		<p class="link-sm__text"><?php echo esc_html( $link_text ); ?></p>
			</a>
		</div>
    <?php echo $args['after_widget'];
	}
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	function form( $instance ) {
		// Check values
		if( $instance ) {
      $link_title = esc_attr( $instance['link_title'] );
      $link_URL = esc_attr( $instance['link_URL'] );
      $link_text = esc_attr( $instance['link_text']);
      $link_color = esc_attr( $instance['link_color']);
		} else {
			$link_title = '';
      $link_URL = '';
      $link_text = '';
      $link_color = '';
		}  ?>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'link_title' ) ); ?>"><?php _e( 'Title:', 'wp_widget_plugin' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'link_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link_title' ) ); ?>" type="text" value="<?php echo esc_attr( $link_title ); ?>" />
		</p>

    <p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'link_URL' ) ); ?>"><?php _e( 'URL:', 'wp_widget_plugin' ); ?></label>
    <input id="<?php echo esc_attr( $this->get_field_id( 'link_URL' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link_URL' ) ); ?>" type="text" value="<?php echo esc_attr( $link_URL ); ?>" />
    </p>

    <p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'link_text' ) ); ?>"><?php _e( 'Text:', 'wp_widget_plugin' ); ?></label>
    <input id="<?php echo esc_attr( $this->get_field_id( 'link_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link_text' ) ); ?>" type="text" value="<?php echo esc_attr( $link_text ); ?>" />
    </p>

    <p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'link_color' ) ); ?>"><?php _e( 'Background Color: (Use a hex value.)', 'wp_widget_plugin' ); ?></label>
    <input id="<?php echo esc_attr( $this->get_field_id( 'link_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link_color' ) ); ?>" type="text" value="<?php echo esc_attr( $link_color ); ?>" />
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
			 $instance['link_title'] = strip_tags($new_instance['link_title']);
       $instance['link_URL'] = strip_tags($new_instance['link_URL']);
 			 $instance['link_text'] = strip_tags($new_instance['link_text']);
 			 $instance['link_color'] = strip_tags($new_instance['link_color']);
      return $instance;
 }
}
