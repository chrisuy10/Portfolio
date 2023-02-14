<?php

include  "database.php";

// Get the form data
$rfid = $_POST['rfid'];

// Check if the RFID exists in the tbl_students table
$sql = "SELECT * FROM tbl_students WHERE fld_rfid = '$rfid' LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // If the RFID exists, fill the table with the data
    $row = mysqli_fetch_assoc($result);
    $yearsem = $row['fld_yearsem'];
    $date = date("Y-m-d"); // Set the date to today's date
    $studentID = $row['fld_studentID'];
    $status = 'Present'; // Set the status to 'Present' by default

    $sql2 = "INSERT INTO tbl_attendance_records (fld_yearsem, fld_date, fld_studentID, fld_status) 
    VALUES ('$yearsem', '$date', '$studentID', '$status')";

    if (mysqli_query($conn, $sql2)) {
        echo "Attendance recorded successfully";
    } else {
        echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
    }
} else {
    echo "RFID not found";
}

// Close the database connection
mysqli_close($conn);
?>
