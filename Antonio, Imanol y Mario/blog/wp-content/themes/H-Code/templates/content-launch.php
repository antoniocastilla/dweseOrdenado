<?php 
$custom_fields = get_post_custom();
$my_custom_field = $custom_fields['link_shoe'][0];


$preview = get_first_image();
if (!isset($preview)) {
    $preview = '../assets/shoes/aaa_no_shoe.jpg';
}
?>
<div class="blog-listing blog-listing-classic wow fadeIn">
        <div class="blog-date"><?php _e('Posted by ', langdomain()); ?><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a> | <?php echo get_the_date( get_option('date_format') ); ?> | <?php the_category(', '); ?> </div>
        <div class="blog-title"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></div>
    <div class="separator-line bg-yellow no-margin-lr margin-four"></div>
    <div class="row">
        <div class="blog-image col-md-5 col-sm-12"><a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $preview;?>" alt=""/></a></div>
        <div class="blog-details col-md-7 col-sm-12">
            <div><?php the_excerpt(); ?></div>
        </div>
    </div>
    <div class="blog-details">
        <a class="btn-warning btn btn-small no-margin" href="<?php echo get_the_permalink(); ?>"><?php _e('Continue Reading', langdomain()); ?></a>
        <a class="btn-success btn btn-small no-margin" href="<?php echo $my_custom_field; ?>"><?php _e('View Storefront', langdomain()); ?></a>
        <div><a href="<?php echo get_comments_link(); ?>" class="comments"><i class="fa fa-comment-o"></i><?php echo comments_number( __('No comments', langdomain()), __('One comment', langdomain()), __('% comments', langdomain()) ); ?></a></div>
    </div>
</div>