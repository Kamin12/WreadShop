<?php
/**
 * Template for site footer
 * @package themify
 * @since 1.0.0
 */
?>
<?php
/** Themify Default Variables
 *  @var object */
	global $themify; ?>

				<?php themify_layout_after(); // hook ?>
			</div>
			<!-- /body -->

			<div id="footerwrap">

				<?php themify_footer_before(); // hook ?>
				<footer id="footer" class="pagewidth clearfix">
					<?php themify_footer_start(); // hook ?>

					<?php get_template_part( 'includes/footer-widgets'); ?>

					<p class="back-top">
						<a href="#header"><?php _e('Back to Top', 'themify'); ?></a>
					</p>

					<div class="social-widget">
						<?php dynamic_sidebar('social-widget-footer'); ?>
					</div>
					<!-- /.social-widget -->

					<div class="footer-text clearfix">
						<?php themify_the_footer_text(); ?>
						<?php themify_the_footer_text('right'); ?>
					</div>

					<!-- /footer-text -->
					<?php themify_footer_end(); // hook ?>
				</footer>
				<!-- /#footer -->

				<?php if ( themify_check( 'setting-store_info_address' ) || themify_check( 'setting-store_info_phone' ) || themify_check( 'setting-store_info_hours' ) ) : ?>
					<div class="store-info">
						<?php if ( themify_check( 'setting-store_info_address' ) ) :
							$store_info_address = function_exists( 'icl_t' )? icl_t( 'Themify', 'setting-store_info_address', themify_get( 'setting-store_info_address' ) ) : themify_get('setting-store_info_address' ); ?>
							<p class="store-address"><i class="fa fa-building icon-building"></i><?php echo $store_info_address; ?></p>
						<?php endif; ?>

						<?php if ( themify_check( 'setting-store_info_phone' ) ) : ?>
							<p class="store-phone"><i class="fa fa-phone icon-phone"></i><?php echo themify_get('setting-store_info_phone' ); ?></p>
						<?php endif; ?>

						<?php if ( themify_check( 'setting-store_info_hours' ) ) : ?>
							<p class="store-hours"><i class="fa fa-time icon-time"></i><?php echo themify_get( 'setting-store_info_hours' ); ?></p>
						<?php endif; ?>
					</div>
				<!-- /.store-info -->
				<?php endif; ?>

				<?php if ( $map = themify_get( 'setting-store_info_map' ) ) :
					if ( ! stripos( $map, 'iframe' ) ) {
						$zoom_level = themify_check( 'setting-store_info_zoom_level' )? themify_get( 'setting-store_info_zoom_level' ) : '8';
						$map = do_shortcode( '[map address="' . str_replace( array("\r", "\n"), '', $map ) . '" width="100%" height="100%" zoom="' . $zoom_level . '"]' );
					}
					?>
					<div class="google-map"><?php echo $map; ?></div>
					<!-- /.google-map -->
				<?php endif; ?>

				<?php themify_footer_after(); // hook ?>
			</div>
			<!-- /#footerwrap -->

		</div>
		<!-- /#pagewrap -->

		<?php
		/**
		 *  Stylesheets and Javascript files are enqueued in theme-functions.php
		 */
		?>

		<?php themify_body_end(); // hook ?>
<!-- wp_footer -->
<?php wp_footer(); ?>

	</body>
</html>