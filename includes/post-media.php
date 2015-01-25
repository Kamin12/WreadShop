<?php
/**
 * Partial template to display the post video or the post image
 * Created by themify
 * @since 1.0.0
 */

/** Themify Default Variables
 *  @var object */
global $themify; ?>

<?php if ( $themify->hide_image != 'yes' ) : ?>

	<?php if ( themify_get( 'video_url' ) != '' ) : ?>

		<?php themify_before_post_image(); // Hook ?>

		<div class="single-media-wrap">
			<div class="post-video">
				<?php
					global $wp_embed;
					echo $wp_embed->run_shortcode('[embed]' . themify_get('video_url') . '[/embed]');
				?>
			</div>
		</div>

		<?php themify_after_post_image(); // Hook ?>

	<?php elseif ( $post_image = themify_get_image( $themify->auto_featured_image . $themify->image_setting . "w=".$themify->width."&h=".$themify->height ) ) : ?>

			<?php themify_before_post_image(); // Hook ?>

			<figure class="post-image <?php echo $themify->image_align; ?> <?php if ( is_single() ) : echo 'single-media-wrap'; endif; ?>">

				<?php if ( 'yes' == $themify->unlink_image ): ?>

					<?php echo $post_image; ?>

				<?php else: ?>

					<a href="<?php echo themify_get_featured_image_link(); ?>"><?php echo $post_image; ?><?php themify_zoom_icon(); ?></a>

				<?php endif; ?>

			</figure>

			<?php themify_after_post_image(); // Hook ?>

	<?php endif; // end if video else image ?>

<?php endif; ?>