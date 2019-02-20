<?php
define("HOST", "localhost"); // E' il server a cui ti vuoi connettere
define("USER", "admin_user"); // E' l'utente con cui ti collegherai al DB.
define("PASSWORD", "Justunieat2019"); // Password di accesso al DB.
define("DATABASE", "just_database"); // Nome del database.
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

session_start();

if(!isset($_SESSION["ID_FORNITORE"])){
  header("location: ../index/accedi.php");
}
//echo $_SESSION["Nome"] . "<br>" . $_SESSION["Cognome"];
$ord = [];
$QueryOrdiniF = $mysqli->prepare("SELECT * FROM ordine WHERE ID_RESTURANT = ? AND ORDINE_INVIATO = 1 AND Stato != -1");
$QueryOrdiniF->bind_param("i", $_SESSION["ID_FORNITORE"]);

$QueryOrdiniF->execute();

$result = $QueryOrdiniF->get_result();

$i=0;
while($row = $result->fetch_assoc()){
  $ord[$i] = $row["ID_ORDINE"];
  $ora[$i] = $row["Orario_Richiesto"];
  $state[$i] = $row["Stato"];
  $user[$i] = $row["ID_USER"];
  $rist[$i] = $row["ID_RESTURANT"];
  $loc[$i] = $row["Luogo"];
  $val[$i] = $row["valutazione"];
  $sent[$i] = $row["ORDINE_INVIATO"];
  //echo $ord[$i];
  $i++;
}

$QueryOrdiniF->close();

$queryPiattiF = $mysqli->prepare("SELECT Nome, Prezzo, Tipologia, Valutazione, Descrizione FROM pietanza WHERE ID_MENU = ?");
$queryPiattiF->bind_param("i", $_SESSION["ID_FORNITORE"]);

$queryPiattiF->execute();

$resultp = $queryPiattiF->get_result();

