<?php

/**
 * Public File
 * Handles to public functionality & other functions
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Load Page Template
 * 
 * Handles to load page template for pages
 */
function lt_load_template( $template ) {

    $find = array( 'language-translate.php' );
    $file = '';

    if ( is_page( lt_get_page_id( 'order_page' ) ) ) { //check it is order page

        $file   = 'order.php';
        $find[] = $file;
        $find[] = 'language-translate/' . $file;

    } elseif ( is_page( lt_get_page_id( 'order_language_page' ) ) ) { //check it is language page

        $file 	= 'language.php';
        $find[] = $file;
        $find[] = 'language-translate/' . $file;

    } elseif ( is_page( lt_get_page_id( 'order_optional_page' ) ) ) { //check it is optional page

        $file 	= 'optional.php';
        $find[] = $file;
        $find[] = 'language-translate/' . $file;
        
    } elseif ( is_page( lt_get_page_id( 'order_thankyou_page' ) ) ) { //check it is thank you page

        $file 	= 'thankyou.php';
        $find[] = $file;
        $find[] = 'language-translate/' . $file;
    }

    if ( $file ) {
        $template = locate_template( $find );
        if ( ! $template ) $template = lt_get_templates_dir() . $file;
    }

    return $template;
}

/**
 * Translate Order Precess 
 */
function lt_translate_order_process() {
    
    if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
    
    if( !empty( $_FILES['lt_file_upload'] ) ) {
        
        $uploadedfile = $_FILES['lt_file_upload'];
        $upload_overrides = array( 'test_form' => false );
        $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
        if ( isset( $movefile['file'] ) && is_file( $movefile['file'] ) ) {
            
            // read into string
            $str = file_get_contents($movefile['file']);
            $numWords = str_word_count($str);
            
            //get order id
            $order_id = lt_get_order_cookie();

            $file_data = array(
                                    'file' => isset( $movefile['file'] ) ? $movefile['file'] : '',
                                    'url'  => isset( $movefile['url'] ) ? $movefile['url'] : '',
                                    'type' => isset( $movefile['type'] ) ? $movefile['type'] : '',
                                    'method' => 'file'
                                );
            
            if( !empty( $order_id ) ) {
                
                //update order file meta
                lt_update_order_file_meta( $order_id, $file_data );
                
            } else {
                
                $order_args = array(
                                        'file_data' => $file_data,
                                    );
                //Create Order
                lt_create_order( $order_args );
            }
            
            $response_data = array( 
                                        'file_path' => $movefile['file'],
                                        'file_url'  => $movefile['url'],
                                        'word_count' => $numWords
                                    );
            echo json_encode( $response_data );
            exit;
        }
    }
}

/**
 * load offer laguages for partucular language
 */
function lt_load_offer_languages() {
    
    $postid = $_POST['postid'];
    
    $prefix = LT_META_PREFIX;
    
    //get order id
    $order_id = lt_get_order_cookie();

    //update translate from order meta
    //$tran_from = get_post_meta( $order_id, $prefix . 'tran_from', $postid  );
    
    $meta = get_post_meta( $postid, $prefix . 'offer_lang', true  );
    
    //get selected langs
    $tran_to = get_post_meta( $order_id, $prefix . 'tran_to', true  );
    $tran_to = !empty( $tran_to ) ? $tran_to : array();
    
    if( !empty( $meta ) ) {
        
        foreach( $meta as $meta_value ) {

            //$selected_class = in_array( $meta_value, $tran_to ) ? ' checked_lang ' : '';
            
            echo '<li data-offer-value="' . $meta_value . '" class=""> 
                    <i class="fa fa-check check_text"></i>
                    <span class="language_name">' . get_the_title( $meta_value ) . '</span>
                </li>'; 
        }
    }
    exit;
}

/**
 * Add Text into File Meta
 */
function lt_add_text() {
    
    $word_count = '';
    
    if( !empty( $_POST['textvalue'] ) ) {
        
        $str = $_POST['textvalue'];
        $word_count = str_word_count( $str );
        
        //get order id
        $order_id = lt_get_order_cookie();

        $data = array(
                            'content' => $str,
                            'method'  => 'text'
                        );

        if( !empty( $order_id ) ) {

            //update order file meta
            lt_update_order_file_meta( $order_id, $data );

        } else {

            $order_args = array(
                                    'file_data' => $data,
                                );
            //Create Order
            lt_create_order( $order_args );
        }
    }
    echo $word_count;
    exit;
}

