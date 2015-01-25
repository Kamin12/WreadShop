<?php
/**
 * Template for page view including query categories
 * @package themify
 * @since 1.0.0
 */
?>

<?php get_header(); ?>

<?php 
/** Themify Default Variables
 *  @var object */
global $themify; ?>

<!-- layout -->
<div id="layout-wrap">
<div id="layout" class="pagewidth clearfix">

	<?php themify_content_before(); // hook ?>
	<!-- content -->
	<div id="content" class="clearfix">

    	<?php themify_content_start(); // hook ?>
	
		<?php 
		/////////////////////////////////////////////
		// 404							
		/////////////////////////////////////////////
		if(is_404()): ?>
			<h1 class="page-title" itemprop="name"><?php _e('404','themify'); ?></h1>	
			<p><?php _e( 'Page not found.', 'themify' ); ?></p>	
		<?php endif; ?>

		<?php 
		/////////////////////////////////////////////
		// PAGE							
		/////////////////////////////////////////////
		?>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<div id="page-<?php the_ID(); ?>" class="type-page" itemscope itemtype="http://schema.org/Article">
						
				<!-- page-title -->
				<?php if($themify->page_title != "yes"): ?>
					<h1 class="page-title" itemprop="name"><?php the_title(); ?></h1>
				<?php endif; ?>
				<!-- /page-title -->

				<div class="page-content entry-content" itemprop="articleBody">

					<?php the_content(); ?>

					<?php wp_link_pages(array('before' => '<p class="post-pagination"><strong>'.__('Pages:','themify').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

					<?php edit_post_link(__('Edit','themify'), '[', ']'); ?>

					<!-- comments -->
					<?php if(!themify_check('setting-comments_pages') && $themify->query_category == ""): ?>
						<?php comments_template(); ?>
					<?php endif; ?>
					<!-- /comments -->

				</div>
				<!-- /.post-content -->
		
			</div><!-- /.type-page -->

		<?php endwhile; endif; ?>

		<?php
		/////////////////////////////////////////////
		// Begin Product / Post Query
		/////////////////////////////////////////////
		?>
		<?php if ( themify_theme_is_product_query() ) : ?>

			<?php themify_get_ecommerce_template( 'includes/query-product', 'page' ); ?>

		<?php else : // do standard query ?>

			<?php
			/////////////////////////////////////////////
			// Query Category
			/////////////////////////////////////////////
			?>
			<?php if($themify->query_category != ''): ?>

				<?php query_posts( apply_filters( 'themify_query_posts_page_args', 'cat='.$themify->query_category.'&posts_per_page='.$themify->posts_per_page.'&paged='.$themify->paged.'&order='.$themify->order.'&orderby='.$themify->orderby ) ); ?>

				<?php if(have_posts()): ?>

					<!-- loops-wrapper -->
					<div id="loops-wrapper" class="loops-wrapper <?php echo $themify->layout . ' ' . $themify->post_layout; ?>">

						<?php while(have_posts()) : the_post(); ?>

							<?php get_template_part('includes/loop', 'query'); ?>

						<?php endwhile; ?>

					</div>
					<!-- /loops-wrapper -->

					<?php if ($themify->page_navigation != 'yes'): ?>
						<?php get_template_part( 'includes/pagination'); ?>
					<?php endif; ?>

				<?php else : ?>

				<?php endif; ?>

				<?php wp_reset_query(); ?>

			<?php endif; ?>

		<?php endif; // end product/post query ?>
        
		<?php themify_content_end(); // hook ?>
	</div>
	<!-- /content -->
    <?php themify_content_after(); // hook ?>

	<?php 
	/////////////////////////////////////////////
	// Sidebar							
	/////////////////////////////////////////////
	if ($themify->layout != 'sidebar-none'): get_sidebar(); endif; ?>

</div>
<!-- /#layout -->
</div>
<!-- /#layout-wrap -->
	
<?php get_footer(); ?>