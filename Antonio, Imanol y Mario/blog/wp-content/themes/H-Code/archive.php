<?php
get_header();
?>
<body>
<?php
    get_template_part('templates/nav','front');
?>

<?php
    if (have_posts()) {
        $total_results = $wp_the_query->found_posts;
    };
    if ( $total_results > 1) {
        $results = $total_results." POSTS";
    }else{
        $results = $total_results." POST";
    };
            
?>
//
<?php
        
    if ( is_category() ) {
        $title = __('Category archives for: ', langdomain()) . '<span class="searchwords2">' . single_cat_title( '', false ) . ' </span>' ;

    } elseif ( is_tag() ) {
        $title = __('Tag archives for: ', langdomain()) .'<span class="searchwords2">' . single_tag_title( '', false ) . '</span>' ;
    } elseif ( is_author() ) {
              the_post();
              $title = __('Author archives for: ', langdomain()) .'<span class="vcard"><a class="url fn n searchwords" href="' 
              . get_author_posts_url( get_the_author_meta( "ID" ) ) . '" title="' . esc_attr( get_the_author() ) 
              . '" rel="me">' . get_the_author() . '</a> </span>';
              rewind_posts();

    } elseif ( is_day() ) {
        $title = __('Daily archives: ', langdomain()) .'<span class="searchwords">' . get_the_date() . ' </span>'  ;
    } elseif ( is_month() ) {
        $title = __('Monthly archives: ', langdomain()) .'<span class="searchwords">' . get_the_date( 'F Y' ) . ' </span>'  ;
    } elseif ( is_year() ) {
        $title = __('Yearly archives: ', langdomain()) .'<span class="searchwords">' . get_the_date( 'Y' ) . ' </span>'  ;
    } else {
        $title = __('Archives', langdomain());
    }
         
?>

<!-- INSERT SEARCH PAGE STUFF HERE -->


<section class="page-title parallax3 parallax-fix page-title-large">
            <div class="opacity-medium bg-black"></div>
            <img class="parallax-background-img" src="/assets/img/multiple.jpg" alt="" />
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center animated fadeInUp">
                        <h1 class="white-text"><?php _e('Post archives', langdomain()); ?></h1>
                        <div class="separator-line bg-yellow no-margin-top margin-four"></div>
                        <!-- page title -->
                        
                        <h3 class="white-text"><?php echo $results; ?><?php _e('FOUND', langdomain()); ?></h1>
                        <!-- end page title -->
                        <!-- page title tagline -->
                        <span class="white-text"><?php echo $title; ?></span>
                        <!-- end title tagline -->
                    </div>
                </div>
            </div>
        </section>


        <section class="wow fadeIn">
            <div class="container">
                <div class="row">
                    <!-- content  -->
                    <div class="col-md-8 col-sm-8">
                        <!-- TABLE item -->
                        
                        <?php if (have_posts()) : ?>
                        <div class="col-md-12 col-sm-12 center-col table-scroll">
                            <table class="table">
                            <thead>
                              <tr>
                                <th><?php _e('Time', langdomain()); ?></th>
                                <th><?php _e('Author', langdomain()); ?></th>
                                <th><?php _e('Title', langdomain()); ?></th>
                                <th><?php _e('Type', langdomain()); ?></th>
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