<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?php get_header(); ?>

<!-- #homepage-features -->
<section id="homepage-features" class="clearfix">
<div class="ht-container">

<?php
// Get index ID
$ht_index_id = get_option('page_for_posts');

// Get post counts
$ht_count_posts = wp_count_posts();
$ht_count_posts = $ht_count_posts->publish;

// Get category number
$ht_count_category = get_terms( 'category');
if ( !is_wp_error( $ht_count_category ) ) {
	$ht_count_category = count($ht_count_category);
} else {
	$ht_count_category = 0;
}

if (class_exists( 'HT_Knowledge_Base' )):
// Get kb post counts
$ht_count_kbposts = wp_count_posts('ht_kb');
$ht_count_kbposts = $ht_count_kbposts->publish;
// Get kb category number
$ht_count_kbcategory = get_terms( 'ht_kb_category');
if ( !is_wp_error( $ht_count_kbcategory ) ) {
	$ht_count_kbcategory = count($ht_count_kbcategory);
} else {
	$ht_count_kbcategory = 0;
}
endif;

if (class_exists( 'bbPress' )):
// Get forum topcs counts
$ht_count_bbp_topics = wp_count_posts('topic');
$ht_count_bbp_topics = $ht_count_bbp_topics->publish;

// Get forum post counts
$ht_count_bbp_reply = wp_count_posts('reply');
$ht_count_bbp_reply = $ht_count_bbp_reply->publish;
endif;

// Get number of blocks
$ht_hpf_count = 1;
if (class_exists( 'HT_Knowledge_Base' )):
$ht_hpf_count++;
endif;
if (class_exists( 'bbPress' )):
$ht_hpf_count++;
endif;

// Set column variable
if ( $ht_hpf_count == 1) {
	$ht_hpf_col = 'ht-grid-12';
} elseif ( $ht_hpf_count == 2) {
	$ht_hpf_col = 'ht-grid-6';
} else {
	$ht_hpf_col = 'ht-grid-4';
}
?>

<div class="ht-grid ht-grid-gutter-20">

	<?php if (class_exists( 'HT_Knowledge_Base' )): ?>
	<div class="ht-grid-col <?php echo $ht_hpf_col; ?>">
	<a href="<?php echo site_url('/database'); ?>">
		<div class="hf-block hf-kb-block">
		<i class="fa fa-lightbulb-o"></i>
		<h4><?php _e( 'Knowledge Base', 'helpguru' ); ?></h4>
		<h5><?php echo $ht_count_kbposts; ?> <?php _e( 'Articles', 'helpguru' ); ?>  /  <?php echo $ht_count_kbcategory; ?> <?php _e( 'Categories', 'helpguru' ); ?></h5>
		</div>
	</a>
	</div>
	<?php endif; ?>

	<?php if (class_exists( 'bbPress' )): ?>
	<div class="ht-grid-col <?php echo $ht_hpf_col; ?>">
	<a href="<?php echo get_post_type_archive_link( 'forum' ); ?>">
		<div class="hf-block hf-forum-block">
		<i class="fa fa-comment-o"></i>
		<h4><?php _e( 'Forums', 'helpguru' ); ?></h4>
		<h5><?php echo $ht_count_bbp_topics; ?> <?php _e( 'Topics', 'helpguru' ); ?>  /  <?php echo $ht_count_bbp_reply; ?> <?php _e( 'Posts', 'helpguru' ); ?></h5>
		</div>
	</a>
	</div>
	<?php endif; ?>

	<?php $ht_index_id = get_option('page_for_posts'); ?>
	<div class="ht-grid-col <?php echo $ht_hpf_col; ?>">
	<a href="<?php echo site_url('/news'); ?>">
		<div class="hf-block hf-posts-block">
		<i class="fa fa-newspaper-o"></i>
		<h4><?php echo "News" ?></h4>
		<h5><?php echo $ht_count_posts; ?> <?php _e( 'Posts', 'helpguru' ); ?>  /  <?php echo $ht_count_category; ?> <?php _e( 'Categories', 'helpguru' ); ?></h5>
		</div>
	</a>
	</div>
</div>

</div>
</section>
<!-- /#homepage-features -->

