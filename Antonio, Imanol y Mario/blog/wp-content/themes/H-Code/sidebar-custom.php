                    <!-- sidebar  -->
                    <div class="col-md-3 col-sm-4 col-md-offset-1 xs-margin-top-ten sidebar">
                        <?php //Popular posts
                        
                        $args = array(
                            'post_type' => get_post_type(),
                            'order_by' => 'post_date',
                            'order' => 'DESC',
                            'posts_per_page' => 3,
                            'post__not_in' => array($post->ID),
                        );
                        
                        $custom_query = new WP_Query( $args );
                        
                        if ($custom_query -> have_posts()) : ?>
                        
                        <div class="widget">
                            <h5 class="widget-title font-alt"><?php _e('Other offerings', langdomain()); ?></h5>
                            <div class="separator-line bg-yellow no-margin-lr"></div>
                            <div class="row blog-1col">
                                    <!-- post item -->
                                <?php while ($custom_query -> have_posts()): ?>
                                <?php $custom_query->the_post();
                                $custom_fields = get_post_custom();
                                $shoe_model = $custom_fields['model_shoe'][0];
                                $shoe_brand = $custom_fields['brand_shoe'][0];
                                
                                $preview = get_first_image();
                                if (!isset($preview)) {
                                    $preview = '../assets/shoes/aaa_no_shoe.jpg';
                                }
                                ?>
                                
                                    <div class="col-md-12 blog-listing wow fadeInUp animated" data-wow-duration="300ms" style="visibility: visible; animation-duration: 300ms; animation-name: fadeInUp;">
                                        <div class="blog-image"><a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $preview;?>" alt=""></a></div>
                                        <div class="blog-details">
                                            <div class="blog-date"><?php echo get_the_date( get_option('date_format') ); ?></div>
                                            <div class="blog-title"><a href="<?php echo get_the_permalink(); ?>"><?php echo $shoe_brand; ?> <?php echo $shoe_model; ?></a></div>
                                            <div><a href="<?php echo get_comments_link(); ?>" class="comments"><i class="fa fa-comment-o"></i><?php echo comments_number( __('No comments', langdomain()), __('One comment', langdomain()), __('% comments', langdomain()) ); ?></a></div>
                                        </div>
                                        <div class="thin-separator-line bg-black no-margin-lr"></div>
                                    </div>
                                    
                                    <!-- end post item -->
                                <?php endwhile; ?>
                            </div>
                        </div>    
                            
                            
                            <?php endif;
                            wp_reset_postdata(); ?>

                    </div>
                    <!-- end sidebar  -->