/**
 * Clear order file meta
 */
function lt_clear_file_meta() {

    $prefix = LT_META_PREFIX;

    //get order id
    $order_id = lt_get_order_cookie();

    //get file data
    $file_data = get_post_meta( $order_id, $prefix . 'file_data', true );

    //get remove file key from user selected delete file
    $remove_file_key = isset( $_POST['filekey'] ) ? $_POST['filekey'] : '';

    if( empty( $remove_file_key ) ) {
        
        //clear language from order meta
        update_post_meta( $order_id, $prefix . 'tran_from', '' );
    
        //clear language to order meta
        update_post_meta( $order_id, $prefix . 'tran_to', '' );
    
        //clear translate level order meta
        update_post_meta( $order_id, $prefix . 'translate_level', '' );
    }
    
    if( !empty( $file_data ) ) {
        
        foreach ( $file_data as $file_key => $file_value ) {
            
            if( $remove_file_key != '' ) {
                
                if( $remove_file_key == $file_key ) {
                    
                    $file_path = lt_get_absulate_path( $file_value['url'] );
                    unlink( $file_path );
                    unset( $file_data[$file_key] );
                }
                
            } else {
            
                $file_path = lt_get_absulate_path( $file_value['url'] );
                unlink( $file_path );
                unset( $file_data[$file_key] );
            }
        }
    }

    //clear file data order meta
    update_post_meta( $order_id, $prefix . 'file_data', $file_data );
    
    exit;
}

/**
 * Clear order language meta
 */
function lt_clear_lang_meta() {

    $prefix = LT_META_PREFIX;

    //get order id
    $order_id = lt_get_order_cookie();
    
    //clear translate to order meta
    update_post_meta( $order_id, $prefix . 'tran_to', '' );
    
}

/**
 * Add seleccted languages into order meta
 */
function lt_add_languages() {
    
    if( !empty( $_POST['tran_from'] ) && !empty( $_POST['tran_to'] ) ) {
        
        $prefix = LT_META_PREFIX;

        //get order id
        $order_id = lt_get_order_cookie();

        //selected languages
        $tran_to = explode(',', trim($_POST['tran_to'], ','));
        
        //update meta for translate from
        update_post_meta( $order_id, $prefix . 'tran_from', $_POST['tran_from'] );
        
        //update meta for translate to
        update_post_meta( $order_id, $prefix . 'tran_to', $tran_to );
    }
    exit;
}

/**
 *  Find Levels of language translation like standard, business or ultra
 */
function lt_translate_level(){
    
    if( !empty( $_POST['level'] ) ) {
        
        $prefix = LT_META_PREFIX;
        
        //get order id
        $order_id = lt_get_order_cookie();
        
        //update meta for translate level
        update_post_meta( $order_id, $prefix . 'translate_level', $_POST['level'] );
    }
    exit;    
}

/**
 *  Change Currency Code
 */
function lt_change_currency() {
    
    if( !empty( $_POST['code'] ) ) {
        
        //set currency code in cookie
        lt_set_currency_cookie( $_POST['code'] );
    }
    exit;
}

/**
 * Send Email
 */
