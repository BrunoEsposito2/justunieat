<?php

define("HOST", "localhost"); // E' il server a cui ti vuoi connettere
define("USER", "admin_user"); // E' l'utente con cui ti collegherai al DB.
define("PASSWORD", "Justunieat2019"); // Password di accesso al DB.
define("DATABASE", "just_database"); // Nome del database.
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if(isset($_POST["NomePiatto"]) &&
   isset($_POST["DescrizionePiatto"]) &&
   isset($_POST["TipoCucina"]) &&
   isset($_POST["TipoPiatto"]) &&
   isset($_POST["PrezzoPiatto"])
 ){
   echo $_POST["NomePiatto"] . "<br>" . $_POST["DescrizionePiatto"] . "<br>" . $_POST["TipoCucina"] . "<br>" . $_POST["TipoPiatto"] . "<br>" . $_POST["PrezzoPiatto"];

   if(isset($_POST["PicP"])){
     $Piccante = 1;
   } else {
     $Piccante = 0;
   }

   if(isset($_POST["VegP"])){
     $Veg = 1;
   } else {
     $Veg = 0;
   }

   $queryRegP = $mysqli->prepare("INSERT INTO pietanza(Nome, Descrizione, Prezzo, Vegetariano, Piccante, Tipologia) VALUES (?, ?, ?, ?, ?, ?)");

   $queryRegP->bind_param("sssiis", $_POST["NomePiatto"], $_POST["DescrizionePiatto"], $_POST["PrezzoPiatto"], $Veg, $Piccante, $_POST["TipoCucina"]);



 }
?>
