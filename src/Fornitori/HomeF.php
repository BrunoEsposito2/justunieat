<?php
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
     <title>Just Uni Eat Fornitori</title>
 </head>
 <body>

   <!---HEADER--->
   <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
       </button>
       <a class="navbar-brand" href="#">Just Uni Eat</a>
        <a href="#">
          <img class="carts" src="../../doc/shopping-cart-empty-side-view.png" alt="shopping carts">
         </a>
       <div class="collapse navbar-collapse" id="navbarSupportedContent">
         <div class="navbar-nav float-left text-left pr-3">
           <ul class="navbar-nav mr-auto">
             <li class="nav-item">
              <a class="nav-link" href="#">Accedi</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Registrati</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Notifiche</a> <!--da rendere hidden se non si ha fatto ancora l'accesso-->
             </li>
             <li class="nav-item">
                 <a class="nav-link" href="#">Miei Ordini</a> <!--da rendere hidden se non si ha fatto ancora l'accesso-->
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Esci</a> <!--da rendere hidden se non si ha fatto ancora l'accesso-->
             </li>
           </ul>
        </div>
       </div>
     </nav>

<!--BODY-->

<!--I TUOI ORDINI -->

<div class="container col-sm-12 col-md-8">
  <h2 style="text-align:center">I TUOI ORDINI</h2>

  <table class="table table-hover">
    <thead>
      <tr>
        <th>ORDINE</th>
        <th>TEMPO</th>
        <th>PREZZO</th>
        <th>STATO</th>
      </tr>
    </thead>
    <tbody>
      <!--TODO PHP -->
      <tr>
        <td>Ordine 1</td>
        <td>Tempo 1</td>
        <td>Prezzo 1</td>
        <td>Stato 1</td>
      </tr>

    </tbody>
  </table>

  <div class="col-sm-2"></div>
  <button class="btn btn-default col-sm-4" onclick="window.location.href='OrdiniF.php'"> Vedi tutti gli ordini </button>
  <div class="col-sm-2"></div>
</div>
</br>
<!--I TUOI PIATTI -->
<div class="container col-sm-12 col-md-8">
  <h2 style="text-align:center">I TUOI PIATTI</h2>

  <table class="table table-hover">
    <thead>
      <tr>
        <th>PIATTO</th>
        <th>TIPOLOGIA</th>
        <th>CUCINA</th>
        <th>PREZZO</th>
      </tr>
    </thead>
    <tbody>
      <!--TODO PHP -->
      <tr>
        <td>Piatto 1</td>
        <td>Tipologia 1</td>
        <td>Cucina 1</td>
        <td>Prezzo 1</td>
      </tr>

    </tbody>
  </table>

<div class="col-sm-2"></div>
  <button class="btn btn-default col-sm-4" onclick="window.location.href='ListinoF.php'"> Vedi tutti i tuoi piatti </button>
<div class="col-sm-2"></div>
</div>
 </body>
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>