function lt_send_email() {
    
    global $lt_options;

    if( !empty( $_POST['email'] ) && is_email( $_POST['email'] ) ) {
        
        $user_email = $_POST['email'];
        $email_to = !empty( $lt_options['email_to'] ) ? $lt_options['email_to'] : get_option( 'admin_email' );
        $email_subject = isset( $lt_options['email_subject'] ) ? $lt_options['email_subject'] : '';
        $email_body = !empty( $lt_options['email_body'] ) ? nl2br( $lt_options['email_body'] ) : '';
        
        $user_email_subject = isset( $lt_options['user_email_subject'] ) ? $lt_options['user_email_subject'] : '';
        $user_email_body = !empty( $lt_options['user_email_body'] ) ? nl2br( $lt_options['user_email_body'] ) : '';
        
        $headers = 'From: '. $user_email."\r\n";
        $headers .= "Reply-To: ". $user_email . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=utf-8\r\n";

        $user_headers = 'From: '. $email_to."\r\n";
        $user_headers .= "Reply-To: ". $email_to . "\r\n";
        $user_headers .= "MIME-Version: 1.0\r\n";
        $user_headers .= "Content-Type: text/html; charset=utf-8\r\n";
                
        $message = $email_body;
        $user_message = $user_email_body;
        
	$prefix = LT_META_PREFIX;
	
	//get order id
	$order_id = lt_get_order_cookie();
	
        //update user email
	update_post_meta( $order_id, $prefix . 'user_email', $user_email );
        
	//get selected langs
	$tran_from = get_post_meta( $order_id, $prefix . 'tran_from', true  );
	$tran_to = get_post_meta( $order_id, $prefix . 'tran_to', true  );
	$tran_to = !empty( $tran_to ) ? $tran_to : array();
		
	//get total words
	$total_words = lt_get_total_words();
	
	//get translate level
	$translate_level = get_post_meta( $order_id, $prefix . 'translate_level', true  );
	$translate_level = !empty( $translate_level ) ? $translate_level : 'standard';
	
	ob_start();
	?>
	<?php
		if( !empty( $tran_from ) ) {
		    
		    $meta       = get_post_meta( $tran_from, $prefix . 'offer_lang', true  );
		    $all_prices = get_post_meta( $tran_from, $prefix . 'lang_conv_price', true  );
		
		    if( !empty( $meta ) ) {
		        $total_price = $grand_total  = 0;
		?>
		        <table border="1" width="100%" cellpadding="5" cellspacing="0" class="language_cart <?php echo $translate_to_details_class ?>">
		            <tbody>
		            	<tr>
		                    <td colspan="4"><strong><?php echo __( 'Translate below languages from ' ) . get_the_title( $tran_from ) . __( ' language', 'langtrans' ) ?></strong></td>
		                </tr>
		            	<tr>
		                    <td><strong><?php _e( 'Language', 'langtrans' ) ?></strong></td>
		                    <td><strong><?php _e( 'Price / word', 'langtrans' ) ?></strong></td>
		                    <td><strong><?php _e( 'Total Words', 'langtrans' ) ?></strong></td>
		                    <td><strong><?php _e( 'Total Price', 'langtrans' ) ?></strong></td>
		                </tr>
		<?php
		        $total_languag = $grand_total = 0;
		        foreach( $meta as $meta_key => $meta_value ) {
		
		        if( in_array( $meta_value, $tran_to ) ) {
		                
		            $lang_prices = !empty( $all_prices[$meta_value] ) ? $all_prices[$meta_value] : array();
		            $price = !empty( $lang_prices[$translate_level] ) ? $lang_prices[$translate_level] : 0;
		            
                            //modified price
                            $price = apply_filters( 'lt_get_price', $price );

		            $land_total = ( $price * $total_words );
		            $grand_total += $land_total;
		            $total_languag++;
		?>              
		                <tr>
		                    <td><?php echo get_the_title( $meta_value ) ?></td>
		                    <td><?php echo LT_CURRENCY_SYMBOL . $price . __( ' / word', 'langtrans' ) ?></td>
		                    <td>
		                        <?php _e( 'x ', 'langtrans' ) ?>
		                        <span class="lt-grand-total-words"><?php echo $total_words ?></span>
		                        <span class="lt-total-words-label"><?php _e( ' words', 'langtrans' ) ?></span>
		                    </td>
		                    <td><?php echo LT_CURRENCY_SYMBOL . $land_total ?></td>
		                </tr>
		<?php } } ?>
		            </tbody>
		            <tfoot>
		                <tr>
		                    <td colspan="3" align="left"><strong><span><?php echo $total_languag ?></span><?php _e( ' Language', 'langtrans' ) ?></strong></td>
		                    <td><strong><?php echo LT_CURRENCY_SYMBOL . $grand_total ?></strong></td>
		                </tr>
		            </tfoot>
		        </table>
		<?php } } ?>
	<?php
	$quotation_html = ob_get_clean();
	
	$message        = str_replace( '{order_id}', $order_id, $message );
	$user_message   = str_replace( '{order_id}', $order_id, $user_message );
        
	$message        = str_replace( '{quotation}', $quotation_html, $message );
	$user_message   = str_replace( '{quotation}', $quotation_html, $user_message );
        
        //send email
        wp_mail( $email_to, $email_subject, $message, $headers );
        $result = wp_mail( $user_email, $user_email_subject, $user_message, $user_headers );
        if( $result ) {
            
            //update order as a completed
            wp_update_post( array( 'ID' => $order_id, 'post_status' => 'publish' ) );
            
	    //clear cookie
	    lt_remove_order_cookie();
	    lt_remove_currency_cookie();
        }
        exit;
    }
}

