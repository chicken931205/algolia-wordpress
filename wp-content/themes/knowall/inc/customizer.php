<?php

// Load library
require_once( get_template_directory() . '/inc/kirki/kirki.php' );

// Update paths
if ( ! function_exists( 'ht_theme_kirki_update_url' ) ) {
	function ht_theme_kirki_update_url( $config ) {
		$config['url_path'] = get_template_directory_uri() . '/inc/kirki/';
		return $config;
	}
}
add_filter( 'kirki/config', 'ht_theme_kirki_update_url', 999 );

// Style library
function ht_theme_kirki_styling( $config ) {
	return wp_parse_args(
		array(
			'disable_loader' => true,
		),
		$config 
	);
}
add_filter( 'kirki/config', 'ht_theme_kirki_styling' );


if ( class_exists( 'Kirki' ) ) {

	/**
	* inheritable configuration
	*/
	Kirki::add_config( 'ht_theme', array(
		'capability'    => 'edit_theme_options',
		'option_type'   => 'theme_mod',
	) );

	/**
	* Panel: Theme
	*/
	Kirki::add_panel( 'ht_panel__main', array(
		'priority'    => 10,
		'title'       => esc_attr__( 'Theme', 'knowall' ),
		'description' => esc_attr__( 'Customize your theme here', 'knowall' ),
	) );


	/**
	* Section: Header
	*/
	Kirki::add_section( 'ht_sec__header', array(
		'title'         => esc_attr__( 'Header', 'knowall' ),
		'panel'     	=> 'ht_panel__main',
		'priority'      => 1,
		'capability'    => 'edit_theme_options',
	) );

	// Setting: Theme Logo
	Kirki::add_field( 'ht_theme', array(
		'type'     		=> 'image',
		'settings' 		=> 'ht_setting__themelogo',
		'label'			=> esc_attr__( 'Site Logo', 'knowall' ),
		'description' 	=> esc_attr__( 'Upload a site logo image.', 'knowall' ),
		'section'  		=> 'ht_sec__header',
		'priority' 		=> 10,
		'default'  		=> get_template_directory_uri().'/img/logo.png',
	) );

	Kirki::add_field( 'ht_theme', array(
		'type'        => 'checkbox',
		'settings'    => 'ht_setting__themelogoretinatoggle',
		'label'       => esc_attr__( 'Different Logo For Retina Devices?', 'knowall' ),
		'section'     => 'ht_sec__header',
		'default'     => false,
	) );

	Kirki::add_field( 'ht_theme', array(
		'type'     		=> 'image',
		'settings' 		=> 'ht_setting__themelogoretina',
		'label'				=> esc_attr__( 'Site Retina Logo', 'knowall' ),
		'description' => esc_attr__( 'Upload a logo image that is twice the size of your site logo.', 'knowall' ),
		'section'  		=> 'ht_sec__header',
		'priority' 		=> 10,
		'required'  => array(
			array(
				'setting'  => 'ht_setting__themelogoretinatoggle',
				'operator' => '==',
				'value'    => true,
			),
		),
	) );


	Kirki::add_field( 'ht_theme', array(
		'settings'    => 'ht_setting__themelogolinkurl',
		'section'     => 'ht_sec__header',
		'type'        => 'text',
		'label'       => esc_attr__( 'Logo Link', 'knowall' ),
		'description' => esc_attr__( 'The URL link to use for the site logo', 'knowall' ),
		'tooltip'     => esc_attr__( 'Use this settings to link the logo to a different url. Leave blank to link to the homepage and the # symbol to do nothing.', 'knowall' ),
		'default'     => '',	    
		'priority'    => 10,
	) );

	Kirki::add_field( 'ht_theme', array(
		'settings'    => 'ht_setting__searchplaceholder',
		'section'     => 'ht_sec__header',
		'type'        => 'text',
		'label'       => esc_attr__( 'Search Placeholder', 'knowall' ),
		'description' => esc_attr__( 'To remove, leave this blank', 'knowall' ),
		'default'     => esc_attr__( 'Search the knowledge base...', 'knowall' ),	    
		'priority'    => 10,
	) );

	Kirki::add_field( 'ht_theme', array(
		'type'        => 'radio-buttonset',
		'settings'    => 'ht_setting__headerbg',
		'label'       => esc_attr__( 'Header Background', 'knowall' ),
		'description' => esc_attr__( 'Select the background type', 'knowall' ),
		'section'     => 'ht_sec__header',
		'default'     => 'color',
		'priority'    => 10,
		'choices'     => array(
			'color'   => esc_attr__( 'Solid Color', 'knowall' ),
			'image' => esc_attr__( 'Image', 'knowall' ),
			'gradient'  => esc_attr__( 'Gradient', 'knowall' ),
		),
	) );


	Kirki::add_field( 'ht_theme', array(
		'type'        => 'color',
		'settings'    => 'ht_setting__headerbgcolor',
		'label'       => esc_attr__( 'Background Color', 'knowall' ),
		'description' => esc_attr__( 'Set background color', 'knowall' ),
		'tooltip'        => esc_attr__( 'Use this section to set a background color', 'knowall' ),
		'section'     => 'ht_sec__header',
		'default'  		=> '#00b4b3',
		'priority'    => 10,
		'required'  => array(
			array(
				'setting'  => 'ht_setting__headerbg',
				'operator' => '==',
				'value'    => 'color',
			),
		),
		'output' => array(
			array(
				'element'  => '.site-header',
				'property' => 'background',
			),
		),
	) );


	Kirki::add_field( 'ht_theme', array(
		'type'     		=> 'background',
		'settings' 		=> 'ht_setting__headerbgimg',
		'label'			=> esc_attr__( 'Background Image', 'knowall' ),
		'description' 	=> esc_attr__( 'Upload a background image', 'knowall' ),
		'section'  		=> 'ht_sec__header',
		'default'  		=> array(
			'background-color'    => '#00b4b3',
			'background-image'    => '',
			'background-repeat'   => 'no-repeat',
			'background-size'     => 'cover',
			'background-attachment'   => 'fixed',
			'background-position' => 'left-top',
		),
		'priority' 		=> 10,
		'required'  => array(
			array(
				'setting'  => 'ht_setting__headerbg',
				'operator' => '==',
				'value'    => 'image',
			),
		),
		'output' => array(
			array(
				'element'  => '.site-header',
			),
		),

	) );


	Kirki::add_field( 'ht_theme', array(
		'type'        => 'color',
		'settings'    => 'ht_setting__headerbggrad_color1',
		'label'       => esc_attr__( 'Background Gradient Color 1', 'knowall' ),
		'description' => esc_attr__( 'Set background color gradient 1', 'knowall' ),
		'section'     => 'ht_sec__header',
		'default'     => '#00b4b3',
		'priority'    => 10,
		'required'  => array(
			array(
				'setting'  => 'ht_setting__headerbg',
				'operator' => '==',
				'value'    => 'gradient',
			),
		),
		'transport'    => 'postMessage',
	) );


	Kirki::add_field( 'ht_theme', array(
		'type'        => 'slider',
		'settings'    => 'ht_setting__headerbggrad_angle',
		'label'       => esc_attr__( 'Background Gradient Angle', 'knowall' ),
		'description' => esc_attr__( 'Select the gradient angle', 'knowall' ),
		'section'     => 'ht_sec__header',
		'default'     => '90',
		'priority'    => 10,
		'required'  => array(
			array(
				'setting'  => 'ht_setting__headerbg',
				'operator' => '==',
				'value'    => 'gradient',
			),
		),
		'transport'    => 'postMessage',
		'choices'      => array(
			'min'  => 0,
			'max'  => 360,
			'step' => 1,
		)
	) );

	Kirki::add_field( 'ht_theme', array(
		'type'        => 'color',
		'settings'    => 'ht_setting__headerbggrad_color2',
		'label'       => esc_attr__( 'Background Gradient Color 2', 'knowall' ),
		'description' => esc_attr__( 'Set background color gradient 2.', 'knowall' ),
		'section'     => 'ht_sec__header',
		'default'     => '#c75552',
		'priority'    => 10,
		'required'  => array(
			array(
				'setting'  => 'ht_setting__headerbg',
				'operator' => '==',
				'value'    => 'gradient',
			),
		),
		'transport'    => 'postMessage',
	) );	


	Kirki::add_field( 'ht_theme', array(
		'type'        => 'color',
		'settings'    => 'ht_setting__headerfontcolor',
		'label'       => esc_attr__( 'Header Font Color', 'knowall' ),
		'description' => esc_attr__( 'Set the font color for text in the header.', 'knowall' ),
		'section'     => 'ht_sec__header',
		'default'     => '#fff',
		'priority'    => 10,
		'transport'    => 'postMessage',
		'output'      => array(
			array(
				'element'  => '.site-header .site-header__title, .nav-header ul li a',
				'property' => 'color',
			),
			array(
				'element'  => '.nav-header .nav-header__mtoggle span, .nav-header .nav-header__mtoggle span::before, .nav-header .nav-header__mtoggle span::after',
				'property' => 'background',
			),
		),
		'js_vars'     => array(
			array(
				'element'  => '.site-header .site-header__title, .nav-header ul li a',
				'function' => 'style',
				'property' => 'color',
			),
			array(
				'element'  => '.nav-header > ul > li.menu-item-has-children > a::after',
				'function' => 'style',
				'property' => 'background-image',
				'value_pattern' => "url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 34.1 19\" fill=\"$\"><path d=\"M17 19c-0.5 0-1-0.2-1.4-0.6L0.6 3.4c-0.8-0.8-0.8-2 0-2.8 0.8-0.8 2-0.8 2.8 0L17 14.2 30.7 0.6c0.8-0.8 2-0.8 2.8 0 0.8 0.8 0.8 2 0 2.8L18.4 18.4C18 18.8 17.5 19 17 19z\"/></svg>')",
			),
			array(
				'element'  => '.nav-header .nav-header__mtoggle span, .nav-header .nav-header__mtoggle span::before, .nav-header .nav-header__mtoggle span::after',
				'function' => 'style',
				'property' => 'background',
			),
		),
	) );

	/** 
	* Section: Footer
	*/
	Kirki::add_section( 'ht_sec__footer', array(
		'title'         => esc_attr__( 'Footer', 'knowall' ),
		'panel'     	=> 'ht_panel__main',
		'priority'      => 1,
		'capability'    => 'edit_theme_options',
	) );

	Kirki::add_field( 'ht_theme', array(
		'type'     => 'textarea',
		'settings' => 'ht_setting__copyright',
		'label'    => esc_attr__( 'Copyright Message', 'knowall' ),
		'section'  => 'ht_sec__footer',
		'default'  => __('&copy; Copyright KnowAll. Powered by <a href="https://herothemes.com">HeroThemes</a>.', 'knowall' ),
		'priority' => 10,
	) );


	/** 
	* Section: Styling
	*/
	Kirki::add_section( 'ht_sec__styling', array(
		'title'          => esc_attr__( 'Styling', 'knowall' ),
		'panel'     	=> 'ht_panel__main',
		'priority'       => 1,
		'capability'     => 'edit_theme_options',
	) );

	// Setting: Link Color
	Kirki::add_field( 'ht_theme', array(
		'type'        => 'color',
		'settings'    => 'ht_setting__linkcolor',
		'label'       => esc_attr__( 'Link Color', 'knowall' ),
		'description' => esc_attr__( 'Set the link color. Note: This color is also used to color other accented areas.', 'knowall' ),
		'section'     => 'ht_sec__styling',
		'default'     => '#00b4b3',
		'priority'    => 10,
		'transport'   => 'postMessage',
		'output'      => array(
			array(
				'element'  => 'a',
				'property' => 'color',
			),
			array(
				'element'  => 'input[type="reset"], input[type="submit"], input[type="button"], .hkb-article__content ol li:before, .hkb-article__content ul li:before, .hkb_widget_exit__btn',
				'property' => 'background',
			),
			array(
				'element'  => '.hkb-breadcrumbs__icon',
				'property' => 'fill',
			),
			array(
				'element'  => '.hkb-article__title a:hover, .hkb-article__link:hover h2, .ht-post__title a:hover, .hkb-category .hkb-category__articlelist a',
				'property' => 'color',
			),
			array(
				'element'  => '.hkb-article-attachment__icon',
				'property' => 'fill',
			),
			array(
				'element'  => '.edit-post-visual-editor.editor-styles-wrapper a',
				'property' => 'color',
				'context'  => array( 'editor' ),
			),
		),
		'js_vars'     => array(
			array(
				'element'  => 'a',
				'function' => 'style',
				'property' => 'color',
			),
			array(
				'element'  => 'button, input[type="reset"], input[type="submit"], input[type="button"], .hkb-article__content ol li:before, .hkb-article__content ul li:before, .hkb_widget_exit__btn',
				'function' => 'style',
				'property' => 'background',
			),
			array(
				'element'  => '.hkb-breadcrumbs__icon',
				'function' => 'style',
				'property' => 'fill',
			),
			array(
				'element'  => '.hkb-article__title a:hover, .ht-post__title a:hover, .hkb-category .hkb-category__articlelist a',
				'function' => 'style',
				'property' => 'color',
			),
			array(
				'element'  => '.hkb-article-attachment__icon',
				'function' => 'style',
				'property' => 'fill',
			),
		),
	) );

	// Setting: Link Color:Hover
	Kirki::add_field( 'ht_theme', array(
		'type'        => 'color',
		'settings'    => 'ht_setting__linkcolorhover',
		'label'       => esc_attr__( 'Link Color:hover', 'knowall' ),
		'description' => esc_attr__( 'Set the link on hover color', 'knowall' ),
		'section'     => 'ht_sec__styling',
		'default'     => '#00a8a8',
		'priority'    => 10,
		'transport'   => 'postMessage',
		'output'      => array(
			array(
				'element'  => 'a:hover, .hkb-category .hkb-category__articlelist a:hover',
				'property' => 'color',
			),
			array(
				'element'  => 'button:hover, input[type="reset"]:hover, input[type="submit"]:hover, input[type="button"]:hover, .ht-transferbox__btn:hover',
				'property' => 'background',
			),
			array(
				'element'  => '.edit-post-visual-editor.editor-styles-wrapper a:hover',
				'property' => 'color',
				'context'  => array( 'editor' ),
			),
		),
		
		'js_vars'     => array(
			array(
				'element'  => 'a:hover, .hkb-category .hkb-category__articlelist a:hover',
				'function' => 'style',
				'property' => 'color',
			),
			array(
				'element'  => 'button:hover, input[type="reset"]:hover, input[type="submit"]:hover, input[type="button"]:hover, .ht-transferbox__btn:hover',
				'function' => 'style',
				'property' => 'background',
			),
		),
	) );

	

	// Setting: Site Width
	Kirki::add_field( 'ht_theme', array(
		'type'        => 'slider',
		'settings'    => 'ht_setting__sitewidth',
		'label'       => __( 'Site Width', 'knowall' ),
		'description' => __( 'Modify the width of your site', 'knowall' ),
		'section'     => 'ht_sec__styling',
		'default'     => '1000',
		'priority'    => 10,
		'choices'     => array(
			'min'  => 920,
			'max'  => 1600,
			'step' => 10
		),
		'transport'   => 'refresh',
		'js_vars'     => array(
			array(
				'element'  => '.ht-container',
				'function' => 'css',
				'property' => 'max-width',
				'units' => 'px',
			),
			array(
				'element'  => '.ht-sitecontainer--boxed',
				'function' => 'css',
				'property' => 'max-width',
				'units' => 'px',
			),
		),
		'output'      => array(
			array(
				'element'  => '.ht-container',
				'property' => 'max-width',
				'units' => 'px',
			),
			array(
				'element'  => '.ht-sitecontainer--boxed',
				'property' => 'max-width',
				'units' => 'px',
			),
		),
	) );

	// Setting: Site Layout
	Kirki::add_field( 'ht_theme', array(
		'type'        => 'radio-image',
		'settings'    => 'ht_setting__sitelayout',
		'label'       => esc_attr__( 'Theme Layout', 'knowall' ),
		'description' => esc_attr__( 'Select the layout for the theme. Boxed or Wide.', 'knowall' ),
		'section'     => 'ht_sec__styling',
		'default'     => 'wide',
		'priority'    => 10,
		'choices'     => array(
			'boxed'   => get_template_directory_uri() . '/img/admin/layout-boxed.png',
			'wide' => get_template_directory_uri() . '/img/admin/layout-wide.png',
		),
	) );

	// Setting: Boxed Box Shadow
	Kirki::add_field( 'ht_theme', array(
		'type'        => 'slider',
		'settings'    => 'ht_setting__siteboxshadow',
		'label'       => esc_attr__( 'Website Shadow', 'knowall' ),
		'section'     => 'ht_sec__styling',
		'default'     => '1',
		'priority'    => 10,
		'choices'     => array(
			'min'  => 0,
			'max'  => 5,
			'step' => 1
		),
		'required'  => array(
			array(
				'setting'  => 'ht_setting__sitelayout',
				'operator' => '==',
				'value'    => 'boxed',
			),
		),
	) );

	// Setting Background Type Switcher
	Kirki::add_field( 'ht_theme', array(
		'type'        => 'radio-buttonset',
		'settings'    => 'ht_setting__sitebg',
		'label'       => esc_attr__( 'Background Type', 'knowall' ),
		'description' => esc_attr__( 'Select the background type', 'knowall' ),
		'section'     => 'ht_sec__styling',
		'default'     => 'color',
		'priority'    => 10,
		'choices'     => array(
			'color'   => esc_attr__( 'Solid Color', 'knowall' ),
			'image' => esc_attr__( 'Image', 'knowall' ),
			'gradient'  => esc_attr__( 'Gradient', 'knowall' ),
		),
		'required'  => array(
			array(
				'setting'  => 'ht_setting__sitelayout',
				'operator' => '==',
				'value'    => 'boxed',
			),
		),
	) );

	// Setting: BG color
	Kirki::add_field( 'ht_theme', array(
		'type'        => 'color',
		'settings'    => 'ht_setting__sitebgcolor',
		'label'       => esc_attr__( 'Background Color', 'knowall' ),
		'description' => esc_attr__( 'Set background color', 'knowall' ),
		'section'     => 'ht_sec__styling',
		'default'     => '#f4f5f5',
		'priority'    => 10,
		'required'  => array(
			array(
				'setting'  => 'ht_setting__sitelayout',
				'operator' => '==',
				'value'    => 'boxed',
			),
			array(
				'setting'  => 'ht_setting__sitebg',
				'operator' => '==',
				'value'    => 'color',
			),
		),
		'output'      => array(
			array(
				'element'  => 'body',
				'property' => 'background-color',
			),
		),
		'js_vars'     => array(
			array(
				'element'  => 'body',
				'function' => 'css',
				'property' => 'background-color',
			),
		),
	) );


	// Setting: BG Image
	Kirki::add_field( 'ht_theme', array(
		'type'     		=> 'background',
		'settings' 		=> 'ht_setting__sitebgimg',
		'label'			=> esc_attr__( 'Background Image', 'knowall' ),
		'description' 	=> esc_attr__( 'Upload a background image', 'knowall' ),
		'section'  		=> 'ht_sec__styling',
		'default'  		=> array(
			'background-color'    => '',
			'background-image'    => '',
			'background-repeat'   => 'no-repeat',
			'background-size'     => 'cover',
			'background-attachment'   => 'fixed',
			'background-position' => 'left-top',
		),
		'priority' 		=> 10,
		'required'  => array(
			array(
				'setting'  => 'ht_setting__sitelayout',
				'operator' => '==',
				'value'    => 'boxed',
			),
			array(
				'setting'  => 'ht_setting__sitebg',
				'operator' => '==',
				'value'    => 'image',
			),
		),
		'output' => array(
			array(
				'element'  => 'body',
			),
		),
		'transport'   => 'auto'

	) );

	// Setting BG Gradient
	Kirki::add_field( 'ht_theme', array(
		'type'        => 'color',
		'settings'    => 'ht_setting__sitebggrad_color1',
		'label'       => esc_attr__( 'Background Gradient Color 1', 'knowall' ),
		'description' => esc_attr__( 'Set background color gradient 1', 'knowall' ),
		'section'     => 'ht_sec__styling',
		'default'     => '#ffffff',
		'priority'    => 10,
		'required'  => array(
			array(
				'setting'  => 'ht_setting__sitelayout',
				'operator' => '==',
				'value'    => 'boxed',
			),
			array(
				'setting'  => 'ht_setting__sitebg',
				'operator' => '==',
				'value'    => 'gradient',
			),
		),
		'transport'    => 'postMessage',
	) );


	Kirki::add_field( 'ht_theme', array(
		'type'        => 'slider',
		'settings'    => 'ht_setting__sitebggrad_angle',
		'label'       => esc_attr__( 'Background Gradient Angle', 'knowall' ),
		'description' => esc_attr__( 'Select the gradient angle', 'knowall' ),
		'section'     => 'ht_sec__styling',
		'default'     => '90',
		'priority'    => 10,
		'required'  => array(
			array(
				'setting'  => 'ht_setting__sitelayout',
				'operator' => '==',
				'value'    => 'boxed',
			),
			array(
				'setting'  => 'ht_setting__sitebg',
				'operator' => '==',
				'value'    => 'gradient',
			),
		),
		'transport'    => 'postMessage',
		'choices'      => array(
			'min'  => 0,
			'max'  => 360,
			'step' => 1,
		)
	) );

	Kirki::add_field( 'ht_theme', array(
		'type'        => 'color',
		'settings'    => 'ht_setting__sitebggrad_color2',
		'label'       => esc_attr__( 'Background Gradient Color 2', 'knowall' ),
		'description' => esc_attr__( 'Set background color gradient 2', 'knowall' ),
		'section'     => 'ht_sec__styling',
		'default'     => '#cccccc',
		'priority'    => 10,
		'required'  => array(
			array(
				'setting'  => 'ht_setting__sitelayout',
				'operator' => '==',
				'value'    => 'boxed',
			),
			array(
				'setting'  => 'ht_setting__sitebg',
				'operator' => '==',
				'value'    => 'gradient',
			),
		),
		'transport'    => 'postMessage',
	) );


	/**
	* Theme Typography
	*/
	Kirki::add_section( 'typography_sec', array(
		'title'          => esc_attr__( 'Typography', 'knowall' ),
		'panel'     	=> 'ht_panel__main',
		'priority'       => 1,
		'capability'     => 'edit_theme_options',
	) );



	Kirki::add_field( 'ht_theme', array(
		'type'        => 'typography',
		'settings'    => 'ht_typography_headings',
		'label'       => esc_attr__( 'Headings Font', 'knowall' ),
		'description' => esc_attr__( 'Set the heading typography here', 'knowall' ),
		'section'     => 'typography_sec',
		'default'     => array(
			'font-family'    => 'Roboto',
			'variant' 		 => '700',
			'letter-spacing' => '0',
			'color'          => '#333333',
			'text-transform' => 'none',
		),
		'priority'    => 10,
		'choices' => array(
			'fonts' => array(
				'google',
				'standard' => array(
					'-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"',
				),
			),
		),
		'output' => array(
			array(
				'element' => 'h1, h2, h3, h4, h5, h6',
			),
			
		),
	) );

	Kirki::add_field( 'ht_theme', array(
		'type'        => 'typography',
		'settings'    => 'ht_typography_body',
		'label'       => esc_attr__( 'Body Font', 'knowall' ),
		'description' => esc_attr__( 'Set the body typography here', 'knowall' ),
		'section'     => 'typography_sec',
		'default'     => array(
			'font-family'    => 'Roboto',
			'variant'        => 'regular',
			'font-size'      => '17px',
			'line-height'    => '1.55',
			'letter-spacing' => '0',
			'color'          => '#595959',
		),
		'priority'    => 10,
		'choices' => array(
			'fonts' => array(
				'google',
				'standard' => array(
					'-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"',
				),
			),
		),
		'output'      => array(
			array(
				'element' => 'body, input, optgroup, select, textarea, p',
			),
		),
	) );

	/**
	* Section: Homepage
	*/

	Kirki::add_section( 'ht_sec__homepage', array(
		'title'          => esc_attr__( 'Homepage', 'knowall' ),
		'panel'     	=> 'ht_panel__main',
		'priority'       => 1,
		'capability'     => 'edit_theme_options',
	) );

	Kirki::add_field( 'ht_theme', array(
		'settings'    => 'ht_setting__searchtitle',
		'section'     => 'ht_sec__homepage',
		'type'        => 'text',
		'label'       => esc_attr__( 'Search Title', 'knowall' ),
		'description' => esc_attr__( 'To remove, leave this blank', 'knowall' ),
		'default'     => esc_attr__( 'How can we help?', 'knowall' ),	    
		'priority'    => 10,
	) );

	Kirki::add_field( 'ht_theme', array(
		'settings'    => 'ht_setting__homepagesidebar',
		'section'     => 'ht_sec__homepage',
		'type'        => 'radio-image',
		'label'       => esc_attr__( 'Homepage Sidebar Position', 'knowall' ),
		'description' => esc_attr__( 'Select the sidebar position for the homepage', 'knowall' ),
		'default'     => 'right',
		'priority'    => 10,
		'choices'     => array(
			'off'   => get_template_directory_uri() . '/img/admin/sidebar-off.png',
			'left' => get_template_directory_uri() . '/img/admin/sidebar-left.png',
			'right'  => get_template_directory_uri() . '/img/admin/sidebar-right.png',
		),
	) );

	Kirki::add_field( 'ht_theme', array(
		'settings'    => 'ht_setting__homepagetitle',
		'section'     => 'ht_sec__homepage',
		'type'        => 'text',
		'label'       => esc_attr__( 'Homepage Title', 'knowall' ),
		'description' => esc_attr__( 'To remove, leave this blank', 'knowall' ),
		'default'     => esc_attr__( 'Help Topics', 'knowall' ),	    
		'priority'    => 10,
	) );

	Kirki::add_field( 'ht_theme', array(
		'settings'    => 'ht_setting__kbarchivecols',
		'section'     => 'ht_sec__homepage',
		'type'        => 'radio-image',
		'label'       => esc_attr__( 'Archive Columns', 'knowall' ),
		'description' => esc_attr__( 'Select the number of columns for the knowledge base categories', 'knowall' ),
		'default'     => '2',
		'priority'    => 10,
		'choices'     => array(
			'1' => get_template_directory_uri() . '/img/admin/1cols.png',
			'2' => get_template_directory_uri() . '/img/admin/2cols.png',
			'3'  => get_template_directory_uri() . '/img/admin/3cols.png',
			'4'   => get_template_directory_uri() . '/img/admin/4cols.png',
		),
	));

	Kirki::add_field( 'ht_theme', array(
		'settings'    => 'ht_setting__kbarchivecolsjustify',
		'type'        => 'toggle',
		'section'     => 'ht_sec__homepage',
		'label'       => __( 'Justify Columns', 'knowall' ),
		'description' => __( 'Centers last row of categories.', 'knowall' ),
		'default'     => '0',
		'priority'    => 10,
	) );

	Kirki::add_field( 'ht_theme', array(
		'settings'    => 'ht_setting__kbarchivehideemptycats',
		'section'     => 'ht_sec__homepage',
		'type'        => 'toggle',
		'label'       => esc_attr__( 'Hide empty categories', 'knowall' ),   
		'description' => esc_attr__( 'Empty categories are hidden', 'knowall' ),
		'default'     => '0',
		'priority'    => 10,
	) );

	Kirki::add_field( 'ht_theme', array(
		'settings'    => 'ht_setting__kbarchivestyle',
		'section'     => 'ht_sec__homepage',
		'type'        => 'radio-image',
		'label'       => esc_attr__( 'Archive Style', 'knowall' ),
		'description' => esc_attr__( 'Select the style of your categories', 'knowall' ),
		'default'     => '7',
		'priority'    => 10,
		//do not add any more choices < 7, as these will be overwritten on *_switch_theme (see ht_knowall_setup_customizer_options_upgrade)
		'choices'     => array(
			'7'   => get_template_directory_uri() . '/img/admin/archive2.png',
			'8' 	=> get_template_directory_uri() . '/img/admin/archive4.png',
			'9'  	=> get_template_directory_uri() . '/img/admin/archive6.png',
		),
	) );

	Kirki::add_field( 'ht_theme', array(
		'settings'    => 'ht_setting__kbarchiveboxed',
		'type'        => 'toggle',
		'section'     => 'ht_sec__homepage',
		'label'       => __( 'Boxed Categories?', 'knowall' ),
		'description' => __( 'Enable boxed style of categories', 'knowall' ),
		'default'     => '0',
		'priority'    => 10,
	) );

	Kirki::add_field( 'ht_theme', array(
		'settings'    => 'ht_setting__kbarchivestyleborder',
		'section'     => 'ht_sec__homepage',
		'type'        => 'toggle',
		'label'       => __( 'Category Border Divider', 'knowall' ),   
		'description' => __( 'Enable a border at the bottom of categories', 'knowall' ),
		'default'     => '1',
		'priority'    => 10,
	) );

	Kirki::add_field( 'ht_theme', array(
		'settings'    => 'ht_setting__kbarchivecatdesc',
		'type'        => 'toggle',
		'section'     => 'ht_sec__homepage',
		'label'       => __( 'Show Category Descriptions?', 'knowall' ),	
		'description' => __( 'Select to show category descriptions.', 'knowall' ),
		'default'     => '0',
		'priority'    => 10,
	) );

	Kirki::add_field( 'ht_theme', array(
		'settings'    => 'ht_setting__kbarchivecatarticles',
		'type'        => 'toggle',
		'section'     => 'ht_sec__homepage',
		'label'       => __( 'Display Articles Beneath Categories?', 'knowall' ),	
		'description' => __( 'Select to show category articles.', 'knowall' ),
		'default'     => '0',
		'priority'    => 10,
	) );

	Kirki::add_field( 'ht_theme', array(
		'type'        => 'toggle',
		'settings'    => 'ht_setting__kbarchivecatarticles_viewall',
		'label'       => __( 'Display View All Link', 'knowall' ),
		'description' => __( 'Will show a view all link when enabled', 'knowall' ),
		'section'     => 'ht_sec__homepage',
		'default'     => '0',
		'active_callback'    => array(
			array(
				'setting'  => 'ht_setting__kbarchivecatarticles',
				'operator' => '==',
				'value'    => true,
			),
		),
	) );

	Kirki::add_field( 'ht_theme', array(
		'type'        => 'slider',
		'settings'    => 'ht_setting__kbarchivecatarticles_num',
		'label'       => __( 'Number of articles to display', 'knowall' ),
		'section'     => 'ht_sec__homepage',
		'default'     => 5,
		'choices'     => array(
			'min'  => '3',
			'max'  => '10',
			'step' => '1',
		),
		'active_callback'    => array(
			array(
				'setting'  => 'ht_setting__kbarchivecatarticles',
				'operator' => '==',
				'value'    => true,
			),
		),
	) );
	
	Kirki::add_field( 'ht_theme', array(
		'type'        => 'slider',
		'settings'    => 'ht_setting__categoryiconsize',
		'label'       => __( 'Category Icon Size', 'knowall' ),
		'section'     => 'ht_sec__homepage',
		'default'     => 35,
		'choices'     => array(
			'min'  => '30',
			'max'  => '100',
			'step' => '1',
		),
		'transport'    => 'refresh',
		'output'      => array(
			array(
				'element'  => '.hkb-category .hkb-category__iconwrap, .ht-categoryheader .hkb-category__iconwrap',
				'property' => 'flex-basis',
				'units'    => 'px',
			),
			array(
				'element'  => '.hkb-category .hkb-category__iconwrap, .ht-categoryheader .hkb-category__iconwrap',
				'property' => 'min-width',
				'units'    => 'px',
			),
			array(
				'element'  => '.hkb-category .hkb-category__iconwrap img, .ht-categoryheader .hkb-category__iconwrap img',
				'property' => 'max-width',
				'units'    => 'px',				
			),
			array(
				'element'  => '.hkb-category .hkb-category__iconwrap img, .ht-categoryheader .hkb-category__iconwrap img, .hkb-category .hkb-category__iconwrap, .ht-categoryheader .hkb-category__iconwrap, .ht-categoryheader .hkb-category__iconwrap svg',
				'property' => 'max-height',
				'units'    => 'px',				
			),
		),
		
		'js_vars'     => array(
			array(
				'element'  => '.hkb-category .hkb-category__iconwrap, .ht-categoryheader .hkb-category__iconwrap',
				'function' => 'style',
				'property' => 'flex-basis',
				'units'    => 'px',
			),
			array(
				'element'  => '.hkb-category .hkb-category__iconwrap, .ht-categoryheader .hkb-category__iconwrap',
				'function' => 'style',
				'property' => 'min-width',
				'units'    => 'px',
			),              
			array(
				'element'  => '.hkb-category .hkb-category__iconwrap img, .ht-categoryheader .hkb-category__iconwrap img',
				'function' => 'style',
				'property' => 'max-width',
				'units'    => 'px',
			),
			array(
				'element'  => '.hkb-category .hkb-category__iconwrap img, .ht-categoryheader .hkb-category__iconwrap img, .hkb-category .hkb-category__iconwrap, .ht-categoryheader .hkb-category__iconwrap, .ht-categoryheader .hkb-category__iconwrap svg',
				'function' => 'style',
				'property' => 'max-height',
				'units'    => 'px',
			),
		),

	));


	/**
	* Section: Category Settings
	*/
	Kirki::add_section( 'ht_sec__acategory', array(
		'title'          => esc_attr__( 'Category Settings', 'knowall' ),
		'panel'     	=> 'ht_panel__main',
		'priority'       => 1,
		'capability'     => 'edit_theme_options',
	) );

	/**
	* Setting: Category Sidebar
	*/
	Kirki::add_field( 'ht_theme', array(
		'settings'    => 'ht_setting__acategorysidebar',
		'section'     => 'ht_sec__acategory',
		'type'        => 'radio-image',		
		'label'       => esc_attr__( 'Category Sidebar Position', 'knowall' ),
		'description' => esc_attr__( 'Select the sidebar position for the category pages', 'knowall' ),
		'default'     => 'right',
		'priority'    => 10,
		'choices'     => array(
			'off'   => get_template_directory_uri() . '/img/admin/sidebar-off.png',
			'left' => get_template_directory_uri() . '/img/admin/sidebar-left.png',
			'right'  => get_template_directory_uri() . '/img/admin/sidebar-right.png',
		),
	) );

	/**
	* Section: Article
	*/
	Kirki::add_section( 'ht_sec__article', array(
		'title'          => esc_attr__( 'Article Settings', 'knowall' ),
		'panel'     	=> 'ht_panel__main',
		'priority'       => 1,
		'capability'     => 'edit_theme_options',
	) );


	Kirki::add_field( 'ht_theme', array(
		'settings'    => 'ht_setting__articlesidebar',
		'section'     => 'ht_sec__article',
		'type'        => 'radio-image',		
		'label'       => esc_attr__( 'Article Sidebar Position', 'knowall' ),
		'description' => esc_attr__( 'Select the sidebar position for your articles', 'knowall' ),
		'default'     => 'left',
		'priority'    => 10,
		'choices'     => array(
			'off'   => get_template_directory_uri() . '/img/admin/sidebar-off.png',
			'left' => get_template_directory_uri() . '/img/admin/sidebar-left.png',
			'right'  => get_template_directory_uri() . '/img/admin/sidebar-right.png',
		),
	) );

	Kirki::add_field( 'ht_theme', array(
		'settings'    => 'ht_setting__articlesidebar_stick',
		'section'     => 'ht_sec__article',
		'type'        => 'toggle',
		'label'       => esc_attr__( 'Sticky Sidebar', 'knowall' ),   
		'description' => esc_attr__( 'Enable the sticky sidebar', 'knowall' ),
		'default'     => '1',
		'priority'    => 10,
	) );

	Kirki::add_field( 'ht_theme', array(
		'settings'    => 'ht_setting__articlerelated',
		'section'     => 'ht_sec__article',
		'type'        => 'toggle',
		'label'       => esc_attr__( 'Show Related Articles', 'knowall' ),
		'description' => esc_attr__( 'Show related articles at the end of the article', 'knowall' ),
		'default'     => '1',
		'priority'    => 10,
	) );

	Kirki::add_field( 'ht_theme', array(
		'settings'    => 'ht_setting__articleexpandedattachments',
		'section'     => 'ht_sec__article',
		'type'        => 'toggle',
		'label'       => esc_attr__( 'Expand Article Attachments', 'knowall' ),
		'description' => esc_attr__( 'Article attachments box already expanded', 'knowall' ),
		'default'     => '0',
		'priority'    => 10,
	) );

	Kirki::add_field( 'ht_theme', array(
		'settings'    => 'ht_setting__articleauthor',
		'section'     => 'ht_sec__article',
		'type'        => 'toggle',
		'label'       => esc_attr__( 'Show Author Bio', 'knowall' ),
		'description' => esc_attr__( 'Display the author bio block at the end of the article', 'knowall' ),   
		'default'     => '0',
		'priority'    => 10,
	) );

	Kirki::add_field( 'ht_theme', array(
		'settings'    => 'ht_setting__articlemodified',
		'section'     => 'ht_sec__article',
		'type'        => 'toggle',
		'label'       => esc_attr__( 'Show Last Modified', 'knowall' ),
		'description' => esc_attr__( 'Display the last modified date at the end of the article', 'knowall' ),   
		'default'     => '1',
		'priority'    => 10,
	) );

	Kirki::add_field( 'ht_theme', array(
		'settings'    => 'ht_setting__articlecomments',
		'section'     => 'ht_sec__article',
		'type'        => 'toggle',
		'label'       => esc_attr__( 'Enable Comments?', 'knowall' ),
		'description' => esc_attr__( 'Enable article comments', 'knowall' ),   
		'default'     => '0',
		'priority'    => 10,
	) );


	/**
	* Section: Page Settings
	*/

	Kirki::add_section( 'ht_sec__page', array(
		'title'          => esc_attr__( 'Page', 'knowall' ),
		'panel'     	=> 'ht_panel__main',
		'priority'       => 1,
		'capability'     => 'edit_theme_options',
	) );

	Kirki::add_field( 'ht_theme', array(
		'settings'    => 'ht_setting__pagesidebar',
		'section'     => 'ht_sec__page',
		'type'        => 'radio-image',		
		'label'       => esc_attr__( 'Page Sidebar Position', 'knowall' ),
		'description' => esc_attr__( 'Select the sidebar position for your pages', 'knowall' ),
		'default'     => 'off',
		'priority'    => 10,
		'choices'     => array(
			'off'   => get_template_directory_uri() . '/img/admin/sidebar-off.png',
			'left' => get_template_directory_uri() . '/img/admin/sidebar-left.png',
			'right'  => get_template_directory_uri() . '/img/admin/sidebar-right.png',
		),
	) );


	/**
	* Section: Blog
	*/

	if( apply_filters( 'ht_knowall_posts_functionality', false ) ){
		Kirki::add_section( 'ht_sec__blog', array(
			'title'          => esc_attr__( 'Blog', 'knowall' ),
			'panel'     	=> 'ht_panel__main',
			'priority'       => 1,
			'capability'     => 'edit_theme_options',
		) );

		Kirki::add_field( 'ht_theme', array(
			'settings'    => 'ht_setting__blogsidebar',
			'section'     => 'ht_sec__blog',
			'type'        => 'radio-image',		
			'label'       => esc_attr__( 'Blog Sidebar Position', 'knowall' ),
			'description' => esc_attr__( 'Select the sidebar position for your blog', 'knowall' ),
			'default'     => 'right',
			'priority'    => 10,
			'choices'     => array(
				'off'   => get_template_directory_uri() . '/img/admin/sidebar-off.png',
				'left' => get_template_directory_uri() . '/img/admin/sidebar-left.png',
				'right'  => get_template_directory_uri() . '/img/admin/sidebar-right.png',
			),
		) );
	}


	/**
	* Section: Theme Custom CSS
	*/
	Kirki::add_section( 'custom_css_sec', array(
		'title'          => esc_attr__( 'Custom CSS', 'knowall' ),
		'panel'     	=> 'ht_panel__main',
		'priority'       => 1,
		'capability'     => 'edit_theme_options',
	) );


	Kirki::add_field( 'ht_theme', array(
		'type'        => 'code',
		'settings'    => 'custom_css',
		'label'       => esc_attr__( 'Custom CSS', 'knowall' ),
		'tooltip'        => esc_attr__( 'You can add custom CSS using this customizer option', 'knowall' ),
		'description' => esc_attr__( 'Custom CSS you enter here will be used to customize every page in the theme', 'knowall' ),
		'section'     => 'custom_css_sec',
		'default'     => '',
		'priority'    => 10,
		'choices'     => array(
			'language' => 'css',
			'theme'    => 'material',
			'height'   => 250,
		),
	) );

}


