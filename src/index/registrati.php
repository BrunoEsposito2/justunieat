<?php

define("HOST", "localhost"); // E' il server a cui ti vuoi connettere
define("USER", "admin_user"); // E' l'utente con cui ti collegherai al DB.
define("PASSWORD", "Justunieat2019"); // Password di accesso al DB.
define("DATABASE", "just_database"); // Nome del database.
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if(isset($_GET["pass"])){
  echo "Le password non coincidono";
}
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
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="icon" href="http://example.com/favicon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href='https://fonts.googleapis.com/css?family=Faster One' rel='stylesheet'>
    <link href="Toasty.js-master/dist/toasty.min.css" rel="stylesheet">
    <title>Just Uni Eat | Registrati</title>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="index.php">Just Uni Eat</a>
        <a href="checkout.html">
          <?php
          $servername = "localhost";
          $username = "root";
          $password = "";
          $dbname = "just_database";

          $conn = new mysqli($servername, $username, $password, $dbname);
          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }

          if(isset($_SESSION['id'])) {
            $idUs = $_SESSION['id'];
            $checkCart = "SELECT ID_ORDINE FROM ordine WHERE ID_USER='$idUs' AND ORDINE_INVIATO=0";
            $execControl = mysqli_query($conn, $checkCart);
            $n_rows = mysqli_num_rows($execControl);
  
            if($n_rows === 0) {
             ?>
              <i class="material-icons md-36 carts">remove_shopping_cart</i>
              <?php
            } else if($n_rows > 0) {
              ?>
              <i class="material-icons md-36 carts">shopping_cart</i>
              <?php
            }
            
          }
          ?>
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="navbar-nav float-left text-left pr-3">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" id="navAcc" href="accedi.php">Accedi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="navReg" href="registrati.php">Registrati</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="navMes" href="message.php">
                          <i class="fa fa-envelope-o">
                            <span class="badge badge-danger">1</span>
                          </i>
                          Messaggi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="navOrd" href="#">Miei Ordini</a>
                        <!--da rendere hidden se non si ha fatto ancora l'accesso-->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="navExit" href="logout.php">Esci</a>
                        <!--da rendere hidden se non si ha fatto ancora l'accesso-->
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#RegCli" role="tab" aria-controls="home" aria-selected="true">Cliente</a>
      </li>

      <li class="nav-item ">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#RegForn" role="tab" aria-controls="profile" aria-selected="false">Ristorante</a>
      </li>
    </ul>


    <div class="jumbotron jumboAcc text-center col-sm-12">


      <div class="tab-content col-sm-12" id="myTabContent">
        <!--REGISTRAZIONE CLIENTE-->
      <div class="tab-pane fade show active col-sm-12" id="RegCli" role="tabpanel" aria-labelledby="home-tab">


        <div class="text-center">

            <form class="form-signin" action="elogin.php" name="btnReg" method="POST">
                <h4 class="font-weight-normal">Registrati come Utente</h4>
                <label for="inputNome" class="sr-only">Nome</label>
                <input type="text" name="nome" id="inputNome" class="form-control" placeholder="Nome" required="true" autofocus="true">
                <label for="inputCognome" class="sr-only">Cognome</label>
                <input type="text" name="cognome" id="inputCognome" class="form-control" placeholder="Cognome" required="true"
                    autofocus="true">
                <label for="inputCell" class="sr-only">Cellulare</label>
                <input type="tel" name="cell" id="inputCell" class="form-control" placeholder="Cellulare" required="true" autofocus="true">
                <label for="inputEmail" class="sr-only">Email</label>
                <div id="divResults"></div>
                <div id="divErrorMessages"></div>
                <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email" required="true" autofocus="">
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" name="pass" id="inputPassword" class="form-control" placeholder="Password" required="true">
                <div class="form-row">
                    <div class="col-12">
                        <button type="submit" id="submit" class="btn btn-primary btn-lg btn3d reg_but">REGISTRATI</button>
                    </div>
                </div>
            </form>
            <div class="row haveyet">
                <div class="col mb-12">
                    <p>Hai già un account? <a href="accedi.php">Accedi</a></p>
                </div>
            </div>

        </div>
      </div>
      <!--FINE REGISTRAZIONE CLIENTE-->

    <div id="myDIV" class="cookie-accept d-block position-fixed mw-25 bg-primary text-white rounded-top pt-2 pr-3 pl-3 pb-2">
        <h5>Uso dei Cookie e dei dati personali</h5>
        <p>Noi - <em>e i nostri partern</em> - usano i cookie per offrire un servizio migliore e inerente ai tui gusti. Ulteriori informazioni le troverai nel sezione: Privacy Policy. Usando il nostro sito, sei d'accordo all'utilizzo dei cookie.</p>
     <button onclick="myFunction()" class="btn btn-outline-light btn-block">Accetto</button>
    </div>

      <!--REGISTRAZIONE RISTORANTE-->
      <div class="tab-pane fade col-sm-12" id="RegForn" role="tabpanel" aria-labelledby="profile-tab">
        <div class="text-center col-sm-12" >
            <form class="form-signin" action="regF.php" method="POST">
                <h4 class="font-weight-normal">Registrati come Fornitore</h4>
                <label for="inputNameF" class="sr-only" >Nome</label>
                <input type="text" id="inputNameF" name="inputNameF" class="form-control" style="margin-top:20px;" placeholder="Nome" required="true" autofocus="true">

                <label for="inputSurnameF" class="sr-only">Cognome</label>
                <input type="text" id="inputSurnameF" name="inputSurnameF" class="form-control" style="margin-top:20px;" placeholder="Cognome" required="true" autofocus="true">

                <label for="inputRistoranteF" class="sr-only">Ristorante</label>
                <input type="text" id="inputRistoranteF" name="inputRistoranteF" class="form-control" style="margin-top:20px;" placeholder="Ristorante" required="true" autofocus="true">

                <label for="inputCellF" class="sr-only" >Cellulare</label>
                <input type="tel" id="inputCellF" name="inputCellF" class="form-control" style="margin-top:20px;" placeholder="Cellulare" required="true" autofocus="true">

                <label for="inputPIVAF" class="sr-only">Partita IVA</label>
                <input type="text" id="inputPIVAF" name="inputPIVAF" class="form-control" style="margin-top:20px;" placeholder="Partita IVA" required="true" autofocus="true">

                <label for="inputEmailF" class="sr-only">Email</label>
                <input type="email" id="inputEmailF" name="inputEmailF" class="form-control" style="margin-top:20px;" placeholder="Email" required="true" autofocus="true">

                <label for="inputPasswordF" class="sr-only">Password</label>
                <input type="password" id="inputPasswordF" name="inputPasswordF" class="form-control" style="margin-top:20px;" placeholder="Password" required="true">

                <label for="inputConfirmPasswordF" class="sr-only">Conferma Password</label>
                <input type="password" id="inputConfirmPasswordF" name="inputConfirmPasswordF" class="form-control" style="margin-top:20px;" placeholder="Conferma Password" required="true">

                <div class="form-row text-center">
                    <div class="col-12">
                        <button type="submit" value="Submit" class="btn btn-primary btn-lg btn3d reg_but">REGISTRATI</button>
                    </div>
                </div>

                <div class="row haveyet">
                    <div class="col mb-12">
                        <p>Hai già un account? <a href="accedi.php">Accedi</a></p>
                    </div>
                </div>
              </form>
        </div>
      </div>
      <!--FINE REGISTRAZIONE RISTORANTE-->
    </div>

    </div>
            </div>

        </div>
    </div>




