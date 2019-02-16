<?php
session_start();
$nMess = 0;
function controllo_cookie(){

	if(isset($_COOKIE['session'])  & isset($_SESSION['nome'])){

        if(isset($_SESSION["email"])) {
            $tmp=$_SESSION["email"];
        } else {
            return false;
        }
        //prendo l'email presente nel cookie
		

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "just_database";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $q="SELECT * from utente where Email='".$tmp."'";
		//confronto username e password del cookie con il database
        $query=mysqli_query($conn, $q);

		if($query){
            $row=mysqli_fetch_array($query);
			//immagazzinano le informazioni dell'utente in un array
			$_SESSION["id"]=$row["ID_USER"];
			return true;
		} else {
            return false;
        }
			

	}else {
        return false;
    }
		

}

if(!controllo_cookie()){
    $auth = false;
    header("location: accedi.php");
} else {
    $auth = true;
}
?>


<!DOCTYPE html>
<html lang="it-IT">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="Cibo, food, Just Eat, Just Uni Eat, just uni eat, asporto, università, fame, veloce, eat"/>
    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="icon" href="http://example.com/favicon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href='https://fonts.googleapis.com/css?family=Faster One' rel='stylesheet'>
    <link href="Toasty.js-master/dist/toasty.min.css" rel="stylesheet">
    <title>Just Uni Eat | Privacy</title>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="index.php">Just Uni Eat</a>
        <a href="checkout.php">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "just_database";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if(isset($_SESSION['id'])) {
                $idUs = $_SESSION['id'];
                $checkCart = "SELECT ID_ORDINE FROM ordine WHERE ID_USER='$idUs' AND ORDINE_INVIATO=0";
                $execControl = mysqli_query($conn, $checkCart);
                $n_rows = mysqli_num_rows($execControl);
    
                if($n_rows === 0) {
                ?>
                <i class="material-icons md-36 carts">remove_shopping_cart</i>
                <?php
                } else if($n_rows > 0) {
                ?>
                <i class="material-icons md-36 carts">shopping_cart</i>
                <?php
                }
                
            }
            ?>
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="navbar-nav float-left text-left pr-3">
                <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                        <a class="nav-link" id="navUser" href="profile.php"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="navAcc" href="accedi.php">Accedi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="navReg" href="registrati.html">Registrati</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="navMes" href="message.php">
                            <i class="fa fa-envelope-o">
                                <span id="countMess" class="badge badge-danger">
                                    
                                <?php 
                                      if($auth) {
                                        $q= "SELECT COUNT(*) FROM utente AS U, messaggio AS M WHERE 
                                        U.ID_USER='".$_SESSION["id"]."' AND U.ID_USER = M.ID_USER AND M.Letto='0' AND M.Ricevuto_Dal_Utente='1'";
                                        $query=mysqli_query($conn, $q);
                                        $result = mysqli_fetch_array($query);
                                        echo $result['COUNT(*)']; 
                                    } else echo "0";?>
                                </span>
                            </i>
                            Messaggi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="navOrd" href="mieiOrdini.php">Miei Ordini</a>
                        <!--da rendere hidden se non si ha fatto ancora l'accesso-->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="navExit" href="logout.php">Esci</a>
                        <!--da rendere hidden se non si ha fatto ancora l'accesso-->
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="jumbotron">
        <h3>INFORMATIVA PRIVACY AI SENSI DEL REGOLAMENTO EUROPEO 2016/679 E DELLA NORMATIVA PRIVACY VIGENTE</h3>


        <p>Ai sensi e per gli effetti di quanto disposto dall’art. 13 del Regolamento Europeo 2016/679 in materia di protezione dei dati personali (“GDPR”) 
        e della Normativa Privacy nazionale (di seguito “Normativa Privacy vigente”), ti informiamo che i tuoi dati personali verranno trattati attraverso strumenti 
        elettronici e manuali, in Italia e all’estero, anche attraverso l’utilizzo dei Social Network. La presente informativa, 
        redatta sulla base del principio della trasparenza e di tutti gli elementi richiesti dal GDPR è articolata in singole sezioni ognuna 
        delle quali tratta uno specifico argomento in modo da renderti la lettura più rapida, agevole e di facile comprensione (nel seguito l’“Informativa”).</p>

 

        <h4>Chi è il Titolare del Trattamento?</h4>

        <p>Il Titolare del trattamento è Just Uni Eat, Cesena Via del Circondario 182 FC.</p>


        <h4>Data Protection Officer</h4>

        <p>Il Gruppo Just Uni Eat ha designato il Data Protection Officer (di seguito “DPO”) con sede in Viale Europa 48 - 48123 Ravenna RA.</p>

        <p>Ai sensi dell’art. 38, par. 4, hai la possibilità di contattare il DPO, per tutte le questioni relative al 
        trattamento dei tuoi dati personali e all’esercizio dei tuoi diritti previsti dal GDPR, ai seguenti dati di contatto: justunieat@gmail.com</p>

 

        <h4>Qual è la base giuridica del trattamento?</h4>
        
        <p>I fondamenti giuridici del trattamento dei tuoi dati personali sono:</p>

        <ul>
            <li>il Consenso da te rilasciato per il trattamento dei tuoi dati nell’accedere e/o usufruire dei servizi Just Uni Eat</li>
            <li>per l’adempimento degli obblighi contrattuali</li>
            <li>per l’adempimento degli obblighi normativi inclusi quelli contabili, amministrativi e fiscali</li>
        </ul>

        <h4>Per quali finalità saranno trattati i tuoi dati?</h4>

        <p>I tuoi dati personali verranno trattati per le seguenti finalità:</p>

        <ol>
            <li>registrazione ai servizi Just Uni Eat;</li>

            <li>suggerimenti e assistenza tecnica al Servizio. In alcuni casi per ricevere suggerimenti o segnalazioni dagli utenti 
            su dei malfunzionamenti dei nostri prodotti acquisiremo informazioni relativi al Mac Address o ID del device, indirizzo IP, sistema operativo, 
            tipologia del device e email;</li>

            <li>partecipazione a eventuali concorsi, contatto con i vincitori e gestione degli adempimenti relativi es. notifica e invio premio;</li>

            <li>invio di mail, richiesta informazioni tramite form;</li>

        
            <li>gestione di eventuali reclami e contestazioni;</li>
        </ol>

        
        <p>Inoltre, i Tuoi dati personali con il tuo consenso facoltativo verranno trattati per le finalità di:</p>

        <ol>

            <li>raccolta e analisi di comportamenti ed abitudini nella fruizione dei contenuti web, televisivi e dei nostri servizi, anche
                 attraverso cookie o altri identificativi elettronici, motori di raccomandazione, statistiche, 
                 preferenze rilasciate dal cliente allo scopo di effettuare ricerche di mercato, migliorare i servizi forniti 
                 e di personalizzarli, nonché di ridurre il numero di ripetizioni dei messaggi pubblicitari e agevolare 
                 l’inoltro di informazioni e offerte commerciali di cui al numero </li>
                 
                 
                 
            <li>comunicazione e/o invio (a mezzo e-mail, sms, notifiche, posta, contatto telefonico, ecc.), 
                anche con modalità automatizzate, di informazioni e offerte commerciali, di materiale pubblicitario 
                e promozionale su servizi propri e/o anche di soggetti terzi, nonché realizzazione di ricerche di mercato</li>

            <li>comunicazione dei dati a società terze esterne ed interne al Gruppo Just Uni Eat, di cui alle categorie merceologiche specificate di seguito.</li>

        </ol>    

        <p>Il conferimento dei Tuoi dati è necessario per il conseguimento delle finalità di cui al punto 1).</p>

        <p>Il tuo mancato, parziale o inesatto conferimento potrebbe avere come conseguenza l’impossibilità di attivare e fornire il servizio richiesto.</p>

        <p>Inoltre, il conferimento dei tuoi dati per le finalità specifiche di cui al punto 2) è facoltativo, ma l’eventuale rifiuto comporta 
        l’impossibilità per Just Uni Eat di dare corso alla tua richiesta e contattarti. In ogni caso e come nel seguito meglio precisato,
         potrai revocare il tuo consenso, anche in modo parziale, ad esempio acconsentendo alle sole modalità di contatto tradizionali.</p>

        <h4>A quali soggetti potranno essere comunicati i tuoi Dati Personali?</h4>

        <p>I tuoi dati personali saranno trattati esclusivamente da persone autorizzate al trattamento e da persone designate quali 
        Responsabili del trattamento nel rispetto del GDPR al fine di svolgere correttamente tutte le attività di Trattamento necessarie a 
        perseguire le finalità di cui alla presente Informativa. I tuoi Dati Personali potranno essere comunicati ad enti pubblici o 
        all’autorità giudiziaria, ove richiesto per legge o per prevenire o reprimere la commissione di un reato.</p>

        <h4>Ulteriori comunicazioni</h4>

        <p>Con il tuo consenso libero e facoltativo, i tuoi dati personali (nome, cognome, indirizzo, e-mail, telefono, provincia, 
            sesso, username, IP e ID Device) saranno comunicati da Just Uni Eat alle seguenti categorie di soggetti e/o aziende terze:</p>

        <ul>
            <li>chiunque sia legittimo destinatario di comunicazioni previste da norme di legge o regolamenti (quali, ad esempio, uffici ed Autorità Pubbliche);</li>

            <li>chiunque sia destinatario di comunicazioni necessarie in esecuzione degli obblighi derivanti dal Servizio;</li>

            <li>ocietà terze specializzate nella gestione di informazioni commerciali e relative al credito 
                (quali, ad esempio, centri di elaborazione dati, banche, ecc.).</li>

            <p>Inoltre, potranno essere comunicati per le medesime finalità anche a:</p>

            <li>società e/o collaboratori per la gestione di servizi amministrativi di cui ci si avvalga per adempiere ai propri obblighi legali o contrattuali;</li>

            <li>altri soggetti (imprese, società, persone fisiche) che collaborano alla realizzazione del Servizio.</li>

        </ul>
        
        <h4>Questi soggetti operano in qualità di Responsabili opportunamente nominati e istruiti.</h4>

 

        <h4>Minori</h4>

        <p>I Dati Personali dei minori con un età inferiore a 16 anni non verranno trattati dal Titolare del trattamento, 
            se non previa autorizzazione del titolare della responsabilità genitoriale.</p>

        <h4>Interesse legittimo del Titolare</h4>

        <p>Il Titolare ha l’interesse legittimo a trasferire i dati personali alle Società interne al Gruppo Just Uni Eat per fini amministrativi interni.</p>

 

        <h4>Per quanto tempo saranno trattati i tuoi Dati Personali?</h4>

        <p>I tuoi dati personali verranno conservati per il periodo necessario al perseguimento delle finalità relative al punto 1) di cui sopra. In particolare, 
        i tuoi Dati Personali saranno trattati per un periodo di tempo pari al minimo necessario al raggiungimento delle finalità, 
        fatto salvo un ulteriore periodo di conservazione che potrà essere imposto da norme di legge.

        Inoltre, qualora decidessi di rilasciare il tuo consenso facoltativo di cui al punto 2) relativo alle finalità di marketing, 
        di profilazione e/o comunicazione a soggetti terzi, i tuoi Dati personali verranno conservati, salvo revoca del consenso,
         per un arco di tempo non superiore a quello necessario al conseguimento delle finalità.</p>

        <p>I tuoi Dati verranno conservati per un periodo ulteriore in relazione alle finalità di contestazioni ed eventuali obblighi di legge.</p>

 

        <h4>Come puoi revocare il consenso prestato?</h4>

        <p>Hai il diritto di revocare il tuo consenso rilasciato al Titolare in ogni momento totalmente e/o parzialmente 
            senza pregiudicare la liceità del Trattamento basata sul consenso prestato prima della revoca.</p>

        <p>Per revocare il tuo consenso basta contattare il Titolare agli indirizzi pubblicati nella presente informativa.</p>


        <h4>Dove saranno trattati i tuoi dati?</h4>

        <p>I tuoi Dati Personali saranno trattati dal Titolare all’interno del territorio dell’Unione Europea.</p>

        <p>Qualora per questioni di natura tecnica e/o operativa si renda necessario avvalersi di soggetti ubicati al di fuori dell’Unione Europea, 
        ti informiamo sin d’ora che tali soggetti saranno nominati Responsabili del Trattamento ai sensi e per gli effetti di cui all’articolo 
        28 del GDPR ed il trasferimento dei tuoi Dati Personali a tali soggetti, limitatamente allo svolgimento di specifiche attività di Trattamento, 
        sarà regolato in conformità a quanto previsto dal GDPR.</p>

        <p>Saranno adottate tutte le cautele necessarie al fine di garantire la totale protezione dei tuoi Dati personali basando tale 
            trasferimento sulla valutazione di opportune garanzie tra le quali a titolo esemplificativo, decisioni di adeguatezza dei paesi terzi 
            destinatari espresse dalla Commissione Europea; garanzie adeguate espresse dal soggetto terzo destinatario ai sensi dell’articolo 46 del GDPR.</p>

        <p>In ogni caso potrai richiedere maggiori dettagli al Titolare del Trattamento qualora i tuoi Dati Personali 
            siano stati trattati al di fuori dell’Unione Europea richiedendo evidenza delle specifiche garanzie adottate.</p>


        <h4>Quali sono i Tuoi diritti ?</h4>

        <p>Ti ricordiamo che potrai esercitare i tuoi diritti previsti dal GDPR e in particolare di ottenere:</p>

        <ul>
            <li>la conferma che sia o meno in corso un Trattamento di Dati personali che ti riguardano e di ottenere l’accesso ai dati e 
            alle seguenti informazioni (finalità del Trattamento, categorie di Dati personali, destinatari e/o categorie di destinatari a cui i
             dati sono stati e/o saranno comunicati, periodo di conservazione);</li>
            <li>  la rettifica dei Dati personali inesatti che ti riguardano e/o l’integrazione 
                dei Dati personali incompleti, anche fornendo una dichiarazione integrativa;</li>
            <li>la cancellazione dei Dati personali, nei casi previsti dal GDPR;</li>
            <li>la limitazione al Trattamento nelle ipotesi previste dalla Normativa Privacy vigente;</li>
            <li>la portabilità dei dati che ti riguardano, ed in particolare di richiedere i dati personali che
                 ti riguardano forniti al Titolare e/o richiedere la trasmissione diretta dei tuoi dati a un altro titolare del trattamento;</li>
            <li>l’opposizione al trattamento in qualsiasi momento, per motivi connessi alla tua situazione particolare, al trattamento dei dati personali che
                 ti riguardano nel pieno rispetto della Normativa Privacy Vigente, nonché per le finalità relative a marketing e profilazione.</li>
 

      <p>Potrai esercitare i Tuoi diritti rivolgendoti alla seguente casella di posta elettronica justunieat@gmail.com  allegando copia del documento d’identità.</p>

 

