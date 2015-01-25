<?php
/**
 * Post Meta Box Options
 * @param array $args
 * @return array
 * @since 1.0.0
 */
function themify_theme_product_meta_box( $args = array() ) {
	extract( $args );
	return array(
		// Content Width
		array(
			'name'=> 'content_width',
			'title' => __('Content Width', 'themify'),
			'description' => '',
			'type' => 'layout',
			'show_title' => true,
			'meta' => array(
				array(
					'value' => 'default_width',
					'img' => 'themify/img/default.png',
					'selected' => true,
					'title' => __( 'Default', 'themify' )
				),
				array(
					'value' => 'full_width',
					'img' => 'themify/img/fullwidth.png',
					'title' => __( 'Fullwidth', 'themify' )
				)
			)
		),
		// Product Image Position
		array(
			'name' 			=> 'product_image_layout',
			'title'			=> __('Product Image Layout', 'themify'),
			'description'	=> '',
			'type'			=> 'layout',
			'show_title' 	=> true,
			'meta'			=>  array(
				array('value' => 'image-left', 'img' => 'images/layout-icons/image-left.png', 'selected' => true, 'title' => __('Product Image Left', 'themify')),
				array('value' => 'image-center', 'img' => 'images/layout-icons/image-center.png', 'title' => __('Product Image Center', 'themify')),
				array('value' => 'image-right', 'img' => 'images/layout-icons/image-right.png', 'title' => __('Product Image Right', 'themify'))
			)
		),
		// Separator
		array(
			'name' => 'separator_title_text_color',
			'title' => '',
			'description' => '',
			'type' => 'separator',
			'meta' => array('html'=>'<h4>'.__('Product Title &amp; Description', 'themify').'</h4><hr class="meta_fields_separator"/>'),
		),
		// Title Font Color
		array(
			'name' => 'title_font_color',
			'title' => __('Title Font Color', 'themify'),
			'description' => '',
			'type' => 'color',
			'meta' => array('default' => null),
		),
		// Price Font Color
		array(
			'name' => 'price_font_color',
			'title' => __('Price Font Color', 'themify'),
			'description' => '',
			'type' => 'color',
			'meta' => array('default' => null),
		),
		// Text Font Color
		array(
			'name' => 'description_font_color',
			'title' => __('Text Font Color', 'themify'),
			'description' => '',
			'type' => 'color',
			'meta' => array('default' => null),
		),
		// Link Font Color
		array(
			'name' => 'link_font_color',
			'title' => __('Link Font Color', 'themify'),
			'description' => '',
			'type' => 'color',
			'meta' => array('default' => null),
		),
		// Button Font Color
		array(
			'name' => 'button_font_color',
			'title' => __('Button Font Color', 'themify'),
			'description' => '',
			'type' => 'color',
			'meta' => array('default' => null),
		),
		// Background Color
		array(
			'name' => 'button_background_color',
			'title' => __('Button Background Color', 'themify'),
			'description' => '',
			'type' => 'color',
			'meta' => array('default'=>null),
		),
		// Separator
		array(
			'name' => 'separator',
			'title' => '',
			'description' => '',
			'type' => 'separator',
			'meta' => array('html'=>'<h4>'.__('Product Background', 'themify').'</h4><hr class="meta_fields_separator"/>'),
		),
		// Background Color
		array(
			'name' => 'background_color',
			'title' => __('Background Color', 'themify'),
			'description' => '',
			'type' => 'color',
			'meta' => array('default'=>null),
		),
		// Background image
		array(
			'name' 	=> 'background_image',
			'title' => __('Background Image', 'themify'),
			'type' 	=> 'image',
			'description' => '',
			'meta'	=> array(),
			'before' => '',
			'after' => ''
		),
		// Background repeat
		array(
			'name' 		=> 'background_repeat',
			'title'		=> __('Background Repeat', 'themify'),
			'description'	=> '',
			'type' 		=> 'dropdown',
			'meta'		=> array(
				array('value' => 'fullcover', 'name' => __('Fullcover', 'themify'), 'selected' => true),
				array('value' => 'repeat', 'name' => __('Repeat', 'themify')),
				array('value' => 'repeat-x', 'name' => __('Repeat horizontally', 'themify')),
				array('value' => 'repeat-y', 'name' => __('Repeat vertically', 'themify')),
				array('value' => 'no-repeat', 'name' => __('Do not repeat', 'themify'))
			)
		),
		// Multi field: Background Position
		array(
			'type' => 'multi',
			'name' => '_multi_bg_position',
			'title' => __('Background Position', 'themify'),
			'meta' => array(
				'fields' => array(
					// Background horizontal position
					array(
						'name'  => 'background_position_x',
						'label' => '',
						'description' => '',
						'type' 	=> 'dropdown',
						'meta'	=> array(
							array('value' => '',   'name' => '', 'selected' => true),
							array('value' => 'left',   'name' => __('Left', 'themify')),
							array('value' => 'center', 'name' => __('Center', 'themify')),
							array('value' => 'right',  'name' => __('Right', 'themify'))
						),
						'before' => '',
						'after'  => ''
					),
					// Background vertical position
					array(
						'name'  => 'background_position_y',
						'label' => '',
						'description' => '',
						'type' 	=> 'dropdown',
						'meta'	=> array(
							array('value' => '',   'name' => '', 'selected' => true),
							array('value' => 'top',   'name' => __('Top', 'themify')),
							array('value' => 'center', 'name' => __('Center', 'themify')),
							array('value' => 'bottom',  'name' => __('Bottom', 'themify'))
						),
						'before' => '',
						'after'  => ''
					),
				),
				'description' => '',
				'before' => '',
				'after' => '',
				'separator' => ''
			)
		),
	);
}

