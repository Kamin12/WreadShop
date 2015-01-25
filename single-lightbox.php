<!doctype html>
<html <?php language_attributes(); ?>>

	<head>
		<meta charset="<?php bloginfo('charset'); ?>">

		<title><?php echo is_home() || is_front_page()? get_bloginfo('name') : wp_title('');?></title>

		<!-- wp_header -->
		<?php wp_head(); ?>
	</head>

	<body class="single single-post">

		<div id="pagewrap">

			<div id="body">

				<div class="lightbox-item">

					<?php if (have_posts()) while (have_posts()) : the_post(); ?>

						<?php woocommerce_get_template_part('content', 'single-product'); ?>

						<?php edit_post_link(__('Edit', 'themify'), '<span class="edit-button">[', ']</span>'); ?>

						<?php get_template_part( 'includes/post-nav'); ?>

					<?php endwhile; ?>

				</div>
				<!-- /.lightbox-item -->

			</div>
			<!-- /#body -->

			<!-- wp_footer -->
			<?php wp_footer(); ?>

		</div>

	</body>

</html>