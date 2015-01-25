<?php

/**
 * WooCommerce Template Override
 * woocommerce-template.php
 */

if (!function_exists('woocommerce_get_product_thumbnail')) {
	/**
	 * WooCommerce Product Thumbnail
	 * @param string $size Image size
	 * @param int $placeholder_width Width of image placeholder
	 * @param int $placeholder_height Height of image placeholder
	 * @return string Markup including image
	 */
	function woocommerce_get_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0 ) {
		global $post;

		$shop_catalog = wc_get_image_size( $size );

		if (!$placeholder_width) $placeholder_width = $shop_catalog['width'];
		if (!$placeholder_height) $placeholder_height = $shop_catalog['height'];

		$html = '<figure class="product-image">';

		if ( has_post_thumbnail() ) {
			$html .= get_the_post_thumbnail($post->ID, $size);
		} else {
			$html .= '<img src="http://placehold.it/'.$placeholder_width.'x'.$placeholder_height.'" alt="Placeholder" />';
		}

		$html .= '<span class="loading-product"></span>';
		$html .= '</figure>';

		return $html;
	}
}

if ( ! function_exists( 'themify_theme_before_shop_content' ) ) {
	/**
	 * Add initial portion of wrapper
	 */
	function themify_theme_before_shop_content() {
		global $themify;
		if( 'sidebar-none' == $themify->layout ) {
			$fullwidth = '';
		} else {
			$fullwidth = 'pagewidth';
		}
		?>

		<!-- layout -->
		<div id="layout-wrap">
		<div id="layout" class="pagewidth clearfix">

	        <?php themify_content_before(); //hook ?>
			<!-- content -->
			<div id="content">
				
				<?php if ( ! themify_check( 'setting-hide_shop_breadcrumbs' ) && ! is_product() ) { ?>
				
					<?php themify_breadcrumb_before(); ?>
					
					<?php woocommerce_breadcrumb(); ?>
					
					<?php themify_breadcrumb_after(); ?>
					
				<?php } ?>
				
				<?php themify_content_start(); //hook ?>
				
				<?php
	}
}

if(!function_exists('themify_theme_after_shop_content')) {
	/**
	 * Add end portion of wrapper
	 */
	function themify_theme_after_shop_content() {
				if (is_search() && is_post_type_archive() ) {
					add_filter( 'woo_pagination_args', 'woocommerceframework_add_search_fragment', 10 );
				} ?>
				<?php themify_content_end(); //hook ?>
			</div>
			<!-- /#content -->
			 <?php themify_content_after() //hook; ?>

			<?php
			if(is_shop() || is_product_category()) {
				$layout = themify_get('setting-shop_layout');
			} else {
				$layout = themify_check('setting-single_product_layout')? themify_get('setting-single_product_layout'): 'sidebar-none';
			}
			if ($layout != 'sidebar-none') get_sidebar();
		?>
		</div>
		<!-- /#layout -->
		</div>
		<!-- /#layout-wrap -->
		<?php
	}
}

///////////////////////////////////////////////////////////////////////
// Single product
///////////////////////////////////////////////////////////////////////

if ( ! function_exists( 'themify_theme_single_product_start' ) ) {
	function themify_theme_single_product_start() {
		global $themify;
		$themify->is_single_product_main = true;
		$post_id = get_the_ID();
		$class = 'sidebar-none' == $themify->layout? 'pagewidth' : '';
		$class = themify_theme_is_product_lightbox() ? '' : $class;
		?>

		<div class="<?php echo 'product-single-top ' . themify_get( 'product_image_layout' ) . ' ' . themify_product_fullcover( $post_id ); ?>">

			<div id="product_single_wrapper" class="<?php echo $class; ?> clearfix">

				<?php
				if ( ! themify_check( 'setting-hide_shop_breadcrumbs' ) && is_product() ) { ?>

					<?php themify_breadcrumb_before(); ?>

					<?php if ( ! themify_theme_is_product_lightbox() ) woocommerce_breadcrumb(); ?>

					<?php themify_breadcrumb_after(); ?>

				<?php
				}
	}
}

