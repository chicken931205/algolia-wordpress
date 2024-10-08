<?php $subcategories = hkb_get_subcategories(); ?>
<?php if ( $subcategories ) : ?>

	<!--.hkb-subcats-->
	<ul class="hkb-subcats <?php echo esc_attr( ht_kbarchive_style() ); ?>">
		<?php foreach ( $subcategories as $subcategory ) : ?>
			<li>
				<?php
					$hkb_current_term_id    = $subcategory->term_id;
					$hkb_current_term_class = apply_filters( 'hkb_current_term_class_prefix', 'hkb-category--', 'subcategories' ) . $hkb_current_term_id;
					$hkb_current_term_class = apply_filters( 'hkb_current_term_class', $hkb_current_term_class, $hkb_current_term_id );
				?>
				<div class="hkb-category <?php echo esc_attr( ht_kbarchive_catstyle( $hkb_current_term_id ) ); ?> <?php echo esc_attr( $hkb_current_term_class ); ?>">

					<a class="hkb-category__link" href="<?php echo esc_attr( get_term_link( $subcategory, 'ht_kb_category' ) ); ?>">

						<?php if ( hkb_has_category_custom_icon( $subcategory->term_id ) == 'true' ) : ?>
							<div class="hkb-category__iconwrap"><?php hkb_category_thumb_img( $subcategory->term_id ); ?></div>
						<?php endif; ?>

						<div class="hkb-category__content">

							<h2 class="hkb-category__title">
								<?php echo esc_html( $subcategory->name ); ?>
							</h2>

							<?php if ( ( '' != $subcategory->description ) && get_theme_mod( 'ht_setting__kbarchivecatdesc', '1' ) == true ) : ?>
								<div class="hkb-category__description">
									<?php echo esc_html( $subcategory->description ); ?>
								</div>
							<?php endif; ?>                            

						</div>

					</a>

				</div>
			</li>
		<?php endforeach; ?>
	</ul>
	<!--/.hkb-subcats-->

<?php endif; ?>
