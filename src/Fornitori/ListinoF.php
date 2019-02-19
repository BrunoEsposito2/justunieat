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

if(isset($_GET["cats"])){
  echo "Le tue categorie sono state modificate.";
}



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
    <meta name="keywords" content="Cibo, food, Just Eat, Just Uni Eat, just uni eat, asporto, università, fame, veloce, eat"/>
    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="icon" href="http://example.com/favicon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="style.css">
    <link href='https://fonts.googleapis.com/css?family=Faster One' rel='stylesheet'>
     <title>Just Uni Eat Fornitori - Il tuo Listino</title>
 </head>

 <body>
   <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
       <a class="navbar-brand" href="HomeF.php">Just Uni Eat</a>
       <div class="collapse navbar-collapse" id="navbarSupportedContent">
         <div class="navbar-nav float-left text-left pr-3">
           <ul class="navbar-nav mr-auto">
             <li class="nav-item">
              <a class="nav-link" href="HomeF.php">Benvenuto!</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="DatiF.php"><?php echo $_SESSION["Nome"] . " " . $_SESSION["Cognome"];?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="navMes" href="MessageF.php">
                  <i class="fa fa-envelope-o">
                      <span id="countMess" class="badge badge-danger">

                          <?php

                          $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

                          if ($conn->connect_error) {
                              die("Connection failed: " . $conn->connect_error);
                          }
                          //NOTIFICA PER MESSAGGI RICEVUTI
                          if(isset($_SESSION["ID_FORNITORE"])) {
                              $q= "SELECT COUNT(*) FROM fornitore AS F, messaggio AS M WHERE
                              F.ID_FORNITORE='".$_SESSION["ID_FORNITORE"]."' AND F.ID_FORNITORE = M.ID_RISTORANTE AND M.Letto='0' AND M.Ricevuto_Dal_Utente='0'";
                              $query=mysqli_query($conn, $q);
                              $result = mysqli_fetch_array($query);
                              echo $result['COUNT(*)'];
                          } else echo "0";?>
                      </span>
                  </i>
                  Messaggi
              </a>
             </li>
             <li class="nav-item">
                 <a class="nav-link" href="OrdiniF.php">Miei Ordini</a> <!--da rendere hidden se non si ha fatto ancora l'accesso-->
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../index/logout.php">Esci</a> <!--da rendere hidden se non si ha fatto ancora l'accesso-->
             </li>
           </ul>
        </div>
       </div>
     </nav>

<!--I TUOI ORDINI -->

