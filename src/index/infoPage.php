<?php
session_start();
$nMess = 0;
function controllo_cookie(){

	if(isset($_COOKIE['session']) & isset($_SESSION['nome'])){

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
    <link href="Toasty.js-master/dist/toasty.min.css" rel="stylesheet">
    <title>Just Uni Eat | Info</title>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="index.php">Just Uni Eat</a>
        <a href="checkout.php">
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
                        <a class="nav-link" id="navUser" href="profile.php"></a>
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
                                <span id="countMess" class="badge badge-danger">
                                    
                                    <?php 
                                    if($auth) {
                                        $q= "SELECT COUNT(*) FROM utente AS U, messaggio AS M WHERE 
                                        U.ID_USER='".$_SESSION["id"]."' AND U.ID_USER = M.ID_USER AND M.Letto='0'";
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
                        <a class="nav-link" id="navOrd" href="mieiOrdini.php">Miei Ordini</a>
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

    <div class="jumbotron">
       <?php if($_GET['error'] == "loginYet") {
        ?>   
            <div class="row">
                <div class="col-sm-4 offset-sm-4">
                    <div class="alert alert-danger"><h2 class="text-center">Sei già loggato!</h2></div>
                    <form name="continua" class="text-center" onclick="history.back()">
                        <input type="button" id="go_after_acc" class="btn btn-success btn-lg btn3d" value="CONTINUA">
                    </form>
                </div>
                
            </div>
           
        <?php
        } else if ($_GET['error'] == "404") {
            ?>
            <div class="row">
                <div class="col-sm-4 offset-sm-4">
                    <div class="alert alert-danger"><h2 class="text-center"><i class="material-icons md-36">sentiment_very_dissatisfied
                    </i> Ops! Non hai i permessi per accedere.</h2></div>
                    <form name="continua" class="text-center" action="index.php">
                        <input type="submit" id="go_after_acc" class="btn btn-success btn-lg btn3d" value="CONTINUA">
                    </form>
                </div>
                
            </div>
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

        <script>
        $('#inBoxMsg').click(function() {
            $('.msgList').toggle('slow', function() {
            // Animation complete.
            });
        });

        $('#recMsg').click(function() {
            document.getElementById('top_rec_arr').style.display = "block";
            $('.msgListRec').toggle('fadeOut', function() {
            //Aniamtion
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
        
        var ajax_call = function() {
        
        var id_user = <?php echo $_SESSION['id'];?>

        $.ajax({

        url : 'checkMessageNew.php',
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

    var interval = 30000; //30 secondi

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