$y=0;
while($ress = $resultp->fetch_assoc()){
  $name[$y] = $ress["Nome"];
  $prezzo[$y] = $ress["Prezzo"];
  $tipo[$y] = $ress["Tipologia"];
  $valp[$y] = $ress["Valutazione"];
  $desc[$y] = $ress["Descrizione"];
  $y++;
}

 ?>

 <!DOCTYPE html>
 <html lang="it-IT">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <!--Bootstrap CSS-->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
     <link rel="stylesheet" href="style.css">
     <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
     <link rel="icon" href="http://example.com/favicon.png">
     <link href='https://fonts.googleapis.com/css?family=Faster One' rel='stylesheet'>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

     <title>Just Uni Eat Fornitori</title>
 </head>
 <body>

   <!---HEADER--->
   <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
       <a class="navbar-brand" href="HomeF.php">Just Uni Eat</a>
       <div class="collapse navbar-collapse" id="navbarSupportedContent">
         <div class="navbar-nav float-left text-left pr-3">
           <ul class="navbar-nav mr-auto">
             <li class="nav-item">
              <a class="nav-link" href="HomeF.php">Benvenuto!</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="DatiF.php"><?php echo $_SESSION["Nome"] . " " . $_SESSION["Cognome"];?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="navMes" href="MessageF.php">
                  <i class="fa fa-envelope-o">
                      <span id="countMess" style="font-family:sans-serif" class="badge badge-danger">

                          <?php

                          $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

                          if ($conn->connect_error) {
                              die("Connection failed: " . $conn->connect_error);
                          }
                          //NOTIFICA PER MESSAGGI RICEVUTI
                          if(isset($_SESSION["ID_FORNITORE"])) {
                              $q= "SELECT COUNT(*) FROM fornitore AS F, messaggio AS M WHERE
                              F.ID_FORNITORE='".$_SESSION["ID_FORNITORE"]."' AND F.ID_FORNITORE = M.ID_RISTORANTE AND M.Letto='0' AND M.Ricevuto_Dal_Utente='0'";
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
                 <a class="nav-link" href="OrdiniF.php">Miei Ordini</a> <!--da rendere hidden se non si ha fatto ancora l'accesso-->
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../index/logout.php">Esci</a> <!--da rendere hidden se non si ha fatto ancora l'accesso-->
             </li>
           </ul>
        </div>
       </div>
     </nav>

<!--BODY-->

<!--I TUOI ORDINI -->
<button class="ShowMenuF btn btn-default row" style="margin:1em; display:none;" onclick="ToggleMenu()">Menu</button></br>
<script> function ToggleMenu() {

  $(".containerMenu").toggle();
}
</script>

<div class="containerMenu col-sm-12 col-md-4" style="margin-left: 2%; float:left; display:none;">

  <button class="btn btn-default" style="margin-bottom:0.5em" onclick="window.location.href='DatiF.php'">I TUOI DATI</button></br>
  <button class="btn btn-default" style="margin-bottom:0.5em" onclick="window.location.href='OrdiniF.php'">ORDINI</button></br>
  <button class="btn btn-default" style="margin-bottom:0.5em" onclick="window.location.href='ListinoF.php'">LISTINO</button></br>

</div>


<div class="container col-sm-12 col-md-8">
  <h1 class="text-center onBoard homeTitleSpace"><?php echo $_SESSION["Ristorante"] . "<br>";?></h1>
  <hr class="onBoard-hr">
  <h3 class="text-center onBoard onBoard-space">I TUOI ORDINI</h3>
  <hr class="onBoard-hr homeSectionSpace">

  <?php if(count($ord) > 0) {?>
    <table class="table table-hover">
      <thead>
        <tr>
          <th class="text-center titleColor onBoard">ORDINE</th>
          <th class="text-center titleColor onBoard">ORARIO</th>
          <th class="text-center titleColor onBoard">LUOGO</th>
          <th class="text-center titleColor onBoard">STATO</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $maxx;
        if(count($ord) < 5){
            $maxx = count($ord);
        } else {
        $maxx = 4;
        }



          for($x=0; $x < $maxx; $x++){
          echo '<tr>
                  <td class="text-center onBoard">'.$ord[$x].'</td>
                  <td class="text-center onBoard">'.$ora[$x].'</td>
                  <td class="text-center onBoard" >'.$loc[$x].'</td>

                  <td class="text-center onBoard">';if($state[$x]==1)
                          echo 'Concluso</br>';
                        else if ($state[$x]==0)
                          echo 'In consegna</br>';
                        else if ($state[$x]==-1)
                          echo 'Annullato</br>';
                  echo '</td>
                </tr>';
          }
    } else {
      echo "<div class=\"text-center alert alert-dismissible onBoard-space-md fade show alert-warning\" role=\"alert\">
      <h3>Nessun Ordine Da Svolgere!</h3>
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span>
      </button>
    </div>";
    }
      ?>


    </tbody>
  </table>

  <div class="col-sm-4 offset-sm-5">
    <button class="btn btn-info btn3d homeSectionSpace" onclick="window.location.href='OrdiniF.php'">VEDI TUTTI</button>
  </div>
</div>
</br>
<!--I TUOI PIATTI -->
<div class="container col-sm-12 col-md-8">
<hr class="onBoard-hr">
  <h2 class="text-center onBoard">I TUOI PIATTI</h2>
  <hr class="onBoard-hr homeSectionSpace">

  <table class="table table-hover">
    <thead>
      <tr>
        <th class="text-center titleColor onBoard">PIATTO</th>
        <th class="text-center titleColor onBoard">TIPOLOGIA</th>
        <th class="text-center titleColor onBoard">PREZZO</th>
        <th class="text-center titleColor onBoard">DESCRIZIONE</th>
      </tr>
    </thead>
    <tbody>

      <?php
        if(count($name) < 5){
          $maxp = count($name);
        } else {
          $maxp = 4;
        }
        for($h=0; $h < $maxp; $h++){
          echo '<tr>
            <td class="text-center onBoard">'.$name[$h].'</td>
            <td class="text-center onBoard">'.$tipo[$h].'</td>
            <td class="text-center onBoard">'.$prezzo[$h]. ' €' . '</td>
            <td class="text-center onBoard">'.$desc[$h].'</td>
          </tr>';
        }
      ?>

    </tbody>
  </table>

<div class="col-sm-4 offset-sm-5">
  <button class="btn btn-info btn3d" onclick="window.location.href='ListinoF.php'">VEDI TUTTI</button>
</div>
<div class="col-sm-2"></div>
</div>

<div class="content">
    </div>
    <footer id="myFooter">

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

<script>

        var id = <?php echo $_SESSION['ID_FORNITORE']?>;
        $('#inBoxMsg').click(function() {
            $('.msgList').toggle('slow', function() {
            });
        });

        $('#recMsg').click(function() {
            document.getElementById('top_rec_arr').style.display = "block";
            $('.msgListRec').toggle('fadeOut', function() {
                $.ajax({

                url : 'updateMessageCountF.php',
                method : 'post',
                data : {id : id},

                success : function(response) {

                document.getElementById("messUnRead").innerHTML = "0";

                }

                });
            });
        });

</script>

<?php

    if(isset($_SESSION["ID_FORNITORE"])) {

    ?>

    <script>

    $(document).ready(function() {
        var myvar = decodeURIComponent("<?php echo rawurlencode($_SESSION['Ristorante']); ?>");
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

    var id_user = <?php echo $_SESSION['ID_FORNITORE'];?>

    $.ajax({

    url : 'checkMessageNewF.php',
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

var interval = 3000; //30 secondi

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
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>
