<?php



/**
 * Enqueue custom styles and scripts for the WordPress login page.
 *
 * This function hooks into 'login_enqueue_scripts' to add custom CSS and JS.
 */
function news7_login_assets() {
   $style_path=get_stylesheet_directory_uri();
    wp_enqueue_style(  'news7-login-styles', $style_path. '/assets/css/login-styles.css?tm='.time(), array(),  '1.0.0'  );

    
    //wp_enqueue_script( 'news7-login-script',  $style_path. '/js/login-script.js', array( 'jquery' ),  '1.0.0', true );

}
add_action( 'login_enqueue_scripts', 'news7_login_assets' );

add_filter( 'login_headerurl', function($url){
    return home_url('/');
} );

add_filter( 'login_headertext', function($url){
    return 'News7';
} );

function remove_wp_logo_from_admin_bar( $wp_admin_bar ) {
    // Check if the admin bar object exists and if the 'wp-logo' node is present.
    //if ( $wp_admin_bar && $wp_admin_bar->get_node( 'wp-logo' ) ) {
        // Remove the 'wp-logo' node.
        $wp_admin_bar->remove_node( 'wp-logo' );
        $wp_admin_bar->remove_node( 'comments' );
        $wp_admin_bar->remove_node( 'updates' );
       
    //}
}
// Hook the function to 'admin_bar_menu' with a priority of 999
// A high priority ensures it runs late, after the logo has been added.
add_action( 'admin_bar_menu', 'remove_wp_logo_from_admin_bar', 999 );