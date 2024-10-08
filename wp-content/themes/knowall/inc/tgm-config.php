<?php
/**
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Ht Theme
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 */
require_once get_template_directory() . '/inc/tgm/class-tgm-plugin-activation.php';

//@todo query this on hook admin_init vs tgmpa_register (wizard doesn't work with tgmpa_register)
add_action( 'admin_init', 'ht_knowall_register_required_plugins', 5 );
add_action( 'tgmpa_register', 'ht_knowall_register_required_plugins', 5 );

/**
* Register the required plugins for this theme.
*
*
* This function is hooked into tgmpa_init, which is fired within the
* TGM_Plugin_Activation class constructor.
*/
function ht_knowall_register_required_plugins() {

    /*
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array();

    //Knowledge Base
    if( apply_filters( 'ht_knowall_allow_hkb_install', true ) ){
      $plugins[] = array(
                    'name'               => 'Heroic Knowledge Base', 
                    'slug'               => 'ht-knowledge-base', 
                    'source'             => get_template_directory() . '/inc/tgm/plugins/ht-knowledge-base-v3.10.4.0-packaged.zip', 
                    'required'           => true, 
                    'version'            => '3.10.4', 
                    'force_activation'   => apply_filters( 'ht_heroic_knowledge_base_plugin_force_activation', true ), 
                    'force_deactivation' => apply_filters( 'ht_heroic_knowledge_base_plugin_force_deactivation', false ),
                    'external_url'       => '', 
                    'is_callable'        => '', 
                    'order'              => 0,
                  );
    }

    //Blocks
    if( apply_filters( 'ht_knowall_allow_heroic_blocks_install', true ) ){
      $plugins[] = array(
                    'name'               => 'Heroic Blocks', 
                    'slug'               => 'heroic-blocks', 
                    'source'             => get_template_directory() . '/inc/tgm/plugins/heroic-blocks-v1.2.4.0.zip', 
                    'required'           => true, 
                    'version'            => '1.2.4', 
                    'force_activation'   => apply_filters( 'ht_heroic_blocks_plugin_force_activation', true ), 
                    'force_deactivation' => apply_filters( 'ht_heroic_blocks_plugin_force_deactivation', false ), 
                    'external_url'       => '', 
                    'is_callable'        => '',
                    'order'              => 1, 
                  );
    }

    //Integrations (pro only)
    if( apply_filters( 'ht_knowall_allow_integrations_install', false ) ){
      $plugins[] = array(
                    'name'               => 'Heroic Knowledge Base Integrations', 
                    'slug'               => 'ht-kb-integrations', 
                    'source'             => get_template_directory() . '/inc/tgm/plugins/ht-kb-integrations-v1.1.2.0.zip', 
                    'required'           => true, 
                    'version'            => '1.1.2', 
                    'force_activation'   => apply_filters( 'ht_kb_integrations_plugin_force_activation', true ), 
                    'force_deactivation' => apply_filters( 'ht_kb_integrations_plugin_force_deactivation', false ), 
                    'external_url'       => '', 
                    'is_callable'        => '', 
                    'order'              => 2,
                  );
    }

    //Analytics (plus and pro only)
    if( apply_filters( 'ht_knowall_allow_analytics_plugin_install', false ) ){
      $plugins[] = array(
                    'name'               => 'Heroic Knowledge Base Analytics Pro', 
                    'slug'               => 'ht-kb-analytics-pro', 
                    'source'             => get_template_directory() . '/inc/tgm/plugins/ht-kb-analytics-pro-v1.0.0.0.zip', 
                    'required'           => true, 
                    'version'            => '1.0.0', 
                    'force_activation'   => apply_filters( 'ht_kb_analytics_plugin_force_activation', true ), 
                    'force_deactivation' => apply_filters( 'ht_kb_analytics_plugin_force_deactivation', false ), 
                    'external_url'       => '', 
                    'is_callable'        => '', 
                    'order'              => 3,
                  );
    }    

    //determine if the gravity forms directory exists
    $plugins_url = plugins_url();
    $plugins_path = parse_url($plugins_url);
    $gravityforms_dir = untrailingslashit( ABSPATH ). $plugins_path['path'] . DIRECTORY_SEPARATOR .'gravityforms'. DIRECTORY_SEPARATOR ;
    $gravityforms_dir_exists = file_exists($gravityforms_dir);

    //Gravity Forms
    if( apply_filters( 'ht_knowall_allow_gravityforms_install', true ) && $gravityforms_dir_exists ){
      $plugins[] = array(
                    'name'               => 'Gravity Forms', 
                    'slug'               => 'gravityforms', 
                    'required'           => false, 
                    'version'            => '2.2.0', 
                    'force_activation'   => apply_filters( 'ht_gravityforms_plugin_force_activation', false ), 
                    'force_deactivation' => apply_filters( 'ht_gravityforms_plugin_force_deactivation', false ), 
                    'external_url'       => '', 
                    'is_callable'        => '', 
                    'order'              => 4,
                  );
    }

    //Heroic Glossary
    if( apply_filters( 'ht_knowall_allow_heroic_glossary_install', true ) ){
      $plugins[] = array(
                    'name'               => 'Heroic Glossary', 
                    'slug'               => 'heroic-glossary', 
                    'required'           => false, 
                    'version'            => '1.1.0', 
                    'force_activation'   => apply_filters( 'ht_glossary_plugin_force_activation', false ), 
                    'force_deactivation' => apply_filters( 'ht_glossary_plugin_force_deactivation', false ), 
                    'external_url'       => '', 
                    'is_callable'        => '', 
                    'order'              => 5,
                  );
    }

    //Heroic ToC
    if( apply_filters( 'ht_knowall_allow_heroic_toc_install', true ) ){
      $plugins[] = array(
                    'name'               => 'Heroic Table of Contents', 
                    'slug'               => 'heroic-table-of-contents', 
                    'required'           => false, 
                    'version'            => '1.0.2', 
                    'force_activation'   => apply_filters( 'ht_toc_plugin_force_activation', false ), 
                    'force_deactivation' => apply_filters( 'ht_toc_plugin_force_deactivation', false ), 
                    'external_url'       => '', 
                    'is_callable'        => '',
                    'order'              => 6, 
                  );
    }
    

    /*
   * Array of configuration settings. Amend each line as needed.
   *
   * TGMPA will start providing localized text strings soon. If you already have translations of our standard
   * strings available, please help us make TGMPA even better by giving us access to these translations or by
   * sending in a pull-request with .po file(s) with the translations.
   *
   * Only uncomment the strings in the config array if you want to customize the strings.
   */
  $config = array(
    'id'           => 'ht-theme',                 // Unique ID for hashing notices for multiple instances of TGMPA.
    'default_path' => '',                      // Default absolute path to bundled plugins.
    'menu'         => 'tgmpa-install-plugins', // Menu slug.
    'parent_slug'  => 'themes.php',            // Parent menu slug.
    'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
    'has_notices'  => false,                    // Show admin notices or not.
    'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
    'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
    'is_automatic' => false,                   // Automatically activate plugins after installation or not.
    'message'      => '',                      // Message to output right before the plugins table.

    /*
    'strings'      => array(
      'page_title'                      => __( 'Install Required Plugins', 'knowall' ),
      'menu_title'                      => __( 'Install Plugins', 'knowall' ),
      /* translators: %s: plugin name. * /
      'installing'                      => __( 'Installing Plugin: %s', 'knowall' ),
      /* translators: %s: plugin name. * /
      'updating'                        => __( 'Updating Plugin: %s', 'knowall' ),
      'oops'                            => __( 'Something went wrong with the plugin API.', 'knowall' ),
      'notice_can_install_required'     => _n_noop(
        /* translators: 1: plugin name(s). * /
        'This theme requires the following plugin: %1$s.',
        'This theme requires the following plugins: %1$s.',
        'knowall'
      ),
      'notice_can_install_recommended'  => _n_noop(
        /* translators: 1: plugin name(s). * /
        'This theme recommends the following plugin: %1$s.',
        'This theme recommends the following plugins: %1$s.',
        'knowall'
      ),
      'notice_ask_to_update'            => _n_noop(
        /* translators: 1: plugin name(s). * /
        'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
        'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
        'knowall'
      ),
      'notice_ask_to_update_maybe'      => _n_noop(
        /* translators: 1: plugin name(s). * /
        'There is an update available for: %1$s.',
        'There are updates available for the following plugins: %1$s.',
        'knowall'
      ),
      'notice_can_activate_required'    => _n_noop(
        /* translators: 1: plugin name(s). * /
        'The following required plugin is currently inactive: %1$s.',
        'The following required plugins are currently inactive: %1$s.',
        'knowall'
      ),
      'notice_can_activate_recommended' => _n_noop(
        /* translators: 1: plugin name(s). * /
        'The following recommended plugin is currently inactive: %1$s.',
        'The following recommended plugins are currently inactive: %1$s.',
        'knowall'
      ),
      'install_link'                    => _n_noop(
        'Begin installing plugin',
        'Begin installing plugins',
        'knowall'
      ),
      'update_link'             => _n_noop(
        'Begin updating plugin',
        'Begin updating plugins',
        'knowall'
      ),
      'activate_link'                   => _n_noop(
        'Begin activating plugin',
        'Begin activating plugins',
        'knowall'
      ),
      'return'                          => __( 'Return to Required Plugins Installer', 'knowall' ),
      'plugin_activated'                => __( 'Plugin activated successfully.', 'knowall' ),
      'activated_successfully'          => __( 'The following plugin was activated successfully:', 'knowall' ),
      /* translators: 1: plugin name. * /
      'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'knowall' ),
      /* translators: 1: plugin name. * /
      'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'knowall' ),
      /* translators: 1: dashboard link. * /
      'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'knowall' ),
      'dismiss'                         => __( 'Dismiss this notice', 'knowall' ),
      'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'knowall' ),
      'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'knowall' ),

      'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
    ),
    */
  );

    tgmpa( $plugins, $config );

}


