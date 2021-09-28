<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?> 
    </head>

    <?php
    //Se la variabile debug =1 viene visualizzato il log
    if ($DEBUG)
        ini_set("display_errors", 1);
    $actionOnLoad = "";
    $elencoFunzioni = array("1", "2", "3", "4", "100", "101");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);
    //############# STRINGHE UTENTI - AZIENDE VISIBILI###########################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'prodotto');

    //##########################################################################
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php 
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php'); 
            include("../tracciabilita_colli_lotti/include/funzioni.php");
  
            begin();
                 $sql = findAllColli(); 
            commit();
            $trovati = mysql_num_rows($sql);
 
            include('moduli/visualizza_colli.php');
            ?> 
            <div id="msgLog">
            <?php
            if ($DEBUG) {
                echo "actionOnLoad :" . $actionOnLoad;
                echo "</br>Tab prodotto : Nuova stringa unica utenti e aziende visibili : " . $strUtentiAziende;
            }
            ?>
            </div>
        </div>
		 
    </body>
</html>

