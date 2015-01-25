<?php
/**
 * Main Themify class
 * @package themify
 * @since 1.0.0
 */

class Themify {
	/** Default sidebar layout
	 * @var string */
	public $layout;
	/** Default posts layout
	 * @var string */
	public $post_layout;
	
	public $hide_title;
	public $hide_meta;
	public $hide_meta_author;
	public $hide_meta_category;
	public $hide_meta_comment;
	public $hide_meta_tag;
	public $hide_date;
	public $hide_image;
	
	public $unlink_title;
	public $unlink_image;
	
	public $display_content = '';
	public $auto_featured_image;
	
	public $width = '';
	public $height = '';
	
	public $avatar_size = 96;
	public $page_navigation;
	public $posts_per_page;
	
	public $image_align = '';
	public $image_setting = '';
	
	public $page_id = '';
	public $query_category = '';
	public $paged = '';

	////////////////////////////////////////////
	// Product Variables
	////////////////////////////////////////////
	public $query_products = '';
	public $products_per_page = '';
	public $product_category = '';
	public $query_products_field = '';
	public $is_related_loop = false;
	public $is_single_product_main = false;
	public $product_archive_show_short = '';

	/////////////////////////////////////////////
	// Set Default Image Sizes 					
	/////////////////////////////////////////////
	
	// Default Index Layout
	static $content_width = 978;
	static $sidebar1_content_width = 670;
	
	// Default Single Post Layout
	static $single_content_width = 978;
	static $single_sidebar1_content_width = 670;
	
	// Default Single Image Size
	static $single_image_width = 1064;
	static $single_image_height = 500;
	
	// Grid4
	static $grid4_width = 222;
	static $grid4_height = 140;
	
	// Grid3
	static $grid3_width = 306;
	static $grid3_height = 180;
	
	// Grid2
	static $grid2_width = 474;
	static $grid2_height = 250;
	
	// List Post
	static $list_post_width = 1064;
	static $list_post_height = 500;
	
	// Sorting Parameters
	public $order = 'DESC';
	public $orderby = 'date';

	function __construct() {
		
		///////////////////////////////////////////
		//Global options setup
		///////////////////////////////////////////
		$this->layout = themify_get('setting-default_layout');
		if($this->layout == '' ) $this->layout = 'sidebar1'; 
		
		$this->post_layout = themify_get('setting-default_post_layout');
		if($this->post_layout == '') $this->post_layout = 'list-post'; 
		
		$this->page_title = themify_get('setting-hide_page_title');
		$this->hide_title = themify_get('setting-default_post_title');
		$this->unlink_title = themify_get('setting-default_unlink_post_title');
		
		$this->hide_image = themify_get('setting-default_post_image');
		$this->unlink_image = themify_get('setting-default_unlink_post_image');
		$this->auto_featured_image = !themify_check('setting-auto_featured_image')? 'field_name=post_image, image, wp_thumb&' : '';
		
		$this->hide_meta = themify_get('setting-default_post_meta');
		$this->hide_meta_author = themify_get('setting-default_post_meta_author');
		$this->hide_meta_category = themify_get('setting-default_post_meta_category');
		$this->hide_meta_comment = themify_get('setting-default_post_meta_comment');
		$this->hide_meta_tag = themify_get('setting-default_post_meta_tag');

		$this->hide_date = themify_get('setting-default_post_date');
		
		// Set Order & Order By parameters for post sorting
		$this->order = themify_check('setting-index_order')? themify_get('setting-index_order'): 'DESC';
		$this->orderby = themify_check('setting-index_orderby')? themify_get('setting-index_orderby'): 'date';

		$this->display_content = themify_get('setting-default_layout_display');
		$this->avatar_size = apply_filters('themify_author_box_avatar_size', 96);
		
		add_action('template_redirect', array(&$this, 'template_redirect'));
	}

