<?php

/**
 * Adds Widget_Single_Article widget.
 */
class Widget_Single_Article extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Widget_Single_Article', // Base ID
			__('Single Article', 'text_domain'), // Name
			array( 'description' => 'Features a single article') // Args
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
    <div class="single-article">
			<div class="single-article__flex">
				<div class="single-article__imagebox">
					<img class="single-article__image" src="http://honisoit.com/wp-content/uploads/2016/05/honour_society_splash-620x400.png"></img>
				</div>
				<div class="single-article__textbox">
					<h4 class="single-article__headline">The Honour Society</h4>
					<p class="single-article__byline">by Thomas Joyner</p>
					<p class="single-article__excerpt">
						In cramped offices in the inner Sydney suburb of Ultimo, the Golden Key International Honour Society’s headquarters for the Asia-Pacific feel more like a family tax accountant or a business startup. Its rooms are on the fourth floor of a shared block on Jones Street, and overlook a Chinese supermarket on one side and a self-storage warehouse on the other. There’s barely enough space for seating in the reception area, and a large collapsible banner emblazoned with the company’s logo leans haphazardly against the front counter.
					</p>
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
