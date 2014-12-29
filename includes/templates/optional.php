<?php 

/**
 * Template For Optional Page
 * 
 * Handles to return for optional page content
 * 
 * Override this template by copying it to yourtheme/language-translate/optional.php
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	
    //get header
    get_header( 'optional' );

    global $post;
?>

    <div class="gdlr-content site-content">
        <div class="with-sidebar-wrapper">
            <section id="content-section-1">

                <div class="section-container container">

                    <?php
                        //do action to show optional content before
                        do_action( 'lt_optional_content_before' );
                    ?>	
                    <div class="three-fifth columns">

                    <?php
                    
                        //do action to show optional content
                        do_action( 'lt_optional_content' );
                    ?>

                    </div><!--.columns-->

                    <div class="two-fifth columns">
                    
                    <?php
                        //do action to show optional content after
                        do_action( 'lt_order_widget_content' );
                        do_action( 'lt_optional_content_after' );
                    ?>	
 
                    </div>
                    <div class="clear"></div>
                    
                </div><!--.section-container-->

            </section>
        </div><!--.with-sidebar-wrapper-->
    </div><!--.gdlr-content-->
    
<?php

    //get sidebar
    get_sidebar( 'optional' );

    //get footer
    get_footer( 'optional' );
	
?>