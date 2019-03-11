
<!-- navigation panel -->
<nav class="navbar navbar-default navbar-fixed-top nav-transparent overlay-nav sticky-nav nav-border-bottom bg-white" role="navigation">
    <div class="container">
        <div class="row">
            <!-- logo -->
            <div class="col-md-2 pull-left">
                <a class="logo-light" href="/index"><img alt="" src="<?= get_template_directory_uri(); ?>/images/logo.png" class="logo" /></a>
                <a class="logo-dark" href="/index"><img alt="" src="<?= get_template_directory_uri(); ?>/images/logo-light.png" class="logo logo-small" /></a>
            </div>
            <!-- end logo -->
            <!-- search and cart  -->
            <div class="col-md-2 no-padding-left search-cart-header pull-right">
                <div id="top-search">
                    <!-- nav search -->
                    <a href="<?php echo bloginfo('url'); ?>?lang=en" class="" id="js-langEN">EN</a>
                    <!-- end nav search -->
                    <i class="fas fa-globe-europe"></i>
                    <!-- nav search -->
                    <a href="<?php echo bloginfo('url'); ?>?lang=es" class="" id="js-langES">ES</a>
                    <!-- end nav search -->
                </div>
                <!-- end search input -->
                <div class="top-cart">
                    <!-- nav shopping bag -->
                    <a href="#" class="shopping-cart">
                        <i class="fa fa-shopping-cart"></i>
                        <div class="subtitle js-cartTitle">(0) Items</div>
                    </a>
                    <!-- end nav shopping bag -->
                    <!-- shopping bag content -->
                    <div class="cart-content">
                        <ul class="cart-list" id="cartList"></ul>
                        <p class="total js-cartTotal"></p>
                        <p class="buttons" id="cartButtons"></p>
                    </div>
                    <!-- end shopping bag content -->
                </div>
            </div>
            <!-- end search and cart  -->
            <!-- toggle navigation -->
            <div class="navbar-header col-sm-8 col-xs-2 pull-right">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            </div>
            <!-- toggle navigation end -->
            <!-- main menu -->
            <div class="col-md-8 no-padding-right accordion-menu text-right">
                <div class="navbar-collapse collapse">
                    <ul id="accordion" class="nav navbar-nav navbar-right panel-group">
                        <!-- menu item -->
                        <li class="dropdown panel">
                            <a href="/index"><?php _e('Home', langdomain()); ?></a>
                        </li>
                        
                        <li class="dropdown panel">
                            <a href="/store"><?php _e('Store', langdomain()); ?></a>
                        </li>
          
                        <li class="dropdown panel simple-dropdown">
                            <a href="/blog" class="dropdown-toggle collapsed" data-toggle="collapse" data-parent="#accordion" data-hover="dropdown">
                                <i class="fa fa-user"></i>
                                <?php _e('Blog', langdomain()); ?><i class="fa fa-angle-down"></i>
                            </a>
                            <ul id="collapse7" class="dropdown-menu panel-collapse collapse" role="menu">
                                <li><a href="/blog"><?php _e('Index', langdomain()); ?></a></li>
                                <li><a href="/blog/archives"><?php _e('Archives', langdomain()); ?></a></li>
                            </ul>
                            <!-- end sub menu item  -->
                            <!-- end sub menu single -->
                        </li>
                        <li class="dropdown panel">
                            <a href="/blog/drops"><?php _e('Drops', langdomain()); ?></a>
                        </li>
                        <!-- end menu item -->
                        <li class="dropdown panel">
                            <a href="<?php 
                            $link = get_permalink();
                            echo wp_login_url($link); ?>"><?php _e('Blog Account', langdomain()); ?></a>
                        </li>
                        
                        <li class="dropdown panel">
                            <a href="/about"><?php _e('About', langdomain()); ?></a>
                        </li>
                        
                        <li class="dropdown panel">
                            <a href="/contact"><?php _e('Contact', langdomain()); ?></a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- end main menu -->
        </div>
    </div>
</nav>
<!--end navigation panel -->
