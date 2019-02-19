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
//echo $_SESSION["Nome"] . "<br>" . $_SESSION["Cognome"];

$uploaddir = "../index/resturant_photo/";



if(isset($_FILES["foto"])){
  $nomefile = $_FILES["foto"]["name"];


}

$userfile_tmp = $_FILES["foto"]["tmp_name"];

if (move_uploaded_file($userfile_tmp, $uploaddir . $nomefile)){
  echo "Funziona";
} else {
  echo "Non caricato";
}

if(isset($_POST["Nome"]) &&
   isset($_POST["Cognome"]) &&
   isset($_POST["Ristorante"]) &&
   isset($_POST["Partita_IVA"]) &&
   isset($_POST["Cellulare"]) &&
   isset($_POST["Città"]) &&
   isset($_POST["Via_e_Num"])){

  $QueryUpdateData = $mysqli->prepare("UPDATE fornitore SET path_photo = ? ,Nome = ?, Cognome = ?, Ristorante = ?, Partita_IVA = ?, Cellulare = ?, Città = ?, Via_e_Num = ? WHERE ID_FORNITORE = ?");
  $QueryUpdateData->bind_param("ssssssssi", $nomefile, $_POST["Nome"], $_POST["Cognome"], $_POST["Ristorante"], $_POST["Partita_IVA"], $_POST["Cellulare"], $_POST["Città"], $_POST["Indirizzo"], $_SESSION["ID_FORNITORE"]);
  $QueryUpdateData->execute();
  $QueryUpdateData->close();



  header("location: ModifyDataF.php?e=0");

} else {
  header("location: ModifyDataF.php?e=1");
}
