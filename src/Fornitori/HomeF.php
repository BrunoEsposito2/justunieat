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

$QueryOrdiniF = $mysqli->prepare("SELECT * FROM ordine WHERE ID_RESTURANT = ? AND ORDINE_INVIATO = 1 AND Stato != -1");
$QueryOrdiniF->bind_param("i", $_SESSION["ID_FORNITORE"]);

$QueryOrdiniF->execute();

$result = $QueryOrdiniF->get_result();

$i=0;
while($row = $result->fetch_assoc()){
  $ord[$i] = $row["ID_ORDINE"];
  $ora[$i] = $row["Orario_Richiesto"];
  $state[$i] = $row["Stato"];
  $user[$i] = $row["ID_USER"];
  $rist[$i] = $row["ID_RESTURANT"];
  $loc[$i] = $row["Luogo"];
  $val[$i] = $row["valutazione"];
  $sent[$i] = $row["ORDINE_INVIATO"];
  //echo $ord[$i];
  $i++;
}

$QueryOrdiniF->close();

$queryPiattiF = $mysqli->prepare("SELECT Nome, Prezzo, Tipologia, Valutazione FROM pietanza WHERE ID_MENU = ?");
$queryPiattiF->bind_param("i", $_SESSION["ID_FORNITORE"]);

$queryPiattiF->execute();

$resultp = $queryPiattiF->get_result();

$y=0;
while($ress = $resultp->fetch_assoc()){
  $name[$y] = $ress["Nome"];
  $prezzo[$y] = $ress["Prezzo"];
  $tipo[$y] = $ress["Tipologia"];
  $valp[$y] = $ress["Valutazione"];
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
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

     <title>Just Uni Eat Fornitori</title>
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
              <a class="nav-link" href="#">Benvenuto!</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><?php echo $_SESSION["Nome"] . " " . $_SESSION["Cognome"];?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Notifiche</a> <!--da rendere hidden se non si ha fatto ancora l'accesso-->
             </li>
             <li class="nav-item">
                 <a class="nav-link" href="#">Miei Ordini</a> <!--da rendere hidden se non si ha fatto ancora l'accesso-->
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/Progetto2019/src/index/logout.php">Esci</a> <!--da rendere hidden se non si ha fatto ancora l'accesso-->
             </li>
           </ul>
        </div>
       </div>
     </nav>

<!--BODY-->

<!--I TUOI ORDINI -->
<button class="ShowMenuF btn btn-default row" style="margin:1em" onclick="ToggleMenu()">Menu</button></br>
<script> function ToggleMenu() {

  $(".containerMenu").toggle();
}
</script>

<div class="containerMenu col-sm-12 col-md-4" style="margin-left: 2%; float:left;">

  <button class="btn btn-default" style="margin-bottom:0.5em" onclick="window.location.href='DatiF.php'">I TUOI DATI</button></br>
  <button class="btn btn-default" style="margin-bottom:0.5em" onclick="window.location.href='OrdiniF.php'">ORDINI</button></br>
  <button class="btn btn-default" style="margin-bottom:0.5em" onclick="window.location.href='ListinoF.php'">LISTINO</button></br>

</div>


<div class="container col-sm-12 col-md-8">
  <h1 style="text-align:center"><?php echo $_SESSION["Ristorante"] . "<br>";?></h1>
  <h2 style="text-align:center">I TUOI ORDINI</h2>

  <table class="table table-hover">
    <thead>
      <tr>
        <th>ORDINE</th>
        <th>ORARIO</th>
        <th>LUOGO</th>
        <th>STATO</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if(count($ord) < 5){
          $maxx = count($ord);
      } else {
      $maxx = 4;
      }
      for($x=0; $x < $maxx; $x++){
       echo '<tr>
              <td>'.$ord[$x].'</td>
              <td>'.$ora[$x].'</td>
              <td>'.$loc[$x].'</td>
              <td>'.$state[$x].'</td>
            </tr>';
      }
      ?>


    </tbody>
  </table>

  <div class="col-sm-2"></div>
  <button class="btn btn-default col-sm-4" onclick="window.location.href='OrdiniF.php'"> Vedi tutti gli ordini </button>
  <div class="col-sm-2"></div>
</div>
</br>
<!--I TUOI PIATTI -->
<div class="container col-sm-12 col-md-8">
  <h2 style="text-align:center">I TUOI PIATTI</h2>

  <table class="table table-hover">
    <thead>
      <tr>
        <th>PIATTO</th>
        <th>TIPOLOGIA</th>
        <th>PREZZO</th>
        <th>VALUTAZIONE</th>
      </tr>
    </thead>
    <tbody>

      <?php
        if(count($name) < 5){
          $maxp = count($name);
        } else {
          $maxp = 4;
        }
        for($h=0; $h < $maxp; $h++){
          echo '<tr>
            <td>'.$name[$h].'</td>
            <td>'.$tipo[$h].'</td>
            <td>'.$prezzo[$h].'</td>
            <td>'.$valp[$h].'</td>
          </tr>';
        }
      ?>

    </tbody>
  </table>

<div class="col-sm-2"></div>
  <button class="btn btn-default col-sm-4" onclick="window.location.href='ListinoF.php'"> Vedi tutti i tuoi piatti </button>
<div class="col-sm-2"></div>
</div>
 </body>
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>
