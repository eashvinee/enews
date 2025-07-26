<?php
/**
 * Plugin Name: User Certificate PDF Generator
 * Description: Generates a personalized PDF certificate for the logged-in user based on provided course data.
 * Version: 1.0
 * Author: WordPress Team
 * Author URI: https://yourwebsite.com
 * License: GPL2
 * 
 */

// Exit if accessed directly to prevent security vulnerabilities.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin constants for file paths.
define( 'PDFGEN_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PDFGEN_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * 1. Include Dompdf Library
 *
 * IMPORTANT: You need to download Dompdf and place it in a 'vendor/dompdf' directory
 * inside this plugin's folder.
 *
 * How to get Dompdf:
 * - Download the latest release from GitHub: https://github.com/dompdf/dompdf/releases
 * - Look for a release like 'dompdf-2.0.7.zip' (or newer).
 * - Extract the contents of the zip file.
 * - Inside the extracted folder, you'll find a 'dompdf' folder.
 * - Create a 'vendor' folder inside your plugin's directory.
 * - Copy the 'dompdf' folder (from the extracted zip) into your plugin's 'vendor' folder.
 * So the path will be: your-plugin-folder/vendor/dompdf/autoload.inc.php
 */
if ( file_exists( PDFGEN_PLUGIN_DIR . 'vendor/autoload.inc.php' ) ) {
    require_once PDFGEN_PLUGIN_DIR . 'vendor/autoload.inc.php';

} else {
    // Fallback or error message if Dompdf is not found.
    add_action( 'admin_notices', function() {
        echo '<div class="notice notice-error is-dismissible"><p><strong>User Certificate PDF Generator:</strong> Dompdf library not found. Please ensure it\'s installed in <code>' . esc_html( CERTIFICATE_PLUGIN_DIR ) . 'vendor/dompdf/</code>.</p></div>';
    });
    return; // Stop plugin execution if Dompdf is missing.
}

require_once PDFGEN_PLUGIN_DIR . 'class-pdfgen-download.php';
new Pdfgen_Download();



/**
 * Add a custom menu item under the 'My Account' node in the admin bar.
 *
 * This function is hooked into 'admin_bar_menu'.
 *
 * @param WP_Admin_Bar $wp_admin_bar The WP_Admin_Bar instance.
 */
function pdfgen_link_to_my_account_menu( $wp_admin_bar ) {

    if ( ! is_user_logged_in() || ! is_admin_bar_showing() ) {
        return;
    }

    // Get current user data.
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    $user_display_name = esc_html( $current_user->display_name );
   

    // Create a nonce for security.
    $nonce = wp_create_nonce( 'pdfgen_certificate_nonce' );

    // Build the URL for the PDF generation handler.
    // We'll use a custom query parameter to trigger our handler.
    $download_url = add_query_arg(
        array(
            'pdfgen' => 'certificate',
            'user_id'              => $user_id,
            '_wpnonce'             => $nonce,
        ),
        home_url() // Base URL for the download link
    );




    // Define the arguments for our new menu item.
    $args = array(
        'id'     => 'pdfgen-certificate-link', 
        'parent' => 'my-account',               
        'title'  => __( 'Download Certificate', 'pdfgen' ), 
        'href'   => $download_url, 
        'meta'   => array(
            'target'   => '_self', 
            'class'    => 'pdfgen-admin-bar-item', 
            'title'    => __( 'Generate your certificate', 'pdfgen' ), // Tooltip text
        ),
    );

    $wp_admin_bar->add_node( $args );

}

add_action( 'admin_bar_menu', 'pdfgen_link_to_my_account_menu', 99 );



/**
 * Add a custom submenu page under the 'Profile' menu.
 *
 * This function is hooked into 'admin_menu'.
 */
function pdfgen_profile_submenu_page() {

        // Get current user data.
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    // Create a nonce for security.
    $nonce = wp_create_nonce( 'pdfgen_certificate_nonce' );

    $link='__false&pdfgen=certificate&user_id='.$user_id.'&_wpnonce='.$nonce;
    
    
    add_submenu_page(
        'profile.php',                  // Parent slug (the main menu item slug under which this submenu will appear)
        __( 'Download Certificate', 'pdfgen' ), // Page title (displayed in the browser tab/title bar)
        __( 'Download Certificate', 'pdfgen' ),    // Menu title (displayed in the admin menu)
        'read',                         // Capability required to access this menu item (e.g., 'read', 'edit_posts', 'manage_options')
        $link,      // Menu slug (unique identifier for this menu item)
        function(){ return false;} // Callback function to render the page content (will redirect)
    );
}
add_action( 'admin_menu', 'pdfgen_profile_submenu_page' );
