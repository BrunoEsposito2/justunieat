<?php
include_once("./addAndRemove.php");
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
    <link href='https://fonts.googleapis.com/css?family=Nosifer' rel='stylesheet'>
    <title>Just Uni Eat | Checkout</title>
</head>

<body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="#">Just Uni Eat</a>
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


    <div class="jumbotron">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Checkout</h1>
            </div>
        </div>

				<?php
					$servername = "localhost";
					$username = "root";
					$password = "";
					$dbname = "just_database";

					$conn = new mysqli($servername, $username, $password, $dbname);
					if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
					}

					$sommaPrezzi = 0;
					$sel = "SELECT * FROM carrello";
			    $ex = mysqli_query($conn, $sel);
			    if($ex) {
			      echo "Query eseguita";
			    	while($riga = mysqli_fetch_array($ex)) {
				?>

							<div class="container item">
									<div class="row">
											<div class="col-sm-12 col-sm-offset-2">
													<div class="card">
															<div class="card-body">
																	<div class="row ing ">
																			<div class="col-xs-3">
																					<div class="d-flex justify-content-between">
																							<div class="p-2">
																									<h5>
																									<?php
																										echo $riga['Nome'];
																									?>
																								</h5>
																							</div>
																							<div class="p-2">
																									<p>
																									<?php
																										$sommaPrezzi += $riga['Prezzo'];
																										echo $riga['Prezzo'];
																									?>€
																								</p>
																							</div>
																							<div class="p-3">
																								<p>
																									<?php
																									$sommaPrezzi *= $riga['Quantita'];
																									echo "Quantità: ".$riga['Quantita'];
																									 ?>
																								</p>
																							</div>
																					</div>
																			</div>
																	</div>
																	<div class="row">
																			<div class="col-md-12">
																					<div class="d-flex flex-row-reverse">
																							<div class="p-2"><button type="button" id="<?php echo $riga['Nome'] ?>" onclick="remove(this.id)" class="btn btn-default btn-sm btn3d"><i
																													class="material-icons md-36">remove_circle</i></button>
																							</div>
																					</div>
																			</div>
																	</div>
																	<div class="row ing">
																			<div class="col-xs-4 ingredient">
																					<p><?php echo $riga['Ingredienti']; ?></p>
																			</div>
																	</div>
															</div>
													</div>
											</div>
									</div>
							</div>
							<?php
						}
					} else {
						echo "Query non eseguita";
					}
					?>
						<div class="jumbotron">
								<div class="container item">
										<div class="row">
												<div class="d-flex align-items-start">
														<p><i class="material-icons">euro_symbol</i>Totale: <?php echo $sommaPrezzi?> €</p>
												</div>
										</div>

					            <form name="saveOrder" method="POST">
					                <div class="form-group row">
					                    <label class="col-sm-3 col-form-label"><i class="material-icons">access_time</i>Orario di consegna:</label>
					                    <div class="col-sm-3">
					                        <div class="input-group registration-date-time ">
					                            <span class="input-group-addon"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></span>
					                            <select type="text" class="form-control" id="ship_date" name="ship_date">
					                                <option value="7">07</option>
					                                <option value="8">08</option>
					                                <option value="9">09</option>
					                                <option value="10">10</option>
					                                <option value="11">11</option>
					                                <option value="12" selected>12</option>
					                                <option value="13">13</option>
					                                <option value="14">14</option>
					                                <option value="15">15</option>
					                                <option value="16">16</option>
					                                <option value="17">17</option>
					                                <option value="18">18</option>
					                                <option value="19">19</option>
					                            </select>
					                            <span class="input-group-addon"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></span>
					                            <select type="text" class="form-control" id="shiptime" name="ship_time">
					                                <option value="00" selected>00</option>
					                                <option value="15">15</option>
					                                <option value="30">30</option>
					                                <option value="45">45</option>
					                            </select>
					                        </div>
					                    </div>
					                </div>

					                <div class="form-group row">
					                    <label for="" class="col-sm-3 col-form-label"><i class="material-icons">edit_location</i>Luogo di
					                        consegna:</label>
					                    <div class="col-sm-4">
					                        <input type="text" name="place" class="form-control" id="consegna" placeholder="Sala Ristoro">
					                    </div>
					                </div>


					                <div class="form-row text-center">
					                    <div class="col-12">
					                        <button type="submit" name="saveOrder" class="btn btn-success btn-lg btn3d reg_but">INVIA ORDINE!</button>
															</div>
					                </div>
						</div>
          </form>
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

    <script>
    function getCookie(nome) {
    var name = nome + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ')
            c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";

    }
    if(getCookie("session")) {
        console.log(var_dump(getCookie("session")));
    } else {
        console.log("non va");
    }


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

		<script>
		function remove(el) {
				var httpRequest = new XMLHttpRequest();
				httpRequest.onreadystatechange = function()	{
						location.reload(true);
						//document.getElementById(el).innerHTML = this.responseText; //FOR DEBUGGING
				};
				httpRequest.open("GET", "removeRecord.php?val="+el, true);
				httpRequest.send();
		}
		</script>

</body>


</html>
