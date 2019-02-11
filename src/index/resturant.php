<?php
session_start();

//include_once("./addAndRemove.php");

function controllo_cookie(){

	if(isset($_COOKIE['session'])){

		//prendo l'email presente nel cookie
		$tmp=$_SESSION["email"];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "just_database";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $q="SELECT * from utente where Email='".$tmp."'";
		//confronto username e password del cookie con il database
        $query=mysqli_query($conn, $q);

		if($query){
            $row=mysqli_fetch_array($query);
			//immagazzinano le informazioni dell'utente in un array
			$_SESSION["id"]=$row["ID_USER"];
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<!-- FOR CART
		<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
	--><title>Just Uni Eat | Ristorante</title>
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
					}	 ?>
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

    <div class="jumbotron text-center">
        <div class="row">
            <div class="col-md-12">
                <?php

                $tmp=$_SESSION["email"];

                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "just_database";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $row = "";
                $result = "";

                $q="SELECT * from fornitore where ID_FORNITORE = '".$_GET['id']."'";
                $query=mysqli_query($conn, $q);
                $conn->close();
                if(mysqli_num_rows($query) > 0) {

                $rist=mysqli_fetch_array($query);
                }
                ?>
                <div class="row">
                    <div class="col-md-12 title_resturant">
                        <h1><?php echo $rist["Ristorante"]?></h1>
                    </div>
                    <div class="col-md-3">

                        <img src="<?php echo $rist['path_photo'];?>"
                            alt="resturant_logo" width=250px; height="250px;" class="img-rounded img-responsive"/>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <ul>
                                    <?php

                                    $servername = "localhost";
                                    $username = "root";
                                    $password = "";
                                    $dbname = "just_database";

                                    $conn = new mysqli($servername, $username, $password, $dbname);
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }

                                    $q="SELECT Nome FROM CATEGORIE, categoria_ristorante WHERE categorie.ID_FORNITORE = '".$_GET['id']."' AND categorie.ID_CAT = categoria_ristorante.ID_CAT;";
                                    $query=mysqli_query($conn, $q);
                                    while($row = $query->fetch_array()) {
                                        $rows[] = $row;
                                    }
                                    foreach($rows as $row) {
                                    ?>
                                        <li><?php echo $row["Nome"]?></li>
                                    <?php
                                    }
                                    ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="row-info">
                            <ul>
                                <li><i class="material-icons">location_on</i>
                                    <p><?php echo $rist['Città'] . " - " . $rist['Via_e_Num']?></p>
                                </li>
                                <li><i class="material-icons">phone</i>
                                    <p> Cellulare : <?php echo $rist['Cellulare']?></p>
                                </li>
                                <li><i class="material-icons">mail_outline</i> <a href="message.php">Invia
                                        Messaggio</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="ratings">
                            <ul class="list-inline">
                            <?php
                                $fiveStar = 5;
                                $blackStar = 5;
                                $blackStar -= (int)$rist["Valutazione"];
                                for($i = 0; $i < (int)$rist["Valutazione"]; $i++){
                                    echo "<span class='fa fa-star checked'></span>";
                                }
                                if($blackStar > 0) {
                                    for($i = 0; $i < $blackStar; $i++){
                                        echo "<span class='fa fa-star'></span>";
                                    }
                                }
                                ?>
                            </ul>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h2>Menu</h2>
                    </div>
                </div>

                <?php
                $m="SELECT M.ID_MENU FROM fornitore AS F, menu AS M WHERE F.ID_FORNITORE = '".$_GET['id']."' AND F.ID_FORNITORE = M.ID_FORNITORE";
                $query=mysqli_query($conn, $m);
                while($menu = $query->fetch_array()) {
                    $menus[] = $menu;
                }
                foreach($menus as $menu) {
                $q="SELECT * FROM pietanza AS P, menu AS M WHERE M.ID_MENU = '".$menu["ID_MENU"]."' AND P.ID_MENU = M.ID_MENU";
                $query=mysqli_query($conn, $q);
                while($pietanze = $query->fetch_array()) {
                    $pietanzes[] = $pietanze;
                }
                foreach($pietanzes as $pietanze) {
                ?>
                <div class="container item">
                    <form method="POST" >
                        <div class="row">
                            <div class="col-sm-12 col-sm-offset-2">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row ing ">
                                            <div class="col-xs-3">
                                                <div class="d-flex justify-content-between">
                                                    <div class="p-2">
                                                        <h5><?php echo $pietanze["Nome"]?></h5>
                                                    </div>
                                                    <div class="p-2">
                                                        <input type="hidden" name="cart[]" value="<?php echo $pietanze['Nome']?>">
                                                        <p><?php echo $pietanze['Prezzo']?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="d-flex flex-row-reverse">
                                                    <div class="p-2">
                                                            <button type="button" onclick="link('<?php echo $pietanze['Nome'] ?>')" class="btn btn-default btn-sm btn3d">
                                                            <i class="material-icons md-36">add_shopping_cart</i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row ing">
                                        <div class="col-xs-3">
                                                <div class="d-flex justify-content-between">
                                                    <div class="p-2">
                                                        <p><?php echo $pietanze["Descrizione"]?></p>
                                                    </div>
                                                    <div class="iconWrap">
                                                        <?php if($pietanze["Vegetariano"]) {
                                                            ?><a title="Vegetariano"><i class="material-icons">spa</i><?php
                                                        }

                                                        if($pietanze["Piccante"]) {
                                                            ?><a title="Piccante"><i id="picIcon" class="material-icons">whatshot</i><?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <?php
                }
            }
                ?>



            </div>

        </div>
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
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
<<<<<<< HEAD
		<!-- For ajax compact ($.ajax ...) -->
=======
>>>>>>> b29be260e9a71cb1a643c9795e680803395a5e28
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

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

		<script>

		function link(el) {
			$.ajax({
   			type: "POST",
   			url: "addAndRemove.php",
   			data: "cart="+el,
   			success: function(msg){
					location.reload();
     			//alert( "Data Saved: " + msg );
   			}
 			});
		}

		</script>

</body>

</html>
