<?php

define("HOST", "localhost"); // E' il server a cui ti vuoi connettere
define("USER", "admin_user"); // E' l'utente con cui ti collegherai al DB.
define("PASSWORD", "Justunieat2019"); // Password di accesso al DB.
define("DATABASE", "just_database"); // Nome del database.
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if(isset($_POST["inputNameF"]) &&
   isset($_POST["inputSurnameF"]) &&
   isset($_POST["inputCellF"]) &&
   isset($_POST["inputPIVAF"]) &&
   isset($_POST["inputCellF"]) &&
   isset($_POST["inputEmailF"]) &&
   isset($_POST["inputPasswordF"])
 ){
   if($_POST["inputPasswordF"] == $_POST["inputConfirmPasswordF"]){
        //echo "Le password sono uguali";

     //Registration starts here
     /*echo $_POST["inputNameF"] ."<br>".
        $_POST["inputSurnameF"] ."<br>".
        $_POST["inputCellF"] ."<br>".
        $_POST["inputPIVAF"] ."<br>".
        $_POST["inputCellF"] ."<br>".
        $_POST["inputEmailF"] ."<br>".
        $_POST["inputPasswordF"]; */

        //Need to check if Email is already registered
        $queryCheckF = $mysqli->prepare("SELECT Email FROM fornitore WHERE Email = ?");

        $email=$_POST["inputEmailF"];

        $queryCheckF->bind_param("s", $email);



        $queryCheckF->execute();

        //La query mi restituisce un solo campo
        $queryCheckF->bind_result($email);

        $queryCheckF->fetch();

        //echo "<br><br>" . $email . "<br>";

        $queryCheckF->close();

        //Checks if Email already exists
        if($email==NULL){

          //If not exists
          $queryRegF = $mysqli->prepare("INSERT INTO fornitore(Nome, Cognome, Ristorante, Cellulare, Partita_IVA, Email, Password) VALUES (?, ?, ?, ?, ?, ?, ?)");


          //Must generate sha512 Password

          $queryRegF->bind_param("sssssss", $_POST["inputNameF"], $_POST["inputSurnameF"], $_POST["inputRistoranteF"], $_POST["inputCellF"], $_POST["inputPIVAF"], $_POST["inputEmailF"], $_POST["inputPasswordF"]);

          //WORKS   <<<<<<<REMEMBER TO DECOMMENT>>>>>>>>>
          $queryRegF->execute();

          //echo "New record created on Table fornitori";

//<<<<<<< HEAD
          $queryRegF->close();

          $queryMenuF = $mysqli->prepare("SELECT ID_FORNITORE FROM fornitore WHERE Email = ?");
          $queryMenuF->bind_param("s", $_POST["inputEmailF"]);

          $queryMenuF->execute();

          $queryMenuF->bind_result($idmenu);

          $queryMenuF->fetch();

          $queryMenuF->close();

          $queryMenuFInse = $mysqli->prepare("INSERT INTO menu(ID_FORNITORE, ID_MENU) VALUES (?, ?)");

          $queryMenuFInse->bind_param("ii", $idmenu, $idmenu);

          $queryMenuFInse->execute();

          $queryMenuFInse->close();

          header("location: /../Progetto2019/src/Fornitori/HomeF.php");
//||||||| merged common ancestors
          header("location: /../Progetto2019/src/Fornitori/HomeF.php");
//=======
          header("location: HomeF.php");
//>>>>>>> 4a00fa3e03cc74be24543ef9a29798360009812a
        } else {
          //If exists
          echo "<br>La mail " . $email . " è già registrata. <br>";

        }
      } else {
          echo "Le password non coincidono!";
          header("location: /../Progetto2019/src/index/registrati.php?pass=1");
      }

 } else {
   echo "Hai dimenticato di inserire un campo";
 }

 ?>
