<?php 
$custom_fields = get_post_custom();
$store_link = $custom_fields['link_shoe'][0];
$shoe_model = $custom_fields['model_shoe'][0];
$shoe_brand = $custom_fields['brand_shoe'][0];

$preview = get_first_image();
if (!isset($preview)) {
    $preview = '../../assets/shoes/aaa_no_shoe.jpg';
}
?>


<div class="blog-date no-padding-top"><?php _e('Posted by ', langdomain()); ?><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a> | <?php echo get_the_date( get_option('date_format') ); ?> | <?php echo get_num_visits(get_the_ID()); ?></div>

<h2 class="blog-details-headline text-black"><?php the_title(); ?></h2>
 <!-- end post title  -->
 <!-- post date and categories  -->
<div class="blog-image margin-eight"><img src="<?php echo $preview;?>" alt="" ></div>
<!-- post title  -->

<div class="blog-details-text">
<p><?php the_content(); ?></p>
</div>

<div class="separator-line bg-yellow no-margin-lr margin-four"></div>
    <div class="row">
        <div class="blog-details col-md-6 col-sm-12">
            <div>
                <ul>
                    <?php
                    if (!empty($shoe_brand)) {
                        echo '<li><h4>Brand: '. $shoe_brand . '</h4></li>';
                    }
                    if (!empty($shoe_model)) {
                        echo '<li><h4>Brand: '. $shoe_model . '</h4></li>';
                    }
                    if (!empty($shoe_brand)) {
                        echo '<li><h4>Brand: '. $shoe_brand . '</h4></li>';
                    }
                    if (get_the_date( get_option('date_format')) != null && get_the_date( get_option('date_format')) != '') {
                        echo '<li><h4>Release date: ' .get_the_date( get_option('date_format')) . '</h4></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="blog-details">
            <a class="btn-success btn btn-medium no-margin" href="<?php echo $store_link; ?>">View Storefront</a>
        </div>
    </div>

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
