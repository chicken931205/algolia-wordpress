<?php if ( is_active_sidebar( 'sidebar-blog' ) ) : ?>
	<!-- .sidebar -->
	<aside class="sidebar" itemscope itemtype="https://schema.org/WPSideBar">   
		<?php dynamic_sidebar( 'sidebar-blog' ); ?>
	</aside>
	<!-- /.sidebar -->
<?php endif; ?>
