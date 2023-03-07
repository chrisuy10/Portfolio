<?php
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

    if (mysqli_num_rows($result2) > 0) {
      // Loop through each record and display it
      echo '<h1>Attendance Record for Student with RFID '.$rfid.' between '.$start_date.' and '.$end_date.'</h1>';
      echo '<table><tr><th>Date</th><th>Attendance Status</th></tr>';
      while($row2 = mysqli_fetch_assoc($result2)) {
        $date = $row2['fld_date'];
        $status = $row2['fld_status'];
        echo '<tr><td>'.$date.'</td><td>'.$status.'</td></tr>';
      }
      echo '</table>';
    } else {
      $response = "No attendance record found for the student between $start_date and $end_date";
      echo '<h1>' . $response . '</h1>';
    }
  } else {
    $response = "RFID not found";
    echo '<h1>' . $response . '</h1>';
  }
}
?>