<!-- .ht-page home-->
<div class="ht-page <?php ht_sidebarpostion_homepage(); ?>">
<div class="ht-container">

	<?php ht_get_sidebar_homepage( 'left' ); ?>

	<div class="ht-page__content">

	<?php
	$ht_hometitle = get_theme_mod( 'ht_setting__homepagetitle', __( 'Help Topics', 'knowall' ) );
	if ( '' != $ht_hometitle ) :
		?>
		<!-- <h2 class="hkb-archive__title"> -->
			<?php // echo esc_html( $ht_hometitle ); ?>
		<!-- </h2> -->
	<?php endif; ?>

		<?php global $hkb_current_term_id, $tax_term; ?>
		<?php $tax_terms = hkb_get_archive_tax_terms(); ?>

		<!-- .hkb-archive home-->
		<?php if ( $tax_terms ) : ?>

			<ul class="hkb-archive <?php echo esc_attr( ht_kbarchive_style() ); ?>">
				<?php foreach ( $tax_terms as $key => $tax_term ) : ?>
					<?php
					//set hkb_current_term_id
					$hkb_current_term_id    = $tax_term->term_id;
					$hkb_current_term_class = apply_filters( 'hkb_current_term_class_prefix', 'hkb-category--', 'archive' ) . $hkb_current_term_id;
					$hkb_current_term_class = apply_filters( 'hkb_current_term_class', $hkb_current_term_class, $hkb_current_term_id );
					?>
               <!-- custom code -->
					<?php if ($key === array_key_first($tax_terms)) {
						?>
						<li>
    					
						<div class="hkb-category <?php echo esc_attr( ht_kbarchive_catstyle( $hkb_current_term_id ) ); ?> <?php echo esc_attr( $hkb_current_term_class ); ?>">

						<?php if ( get_theme_mod( 'ht_setting__kbarchivecatarticles', '0' ) != true ) : ?>
						<a class="hkb-category__link" href="<?php echo esc_attr( get_term_link( $tax_term, 'ht_kb_category' ) ); ?>">
						<?php endif; ?>

						<?php if ( hkb_has_category_custom_icon( $hkb_current_term_id ) == 'true' ) : ?>
							<div class="hkb-category__iconwrap"><i class="fa fa-newspaper-o" style="font-size:30px;"></i></div>
						<?php endif; ?>

						<div class="hkb-category__content">
							<?php if ( get_theme_mod( 'ht_setting__kbarchivecatarticles', '0' ) == true ) : ?>
								<a class="hkb-category__headerlink" href="<?php echo site_url('/news'); ?>">
							<?php endif; ?>

							<h2 class="hkb-category__title">
								<?php echo "Recent Updates" ?>
							</h2>

							<?php if ( ( '' != $tax_term->description ) && get_theme_mod( 'ht_setting__kbarchivecatdesc', '1' ) == true ) : ?>
								<div class="hkb-category__description"><?php echo esc_html( $tax_term->description ); ?></div>
							<?php endif; ?>

							<?php if ( get_theme_mod( 'ht_setting__kbarchivecatarticles', '0' ) == true ) : ?>
								</a>
							<?php endif; ?>

							<?php
							if ( get_theme_mod( 'ht_setting__kbarchivecatarticles', '0' ) == true ) :
								$cat_posts = hkb_get_archive_articles( $tax_term, null, null, 'kb_home' );
								?>
								<?php if ( ! empty( $cat_posts ) && ! is_a( $cat_posts, 'WP_Error' ) ) : ?>

									<ul class="hkb-category__articlelist">
										<?php $homepageNews = new WP_Query(array(
           								 'posts_per_page' => 10,
         								   'post_type' => 'post',
         								   'order' => 'DESC',
         								 ));
										 while($homepageNews->have_posts()) {
          									  $homepageNews->the_post(); 
											  ?>
         									 <li>
												<a href="<?php echo esc_url( the_permalink() ); ?>"><?php echo esc_html( the_title() ); ?></a>
											</li>
											<?php
      									 }
										  wp_reset_postdata();
										 ?>
										
									</ul>
									<?php if ( get_theme_mod( 'ht_setting__kbarchivecatarticles_viewall', '0' ) == true ) : ?>
										<a class="hkb-category__viewall" href="<?php echo site_url('/news'); ?>"><?php _e( 'View all →', 'knowall' ); ?></a>
									<?php endif; ?>
								   
								<?php endif; ?>
							<?php endif; ?>

						</div>

					<?php if ( get_theme_mod( 'ht_setting__kbarchivecatarticles', '0' ) != true ) : ?> 
						</a>
					<?php endif; ?>
					</div>

						 </li>
						 <?php
  					 }?>
					 <!-- end of custom code -->
                    
				<li>

					<div class="hkb-category <?php echo esc_attr( ht_kbarchive_catstyle( $hkb_current_term_id ) ); ?> <?php echo esc_attr( $hkb_current_term_class ); ?>">

					<?php if ( get_theme_mod( 'ht_setting__kbarchivecatarticles', '0' ) != true ) : ?>
					<a class="hkb-category__link" href="<?php echo esc_attr( get_term_link( $tax_term, 'ht_kb_category' ) ); ?>">
					<?php endif; ?>

						<?php if ( hkb_has_category_custom_icon( $hkb_current_term_id ) == 'true' ) : ?>
							<div class="hkb-category__iconwrap"><?php hkb_category_thumb_img( $hkb_current_term_id ); ?></div>
						<?php endif; ?>

						<div class="hkb-category__content">
							<?php if ( get_theme_mod( 'ht_setting__kbarchivecatarticles', '0' ) == true ) : ?>
								<a class="hkb-category__headerlink" href="<?php echo esc_attr( get_term_link( $tax_term, 'ht_kb_category' ) ); ?>">
							<?php endif; ?>

							<h2 class="hkb-category__title">
								<?php 
								if($tax_term->slug == "bsea-decisions"){	
									echo "Recent Decisions "; 
								}
								elseif($tax_term->slug == "bsea-rulings"){
									echo "Recent Rulings"; 
								}
								else{
									echo esc_html( $tax_term->name ); 
								}
								?>
							</h2>

							<?php if ( ( '' != $tax_term->description ) && get_theme_mod( 'ht_setting__kbarchivecatdesc', '1' ) == true ) : ?>
								<div class="hkb-category__description"><?php echo esc_html( $tax_term->description ); ?></div>
							<?php endif; ?>

							<?php if ( get_theme_mod( 'ht_setting__kbarchivecatarticles', '0' ) == true ) : ?>
								</a>
							<?php endif; ?>

							<?php
							if ( get_theme_mod( 'ht_setting__kbarchivecatarticles', '0' ) == true ) :
								$cat_posts = hkb_get_archive_articles( $tax_term, null, null, 'kb_home' );
								?>
								<?php if ( ! empty( $cat_posts ) && ! is_a( $cat_posts, 'WP_Error' ) ) : ?>

									<ul class="hkb-category__articlelist">
										<?php foreach ( $cat_posts as $cat_post ) : ?>                            
											<li>
												<a href="<?php echo esc_url( get_permalink( $cat_post->ID ) ); ?>"><?php echo esc_html( get_the_title( $cat_post->ID ) ); ?></a>
											</li>
										<?php endforeach; ?>
									</ul>
									<?php if ( get_theme_mod( 'ht_setting__kbarchivecatarticles_viewall', '0' ) == true ) : ?>
										<a class="hkb-category__viewall" href="<?php echo esc_attr(get_term_link($tax_term, 'ht_kb_category')) ?>"><?php _e( 'View all →', 'knowall' ); ?></a>
									<?php endif; ?>
								   
								<?php endif; ?>
							<?php endif; ?>

						</div>

					<?php if ( get_theme_mod( 'ht_setting__kbarchivecatarticles', '0' ) != true ) : ?> 
						</a>
					<?php endif; ?>
					</div>                 

				</li>
				<?php endforeach; ?>
			</ul> 

		<?php else : ?>

			<div class="hkb-no-categories"><?php esc_html_e( 'No knowledge base categories to display', 'knowall' ); ?></div>

		<?php endif; ?>
		<!-- /.hkb-archive -->

		<?php
			// If HKB Exit widget is active, display mobile version on appropriate screen sizes
		if ( ht_is_widget_in_sidebar( 'ht-kb-exit-widget', 'sidebar-home' ) ) :

			$widget_instance = ht_get_widget_instance_settings( 'ht-kb-exit-widget', 'sidebar-home' );

			$ht_mobile_exit_args = array(
				'before_widget' => '<div class="ht-mobile-exit">',
				'after_widget'  => '</div>',
				'before_title'  => '<strong class="ht-mobile-exit__title">',
				'after_title'   => '</strong>',
			);
			the_widget( 'HT_KB_Exit_Widget', $widget_instance, $ht_mobile_exit_args );
		?>
			<?php endif; ?>

	</div>

	<?php ht_get_sidebar_homepage( 'right' ); ?>

</div>
</div>
<!-- /.ht-page -->

<?php
get_footer();