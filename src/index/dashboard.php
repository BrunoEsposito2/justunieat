<?php
session_start();
$button = "";
function controllo_cookie()
{

    if (isset($_COOKIE['session'])) {

        //prendo l'email presente nel cookie
        $tmp = $_COOKIE['session'];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "just_database";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $q = "SELECT * from utente where Email='justunieat@gmail.com'";
        //confronto username e password del cookie con il database
        $query = mysqli_query($conn, $q);

        if ($query) {
            $row = mysqli_fetch_array($query);
            //immagazzinano le informazioni dell'utente in un array
            $_SESSION["id"] = $row["ID_USER"];
            return true;
        } else {
            return false;
        }

    } else {
        return false;
    }

}

if (!controllo_cookie()) {
    $auth = false;
    header("location: accedi.php");
} else {
    $auth = true;
}
?>

<!DOCTYPE html>
<html lang="it-IT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="icon" href="http://example.com/favicon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href='https://fonts.googleapis.com/css?family=Faster One' rel='stylesheet'>
    <title>Just Uni Eat</title>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
    </button>
        <a class="navbar-brand" href="index.php">Just Uni Eat</a>
        <a href="checkout.php">
            <i class="material-icons md-36 carts">shopping_cart</i>
        </a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="navbar-nav float-left text-left pr-3">
                <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                        <a class="nav-link" id="navUser" href="#"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="navAcc" href="accedi.php">Accedi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="navReg" href="registrati.html">Registrati</a>
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
      <li class="nav-item ">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#AccCli" role="tab" aria-controls="home" aria-selected="true">Utente</a>
      </li>

      <li class="nav-item  ">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#AccForn" role="tab" aria-controls="profile" aria-selected="false">Fornitore</a>
      </li>
    </ul>

    <div class="jumbotron jumboAcc text-center">

        <div class="tab-content col-sm-12" id="myTabContent">
            <div class="tab-pane fade show active col-sm-12" id="AccCli" role="tabpanel" aria-labelledby="home-tab">

                <div class="row">
                    <div class="col-xl-2">
                        <button type="submit" value="orderSurname" class="btn btn-primary btn3d">ORDINA PER COGNOME</button>
                    </div>
                    <div class="col-xl-2">
                        <button type="submit" value="orderID" class="btn btn-primary btn3d">ORDINA PER ID</button>
                    </div>
                    <div class="col-xl-4">
                        <h3 class="text-center">Dashboard Utenti</h3>
                    </div>
                    <div class="col-xl-2">
                        <button type="submit" value="orderName" class="btn btn-primary btn3d">ORDINA PER NOME</button>
                    </div>
                    <div class="col-xl-2">
                        <button type="submit" value="orderBlock" class="btn btn-primary btn3d">VISUALIZZA NON ABILITATI</button>
                    </div>

                </div>

                <?php

                $tmp = $_COOKIE['session'];

                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "just_database";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $m = "SELECT * FROM utente";
                $m .= $button;
                $query = mysqli_query($conn, $m);
                while ($utente = $query->fetch_array()) {
                    $utentes[] = $utente;
                }
                foreach ($utentes as $utente) {
                    ?>
                        <div class="container item">
                            <div class="card usr_block">
                                <div class="card-body usr_body">
                                    <div class="row">
                                            <div class="p-2 col-md-4">
                                                <h5 id='ngU<?php echo $utente["ID_USER"] ?>'><?php echo $utente["Nome"] . " " . $utente["Cognome"] ?></h5>
                                            </div>
                                            <div class="p-2 col-md-4">
                                                <p id='cellU<?php echo $utente["ID_USER"] ?>'><?php echo "Cellulare: " . $utente["Cellulare"] ?></p>
                                            </div>
                                            <div class="p-2 col-md-4">
                                                <p><?php echo "ID: " . $utente["ID_USER"] ?></p>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="p-2 col-md-6">
                                                <p id='emU<?php echo $utente["ID_USER"] ?>'><?php echo "Email: " . $utente["Email"] ?></p>
                                            </div>
                                            <div class="p-2 col-md-6">
                                                <p id='abU<?php echo $utente["ID_USER"] ?>'><?php echo "Abilitato: " . $utente["abilitato"] ?></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="p-2 col-md-12">
                                                <a class="btn btn-warning btn3d Usave" data-toggle="collapse" href="#collapseExample<?php echo $utente['ID_USER'] ?>"
                                                role="button" aria-expanded="false" aria-controls="collapseExample<?php echo $utente['ID_USER'] ?>">EDIT</a>
                                                    <div class="collapse" id="collapseExample<?php echo $utente['ID_USER'] ?>">
                                                        <div class="card card-body">
                                                            <div id="collapse1" class="collapse show">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-md-2 col-lg-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Nome</label>
                                                                                    <input id='nomeU<?php echo $utente["ID_USER"] ?>' value='<?php echo $utente["Nome"] ?>' name="nome" type="text" class="form-control" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-1 col-lg-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Cognome</label>
                                                                                    <input id='cognomeU<?php echo $utente["ID_USER"] ?>' name="cognome"  value='<?php echo $utente["Cognome"] ?>' type="text" class="form-control" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 col-lg-4 text-center">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">ID</label>
                                                                                    <input disabled value="<?php echo $utente['ID_USER'] ?>" class="form-control" type="text" />
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-4 col-lg-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Email</label>
                                                                                    <input id='emailU<?php echo $utente["ID_USER"] ?>' value='<?php echo $utente["Email"] ?>' name="email" type="text" class="form-control" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 col-lg-3">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Cellulare</label>
                                                                                    <input id='cellU<?php echo $utente["ID_USER"] ?>' value='<?php echo $utente["Cellulare"] ?>' name="cell" type="text" class="form-control" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3 col-lg-3">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Abilitato</label>
                                                                                    <input id='abilitatoU<?php echo $utente["ID_USER"] ?>'  value='<?php echo $utente["abilitato"] ?>' name="abilitato" type="text" class="form-control" />
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-3 col-lg-12">
                                                                                <div class="form-group">
                                                                                    <button type="button" name="userUpdate" class="btn-sm btn-success btn3d updateU">AGGIORNA</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

            
                <?php
                }
                ?>
            </div>

            <div class="tab-pane fade show col-sm-12" id="AccForn" role="tabpanel" aria-labelledby="home-tab">


                <div class="row">
                    <div class="col-xl-2">
                        <button type="submit" value="orderSurnameR" class="btn btn-primary btn3d">ORDINA PER COGNOME</button>
                    </div>
                    <div class="col-xl-2">
                        <button type="submit" value="orderRID" class="btn btn-primary btn3d">ORDINA PER ID</button>
                    </div>
                    <div class="col-xl-4">
                        <h3 class="text-center">Dashboard Fornitori</h3>
                    </div>
                    <div class="col-xl-2">
                        <button type="submit" value="orderRist" class="btn btn-primary btn3d">ORDINA PER RISTORANTE</button>
                    </div>
                    <div class="col-xl-2">
                        <button type="submit" value="topOrders" class="btn btn-primary btn3d">CON PIU' ORDINI</button>
                    </div>

                </div>

                <?php

                $tmp = $_COOKIE['session'];

                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "just_database";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $m = "SELECT * FROM fornitore";
                $query = mysqli_query($conn, $m);
                while ($fornitore = $query->fetch_array()) {
                    $fornitores[] = $fornitore;
                }
                foreach ($fornitores as $fornitore) {
                    ?>
                        <div class="container item">
                            <div class="card usr_block">
                                <div class="card-body ">
                                    <div class="row ">
                                        <div class=" col-md-3">
                                            <h5 id="ng<?php echo $fornitore['ID_FORNITORE'] ?>" data-target="nameTarget"><?php echo $fornitore["Nome"] . " " . $fornitore["Cognome"] ?></h5>
                                        </div>
                                        <div class=" col-md-3">
                                            <p id="cel<?php echo $fornitore['ID_FORNITORE'] ?>" data-target="cellTarget"><?php echo "Cellulare: " . $fornitore["Cellulare"] ?></p>
                                        </div>
                                        <div class=" col-md-3">
                                            <p data-target="idTarget"><?php echo "ID: " . $fornitore["ID_FORNITORE"] ?></p>
                                        </div>
                                        <div class=" col-md-3">
                                            <p id="pa<?php echo $fornitore['ID_FORNITORE'] ?>" data-target="P_ivaTarget"><?php echo "Partita_IVA: " . $fornitore["Partita_IVA"] ?></p>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class=" col-md-4">
                                            <p id="em<?php echo $fornitore['ID_FORNITORE'] ?>" data-target="emailTarget"><?php echo "Email: " . $fornitore["Email"] ?></p>
                                        </div>
                                        <div class=" col-md-4">
                                            <p id="rist<?php echo $fornitore['ID_FORNITORE'] ?>" data-target="ristoranteTarget"><?php echo "Ristorante: " . $fornitore["Ristorante"] ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p id="civinu<?php echo $fornitore['ID_FORNITORE'] ?>" data-target="cittaTarget"><?php echo "Location: " . $fornitore["Città"] . ' - ' . $fornitore["Via_e_Num"] ?></p>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="p-2 col-md-12">
                                            <a class="btn btn-warning btn3d Fsave" data-toggle="collapse" href="#FcollapseExample<?php echo $fornitore['ID_FORNITORE'] ?>"
                                            role="button" aria-expanded="false" aria-controls="collapseExample">EDIT</a>
                                                 <div class="collapse" id="FcollapseExample<?php echo $fornitore['ID_FORNITORE'] ?>">
                                                    <div class="card card-body" id="<?php echo $fornitore['ID_FORNITORE'] ?>">
                                                        <div id="collapse1" class="collapse show">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-2 col-lg-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Nome</label>
                                                                                <input name="nomeF" id="nomeF<?php echo $fornitore['ID_FORNITORE'] ?>" value="<?php echo $fornitore['Nome'] ?>" type="text" class="form-control" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1 col-lg-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Cognome</label>
                                                                                <input value="<?php echo $fornitore['Cognome'] ?>" id="cognomeF<?php echo $fornitore['ID_FORNITORE'] ?>" name="cognomeF" type="text" class="form-control" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 col-lg-2 text-center">
                                                                            <div class="form-group">
                                                                                <label class="control-label">ID</label>
                                                                                <input disabled placeholder="<?php echo $fornitore['ID_FORNITORE'] ?>" value="<?php echo $fornitore['ID_FORNITORE'] ?>" class="form-control" type="text" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 col-lg-3">
                                                                            <div class="form-group">
                                                                               <label class="control-label">Partita_IVA</label>
                                                                                <div class="input-group">
                                                                                    <input value="<?php echo $fornitore['Partita_IVA'] ?>" id="partita_iva<?php echo $fornitore['ID_FORNITORE'] ?>" name="partita_iva" class="form-control" type="text" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-4 col-lg-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Email</label>
                                                                                <input value="<?php echo $fornitore['Email'] ?>" id="emailF<?php echo $fornitore['ID_FORNITORE'] ?>" name="emailF" type="text" class="form-control" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 col-lg-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Cellulare</label>
                                                                                <input value="<?php echo $fornitore['Cellulare'] ?>" id="cellF<?php echo $fornitore['ID_FORNITORE'] ?>" name="cellF" type="text" class="form-control" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 col-lg-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Città</label>
                                                                                <input name="citta" id="cittaF<?php echo $fornitore['ID_FORNITORE'] ?>" value="<?php echo $fornitore['Città'] ?>" type="text" class="form-control" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 col-lg-2">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Via</label>
                                                                                <input name="via" id="viaF<?php echo $fornitore['ID_FORNITORE'] ?>" value="<?php echo $fornitore['Via_e_Num'] ?>" type="text" class="form-control" />
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-3 col-lg-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Ristorante</label>
                                                                                <input name="ristorante" id="ristorante<?php echo $fornitore['ID_FORNITORE'] ?>" value="<?php echo $fornitore['Ristorante'] ?>" type="text" class="form-control" />
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-3 col-lg-12">
                                                                            <div class="form-group">
                                                                                <a type="button" class="btn-sm btn-success btn3d updateF">AGGIORNA</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
            </div>
        </div>

    </div>

    <div class="content">
    </div>
    <footer id="myFooter">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h5>Inizia</h5>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="accedi.php">Accedi</a></li>
                        <li><a href="registrati.html">Registrati</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Chi siamo</h5>
                    <ul>
                        <li><a href="storia.html">La Nostra Storia</a></li>
                        <li><a href="contacci.html">Contattaci</a></li>
                        <li><a href="our.html">Dicono di noi</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Fornitori</h5>
                    <ul>
                        <li><a href="#">Elenco completo</a></li>
                        <li><a href="registrati.php">Diventa affiliato</a></li>
                        <li><a href="diventa_fattorino.php">Diventa fattorino</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Termini</h5>
                    <ul>
                        <li><a href="#">Termini del servizio</a></li>
                        <li><a href="#">Termini di utilizzo</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="social-networks">
            <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
            <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
            <a href="#" class="google"><i class="fa fa-google-plus"></i></a>
        </div>
        <div class="footer-copyright">
            <p>© 2018 Copyright Just Uni Eat</p>
        </div>
    </footer>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>


    <?php

if ($auth) {
    ?>

        <script>

        $(document).ready(function() {
            var myvar = decodeURIComponent("<?php echo rawurlencode($_SESSION['nome']); ?>");
            var hello = "Ciao, ";
            document.getElementById('navUser').innerHTML = hello.concat(myvar);
            document.getElementById('navUser').style.display = "block";
            document.getElementById('navAcc').style.display = "none";
            document.getElementById('navReg').style.display = "none";
            document.getElementById('navMes').style.display = "block";
            document.getElementById('navOrd').style.display = "block";
            document.getElementById('navExit').style.display = "block";
        });

        </script>
    <?php
} else {
    ?>

    <script>


    </script>

    <?php

}
?>



        <script>
            $(document).ready(function() {

            var ID = "";
            $('.Fsave').click(function(){
                var id = $(this).next();
                var allId = id.prop('id');
                ID = allId.substring(16, allId.length);

            })

            $('.updateF').click(function(){

                var id = ID;
                var nome = $('#nomeF' + ID).val();
                var cognome = $('#cognomeF' + ID).val();
                var partita_iva = $('#partita_iva' + ID).val();
                var cell = $('#cellF' + ID).val();
                var citta = $('#cittaF' + ID).val();
                var email = $('#emailF' + ID).val();
                var via = $('#viaF' + ID).val();
                var ristorante = $('#ristorante' + ID).val();

                $.ajax({

                    url : 'ajaxFornitore.php',
                    method : 'post',
                    data : {nome : nome, cognome : cognome, email: email, partita_iva : partita_iva, cell : cell, ristorante : ristorante, citta : citta, via : via, id : id},

                    success : function(response) {
                    $('#nomeF' + ID).text(nome);
                    $('#cognomeF' + ID).text(cognome);
                    $('#partita_iva' + ID).text(partita_iva);
                    $('#cellF' + ID).text(cell);
                    $('#emialF' + ID).text(email);
                    $('#viaF' + ID).text(via);
                    $('#ristorante' + ID).text(ristorante);
                    $('#cittaF' + ID).text(citta);

                    $('#ng' + ID).text(nome + " " + cognome);
                    $('#pa' + ID).text("Partita_IVA: " + partita_iva);
                    $('#cel' + ID).text("Cellulare: " + cell);
                    $('#em' + ID).text("Email: " + email);
                    $('#civinu' + ID).text("Location: " + citta + " - " + via);
                    $('#rist' + ID).text("Ristorante: "  + ristorante);


                    }




                });

            });


            var IDU = "";
            $('.Usave').click(function(){
                var id = $(this).next();
                var allId = id.prop('id');
                IDU = allId.substring(15, allId.length);
            })

            $('.updateU').click(function(){

                var id = IDU;
                var nome = $('#nomeU' + IDU).val();
                var cognome = $('#cognomeU' + IDU).val();
                var cell = $('#cellU' + IDU).val();
                var email = $('#emailU' + IDU).val();
                var abilitato = $('#abilitatoU' + IDU).val();

                $.ajax({

                    url : 'ajaxUtente.php',
                    method : 'post',
                    data : {nome : nome, cognome : cognome, email: email, cell : cell, abilitato: abilitato, id : id},

                    success : function(response) {
                    $('#nomeU' + ID).text(nome);
                    $('#cognomeU' + ID).text(cognome);
                    $('#abilitatoU' + IDU).text(abilitato);
                    $('#cellU' + ID).text(cell);
                    $('#emailU' + ID).text(email);


                    $('#ngU' + IDU).text(nome + " " + cognome);
                    $('#celU' + IDU).text("Cellulare: " + cell);
                    $('#emU' + IDU).text("Email: " + email);
                    $('#abU' + IDU).text("Abilitato: " + abilitato);


                    }




                });

            });







            });
         </script>





</body>

</html>
