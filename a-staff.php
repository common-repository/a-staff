<?php

/*
Plugin Name: a-staff
Plugin URI:  https://a-idea.studio/a-staff/
Description: Add a team member section easily to your website with this plugin
Version:     1.2.2
Author:      a-idea studio
Author URI:  https://a-idea.studio/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: a-staff
Domain Path: /languages

@fs_premium_only /pro/
*/
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !function_exists( 'a_staff_freemius' ) ) {
    // Create a helper function for easy SDK access.
    function a_staff_freemius()
    {
        global  $a_staff_freemius ;
        
        if ( !isset( $a_staff_freemius ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $a_staff_freemius = fs_dynamic_init( array(
                'id'             => '2555',
                'slug'           => 'a-staff',
                'type'           => 'plugin',
                'public_key'     => 'pk_b01cfbc537ce64d7e381c8ccb91ea',
                'is_premium'     => false,
                'has_addons'     => false,
                'has_paid_plans' => true,
                'menu'           => array(
                'slug'    => 'a_staff_settings',
                'support' => false,
            ),
                'is_live'        => true,
            ) );
        }
        
        return $a_staff_freemius;
    }
    
    // Init Freemius.
    a_staff_freemius();
    // Signal that SDK was initiated.
    do_action( 'a_staff_freemius_loaded' );
    // Defining the current plugin version
    define( 'A_STAFF_VERSION', '1.2.2' );
    define( 'A_STAFF_BASE_DIR', dirname( __FILE__ ) );
    define( 'A_STAFF_BASE_URL', plugin_dir_url( __FILE__ ) );
    // Load the classes
    require_once "inc/class/class-member.php";
    // Including the plugin files
    require_once "inc/a-staff-cpt.php";
    require_once "inc/a-staff-init.php";
    require_once "inc/a-staff-functions.php";
    require_once "inc/a-staff-options.php";
    require_once "inc/a-staff-shortcode.php";
    require_once "inc/a-staff-templates.php";
    // Define the member class to be used - if not defined before
    if ( !defined( 'A_STAFF_MEMBER_CLASS' ) ) {
        define( 'A_STAFF_MEMBER_CLASS', 'A_STAFF_Member' );
    }
    // Load the Gutenberg part conditionally only if the Gutenberg plugin is active or WP version >= 5.0
    if ( in_array( 'gutenberg/gutenberg.php', (array) get_option( 'active_plugins', array() ) ) || version_compare( get_bloginfo( 'version' ), '5.0', '>=' ) ) {
        require_once "inc/a-staff-gutenberg.php";
    }
    // Activation / Deactivation / Uninstall hooks
    register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
    register_activation_hook( __FILE__, 'a_staff_flush_rewrites' );
    a_staff_freemius()->add_action( 'after_uninstall', 'a_staff_uninstall' );
    // Load the textdomain for i18n
    add_action( 'plugins_loaded', function () {
        if ( is_admin() ) {
            load_plugin_textdomain( 'a-staff', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
        }
    } );
}
