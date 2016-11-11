<?php

/**
 * Large (full width) single article display widget.
 */
class Huntingslow_Pane_Single_Lg extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Huntingslow_Pane_Single_Lg', // Base ID
			__('Article (Full Strap)', 'text_domain'), // Name
			array( 'description' => 'Full width single article.') // Args
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
		$display_standfirst = $instance['display_standfirst'];
		$display_excerpt = $instance['display_excerpt'];
		$related_one_URL = $instance['related_one_URL'];
		$related_two_URL = $instance['related_two_URL'];

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

				<div class="single-lg">
					<div class="flex-container">
						<?php if ($display_image == '1') {
							echo '<figure class="single-lg__image"><a href="';
							echo get_the_permalink();
							echo '">';
							the_post_thumbnail();
							echo '</a></figure>';
						} ?>
						<div class="single-lg__copy">
							<?php if ($display_primary_tag == '1') {
								$primary_tag_id = get_post_meta( get_the_id(), 'primary_tag', true );
						    $primary_tag_array = get_term_by( 'id', $primary_tag_id, 'post_tag', ARRAY_A);
						    $primary_tag = ucwords($primary_tag_array['name']);
						    // We need to get the tag URL in a way that doesn't mess up when there are
						    // special characters in the primary tag. Otherwise prevent their use.
						    if ($primary_tag) {
						      echo '<p class="single-lg__primary-tag"><a href="/tag/' . $primary_tag .'">' . $primary_tag . '</a></p>';
						    }
							} ?>
							<h1 class="single-lg__headline">
								<?php echo '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>'; ?>
							</h1>
							<p class="single-lg__standfirst">
								<?php echo $standfirst = ($display_standfirst == '1' ? get_post_meta( get_the_id(), 'standfirst', true) : ''); ?>
							</p>
							
							<?php if ( $display_excerpt == '1' ) {
								echo '<div class="single-lg__excerpt">';
								the_excerpt();
								echo '</div>';
							}

							if ( $display_byline == '1' ) {
								echo '<p class="single-lg__byline">By ';
								if ( function_exists( 'coauthors_posts_links' ) ) {
									coauthors_posts_links();
								} else {
									the_author_posts_link();
								}
								echo '</p>';
							}

							if ( ! $related_one_URL == '') {
								$related_one_ID = url_to_postid( $related_one_URL );
								$related_one_post = get_post( $related_one_ID );
								echo '<span class="single-lg__related-one">';
								echo $related_one_post->post_title;
								echo '</span>';
							}

							if ( ! $related_two_URL == '') {
								$related_two_ID = url_to_postid( $related_two_URL );
								$related_two_post = get_post( $related_two_ID );
								echo '<span class="single-lg__related-two">';
								echo $related_two_post->post_title;
								echo '</span>';
							} ?>
						</div>
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
			$display_standfirst = esc_attr( $instance['display_standfirst'] );
			$display_excerpt = esc_attr( $instance['display_excerpt'] );
			$related_one_URL = esc_attr( $instance['related_one_URL']);
			$related_two_URL = esc_attr( $instance['related_two_URL']);
		} else {
			$article_URL = '';
			$display_image = '';
			$display_byline = '';
			$display_primary_tag = '';
			$display_standfirst = '';
			$display_excerpt = '';
			$related_one_URL = '';
			$related_two_URL = '';
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

		<p>
		<input id="<?php echo esc_attr( $this->get_field_id( 'display_standfirst' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display_standfirst' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $display_standfirst ); ?> />
		<label for="<?php echo esc_attr( $this->get_field_id( 'display_standfirst' ) ); ?>"><?php _e( 'Standfirst', 'wp_widget_plugin' ); ?></label>
		</p>

		<p>
		<input id="<?php echo esc_attr( $this->get_field_id( 'display_excerpt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display_excerpt' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $display_excerpt ); ?> />
		<label for="<?php echo esc_attr( $this->get_field_id( 'display_excerpt' ) ); ?>"><?php _e( 'Excerpt', 'wp_widget_plugin' ); ?></label>
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'related_one_URL' ) ); ?>"><?php _e( 'Related article one URL: ', 'wp_widget_plugin' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'related_one_URL' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'related_one_URL' ) ); ?>" type="text" value="<?php echo esc_attr( $related_one_URL ); ?>" />
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'related_two_URL' ) ); ?>"><?php _e( 'Related article two URL: ', 'wp_widget_plugin' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'related_two_URL' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'related_two_URL' ) ); ?>" type="text" value="<?php echo esc_attr( $related_two_URL ); ?>" />
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
			 $instance['display_standfirst'] = strip_tags($new_instance['display_standfirst']);
			 $instance['display_excerpt'] = strip_tags($new_instance['display_excerpt']);
			 $instance['related_one_URL'] = strip_tags($new_instance['related_one_URL']);
			 $instance['related_two_URL'] = strip_tags($new_instance['related_two_URL']);

      return $instance;
 }
}
