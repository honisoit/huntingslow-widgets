<?php

/**
 * Adds Widget_Related widget.
 */
class Widget_Related extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Widget_Related', // Base ID
			__('Related posts', 'text_domain'), // Name
			array( 'description' => 'Displays links to 3 related posts') // Args
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
	public function widget( $args, $instance ) {

    echo $args['before_widget'];
    ?>
    <div class="related">
			<h3 class="related__title">Related</h3>
			<div class="related__item-row">
	      <div class="related__item">
					<p class="related__category">News</p>
					<h4 class="related__headline">Further cuts to SCA provoke protest</h1>
					<p class="related__date">April 15</p>
				</div>
				<div class="related__item">
					<p class="related__category">Feature</p>
					<h4 class="related__headline">How an art school was eaten</h1>
					<p class="related__date">April 15</p>
				</div>
				<div class="related__item">
					<p class="related__category">News</p>
					<h4 class="related__headline">Twenty bizarre bugs of the hinterlands</h1>
					<p class="related__date">April 15</p>
				</div>
			</div>
    </div>
    <?php
		echo $args['after_widget'];
	}
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'text_domain' );
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
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
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} // class Widget_Popular