<!--FOOTER-->
    <div class="content">
    </div>
    <footer id="myFooter">
        <div class="container text-center">
            <div class="row">
                <div class="col-sm-4">
                    <h5>Inizia</h5>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="accedi.php">Accedi</a></li>
                        <li><a href="registrati.php">Registrati</a></li>
                    </ul>
                </div>
                <div class="col-sm-4">
                    <h5>Chi siamo</h5>
                    <ul>
                        <li><a href="storia.html">La Nostra Storia</a></li>
                        <li><a href="contattaci.html">Contattaci</a></li>
                        <li><a href="dicono_di_noi.html">Dicono di noi</a></li>
                    </ul>
                </div>
                <div class="col-sm-4">
                    <h5>Info</h5>
                    <ul>
                        <li><a href="privacy.php">Privacy & Cookie</a></li>
                        <li><a href="registrati.php">Diventa affiliato</a></li>
                        <li><a href="diventa_fattorino.php">Diventa fattorino</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="social-networks">
            <a target="_blank" href="https://twitter.com/JustUniEat1" class="twitter"><i class="fa fa-twitter"></i></a>
            <a target="_blank" href="https://www.facebook.com/justuni.eat.5" class="facebook"><i class="fa fa-facebook"></i></a>
            <a target="_blank" href="https://plus.google.com/u/0/114848465565497583176" class="google"><i class="fa fa-google-plus"></i></a>
        </div>
        <div class="footer-copyright">
            <p>© 2018 Copyright Just Uni Eat</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
    
        <script>

        function myFunction() {
        var x = document.getElementById("myDIV");
        x.remove();
        } 

    
        $(document).ready(function(){
            $('input[name=email]').change(function() {

                var email = $('#inputEmail').val();

                $.ajax({

                url : 'checkEmailExist.php',
                method : 'post',
                data : {email : email},

                success : function(response) {
                
                    if(response == 1)
                    alert("Errore! Email già presente a sistema.");

                }

                });
            });
        });
        </script>



</body>

</html>
