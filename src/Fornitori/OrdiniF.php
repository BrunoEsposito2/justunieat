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

$QueryOrdF= $mysqli->prepare("SELECT * FROM ordine WHERE ID_RESTURANT = ? AND ORDINE_INVIATO = 1 ORDER BY Orario_richiesto DESC");
$QueryOrdF->bind_param("i", $_SESSION["ID_FORNITORE"]);

$QueryOrdF->execute();

$result = $QueryOrdF->get_result();
$i=0;
while($row = $result->fetch_assoc()){
  $ord[$i] = $row["ID_ORDINE"];
  $time[$i] = $row["Orario_Richiesto"];
  $state[$i] = $row["Stato"];
  $user[$i] = $row["ID_USER"];
  $rest[$i] = $row["ID_RESTURANT"];
  $loc[$i] = $row["Luogo"];
  $val[$i] = $row["valutazione"];
  $sent[$i] = $row["ORDINE_INVIATO"];

  //echo '<br>'.$ord[$i].' '.$time[$i].' '.$state[$i].' '.$user[$i].' '.$rest[$i].' '.$loc[$i].' '.$val[$i].' '.$sent[$i]."<br>";
  $i++;
}
//var_dump(count($ord));
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
     <title>Just Uni Eat Fornitori - I tuoi ordini</title>
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

<!--I TUOI ORDINI -->

<div id="accordion" class="container col-sm-12 col-md-8">
  <h2 style="text-align:center">I TUOI ORDINI</h2>
  <div class="card">
    <table class="card-header table" id="headingTitle">
      <thead>
      <h5 class="mb-0">
        <tr class="">
          <th>ORDINE</th>
          <th>TEMPO</th>
          <th>STATO</th>
          <th></th>
        </tr>
      </thead>
    </table>
  </div>
<?php
for($i=0; $i< count($ord); $i++){
  echo '<div class="card">
        <button class="btn btn-default card-header" id="headingOne" data-toggle="collapse" data-target="#collapse'.$ord[$i].'" aria-expanded="true" aria-controls="collapseOne">
          '.$ord[$i].'
        </button>

    <div id="collapse'.$ord[$i].'" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
      <table class="card-body table">
      <tbody>
        <tr class="row">
          <td class="col-lg-3" style="text-align:center">'.$ord[$i].'</td>
          <td class="col-lg-3" style="text-align:center">'.$time[$i].'</td>
          <td class="col-lg-3" style="text-align:center">';

          if($state[$i]==1)
                  echo 'Concluso</br>';
                else if ($state[$i]==0)
                  echo 'In consegna</br>';
                else if ($state[$i]==-1)
                  echo 'Annullato</br>';


          echo'</td>
          <td class="col-lg-3" style="text-align:center"><button onclick="window.location.href=\'OrdineCompleto.php?n='.$ord[$i].'\'">Dettagli</button></td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>';
}
 ?>

  <button class="btn btn-default col" style="margin-top:1em" onclick="window.location.href='HomeF.php'">INDIETRO</button>
</div>



 </body>
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>
