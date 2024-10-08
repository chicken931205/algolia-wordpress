<?php
/*
*
* Theme template for ht_kb_tag taxonomy
*
*/
$ht_acategorysidebar = get_theme_mod( 'ht_setting__acategorysidebar', 'right' );
?>

<?php get_header(); ?>

<?php hkb_get_template_part( 'hkb-pageheader', 'single' ); ?>

<!-- .ht-page -->
<div class="ht-page ht-page--sidebar<?php echo esc_attr( $ht_acategorysidebar ); ?>">
<div class="ht-container">

	<?php
	if ( 'left' == $ht_acategorysidebar ) :
		get_sidebar( 'category' );
	endif;
	?>

	<div class="ht-page__content">

	<?php if ( have_posts() ) : ?>

		<ul class="ht-articlelist">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<li>
					<?php hkb_get_template_part( 'hkb-content-article', 'tag' ); ?>
				</li>
			<?php endwhile; ?>
		</ul>

		<?php posts_nav_link(); ?> 

	<?php else : ?>

		<h2><?php esc_html_e( 'Nothing else in this category.', 'knowall' ); ?></h2>

	<?php endif; ?>

</div>

	<?php
	if ( 'right' == $ht_acategorysidebar ) :
		get_sidebar( 'category' );
	endif;
	?>

</div>
</div>
<!-- /.ht-page -->

<?php
get_footer();
