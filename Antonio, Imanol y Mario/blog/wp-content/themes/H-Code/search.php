<?php
get_header();
?>
<body>
<?php
    get_template_part('templates/nav','front');
?>

<?php
    $total_results = $wp_the_query->found_posts; //post_count
    switch ($total_results) {
        case 0: $label = _e('NO', langdomain());
        break;
        default: $label = $total_results;
        break;
    }
?>

<section class="page-title parallax3 parallax-fix page-title-large">
            <div class="opacity-medium bg-black"></div>
            <img class="parallax-background-img" src="/assets/img/multiple.jpg" alt="" />
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center animated fadeInUp">
                        <!-- page title -->
                        <h1 class="white-text">Search Query</h1>
                        <div class="separator-line bg-yellow no-margin-top margin-four"></div>
                        
                        <h3 class="white-text"><?php _e('Found ', langdomain()) ?><?php echo $label; ?><?php _e(' RESULTS', langdomain()) ?></h1>
                        <!-- end page title -->
                        <!-- page title tagline -->
                        <span class="white-text"><?php echo $label; ?><?php echo _e(' ITEMS COINCIDE WITH THE SEARCH TERM ', langdomain()); ?> <?php echo get_search_query(); ?></span>
                        <!-- end title tagline -->
                    </div>
                </div>
            </div>
        </section>


        <section class="wow fadeIn">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 center-block text-center">
                        <div class="widget">
                            <?php get_search_form(); ?>
                        </div>
                    </div>
                    <div class="col-md-4 center-block ws-s categories-widget">
                        <h5 class="header-widget"><?php echo _e('Categories', langdomain()); ?></h5>
                        <?php
                                $args = array(
                                        'show_count' => 1,
                                        'title_li' => '',
                                    );
                                wp_list_categories($args); // OFFICIAL FUNCTION
                                ?>
        
                    </div><!-- / .categories-widget -->
                </div>
                <div class="row">
                    <!-- content  -->
                    <div class="col-md-11 col-sm-10">
                        <!-- TABLE item -->
                        <?php if (have_posts()) : ?>
                        <div class="col-md-12 col-sm-12 center-col table-scroll">
                            <table class="table">
                            <thead>
                              <tr>
                                <th><?php echo _e('Time', langdomain()); ?></th>
                                <th><?php echo _e('Author', langdomain()); ?></th>
                                <th><?php echo _e('Title', langdomain()); ?></th>
                                <th><?php echo _e('Type', langdomain()); ?></th>
                              </tr>
                            </thead>
                            <tbody>
                            
                        <?php while (have_posts()): ?>
                        <?php the_post();
                            get_template_part('templates/content','list');
                        endwhile; ?>    
                        
                        </tbody>
                      </table><!-- / .table -->
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
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
        </section>
        


<?php
get_footer();
?>