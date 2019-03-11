<?php
    
    function query_lastposts( $request ){
        global $wpdb;
        
        $args = array(
            'posts_per_page' => 3,
            'post_type' => 'post'
            );
        $data = array();
        $custom_query = new WP_Query($args);
        if ($custom_query->have_posts()) {
            while ($custom_query->have_posts()) {
                $custom_query->the_post();
                $data[ get_the_ID() ] = array(
                    'id'           => get_the_ID(),
                    'date'         => get_the_time('l j F Y'),
                    'name'         => get_the_title(),
                    'link'         => get_the_permalink( $post->ID ),
                    'thumbnail_url' => get_the_post_thumbnail_url(),
                    'image_src'    => get_first_image(), 
                    'excerpt'      => urlencode (get_the_excerpt()),
                    'author'       => get_the_author(),
                    'author_url'   => get_author_posts_url( get_the_author_meta( 'ID' ) ),
                    'tagline'      => get_post_meta( get_the_ID(), 'product_tagline', true ),
                    'slug'         => get_post()->post_name,
                );
            }
        }
        wp_reset_postdata();
        return rest_ensure_response($data);
    }
    
    function register_custom_api() {
        $namespace='/miapi';
		$base='/lastposts';
        register_rest_route($namespace,$base,array('methods' => 'GET','callback' => 'query_lastposts'));

    }
    add_action( 'rest_api_init', 'register_custom_api');
    
    