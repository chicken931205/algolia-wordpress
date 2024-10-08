<?php
/**
* Template helper functions
*/

// Homepage Sidebar Position
function ht_sidebarpostion_homepage() {
	$ht_homesidebar = get_theme_mod( 'ht_setting__homepagesidebar', 'right' );
  // Check if there are any widgets in widget area before adding class
  if ( is_active_sidebar( 'sidebar-home' ) ) :
	 echo 'ht-page--sidebar' . esc_attr( $ht_homesidebar );
  else :
    echo 'ht-page--sidebaroff';
  endif;
}

// KB Category Sidebar Position
function ht_sidebarpostion_kbcategory() {
  $ht_kbcategorysidebar = get_theme_mod( 'ht_setting__acategorysidebar', 'right' );
  // Check if there are any widgets in widget area before adding class
  if ( is_active_sidebar( 'sidebar-category' ) ) :
    echo 'ht-page--sidebar' . esc_attr( $ht_kbcategorysidebar );
  else :
    echo 'ht-page--sidebaroff';
  endif;
}

// Article Sidebar Position
function ht_sidebarpostion_article() {
  $ht_articlesidebar = get_theme_mod( 'ht_setting__articlesidebar', 'left' );
  // Check if there are any widgets in widget area before adding class
  if ( is_active_sidebar( 'sidebar-article' ) ) :
    echo 'ht-page--sidebar' . esc_attr( $ht_articlesidebar );
  else :
    echo 'ht-page--sidebaroff';
  endif;
}

// Page Sidebar Position
function ht_sidebarpostion_page() {
  $ht_pagesidebar = get_theme_mod( 'ht_setting__pagesidebar', 'off' );
  // Check if there are any widgets in widget area before adding class
  if ( is_active_sidebar( 'sidebar-page' ) ) :
    echo 'ht-page--sidebar' . esc_attr( $ht_pagesidebar );
  else :
    echo 'ht-page--sidebaroff';
  endif;
}

// Blog Sidebar Position
function ht_sidebarpostion_blog() {
  $ht_blogsidebar = get_theme_mod( 'ht_setting__blogsidebar', 'off' );
  // Check if there are any widgets in widget area before adding class
  if ( is_active_sidebar( 'sidebar-blog' ) ) :
    echo 'ht-page--sidebar' . esc_attr( $ht_blogsidebar );
  else :
    echo 'ht-page--sidebaroff';
  endif;
}

// Get homepage sidebar
function ht_get_sidebar_homepage($position) {
	$ht_homesidebar = get_theme_mod( 'ht_setting__homepagesidebar', 'right' );
	if ( ($ht_homesidebar == 'left') && ($position == 'left') ):
    get_sidebar('home');
  elseif ( ($ht_homesidebar == 'right') && ($position == 'right') ):
  	get_sidebar('home');
  endif;
}

// Get KB category sidebar
function ht_get_sidebar_kbcategory($position) {
  $ht_kbcategorysidebar = get_theme_mod( 'ht_setting__acategorysidebar', 'right' );
  if ( ($ht_kbcategorysidebar == 'left') && ($position == 'left') ):
    get_sidebar('category');
  elseif ( ($ht_kbcategorysidebar == 'right') && ($position == 'right') ):
    get_sidebar('category');
  endif;
}

// Get article sidebar
function ht_get_sidebar_article($position) {
  $ht_articlesidebar = get_theme_mod( 'ht_setting__articlesidebar', 'left' );
  if ( ($ht_articlesidebar == 'left') && ($position == 'left') ):
    get_sidebar('article');
  elseif ( ($ht_articlesidebar == 'right') && ($position == 'right') ):
    get_sidebar('article');
  endif;
}

// Get page sidebar
function ht_get_sidebar_page($position) {
  $ht_pagesidebar = get_theme_mod( 'ht_setting__pagesidebar', 'off' );
  if ( ($ht_pagesidebar == 'left') && ($position == 'left') ):
    get_sidebar('page');
  elseif ( ($ht_pagesidebar == 'right') && ($position == 'right') ):
    get_sidebar('page');
  endif;
}

// Get blog sidebar
function ht_get_sidebar_blog($position) {
  $ht_blogsidebar = get_theme_mod( 'ht_setting__blogsidebar', 'right' );
  if ( ($ht_blogsidebar == 'left') && ($position == 'left') ):
    get_sidebar('blog');
  elseif ( ($ht_blogsidebar == 'right') && ($position == 'right') ):
    get_sidebar('blog');
  endif;
}


// Homepage Archive Classes
function ht_kbarchive_style() {

  $classes = '';

  // Add KB Archive Column Class
	$ht_kbarchivecols = get_theme_mod( 'ht_setting__kbarchivecols', '2' );
	$classes .= ' hkb-archive--' . $ht_kbarchivecols. 'cols';

  // Add KB Archive Justify Class
  $ht_setting__kbarchivecolsjustify = get_theme_mod( 'ht_setting__kbarchivecolsjustify', '0' );
  if ( $ht_setting__kbarchivecolsjustify == true ) {
    $classes .= ' hkb-archive--justify';
  }

  // Add margin to bottom of li if boxed categories are chosen
  $ht_setting__kbarchiveboxed = get_theme_mod( 'ht_setting__kbarchiveboxed', '0' );
  if ( $ht_setting__kbarchiveboxed == true ) {
    $classes .= ' hkb-archive--marginb';
  }

  return $classes;
}

// KB Archive Category Classes
function ht_kbarchive_catstyle($hkb_current_term_id) {

  $classes = '';

  // Add class for when box setting is true
  $ht_setting__kbarchiveboxed = get_theme_mod( 'ht_setting__kbarchiveboxed', '0' );
  if ( $ht_setting__kbarchiveboxed == true ) {
    $classes .= ' hkb-category--boxed';
  }

  // Add class if category description is on, and there is a description available
  $ht_setting__kbarchivecatdesc = get_theme_mod( 'ht_setting__kbarchivecatdesc', '1' );
  $ht_thiscategorydesc = term_description( $hkb_current_term_id, 'ht_kb_category' );
  if ( ($ht_setting__kbarchivecatdesc == true) && ($ht_thiscategorydesc != '') ) {
    $classes .= ' hkb-category--withdesc';
  }

  // Add class if category articles list is on
  $ht_setting__kbarchivecatarticles = get_theme_mod( 'ht_setting__kbarchivecatarticles', '0' );
  if ( ($ht_setting__kbarchivecatarticles == true) && (!is_tax('ht_kb_category')) ) {
    $classes .= ' hkb-category--witharticles';
  }

  // Add class for archive style selected
  $ht_setting__kbarchivestyle = get_theme_mod( 'ht_setting__kbarchivestyle', '7' );
  $classes .= ' hkb-category--style'. $ht_setting__kbarchivestyle;

  // Add class when an icon is available for this category
  if( hkb_has_category_custom_icon( $hkb_current_term_id ) == 'true' ) {
    $classes .= ' hkb-category--withicon';
  }

  return $classes;
}

// Subcategory Lsiting Classes
function ht_kbsubcats_style() {

  $classes = '';

  // Add margin to bottom of li if boxed categories are chosen
  $ht_setting__kbarchiveboxed = get_theme_mod( 'ht_setting__kbarchiveboxed', '0' );
  if ( $ht_setting__kbarchiveboxed == true ) {
    $classes .= ' hkb-subcats--marginb';
  }

  return $classes;
}