/**************************************************************************************************
 * Themify Theme Settings Module
 **************************************************************************************************/

/**
 * Creates module for general shop layout and settings
 * @param array
 * @return string
 * @since 1.0.0
 */
function themify_shop_layout($data=array()){
	$data = themify_get_data();

	$sidebar_options = array(
		array('value' => 'sidebar1', 'img' => 'images/layout-icons/sidebar1.png', 'title' => __('Sidebar Right', 'themify')),
		array('value' => 'sidebar1 sidebar-left', 'img' => 'images/layout-icons/sidebar1-left.png', 'title' => __('Sidebar Left', 'themify')),
		array('value' => 'sidebar-none', 'img' => 'images/layout-icons/sidebar-none.png', 'title' => __('No Sidebar', 'themify'), 'selected' => true)
	);
	/**
	 * Entries layout options
	 * @var array
	 */
	$default_entry_layout_options = array(
		array('value' => 'list-post', 'img' => 'images/layout-icons/list-post.png', 'title' => __('List Post', 'themify'), 'selected' => true),
		array('value' => 'grid4', 'img' => 'images/layout-icons/grid4.png', 'title' => __('Grid 4', 'themify')),
		array('value' => 'grid3', 'img' => 'images/layout-icons/grid3.png', 'title' => __('Grid 3', 'themify')),
		array('value' => 'grid2', 'img' => 'images/layout-icons/grid2.png', 'title' => __('Grid 2', 'themify'))
	);
	$default_options = array(
		'' => '',
		__('Yes', 'themify') => 'yes',
		__('No', 'themify') => 'no'
	);
	$content_options = array(
		__('None', 'themify') => '',
		__('Short Description', 'themify') => 'excerpt',
		__('Full Content', 'themify') => 'content'
	);

	$val = isset( $data['setting-shop_layout'] ) ? $data['setting-shop_layout'] : '';

	/**
	 * Modules output
	 * @var String
	 * @since 1.0.0
	 */
	$output = '';

	/**
	 * Sidebar option
	 */
	$output .= '<p><span class="label">' . __('Page Sidebar Option', 'themify') . '</span>';
	foreach($sidebar_options as $option){
		if ( ( '' == $val || ! $val || ! isset( $val ) ) && ( isset( $option['selected'] ) && $option['selected'] ) ) {
			$val = $option['value'];
		}
		if ( $val == $option['value'] ) {
			$class = "selected";
		} else {
			$class = "";
		}
		$output .= '<a href="#" class="preview-icon '.$class.'" title="'.$option['title'].'"><img src="'.THEME_URI.'/'.$option['img'].'" alt="'.$option['value'].'"  /></a>';
	}
	$output .= '<input type="hidden" name="setting-shop_layout" class="val" value="'.$val.'" /></p>';
	$output .= '<p><span class="label">' . __('Products Per Page', 'themify') . '</span>
				<input type="text" name="setting-shop_products_per_page" value="' . themify_get( 'setting-shop_products_per_page' ) . '" class="width2" /></p>';

	/**
	 * Entries Layout
	 */
	$output .= '<p>
					<span class="label">' . __('Products Layout', 'themify') . '</span>';
	$val = isset( $data['setting-products_layout'] ) ? $data['setting-products_layout'] : '';
	foreach($default_entry_layout_options as $option){
		if ( ( '' == $val || ! $val || ! isset( $val ) ) && ( isset( $option['selected'] ) && $option['selected'] ) ) {
			$val = $option['value'];
		}
		if ( $val == $option['value'] ) {
			$class = 'selected';
		} else {
			$class = '';
		}
		$output .= '<a href="#" class="preview-icon '.$class.'" title="'.$option['title'].'"><img src="'.THEME_URI.'/'.$option['img'].'" alt="'.$option['value'].'"  /></a>';
	}

	$output .= '	<input type="hidden" name="setting-products_layout" class="val" value="'.$val.'" />
				</p>';

	/**
	 * Hide Title Options
	 * @var String
	 * @since 1.0.0
	 */
	$hide_title = '';
	foreach($default_options as $name => $option){
		if ( themify_get( 'setting-product_archive_hide_title' ) == $option ) {
			$hide_title .= '<option value="'.$option.'" selected="selected">'.$name.'</option>';
		} else {
			$hide_title .= '<option value="'.$option.'">'.$name.'</option>';
		}
	}
	$output .= '<p class="feature_box_posts">
					<span class="label">' . __('Hide Product Title', 'themify') . '</span>
					<select name="setting-product_archive_hide_title">
						'.$hide_title.'
					</select>
				</p>';

	/**
	 * Hide Price Options
	 * @var String
	 * @since 1.0.0
	 */
	$hide_price = '';
	foreach($default_options as $name => $option){
		if ( themify_get( 'setting-product_archive_hide_price' ) == $option ) {
			$hide_price .= '<option value="'.$option.'" selected="selected">'.$name.'</option>';
		} else {
			$hide_price .= '<option value="'.$option.'">'.$name.'</option>';
		}
	}
	$output .= '<p class="feature_box_posts">
					<span class="label">' . __('Hide Product Price', 'themify') . '</span>
					<select name="setting-product_archive_hide_price">
						'.$hide_price.'
					</select>
				</p>';

	/**
	 * Hide Breadcrumbs
	 * @var String
	 */
	$output .= '<p><span class="label">' . __('Hide Shop Breadcrumbs', 'themify') . '</span>
				<label for="setting-hide_shop_breadcrumbs"><input type="checkbox" id="setting-hide_shop_breadcrumbs" name="setting-hide_shop_breadcrumbs" '.checked( themify_get( 'setting-hide_shop_breadcrumbs' ), 'on', false ).' /> ' . __('Check to hide shop breadcrumbs', 'themify') . '</label></p>';

	/**
	 * Hide Product Count
	 * @var String
	 */
	$output .= '<p><span class="label">' . __('Hide Product Count', 'themify') . '</span>
				<label for="setting-hide_shop_count"><input type="checkbox" id="setting-hide_shop_count" name="setting-hide_shop_count" '.checked( themify_get( 'setting-hide_shop_count' ), 'on', false ).' /> ' . __('Check to hide products counting', 'themify') . '</label></p>';

	/**
	 * Hide Sorting Bar
	 * @var String
	 */
	$output .= '<p><span class="label">' . __('Hide Sorting Bar', 'themify') . '</span>
				<label for="setting-hide_shop_sorting"><input type="checkbox" id="setting-hide_shop_sorting" name="setting-hide_shop_sorting" '.checked( themify_get( 'setting-hide_shop_sorting' ), 'on', false ).' /> ' . __('Check to hide product sorting bar', 'themify') . '</label></p>';

	/**
	 * Hide Shop Page Title
	 * @var String
	 */
	$output .= '<p><span class="label">' . __('Hide Shop Page Title', 'themify') . '</span>
				<label for="setting-hide_shop_title"><input type="checkbox" id="setting-hide_shop_title" name="setting-hide_shop_title" '.checked( themify_get( 'setting-hide_shop_title' ), 'on', false ).' /> ' . __('Check to hide shop page title', 'themify') . '</label></p>';
			
	/**
	 * Hide More Info Button
	 * @var String
	 */
	$output .= '<p><span class="label">' . __('Hide More Info Button', 'themify') . '</span>
				<label for="setting-hide_shop_more_info"><input type="checkbox" id="setting-hide_shop_more_info" name="setting-hide_shop_more_info" '.checked( themify_get( 'setting-hide_shop_more_info' ), 'on', false ).' /> ' . __('Check to hide product more info button', 'themify') . '</label></p>';
	
	/**
	 * Use Lightbox for Product Info
	 * @var String
	 * @since 1.0.0
	 */
	$product_lightbox = '';
	foreach($default_options as $name => $option){
		if ( themify_get( 'setting-product_archive_lightbox_link' ) == $option ) {
			$product_lightbox .= '<option value="'.$option.'" selected="selected">'.$name.'</option>';
		} else {
			$product_lightbox .= '<option value="'.$option.'">'.$name.'</option>';
		}
	}
	$output .= '<p class="feature_box_posts">
					<span class="label">' . __('Use Lightbox for More Info Link', 'themify') . '</span>
					<select name="setting-product_archive_lightbox_link">
						'.$product_lightbox.'
					</select>
				</p>';
	
	/**
	 * Show Short Description Options
	 * @var String
	 * @since 1.0.0
	 */
	$show_short = '';
	foreach($content_options as $name => $option){
		if ( themify_get( 'setting-product_archive_show_short' ) == $option ) {
			$show_short .= '<option value="'.$option.'" selected="selected">'.$name.'</option>';
		} else {
			$show_short .= '<option value="'.$option.'">'.$name.'</option>';
		}
	}
	$output .= '<p class="feature_box_posts">
					<span class="label">' . __('Product Description', 'themify') . '</span>
					<select name="setting-product_archive_show_short">
						'.$show_short.'
					</select>
				</p>';

	return $output;
}

