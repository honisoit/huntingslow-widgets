<?php

/**
 * Small (quarter width) single article display widget.
 */
class Huntingslow_Single_Sm extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Huntingslow_Single_Sm', // Base ID
			__('Article (Quarter Strap)', 'text_domain'), // Name
			array( 'description' => 'Quarter width single article.') // Args
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
		$article_URL = $instance['article_URL'];
		$display_image = $instance['display_image'];
		$display_byline = $instance['display_byline'];
		$display_primary_tag = $instance['display_primary_tag'];

		// TODO: Move this logic to the save function so it is only run once
		$article_ID = url_to_postid( $article_URL );

		// Run the query
		$article = new WP_Query( array(
			'p' => $article_ID
		) );

		// Spit the markup
		echo $args['before_widget'];

		if ( $article->have_posts() ) {
			while ( $article->have_posts() ) {
				$article->the_post(); ?>

				<div class="single-sm">
					<?php if ($display_image == '1') : ?>
						<figure class="single-sm__image">
							<a href="<?php echo get_the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
						</figure>
					<?php endif; ?>

					<div class="single-sm__text">
					<?php if ( $display_primary_tag == '1' ) : ?>
						<p class="single-sm__primary-tag"><?php echo get_the_primary_tag_link(); ?></p>
					<?php endif; ?>
					<h4 class="single-sm__headline">
						<a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
					</h4>
					<?php if ( $display_byline == '1' ) : ?>
						<p class="single-sm__byline">By <?php get_the_byline_link(); ?></p>
					<?php endif; ?>
					</div> 
				</div>

				<?php
			}
			/* Restore original Post Data */
			wp_reset_postdata();
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
		// Fill the form with saved data if it exists
		if( $instance ) {
			$article_URL = esc_attr( $instance['article_URL'] );
			$display_image = esc_attr( $instance['display_image']);
			$display_byline = esc_attr( $instance['display_byline'] );
			$display_primary_tag = esc_attr( $instance['display_primary_tag'] );
		} else {
			$article_URL = '';
			$display_image = '';
			$display_byline = '';
			$display_primary_tag = '';
		}  ?>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'article_URL' ) ); ?>"><?php _e( 'Article URL: ', 'wp_widget_plugin' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'article_URL' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'article_URL' ) ); ?>" type="text" value="<?php echo esc_attr( $article_URL ); ?>" />
		</p>

		<hr>

		<p>Display:</p>
		<p>
		<input id="<?php echo esc_attr( $this->get_field_id( 'display_image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display_image' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $display_image ); ?> />
		<label for="<?php echo esc_attr( $this->get_field_id( 'display_image' ) ); ?>"><?php _e( 'Image', 'wp_widget_plugin' ); ?></label>
		</p>

		<p>
		<input id="<?php echo esc_attr( $this->get_field_id( 'display_byline' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display_byline' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $display_byline ); ?> />
		<label for="<?php echo esc_attr( $this->get_field_id( 'display_byline' ) ); ?>"><?php _e( 'Byline', 'wp_widget_plugin' ); ?></label>
		</p>

		<p>
		<input id="<?php echo esc_attr( $this->get_field_id( 'display_primary_tag' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display_primary_tag' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $display_primary_tag ); ?> />
		<label for="<?php echo esc_attr( $this->get_field_id( 'display_primary_tag' ) ); ?>"><?php _e( 'Primary tag', 'wp_widget_plugin' ); ?></label>
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
			 $instance['article_URL'] = strip_tags($new_instance['article_URL']);
			 $instance['display_image'] = strip_tags($new_instance['display_image']);
			 $instance['display_byline'] = strip_tags($new_instance['display_byline']);
			 $instance['display_primary_tag'] = strip_tags($new_instance['display_primary_tag']);

      return $instance;
 }
}
