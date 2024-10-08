<?php
/**
* Pagination function
*/
if ( ! function_exists( 'ht_posts_nav_link' ) ) :
function ht_posts_nav_link() {
	global $wp_query;
	$max_num_pages = $wp_query->max_num_pages;

	if ( $max_num_pages > 1 ) : ?>
		<div class="ht-pagination">

			<?php if ( get_previous_posts_link() ) : ?>

				<span class="ht-pagination__prev"><?php  previous_posts_link( __( 'Prev','knowall' ) ); ?></span>

			<?php endif; ?>

			<?php if ( get_next_posts_link() ) : ?>

				<span class="ht-pagination__next"><?php next_posts_link( __( 'Next','knowall' ) ); ?></span>

			<?php endif; ?>
			
		</div>
	<?php endif;
}
endif;

/**
* Build body attributes
*/
function ht_get_body_attributes() {

	$ht_articlesidebar_stick = get_theme_mod( 'ht_setting__articlesidebar_stick', '1' );

	$ht_body_attributes = '';

	if ( '1' == $ht_articlesidebar_stick ) :
		$ht_body_attributes .= 'data-spy="scroll" data-offset="' . ( apply_filters('ht_scroll_offset', 0 ) + apply_filters('ht_scrollspy_offset', 30 ) ) . '" data-target="#navtoc"';
	endif;

	return $ht_body_attributes;

}

/**
* Output attributes to the <body>
*/
function ht_output_body_attributes() {
	echo ht_get_body_attributes();
}