/**
 * Creates module for single product settings
 * @param array
 * @return string
 * @since 1.0.0
 */
function themify_single_product($data=array()){
	$data = themify_get_data();

	$options = array(
		array('value' => 'sidebar1', 'img' => 'images/layout-icons/sidebar1.png', 'title' => __('Sidebar Right', 'themify')),
		array('value' => 'sidebar1 sidebar-left', 'img' => 'images/layout-icons/sidebar1-left.png', 'title' => __('Sidebar Left', 'themify')),
		array('value' => 'sidebar-none', 'img' => 'images/layout-icons/sidebar-none.png', 'title' => __('No Sidebar', 'themify'), 'selected' => true)
	);

	$image_options = array(
		array('value' => 'featimage_right', 'img' => 'images/layout-icons/image-left.png', 'selected' => true, 'title' => __('Product Image Left', 'themify')),
		array('value' => 'featimage_center', 'img' => 'images/layout-icons/image-center.png', 'title' => __('Product Image Center', 'themify')),
		array('value' => 'featimage_left', 'img' => 'images/layout-icons/image-right.png', 'title' => __('Product Image Center', 'themify'))
	);

	$default_options = array(
		array('name' => '', 'value' => ''),
		array('name' => __('Yes', 'themify'), 'value' => 'yes'),
		array('name' => __('No', 'themify'), 'value' => 'no')
	);

	/**
	 * Product Sidebar
	 */
	$val = isset( $data['setting-single_product_layout'] ) ? $data['setting-single_product_layout'] : '';
	$output = '<p><span class="label">' . __('Product Sidebar Option', 'themify') . '</span>';
	foreach ( $options as $option ) {
		if ( ( '' == $val || ! $val || ! isset( $val ) ) && ( isset( $option['selected'] ) && $option['selected'] ) ) {
			$val = $option['value'];
		}
		if ( $val == $option['value'] ) {
			$class = 'selected';
		} else {
			$class = '';
		}
		$output .= '<a href="#" class="preview-icon '.$class.'" title="'.$option['title'].'"><img src="'.THEME_URI.'/'.$option['img'].'" alt="'.$option['value'].'"  /></a>';
	}
	$output .= '<input type="hidden" name="setting-single_product_layout" class="val" value="'.$val.'" /></p>';

	/**
	 * Product Reviews
	 */
	$output .= '<p><span class="label">' . __('Product Reviews', 'themify') . '</span>
				<label for="setting-product_reviews"><input type="checkbox" id="setting-product_reviews" name="setting-product_reviews" '.checked( themify_get( 'setting-product_reviews' ), 'on', false ).' /> ' . __('Disable product reviews', 'themify') . '</label></p>';

	/**
	 * Related Products
	 */
	$output .= '<p><span class="label">' . __('Related Products', 'themify') . '</span>
				<label for="setting-related_products"><input type="checkbox" id="setting-related_products" name="setting-related_products" '.checked( themify_get( 'setting-related_products' ), 'on', false ).' /> ' . __('Do not display related products', 'themify') . '</label></p>';

	$related_products_limit = themify_check( 'setting-related_products_limit' ) ? themify_get( 'setting-related_products_limit' ) : 3;
	$output .= '<p><span class="label">' . __('Related Products Limit', 'themify') . '</span>
					<input type="text" name="setting-related_products_limit" value="' . $related_products_limit . '" class="width2" /></p>';

	return $output;
}

