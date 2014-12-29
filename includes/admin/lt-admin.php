<?php

/**
 * Admin File
 * Handles to admin functionality & other functions
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Custom Meta box for talents post type.
 */
function lt_meta_box() {

    //add_meta_box( 'lt_language_meta', __( 'Language Options', 'langtrans' ), 'lt_language_meta_options_page', LT_LANG_POST_TYPE, 'normal', 'high' );
    add_meta_box( 'lt_conversion_meta', __( 'Conversion Options', 'langtrans' ), 'lt_conversion_meta_options_page', LT_CONV_POST_TYPE, 'normal', 'high' );
    
}

/**
 * Languages Meta Options
 */
function lt_language_meta_options_page(){
    
    include LT_DIR . '/includes/admin/views/lt-language-meta.php';
}

/**
 * Conversion Meta Options
 */
function lt_conversion_meta_options_page(){
    
    include LT_DIR . '/includes/admin/views/lt-conversion-meta.php';
}

/**
 * Save Meta for post type.
 */
function lt_save_meta( $post_id ) {
    
    $prefix = LT_META_PREFIX;
    
    /* Save Meta For Language PoatType  */
    if( isset( $_POST['post_type'] ) && $_POST['post_type'] == LT_LANG_POST_TYPE ) {
        
        if ( isset( $_POST[$prefix.'lang_code'] ) ) {
            update_post_meta( $post_id, $prefix.'lang_code', lt_escape_slashes_deep( $_POST[$prefix.'lang_code'] ) );
        }   
    }
    
    /* Save Meta For Conversion Post Type */
    if(isset( $_POST['post_type'] ) && $_POST['post_type'] == LT_CONV_POST_TYPE ) {
        
        if( isset( $_POST[$prefix.'lang'] ) ) {
            update_post_meta( $post_id, $prefix.'lang', lt_escape_slashes_deep( $_POST[$prefix.'lang'] ) );
        }
        if( isset( $_POST[$prefix.'offer_lang'] ) ) {
            update_post_meta( $post_id, $prefix.'offer_lang', lt_escape_slashes_deep( $_POST[$prefix.'offer_lang'] ) );
        }
        
    }
}

/**
 * Save Conversation Price
 */
function lt_save_conversation_price() {
    
    $prefix = LT_META_PREFIX;

    // Check save price button
    // Check conversation id is not empty
    // Check language conversation price meta are not empty
    if( !empty( $_POST['lt_save_conv_price'] ) && !empty( $_POST['lt_conv_id'] )
        && !empty( $_POST[$prefix.'lang_conv_price'] ) ) {
        
        $conv_id = $_POST['lt_conv_id'];
        
        // update langusge conversation price meta
        update_post_meta( $conv_id, $prefix . 'lang_conv_price', lt_escape_slashes_deep( $_POST[$prefix.'lang_conv_price'] ) );
    }
}

/**
 * Add admin menu
 */
function lt_add_admin_menu() {
    
    add_submenu_page( '', __( 'Conversation Price', 'langtrans' ), '', 'manage_options', 'lt-conv-price-opt', 'lt_conv_price_options_page' );
    add_submenu_page( 'edit.php?post_type='.LT_CONV_POST_TYPE, __( 'Orders', 'langtrans' ), __( 'Orders', 'langtrans' ), 'manage_options', 'lt-orders', 'lt_orders_page' );
    add_submenu_page( 'edit.php?post_type='.LT_CONV_POST_TYPE, __( 'Settings', 'langtrans' ), __( 'Settings', 'langtrans' ), 'manage_options', 'lt-settings', 'lt_settings_page' );
}

/**
 * Conversion Price Options Page
 */
function lt_conv_price_options_page() {
    
    include LT_DIR . '/includes/admin/views/lt-conversation-price.php';
}

/**
 * Orders Page
 */
function lt_orders_page() {
    
    include LT_DIR . '/includes/admin/views/lt-orders.php';
}

/**
 * Settings Page
 */
function lt_settings_page() {
    
    include LT_DIR . '/includes/admin/views/lt-settings.php';
}

/**
 * Custom column
 *
 * Handles the custom columns to set conversion price
 */