if ( ! function_exists( 'themify_theme_single_product_end' ) ) {
	function themify_theme_single_product_end() { ?>
				</div>
				<!-- /.pagewidth -->
			</div>
			<!-- /.product-style -->
		<?php
		if ( ! themify_theme_is_product_lightbox() ) {
			themify_theme_custom_post_css();
		}
		global $themify;
		$themify->is_single_product_main = false;
	}
}

if(!function_exists('themify_theme_wc_compatibility_sidebar')) {
	/**
	 * Add sidebar if it's enabled in theme settings
	 * @since 1.4.6
	 */
	function themify_theme_wc_compatibility_sidebar(){
		// Check if WC is active and this is a WC-managed page
		if( !themify_is_woocommerce_active() || !is_woocommerce() ) return;

		$sidebar_layout = 'sidebar-none';

		if( is_product() ) {
			if( themify_check('setting-single_product_layout') ) {
				$sidebar_layout = themify_get('setting-single_product_layout');
			} elseif( themify_check('setting-default_page_post_layout') ) {
				$sidebar_layout = themify_get('setting-default_page_post_layout');
			}
		} else {
			if( themify_check('setting-shop_layout') ) {
				$sidebar_layout = themify_get('setting-shop_layout');
			} elseif( themify_check('setting-default_layout') ) {
				$sidebar_layout = themify_get('setting-default_layout');
			}
		}

		themify_ecommerce_sidebar_before(); // Hook

		if ( $sidebar_layout != 'sidebar-none' ) {
			get_sidebar();
		}

		themify_ecommerce_sidebar_after(); // Hook
	}
}

////////////////////////////////////////////////////////////////////////
// Loop products
////////////////////////////////////////////////////////////////////////

/**
 * Outputs product short description or full content depending on the setting.
 */
function themify_after_shop_loop_item() {
	global $themify;
	// Product Short Description or Full Content /////////////////////////
	if ( '' != $themify->product_archive_show_short ) {
		$product_archive_show_short = $themify->product_archive_show_short;
	} elseif ( themify_check( 'setting-product_archive_show_short' ) ) {
		$product_archive_show_short = 'excerpt';
	} else {
		$product_archive_show_short = '';
	}
	 ?>
		<div itemprop="description" class="product-description">
			<?php
			if ( 'excerpt' == $product_archive_show_short ) {
				the_excerpt();
			} elseif ( 'content' == $product_archive_show_short ) {
				the_content();
			}
			?>
		</div>
	<?php
	if ( ! $themify->is_related_loop ) {
		themify_theme_custom_post_css();
	}
}

if ( ! function_exists( 'themify_theme_product_class' ) ) {
	function themify_theme_product_class( $classes, $class, $post_id ) {
		global $themify;
		if ( 'product' == get_post_type( $post_id ) ) {
			if ( 'list-post' == $themify->post_layout && ! is_product() ) {
				$classes[] = themify_get( 'product_image_layout' );
			}
			if ( themify_theme_is_product_lightbox() ) {
				$classes[] = 'image-left';
			}
			$classes[] = themify_product_fullcover( $post_id );
		}
		return $classes;
	}
}

if ( ! function_exists( 'themify_theme_product_description_wrap' ) ) {
	function themify_theme_product_description_wrap( $description ) {
		return '<div class="product-description">' . $description . '</div><!-- /.product-description -->';
	}
}

