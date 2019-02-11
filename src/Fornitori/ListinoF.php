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

if(isset($_GET["mod"])){
  echo "Il piatto" . $_SESSION["piatto"] . " è stato modificato";
}

if(isset($_GET["c"])){
  echo "Il piatto " . $_SESSION["piatto"] . " è stato inserito";
}

if(isset($_GET["e"])){
  echo "Errore: Il piatto " . $_SESSION["piatto"] . " esiste già.";
}

if(isset($_GET["del"])){
  echo "Il piatto " . $_SESSION["piatto"] . " è stato eliminato.";
}

$queryListF = $mysqli->prepare("SELECT * FROM pietanza WHERE ID_MENU = ?");
$queryListF->bind_param("i", $_SESSION["ID_FORNITORE"]);

$queryListF->execute();

$result = $queryListF->get_result();

$rows = $result->num_rows;

//echo $_SESSION["ID_FORNITORE"] . "<br>";
//echo $rows;

//var_dump($result);

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
     <title>Just Uni Eat Fornitori - Il tuo Listino</title>
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
                <a class="nav-link" href="#">Esci</a> <!--da rendere hidden se non si ha fatto ancora l'accesso-->
             </li>
           </ul>
        </div>
       </div>
     </nav>

<!--I TUOI ORDINI -->

