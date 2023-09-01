<?php

require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

// Get the HTML content from the desired element
$html = '<html><head><title>Test PDF</title></head><body>' . $_POST['content'] . '</body></html>';

// Create a new Dompdf instance
$dompdf = new Dompdf();

// Load the HTML content into Dompdf
$dompdf->loadHtml($html);

// Set the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as a PDF
$dompdf->render();

// Output the generated PDF to the browser
$dompdf->stream('test.pdf');

?>