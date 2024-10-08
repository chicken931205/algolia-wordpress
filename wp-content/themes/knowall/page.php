<?php get_header(); ?>

<?php 
	//don't use pageheader for front page
	if( !is_front_page() ){
		hkb_get_template_part( 'hkb-pageheader', 'single' );
	}
?>

<!-- .ht-page -->
<div class="ht-page <?php ht_sidebarpostion_page(); ?>">
<div class="ht-container">

	<?php ht_get_sidebar_page( 'left' ); ?>

	<div class="ht-page__content">

		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<article class="hkb-article">

				<header class="hkb-article__header">
					<h1 class="hkb-article__title"><?php the_title(); ?></h1>
				</header>

				<div class="hkb-article__content" itemprop="articleBody">

				<?php
				the_content();

				wp_link_pages(
					array(
						'before' => '<div class="ht-article__links">' . __( 'Pages:', 'knowall' ),
						'after'  => '</div>',
					)
				);
				?>

				</div>

			</article>

			<?php
		endwhile; // End of the loop.
		?>

		<?php
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
		?>
	</div>

	<?php ht_get_sidebar_page( 'right' ); ?>

</div>
</div>
<!-- /.ht-page -->

<?php
get_footer();
