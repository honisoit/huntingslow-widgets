<?php

/**
 * Adds Widget_Related widget.
 */
class Huntingslow_Aggregator_Related extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Huntingslow_Aggregator_Related', // Base ID
			__('Related (Full Strap)', 'text_domain'), // Name
			array( 'description' => 'Displays links to 3 related posts. For article page use only.') // Args
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

		// Populate the variables from the saved instance
		$title = $instance['title'];

		// Start the widget content
		echo $args['before_widget'];
		echo '<div class="aggregator-related"><h3 class="related__title">';
		echo $title;
		echo '</h3>';

		// If jetpack exists, query the related posts and spit the markup
		if ( class_exists( 'Jetpack_RelatedPosts' ) && method_exists( 'Jetpack_RelatedPosts', 'init_raw' ) ) {
        $related = Jetpack_RelatedPosts::init_raw()
            ->set_query_name( 'huntingslow_related' ) // Optional, name can be anything
            ->get_for_post_id(
                get_the_ID(),
                array( 'size' => 3 )
            );

        if ( $related ) {
            foreach ( $related as $result ) {
                // Get the related post IDs
                $related_post = get_post( $result[ 'id' ] );
                // From there you can do just about anything. Here we get the post titles
                $posts_titles[] = $related_post->post_title;
            }
        }
    } else {
			echo '<p>The related post functionality of Jetpack is either disabled or unavailable. Fix that.</p>';
		}

		echo '</div>';
		echo $args['after_widget'];

    ?>
    <div class="related">

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

	}
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		// Fill the form with saved data if it exists
		if( $instance ) {
			$title = esc_attr( $instance['title'] );
		} else {
			$title = '';
		}  ?>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Article URL: ', 'wp_widget_plugin' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
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
		$instance = $old_instance;
		// Fields
		$instance['title'] = strip_tags($new_instance['title']);

	 return $instance;
	}
} // class Widget_Popular
