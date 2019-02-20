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
    //$query2 = "UPDATE ordine SET Stato = 0 WHERE ID_ORDINE = '".$_POST["ORDINE"]."'";
    //$mysqli->query($query2);

    $testo = "L ordine ".$_POST["ORDINE"]. " è stato spedito.";
    $orario=time();
    $data=date('d-m-y');
    $titolo ="Il tuo ordine";
    $id_user = $row["ID_USER"];
    $id_ristorante = $_SESSION["ID_FORNITORE"];
    $ricev_utente = 1;
    $queryMessage = "INSERT INTO messaggio ( Testo ,  Data ,  Titolo ,  Orario ,  ID_USER ,  ID_RISTORANTE ,  Ricevuto_Dal_Utente)
                                    VALUES ('".$testo."', '".$data."', '".$titolo."', '".$orario."', '".$id_user."', '".$id_ristorante."', '".$ricev_utente."')";

    $mysqli->query($queryMessage);
    header("location: OrdiniF.php");
  } else {
    header("location: OrdiniF.php");
  }
}
