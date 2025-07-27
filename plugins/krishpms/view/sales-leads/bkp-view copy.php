<?php 
//namespace Krish\PMS;
?>
<style>
    table.salesleads .column-id{ width: 40px;}
    table.salesleads .column-phone_number{ width: 140px;}
    table.salesleads .column-status{ width: 80px;}
    table.salesleads .column-created_date{ width: 120px;}
</style>
<div class="wrap">
    <h1>Sales Leads<a class="button" href="?page=sales-leads&action=add">Add Sales Lead</a></h1>
    <p>This page is for managing  your sales leads.</p>
    <?php 

        $sales_leads_list_table = new Sales_Leads_List_Table();
        $sales_leads_list_table->prepare_items();    
        $sales_leads_list_table->display();
        
    ?>
</div>


<?php
/**
 * Custom WP_List_Table for Sales Leads.
 *
 * @package Krishpms
 */



// Ensure WP_List_Table is available.
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * Class Sales_Leads_List_Table
 *
 * Extends WP_List_Table to display and manage Sales Leads.
 */
class Sales_Leads_List_Table extends \WP_List_Table {

    /**
     * Constructor.
     *
     * @param array $args An associative array of arguments.
     */
    public function __construct( $args = array() ) {
        parent::__construct(
            array_merge(
                array(
                    'singular' => __( 'Sales Lead', 'krishpms' ), // singular name of the listed records
                    'plural'   => __( 'Sales Leads', 'krishpms' ),  // plural name of the listed records
                    'ajax'     => false,                     // Does this table support ajax for sorting, pagination, and searching?
                ),
                $args
            )
        );
    }

    /**
     * Get a list of columns for the list table.
     *
     * @return array Associative array of column headers.
     */
    public function get_columns() {
        $columns = array(
          //  'cb'             => '<input type="checkbox" />', // Checkbox for bulk actions
            'id'          => __( 'ID', 'krishpms' ),
            'contact_person' => __( 'Contact Person', 'krishpms' ),
            //'company_name'   => __( 'Company', 'krishpms' ),
            'email_address'  => __( 'Email', 'krishpms' ),
            'phone_number'   => __( 'Phone', 'krishpms' ),
            //'source'         => __( 'Source', 'krishpms' ),
            'status'         => __( 'Status', 'krishpms' ),
            'created_date'           => __( 'Date Created', 'krishpms' ),
        );
        return $columns;
    }

    /**
     * Get a list of sortable columns.
     *
     * @return array Associative array of sortable columns.
     */
    protected function get_sortable_columns() {
        $sortable_columns = array(
            //'title'          => array( 'title', false ), // True for ascending initial sort
            //'contact_person' => array( 'contact_person', false ),
            //'company_name'   => array( 'company_name', false ),
            //'email_address'  => array( 'email_address', false ),
            //'phone_number'   => array( 'phone_number', false ),
            //'source'         => array( 'source', false ),
            //'status'         => array( 'status', false ),
           // 'date'           => array( 'date', true ), // Default sort by date descending
        );
        return $sortable_columns;
    }

    /**
     * Get a list of bulk actions.
     *
     * @return array Associative array of bulk actions.
     */
    protected function get_bulk_actions() {
        $actions = array(
            //'edit'   => __( 'Edit', 'krishpms' ), // Standard WordPress edit action
            //'trash'  => __( 'Move to Trash', 'krishpms' ), // Standard WordPress trash action
            //'untrash' => __( 'Restore', 'krishpms' ), // Standard WordPress untrash action
            //'delete' => __( 'Delete Permanently', 'krishpms' ), // Standard WordPress delete action
        );
        return $actions;
    }

    /**
     * Handles data for the 'cb' column (checkbox).
     *
     * @param object $item The current item object.
     * @return string The HTML for the checkbox.
     */
    protected function column_cb( $item ) {
        return '';
        /* sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            $this->_args['singular'], // The singular name of the list table.
            $item->ID                 // The ID of the current item.
        );*/
    }

