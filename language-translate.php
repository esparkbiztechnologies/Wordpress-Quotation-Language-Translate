<?php
/*
Plugin Name: ESB Language Translation
Plugin URI: https://wordpress.org/plugins/language-translate/
Description: Language Translation provides a facility where the end-user can convert the contents from one language to other.
Version: 1.0.0
Author: Henry
Author URI: http://esparkinfo.com/
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if( !defined( 'LT_DIR' ) ) {
    define('LT_DIR', dirname( __FILE__ ) ); // plugin dir
}
if( !defined( 'LT_URL' ) ) {
    define('LT_URL', plugin_dir_url( __FILE__ ) ); // plugin url
}
if( !defined( 'LT_META_PREFIX' ) ) {
    define( 'LT_META_PREFIX', '_lt_' ); // meta box prefix
}
if( !defined('LT_LANG_POST_TYPE' ) ) {
    define('LT_LANG_POST_TYPE', 'lang_trans' ); // custom post type's slug
}
if( !defined('LT_CONV_POST_TYPE') ){
    define('LT_CONV_POST_TYPE', 'lang_conv');  // custom post type's slug
}
if( !defined('LT_ORDER_POST_TYPE') ){
    define('LT_ORDER_POST_TYPE', 'lang_order');  // custom post type's slug
}
if( !defined('LT_BASENAME') ){
    define('LT_BASENAME', 'language-translate');  // plugin base name
}
if( !defined('LT_OPEN_EXCHANGE_API_URL') ){
    define('LT_OPEN_EXCHANGE_API_URL', 'https://openexchangerates.org/api/latest.json');  // open exchange api url
}

//include post type file
include LT_DIR . '/includes/lt-post-types.php';

/**
 * Load Text Domain
 *
 * This gets the plugin ready for translation.
 */

