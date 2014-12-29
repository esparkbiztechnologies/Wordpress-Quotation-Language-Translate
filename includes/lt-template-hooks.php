<?php
/**
 * Template Hooks
 * 
 * Handles to add all hooks of template
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

//add action to display order page content
add_action( 'lt_order_content', 'lt_order_content' );

//add action to display language page content
add_action( 'lt_language_content', 'lt_language_content' );

//add action to display optional page content
add_action( 'lt_optional_content', 'lt_optional_content' );

//add action to display thankyou page content
add_action( 'lt_thankyou_content', 'lt_thankyou_content' );

//add action for display widget content
add_action( 'lt_order_widget_content', 'lt_order_widget_content' );

?>