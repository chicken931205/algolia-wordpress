<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?>>

	<h3 class="entry-title" itemprop="headline">
		<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
	</h3>

	<?php // hkb_get_template_part( 'hkb-article-meta' ); ?>

	<span class="ht-kb-search-result-excerpt"><?php the_excerpt(); ?></span>

</article>