function lt_load_textdomain() {

  load_plugin_textdomain( 'langtrans', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

}
add_action( 'init', 'lt_load_textdomain' ); 

/**
 * Activation Hook
 *
 * Register plugin activation hook.
 */
register_activation_hook( __FILE__, 'lt_install' );

/**
 * Deactivation Hook
 *
 * Register plugin deactivation hook.
 */
register_deactivation_hook( __FILE__, 'lt_uninstall');

/**
 * Plugin Setup (On Activation)
 *
 * Does the initial setup,
 * stest default values for the plugin options.
 */
function lt_install() {
    
    global $user_ID;
    
    //register custom post type
    lt_register_post_type();

    //IMP Call of Function
    //Need to call when custom post type is being used in plugin
    flush_rewrite_rules();

    //get option for when plugin is activating first time
    $lt_set_option = get_option( 'lt_set_option' );

    if( empty( $lt_set_option ) ) { //check plugin version option

        $order_page = array(
                                'post_type' 	=> 'page',
                                'post_status' 	=> 'publish',
                                'post_title' 	=> __('Order','langtrans'),
                                'post_content' 	=> '[lt_order][/lt_order]',
                                'post_author' 	=> $user_ID,
                                'menu_order' 	=> 0,
                                'comment_status' => 'closed'
                            );

        //create main page for plugin					
        $order_parent_page_id = wp_insert_post($order_page);

        // order language page creation
        $order_language_page = array(
                                        'post_type' => 'page',
                                        'post_status' => 'publish',
                                        'post_parent' => $order_parent_page_id,
                                        'post_title' => __('Languages','langtrans'),
                                        'post_content' => '[lt_language][/lt_language]',
                                        'post_author' => $user_ID,
                                        'comment_status' => 'closed'
                                    );
        //create order language page						
        $order_language_page_id = wp_insert_post($order_language_page);
	
        // order optional page creation
        $order_optional_page = array(
                                        'post_type' => 'page',
                                        'post_status' => 'publish',
                                        'post_parent' => $order_parent_page_id,
                                        'post_title' => __('Optional','langtrans'),
                                        'post_content' => '[lt_optional][/lt_optional]',
                                        'post_author' => $user_ID,
                                        'comment_status' => 'closed'
                                    );
        //create order optional page						
        $order_optional_page_id = wp_insert_post($order_optional_page);
	
        // order thankyou page creation
        $order_thankyou_page = array(
                                        'post_type' => 'page',
                                        'post_status' => 'publish',
                                        'post_parent' => $order_parent_page_id,
                                        'post_title' => __('Thank You','langtrans'),
                                        'post_content' => '[lt_thankyou][/lt_thankyou]',
                                        'post_author' => $user_ID,
                                        'comment_status' => 'closed'
                                    );
        //create order thankyou page						
        $order_thankyou_page_id = wp_insert_post($order_thankyou_page);
	
        // this option contains all page ID(s)
        $lt_options = $pages_id = array(
	                                'order_page'             => 	$order_parent_page_id,
	                                'order_language_page'    =>	$order_language_page_id,
	                                'order_optional_page'    =>	$order_optional_page_id,
	                                'order_thankyou_page'    =>	$order_thankyou_page_id
	                            );
        update_option( 'lt_set_pages', $pages_id );
        
        $lt_options['order_title'] 	   = __( 'What would you like to translate?', 'langtrans' );
        $lt_options['order_tooltip_title'] = __( 'We accept most file types', 'langtrans' );
        $lt_options['order_tooltip_desc']  = '';

        $lt_options['language_from'] 	= __( 'Language from', 'langtrans' );
        $lt_options['language_to'] 	= __( 'Language to', 'langtrans' );
        $lt_options['language_support'] = __( 'Can\'t find your language?', 'langtrans' );

        $lt_options['quotation_title'] 	   = __( 'How important is quality?', 'langtrans' );
        $lt_options['quotation_desc'] 	   = __( 'Tell us the purpose of your translation, and we can recommend a quality level.', 'langtrans' );
        $lt_options['quotation_tooltip_title'] = __( 'Estimated delivery <strong>7 hours.</strong>', 'langtrans' );
        $lt_options['quotation_tooltip_desc']  = __( '<p><strong>Estimated Delivery</strong></p><p>This is an estimate, not a guarantee.</p>', 'langtrans' );
        $lt_options['agree_terms'] 	= __( ' I agree to the Terms & Conditions and Quality Policy', 'langtrans' );

        $lt_options['email_to'] 	= '';
        $lt_options['email_subject'] 	= __( 'Quotation', 'langtrans' );
        $lt_options['email_body'] 	= __( 'Order details are as per below :' . "\n\n" . 'Order ID : {order_id}' . "\n\n" . '{quotation}' . "\n\n" . 'Thank you', 'langtrans' );
        $lt_options['user_email_subject']= __( 'Quotation', 'langtrans' );
        $lt_options['user_email_body'] 	= __( 'Thank you for your order. We will contact you shortly.' . "\n\n" . 'Order ID : {order_id}' . "\n\n" . 'Thank you', 'langtrans' );
        
        $lt_options['open_exchange_key']= '';
        $lt_options['currency_base']	= 'USD';
        
        //update plugin options
        update_option( 'lt_options', $lt_options );
        
        //update plugin version to option 
        update_option( 'lt_set_option', '1.0' );
    }	
}

/**
 * Plugin Setup (On Deactivation)
 *
 * Delete plugin options.
 */
function lt_uninstall() {
    
    //register custom post type
    lt_register_post_type();

    //IMP Call of Function
    //Need to call when custom post type is being used in plugin
    flush_rewrite_rules();
    
    //clear schedule for getting open exchange rates
    wp_clear_scheduled_hook( 'lt_open_exchange_rates' );
    
}

global $lt_options;
$lt_options = get_option( 'lt_options' );

//include model file
include LT_DIR . '/includes/lt-model.php';

$base_currency = isset( $lt_options['currency_base'] ) ? $lt_options['currency_base'] : 'USD';

if( !defined('LT_DEFAULT_CURRENCY_CODE') ){
    define('LT_DEFAULT_CURRENCY_CODE', $base_currency);  // default currency code
}

//get selected currency code
$selected_currency_code = lt_get_currency_cookie();

if( !is_admin() || ( defined('DOING_AJAX') && DOING_AJAX ) ) {
    $base_currency = $selected_currency_code;
}
$symbol = lt_get_currency_symbol( $base_currency );
define('LT_CURRENCY_SYMBOL', $symbol);  // currency symbol

//include scripts file
include LT_DIR . '/includes/lt-scripts.php';

//include shortcode file
include LT_DIR . '/includes/lt-shortcode.php';

//include admin file
include LT_DIR . '/includes/admin/lt-admin.php';

//include public file
include LT_DIR . '/includes/lt-public.php';

// loads the Templates Functions file
require_once ( LT_DIR . '/includes/lt-template-functions.php' );

//Load Template Hook File
require_once( LT_DIR . '/includes/lt-template-hooks.php' );

//Load Order Widget File
require_once( LT_DIR . '/includes/widgets/class-lt-order.php' );

?>