In ogni caso avrai sempre diritto di proporre reclamo all’autorità di controllo competente (Garante per la Protezione dei Dati personali), ai sensi dell’art. 77 GDPR, qualora ritieni che il trattamento dei tuoi dati sia contrario alla Normativa Privacy vigente.
    </div>

    <div class="content">
    </div>
    <footer id="myFooter">
        <div class="container text-center">
            <div class="row">
                <div class="col-sm-4">
                    <h5>Inizia</h5>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="accedi.php">Accedi</a></li>
                        <li><a href="registrati.php">Registrati</a></li>
                    </ul>
                </div>
                <div class="col-sm-4">
                    <h5>Chi siamo</h5>
                    <ul>
                        <li><a href="storia.html">La Nostra Storia</a></li>
                        <li><a href="contattaci.html">Contattaci</a></li>
                        <li><a href="dicono_di_noi.html">Dicono di noi</a></li>
                    </ul>
                </div>
                <div class="col-sm-4">
                    <h5>Info</h5>
                    <ul>
                        <li><a href="privacy.php">Privacy & Cookie</a></li>
                        <li><a href="registrati.php">Diventa affiliato</a></li>
                        <li><a href="diventa_fattorino.php">Diventa fattorino</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="social-networks">
            <a target="_blank" href="https://twitter.com/JustUniEat1" class="twitter"><i class="fa fa-twitter"></i></a>
            <a target="_blank" href="https://www.facebook.com/justuni.eat.5" class="facebook"><i class="fa fa-facebook"></i></a>
            <a target="_blank" href="https://plus.google.com/u/0/114848465565497583176" class="google"><i class="fa fa-google-plus"></i></a>
        </div>
        <div class="footer-copyright">
            <p>© 2018 Copyright Just Uni Eat</p>
        </div>
    </footer>
    </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
    <script src="Toasty.js-master/dist/toasty.min.js"></script>

        <?php

    if($auth) {
    ?>

        <script>
        
        $(document).ready(function() {
            var myvar = decodeURIComponent("<?php echo rawurlencode($_SESSION['nome']); ?>");
            var hello = "Ciao, ";
            document.getElementById('navUser').innerHTML = hello.concat(myvar);
            document.getElementById('navUser').style.display = "block";
            document.getElementById('navAcc').style.display = "none";
            document.getElementById('navReg').style.display = "none";
            document.getElementById('navMes').style.display = "block";
            document.getElementById('navOrd').style.display = "block";
            document.getElementById('navExit').style.display = "block";
        });
        
        var ajax_call = function() {
        
        var id_user = <?php echo $_SESSION['id'];?>

        $.ajax({

        url : 'checkMessageNew.php',
        method : 'post',
        data : {id_user : id_user},

            success : function(response) {

                if(response == "1") {
                    var toast = new Toasty();
                    //toast.progressBar("true");
                    toast.success("Hai un nuovo messaggio!");
                    $('#countMess').text("1");
                }    
            
            }

        });

    };

    var interval = 30000; //30 secondi

    setInterval(ajax_call, interval);
        </script>
    <?php
    } else {
    ?>

    <script>


    </script>

    <?php


    }
    ?>



</body>

</html>