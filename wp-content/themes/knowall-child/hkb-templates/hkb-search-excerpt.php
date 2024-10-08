<a href="<?php the_permalink(); ?>">
	<span class="hkb-searchresults__title"><?php the_title(); ?></span>
	<?php if( hkb_show_search_excerpt() && function_exists('hkb_the_excerpt') ): ?>
		<span class="hkb-searchresults__excerpt"><?php hkb_the_excerpt(); ?></span>
	<?php endif; ?>
	<?php hkb_get_template_part( 'hkb-article-meta', 'search' ); ?>
</a>