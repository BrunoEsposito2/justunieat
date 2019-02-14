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
$x = 2;
$QueryIDCat = $mysqli->prepare("SELECT ID_CAT FROM categorie WHERE ID_FORNITORE = ?");
$QueryIDCat->bind_param("i", $x);

$QueryIDCat->execute();

$QueryIDCat->bind_result($ids);

while($QueryIDCat->fetch())
var_dump($ids);
echo "<br><br>";

$QueryIDCat->close();

$QueryCheckCats = $mysqli->prepare("SELECT categoria_ristorante.ID_CAT, categoria_ristorante.Nome FROM categorie, categoria_ristorante WHERE categorie.ID_FORNITORE = ? AND categorie.ID_CAT = categoria_ristorante.ID_CAT");
$QueryCheckCats->bind_param("i", $_SESSION["ID_FORNITORE"]);

$QueryCheckCats->execute();

$QueryCheckCats->bind_result($idcats, $cats);

$queryAdd = "INSERT INTO categorie(ID_FORNITORE, ID_CAT) VALUES ";

while($QueryCheckCats->fetch()){
  $add = false;
for($i = 0; $i<count($ids); $i++){
  if($ids[$i] == $idcats)
    $add = true;
}
if($add && $i!=0)
  $queryAdd +=", ";

if($add){
  $queryAdd += "(?, ?)";
}

echo $cats."<br>".$idcats;

}


echo "<br><br>".$queryAdd;
