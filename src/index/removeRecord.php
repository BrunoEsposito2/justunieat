<?php
  session_start();
  $id_pietanza = $_REQUEST["val"];
  $sum = $_REQUEST["sum"];

  $id_sess = $_SESSION['id'];

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "just_database";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $getPrice = "SELECT * FROM pietanza";
  $exGetP = mysqli_query($conn, $getPrice);
  while($row = mysqli_fetch_array($exGetP)) {
    if($row['ID_PIETANZA'] === $id_pietanza) {
      $price = $row['Prezzo'];
    }
  }

  $takeIdOrd = "SELECT * FROM pietanza_nel_ordine";
  $exTakeIO = mysqli_query($conn, $takeIdOrd);
  while($id = mysqli_fetch_array($exTakeIO)) {
    if($id['ID_PIETANZA'] === $id_pietanza) {
      $id_ordine = $id['ID_ORDINE'];
    }
  }

  $take = "SELECT * FROM pietanza_nel_ordine";
  $doQuery = mysqli_query($conn, $take);

  if($doQuery) {
    while($riga = mysqli_fetch_array($doQuery)) {
      if($riga['ID_PIETANZA'] === $id_pietanza && !$riga['PIETANZA_ORDINATA']) {
        $updated = $riga['Quantita'];
        $updated--;
        $sum -= $price;
        if($updated === 0) {
          $del = "DELETE FROM pietanza_nel_ordine WHERE ID_PIETANZA='$id_pietanza' AND PIETANZA_ORDINATA=0";
          mysqli_query($conn, $del);
          //Se in pietanza nel ordine non c'è più nessun id_ordine equivalente con quello in ordine allora elimino anche l'ORDINE
          // 1. Seleziono l'ordine con id user e ordine inviato = 0
          $takeOr = "SELECT ID_ORDINE FROM ordine WHERE ID_USER='$id_sess' AND ORDINE_INVIATO=0";
          $execute = mysqli_query($conn, $takeOr);
          while($ordine = $execute->fetch_array()) {
            $getOrd = $ordine;
          }
          foreach ($getOrd as $key => $value) {
            $getted = $value;
          }
          // 2. Controllo se in pietanza_nel_ordine c'è questo id ordine
          $doControl = "SELECT * FROM pietanza_nel_ordine WHERE ID_ORDINE='$getted' AND PIETANZA_ORDINATA=0";
          $execControl = mysqli_query($conn, $doControl);
          $getCount = mysqli_num_rows($execControl);
          if($getCount === 0) {
            $delFromOrd = "DELETE FROM ordine WHERE ID_ORDINE='$id_ordine' AND ORDINE_INVIATO=0";
            mysqli_query($conn, $delFromOrd);
          }
        } else {
          $ok = "UPDATE pietanza_nel_ordine SET Quantita='$updated' WHERE ID_PIETANZA='$id_pietanza' AND PIETANZA_ORDINATA=0";
          mysqli_query($conn, $ok);
        }
      }
    }
  }
?>
