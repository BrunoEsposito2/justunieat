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

$QueryOrdine = $mysqli->prepare("SELECT ordine.ID_ORDINE, ordine.Orario_Richiesto, ordine.Stato, ordine.ID_USER, ordine.Luogo, ordine.valutazione, pietanza.Nome, pietanza.Prezzo, pietanza_nel_ordine.Quantita, utente.Nome as UName, utente.Cellulare
                                 FROM ordine, pietanza_nel_ordine, pietanza, utente
                                 WHERE ordine.ID_ORDINE=pietanza_nel_ordine.ID_ORDINE
                                 AND pietanza_nel_ordine.ID_PIETANZA = pietanza.ID_PIETANZA
                                 AND ordine.ID_USER = utente.ID_USER
                                 AND ordine.ID_RESTURANT = ?
                                 AND ordine.ID_ORDINE = ?
                                 AND ordine.ORDINE_INVIATO = 1");
$QueryOrdine->bind_param("ii", $_SESSION["ID_FORNITORE"], $_GET["n"]);
$QueryOrdine->execute();

$result = $QueryOrdine->get_result();
$i=0;
while($row = $result->fetch_assoc()){
  $ord[$i] = $row["ID_ORDINE"];
  $time[$i] = $row["Orario_Richiesto"];
  $state[$i] = $row["Stato"];
  $user[$i] = $row["ID_USER"];
  $loc[$i] = $row["Luogo"];
  $val[$i] = $row["valutazione"];
  $nome[$i] = $row["Nome"];
  $prezzo[$i] = $row["Prezzo"];
  $qta[$i] = $row["Quantita"];
  $UName[$i] = $row["UName"];
  $cell[$i] = $row["Cellulare"];
  $i++;
}
//echo $ord[0]." ".$time[0]." ".$state[0]." ".$user[0]." ".$loc[0]." ".$val[0]." ".$nome[0]." ".$prezzo[0]." ".$qta[0]." ".$UName[0]." ".$cell[0];

$QueryOrdine->close();

$QueryPietanzeOrdine = $mysqli->prepare("SELECT pietanza_nel_ordine.Quantita, pietanza.Nome, pietanza.Prezzo FROM pietanza_nel_ordine, pietanza WHERE ID_ORDINE= ?
                                         AND pietanza_nel_ordine.ID_PIETANZA = pietanza.ID_PIETANZA");
$QueryPietanzeOrdine->bind_param("i", $ord[0]);


$QueryPietanzeOrdine->execute();

$resp = $QueryPietanzeOrdine->get_result();


$x=0;
while($res = $resp->fetch_assoc()){
  $pname[$x] = $res["Nome"];
  $pqta[$x] = $res["Quantita"];
  $pprice[$x] = $res["Prezzo"];

  //echo "<br>".$pname[$x]." ".$pqta[$x]."</br>";
  $x++;
}

 ?>

 <!DOCTYPE html>
 <html lang="it-IT">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <!--Bootstrap CSS-->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
     <link rel="stylesheet" href="style.css">
     <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
     <link rel="icon" href="http://example.com/favicon.png">
     <title>Just Uni Eat Fornitori - Ordine #ADDNUMBERWITHPHPORJS</title>
 </head>

 <body>
   <!---HEADER--->
   <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
       </button>
       <a class="navbar-brand" href="#">Just Uni Eat</a>
        <a href="#">
          <img class="carts" src="../../doc/shopping-cart-empty-side-view.png" alt="shopping carts">
         </a>
       <div class="collapse navbar-collapse" id="navbarSupportedContent">
         <div class="navbar-nav float-left text-left pr-3">
           <ul class="navbar-nav mr-auto">
             <li class="nav-item">
              <a class="nav-link" href="#">Accedi</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Registrati</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Notifiche</a> <!--da rendere hidden se non si ha fatto ancora l'accesso-->
             </li>
             <li class="nav-item">
                 <a class="nav-link" href="#">Miei Ordini</a> <!--da rendere hidden se non si ha fatto ancora l'accesso-->
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Esci</a> <!--da rendere hidden se non si ha fatto ancora l'accesso-->
             </li>
           </ul>
        </div>
       </div>
     </nav>

<!--IL TUO ORDINE -->

<div class="menu col-lg-4">
</div>

<div class="container-fluid col-lg-8 col-sm-12 ">
  <h5 class="mb-0 " style="text-align:center;">ORDINE #<?php echo $ord[0];?></h5>

  <div class="container-fluid row">
    <div class="col-sm-6 col" style="">
      Orario Richiesto: <?php echo $time[0];?></br>
      <?php for ($x=0; $x < count($pname); $x++){
        echo 'Piatto: '.$pname[$x].'</br>';
        echo 'Quantità: '.$pqta[$x].'</br>';
        echo 'Prezzo: '.$pprice[$x].'</br>';
      } ?>
      Luogo: <?php echo $loc[0];?></br>

      <?php if($state[0]==1)
              echo 'Stato: concluso.</br>';
            else if ($state[0]==0)
              echo 'Stato: In consegna.</br>';
            else if ($state[0]==-1)
              echo 'Stato: Annullato.</br>';
      ?>
    </div>

    <div class="col-sm-6 col">
      ID_Utente: <?php echo $user[0];?></br>
      Nome: <?php echo $UName[0];?></br>
      Telefono:<?php echo $cell[0];?></br>
    </div>
</div>

  <h5 class="mb-0" style="text-align:center">Valutazione</h5>
  <?php if($val[0] == NULL){
    echo '<h6 class="mb-0" style="text-align:center">L\'ordine non è ancora stato valutato.</h6>';
  } else {
    
  }
  ?>
  <button class="btn btn-default col" style="margin-top:1em" onclick="window.location.href='OrdiniF.php'">INDIETRO</button>
</div>


 </body>
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>
