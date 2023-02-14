<?php
include  "database.php";

// Get the form data
$rfid = $_POST['rfid'];
$date = $_POST['date'];

// Check if the RFID exists in the tbl_students table
$sql = "SELECT * FROM tbl_students WHERE fld_rfid = '$rfid' LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // If the RFID exists, get the student's data
    $row = mysqli_fetch_assoc($result);
    $studentID = $row['fld_studentID'];

    // Check if the student is present on the specified date
    $sql2 = "SELECT * FROM tbl_attendance_records WHERE fld_studentID = '$studentID' AND fld_date = '$date' LIMIT 1";
    $result2 = mysqli_query($conn, $sql2);

    if (mysqli_num_rows($result2) > 0) {
        $response = "Student is present on $date";
    } else {
        $response = "Student is absent on $date";
    }
} else {
    $response = "RFID not found";
}

echo $response;

// Close the database connection
mysqli_close($conn);
?>
