<?php
include  "function.php";
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

// Get the form data
$start_date = "";
$end_date = "";

if(isset($_POST['checking2'])){
  $rfid = $_POST['rfid'];
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];

  // Check if the RFID exists in the tbl_students table
  $sql = "SELECT * FROM tbl_students WHERE fld_rfid = '$rfid' LIMIT 1";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    // If the RFID exists, get the student's data
    $row = mysqli_fetch_assoc($result);
    $studentID = $row['fld_studentID'];

    // Check the attendance record of the student between the specified start and end date
    $sql2 = "SELECT * FROM tbl_attendance_records WHERE fld_studentID = '$studentID' AND fld_date BETWEEN '$start_date' AND '$end_date'";
    $result2 = mysqli_query($conn, $sql2);

    // Create the HTML content for the attendance record
    $html = '<!DOCTYPE html>
             <html>
             <head>
             <meta charset="UTF-8">
             <title>Attendance Record</title>
             <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
             </head>
             <body>
             <h2 class="text-center">Attendance Record for Student with RFID '.$rfid.' between '.$start_date.' and '.$end_date.'</h2>';
    $html .= '<div class="container">';
    $html .= '<table class="table table-striped table-bordered table-sm mx-auto" style="max-width: 700px;"><tr><th>Date</th><th>Attendance Status</th></tr>';

    // Loop through each date between start and end date
    $date = $start_date;
    while (strtotime($date) <= strtotime($end_date)) {
      $found_record = false;
      mysqli_data_seek($result2, 0);
      while($row2 = mysqli_fetch_assoc($result2)) {
        if ($row2['fld_date'] == $date) {
          $found_record = true;
          $status = $row2['fld_status'];
          $html .= '<tr><td>'.$date.'</td><td>'.$status.'</td></tr>';
        }
      }
      if (!$found_record) {
        $html .= '<tr><td>'.$date.'</td><td>No Work</td></tr>';
      }
      $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
    }
    $html .= '</table>';
    $html .= '</div>';


    $html .= '<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
              <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
              <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>';

    $html .= '</body></html>';

    // Create a new Dompdf instance
    $dompdf = new Dompdf();

    // Load the HTML content into Dompdf
    $dompdf->loadHtml($html);
    $dompdf->set_option('isRemoteEnabled', true);

    // Set the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as a PDF
    $dompdf->render();

    // Output the generated PDF to the browser
    $dompdf->stream('test.pdf');

  } else {
    $response = "RFID not found";
    echo '<h1>' . $response . '</h1>';
  }
}


?>
