<?php

/**
 * Settings Page
 * Handles to settings
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

global $lt_options;

//get all pages					
$get_pages = get_pages();

function lt_admin_tabs( $current = 'pages' ) {
    
    $tabs = array( 
                    'lt_tab_pages'         => __( 'Pages', 'langtrans' ),
                    'lt_tab_order'         => __( 'Order', 'langtrans' ),
                    'lt_tab_language'      => __( 'Language', 'langtrans' ),
                    'lt_tab_quatation'     => __( 'Quatation', 'langtrans' ),
                    'lt_tab_email'         => __( 'Eamil', 'langtrans' ),
                    'lt_tab_exchange_rate' => __( 'Exchange Rate', 'langtrans' )
                ); 
    $links = array();
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='#$tab'>$name</a>";
    }
    echo '</h2>';
}

?>
<div class="wrap">
    
    <h2><?php _e( 'Settings', 'langtrans' ); ?></h2>
    
    <!-- beginning of the settings meta box -->
    <div id="lt_settings" class="post-box-container">
        <div class="metabox-holder">	
            <div class="meta-box-sortables ui-sortable">
                <div id="settings" class="postbox">

                    <!-- settings box title
                    <h3 class="hndle">
                        <span style='vertical-align: top;'><?php _e( 'Settings', 'langtrans' ); ?></span>
                    </h3>
                    -->
                    
                    <div class="inside">

                        <?php echo lt_admin_tabs() ?>

                        <form action="options.php" method="POST">

                            <?php settings_fields( 'lt_plugin_options' ); ?>

                            <div class="lt-content">

                                <div class="lt-tab-content" id="lt_tab_pages">

                                    <table class="form-table lt-form-table">

                                        <!-- Page Settings Start -->
                                        <tr>
                                            <td colspan="2" valign="top" scope="row">
                                                <strong><?php _e( 'Pages Settings', 'langtrans' ); ?></strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                <label for="lt_options[order_page]"><?php _e( 'Order Page:', 'langtrans' );?></label>
                                            </td>
                                            <td>
                                                <select id="lt_options[order_page]" name="lt_options[order_page]">
                                                    <option value=""><?php _e('--Select A Page--','langtrans');?></option>
                                                    <?php foreach ( $get_pages as $page ) { ?>
                                                        <option value="<?php echo $page->ID;?>" <?php selected( $page->ID, $lt_options['order_page'], true ); ?>><?php echo get_the_title( $page->ID );?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                <label for="lt_options[order_language_page]"><?php _e( 'Language Page:', 'langtrans' );?></label>
                                            </td>
                                            <td>
                                                <select id="lt_options[order_page]" name="lt_options[order_language_page]">
                                                    <option value=""><?php _e('--Select A Page--','langtrans');?></option>
                                                    <?php foreach ( $get_pages as $page ) { ?>
                                                        <option value="<?php echo $page->ID;?>" <?php selected( $page->ID, $lt_options['order_language_page'], true ); ?>><?php echo get_the_title( $page->ID );?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                <label for="lt_options[order_optional_page]"><?php _e( 'Optional Page:', 'langtrans' );?></label>
                                            </td>
                                            <td>
                                                <select id="lt_options[order_optional_page]" name="lt_options[order_optional_page]">
                                                    <option value=""><?php _e('--Select A Page--','langtrans');?></option>
                                                    <?php foreach ( $get_pages as $page ) { ?>
                                                        <option value="<?php echo $page->ID;?>" <?php selected( $page->ID, $lt_options['order_optional_page'], true ); ?>><?php echo get_the_title( $page->ID );?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                <label for="lt_options[order_thankyou_page]"><?php _e( 'Thank You Page:', 'langtrans' );?></label>
                                            </td>
                                            <td>
                                                <select id="lt_options[order_thankyou_page]" name="lt_options[order_thankyou_page]">
                                                    <option value=""><?php _e('--Select A Page--','langtrans');?></option>
                                                    <?php foreach ( $get_pages as $page ) { ?>
                                                        <option value="<?php echo $page->ID;?>" <?php selected( $page->ID, $lt_options['order_thankyou_page'], true ); ?>><?php echo get_the_title( $page->ID );?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <!-- Page Settings End -->
                                        
                                    </table>

                                </div>
                                <div class="lt-tab-content" id="lt_tab_order">

                                    <table class="form-table lt-form-table">

                                        <!-- Order Page Settings Start -->
                                        <tr>
                                            <td colspan="2" valign="top" scope="row">
                                                <strong><?php _e( 'Order Pages Settings', 'langtrans' ); ?></strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                <label for="lt_options[order_title]"><?php _e( 'Title:', 'langtrans' );  ?></label>
                                            </td>
                                            <td>
                                                <input type="text" name="lt_options[order_title]" id="lt_options[order_title]" class="regular-text" value="<?php echo isset( $lt_options['order_title'] ) ? $lt_options['order_title'] : '' ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                <label for="lt_options[order_tooltip_title]"><?php _e( 'Tooltip Title:', 'langtrans' );  ?></label>
                                            </td>
                                            <td>
                                                <input type="text" name="lt_options[order_tooltip_title]" id="lt_options[order_tooltip_title]" class="regular-text" value="<?php echo isset( $lt_options['order_tooltip_title'] ) ? $lt_options['order_tooltip_title'] : '' ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                <label for="lt_options[order_tooltip_desc]"><?php _e( 'Tooltip Description:', 'langtrans' );  ?></label>
                                            </td>
                                            <td>
                                                <textarea name="lt_options[order_tooltip_desc]" id="lt_options[order_tooltip_desc]" cols="37" rows="4"><?php echo isset( $lt_options['order_tooltip_desc'] ) ? $lt_options['order_tooltip_desc'] : '' ?></textarea>
                                            </td>
                                        </tr>
                                        <!-- Order Page Settings End -->
                                        
                                    </table>

                                </div>
                                <div class="lt-tab-content" id="lt_tab_language">

                                    <table class="form-table lt-form-table">

                                        <!-- Language Page Settings Start -->
                                        <tr>
                                            <td colspan="2" valign="top" scope="row">
                                                <strong><?php _e( 'Language Pages Settings', 'langtrans' ); ?></strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                <label for="lt_options[language_from]"><?php _e( 'Language From:', 'langtrans' );  ?></label>
                                            </td>
                                            <td>
                                                <input type="text" name="lt_options[language_from]" id="lt_options[language_from]" class="regular-text" value="<?php echo isset( $lt_options['language_from'] ) ? $lt_options['language_from'] : '' ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                <label for="lt_options[language_to]"><?php _e( 'Language To:', 'langtrans' );  ?></label>
                                            </td>
                                            <td>
                                                <input type="text" name="lt_options[language_to]" id="lt_options[language_to]" class="regular-text" value="<?php echo isset( $lt_options['language_to'] ) ? $lt_options['language_to'] : '' ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                <label for="lt_options[language_support]"><?php _e( 'Language Support:', 'langtrans' );  ?></label>
                                            </td>
                                            <td>
                                                <input type="text" name="lt_options[language_support]" id="lt_options[language_support]" class="regular-text" value="<?php echo isset( $lt_options['language_support'] ) ? $lt_options['language_support'] : '' ?>">
                                            </td>
                                        </tr>
                                        <!-- Language Page Settings End -->
                                        
                                    </table>

                                </div>
                                <div class="lt-tab-content" id="lt_tab_quatation">

                                    <table class="form-table lt-form-table">

                                        <!-- Quotation Page Settings Start -->
                                        <tr>
                                            <td colspan="2" valign="top" scope="row">
                                                <strong><?php _e( 'Quotation Pages Settings', 'langtrans' ); ?></strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                <label for="lt_options[quotation_title]"><?php _e( 'Title:', 'langtrans' );  ?></label>
                                            </td>
                                            <td>
                                                <input type="text" name="lt_options[quotation_title]" id="lt_options[quotation_title]" class="regular-text" value="<?php echo isset( $lt_options['quotation_title'] ) ? $lt_options['quotation_title'] : '' ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                <label for="lt_options[quotation_desc]"><?php _e( 'Description:', 'langtrans' );  ?></label>
                                            </td>
                                            <td>
                                                <textarea name="lt_options[quotation_desc]" id="lt_options[quotation_desc]" cols="37" rows="4"><?php echo isset( $lt_options['quotation_desc'] ) ? $lt_options['quotation_desc'] : '' ?></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                <label for="lt_options[quotation_tooltip_title]"><?php _e( 'Tooltip Title:', 'langtrans' );  ?></label>
                                            </td>
                                            <td>
                                                <input type="text" name="lt_options[quotation_tooltip_title]" id="lt_options[quotation_tooltip_title]" class="regular-text" value="<?php echo isset( $lt_options['quotation_tooltip_title'] ) ? $lt_options['quotation_tooltip_title'] : '' ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                <label for="lt_options[quotation_tooltip_desc]"><?php _e( 'Tooltip Description:', 'langtrans' );  ?></label>
                                            </td>
                                            <td>
                                                <textarea name="lt_options[quotation_tooltip_desc]" id="lt_options[quotation_tooltip_desc]" cols="37" rows="4"><?php echo isset( $lt_options['quotation_tooltip_desc'] ) ? $lt_options['quotation_tooltip_desc'] : '' ?></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                <label for="lt_options[agree_terms]"><?php _e( 'Terms & Condition Text:', 'langtrans' );  ?></label>
                                            </td>
                                            <td>
                                                <input type="text" name="lt_options[agree_terms]" id="lt_options[agree_terms]" class="regular-text" value="<?php echo isset( $lt_options['agree_terms'] ) ? $lt_options['agree_terms'] : '' ?>">
                                            </td>
                                        </tr>
                                        <!-- Quotation Page Settings End -->
                                        
                                    </table>

                                </div>
                                <div class="lt-tab-content" id="lt_tab_email">

                                    <table class="form-table lt-form-table">

                                        <!-- Email Settings Start -->
                                        <tr>
                                            <td colspan="2" valign="top" scope="row">
                                                <strong><?php _e( 'Email Settings', 'langtrans' ); ?></strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                <label for="lt_options[email_to]"><?php _e( 'Admin Email:', 'langtrans' );  ?></label>
                                            </td>
                                            <td>
                                                <input type="text" name="lt_options[email_to]" id="lt_options[email_to]" class="regular-text" value="<?php echo isset( $lt_options['email_to'] ) ? $lt_options['email_to'] : '' ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                <label for="lt_options[email_subject]"><?php _e( 'Admin Email Subject:', 'langtrans' );  ?></label>
                                            </td>
                                            <td>
                                                <input type="text" name="lt_options[email_subject]" id="lt_options[email_subject]" class="regular-text" value="<?php echo isset( $lt_options['email_subject'] ) ? $lt_options['email_subject'] : '' ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                <label for="lt_options[email_body]"><?php _e( 'Admin Email Body:', 'langtrans' );  ?></label>
                                            </td>
                                            <td>
                                                <textarea name="lt_options[email_body]" id="lt_options[email_body]" rows="4" cols="37"><?php echo isset( $lt_options['email_body'] ) ? $lt_options['email_body'] : '' ?></textarea><br/>
                                                <span class="description"><?php _e( 'Use shortcodes: <code>{order_id}</code> for display the order id,<br/> <code>{quatation}</code> for display the quatation details', 'langtrans' ) ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                <label for="lt_options[user_email_subject]"><?php _e( 'User Email Subject:', 'langtrans' );  ?></label>
                                            </td>
                                            <td>
                                                <input type="text" name="lt_options[user_email_subject]" id="lt_options[user_email_subject]" class="regular-text" value="<?php echo isset( $lt_options['user_email_subject'] ) ? $lt_options['user_email_subject'] : '' ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                <label for="lt_options[user_email_body]"><?php _e( 'User Email Body:', 'langtrans' );  ?></label>
                                            </td>
                                            <td>
                                                <textarea name="lt_options[user_email_body]" id="lt_options[user_email_body]" rows="4" cols="37"><?php echo isset( $lt_options['user_email_body'] ) ? $lt_options['user_email_body'] : '' ?></textarea><br/>
                                                <span class="description"><?php _e( 'Use shortcode: <code>{order_id}</code> for display the order id,<br/> <code>{quatation}</code> for display the quatation details', 'langtrans' ) ?></span>
                                            </td>
                                        </tr>
                                        <!-- Email Settings End-->
                                        
                                    </table>

                                </div>
                                <div class="lt-tab-content" id="lt_tab_exchange_rate">

                                    <table class="form-table lt-form-table">

                                        <!-- Open Exchange API Settings Start -->
                                        <tr>
                                            <td colspan="2" valign="top" scope="row">
                                                <strong><?php _e( 'Open Exchange API Settings', 'langtrans' ); ?></strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                <label for="lt_options[open_exchange_key]"><?php _e( 'API Key:', 'langtrans' );  ?></label>
                                            </td>
                                            <td>
                                                <input type="text" name="lt_options[open_exchange_key]" id="lt_options[open_exchange_key]" class="regular-text" value="<?php echo isset( $lt_options['open_exchange_key'] ) ? $lt_options['open_exchange_key'] : '' ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                <label for="lt_options[currency_base]"><?php _e( 'Base Currency:', 'langtrans' );  ?></label>
                                            </td>
                                            <td>
                                                <input type="text" name="lt_options[currency_base]" id="lt_options[currency_base]" class="small-text" value="<?php echo isset( $lt_options['currency_base'] ) ? $lt_options['currency_base'] : '' ?>">
                                            </td>
                                        </tr>
                                        <!-- Open Exchange API Settings End -->

                                    </table>

                                </div>

                            <?php submit_button(); ?>

                        </form>

                    </div><!-- .inside -->
                </div><!-- #settings -->
            </div><!-- .meta-box-sortables ui-sortable -->
	</div><!-- .metabox-holder -->
    </div><!-- #lt_settings -->
</div>