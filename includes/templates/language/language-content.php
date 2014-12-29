<?php 

/**
 * Template For Language Content
 * 
 * Handles to return for language content
 * 
 * Override this template by copying it to yourtheme/language-translate/language/language-content.php
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

global $post, $post_type, $lt_options;

$order_page_id     = !empty( $lt_options['order_page'] ) ? $lt_options['order_page'] : '' ;
$language_page_id  = !empty( $lt_options['order_language_page'] ) ? $lt_options['order_language_page'] : '' ;
$optional_page_id  = !empty( $lt_options['order_optional_page'] ) ? $lt_options['order_optional_page'] : '' ;

$prefix = LT_META_PREFIX;

//get order id
$order_id = lt_get_order_cookie();

//get selected langs
$tran_from = get_post_meta( $order_id, $prefix . 'tran_from', true  );
$tran_to = get_post_meta( $order_id, $prefix . 'tran_to', true  );
$tran_to = !empty( $tran_to ) ? $tran_to : array();

$translate_to_btn_class = !empty( $tran_to ) ? ' lt-display-none ' : '';
$translate_to_details_class = !empty( $tran_to ) ? '' : ' lt-display-none ';

//get total words
$total_words = lt_get_total_words();

//get translate level
$translate_level = get_post_meta( $order_id, $prefix . 'translate_level', true  );
$translate_level = !empty( $translate_level ) ? $translate_level : 'standard';

$trans_to_html = '';
if( !empty( $tran_from ) ) {
    
    $meta = get_post_meta( $tran_from, $prefix . 'offer_lang', true  );

    if( !empty( $meta ) ) {

        foreach( $meta as $meta_value ) {

            $selected_class = in_array( $meta_value, $tran_to ) ? ' checked_lang ' : '';

            $trans_to_html .= '<li data-offer-value="' . $meta_value . '" class="' . $selected_class . '"> 
                    <i class="fa fa-check check_text"></i>
                    <span class="language_name">' . get_the_title( $meta_value ) . '</span>
                </li>'; 
        }
    }
}

$args = array(
                'post_type' => LT_CONV_POST_TYPE,
                'posts_per_page' => -1,
                'post_status'   => 'publish'
             );

$posts = get_posts( $args ); 

?>

<div class="orderform">
    <div class="orderform_box">

	<?php if( !empty( $lt_options['language_from'] ) ) { ?>
        	<h3><?php echo $lt_options['language_from'] ?></h3>
	<?php } ?>

        <select class="selectpicker lt-translate-from" name="lt-translate-from">
            <option value=""><?php _e( 'Choose Languages', 'langtrans' ) ?></option>
            <?php foreach($posts as $post): ?>
                  <option value="<?php echo $post->ID; ?>" <?php selected( $post->ID, $tran_from ) ?>><?php echo $post->post_title; ?></option>
            <?php endforeach; ?>
        </select>

	<?php if( !empty( $lt_options['language_to'] ) ) { ?>
        	<h3 class="lt-clear"><?php echo $lt_options['language_to'] ?></h3>
	<?php } ?>

        <button class="select_btn lt-translate-to-btn <?php echo $translate_to_btn_class ?>" type="button" data-toggle="modal" data-target=".model_box"><?php _e( 'Choose languages', 'langtrans' ) ?><span class="pull-right fa fa-angle-down"></span></button>

        <div class="modal fade model_box languageselect_model" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <h3><?php _e( 'Choose Languages', 'langtrans' ) ?></h3>
                    <ul class="language_select lt-translate-to">
                        <?php echo $trans_to_html ?>
                    </ul>
                    <div class="orderbot_cont">
                        <span class="support_text"><?php echo $lt_options['language_support'] ?></span>
                        <div class="pull-right">
                            <button id="lt_add_lnaguage_btn" class="nextbtn" type="button"><?php _e( 'Add Language', 'langtrans' ) ?></button>
                            <a href="#" data-dismiss="modal" class="cancle_link"><?php _e( 'Cancel', 'langtrans' ) ?></a>
                        </div>
                    </div>
                    <br class="clear">
                </div>
            </div>
        </div>
        
<?php
if( !empty( $tran_from ) ) {
    
    $meta       = get_post_meta( $tran_from, $prefix . 'offer_lang', true  );
    $all_prices = get_post_meta( $tran_from, $prefix . 'lang_conv_price', true  );

    if( !empty( $meta ) ) {
        $total_price = 0;
?>
        <a href="javascript:void(0);" class="ClearAll_link ClearAll_lang <?php echo $translate_to_details_class ?>"><?php _e( 'Clear all languages', 'langtrans' ) ?></a>

        <table width="100%" cellpadding="0" cellspacing="0" class="language_cart <?php echo $translate_to_details_class ?>">
            <tbody>
<?php
        $total_languag = $grand_total = 0;
        foreach( $meta as $meta_key => $meta_value ) {

        if( in_array( $meta_value, $tran_to ) ) {
                
            $selected_class = in_array( $meta_value, $tran_to ) ? ' checked_lang ' : '';
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
                <tr>
                    <td colspan="3">
                        <a href="javascript:void(0);" class="color_link" data-toggle="modal" data-target=".model_box"><?php _e( '+ Add more Languages', 'langtrans' ) ?></a>
                    </td>
                    <td></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" align="left"><span><?php echo $total_languag ?></span><?php _e( ' Language', 'langtrans' ) ?></th>
                    <th><?php echo LT_CURRENCY_SYMBOL . $grand_total ?></th>
                </tr>
            </tfoot>
        </table>
<?php } } ?>
                
    </div><!--orderform_box end-->

    <a href="<?php echo get_permalink( $order_page_id ) ?>" class="color_link pull-left support_text">&laquo;<?php _e( ' Back to items', 'langtrans' ) ?></a>
    <button id="lt_next_options_btn" class="nextbtn pull-right" type="button"><?php _e( 'Next: Options', 'langtrans' ) ?></button>

</div>
<?php
    //reset query
    wp_reset_query();
?>