<?php

function add_custom_fields( $user ) { ?>
    <table class="form-table">
            <tr>
                <th><label for="user-formalrole"><?php _e('Company role', langdomain()); ?></label></th>
            <td>
                <input type="text" name="user-formalrole" id="user-formalrole" value="<?php echo
                    esc_attr( get_the_author_meta( 'user-formalrole', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e('Your role in the company.', langdomain()); ?></span>
            </td>
            </tr>
        
            <tr>
                <th><label for="avatar-custom"><?php _e('Custom avatar', langdomain()); ?></label></th>
            <td>
                <input type="text" name="avatar-custom" id="avatar-custom" value="<?php echo
                    esc_attr( get_the_author_meta( 'avatar-custom', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e('Custom avatar from url', langdomain()); ?></span>
            </td>
            </tr>
            
            <tr>
                <th><label for="user-custom-quote"><?php _e('Personal quote', langdomain()); ?></label></th>
            <td>
                <input type="text" name="user-custom-quote" id="user-custom-quote" value="<?php echo
                    esc_attr( get_the_author_meta( 'user-custom-quote', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e('Something on your mind?', langdomain()); ?></span>
            </td>
            </tr>
    </table>
    <h3><?php _e('Workplace skills', langdomain()); ?></h3>
    <table class="form-table">
            <tr>
                <th><label for="sk1"><?php _e('Web Development', langdomain()); ?></label></th>
            <td>
                <input type="text" name="sk1" id="sk1" value="<?php echo
                    esc_attr( get_the_author_meta( 'sk1', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e('Web dev expertise level.', langdomain()); ?></span>
            </td>
            </tr>
            <tr>
                <th><label for="sk2"><?php _e('Web Design', langdomain()); ?></label></th>
            <td>
                <input type="text" name="sk2" id="sk2" value="<?php echo
                    esc_attr( get_the_author_meta( 'sk2', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e('Web design expertise level.', langdomain()); ?></span>
            </td>
            </tr>
            <tr>
                <th><label for="sk3"><?php _e('Research', langdomain()); ?></label></th>
            <td>
                <input type="text" name="sk3" id="sk3" value="<?php echo
                    esc_attr( get_the_author_meta( 'sk3', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e('Research and investigation experience.', langdomain()); ?></span>
            </td>
            </tr>
            <tr>
                <th><label for="sk4"><?php _e('Marketing', langdomain()); ?></label></th>
            <td>
                <input type="text" name="sk4" id="sk4" value="<?php echo
                    esc_attr( get_the_author_meta( 'sk4', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e('Marketing abilities', langdomain()); ?></span>
            </td>
            </tr>
    </table>
    <h3><?php _e('Social links', langdomain()); ?></h3>
    <table class="form-table">
            <tr>
                <th><label for="social-facebook">Facebook</label></th>
            <td>
                <input type="text" name="social-facebook" id="social-facebook" value="<?php echo
                    esc_attr( get_the_author_meta( 'social-facebook', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e('Link to your facebook profile.', langdomain()); ?></span>
            </td>
            </tr>
            <tr>
                <th><label for="social-twitter">Twitter</label></th>
            <td>
                <input type="text" name="social-twitter" id="social-twitter" value="<?php echo
                    esc_attr( get_the_author_meta( 'social-twitter', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e('Link to your twitter profile.', langdomain()); ?></span>
            </td>
            </tr>
            <tr>
                <th><label for="social-linkedin">Linkedin</label></th>
            <td>
                <input type="text" name="social-linkedin" id="social-linkedin" value="<?php echo
                    esc_attr( get_the_author_meta( 'social-linkedin', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e('Link to your linkedin profile.', langdomain()); ?></span>
            </td>
            </tr>
            
            <tr>
                <th><label for="social-linkedin">Instagram</label></th>
            <td>
                <input type="text" name="social-instagram" id="social-instagram" value="<?php echo
                    esc_attr( get_the_author_meta( 'social-instagram', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e('Link to your instagram profile.', langdomain()); ?></span>
            </td>
            </tr>
    
    </table>
<?php 
}

add_action('show_user_profile','add_custom_fields');
add_action('edit_user_profile','add_custom_fields');

function save_custom_fields($user_id) {
    
    
    if (!current_user_can('edit_user',$user_id)) return false;
    
    update_user_meta($user_id, 'avatar-custom', $_POST['avatar-custom']);
    
    update_user_meta($user_id, 'user-custom-quote', $_POST['user-custom-quote']);
    
    update_user_meta($user_id, 'social-twitter', $_POST['social-twitter']);
    update_user_meta($user_id, 'social-facebook', $_POST['social-facebook']);
    update_user_meta($user_id, 'social-linkedin', $_POST['social-linkedin']);
    update_user_meta($user_id, 'social-instagram', $_POST['social-instagram']);
    
    update_user_meta($user_id, 'sk1', $_POST['sk1']);
    update_user_meta($user_id, 'sk2', $_POST['sk2']);
    update_user_meta($user_id, 'sk3', $_POST['sk3']);
    update_user_meta($user_id, 'sk4', $_POST['sk4']);
    
    update_user_meta($user_id, 'user-formalrole', $_POST['user-formalrole']);

}
add_action('personal_options_update','save_custom_fields');
add_action('edit_user_profile_update','save_custom_fields');


function get_better_page_name($id = null) {
    $pagename = get_query_var('pagename');  
    if ( !$pagename && $id > 0 ) {  
        // If a static page is set as the front page, $pagename will not be set. Retrieve it from the queried object  
        $post = $wp_query->get_queried_object();  
        $pagename = $post->post_name;  
    }
    return $pagename;
}





function get_author_role($author_id) {
    $user_info = get_userdata($author_id);
    return implode(', ', $user_info->roles);
}

function list_tags() {
    if (is_page('archives')) {
        $tags = get_tags(array('orderby' => 'count', 'order' => 'DESC', 'number' => 30));
        foreach ($tags as $tag) {
                echo '<i class="fa fa-tag mygrey"></i>&nbsp;<a href="' . get_tag_link ($tag->term_id) . '" rel="tag">' . $tag->name . ' <span class="heavyblue pull-right">' . $tag->count . '</span></a><br />';
        }
    }
    
}


function get_num_visits($post_id) {
    $numvisits = 1;
    $suffix = __(' VISIT', langdomain());
    if (!add_post_meta($post_id, 'postsvisits', $numvisits, true)) {
        $numvisits = get_post_meta($post_id, 'postsvisits', true);
        $numvisits++;
        $suffix = __(' VISITS', langdomain());
        update_post_meta($post_id,'postsvisits', $numvisits);
    }
    return $numvisits.$suffix;
}

function get_num_visits_nosum($post_id) {
    
        $numvisits = get_post_meta($post_id, 'postsvisits', true);
        $suffix = __(' VISITS', langdomain());
        if ($numvisits == 1) {
            $suffix = __(' VISIT', langdomain());
        }
        if ($numvisits <= 0) {
            $numvisits='NO';
            $suffix= __(' VISITS', langdomain());
        }
        
    return $numvisits.$suffix;
}


   
// COMMENTS
/**
 * Customize the comment submit button OK
 */
function change_submit_button($submit_field) {
    $changed_submit = str_replace ('name="submit" type="submit" id="submit"', 'name="submit" type="submit" id="submit" tabindex = "5" class="highlight-button-dark btn btn-small no-margin-bottom"', $submit_field);
    return $changed_submit;
    
    //return '<button class="highlight-button-dark btn btn-small no-margin-bottom" id="submit" type="submit">Send</button>'; 
}
add_filter('comment_form_submit_field', 'change_submit_button');


/**
 *  Delete the url field from comments form OK
 */

 function remove_comment_fields($fields) {
        unset($fields['url']);
        return $fields;
}
add_filter('comment_form_default_fields','remove_comment_fields');



/**
 *  Add a new field to comments form for consenting privacy policy
 *  @fields  Commments form fields
 *  
 */
function hcode_add_comment_fields($fields) {
    //if( is_page('report-feedback') ) {  comment out this line if you want checkbox on all comment forms
        $fields['consent'] = '<p class="comment-form-public">
               <input id="consent" name="consent" type="checkbox" required/>
               <label for="consent">'.__('Check this box to give us permission to publicly post your comment. (I comply with the GDPR rules)', langdomain()) 
               .'</label></p>';
    //}  comment out this line if you want checkbox on all comment forms
    return $fields;
}
add_filter('comment_form_default_fields', 'hcode_add_comment_fields');

function hcode_add_admin_fields() {
    echo '<p class="comment-form-public">
               <input id="consent" name="consent" type="checkbox" required/>
               <label for="consent">'.
               __('Check this box to give us permission to publicly post your comment. (I comply with the GDPR rules)', langdomain()) 
               .'</label></p>';
    
}
add_action('comment_form_logged_in_after', 'hcode_add_admin_fields');

/**
 *  Save the privacy policy approved in DDBB
 *  @post_id  Post ID
 *  
 */
function save_comment_meta_checkbox ( $post_id ) {
    $save_meta_checkbox = $_POST['consent'];
    if ( $save_meta_checkbox == 'on' ) {
        $value = 'Checkbox is checked: I accept the privacy policy';
    } else {
     	$value = 'Checkbox is NOT checked: I do not accept';
    }
    add_comment_meta( $post_id, 'consent', $value, true );
}
add_action( 'comment_post', 'save_comment_meta_checkbox', 1 );

 /**
 *  Move comment field textarea to bottom
 *  $fields    Comment form fields array
 *  
 */
function wpb_move_comment_field_to_bottom( $fields ) {
    $consent_field = $fields['consent']; // Just take care of the new field consent, must be the last one
    unset( $fields['consent'] );
    
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    
    $fields['comment'] = $comment_field;
    $fields['consent'] = $consent_field;
    return $fields;
}

add_filter( 'comment_form_fields', 'wpb_move_comment_field_to_bottom' );


function dcms_modify_fields_form( $args ){

	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );

	$author = '<input placeholder="'.__( 'Name' ) . ( $req ? ' *' : '' ).'" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .'" size="30"' . $aria_req . ' />';
	$email = '<div class="fields-wrap"><input placeholder="'.__( 'Email' ) . ( $req ? ' *' : '' ).'" id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) .'" size="30"' . $aria_req . ' />';
	$url = '<input placeholder="'.__( 'Website' ).'" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .'" size="30" /></div>';
	$comment = '<textarea placeholder="'. _x( 'Comment', 'noun' ).'" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>';

	$args['fields']['author'] = $author;
	$args['fields']['email'] = $email;
	$args['fields']['url'] = $url;
	$args['comment_field'] = $comment;

	return $args;

}
//add_filter( 'comment_form_defaults', 'dcms_modify_fields_form' );




/* EMBEDDED VIDEOS */
function get_first_embed_media($post_id) {

    $post = get_post($post_id);
    $content = do_shortcode( apply_filters( 'the_content', $post->post_content ) );
    $embeds = get_media_embedded_in_content( $content );

    if( !empty($embeds) ) {
        //check what is the first embed containg video tag, youtube or vimeo
        foreach( $embeds as $embed ) {
            if( strpos( $embed, 'video' ) || strpos( $embed, 'youtube' ) || strpos( $embed, 'vimeo' ) ) {
                return $embed;
            }
        }

    } else {
        //No video embedded found
        return false;
    }

}



function get_first_image() {
  global $post, $posts;
 
    $thumb = get_the_post_thumbnail_url();
    if (empty($thumb)) {
         $first_img = '';
          ob_start();
          ob_end_clean();
          $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
          $first_img = $matches[1][0];
        
        return $first_img;
        
    } else {
        return $thumb;
    }
 
}



/* 8beast fixes */

add_action( 'pre_get_posts', function ( $q ) {
    if (    $q->is_home() && $q->is_main_query() ) {
        $q->set( 'posts_per_page', 6 );
        $q->set( 'post_type', array('eightbeast_shoe','post'));
    }
});

add_filter( 'pre_get_posts', 'tgm_io_cpt_search' );
function tgm_io_cpt_search( $query ) {
	
    if ( $query->is_search ) {
	$query->set( 'post_type', array( 'post', 'eightbeast_shoe') );
    }
    
    return $query;
    
}

function namespace_add_custom_types( $query ) {
  if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
    $query->set( 'post_type', array(
     'post', 'nav_menu_item', 'eightbeast_shoe'
		));
	  return $query;
	}
}
add_filter( 'pre_get_posts', 'namespace_add_custom_types' );


add_filter( 'getarchives_where' , 'ucc_getarchives_where_filter' , 10 , 2 ); 
function ucc_getarchives_where_filter( $where , $r ) { 
    $args = array( 'public' => true , '_builtin' => false ); 
    $output = 'names'; $operator = 'and';
    $post_types = get_post_types( $args , $output , $operator ); 
    $post_types = array_merge( $post_types , array( 'post','CUSTOM_POST_TYPE_NAME' ) ); 
    $post_types = "'" . implode( "' , '" , $post_types ) . "'";
    return str_replace( "post_type = 'post'" , "post_type IN ( $post_types )" , $where ); 
} 