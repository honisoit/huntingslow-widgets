<?php

/**
 * Adds top 5 list widget.
 */
class Huntingslow_Popular extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Huntingslow_Popular', // Base ID
			__('Top 5 list', 'text_domain'), // Name
			array( 'description' => 'Display top 5 posts from around the site') // Args
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
    <div class="pane-popular">
      <h3 class="pane-popular__title">Most Popular</h3>
      <ul class="pane-popular__list">
        <li class="pane-popular__list-item">
          <a href="#">Let SCA Stay movement stages performance art protest outside Archibald Prize ceremony</a>
        </li>
        <li class="pane-popular__list-item">
					<a href="#">Andrew is bad</a>
        </li>
        <li class="pane-popular__list-item">
          <a href="#">300 students protest SCA closure at USyd Senate meeting</a>
        </li>
        <li class="pane-popular__list-item">
          <a href="#">Yes is bad</a>
        </li>
        <li class="pane-popular__list-item">
          <a href="#">Everything is bad</a>
        </li>
      </ul>
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
