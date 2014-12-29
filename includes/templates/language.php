<?php 

/**
 * Template For Language Page
 * 
 * Handles to return for language page content
 * 
 * Override this template by copying it to yourtheme/language-translate/language.php
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	
    //get header
    get_header( 'language' );

    global $post;
?>

    <div class="gdlr-content site-content">
        <div class="with-sidebar-wrapper">
            <section id="content-section-1">

                <div class="section-container container">

                    <?php
                        //do action to show language content before
                        do_action( 'lt_language_content_before' );
                    ?>	
                    <div class="three-fifth columns">

                    <?php
                    
                        //do action to show language content
                        do_action( 'lt_language_content' );
                    ?>

                    </div><!--.columns-->

                    <div class="two-fifth columns">
                    
                    <?php
                        //do action to show language content after
                        do_action( 'lt_order_widget_content' );
                        do_action( 'lt_language_content_after' );
                    ?>	
 
                    </div>
                    <div class="clear"></div>
                    
                </div><!--.section-container-->

            </section>
        </div><!--.with-sidebar-wrapper-->
    </div><!--.gdlr-content-->
    
<?php

    //get sidebar
    get_sidebar( 'language' );

    //get footer
    get_footer( 'language' );
	
?>