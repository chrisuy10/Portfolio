<?php include "header.php" ?>
<body>
	<?php include "nav.php"; ?>

    <div id="enroll" class="container">
		<h1>Register Student Details</h1><hr>
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


</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
    //var divContent = document.getElementById("response").innerHTML;

    // Set the content to the hidden input field
    //document.getElementById("content").value = divContent;
</script>