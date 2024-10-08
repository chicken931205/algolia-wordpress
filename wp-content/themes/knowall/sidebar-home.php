<?php if ( is_active_sidebar( 'sidebar-home' ) ) : ?>
	<!-- .sidebar -->
	<aside class="sidebar" itemscope itemtype="https://schema.org/WPSideBar">   
		<?php dynamic_sidebar( 'sidebar-home' ); ?>
	</aside>
	<!-- /.sidebar -->
<?php endif; ?>
