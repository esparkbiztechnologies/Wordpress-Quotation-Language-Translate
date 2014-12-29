<?php

/**
 * Custom Post Types & Taxonomies File
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Register a Language post type.
 */
function lt_register_post_type() {
    
    $labels = array(
            'name'               => _x( 'Languages', 'lang_trans', 'langtrans' ),
            'singular_name'      => _x( 'Language', 'language', 'langtrans' ),
            'menu_name'          => _x( 'Languages', 'language', 'langtrans' ),
            'name_admin_bar'     => _x( 'Language', 'language', 'langtrans' ),
            'add_new'            => _x( 'Add New', 'language', 'langtrans' ),
            'add_new_item'       => __( 'Add New Language', 'langtrans' ),
            'new_item'           => __( 'New Language', 'langtrans' ),
            'edit_item'          => __( 'Edit Language', 'langtrans' ),
            'view_item'          => __( 'View Languages', 'langtrans' ),
            'all_items'          => __( 'Languages', 'langtrans' ),
            'search_items'       => __( 'Search Language', 'langtrans' ),
            'parent_item_colon'  => __( 'Parent Language:', 'langtrans' ),
            'not_found'          => __( 'No language found.', 'langtrans' ),
            'not_found_in_trash' => __( 'No language found in Trash.', 'langtrans' ),
    );

    $args = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => 'edit.php?post_type='.LT_CONV_POST_TYPE,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => LT_LANG_POST_TYPE ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'author' ),
    );

    register_post_type( LT_LANG_POST_TYPE, $args );
    
    $labels = array(
            'name'               => _x( 'Conversions', 'lang_conv', 'langtrans' ),
            'singular_name'      => _x( 'Conversion', 'conversion', 'langtrans' ),
            'menu_name'          => _x( 'Conversions', 'conversion', 'langtrans' ),
            'name_admin_bar'     => _x( 'Conversion', 'conversion', 'langtrans' ),
            'add_new'            => _x( 'Add New', 'conversion', 'langtrans' ),
            'add_new_item'       => __( 'Add New Conversion', 'langtrans' ),
            'new_item'           => __( 'New Conversion', 'langtrans' ),
            'edit_item'          => __( 'Edit Conversion', 'langtrans' ),
            'view_item'          => __( 'View Conversion', 'langtrans' ),
            'all_items'          => __( 'All Conversions', 'langtrans' ),
            'search_items'       => __( 'Search Conversion', 'langtrans' ),
            'parent_item_colon'  => __( 'Parent Conversion:', 'langtrans' ),
            'not_found'          => __( 'No conversion found.', 'langtrans' ),
            'not_found_in_trash' => __( 'No conversion found in Trash.', 'langtrans' ),
    );

    $args = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => LT_CONV_POST_TYPE ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'author' ),
    );

    register_post_type( LT_CONV_POST_TYPE, $args );
  
    $args = array(
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => false,
            'show_in_menu'       => false,
            'query_var'          => true,
            'rewrite'            => false,
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title' ),
    );

    register_post_type( LT_ORDER_POST_TYPE, $args );
    
}

//Post Type For Language Translation
add_action( 'init', 'lt_register_post_type' );

?>