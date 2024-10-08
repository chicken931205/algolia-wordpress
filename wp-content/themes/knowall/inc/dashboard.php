<?php

/*
* KnowAll Dashboard
*
*/

define( 'HT_KNOWALL_SETTINGS_GROUP_KEY', 'ht-knowall-settings-group' ); 
define( 'HT_KNOWALL_LICENSE_KEY_OPTION_KEY', '_ht_knowall_theme_license' ); 


if( ! class_exists( 'HT_KnowAll_Dashboard' ) ){

    class HT_KnowAll_Dashboard {

        function __construct(){

            //@todo - decide on if we want to keep the dashboard

            //register the settings
            //add_action( 'admin_init', array( $this, 'ht_knowall_register_settings' ) );

            //add menu page
            //add_action( 'admin_menu', array( $this, 'ht_knowall_register_dashboard_page' ) );

            

        }

        function ht_knowall_register_dashboard_page() {
            add_menu_page(
                            __( 'KnowAll Theme Options', 'knowall' ),
                            __( 'KnowAll', 'knowall' ),
                            'manage_options',
                            'knowall-dash',
                            array($this, 'ht_knowall_display_dashboard'),
                            plugins_url( 'myplugin/images/icon.png' ),
                            3
                        );
        }

        function ht_knowall_display_dashboard(){
            include('dashboard/dashboard-main.php');
        }

        function ht_knowall_register_settings(){
            register_setting( HT_KNOWALL_SETTINGS_GROUP_KEY, HT_KNOWALL_LICENSE_KEY_OPTION_KEY );
        }






    }
}


if( class_exists( 'HT_KnowAll_Dashboard' ) ){
    $ht_knowall_dashboard_init = new HT_KnowAll_Dashboard();
    
}