//add filter to check knowall license version and allow selective install of integrations
//note this is deliberately left easy to override with another filter for environments where it is not possible to check the license
add_filter('ht_knowall_allow_integrations_install', 'ht_knowall_allow_integrations_install_check_license_price_id', 10);

function ht_knowall_allow_integrations_install_check_license_price_id($state){
  $knowall_license_price_id = trim( get_option( 'knowall_license_price_id', '' ) );

  $pro_price_ids = array( '3', '5', '8', '9' );

  if( $knowall_license_price_id && in_array( $knowall_license_price_id, $pro_price_ids ) ){
    return true;
  } else {
    return $state;
  }
}


//add filter to check knowall license version and allow selective install of analytics plugin
//note this is deliberately left easy to override with another filter for environments where it is not possible to check the license
add_filter('ht_knowall_allow_analytics_plugin_install', 'ht_knowall_allow_analytics_plugin_install_check_license_price_id', 10);

function ht_knowall_allow_analytics_plugin_install_check_license_price_id($state){
  $knowall_license_price_id = trim( get_option( 'knowall_license_price_id', '' ) );

  $pro_and_plus_price_ids = array( '2', '3', '4', '5', '7', '8', '9' );

  if( $knowall_license_price_id && in_array( $knowall_license_price_id, $pro_and_plus_price_ids ) ){
    return true;
  } else {
    return $state;
  }
}
