<?php
include  "database.php";
//for testing http://mailsender.test/reference-code/mailsender/
?>

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
<form action="submit_rfid.php" method="post">
    <label for="rfid">RFID:</label>
    <input type="text" id="rfid" name="rfid"><br><br>

    <input type="submit" value="Submit">
</form>
