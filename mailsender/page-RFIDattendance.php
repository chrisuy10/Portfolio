<?php include "header.php" ?>
<style>
    body {
    z-index: 0;
    background-image: url('images/banner-dog.jpg');
    background-size: cover; /* to cover the entire screen */
    background-repeat: no-repeat; /* to avoid repeating the image */
    }
</style>
<body>
	<?php include "nav.php"; ?>
	<div id="log_rfid" class="container-fluid">
		<h1>RFID Attendance</h1>
		<form method="post" action="">
			<div class="form-group">
				<label for="rfid">RFID:</label>
				<input type="text" class="form-control col-md-2" name="rfid">
			</div>
			<button type="submit" class="btn btn-primary" name="attendance_log">Submit</button>
		</form>
        <?php
            if (isset($_POST['attendance_log'])) {
                submit_rfid($conn);
				echo "<script>document.getElementById('log_rfid').scrollIntoView();</script>";
            }
        ?>
	</div>

</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
    window.onload = function() {
        document.getElementsByName("rfid")[0].focus();
    };
    var divContent = document.getElementById("response").innerHTML;

    // Set the content to the hidden input field
    document.getElementById("content").value = divContent;
</script>