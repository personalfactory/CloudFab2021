<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
   
    <?php
     
    if ($DEBUG)  ini_set('display_errors', 1);
    //##########################################################################            
    //NOTE GESTIONE UTENTI
    //1) Si verifica se l'utente ha il permesso di visualizzare la lista dei colori base
    //2) Si verifica se l'utente ha il permesso di creare nuovi colori base    
    $actionOnLoad = "";
    $elencoFunzioni = array("9","10");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);

    //############# STRINGA UTENTI - AZIENDE VIS ###############################
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'colore_base');    
        
    //##########################################################################
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">

            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_colore_base.php');

            $sql = findAllColoreBaseVis($strUtentiAziende, "nome_colore_base");

            include('./moduli/visualizza_colori_base.php');
            ?>
            <div id="msgLog">
                <?php
                if ($DEBUG) {
                    echo "</br>actionOnLoad :" . $actionOnLoad;
                    echo "</br>Tab colore_base : Utenti e aziende visibili " . $strUtentiAziende;
                }
                ?>
            </div>
        </div>
    </body>
</html>
