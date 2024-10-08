<?php
/*
*
* Attachments display
*
*/
?>

<?php $attachments = hkb_get_attachments(); ?>
<?php $pre_expanded_class = get_theme_mod( 'ht_setting__articleexpandedattachments', '0' ) == '1' ? 'hkb-article-attachments--active hkb-article-attachments--preexpanded' : ''; ?>

<?php if ( ! empty( $attachments ) && ! post_password_required( $post ) ) : ?>

	<!-- .hkb-article-attachments -->
	<section class="hkb-article-attachments <?php echo esc_attr( $pre_expanded_class ); ?>">
		<h3 class="hkb-article-attachments__title"><?php esc_html_e( 'Article Attachments', 'knowall' ); ?></h3>
		<div class="hkb-article-attachments__content">
			<ul class="hkb-article-attachments__list">
				<?php foreach ( $attachments as $attachment_id => $attachment ) : ?>
					<?php
						$attachment_post         = get_post( $attachment_id );
						$default_attachment_name = __( 'Attachment', 'knowall' );
						$attachment_name         = ! empty( $attachment_post ) ? $attachment_post->post_title : $default_attachment_name;
						$attachment_url          = wp_get_attachment_url( $attachment_id );
						$attachment_filetype     = wp_check_filetype( $attachment_url );
						$attachment_filesize     = filesize( get_attached_file( $attachment_id ) );
						$attachment_filesize     = size_format( $attachment_filesize, 0 );
						$download                = apply_filters( 'hkb_attachment_download', 'download', $post, $attachment );
					?>
					<li class="hkb-article-attachment__item">
						<a class="hkb-article-attachment__link" href="<?php echo esc_url( $attachment_url ); ?>" <?php echo esc_html( $download ); ?>>
							<div class="hkb-article-attachment__img">
								<svg class="hkb-article-attachment__icon" width="40" height="40" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1152 512v-472q22 14 36 28l408 408q14 14 28 36h-472zm-128 32q0 40 28 68t68 28h544v1056q0 40-28 68t-68 28h-1344q-40 0-68-28t-28-68v-1600q0-40 28-68t68-28h800v544z"/></svg>
								<span>.<?php echo esc_html( $attachment_filetype['ext'] ); ?></span>
							</div>      
							<div class="hkb-article-attachment__content">  
								<span class="hkb-article-attachment__title">        
									<?php echo esc_html( $attachment_name ); ?>
								</span>
								<span class="hkb-article-attachment__size">
									<?php echo esc_html( $attachment_filesize ); ?>
								</span>
							</div>
						</a>
					</li>

				<?php endforeach; ?>
			</ul>
		</div>

	</section>
	<!-- /.hkb-article-attachments -->

<?php endif; ?>
