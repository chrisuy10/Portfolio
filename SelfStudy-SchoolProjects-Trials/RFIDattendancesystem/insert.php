<?php

if (isset($_POST['enroll'])) {
    // Get the form data
    $yearsem = $_POST['yearsem'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $studentID = $_POST['studentID'];
    $course = $_POST['course'];
    $email = $_POST['email'];
    $rfid = $_POST['rfid'];

    // Insert the data into the table
    $sql = "INSERT INTO tbl_students (fld_yearsem, fld_firstname, fld_lastname, fld_studentID, fld_course, fld_email, fld_rfid) 
    VALUES ('$yearsem', '$firstname', '$lastname', '$studentID', '$course', '$email', '$rfid')";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}


?>
