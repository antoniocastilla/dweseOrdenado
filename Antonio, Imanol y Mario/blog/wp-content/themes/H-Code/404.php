<?php
get_header();
?>
<body>
        <!-- content section -->
        <section class="no-padding-bottom wow fadeIn" style="background-image:url(/assets/img/lost.jpg); background-repeat: no-repeat; background-size:cover; height:100vh; background-position: center center;">
            <div class="container">
                <div class="row white-text" >
                    <div class="col-md-10 col-sm-8 col-xs-11 text-center center-col">
                        <p class="not-found-title white-text">404!</p>
                        <p class="text-med text-uppercase letter-spacing-2"><?php _e('The page you were looking', langdomain()); ?><br><?php _e('for could not be found.', langdomain()); ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-8 text-center center-col">
                        <div class="widget">
                            <?php get_search_form(); ?>
                        </div>
                    </div>
                </div>
                <div class="row margin-ten">
                        <!-- phone -->
                        <a class="col-md-4 col-sm-4 text-center" href="javascript:history.back()"><i class="fas fa-backward small-icon white-text"></i><h6 class="white-text margin-two no-margin-bottom"><?php _e('Previous page', langdomain()); ?></h6></a>
                        <!-- end phone -->
                        <!-- address -->
                        <a class="col-md-4 col-sm-4 text-center" href="<?php echo home_url(); ?>"><i class="fas fa-home small-icon white-text"></i><h6 class="white-text margin-two no-margin-bottom"><?php _e('Home', langdomain()); ?></h6></a>
                        <!-- end address -->
                        <!-- email -->
                        <a class="col-md-4 col-sm-4 text-center" href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>"><i class="fas fa-blog small-icon white-text"></i><h6 class="white-text margin-two no-margin-bottom"><?php _e('Blog', langdomain()); ?></h6></a>
                        <!-- end email -->
                    </div>
            </div>
        </section>
        <!-- end content section -->
<?php wp_footer(); ?>