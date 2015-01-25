<?php
/**
 * Template for home page slider
 */

global $themify;
$show = false;
$theme_enabled = 'off' != themify_get( 'setting-feature_box_enabled' );
$fp = is_front_page();
$p = is_page();
$slider_term = themify_get( 'setting-feature_box_category' );
$slides = themify_check( 'setting-feature_box_slides' )? themify_get( 'setting-feature_box_slides' ) : '5';

if ( themify_is_woocommerce_active() && is_shop() ) {
	$page_slider = get_post_meta( get_option('woocommerce_shop_page_id'), 'page_slider', true );
} elseif( isset( $themify->page_id ) ) {
	$page_slider = get_post_meta( $themify->page_id, 'page_slider', true );
}

if ( ! isset( $page_slider ) || '' == $page_slider ) {
	if ( $fp ) {
		if ( $theme_enabled ) {
			$show = true;
		} else {
			$show = false;
		}
	} else {
		$show = false;
	}
} else {
	$show = true;
	$slider_term = $page_slider;
}

if ( $show ) :

	$slider_query = array(
		'post_type' => 'slider',
		'posts_per_page' => $slides
	);

	if ( '' != $slider_term && '0' != $slider_term ) {
		$slider_query['tax_query'] = array(
			array(
				'taxonomy' => 'slider-category',
				'field' => 'slug',
				'terms' => $slider_term
			)
		);
	}

	$slider_loop = new WP_Query( $slider_query );
	?>

	<?php if ( $slider_loop->have_posts() ) : ?>

	<div id="sliderwrap" class="clearfix">

		<?php themify_slider_before(); //hook ?>

		<div id="slider-inner">

			<?php themify_slider_start(); //hook ?>

			<div id="slider">

				<ul class="slides clearfix">

					<?php while ( $slider_loop->have_posts() ) : $slider_loop->the_post(); ?>

					<li <?php post_class( 'type-post slider-post' ); ?>>

						<?php $link = themify_get_featured_image_link('no_permalink=true'); ?>

						<?php
						$before = '';
						$after = '';
						if( $link != ''){
							$before = '<a href="'. $link .'" title="'. the_title_attribute('echo=0') . '">';
							$after = '</a>' . $after;
						}
						$slider_image_w = '' != themify_get( 'image_width' )? themify_get( 'image_width' ) : '1064';
						$slider_image_h = '' != themify_get( 'image_height' )? themify_get( 'image_height' ) : '500';
						?>

						<figure class="slide-feature-image">
							<?php echo $before . themify_get_image('ignore=true&w='.$slider_image_w.'&h='.$slider_image_h.'&class=slide-feature-image') . $after; ?>
						</figure>
						<!-- /.slide-feature-image -->

						<div class="slide-content-wrap <?php echo themify_get('layout'); ?>">
							<div class="slide-content">
								<?php if ( 'hide' != themify_get( 'setting-feature_box_title' ) ) : ?>
									<h3 class="slide-post-title">
										<?php echo $before . get_the_title() . $after; ?>
									</h3>
								<?php endif; ?>
								<div class="slide-excerpt">
									<?php the_content(); ?>
								</div>
								<!-- /.slide-excerpt -->
								<?php edit_post_link(__('Edit Slide', 'themify'), '<span class="edit-button">[', ']</span>'); ?>
							</div>
							<!-- /.slide-content -->
						</div>
						<!-- /.slide-content-wrap -->
						<?php themify_theme_custom_post_css(); ?>
					</li>
					<?php endwhile; ?>
				</ul>

			</div>
			<!-- /slider -->

			<?php themify_slider_end(); //hook ?>
		</div>
		<!--/slider-inner -->
		<?php themify_slider_after(); //hook ?>

	</div>
	<!--/sliderwrap -->
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>

<?php endif; // end if show slider ?>