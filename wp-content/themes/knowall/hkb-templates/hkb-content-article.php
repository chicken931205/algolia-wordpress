<article id="post-<?php the_ID(); ?>" class="hkb-articlemini" itemscope itemtype="https://schema.org/CreativeWork">
	<a class="hkb-article__link" href="<?php the_permalink(); ?>">
	<h2 class="hkb-article__title" itemprop="headline">
			<?php the_title(); ?>
	</h2>

	<?php if ( hkb_show_taxonomy_article_excerpt() && hkb_get_the_excerpt() ) : ?>
		<div class="hkb-article__excerpt">
			<?php hkb_the_excerpt(); ?>
		</div>
	<?php endif; ?>
	</a>
</article>
