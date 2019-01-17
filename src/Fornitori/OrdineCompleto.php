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
     <title>Just Uni Eat Fornitori - Ordine #ADDNUMBERWITHPHPORJS</title>
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

<!--IL TUO ORDINE -->

<div class="menu col-lg-4">
</div>

<div class="container-fluid col-lg-8 col-sm-12 ">
  <h5 class="mb-0 " style="text-align:center;">ORDINE #ADDWITHPHPORJS</h5>

  <div class="container-fluid row">
    <div class="col-sm-6 col" style="">
      Piatti:</br>
      Creato:</br>
      data</br>
      Fattorino:</br>
      NomeFattorino</br>
    </div>

    <div class="col-sm-6 col">
      Prezzo</br>
      Consegnato:</br>
      data</br>
      Tel:</br>
      Telefono</br>
    </div>
</div>

  <h5 class="mb-0" style="text-align:center">Valutazione</h5>

  <button class="btn btn-default col" style="margin-top:1em" onclick="window.location.href='OrdiniF.php'">INDIETRO</button>
</div>


 </body>
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>
