<?php
/**
* Applys filters to settings so the theme can control these
*/

//exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


if( ! class_exists( 'HT_KnowAll_Setting_Filters' ) ){

	class HT_KnowAll_Setting_Filters{

		//constructor 
		function __construct(){
			
			//remove settings sections and/or settings from knowledge base settings page sections
			//add_filter( 'hkb_add_archive_settings_section', '__return_false' );
			add_filter( 'hkb_archive_display_kb_archive_page_header_text_option_render', '__return_false' );
			add_filter( 'hkb_archive_archive_columns_option_render', '__return_false' );
			add_filter( 'hkb_archive_display_article_count_option_render', '__return_false' );
			add_filter( 'hkb_archive_num_articles_home_option_render', '__return_false' );
			add_filter( 'hkb_archive_hide_empty_cats_option_render', '__return_false' );
			add_filter( 'hkb_archive_hide_uncat_articles_option_render', '__return_false' );
			add_filter( 'hkb_add_article_settings_section', '__return_false' );
			add_filter( 'hkb_add_sidebars_settings_section', '__return_false' );
			add_filter( 'hkb_add_search_settings_section', '__return_false' );
			add_filter( 'hkb_add_customstyles_settings_section', '__return_false' );

			//override setting output text
			add_filter( 'hkb_archive_display_kb_archive_page_header_text_option_render_false', array( $this, 'knowall_settings_controlled_from_customizer' ) );
			add_filter( 'hkb_archive_archive_columns_option_render_false', array( $this, 'knowall_settings_controlled_from_customizer' ) );
			add_filter( 'hkb_archive_display_article_count_option_render_false', array( $this, 'knowall_settings_not_available' ) );
			add_filter( 'hkb_archive_num_articles_home_option_render_false', array( $this, 'knowall_settings_controlled_from_customizer' ) );
			add_filter( 'hkb_archive_hide_empty_cats_option_render_false', array( $this, 'knowall_settings_controlled_from_customizer' ) );
			add_filter( 'hkb_archive_hide_uncat_articles_option_render_false', array( $this, 'knowall_settings_not_available' ) );

		}

		function knowall_settings_controlled_from_customizer( $text ){
			return esc_attr__( 'This setting can be controlled from Appearance > Customize > Theme', 'knowall' );
		}

		function knowall_settings_not_available( $text ){
			return esc_attr__( 'This setting is not available', 'knowall' );
		}

	}

}

if( class_exists( 'HT_KnowAll_Setting_Filters' ) ){
	$ht_knowall_setting_filters = new HT_KnowAll_Setting_Filters();
}