<?php
session_start();
$button="";
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

        $q="SELECT * from utente where Email='justunieat@gmail.com'";
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

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "just_database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
/*
UPDATE Customers
SET ContactName = 'Alfred Schmidt', City= 'Frankfurt'
WHERE CustomerID = 1;
*/
if(isset($_POST["fornUpdate"])) {
    echo "yesss";
    console.log("sciaooo");
    $count = 0;
    $update ="SET";
    if(isset($_POST["nomeF"])) {
        $count++;
        $update .= "Nome = . '".$_POST['nomeF']."'";
    }
    if(isset($_POST["cognomeF"])) {
        $count++;
        $update .= "Cognome = . '".$_POST['cognomeF']."'";
    }
    if(isset($_POST["cellF"])) {
        $count++;
        $update .= "Cellulare = . '".$_POST['cellF']."'";
    }
    if(isset($_POST["citta"])) {
        $count++;
        $update .= "Città = . '".$_POST['citta']."'";
    }
    if(isset($_POST["partita_iva"])) {
        $count++;
        $update .= "Partita_IVA = . '".$_POST['partita_iva']."'";
    }
    if(isset($_POST["via_e_num"])) {
        $count++;
        $update .= "Via_e_Num = . '".$_POST['via_e_num']."'";
    }
    if(isset($_POST["email"])) {
        $count++;
        $update .= "Email = . '".$_POST['via_e_num']."'";
    }

    $query = "UPDATE fornitore WHERE ID_FORNITORE = '".$_POST['ID_FORNITORE']."' ";

    if(count($count) == 1) {
        $query .= $update;
        $conn->query($query);
        $conn->close();
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

                    $tmp=$_COOKIE['session'];

                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "just_database";

                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    $m="SELECT * FROM utente";
                    $m .= $button;
                        $query=mysqli_query($conn, $m);
                        while($utente = $query->fetch_array()) {
                            $utentes[] = $utente;                
                        }
                        foreach($utentes as $utente) {
                        ?>
                        <div class="container item">
                            <form method="POST" >
                                <div class="card usr_block">     
                                    <div class="card-body usr_body">
                                        <div class="row">
                                            <div class="p-2 col-md-4">
                                                <h5><?php echo $utente["Nome"] . " " . $utente["Cognome"]?></h5>
                                            </div>
                                            <div class="p-2 col-md-4">
                                                <p><?php echo "Cellulare: " .$utente["Cellulare"]?></p>
                                            </div>
                                            <div class="p-2 col-md-4">
                                                <p><?php echo "ID: " .$utente["ID_USER"]?></p>
                                            </div>  
                                        </div>
                                                     

                                        <div class="row">
                                            <div class="p-2 col-md-6">
                                                <p><?php echo "Email: " .$utente["Email"]?></p>
                                            </div>
                                            <div class="p-2 col-md-6">
                                                <p><?php echo "Abilitato: " .$utente["abilitato"]?></p>
                                            </div>         
                                        </div>

                                        <div class="row">
                                            <div class="p-2 col-md-12">
                                                <a class="btn btn-warning btn3d" data-toggle="collapse" href="#collapseExample<?php echo $utente['ID_USER']?>" 
                                                role="button" aria-expanded="false" aria-controls="collapseExample">EDIT</a>
                                                    <div class="collapse" id="collapseExample<?php echo $utente['ID_USER']?>">
                                                        <div class="card card-body">
                                                            <div id="collapse1" class="collapse show">
                                                                <form method="POST"></form>
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-md-2 col-lg-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Nome</label>
                                                                                    <input name="nome" type="text" class="form-control" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-1 col-lg-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Cognome</label>
                                                                                    <input name="cognome" type="text" class="form-control" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 col-lg-4 text-center">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">ID</label>
                                                                                    <input disabled placeholder="<?php echo $utente['ID_USER']?>" value="<?php echo $utente['ID_USER']?>" class="form-control" type="text" />
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-4 col-lg-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Email</label>
                                                                                    <input name="email" type="text" class="form-control" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 col-lg-3">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Cellulare</label>
                                                                                    <input name="cell" type="text" class="form-control" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3 col-lg-3">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Abilitato</label>
                                                                                    <input name="abilitato" type="text" class="form-control" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    
                                                                        <div class="row">
                                                                            <div class="col-md-3 col-lg-12">
                                                                                <div class="form-group">
                                                                                    <button type="submit" name="userUpdate" class="btn-sm btn-success btn3d">AGGIORNA</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                     
                                    </div>
                                </div> 
                                         
                            </form>
                        
                        <?php
                    }
                ?> 
         </div>
       
         
        <div class="tab-pane fade show col-sm-12" id="AccForn" role="tabpanel" aria-labelledby="home-tab">
                

            <div class="row">
                <div class="col-sm-2">
                    <button type="submit" value="orderSurnameR" class="btn btn-primary btn3d">ORDINA PER COGNOME</button>
                </div>
                <div class="col-sm-2">
                    <button type="submit" value="orderRID" class="btn btn-primary btn3d">ORDINA PER ID</button>
                </div>
                <div class="col-sm-4">
                    <h3 class="text-center">Dashboard Fornitori</h3>
                </div>
                <div class="col-sm-2">
                    <button type="submit" value="orderRist" class="btn btn-primary btn3d">ORDINA PER RISTORANTE</button>
                </div>
                <div class="col-sm-2">
                    <button type="submit" value="topOrders" class="btn btn-primary btn3d">CON PIU' ORDINI</button>
                </div>
                
            </div>

                <?php

                $tmp=$_COOKIE['session'];

                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "just_database";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                    $m="SELECT * FROM fornitore";
                        $query=mysqli_query($conn, $m);
                        while($fornitore = $query->fetch_array()) {
                            $fornitores[] = $fornitore;                
                        }
                        foreach($fornitores as $fornitore) {
                        ?>
                        <div class="container item">
                            <div class="card usr_block">
                                <div class="card-body ">
                                    <div class="row ">
                                        <div class=" col-md-3">
                                            <h5><?php echo $fornitore["Nome"] . " " . $fornitore["Cognome"]?></h5>
                                        </div>
                                        <div class=" col-md-3">
                                            <p><?php echo "Cellulare: " .$fornitore["Cellulare"]?></p>
                                        </div>
                                        <div class=" col-md-3">
                                            <p><?php echo "ID: " .$fornitore["ID_FORNITORE"]?></p>
                                        </div>
                                        <div class=" col-md-3">
                                            <p><?php echo "Partita_IVA: " .$fornitore["Partita_IVA"]?></p>
                                        </div>
                                                        
                                    </div>
                                            
                                    <div class="row">
                                        <div class=" col-md-4">
                                            <p><?php echo "Email: " .$fornitore["Email"]?></p>
                                        </div>
                                        <div class=" col-md-4">
                                            <p><?php echo "Ristorante: " .$fornitore["Ristorante"]?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><?php echo "Location: " .$fornitore["Città"] . ' - ' .$fornitore["Via_e_Num"] ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="p-2 col-md-12">
                                            <a class="btn btn-warning btn3d" data-toggle="collapse" href="#collapseExample<?php echo $fornitore['ID_FORNITORE']?>" 
                                            role="button" aria-expanded="false" aria-controls="collapseExample">EDIT</a>
                                                 <div class="collapse" id="collapseExample<?php echo $fornitore['ID_FORNITORE']?>">
                                                    <div class="card card-body">
                                                        <div id="collapse1" class="collapse show">
                                                            <form method="POST"></form>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-2 col-lg-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Nome</label>
                                                                                <input name="nomeF" type="text" class="form-control" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1 col-lg-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Cognome</label>
                                                                                <input name="cognomeF" type="text" class="form-control" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 col-lg-2 text-center">
                                                                            <div class="form-group">
                                                                                <label class="control-label">ID</label>
                                                                                <input disabled placeholder="<?php echo $fornitore['ID_FORNITORE']?>" value="<?php echo $fornitore['ID_FORNITORE']?>" class="form-control" type="text" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 col-lg-3">
                                                                            <div class="form-group">
                                                                               <label class="control-label">Partita_IVA</label>
                                                                                <div class="input-group">
                                                                                    <input name="partita_iva" class="form-control" type="text" />
                                                                                </div> 
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-4 col-lg-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Email</label>
                                                                                <input name="emailF" type="text" class="form-control" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 col-lg-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Cellulare</label>
                                                                                <input name="cellF" type="text" class="form-control" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 col-lg-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Città</label>
                                                                                <input name="citta" type="text" class="form-control" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 col-lg-2">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Via</label>
                                                                                <input name="via" type="text" class="form-control" />
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-3 col-lg-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Ristorante</label>
                                                                                <input name="ristorante" type="text" class="form-control" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                
                                                                    <div class="row">
                                                                        <div class="col-md-3 col-lg-12">
                                                                            <div class="form-group">
                                                                                <button type="submit" name="fornUpdate" class="btn-sm btn-success btn3d">AGGIORNA</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
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
