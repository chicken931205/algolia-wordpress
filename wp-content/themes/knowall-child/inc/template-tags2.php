<?php
/**
* Pagination function
*/
if ( ! function_exists( 'ht_posts_nav_link' ) ) :
function ht_posts_nav_link() {
	global $wp_query;
	$max_num_pages = $wp_query->max_num_pages;

	if ( $max_num_pages > 1 ) : ?>
		<div class="ht-pagination tt">

			<?php if ( get_previous_posts_link() ) : ?>

				<!-- <span class="ht-pagination__prev"> -->
					<?php  //previous_posts_link( __( 'Prev','knowall' ) ); ?>
				<!-- </span> -->

			<?php endif; ?>
				<?php echo paginate_links(); ?>
			<?php if ( get_next_posts_link() ) : ?>

				<!-- <span class="ht-pagination__next"> -->
					<?php //next_posts_link( __( 'Next','knowall' ) ); ?>
				<!-- </span> -->

			<?php endif; ?>
			
		</div>
	<?php endif;
}
endif;

