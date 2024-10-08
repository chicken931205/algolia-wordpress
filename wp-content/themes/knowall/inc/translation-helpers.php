<?php
/**
* Translation Helper Files
*/


/**
* Source:
* 	apply_filters( 'hkb_breadcrumbs_blog_home_label', __('Home', 'ht-knowledge-base') ), 
	apply_filters( 'hkb_breadcrumbs_blog_home_title', __('Home', 'ht-knowledge-base') ), 
	apply_filters( 'hkb_breadcrumbs_kb_home_label', __('Knowledge Base', 'ht-knowledge-base') ), 
	apply_filters( 'hkb_breadcrumbs_kb_home_title', __('Knowledge Base', 'ht-knowledge-base') ), 
	apply_filters( 'hkb_breadcrumbs_kb_tax_label', $term->name ), 
	apply_filters( 'hkb_breadcrumbs_kb_tax_title', __( 'View all posts in %s', 'ht-knowledge-base' ) ), $term->name), 
	apply_filters( 'hkb_breadcrumbs_kb_search_label', __('Search Results', 'ht-knowledge-base') ), 
	apply_filters( 'hkb_breadcrumbs_kb_search_title', __('Search Results', 'ht-knowledge-base') ), 
*/


//exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


if( ! class_exists( 'HT_KnowAll_Translation_Helpers' ) ){

	class HT_KnowAll_Translation_Helpers{

		//constructor 
		function __construct(){
			add_filter( 'hkb_breadcrumbs_blog_home_label', array( $this, 'hkb_breadcrumbs_blog_home_label' ), 10, 1 );
			add_filter( 'hkb_breadcrumbs_blog_home_title', array( $this, 'hkb_breadcrumbs_blog_home_title' ), 10, 1 );
			add_filter( 'hkb_breadcrumbs_kb_home_label', array( $this, 'hkb_breadcrumbs_kb_home_label' ), 10, 1 );
			add_filter( 'hkb_breadcrumbs_kb_home_title', array( $this, 'hkb_breadcrumbs_kb_home_title' ), 10, 1 );
			add_filter( 'hkb_breadcrumbs_kb_tax_label', array( $this, 'hkb_breadcrumbs_kb_tax_label' ), 10, 1 );
			add_filter( 'hkb_breadcrumbs_kb_tax_title', array( $this, 'hkb_breadcrumbs_kb_tax_title' ), 10, 1 );
			add_filter( 'hkb_breadcrumbs_kb_search_label', array( $this, 'hkb_breadcrumbs_kb_search_label' ), 10, 1 );
			add_filter( 'hkb_breadcrumbs_kb_search_title', array( $this, 'hkb_breadcrumbs_kb_search_title' ), 10, 1 );
			add_filter( 'hkb_breadcrumbs_non_kb_search_label', array( $this, 'hkb_breadcrumbs_kb_search_label' ), 10, 1 );
			add_filter( 'hkb_breadcrumbs_non_kb_search_title', array( $this, 'hkb_breadcrumbs_kb_search_title' ), 10, 1 );
			add_filter( 'hkb_search_keep_typing_text', array( $this, 'hkb_search_keep_typing_text' ), 10, 1 );
		}

		function hkb_breadcrumbs_blog_home_label( $label ){
			return __( 'Home', 'knowall' );
		} 

		function hkb_breadcrumbs_blog_home_title( $title ){
			return __( 'Home', 'knowall' );
		} 

		function hkb_breadcrumbs_kb_home_label( $label ){
			return __( 'Knowledge Base', 'knowall' );
		} 

		function hkb_breadcrumbs_kb_home_title( $title ){
			return __( 'Knowledge Base', 'knowall' );
		} 

		function hkb_breadcrumbs_kb_tax_label( $label ){
			return $label;
		} 

		function hkb_breadcrumbs_kb_tax_title( $title ){
			return __( 'View all posts in %s', 'knowall' );
		} 

		function hkb_breadcrumbs_kb_search_label( $label ){
			return __( 'Search Results for %s', 'knowall' );
		} 

		function hkb_breadcrumbs_kb_search_title( $title ){
			return __( 'Search Results for %s', 'knowall' );
		} 

		function hkb_search_keep_typing_text( $text ){
			return __( 'Keep typing for live search results', 'knowall' );
		}

	}

}

if( class_exists( 'HT_KnowAll_Translation_Helpers' ) ){
	$ht_knowall_tranlsation_helpers = new HT_KnowAll_Translation_Helpers();
}