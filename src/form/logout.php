<?php

include 'function.php';
sec_session_start();
// Elimina tutti i valori della sessione.
$_SESSION = array();
// Recupera i parametri di sessione.
$params = session_get_cookie_params();
// Cancella i cookie attuali.
setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
// Cancella la sessione.
session_destroy();
header('Location: ./');


/*

Pagina di Registrazione.
Per criptare la password avremo la necessità di usare il seguente codice:

Script per l'hashing della password: 
// Recupero la password criptata dal form di inserimento.
$password = $_POST['p']; 
// Crea una chiave casuale
$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
// Crea una password usando la chiave appena creata.
$password = hash('sha512', $password.$random_salt);
// Inserisci a questo punto il codice SQL per eseguire la INSERT nel tuo database
// Assicurati di usare statement SQL 'prepared'.
if ($insert_stmt = $mysqli->prepare("INSERT INTO members (Name, Cognome, Email, Password, salt, ID_USER, Cellulare) VALUES (?, ?, ?, ?, ?, ?, ?)")) {    
   $insert_stmt->bind_param('ssss', $username, $email, $password, $random_salt); 
   // Esegui la query ottenuta.
   $insert_stmt->execute();
}

Assicurati che il valore del parametro '$_POST['p']' sia già stato criptato utilizzando un javascript. Se non userai questo metodo, perché vuoi validare la password direttamente sul server, assicurati che sia criptata.


 */


?>