/**************************************************************************************************
 * Start Woocommerce Functions
 **************************************************************************************************/

// Declare Woocommerce support
add_theme_support( 'woocommerce' );

add_action( 'template_redirect', 'themify_redirect_product_ajax_content', 20 );
add_action( 'admin_notices', 'themify_check_ecommerce_environment_admin' );
add_action( 'current_screen', 'themify_theme_restore_image_product' );
add_action( 'themify_body_end', 'themify_theme_lightbox_added' );

add_filter( 'woocommerce_params', 'themify_woocommerce_params' );
add_filter( 'themify_body_classes', 'themify_woocommerce_site_notice_class' );
add_filter( 'themify_post_types', 'themify_theme_add_product_type' );

if ( ! function_exists( 'themify_theme_add_product_type' ) ) {
	/**
	 * Add 'product' to list of post types managed by Themify
	 * @param $types
	 * @return array
	 */
	function themify_theme_add_product_type( $types ) {
		$extended = array_merge( array( 'product' ), $types	);
		return array_unique( $extended );
	}
}

if ( ! function_exists( 'themify_edit_link' ) ) {
	/**
	 * Displays a link to edit the entry
	 */
	function themify_edit_link() {
		edit_post_link(__('Edit', 'themify'), '[', ']');
	}
}

