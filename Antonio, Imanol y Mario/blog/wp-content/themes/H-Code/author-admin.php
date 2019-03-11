<?php
get_header();
?>
<body>
<?php
    get_template_part('templates/nav','front');
    $curauth = (get_query_var('author_name')) ? get_user_by('slug',
                get_query_var('author_name')) : get_userdata(get_query_var('author'));
?>
        <section class="content-top-margin page-title page-title-small bg-gray">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-sm-12 wow fadeInUp" data-wow-duration="300ms">
                        <!-- page title -->
                        <h1 class="black-text"><?php echo get_author_role($curauth->ID); ?></h1>
                        <?php if (is_user_logged_in() && (wp_get_current_user()->ID == $curauth->ID)) { ?>
                            <a class="btn-warning btn btn-small button btn-round mt-3" href="<?php echo wp_logout_url( home_url() ); ?>"><?php _e('Logout', langdomain()); ?></a>
                        <?php } ?>
                    </div>
                    <div class="col-md-4 col-sm-12 breadcrumb text-uppercase wow fadeInUp xs-display-none" data-wow-duration="600ms">
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
                    <div class="col-md-11 col-sm-10">

                        <div class="row">
                                <div class="col-md-4 col-sm-6 text-center team-member position-relative wow fadeInUp" data-wow-duration="300ms">
                                    <?php
                                          $field = get_the_author_meta('avatar-custom', $curauth->ID);
                                          if ($field != null || $field !='') : ?>
                                            <img src="<?php echo $field ?>" alt=""/>
                                          <?php else: ?>
                                          <div class="t-image img-fluid">
                                            <img src="<?php echo get_avatar_url($curauth->ID); ?>" alt=""/>
                                          </div>
                                      <?php endif; ?>
                                      
                                        
                                        <figure class="position-relative bg-white">
                                            <span class="team-name text-uppercase black-text letter-spacing-2 display-block font-weight-600"><?php echo $curauth->display_name; ?></span>
                                            <span class="team-post text-uppercase letter-spacing-2 display-block"><?php echo get_the_author_meta('user-formalrole', $curauth->ID); ?></span>
                                        </figure>
                                    </div>

                                    <div class="col-md-8 col-sm-6 text-center team-member position-relative wow fadeInUp" data-wow-duration="300ms">
                                            <h2 class="blog-details-headline text-black"><?php echo the_author_meta('user-custom-quote', $curauth->ID); ?></h2>
                                            <p class="text-large"><?php echo the_author_meta('description', $curauth->ID); ?></p>

                                            <div class="text-center border-bottom margin-ten padding-four no-margin-top">
                                                
                                                <?php
                                                  $field = get_the_author_meta('social-facebook', $curauth->ID);
                                                  if ($field != null || $field !='') : ?>
                                                    <a href="<?php echo $field ?>" class="btn social-icon social-icon-large button"><i class="fa fa-facebook"></i></a>
                                                  <?php endif; ?>
                                                  
                                                  <?php
                                                  $field = get_the_author_meta('social-twitter', $curauth->ID);
                                                  if ($field != null || $field !='') : ?>
                                                    <a href="<?php echo $field ?>" class="btn social-icon social-icon-large button"><i class="fa fa-twitter"></i></a>
                                                  <?php endif; ?>
                                                  
                                                  
                                                  <?php
                                                  $field = get_the_author_meta('social-linkedin', $curauth->ID);
                                                  if ($field != null || $field !='') : ?>
                                                    <a href="<?php echo $field ?>" class="btn social-icon social-icon-large button"><i class="fa fa-linkedin"></i></a>
                                                  <?php endif; ?>
                                                  
                                                  <?php
                                                  $field = get_the_author_meta('social-instagram', $curauth->ID);
                                                  if ($field != null || $field !='') : ?>
                                                    <a href="<?php echo $field ?>" class="btn social-icon social-icon-large button"><i class="fa fa-instagram"></i></a>
                                                  <?php endif; ?>
                                            </div>
                                        </div>

                                        
                        </div>


                        <div class="row mymargin-bottom">
                                <div class="text-center center-col">
                                    <!-- pie charts -->
                                    <div class="col-md-3 col-sm-3 chart-style2 wow zoomIn xs-margin-bottom-ten animated" style="visibility: visible; animation-name: zoomIn;">
                                        <div class="chart-percent"><span class="chart2 black-text" data-percent="<?php echo the_author_meta('sk1', $curauth->ID); ?>"><span class="percent"><?php echo the_author_meta('sk1', $curauth->ID); ?></span> <canvas height="120" width="120"></canvas></span></div>
                                        <div class="chart-text">
                                            <h5 class="black-text"><?php _e('Web Development', langdomain()); ?></h5>
                                        </div>
                                    </div>
                                    <!-- end pie charts -->
                                    <!-- pie charts -->
                                    <div class="col-md-3 col-sm-3 chart-style2 wow zoomIn xs-margin-bottom-ten animated" style="visibility: visible; animation-name: zoomIn;">
                                        <div class="chart-percent"><span class="chart2 black-text" data-percent="<?php echo the_author_meta('sk2', $curauth->ID); ?>"><span class="percent"><?php echo the_author_meta('sk2', $curauth->ID); ?></span><canvas height="120" width="120"></canvas></span></div>
                                        <div class="chart-text">
                                            <h5 class="black-text"><?php _e('Web Design', langdomain()); ?></h5>
                                        </div>
                                    </div>
                                    <!-- end pie charts -->
                                    <!-- pie charts -->
                                    <div class="col-md-3 col-sm-3 chart-style2 wow zoomIn xs-margin-bottom-ten animated" style="visibility: visible; animation-name: zoomIn;">
                                        <div class="chart-percent"><span class="chart2 black-text" data-percent="<?php echo the_author_meta('sk3', $curauth->ID); ?>"><span class="percent"><?php echo the_author_meta('sk3', $curauth->ID); ?></span> <canvas height="120" width="120"></canvas></span></div>
                                        <div class="chart-text">
                                            <h5 class="black-text"><?php _e('Graphic Design', langdomain()); ?></h5>
                                        </div>
                                    </div>
                                    <!-- end pie charts -->
                                    <!-- pie charts -->
                                    <div class="col-md-3 col-sm-3 chart-style2 wow zoomIn animated" style="visibility: visible; animation-name: zoomIn;">
                                        <div class="chart-percent"><span class="chart2 black-text" data-percent="<?php echo the_author_meta('sk4', $curauth->ID); ?>"><span class="percent"><?php echo the_author_meta('sk4', $curauth->ID); ?></span> <canvas height="120" width="120"></canvas></span></div>
                                        <div class="chart-text">
                                            <h5 class="black-text"><?php _e('Marketing', langdomain()); ?></h5>
                                        </div>
                                    </div>
                                    <!-- end pie charts -->
                                </div>
                            </div>
                            
                            <?php //Posts of this author
                            $arguments=array(
                              'posts_per_page' => 3,
                              'author__in' => array($curauth->ID),
                            );
                            $custom_query = new WP_Query($arguments); ?>

                            <?php if ($custom_query -> have_posts()) : ?>
                            <div class="row blog-4col">
                                    <!-- post item -->
                                <?php while ($custom_query -> have_posts()): ?>
                                <?php $custom_query->the_post(); ?>
                                
                                    <div class="col-md-4 col-sm-6 col-xs-6 blog-listing wow fadeInUp animated" data-wow-duration="300ms" style="visibility: visible; animation-duration: 300ms; animation-name: fadeInUp;">
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
                            wp_reset_postdata(); ?>

                    </div>
                </div>
            </div>
        </section>
        <!-- end content section -->
<?php
get_footer();
?>