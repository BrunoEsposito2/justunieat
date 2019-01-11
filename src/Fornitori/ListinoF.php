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
     <title>Just Uni Eat Fornitori - Il tuo Listino</title>
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

<!--I TUOI ORDINI -->

<div id="accordion" class="container col-sm-12 col-md-8">
  <h2 style="text-align:center">IL TUO LISTINO</h2>
  <div class="card">
    <div class="card-header" id="headingTitle">
      <h5 class="mb-0" style="text-align:center"> I TUOI PIATTI</h5>

    </div>
  </div>


  <!-- TEMPLATE PER TUTTI I BUTTONS -->
  <div class="card">
    <button class="btn btn-default card-header" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Piatto #1
        </button>
    </div>
    <!-- Cambiare anche gli altri buttons!-->

    <div id="collapseOne" class="collapse container-fluid" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body row">

        <!-- ADD PHP -->
        <div class="classDescrPiatto col-sm-4 col-lg-4">
          <label for="DescrizionePiatto">Descrizione:</label>
          <textarea class="form-control" name="DescrizionePiatto">Descrizione del piatto</textarea>
        </div>

        <div class="classTipoPiatto col-sm-4 col-lg-4">
          <label for="TipoCucina">Cucina:</label>
          <select class="form-control" name="TipoCucina">
            <option selected>Romagnolo</option>
            <option>Giapponese</option>
          </select>

          <label for="TipoPiatto">Piatto:</label>
          <select class="form-control" name="TipoPiatto">
            <option>Primo</option>
            <option>Secondo</option>
          </select>
        </div>

        <div class="classButtonsPiatto col-sm-4 col-lg-4">
          <label for="PrezzoPiatto">Prezzo: </label>
          <h6 class="mb-0" name="PrezzoPiatto">€Millemila</h6>

          <!-- ADD JS OR PHP-->
          <button class="btn btn-default" onclick="" name="ModificaPiatto">Modifica</button>
          <button class="btn btn-default" onclick=""name="EliminaPiatto">Elimina</button>
        </div>
      </div>
    </div>
  </div>
  <!--FINE TEMPLATE PER I BUTTONS -->

  <!-- FILL WITH PHP -->
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Piatto #2
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
        Info piatto
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Piatto #3
        </button>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
      <div class="card-body">
        Info piatto
      </div>
    </div>
  </div>


  <button class="btn btn-default col" style="margin-top:1em" onclick="window.location.href='HomeF.php'">INDIETRO</button>

  <!-- CATEGORIE -->
  <h5 class="mb-0" style="text-align:center; margin-top:1em;"> LE TUE CATEGORIE</h5>


</div>




 </body>
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>
