<?php include "header.php" ?>
<body>
	<?php include "nav.php"; ?>
    
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

</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
    var divContent = document.getElementById("response").innerHTML;

    // Set the content to the hidden input field
    document.getElementById("content").value = divContent;
</script>