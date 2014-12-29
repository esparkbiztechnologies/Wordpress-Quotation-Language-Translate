<?php

/**
 * Model File
 * Handles to database functionality & other functions
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
* Escape Attr
*/
function lt_escape_attr($data){

       $data = escape_attr(stripslashes_deep($data));
       return $data;
}

/**
* Strip Slashes From Array
*/
function lt_escape_slashes_deep($data = array(),$flag=true){

       if($flag != true) {
               $data = lt_nohtml_kses($data);
       }
       $data = stripslashes_deep($data);
       return $data;
}

/**
* Strip Html Tags 
* 
* It will sanitize text input (strip html tags, and escape characters)
*/
function lt_nohtml_kses($data = array()) {

       if ( is_array($data) ) {

               $data = array_map(array($this,'lt_nohtml_kses'), $data);

       } elseif ( is_string( $data ) ) {

               $data = wp_filter_nohtml_kses($data);
       }

       return $data;
}

/**
 * Convert Object To Array
 */
function lt_object_to_array($result) {

    $array = array();
    foreach ($result as $key=>$value)
    {	
        if (is_object($value)) {
            $array[$key]=lt_object_to_array($value);
        } else {
            $array[$key]=$value;
        }
    }
    return $array;
}

/**
 * Get Orders Data
 * 
 * Handles get all orders data
 */
function lt_get_orders( $args=array() ) {

    $prefix = LT_META_PREFIX;

    $orderargs = array('post_type' => LT_ORDER_POST_TYPE, 'post_status' => 'publish');

    //show how many per page records
    if(isset($args['posts_per_page']) && !empty($args['posts_per_page'])) {
            $orderargs['posts_per_page'] = $args['posts_per_page'];
    } else {
            $orderargs['posts_per_page'] = -1;
    }

    //return only id
    if(isset($args['fields']) && !empty($args['fields'])) {
        $orderargs['fields'] = $args['fields'];
    }

    //return by search
    if(isset($args['s']) && !empty($args['s'])) {
        $orderargs['s'] = $args['s'];
    }

    //return based on meta query 
    //this should be passed like array( array( 'key' => $key, 'value' => $value ) )
    if(isset($args['meta_query']) && !empty($args['meta_query'])) {
        $orderargs['meta_query'] = $args['meta_query'];
    }

    //this is for user is should not zero
    if(isset($args['author']) && !empty($args['author'])) {
        $orderargs['author'] = $args['author'];
    }

    //show per page records
    if(isset($args['paged']) && !empty($args['paged'])) {
        $orderargs['paged']	=	$args['paged'];
    }

    //get particulate order id's order data
    if(isset($args['p']) && !empty($args['p'])) {
        $orderargs['p']	= $args['p'];
    }

    //get the data by year
    if(isset($args['year']) && !empty($args['year'])) {
        $orderargs['year']	= $args['year'];	
    }

    //get the data by mont
    if(isset($args['monthnum']) && !empty($args['monthnum'])) {
        $orderargs['monthnum']	= $args['monthnum'];	
    }

    //get the data by day
    if(isset($args['day']) && !empty($args['day'])) {
        $orderargs['day']	= $args['day'];	
    }
    //get the data by hour
    if(isset($args['hour']) && !empty($args['hour'])) {
        $orderargs['hour']	= $args['year'];	
    }

    //get order by records
    $orderargs['order'] = 'DESC';
    $orderargs['orderby'] = 'date';

    //fire query in to table for retriving data
    $result = new WP_Query( $orderargs );

    if(isset($args['getcount']) && $args['getcount'] == '1') {
        $postslist = $result->post_count;	
    }  else {
        //retrived data is in object format so assign that data to array for listing
        $postslist = lt_object_to_array($result->posts);
    }

    return $postslist;
}

/**
 * Get Date Format
 * 
 * Handles to return formatted date which format is set in backend
 */
function lt_get_date_format( $date, $time = false ) {

    $format = $time ? get_option( 'date_format' ).' '.get_option('time_format') : get_option('date_format');
    $date = date_i18n( $format, strtotime($date));
    return $date;
}

/**
 * Get Currency Name
 */
