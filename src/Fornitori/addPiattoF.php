<?php
session_start();
define("HOST", "localhost"); // E' il server a cui ti vuoi connettere
define("USER", "admin_user"); // E' l'utente con cui ti collegherai al DB.
define("PASSWORD", "Justunieat2019"); // Password di accesso al DB.
define("DATABASE", "just_database"); // Nome del database.
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

if(!isset($_SESSION["ID_FORNITORE"])){
  header("location: ../index/accedi.php");
}

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if(isset($_POST["NomePiatto"]) &&
   isset($_POST["DescrizionePiatto"]) &&
   isset($_POST["TipoPiatto"]) &&
   isset($_POST["PrezzoPiatto"])
 ){
   echo $_POST["NomePiatto"] . "<br>" . $_POST["DescrizionePiatto"] . "<br>" . $_POST["TipoPiatto"] . "<br>" . $_POST["PrezzoPiatto"];

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

   $queryCheckP = $mysqli->prepare("SELECT Nome FROM pietanza WHERE Nome = ? AND ID_MENU = ?");
   $queryCheckP->bind_param("si", $_POST["NomePiatto"], $_SESSION["ID_FORNITORE"]);

   $queryCheckP->execute();

   $queryCheckP->bind_result($piatto);

   $queryCheckP->fetch();

   echo "<br><br>" . $piatto . "<br><br>";

   $queryCheckP->close();

   if($piatto==NULL){

     $queryRegP = $mysqli->prepare("INSERT INTO pietanza(Nome, Descrizione, Prezzo, Vegetariano, Piccante, Tipologia, ID_MENU) VALUES (?, ?, ?, ?, ?, ?, ?)");

     $queryRegP->bind_param("ssdiisi", $_POST["NomePiatto"], $_POST["DescrizionePiatto"], $_POST["PrezzoPiatto"], $Veg, $Piccante, $_POST["TipoPiatto"], $_SESSION["ID_FORNITORE"]);

     $queryRegP->execute();


     echo $queryRegP->error;

     $queryRegP->close();

     $_SESSION["piatto"] = $_POST["NomePiatto"];
     header("Location: ListinoF.php?c=1");
   } else {
     $_SESSION["piatto"] = $piatto;
      header("location: ListinoF.php?e=1");
   }

 }
?>
