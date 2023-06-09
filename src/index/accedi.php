<?php

$error = false;
$nMess = 0;
session_start();
if(isset($_SESSION['nome'])) {
    header("location: infoPage.php?error=loginYet");
    exit();
}

if (isset($_POST['btnLogin'])) {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "just_database";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['email'])) {
        $q = "SELECT * from utente where Email ='" . ($_POST['email']) . "' and Password='" . ($_POST['pass']) . "'";
        $query = mysqli_query($conn, $q);
        $row = mysqli_fetch_array($query);
    }

    //se i dati inviati al form corrispondono a un utente, allora mi loggo, creo il cookie di sessione e vado a index.php
    if (!is_null($row)) {

        //setto la durata del cookies a una settimana
        $time_cookie = 3600 * 24 * 7;
        setcookie("session", $_POST['email'], time() + $time_cookie, "/");
        session_start();
        $_SESSION["email"] = $row['Email'];
        $_SESSION["nome"] = $row["Nome"];

        mysqli_close($conn);
        header("Location: logAction.php");
        exit;

        //nessuna corrispondenza con gli utenti: non mi loggo e ritorno al form
    } else {
        $error = true;
    }

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
    <link href="Toasty.js-master/dist/toasty.min.css" rel="stylesheet">
    <title>Just Uni Eat</title>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="index.php">Just Uni Eat</a>
        <a id="cartIcon" href="checkout.php">
            <i class="material-icons md-36 carts">shopping_cart</i>
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
                <div class="text-center">
                    <form class="form-signin" name="btnLogin" method="POST">
                        <div class="h6 mb-3 alert alert-danger alert-php" id="alert-php-error" style="display:none" role="alert">
                            <p>Password o Email non corretta</p>
                        </div>
                        <h3 class="mb-3 font-weight-normal">Accedi come Utente</h3>
                        <label for="inputEmail" class="sr-only">Email</label>
                            <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email" required="" autofocus="">

                        <label for="inputPassword" class="sr-only">Password</label>
                        <input type="password" name="pass" id="inputPassword" class="form-control" placeholder="Password" required="">

                        <div class="checkbox mb-3">
                            <label>
                                <input type="checkbox" value="remember-me"> Ricordami
                            </label>
                            <div class="form-row">
                                <div class="col-12">
                                    <button type="submit" name="btnLogin" class="btn btn-primary btn-lg btn3d reg_but">ACCEDI</button>
                                </div>
                            </div>
                        </div>
                        <div class="row haveyet">
                            <div class="col mb-12">
                                <p>Non hai ancora un account? <a href="registrati.php">Registrati</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <div class="tab-pane fade show col-sm-12" id="AccForn" role="tabpanel" aria-labelledby="home-tab">
                <div class="text-center">
                    <form class="form-signin" name="btnLoginF" action="accF.php" method="POST">
                        <div class="h6 mb-3 alert alert-danger alert-php" id="alert-php-error" style="display:none" role="alert">
                            <p>Password o Email non corretta</p>
                        </div>
                        <h3 class="mb-3 font-weight-normal">Accedi come Fornitore</h3>
                        <label for="inputEmailF" class="sr-only">Email</label>
                        <input type="email" name="emailF" id="inputEmailF" class="form-control" placeholder="Email" required="" autofocus="">

                        <label for="inputPasswordF" class="sr-only">Password</label>
                        <input type="password" name="passwordF" id="inputPasswordF" class="form-control" placeholder="Password" required="">

                        <div class="checkbox mb-3">
                            <label>
                                <input type="checkbox" value="remember-me"> Ricordami
                            </label>
                            <div class="form-row">
                                <div class="col-12">
                                    <button type="submit" name="btnLogin" class="btn btn-primary btn-lg btn3d reg_but">ACCEDI</button>
                                </div>
                            </div>
                        </div>
                        <div class="row haveyet">
                            <div class="col mb-12">
                                <p>Non hai ancora un account? <a href="registrati.php">Registrati</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>


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
    </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
    <script src="Toasty.js-master/dist/toasty.min.js"></script>

        <?php

if ($error) {
    ?>

        <script>

        $(document).ready(function() {
        document.getElementById('alert-php-error').style.display = "block";
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


</body>

</html>
