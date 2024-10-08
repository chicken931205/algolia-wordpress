<?php 

// Load all includes
require_once get_stylesheet_directory() . '/inc/template-tags2.php';
require( get_stylesheet_directory() . '/includes/functions-search.php' );
//require( get_stylesheet_directory() . '/includes/functions-ht-kb-fix.php' );

/* Load theme stylesheets */
function ht_theme_style() {
wp_enqueue_style( 'font-awesome', get_template_directory_uri() . 'font-awesome.min.css' );
	// Load parent style
	wp_enqueue_style( 'ht-theme-style', get_template_directory_uri() . '/css/style.css' );
	// Load child style
	wp_enqueue_style( 'ht-childtheme-style', get_stylesheet_uri(), array('ht-theme-style') );
}
add_action( 'wp_enqueue_scripts', 'ht_theme_style' );


/* Insert custom functions here */
add_filter( 'relevanssi_remove_punctuation', 'rlv_remove_hyphens', 9 );
function rlv_remove_hyphens( $a ) {

	$a = str_replace( '-', '', $a );

	return $a;
}

add_action( 'wp_print_scripts', 'sel_remove_hero_kb_resources', 100 );
/**
 * Remove unused resources from the knowledge base plugin
 */
function sel_remove_hero_kb_resources() {
	wp_dequeue_script( 'enqueue_ht_kb_live_search_scripts_and_styles' );
}

add_action( 'wp_enqueue_scripts', 'sel_register_scripts' );
/**
 * Register and enqueue our main script
 *
 * @return void
 */
function sel_register_scripts() {
//wp_register_script( 'sel-main', get_stylesheet_directory_uri() . '/assets/js/main.js', null, true );
	wp_register_script( 'sel-main', get_stylesheet_directory_uri() . '/assets/js/main.js', array( 'ht-kb-frontend-scripts' ), '1.0.0', true );
	wp_localize_script( 'sel-main', 'sel', array( 'cats' => array(), 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	wp_enqueue_script( 'sel-main' );
}

add_action( 'init', 'sel_may_start_session' );
/**
 * Start the PHP session if not already done
 *
 * This is used by sel_update_search_cats_session()
 *
 * @return void
 */
function sel_may_start_session() {
	if ( session_status() == PHP_SESSION_NONE ) {
		session_start();
	}
}

add_filter( 'gettext', 'sel_translate_text', 20, 3 );
/**
 * Change text content where hardcoded
 *
 * @return string
 */
function sel_translate_text( $translated_text, $text, $domain ) {

	switch ( $translated_text ) {
		case 'Heroic KB':
			$translated_text = 'Database';
			break;
        case 'Knowledge Base':
			$translated_text = 'Database';
			break;
		case 'Articles':
			$translated_text = 'Documents';
			break;
		case 'Article Attachments':
			$translated_text = 'Document Attachments';
			break;
		case 'Related Articles':
			$translated_text = 'Related Documents';
			break;
	}

	return $translated_text;
}

add_filter( 'ngettext', 'sel_translate_text_plural', 20, 5 );
/**
 * Change text content where hardcoded (with numeric context)
 *
 * @return  string
 */
function sel_translate_text_plural( $translated_text, $single, $plural, $number, $domain ) {

	if ( '%s Articles' === $translated_text ) {
		if ( 1 === $number ) {
			$translated_text = '%s Document';
		} else {
			$translated_text = '%s Documents';
		}
	}

	return $translated_text;
}
function custom_theme_widgets() {
    register_sidebar(array(
        'name' => 'Footer Widget Area',
        'id' => 'footer-widget-area',
        'description' => 'This is a custom widget area.',
        'before_widget' => '<div class="footer-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-footer">',
        'after_title' => '</h2>',
    ));
}
add_action('widgets_init', 'custom_theme_widgets');

 
