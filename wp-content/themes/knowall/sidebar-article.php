<?php if ( is_active_sidebar( 'sidebar-article' ) ) : ?>
	<?php $ht_articlesidebar_stick = get_theme_mod( 'ht_setting__articlesidebar_stick', '1' ); ?>
	<!-- .sidebar -->
	<aside class="sidebar <?php if ( '1' == $ht_articlesidebar_stick ) : ?>sidebar--sticky<?php endif; ?>" itemscope itemtype="https://schema.org/WPSideBar">
		<?php dynamic_sidebar( 'sidebar-article' ); ?>
	</aside>
	<!-- /.sidebar -->
<?php endif; ?>