<div id="accordion" class="container col-sm-12 col-md-8">

  <h1 class="text-center onBoard"><?php echo $_SESSION["Ristorante"] . "<br>";?></h1>
  <hr class="onBoard-hr">
  <h2 class="text-center onBoard onBoard-space-md">IL TUO LISTINO</h2>
  <div class="card">
    <div class="card-header" id="headingTitle">
      <h5 class="mb-0 text-center"> I TUOI PIATTI</h5>

    </div>
  </div>

  <?php
  $queryListF = $mysqli->prepare("SELECT * FROM pietanza WHERE ID_MENU = ?");
  $queryListF->bind_param("i", $_SESSION["ID_FORNITORE"]);

  $queryListF->execute();

  $result = $queryListF->get_result();

  $rows = $result->num_rows;

  if($rows > 0){
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

        <div class="classDescrPiatto onBoard col-sm-4 col-lg-4">
          <label for="DescrizionePiatto">Descrizione:</label>
          <p name="DescrizionePiatto">'.$ris["Descrizione"].'</p>
        </div>

        <div class="classTipoPiatto onBoard col-sm-4 col-lg-4">
          <label for="TipoCucina">Tipologia:</label>
          <h6 name="TipoCucina">'.$ris["Tipologia"].'</h6>
        </div>

        <div class="">';


          if($ris["Vegetariano"]){
          echo '<div class="onBoard col-sm-12">
            Vegetariano
          </div>';
          }

          if($ris["Piccante"]){
          echo '<div class="onBoard col-sm-12">
            Piccante
          </div>';
          }
          echo  '<label class="onBoard" for="PrezzoPiatto">Prezzo: </label>
            <h6 class="mb-0 onBoard" name="PrezzoPiatto">'.$ris["Prezzo"].'</h6>



        </div>

      </div>
      <div class="row">
            <div class="col-sm-3">
              <button class="btn btn-info btn3d" style="margin-bottom:2px" data-toggle="modal" data-target="#Modify'.$ris["Nome"].'" name="modificare" value="'.$ris["ID_PIETANZA"].'">Modifica</button>
              </div>
              <div class="col-sm-3">
              <form action="deletePiatto.php" method="post">
                <button class="btn btn-warning btn3d" onclick="jsDelete(this.parentElement.parentElement.parentElement.parentElement.id)" name="eliminare" id="'.$ris["Nome"].'" value="'.$ris["ID_PIETANZA"].'">Elimina</button>
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

  $queryListF->close();
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


  <button class="btn-xl btn-warning btn3d col onBoard-space-md" style="margin-top:1em" onclick="window.location.href='HomeF.php'">INDIETRO</button>

</div>

<?php

  $QueryCatF = $mysqli->prepare("SELECT Nome FROM categoria_ristorante, categorie WHERE categoria_ristorante.ID_CAT = categorie.ID_CAT AND categorie.ID_FORNITORE = ?");
  $QueryCatF->bind_param("i", $_SESSION["ID_FORNITORE"]);

  $QueryCatF->execute();

  $QueryCatF->bind_result($categoria);

  $QueryCatF->fetch();

 ?>

  <!-- CATEGORIE -->
  <div class="container-fluid col-sm-12 col-md-8 col-lg-8">
  <h5 class="mb-0 text-center onBoard onBoard-space-md" >LE TUE CATEGORIE</h5>

  <div class="Categorie container-fluid onBoard-space-md">
    <div class="row container-fluid">
    <div name="ContainerCategorie" class="containerCategorie col-sm-6 col-lg-6 onBoard" style="border:2px solid white;">
      <!-- ADD CHECKBOXES -->
      <?php if($categoria == NULL)
              echo "Non hai scelto categorie.";
            else { do{
                      echo $categoria."<br>";
                    } while($QueryCatF->fetch());
            }

            $QueryCatF->close();
      ?>

    </div>

    <div class="ButtonsCategorie col-sm-6 col-lg-6 ">
    <button class="btn btn-info btn3d col-12" data-target="#AddCategorie" data-toggle="modal" style="margin-top:5px;">MODIFICA</button>
    </div>
  </div>
</div>
</div>

<?php
$QueryCats = $mysqli->prepare("SELECT Nome FROM categoria_ristorante");
$QueryCats->execute();
$result = $QueryCats->get_result();
$i=0;
while($row[$i] = $result->fetch_array(MYSQLI_NUM)){
  //var_dump($row[$i]);
  $i++;
}
$QueryCats->close();

$QueryAddCat = $mysqli->prepare("SELECT Nome FROM categoria_ristorante, categorie WHERE categorie.ID_FORNITORE = ? AND categoria_ristorante.ID_CAT = categorie.ID_CAT");
$QueryAddCat->bind_param("i", $_SESSION["ID_FORNITORE"]);

$QueryAddCat->execute();

$resCats = $QueryAddCat->get_result();
$j = 0;
while($rowC[$j] = $resCats->fetch_array(MYSQLI_NUM)){
  $j++;
}

$QueryAddCat->close();

 ?>
<!--MODAL CATEGORIE-->
<div class="modal" id="AddCategorie" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Scegli le tue categorie</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="addCategoria.php" method="POST" name="FormCucine">
      <div class="modal-body">
          <?php for($cats=0; $cats < count($row)-1; $cats++){
            echo '<input type="checkbox" name="'.$row[$cats][0].'" ';
            //checks if already checked
            for($checked = 0; $checked < count($rowC)-1; $checked++){
              if($rowC[$checked][0] == $row[$cats][0])
                echo 'checked';
            }
            echo '> '.$row[$cats][0].'</br>';
          } ?>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary">Salva le modifiche</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
      </div>
      </form>
    </div>
  </div>
</div>


<script type="text/javascript">
  function addCategorie(){
    var x = document.getElementById("AddCategorie");
    x.style.visibility = "visible";
  }

</script>

<div class="content">
    </div>
    <footer id="myFooter">

        <div class="social-networks">
            <a target="_blank" href="https://twitter.com/JustUniEat1" class="twitter"><i class="fa fa-twitter"></i></a>
            <a target="_blank" href="https://www.facebook.com/justuni.eat.5" class="facebook"><i class="fa fa-facebook"></i></a>
            <a target="_blank" href="https://plus.google.com/u/0/114848465565497583176" class="google"><i class="fa fa-google-plus"></i></a>
        </div>
        <div class="footer-copyright">
            <p>© 2018 Copyright Just Uni Eat</p>
        </div>
    </footer>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
    <script src="Toasty.js-master/dist/toasty.min.js"></script>

    <script>

            var id = <?php echo $_SESSION['ID_FORNITORE']?>;
            $('#inBoxMsg').click(function() {
                $('.msgList').toggle('slow', function() {
                });
            });

            $('#recMsg').click(function() {
                document.getElementById('top_rec_arr').style.display = "block";
                $('.msgListRec').toggle('fadeOut', function() {
                    $.ajax({

                    url : 'updateMessageCountF.php',
                    method : 'post',
                    data : {id : id},

                    success : function(response) {

                    document.getElementById("countMess").innerHTML = "0";

                    }

                    });
                });
            });

    </script>

    <?php

        if(isset($_SESSION["ID_FORNITORE"])) {

        ?>

        <script>

        $(document).ready(function() {
            var myvar = decodeURIComponent("<?php echo rawurlencode($_SESSION['Ristorante']); ?>");
            var hello = "Ciao, ";
            document.getElementById('navUser').innerHTML = hello.concat(myvar);
            document.getElementById('navUser').style.display = "block";
            document.getElementById('navAcc').style.display = "none";
            document.getElementById('navReg').style.display = "none";
            document.getElementById('navMes').style.display = "block";
            document.getElementById('navOrd').style.display = "block";
            document.getElementById('navExit').style.display = "block";
        });


        var ajax_call = function() {

        var id_user = <?php echo $_SESSION['ID_FORNITORE'];?>

        $.ajax({

        url : 'checkMessageNewF.php',
        method : 'post',
        data : {id_user : id_user},

            success : function(response) {

                if(response == "1") {
                    var toast = new Toasty();
                    //toast.progressBar("true");
                    toast.success("Hai un nuovo messaggio!");
                    $('#countMess').text("1");
                }

            }

        });

    };

    var interval = 3000; //3 secondi

    setInterval(ajax_call, interval);

        </script>

    <?php
    } else {
    ?>

    <script>


    </script>

    <?php


    }
    ?>

 </body>

</html>
