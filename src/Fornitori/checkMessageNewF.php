<?php
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "just_database";

 $connection = new mysqli($servername, $username, $password, $dbname);
 if ($connection->connect_error) {
     die("Connection failed: " . $connection->connect_error);
 }


	$id_user = $_POST['id_user'];


	$result = mysqli_query($connection , "SELECT * FROM messaggio WHERE ID_RISTORANTE = '".$id_user."' AND Letto = 0 AND Ricevuto_Dal_Utente = 0");

	if(mysqli_num_rows($result) > 0) {
		echo "1";
	} else {
		echo "0";
	}


?>
