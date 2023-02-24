<?php
include  "database.php";
//for testing http://mailsender.test/reference-code/mailsender/
?>
<!DOCTYPE html>
<html>
<head>
	<title>RFID Attendance</title>
    <style>
        .card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2);
            margin: 20px auto;
            max-width: 400px;
            padding: 20px;
            text-align: center;
        }

        .card h1 {
            font-size: 1.5em;
            margin-bottom: 0.5em;
        }

        .card p {
            font-size: 1.2em;
        }

    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	
</head>

<body>
    <h1>Enroll Student Details</h1>
    <form action="insert.php" method="post">
        <label for="yearsem">Year and Semester:</label>
        <input type="text" id="yearsem" name="yearsem"><br><br>

        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname"><br><br>

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname"><br><br>

        <label for="studentID">Student ID:</label>
        <input type="text" id="studentID" name="studentID"><br><br>

        <label for="course">Course:</label>
        <input type="text" id="course" name="course"><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email"><br><br>

        <label for="rfid">RFID:</label>
        <input type="text" id="rfid" name="rfid"><br><br>

        <input type="submit" name="enroll" value="Submit">
    </form>
<?php
	include "insert.php";
?> 

    <br><br>
    <h1>Check Attendance</h1>
    <form method="POST" action="">
        <label>RFID:</label>
        <input type="text" name="rfid"><br><br>
        <label>Date:</label>
        <input type="text" id="datepickers" name="date"><br><br>
        <button type="submit" name="checking">Check Attendance</button>
    </form>
<?php
	include "attendance-checker.php";
?>   
    
    <br><br>
	<h1>RFID Attendance</h1>
	<form method="post" action="">
		<label>RFID:</label>
		<input type="text" name="rfid">
		<button type="submit" name="attendance_log">Submit</button>
	</form>
<?php
	include "submit_rfid.php";
?>

    <br><br>
    <h1>Marked Absent all</h1>
    <form method="POST" action="">
        <label for="datepicker">Date:</label>
        <input type="text" id="datepicker" name="date">
        <button type="submit" name="absentnow">Submit</button>
    </form>
<?php
	include "absentnow.php";
?>
</body>
<script>
	$(function() {
		$("#datepicker").datepicker({dateFormat: 'yy-mm-dd'}).val(new Date().toISOString().slice(0, 10));
        $("#datepickers").datepicker({dateFormat: 'yy-mm-dd'}).val(new Date().toISOString().slice(0, 10));
	});
</script>