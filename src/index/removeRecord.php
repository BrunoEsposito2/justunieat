<?php
  $val = $_REQUEST["val"];
  $sum = $_REQUEST["sum"];

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "just_database";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $take = "SELECT * FROM carrello WHERE Nome='$val'";
  $doQuery = mysqli_query($conn, $take);

  if($doQuery) {
    while($riga = mysqli_fetch_array($doQuery)) {
      if($riga['Nome'] === $val) {
        $updated = $riga['Quantita'];
        $updated--;
        $sum -= $riga['Prezzo'];
        if($updated === 0) {
          $del = "DELETE FROM carrello WHERE Nome='$val'";
          mysqli_query($conn, $del);
        } else {
          $ok = "UPDATE carrello SET Quantita='$updated' WHERE Nome='$val'";
          mysqli_query($conn, $ok);
        }
      }
    }
  }
?>