    /**
     * Handles data for the 'title' column, including row actions.
     *
     * @param object $item The current item object.
     * @return string The HTML for the title and row actions.
     */
    protected function column_contact_person( $item ) {
        $actions = array(
            'followup'    => '<a href="admin.php?page=sales-leads-follow-up&action=single&lead='.$item->ID.'">Follow Up</a>',
            'edit'    => '<a href="admin.php?page=sales-leads&action=edit&id='.$item->ID.'">Edit</a>',
            'delete'  => '<a href="#">Delete</a>',
        );

       /* // Adjust actions based on post status.
        if ( 'trash' === $item->post_status ) {
            unset( $actions['edit'], $actions['view'], $actions['trash'] );
        } else {
            unset( $actions['untrash'], $actions['delete'] );
        }*/
          //  print_r($item);

        return sprintf(
            '<strong><a class="row-title" href="%1$s">%2$s</a></strong>%3$s',
            get_edit_post_link( $item->ID ),
            esc_html( get_post_meta( $item->ID, 'contact_person', true )),
            $this->row_actions( $actions )
        );
    }

    /**
     * Handles data for other custom columns.
     *
     * @param object $item        The current item object.
     * @param string $column_name The name of the column.
     * @return string The content for the column.
     */
    protected function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'id':
                return $item->ID;
            case 'contact_person':
                return get_post_meta( $item->ID, 'contact_person', true );
            case 'company_name':
                return esc_html( get_post_meta( $item->ID, 'company_name', true ) );
            case 'email_address':
                return get_post_meta( $item->ID, 'email_address', true );
            case 'phone_number':
                return get_post_meta( $item->ID, 'phone_number', true );
            case 'source':
                return get_post_meta( $item->ID, 'source', true );
            case 'status':
                return  get_post_meta( $item->ID, 'status', true );
            case 'created_date':
                return get_post_meta( $item->ID, 'created_date', true );;
            default:
                return print_r( $item, true ); // For debugging, displays the whole item object
        }
    }

    /**
     * Message to be displayed when there are no items.
     */
    public function no_items() {
        _e( 'No sales leads found.', 'krishpms' );
    }

    /**
     * Prepares the list of items for displaying.
     *
     * This is where you query your data, handle sorting, pagination, and search.
     */
    public function prepare_items() {
        global $wpdb;

        // Determine columns and sortable columns.
        $columns  = $this->get_columns();
        $hidden   = array(); // No hidden columns by default.
        $sortable = $this->get_sortable_columns();

        // Set column headers.
        $this->_column_headers = array( $columns, $hidden, $sortable );

        // Handle bulk actions.
        $this->process_bulk_action();

        // --- Pagination ---
        $per_page     = 20; // Number of items per page.
        $current_page = $this->get_pagenum(); // Current page number.
        $total_items  = $this->get_sales_leads_count(); // Total number of items.

        // Set pagination arguments.
        $this->set_pagination_args(
            array(
                'total_items' => $total_items,
                'per_page'    => $per_page,
                'total_pages' => ceil( $total_items / $per_page ),
            )
        );

        // --- Fetch data ---
        $this->items = $this->get_sales_leads( $per_page, $current_page );
    }

    /**
     * Get the total count of sales leads.
     *
     * @return int Total number of sales leads.
     */
    public function get_sales_leads_count() {
        $args = array(
            'post_type'      => 'sales_lead',
            'post_status'    => array( 'publish', 'draft', 'pending', 'trash' ), // Include trash for counts
            'posts_per_page' => -1, // Get all posts for counting
            'fields'         => 'ids', // Only get IDs for efficiency
            'no_found_rows'  => true, // No need for pagination data here
        );

        // Apply search query if present.
        if ( ! empty( $_REQUEST['s'] ) ) {
            $args['s'] = sanitize_text_field( $_REQUEST['s'] );
        }

        // Apply status filter if present.
        if ( ! empty( $_REQUEST['post_status'] ) && 'all' !== $_REQUEST['post_status'] ) {
            $args['post_status'] = sanitize_text_field( $_REQUEST['post_status'] );
        }

        $query = new \WP_Query( $args );
        return $query->found_posts; // Use found_posts for accurate count with search/filters
    }

    /**
     * Get sales leads data for the list table.
     *
     * @param int $per_page Number of items per page.
     * @param int $page_number Current page number.
     * @return array Array of sales lead objects.
     */
    public function get_sales_leads( $per_page = 20, $page_number = 1 ) {
        $args = array(
            'post_type'      => 'sales_lead',
            'post_status'    => array( 'publish', 'draft', 'pending' ), // Default statuses to show
            'posts_per_page' => $per_page,
            'paged'          => $page_number,
            'orderby'        => 'date', // Default orderby
            'order'          => 'DESC', // Default order
        );

        // Handle sorting.
        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $orderby = sanitize_sql_orderby( $_REQUEST['orderby'] ); // Sanitize for SQL safety
            $order   = strtoupper( sanitize_text_field( $_REQUEST['order'] ) );

            // Custom meta key sorting.
            $meta_keys_for_sorting = array(
                'contact_person',
                'company_name',
                'email_address',
                'phone_number',
                'source',
                'status',
            );

            if ( in_array( $orderby, $meta_keys_for_sorting ) ) {
                $args['orderby']  = 'meta_value';
                $args['meta_key'] = '_' . $orderby; // Assuming meta keys start with underscore
            } else {
                $args['orderby'] = $orderby;
            }
            $args['order'] = $order;
        }

        // Handle search query.
        if ( ! empty( $_REQUEST['s'] ) ) {
            $args['s'] = sanitize_text_field( $_REQUEST['s'] );
        }

        // Handle post status filter (e.g., if "Trash" view is selected).
        if ( isset( $_REQUEST['post_status'] ) && 'all' !== $_REQUEST['post_status'] ) {
            $args['post_status'] = sanitize_text_field( $_REQUEST['post_status'] );
        }

        $query = new \WP_Query( $args );
        return $query->posts;
    }

    /**
     * Displays the search box.
     *
     * @param string $text The search button text.
     * @param string $input_id The search input id.
     * /
    public function search_box( $text, $input_id ) {
        if ( empty( $_REQUEST['s'] ) && ! $this->has_items() ) {
            return;
        }

        $input_id = $input_id . '-search-input';

        if ( ! empty( $_REQUEST['orderby'] ) ) {
            echo '<input type="hidden" name="orderby" value="' . esc_attr( $_REQUEST['orderby'] ) . '" />';
        }
        if ( ! empty( $_REQUEST['order'] ) ) {
            echo '<input type="hidden" name="order" value="' . esc_attr( $_REQUEST['order'] ) . '" />';
        }
        if ( ! empty( $_REQUEST['post_status'] ) ) {
            echo '<input type="hidden" name="post_status" value="' . esc_attr( $_REQUEST['post_status'] ) . '" />';
        }
        ?>
        <p class="search-box">
            <label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_html( $text ); ?>:</label>
            <input type="search" id="<?php echo esc_attr( $input_id ); ?>" name="s" value="<?php _admin_search_query(); ?>" />
            <?php submit_button( $text, 'button', '', false, array( 'id' => 'search-submit' ) ); ?>
        </p>
        <?php
    }*/

    /**
     * Get the list of views (e.g., All, Published, Draft, Trash).
     *
     * @return array Associative array of views.
     */
    protected function get_views() {
        $status_links = array();
        $post_type = 'sales_lead';
        $num_posts = wp_count_posts( $post_type, 'readable' );
        $class = '';
        $all_count = array_sum( (array) $num_posts );

        $current_status = $_REQUEST['post_status'] ?? 'all';

        // All link
        $class = ( 'all' === $current_status ) ? 'current' : '';
        $status_links['all'] = sprintf(
            '<a href="%s" class="%s">%s <span class="count">(%s)</span></a>',
            esc_url( admin_url( 'admin.php?page=sales-leads-custom-list' ) ),
            esc_attr( $class ),
            _x( 'All', 'all posts', 'krishpms' ),
            number_format_i18n( $all_count )
        );

        // Published link
        if ( ! empty( $num_posts->publish ) ) {
            $class = ( 'publish' === $current_status ) ? 'current' : '';
            $status_links['publish'] = sprintf(
                '<a href="%s" class="%s">%s <span class="count">(%s)</span></a>',
                esc_url( admin_url( 'admin.php?page=sales-leads-custom-list&post_status=publish' ) ),
                esc_attr( $class ),
                _x( 'Published', 'published posts', 'krishpms' ),
                number_format_i18n( $num_posts->publish )
            );
        }

        // Draft link
        if ( ! empty( $num_posts->draft ) ) {
            $class = ( 'draft' === $current_status ) ? 'current' : '';
            $status_links['draft'] = sprintf(
                '<a href="%s" class="%s">%s <span class="count">(%s)</span></a>',
                esc_url( admin_url( 'admin.php?page=sales-leads-custom-list&post_status=draft' ) ),
                esc_attr( $class ),
                _x( 'Draft', 'draft posts', 'krishpms' ),
                number_format_i18n( $num_posts->draft )
            );
        }

        // Pending link
        if ( ! empty( $num_posts->pending ) ) {
            $class = ( 'pending' === $current_status ) ? 'current' : '';
            $status_links['pending'] = sprintf(
                '<a href="%s" class="%s">%s <span class="count">(%s)</span></a>',
                esc_url( admin_url( 'admin.php?page=sales-leads-custom-list&post_status=pending' ) ),
                esc_attr( $class ),
                _x( 'Pending', 'pending posts', 'krishpms' ),
                number_format_i18n( $num_posts->pending )
            );
        }

        // Trash link
        if ( ! empty( $num_posts->trash ) ) {
            $class = ( 'trash' === $current_status ) ? 'current' : '';
            $status_links['trash'] = sprintf(
                '<a href="%s" class="%s">%s <span class="count">(%s)</span></a>',
                esc_url( admin_url( 'admin.php?page=sales-leads-custom-list&post_status=trash' ) ),
                esc_attr( $class ),
                _x( 'Trash', 'trash posts', 'krishpms' ),
                number_format_i18n( $num_posts->trash )
            );
        }

        return $status_links;
    }

    /**
     * Process bulk actions.
     * /
    protected function process_bulk_action() {
        // Only proceed if a bulk action is set and a nonce is valid.
        if ( ! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'bulk-' . $this->_args['plural'] ) ) {
            return;
        }

        $action = $this->current_action();

        if ( empty( $action ) ) {
            return;
        }

        // Ensure post IDs are set.
        if ( empty( $_REQUEST[$this->_args['singular']] ) ) {
            return;
        }

        $post_ids = array_map( 'absint', (array) $_REQUEST[$this->_args['singular']] );

        switch ( $action ) {
            case 'trash':
                foreach ( $post_ids as $post_id ) {
                    wp_trash_post( $post_id );
                }
                $message = sprintf( _n( '%d item moved to the Trash.', '%d items moved to the Trash.', count( $post_ids ), 'krishpms' ), count( $post_ids ) );
                add_settings_error( 'sales_leads_list_table', 'bulk_trash', $message, 'success' );
                break;
            case 'untrash':
                foreach ( $post_ids as $post_id ) {
                    wp_untrash_post( $post_id );
                }
                $message = sprintf( _n( '%d item restored from the Trash.', '%d items restored from the Trash.', count( $post_ids ), 'krishpms' ), count( $post_ids ) );
                add_settings_error( 'sales_leads_list_table', 'bulk_untrash', $message, 'success' );
                break;
            case 'delete':
                foreach ( $post_ids as $post_id ) {
                    wp_delete_post( $post_id, true ); // true for permanent delete
                }
                $message = sprintf( _n( '%d item permanently deleted.', '%d items permanently deleted.', count( $post_ids ), 'krishpms' ), count( $post_ids ) );
                add_settings_error( 'sales_leads_list_table', 'bulk_delete', $message, 'success' );
                break;
            // Add more bulk actions here if needed (e.g., 'mark_as_contacted')
            // case 'mark_as_contacted':
            //     foreach ( $post_ids as $post_id ) {
            //         update_post_meta( $post_id, '_sales_lead_status', 'contacted' );
            //     }
            //     $message = sprintf( _n( '%d lead marked as contacted.', '%d leads marked as contacted.', count( $post_ids ), 'krishpms' ), count( $post_ids ) );
            //     add_settings_error( 'sales_leads_list_table', 'bulk_contacted', $message, 'success' );
            //     break;
        }
    }*/
}
