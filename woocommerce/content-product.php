<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $themify;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';

////////////////////////////////////
// Themify Specific
////////////////////////////////////

$full_width = '';
$title_class = 'product_title';
if ( 'sidebar-none' == $themify->layout ) {
	$full_width = 'pagewidth';
}
if ( 'list-post' != $themify->post_layout ) {
	$full_width = '';
}
if ( $themify->is_related_loop || ( ( is_woocommerce() || themify_theme_is_product_query() ) && 'list-post' != $themify->post_layout ) ) {
	$title_class = '';
}

?>
<li data-product-id="<?php echo get_the_ID(); ?>" <?php post_class( $classes ); ?>>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<?php if ( ! $themify->is_related_loop ) : ?>
		<div class="clearfix <?php echo $full_width; ?>">
	<?php endif; ?>

		<a href="<?php the_permalink(); ?>">
			<?php
				/**
				 * woocommerce_before_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_show_product_loop_sale_flash - 10
				 * @hooked woocommerce_template_loop_product_thumbnail - 10
				 */
				do_action( 'woocommerce_before_shop_loop_item_title' );
			?>
		</a>

		<?php if ( ! $themify->is_related_loop ) : ?>
			<div class="summary entry-summary">
		<?php endif; ?>

			<a href="<?php the_permalink(); ?>">
				<h3 class="<?php echo $title_class; ?>"><?php the_title(); ?></h3>
			</a>

			<?php
				/**
				 * woocommerce_after_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_template_loop_price - 10
				 */
				do_action( 'woocommerce_after_shop_loop_item_title' );
			?>

			<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

			<?php
			if('' == themify_get('setting-hide_shop_more_info')) {
				$info_link	= get_permalink();
				$link_class	= '';
				if(themify_get('setting-product_archive_lightbox_link') != 'no') {
					$info_link = add_query_arg( array('post_in_lightbox' => '1'), $info_link );
					$link_class	.= 'themify-lightbox';
				}
			?>
			<a href="<?php echo $info_link; ?>" class="button outline <?php echo $link_class; ?>">
				<?php _e('More Info', 'themify'); ?>
			</a>
			<?php
			}
			?>

	<?php if ( ! $themify->is_related_loop ) : ?>
			</div>
			<!-- /.summary -->

		</div><!-- /.fullwidth -->
	<?php endif; ?>

</li>