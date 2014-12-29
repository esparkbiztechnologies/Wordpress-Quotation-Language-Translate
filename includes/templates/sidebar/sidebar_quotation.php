<?php 

/**
 * Template For Order Content
 * 
 * Handles to return for order content
 * 
 * Override this template by copying it to yourtheme/language-translate/sidebar/sidebar_quotation.php
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$grand_total = 0;

?>

<div id="quote_summary_section" class="gdlr-item-title-wrapper  pos-no-caption">

    <h3 class="gdlr-item-title gdlr-skin-title gdlr-skin-border"><?php echo $title ?></h3>

    <?php if( !empty( $curencies ) ) { ?>
        <select id="lt_change_currency" name="lt_change_currency" class="selectpicker lt-change-currency">
        <?php foreach ($curencies as $code => $currency) { ?>
            <option value="<?php echo $code ?>" <?php selected( $selected_currency, $code ) ?>><?php echo $currency ?></option>
        <?php } ?>
        </select>
    <?php } ?>
    
    <table width="100%" class="orderform_table">
        <tbody>
            <tr>
                <td width="15"><i class="fa fa-circle dot_text <?php echo ( $post_id == $order_page_id ) ? 'green_text' : '' ?>"></i></td>
                <td width="123">
                    <a href="<?php echo get_permalink( $order_page_id ) ?>">
                        <?php echo $total_items . __( ' items', 'langtrans' ) ?>
                    </a>
                </td>
                <td width="118" >
                    <span class="lt-grand-total-words"><?php echo $total_words ?></span>
                    <span class="lt-total-words-label"><?php _e( ' words', 'langtrans' ) ?></span>
                    <a href="#" class="edit_link"><?php _e( ' Edit', 'langtrans' ) ?></a>
                </td>
            </tr>
            <tr>
                <td><i class="fa fa-circle dot_text <?php echo ( $post_id == $language_page_id ) ? 'green_text' : '' ?>"></i></td>
                <td>
                    <a href="<?php echo get_permalink( $language_page_id ) ?>">
                        <?php _e( 'Choose languages', 'langtrans' ) ?>
                    </a>
                </td>
                <td>
                    <?php echo $total_languages ?>
                    <a href="#" class="edit_link"><?php _e( ' Edit', 'langtrans' ) ?></a>
                </td>
            </tr>
            <tr>
                <td><i class="fa fa-circle dot_text <?php echo ( $post_id == $optional_page_id ) ? 'green_text' : '' ?>"></i></td>
                <td>
                    <a href="<?php echo get_permalink( $optional_page_id ) ?>">
                        <?php _e( 'Choose quality level', 'langtrans' ) ?>
                    </a>
                </td>
                <td></td>
            </tr>
            <?php
                if( !empty( $tran_from ) ) {

                    $meta       = get_post_meta( $tran_from, $prefix . 'offer_lang', true  );
                    $all_prices = get_post_meta( $tran_from, $prefix . 'lang_conv_price', true  );

                    if( !empty( $meta ) ) {
                        $total_price = $total_languag = 0;
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
                                    <td></td>
                                    <td>
                                        <?php echo get_the_title( $meta_value ) ?> - 
                                        <?php echo LT_CURRENCY_SYMBOL . $price . __( ' / word', 'langtrans' ) ?>
                                    </td>
                                    <td><?php echo LT_CURRENCY_SYMBOL . $land_total ?></td>
                                </tr>
                <?php } } ?>
                <?php } } ?>
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th><?php _e( 'Total', 'langtrans' ) ?></th>
                <th><span class="lt-grand-total"><?php echo LT_CURRENCY_SYMBOL . $grand_total ?></span></th>
            </tr>
        </tfoot>
    </table>

<?php if( is_page( $optional_page_id ) ) { ?>
    <p class="eta-text">
        <?php echo $lt_options['quotation_tooltip_title'] ?>
        <a href="javascript:void(0);" class="fa fa-info-circle popoverlink" data-placement="top" data-toggle="popover" data-content="<?php echo nl2br( $lt_options['quotation_tooltip_desc'] ) ?>"></a>
    </p>
    <p>
        <input type="email" name="lt_user_email" id="lt_user_email" value="" placeholder="<?php _e( 'Email', 'langtrans' ) ?>">
    </p>
    <p>
        <input type="checkbox" name="lt_term_condition" id="lt_term_condition">
        <label for="lt_term_condition"><?php echo $lt_options['agree_terms'] ?></label>
    </p>
    <button class="confirm_btn" type="button"><?php _e( 'Send Email', 'langtrans' ) ?></button>
<?php } ?>
</div>