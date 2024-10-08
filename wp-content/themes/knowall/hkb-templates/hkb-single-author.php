<?php
/**
* The template for author single
*/
?>

<?php if ( function_exists( 'get_the_author_meta' ) ) : ?>
	<section class="hkb-article-author">
		<?php if ( ! is_author() ) : ?>
			<h3 class="hkb-article-author__title">
			<?php esc_html_e( 'About The Author', 'knowall' ); ?>
			</h3>
		<?php endif; ?>
		<div class="hkb-article-author__avatar">
			<?php if ( function_exists( 'get_avatar' ) ) : ?> 
				<?php echo get_avatar( get_the_author_meta( 'email' ), '70' ); ?>
			<?php endif; ?>
		</div>
		<h4 class="hkb-article-author__name">
			<?php echo get_the_author(); ?>
		</h4>
		<div class="hkb-article-author__bio">
			<?php if ( get_the_author_meta( 'description' ) ) : ?>
				<?php the_author_meta( 'description' ); ?>
			<?php else : ?>
				<?php echo esc_html( printf( __( '%s has not written a bio yet', 'knowall' ), get_the_author() ) ); ?>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
