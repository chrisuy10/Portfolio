<?php

include "send_email.php"; //UPDATE --- $send_to = 'chrisbenedictuy19@gmail.com'; $send_to_name = 'benedict uy';

if (isset($_POST['absentnow'])) {
  // Set the date for the attendance record
  $date = mysqli_real_escape_string($conn, $_POST['date']);

  // Get all student IDs that do not have an attendance record for the date
  $sql = "SELECT * FROM tbl_students
          WHERE fld_studentID NOT IN (
            SELECT DISTINCT fld_studentID FROM tbl_attendance_records WHERE fld_date = '$date'
          )";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    $studentID = $row['fld_studentID'];
    $yearsem = $row['fld_yearsem'];
    $absences = $row['fld_absences'];
    $email = $row['fld_email'];
    $firstname = $row['fld_firstname'];
    $lastname = $row['fld_lastname'];
    // Insert an absent record for the student
    $status = "Absent";
    
    $sql = "INSERT INTO tbl_attendance_records (fld_yearsem, fld_date, fld_studentID, fld_status) 
            VALUES ('$yearsem', '$date', '$studentID', '$status')";
    mysqli_query($conn, $sql);

    // Update the number of absences for the student in the tbl_students table
    $sql = "UPDATE tbl_students SET fld_absences = fld_absences + 1 WHERE fld_studentID = '$studentID'";
    mysqli_query($conn, $sql);

    // Send notification to student with 3 or more absences and reset their absences to zero
    if ($absences >= 3) {      
      $sql = "UPDATE tbl_students SET fld_absences = 0 WHERE fld_studentID = '$studentID'";
      mysqli_query($conn, $sql);


      
      $send_to = $email;
      $send_to_name = $firstname . " " . $lastname;
      $body = $emailBody->getBody($send_to_name);

      $mailer = new Mailer();
      $mailer->sendMail($send_to, $send_to_name, $subject, $body);
    }
  }
  echo "Attendance records added for date $date.";
}

  ?>