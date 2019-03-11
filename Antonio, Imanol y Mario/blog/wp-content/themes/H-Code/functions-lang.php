<?php

function load_language_spanish() {
    load_textdomain( $this->langdomain(), get_template_directory().'/lang/es_ES.mo' );
}

add_action('wp_ajax_nopriv_langes', 'load_language_spanish');
add_action('wp_ajax_langes', 'load_language_spanish');

function load_language_default() {
    load_default_textdomain();
}

add_action('wp_ajax_nopriv_lang', 'load_language_default');
add_action('wp_ajax_lang', 'load_language_default');