<?php 

/**
 * Template For Thank You Page
 * 
 * Handles to return for thank you page content
 * 
 * Override this template by copying it to yourtheme/language-translate/thankyou.php
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	
    //get header
    get_header( 'thankyou' );

    global $post;
?>

    <div class="gdlr-content site-content">
        <div class="with-sidebar-wrapper">
            <section id="content-section-1">

                <div class="section-container container">

                    <?php
                        //do action to show thankyou content before
                        do_action( 'lt_thankyou_content_before' );
                    ?>	
                    <div class="entry-content">

                    <?php
                    
                        //do action to show thankyou content
                        do_action( 'lt_thankyou_content' );
                    ?>

                    </div><!--.columns-->

                    <?php
                        //do action to show thankyou content after
                        do_action( 'lt_thankyou_content_after' );
                    ?>
                    
                    <div class="clear"></div>
                    
                </div><!--.section-container-->

            </section>
        </div><!--.with-sidebar-wrapper-->
    </div><!--.gdlr-content-->
    
<?php

    //get sidebar
    get_sidebar( 'thankyou' );

    //get footer
    get_footer( 'thankyou' );
	
?>