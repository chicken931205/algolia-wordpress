<?php get_header(); ?>

<?php get_template_part( 'pageheader', 'single' ); ?>

<!-- .ht-page -->
<div class="ht-page <?php ht_sidebarpostion_blog(); ?>">
<div class="ht-container">

	<?php ht_get_sidebar_blog( 'left' ); ?>

	<div class="ht-page__content">
		<?php
		while ( have_posts() ) :
			the_post();
			?>


		<article id="ht-post-<?php the_ID(); ?>" <?php post_class('ht-post'); ?> itemscope itemtype="https://schema.org/CreativeWork">
		<meta itemprop="datePublished" content="<?php the_date( 'F j, Y' ); ?>">

			<header class="ht-post__header">
				<h1 class="ht-post__title"><?php the_title(); ?></h1>
				<div class="ht-post__meta">
					<?php the_date(); ?>
					<?php the_category( ', ' ); ?>
					<?php the_author(); ?>
				</div>
			</header>

			<div class="ht-post__content">

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

			<footer class="ht-post__footer">
				<div class="hkb-article-tags">
					<?php the_tags( __( 'Tagged: ', 'knowall' ), '', '' ); ?>
				</div>
			</footer>

			<?php
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>

		</article>

		<?php endwhile; // End of the loop. ?>

	</div>

	<?php ht_get_sidebar_blog( 'right' ); ?>

</div>
</div>

<?php
get_footer();
