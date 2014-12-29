<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

    $lt_set_pages = get_option( 'lt_set_pages' );

    foreach ($lt_set_pages as $page_id) {
        wp_delete_post( $page_id, true );
    }
    
    delete_option( 'lt_open_exchange_data' );
    delete_option( 'lt_options' );
    delete_option( 'lt_set_pages' );
    delete_option( 'lt_set_option' );

?>