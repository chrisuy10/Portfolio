<?php
$conn = database();
$insert_result = '';
$response = '';
$card = '';
$marked_absent_result = '';

function database(){

    // Connect to the MySQL database
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "db_attendance";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}
function insert($conn){
    // Get the form data
    $yearsem = $_POST['yearsem'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $studentID = $_POST['studentID'];
    $course = $_POST['course'];
    $email = $_POST['email'];
    $rfid = $_POST['rfid'];

    // Prepare a statement with placeholders
    $stmt = mysqli_prepare($conn, "INSERT INTO tbl_students (fld_yearsem, fld_firstname, fld_lastname, fld_studentID, fld_course, fld_email, fld_rfid) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Bind variables to the placeholders
    mysqli_stmt_bind_param($stmt, "sssssss", $yearsem, $firstname, $lastname, $studentID, $course, $email, $rfid);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        $insert_result = "New record created successfully";
    } else {
        $insert_result = "Error: " . mysqli_error($conn);
    }

    // Close the statement
    mysqli_stmt_close($stmt);

    // Return the insert result
    return $insert_result;
}
function insert1($conn){
    
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
        $insert_result = "New record created successfully";
    } else {
        $insert_result = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    echo $insert_result;
} 

function submit_rfid($conn){
    $phone = 639385129959;
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
        $card = "<div class='card'>
                    <h2>Student Information</h2>
                    <p><strong>Name:</strong> $firstname $lastname</p>
                    <p><strong>Student ID:</strong> $studentID</p>
                    <p><strong>Course:</strong> $course</p>
                    <p><strong>Email:</strong> $email</p>
                </div>"; 
        
                $curl = curl_init();
                $data = array(
                  'api_key' => "2N85dnCuQl4PQoAWlSTE5P0YmZ5",
                  'api_secret' => "9ps3D8bMRFe4pShXmDwhq4I1vc0ghqYwJg3AQT6F",
                  'text' => "Hello!
            
                    Student Name is Present, TIME IN at Time
            
                    Have a great day ahead.",
                  'to' => "$phone",
                  'from' => "Attendance Monitoring"
                );
            
                curl_setopt_array($curl, array(
                  CURLOPT_URL => "https://api.movider.co/v1/sms",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_CUSTOMREQUEST => "POST",
                  CURLOPT_POSTFIELDS => http_build_query($data),
                  CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/x-www-form-urlencoded",
                    "cache-control: no-cache"
                  ),
                ));
            
                $response = curl_exec($curl);
                $err = curl_error($curl);
            
                curl_close($curl);
            
                if ($err) {
                  echo "cURL Error #:" . $err;
                } else {
                  echo $response;
                }

    } else {
        $card =  "RFID not found";
    }
    echo $card;
}

function attendance_checker($conn){
    
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
    echo '<h1>' . $response . '</h1>';
    
}

function marked_absent($conn){

    include "send_email.php"; //UPDATE --- $send_to = 'chrisbenedictuy19@gmail.com'; $send_to_name = 'benedict uy';

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
    $marked_absent_result = "Attendance records added for date $date.";
    echo $marked_absent_result;
}

