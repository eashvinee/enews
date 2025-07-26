<?php


class Pdfgen_Download{
    public function __construct(){
        add_action( 'init', [$this, 'form_action'] );
    }
    public function form_action(){
        if(isset( $_GET['pdfgen'] ) && $_GET['pdfgen']== 'certificate'){
            // Verify nonce for security.
            if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'pdfgen_certificate_nonce' ) ) {
                wp_die( __( 'Security check failed!', 'pdfgen' ), __( 'Error', 'pdfgen' ), array( 'response' => 403 ) );
            }

            // Ensure user is logged in.
            if ( ! is_user_logged_in() ) {
                wp_die( __( 'You must be logged in to generate a certificate.', 'pdfgen' ), __( 'Error', 'pdfgen' ), array( 'response' => 401 ) );
            }

            $this->certificate_download();

        }
    }
    function certificate_download() {
        
        $current_user = wp_get_current_user();
        //$current_user = get_user_by( 'ID', $user_id );
        if ( ! $current_user ) {
            wp_die( __( 'User not found.', 'pdfgen' ), __( 'Error', 'pdfgen' ), array( 'response' => 404 ) );
        }

        $user_display_name = $current_user->display_name;
        $issue_date = date_i18n( get_option( 'date_format' ) ); // Localized date format

        $template='template/type1'; //TEMPLATE PATH
        // Prepare HTML content for the PDF.
        $html = $this->get_template($template, $user_display_name,  $issue_date );

        //echo $html;
        //die;
        include_once (PDFGEN_PLUGIN_DIR.'pdfgen-dompdf.php');
        exit; // Important: Stop further WordPress execution after PDF generation.
    
    }
    function get_template( $template, $user_name, $issue_date ) {
        $certificate_url = PDFGEN_PLUGIN_URL .$template. '/background.jpg'; // Path to your logo image
        
        ob_start(); // Start output buffering to build HTML string
        include_once PDFGEN_PLUGIN_DIR.$template.'/html.php';
        return ob_get_clean(); // Return the HTML string
    }
}

