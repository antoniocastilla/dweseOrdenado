<?php
/*
	Template Name: Drops
*/

get_header();
?>
<body>
<?php
    get_template_part('templates/nav','front');
?>

<!-- head section -->
        <section class="content-top-margin page-title page-title-small border-top-light">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-sm-12 wow fadeInUp" data-wow-duration="300ms">
                        <!-- page title -->
                        <h1 class="black-text"><?php echo get_better_page_name(); ?></h1>
                        <!-- end page title -->
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


<?php
        $args = array(
            'posts_per_page' =>2,
            'post_type' => array('eightbeast_shoe'),
            'order_by' => 'post_date',
            'order' => 'DESC'
                    );
        $post_destacado = new WP_Query($args);
        $ID_destacado = [];
        
        if($post_destacado->have_posts()): ?>
            
        <section class="work-2col wide no-margin-top content-section">
            <div class="container-fluid position-relative">
                <div class="row">
                    <div class="col-md-12 grid-gallery overflow-hidden no-padding">
                            <!-- work grid -->
                            <ul class="grid masonry-items">
                            <?php
                                while ($post_destacado->have_posts()):
                                $post_destacado->the_post();
                                $ID_destacado[] = $post->ID;
                                
                                $custom_fields = get_post_custom();
                                $shoe_model = $custom_fields['model_shoe'][0];
                                $shoe_brand = $custom_fields['brand_shoe'][0];
                                
                                $preview = get_first_image();
                                if (!isset($preview)) {
                                    $preview = '../assets/shoes/aaa_no_shoe.jpg';
                                }
                                ?>
                                <!-- work item -->
                                <li class="html jquery">
                                    <figure>
                                        <div class="gallery-img"><a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $preview;?>" alt=""></a></div>
                                        <figcaption>
                                            <h3><?php echo $shoe_brand ?> <?php echo $shoe_model ?></h3>
                                            <p><?php echo get_the_date( get_option('date_format') ); ?></p>
                                        </figcaption>
                                    </figure>
                                </li>
                                <!-- end work item -->
                                <?php endwhile; ?>
                            </ul>
                            <!-- end work grid -->
                    </div>
                </div>
            </div>
        </section>
        <!-- end portfolio section -->
        <?php endif;
        wp_reset_postdata();
        
        $paged = get_query_var('paged') > 1 ? get_query_var('paged') : 1 ;
        $arguments=array(
            'posts_per_page' => 6,
            'post__not_in' => $ID_destacado,
            'paged' => $paged,
            'post_type' => array('eightbeast_shoe'),
            'order_by' => 'post_date',
            'order' => 'DESC'
            );
$custom_query = new WP_Query($arguments); 
?>


<?php if ($custom_query -> have_posts()) : ?>
<!-- content section -->
        <section class="wow fadeIn">
            <div class="container">
                <div class="row blog-3col">
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
                    <!-- post item -->
                    <div class="col-md-4 col-sm-6 col-xs-6 blog-listing wow fadeInUp" data-wow-duration="300ms">
                        <div class="blog-image"><a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $preview;?>" alt=""/></a></div>
                        <div class="blog-details">
                            <div class="blog-date"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a> | <?php echo get_the_date( get_option('date_format') ); ?></div>
                            <div class="blog-title"><a href="<?php echo get_the_permalink(); ?>"><?php echo $shoe_brand; ?> <?php echo $shoe_model; ?></a></div>
                            <div class="separator-line bg-black no-margin-lr"></div>
                            <div><a href="<?php echo get_comments_link(); ?>" class="comments"><i class="fa fa-comment-o"></i><?php echo comments_number( __('No comments', langdomain()), __('One comment', langdomain()), __('% comments', langdomain()) ); ?></a></div>
                        </div>
                    </div>
                    <!-- end post item -->
                    
                    <?php endwhile; ?>
                </div>
                
                
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 wow fadeInUp">
                        <?php 
                            $backtag = '<img src="' . get_template_directory_uri() . '/images/arrow-pre-small.png" alt=""/>';
                            $fwdtag = '<img src="' . get_template_directory_uri() . '/images/arrow-next-small.png" alt=""/>';
                            
                            $GLOBALS['wp_query']->max_num_pages = $custom_query->max_num_pages;
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
        <!-- end content section -->
<?php endif;
wp_reset_postdata();
?>

<?php
    get_footer();
?>