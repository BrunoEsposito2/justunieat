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

$QueryDatiF = $mysqli->prepare("SELECT * FROM fornitore WHERE ID_FORNITORE = ?");
$QueryDatiF->bind_param("i", $_SESSION["ID_FORNITORE"]);
$QueryDatiF->execute();
$result = $QueryDatiF->get_result();

while($res = $result->fetch_assoc()){
  $Nome = $res["Nome"];
  $Cognome = $res["Cognome"];
  $Ristorante = $res["Ristorante"];
  $Cellulare = $res["Cellulare"];
  $Partita_IVA = $res["Partita_IVA"];
  $Citta = $res["Città"];
  $Via_e_Num = $res["Via_e_Num"];
  $Foto = $res["path_photo"];
  $Email = $res["Email"];
  $Valutazione = $res["Valutazione"];
  $ID = $res["ID_FORNITORE"];
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

<div class="container-fluid col-lg-8 col-sm-12">
  <h4 class="mb-0" style="text-align:center">I TUOI DATI</h4>
  <br>
  <h5 class="mb-0" style="text-align:center"><?php echo $Ristorante; ?></h5><br>
  <div class="container-fluid row">
  <div class="col-lg-6 col-sm-12">
    Nome: <?php echo $Nome; ?><br>
    Cognome: <?php echo $Cognome; ?><br>
    Ristorante: <?php echo $Ristorante; ?><br>
    Partita IVA: <?php echo $Partita_IVA; ?><br>
    Cellulare: <?php echo $Cellulare; ?><br>
    Email: <?php echo $Email; ?><br>
    <br>
    Città: <?php echo $Citta; ?><br>
    Indirizzo: <?php echo $Via_e_Num; ?>
    <br><br>
    <h5 class="mb-0">Il tuo ID: <?php echo $ID; ?></h5>
  </div>
  <div class="col-lg-6 col-sm-12">
    <?php if($Foto!=NULL){
    echo '<h6 class="mb-0">La tua immagine:</h6>
    <img src="../index/resturant_photo/<?php echo $Foto; ?>" style="height:200px; width:200px;">
    <h6 class="mb-0">Carica una nuova immagine:</h6>
    <input class="btn btn-primary" type="file" name="myfile">';

  } else {
    echo '<h6 class="mb-0">Non hai ancora caricato una tua immagine!</h6>
      <img src="../index/resturant_photo/sad.jpg" style="height:200px; width:200px;">
      <h6 class="mb-0">Carica subito un\'immagine!</h6>';

  }
  ?>
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Modifica i tuoi dati
  </button>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Modifica dati <?php echo $Ristorante;?></h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <form enctype="multipart/form-data" action="ModifyDataF.php" method="POST">
        <label for="Nome">Nome: </label>
        <input type="text" class="form-control" name="Nome" placeholder="Nome" value="<?php echo $Nome;?>"></input>

        <label for="Cognome">Cognome: </label>
        <input type="text" class="form-control" name="Cognome" placeholder="Cognome" value="<?php echo $Cognome;?>"></input>

        <label for="Ristorante">Ristorante: </label>
        <input type="text" class="form-control" name="Ristorante" placeholder="Ristorante" value="<?php echo $Ristorante;?>"></input>

        <label for="Partita_IVA">Partita IVA: </label>
        <input type="text" class="form-control" name="Partita_IVA" placeholder="Partita_IVA" value="<?php echo $Partita_IVA;?>"></input>

        <label for="Cellulare">Cellulare: </label>
        <input type="text" class="form-control" name="Cellulare" placeholder="Cellulare" value="<?php echo $Cellulare;?>"></input>

        <label for="Città">Città: </label>
        <input type="text" class="form-control" name="Città" placeholder="Città" value="<?php echo $Citta;?>"></input>

        <label for="Indirizzo">Indirizzo: </label>
        <input type="text" class="form-control" name="Via_e_Num" placeholder="Indirizzo" value="<?php echo $Via_e_Num;?>"></input>

        <label for="foto">Immagine: </label>
        <input type="file" name="foto" class="btn btn-primary" style="margin-top:1em">

        <button style="margin-top:1em" class="btn btn-primary">Salva modifiche</button>
      </form>

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>

    </div>
  </div>
</div>
</div>


  <button class="btn btn-default col" style="margin-top:1em" onclick="window.location.href='HomeF.php'">INDIETRO</button>
</div>
 </body>
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>
