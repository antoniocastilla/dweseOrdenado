<!-- post date and categories  -->
<div class="blog-date no-padding-top"><?php _e('Posted by ', langdomain()); ?><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a> | <?php echo get_the_date( get_option('date_format') ); ?> | <?php echo get_num_visits(get_the_ID()); ?></div>
<!-- end date and categories   -->
<!-- post title  -->
<h2 class="blog-details-headline text-black"><?php the_title(); ?></h2>
 <!-- end post title  -->
<!-- post image -->
<div class="blog-image margin-eight"><img src="<?php echo get_the_post_thumbnail_url();?>" alt="" ></div>
<!-- end post image -->
<!-- post details text -->
<div class="blog-details-text">
<p><?php the_content(); ?></p>
<div class="row blog-date no-padding-top margin-eight no-margin-bottom">
<!-- post tags -->
<div class="col-md-6">
<h5 class="widget-title margin-one no-margin-top"><?php _e('Category', langdomain()); ?></h5>
<?php the_category(', '); ?>
</div>
<div class="col-md-6">
<h5 class="widget-title margin-one no-margin-top"><?php _e('Tags', langdomain()); ?></h5>
<?php the_tags('', ', ', ''); ?>
</div>

</div>
<!-- end post tags -->
</div>