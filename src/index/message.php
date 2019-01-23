<?php
session_start();
function controllo_cookie(){

	if(isset($_COOKIE['session'])){

		//prendo l'email presente nel cookie
		$tmp=$_COOKIE['session'];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "just_database";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        $q="SELECT * from utente where Email='".$_SESSION['email']."'";
		//confronto username e password del cookie con il database
        $query=mysqli_query($conn, $q);


		if($query){
            $row=mysqli_fetch_array($query, MYSQLI_ASSOC);
			//immagazzinano le informazioni dell'utente in un array
            $_SESSION["id"]=$row["ID_USER"];
                /*  PER MOSTRARE TUTTI I MESSAGGI DELL'UTENTE"  */
            $q="SELECT * from messaggio where ID_USER='".$_SESSION['id']."'";
            $query=mysqli_query($conn, $q);
            $conn->close();
			return true;
		} else {
            return false;
        }
			

	}else {
        return false;
    }
		

}

if(!controllo_cookie()){
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href='https://fonts.googleapis.com/css?family=Faster One' rel='stylesheet'>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://select2.github.io/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://select2.github.io/dist/js/select2.full.js"></script>
    <title>Just Uni Eat | Messaggi</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">Just Uni Eat</a>
        <a href="#">
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
    <div>
        <a name="top"></a>
    </div>

    <div class="jumbotron">
        <div class="container">
            <div class="row inbox">
                <div class="col-md-3">
                    <div class="panel panel-default">
                    
                            <ul>
                                
                                <li>
                                     <button id="inBoxMsg" class="btn btn-primary btn3d">Messaggi Inviati</button>
                                </li>
                                
                                <?php

                                    $servername = "localhost";
                                    $username = "root";
                                    $password = "";
                                    $dbname = "just_database";

                                    $mysqli = new mysqli($servername, $username, $password, $dbname);
                                    if ($mysqli->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                                                        
                                        /*  PER MOSTRARE TUTTI I MESSAGGI DELL'UTENTE"  */
                                    $query="SELECT * from messaggio where ID_USER='".$_SESSION['id']."'";
                                    
                                    $result = $mysqli->query($query);

                                    while($row = $result->fetch_array())
                                    {
                                    $rows[] = $row;
                                    }
                                    foreach($rows as $row) {
                                    
                                    
                                    ?>

                                    <div class="list-group msgList" style="display: none;">
                                    <li>

                                    <div class="list-group msgList" style="display: none;">
                                        <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1"><?php printf ("%s", $row["Titolo"]);?></h5>
                                                <small><?php printf ("%s", $row["Data"]);?></small>
                                            </div>
                                            <p class="mb-1"><?php printf ("%s", $row["Testo"]);?></p>
                                        </a>
                                    </div> 
                                    </li>
                                    <?php
                                    }
                                    ?>

                                    <br>
                                    <a href="#top">Torna su<i class="material-icons">vertical_align_top</i></a>
                            </ul>
                    </div>

                </div>
                <!--/.col-->

                <div class="col-md-9">
                    <div class="panel panel-default">
                        <div class="panel-body message">
                            <div class="text-center">
                                <h2 class="text-center">Area Messaggi</h2>
                            </div>
                            <form class="form-horizontal" method="POST" action="sendMess.php" role="form">
                                <div class="form-group">
                                    <label for="to" class="col-sm-1 control-label">A:</label>
                                    <div class="col-sm-11">
                                        <input type="text" name="ristorante" class="form-control select2-offscreen" id="to"
                                            placeholder="Ristorante" tabindex="-1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="cc" class="col-sm-1 control-label">Titolo:</label>
                                    <div class="col-sm-11">
                                        <input type="text" name="titolo" class="form-control select2-offscreen" id="cc"
                                            placeholder="Titolo" tabindex="-1">
                                    </div>
                                </div>
                            

                                <div class="col-sm-11 col-sm-offset-1">



                                <div class="form-group">
                                    <textarea class="form-control" name="testo" id="message" name="body" rows="12"
                                        placeholder="Clicca qui per scrivere..."></textarea>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-lg btn3d">Invia</button>
                                </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--/.col-->
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
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Accedi</a></li>
                        <li><a href="#">Registrati</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Chi siamo</h5>
                    <ul>
                        <li><a href="#">La Nostra Storia</a></li>
                        <li><a href="#">Contattaci</a></li>
                        <li><a href="#">Dicono di noi</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Fornitori</h5>
                    <ul>
                        <li><a href="#">Elenco completo</a></li>
                        <li><a href="#">Diventa affiliato</a></li>
                        <li><a href="#">Diventa fattorino</a></li>
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

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>

        <script>
        $('#inBoxMsg').click(function() {
            $('.msgList').toggle('slow', function() {
            // Animation complete.
            });
        });
        </script>
    
        <?php

    if($auth) {
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

</body>

</html>