<div id="accordion" class="container col-sm-12 col-md-8">

  <h1 style="text-align:center"><?php echo $_SESSION["Ristorante"] . "<br>";?></h1>
  <h2 style="text-align:center">IL TUO LISTINO</h2>
  <div class="card">
    <div class="card-header" id="headingTitle">
      <h5 class="mb-0" style="text-align:center"> I TUOI PIATTI</h5>

    </div>
  </div>

  <?php if($rows > 0){
    while($ris = $result->fetch_assoc()){

    //Prints Accordion header
    echo '<div class="card">
      <button class="btn btn-default card-header" id="headingOne" data-toggle="collapse" data-target="#'.$ris["Nome"].'" aria-expanded="true" aria-controls="collapseOne">
            '.$ris["Nome"].'
          </button>
      </div>';

    //Prints accordion body
    echo '<div id="'.$ris["Nome"].'" class="collapse container-fluid" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body row">

        <div class="classDescrPiatto col-sm-4 col-lg-4">
          <label for="DescrizionePiatto">Descrizione:</label>
          <p name="DescrizionePiatto">'.$ris["Descrizione"].'</p>
        </div>

        <div class="classTipoPiatto col-sm-4 col-lg-4">
          <label for="TipoCucina">Tipologia:</label>
          <h6 name="TipoCucina">'.$ris["Tipologia"].'</h6>
        </div>

        <div class="classButtonsPiatto col-sm-4 col-lg-4">';


        if($ris["Vegetariano"]){
        echo '<div class="col-sm-12">
          Vegetariano
        </div>';
        }

        if($ris["Piccante"]){
        echo '<div class="col-sm-12">
          Piccante
        </div>';
        }
        echo  '<label for="PrezzoPiatto">Prezzo: </label>
          <h6 class="mb-0" name="PrezzoPiatto">'.$ris["Prezzo"].'</h6>

          <!-- ADD JS OR PHP-->

            <button class="btn btn-default" data-toggle="modal" data-target="#Modify'.$ris["Nome"].'" name="modificare" value="'.$ris["ID_PIETANZA"].'">Modifica</button>

          <form action="deletePiatto.php" method="post">
            <button class="btn btn-default" onclick="jsDelete(this.parentElement.parentElement.parentElement.parentElement.id)" name="eliminare" id="'.$ris["Nome"].'" value="'.$ris["ID_PIETANZA"].'">Elimina</button>
          </form>
        </div>
      </div>
    </div>';

    echo '<div class="modal fade" id="Modify'.$ris["Nome"].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <form action="modifyP.php" method="post">
                <div class="modal-body row">
                    <div class="classDescrPiatto col-sm-12 col-lg-4">
                      <label for="NomePiatto">Nome:</label>
                      <textarea class="form-control " name="NomePiatto" placeholder="Nome del piatto">'.$ris["Nome"].'</textarea>


                      <label for="DescrizionePiatto">Descrizione:</label>
                      <textarea class="form-control " name="DescrizionePiatto" placeholder="Descrizione del piatto">'.$ris["Descrizione"].'</textarea>
                    </div>

                    <div class="classTipoPiatto col-sm-12 col-lg-4">';


                      echo '<label for="TipoPiatto">Piatto:</label>
                      <select class="form-control" name="TipoPiatto">
                        <option value="Primo" ';
                        if ($ris["Tipologia"] == 'Primo') echo 'selected';
                        echo'>Primo</option>

                        <option value="Secondo" ';
                        if ($ris["Tipologia"] == 'Secondo') echo 'selected';
                        echo'>Secondo</option>

                        <option value="Contorno" ';
                        if ($ris["Tipologia"] == 'Contorno') echo 'selected';
                        echo'>Contorno</option>

                        <option value="Dolce" ';
                        if ($ris["Tipologia"] == 'Dolce') echo 'selected';
                        echo'>Dolce</option>

                        <option value="Bevanda" ';
                        if ($ris["Tipologia"] == 'Bevanda') echo 'selected';
                        echo'>Bevanda</option>

                      </select>
                    </div>

                    <div class="classButtonsPiatto col-sm-12 col-lg-4">
                      <div class="classCheckboxes">
                        <div class="col-sm-12">
                          <label for="VegP">Vegetariano</label>
                          <input type="checkbox" name="VegP"';
                          if($ris["Vegetariano"]==1) echo 'checked';
                          echo'>
                        </div>
                        <div class="col-sm-12">
                          <label for="PicP">Piccante</label>
                          <input type="checkbox" name="PicP"';
                          if($ris["Piccante"]==1) echo 'checked';
                          echo'>
                        </div>

                        <label for="PrezzoPiatto">Prezzo: </label>
                        <textarea class="form-control" name="PrezzoPiatto" placeholder="Prezzo">'.$ris["Prezzo"].'</textarea>
                      </div>

                      <!-- ADD JS AND/OR PHP-->
                      <button class="btn btn-default row" name="ModificaPiattoF" value="'.$ris["ID_PIETANZA"].'" style="margin-top:1em;">Conferma</button>
                    </div>
                  </div>
                  </form>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
              </div>
            </div>
          </div>';
    }
  }
  ?>




  <script type="text/javascript" >
  function jsDelete(clicked_id) {
    var x = confirm("Sicuro di voler eliminare la pietanza " + clicked_id + " ?");
    if(x){

    } else {
      this.event.preventDefault();
    }
  }

  function jsModify(clicked_id) {
    var x = confirm("Modifica pietanza " + clicked_id + " .");
    var y = document.getElementById("Modify" + clicked_id);
    y.style.visibility = "visible";
    this.event.preventDefault();
  }
  </script>

  <div class="card">
        <button id="headingThree" class="card-header btn btn-default collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Aggiungi piatto
        </button>
    </div>

    <div id="collapseThree" class="collapse container-fluid" aria-labelledby="headingThree" data-parent="#accordion">
      <div class="card-body">
        <!-- ADD PHP -->
        <form action="addPiattoF.php" method="POST" class="container-fluid row">

        <div class="classDescrPiatto col-sm-12 col-lg-4">
        <label for="NomePiatto">Nome:</label>
        <textarea class="form-control " name="NomePiatto" placeholder="Nome del piatto"></textarea>


          <label for="DescrizionePiatto">Descrizione:</label>
          <textarea class="form-control " name="DescrizionePiatto" placeholder="Descrizione del piatto"></textarea>
        </div>

        <div class="classTipoPiatto col-sm-12 col-lg-4">

          <label for="TipoPiatto">Piatto:</label>
          <select class="form-control" name="TipoPiatto">
            <option>Primo</option>
            <option>Secondo</option>
            <option>Contorno</option>
            <option>Dolce</option>
            <option>Bevanda</option>
          </select>
        </div>

        <div class="classButtonsPiatto col-sm-12 col-lg-4">
          <div class="classCheckboxes">
            <div class="col-sm-12">
              <label for="VegP">Vegetariano</label>
              <input  type="checkbox" name="VegP">
            </div>
            <div class="col-sm-12">
              <label for="PicP">Piccante</label>
              <input type="checkbox" name="PicP">
            </div>

            <label for="PrezzoPiatto">Prezzo: </label>
            <textarea class="form-control" name="PrezzoPiatto" placeholder="Prezzo"></textarea>
          </div>

          <!-- ADD JS AND/OR PHP-->
          <button class="btn btn-default row" name="InserisciPiattoF" style="margin-top:1em;">Conferma</button>
          </div>

      </form>
      </div>
    </div>


  <button class="btn btn-default col" style="margin-top:1em" onclick="window.location.href='HomeF.php'">INDIETRO</button>

</div>

  <!-- CATEGORIE -->
  <div class="container-fluid col-sm-12 col-md-8 col-lg-8">
  <h5 class="mb-0" style="text-align:center; margin-top:1em;"> LE TUE CATEGORIE</h5>

  <div class="Categorie container-fluid">
    <label class="row" for="ContainerCategorie">Categorie:</label>
    <div class="row container-fluid">
    <div name="ContainerCategorie" class="containerCategorie col-sm-6 col-lg-6" style="border:1px solid black;">
      <!-- ADD CHECKBOXES -->
      <form action="" name="FormCucine">
        <input type="checkbox"> Ciccia</br>
        <input type="checkbox"> Romagnolo</br>
        <input type="checkbox"> Giapponese</br>
        <input type="checkbox"> Americano</br>
      </form>
    </div>

    <div class="ButtonsCategorie col-sm-6 col-lg-6 ">
    <button class=" btn btn-default col-12" style="margin-top:5px;">ELIMINA</button>
    <button class="btn btn-default col-12" style="margin-top:5px;">AGGIUNGI</button>
    </div>
  </div>
</div>
</div>





 </body>
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>
