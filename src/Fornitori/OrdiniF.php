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

$QueryOrdF= $mysqli->prepare("SELECT * FROM ordine WHERE ID_RESTURANT = ? AND ORDINE_INVIATO = 1 ORDER BY Orario_richiesto DESC");
$QueryOrdF->bind_param("i", $_SESSION["ID_FORNITORE"]);

$QueryOrdF->execute();

$result = $QueryOrdF->get_result();
$i=0;
while($row = $result->fetch_assoc()){
  $ord[$i] = $row["ID_ORDINE"];
  $time[$i] = $row["Orario_Richiesto"];
  $state[$i] = $row["Stato"];
  $user[$i] = $row["ID_USER"];
  $rest[$i] = $row["ID_RESTURANT"];
  $loc[$i] = $row["Luogo"];
  $val[$i] = $row["valutazione"];
  $sent[$i] = $row["ORDINE_INVIATO"];

  //echo '<br>'.$ord[$i].' '.$time[$i].' '.$state[$i].' '.$user[$i].' '.$rest[$i].' '.$loc[$i].' '.$val[$i].' '.$sent[$i]."<br>";
  $i++;
}
//var_dump(count($ord));
 ?>

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
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="icon" href="http://example.com/favicon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="style.css">
    <link href='https://fonts.googleapis.com/css?family=Faster One' rel='stylesheet'>
     <title>Just Uni Eat Fornitori - I tuoi ordini</title>
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
                      <span id="countMess" class="badge badge-danger">

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

<!--I TUOI ORDINI -->

<div id="accordion" class="container col-sm-12 col-md-8">
  <h2 class="text-center onBoard ">I TUOI ORDINI</h2>
  <hr class="onBoard-hr onBoard-space-md">
  <div class="card">
    <table class="card-header table" id="headingTitle">
      <thead>
      <h5 class="mb-0">
        <tr class="">
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
      </thead>
    </table>
  </div>
<?php
for($i=0; $i< count($ord); $i++){
  echo '<div class="card">
        <button class="btn btn-default card-header" id="headingOne" data-toggle="collapse" data-target="#collapse'.$ord[$i].'" aria-expanded="true" aria-controls="collapseOne">
          '. '<strong>' . 'Ordine: ' .$ord[$i]. '</strong>' .'
        </button>

    <div id="collapse'.$ord[$i].'" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
      <table class="card-body table">
      <tbody>
        <tr class="row">
          <td class="col-lg-3 text-center">'.$loc[$i].'</td>
          <td class="col-lg-3">'.$time[$i].'</td>
          <td class="col-lg-3" style="text-align:center">';

          if($state[$i]==1)
                  echo 'Concluso</br>';
                else if ($state[$i]==0)
                  echo 'In consegna</br>';
                else if ($state[$i]==-1)
                  echo 'Annullato</br>';


          echo'</td>
          <td class="col-lg-3 text-center"><button class="btn btn-sm btn-info" onclick="window.location.href=\'OrdineCompleto.php?n='.$ord[$i].'\'">Dettagli</button></td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>';
}
 ?>

  <button class="btn btn-warning btn3d col onBoard-space-md" onclick="window.location.href='HomeF.php'">INDIETRO</button>
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

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
    <script src="Toasty.js-master/dist/toasty.min.js"></script>

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

                    document.getElementById("countMess").innerHTML = "0";

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

    var interval = 3000; //3 secondi

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