////////////////////////////////////////////////////////////
// Sidebar Layout Classes Filter
////////////////////////////////////////////////////////////
if ( ! function_exists( 'themify_theme_sidebar_layout_condition' ) ) {
	/**
	 * Alters condition to filter layout class
	 * @param bool
	 * @return bool
	 */
	function themify_theme_sidebar_layout_condition($condition){
		return $condition || themify_is_function('is_shop') || themify_is_function('is_product_category') || themify_is_function('is_product_tag') || themify_is_function('is_product') || themify_theme_is_product_query();
	}
	add_filter('themify_default_layout_condition', 'themify_theme_sidebar_layout_condition');
}

if ( ! function_exists( 'themify_theme_sidebar_layout' ) ) {
	/**
	 * Returns default shop layout
	 * @param string $class
	 * @return string
	 */
	function themify_theme_sidebar_layout($class) {
		global $themify;
		$class = $themify->layout;
		if ( themify_is_function('is_shop') || themify_is_function('is_product_category') || themify_is_function('is_product_tag') ) {
			$class = themify_get('setting-shop_layout')? themify_get('setting-shop_layout') : 'sidebar-none';
		} elseif ( themify_is_function('is_product') ){
			$class = themify_get('setting-single_product_layout')? themify_get('setting-single_product_layout') : 'sidebar-none';
		} elseif ( themify_theme_is_product_query() ) {
			$class .= ' query-product';
		}
		return $class;
	}
	add_filter('themify_default_layout', 'themify_theme_sidebar_layout');
}

////////////////////////////////////////////////////////////
// Post Layout Classes Filter
////////////////////////////////////////////////////////////
if ( ! function_exists( 'themify_theme_default_post_layout_condition' ) ) {
	/**
	 * Alters condition to filter post layout class
	 * @param bool
	 * @return bool
	 */
	function themify_theme_default_post_layout_condition($condition) {
		return $condition || themify_is_function('is_shop') || themify_is_function('is_product_category') || themify_is_function('is_product_tag') || themify_theme_is_product_query();
	}
	add_filter('themify_default_post_layout_condition', 'themify_theme_default_post_layout_condition');
}

