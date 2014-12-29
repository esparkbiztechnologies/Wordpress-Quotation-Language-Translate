<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

add_action( 'widgets_init', 'lt_order_widget' );

/**
 * Register the Newsletter Widget
 */
function lt_order_widget() {
	register_widget( 'Lt_Order' );
}

class Lt_Order extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Lt_Order() {
	
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'lt-order', 'description' => __( 'A Language Translate Order widget, which lets used for display order.', 'langtrans' ) );

		/* Create the widget. */
		$this->WP_Widget( 'lt-order', __( 'Language Translate Order', 'langtrans' ), $widget_ops );
	
	}
	
	/**
	 * Outputs the content of the widget
	 */
	function widget( $args, $instance ) {
	
            extract( $args );

            echo $before_widget;
	
            $title 	= apply_filters( 'widget_title', $instance['title'] );

            //Order widget content
            do_action( 'lt_order_widget_content', $title );
            
            echo $after_widget;
        }
	
	/**
	 * Updates the widget control options for the particular instance of the widget
	 */
	function update( $new_instance, $old_instance ) {
	
            $instance = $old_instance;
		
            /* Set the instance to the new instance. */
            $instance = $new_instance;

            /* Input fields */
            $instance['title'] 	= strip_tags( $new_instance['title'] );

        return $instance;
		
    }
	
	/*
	 * Displays the widget form in the admin panel
	 */
	function form( $instance ) {

            $defaults = array( 'title' => __( 'Your Quatation', 'langtrans' ) );

            $instance = wp_parse_args( (array) $instance, $defaults );

            ?>

            <p>
                    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'langtrans'); ?></label> 
                    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
            </p>

            <?php
	}
}