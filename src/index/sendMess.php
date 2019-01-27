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
    <link rel="stylesheet" href="circleok_ko.css">
    <title>Just Uni Eat | Messaggio</title>
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
                        <a class="nav-link" id="navMes" href="#">
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

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    
        $errors = "";
        $insertError = "";
        $isInserted = false;

        if(!isset($_POST["ristorante"]) || strlen($_POST["ristorante"]) < 2){
        $errors .= "Il nome del Ristorante è obbligatorio e deve avere almeno 2 caratteri <br/>";
        }

        if(!isset($_POST["titolo"]) || strlen($_POST["titolo"]) < 2){
        $errors .= "Il Titolo è obbligatorio e deve avere almeno 2 caratteri";
        }

        if(!isset($_POST["testo"]) || strlen($_POST["testo"]) < 2){
        $errors .= "Il Testo è obbligatorio e deve avere almeno 2 caratteri <br/>";
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

            $orario=time();
            $data=date('d-m-y');
            $q = "SELECT ID_USER FROM utente WHERE Email ='". $_SESSION["email"] ."'";
            
           
            $result=mysqli_query($conn, $q);
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                $id_user = $row['ID_USER'];
                $flag = TRUE;
            }
            
            
            
            $q = "SELECT ID_FORNITORE FROM fornitore WHERE Ristorante='" . $_POST["ristorante"]."'";
            
            $result=mysqli_query($conn, $q);
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                $id_ristorante = $row['ID_FORNITORE'];
                $flag = TRUE;
            }
            

            $stmt = $conn->prepare("INSERT INTO messaggio (Testo, Data, Orario, ID_USER, ID_RISTORANTE, Titolo) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssiis", $testo, $data, $orario, $id_user, $id_ristorante, $titolo);
                    
            $testo = $_POST["testo"];
            $ristorante = $_POST["ristorante"];
            $titolo = $_POST["titolo"];

            $isInserted = $stmt->execute();
            if(!$isInserted){
                $insertError = $stmt->error;
            }
               
            if ($isInserted) {
                $stmt->close();     
                
            }
             
        } 

}    
?>

    <div class="jumbotron" style="background-color:white;">

        <?php

        if($isInserted) {

        ?>    
            <div class="swal2-icon swal2-success swal2-animate-success-icon" style="display: flex;">
                <div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div>
                <span class="swal2-success-line-tip"></span>
                <span class="swal2-success-line-long"></span>
                <div class="swal2-success-ring"></div> 
                <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div>
                <div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div>
            </div>

            <h3 class="text-center">Messaggio correttamente inviato al Ristorante!</h3>

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

            <h3 class="text-center">Errore! Messaggio non corretto!<br><?php echo $errors?>.</h3>
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




