<?php
get_header();
?>
<body>
<?php
    get_template_part('templates/nav','front');
    the_post();
    $author_ID = get_the_author_meta('ID');
?>

        <!-- head section -->
        <section class="content-top-margin page-title page-title-small bg-gray">
            <div class="container">
                <div class="row">
                    <div class="col-md-7 col-sm-12 wow fadeInUp" data-wow-duration="300ms">
                        <!-- page title -->
                        <h1 class="black-text"><?php echo _e('Blog Post', langdomain()); ?></h1>
                        <!-- end page title -->
                    </div>
                    <div class="col-md-5 col-sm-12 breadcrumb text-uppercase wow fadeInUp xs-display-none" data-wow-duration="600ms">
                        <!-- breadcrumb -->
                        <?php the_breadcrumb(); ?>
                        <!-- end breadcrumb -->
                    </div>
                </div>
            </div>
        </section>
        <!-- end head section -->

        <!-- content section -->
        <section class="wow fadeIn">
            <div class="container">
                <div class="row">
                    <!-- content  -->
                    <div class="col-md-8 col-sm-8">
                        <?php
                        if (get_post_type() == 'eightbeast_shoe') {
                            get_template_part('templates/single', 'launch');
                        } else {
                            $format = get_post_format() ? : 'standard';
                            get_template_part('templates/single', $format);
                        }

                        $fname = get_the_author_meta('first_name',$author_ID);
                        $lname = get_the_author_meta('last_name',$author_ID);
                        $full_name = '';
                        
                        if( empty($fname)){
                            $full_name = $lname;
                        } elseif( empty( $lname )){
                            $full_name = $fname;
                        } else {
                            //both first name and last name are present
                            $full_name = "{$fname} {$lname}";
                        }
                        ?>
                        
                        <!-- about author KEEP-->
                        <div class="text-center margin-eight about-author text-left bg-gray border-bottom">
                            <div class="blog-comment text-left clearfix no-margin">
                                <!-- author image -->
                                
                                <?php
                                    $field = get_the_author_meta('avatar-custom', $author_ID);
                                    if ($field != null || $field !='') : ?>
                                        <a class="comment-avtar no-margin-top"><img src="<?php echo $field ?>" alt=""></a>
                                    <?php else: ?>
                                        <a class="comment-avtar no-margin-top"><img src="<?php echo get_avatar_url($author_ID); ?>" alt=""></a>
                                    <?php endif; ?>
                                <!-- end author image -->
                                <!-- author text -->
                                <div class="comment-text overflow-hidden position-relative">
                                    <h5 class="widget-title"><?php echo _e('About The Author', langdomain()); ?></h5>
                                    <p class="blog-date no-padding-top"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo $full_name; ?></a> - <?php echo get_the_author_meta('user-formalrole', $author_ID); ?></p>
                                    <p class="about-author-text no-margin"><?php echo get_the_author_meta('description', $author_ID); ?></p>
                                </div>
                                <!-- end author text -->
                            </div>
                        </div>
                        <!-- end about author -->
                        <!-- social icon 
                        <div class="text-center border-bottom margin-ten padding-four no-margin-top">
                            <a href="#" class="btn social-icon social-icon-large button"><i class="fa fa-facebook"></i></a>
                            <a href="#" class="btn social-icon social-icon-large button"><i class="fa fa-twitter"></i></a>
                            <a href="#" class="btn social-icon social-icon-large button"><i class="fa fa-google-plus"></i></a>
                            <a href="#" class="btn social-icon social-icon-large button"><i class="fa fa-tumblr"></i></a>
                            <a href="#" class="btn social-icon social-icon-large button"><i class="fa fa-instagram"></i></a>
                        </div>-->
                        
                        <?php //Posts of this author
                        wp_reset_postdata();
                            $arguments=  array(
                                'category__in'   => wp_get_post_categories( get_the_ID() ),
                                'posts_per_page' => 4,
                                'post__not_in'   => array( get_the_ID() )
                            );
                            $custom_query = new WP_Query($arguments); ?>

                            <?php if ($custom_query -> have_posts()) : ?>
                            <div class="row blog-4col margin-ten no-margin-top">
                                    <!-- post item -->
                                <?php while ($custom_query -> have_posts()): ?>
                                <?php $custom_query->the_post(); ?>
                                
                                    <div class="col-md-6 col-sm-6 col-xs-6 blog-listing wow fadeInUp animated" data-wow-duration="300ms" style="visibility: visible; animation-duration: 300ms; animation-name: fadeInUp;">
                                        <div class="blog-image"><a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo get_the_post_thumbnail_url();?>" alt=""></a></div>
                                        <div class="blog-details">
                                            <div class="blog-date"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_date(); ?></div>
                                            <div class="blog-title"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></div>
                                            <div class="blog-short-description"><?php the_excerpt(); ?></div>
                                            <div class="separator-line bg-black no-margin-lr"></div>
                                            <div><a href="<?php echo get_comments_link(); ?>" class="comments"><i class="fa fa-comment-o"></i><?php echo comments_number( __('No comments', langdomain()), __('One comment', langdomain()), __('% comments', langdomain()) ); ?></a></div>
                                        </div>
                                    </div>
                                    <!-- end post item -->
                                <?php endwhile; ?>
                            </div>
                            <?php endif;
                            wp_reset_postdata();
                            ?>
                        
                        <!-- end social icon -->
                        
                        <?php comments_template(); ?>
                    </div>
                    <?php if (get_post_type() == 'eightbeast_shoe') {
                        get_sidebar('custom');
                    } else {
                        get_sidebar();
                    } ?>
                </div>
            </div>
        </section>
        <!-- end content section -->
        
<?php
get_footer();
?>