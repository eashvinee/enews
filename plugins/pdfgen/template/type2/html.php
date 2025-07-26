<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title><?php echo esc_html( $user_name ); ?> - Certificate</title>
        <style>
            /* Basic certificate styling */
            body {
                font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f8f8f8;
            }
            .hide{display: none;}
            /*size refrence: jspdf.js */
            .certificate-container {
                width: 1024px; /* A4 Landscape Width: 841.89px */
                height: 695px; /* A4 Landscape Height: 595.28px */
                /*padding: 50px;*/
               /* box-sizing: border-box; */
                text-align: center;
               /* border: 10px solid #0073aa; /* Main border * /
                background-color: #ffffff;*/
                position: relative;
                overflow: hidden; /* Ensure borders are within bounds */
                margin: 0 auto; /* Center the container on the page */
                background:url("<?php echo esc_url( $certificate_url); ?>");
                background-repeat: no-repeat;
                background-position: center center;
 background-size: cover;
 /* background-attachment: fixed;*/
            }
            .certificate-header {
                margin-bottom: 40px;
            }
            .certificate-logo {
                max-width: 150px;
                height: auto;
                margin-bottom: 20px;
            }
            .certificate-title {
                font-size: 12px;
                color: #0073aa;
                margin: 0;
                padding: 0;
                text-transform: uppercase;
                letter-spacing: 2px;
                /*border-bottom: 2px solid #eee;*/
                padding-bottom: 10px;
            }
            .certificate-subtitle {
                font-size: 12px;
                color: #555;
                margin-top: 10px;
            }
            .certificate-body {
                margin-top: 290px;
                margin-bottom: 50px;
            }
            .certificate-body p {
                font-size: 28px;
                color: #333;
                line-height: 1.6;
            }
            .recipient-name {
                font-size: 28px; /* Larger font for recipient name */
                font-weight: bold;
                color: #333;
                margin: 30px 0;
                text-transform: capitalize;
            }
            .course-name {
                font-size: 12px;
                font-weight: 600;
                color: #0073aa;
                margin: 20px 0;
            }
            .certificate-footer {
                display: flex; /* Flexbox might not work perfectly in all Dompdf versions */
                justify-content: space-around;
                align-items: flex-end;
                margin-top: 170px;
            }
            .signature-block {
                display: inline-block; /* Use inline-block for better compatibility */
                width: 45%;
                text-align: center;
                margin: 0 2%;
            }
            .signature-line {
                /*border-top: 1px solid #000;*/
                margin-top: 40px; /* Space for actual signature */
                padding-top: 5px;
                font-size: 16px;
                color: #666;
            }
            .issue-date {
                font-size: 16px;
                color: #777;
                margin-top: 30px;
            }
            /* Optional: Background pattern or border design */
          /*  .certificate-container::before {
                content: "";
                position: absolute;
                top: 20px;
                left: 20px;
                right: 20px;
                bottom: 20px;
                border: 2px solid #a0d2e7; /* Inner border * /
                border-radius: 5px;
                z-index: -1;
            }*/
        </style>
    </head>
    <body>
        <div class="certificate-container">
            <div class="certificate-header">
                <?php /* if ( file_exists( CERTIFICATE_PLUGIN_DIR . 'template/course.png' ) ) : ?>
                    <img src="<?php echo esc_url( $logo_url ); ?>" alt="Company Logo" class="certificate-logo">
                <?php endif; */ ?>
                <h1 class="certificate-title hide"><?php _e( 'Certificate of Achievement', 'certificate-generator' ); ?></h1>
                <p class="certificate-subtitle hide"><?php _e( 'This certifies that', 'certificate-generator' ); ?></p>
            </div>

            <div class="certificate-body">
                <p class="recipient-name"><?php echo esc_html( $user_name ); ?></p>
                <p class="hide"><?php _e( 'has successfully completed the', 'certificate-generator' ); ?></p>
                <p class="course-name hide"><?php //echo esc_html( $course_name ); ?></p>
            </div>

            <div class="certificate-footer">
                <div class="signature-block">
                    <p class="signature-line"><?php /*_e( 'Date Issued: ', 'certificate-generator' );*/ ?><?php echo esc_html( $issue_date ); ?></p>
                </div>
                <div class="signature-block">
                    <p class="signature-line hide"><?php _e( 'Authorized Signature', 'certificate-generator' ); ?></p>
                </div>
                
            </div>
        </div>
    </body>
    </html>