<?php
/*
*
* The template used for single KB articles, for use by the theme
*
*/?>

<?php get_header(); ?>

<?php hkb_get_template_part( 'hkb-pageheader', 'single' ); ?>

<!-- .ht-page -->
<div class="ht-page <?php ht_sidebarpostion_article(); ?>">
<div class="ht-container">

	<?php ht_get_sidebar_article( 'left' ); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>

		<div class="ht-page__content">
		<article <?php post_class('hkb-article'); ?> itemscope itemtype="https://schema.org/CreativeWork">
		<meta itemprop="datePublished" content="<?php the_date( 'F j, Y' ); ?>">

			<header class="hkb-article__header">
				<h1 class="hkb-article__title" itemprop="headline"><?php the_title(); ?></h1>
			</header>

			<?php
			// Is the sidebar on?
			$ht_articlesidebar = get_theme_mod( 'ht_setting__articlesidebar', 'left' );
			if ( $ht_articlesidebar != 'off' ) :

				// If TOC widget is active, display mobile version on appropriate screen sizes
				if ( ht_is_widget_in_sidebar( 'ht-kb-toc-widget', 'sidebar-article' ) ) : // check if TOC widget is active

					$widget_instance = ht_get_widget_instance_settings( 'ht-kb-toc-widget', 'sidebar-article' );

					$ht_mobile_toc_args = array(
						'before_widget' => '<div class="ht-mobile-toc">',
						'after_widget'  => '</div>',
						'before_title'  => '<strong class="ht-mobile-toc__title">',
						'after_title'   => '</strong>',
					);
					the_widget( 'HT_KB_Table_Of_Contents', $widget_instance, $ht_mobile_toc_args );
			
				endif;
			endif; ?>

			<div class="hkb-article__content" itemprop="text">

				<?php the_content(); ?>

				<?php
				wp_link_pages(
					array(
						'before' => '<div class="ht-article__links">' . __( 'Pages:', 'knowall' ),
						'after'  => '</div>',
					)
				);
				?>

			</div>

			<?php if ( get_theme_mod( 'ht_setting__articlemodified', '1' ) == 1 ) : ?>
				<div class="hkb-article__lastupdated" itemprop="dateModified">
					<?php esc_html_e( 'Updated on', 'knowall' ); ?> <?php the_modified_date(); ?>
				</div>
			<?php endif; ?>

			<?php hkb_get_template_part( 'hkb-single-attachments' ); ?>

			<?php hkb_get_template_part( 'hkb-single-tags' ); ?>

			<?php do_action( 'ht_kb_end_article' ); ?>

			<?php if ( get_theme_mod( 'ht_setting__articleauthor', '0' ) == 1 ) : ?>
				<?php hkb_get_template_part( 'hkb-single-author' ); ?>
			<?php endif; ?>

			<?php if ( get_theme_mod( 'ht_setting__articlerelated', '1' ) == 1 ) : ?>
				<?php hkb_get_template_part( 'hkb-single-related' ); ?>
			<?php endif; ?>

			<?php
			// If HKB Exit widget is active, display mobile version on appropriate screen sizes
			if ( ht_is_widget_in_sidebar( 'ht-kb-exit-widget', 'sidebar-article' ) ) :

				$widget_instance = ht_get_widget_instance_settings( 'ht-kb-exit-widget', 'sidebar-article' );
				
				$ht_mobile_exit_args = array(
					'before_widget' => '<div class="ht-mobile-exit">',
					'after_widget'  => '</div>',
					'before_title'  => '<strong class="ht-mobile-exit__title">',
					'after_title'   => '</strong>',
				);
				the_widget( 'HT_KB_Exit_Widget', $widget_instance, $ht_mobile_exit_args );
				?>
			<?php endif; ?>

		</article>

		<?php
		// Get global setting for comments on articles
		if ( get_theme_mod( 'ht_setting__articlecomments', '0' ) ) :

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

		endif;
		?>

		</div>

	<?php endwhile; // end of the loop. ?>

	<?php ht_get_sidebar_article( 'right' ); ?>

</div>
</div>

<?php
get_footer();
