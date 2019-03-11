<?php

function custom_tab_title() {
    if (is_category()) {
    	_e('Category ', langdomain()). wp_title(''); echo ' - ';
    
    } elseif (function_exists('is_tag') && is_tag()) {
    	single_tag_title(_e('Tag archive for &quot;', langdomain())); echo '&quot; - ';
    
    } elseif (is_archive()) {
    	wp_title(''); _e(' Archive - ', langdomain());
    
    } elseif (is_page() && !is_front_page()) {
    	echo wp_title(''); echo ' - ';
    	
    } elseif (is_front_page()) {
        _e('Blog - ', langdomain());
    
    } elseif (is_home()) {
        _e('Blog - ', langdomain());
        
    } elseif (is_search()) {
    	_e('Search for &quot;', langdomain()).wp_specialchars($s).'&quot; - ';
    
    } elseif (!(is_404()) && (is_single()) || (is_page())) {
    	wp_title(''); echo ' - ';
    
    } elseif (is_404()) {
    	_e('Not found - ', langdomain());
    
    } bloginfo('name');
}