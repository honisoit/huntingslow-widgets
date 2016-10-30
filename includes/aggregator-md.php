
<?php

/**
* Medium (half strap) category or tag widget.
*/
class Huntingslow_Pane_Aggregator_Md extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Huntingslow_Pane_Aggregator_Md', // Base ID
			__('Aggregator (Half Strap)', 'text_domain'), // Name
			array( 'description' => 'Collates posts from a particular category or tag.') // Args
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
  $title = $instance['title'];
  $query_type = $instance['query_type'];
  $query_term = $instance['query_term'];
  $override_feature_URL = $instance['override_feature_URL'];

  // do a little business thinking
  $feature_is_overriden = '0';
  $override_feature_ID = '6';

  // spit that initial markup
	echo $args['before_widget'];
  echo '<div class="aggregator-md"><h1 class="aggregator-md__title">'. $title . '</h1>';
	echo '<div class="flex-container">';
	echo '<div class="aggregator-md__featured">';

  // do the feature query
  $override_feature_args = array( 'p' => $override_feature_ID );
  $category__feature_args = array( 'posts_per_page' => 1, 'category_name' => $query_term );
  $tag_feature_args = array( 'posts_per_page' => 1, 'tag' => $query_term );

  if ( $feature_is_overriden == '1' ) {
    $feature_post = new WP_Query( $override_feature_args );
  } elseif ( $query_type = 'category') {
    $feature_post = new WP_Query( $category__feature_args );
  } else {
    $feature_post = new WP_Query( $tag_feature_args );
  };

  if ( $feature_post->have_posts() ) {
	  while ( $feature_post->have_posts() ) {
		  $feature_post->the_post();
      // get the thumbnail
			echo '<figure class="aggregator-md__featured-image"><a href="';
			echo get_the_permalink();
			echo '">';
			the_post_thumbnail();
			echo '</a></figure>';
			echo '<h4 class="aggregator-md__featured-headline"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h4>';
      echo '<p class="aggregator-md__featured-standfirst">' . get_post_meta( get_the_id(), 'standfirst', true) . '</p>';
			echo '<p class="single-lg__byline aggregator-md__featured-byline">By ';
			if ( function_exists( 'coauthors_posts_links' ) ) {
				coauthors_posts_links();
			} else {
				the_author_posts_link();
			}
			echo '</p>';
		}
	  /* Restore original Post Data */
	  wp_reset_postdata();
  } else {
	  echo 'Something went wrong with the query.';
  }

  echo '</div><div class="aggregator-md__list">';

  // now for the list query
  $override_category_list_args = array(
    'posts_per_page' => 5,
    'category_name' => $query_term,
    'post__not_in' => array( $override_feature_ID )
  );
  $override_tag_list_args = array(
    'posts_per_page' => 5,
    'tag' => $query_term,
    'post__not_in' => array( $override_feature_ID )
  );
  $category_list_args = array(
    'posts_per_page' => 5,
    'offset' => 1,
    'category_name' => $query_term
  );
  $tag_list_args = array(
    'posts_per_page' => 5,
    'offset' => 1,
    'tag' => $query_term
  );

  if ( $feature_is_overriden == '1' ) {
    if ( $query_type == 'category' ) {
      $list_posts = new WP_Query( $override_category_list_args );
    } else {
      $list_posts = new WP_Query( $override_tag_list_args );
    }
  } elseif ( $query_type == 'category' ) {
    $list_posts = new WP_Query( $category_list_args );
  } else {
    $list_posts = new WP_Query( $tag_list_args );
  }

  if ( $list_posts->have_posts() ) {
    while ( $list_posts->have_posts() ) {
      $list_posts->the_post();
      // get the thumbnail
			$primary_tag_id = get_post_meta( get_the_id(), 'primary_tag', true );
			$primary_tag_array = get_term_by( 'id', $primary_tag_id, 'post_tag', ARRAY_A);
			$primary_tag = ucwords($primary_tag_array['name']);
			echo '<p class="aggregator-md__primary-tag"><a href="">' . $primary_tag . '</a></p>';
      echo '<p class="aggregator-md__headline"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></p>';
    }
    /* Restore original Post Data */
    wp_reset_postdata();
  } else {
    echo 'You made an error with the query. Try fixing the name of the category or tag you are trying to show';
  }
  echo '</div></div></div>';
  echo $args['after_widget']; ?>

	<?php }
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
      $title = esc_attr( $instance['title'] );
      $query_type = esc_attr( $instance['query_type'] );
      $query_term = esc_attr( $instance['query_term'] );
      $override_feature_URL = esc_attr( $instance['override_feature_URL'] );
		} else {
      $title = '';
      $query_type = '';
      $query_term = '';
      $override_feature_URL = '';
		} ?>

    <p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'wp_widget_plugin' ); ?></label>
    <input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'query_type' ) ); ?>"><?php _e( 'Show a:', 'wp_widget_plugin' ); ?></label>
		<select id="<?php echo esc_attr( $this->get_field_id( 'query_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'query_type' ) ); ?>">
			<option value="category"><?php _e( 'Category', 'wp_widget_plugin' ); ?></option>
			<option value="tag"><?php _e( 'Tag', 'wp_widget_plugin' ); ?></option>
		</select>

    <p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'query_term' ) ); ?>"><?php _e( 'Name of category or tag (No caps):', 'wp_widget_plugin' ); ?></label>
    <input id="<?php echo esc_attr( $this->get_field_id( 'query_term' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'query_term' ) ); ?>" type="text" value="<?php echo esc_attr( $query_term ); ?>" />
    </p>

		<hr>

		<p>Optional:</p>
    <p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'override_feature_URL' ) ); ?>"><?php _e( 'Feature override URL', 'wp_widget_plugin' ); ?></label>
    <input id="<?php echo esc_attr( $this->get_field_id( 'override_feature_URL' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'override_feature_URL' ) ); ?>" type="text" value="<?php echo esc_attr( $override_feature_URL ); ?>" />
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
      $instance['title'] = strip_tags($new_instance['title']);
      $instance['query_term'] = strip_tags($new_instance['query_term']);
			$instance['query_type'] = strip_tags($new_instance['query_type']);
			$instance['override_feature_URL'] = strip_tags($new_instance['override_feature_URL']);

     return $instance;
}
}
