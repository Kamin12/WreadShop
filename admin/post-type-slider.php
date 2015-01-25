<?php
/**
 * Slider Meta Box Options
 * @param array $args
 * @return array
 * @since 1.0.0
 */
function themify_theme_slider_meta_box( $args = array() ) {
	extract( $args );
	return array(
		// Post Layout
		array(
			"name" 		=> "layout",
			"title"		=> __('Slide Layout', 'themify'),
			"description"	=> "",
			"type"		=> "layout",
			'show_title' => true,
			"meta"		=> array(
				array(
					'value' => 'textright',
					'img' => 'images/layout-icons/slider-default.png',
					'selected' => true,
					'title' => __('Text Right', 'themify')
				),
				array(
					'value' => 'textcenter',
					'img' => 'images/layout-icons/slider-image-center.png',
					'selected' => true,
					'title' => __('Text Center', 'themify')
				),
				array(
					'value' => 'textleft',
					'img' => 'images/layout-icons/slider-image-right.png',
					'selected' => true,
					'title' => __('Text Left', 'themify')
				)
			)
		),
		// Feature Image
		array(
			"name" 		=> "feature_image",
			"title" 		=> __('Featured Image', 'themify'), //slider image
			"description" => __('This image is used as the slide background.', 'themify'),
			"type" 		=> "image",
			"meta"		=> array()
		),
		// Featured Image Size
		array(
			'name'	=>	'feature_size',
			'title'	=>	__('Image Size', 'themify'),
			'description' => __('Image sizes can be set at <a href="options-media.php">Media Settings</a> and <a href="admin.php?page=themify_regenerate-thumbnails">Regenerated</a>', 'themify'),
			'type'		 =>	'featimgdropdown'
		),
		// Image Width
		array(
			"name" 		=> "image_width",
			"title" 		=> __('Image Width', 'themify'),
			"description" => "",
			"type" 		=> "textbox",
			"meta"		=> array("size"=>"small")
		),
		// Image Height
		array(
			"name" 		=> "image_height",
			"title" 		=> __('Image Height', 'themify'),
			"description" => __('Enter height = 0 to disable vertical cropping with img.php enabled', 'themify'),
			"type" 		=> "textbox",
			"meta"		=> array("size"=>"small")
		),
		// Image Link
		array(
			"name" 		=> "image_link",
			"title" 		=> __('Image Link', 'themify'),
			"description" => "",
			"type" 		=> "textbox",
			"meta"		=> array()
		),
		// External Link
		array(
			"name" 		=> "external_link",
			"title" 		=> __('External Link', 'themify'),
			"description" => __('Link Featured Image to external URL', 'themify'),
			"type" 		=> "textbox",
			"meta"		=> array()
		),
		// Lightbox Link + Zoom icon
		themify_lightbox_link_field()
	);
}

/**
 * Slide styles
 * @param array $args
 * @return array
 */
