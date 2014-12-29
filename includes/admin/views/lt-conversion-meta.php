<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

global $post, $post_type;

$prefix = LT_META_PREFIX;

$post_id = $post->ID;

//get your custom posts ids as an array
$conv_args = array(
                        'post_type'     => LT_CONV_POST_TYPE,
                        'post_status'   => 'publish',
                        'posts_per_page'=> -1,
                        'fields'        => 'ids',
                        'post__not_in'  => array( $post_id ),
                        'meta_query'    => array(
                                                    array(
                                                            'key'       => $prefix.'lang',
                                                            'value'     => '',
                                                            'compare'   => '!='
                                                    )
                                                )
                    );
$conv_ids = get_posts( $conv_args );
$lang_ids = lt_get_lang_ids_by_conv_ids( $conv_ids );

//get your custom posts ids as an array
$lnag_args = array(
                        'post_type'     => LT_LANG_POST_TYPE,
                        'post_status'   => 'publish',
                        'posts_per_page'=> -1,
                        'exclude'       => $lang_ids
                    );
$languages = get_posts( $lnag_args );

//get your custom posts ids as an array
$offer_lnag_args = array(
                        'post_type'     => LT_LANG_POST_TYPE,
                        'post_status'   => 'publish',
                        'posts_per_page'=> -1
                    );
$offer_languages = get_posts( $offer_lnag_args );

$lang_meta          = get_post_meta($post_id, $prefix.'lang', true);
$offer_lang_meta    = get_post_meta($post_id, $prefix.'offer_lang', true);
$offer_lang_meta    = !empty( $offer_lang_meta ) ? $offer_lang_meta : array();

?>
<table class="form-table lt-form-table">
    
    <tr>
        <td>
            <label for="lt_lang_to"><?php _e( 'Select Language', 'langtrans' ) ?></label>
        </td>
        <td class="file-input-advanced">
            
            <select name="<?php echo $prefix; ?>lang" id="lt-from-lang">
                <option value="">--<?php _e( 'Select', 'langtrans' ) ?>--</option>
              <?php  foreach($languages as $lang){ ?>
                <option value="<?php echo $lang->ID; ?>" <?php selected( $lang_meta, $lang->ID ) ?>><?php echo $lang->post_title; ?></option>
              <?php } ?>
            </select>
            
            </form>
        </td>
    </tr>
    <tr>
        <td>
    <lable for="lt_lang_from"><?php _e( 'Offer Languages', 'langtrans' ) ?></lable>
        </td>
        <td>
             <?php 
                foreach( $offer_languages as $lang ) {
                    $lt_offer_lang_wrap_class = ( $lang_meta == $lang->ID ) ? ' lt-display-none ' : '';
             ?>
                <span id="<?php echo $lang->ID; ?>" class="lt-offer-lang-span <?php echo $lt_offer_lang_wrap_class ?>">
                    
                    <input type="checkbox" id="lt_offer_lang_<?php echo $lang->ID; ?>" name="<?php echo $prefix; ?>offer_lang[]" value="<?php echo $lang->ID; ?>" <?php checked( in_array( $lang->ID, $offer_lang_meta ), true ) ?>>
                    <label for="lt_offer_lang_<?php echo $lang->ID; ?>"><?php echo get_the_title( $lang->ID ); ?></label>
                    
                </span>
            
            <?php } ?>   
        </td>
    </tr>
    
</table>