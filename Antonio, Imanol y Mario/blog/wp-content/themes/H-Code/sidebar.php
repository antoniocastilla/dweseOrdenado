<!-- sidebar  -->
<div class="col-md-3 col-sm-4 col-md-offset-1 xs-margin-top-ten sidebar">
    <!-- widget  
    <div class="widget">
        <form>
            <i class="fa fa-search close-search search-button"></i>
            <input type="text" placeholder="Search..." class="search-input" name="search">
        </form>
    </div>-->
    <!-- end widget  -->
    <!-- SEARCH WIDGET widget  -->
    
    <div class="widget">
        <?php get_search_form(); ?>
    </div>
    <!-- end widget  -->
    <!-- widget  -->
    <div class="widget">
        <h5 class="widget-title font-alt"><?php _e('Tag cloud', langdomain()); ?></h5>
        <div class="thin-separator-line bg-dark-gray no-margin-lr"></div>
            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Widgets')) : ?>
              <div class="warning"><?php _e('No widgets installed here', langdomain()); ?></div>
            <?php endif; ?>
    </div>
    <!-- end widget  -->
    <!-- widget  -->
    <div class="widget">
        <h5 class="widget-title font-alt"><?php _e('Categories', langdomain()); ?></h5>
        <div class="thin-separator-line bg-dark-gray no-margin-lr"></div>
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
    

    <div class="widget">
        <h5 class="widget-title font-alt"><?php _e('Monthly posts', langdomain()); ?></h5>
        <div class="thin-separator-line bg-dark-gray no-margin-lr"></div>
        <div class="widget-body">
            <ul>
        <?php 
                $args = array (
                    'type' => 'monthly',
                    'show_post_count' => 1,
                    'echo' => false
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
    <!-- end widget  -->
    
    
    <div class="widget">
        <h5 class="widget-title font-alt"><?php _e('Authors', langdomain()); ?></h5>
        <div class="thin-separator-line bg-dark-gray no-margin-lr"></div>
        <div class="widget-body">
            <?php
                $args = array(
                    'orderby'       => 'nicename', 
                    'order'         => 'ASC',
                    'has_published_posts' => true,
                    'optioncount' => 1,
                    'echo' => false,
                );
                $dailypost = wp_list_authors($args);
                $dailypost = preg_replace( '/[\(]/', '&nbsp;&nbsp;/', $dailypost );
                $dailypost = preg_replace( '/[\)]/', '', $dailypost );
                echo $dailypost;
            ?>
        </div>
    </div>
    <!-- end widget  -->
    
    
    
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
    <!-- widget  -->
    <div class="widget">
        <h5 class="widget-title font-alt"><?php _e('Popular posts', langdomain()); ?></h5>
        <div class="thin-separator-line bg-dark-gray no-margin-lr"></div>
        <div class="widget-body">
            <ul class="widget-posts">
                
                <?php while ($sidequery->have_posts()) : ?>
                <?php $sidequery -> the_post(); ?>
                <li class="clearfix">
                    <div class="widget-posts-details"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a> <?php echo get_num_visits_nosum(get_the_ID()); ?> - <?php the_time('j');?> <?php the_time('M');?> <?php the_time('Y');?></div>
                </li>
                
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
    <!-- end widget  -->
    <?php endif; wp_reset_postdata();?>
    
    
    <?php //TOP COMMENTED POSTS
    $args = array (
        'post_type' => array('post', 'eightbeast_shoe'),
      'orderby' => 'comment_count',
      'posts_per_page' => 4,
    );
    $most = new WP_Query( $args );
    
    if ($most->have_posts()) :
    ?>        
    <!-- widget  -->
    <div class="widget">
        <h5 class="widget-title font-alt"><?php _e('Most commented posts', langdomain()); ?></h5>
        <div class="thin-separator-line bg-dark-gray no-margin-lr"></div>
        <div class="widget-body">
            <?php
            $args = array (
              'orderby' => 'comment_count',
              'posts_per_page' => 3,
            );
            $most = new WP_Query( $args );
            echo '<ul>';
            while ( $most->have_posts() ) : $most->the_post();
                   $num_comments = get_comments_number( $post->ID );
                   echo '<li class="cat-item"><a href="'.get_the_permalink($post->ID).'">'. get_the_title().'</a>&nbsp;&nbsp;/'.$num_comments.'</li>';
             endwhile;
             echo '</ul>';
            ?>
        </div>
    </div>
    <!-- end widget  -->
    <?php endif; wp_reset_postdata();?>

</div>
<!-- end sidebar  -->