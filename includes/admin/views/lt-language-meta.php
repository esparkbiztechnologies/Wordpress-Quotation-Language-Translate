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

$lang_code = get_post_meta( $post_id, $prefix.'lang_code', true );

?>
<table class="form-table lt-form-table">
    
    <tr>
        <td>
            <label for="lt_lang_code"><?php _e( 'Language Code', 'langtrans' ) ?></label>
        </td>
        <td class="file-input-advanced">
            <input type="text" name="<?php echo $prefix; ?>lang_code" value="<?php echo $lang_code; ?>" class="small-text"/>
        </td>
    </tr>
    
</table><?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

