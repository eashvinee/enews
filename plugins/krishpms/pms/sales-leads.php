<?php


/**
 * Define a namespace for our plugin to prevent naming conflicts.
 */
namespace Krish\PMS; // Updated namespace

/**
 * Class SalesLeadCPT
 *
 * Manages the registration and functionality of the "Sales Leads" custom post type.
 */

class SalesLeadCPT {

    /**
     * Constructor.
     * Hooks into WordPress actions and filters.
     */
    public function __construct() {
        // Register the custom post type on 'init' hook.
        add_action( 'init', array( $this, 'register_post_type' ) );
         // Add custom submenu page under Sales Leads.
        add_action( 'admin_menu', array( $this, 'add_submenu_pages' ) );

        add_action( 'admin_init', array( $this, 'crud_sales_lead' ) );
    }

    public function crud_sales_lead(){


        if(isset($_POST['sales_lead_action'])){
            $lead_action=$_POST['sales_lead_action'];
            switch($lead_action):
                case 'add': $this->insert_sales_lead();break;
                case 'edit': $this->update_sales_lead();break;
            endswitch;    
        }

    }

    public function update_sales_lead(){
     
         
         if ( ! isset( $_POST['sales_lead_edit_nonce_field'] ) || ! wp_verify_nonce( $_POST['sales_lead_edit_nonce_field'], 'sales_lead_edit_nonce' ) ) {
                return;
        }

        $data=$_POST;
        $post_id=$data['id'];

        
          if ( $post_id ) {
            // Now, add the custom meta data.
            update_post_meta( $post_id, 'contact_person', $data['contact_person'] );
            update_post_meta( $post_id, 'phone_number', $data['phone_number'] );
            update_post_meta( $post_id, 'email_address', $data['email_address'] );
            update_post_meta( $post_id, 'created_date', $data['created_date'] );
            update_post_meta( $post_id, 'source', $data['source'] );
            update_post_meta( $post_id, 'company_name', $data['company_name'] );
            update_post_meta( $post_id, 'notes', $data['notes'] );
            update_post_meta( $post_id, 'status', $data['status'] );

            $this->upload_attachment($post_id);
        }

    }

    public function insert_sales_lead() {

  
        if ( ! isset( $_POST['sales_lead_add_nonce_field'] ) || ! wp_verify_nonce( $_POST['sales_lead_add_nonce_field'], 'sales_lead_add_nonce' ) ) {
                return;
        }

        $data=$_POST;

        $title = uniqid( 'Lead-', true ); // 'true' for more entropy
        //$title= 'Lead - ' . $random_string;

        // Define post data for the new sales lead.
        $post_data = array(
            'post_title'    => $title,
            'post_status'   => 'publish',
            'post_type'     => 'sales_lead',
        );

        // Insert the post.
        $post_id = wp_insert_post( $post_data );

        // Check if the post was inserted successfully.
        if ( is_wp_error( $post_id ) ) {
            echo 'Error inserting sales lead: ' . $post_id->get_error_message();
            die;
        }

        if ( $post_id ) {
            // Now, add the custom meta data.
            update_post_meta( $post_id, 'contact_person', $data['contact_person'] );
            update_post_meta( $post_id, 'phone_number', $data['phone_number'] );
            update_post_meta( $post_id, 'email_address', $data['email_address'] );
            update_post_meta( $post_id, 'created_date', $data['created_date'] );
            update_post_meta( $post_id, '_created_date', date("Ymd",strtotime($data['created_date'])) );
            update_post_meta( $post_id, 'source', $data['source'] );
            update_post_meta( $post_id, 'company_name', $data['company_name'] );
            update_post_meta( $post_id, 'notes', $data['notes'] );
            update_post_meta( $post_id, 'status', $data['status'] );

            $this->upload_attachment($post_id);
        }

        //admin.php?page=sales-leads&action=edit&id='.$post_id
        wp_redirect(admin_url('admin.php?page=sales-leads'));
        die;
    }