function lt_get_currency_data( $code = '' ) {
	 
	$currency_data = array(	
				'USD'	=> __('US Dollars (&#36;)', 'langtrans'),
				'GBP'	=> __('Pounds Sterling (&pound;)', 'langtrans'),
				'EUR'	=> __('Euros (&euro;)', 'langtrans'),
				'AUD' 	=> __('Australian Dollars (&#36;)', 'langtrans'),
				'BRL' 	=> __('Brazilian Real (R&#36;)', 'langtrans'),
				'CAD' 	=> __('Canadian Dollars (&#36;)', 'langtrans'),
				'CZK' 	=> __('Czech Koruna', 'langtrans'),
				'DKK'	=> __('Danish Krone', 'langtrans'),
				'HKD' 	=> __('Hong Kong Dollar (&#36;)', 'langtrans'),
				'HUF' 	=> __('Hungarian Forint', 'langtrans'),
				'RIAL' 	=> __('Iranian Rial', 'langtrans'),
				'ILS' 	=> __('Israeli Shekel', 'langtrans'),
				'JPY' 	=> __('Japanese Yen (&yen;)', 'langtrans'),
				'MYR' 	=> __('Malaysian Ringgits', 'langtrans'),
				'MXN' 	=> __('Mexican Peso (&#36;)', 'langtrans'),
				'NZD' 	=> __('New Zealand Dollar (&#36;)', 'langtrans'),
				'NOK' 	=> __('Norwegian Krone', 'langtrans'),
				'PHP' 	=> __('Philippine Pesos', 'langtrans'),
				'PLN' 	=> __('Polish Zloty', 'langtrans'),
				'SGD' 	=> __('Singapore Dollar (&#36;)', 'langtrans'),
				'ZAR'	=> __('South African Rand (R)', 'langtrans'),
				'SEK' 	=> __('Swedish Krona', 'langtrans'),
				'CHF' 	=> __('Swiss Franc', 'langtrans'),
				'TWD' 	=> __('Taiwan New Dollars', 'langtrans'),
				'THB' 	=> __('Thai Baht', 'langtrans'),
				'INR' 	=> __('Indian Rupee', 'langtrans'),
				'TRY' 	=> __('Turkish Lira', 'langtrans'),
				'IDR' 	=> __('Indonesia Rupiah (Rp)', 'langtrans')
	  		 );
	return !empty( $code ) ? ( isset( $currency_data[$code] ) ? $currency_data[$code] : $code ) : $currency_data;
}

/**
 * Get Currency Symbol
 */
function lt_get_currency_symbol( $code = LT_DEFAULT_CURRENCY_CODE ) {
	 
	$currency_data = array(	
				'USD'	=> '&#36;',
				'GBP'	=> '&pound;',
				'EUR'	=> '&euro;',
				'AUD' 	=> '&#36;',
				'BRL' 	=> 'R&#36;',
				'CAD' 	=> '&#36;',
				'HKD' 	=> '&#36;',
				'JPY' 	=> '&yen;',
				'MXN' 	=> '&#36;',
				'NZD' 	=> '&#36;',
				'SGD' 	=> '&#36;',
	  		 );
	return isset( $currency_data[$code] ) ? $currency_data[$code] : $code;
}

/**
 * Get Absulate path
 */
function lt_get_absulate_path( $url ) {
    
    $abs = '';
    if( !empty( $url ) ) {
        
        $upload_path = wp_upload_dir();
        $abs = str_replace($upload_path['baseurl'], $upload_path['basedir'], $url);
    }
    return $abs;
}

/**
 * Page IDs
 * 
 * Handles to return page id from settings
 */
function lt_get_page_id( $page ) {

    $lt_options = get_option( 'lt_options' );
    $pageid = !empty( $page ) && isset( $lt_options[$page] ) && !empty( $lt_options[$page] ) ? $lt_options[$page] : '-1';

    return $pageid;
}

/**
 * Get all ids of languages from conversion
 */
function lt_get_lang_ids_by_conv_ids( $conv_ids ) {
    
    $prefix = LT_META_PREFIX;

    $lang_ids = array();
    if( !empty( $conv_ids ) ) {
        
        foreach ( $conv_ids as $conv_id ) {
            
            $lang_id = get_post_meta( $conv_id, $prefix.'lang', true );
            if( !empty( $lang_id ) ) {
                $lang_ids[] = $lang_id;
            }
        }
    }
    return $lang_ids;
}

/**
 * Set Order Id in Cookie
 */
function lt_set_order_cookie( $order_id ) {
    
    if( !empty( $order_id ) ) {
        
        $time = time()+ ( 3600 * 30 );
        setcookie( "lt_set_order", $order_id, $time, '/', '', 0 );
    }
}

/**
 * Get Order Cookie
 */
function lt_get_order_cookie() {
    
    return isset( $_COOKIE['lt_set_order'] ) ? $_COOKIE['lt_set_order'] : '';
}

