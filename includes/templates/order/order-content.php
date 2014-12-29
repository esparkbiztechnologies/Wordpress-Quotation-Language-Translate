<?php 

/**
 * Template For Order Content
 * 
 * Handles to return for order content
 * 
 * Override this template by copying it to yourtheme/language-translate/order/order-content.php
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

global $lt_options;

$total_words = 0;

$prefix = LT_META_PREFIX;

//get order id
$order_id = lt_get_order_cookie();

//get file data
$file_data = get_post_meta( $order_id, $prefix . 'file_data', true );

$total_items = count( $file_data );
$heading_text = !empty( $file_data ) ? $total_items . __( ' items to translate', 'langtrans' ) :  $lt_options['order_title'];
?>

<div class="orderform">

    <div class="orderform_box">

	<?php if( !empty( $heading_text ) ) { ?>
	        <h3><?php echo $heading_text ?></h3>
	<?php } ?>
        
        <?php if( empty( $file_data ) ) { ?>
        
        <div class="orderform_btextarea">
          <textarea rows="9"></textarea>
          <div class="orderform_bTypebox"><?php _e( 'Type or paste your text here, or', 'langtrans' ) ?>
            <div class="browse_btn">
                <form id="lt_file_upload_form1" class="lt-file-upload-form" enctype="multipart/form-data" method="POST">
                    <span class="browse_text"><?php _e( 'Upload File', 'langtrans' ) ?></span>
                    <input type="file" name="lt_file_upload" class="lt-file-upload" >
                </form>
            </div>
          </div>
        </div><!--orderform_btextarea end-->
 
        <div class="wordcount_text text-wordcount-row"> 
            <a href="javascript:void(0);" class="color_link"><?php _e( 'Cancel', 'langtrans' ) ?></a>
            <span class="pull-right">
                <span class="lt-text-total-words">0</span>
                <span class="lt-grand-total-words-label"><?php echo __( ' words', 'langtrans' ) ?></span>
            </span>
        </div>
        
        <?php } else if( !empty( $file_data ) ) { ?>
            
            <a href="javascript:void(0);" class="ClearAll_link ClearAll_items"><?php _e( 'Clear All Items', 'langtrans' ) ?></a>
        
            <table width="100%" cellpadding="0" cellspacing="0" class="counttable">
              <tbody>
            <?php
                $file_icon = '';
                foreach ( $file_data as $file_key => $file_value ) {

                    if( isset( $file_value['method'] ) && $file_value['method'] == 'file' ) {
                        
                        $file_path = lt_get_absulate_path( $file_value['url'] );

                        if( empty( $file_path ) && !is_file( $file_path ) ) {
                            
                            continue;
                            
                        } else {
                            
                            // read into string
                            $str = file_get_contents( $file_path );
                            
                            $file_name = basename( $file_path );
                            $file_icon = 'flaticon-txt2';
                        }
                        
                    } else {
                        
                        $str = isset( $file_value['content'] ) ? $file_value['content'] : '';
                        
                        $file_name = $str;
                        $file_icon = 'flaticon-documents7';
                    }
                    
                    $numWords = str_word_count($str);
                    $total_words += $numWords;
                    ?>
                  
                        <tr>
                          <td><i class="flaticon <?php echo $file_icon ?>"></i></td>
                          <td><?php echo $file_name ?></td>
                          <td align="right">
                              <strong>
                                    <span class="lt-total-words"><?php echo $numWords ?></span>
                                    <span class="lt-total-words-label"><?php echo __( ' words', 'langtrans' ) ?></span>
                              </strong>
                          </td>
                          <td><a href="javascript:void(0);" class="lt-remove-file" data-file-key="<?php echo $file_key ?>"><?php echo 'X' ?></a></td>
                        </tr>

                  <?php
                }
            ?>
          </tbody>
          <tfoot>
            <tr>
              <td ><i class="flaticon-documents7"></i></td>
              <td>
                  <b>
                      <span class="total_item_count_text">
                      <?php echo $total_items ?></span><?php echo __( ' items', 'langtrans' ) ?>
                  </b>
              </td>
              <td align="right" colspan="2">
                  <strong>
                      <span class="lt-grand-total-words"><?php echo $total_words ?></span>
                      <span class="lt-total-words-label"><?php echo __( ' words', 'langtrans' ) ?></span>
                  </strong>
              </td>
            </tr>
          </tfoot>
        </table>
        
        <div class="addmore_cont" >
            <span href="#model_box" class="type_here_text" data-toggle="modal" data-target=".model_box">
                <?php _e( '+ To add more, click and type, or', 'langtrans' ) ?>
            </span>
            <div class="browse_btn">
                <input style="display:none" type="file" id="typefile" >
                <form id="lt_file_upload_form2" class="lt-file-upload-form" enctype="multipart/form-data" method="POST">
                    <span class="browse_text"><?php _e( 'Upload File', 'langtrans' ) ?></span>
                    <input type="file" name="lt_file_upload" class="lt-file-upload" >
                </form>
            </div>
        </div>
        
        <div class="modal fade model_box" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <textarea rows="9"></textarea>
              <div class="wordcount_text">

                <button class="nextbtn noncolor wordcount_btn" type="button"><?php _e( 'Done', 'langtrans' ) ?></button>
                <a href="#" data-dismiss="modal"><?php _e( 'Cancel', 'langtrans' ) ?></a>
                <span class="pull-right">
                    <span class="lt-text-total-words">0</span>
                    <span class="lt-grand-total-words-label"><?php echo __( ' words', 'langtrans' ) ?></span>
                </span> 
              </div>
              <p><a href="javascript:void(0);" class="fa fa-info-circle popoverlink" data-placement="top" data-toggle="popover" data-content='<?php echo nl2br( $lt_options['order_tooltip_desc'] ); ?>'></a> <?php echo $lt_options['order_tooltip_title']; ?></p>
            </div>
          </div>
        </div>
            
        <?php } if( empty( $file_data ) ) { ?>
        
        <div class="helper_text">
          <p><a href="javascript:void(0);" class="fa fa-info-circle popoverlink" data-placement="top" data-toggle="popover" data-content='<?php echo nl2br( $lt_options['order_tooltip_desc'] ); ?>'></a> <?php echo $lt_options['order_tooltip_title']; ?></p>
        </div>
      
      <?php } ?>
            
      </div><!--orderform_box end-->
      
      <button id="lt_choose_lnaguage_btn" class="nextbtn pull-right" type="button"><?php _e( 'Next: Choose languages', 'langtrans' ) ?></button>
      
  </div>