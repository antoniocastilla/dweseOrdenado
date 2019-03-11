<?php
/*
	Template Name: Blog
*/
get_header();

?>
<body>
<?php
    get_template_part('templates/nav','front');
?>

<section class="page-title parallax3 parallax-fix page-title-large" style="height: 60vh;">
            <div class="opacity-medium bg-black"></div>
            <img class="parallax-background-img" src="/assets/img/multiple.jpg" alt="" />
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center animated fadeInUp">
                        <!-- page title -->
                        <h1 class="white-text"><?php _e('8Beast Blog', langdomain()); ?></h1>
                        <!-- end page title -->
                        <div class="separator-line bg-yellow no-margin-top margin-four"></div>
                        <!-- page title tagline -->
                        <span class="white-text"><?php _e('Latest news and releases', langdomain()); ?></span>
                        <!-- end title tagline -->
                    </div>
                </div>
            </div>
        </section>
 
<?php
//NORMAL ENTRIES

//$paged = get_query_var('paged') > 1 ? get_query_var('paged') : 1 ;
//$paged = get_query_var('paged') ? get_query_var('paged') : 1 ;
/*$arguments=array(
    'posts_per_page' => 1,
    'post_type' => array('post', 'eightbeast_shoe'),
    'paged' => $paged
    );
$custom_query = new WP_Query($arguments); */?>

        <section class="wow fadeIn">
            <div class="container">
                <div class="row">
                    <!-- content  -->
                    <div class="col-md-8 col-sm-8">
                        <!-- post item -->
                        
                        <?php if (have_posts()) : ?>
                        <?php while (have_posts()): ?>
                        <?php the_post(); ?>
                            <?php if (get_post_type() == 'eightbeast_shoe') {
                                get_template_part('templates/content', 'launch');
                            } else {
                                get_template_part('templates/content', get_post_format());
                            }
              
                        endwhile; ?>
                        <?php endif; 
                        wp_reset_postdata();
                        ?>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <?php 
                                    
                                    $backtag = '<img src="' . get_template_directory_uri() . '/images/arrow-pre-small.png" alt=""/>';
                                    $fwdtag = '<img src="' . get_template_directory_uri() . '/images/arrow-next-small.png" alt=""/>';
                                    
                                    the_posts_pagination( array(
                                        'mid_size' => 2,
                                        'prev_text' => $backtag,
                                        'next_text' => $fwdtag,
                                        'screen_reader_text' => '&nbsp;',
                                    ) ); ?>
                            </div>
                        </div>
                        
                    </div>
                    <!-- end content  -->
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </section>
        


<?php
get_footer();
?>