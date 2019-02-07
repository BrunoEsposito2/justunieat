<?php
  session_start();
  $id_pietanza = $_REQUEST["val"];
  $sum = $_REQUEST["sum"];

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
      if($riga['ID_PIETANZA'] === $id_pietanza) {
        $updated = $riga['Quantita'];
        $updated--;
        $sum -= $price;
        if($updated === 0) {
          $del = "DELETE FROM pietanza_nel_ordine WHERE ID_PIETANZA='$id_pietanza'";
          mysqli_query($conn, $del);
          $delFromOrd = "DELETE FROM ordine WHERE ID_ORDINE='$id_ordine' AND ORDINE_INVIATO=0";
          mysqli_query($conn, $delFromOrd);
        } else {
          $ok = "UPDATE pietanza_nel_ordine SET Quantita='$updated' WHERE ID_PIETANZA='$id_pietanza'";
          mysqli_query($conn, $ok);
        }
      }
    }
  }
?>
