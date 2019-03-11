<?php
/*
    Plugin Name: Language Switch
    Plugin URI: https://eightbeast-project-superwave.c9users.io/blog
    Description: Switch between the diferents languages
    Version: 1.0
    Author: 8BEAST
    Author URI: https://eightbeast-project-superwave.c9users.io/blog
    License: GPL
*/

function switch_language($locale) {
    if (isset($_GET['lang'])) {
        $lang = $_GET['lang'];
        if ($lang === 'es') {
            setcookie('custom_lang', 'es_ES', time()+172800); // 2 dias de cookie
        } elseif ($lang === 'en') {
            //unset($_COOKIE['custom_lang']);
            setcookie( 'custom_lang', '', time() - ( 15 * 60 ) );
        }
        wp_redirect(get_bloginfo('url'));
        exit;
    }
    
    if ($_COOKIE['custom_lang'] !== '') {
        $locale = $_COOKIE['custom_lang'];
    } else {
        $locale = 'en_GB';
    }
return $locale;
}
add_filter('locale','switch_language',10);