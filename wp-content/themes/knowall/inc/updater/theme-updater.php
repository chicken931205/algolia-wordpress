<?php
/**
 * Theme Updater Config
 */

// Includes the files needed for the theme updater
if ( !class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

global $knowall_theme_updater;
// Loads the updater classes
$knowall_theme_updater = new EDD_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'https://www.herothemes.com/?nocache', // Site where EDD is hosted
		'item_name' => 'KnowAll WordPress Theme', // Name of theme
		'theme_slug' => 'knowall', // Theme slug
		'version' => get_ht_theme_version(), // The current version of this theme
		'author' => 'HeroThemes', // The author of this theme
		'download_id' => '', // Optional, used for generating a license renewal link
		'renew_url' => '' // Optional, allows for a custom license renewal link
	),

	// Strings
	$strings = array(
		'theme-license' => __( 'KnowAll Theme License', 'knowall' ),
		'enter-key' => __( 'Enter your KnowAll theme license key.', 'knowall' ),
		'license-key' => __( 'License Key', 'knowall' ),
		'license-action' => __( 'License Action', 'knowall' ),
		'deactivate-license' => __( 'Deactivate License', 'knowall' ),
		'activate-license' => __( 'Activate License', 'knowall' ),
		'status-unknown' => __( 'License status is unknown.', 'knowall' ),
		'renew' => __( 'Renew?', 'knowall' ),
		'unlimited' => __( 'unlimited', 'knowall' ),
		'license-key-is-active' => __( 'License key is active.', 'knowall' ),
		'expires%s' => __( 'Expires %s.', 'knowall' ),
		'%1$s/%2$-sites' => __( 'You have %1$s / %2$s sites activated.', 'knowall' ),
		'license-key-expired-%s' => __( 'License key expired %s.', 'knowall' ),
		'license-key-expired' => __( 'License key has expired. Please check the license status in your HeroThemes account.', 'knowall' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'knowall' ),
		'license-is-inactive' => __( 'License is inactive. Please check the license status in your HeroThemes account.', 'knowall' ),
		'license-key-is-disabled' => __( 'License key is disabled. Please check the license status in your HeroThemes account.', 'knowall' ),
		'site-is-inactive' => __( 'Site is inactive. You may need to transfer your domain from your HeroThemes account.', 'knowall' ),
		'license-status-unknown' => __( 'License status is unknown. Please check the license status in your HeroThemes account.', 'knowall' ),
		'update-notice' => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'knowall' ),
		'update-available' => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'knowall' )
	)

);