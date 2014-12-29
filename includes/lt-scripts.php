<?php

/**
 * Scripts File
 * Handles to admin functionality & other functions
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Load Admin styles & scripts
 */
function lt_admin_scripts(){
    
     // Load our admin stylesheet.
     wp_enqueue_style( 'lt-admin-style', LT_URL . '/css/admin-style.css' );

     // Load jQuery
     wp_enqueue_script( 'jquery' );

     // Load our admin script.
     wp_enqueue_script( 'lt-admin-script', LT_URL . '/js/admin-script.js' );
}

//add action to load scripts and styles for the back end
add_action( 'admin_enqueue_scripts', 'lt_admin_scripts' );

/**
 * Load Public styles & scripts
 */
function lt_public_scripts(){

     global $lt_options;
    
     $order_page_id     = !empty( $lt_options['order_page'] ) ? $lt_options['order_page'] : '' ;
     $language_page_id  = !empty( $lt_options['order_language_page'] ) ? $lt_options['order_language_page'] : '' ;
     $optional_page_id  = !empty( $lt_options['order_optional_page'] ) ? $lt_options['order_optional_page'] : '' ;
     $thankyou_page_id  = !empty( $lt_options['order_thankyou_page'] ) ? $lt_options['order_thankyou_page'] : '' ;

     // Load our public stylesheet.
     wp_enqueue_style( 'lt-public-style', LT_URL . '/css/public-style.css' );

     // Load our stylesheet.
     wp_enqueue_style( 'lt-style', LT_URL . '/css/style.css' );

     // Load our font awesome stylesheet.
     wp_enqueue_style( 'lt-font-awesome', LT_URL . '/css/font-awesome.css' );

     // Load jQuery
     wp_enqueue_script( 'jquery' );

     // Load our jquery form script.
     wp_enqueue_script( 'lt-jquery-form', LT_URL . '/js/jquery.form.min.js' );

     // Load custom script.
     wp_enqueue_script( 'lt-script', LT_URL . '/js/script.js' );

     // Load our public script.
     wp_enqueue_script( 'lt-public-script', LT_URL . '/js/public-script.js' );
     wp_localize_script( 'lt-public-script', 'LtPublic', array(
                                                                    'ajaxurl'           => admin_url( 'admin-ajax.php', ( is_ssl() ? 'https' : 'http' ) ),
                                                                    'order_page_url'    => get_permalink( $order_page_id ),
                                                                    'language_page_url' => get_permalink( $language_page_id ),
                                                                    'optional_page_url' => get_permalink( $optional_page_id ),
                                                                    'thankyou_page_url' => get_permalink( $thankyou_page_id ),
                                                                ) );
}

//add action to load scripts and styles for the front end
add_action( 'wp_enqueue_scripts', 'lt_public_scripts' );

?>