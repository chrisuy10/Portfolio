<?php

if(isset($_POST['attendance_log'])) {
    // Get the form data
    $rfid = $_POST['rfid'];

    // Check if the RFID exists in the tbl_students table
    $sql = "SELECT * FROM tbl_students WHERE fld_rfid = '$rfid' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // If the RFID exists, get the data for the card
        $row = mysqli_fetch_assoc($result);
        $yearsem = $row['fld_yearsem'];
        $firstname = $row['fld_firstname'];
        $lastname = $row['fld_lastname'];
        $studentID = $row['fld_studentID'];
        $course = $row['fld_course'];
        $email = $row['fld_email'];

        $date = date("Y-m-d"); // Set the date to today's date
        $status = 'Present'; // Set the status to 'Present' by default

        $sql2 = "INSERT INTO tbl_attendance_records (fld_yearsem, fld_date, fld_studentID, fld_status) 
        VALUES ('$yearsem', '$date', '$studentID', '$status')";
        mysqli_query($conn, $sql2);

        // Output the response message with the student's data
        echo "<div class='card'>
                <h2>Student Information</h2>
                <p><strong>Name:</strong> $firstname $lastname</p>
                <p><strong>Student ID:</strong> $studentID</p>
                <p><strong>Course:</strong> $course</p>
                <p><strong>Email:</strong> $email</p>
             </div>";
    } else {
        echo "RFID not found";
    }
}

?>
