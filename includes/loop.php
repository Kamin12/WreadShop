<?php
/**
 * Template for generic post display.
 * @package themify
 * @since 1.0.0
 */
?>
<?php if(!is_single()){ global $more; $more = 0; } //enable more link ?>

<?php
/** Themify Default Variables
 *  @var object */
global $themify; ?>

<?php themify_post_before(); // hook ?>

<article itemscope itemtype="http://schema.org/Article" id="post-<?php the_ID(); ?>" <?php post_class('post clearfix'); ?>>

	<?php themify_post_start(); // hook ?>

	<?php if ( ! is_singular( 'post' ) ): ?>
			<?php get_template_part( 'includes/post-media' ); ?>
	<?php endif; // hide image ?>

	<?php if ( $overlap_image = themify_get('overlap_image') ) : ?>
		<div class="overlap-image">
			<?php
			$overlap_image_dimensions = apply_filters( 'themify_theme_overlap_image_dimensions', array(
				'width' => 120,
				'height' => 0,
			));

			if ( themify_is_image_script_disabled() ) {
				if ( $oi = get_post_meta(get_the_ID(), '_overlap_image_attach_id', true) ) {
					echo wp_get_attachment_image( $oi, 'thumbnail', false, array(
						'width' => $overlap_image_dimensions['width'],
						'alt' => trim(strip_tags( get_post_meta($oi, '_wp_attachment_image_alt', true) )),
					) );
				}
			} else {
				themify_image( 'ignore=true&w=' . $overlap_image_dimensions['width'] . '&h=' . $overlap_image_dimensions['height'] . '&src=' . $overlap_image . '&alt=' . the_title_attribute('echo=0') );
			}
			?>
		</div>
	<?php endif; ?>

	<div class="post-content">

		<?php if($themify->hide_title != 'yes'): ?>
			<?php themify_before_post_title(); // Hook ?>
			<?php if($themify->unlink_title == 'yes'): ?>
				<h1 class="post-title entry-title" itemprop="name"><?php the_title(); ?></h1>
			<?php else: ?>
				<h1 class="post-title entry-title" itemprop="name"><a href="<?php echo themify_get_featured_image_link(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
			<?php endif; //unlink post title ?>
			<?php themify_after_post_title(); // Hook ?>
		<?php endif; //post title ?>

		<?php if($themify->hide_meta != 'yes'): ?>
			<p class="post-meta entry-meta">

				<?php if($themify->hide_date != 'yes'): ?>
					<time datetime="<?php the_time('o-m-d') ?>" class="post-date entry-date updated" itemprop="datePublished"><?php echo get_the_date( apply_filters( 'themify_loop_date', '' ) ) ?></time> <span class="separator">|</span>
				<?php endif; ?>

				<?php if($themify->hide_meta_author != 'yes'): ?>
					<span class="post-author"><?php echo themify_get_author_link() ?></span> <span class="separator">|</span>
				<?php endif; ?>

				<?php  if( !themify_get('setting-comments_posts') && comments_open() && $themify->hide_meta_comment != 'yes' ) : ?>
					<span class="post-comment"><?php comments_popup_link( __( '0 Comment', 'themify' ), __( '1 Comment', 'themify' ), __( '% Comments', 'themify' ) ); ?></span> <span class="separator">|</span>
				<?php endif; ?>

				<?php if($themify->hide_meta_category != 'yes'): ?>
					<?php echo the_terms( get_the_ID(), 'category', '<span class="post-category">', ', ', '</span> <span class="separator">|</span> ' ); ?>
				<?php endif; ?>

				<?php if($themify->hide_meta_tag != 'yes'): ?>
					<?php echo the_terms( get_the_ID(), 'post_tag', '<span class="post-tag">', ', ', '</span>' ); ?>
				<?php endif; ?>

			</p>
		<?php endif; //post meta ?>

		<div class="entry-content" itemprop="articleBody">

		<?php if ( 'excerpt' == $themify->display_content && ! is_attachment() ) : ?>

			<?php the_excerpt(); ?>

			<?php if( themify_check('setting-excerpt_more') ) : ?>
				<p><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute('echo=0'); ?>" class="more-link"><?php echo themify_check('setting-default_more_text')? themify_get('setting-default_more_text') : __('More &rarr;', 'themify') ?></a></p>
			<?php endif; ?>

		<?php elseif ( 'none' == $themify->display_content && ! is_attachment() ) : ?>

		<?php else: ?>

			<?php the_content(themify_check('setting-default_more_text')? themify_get('setting-default_more_text') : __('More &rarr;', 'themify')); ?>

		<?php endif; //display content ?>

		</div><!-- /.entry-content -->

		<?php edit_post_link(__('Edit', 'themify'), '<span class="edit-button">[', ']</span>'); ?>

	</div>
	<!-- /.post-content -->
	<?php themify_post_end(); // hook ?>

</article>
<?php themify_post_after(); // hook ?>

<!-- /.post -->