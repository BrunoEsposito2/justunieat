<?php
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "just_database";

 $connection = new mysqli($servername, $username, $password, $dbname);
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }

    $id = $_POST["id"];
     
	$result  = mysqli_query($connection , "UPDATE messaggio SET Letto=1 WHERE ID_USER='$id'");
    $conn->close();
?>