/**
 * On an early action hook, check if the hook is scheduled - if not, schedule it.
 */
function lt_set_schedule_event() {
	if ( ! wp_next_scheduled( 'lt_open_exchange_rates' ) ) {
		wp_schedule_event( time(), 'hourly', 'lt_open_exchange_rates');
	}
}

/**
 * On the scheduled action hook, run a function.
 */
function lt_get_open_exchange_rates() {
	
	global $lt_options;
	
	$base_currency = isset( $lt_options['currency_base'] ) ? $lt_options['currency_base'] : LT_DEFAULT_CURRENCY_CODE;
	if( !empty( $lt_options['open_exchange_key'] ) && trim( $lt_options['open_exchange_key'] ) != '' ) {
	
		$open_exchange_url = add_query_arg( array( 'app_id' => $lt_options['open_exchange_key'] ), LT_OPEN_EXCHANGE_API_URL );
		$result = wp_remote_get( $open_exchange_url );
		if( !is_wp_error( $result ) && !is_wp_error( $result['body'] ) ) {
			
			$exchange_data = json_decode( $result['body'] );
			$exchange_data = lt_object_to_array( $exchange_data );
			
			//update open exchange data
			update_option( 'lt_open_exchange_data', $exchange_data );
		}
	}
}

/**
 * Change Price based on currency
 */
function lt_change_price( $price ) {
    
    $base_currency = LT_DEFAULT_CURRENCY_CODE;
    
    //get selected currency code
    $selected_currency_code = lt_get_currency_cookie();
    
    //open exchange rates
    $rates = lt_get_open_exchange_rate();

    $base_currency_rate = isset( $rates[$base_currency] ) ? $rates[$base_currency] : 1;
    $choosen_currency_rate = isset( $rates[$selected_currency_code] ) ? $rates[$selected_currency_code] : 1;
    
    $price = ( ( $price / $base_currency_rate ) * $choosen_currency_rate );
    $price = number_format( $price, 2 );
    
    return $price;
}

add_action( 'wp', 'lt_set_schedule_event' );
add_action( 'lt_open_exchange_rates', 'lt_get_open_exchange_rates' );

//template loader
add_filter( 'template_include', 'lt_load_template' );

//add action to process for translate order
add_action( 'wp', 'lt_translate_order_process' );

//add action to load offer laguages for partucular language
add_action( 'wp_ajax_lt_load_offer_languages', 'lt_load_offer_languages' );
add_action( 'wp_ajax_nopriv_lt_load_offer_languages', 'lt_load_offer_languages' );

//add action to add text into file meta
add_action( 'wp_ajax_lt_add_text', 'lt_add_text' );
add_action( 'wp_ajax_nopriv_lt_add_text', 'lt_add_text' );

//add action to clear order file meta
add_action( 'wp_ajax_lt_clear_file_meta', 'lt_clear_file_meta' );
add_action( 'wp_ajax_nopriv_lt_clear_file_meta', 'lt_clear_file_meta' );

//add action to clear order language meta
add_action( 'wp_ajax_lt_clear_lang_meta', 'lt_clear_lang_meta' );
add_action( 'wp_ajax_nopriv_lt_clear_lang_meta', 'lt_clear_lang_meta' );

//add action to add order languages meta
add_action( 'wp_ajax_lt_add_languages', 'lt_add_languages' );
add_action( 'wp_ajax_nopriv_lt_add_languages', 'lt_add_languages' );

//add action for get translation level
add_action( 'wp_ajax_lt_translate_level', 'lt_translate_level' );
add_action( 'wp_ajax_nopriv_lt_translate_level', 'lt_translate_level' );

//add action for change currecy code
add_action( 'wp_ajax_lt_change_currency', 'lt_change_currency' );
add_action( 'wp_ajax_nopriv_lt_change_currency', 'lt_change_currency' );

//add action for send email to admin
add_action( 'wp_ajax_lt_send_email', 'lt_send_email' );
add_action( 'wp_ajax_nopriv_lt_send_email', 'lt_send_email' );

//add filter for alter price
add_filter( 'lt_get_price', 'lt_change_price' );
?>