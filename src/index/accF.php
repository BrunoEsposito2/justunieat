<?php

define("HOST", "localhost"); // E' il server a cui ti vuoi connettere
define("USER", "admin_user"); // E' l'utente con cui ti collegherai al DB.
define("PASSWORD", "Justunieat2019"); // Password di accesso al DB.
define("DATABASE", "just_database"); // Nome del database.
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}



if(isset($_POST["emailF"])){
  $queryLogF = $mysqli->prepare("SELECT * FROM fornitore WHERE Email = ? AND Password = ?");
  $queryLogF->bind_param("ss",$_POST["emailF"], $_POST["passwordF"]);

  $queryLogF->execute();

  //$queryLogF->bind_result($NomeF, $CognomeF, $RistoranteF, $CellulareF, $Partita_IVAF, $EmailF, $PasswordF, $ValutazioneF, $ID_FORNITOREF);

  $result = $queryLogF->get_result();

  $num_rows = $result->num_rows;

  if($num_rows > 0){
    //Corrispondenza trovata, loggo l'utente

    while($row = $result->fetch_assoc()){

      //echo $row["Email"] . "<br>" . $row["Nome"] . "<br>" . $row["Cognome"];
      session_start();
      $_SESSION["Nome"] = $row["Nome"];
      $_SESSION["Cognome"] = $row["Cognome"];
      header("location: /Progetto2019/src/Fornitori/HomeF.php");
    }
  } else {
    //Ritorno alla pagina di login
    echo "Nessuna corrispondenza trovata";
    header("location: accediV2.php?errF=1");
  }
}