if (!function_exists('woocommerce_single_product_content_ajax')) {
	/**
	 * WooCommerce Single Product Content with AJAX
	 * @param object|bool $wc_query
	 */
	function woocommerce_single_product_content_ajax( $wc_query = false ) {

		// Override the query used
		if (!$wc_query) {
			global $wp_query;
			$wc_query = $wp_query;
		}

		if ( $wc_query->have_posts() ) while ( $wc_query->have_posts() ) : $wc_query->the_post(); ?>
			<div id="product_single_wrapper" class="product product-<?php the_ID(); ?> single product-single-ajax">
				<div class="product-imagewrap">
					<?php do_action('themify_single_product_image_ajax'); ?>
				</div>
				<div class="product-content product-single-entry">
					<h3 class="product-title"><?php the_title(); ?></h3>
					<div class="product-price">
						<?php do_action('themify_single_product_price'); ?>
					</div>
					<?php do_action('themify_single_product_ajax_content'); ?>
				</div>
			</div>
			<!-- /.product -->
		<?php endwhile;
	}
}

if(!function_exists('themify_product_image_ajax')){
	/**
	 * Filter image of product loaded in lightbox to remove link and wrap in figure.product-image. Implements filter themify_product_image_ajax for external usage
	 * @param string $html Original markup
	 * @param int $post_id Post ID
	 * @return string Image markup without link
	 */
	function themify_product_image_ajax($html, $post_id) {
		$image = get_the_post_thumbnail( $post_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
		return apply_filters( 'themify_product_image_ajax', sprintf( '<figure class="product-image">%s<span class="loading-product"></span></figure>', $image ) );
	};
}

if(!function_exists('themify_product_image_single')){
	/**
	 * Filter image of product loaded in lightbox to remove link and wrap in figure.product-image. Implements filter themify_product_image_ajax for external usage
	 * @param string $html Original markup
	 * @param int $post_id Post ID
	 * @return string Image markup without link
	 */
	function themify_product_image_single($html, $post_id) {
		//$html = str_replace('</a>', '<span class="loading-product"></span></a>', $html);
		//<figure class="product-image">%s</figure>
		$pattern = '/(<img(.*)>)<\/a>/i';
		$replacement = '<figure class="product-image">${1}<span class="loading-product"></span></figure></a>';
		$html = preg_replace($pattern, $replacement, $html);
		return $html;
	};
}

if(!function_exists('themify_loop_add_to_cart_link')) {
	/**
	 * Filter link to setup lightbox capabilities
	 * @param string $format Original markup
	 * @param object $product WC Product Object
	 * @param array $link Array of link parameters
	 * @return string Markup for link
	 */
	function themify_loop_add_to_cart_link( $format = '', $product = null ) {
		$url = $product->add_to_cart_url();
		if ( function_exists( 'themify_is_touch' ) ) {
			$isPhone = themify_is_touch( 'phone' );
		} else {
			if ( ! class_exists( 'Themify_Mobile_Detect' ) ) {
				require_once THEMIFY_DIR . '/class-themify-mobile-detect.php';
			}
			$detect = new Themify_Mobile_Detect;
			$isPhone = $detect->isMobile() && !$detect->isTablet();
		}
		if( ( 'variable' == $product->product_type || 'grouped' == $product->product_type ) && !$isPhone ) {
			$url = add_query_arg( array('post_in_lightbox' => '1'), $url );
			$replacement = 'class="variable-link themify-lightbox '; // add space at the end
			$format = preg_replace( '/(class=")/', $replacement, $format, 1 );
			$format = preg_replace( '/href="(.*?)"/', 'href="'.$url.'"', $format, 1 );
		}
		if ( $product->is_purchasable() ) {
			$format = preg_replace( '/add_to_cart_button/', 'add_to_cart_button theme_add_to_cart_button', $format, 1 );
		}
		return $format;
	}
}

if(!function_exists('themify_product_description')){
	/**
	 * WooCommerce Single Product description
	 */
	function themify_product_description(){
		the_content();
	}
}

if ( ! function_exists( 'themify_theme_sale_flash' ) ) {
	function themify_theme_sale_flash( $html ) {
		return '<span class="onsale">'.__( 'Sale', 'themify' ).'</span>';
	}
}