
<?php include "header.php" ?>
<body>
	<?php include "nav.php"; ?> 
    <div class="container-fluid" style="padding-right: 0px;padding-left: 0px;">
        <img src="images/cube.jpg" width="100%"  height="700px" alt="Banner">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <a href="page1.html">
                <img src="images/code1.jpg" alt="Image 1" class="img-fluid">
                </a>
            </div>
            <div class="col-md-6">
                <a href="page2.html">
                <img src="images/code2.jpg" alt="Image 2" class="img-fluid">
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <a href="page1.html">
                <img src="images/code3.jpg" alt="Image 1" class="img-fluid">
                </a>
            </div>
            <div class="col-md-6">
                <a href="page2.html">
                <img src="images/code1.jpg" alt="Image 2" class="img-fluid">
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <a href="page1.html">
                <img src="images/code2.jpg" alt="Image 1" class="img-fluid">
                </a>
            </div>
            <div class="col-md-6">
                <a href="page2.html">
                <img src="images/code3.jpg" alt="Image 2" class="img-fluid">
                </a>
            </div>
        </div>
    </div>

<!-- tag before the code and a 
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
-->     


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

