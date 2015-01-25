<?php
/**
 * Loop Price
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;

if ( is_object( $product ) ) :
	if ( $price_html = $product->get_price_html() ) : ?>
		<p itemprop="price" class="price">
			<?php echo $product->get_price_html(); ?>

			<?php if ($product->is_on_sale()) : ?>

				<?php echo apply_filters('woocommerce_sale_flash', '<span class="onsale">'.__( 'Sale!', 'woocommerce' ).'</span>', $post, $product); ?>

			<?php endif; ?>
		</p>
	<?php
	endif; // $price_html
endif; // is_object( $product ) ?>