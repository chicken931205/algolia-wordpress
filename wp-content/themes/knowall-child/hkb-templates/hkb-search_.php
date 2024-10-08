<?php
/**
 * The template for displaying Archive pages.
 *
 */

get_header(); ?>

<?php  // get_template_part( 'page-header', 'kb' ); 
hkb_get_template_part( 'hkb-pageheader', 'single' );?>

	<!-- #primary -->
	<div id="primary" class="<?php echo get_theme_mod( 'ht_blog_sidebar', 'sidebar-right' ); ?> clearfix">
		<div class="ht-container">
			<!-- #content -->
			<main id="content" role="main">
				<div id="ht-kb" class="ht-kb-search">

					<?php if ( have_posts() ) : ?>

						<?php while ( have_posts() ) : the_post(); ?>

							<?php hkb_get_template_part( 'hkb-content-archive-search' ); ?>

						<?php endwhile; ?>

						<?php //ht_pagination(); 
						 ht_posts_nav_link(); 
						?>

					<?php else : ?>

						<?php get_template_part( 'content', 'none' ); ?>

					<?php endif; ?>
				</div>
			</main>
			<!-- /#content -->

			<?php $ht_blog_sidebar = get_theme_mod( 'ht_blog_sidebar', 'sidebar-right' );
			if ( $ht_blog_sidebar != 'sidebar-off' ) {
				get_sidebar();
			} ?>

		</div>
	</div>
	<!-- /#primary -->

<?php get_footer(); ?>