<?php
/**
 * Template for site header
 * @package themify
 * @since 1.0.0
 */
?>
<!doctype html>
<html <?php echo themify_get_html_schema(); ?> <?php language_attributes(); ?>>
<head>
<?php
/** Themify Default Variables
 *  @var object */
	global $themify; ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">

<title itemprop="name"><?php wp_title(); ?></title>

<?php
/**
 *  Stylesheets and Javascript files are enqueued in theme-functions.php
 */
?>

<!-- wp_header -->
<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php themify_body_start(); // hook ?>

<div id="pagewrap" class="hfeed site">

	<div id="headerwrap" class="clearfix">

		<?php themify_header_before(); // hook ?>

		<header id="header" class="pagewidth">

        	<?php themify_header_start(); // hook ?>

			<hgroup>
				<?php echo themify_logo_image('site_logo'); ?>

				<?php if ( $site_desc = get_bloginfo( 'description' ) ) : ?>
					<?php global $themify_customizer; ?>
					<div id="site-description" class="site-description"><?php echo class_exists( 'Themify_Customizer' ) ? $themify_customizer->site_description( $site_desc ) : $site_desc; ?></div>
				<?php endif; ?>
			</hgroup>

			<?php if ( themify_is_woocommerce_active() ) : global $woocommerce; ?>
				<a id="cart-icon" href="#slide-cart" data-uk-offcanvas="{target:'#slide-cart'}"><i class="fa fa-shopping-cart icon-shopping-cart"></i><?php echo $woocommerce->cart->get_cart_total(); ?></a>
			<?php endif; ?>

			<a id="menu-icon" href="#slide-nav" data-uk-offcanvas="{target:'#slide-nav'}"><i class="fa fa-reorder icon-reorder"></i></a>

			<?php if ( has_nav_menu( 'horizontal-menu' ) ) : ?>
				<nav class="horizontal-menu-wrap">
					<?php
						wp_nav_menu( array( 'theme_location' => 'horizontal-menu' , 'fallback_cb' => 'themify_default_main_nav' , 'container'  => '' , 'menu_id' => 'horizontal-menu' , 'menu_class' => 'horizontal-menu' ) );
					?>
					<!-- /#horizontal-menu -->
				</nav>
			<?php endif; ?>

			<div id="slide-nav" class="uk-offcanvas">
				<div class="uk-offcanvas-bar uk-offcanvas-bar-flip">
					<a id="menu-icon-close" href="#slide-nav"><i class="icon-flatshop-close"></i></a>

					<?php if ( ! themify_check( 'setting-exclude_search_form' ) ) : ?>
						<?php get_search_form(); ?>
					<?php endif ?>

					<div class="social-widget">
						<?php dynamic_sidebar('social-widget'); ?>

						<?php if ( ! themify_check('setting-exclude_rss' ) ) : ?>
							<div class="rss"><a href="<?php themify_theme_feed_link(); ?>"><i class="fa fa-rss icon-rss"></i></a></div>
						<?php endif ?>
					</div>
					<!-- /.social-widget -->

					<nav class="main-nav-wrap">
						<?php
						if ( function_exists( 'themify_custom_menu_nav' ) ) {
							themify_custom_menu_nav();
						} else {
							wp_nav_menu( array(
								'theme_location' => 'main-nav',
								'fallback_cb'    => 'themify_default_main_nav',
								'container'      => '',
								'menu_id'        => 'main-nav',
								'menu_class'     => 'main-nav'
							));
						}
						?>
						<!-- /#main-nav -->
					</nav>
				</div>
			</div>
			<!-- /#slide-nav -->

			<?php if ( themify_is_woocommerce_active() ) : ?>
				<div id="slide-cart" class="uk-offcanvas">
					<div class="uk-offcanvas-bar uk-offcanvas-bar-flip">
						<a id="cart-icon-close" href="#slide-cart"><i class="icon-flatshop-close"></i></a>
						<?php themify_get_ecommerce_template( 'includes/shopdock' ); ?>
					</div>
				</div>
			<?php endif; ?>

		<?php themify_header_end(); // hook ?>

		</header>
		<!-- /#header -->

        <?php themify_header_after(); // hook ?>

	</div>
	<!-- /#headerwrap -->

	<div id="body" class="clearfix">

    <?php themify_layout_before(); //hook ?>
