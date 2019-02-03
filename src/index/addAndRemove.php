<?php
  if(isset($_POST['cart'])) {
    $nome = $_POST['cart'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "just_database";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $q="SELECT * FROM pietanza";
    $query=mysqli_query($conn, $q);
    while($pietanze = $query->fetch_array()) {
      $pietanzes[] = $pietanze;
      $pietanze = array();
    }
    //Controllo se è già presente la pietanza nel carrello
    foreach ($nome as $key => $value) {
      $val = $value;
    }

    $check = "SELECT Nome, Prezzo, Ingredienti, Quantita FROM carrello WHERE Nome='$val'";
    $exec = mysqli_query($conn, $check);
    $flag = 0;
    if($exec) {
      //echo "Query eseguita";
      while($riga = mysqli_fetch_array($exec)) {
        if($riga['Nome'] === $val) {
          //echo "E' presente";
          $nuovaQ = $riga['Quantita'];
          $nuovaQ++;
          $update = "UPDATE carrello SET Quantita='$nuovaQ' WHERE Nome='$val'";
          mysqli_query($conn, $update);
          $flag = 1;
        } else {
          //echo "Non è presente";
        }
      }
    } else {
      //echo "Query non eseguita";
      $flag = 2;
    }

    if($flag === 0) {
      $num = mysqli_num_rows($query);
      $num--;
      while($num > -1) {
        extract($pietanzes[$num]);
        if($Nome === $val) {
          $insert = "INSERT INTO carrello(Nome, Prezzo, Ingredienti, Quantita) VALUES('$val', '$Prezzo', '$Descrizione', 1)";
          $quer = mysqli_query($conn, $insert);
        if(!$quer) {
          //echo "NON ESEGUITA".$conn->error;
        } else {
          //echo "ESEGUITA";
        }
        //echo $Nome." ".$Prezzo." ".$Descrizione;
      }
      $num--;
    }
  }
}


if(isset($_POST['saveOrder'])) {
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "just_database";

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
	}

	$time = $_POST['ship_time'];
	$stato = "in lavorazione";

	$qOrder = "INSERT INTO ordine(Orario_richiesto, Stato) VALUES ('$time', '$stato')";

	if(!$conn->query($qOrder)) {
		$conn->error;
	}

}
?>
