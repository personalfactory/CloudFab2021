<?php

session_start();

//Incremento la variabile aggiornamento per aggiornare 
//la sessione e mantenerla in vita pi� a lungo.
$_SESSION['aggiornamento']++;


if (!isset($_SESSION['username'])) {

  header('Location: /CloudFab/login.php');
  
} else if (isset($_SESSION['username'])) {
  
  include('../Connessioni/serverdb.php');
  include('../sql/script_utente.php');
  
  $sqlIdSess = findSessioneById(session_id());
  //NOTA:
  //Se due utenti si loggano dallo stesso browser la seconda sessione non viene 
  //ricreata con un nuovo id ma viene ripristinata quella esistente quindi 
  //possono utilizzare entrambi la stessa sessione per navigare
  if (mysql_num_rows($sqlIdSess) == 0) {

    session_unset();
    session_destroy();
    ?>
    
    <script>
        alert("Sei stato disconnesso perchè qualcun altro si è autenticato con le tue credenziali!");
        location.href="/CloudFab/login.php"
    </script>
    
    <?php
     echo 'Puoi provare ad effettuare il login più tardi ' . '<a href="/CloudFab/login.php">Login</a>';
  } else {
    
//    echo "HTTP_USER_AGENT : ".$_SERVER['HTTP_USER_AGENT'];
//    echo "</br>ID della sessione corrente : " . session_id();
    
    aggiornaDataSessioneDb($_SESSION['id_utente']);
  }
}
?>
