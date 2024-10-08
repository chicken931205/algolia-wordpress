<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<!-- congfigure x-frame-options if required -->
		<!-- 
			X-Frame-Options: DENY
			X-Frame-Options: SAMEORIGIN
		-->
	<?php 
		//some break conditions?
		if( false ){
			return;
		}

		$embed_server_enabled = apply_filters('kb_fe_embed_get_server_enabled', false);

		if( !$embed_server_enabled ){
			_e('Heroic Knowledge Base Embed is not enabled for this site', 'ht-knowledge-base');
			die();
		}

		$ht_kb_page_embed_script_src = (HKB_DEBUG_SCRIPTS) ? 'src/ht-kb-page-embed.js' : 'dist/ht-kb-page-embed.min.js';

		//$script_ver = HT_KB_FE_EMBED_MAIN_VERSION;
		//$script_ver = filemtime( plugin_dir_path( HT_KB_FE_EMBED_MAIN_FILE ) . $ht_kb_page_embed_script_src );
		//better to use plugin version number constant?  
		$script_ver = HT_KB_VERSION_NUMBER;

		wp_enqueue_script( 'ht-kb-page-embed-js', plugins_url( $ht_kb_page_embed_script_src, HT_KB_FE_EMBED_MAIN_FILE ), array( 'wp-api', 'wp-i18n' ), $script_ver, true );	

		//localize script, eg server url = this?
		$settings_array = array(
			'embedColor' => apply_filters('kb_fe_embed_get_embed_color', ''),
			'postViewsCountMetaKey' => HT_KB_POST_VIEW_COUNT_KEY,
		);
		wp_localize_script( 'ht-kb-page-embed-js', 'htkbFeEmbedSettings', $settings_array );

		wp_set_script_translations( 'ht-kb-page-embed-js', 'ht-knowledge-base' , plugin_dir_path( HT_KB_MAIN_PLUGIN_FILE ) . 'languages' );

		wp_print_scripts( 'ht-kb-page-embed-js' );

		
		//todo - switch for debug
		//$ht_kb_page_embed_style_src = '';
		$ht_kb_page_embed_style_src = 'dist/ht-kb-page-embed.css';

		//$style_ver = HT_KB_FE_EMBED_MAIN_VERSION;
		//$style_ver = filemtime( plugin_dir_path( HT_KB_FE_EMBED_MAIN_FILE ) . $ht_kb_page_embed_style_src );
		//better to use plugin version number constant?  
		$style_ver = HT_KB_VERSION_NUMBER;

		wp_enqueue_style( 'ht-kb-page_embed-style', plugins_url( $ht_kb_page_embed_style_src, HT_KB_FE_EMBED_MAIN_FILE ), array() , $style_ver );

		wp_print_styles( 'ht-kb-page_embed-style' );
		?>
	</head>
	<body class="hkbfe-body">
		<?php wp_body_open(); ?>
		<?php 
		$embed_server_enabled = apply_filters('kb_fe_embed_get_server_enabled', false);

		if( $embed_server_enabled ):
			?>
				<div id="ht-kb-page-embed-anchor">

					<div class="hkbfe-loader">
						<svg width="38" height="38" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg" stroke="#000">
							<g fill="none" fill-rule="evenodd">
								<g transform="translate(1 1)" stroke-width="2">
									<circle stroke-opacity=".5" cx="18" cy="18" r="18"/>
									<path d="M36 18c0-9.94-8.06-18-18-18">
										<animateTransform
											attributeName="transform"
											type="rotate"
											from="0 18 18"
											to="360 18 18"
											dur="1s"
											repeatCount="indefinite"/>
									</path>
								</g>
							</g>
						</svg>
					</div>

				</div>
				
			<?php
		else :
			?>
				<div id="ht-kb-page-embed-notenabled"> 
					<?php _e('Heroic Knowledge Base Page Embed not enabled on this site, please check settings', 'ht-knowledge-base'); ?>
				</div>
			<?php
		endif;
		?>

		<?php //wp_footer(); ?>
 
	</body>
</html>


