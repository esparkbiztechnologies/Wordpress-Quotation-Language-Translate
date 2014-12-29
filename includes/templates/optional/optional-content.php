<?php 

/**
 * Template For Language Content
 * 
 * Handles to return for language content
 * 
 * Override this template by copying it to yourtheme/language-translate/optional/optional-content.php
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

global $lt_options;

$order_page_id     = !empty( $lt_options['order_page'] ) ? $lt_options['order_page'] : '' ;
$language_page_id  = !empty( $lt_options['order_language_page'] ) ? $lt_options['order_language_page'] : '' ;
$optional_page_id  = !empty( $lt_options['order_optional_page'] ) ? $lt_options['order_optional_page'] : '' ;

$prefix = LT_META_PREFIX;

//get order id
$order_id = lt_get_order_cookie();

//get translate level
$trans_level = get_post_meta( $order_id, $prefix . 'translate_level', true );

$standard = ($trans_level == "standard") ? 'checked="checked"' : '';
$business = ($trans_level == "business") ? 'checked="checked"' : '';
$ultra = ($trans_level == "ultra") ? 'checked="checked"' : '';
?>
<div class="orderform">
      <div class="orderform_box">

	<?php if( !empty( $lt_options['quotation_title'] ) ) { ?>
	        <h3><?php echo $lt_options['quotation_title'] ?></h3>
	<?php } ?>
         
	<?php if( !empty( $lt_options['quotation_desc'] ) ) { ?>
	        <p><?php echo nl2br( $lt_options['quotation_desc'] ) ?></p>
	<?php } ?>
         
<div class="quality_boxes">
<div class="quality_box">
  <label class="radio">
      <input type="radio" name="level" id="level" value="standard" <?php if(!empty($standard)){ echo $standard; }else{ ?>checked="checked" <?php } ?>>
    STANDARD </label>
  <p class="description">Fast translation by native speakers</p>
  <p>Best For:</p>
  <ul>
    <li>- Everyday content</li>
    <li>- User reviews</li>
    <li>- Product descriptions</li>
  </ul>
  
</div>
<div class="quality_box recomended_box">
<span class="qualitycorner_tag"></span>
  <label class="radio">
      <input type="radio" value="business" name="level" id="level" <?php echo $business; ?> >
    BUSINESS </label>
  <p class="description">Professional quality translation</p>
  <p>Best For:</p>
  <ul>
    <li>- App or web localization</li>
    <li>- Smartphone games</li>
    <li>- Web marketing pages</li>
  </ul>
  
</div>
<div class="quality_box">
  <label class="radio">
      <input type="radio" value="ultra" name="level" id="level" <?php echo $ultra; ?> >
    ULTRA </label>
  <p class="description">Professional plus extra proofreading</p>
  <p>Best For:</p>
  <ul>
    <li>- Media content</li>
    <li>- Posters</li>
    <li>- Marketing</li>
  </ul>
  
</div>

 </div>
 
      </div>
      <!--orderform_box end-->
      
      <a href="<?php echo get_permalink( $language_page_id ) ?>" class="color_link pull-left support_text">&laquo;<?php _e( ' Back to languages', 'langtrans' ) ?></a>
       
  </div>