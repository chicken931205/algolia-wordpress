<article id="post-<?php the_ID(); ?>" class="hkb-articlemini" itemscope itemtype="https://schema.org/CreativeWork">

	<h2 class="hkb-article__title" itemprop="headline">
		<a href="<?php the_permalink(); ?>">
			<?php the_title(); ?>
		</a>
	</h2>

	<?php if ( hkb_show_search_excerpt() && hkb_get_the_excerpt() ) : ?>
		<div class="hkb-article__excerpt">
			<?php hkb_the_excerpt(); ?>
		</div>
	<?php endif; ?>

</article>
