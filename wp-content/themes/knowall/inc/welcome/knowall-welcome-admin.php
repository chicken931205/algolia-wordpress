<?php
/**
 * Welcome setup
 */

//exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


if( !class_exists('KnowAll_Welcome_Setup') ){

	//options stage key
	if(!defined('KNOWALL_OPTION_STAGE_KEY')){
		define('KNOWALL_OPTION_STAGE_KEY', 'knowall_option_stage');
	}


	class KnowAll_Welcome_Setup {

		private $theme_slug = 'knowall';
		private $tgmpa_url = 'themes.php?page=tgmpa-install-plugins';
		private $tgmpa_menu_slug = 'tgmpa-install-plugins';

		//Constructor
		function __construct(){

			add_action( 'admin_menu', array( $this, 'ka_welcome_setup_menu' ) );
			add_action( 'admin_head', array( $this, 'ka_skip_activation' ) );
			add_action( 'admin_head', array( $this, 'ka_hide_gf_integration_warning_on_welcome_admin_page' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'ka_welcome_load_scripts_and_styles' ) );

			add_action( 'wp_ajax_ka_setup_plugins', array( $this, 'ajax_plugins' ) );
			add_action( 'wp_ajax_ka_activate_theme_key', array( $this, 'ajax_activate_theme_key' ) );

			//sample content helpers
			require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'ka-sample-content-helpers.php');

		}

		/**
		* Create menu option
		*/
		function ka_welcome_setup_menu(){
			add_theme_page(
				__('KnowAll Welcome Setup', 'knowall'),
				__('KnowAll Welcome Setup', 'knowall'),
				'manage_options',
				'knowall-welcome',
				array( $this, 'ka_welcome_setup_page' )
			);
		}

		/**
		* Skip activation listener
		*/
		function ka_skip_activation(){
			$skip_activation = array_key_exists('skip-activation', $_POST) ? true : false;
			if(false!=$skip_activation){
				//skip activation prompt for 30 seconds
				set_transient('skip_knowall_theme_activation', true, 30);
			}				
		}

		/**
		* Hide gravity forms integration warning
		*/
		function ka_hide_gf_integration_warning_on_welcome_admin_page(){
			$screen = function_exists('get_current_screen') ? get_current_screen() : false;

			//hide gravity forms integration warning on this page
			if( is_a( $screen, 'WP_Screen' ) && 'appearance_page_knowall-welcome' ===  $screen->base ) {
				add_filter('kb_suggest_hide_gravity_forms_activation_warning', '__return_true');
			}
		}

		/**
		* Welcome page callback
		*/
		function ka_welcome_setup_page(){

				$status = get_option( $this->theme_slug . '_license_key_status', false );

				$requested_stage = array_key_exists('stage', $_REQUEST) ? intval($_REQUEST['stage']) : 0;

				$articles = get_posts('post_type=ht_kb&posts_per_page=10');
	            $article_count = count($articles); 
	            $articles_installed = ($article_count>0) ? true : false;

				$skip_activation = array_key_exists('skip-activation', $_REQUEST) ? true : false;
				if($skip_activation){
					//skip activation prompt for 30 seconds
					set_transient('skip_knowall_theme_activation', true, 30);
				} else {
					$skip_activation = get_transient('skip_knowall_theme_activation');
					$skip_activation = apply_filters('knowall_skip_theme_activation', $skip_activation);
				}

				//use security to ensure requested stage is legit
				if( $requested_stage > 1 ){
					check_admin_referer( 'stage-check', 'stage-check' );
				}

				$stage = 1;
				if('valid'==$status || $skip_activation ){
					$stage = 2;
				}

				$skip_plugins = apply_filters('knowall_skip_plugin_installation',false);
				if(3==$requested_stage || $skip_plugins ){
					$stage = 3;
				}

				if(4==$requested_stage){
					$stage = 4;
				}

				//save the stage
				update_option(KNOWALL_OPTION_STAGE_KEY, $stage);

				?>
				<div class="ka-setupwizard">

					<?php
						$this->ka_theme_intro_header($stage); ?>
						<?php if( $articles_installed && $stage < 4 ) : ?>
							<div class="ka-setupwizard__upgradenotice">
								<h2 class="ka-setupwizard__title"><?php esc_html_e('Upgrading KnowAll?', 'knowall'); ?></h2>
								<p><?php esc_html_e('It looks like you have previously installed KnowAll, if upgrading please complete these steps to ensure the theme license is active and the packaged plugins are up-to-date.', 'knowall' ); ?></p>
							</div>
						<?php endif; ?>
						<div class="ka-setupwizard__content">
						<?php switch ($stage) {
							case 1:
								$this->ka_theme_license_tab();
								break;
							case 2:
								$this->ka_theme_install_reqd_plugins();
								break;
							case 3:
								$this->ka_theme_install_sample_content();
								break;
							case 4:
								$this->ka_theme_setup_complete();
								break;						
							default:
								//default action
								break;
						}
					?></div>

				</div><!-- /ka-setupwizard -->

				<?php
		}

		/**
		* Progress bar
		*/
		function ka_theme_intro_header($current_stage){
			//valid stages
			$stages = array(1,2,3,4);
			?>
			<div class="ka-progressbar">
				<ul>
				<?php foreach ($stages as $key => $stage ): ?>
					<?php $active_class = ($stage==$current_stage) ? ' active ' : ''; ?>
					<?php $complete_class = ($stage<$current_stage) ? ' complete ' : ''; ?>
					<?php $justcomplete_class = ($stage == ($current_stage -1 )) ? ' justcomplete ' : ''; ?>
					<li class="<?php echo $complete_class . $justcomplete_class . $active_class; ?>">
						<?php echo $stage; ?>						
					</li>
				<?php endforeach; ?>
				</ul>
			</div>
			<?php
		}

		/**
		* Theme license tab
		*/
		function ka_theme_license_tab(){
			global $knowall_theme_updater;
			$license = trim( get_option( $this->theme_slug . '_license_key' ) );
			$status = get_option( $this->theme_slug . '_license_key_status', false );

			// Checks license status to display under license key
			if ( ! $license ) {
				$message    = __('Please enter license key', 'knowall');
			} else {
				$message    = __('There was a problem verifying your license, please re-check', 'knowall');

				if ( ! get_transient( $this->theme_slug . '_license_message', false ) ) {
					set_transient( $this->theme_slug . '_license_message', $knowall_theme_updater->check_license(), ( 60 * 60 * 24 ) );
				}
				$message = get_transient( $this->theme_slug . '_license_message' );
				
			}
			//recheck the status after validation
			$status = get_option( $this->theme_slug . '_license_key_status', false);

			?>

				<h2 class="ka-setupwizard__title"><?php esc_html_e('Activate KnowAll', 'knowall'); ?></h2>
				<p><?php esc_html_e('Activate your new theme to unlock automatic updates and enable support for this site.', 'knowall'); ?></p>

				
				<form method="post" action="options.php">

					<?php settings_fields( $this->theme_slug . '-license' ); ?>

					<div class="ka-licenseinput">

						<input id="<?php echo $this->theme_slug; ?>_license_key" name="<?php echo $this->theme_slug; ?>_license_key" type="text" class="ka-licenseinput__input" value="<?php echo esc_attr( $license ); ?>" placeholder="********************************" />
						
						<div class="ka-license-status">
							<span data-submit-message="<?php esc_html_e('Please wait, validating and activating key...', 'knowall'); ?>"></span>
						</div>
						

					</div>
					
					
					<p class="ka-u-notice"><span><?php esc_html_e('Note:', 'knowall'); ?></span><?php esc_html_e('You can find your license key in your HeroThemes account area or your purchase receipt email.', 'knowall'); ?></p>


					<?php $button_text = ('valid' == $status) ? __('Continue', 'knowall') : __('Activate', 'knowall'); ?>

					<?php $stage_check = wp_create_nonce( 'stage-check' ); ?>

					<p class="ka-setupwizard__actions step">
						<a href="?page=knowall-welcome&stage=2&stage-check=<?php echo $stage_check; ?>"
						   class="button-primary button button-large button-next"
						   data-nonce="<?php echo wp_create_nonce($this->theme_slug . '_nonce'); ?>"
						   data-callback="activateLicense"><?php echo $button_text; ?></a>
						<a href="?page=knowall-welcome&stage=2&skip-activation=1&stage-check=<?php echo $stage_check; ?>"
						   class="button button-large button-next"><?php esc_html_e( 'Skip this step', 'knowall' ); ?></a>
						<?php wp_nonce_field( 'ka-theme-setup' ); ?>
					</p>
					
				</form>
			<?php
		}

		/**
		* Email alerts signup tab
		* not used in knowall
		*/
		function ka_theme_email_alerts_tab(){
			$current_user = wp_get_current_user();
			?>
				<h2 class="ka-setupwizard__title"><?php esc_html_e('Sign up for email notifications', 'knowall'); ?></h2>
                <p><?php printf(__('Visit <a href="%s" target="_blank">HeroThemes</a>, or signup with the form below for more tips, guides and addons to harness the power of your new Knowledge Base', 'knowall') , 'http://herothemes.com'); ?></p>
                <!-- Sign up form -->
                <!-- Begin MailChimp Signup Form -->
                <link href="//cdn-images.mailchimp.com/embedcode/classic-081711.css" rel="stylesheet" type="text/css" >
                <style type="text/css">
                    #mc_embed_signup{clear:left; font:14px Helvetica,Arial,sans-serif; max-width: 600px; }
                    #mc_embed_signup .indicates-required, #mc_embed_signup .mc-field-group .asterisk {display: none;}
                    /* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
                       We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
                </style>
                <div id="mc_embed_signup">
                <form action="//herothemes.us10.list-manage.com/subscribe/post?u=958c07d7ba2f4b21594564929&amp;id=db684b9928" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                    <div id="mc_embed_signup_scroll">
                <div class="indicates-required"><span class="asterisk">*</span> <?php esc_html_e('indicates required', 'knowall'); ?></div>
                <div class="mc-field-group">
                    <label for="mce-EMAIL"><?php esc_html_e('Email Address', 'knowall'); ?>  <span class="asterisk">*</span>
                </label>
                    <input type="email" value="<?php echo $current_user->user_email; ?>" name="EMAIL" class="required email" id="mce-EMAIL">
                    <input type="hidden" value="<?php echo $current_user->user_firstname; ?>" name="FNAME" class="" id="mce-FNAME">
                    <input type="hidden" value="<?php echo $current_user->user_lastname; ?>" name="LNAME" class="" id="mce-LNAME">
                    <input type="hidden" id="group_4096" name="group[925][4096]" value="1" /><!-- signup location = HKB Dashboard (group 4096) -->
                    <input type="hidden" name="SIGNUP" id="SIGNUP" value="ht-knowall-dash" />
                </div>
                    <div id="mce-responses" class="clear">
                        <div class="response" id="mce-error-response" style="display:none"></div>
                        <div class="response" id="mce-success-response" style="display:none"></div>
                    </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                    <div style="position: absolute; left: -5000px;"><input type="text" name="b_958c07d7ba2f4b21594564929_db684b9928" tabindex="-1" value=""></div>
                    <input type="submit" value="<?php esc_html_e('Subscribe', 'knowall'); ?>" name="subscribe" id="mc-embedded-subscribe" class="button">
                    <?php $stage_check = wp_create_nonce( 'stage-check' ); ?>
					<a href="?page=knowall-welcome&stage=3&stage-check=<?php echo $stage_check; ?>"
					   class="button button-large button-next"><?php esc_html_e( 'Skip this step', 'knowall' ); ?></a>
					<?php wp_nonce_field( 'ka-theme-setup' ); ?>					
                    </div>
                </form>
                </div>
                <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
                <!--End mc_embed_signup-->
                </script>

			<?php
		}

		function sort_plugins($a, $b){
			if ($a['order'] == $b['order']) {
				return 0;
			}
				return ($a['order'] < $b['order']) ? -1 : 1;
		}

		/**
		* Install required plugins tab
		*/
		function ka_theme_install_reqd_plugins(){
			$all_plugins_ready = false;
			?>

				<h2 class="ka-setupwizard__title"><?php esc_html_e('Install Required Plugins', 'knowall'); ?></h2>
				<form method="post">

					<?php
					
					$tgm_plugins = $this->get_all_tgm_config_plugins();

					uasort($tgm_plugins->plugins, array($this, 'sort_plugins'));

					//echo '<pre>';
					//print_r($tgm_plugins->plugins);
					//echo '</pre>';


					if ( true /*todo - logic for detecting required plugins active?*/ ) {
						?>
						<p><?php esc_html_e( 'Your website needs a few essential plugins. The following plugins will be installed or updated:', 'knowall' ); ?></p>
						<ul class="theme-install-setup-plugins">
							<?php foreach ( $tgm_plugins->plugins as $key => $plugin ) : ?>

								<?php 
									$slug = $plugin['slug'];
									$plugin_already_installed = $tgm_plugins->is_plugin_installed($slug) && false === $tgm_plugins->does_plugin_have_update($slug) && !$tgm_plugins->can_plugin_activate( $slug );
									$plugin_required = ($plugin['required']) ? true : false;
									$disable_selection = ( $plugin_already_installed || $plugin['required'] ) ? 'disabled' : '';
								
								?>
								<li class="ka-plugin-li" data-slug="<?php echo esc_attr( $slug ); ?>">
									<span class="ka-plugin-item">
										<input type="checkbox" name="knowall-plugin-<?php echo esc_attr( $slug ); ?>" data-slug="<?php echo esc_attr( $slug ); ?>" checked <?php echo $disable_selection; ?> />
										<label for="knowall-plugin-<?php echo esc_attr( $slug ); ?>">
											<?php echo esc_html( $plugin['name'] . ' - ' ); ?>
											<?php
											if ( $plugin_already_installed ) {
												$info = esc_html('Already Installed and Active', 'knowall');
											}
											if ( !$tgm_plugins->is_plugin_installed($slug) ) {
												$info = esc_html('Installation', 'knowall');
												if($plugin_required){
													$info .= ' ' . esc_html('required', 'knowall');
												} else {
													$info .= ' ' . esc_html('optional', 'knowall');
												}
											}
											if ( $tgm_plugins->is_plugin_installed($slug) && false !== $tgm_plugins->does_plugin_have_update($slug)  ) {
												$info = esc_html('Update', 'knowall');
												if($plugin_required){
													$info .= ' ' . esc_html('required', 'knowall');
												} else {
													$info .= ' ' . esc_html('optional', 'knowall');
												}
											}
											if ( $tgm_plugins->can_plugin_activate( $slug ) ) {
												$info = esc_html('Activation', 'knowall');
												if($plugin_required){
													$info .= ' ' . esc_html('required', 'knowall');
												} else {
													$info .= ' ' . esc_html('optional', 'knowall');
												}
											}
											echo $info;
											?>
										</label>
										<span class="ka-plugin-item-info"></span>
										<div class="spinner"></div>
									</span>
								</li>
							<?php endforeach; ?>
						</ul>
						<?php
					} else {
						$all_plugins_ready = true;
						echo '<p><strong>' . esc_html__( 'Good news! All plugins are already installed and up to date. Please continue.', 'knowall' ) . '</strong></p>';
					} ?>

					<?php $stage_check = wp_create_nonce( 'stage-check' ); ?>



					<p class="ka-u-notice"><span><?php esc_html_e('Note:', 'knowall'); ?></span><?php esc_html_e('You can add and remove plugins later on from within WordPress.', 'knowall'); ?></p>

					<p class="ka-u-notice"><span><?php esc_html_e('New:', 'knowall'); ?></span><?php esc_html_e('Heroic Blocks is a new plugin included in this version of KnowAll, you can use it to create messages, accordions, tabs and toggles right from the editor, find it in the Heroic Blocks section.', 'knowall'); ?></p>

					<p class="ka-setupwizard__actions step">
						<a href="?page=knowall-welcome&stage=3&stage-check=<?php echo $stage_check; ?>"
						   class="button-primary button button-large button-next"
						   data-callback="installPlugins"><?php esc_html_e( 'Continue', 'knowall' ); ?></a>
						<?php wp_nonce_field( 'ka-theme-setup' ); ?>
					</p>
					
				</form>

			<?php
		}

		/**
		* Install sample content tab
		*/
		function ka_theme_install_sample_content(){
			?>

				<h2 class="ka-setupwizard__title"><?php esc_html_e('Install Sample Content', 'knowall'); ?></h2>

				<?php	
					//only display if no articles
					$articles = get_posts('post_type=ht_kb&posts_per_page=10');
		            $article_count = count($articles); 
		            $checkstate = ($article_count>0) ? '' : 'checked';
		            $enable_posts_checkstate = ('enable' == get_option( 'knowall_blog_support' ) || '' == get_option( 'knowall_blog_support' )) ? 'checked' : '';
	            ?>

	            <?php if($article_count<=0): ?>


					<p><?php esc_html_e('It\'s time to insert some default content for your new WordPress website. Choose what you would like inserted below and click Install Marked.', 'knowall'); ?></p>

				<?php else: ?>

					<p><?php esc_html_e('It looks like you already have content installed, you can check the items below to add additional demo data or re-install any missing items.', 'knowall'); ?></p>

				<?php endif; ?>

				<form method="post" action="">
					<ul class="ka-content-items theme-install-setup-content">
						<li class="ka-content-item">
							<input type="checkbox" name="knowall-sample-pages" data-content="pages" <?php echo $checkstate; ?> /><label for="knowall-sample-pages"><?php esc_html_e('Pages', 'knowall'); ?></label>
							<span class="ka-content-item-info-span"></span>
							<div class="spinner"></div>
						</li>
						<li class="ka-content-item">
							<input type="checkbox" name="knowall-sample-articles" data-content="articles" <?php echo $checkstate; ?> /><label for="knowall-sample-articles"><?php esc_html_e('Articles', 'knowall'); ?></label>
							<span class="ka-content-item-info-span"></span>
							<div class="spinner"></div>
						</li>
						<li class="ka-content-item">
							<input type="checkbox" name="knowall-sample-menus" data-content="menus" <?php echo $checkstate; ?> /><label for="knowall-sample-menus"><?php esc_html_e('Menus', 'knowall'); ?></label>
							<span class="ka-content-item-info-span"></span>
							<div class="spinner"></div>
						</li>
						<li class="ka-content-item">
							<input type="checkbox" name="knowall-sample-sidebar-widgets" data-content="widgets" <?php echo $checkstate; ?> /><label for="knowall-sample-sidebar-widgets"><?php esc_html_e('Sidebars and Widgets', 'knowall'); ?></label>
							<span class="ka-content-item-info-span"></span>
							<div class="spinner"></div>
						</li>
						<li class="ka-content-item">
							<input type="checkbox" name="knowall-sample-settings" data-content="settings" <?php echo $checkstate; ?> /><label for="knowall-sample-settings"><?php esc_html_e('Settings', 'knowall'); ?></label>
							<span class="ka-content-item-info-span"></span>
							<div class="spinner"></div>
						</li>
						<?php if( class_exists( 'GFForms' ) ): ?>
							<li class="ka-content-item">
								<input type="checkbox" name="knowall-sample-gravityforms-templates" data-content="gravityforms-templates" <?php echo $checkstate; ?> /><label for="knowall-sample-gravityforms-templates"><?php esc_html_e('Gravity Forms Templates', 'knowall'); ?></label>
								<span class="ka-content-item-info-span"></span>
								<div class="spinner"></div>
							</li>
						<?php else: ?>
							<li class="ka-content-item">
								<input type="checkbox" name="knowall-sample-gravityforms-templates" data-content="gravityforms-templates" disabled /><label for="knowall-sample-gravityforms-templates"><?php esc_html_e('Gravity Forms Templates', 'knowall'); ?></label>
								<span class="ka-content-item-info-span"></span>
								<br/>
								<?php printf( __( '(Optional) Gravity Forms required to import Gravity Forms demo templates. <a href="%s" target="_blank">Read More here</a>.', 'knowall' ), HT_GF_INFO_URL ); ?>
								<div class="spinner"></div>
							</li>
						<?php endif; ?>
					</ul><!-- /ka-content-items -->

					<?php if($article_count<=0): ?>

						<p class="ka-u-notice"><span><?php esc_html_e('Note:', 'knowall'); ?></span><?php esc_html_e('It is recommended to leave everything selected. Once inserted, this content can be managed from the WordPress admin dashboard.', 'knowall'); ?></p>

					<?php else: ?>

						<p class="ka-u-notice"><span><?php esc_html_e('Note:', 'knowall'); ?></span><?php esc_html_e('The checked items will be installed. You can skip this step if you are upgrading KnowAll.', 'knowall'); ?></p>

					<?php endif; ?>
				
	            	<input type="hidden" name="stage" value="5" />
	            	<?php $stage_check = wp_create_nonce( 'stage-check' ); ?>

	            	<p class="ka-setupwizard__actions step">
						<a href="?page=knowall-welcome&stage=4&stage-check=<?php echo $stage_check; ?>"
						   class="button-primary button button-large button-next"
						   data-callback="installContent"><?php esc_html_e( 'Install Marked', 'knowall' ); ?></a>
						<a href="?page=knowall-welcome&stage=4&stage-check=<?php echo $stage_check; ?>"
						   class="button button-large button-next"><?php esc_html_e( 'Skip this step', 'knowall' ); ?></a>
						<?php wp_nonce_field( 'ka-theme-setup' ); ?>
					</p>
	            </form>

			<?php
		}

		/**
		* Theme setup complete tab
		*/
		function ka_theme_setup_complete(){
			?>

				<h2 class="ka-setupwizard__title"><?php esc_html_e('You\'re All Set!', 'knowall'); ?></h2>

				<p><?php esc_html_e('KnowAll has been successfully setup and your website is ready!', 'knowall'); ?></p>

				<a class="ka-viewsite" href="<?php echo esc_url( home_url( '/' ) ); ?>" target"_blank">
					<?php esc_html_e('View Your Site', 'knowall'); ?>
				</a>

				<div class="ka-setup-nextsteps">
					<h2><?php esc_html_e('What Next?', 'knowall'); ?></h2>

					<ul>
						<li><a href="<?php echo admin_url( 'post-new.php?post_type=ht_kb' ); ?>" target="_blank"><?php esc_html_e('Add or Edit your first article', 'knowall'); ?></a></li>
						<li><a href="<?php echo admin_url( 'customize.php' ); ?>" target="_blank"><?php esc_html_e('Customize your site with your logo and colours', 'knowall'); ?></a></li>
						<li><a href="<?php echo HT_KA_SUPPORT_URL; ?>" target="_blank"><?php esc_html_e('Check the KnowAll documentation to get the most from your theme', 'knowall'); ?></a></li>
					</ul>

				</div>

			<?php
		}

		/**
		* Get TGM config plugins
		*/
		function get_tgm_config_plugins() {
			$instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
			$plugins  = array(
				'all'      => array(), // Meaning: all plugins which still have open actions.
				'install'  => array(),
				'update'   => array(),
				'activate' => array(),
			);

			foreach ( $instance->plugins as $slug => $plugin ) {
				if ( $instance->is_plugin_active( $slug ) && false === $instance->does_plugin_have_update( $slug ) ) {
					// No need to display plugins if they are installed, up-to-date and active.
					continue;
				} else {
					$plugins['all'][ $slug ] = $plugin;

					if ( ! $instance->is_plugin_installed( $slug ) ) {
						$plugins['install'][ $slug ] = $plugin;
					} else {
						if ( false !== $instance->does_plugin_have_update( $slug ) ) {
							$plugins['update'][ $slug ] = $plugin;
						}

						if ( $instance->can_plugin_activate( $slug ) ) {
							$plugins['activate'][ $slug ] = $plugin;
						}
					}
				}
			}

			return $plugins;
		}

		/**
		* Get ALL TGM config plugins
		*/
		function get_all_tgm_config_plugins() {
			$tgm_plugins = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
			
			return $tgm_plugins;
		}

		/**
		* ajax handler for theme key activation
		*/
		function ajax_activate_theme_key() {
			if ( ! check_ajax_referer( 'ka_setup_setup_security', 'wpnonce' ) ) {
				wp_send_json_error( array( 'error' => 1, 'message' => esc_html__( 'Failed Security', 'knowall' ) ) );
			}

			$json = array();

			//htmlspecialchars is a replacement for FILTER_SANITIZE_STRING
			$key = htmlspecialchars( filter_input( INPUT_POST, 'key' ), ENT_IGNORE );
			//$key = filter_input( INPUT_POST, 'key' );

			$attempt = filter_input( INPUT_POST, 'attempt', FILTER_SANITIZE_NUMBER_INT );

			update_option( $this->theme_slug . '_license_key', $key );

			$status = get_option( $this->theme_slug . '_license_key_status', false );

			$retry = false;

			//response license_valid
			$license_valid = false;

			if('valid'==$status){
				$message = esc_html__('License successfully activated. Redirecting...', 'knowall');
				$license_valid = true;
			} else {
				//workaround for when the license is valid, but has not activated correctly, retry upto three times
				if($attempt < 2){
					$message = esc_html__('Validating license with HeroThemes', 'knowall') . sprintf(' (%s)', $attempt);
					$retry = true;
				} else {
					$message = esc_html__('There is a problem with the license key.', 'knowall');	
					$message .= ' ';	
					$message .= esc_html__('Check your license status, add or remove sites from your HeroThemes.com account.', 'knowall');	
				}				
			}

			//send response
			wp_send_json( array( 'done' => 1, 'valid' => $license_valid, 'message' => $message, 'retry' => $retry, 'attempt' => $attempt+1 ) );
			//needed on ajax calls to exit cleanly
			exit;
		}

		/**
		* ajax handler for plugin installation
		*/
		function ajax_plugins() {

			if ( ! check_ajax_referer( 'ka_setup_setup_security', 'wpnonce' )  ) {
				wp_send_json_error( array( 'error' => 1, 'message' => esc_html__( 'Failed Security', 'knowall' ) ) );
			}

			if ( empty( $_POST['slug'] ) ) {
				wp_send_json_error( array( 'error' => 1, 'message' => esc_html__( 'Missing plugin slug', 'knowall' ) ) );
			}

			$json = array();
			// send back some json we use to hit up TGM
			$plugins = $this->get_tgm_config_plugins();
			// what are we doing with this plugin?
			foreach ( $plugins['activate'] as $slug => $plugin ) {
				if ( $_POST['slug'] == $slug ) {
					$json = array(
						'url'           => admin_url( $this->tgmpa_url ),
						'plugin'        => array( $slug ),
						'tgmpa-page'    => $this->tgmpa_menu_slug,
						'plugin_status' => 'all',
						'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
						'action'        => 'tgmpa-bulk-activate',
						'action2'       => - 1,
						'message'       => esc_html__( 'Activating Plugin', 'knowall' ),
					);
					break;
				}
			}
			foreach ( $plugins['update'] as $slug => $plugin ) {
				if ( $_POST['slug'] == $slug ) {
					$json = array(
						'url'           => admin_url( $this->tgmpa_url ),
						'plugin'        => array( $slug ),
						'tgmpa-page'    => $this->tgmpa_menu_slug,
						'plugin_status' => 'all',
						'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
						'action'        => 'tgmpa-bulk-update',
						'action2'       => - 1,
						'message'       => esc_html__( 'Updating Plugin', 'knowall' ),
					);
					break;
				}
			}
			foreach ( $plugins['install'] as $slug => $plugin ) {
				if ( $_POST['slug'] == $slug ) {
					$json = array(
						'url'           => admin_url( $this->tgmpa_url ),
						'plugin'        => array( $slug ),
						'tgmpa-page'    => $this->tgmpa_menu_slug,
						'plugin_status' => 'all',
						'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
						'action'        => 'tgmpa-bulk-install',
						'action2'       => - 1,
						'message'       => esc_html__( 'Installing Plugin', 'knowall' ),
					);
					break;
				}
			}

			if ( !empty($json) ) {
				$json['hash'] = md5( serialize( $json ) ); // used for checking if duplicates happen, move to next plugin
				wp_send_json( $json );
			} else {
				wp_send_json( array( 'done' => 1, 'message' => esc_html__( 'Success', 'knowall' ) ) );
			}
			exit;

		}

		/**
		* Load scripts and styles
		*/
		function ka_welcome_load_scripts_and_styles(){
			$screen = get_current_screen();
			if(is_a($screen, 'WP_Screen') && 'appearance_page_knowall-welcome' == $screen->base ){
				//enqueue style
				wp_enqueue_style( 'theme-setup-css', get_template_directory_uri() . '/inc/welcome/css/theme-setup-admin-style.css' );

				//enqueue script
				wp_enqueue_script( 'jquery-blockui', get_template_directory_uri(). '/inc/welcome/js/jquery.blockUI.js', array( 'jquery' ), '2.70', true );
			
				$theme_welcome_js_file_src = (KNOWALL_DEBUG_SCRIPTS) ?  get_template_directory_uri() . '/inc/welcome/js/theme-setup-js.js' :  get_template_directory_uri() . '/inc/welcome/js/theme-setup-js.min.js';
				wp_enqueue_script( 'theme-setup-js', $theme_welcome_js_file_src, array(
					'jquery',
					'jquery-blockui',
				), get_ht_theme_version() );
				wp_localize_script( 'theme-setup-js', 'ka_theme_setup', array(
					'tgm_plugin_nonce' => array(
						'update'  => wp_create_nonce( 'tgmpa-update' ),
						'install' => wp_create_nonce( 'tgmpa-install' ),
					),
					'theme_slug'	   => $this->theme_slug,
					'tgm_bulk_url'     => admin_url( $this->tgmpa_url ),
					'ajaxurl'          => admin_url( 'admin-ajax.php' ),
					'wpnonce'          => wp_create_nonce( 'ka_setup_setup_security' ),
					'verify_text'      => esc_html__( '...verifying', 'knowall' ),
				) );

			}
			
		}

	}

}

if( class_exists('KnowAll_Welcome_Setup') ){
	$knowall_welcome_setup_init = new KnowAll_Welcome_Setup();
}