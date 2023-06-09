<?php

$servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "just_database";

        $mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

session_start();

if(!isset($_SESSION["ID_FORNITORE"])){
  header("location: ../index/accedi.php");
}

$QuerySelectCats = $mysqli->prepare("SELECT Nome FROM categoria_ristorante");
$QuerySelectCats->execute();
$resCats = $QuerySelectCats->get_result();
$i = 0;
while($cat[$i] = $resCats->fetch_array(MYSQLI_NUM)){
  echo count($cat);
  $i++;
}

$QuerySelectCats->close();

for($x = 0; $x < count($cat)-1; $x++){
  $QueryFindCatID = $mysqli->prepare("SELECT ID_CAT FROM categoria_ristorante WHERE Nome = ?");
  $QueryFindCatID->bind_param("s", $cat[$x][0]);
  $QueryFindCatID->execute();
  $QueryFindCatID->bind_result($catx);
  $QueryFindCatID->fetch();
  echo "<br>".$catx;
  $QueryFindCatID->close();
  if(isset($_POST[$cat[$x][0]])){
    echo "<br><br>".$cat[$x][0]." ".$_POST[$cat[$x][0]];

    $QueryAddCats = $mysqli->prepare("INSERT INTO categorie(ID_FORNITORE, ID_CAT) VALUES (?, ?)");
    $QueryAddCats->bind_param("ii", $_SESSION["ID_FORNITORE"], $catx);
    $QueryAddCats->execute();
    $QueryAddCats->close();
  } else {
    echo "<br><br>".$cat[$x][0];
    $QueryDeleteCat = $mysqli->prepare("DELETE FROM categorie WHERE ID_FORNITORE = ? AND ID_CAT = ?");
    $QueryDeleteCat->bind_param("ii", $_SESSION["ID_FORNITORE"], $catx);
    $QueryDeleteCat->execute();
    $QueryDeleteCat->close();
  }
}

header("location: ListinoF.php?cats=1");
