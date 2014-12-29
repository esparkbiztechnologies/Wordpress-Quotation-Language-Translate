<?php

/**
 * Custom Post Types & Taxonomies File
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Display order page
 * 
 * Handles to upload file and count word
 */
function lt_order( $content ){
    
    ob_start();
    
    //do action to show order content
    do_action( 'lt_order_content' );
    
    return ob_get_clean();
}

/**
 * Display language page
 * 
 * Handles to set conversion language
 */
function lt_language( $content ){
    
    ob_start();
    
    //do action to show language content
    do_action( 'lt_language_content' );
    
    return ob_get_clean();
}

/**
 * Display Optional page
 * 
 * Handles to set conversion optional
 */
function lt_optional( $content ){
    
    ob_start();
    
    //do action to show optional content
    do_action( 'lt_optional_content' );
    
    return ob_get_clean();
}

/**
 * Display Thank You page
 * 
 * Handles to set conversion thankyou
 */
function lt_thankyou( $content ){
    
    ob_start();
    
    //do action to show thankyou content
    do_action( 'lt_thankyou_content' );
    
    return ob_get_clean();
}

//add shortcode for diplay file upload order page
add_shortcode( 'lt_order', 'lt_order' );

//add shortcode for diplay language page
add_shortcode( 'lt_language', 'lt_language' );

//add shortcode for diplay optional page
add_shortcode( 'lt_optional', 'lt_optional' );

//add shortcode for diplay thankyou page
add_shortcode( 'lt_thankyou', 'lt_thankyou' );

?>