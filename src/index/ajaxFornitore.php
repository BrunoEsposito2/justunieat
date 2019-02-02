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
    $partita_iva = $_POST['partita_iva'];
    $cell = $_POST['cell'];
    $citta = $_POST['citta'];
    $via = $_POST['via'];
    $ristorante = $_POST['ristorante'];
    $id = $_POST["id"];
     
	$result  = mysqli_query($connection , "UPDATE fornitore SET Nome='$nome' , Cognome='$cognome' , Email = '$email', Ristorante='$ristorante', Partita_IVA='$partita_iva', Cellulare='$cell', Via_e_Num='$via', Città='$citta' WHERE ID_FORNITORE='$id'");
	if($result){
		echo "UPDATE fornitore SET Nome='$nome' , Cognome='$cognome' , Email = '$email', Ristorante='$ristorante', Partita_IVA='$partita_iva', Cellulare='$cell', Via_e_Num='$via', Città='$citta' WHERE ID_FORNITORE='$id'";
	}

?>