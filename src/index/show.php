<?php
session_start();
function controllo_cookie(){

	if(isset($_COOKIE['session']) & isset($_SESSION['nome'])){

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
	<link rel="icon" href="http://example.com/favicon.png">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link href='https://fonts.googleapis.com/css?family=Faster One' rel='stylesheet'>
	<link href="Toasty.js-master/dist/toasty.min.css" rel="stylesheet">
    <title>Just Uni Eat | Mostra Ristoranti</title>
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

    <section class="mb-5">
        <div class="container">
            <div class="row title py-3">


                <div class="col-md-8">
                    <h1>Ristoranti</h1>
                </div>

            </div>

            <div class="row">
                    <div class="col-md-3">
                        <form method="GET" >
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <strong>
                                                <p>Categorie</p>
                                            </strong>
                                            <ul>
                                            <?php

                                            $servername = "localhost";
                                            $username = "root";
                                            $password = "";
                                            $dbname = "just_database";

                                            $mysqli = new mysqli($servername, $username, $password, $dbname);
                                            if ($mysqli->connect_error) {
                                                die("Connection failed: " . $conn->connect_error);
                                            }

                                            $row = "";
                                            $result = "";

                                            $q="SELECT Nome from categoria_ristorante";

                                            $result = $mysqli->query($q);
                                            while($row = $result->fetch_array()) {
                                                $rows[] = $row;
                                            }
                                            foreach($rows as $row) {
                                            ?>
                                                <li>
                                                    <div class="contact">
                                                        <label>
                                                            <input type="checkbox" name="category[]" value="<?php echo $row['Nome']?>">
                                                            <span><?php echo $row["Nome"]?></span>
                                                        </label>
                                                    </div>
                                                </li>
                                            <?php
                                            }
                                            ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body card_icon_filtri text-center">
                                        <i class="material-icons" id="icon_show_apply">save_alt</i><button type="submit" class="btn btn-danger btn3d">Applica Filtri</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>


                <div class="col-md-9">

                    <?php


                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "just_database";

                        $mysqli = new mysqli($servername, $username, $password, $dbname);
                        if ($mysqli->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $row = "";
                        $result = "";

                        if(isset($_GET['category'])) {
                            $categorys = $_GET['category'];
                        }
                        if(isset($_GET['category'])) {
                            foreach ($categorys as $category){
                                $rows = array();
                                ?>
                                <?php echo "<h4 class='catHr'>$category</h4>" ?>
                                <hr id="Hr_cat"/>
                                <?php
                                $q="SELECT * FROM categorie as c, categoria_ristorante as cr, fornitore as f
                                WHERE cr.Nome = '$category' AND c.ID_FORNITORE = f.ID_FORNITORE AND cr.ID_CAT = c.ID_CAT GROUP BY f.ID_FORNITORE";

                                $result = $mysqli->query($q);
                                while($row = $result->fetch_array()) {
                                    $rows[] = $row;
                                }                                                                   /*MI MOSTRA SEMPRE LO STESSO RISTORANTE E STESSO ID*/
                                foreach($rows as $row) {
                                        ?>

                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <form action='resturant.php' method="GET">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <img alt="resturant_image" src="<?php echo $row['path_photo']?>" width=300px; height="150px;" class="rounded-circle" >
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <input type="hidden" name="id" value="<?php echo $row['ID_FORNITORE'];?>">
                                                                        <a href='<?php echo "resturant.php?id=" .  $row['ID_FORNITORE']?>'><h5><?php echo $row["Ristorante"]?></h5></a>
                                                                        <small><?php echo $row["Nome"]?></small>
                                                                        <p><small><?php echo $row["Cellulare"]?></small></p>
                                                                        <?php
                                                                        $fiveStar = 5;
                                                                        $blackStar = 5;
                                                                        $blackStar -= (int)$row["Valutazione"];
                                                                        for($i = 0; $i < (int)$row["Valutazione"]; $i++){
                                                                            echo "<span class='fa fa-star checked'></span>";
                                                                        }
                                                                        if($blackStar > 0) {
                                                                            for($i = 0; $i < $blackStar; $i++){
                                                                                echo "<span class='fa fa-star'></span>";
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <button type="submit" class="btn btn-sm btn3d btn-default menu_bt">MENU</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        <?php
                                }
                            }
                        } else {

                                ?>

                                <h4 class="catHr">Tutte le Categorie<h4>
                                <?php
                                $q="SELECT DISTINCT cef.Nome, f.ID_FORNITORE, f.Ristorante, f.Cellulare, f.Valutazione, m.ID_MENU, f.path_photo
                                FROM categorie as cat, categoria_ristorante as cef, fornitore as f, menu as m
                                WHERE cat.ID_FORNITORE = f.ID_FORNITORE AND cef.ID_CAT = cat.ID_CAT GROUP BY f.Ristorante";

                                $rows = array();
                                $result = $mysqli->query($q);
                                while($row = $result->fetch_array()) {
                                    $rows[] = $row;
                                }
                                foreach($rows as $row) {
                                        ?>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <form action='resturant.php' method="GET">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <img alt="resturant_image" width=300px; height="150px;" class="rounded-circle" src="<?php echo $row['path_photo']?>">
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <input type="hidden" name="id" value="<?=$row['ID_FORNITORE'];?>" />
                                                                        <a href=<?php echo "resturant.php?id=".$row['ID_FORNITORE']?>><h5><?php echo $row["Ristorante"]?></h5></a>
                                                                        <small><?php echo $row["Nome"]?></small>
                                                                        <p><small><?php echo $row["Cellulare"]?></small></p>
                                                                        <?php
                                                                        $fiveStar = 5;
                                                                        $blackStar = 5;
                                                                        $blackStar -= (int)$row["Valutazione"];
                                                                        for($i = 0; $i < (int)$row["Valutazione"]; $i++){
                                                                            echo "<span class='fa fa-star checked'></span>";
                                                                        }
                                                                        if($blackStar > 0) {
                                                                            for($i = 0; $i < $blackStar; $i++){
                                                                                echo "<span class='fa fa-star'></span>";
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <button type="submit" class="btn btn-sm btn3d btn-default menu_bt">MENU</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        <?php
                                }
                        }
                    ?>





                </div>


            </div>
        </div>
    </section>


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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>

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
