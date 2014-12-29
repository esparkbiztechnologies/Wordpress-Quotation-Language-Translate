<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Templates Functions
 *
 * Handles to manage templates of plugin
 */

/**
 * Returns the path to the Plugins templates directory
 */
function lt_get_templates_dir() {
	
    return LT_DIR . '/includes/templates/';
}
/**
 * Get template part.
 */ 
function lt_get_template_part( $slug, $name='' ) {
	
    $template = '';

    // Look in yourtheme/slug-name.php and yourtheme/language-translate/slug-name.php
    if ( $name )
            $template = locate_template( array ( $slug.'-'.$name.'.php', lt_get_templates_dir().$slug.'-'.$name.'.php' ) );

    // Get default slug-name.php
    if ( !$template && $name && file_exists( lt_get_templates_dir().$slug.'-'.$name.'.php' ) )
            $template = lt_get_templates_dir().$slug.'-'.$name.'.php';

    // If template file doesn't exist, look in yourtheme/slug.php and yourtheme/language-translate/slug.php
    if ( !$template )
            $template = locate_template( array ( $slug.'.php', lt_get_templates_dir().$slug.'.php' ) );

    if ( $template )
            load_template( $template, false );
}


/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *		yourtheme		/	$template_path	/	$template_name
 *		yourtheme		/	$template_name
 *		$default_path	/	$template_name
 */
function lt_locate_template( $template_name, $template_path = '', $default_path = '' ) {
	
    if ( ! $template_path ) $template_path = LT_BASENAME . '/';//lt_get_templates_dir();
    if ( ! $default_path ) $default_path = lt_get_templates_dir();

    // Look within passed path within the theme - this is priority

    $template = locate_template(
            array(
                    trailingslashit( $template_path ) . $template_name,
                    $template_name
            )
    );

    // Get default template
    if ( ! $template )
            $template = $default_path . $template_name;

    // Return what we found
    return $template;
}

/**
 * Get other templates (e.g. attributes) passing attributes and including the file.
 */

function lt_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	
    if ( $args && is_array($args) )
            extract( $args );

    $located = lt_locate_template( $template_name, $template_path, $default_path );

    include( $located );
}

/************************************ Call Different Templates Functions ***************************/

/**
 * Display Order Page Content
 */
function lt_order_content() {
    
    //order page content template
    lt_get_template( 'order/order-content.php' , array() );
}

/**
 * Display Language Page Content
 */
function lt_language_content() {
    
    //language page content template
    lt_get_template( 'language/language-content.php' , array() );
    
}

/**
 * Display Optional Page Content
 */
function lt_optional_content() {
    
    //optional page content template
    lt_get_template( 'optional/optional-content.php' , array() );
    
}

/**
 * Display Thank You Page Content
 */
function lt_thankyou_content() {
    
    //thankyou page content template
    lt_get_template( 'thankyou/thankyou-content.php' , array() );
    
}

/**
 * Display Order Widget Content
 */
function lt_order_widget_content( $title = '' ) {
    
    global $lt_options, $post;

    $prefix = LT_META_PREFIX;

    $order_page_id     = !empty( $lt_options['order_page'] ) ? $lt_options['order_page'] : '' ;
    $language_page_id  = !empty( $lt_options['order_language_page'] ) ? $lt_options['order_language_page'] : '' ;
    $optional_page_id  = !empty( $lt_options['order_optional_page'] ) ? $lt_options['order_optional_page'] : '' ;

    //get order id
    $order_id = lt_get_order_cookie();

    //get total items
    $total_items = lt_get_total_items();

    //get total words
    $total_words = lt_get_total_words();

    //get total languages
    $total_languages = lt_get_total_languages();

    //get selected langs
    $tran_from = get_post_meta( $order_id, $prefix . 'tran_from', true  );
    $tran_to = get_post_meta( $order_id, $prefix . 'tran_to', true  );
    $tran_to = !empty( $tran_to ) ? $tran_to : array();

    //get translate level
    $translate_level = get_post_meta( $order_id, $prefix . 'translate_level', true  );
    $translate_level = !empty( $translate_level ) ? $translate_level : 'standard';

    $title = !empty( $title ) ? $title : __( 'Your Quotation', 'langtrans' );
    
    //open exchange rates
    $rates = lt_get_open_exchange_rate();
    
    //get all currencies
    $curencies = !empty( $rates ) ? lt_get_currency_data() : array();
    
    //selected currency
    $selected_currency = lt_get_currency_cookie();
    
    $quatation_args = array(
                                'prefix'            => $prefix,
                                'post_id'           => $post->ID,
                                'lt_options'        => $lt_options,
                                'title'             => $title,
                                'order_page_id'     => $order_page_id,
                                'language_page_id'  => $language_page_id,
                                'optional_page_id'  => $optional_page_id,
                                'order_id'          => $order_id,
                                'total_items'       => $total_items,
                                'total_words'       => $total_words,
                                'total_languages'   => $total_languages,
                                'tran_from'         => $tran_from,
                                'tran_to'           => $tran_to,
                                'translate_level'   => $translate_level,
                                'curencies'         => $curencies,
                                'selected_currency'=> $selected_currency
                            );
    
    //optional page content template
    lt_get_template( 'sidebar/sidebar_quotation.php' , $quatation_args );
    
}