function lt_conv_manage_custom_column( $column_name, $post_id ) {

    global $wpdb,$post;

    $prefix = LT_META_PREFIX;

    switch ($column_name) {

        case 'set_price' :
                            $price_opt_page_url = add_query_arg( array( 'post_type' => LT_CONV_POST_TYPE, 'page' => 'lt-conv-price-opt', 'post_id' => $post->ID ), admin_url( 'edit.php' ) );
                            echo '<a target="_BLANK" href="'.$price_opt_page_url.'">'.__( 'Set Price', 'langtrans' ).'</a>';
                            break;

    }
}

/**
 * Add New Column to set conversion price
 */
function add_new_lt_conv_columns($new_columns) {

    unset($new_columns['date']);

    $new_columns['set_price']= __('Set Price','langtrans');
    $new_columns['date']     = _x('Date','column name','langtrans');

    return $new_columns;
}

/**
 * Register Settings
 */
function lt_admin_register_settings() {

    register_setting( 'lt_plugin_options', 'lt_options', 'lt_validate_options' );
}

/**
 * Validate Settings Options
 * 
 * Handle settings page values
 */
function lt_validate_options($input) {

    // sanitize text input (strip html tags, and escape characters)
    $input['order_page']            = lt_escape_slashes_deep( $input['order_page'] );
    $input['order_language_page']   = lt_escape_slashes_deep( $input['order_language_page'] );
    $input['order_optional_page']   = lt_escape_slashes_deep( $input['order_optional_page'] );
    $input['order_thankyou_page']   = lt_escape_slashes_deep( $input['order_thankyou_page'] );

    $input['order_title']           = lt_escape_slashes_deep( $input['order_title'] );
    $input['order_tooltip_title']   = lt_escape_slashes_deep( $input['order_tooltip_title'] );
    $input['order_tooltip_desc']    = lt_escape_slashes_deep( $input['order_tooltip_desc'], true );

    $input['language_from']         = lt_escape_slashes_deep( $input['language_from'] );
    $input['language_to']           = lt_escape_slashes_deep( $input['language_to'] );
    $input['language_support']      = lt_escape_slashes_deep( $input['language_support'], true );

    $input['quotation_title']        = lt_escape_slashes_deep( $input['quotation_title'] );
    $input['quotation_desc']         = lt_escape_slashes_deep( $input['quotation_desc'], true );
    $input['quotation_tooltip_title']= lt_escape_slashes_deep( $input['quotation_tooltip_title'] );
    $input['quotation_tooltip_desc'] = lt_escape_slashes_deep( $input['quotation_tooltip_desc'], true );
    $input['agree_terms']	     = lt_escape_slashes_deep( $input['agree_terms'] );

    $input['email_to']              = lt_escape_slashes_deep( $input['email_to'] );
    $input['email_subject']         = lt_escape_slashes_deep( $input['email_subject'] );
    $input['email_body']            = lt_escape_slashes_deep( $input['email_body'], true );
    $input['user_email_subject']    = lt_escape_slashes_deep( $input['user_email_subject'] );
    $input['user_email_body']       = lt_escape_slashes_deep( $input['user_email_body'], true );
    
    $input['open_exchange_key']     = lt_escape_slashes_deep( trim( $input['open_exchange_key'] ) );
    $input['currency_base']         = !empty( $input['currency_base'] ) ? lt_escape_slashes_deep( $input['currency_base'] ) : LT_DEFAULT_CURRENCY_CODE;
	
    wp_schedule_event( time(), 'hourly', 'lt_open_exchange_rates');

    return $input;
}

//add action to create custom meta box
add_action( 'admin_init', 'lt_meta_box' );

//add action to save custom meta
add_action( 'save_post', 'lt_save_meta' );

//ad action to save conversation price
add_action( 'admin_init', 'lt_save_conversation_price' );

//add action to add admin menu
add_action( 'admin_menu', 'lt_add_admin_menu' );

//add new field to post listing page
add_action( 'manage_'.LT_CONV_POST_TYPE.'_posts_custom_column', 'lt_conv_manage_custom_column', 10, 2 );
add_filter( 'manage_edit-'.LT_CONV_POST_TYPE.'_columns', 'add_new_lt_conv_columns' );

//add register plugin settings
add_action ( 'admin_init', 'lt_admin_register_settings' );

?>