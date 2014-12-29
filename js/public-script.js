/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function($) {
    
    //scroll page to focus on error
    $('html, body').animate({ scrollTop: $( '.orderform' ).offset().top - 80 }, 500);

    var total_words = $( '.lt-grand-total-words' ).html();
    
    if( total_words == '' || total_words == 'undefine' || total_words == '0' ) {
        $( '#lt_choose_lnaguage_btn' ).attr( 'disabled', 'disabled' );
    } else {
        $( '#lt_choose_lnaguage_btn' ).removeAttr( 'disabled' );
    }
    
    $( document ).on( 'click', '.close', function() {
        $( this ).parents( '.popover' ).css( 'display', 'none' );
    });
    
    $( document ).on( 'change', '.lt-file-upload', function() {
        $( this ).parents( '.lt-file-upload-form' ).submit();
    });
    
    $( '#lt_file_upload_form1, #lt_file_upload_form2' ).ajaxForm({
        beforeSend: function() {
            
        },
        uploadProgress: function(event, position, total, percentComplete) {
            
        },
        success: function() {
            
        },
        complete: function(xhr) {
            
            var response = xhr.responseText;
            
            if( response ) {
                
                var total_words = $( '.lt-grand-total-words' ).html()
                $( '.lt-file-upload' ).val( '' );

                data = jQuery.parseJSON( response );
                var word_count = data.word_count;
                
                total_words = parseInt( total_words ) + word_count;
                
                $( '.lt-grand-total-words' ).html( total_words );
                
                window.location.reload();
            } 
        }
    });
    
    $( document ).on( 'change', '.lt-translate-from', function() {
        
        var postid = $(this).val();
        
        var data = {
                        action: 'lt_load_offer_languages',
                        postid: postid
                    };
        jQuery.post( LtPublic.ajaxurl, data, function(response) {

            $('.lt-translate-to').html(response);
            
        });        
    });
    
    $( document ).on( 'click', '.ClearAll_items', function() {
        
        var data = {
                        action: 'lt_clear_file_meta'
                    };
        jQuery.post( LtPublic.ajaxurl, data, function(response) {

            window.location.reload();
            
        });
    });
    
    $( document ).on( 'click', '.ClearAll_lang', function() {
        
        var data = {
                        action: 'lt_clear_lang_meta'
                    };
        jQuery.post( LtPublic.ajaxurl, data, function(response) {

            window.location.reload();
            
        });
    });
    
    $( document ).on( 'click', '.lt-remove-file', function() {
        
        var file_key = $( this ).attr( 'data-file-key' );
        
        var data = {
                        action: 'lt_clear_file_meta',
                        filekey: file_key
                    };
        jQuery.post( LtPublic.ajaxurl, data, function(response) {

            window.location.reload();
            
        });
    });
   
    $( document ).on( 'keyup', '.orderform_btextarea textarea', function() {
       
        var str = $( this ).val();
        if( str.length > 0 ) {
            
            var word_count = $.trim( str ).split( ' ' ).length;
            $( '.lt-text-total-words' ).html( word_count );
            $( '.orderform_bTypebox' ).fadeOut();
            $( '.text-wordcount-row' ).fadeIn();
            $( '#lt_choose_lnaguage_btn' ).removeAttr( 'disabled' );
            
        } else {
            
            $( '.orderform_bTypebox' ).fadeIn();
            $( '.text-wordcount-row' ).fadeOut();
        }
    });
   
    $( document ).on( 'click', '.color_link', function() {

        $( '.orderform_btextarea textarea' ).val( '' );
        $( '.orderform_bTypebox' ).fadeIn();
        $( '.text-wordcount-row' ).fadeOut();
    });
    
    $( document ).on( 'click', '#lt_choose_lnaguage_btn', function() {
       
        var text_value = $( '.orderform_btextarea textarea' ).val();
	var total_words = $( '.lt-grand-total-words' ).html();
	total_words = parseInt( total_words );
        if( text_value != '' ) {
            
            var data = {
                            action: 'lt_add_text',
                            textvalue: text_value
                        };
            jQuery.post( LtPublic.ajaxurl, data, function(response) {

                if( response ) {
                    
                    var total_words = $( '.lt-grand-total-words' ).html()
                    $( '.orderform_btextarea textarea' ).val( '' );

                    total_words = parseInt( total_words ) + response;

                    $( '.lt-grand-total-words' ).html( total_words );

                    window.location.reload();
                }
            });
        }

        if( total_words > 0 ) {
		window.location = LtPublic.language_page_url;
	}
    });
    
    $( document ).on( 'keyup', '.modal-content textarea', function() {
       
        var str = $( this ).val();
        if( str.length > 0 ) {
            
            var word_count = $.trim( str ).split( ' ' ).length;
            $( '.lt-text-total-words' ).html( word_count );
            
        }
    });
   
    $( document ).on( 'click', '.wordcount_btn', function() {
       
        var text_value = $( '.modal-content textarea' ).val();
        if( text_value != '' ) {
            
            var data = {
                            action: 'lt_add_text',
                            textvalue: text_value
                        };
            jQuery.post( LtPublic.ajaxurl, data, function(response) {

                if( response ) {
                    
                    var total_words = $( '.lt-grand-total-words' ).html()
                    $( '.modal-content textarea' ).val( '' );

                    total_words = parseInt( total_words ) + response;

                    $( '.lt-grand-total-words' ).html( total_words );

                    window.location.reload();
                }
            });
        }
    });
    
    $( document ).on( 'click', '.language_select li', function() {
       
        if( $( this ).hasClass( 'checked_lang' ) ) {
            $( this ).removeClass( 'checked_lang' );
        } else {
            $( this ).addClass( 'checked_lang' );
        }
    });
    
    $( document ).on( 'click', '#lt_add_lnaguage_btn, #lt_next_options_btn', function() {
        
        var clickable_btn = $( this ).attr( 'id' );
        
        var tran_to = '';
        $( '.language_select li.checked_lang' ).each(function(index, value) {
            var selected_lan = $( this ).attr( 'data-offer-value' );
            tran_to += selected_lan + ',';
        });
        
        if( tran_to != '' ) {
            
            var tran_from = $( '.lt-translate-from' ).val();
            var data = {
                            action: 'lt_add_languages',
                            tran_from: tran_from,
                            tran_to : tran_to
                        };
            jQuery.post( LtPublic.ajaxurl, data, function(response) {
                
                if( clickable_btn == 'lt_add_lnaguage_btn' ) {
                    window.location.reload();
                } else {
                    window.location = LtPublic.optional_page_url;
                }

            });
        }
    });
    
    $( document ).on( 'change', '.lt-change-currency', function() {
        
        var code = $( this ).val();
        
        if( code != '' && code != 'undefined' ) {
            
            var tran_from = $( '.lt-translate-from' ).val();
            var data = {
                            action: 'lt_change_currency',
                            code : code
                        };
            jQuery.post( LtPublic.ajaxurl, data, function(response) {
                
                window.location.reload();
            });
        }
    });
    
    $( document ).on( 'click', '#level', function() { 
    
        level = $("input[type='radio']:checked").val()
        
        if( level != '' ) {
            
            var data = {
                          action: 'lt_translate_level',
                          level: level
                       };
            
            jQuery.post( LtPublic.ajaxurl, data, function(response) {
                
                window.location.reload();
            });  
        }
    });
    
    $( document ).on( 'click', '.confirm_btn', function() {
       
        var email = $( '#lt_user_email' ).val();
        
        $( '#lt_user_email' ).css( 'border-color', 'inherit' );
        if( email == '' || email == 'undefined' ) {
            $( '#lt_user_email' ).css( 'border-color', '#FF0000' );
        }
        if( $( '#lt_term_condition' ).is( ':checked' ) ) {
            
            var data = {
                          action: 'lt_send_email',
                          email: email
                       };
            
            jQuery.post( LtPublic.ajaxurl, data, function(response) {
                
                window.location = LtPublic.thankyou_page_url;
            });
        }
    });
});