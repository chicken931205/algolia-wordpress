<?php
/**
* Theme updater
*/

//debug feature for updater
//set_site_transient( 'update_plugins', null );

//HeroThemes site url and product name
define( 'HT_KNOWALL_HEROTHEMES_STORE_URL', 'https://www.herothemes.com/?nocache' );
define( 'HT_KNOWALL_PRODUCT_NAME', 'KnowAll WordPress Knowledge Base Theme' ); 

if( !class_exists( 'HT_KnowAll_Updater' ) ) {
	class HT_KnowAll_Updater {

		function __construct(){
			//after setup theme
			add_action( 'after_setup_theme', array( $this, 'ht_knowall_load_updater' ) );
			//cron action hooks
            add_action( 'ht_knowall_license_check', array( $this, 'ht_knowall_license_check' ) );
            //after theme switch setup
            add_action( 'after_switch_theme', array( $this, 'after_switch_theme_setup_cron' ) );
            //admin notices
            add_action( 'admin_notices', array( $this, 'admin_notices' ) );

		}

		/**
		* Load the updater
		*/
		function ht_knowall_load_updater(){
			if(!apply_filters('knowall_disable_theme_updater', false)){
				include('updater/theme-updater.php');	
			}			
		}

        /**
        * Get the current license key and check it
        */
        function ht_knowall_license_check(){
        	global $knowall_theme_updater;
            //don't check the license if theme managed updates (the theme should do it's own if required)
            if(apply_filters('knowall_disable_theme_updater', false)){
                return;
            }
            //activate license to force check and flush status
            $check = $knowall_theme_updater->activate_license();             
        }

        /**
		* After switch theme setup daily license check
		*/
		function after_switch_theme_setup_cron(){
			//add a daily license key check
            if ( ! wp_next_scheduled( 'ht_knowall_license_check' ) ) {
                wp_schedule_event( time(), 'daily', 'ht_knowall_license_check' );
            }
		}

		/**
		* Admin notices
		*/
		function admin_notices(){
			$screen = get_current_screen();
 			if( $screen && 'appearance_page_knowall-license'===$screen->base && apply_filters('knowall_display_license_upgrade_notice_info', true) ):          
			?>
				<div class="notice notice-info">
					<p>
						<?php printf( __( 'If you upgrade or change your license key, please <a href="%s">repeat the KnowAll theme setup</a>, to ensure packaged plugins are correctly configured.', 'knowall' ), admin_url( 'themes.php?page=knowall-welcome' ) ); ?>
					</p>
				</div>
			<?php
			endif;
		}

	}
}

if( class_exists( 'HT_KnowAll_Updater' ) ) {
	$ht_knowall_updater_init = new HT_KnowAll_Updater();
}