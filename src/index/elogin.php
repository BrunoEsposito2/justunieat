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
    <title>Just Uni Eat - Log</title>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="index.php">Just Uni Eat</a>
        
        
    </nav>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $auth = false;

        $errors = "";
        $insertError = "";
        $auth = false;

        if(!isset($_POST["nome"]) || strlen($_POST["nome"]) < 2){
        $errors .= "Il Nome è obbligatorio e deve essere almeno 2 caratteri <br/>";
        }

        if(!isset($_POST["cognome"]) || strlen($_POST["cognome"]) < 2){
        $errors .= "Il Cognome è obbligatorio e deve essere almeno 2 caratteri";
        }

        if(!isset($_POST["email"]) || strlen($_POST["email"]) < 2){
        $errors .= "L'Email è obbligatoria e deve essere valida <br/>";
        }

        if(!isset($_POST["cell"]) || strlen($_POST["cell"]) < 10){
        $errors .= "Il cellulare è obbligatorio e deve essere valido <br/>";
        }

        if(!isset($_POST["pass"]) || strlen($_POST["pass"]) < 8){
        $errors .= "La password deve essere lunga almeno 8 caratteri <br/>";
        }

            if(strlen($errors) == 0){


            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "just_database";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("INSERT INTO utente (Nome, Cognome, Email, Password, Cellulare) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $nome, $cognome, $email, $pass, $cell);

            $nome = $_POST["nome"];
            $cognome = $_POST["cognome"];
            $email = $_POST["email"];
            $cell = $_POST["cell"];
            $pass = $_POST["pass"];

            $isInserted = $stmt->execute();
            if(!$isInserted){
                $insertError = $stmt->error;
            }

            if ($isInserted) {
                $stmt->close();
                $auth = true;
            }

        }

}
        ?>

    <div class="jumbotron" style="background-color:white;">
    <?php

if($auth) {

?>
    <div class="swal2-icon swal2-success swal2-animate-success-icon" style="display: flex;">
        <div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div>
        <span class="swal2-success-line-tip"></span>
        <span class="swal2-success-line-long"></span>
        <div class="swal2-success-ring"></div>
        <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div>
        <div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div>
    </div>

    <h3 class="text-center">Complimenti, la registrazione è andata a buon fine!</h3>
    <form class="text-center" action="accedi.php">
        <input type="submit" id="go_after_acc" class="btn btn-success btn-lg btn3d" value="CONTINUA">
    </form>

<?php
} else {
?>

<div class="swal2-icon swal2-error swal2-animate-error-icon" style="display: flex;">
<span class="swal2-x-mark">
    <span class="swal2-x-mark-line-left">
    </span>
    <span class="swal2-x-mark-line-right">
    </span>
</span>
 </div>

    <h3 class="text-center"><?php echo $errors?></h3>
    <form>
        <input type="button" class="btn btn-danger btn-lg btn3d" value="INDIETRO" onclick="history.back()">
    </form>
<?php
}
?>
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

    if($auth) {
    ?>

        <script>

        

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
