<article id="post-<?php the_ID(); ?>" class="hkb-articlemini" itemscope itemtype="https://schema.org/CreativeWork">
	<div class="hkb-article__link" data_href="<?php the_permalink(); ?>" data_post_id="<?php the_ID(); ?>">
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
