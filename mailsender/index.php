<?php
include  "function.php";

//for testing http://mailsender.test/reference-code/mailsender/
?>
<!DOCTYPE html>
<html>
<head>
	<title>RFID Attendance</title>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
		.navbar {
			background-color: #4CAF50;
		}

		.nav-link {
			color: #FFFFFF;
		}

		.footer {
			background-color: #4CAF50;
			color: #FFFFFF;
			padding: 20px;
		}

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

		form {
			margin-top: 20px;
		}
        body {
			background-color: #f2f2f2;
		}
		.container {
			background-color: white;
			margin-top: 50px;
			padding: 50px;
			border-radius: 10px;
			box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
		}
		h1 {
			text-align: center;
			margin-bottom: 30px;
		}
		input[type="submit"] {
			margin-top: 20px;
		}
	</style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light">
		<a class="navbar-brand" href="#">RFID Attendance</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
			aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav">
				<li class="nav-item active">
					<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Enroll Students</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Check Attendance</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Attendance Log</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Mark Absent</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Attendance Record</a>
				</li>
			</ul>
		</div>
	</nav>
    <div id="enroll" class="container">
		<h1>Enroll Student Details</h1><hr>
		<form action="" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label for="yearsem">Year and Semester:</label>
				<select class="form-control col-md-4" id="yearsem" name="yearsem">
					<option value="">Select Year and Semester</option>
					<option value="2023-1ST">2023-1ST</option>
					<option value="2023-2ND">2023-2ND</option>
					<option value="2024-1ST">2024-1ST</option>
					<option value="2024-2ND">2024-2ND</option>

				</select>
			</div>


			<div class="form-group row">
                <div class="col-md-6">
                    <label for="firstname">First Name:</label>
                    <input type="text" class="form-control" id="firstname" name="firstname">
                </div>
                <div class="col-md-6">
                    <label for="lastname">Last Name:</label>
                    <input type="text" class="form-control" id="lastname" name="lastname">
                </div>
            </div>

			<div class="form-group row">
                <div class="col-md-12">
                    <label for="address">Complete Address:</label>
                    <input type="text" class="form-control" id="address" name="address">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="studentID">Student ID:</label>
                    <input type="text" class="form-control" id="studentID" name="studentID">
                </div>
                <div class="col-md-6">
                    <label for="course">Course:</label>
                    <input type="text" class="form-control" id="course" name="course">
                </div>
            </div>
			<div class="form-group row">
                <div class="col-md-6">
                    <label for="phone">Emergency Contact No.:</label>
                    <input type="text" class="form-control" id="phone" name="phone">
                </div>
                <div class="col-md-6">
                    <label for="rfid">RFID:</label>
                    <input type="text" class="form-control" id="rfid" name="rfid">
                </div>
            </div>
			<div class="form-group row">
				<div class="col-md-6">
					<input class="form-control" type="file" name="profile-pic" id="profile-pic">
                </div>				
            </div>

			<input type="submit" class="btn btn-primary" name="enroll" value="Submit">
		</form>
        <?php 
            if (isset($_POST['enroll'])) {
                insert($conn);
				echo $insert_result;
				echo "<script>document.getElementById('enroll').scrollIntoView();</script>";
            }
        ?>
	</div> 
    
    <br><br>
	<div class="container">
		<h1>RFID Attendance</h1>
		<form method="post" action="">
			<div class="form-group">
				<label for="rfid">RFID:</label>
				<input type="text" class="form-control col-md-4" name="rfid">
			</div>
			<button type="submit" class="btn btn-primary" name="attendance_log">Submit</button>
		</form>
        <?php
            if (isset($_POST['attendance_log'])) {
                submit_rfid($conn);
				echo "<script>document.getElementById('output').scrollIntoView();</script>";
            }
        ?>
	</div>

    <br><br>
    <div class="container">
		<h1>Marked Absent all</h1>
		<form method="POST" action="">
            <div class="form-group">
				<label for="date">Date:</label>
				<input type="date" class="form-control col-md-4" id="datepicker" name="date">
			</div>
		    <button type="submit" class="btn btn-primary" name="absentnow">Submit</button>
		</form>
        <?php
            if (isset($_POST['absentnow'])) {
                marked_absent($conn);
            }
        ?>
	</div>
    
    <div class="container">
        <h1 class="text-center">Check Attendance Record</h1>
        <form id="attendanceForm"  method="POST">
            <div class="form-group">
                <label for="rfid">RFID:</label>
                <input type="text" id="rfid" name="rfid" class="form-control col-md-4" required>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="start_date">Start Date:</label>
                    <input type="date" id="start_date" name="start_date" class="form-control " required>
                </div>
                <div class="col-md-4">
                    <label for="end_date">End Date:</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" required>
                </div>
            </div>
			<input type="hidden" name="content" id="content">
            <button type="submit" name="checking2" class="btn btn-primary" formaction="export-attendance.php">Export Data</button>
			<button type="submit" name="check_display" class="btn btn-primary" formaction="">Display/Check Attendance</button>
        </form>
        <div id="response" class="mt-4"></div>
        <?php include 'attendance-checker.php'; ?>
        
	</div>

	<br><br>
    <div class="container">
		<h1>Check Attendance</h1>
		<form method="POST" action="">
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="date">Date:</label>
                    <input type="date" class="form-control" id="datepickers" name="date">
                </div>
                <div class="col-md-6">
                    <label for="rfid">RFID:</label>
                    <input type="text" class="form-control" name="rfid">
                </div>
            </div>
			<button type="submit" class="btn btn-primary" name="checking">Check Attendance</button>
		</form>
        <?php
            if (isset($_POST['checking'])) {
                attendance_checker($conn);
            }
        ?>
	</div>s
    


</body>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script>
		var divContent = document.getElementById("response").innerHTML;

		// Set the content to the hidden input field
		document.getElementById("content").value = divContent;
	</script>

