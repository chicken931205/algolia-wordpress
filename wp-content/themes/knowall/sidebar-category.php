<?php if ( is_active_sidebar( 'sidebar-category' ) ) : ?>
	<!-- .sidebar -->
	<aside class="sidebar" itemscope itemtype="https://schema.org/WPSideBar">   
		<?php dynamic_sidebar( 'sidebar-category' ); ?>
	</aside>
	<!-- /.sidebar -->
<?php endif; ?>
