<!--Normal content layout done -->
<div class="blog-listing blog-listing-classic wow fadeIn">
    <div class="blog-details">
        <div class="blog-date"><?php _e('Posted by ', langdomain()); ?><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a> | <?php echo get_the_date( get_option('date_format') ); ?> | <?php the_category(', '); ?> </div>
        <div class="blog-title"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></div>
    </div>
    <!-- post image -->
    <div class="blog-image"><a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo get_the_post_thumbnail_url();?>" alt=""/></a></div>
    <!-- end post image -->
    <div class="blog-details">
        <div><?php the_excerpt(); ?></div>
        <div class="separator-line bg-black no-margin-lr margin-four"></div>
        <div><a href="<?php echo get_comments_link(); ?>" class="comments"><i class="fa fa-comment-o"></i><?php echo comments_number( __('No comments', langdomain()), __('One comment', langdomain()), __('% comments', langdomain()) ); ?></a></div>
        <a class="highlight-button btn btn-small xs-no-margin-bottom" href="<?php echo get_the_permalink(); ?>"><?php _e('Continue Reading', langdomain()); ?></a>
    </div>
</div>