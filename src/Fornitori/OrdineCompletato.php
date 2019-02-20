<?php
define("HOST", "localhost"); // E' il server a cui ti vuoi connettere
define("USER", "admin_user"); // E' l'utente con cui ti collegherai al DB.
define("PASSWORD", "Justunieat2019"); // Password di accesso al DB.
define("DATABASE", "just_database"); // Nome del database.
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

session_start();

if(!isset($_SESSION["ID_FORNITORE"])){
  header("location: ../index/accedi.php");
}

$query = "SELECT Stato, ID_USER FROM ordine WHERE ID_ORDINE = '".$_POST["ORDINE"]."'";

$result = $mysqli->query($query);


if($result){
  $row = $result->fetch_array(MYSQLI_ASSOC);
  echo $row["ID_USER"];
  if($row["Stato"] == 0){
    $query2 = "UPDATE ordine SET Stato = 1 WHERE ID_ORDINE = '".$_POST["ORDINE"]."'";
    $mysqli->query($query2);

    header("location: OrdiniF.php");
  } else {
    header("location: OrdiniF.php");
  }
}