if ( ! function_exists( 'themify_theme_default_post_layout' ) ) {
	/**
	 * Returns default shop layout
	 * @param string $class
	 * @return string
	 */
	function themify_theme_default_post_layout( $class ) {
		global $themify;
		$class = $themify->post_layout;
		if( themify_is_function('is_shop') || themify_is_function('is_product_category') || themify_is_function('is_product_tag') ) {
			$class = '' != themify_get('setting-products_layout')? themify_get('setting-products_layout') : 'list-post';
		}
		return $class;
	}
	add_filter('themify_default_post_layout', 'themify_theme_default_post_layout');
}

/**
 * Check if the current view must be replaced with a query product loop
 * @param $context
 * @return bool
 */
function themify_theme_is_product_query() {
	global $themify;
	return '' != $themify->product_category && themify_is_woocommerce_active();
}

if ( ! function_exists( 'themify_is_function' ) ) {
	/**
	 * Checks if it's the function name passed exists and in that case, it calls the function
	 * @param string $context
	 * @return bool|mixed
	 * @since 1.0.0
	 */
	function themify_is_function( $context = '' ) {
		if( function_exists( $context ) )
			return call_user_func( $context );
		else
			return false;
	}
}

if ( ! function_exists( 'themify_woocommerce_site_notice_class' ) ) {
	/**
	 * Add additional class when Woocommerce site wide notice is enabled.
	 * @param array $classes
	 * @return array
	 * @since 1.0.0
	 */
	function themify_woocommerce_site_notice_class( $classes ) {
		$notice = get_option( 'woocommerce_demo_store' );
		if ( ! empty( $notice ) && 'no' != $notice ) {
			$classes[] = 'site-wide-notice';
		}
		return $classes;
	}
}

if ( ! function_exists( 'themify_get_ecommerce_template' ) ) {
	/**
	 * Checks if Woocommerce is active and loads the requested template
	 * @param string $template
	 * @since 1.0.0
	 */
	function themify_get_ecommerce_template( $template = '' ) {
		if ( themify_is_woocommerce_active() )
			get_template_part( $template );
	}
}

<br></br>
/**
 * Add woocommerce_enable_ajax_add_to_cart option to JS
 * @param Array
 * @return Array
 */
function themify_woocommerce_params($params){
	return array_merge($params, array(
		'option_ajax_add_to_cart' => ( 'yes' == get_option('woocommerce_enable_ajax_add_to_cart') )? 'yes': 'no'
	) );
}

/**
 * Put product variations in page
 */
function themify_available_variations() {
	global $product;
	if(isset($product->product_type) && 'variable' == $product->product_type){
		$product_vars = $product->get_available_variations();
		themify_json_esc_array($product_vars);
	} else {
		$product_vars = array();
	}
	echo '<div style="display:none;" id="themify_product_vars">' . json_encode($product_vars) . '</div>';
};

/**
 * Escape array data for later json_encode
 * @param array $arr_r Array passed by reference with data to be escaped
 */
function themify_json_esc_array(&$arr_r) {
	if(is_array($arr_r)) {
		foreach ($arr_r as &$val) {
			if(is_array($val)) {
				themify_json_esc_array($val);
			} else {
				$val = esc_html( str_replace('"', '\'', $val) );
			}
			unset($val);
		}
	} else {
		$arr_r = esc_html( str_replace('"', '\'', $val) );
	}
}

/**
 * Single product lightbox
 */
function themify_redirect_product_ajax_content() {
	global $post, $wp_query;
	// locate template single page in lightbox
	if (is_single() && isset($_GET['ajax']) && $_GET['ajax']) {
		// remove admin bar inside iframe
		add_filter( 'show_admin_bar', '__return_false' );
		if (have_posts()) {
			woocommerce_single_product_content_ajax();
			die();
		} else {
			$wp_query->is_404 = true;
		}
	}
}

