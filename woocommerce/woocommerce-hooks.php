<?php
/**
 * WooCommerce Custom Hook
 * woocommerce-hooks.php
 */

// include plugin functions
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// Disable WooCommerce styles
if ( version_compare( WOOCOMMERCE_VERSION, '2.1' ) >= 0 ) {
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
} else {
	define( 'WOOCOMMERCE_USE_CSS', false );
}

/* Single product actions */
add_action( 'themify_single_product_price', 'woocommerce_template_single_price', 10);
add_action( 'template_redirect', 'themify_single_product_related_products', 12);
add_action( 'template_redirect', 'themify_hide_shop_features', 12);

// Maybe remove reviews based in user choice
add_filter( 'woocommerce_product_tabs', 'themify_single_product_reviews' );

// Add wrappers and breadcrumb in single product
add_action( 'woocommerce_before_single_product_summary', 'themify_theme_single_product_start', 9 );
add_action( 'woocommerce_after_single_product_summary', 'themify_theme_single_product_end', 9 );

// Remove sale flash since it will be included manually
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

// Change product thumbnail
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail');
add_action( 'woocommerce_before_shop_loop_item_title', 'themify_theme_loop_product_medium' );

// Replace link to rebuild thumbnails
add_filter( 'woocommerce_catalog_settings', 'themify_theme_replace_rebuild_link' );

// Wrap product description
add_filter( 'woocommerce_short_description', 'themify_theme_product_description_wrap' );

// Output classes for product
add_filter( 'post_class', 'themify_theme_product_class', 10, 3 );

/* Single product on lightbox actions */
add_action( 'themify_single_product_image_ajax', 'woocommerce_show_product_sale_flash', 20);
add_action( 'themify_single_product_image_ajax', 'woocommerce_show_product_images', 20);
add_action( 'themify_single_product_ajax_content', 'woocommerce_template_single_add_to_cart', 10);
if ( isset( $_GET['ajax'] ) && $_GET['ajax'] ) {
	add_filter('woocommerce_single_product_image_html', 'themify_product_image_ajax', 10, 2);
	add_filter('woocommerce_single_product_image_thumbnail_html', create_function('', "return '';"));
}
add_filter('woocommerce_single_product_image_html', 'themify_product_image_single', 10, 2);

/* Sorting menu */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
add_action( 'woocommerce_before_shop_loop', 'themify_catalog_ordering', 8 );

// Remove breadcrumb for later insertion within Themify wrapper
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

add_filter( 'woocommerce_sale_flash', 'themify_theme_sale_flash' );

// Remove dock item hooks
add_action( 'init', 'themify_update_cart_action');

/* Content Wrapper */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

// Replace default Themify wrappers with theme custom wrappers
remove_action( 'woocommerce_before_main_content', 'themify_before_shop_content', 20);
remove_action( 'woocommerce_after_main_content', 'themify_after_shop_content', 20);
add_action( 'woocommerce_before_main_content', 'themify_theme_before_shop_content', 20);
add_action( 'woocommerce_after_main_content', 'themify_theme_after_shop_content', 20);
remove_action( 'themify_content_after', 'themify_wc_compatibility_sidebar', 10);
add_action( 'themify_content_after', 'themify_theme_wc_compatibility_sidebar' );

/* Sidebar */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
add_action('template_redirect', 'themify_woocommerce_sidebar_layout', 12);

// Edit link
add_action( 'woocommerce_after_shop_loop_item', 'themify_edit_link');

// Add product variations
add_action('woocommerce_before_add_to_cart_form', 'themify_available_variations');

// Hide title in shop/store page
add_action('template_redirect', 'themify_hide_shop_title');
// Show excerpt or content in product archive pages
add_action('woocommerce_after_shop_loop_item', 'themify_after_shop_loop_item', 9);
// Set WC image sizes
add_image_size('cart_thumbnail', 40, 40, true);
add_action( 'switch_theme', 'themify_theme_delete_image_sizes_flag' );
add_action( 'wp_loaded', 'themify_set_wc_image_sizes' );

// Add to cart link
add_filter('woocommerce_loop_add_to_cart_link', 'themify_loop_add_to_cart_link', 10, 3);
// No product title in product archive pages
add_filter('the_title', 'themify_no_product_title');
// No product price in product archive pages
add_filter('woocommerce_get_price_html', 'themify_no_price');
// Set number of products shown in product archive pages
add_filter('loop_shop_per_page', 'themify_products_per_page');

/**
 * Fragments
 * Adding cart total and shopdock markup to the fragments
 */
add_filter( 'add_to_cart_fragments', 'themify_theme_add_to_cart_fragments' );

/**
 * Theme delete cart hook
 * Note: for Add to cart using default WC function
 */
add_action( 'wp_ajax_theme_delete_cart', 'themify_theme_woocommerce_delete_cart' );
add_action( 'wp_ajax_nopriv_theme_delete_cart', 'themify_theme_woocommerce_delete_cart' );

/**
 * Theme adding cart hook
 * Adding cart ajax on single product page
 */
add_action( 'wp_ajax_theme_add_to_cart', 'themify_theme_woocommerce_add_to_cart' );
add_action( 'wp_ajax_nopriv_theme_add_to_cart', 'themify_theme_woocommerce_add_to_cart' );

/**
 * WC Plugins compliance 
 */
// Dynamic Gallery Plugin
if ( is_plugin_active( 'woocommerce-dynamic-gallery/wc_dynamic_gallery_woocommerce.php' ) ) {
	remove_action( 'themify_single_product_image', 'woocommerce_show_product_images', 20);
	remove_action( 'themify_single_product_image', 'woocommerce_show_product_thumbnails', 20);
}

/**
 * Specific for Shopdock Plugin
 */
// Remove shopdock bar that along with plugin shopdock
remove_action('wp_footer', 'shopdock_dock_bar', 10);
// Remove sorting bar from shopdock plugin
remove_action( 'woocommerce_before_shop_loop', 'shopdock_catalog_ordering', 8 );
// Remove shopdock plugin pagination
remove_action('shopdock_pagination', 'woocommerce_pagination', 10);
// Remove shopdock plugin script
remove_action('wp_enqueue_scripts', 'shopdock_enqueue_scripts', 20);

/**
 * Specific for infinite scroll themes
 */
if( 'infinite' == themify_get('setting-more_posts') || '' == themify_get('setting-more_posts') ){
	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
	function themify_shop_infinite_scroll() {
		global $wp_query;
		$total_pages = (int)$wp_query->max_num_pages;
		$current_page = (get_query_var('paged')) ? get_query_var('paged') : 1;
		if( $total_pages > $current_page ){
			//If it's a Query Category page, set the number of total pages
			echo '<p id="load-more"><a href="' . next_posts( $total_pages, false ) . '">' . __('Load More', 'themify') . '</a></p>';
			echo '<script type="text/javascript">var qp_max_pages = ' . $total_pages . ';</script>';
		}
	};
	add_action('woocommerce_after_shop_loop', 'themify_shop_infinite_scroll');
}