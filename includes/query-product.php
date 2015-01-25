<?php
/**
 * Products loop query
 * @since 1.0.0
 */
global $themify;

$loop = new WP_Query( $themify->query_products );

if ( $loop->have_posts() ) : ?>

	<!-- loops-wrapper -->
	<div id="loops-wrapper" class="loops-wrapper <?php echo $themify->layout . ' ' . $themify->post_layout; ?>">

		<ul class="products clearfix">

		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

			<?php
			//////////////////////////////////////////////////////////////////////////
			// Load custom content-product.php template in theme/woocommerce
			//////////////////////////////////////////////////////////////////////////
			woocommerce_get_template_part( 'content', 'product' );
			?>

		<?php endwhile; ?>

		</ul>
		<!-- /.products -->

	</div>
	<!-- /loops-wrapper -->

	<?php if ( 'yes' != $themify->page_navigation ) : ?>

		<?php
		if ( 'infinite' == themify_get( 'setting-more_posts' ) || '' == themify_get( 'setting-more_posts' ) ) {
			global $themify;
			$total_pages = $loop->max_num_pages;
			$current_page = get_query_var( 'paged' )? get_query_var( 'paged' ) : 1;
			if ( $total_pages > $current_page ) {
				if ( $themify->query_category != '' ) {
					//If it's a Query Category page, set the number of total pages
					echo '<script type="text/javascript">var qp_max_pages = ' . $total_pages . '</script>';
				}
				echo '<p id="load-more"><a href="' . next_posts( $total_pages, false ) . '">' . __( 'Load More', 'themify' ) . '</a></p>';
			}
		} else {
			themify_pagenav( '', '', $loop );
		}
		?>

	<?php endif; // show page navigation ?>

<?php endif; // have posts ?>

<?php wp_reset_postdata(); ?>