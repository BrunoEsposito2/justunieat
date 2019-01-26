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

  $result = $queryLogF->get_result();

  $num_rows = $result->num_rows;

  if($num_rows > 0){
    //Corrispondenza trovata, loggo l'utente

    while($row = $result->fetch_assoc()){

      //echo $row["Email"] . "<br>" . $row["Nome"] . "<br>" . $row["Cognome"];
      session_start();
      $_SESSION["Nome"] = $row["Nome"];
      $_SESSION["Cognome"] = $row["Cognome"];
      $_SESSION["Ristorante"] = $row["Ristorante"];
      $_SESSION["Cellulare"] = $row["Cellulare"];
      $_SESSION["Partita_IVA"] = $row["Partita_IVA"];
      $_SESSION["Email"] =  $row["Email"];
      $_SESSION["ID_FORNITORE"] = $row["ID_FORNITORE"];
      header("location: /Progetto2019/src/Fornitori/HomeF.php");
    }
  } else {
    //Ritorno alla pagina di login
    echo "Nessuna corrispondenza trovata";
    header("location: accediV2.php?errF=1");
  }
}
