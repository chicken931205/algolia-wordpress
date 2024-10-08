<?php

//enable posts support
//add_filter( 'ht_knowall_posts_functionality', '__return_true' ); 

/**
* Remove the posts menu
*/
function ht_knowall_remove_menus(){
	if(!apply_filters('ht_knowall_posts_functionality', false)){
		remove_menu_page( 'edit.php' ); 
	}   
}
add_action( 'admin_menu', 'ht_knowall_remove_menus' );

/**
* Disable static front page
*/
function ht_knowall_filter_dropdown_pages($output, $r, $pages){
	if(!apply_filters('ht_knowall_posts_functionality', false)){
		if( (array_key_exists('name', $r) &&'page_on_front'==$r['name']) || (array_key_exists('name', $r) &&'page_for_posts'==$r['name']) ){
			return esc_html_e('Please enable Blog Support in Appearance > Customize > Homepage Settings > KnowAll Blog Support to select ', 'knowall');
		} else {
			return $output;
		}
	} else {
		return $output;
	}
	
	
}
add_filter( 'wp_dropdown_pages', 'ht_knowall_filter_dropdown_pages', 10, 3);

/**
* Whitelist filter
*/
function ht_knowall_filter_whitelist_options($options){
	if(!apply_filters('ht_knowall_posts_functionality', false)){
		//array_key_exists(key, array)
		//remove 
		//remove $options['reading']['show_on_front'];
		unset($options['reading']['show_on_front']);
		//remove $options['reading']['page_on_front']
		unset($options['reading']['page_on_front']);
	}
	return $options;
}
add_filter( 'whitelist_options', 'ht_knowall_filter_whitelist_options', 10, 1 );


/**
* Customize register
*/
function ht_knowall_filter_customize_register( $customize ){
	if(!apply_filters('ht_knowall_posts_functionality', false)){
		$customize->remove_control('show_on_front');
		$customize->remove_control('page_on_front');
	}
}
//add_action( 'customize_register', 'ht_knowall_filter_customize_register', 800, 1 );

function ht_knowall_add_blog_control( $customize ){

		$customize->add_setting(
			'knowall_blog_support',
			array(
				'default' => 'disable',
				'type'       => 'option',
				'capability' => 'manage_options',
				'transport' => 'postMessage',
			)
		);

		$customize->add_control(
			'knowall_blog_support',
			array(
				'label'   => __( 'KnowAll Blog Support', 'knowall' ),
				'section' => 'static_front_page',
				'type'    => 'radio',
				'choices' => array(
					'disable' => __( 'Disable Blog Support', 'knowall' ),
					'enable'  => __( 'Enable Blog and Static Page Support', 'knowall' ),
				),
			)
		);

		
}
add_action( 'customize_register', 'ht_knowall_add_blog_control', 801, 1 );

function ht_knowall_filter_blog_support_customize_option( $enabled ){
	if('enable' == get_option( 'knowall_blog_support' )){
		$enabled = true;
	}
	return $enabled;
}
add_filter('ht_knowall_posts_functionality', 'ht_knowall_filter_blog_support_customize_option', 50, 1);

/*
function ht_knowall_filter_add_blog_enable_customize(){
	echo 'test';
}
*/

/**
* Override front page setting
*/
function ht_knowall_set_show_on_front(){
	if(!apply_filters('ht_knowall_posts_functionality', false)){
		if(is_admin()&&current_user_can('edit_theme_options')){
			$show_on_front=get_option('show_on_front');
			if(isset($show_on_front)&&'page'==$show_on_front){
				//manually override
				update_option('show_on_front', 'posts');
			}
		}
	}	
}
add_action('admin_init', 'ht_knowall_set_show_on_front');

/**
* Disable New > Post from admin bar
*/
function ht_knowall_remove_add_new_post_from_admin_bar(){
	if(!apply_filters('ht_knowall_posts_functionality', false)){
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu('new-post');
	}
}
add_action( 'wp_before_admin_bar_render', 'ht_knowall_remove_add_new_post_from_admin_bar', 10 );


/**
* Redirect edit screen
*/
function ht_knowall_redirect_edit_post_screen(){
	$screen = get_current_screen(); 

	if(!apply_filters('ht_knowall_posts_functionality', false)){
		if($screen && 'edit-tags'!=$screen->base && 'post'==$screen->post_type){
			wp_redirect( admin_url() );
			exit;
		}
	}

}
add_action( 'current_screen', 'ht_knowall_redirect_edit_post_screen', 10 );



/**
 * Filter the except length to 50 characters.
 */
function ht_custom_excerpt_length( $length ) {
	return 50;
}
add_filter( 'excerpt_length', 'ht_custom_excerpt_length', 999 );


/** 
 * Disable Quick Draft Meta Box if post support not enabled
 */

function ht_knowall_remove_quick_draft_meta_box(){ 

	if( !apply_filters( 'ht_knowall_posts_functionality', false ) ){

		//remove the core quick press dashboard widget / meta box
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );

		//early return if warning disabled
		if( !apply_filters( 'ht_knowall_dashboard_quick_press_show_disabled_warning', false ) ){
			return;
		}

		//add replacement widget (disabled by default)
		wp_add_dashboard_widget(
			 'ht_knowall_posts_disabled_dashboard_widget',
			 __('Quick Draft', 'knowall' ),
			 'ht_knowall_replacement_quick_draft_meta_box'
		);
		
	}
}
add_action( 'wp_dashboard_setup', 'ht_knowall_remove_quick_draft_meta_box', 10 );

/**
 * Blog support disabled warning
 */
function ht_knowall_replacement_quick_draft_meta_box(){
	esc_html_e('Blog Support Disabled. If required, enable Blog Support in Appearance > Customize > Homepage Settings > KnowAll Blog Support', 'knowall');
}