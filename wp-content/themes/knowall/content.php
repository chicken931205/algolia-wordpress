<article id="ht-post-<?php the_ID(); ?>" <?php post_class('ht-postmini'); ?>>

	<header class="ht-post__header">

		<h2 class="ht-post__title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

		<div class="ht-post__meta">
			<ul>
				<li><?php the_date(); ?></li>	
				<li>
				<?php if ( get_the_category() ) : ?>
					<ul class="ht-post__metacategory">
					<?php foreach ( ( get_the_category() ) as $category ) { ?>
						<li><?php echo esc_html( $category->cat_name ); ?></li>
						<?php
					}
					?>
					</ul>
				<?php endif; ?>
				</li>
				<li><?php the_author(); ?></li>
			</ul>
		</div>

	</header>

	<div class="ht-post__excerpt">

		<?php the_excerpt(); ?>

	</div>

</article>