function themify_theme_slider_style_meta_box( $args = array() ) {
	extract( $args );
	return array(
		// Separator
		array(
			'name' => 'separator_title_font',
			'title' => '',
			'description' => '',
			'type' => 'separator',
			'meta' => array('html'=>'<h4>'.__('Title Font', 'themify').'</h4><hr class="meta_fields_separator"/>'),
		),
		// Multi field: Font
		array(
			'type' => 'multi',
			'name' => '_font_title',
			'title' => __('Font', 'themify'),
			'meta' => array(
				'fields' => array(
					// Font size
					array(
						'name' => 'title_font_size',
						'label' => '',
						'description' => '',
						'type' => 'textbox',
						'meta' => array('size'=>'small'),
						'before' => '',
						'after' => ''
					),
					// Font size unit
					array(
						'name' 	=> 'title_font_size_unit',
						'label' => '',
						'type' 	=> 'dropdown',
						'meta'	=> array(
							array('value' => 'px', 'name' => __('px', 'themify'), 'selected' => true),
							array('value' => 'em', 'name' => __('em', 'themify'))
						),
						'before' => '',
						'after' => ''
					),
					// Font family
					array(
						'name' 	=> 'title_font_family',
						'label' => '',
						'type' 	=> 'dropdown',
						'meta'	=> array_merge(  themify_get_web_safe_font_list(), themify_get_google_web_fonts_list() ),
						'before' => '',
						'after' => '',
					),
				),
				'description' => '',
				'before' => '',
				'after' => '',
				'separator' => ''
			)
		),
		// Separator
		array(
			'name' => 'separator_title_text_color',
			'title' => '',
			'description' => '',
			'type' => 'separator',
			'meta' => array('html'=>'<h4>'.__('Title &amp; Text', 'themify').'</h4><hr class="meta_fields_separator"/>'),
		),
		// Title Font Color
		array(
			'name' => 'title_font_color',
			'title' => __('Title Font Color', 'themify'),
			'description' => '',
			'type' => 'color',
			'meta' => array('default' => null),
		),
		// Text Font Color
		array(
			'name' => 'text_font_color',
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
		// Background Color
		array(
			'name' => 'background_color',
			'title' => __('Background Color', 'themify'),
			'description' => '',
			'type' => 'color',
			'meta' => array('default'=>null),
		),
	);
}

/**
 * Register slider post type and taxonomy.
 *
 * @since 1.2.5
 */
function themify_theme_register_header_slider() {
	/**************************************************************************************
	 * Slider Post Type
	 **************************************************************************************/

	register_post_type('slider', array(
		'labels' =>  array(
			'name' => __( 'Slider', 'themify' ),
			'singular_name' => __( 'Slider', 'themify' ),
			'add_new' => __( 'Add New Slide', 'themify' ),
			'add_new_item' => __( 'Add New Slide', 'themify' ),
			'edit_item' => __( 'Edit Slide', 'themify' ),
			'new_item' => __( 'New Slide', 'themify' ),
			'view_item' => __( 'View Slide', 'themify' ),
			'search_items' => __( 'Search Slides', 'themify' ),
			'not_found' => __( 'No slides found', 'themify' ),
			'not_found_in_trash' => __( 'No slides found in Trash', 'themify' ),
			'parent_item_colon' => __( 'Parent Slider:', 'themify' ),
			'menu_name' => __( 'Slider', 'themify' ),
		),
		'description' => '',
		'menu_position' => 5,
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'show_in_nav_menus' => false,
		'hierarchical' => false,
		'rewrite' => false,
		'query_var' => false,
		'supports' => array('title', 'editor', 'author', 'custom-fields')
	));

	/**************************************************************************************
	 * Slider Category Taxonomy
	 **************************************************************************************/

	register_taxonomy( 'slider-category', array('slider'), array(
		'labels' => array(
			'name' => __( 'Slide Categories', 'themify' ),
			'singular_name' => __( 'Slide Category', 'themify' ),
			'search_items' => __( 'Search Slide Categories', 'themify' ),
			'popular_items' => __( 'Popular Slide Categories', 'themify' ),
			'all_items' => __( 'All Categories', 'themify' ),
			'parent_item' => __( 'Parent Slide Category', 'themify' ),
			'parent_item_colon' => __( 'Parent Slide Category:', 'themify' ),
			'edit_item' => __( 'Edit Slide Category', 'themify' ),
			'update_item' => __( 'Update Slide Category', 'themify' ),
			'add_new_item' => __( 'Add New Slide Category', 'themify' ),
			'new_item_name' => __( 'New Slide Category', 'themify' ),
			'separate_items_with_commas' => __( 'Separate Slide Category with commas', 'themify' ),
			'add_or_remove_items' => __( 'Add or remove Slide Category', 'themify' ),
			'choose_from_most_used' => __( 'Choose from the most used Slide Category', 'themify' ),
			'menu_name' => __( 'Slide Category', 'themify' ),
		),
		'public' => true,
		'show_in_nav_menus' => false,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_tagcloud' => true,
		'hierarchical' => true,
		'rewrite' => true,
		'query_var' => true
	));
}
add_action( 'init', 'themify_theme_register_header_slider' );

/**************************************************************************************
 * Homepage Feature Box
 **************************************************************************************/

/**
 * Feature box module for theme settings
 * @param array $data
 * @return string
 */
function themify_homepage_featurebox( $data = array() ) {
	$data = themify_get_data();

	$key = 'setting-feature_box_';

	$title_options = array(
		__('Show', 'themify') => 'show',
		__('Hide', 'themify') => 'hide'
	);
	$effect_options = array(
		__('Slide', 'themify') => 'slide',
		__('Fade', 'themify')  => 'fade'
	);
	$speed_options = array(
		__('Slow', 'themify')   => 3000,
		__('Normal', 'themify') => 2000,
		__('Fast', 'themify')   => 1000
	);
	$auto_options = array(
		__('4 Secs (default)', 'themify') => 4000,
		__('Off', 'themify')    => 0,
		__('1 Sec', 'themify')  => 1000,
		__('2 Sec', 'themify')  => 2000,
		__('3 Sec', 'themify')  => 3000,
		__('4 Sec', 'themify')  => 4000,
		__('5 Sec', 'themify')  => 5000,
		__('6 Sec', 'themify')  => 6000,
		__('7 Sec', 'themify')  => 7000,
		__('8 Sec', 'themify')  => 8000,
		__('9 Sec', 'themify')  => 9000,
		__('10 Sec', 'themify') => 10000
	);

	/**
	 * Get slider categories
	 */
	$slider_categories = themify_theme_get_terms( 'slider-category', array(
			'off' => array(
				'name' => __('Disable Slider', 'themify'),
				'value'	=> 'off'
			),
			'' => array(
				'name' => '-----------------------------',
				'value'	=> 'off'
			),
			'all' => array(
				'name' => __('All Slider Categories', 'themify'),
				'value'	=> '0'
			),
		)
	);

	/**
	 * Default or custom number of slides
	 */
	$slides = isset( $data[$key.'slides'] )? $data[$key.'slides'] : '5';

	/**
	 * Slider Category
	 */
	$out = sprintf('
			<p>
				<span class="label">%s</span>
				<select name="%s">%s</select>
				<span class="pushlabel"><small>%s</small></span>
			</p>',
			__( 'Slider Category', 'themify' ),
			$key.'category',
			themify_options_module( $slider_categories, $key.'category', true, '0' ),
			__( 'Select a slide category for the slider.', 'themify' )
		);

	/**
	 * Slider Effect
	 */
	$out .= '<p>
				<span class="label">' . __('Effect', 'themify') . '</span>
				<select name="'.$key.'effect">';
				foreach ( $effect_options as $name => $val ) {
					if ( themify_get( $key.'effect' ) == $val ) {
						$out .= '<option value="'.$val.'" selected="selected">'.$name.'</option>';
					} else {
						$out .= '<option value="'.$val.'">'.$name.'</option>';
					}
				}
	$out .=	'	</select>
			</p>';
	/**
	 * Slider Speed
	 */
	$out .= '<p>
				<span class="label">' . __('Speed', 'themify') . '</span>
				<select name="'.$key.'speed">';
				foreach ( $speed_options as $name => $val ) {
					if ( themify_get( $key.'speed' ) == $val ) {
						$out .= '<option value="'.$val.'" selected="selected">'.$name.'</option>';
					} else {
						$out .= '<option value="'.$val.'">'.$name.'</option>';
					}
				}
	$out .= '	</select>
			</p>';
	/**
	 * Slider AutoPlay
	 */
	$out .= '<p>
				<span class="label">' . __('Auto-play', 'themify') . '</span>
				<select name="'.$key.'auto">';
				foreach ( $auto_options as $name => $val ) {
					if ( themify_get( $key.'auto' ) == $val ) {
						$out .= '<option value="'.$val.'" selected="selected">'.$name.'</option>';
					} else {
						$out .= '<option value="'.$val.'">'.$name.'</option>';
					}
				}
	$out .=	'	</select> <small>' . __('(Off = disable autoplay)', 'themify') . '</small>
			</p>';

	/**
	 * Number of slides to show
	 */
	$out .= '<p>
				<span class="label">' . __('Number of Slides', 'themify') . '</span>
					<input type="text" name="'.$key.'slides" value="'. $slides .'" class="width2" />
			</p>';

	/**
	 * Show slide title
	 */
	$out .= '<p>
				<span class="label">' . __('Show Slide Title', 'themify') . '</span>
				<select name="'.$key.'title">';
				foreach ( $title_options as $name => $val ) {
					if ( themify_get( $key.'title' ) == $val ) {
						$out .= '<option value="'.$val.'" selected="selected">'.$name.'</option>';
					} else {
						$out .= '<option value="'.$val.'">'.$name.'</option>';
					}
				}
	$out .=	'	</select>
			</p>';

	return $out;
}

if( ! function_exists( 'themify_theme_get_terms' ) ) {
	/**
	 * Return terms from specified taxonomy
	 * @param string $terms_tax
	 * @return mixed|void
	 */
	function themify_theme_get_terms( $terms_tax = 'category', $prepend = array() ) {
		$terms_list = array();
		$terms_by_tax = get_terms($terms_tax, array( 'hide_empty' => false ));
		if ( ! is_wp_error( $terms_by_tax ) ) {
			foreach ($terms_by_tax as $term) {
				$terms_list[$term->term_id] = array(
					'name' => $term->name,
					'value'	=> $term->slug
				);
			}
		}
		$out = array_merge(
			$prepend,
			$terms_list
		);
		return apply_filters("themify_theme_get_{$terms_tax}_terms", $out);
	}
}

if ( ! function_exists( 'themify_theme_header_slider' ) ) {
	/**
	 * Include slider
	 * @since 1.0.0
	 */
	function themify_theme_header_slider() {
		get_template_part( 'includes/slider');
	}
	add_action( 'themify_layout_before', 'themify_theme_header_slider' );
}