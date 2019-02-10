<?php
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "just_database";

 $connection = new mysqli($servername, $username, $password, $dbname);
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }

	

 $VALUE = $_POST["ID"];

 $ID_ORDINE = $_POST["ID_ORDINE"];
     
	$result  = mysqli_query($connection , "UPDATE ordine SET Valutazione='$VALUE' WHERE ID_ORDINE='$ID_ORDINE'");

?>