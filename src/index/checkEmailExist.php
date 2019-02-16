<?php
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "just_database";

 $connection = new mysqli($servername, $username, $password, $dbname);
 if ($connection->connect_error) {
     die("Connection failed: " . $connection->connect_error);
 }

	
	$email = $_POST['email'];
	
     
	$result  = mysqli_query($connection , "SELECT * FROM utente WHERE Email='$email'");
	

	if(mysqli_num_rows($result)) {
		echo "1";
	}
	

?>