if ( ! function_exists( 'themify_check_ecommerce_environment_admin' ) ) {
	/**
	 * Check in admin if Woocommerce is enabled and show a notice otherwise.
	 * @since 1.3.0
	 */
	function themify_check_ecommerce_environment_admin() {
		if ( ! themify_is_woocommerce_active() ) {
			$warning = 'installwoocommerce9';
			if ( ! get_option( 'themify_warning_' . $warning ) ) {
				wp_enqueue_script( 'themify-admin-warning' );
				echo '<div class="update-nag">'.__('Remember to install and activate WooCommerce plugin to enable the shop.', 'themify'). ' <a href="#" class="themify-close-warning" data-warning="' . $warning . '" data-nonce="' . wp_create_nonce( 'themify-warning' ) . '">' . __("Got it, don't remind me again.", 'themify') . '</a></div>';
			}
		}
	}
}

if ( ! function_exists( 'themify_check_ecommerce_scripts' ) ) {
	function themify_check_ecommerce_scripts() {
		wp_register_script( 'themify-admin-warning', THEME_URI . '/js/themify.admin.warning.js', array('jquery'), false, true );
	}
	add_action( 'admin_enqueue_scripts', 'themify_check_ecommerce_scripts' );
}

if ( ! function_exists( 'themify_dismiss_warning' ) ) {
	function themify_dismiss_warning() {
		check_ajax_referer( 'themify-warning', 'nonce' );
		$result = false;
		if ( isset( $_POST['warning'] ) ) {
			$result = update_option( 'themify_warning_' . $_POST['warning'], true );
		}
		if ( $result ) {
			echo 'true';
		} else {
			echo 'false';
		}
		die;
	}
	add_action( 'wp_ajax_themify_dismiss_warning', 'themify_dismiss_warning' );
}

/**
 * Prevent removal of featured image meta box for product editing screen
 * @param $current_screen
 */
function themify_theme_restore_image_product( $current_screen ) {
	if ( 'product' == $current_screen->post_type ) {
		remove_action('do_meta_boxes', 'themify_cpt_image_box');
	}
}

/**
 * Checks if it's a product in lightbox
 * @return bool
 */
function themify_theme_is_product_lightbox() {
	return isset( $_GET['post_in_lightbox'] ) && '1' == $_GET['post_in_lightbox'];
}

function themify_theme_lightbox_added() {
	global $woocommerce;
	if ( themify_is_woocommerce_active() ) : ?>
		<div class="lightbox-added" style="display:none;">
			<h2><?php _e('Added to Cart', 'themify'); ?></h2>
			<a href="#" rel="nofollow" class="button outline close-themibox"><?php _e('Keep Shopping', 'themify'); ?></a>
			<button type="submit" class="button checkout" onClick="document.location.href='<?php echo esc_url( $woocommerce->cart->get_checkout_url() ); ?>'; return false;"><?php _e('Checkout', 'themify')?></button>
		</div>
	<?php endif;

}

/**
 * Output settings for product background image
 * @param int $post_id
 * @return string
 */
function themify_product_fullcover( $post_id = 0 ) {
	if ( 0 == $post_id ) $post_id =  get_the_ID();
	$fullcover = get_post_meta( $post_id, 'background_repeat', true );
	return '' == $fullcover || 'default' == $fullcover? 'fullcover' : $fullcover;
}

/**
 * Markup for module to disable masonry in shop
 * @param array $data
 * @return string
 */
function themify_shop_disable_masonry_module( $data = array() ) {
	/**
	 * Variable key in theme settings
	 * @var string
	 */
	$key = 'setting-shop_masonry_disabled';

	/**
	 * Module markup
	 * @var string
	 */
	$html = sprintf('<p><label for="%1$s"><input type="checkbox" id="%1$s" name="%1$s" %2$s /> %3$s</label></p>',
		$key,
		checked( themify_get( $key ), 'on', false ),
		__( 'Disable masonry layout in product archive grid view.', 'themify' )
	);

	return $html;
}

// Load required files
if ( themify_is_woocommerce_active() ) {
	require_once(TEMPLATEPATH . '/woocommerce/theme-woocommerce.php'); // WooCommerce overrides
	require_once(TEMPLATEPATH . '/woocommerce/woocommerce-hooks.php'); // WooCommerce hook overrides
	require_once(TEMPLATEPATH . '/woocommerce/woocommerce-template.php'); // WooCommerce template overrides
}