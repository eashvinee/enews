<?php

/**
 * Define a namespace for our plugin to prevent naming conflicts.
 */
namespace Krish\PMS; // Updated namespace

/**
 * Class KrishPMSDashboard
 *
 * Manages the registration and functionality of the "Sales Leads" custom post type.
 */
class Dashboard {

    public function __construct(){
        // Add top-level admin menu for "PMS".
        add_action( 'admin_menu', array( $this, 'add_pms_admin_menu' ) );
    }

    /**
     * Adds a top-level admin menu page for "PMS".
     */
    public function add_pms_admin_menu() {
        $parent_slug='krishpms-dashboard';
        add_menu_page(
            __( 'KrishPMS', 'krishpms' ), // Page title
            __( 'KrishPMS', 'krishpms' ),             // Menu title
            'manage_options',                    // Capability required (e.g., only administrators)
            $parent_slug,                // Menu slug (unique)
            array( $this, 'render_pms_admin_page' ), // Callback function to render the page
            'dashicons-groups',              // Icon URL or Dashicon class
            3                                    // Position in the menu order (e.g., below Dashboard)
        );
         

       // remove_submenu_page( $parent_slug, $parent_slug );
    }

    /**
     * Renders the content for the "PMS" admin page.
     */
    public function render_pms_admin_page() {
        // Check user capabilities.
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( __( 'You do not have sufficient permissions to access this page.', 'krishpms' ) );
        }
        wp_enqueue_style('krishpms-custom');
        wp_enqueue_script('krishpms-custom');
        ?>
        <div class="wrap">
            <h1>PMS Dashboard</h1>
            <p>Welcome to your Project Management System (PMS) Dashboard!</p>

            <div class="card">
                <h2>Overview</h2>
                <p>This section can display key metrics, recent activities, or quick links related to your sales leads and follow-ups.</p>
                <ul>
                    <li><?php _e( 'Total Sales Leads: X', 'krishpms' ); ?></li>
                    <li><?php _e( 'Pending Follow Ups: Y', 'krishpms' ); ?></li>
                    <li><?php _e( 'Leads Closed Won This Month: Z', 'krishpms' ); ?></li>
                </ul>
            </div>

            <div class="card mt-4">
                <h2>Quick Actions</h2>
                <p>
                    <a href="<?php echo esc_url( admin_url( 'admin.php?page=sales-leads&action=add' ) ); ?>" class="button button-primary">
                        Add New Sales Lead
                    </a>
                    <a href="<?php echo esc_url( admin_url( 'admin.php?page=sales-leads-follow-up&action=add' ) ); ?>" class="button button-secondary">
                        Add New Follow Up
                    </a>
                </p>
            </div>
        </div>
        <?php
    }

}

new Dashboard();