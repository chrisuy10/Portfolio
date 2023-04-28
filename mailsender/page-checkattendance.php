<?php include "header.php" ?>
<body>
	<?php include "nav.php"; ?>
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
    

</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
    var divContent = document.getElementById("response").innerHTML;

    // Set the content to the hidden input field
    document.getElementById("content").value = divContent;
</script>