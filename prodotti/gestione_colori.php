<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>

    <?php
    
    if ($DEBUG)  ini_set('display_errors', 1);
    
    //########################### GESTIONE UTENTI ##############################            
    //1) Si verifica se l'utente ha il permesso di visualizzare la lista deli colori
    //2) Si verifica se l'utente ha il persmesso di editare il colore
    $actionOnLoad = "";
    $elencoFunzioni = array("11", "12");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);

    //############# STRINGA UTENTI - AZIENDE VIS ###############################
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'colore');

    
    
    
    //##########################################################################
    
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">

<div id="mainContainer">
<?php 
include('../include/menu.php'); 
include('../Connessioni/serverdb.php');
include('../sql/script_colore.php');

$sql = findAllColoreVis($strUtentiAziende,"nome_colore");


include('./moduli/visualizza_colori.php');?>
    
<div id="msgLog">
                <?php
                if ($DEBUG) {

                    echo "</br>actionOnLoad :" . $actionOnLoad;
                    echo "</br>Tab colore : Utenti e aziende visibili " . $strUtentiAziende;
                }
                ?>
            </div>
</div>
</body>
</html>
