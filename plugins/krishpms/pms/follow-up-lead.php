<?php

namespace Krish\PMS; // Updated namespace

/**
 * Class SalesLeadCPT
 *
 * Manages the registration and functionality of the "Sales Leads" custom post type.
 */
class FollowUpLead {

    /**
     * Constructor.
     * Hooks into WordPress actions and filters.
     */
    public function __construct() {

        // Add custom submenu page under Sales Leads.
        add_action( 'admin_menu', array( $this, 'add_follow_up_submenu_pages' ) );

         add_action( 'admin_init', array( $this, 'crud_follow_up' ) );

    }
    public function crud_follow_up(){


        if(isset($_POST['follow_up_action'])){
            $lead_action=$_POST['follow_up_action'];
            switch($lead_action):
                case 'add': $this->insert_follow_up();break;
                //case 'edit': $this->update_sales_lead();break;
            endswitch;    
        }

    }
 public function insert_follow_up(){

      if ( ! isset( $_POST['follow_up_add_nonce_field'] ) || ! wp_verify_nonce( $_POST['follow_up_add_nonce_field'], 'follow_up_add_nonce' ) ) {
                return;
        }

        $data=$_POST;
      


        $comment_data = array(
            'comment_post_ID'      => $data['lead_id'], // The ID of the post
            //'comment_author'       => 'ChatGPT',
            //'comment_author_email' => 'chat@example.com',
            //'comment_author_url'   => 'https://www.openai.com/',
            //'comment_content'      => 'This is a programmatically added comment via wp_insert_comment!',
            'comment_type'         => 'followup',
            'comment_parent'       => 0, // Not a reply to another comment
            'user_id'              => 0, // Not a registered user
            'comment_approved'     => 1, // 1 = Approved, 0 = Pending, 'spam'
            //'comment_agent'        => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.75 Safari/537.36',
            //'comment_author_IP'    => '192.168.1.100',
            //'comment_date'         => '2025-07-27 14:00:00', // Specific date and time
            //'comment_date_gmt'     => '2025-07-27 08:30:00', // GMT date and time
        );

        // Insert the comment
        $comment_id = wp_insert_comment( wp_filter_comment( $comment_data ) );

        if ( $comment_id ) {
            update_comment_meta( $comment_id, 'lead_id', $data['lead_id'] );
            update_comment_meta( $comment_id, 'follow_up_date', $data['follow_up_date'] );
            update_comment_meta( $comment_id, '_follow_up_date', date("Ymd",strtotime($data['follow_up_date'])) );

            update_comment_meta( $comment_id, 'mode', $data['mode'] );
            update_comment_meta( $comment_id, 'notes', $data['notes'] );
            update_comment_meta( $comment_id, 'next_follow_up_date', $data['next_follow_up_date'] );
            update_comment_meta( $comment_id, '_next_follow_up_date', date("Ymd",strtotime($data['next_follow_up_date'])) );

            update_comment_meta( $comment_id, 'status', $data['status'] );
             $this->upload_attachment($comment_id);
        } else {
           // echo "Failed to add comment.";
        }
        //admin.php?page=sales-leads&action=edit&id='.$post_id
        wp_redirect(admin_url('admin.php?page=sales-leads-follow-up&action=single&lead='.$data['lead_id']));
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
                update_comment_meta( $post_id, 'attachment', $movefile['url'] );

            }else{
                print_r($movefile['error']);
                die;
            }
        }
    }


    /**
     * Adds custom submenu pages under the 'Sales Leads' menu.
     */
    public function add_follow_up_submenu_pages() {
        // Parent slug for the 'Sales Leads' CPT menu.
        $parent_slug = 'krishpms-dashboard';

        // Add 'Follow Up' submenu page.
        add_submenu_page(
            $parent_slug,
            __( 'Sales Leads Follow Up', 'krishpms' ), // Page title
            __( 'Follow Up', 'krishpms' ),             // Menu title
            'edit_posts',                              // Capability required (e.g., users who can edit posts)
            'sales-leads-follow-up',                   // Menu slug (unique)
            array( $this, 'render_sales_leads_follow_up_page' ) // Callback function
        );
       
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
     * Renders the content for the 'Sales Leads Follow Up' admin page.
     */
    public function render_sales_leads_follow_up_page() {
        // Check user capabilities.
        if ( ! current_user_can( 'edit_posts' ) ) {
            wp_die( __( 'You do not have sufficient permissions to access this page.', 'krishpms' ) );
        }
        wp_enqueue_style('krishpms-custom');
        wp_enqueue_script('krishpms-custom');


        $leads=$this->get_sales_leads();

        $action=(isset($_GET['action']))? $_GET['action'] : 'view'; 
        include KRISH_PMS_PLUGIN_DIR."view/follow-up/{$action}.php";

        //include KRISH_PMS_PLUGIN_DIR."view/follow-up-add.php";
        //include KRISH_PMS_PLUGIN_DIR."view/sales-leads-add.php";
       /* return;
        ?>
        <div class="wrap">
            <h1><?php _e( 'Sales Leads Follow Up', 'krishpms' ); ?></h1>
            <p><?php _e( 'This page is for managing follow-up actions for your sales leads.', 'krishpms' ); ?></p>

            <div class="card">
                <h2><?php _e( 'Upcoming Follow-ups', 'krishpms' ); ?></h2>
                <p><?php _e( 'You can display a list of leads requiring follow-up here, perhaps based on their status or a custom "next follow-up date" field.', 'krishpms' ); ?></p>
                <ul>
                    <li><?php _e( 'Lead: John Doe (New)', 'krishpms' ); ?></li>
                    <li><?php _e( 'Lead: Acme Corp (Contacted)', 'krishpms' ); ?></li>
                    <li><?php _e( 'Lead: Jane Smith (Proposal Sent)', 'krishpms' ); ?></li>
                </ul>
                <p class="description"><?php _e( 'This section can be dynamically populated with actual lead data.', 'krishpms' ); ?></p>
            </div>

            <div class="card mt-4">
                <h2><?php _e( 'Follow Up Settings', 'krishpms' ); ?></h2>
                <p><?php _e( 'Add settings related to follow-up processes, e.g., default follow-up intervals, notification preferences.', 'krishpms' ); ?></p>
                <form method="post" action="">
                    <label for="follow_up_interval"><?php _e( 'Default Follow-up Interval (days):', 'krishpms' ); ?></label>
                    <input type="number" id="follow_up_interval" name="follow_up_interval" value="7" min="1" />
                    <p class="description"><?php _e( 'Number of days before a lead needs a follow-up.', 'krishpms' ); ?></p>
                    <p class="submit">
                        <input type="submit" name="submit_follow_up_settings" id="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Settings', 'krishpms' ); ?>" />
                    </p>
                </form>
            </div>
        </div>
        <?php */
    }

    /*
    // Example for another submenu page (uncomment to activate)
    // public function render_sales_leads_reports_page() {
    //     if ( ! current_user_can( 'manage_options' ) ) {
    //         wp_die( __( 'You do not have sufficient permissions to access this page.', 'krishpms' ) );
    //     }
    //     ? >
    //<!--
    //     <div class="wrap">
    //         <h1><?php _e( 'Sales Leads Reports', 'krishpms' ); ?></h1>
    //         <p><?php _e( 'This page will display various reports and analytics for your sales leads.', 'krishpms' ); ?></p>
    //         <div class="card">
    //             <p><?php _e( 'Report content goes here.', 'krishpms' ); ?></p>
    //         </div>
    //     </div>
    // -->
    <?php
    // }*/
}
new FollowUpLead();