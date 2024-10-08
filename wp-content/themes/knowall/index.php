<?php get_header(); ?>

<!-- .ht-page -->
<div class="ht-page <?php ht_sidebarpostion_blog(); ?>">
	<div class="ht-container">

		<?php ht_get_sidebar_blog( 'left' ); ?>

		<div class="ht-page__content">
		<?php if ( have_posts() ) : ?>

				<ul class="ht-postlist">
					<?php
					while ( have_posts() ) :
						the_post();
						?>
					<li>
						<?php get_template_part( 'content' ); ?>
					</li>
					<?php endwhile; ?>
				</ul>

				<?php
				ht_posts_nav_link();

			else :

				get_template_part( 'content', 'none' );

			endif;
			?>
		</div>

		<?php ht_get_sidebar_blog( 'right' ); ?>

	</div>
</div>

<?php
get_footer();
