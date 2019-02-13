<?php
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "just_database";

 $connection = new mysqli($servername, $username, $password, $dbname);
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }

	
	$email = $_POST['email'];
	
     
	$result  = mysqli_query($connection , "SELECT * utente WHERE Email='$email'");

	if($result) {
		echo "Email già presente";
	}
	

?>