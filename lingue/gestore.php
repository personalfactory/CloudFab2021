<?php

//############## GESTIONE DELLA LINGUA DI INEPHOS ####################
//Se variabile di sessione "lingua" è settata allora viene incluso
//il file contenente le stringhe ed i messaggi tradotti nella lingua indicata.
if(isSet($_SESSION['lingua'])){
 switch ($_SESSION['lingua'])
      {
         case 1:
            include ('/var/www/CloudFab/lingue/it.php');
            break;
         case 2:
            include ('/var/www/CloudFab/lingue/en.php');;
            break;
         case 3:
            include ('/var/www/CloudFab/lingue/fr.php');
            break;
      }      
}
//NOTA: 
//Nelle pagine login.php e login2.php la sessione non è ancora stata creata quindi
//l'istruzione relativa all'inclusione del file viene fatta a parte.

?>