<?php

/**
 * Plugin Name: Krish PMS
 * Description: Registers a custom post type for "Sales Leads" with custom fields and admin columns.
 * Version: 1.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 * License: GPL2
 */


// Exit if accessed directly to prevent security vulnerabilities.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin constants for file paths.
define( 'KRISH_PMS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'KRISH_PMS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );


/**
 * Enqueues admin-specific CSS and JavaScript.
 */
function krishpms_enqueue_admin_assets() {
        $assets_url=KRISH_PMS_PLUGIN_URL . 'assets/';
        // Enqueue custom admin CSS.
        wp_register_style('krishpms-bootstrap-grid', $assets_url. 'css/bootstrap-grid.css', array(),null);
        wp_register_style('krishpms-custom',  $assets_url. 'css/krishpms-custom.css?tm='.time(), array('krishpms-bootstrap-grid'),null);
        //wp_enqueue_style();

        // Enqueue custom admin JavaScript.
        wp_register_script('krishpms-custom', $assets_url. 'js/krishpms-custom.js',  array( 'jquery' ), null,true);
}
add_action( 'admin_enqueue_scripts', 'krishpms_enqueue_admin_assets' );

include_once "pms/dashboard.php";
include_once "pms/sales-leads.php";
include_once "pms/follow-up-lead.php";