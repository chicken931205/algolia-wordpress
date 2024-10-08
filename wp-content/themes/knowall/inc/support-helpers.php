<?php
/**
* Support Helper Files
*/

//exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


if( ! class_exists( 'HT_KnowAll_Support_Helpers' ) ){

	class HT_KnowAll_Support_Helpers{

		//constructor 
		function __construct(){
			//activation reminder
			add_action( 'admin_notices', array( $this, 'ht_knowall_activation_reminder' ), 10 );

			//this function has been replaced by the ht-kb-analytics-pro plugin
			//add_action( 'ht_analytics_functions', array( $this,  'ht_knowall_check_analytics_functions_access' ), 30 );

			add_action( 'update_option_knowall_license_key', array( $this, 'update_knowall_license_key' ), 10, 3 );
			add_action( 'add_option_knowall_license_key', array( $this, 'add_knowall_license_key' ), 10, 2 );

			//enable kb embed (help assistant) settings section if theme license key is valid
			add_filter( 'ht_kb_display_embed_settings_section', array( $this, 'ht_knowall_license_key_status_valid' ), 20 );
			//enable kb email reports section if theme license key is valid
			add_filter( 'ht_kb_display_report_settings_section', array( $this, 'ht_knowall_license_key_status_valid' ), 20 );
			//add filter to override license status for standalone kb
			add_filter( 'ht_kb_settings_is_license_status_valid', array( $this, 'ht_knowall_license_key_status_valid' ), 20 );

			//filter ht_kb_site_health_license_status
			add_filter( 'ht_kb_site_health_license_status', array( $this, 'ht_knowall_theme_managed_hkb_license_status' ), 10 );
		}

		/**
		 * Returns true if knowall license key status is valid
		 */
		function ht_knowall_license_key_status_valid( $default = false ){
			$theme_license_status = get_option( 'knowall_license_key_status', false );
			$is_license_key_valid = 'valid' == $theme_license_status;
			return apply_filters( 'ht_knowall_license_key_status_valid', $is_license_key_valid );
		}

		/**
		 * Display theme managed updates info 
		 */
		function ht_knowall_theme_managed_hkb_license_status( $text = '' ){
			$ht_knowall_license_key_status_valid = $this->ht_knowall_license_key_status_valid();
			$text = sprintf( __( 'Packaged Heroic KB plugin managed by current theme. KnowAll %s', 'knowall' ), get_ht_theme_version() );
			if( $ht_knowall_license_key_status_valid ){
				$text .= ' ' . __('(theme license key is active)', 'knowall');
			} else {
				$text .= ' ' . __('(theme license key is NOT active)', 'knowall');
			}
			return $text;
		}

		/**
		* Activation reminder
		*/
		function ht_knowall_activation_reminder(){
			$screen = get_current_screen();
			$theme_license_status = get_option( 'knowall_license_key_status', false );
			$hide_knowall_activation_reminder = apply_filters( 'hide_knowall_activation_reminder', false );
			if( is_a($screen, 'WP_Screen') && 'appearance_page_knowall-license' != $screen->id && 'appearance_page_knowall-welcome' != $screen->id && 'valid' != $theme_license_status && !$hide_knowall_activation_reminder ):
				?>
				<div class="notice notice-info is-dismissible">
					<p>
						<?php esc_html_e( 'Your KnowAll key is not activated, you could be missing important updates and support.', 'knowall' ); ?> 
						<a href="<?php echo esc_url( admin_url( 'themes.php?page=knowall-license' ) ); ?>"><?php esc_html_e( 'Activate Now', 'knowall' ); ?></a>		        	
					</p>
				</div>
				<?php
			endif;
		}

		/**
		* access check for analytics
		* @deprecated - use ht-kb-analytics-pro plugin instead
		*/
		function ht_knowall_check_analytics_functions_access($allow){
			$knowall_license_price_id = trim( get_option( 'knowall_license_price_id', '' ) );

			if( empty( $knowall_license_price_id ) ){
				//no knowall price id, no access
				$allow = false;
			} else {
				//allow_all
				$allow = true;

				//explicit disallows
				$explicit_knowall_price_id_disallows_analytics = array('6');
				$explicit_knowall_price_id_disallows_analytics = apply_filters( 'explicit_knowall_price_id_disallows_analytics', $explicit_knowall_price_id_disallows_analytics );
				if( in_array( $knowall_license_price_id, $explicit_knowall_price_id_disallows_analytics ) ){
					$allow = false;
				}

				//explicit allows
				$explicit_knowall_price_id_allows_analytics = array();
				$explicit_knowall_price_id_allows_analytics = apply_filters( 'explicit_knowall_price_id_allows_analytics', $explicit_knowall_price_id_allows_analytics );
				if( in_array( $knowall_license_price_id, $explicit_knowall_price_id_allows_analytics ) ){
					$allow = true;
				}


			}

			return $allow;

		}

		/**
		* add_option_knowall_license_key
		* do_action( "add_option_{$option}", $option, $value )
		*/
		function add_knowall_license_key( $option, $value ){
			$this->update_knowall_license_key( '', $value, $option );
		}

		/**
		* update_option_knowall_license_key
		* do_action( "update_option_{$option}", $old_value, $value, $option );
		*/
		function update_knowall_license_key( $old_value, $new_value, $option ){
			if( $old_value != $new_value ){
				//do something
			}
		}


		/** @todo - add knowall_license_price_switch detection - display admin_notice saying upgrade detected */


		
	}

}

if( class_exists( 'HT_KnowAll_Support_Helpers' ) ){
	$ht_knowall_support_helpers = new HT_KnowAll_Support_Helpers();
}