	function template_redirect() {
		
		$post_image_width = themify_get('image_width');
		$post_image_height = themify_get('image_height');

		if( is_singular() ) {
			$this->display_content = 'content';
		}

		if ( is_page() ) {
			$this->page_id = get_the_ID();
			$this->post_layout = (themify_get('layout') != "default" && themify_check('layout')) ?
									themify_get('layout') : themify_get('setting-default_post_layout');
			// set default post layout
			if($this->post_layout == '')
				$this->post_layout = 'list-post';

			// Save page ID in case we need it later
			$this->page_id = get_the_ID();
		}
		
		///////////////////////////////////////////
		// Setting image width, height
		///////////////////////////////////////////
		if($this->post_layout == 'grid4'):
		
			$this->width = self::$grid4_width;
			$this->height = self::$grid4_height;
		
		elseif($this->post_layout == 'grid3'):
		
			$this->width = self::$grid3_width;
			$this->height = self::$grid3_height;
		
		elseif($this->post_layout == 'grid2'):
		
			$this->width = self::$grid2_width;
			$this->height = self::$grid2_height;
			
		elseif($this->post_layout == 'list-post'):
		
			$this->width = self::$list_post_width;
			$this->height = self::$list_post_height;
		
		else:
					
			$this->width = self::$list_post_width;
			$this->height = self::$list_post_height;
			
		endif;

		///////////////////////////////////////////////////////
		// Query Posts
		///////////////////////////////////////////////////////
		if( is_page() ) {
			if(get_query_var('paged')):
				$this->paged = get_query_var('paged');
			elseif(get_query_var('page')):
				$this->paged = get_query_var('page');
			else:
				$this->paged = 1;
			endif;
			$this->query_category = themify_get('query_category');
			
			$this->layout = (themify_get('page_layout') != 'default' && themify_check('page_layout')) ? themify_get('page_layout') : themify_get('setting-default_page_layout');
			if($this->layout == '')
				$this->layout = 'sidebar1'; 
			
			$this->post_layout = (themify_get('layout') != 'default' && themify_check('layout')) ? themify_get('layout') : themify_get('setting-default_post_layout');
			if($this->post_layout == '')
				$this->post_layout = 'list-post';
			
			$this->page_title = (themify_get('hide_page_title') != 'default' && themify_check('hide_page_title')) ? themify_get('hide_page_title') : themify_get('setting-hide_page_title'); 
			$this->hide_title = themify_get('hide_title'); 
			$this->unlink_title = themify_get('unlink_title'); 
			$this->hide_image = themify_get('hide_image'); 
		    $this->unlink_image = themify_get('unlink_image'); 

			// Post Meta Values ///////////////////////
			$post_meta_keys = array(
				'_author' 	=> 'post_meta_author',
				'_category' => 'post_meta_category',
				'_comment'  => 'post_meta_comment',
				'_tag' 	 	=> 'post_meta_tag'
			);
			$post_meta_key = 'setting-default_';
			$this->hide_meta = themify_check('hide_meta_all')?
								themify_get('hide_meta_all') : themify_get($post_meta_key . 'post_meta');
			foreach($post_meta_keys as $k => $v){
				$this->{'hide_meta'.$k} = themify_check('hide_meta'.$k)? themify_get('hide_meta'.$k) : themify_get($post_meta_key . $v);
			}

			$this->display_content = themify_get('display_content');
			$this->post_image_width = themify_get('image_width'); 
			$this->post_image_height = themify_get('image_height'); 
			$this->page_navigation = themify_get('hide_navigation'); 
			$this->posts_per_page = themify_get('posts_per_page');
			$this->order = (themify_get('order') && '' != themify_get('order')) ? themify_get('order') : (themify_check('setting-index_order') ? themify_get('setting-index_order') : 'DESC');
			$this->orderby = (themify_get('orderby') && '' != themify_get('orderby')) ? themify_get('orderby') : (themify_check('setting-index_orderby') ? themify_get('setting-index_orderby') : 'date');
			if ( 'default' != themify_get( 'hide_date' ) ) {
					$this->hide_date = themify_get( 'hide_date' );
				} else {
					$this->hide_date = themify_check( 'setting-default_post_date' ) ?
						themify_get( 'setting-default_post_date' ) : 'no';
				}

			if( '' != $post_image_height && '' != $post_image_width) {
				$this->width = $post_image_width;
				$this->height = $post_image_height;
			}
		}

		if( is_single() ) {
			$this->hide_title = (themify_get('hide_post_title') != 'default' && themify_check('hide_post_title')) ? themify_get('hide_post_title') : themify_get('setting-default_page_post_title');
			$this->unlink_title = (themify_get('unlink_post_title') != 'default' && themify_check('unlink_post_title')) ? themify_get('unlink_post_title') : themify_get('setting-default_page_unlink_post_title');
			$this->hide_date = (themify_get('hide_post_date') != 'default' && themify_check('hide_post_date')) ? themify_get('hide_post_date') : themify_get('setting-default_page_post_date');
			$this->hide_image = (themify_get('hide_post_image') != 'default' && themify_check('hide_post_image')) ? themify_get('hide_post_image') : themify_get('setting-default_page_post_image');
			$this->unlink_image = (themify_get('unlink_post_image') != 'default' && themify_check('unlink_post_image')) ? themify_get('unlink_post_image') : themify_get('setting-default_page_unlink_post_image');

			// Post Meta Values ///////////////////////
			$post_meta_keys = array(
				'_author' 	=> 'post_meta_author',
				'_category' => 'post_meta_category',
				'_comment'  => 'post_meta_comment',
				'_tag' 	 	=> 'post_meta_tag'
			);

			$post_meta_key = 'setting-default_page_';
			$this->hide_meta = themify_check('hide_meta_all')?
								themify_get('hide_meta_all') : themify_get($post_meta_key . 'post_meta');
			foreach($post_meta_keys as $k => $v){
				$this->{'hide_meta'.$k} = themify_check('hide_meta'.$k)? themify_get('hide_meta'.$k) : themify_get($post_meta_key . $v);
			}
			
			$this->layout = (themify_get('layout') == 'sidebar-none'
							|| themify_get('layout') == 'sidebar1'
							|| themify_get('layout') == 'sidebar1 sidebar-left'
							|| themify_get('layout') == 'sidebar2') ?
								themify_get('layout') : themify_get('setting-default_page_post_layout');
			 // set default layout
			 if($this->layout == '')
			 	$this->layout = 'sidebar1';
			
			$this->display_content = '';
			
			$this->post_image_width = themify_get('image_width');
			$this->post_image_height = themify_get('image_height');
			
			// Set Default Image Sizes for Single
			self::$content_width = self::$single_content_width;
			self::$sidebar1_content_width = self::$single_sidebar1_content_width;
			
			if( '' == $post_image_height && '' == $post_image_width){
				$this->width  = self::$single_image_width;
				$this->height = self::$single_image_height;
			} else {
				$this->width  = $post_image_width;
				$this->height = $post_image_height;
			}
		}

		/////////////////////////////////////////////////////////////
		// Query Products
		/////////////////////////////////////////////////////////////
		if ( themify_is_woocommerce_active() ) {

			if ( is_woocommerce() ) {
				$this->post_layout = themify_check( 'setting-products_layout' )? themify_get( 'setting-products_layout' ) : 'list-post';
				$this->layout = themify_check( 'setting-shop_layout' )? themify_get( 'setting-shop_layout' ) : 'sidebar-none';
			}

			if ( is_page() && '' != themify_get('product_query_category') ) {

				$pq = 'product_';
				$this->product_category = themify_get($pq.'query_category');
				$this->query_products_field = 'slug';

				// Page Navigation //////////////////////////////////////////////////
				$this->page_navigation = '' != themify_get($pq.'hide_navigation')? themify_get($pq.'hide_navigation') : 'no';

				// Sidebar and Products Layout //////////////////////////////////////
				if ( 'default' != themify_get( $pq.'layout' ) ) {
					$this->post_layout = themify_get( $pq.'layout' );
				} elseif ( themify_check( 'setting-product_query_layout' ) ) {
					$this->post_layout = themify_get( 'setting-product_query_layout' );
				} else {
					$this->post_layout = 'list-post';
				}
				if ( 'default' != themify_get( 'page_layout' ) ) {
					$this->layout = themify_get( 'page_layout' );
				} elseif ( themify_check( 'setting-product_query_page_layout' ) ) {
					$this->layout = themify_get( 'setting-product_query_page_layout' );
				} else {
					$this->layout = 'sidebar-none';
				}

				// Products Per Page /////////////////////////////////////////////////
				$this->products_per_page = themify_check( $pq.'posts_per_page' )? themify_get( $pq.'posts_per_page' ) : get_option( 'posts_per_page' );

				// Order & OrderBy ///////////////////////////////////////////////////
				$this->orderby = themify_check( $pq.'orderby' )? themify_get( $pq.'orderby' ) : 'date';
				$this->order = themify_check( $pq.'order' )? themify_get( $pq.'order' ) : 'desc';

				// Init this var so it looks like a query category page //////////////
				$this->query_category = $this->product_category;

				// Product Short Description or Full Content /////////////////////////
				if ( '' != themify_get( $pq.'archive_show_short' ) ) {
					$this->product_archive_show_short = themify_get( $pq.'archive_show_short' );
				} else {
					$this->product_archive_show_short = 'none';
				}

				// Set Up Product Query //////////////////////////////////////////////
				global $paged;
				if ( get_query_var( 'paged' ) ) {
				    $paged = get_query_var( 'paged' );
				} else if ( get_query_var( 'page' ) ) {
				    $paged = get_query_var( 'page' );
				} else {
				    $paged = 1;
				}
				$this->query_products = array(
					'post_type' => 'product',
					'posts_per_page' => $this->products_per_page,
					'order' => $this->order,
					'orderby' => $this->orderby,
					'paged' => $paged
				);
				if ( '-1' == $this->product_category ) {
					$this->query_products['meta_query'] = array(
						array(
							'key' => '_featured',
							'value' => 'yes',
						)
					);
				} elseif ( isset( $this->product_category ) && '0' != $this->product_category ) {
					$pcats = explode( ',', $this->product_category );
					if ( ctype_digit( $pcats[0] ) ) {
						$this->query_products_field = 'id';
					}
					$this->query_products['tax_query'] = array(
						array(
							'taxonomy' => 'product_cat',
							'field' => $this->query_products_field,
							'terms' => $pcats
						)
					);
				}
			}
		}
		
		if($this->layout == 'sidebar1' || $this->layout == 'sidebar1 sidebar-left') {
			$ratio = $this->width / self::$content_width;
			$aspect = $this->height / $this->width;
			$this->width = round($ratio * self::$sidebar1_content_width);
			if($this->height != '' && $this->height != 0)
				$this->height = round($this->width * $aspect);
		}
		
		if(is_single() && $this->hide_image != 'yes') {
			$this->image_align = themify_get('setting-image_post_single_align');
			$this->image_setting = 'setting=image_post_single&';
		} elseif($this->query_category != '' && $this->hide_image != 'yes') {
			$this->image_align = '';
			$this->image_setting = '';
		} else {
			$this->image_align = themify_get('setting-image_post_align');
			$this->image_setting = 'setting=image_post&';
		}
	}
}

/**
 * Initializes Themify class
 * @since 1.0.0
 */
function themify_global_options(){
	global $themify;
	$themify = new Themify();
}
add_action( 'after_setup_theme','themify_global_options', 12 );

?>