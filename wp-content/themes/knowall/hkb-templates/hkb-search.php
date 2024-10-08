<?php
/*
*
* The template used for single page, for use by the theme
*
*/
?>

<?php get_header(); ?>

<?php hkb_get_template_part( 'hkb-pageheader', 'single' ); ?>

<div class="ht-page ht-page--sidebaroff">
<div class="ht-container">

	<div class="ht-page__content">

		<?php if ( have_posts() ) : ?>

			<ul class="ht-articlelist">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<li>
				<?php hkb_get_template_part( 'hkb-content-article' ); ?>
				</li>
			<?php endwhile; ?>
			</ul>

			<?php ht_posts_nav_link(); ?>

		<?php else : ?>

			<div class="hkb-search-noresults">
				<h2 class="hkb-search-noresults__title">
					<?php esc_html_e( 'No Results', 'knowall' ); ?>
				</h2>
				<p><?php printf( esc_html__( 'Your search for "%s" returned no results. Perhaps try something else?', 'knowall' ), get_search_query() ); ?></p>
			</div>

		<?php endif; ?>

	</div>

</div>
</div>

<?php
get_footer();
