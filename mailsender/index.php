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
    <form method="POST" action="attendance-checker.php">
        <label>RFID:</label>
        <input type="text" name="rfid"><br><br>
        <label>Date:</label>
        <input type="date" name="date"><br><br>
        <button type="submit">Check Attendance</button>
    </form>
    <br><br>

	<h1>RFID Attendance</h1>
	<form method="post" action="">
		<label>RFID:</label>
		<input type="text" name="rfid">
		<button type="submit">Submit</button>
	</form>

<?php
	if(isset($_POST['rfid'])) {
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

	// Close the database connection
	mysqli_close($conn);
?>
</body>