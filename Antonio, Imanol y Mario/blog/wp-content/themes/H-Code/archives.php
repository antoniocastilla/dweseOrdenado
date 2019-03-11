<?php
/* 
    
        Template Name: Archives
*/
get_header();
?>
<body>
<?php
    get_template_part('templates/nav','front');
?>
        <!-- head section -->
        <section class="content-top-margin page-title bg-gray">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-7 col-sm-12 wow fadeInUp" data-wow-duration="300ms">
                        <!-- page title -->
                        <h1 class="black-text"><?php echo get_better_page_name(); ?></h1>
                        <!-- end page title -->
                        <!-- page title tagline -->
                        <span class="xs-display-none"><?php _e('Find your way around our blog.', langdomain()); ?></span>
                        <!-- end title tagline -->
                        <div class="separator-line margin-three bg-black no-margin-lr sm-margin-top-three sm-margin-bottom-three no-margin-bottom xs-display-none"></div>
                    </div>
                    <div class="col-lg-4 col-md-5 col-sm-12 breadcrumb text-uppercase sm-no-margin-top wow fadeInUp xs-display-none" data-wow-duration="600ms">
                        <!-- breadcrumb -->
                        <?php the_breadcrumb(); ?>
                        <!-- end breadcrumb -->
                    </div>
                </div>
            </div>
        </section>
        <!-- end head section -->

        <!-- content section -->
        <section class="wow">
            <div class="container">
                <div class="row blog-masonry blog-masonry-3col no-transition">
                    
                    <?php
                       //Get posts of a single author
                       $thisauthor = get_users(
                        array(
                         'fields' => array( 'display_name', 'ID' ),
                         'has_published_posts' => array( 'post' ),
                         'orderby' => 'post_count',
                         'order' => 'desc'
                        ));
                       
                       foreach ($thisauthor as $auth) {
                       
                       ?>
                       
                    <!-- post item -->
                    <div class="col-md-4 col-sm-6 col-xs-6 blog-listing">
                        <div class="blog-details">
                            <a href="<?php echo get_author_posts_url( $auth->ID ); ?>"><h5 class="widget-title font-alt"><?php _e('Posts by ', langdomain()); ?><?php echo $auth->display_name ?></h5></a>
                            <div class="separator-line bg-black no-margin-lr"></div>
                            <div class="blog-short-description">
                                <?php
                                 $args =
                                    array(
                                     'post_type' => array('post', 'eightbeast_shoe'),
                                     'author'      => $auth->ID,
                                     'orderby'     => 'date',
                                     'numberposts' => 6
                                   );
                                 $posts_by_author = get_posts($args);
                                 echo '<ul class="archives">';
                                 foreach ($posts_by_author as $post) {
                                   echo '<li><a href="'.get_the_permalink($post->ID).'"> '.$post->post_title. '</a></li>';
                                 }
                               ?>
                            </div>
                        </div>
                    </div>
                    <?php
                      }
                    ?>
                    
                    
                    <!-- Tag list -->
                    <div class="col-md-4 col-sm-6 col-xs-6 blog-listing">
                        <div class="blog-details">
                            <h5 class="widget-title font-alt"><?php _e('Tag cloud', langdomain()); ?></h5>
                            <div class="separator-line bg-black no-margin-lr"></div>
                            <div class="blog-short-description">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Widgets')) : ?>
                                  <div class="warning"><?php _e('No widgets installed here', langdomain()); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!-- end post item -->
                    
                    <!-- Tag list -->
                    <div class="col-md-4 col-sm-6 col-xs-6 blog-listing">
                        <div class="blog-details">
                            <h5 class="widget-title font-alt"><?php _e('Tag list', langdomain()); ?></h5>
                            <div class="separator-line bg-black no-margin-lr"></div>
                            <ul><?php
                                $tags = get_tags();
                            if ( $tags ) :
                                foreach ( $tags as $tag ) : ?>
                                    <li class="cat-item"><i class="fa fa-tag mr-2"></i><a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" title="<?php echo esc_attr( $tag->name ); ?>"> <?php echo esc_html( $tag->name ); ?></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <!-- end post item -->
                    
                    
                    <!-- cat list -->
                    <div class="col-md-4 col-sm-6 col-xs-6 blog-listing">
                        <div class="blog-details">
                            <h5 class="widget-title font-alt"><?php _e('Category list', langdomain()); ?></h5>
                            <div class="separator-line bg-black no-margin-lr"></div>
                            <div class="widget-body">
                                <?php
                                $args = array(
                                        'show_count' => 1,
                                        'title_li' => '',
                                        'echo' => 0,
                                    );
                                    $dailypost = wp_list_categories($args); // OFFICIAL FUNCTION
                                    $dailypost = preg_replace( '~(\(\d++\))~', '&nbsp;&nbsp;/$1', $dailypost );
                                    $dailypost = preg_replace('/[\(\)]/', '', $dailypost); 
                                    echo $dailypost;
                                ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- most commented post list -->
                    <div class="col-md-4 col-sm-6 col-xs-6 blog-listing">
                        <div class="blog-details">
                            <h5 class="widget-title font-alt"><?php _e('Most commented posts', langdomain()); ?></h5>
                            <div class="separator-line bg-black no-margin-lr"></div>
                            <?php
                                $args = array (
                                    'post_type' => array('post', 'eightbeast_shoe'),
                                  'orderby' => 'comment_count',
                                  'posts_per_page' => 6,
                                );
                                $most = new WP_Query( $args );
                                echo '<ul>';
                                while ( $most->have_posts() ) : $most->the_post();
                                       echo '<li class="cat-item"><a href="'.get_the_permalink().'">'. get_the_title().'</a>&nbsp;&nbsp;/'.get_comments_number().'</li>';
                                 endwhile;
                                 echo '</ul>';
                                 wp_reset_postdata();
                            ?>
                            
                            
                        </div>
                    </div>
                    <!-- end post item -->
                    
                    <!-- Tag list -->
                    <div class="col-md-4 col-sm-6 col-xs-6 blog-listing">
                        <div class="blog-details">
                            <h5 class="widget-title font-alt"><?php _e('Latest posts', langdomain()); ?></h5>
                            <div class="separator-line bg-black no-margin-lr"></div>
                            <ul>
                            <?php 
                                    $args = array (
                                        'type' => 'postbypost',
                                        'show_post_count' => 1,
                                        'echo' => false,
                                        'limit' => 6
                                    );
                                    /*<i class="fa fa-calendar"></i>*/
                                    $dailypost = wp_get_archives( $args );
                                    $dailypost = preg_replace( '~(&nbsp;)(\(\d++\))~', ' $1 <span> /$2</span>', $dailypost );
                                    $dailypost = preg_replace('/[\(\)]/', '', $dailypost); 
                                    echo $dailypost;
                                ?>
                            </ul>
                        </div>
                    </div>
                    <!-- end post item -->
                    
                    <!-- Tag list -->
                    <div class="col-md-4 col-sm-6 col-xs-6 blog-listing">
                        <div class="blog-details">
                            <h5 class="widget-title font-alt"><?php _e('Daily posts', langdomain()); ?></h5>
                            <div class="separator-line bg-black no-margin-lr"></div>
                            <ul>
                            <?php 
                                    $args = array (
                                        'type' => 'daily',
                                        'show_post_count' => 1,
                                        'echo' => false,
                                        'limit' => 7
                                    );
                                    /*<i class="fa fa-calendar"></i>*/
                                    $dailypost = wp_get_archives( $args );
                                    $dailypost = preg_replace( '~(&nbsp;)(\(\d++\))~', ' $1 <span> /$2</span>', $dailypost );
                                    $dailypost = preg_replace('/[\(\)]/', '', $dailypost); 
                                    echo $dailypost;
                                ?>
                            </ul>
                        </div>
                    </div>
                    <!-- end post item -->
                    
                    <!-- Tag list -->
                    <div class="col-md-4 col-sm-6 col-xs-6 blog-listing">
                        <div class="blog-details">
                            <h5 class="widget-title font-alt"><?php _e('Monthly posts', langdomain()); ?></h5>
                            <div class="separator-line bg-black no-margin-lr"></div>
                            <ul>
                            <?php 
                                    $args = array (
                                        'type' => 'monthly',
                                        'show_post_count' => 1,
                                        'echo' => false,
                                        'limit' => 6
                                    );
                                    /*<i class="fa fa-calendar"></i>*/
                                    $dailypost = wp_get_archives( $args );
                                    $dailypost = preg_replace( '~(&nbsp;)(\(\d++\))~', ' $1 <span> /$2</span>', $dailypost );
                                    $dailypost = preg_replace('/[\(\)]/', '', $dailypost); 
                                    echo $dailypost;
                                ?>
                            </ul>
                        </div>
                    </div>
                    <!-- end post item -->
                    
                    <!-- Tag list -->
                    <div class="col-md-4 col-sm-6 col-xs-6 blog-listing">
                        <div class="blog-details">
                            <h5 class="widget-title font-alt"><?php _e('Yearly posts', langdomain()); ?></h5>
                            <div class="separator-line bg-black no-margin-lr"></div>
                            <ul>
                            <?php 
                                    $args = array (
                                        'type' => 'yearly',
                                        'show_post_count' => 1,
                                        'echo' => false,
                                        'limit' => 5
                                    );
                                    /*<i class="fa fa-calendar"></i>*/
                                    $dailypost = wp_get_archives( $args );
                                    $dailypost = preg_replace( '~(&nbsp;)(\(\d++\))~', ' $1 <span> /$2</span>', $dailypost );
                                    $dailypost = preg_replace('/[\(\)]/', '', $dailypost); 
                                    echo $dailypost;
                                ?>
                            </ul>
                        </div>
                    </div>
                    <!-- end post item -->
                    
                    
                    
                    <?php //Popular posts
                        
                        $args = array(
                            'post_type' => array('post', 'eightbeast_shoe'),
                            'meta_key' => 'postsvisits', 
                            'orderby' => 'meta_value_num', // <-------
                            'order' => 'DESC',
                            'posts_per_page' => 3
                        );
                        
                        $sidequery = new WP_Query( $args );
                        
                        if ($sidequery->have_posts()) :
                        ?>        
                    
                    <!-- post item -->
                    <div class="col-md-4 col-sm-6 col-xs-6 blog-listing">
                        <div class="blog-details">
                            <h5 class="widget-title font-alt"><?php _e('Popular posts', langdomain()); ?></h5>
                            <div class="separator-line bg-black no-margin-lr"></div>
                                <ul class="widget-posts">
                                    
                                    <?php while ($sidequery->have_posts()) : ?>
                                    <?php $sidequery -> the_post(); ?>
                                    <li class="clearfix">
                                        <div class="widget-posts-details"><a href="<?php get_the_permalink(); ?>"><?php the_title(); ?></a> <?php echo get_num_visits_nosum(get_the_ID()); ?> - <?php the_time('j');?> <?php the_time('M');?> <?php the_time('Y');?></div>
                                    </li>
                                    
                                    <?php endwhile; ?>
                                </ul>
                        </div>
                    </div>
                    <!-- end post item -->
                    <?php endif;
                    wp_reset_postdata(); ?>
                    
                </div>
            </div>
        </section>
<?php
get_footer();
?>