/**
 * Build a background-gradient style for CSS
 *
 * @param $color_1      hex color value
 * @param $color_2      hex color value
 *
 * @return string       CSS definition
 */
function ht_kirki_build_gradients( $angle, $color_1, $color_2 ) {

	$styles  = 'background:'.$color_1.';';
	$styles .= 'background:linear-gradient('.$angle.'deg,'.$color_1.' 0%,'.$color_2.' 100%);';

	return $styles;

}

/**
 * Convertt hex to RGBA
 *
	*/
function ht_kirki_hex2rgb( $colour ) {
	if ( $colour[0] == '#' ) {
		$colour = substr( $colour, 1 );
	}
	if ( strlen( $colour ) == 6 ) {
		list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
	} elseif ( strlen( $colour ) == 3 ) {
		list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
	} else {
		return false;
	}
	$r = hexdec( $r );
	$g = hexdec( $g );
	$b = hexdec( $b );
	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}



/**
 * Build and enqueue the complete CSS for more specific controls
 */
add_filter( 'kirki_ht_theme_dynamic_css', function( $css ) {
		//$css = '';

	// Site BG (Boxed Width)
	$site_layout_type = get_theme_mod( 'ht_setting__sitelayout', 'wide' );
	$site_background_type = get_theme_mod( 'ht_setting__sitebg', 'color' );
	
	if ('boxed'==$site_layout_type) {
		if ('color'==$site_background_type) {
			$bg_color = get_theme_mod( 'ht_setting__sitebgcolor', '#fff' );
			//$css .= 'body {background-color: '. $bg_color . ' }';
		} elseif ('image'==$site_background_type) {		
			$bg_image = get_theme_mod( 'ht_setting__sitebgimg_image', '' );
			$bg_image_color = get_theme_mod( 'ht_setting__sitebgimg_color', '' );
			$bg_image_size = get_theme_mod( 'ht_setting__sitebgimg_size', 'cover' );
			$bg_image_attach = get_theme_mod( 'ht_setting__sitebgimg_attach', 'fixed' );
			$bg_image_repeat = get_theme_mod( 'ht_setting__sitebgimg_repeat', 'no-repeat' );
			$bg_image_position = get_theme_mod( 'ht_setting__sitebgimg_position', 'center center' );
			$bg_image_position = str_replace( '-', ' ', $bg_image_position );
			//if (''!=$bg_image) {
				//$css .= 'body { 
				//	background-color: '. $bg_image_color . ';
				//	background-image: url("'. $bg_image . '");
				//	background-size: '. $bg_image_size . ';
				//	background-attachment: '. $bg_image_attach . ';
				//	background-repeat: '. $bg_image_repeat . ';
				//	background-position: '. $bg_image_position . ';
				//}';
			//}		
		} elseif ('gradient'==$site_background_type) {
			$angle = get_theme_mod( 'ht_setting__sitebggrad_angle', '90' );
			$color_1 = get_theme_mod( 'ht_setting__sitebggrad_color1', '#fff' );
			$color_2 = get_theme_mod( 'ht_setting__sitebggrad_color2', '#ccc' );
			$css .= 'body {'.ht_kirki_build_gradients( $angle, $color_1, $color_2 ).'}';
		}
	}

	// Boxed width shadow
	$siteboxshadow = get_theme_mod( 'ht_setting__siteboxshadow', '0' );
	if ($siteboxshadow == 1) {
		$css .= '.ht-sitecontainer--boxed { box-shadow: 0px 0px 80px rgba(0,0,0,0.05); }';
	} elseif ($siteboxshadow == 2) {
		$css .= '.ht-sitecontainer--boxed { box-shadow: 0px 0px 80px rgba(0,0,0,0.1); }';
	} elseif ($siteboxshadow == 3) {
		$css .= '.ht-sitecontainer--boxed { box-shadow: 0px 0px 80px rgba(0,0,0,0.15); }';
	} elseif ($siteboxshadow == 4) {
		$css .= '.ht-sitecontainer--boxed { box-shadow: 0px 0px 80px rgba(0,0,0,0.2); }';
	} elseif ($siteboxshadow == 5) {
		$css .= '.ht-sitecontainer--boxed { box-shadow: 0px 0px 80px rgba(0,0,0,0.25); }';
	}

	// Header BG
	$header_background_type = get_theme_mod( 'ht_setting__headerbg', 'color' );
	
	if('color'==$header_background_type){
		$bg_color = get_theme_mod( 'ht_setting__headerbgcolor', '#00b4b3' );
		//$css .= '.site-header {background-color: '. $bg_color . ' }';
	} elseif('image'==$header_background_type){
		$bg_image = get_theme_mod( 'ht_setting__headerbgimg_image', '' );
		$bg_image_color = get_theme_mod( 'ht_setting__headerbgimg_color', '#00b4b3' );
		$bg_image_size = get_theme_mod( 'ht_setting__headerbgimg_size', 'cover' );
		$bg_image_attach = get_theme_mod( 'ht_setting__headerbgimg_attach', 'fixed' );
		$bg_image_repeat = get_theme_mod( 'ht_setting__headerbgimg_repeat', 'no-repeat' );
		$bg_image_position = get_theme_mod( 'ht_setting__headerbgimg_position', 'center center' );
		$bg_image_position = str_replace( '-', ' ', $bg_image_position );

		//$css .= '.site-header {background-color: '. $bg_image_color . '; }';
		//if(''!=$bg_image){
			//$css .= '.site-header { 
			//		background-image: url("'. $bg_image . '");
			//		background-size: '. $bg_image_size . ';
			//		background-attachment: '. $bg_image_attach . ';
			//		background-repeat: '. $bg_image_repeat . ';
			//		background-position: '. $bg_image_position . ';
			//	}';
		//}		
	} elseif('gradient'==$header_background_type){
		$angle = get_theme_mod( 'ht_setting__headerbggrad_angle', '90' );
		$color_1 = get_theme_mod( 'ht_setting__headerbggrad_color1', '#00b4b3' );
		$color_2 = get_theme_mod( 'ht_setting__headerbggrad_color2', '#c75552' );
		$css .= '.site-header {'.ht_kirki_build_gradients( $angle, $color_1, $color_2 ).'}';
	}
	// Header Font Color
	$ht_setting__headerfontcolor = get_theme_mod( 'ht_setting__headerfontcolor', '#ffffff' );
	// Remove #
	$ht_setting__headerfontcolor = ltrim($ht_setting__headerfontcolor, '#');
	$css .= '.nav-header > ul > li.menu-item-has-children > a::after {background-image: url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 34.1 19\' fill=\'%23'. $ht_setting__headerfontcolor .'\'%3E%3Cpath d=\'M17 19c-0.5 0-1-0.2-1.4-0.6L0.6 3.4c-0.8-0.8-0.8-2 0-2.8 0.8-0.8 2-0.8 2.8 0L17 14.2 30.7 0.6c0.8-0.8 2-0.8 2.8 0 0.8 0.8 0.8 2 0 2.8L18.4 18.4C18 18.8 17.5 19 17 19z\'/%3E%3C/svg%3E");}';

	// Site Width
	$ht_setting__sitewidth = get_theme_mod( 'ht_setting__sitewidth', '1000' );
	$css .= '.ht-container, .ht-sitecontainer--boxed { max-width: '. $ht_setting__sitewidth .'px }';
	
	$ht_setting__kbarchivestyleborder = get_theme_mod( 'ht_setting__kbarchivestyleborder', '1' );
	if ( $ht_setting__kbarchivestyleborder == '1' ) {
		$css .= '.hkb-category .hkb-category__link { border-bottom: 1px solid #e6e6e6; } .hkb-category.hkb-category--witharticles { border-bottom: 1px solid #e6e6e6; }';
	}

	// TOC Widget
	$toc_widget_color = get_theme_mod( 'ht_setting__linkcolor', '#00b4b3' );
	$toc_widget_color = ht_kirki_hex2rgb($toc_widget_color);
	$css .= '.hkb_widget_toc ol li.active > a { background: rgba( '. $toc_widget_color['red'] .' ,'. $toc_widget_color['green'] .', '. $toc_widget_color['blue'] .', 0.8); }';

	// Custom CSS
	$css .= get_theme_mod( 'custom_css' );

	return $css;
});