    function upload_attachment($post_id){
        if ( isset( $_FILES['attachment'] ) && ! empty( $_FILES['attachment']['name'] ) ) {
            // Include necessary WordPress core files for media handling.
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
            require_once( ABSPATH . 'wp-admin/includes/media.php' );

            $file_to_upload = $_FILES['attachment'];

            // Set overrides for wp_handle_upload. 'test_form' => false is crucial.
            $upload_overrides = array( 'test_form' => false );
            $movefile = wp_handle_upload( $file_to_upload, $upload_overrides );

            // Check if the file was uploaded successfully.
            if ( $movefile && ! isset( $movefile['error'] ) ) {
                // File uploaded successfully, store its URL.
                update_post_meta( $post_id, 'attachment', $movefile['url'] );

            }else{
                print_r($movefile['error']);
                die;
            }
        }
    }


    /**
     * Adds custom submenu pages under the 'Sales Leads' menu.
     */
    public function add_submenu_pages() {
        // Parent slug for the 'Sales Leads' CPT menu.
        $parent_slug = 'krishpms-dashboard';

        // Add 'Follow Up' submenu page.
        add_submenu_page(
            $parent_slug,
            __( 'Sales Leads', 'krishpms' ), // Page title
            __( 'Sales Leads', 'krishpms' ),             // Menu title
            'edit_posts',                              // Capability required (e.g., users who can edit posts)
            'sales-leads',                   // Menu slug (unique)
            array( $this, 'render_sales_leads_page' ) // Callback function
        );
        
    }
    /**
     * Renders the content for the 'Sales Leads' admin page.
     */
    public function render_sales_leads_page() {
        // Check user capabilities.
        if ( ! current_user_can( 'edit_posts' ) ) {
            wp_die( __( 'You do not have sufficient permissions to access this page.', 'krishpms' ) );
        }
        wp_enqueue_style('krishpms-custom');
        wp_enqueue_script('krishpms-custom');

        $leads=$this->get_sales_leads();

        $action=(isset($_GET['action']))? $_GET['action'] : 'view'; 
        include KRISH_PMS_PLUGIN_DIR."view/sales-leads/{$action}.php";
        
       
    }
    function get_sales_leads(){
        $args = array(
            'post_type'      => 'sales_lead',      // Query for standard posts
            'post_status'    => 'publish',   // Only published posts
            'posts_per_page' => -1,          // Get all matching posts
            'fields'         => 'ids',       // Crucial: Only return post IDs
        );

        $query = new \WP_Query( $args );

        $post_ids = $query->posts;

        if (empty( $post_ids ) ) {
            $post_ids =[];
        } 

        wp_reset_postdata();

        return $post_ids;
    }

    /**
     * Registers the 'sales_lead' custom post type.
     */
    public function register_post_type() {
        $labels = array(
            'name'                  => _x( 'Sales Leads', 'Post Type General Name', 'krishpms' ), // Updated textdomain
            'singular_name'         => _x( 'Sales Lead', 'Post Type Singular Name', 'krishpms' ), // Updated textdomain
            'menu_name'             => __( 'Sales Leads', 'krishpms' ), // Updated textdomain
            
        );
        $args = array(
            'label'                 => __( 'Sales Lead', 'krishpms' ), // Updated textdomain
            'description'           => __( 'Manage sales leads for your business.', 'krishpms' ), // Updated textdomain
            'labels'                => $labels,
            'supports'              => array( 'title', 'custom-fields'),//'editor', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields'
            'hierarchical'          => false,
            'public'                => false,
            'show_ui'               => false,
            'show_in_menu'          => false,
            'menu_position'         => 5, // Position in the admin menu (below Posts)
            'menu_icon'             => 'dashicons-groups', // You can choose from Dashicons: https://developer.wordpress.org/resource/dashicons/
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => false,
            'can_export'            => false,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => false,
            'capability_type'       => 'post',
            'rewrite'               => array( 'slug' => 'sales-lead' ), // Permalink slug
            'show_in_rest'          => false, // Enable for Gutenberg editor and REST API
            'rest_base'             => 'sales-leads',
        );
        register_post_type( 'sales_lead', $args );
    }

    
}



/**
 * Instantiate the class to start its functionality.
 * This ensures the hooks are registered when the plugin is loaded.
 */
new SalesLeadCPT();
