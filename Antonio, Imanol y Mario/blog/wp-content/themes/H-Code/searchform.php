<form role="search" method="get" class="" action="<?php echo home_url( '/' ); ?>">
	<button type="submit" class="close-search search-button search-submit"><i class="fa fa-search"></i></button>
	<input type="search" placeholder="<?php echo _e('Search...', langdomain()); ?>" class="search-input " name="s" value="<?php echo esc_attr( get_search_query() ); ?>">
<!--search-field-->
</form>
