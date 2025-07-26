<?php 

use Dompdf\Options;
use Dompdf\Dompdf;


// Configure Dompdf options.
$options = new Options();
$options->set( 'isHtml5ParserEnabled', true );
$options->set( 'isRemoteEnabled', true ); // Allow loading remote images (e.g., Gravatar)
$options->set( 'defaultFont', 'sans-serif' ); // Fallback font

// Instantiate Dompdf with options.
$dompdf = new Dompdf( $options );

// Load HTML into Dompdf.
$dompdf->loadHtml( $html );

// (Optional) Set paper size and orientation.
$dompdf->setPaper( 'A4', 'landscape' ); // 'portrait' or 'landscape'

// Render the HTML as PDF.
$dompdf->render();

// Output the generated PDF (inline or download).
$filename = sanitize_title( $user_display_name . '-' . date('Y-m-d') ) . '-certificate.pdf';
$dompdf->stream( $filename, array( 'Attachment' => true ) ); // 'Attachment' => true for download, false for inline view
