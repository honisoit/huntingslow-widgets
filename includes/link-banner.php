<?php

/**
 * Banner link widget.
 */
class Huntingslow_Link_Banner extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Huntingslow_Link_Banner', // Base ID
			__('Link (Banner)', 'text_domain'), // Name
			array( 'description' => 'Full width, text only link to an article. Ideal for breaking news.') // Args
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

		$banner_text = $instance['banner_text'];
    $link_URL = $instance['link_URL'];
		$is_breaking_news = $instance['is_breaking_news'];

		$headlines = new WP_Query( array(
			'category_name' => 'news',
			'posts_per_page' => 2
		) );
    echo $args['before_widget'];
    echo '<div class="link-banner';
    if ( $is_breaking_news == '1' ) {
      echo ' link-banner--breaking';
    }
    echo '"><h4 class="link-banner__text"><a href="'. $link_URL .'">'. $banner_text .'</a></h4></div>';

    wp_reset_postdata();

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
			$banner_text = esc_attr( $instance['banner_text'] );
      $link_URL = esc_attr( $instance['link_URL'] );
			$is_breaking_news = esc_attr( $instance['is_breaking_news'] ); // Added this
		} else {
			$banner_text    = '';
      $link_URL = '';
			$is_breaking_news = '';
		}  ?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'banner_text' ) ); ?>"><?php _e( 'Banner text:', 'wp_widget_plugin' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'banner_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'banner_text' ) ); ?>" type="text" value="<?php echo esc_attr( $banner_text ); ?>" />
		</p>
    <p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'link_URL' ) ); ?>"><?php _e( 'Link URL:', 'wp_widget_plugin' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'link_URL' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link_URL' ) ); ?>" type="text" value="<?php echo esc_attr( $link_URL ); ?>" />
		</p>
		<p>
		<input id="<?php echo esc_attr( $this->get_field_id( 'is_breaking_news' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'is_breaking_news' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $is_breaking_news ); ?> />
		<label for="<?php echo esc_attr( $this->get_field_id( 'is_breaking_news' ) ); ?>"><?php _e( 'Is breaking news. (Makes banner red.)', 'wp_widget_plugin' ); ?></label>
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
       $instance['banner_text'] = strip_tags($new_instance['banner_text']);
       $instance['link_URL'] = strip_tags($new_instance['link_URL']);
       $instance['is_breaking_news'] = strip_tags($new_instance['is_breaking_news']);
      return $instance;
 }
}
