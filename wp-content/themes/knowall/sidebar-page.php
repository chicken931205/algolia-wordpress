<?php if ( is_active_sidebar( 'sidebar-page' ) ) : ?>
	<!-- .sidebar -->
	<aside class="sidebar" itemscope itemtype="https://schema.org/WPSideBar">   
		<?php dynamic_sidebar( 'sidebar-page' ); ?>
	</aside>
	<!-- /.sidebar -->
<?php endif; ?>
