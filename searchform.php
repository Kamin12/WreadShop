<?php
/**
 * Template for search form that separates blog posts search from products search
 * @package themify
 * @since 1.0.0
 */
?>
<form method="get" id="searchform" action="<?php echo home_url(); ?>/">

	<i class="fa fa-search icon-search"></i>

	<input type="hidden" class="search-type" name="post_type" value="product" />

	<input type="text" name="s" id="s"  placeholder="<?php _e('Search', 'themify'); ?>" />

	<div class="search-option">

		<input id="search-blog" class="search-blog" type="radio" name="search-option" value="post" /> <label for="search-blog"><?php _e('Blog', 'themify'); ?></label>

		<input id="search-shop" class="search-shop" type="radio" name="search-option" value="product" /> <label for="search-shop"><?php _e('Shop', 'themify'); ?></label>

	</div>

</form>