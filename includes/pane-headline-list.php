<?php

/**
 * Adds Headline List widget.
 */
class Huntingslow_Pane_Headline_List extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Huntingslow_Pane_Headline_List', // Base ID
			__('Headline List', 'text_domain'), // Name
			array( 'description' => 'Display narrow verticle column of headlines, usually news. ') // Args
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

		$column_heading = $instance['column_heading'];
		$number_of_headlines = $instance['number_of_headlines'];
		$display_topic_tags = $instance['display_topic_tags'];

		$headlines = new WP_Query( array(
			'category_name' => 'news',
			'posts_per_page' => $number_of_headlines
		) );
    echo $args['before_widget'];

		echo '<h3 class="headline-list__title">' . $column_heading . '</h3>';
		// The Loop
		if ( $headlines->have_posts() ) {
			while ( $headlines->have_posts() ) {
				$headlines->the_post();
				if ( $display_topic_tags == '1' ) {
					$primary_tag_id = get_post_meta( get_the_id(), 'primary_tag', true );
					$primary_tag_array = get_term_by( 'id', $primary_tag_id, 'post_tag', ARRAY_A);

					echo '<p class="headline-list__primary-tag"><a>' . ucwords($primary_tag_array['name']) . '</a></p>';
				}
				echo '<p class="headline-list__headline"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></p>';
			}
			/* Restore original Post Data */
			wp_reset_postdata();
		} else {
			// no posts found
		}

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
		// Check values
		if( $instance ) {
			$column_heading = esc_attr( $instance['column_heading'] );
			$number_of_headlines     = esc_attr( $instance['number_of_headlines'] );
			$display_topic_tags = esc_attr( $instance['display_topic_tags'] ); // Added this
		} else {
			$column_heading    = '';
			$number_of_headlines     = '';
			$display_topic_tags = ''; // Added this
		}  ?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'column_heading' ) ); ?>"><?php _e( 'Column Heading:', 'wp_widget_plugin' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'column_heading' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'column_heading' ) ); ?>" type="text" value="<?php echo esc_attr( $column_heading ); ?>" />
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id('number_of_headlines') ); ?>"><?php _e( 'Number of headlines to list:', 'wp_widget_plugin' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id('number_of_headlines') ); ?>" name="<?php echo esc_attr( $this->get_field_name('number_of_headlines') ); ?>" type="text" value="<?php echo $number_of_headlines; ?>" />
		</p>
		<p>
		<input id="<?php echo esc_attr( $this->get_field_id( 'display_topic_tags' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display_topic_tags' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $display_topic_tags ); ?> />
		<label for="<?php echo esc_attr( $this->get_field_id( 'display_topic_tags' ) ); ?>"><?php _e( 'Display topic tags', 'wp_widget_plugin' ); ?></label>
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
       $instance['column_heading'] = strip_tags($new_instance['column_heading']);
       $instance['number_of_headlines'] = strip_tags($new_instance['number_of_headlines']);
       $instance['display_topic_tags'] = strip_tags($new_instance['display_topic_tags']);
      return $instance;
 }
} // class Widget_Popular
