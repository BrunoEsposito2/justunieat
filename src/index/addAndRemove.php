<?php
  if(isset($_POST['cart'])) {
    session_start();
    $nome = $_POST['cart'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "just_database";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    /* Seleziono tutte le pietanze nella tabella 'pietanza' e le inserisco in un vettore */
    $takeFromPietanza = "SELECT * FROM pietanza";
    $doP = mysqli_query($conn, $takeFromPietanza);
    while($piet = $doP->fetch_array()) {
      $pietanza[] = $piet;
      $piet = array();
    }

    /* Dal vettore 'nome' ricavo il suo unico 'value' e lo salvo in un'altra variabile */
    //foreach ($nome as $key => $value) {
      //$val = $value;
    //}

    $doP = mysqli_query($conn, $takeFromPietanza);
    while($ind = mysqli_fetch_array($doP)) {
      if($ind['Nome'] === $nome) {
        $id_piet = $ind['ID_PIETANZA'];
      }
    }


    //Conteggio di tutti gli elementi nella tabella 'pietanza_nel_ordine'
    $count = "SELECT * FROM pietanza_nel_ordine WHERE PIETANZA_ORDINATA=0";
    $doCount = mysqli_query($conn, $count);
    $rows = mysqli_num_rows($doCount);
    /* DEBUGGING PURPOSE
    echo $rows;
    */

    //LA QUERY VA A BUON FINE ALLORA
    if($doCount) {

      echo "Query select eseguita";

      //SE NON CI SONO ANCORA ELEMENTI NELLA TABELLA INSERISCO IL PRIMO ELEMENTO
      if($rows === 0) {
        $ind = 0;                                         //VARIABILE PER IL CONTEGGIO
        $doP = mysqli_query($conn, $takeFromPietanza);    //SELEZIONO TUTTE LE PIETANZE
        while($i = mysqli_fetch_array($doP)) {
          if($i['Nome'] === $nome) {                       //APPENA TROVO IL NOME DI QUELLA DA AGGIUNGERE SALVO L'INDICE
            $indice = $ind;
          }
          $ind++;
        }
        extract($pietanza[$indice]);                      //ESTRAGGO LA PIETANZA CON L'INDICE APPENA TROVATO
        $ID_M = $ID_MENU;                                 // E PRENDO IL VALORE DI 'ID_MENU'
        $takeID_R = "SELECT ID_FORNITORE FROM menu WHERE ID_MENU='$ID_M'";        //QUI USO L'ID_MENU ('ID_M') APPENA ESTRATTO
        $doID_R = mysqli_query($conn, $takeID_R);
        while($ID = $doID_R->fetch_array()) {             //ESTRAGGO L'ARRAY ID_FORNITORE
          $ID_R = $ID;
          /*DEBUGGING PURPOSE
          echo "ID_RESTURANT -> ".print_r($ID_R);
          */
        }
        foreach ($ID_R as $key => $value) {               //RICAVO IL VALORE DELL'ARRAY ID_FORNITORE
          $id_r = $value;
          /*DEBUGGING PURPOSE
          echo "Real ID_R -> ".$id_r;
          */
        }

        /* PART_1 INSERIMENTO: INSERISCO PRIMA NELLA TABELLA ORDINE */
        $user_id = $_SESSION['id'];

        $doOrder = "INSERT INTO ordine(Orario_richiesto, Stato, ID_USER, ID_RESTURANT, ORDINE_INVIATO) VALUES ('12:00', 0, '$user_id', '$id_r', 0)";
        $okOrd = mysqli_query($conn, $doOrder);
        if(!$okOrd) {
          echo "ERROR -> ".$conn->error;
        }
        $takeID_O = "SELECT ID_ORDINE FROM ordine WHERE ID_USER='$user_id' AND ORDINE_INVIATO=0";
        $doID_O = mysqli_query($conn, $takeID_O);
        while($idO = $doID_O->fetch_array()) {                //RICAVO L'ARRAY ID_ORDINE
          $ID_O = $idO;
        }
        foreach ($ID_O as $key => $value) {                   //E NE ESTRAGGO IL VALORE
          $id_o = $value;
          /*  DEBUGGING PURPOSE
          echo "ID_ORDINE -> ".$id_o;
          */
        }

        /* PARTE_2 INSERIMENTO: INSERISCO POI NELLA TABELLA PIETANZA_NEL_ORDINE (SENNO' L'INSERIMENTO NON E' POSSIBILE) */
        $push = "INSERT INTO pietanza_nel_ordine(ID_PIETANZA, ID_ORDINE, Quantita) VALUES ('$id_piet', '$id_o', 1)";
        $okPush = mysqli_query($conn, $push);
        if(!$okPush) {
          echo "Error ".$conn->error;
        }
    /* INVECE SE LA TABELLA HA GIA' ALMENO UN VALORE */
    } else if($rows > 0) {
      $countR = 0;                              //SETTO UNA VARIABILE PER CONTARE LE RIGHE DELLA TABELLA 'pietanza_nel_ordine'
      $user_id = $_SESSION['id'];
      while($get = mysqli_fetch_array($doCount)) {      //INIZIO LA CONTA
          print_r($get);
          if($get['ID_PIETANZA'] === $id_piet && checkID()) {        //SE LA PIETANZA E' GIA' PRESENTE (E SE L'ID_USER IN ORDINE CORRISPONDE ALL'ID_USER CHE E' LOGGATO). . .
            //echo "E' presente, aggiornare quantità";
            $amount = $get['Quantita'];
            $amount++;
            $upd = "UPDATE pietanza_nel_ordine SET Quantita='$amount' WHERE ID_PIETANZA='$id_piet' AND PIETANZA_ORDINATA=0";   // . . . AGGIORNO LA QUANTITA'
            $exUp = mysqli_query($conn, $upd);
          }
          if($countR === $rows - 1) {           //SE ARRIVO ALL'ULTIMA RIGA DELLA TABELLA 'pietanza_nel_ordine' SIGNIFICA CHE LA PIETANZA NON C'E' QUINDI VIENE AGGIUNTA
            if(checkAdd($id_piet, $nome)) {               //PRIMA DI ESSERE AGGIUNTA PERO' VERIFICO SE SI PUO' AGGIUNGERE
              $ind = 0;
              $doP = mysqli_query($conn, $takeFromPietanza);
              while($i = mysqli_fetch_array($doP)) {
                if($i['Nome'] === $nome) {
                  $indice = $ind;
                }
                $ind++;
              }
              extract($pietanza[$indice]);
              $ID_M = $ID_MENU;
              $takeID_R = "SELECT ID_FORNITORE FROM menu WHERE ID_MENU='$ID_M'";
              $doID_R = mysqli_query($conn, $takeID_R);
              while($ID = $doID_R->fetch_array()) {
                $ID_R = $ID;
                //echo "ID_RESTURANT -> ".print_r($ID_R);
              }
              foreach ($ID_R as $key => $value) {
                $id_r = $value;
                //echo "Real ID_R -> ".$id_r;
              }
              /*Inserire codice per prendere ID_USER e salvare l'id in una variabile*/
              //$doOrder = "INSERT INTO ordine(Orario_richiesto, Stato, ID_USER, ID_RESTURANT, ORDINE_INVIATO) VALUES ('12:00', 0, '$user_id', '$id_r', 0) ";
              //$okOrd = mysqli_query($conn, $doOrder);
              $takeID_O = "SELECT ID_ORDINE FROM ordine WHERE ID_USER='$user_id' AND ORDINE_INVIATO=0";
              $doID_O = mysqli_query($conn, $takeID_O);
              while($idO = $doID_O->fetch_array()) {
                $ID_O = $idO;
              }
              foreach ($ID_O as $key => $value) {
                $id_o = $value;
                echo "ID_ORDINE -> ".$id_o;
              }
              $push = "INSERT INTO pietanza_nel_ordine(ID_PIETANZA, ID_ORDINE, Quantita) VALUES ('$id_piet', '$id_o', 1)";
              $okPush = mysqli_query($conn, $push);
              if(!$okPush) {
                echo "Error ".$conn->error;
              }
              //  echo "Non è presente, inserire";
            } else if (!checkSameRest($nome)){
              echo '<script type="text/javascript">
              alert("' . "Impossibile effettuare un ordine con piatti di diversi ristoranti!! " . '");
              </script>';
            }
          }
          $countR++;
        }
      }
    } else {
      echo "Query select non eseguita";
    }

}


function checkID() {
  $client = $_SESSION['id'];

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "just_database";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $queryOrder = "SELECT * FROM ordine";
  $exQorder = mysqli_query($conn, $queryOrder);
  while($record = mysqli_fetch_array($exQorder)) {
    if($record['ID_USER'] === $client) {
      return true;
    }
  }
  return false;
}


function checkSameRest($nome) {
  $client = $_SESSION['id'];

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "just_database";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $ord = "SELECT * FROM ordine";
  $exOrd = mysqli_query($conn, $ord);

  while($i = mysqli_fetch_array($exOrd)) {
    if($i['ID_USER'] === $client) {           //E' già presente un ordine del cliente loggato
      $takeMenuID = "SELECT ID_MENU FROM pietanza WHERE Nome='$nome'";
      $exTakeMID = mysqli_query($conn, $takeMenuID);
      while($menuID = $exTakeMID->fetch_array()) {
        $id_menu = $menuID;
      }
      foreach ($id_menu as $key => $value) {
        $ID_MENU = $value;
      }
      $takeRistID = "SELECT ID_FORNITORE FROM menu WHERE ID_MENU='$ID_MENU'";
      $exTakeRID = mysqli_query($conn, $takeRistID);
      while($id = $exTakeRID->fetch_array()) {
        $id_rist = $id;
      }
      foreach ($id_rist as $key => $value) {
        $ID_RIST = $value;
      }
      if($ID_RIST === $i['ID_RESTURANT']) {
        return true;
      } else {
        return false;
      }
    }
  }
}

function checkAdd($id_pietanza, $nome) {
  if(checkSameRest($nome)) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "just_database";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $checkP = "SELECT * FROM pietanza_nel_ordine";
    $exCheckP = mysqli_query($conn, $checkP);
    while($record = mysqli_fetch_array($exCheckP)) {
      if($record['ID_PIETANZA'] === $id_pietanza) {
        return false;
      }
    }
    return true;
  } else {
    return true;
  }
}
?>
