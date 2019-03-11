<?php
/*
    Plugin Name: Shoes
    Plugin URI: https://eightbeast-project-superwave.c9users.io/
    Description: Create the custom post type
    Version: 1.0
    Author: 8Beast Team
    Author URI: https://eightbeast-project-superwave.c9users.io/
    License: GPL
*/

function reg_post_type_shoes(){
    $supports = array(
        'title',
        'editor',
        'author',
        'thumbnail',
        'excerpt',
        //'custom-fields',
        'comments',
        'revisions',
        //'post-formats'
    );
    
    $labels = array(
        'name' => _x('Shoes', 'plural'),
        'singular_name' => _x('Shoe', 'singular'),
        'menu_name' => _x('Shoes', 'admin menu'),
        'name_admin_bar' => _x('Shoe', 'admin bar'),
        'add_new' => _x('Add new', 'add new'),
        //
        'add_new_item' => __('Add new Shoe'),
        'new_item' => __('New Shoe'),
        'edit_item' => __('Edit Shoe'),
        'view_item' => __('View Shoe'),
        'all_items' => __('All Shoe'),
        'search_items' => __('Search Shoe'),
        'not_found' => __('No Shoe found'),
    );
        
    $args = array(
        'supports' => $supports,
        'labels' => $labels,
        'public' => true, // Controls how the type is visible to authors (show_in_nav_menus, show_ui) and readers (exclude_from_search, publicly_queryable). Default: false
        'query_var' => true,
        'rewrite' => array('slug' => 'eightbeast_shoe'),
        'has_archive' => true, // Para que podamos usar la plantilla archive-{custom_post_type}.php   -->  no me funciona
        'hierarchical' => false,
        'menu_position' => 5, // The position in the menu order the post type should appear
        'menu_icon' => 'dashicons-cart', //The url to the icon to be used for this menu or the name of the icon from the iconfont [1] Default: null - defaults to the posts icon
    );
    
    register_post_type('eightbeast_shoe', $args);
}
add_action('init', 'reg_post_type_shoes');


/**
 * Funcion para añadir soporte para cateogiras y tags en custom posts types
 */
 
 function add_cat_panels(){
     register_taxonomy_for_object_type('category', 'eightbeast_shoe');
     register_taxonomy_for_object_type('post_tag', 'eightbeast_shoe');
 }
 
 add_action('init', 'add_cat_panels');
 
 /**
 * Funcion para añadir las metabox
 */
 
    function shoe_crear_metabox(){
        $screens = array('eightbeast_shoe');
        foreach ($screens as $screen) {
            add_meta_box(
            'shoe_sectionid', 
            'Shoes Details', 
            'shoe_metabox_callback', 
            $screen, 
            'normal'
            );
        }
    }
    add_action('add_meta_boxes', 'shoe_crear_metabox');
 
    function shoe_metabox_callback($post){
    
        wp_nonce_field('save_metabox', 'shoe_nonce');
        
        $price = get_post_meta($post->ID, 'brand_shoe', true);
        $model = get_post_meta($post->ID, 'model_shoe', true);
        $linkshoe = get_post_meta($post->ID, 'link_shoe', true);
        $releasedate = get_post_meta($post->ID, 'release_date', true);
        
        /*
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
          </div>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        */
        
        echo '<div class="form-group">
                <label for="brand_shoe">Brand</label>';
        echo '  <input class="form-control" type="text" name="brand_shoe" value="'. $price .'"/>
              </div>';
        echo '<div class="form-group">
                <label for="model_shoe">Model</label>';
        echo '  <input class="form-control" type="text" value="'. $model .'" name="model_shoe"/>
              </div>';
        echo '<div class="form-group">
                <label for="link_shoe">Link Shoe</label>';
        echo '  <input class="form-control" type="text" value="'.$linkshoe.'" name="link_shoe">
              </div>';
        echo '<div class="form-group">
                <label for="release_date">Release Date</label>';
        echo '  <input class="form-control" type="date" value="'.$releasedate.'" name="release_date"><hr>
              </div>';
    }
 
    function save_metabox($post_id){
        //Comprobar el campo nonce
        if (!isset($_POST['shoe_nonce'])) {
            return;
        }
        if (!wp_verify_nonce($_POST['shoe_nonce'], 'save_metabox')) {
            return;
        }
        
        //Comprobar que el usuario tiene permisos
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        //Saneamos los campos antes de salvarlos
        $price = sanitize_text_field($_POST['brand_shoe']);
        $model = sanitize_text_field($_POST['model_shoe']);
        $linkshoe = sanitize_text_field($_POST['link_shoe']);
        $releasedate = sanitize_text_field($_POST['release_date']);
        
        //Actualizamos la DB
        update_post_meta($post_id, 'brand_shoe', $price);
        update_post_meta($post_id, 'model_shoe', $model);
        update_post_meta($post_id, 'link_shoe', $linkshoe);
        update_post_meta($post_id, 'release_date', $releasedate);
    }
add_action('save_post', 'save_metabox');