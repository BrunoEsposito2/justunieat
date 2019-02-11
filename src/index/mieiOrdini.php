<?php
session_start();

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
    <link href='https://fonts.googleapis.com/css?family=Faster One' rel='stylesheet'>
    <title>Just Uni Eat | Miei Ordini</title>
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

    <div class="jumbotron text-center">
        <h2 class="numbOrder">Miei Ordini</h2>
        <div class="fixed-top alert" id="ajax-alert" style="display:none">
            <p>Ordine valutato correttamente!</p>
        </div>
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $count = 0;  
                    $id_ordine = 0;  
                    $m="SELECT * FROM pietanza_nel_ordine AS P, pietanza as C, ordine AS O WHERE C.ID_PIETANZA = 
                    P.ID_PIETANZA AND P.ID_ORDINE = O.ID_ORDINE AND O.ID_USER = ". $idUs . " ORDER BY P.ID_ORDINE DESC";
                    $query=mysqli_query($conn, $m);
                    while($ordine = $query->fetch_array()) {
                        $ordines[] = $ordine;
                    }
                    foreach($ordines as $ordine) {
                    ?>
                    <div class="container item">
                        <div class="row">
                            <div class="col-sm-12 col-sm-offset-2">
                                <div class="card">
                                    <div class="card-body">
                                        <?php if($id_ordine == $ordine['ID_ORDINE']) {
                                            goto samePietanza;
                                        }
                                            $count++;
                                            $id_ordine = $ordine['ID_ORDINE'];?>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <h4 class="text-left numbOrder"># <?php echo $count ?></h4>
                                            </div>
                                            <div class="col-sm-11 text-right">
                                                <?php 
                                                if($ordine["Stato"] == 1) {
                                                ?>    
                                                    <i title="Ordine Concluso" class="material-icons">check_circle_outline</i>
                                                <?php    
                                                } else if ($ordine["Stato"] == 0) {
                                                ?>    
                                                    <i title="Ordine in Consegna" class="material-icons">directions_run</i>
                                                <?php    
                                                } else if ($ordine["Stato"] == -1) {
                                                ?>
                                                    <i title="Ordine Annulato" class="material-icons">cancel</i>
                                                <?php    
                                                }
                                                ?>
                                                
                                            </div>

                                        </div>
                                        
                                        
                                        <div class="row ing ">
                                            <div class="col-xs-3">
                                                <div class="d-flex justify-content-between">
                                                    <div class="p-2">
                                                        <h5><?php echo "ID: " . $ordine["ID_ORDINE"]?></h5>
                                                    </div>
                                                    <div class="p-2">
                                                        <p><?php echo "Orario di Consegna: " . $ordine['Orario_Richiesto']?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="d-flex flex-row-reverse">
                                                    <?php
                                                    echo $ordine["valutazione"];
                                                    if($ordine['valutazione'] == null)  {
                                                    ?>
                                                        <form method="POST">
                                                            <fieldset class="rating">
                                                                <input type="radio" id="star5" name="rating" value="5<?php echo $ordine["ID_ORDINE"]?>" /><label class = "full" for="star5" title="Eccellente"></label>
                                                                
                                                                <input type="radio" id="star4" name="rating" value="4<?php echo $ordine["ID_ORDINE"]?>" /><label class = "full" for="star4" title="Molto buono"></label>
                                                                
                                                                <input type="radio" id="star3" name="rating" value="3<?php echo $ordine["ID_ORDINE"]?>" /><label class = "full" for="star3" title="Nella media"></label>
                                                                
                                                                <input type="radio" id="star2" name="rating" value="2<?php echo $ordine["ID_ORDINE"]?>" /><label class = "full" for="star2" title="Discreto"></label>
                                                                
                                                                <input type="radio" id="star1" name="rating" value="1<?php echo $ordine["ID_ORDINE"]?>" /><label class = "full" for="star1" title="Molto scarso"></label>
                                                                
                                                            </fieldset>
                                                        </form>   
                                                    <?php
                                                    } else {
                                                    ?>    
                                                        <div class="ratings">
                                                            <ul class="list-inline">
                                                            <?php
                                                                
                                                                $fiveStar = 5;
                                                                $blackStar = 5;
                                                                $blackStar -= (int)$ordine["valutazione"];
                                                                if($fiveStar > 0) {
                                                                    for($i = 0; $i < (int)$ordine["valutazione"]; $i++){
                                                                        echo "<span class='fa fa-star checked'></span>";
                                                                    }
                                                                }
                                                                
                                                                if($blackStar > 0) {
                                                                    
                                                                    for($j = 0; $j < $blackStar; $j++){
                                                                        echo "<span style='color:black;' class='fa fa-star'></span>";
                                                                    }
                                                                }
                                                                ?>
                                                            </ul>
                            
                                                        </div>
                                                    <?php    
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row ing">
                                        <div class="col-xs-6">
                                                <div class="d-flex justify-content-between">
                                                    <div class="p-2">
                                                        <p><?php echo "Luogo Consegna: " . $ordine['Luogo']?></p>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    
                                
                                        
                                        <hr>
                                                    <!--PIETANZE-->
                                        <?php samePietanza: ?>
                                        <div class="row ing">
                                            <div class="col-xs-6">
                                                <div class="d-flex justify-content-between">
                                                    <div class="p-2">
                                                        <h5><?php echo $ordine["Nome"]?></h5>
                                                    </div>
                                                    <br>
                                                    <div class="p-2">
                                                     <p><?php echo $ordine['Tipologia']?></p> 
                                                    </div>
                                                    <div class="p-2">
                                                        <p><?php echo $ordine['Prezzo'] . " €"?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row ing">
                                            <div class="col-xs-3">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="p-2">
                                                            <p><?php echo $ordine["Descrizione"]?></p>
                                                        </div>
                                                        <div class="iconWrap">
                                                            <?php if($ordine["Vegetariano"]) {
                                                                ?><a title="Vegetariano"><i class="material-icons">spa</i><?php
                                                            }

                                                            if($ordine["Piccante"]) {
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
                        </div>
                    <?php
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
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
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


        
        $(document).ready(function() {

        
            $(".rating").on('change', function(e){
        
                var value = $('input[name=rating]:checked').val();
                var VALUE = value.substring(0,1);
                
                var ID_ORDINE = value.substring(1, value.length);
                
                
                

                $.ajax({

                    url : 'ajaxRating.php',
                    method : 'post',
                    data : {VALUE : VALUE, ID_ORDINE : ID_ORDINE},

                    success : function(response) {
                    

                    }




                });

            });


            







        });
         

		</script>

</body>

</html>
