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

        <input type="submit" value="Submit">
    </form>

    <br><br>
    <h1>Check Attendance</h1>
    <form method="POST" action="">
        <label>RFID:</label>
        <input type="text" name="rfid"><br><br>
        <label>Date:</label>
        <input type="date" name="date"><br><br>
        <button type="submit" name="submit">Check Attendance</button>
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
</body>