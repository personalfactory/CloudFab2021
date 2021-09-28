<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <?php
    if ($DEBUG)
        ini_set('display_errors', 1);

    //########################### GESTIONE UTENTI ##############################            
    //1) Si verifica se l'utente ha il permesso di visualizzare la lista 
    //2) Si verifica se l'utente ha il persmesso di editare 
    $actionOnLoad = "";
    $elencoFunzioni = array("62", "104");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);

    //############# STRINGA UTENTI - AZIENDE VIS ###############################
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'gruppo');

    //##########################################################################
    $_SESSION['Livello1'] = "";
    $_SESSION['Livello2'] = "";
    $_SESSION['Livello3'] = "";
    $_SESSION['Livello4'] = "";
    $_SESSION['Livello5'] = "";
    $_SESSION['Livello6'] = "";
    $_SESSION['Abilitato'] = "";
    $_SESSION['DtAbilitato'] = "";


    if (isset($_POST['Livello1'])) {
        $_SESSION['Livello1'] = trim($_POST['Livello1']);
    }
    if (isset($_POST['Livello2'])) {
        $_SESSION['Livello2'] = trim($_POST['Livello2']);
    }
    if (isset($_POST['Livello3'])) {
        $_SESSION['Livello3'] = trim($_POST['Livello3']);
    }
    if (isset($_POST['Livello4'])) {
        $_SESSION['Livello4'] = trim($_POST['Livello4']);
    }
    if (isset($_POST['Livello5'])) {
        $_SESSION['Livello5'] = trim($_POST['Livello5']);
    }
    if (isset($_POST['Livello6'])) {
        $_SESSION['Livello6'] = trim($_POST['Livello6']);
    }
    if (isset($_POST['Abilitato'])) {
        $_SESSION['Abilitato'] = trim($_POST['Abilitato']);
    }
    if (isset($_POST['DtAbilitato'])) {
        $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
    }



    //########### VARIABILE DI ORDINAMENTO DELLA QUERY #######################
    $_SESSION['Filtro'] = "livello_1";
    if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
        $_SESSION['Filtro'] = trim($_POST['Filtro']);
    }
    ?>

    <body onLoad="<?php echo $actionOnLoad ?>">

        <div id="mainContainer">

            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_gruppo.php');

            $sql = findGruppiByFiltri($_SESSION['Livello1'], $_SESSION['Livello2'], $_SESSION['Livello3'], $_SESSION['Livello4'], $_SESSION['Livello5'], $_SESSION['Livello6'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Filtro'], $strUtentiAziende);


            include('./moduli/visualizza_gruppi.php');
            ?> 
            <div id="msgLog">
                <?php
                if ($DEBUG) {

                    echo "</br>actionOnLoad :" . $actionOnLoad;
                    echo "</br>Tab gruppo : Utenti e aziende visibili " . $strUtentiAziende;
                }
                ?>
            </div>
        </div>
    </body>
</html>
