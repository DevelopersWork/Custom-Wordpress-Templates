<?php
/*
Plugin Name: Plugin Deploy
Version: 0.0.1
Description: Nothing much for now
Author: Developers@Work
Author URI: 
Plugin URI: 

Copyright 2022  Developers@Work
*/

/*
Credits: 
    - https://wordpress.stackexchange.com/questions/301931/how-to-install-and-activate-a-plugin-via-an-external-php-script
*/

require_once( ABSPATH . 'wp-load.php' );
require_once( ABSPATH . 'wp-admin/includes/admin.php' );
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
require_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
require_once( ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php' );
require_once( ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php' );

function read_config() {
    
    $file = plugin_dir_path( __FILE__ ) . 'config.json'; 
    $data = file_get_contents($file); 

    $obj = json_decode($data); 

    return $obj;
}

function get_plugin_file( $plugin_slug ) {
    $plugins = get_plugins();

    foreach( $plugins as $plugin_file => $plugin_info ) {

        // Get the basename of the plugin e.g. [askismet]/askismet.php
        $slug = dirname( plugin_basename( $plugin_file ) );

        if( $slug ) if ( $slug == $plugin_slug ) {
            return $plugin_file; // If $slug = $plugin_name
        }
    }
    return null;
}

function plugin_activate( $plugin_slug ) {

    $plugin_file = get_plugin_file( $plugin_slug );

    if( $plugin_file ){
        activate_plugin( $plugin_file );
        echo '<div class="notice notice-success is-dismissible"><p>' . __( '<strong>Message:</strong> '.$plugin_slug.' has been <strong>installed</strong> and <strong>activated</strong> successfully.', 'plugin-install' ) . '</p></div>';
    }
}

function plugin_download( $plugin_slug ) {

    // already installed, do nothing
    if( get_plugin_file( $plugin_slug ) )
        return true;
    
    $api = plugins_api( 
        'plugin_information',
        array(
            'slug' => $plugin_slug,
            'fields' => array(
                'short_description' => false,
                'sections' => false,
                'requires' => true,
                'rating' => false,
                'ratings' => false,
                'downloaded' => false,
                'last_updated' => false,
                'added' => false,
                'tags' => false,
                'compatibility' => false,
                'homepage' => false,
                'donate_link' => false,
            ),
        )
    );

    if( is_wp_error( $api ) ) {
        echo '<div class="notice notice-error is-dismissible"><p>' . __( '<strong>Error:</strong> plugin with name '.$plugin_slug.' <strong>not found</strong>.', 'plugin-install' ) . '</p></div>';
        return false;
    }

    global $wp_version, $required_php_version;
    
    if ($wp_version < $api->requires) {
        echo '<div class="notice notice-error is-dismissible"><p>' . __( '<strong>Error:</strong> '.$api -> name.' requires <strong>'.$api->requires.'</strong> version of WordPress. <strong>You may encounter unexpected behavior</strong>.', 'plugin-install' ) . '</p></div>';
        return false;
    }
    if ($required_php_version < $api -> requires_php) {
        echo '<div class="notice notice-error is-dismissible"><p>' . __( '<strong>Error:</strong> '.$api -> name.' requires <strong>'.$api->requires.'</strong> version of PHP. <strong>You may encounter unexpected behavior</strong>.', 'plugin-install' ) . '</p></div>';
        return false;
    }

    $skin     = new WP_Ajax_Upgrader_Skin();
    $upgrader = new Plugin_Upgrader( $skin );
    $upgrader -> install( $api -> download_link );

    if ($wp_version >= $api->tested) plugin_activate( $plugin_slug );
    else echo '<div id="message" class="notice notice-warning is-dismissible"><p>' . __( '<strong>Warning:</strong> '.$api -> name.' has <strong>not been tested</strong> with your current version of WordPress. <strong>You may encounter unexpected behavior</strong>.', 'plugin-install' ) . '</p></div>';
    
}

function onActivate() {
    if ( !current_user_can('install_plugins') )
        wp_die( __( 'Sorry, you are not allowed to install plugins on this site.', 'framework' ) );
    // activate_plugin( plugin_basename( __FILE__ ) );
    // echo '<div>Activated</div>';
}

function onDeactivate() {
    // deactivate_plugin( plugin_basename( __FILE__ ) );
}

function init() {

    register_activation_hook( __FILE__, 'onActivate' );
    register_deactivation_hook( __FILE__, 'onDeactivate' );

    if( !is_plugin_active( plugin_basename( __FILE__ ) ) ) {
        print(__FILE__);
        
        return;
    }

    $plugins = read_config();

    foreach( $plugins as $plugin ) {
        $url = explode( '/', trim( trim($plugin -> url), '/' ) );
        $slug = end($url);
        plugin_download( $slug );
    }

    // deactivate_plugin( plugin_dir_path( __FILE__ ) );

}

add_action( 'plugins_loaded', 'init' );
?>