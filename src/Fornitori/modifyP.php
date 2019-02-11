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

  $queryModifyP = $mysqli->prepare("SELECT * FROM pietanza WHERE ID_PIETANZA = ? AND ID_MENU = ?");
  $queryModifyP->bind_param("ii", $_POST["ModificaPiattoF"], $_SESSION["ID_FORNITORE"]);

  $queryModifyP->execute();

  $result = $queryModifyP->get_result();

  //var_dump($result);

  echo "<br>". $_POST["ModificaPiattoF"];

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

  if(isset($_POST["VegP"])){
    $veg = 1;
  } else {
    $veg = 0;
  }

  if(isset($_POST["PicP"])){
    $pic = 1;
  } else {
    $pic = 0;
  }

  $queryModifyP->close();

  $queryModP = $mysqli->prepare("UPDATE pietanza SET Nome = ?, Descrizione = ?, Prezzo = ?, Vegetariano = ?, Piccante = ?, Tipologia = ? WHERE ID_MENU = ? AND ID_PIETANZA = ? ");
  $queryModP->bind_param("ssdiisii",$_POST["NomePiatto"], $_POST["DescrizionePiatto"], $_POST["PrezzoPiatto"], $veg, $pic, $_POST["TipoPiatto"], $_SESSION["ID_FORNITORE"], $_POST["ModificaPiattoF"]);

  $queryModP->execute();

  $queryModP->close();

  $_SESSION["piatto"] = $nome;

  header("location: ListinoF.php?mod=1");
?>
