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

$queryFindPiattoF = $mysqli->prepare("SELECT * FROM pietanza WHERE ID_MENU = ? AND ID_PIETANZA = ?");
$queryFindPiattoF->bind_param("ii", $_SESSION["ID_FORNITORE"], $_POST["eliminare"]);

$queryFindPiattoF->execute();

$result = $queryFindPiattoF->get_result();

$num_rows = $result->num_rows;

while($row = $result->fetch_assoc()){
  $nome = $row["Nome"];
  $descrizione = $row["Descrizione"];
  $valutazione = $row["Valutazione"];
  $prezzo = $row["Prezzo"];
  $vegetariano = $row["Vegetariano"];
  $piccante = $row["Piccante"];
  $tipologia = $row["Tipologia"];
  $idmenu = $row["ID_MENU"];
  $idpietanza = $row["ID_PIETANZA"];
}
//Da completare

$queryFindPiattoF->close();

$queryDeleteP = $mysqli->prepare("DELETE FROM pietanza WHERE ID_PIETANZA = ? AND ID_MENU = ?");
$queryDeleteP->bind_param("ii", $_POST["eliminare"], $_SESSION["ID_FORNITORE"]);

$queryDeleteP->execute();

$_SESSION["piatto"] = $nome;

header("location: ListinoF.php?del=1");

 ?>
