<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
    <?php
     if($DEBUG) ini_set(display_errors, "1"); 
    //##########################################################################            
    //NOTE GESTIONE UTENTI
    //1) Si verifica se l'utente ha il permesso di visualizzare la lista (124)--Per ora commentato
    //2) Si verifica se l'utente ha il permesso di modificare la tabella lab_macchina (125)
    //3) Si verifica se l'utente ha il permesso di inserire dati nella tabella lab_macchina (126)
    //NOTA BENE: nei due link "Elimina rosetta" e "Sblocca rosetta" non viene fatto un controllo all'interno delle rispettive pagine 
    //"elimina_lab_dato.php" e "lab_sblocca_macchina" per vedere se si ha il permesso di modificare quella specifica rosetta
    //il controllo viene fatto solo sulle funzionalità in questa pagina di gestione    
    //############# VERIFICA PERMESSI ##########################################
    $actionOnLoad="";
    $elencoFunzioni = array("125","126");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni,$_SESSION['objPermessiVis']);
    //############# STRINGHE UTENTI - AZIENDE VISIBILI###########################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_macchina');   
        
    //##########################################################################
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
<div id="labContainer" >
<?php 

include('../include/menu.php'); 
include('../Connessioni/serverdb.php');
include('sql/script_lab_macchina.php');

$sql = findAllRosetteVis("nome",$strUtentiAziende);

include('./moduli/visualizza_lab_macchine.php');?>
<div id="msgLog">
                <?php
                if ($DEBUG) {

                    echo "</br>actionOnLoad :" . $actionOnLoad;
                    echo "</br>Tab lab_macchina : Utenti e aziende visibili " . $strUtentiAziende;
                }
                ?>
            </div>
</div>
</body>
</html>
