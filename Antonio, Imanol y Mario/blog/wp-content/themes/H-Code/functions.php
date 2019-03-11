<?php

//Langs
load_theme_textdomain( 'hcodelang', get_template_directory() . '/lang' );

function langdomain(){
    return 'hcodelang';
}

//Soportes del tema

//HAcer en casa: Custom post format styles
add_theme_support('post-formats', ['image', 'gallery', 'video', 'link', 'grid', 'quote']);
add_theme_support('post-thumbnails');
add_theme_support( 'title-tag' );
add_theme_support( 'html5', array( 'search-form' ) );


function mi_nuevo_mime_type( $existing_mimes ) {
    // añade webp a la lista de mime types
    $existing_mimes['webm'] = 'image/webp';
    // devuelve el array a la funcion con el nuevo mime type
    return $existing_mimes;
}
add_filter( 'mime_types', 'mi_nuevo_mime_type' );

/*
function override_stylesheets() {
    wp_enqueue_style('theme-override', '/home/ubuntu/workspace/public_html/styles-custom.css');
}
add_action('wp_enqueue_scripts', 'override_stylesheets');*/

//Develop all custom theme functions
function my_theme_scripts() {
    
    wp_register_script('jquery', 'https://eightbeast-project-superwave.c9users.io/public_html/js/jquery.min.js', array('jquery'), null, false);
    wp_enqueue_script('jquery');
    
    wp_register_script('cust-modernizr', 'https://eightbeast-project-superwave.c9users.io/public_html/js/modernizr.js', array('jquery'), null, true);
    wp_enqueue_script('cust-modernizr');
    
    wp_register_script('bootstrap', 'https://eightbeast-project-superwave.c9users.io/public_html/js/bootstrap.js', array('jquery'), null, true);
    wp_enqueue_script('bootstrap');
    
    wp_register_script('bootstrap-dropdown', 'https://eightbeast-project-superwave.c9users.io/public_html/js/bootstrap-hover-dropdown.js', array('jquery'), null, true);
    wp_enqueue_script('bootstrap-dropdown');
    
    wp_register_script('jquery-easing', 'https://eightbeast-project-superwave.c9users.io/public_html/js/jquery.easing.1.3.js', array('jquery'), null, true);
    wp_enqueue_script('jquery-easing');
    
    wp_register_script('skrollr', 'https://eightbeast-project-superwave.c9users.io/public_html/js/skrollr.min.js', array('jquery'), null, true);
    wp_enqueue_script('skrollr');
    
    wp_register_script('smoothscroll', 'https://eightbeast-project-superwave.c9users.io/public_html/js/smooth-scroll.js', array('jquery'), null, true);
    wp_enqueue_script('smoothscroll');
    
    wp_register_script('jquery-appear', 'https://eightbeast-project-superwave.c9users.io/public_html/js/jquery.appear.js', array('jquery'), null, true);
    wp_enqueue_script('jquery-appear');
    
    wp_register_script('wow', 'https://eightbeast-project-superwave.c9users.io/public_html/js/wow.min.js', array('jquery'), null, true);
    wp_enqueue_script('wow');
    
    wp_register_script('page-scroll', 'https://eightbeast-project-superwave.c9users.io/public_html/js/page-scroll.js', array('jquery'), null, true);
    wp_enqueue_script('page-scroll');
    
    wp_register_script('jquery-easypiechart', 'https://eightbeast-project-superwave.c9users.io/public_html/js/jquery.easypiechart.js', array('jquery'), null, true);
    wp_enqueue_script('jquery-easypiechart');
    
    wp_register_script('jquery-parallax', 'https://eightbeast-project-superwave.c9users.io/public_html/js/jquery.parallax-1.1.3.js', array('jquery'), null, true);
    wp_enqueue_script('jquery-parallax');
    
    wp_register_script('jquery-isotope', 'https://eightbeast-project-superwave.c9users.io/public_html/js/jquery.isotope.min.js', array('jquery'), null, true);
    wp_enqueue_script('jquery-isotope');
    
    wp_register_script('owl', 'https://eightbeast-project-superwave.c9users.io/public_html/js/owl.carousel.min.js', array('jquery'), null, true);
    wp_enqueue_script('owl');
    
    wp_register_script('jquery-magnific', 'https://eightbeast-project-superwave.c9users.io/public_html/js/jquery.magnific-popup.min.js', array('jquery'), null, true);
    wp_enqueue_script('jquery-magnific');
    
    wp_register_script('popup-gallery', 'https://eightbeast-project-superwave.c9users.io/public_html/js/popup-gallery.js', array('jquery'), null, true);
    wp_enqueue_script('popup-gallery');
    
    wp_register_script('text-effect', 'https://eightbeast-project-superwave.c9users.io/public_html/js/text-effect.js', array('jquery'), null, true);
    wp_enqueue_script('text-effect');
    
    wp_register_script('jquery-tools', 'https://eightbeast-project-superwave.c9users.io/public_html/js/jquery.tools.min.js', array('jquery'), null, true);
    wp_enqueue_script('jquery-tools');
    
    wp_register_script('jquery-revolution', 'https://eightbeast-project-superwave.c9users.io/public_html/js/jquery.revolution.js', array('jquery'), null, true);
    wp_enqueue_script('jquery-revolution');
    
    wp_register_script('counter', 'https://eightbeast-project-superwave.c9users.io/public_html/js/js-counter.js', array('jquery'), null, true);
    wp_enqueue_script('counter');
    
    wp_register_script('jquery-countto', 'https://eightbeast-project-superwave.c9users.io/public_html/js/jquery.countTo.js', array('jquery'), null, true);
    wp_enqueue_script('jquery-countto');
    
    wp_register_script('jquery-fitvids', 'https://eightbeast-project-superwave.c9users.io/public_html/js/jquery.fitvids.js', array('jquery'), null, true);
    wp_enqueue_script('jquery-fitvids');
    
    wp_register_script('imagesloaded', 'https://eightbeast-project-superwave.c9users.io/public_html/js/imagesloaded.pkgd.min.js', array('jquery'), null, true);
    wp_enqueue_script('imagesloaded');
    
    wp_register_script('classie', 'https://eightbeast-project-superwave.c9users.io/public_html/js/classie.js', array('jquery'), null, true);
    wp_enqueue_script('classie');
    
    wp_register_script('hamburger', 'https://eightbeast-project-superwave.c9users.io/public_html/js/hamburger-menu.js', array('jquery'), null, true);
    wp_enqueue_script('hamburger');

    wp_register_script('theme-js', 'https://eightbeast-project-superwave.c9users.io/public_html/js/main.js', array('jquery','cust-modernizr','jquery-countto','counter'), null, true);
    wp_enqueue_script('theme-js');
    
    wp_register_script('custom-cart-js', 'https://eightbeast-project-superwave.c9users.io/public_html/js/custom-ajax-cart.js', array('jquery'), null, true);
    wp_enqueue_script('custom-cart-js');
    
    wp_register_script('custom-lang-js', get_template_directory_uri() .'/js/custom-js-lang.js', array('jquery'), null, true);
    wp_enqueue_script('custom-lang-js');
}
add_action('wp_enqueue_scripts', 'my_theme_scripts');

//Load Styles to Backend area
function style_backend() {
    wp_register_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', array(), null, 'all');
    wp_enqueue_style('bootstrap');
    wp_register_script('bootstrapjs', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array('jquery'), null, true);
    wp_enqueue_script('bootstrapjs');
}
add_action('admin_enqueue_scripts', 'style_backend');


function theme_widgets_init() {
    register_sidebar(array(
        'name' => 'Sidebar Widgets',
        'id' => 'sidebar',
        'description' => 'Sidebar Widget Area',
        'before_widget' => '<div class="widget">',
        'after_widget'=>'</div>'
        ));
}

add_action('widgets_init', 'theme_widgets_init');


require_once('functions-custom.php');
require_once('functions-lang.php');
require_once('functions-breadcrumbs.php');
require_once('functions-title.php');
require_once('functions-api.php');
?>