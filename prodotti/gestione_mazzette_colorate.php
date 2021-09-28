<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript">

//        function disabilitaVistaDettaglio() {
//            //PERMESSO DI VISUALIZZAZIONE DETTAGLIO NEGATO
//            //Disabilita il link alla pagina di modifica
//            for (i = 0; i < document.getElementsByName('14').length; i++) {
//                document.getElementsByName('ModificaNomeMaz')[i].removeAttribute('href');
//            }
//            for (i = 0; i < document.getElementsByName('14').length; i++) {
//                document.getElementsByName('ModificaMazzetta')[i].removeAttribute('href');
//            }
//
//        }
//
//        function disabilitaScrittura() {
//            //CASO: PERMESSO DI SCRITTURA NEGATO
//            //Disabilito la creazione di un nuova mazzetta         
//            document.getElementById('NuovaMaz').removeAttribute('href');
//            document.getElementById('NuovaMazColorata').removeAttribute('href');
//
//        }
    </script>
    <?php
    
    if ($DEBUG)  ini_set('display_errors', 1);
    
    //########################### GESTIONE UTENTI ##############################            
    //1) Si verifica se l'utente ha il permesso di visualizzare la lista delle famiglie
    //2) Si verifica se l'utente ha il persmesso di editare la famiglia
    $actionOnLoad = "";
    $elencoFunzioni = array("13", "14","15");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);

    //############# STRINGA UTENTI - AZIENDE VIS ###############################
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'mazzetta');
    
    //##########################################################################
    ?>    
    <body onLoad="<?php echo $actionOnLoad ?>">
         <div id="mainContainer">

            <?php
            
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_mazzetta.php');

            $sql = findAllMazzetteColorataVis($strUtentiAziende);
            
            include('./moduli/visualizza_mazzette_colorate.php');
            ?> 
<div id="msgLog">
                <?php
                if ($DEBUG) {

                    echo "</br>actionOnLoad :" . $actionOnLoad;
                    echo "</br>Tab mazzetta : Utenti e aziende visibili " . $strUtentiAziende;
                }
                ?>
            </div>
        </div>
    </body>
</html>
