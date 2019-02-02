<?php
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "just_database";

 $connection = new mysqli($servername, $username, $password, $dbname);
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }

	
	$nome = $_POST['nome'];
	$cognome = $_POST['cognome'];
	$email = $_POST['email'];
    $cell = $_POST['cell'];
    $abilitato = $_POST['abilitato'];
    $id = $_POST["id"];
     
	$result  = mysqli_query($connection , "UPDATE utente SET Nome='$nome' , Cognome='$cognome' , Email = '$email', Cellulare='$cell', Abilitato='$abilitato' WHERE ID_USER='$id'");
	if($result){
        echo "UPDATE utente SET Nome='$nome' , Cognome='$cognome' , Email = '$email', Cellulare='$cell', Abilitato='$abilitato' WHERE ID_USER='$id'";
	}

?>