function ht_theme_customizer_js_enqueue(){
	$customizer_js_file_src = (KNOWALL_DEBUG_SCRIPTS) ?  get_template_directory_uri().'/js/customizer.js' :  get_template_directory_uri().'/js/customizer.min.js';
	wp_enqueue_script( 
		'ht-theme-customizer',
		$customizer_js_file_src,
		array( 'jquery', 'customize-preview', 'customize-controls' ),
		get_ht_theme_version(),
		true
	);

	//header background
	wp_localize_script( 'ht-theme-customizer', 'htHeaderBgSettings',
	                   array(
	                   	'bgGradient1' => get_theme_mod( 'ht_setting__headerbggrad_color1', '#00b4b3' ),
	                   	'bgGradient2' => get_theme_mod( 'ht_setting__headerbggrad_color2', '#c75552' ),
	                   	'bgGradientAngle' => get_theme_mod( 'ht_setting__headerbggrad_angle', '90' ),
	                   )
	                 );

	//body background
	wp_localize_script( 'ht-theme-customizer', 'htBodyBgSettings',
	                   array(
	                   	'bgGradient1' => get_theme_mod( 'ht_setting__sitebggrad_color1', '#fff' ),
	                   	'bgGradient2' => get_theme_mod( 'ht_setting__sitebggrad_color2', '#ccc' ),
	                   	'bgGradientAngle' => get_theme_mod( 'ht_setting__sitebggrad_angle', '90' ),
	                   )
	                 );
}
add_action( 'customize_controls_init', 'ht_theme_customizer_js_enqueue' );


// Legacy support for Classic Editor
//add_filter('tiny_mce_before_init','ht_knowall_tiny_mce_dynamic_styles');
function ht_knowall_tiny_mce_dynamic_styles( $mceInit ) {

	$ht_typography_headings = get_theme_mod( 'ht_typography_headings', array( 'font-family' => 'Roboto' ) );
	$ht_typography_body = get_theme_mod( 'ht_typography_body', array( 'font-family' => 'Roboto' ) );

  $styles = 'body.mce-content-body { font-family: '. $ht_typography_body['font-family'] .'; } body.mce-content-body h1, body.mce-content-body h2, body.mce-content-body h3, body.mce-content-body h4, body.mce-content-body h5, body.mce-content-body h6 { font-family: '. $ht_typography_headings['font-family'] .'; }';

  if ( isset( $mceInit['content_style'] ) ) {
      $mceInit['content_style'] .= ' ' . $styles . ' ';
  } else {
      $mceInit['content_style'] = $styles . ' ';
  }
  return $mceInit;

}
