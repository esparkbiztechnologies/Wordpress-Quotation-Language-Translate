<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Settings Page
 *
 * The code for the plugins main settings page
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

$prefix = LT_META_PREFIX;
$headding =  !empty( $_GET['post_id'] ) ? __( ' for ', 'langtrans' ) . get_the_title( $_GET['post_id'] ) : '';

 ?>

<div class="wrap">
    
    <h2><?php echo __( 'Conversation Price', 'langtrans' ) . $headding; ?></h2>
    
    <!-- beginning of the conv price meta box -->
    <div id="lt_conv_price" class="post-box-container">
        <div class="metabox-holder">	
            <div class="meta-box-sortables ui-sortable">
                <div id="conv_price" class="postbox">

                    <!-- conv price box title -->
                    <h3 class="hndle">
                        <span style='vertical-align: top;'><?php _e( 'Price Settings', 'langtrans' ); ?></span>
                    </h3>

                    <div class="inside">

                        <?php 
                            if( !empty( $_GET['post_id'] ) ) {
                                
                                $conv_id = $_GET['post_id'];
                                
                                $offer_lang_meta= get_post_meta( $conv_id, $prefix.'offer_lang', true );
                                $lang_conv      = get_post_meta( $conv_id, $prefix.'lang_conv_price', true );
                                
                                if( !empty( $offer_lang_meta ) ) {
                        ?>
                        
                            <form action="" method="POST">
                                <table class="form-table lt-form-table">
                                    <tbody>
                                        <tr>
                                            <td><strong><?php _e( 'Offer Language', 'langtrans' ); ?></strong></td>
                                            <td><strong><?php _e( 'Standard Price', 'langtrans' ); ?></strong></td>
                                            <td><strong><?php _e( 'Business Price', 'langtrans' ); ?></strong></td>
                                            <td><strong><?php _e( 'Ultra Price', 'langtrans' ); ?></strong></td>
                                        </tr>
                                        <?php
                                            foreach ( $offer_lang_meta as $offer_lang_id ) {

                                                $standard_price = isset( $lang_conv[$offer_lang_id] ) && isset( $lang_conv[$offer_lang_id]['standard'] ) ? $lang_conv[$offer_lang_id]['standard'] : '';
                                                $business_price = isset( $lang_conv[$offer_lang_id] ) && isset( $lang_conv[$offer_lang_id]['business'] ) ? $lang_conv[$offer_lang_id]['business'] : '';
                                                $ultra_price    = isset( $lang_conv[$offer_lang_id] ) && isset( $lang_conv[$offer_lang_id]['ultra'] ) ? $lang_conv[$offer_lang_id]['ultra'] : '';
                                        ?>
                                                <tr>
                                                    <td>
                                                        <?php echo get_the_title( $offer_lang_id ) ?>
                                                        <input type="hidden" name="<?php echo $prefix ?>lang_conv_price[<?php echo $offer_lang_id ?>][lang_id]" value="<?php echo $offer_lang_id ?>" />
                                                    </td>
                                                    <td>
                                                        $ <input type="text" name="<?php echo $prefix ?>lang_conv_price[<?php echo $offer_lang_id ?>][standard]" value="<?php echo $standard_price ?>" />
                                                    </td>
                                                    <td>
                                                        $ <input type="text" name="<?php echo $prefix ?>lang_conv_price[<?php echo $offer_lang_id ?>][business]" value="<?php echo $business_price ?>" />
                                                    </td>
                                                    <td>
                                                        $ <input type="text" name="<?php echo $prefix ?>lang_conv_price[<?php echo $offer_lang_id ?>][ultra]" value="<?php echo $ultra_price ?>" />
                                                    </td>
                                                </tr>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="4">
                                                <input type="hidden" name="lt_conv_id" value="<?php echo $conv_id ?>" />
                                                <input type="submit" class="button-primary" name="lt_save_conv_price" value="<?php _e( 'Save Price', 'langtrans' ) ?>" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        <?php
                                }
                            } else {

                                _e( 'Please open proper link!', 'langtrans' );
                            }
                        ?>
                        
                    </div><!-- .inside -->
                </div><!-- #conv_price -->
            </div><!-- .meta-box-sortables ui-sortable -->
	</div><!-- .metabox-holder -->
    </div><!-- #lt_conv_price -->
</div>