/**
 * Remove Order Cookie
 */
function lt_remove_order_cookie() {
    
    $time = time() - ( 3600 * 30 * 7 );
    setcookie( "lt_set_order", '', $time, '/', '', 0 );
}

/**
 * Set Currency in Cookie
 */
function lt_set_currency_cookie( $currency_code ) {
    
    if( !empty( $currency_code ) ) {
        
        $time = time()+ ( 3600 * 30 );
        setcookie( "lt_set_currency_code", $currency_code, $time, '/', '', 0 );
    }
}

/**
 * Get Currency Cookie
 */
function lt_get_currency_cookie() {
    
    return isset( $_COOKIE['lt_set_currency_code'] ) ? $_COOKIE['lt_set_currency_code'] : LT_DEFAULT_CURRENCY_CODE;
}

/**
 * Remove Currency Cookie
 */
function lt_remove_currency_cookie() {
    
    $time = time() - ( 3600 * 30 * 7 );
    setcookie( "lt_set_currency_code", '', $time, '/', '', 0 );
}

/**
 * Update Order File Meta
 */
function lt_update_order_file_meta( $order_id, $data ) {
    
    $prefix = LT_META_PREFIX;

    if( !empty( $order_id ) && !empty( $data ) ) {
        
        $file_data = get_post_meta( $order_id, $prefix . 'file_data', true );
        $file_data = !empty( $file_data ) ? $file_data : array();
        $file_data[] = $data;
        
        //update file data
        update_post_meta( $order_id, $prefix . 'file_data', $file_data );
    }
}

/**
 * Create Order
 */
function lt_create_order( $args = array() ) {
    
    $prefix = LT_META_PREFIX;

    //get order id
    $order_id = lt_get_order_cookie();
    if( empty( $order_id ) ) {
        
        $order_args = array(
                                'post_type'     => LT_ORDER_POST_TYPE,
                                'post_status'   => 'pending'
                            );
        $order_id = wp_insert_post( $order_args );
        
        if( !empty( $args['file_data'] ) ) {
            
            //update order file meta
            lt_update_order_file_meta( $order_id, $args['file_data'] );
        }
        
        //Set Cookie
        lt_set_order_cookie( $order_id );
    }
}

/**
 * Get total items
 */
function lt_get_total_items() {
    
    $prefix = LT_META_PREFIX;

    //get order id
    $order_id = lt_get_order_cookie();

    //get file data
    $file_data = get_post_meta( $order_id, $prefix . 'file_data', true );

    return !empty( $file_data ) ? count( $file_data ) : 0;
}

/**
 * Get total words
 */
function lt_get_total_words() {
    
    $total_words = 0;
    
    $prefix = LT_META_PREFIX;

    //get order id
    $order_id = lt_get_order_cookie();

    //get file data
    $file_data = get_post_meta( $order_id, $prefix . 'file_data', true );
    
    if( !empty( $file_data ) ) {
        
        foreach ( $file_data as $file_key => $file_value ) {

            if( isset( $file_value['method'] ) && $file_value['method'] == 'file' ) {

                $file_path = lt_get_absulate_path( $file_value['url'] );

                if( empty( $file_path ) && !is_file( $file_path ) ) {
                    continue;
                } else {
                    // read into string
                    $str = file_get_contents( $file_path );
                }
            } else {
                $str = isset( $file_value['content'] ) ? $file_value['content'] : '';
            }

            $numWords = str_word_count($str);
            $total_words += $numWords;
        }
    }
    
    return $total_words;
}

/**
 * Get total languages
 */
function lt_get_total_languages() {
    
    $total_languages = 0;
    
    $prefix = LT_META_PREFIX;

    //get order id
    $order_id = lt_get_order_cookie();

    //get selected langs
    $tran_from = get_post_meta( $order_id, $prefix . 'tran_from', true  );
    $tran_to = get_post_meta( $order_id, $prefix . 'tran_to', true  );
    $tran_to = !empty( $tran_to ) ? $tran_to : array();
    
    if( !empty( $tran_from ) && !empty( $tran_to )
        && is_array( $tran_to ) ) {
        
        //get total languages
        $total_languages = count( $tran_to );
    }
    
    return $total_languages;
}

/**
 * Get Open Exchange Rates
 */
function lt_get_open_exchange_rate() {

    $rates = array();
    $open_exchange_data = get_option( 'lt_open_exchange_data' );
    if( !empty( $open_exchange_data['rates'] ) ) {
	
        $rates = $open_exchange_data['rates'];
    }
    return $rates;
}

?>