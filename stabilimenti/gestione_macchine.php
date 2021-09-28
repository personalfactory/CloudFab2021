<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
   
    <?php
    //Se la variabile debug=1 viene visualizzato il log
    
    if ($DEBUG)
        ini_set('display_errors', 1);
    //##########################################################################            
    //####################### GESTIONE UTENTI ##################################
    //##########################################################################
    //1) Si verifica se l'utente ha il permesso di visualizzare la lista delle macchine
    //2) Si verifica se l'utente ha il permesso di visualizzare il dettaglio di una macchina
    //3) Si verifica se l'utente ha il permesso di visualizzare i processi
    //4) Si verifica se l'utente ha il permesso di visualizzare i valori parametri comp 
    //5) Si verifica se l'utente ha il permesso di visualizzare i valori parametri sm
    //6) Si verifica se l'utente ha il permesso di visualizzare i valori par ripristino
    //7) Si verifica se l'utente ha il permesso di editare la macchina
    //8) Si verifica se l'utente ha il permesso di connettersi al server FTP
    //L'elenco delle funzioni relative ad una voce-sottovoce in generale relativo ad una pagina
    //può essere recuperato dalla tabella voce_funzione di dbutente
    $elencoFunzioni = array("34", "35", "36", "37", "38", "39", "40","140");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);

    //############# STRINGA UTENTI-AZIENDE VISIBILI ############################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'macchina');

    //##########################################################################
   
    ?>    
    <body onLoad="<?php echo $actionOnLoad ?>">
   
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_macchina.php');
            include('../sql/script_anagrafe_macchina.php');

            //##### VALORI DI DEFAULT PER Gruppo, Rif geografico e Filtro ordinamento #######

            if (isset($_POST['Gruppo']) AND $_POST['Gruppo'] != "") {
                $_SESSION['Gruppo'] = trim($_POST['Gruppo']);
            } else {
                //VALORE DI DEFAULT
                $_SESSION['Gruppo'] = "Universale";
            }
            if (isset($_POST['Geografico']) AND $_POST['Geografico'] != "") {
                $_SESSION['Geografico'] = trim($_POST['Geografico']);
            } else {
                //VALORE DI DEFAULT
                $_SESSION['Geografico'] = "Mondo";
            }
            
            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #######################
            $_SESSION['Filtro'] = "descri_stab";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }
            //########################################################################

            $_SESSION['IdMacchina'] = "";
            $_SESSION['CodStab'] = "";
            $_SESSION['DescriStab'] = "";
            $_SESSION['VersCloudFab'] = "";//campo user_origami
            $_SESSION['TipoOrigami'] = "";// campo user_server
            $_SESSION['Abilitato']="";

            if (isset($_POST['IdMacchina']) AND $_POST['IdMacchina'] != "") {
                $_SESSION['IdMacchina'] = trim($_POST['IdMacchina']);
            }
            if (isset($_POST['CodStab']) AND $_POST['CodStab'] != "") {
                $_SESSION['CodStab'] = trim($_POST['CodStab']);
            }
            if (isset($_POST['DescriStab']) AND $_POST['DescriStab'] != "") {
                $_SESSION['DescriStab'] = trim($_POST['DescriStab']);
            }
            if (isset($_POST['VersCloudFab']) AND $_POST['VersCloudFab'] != "") {
                $_SESSION['VersCloudFab'] = trim($_POST['VersCloudFab']);
            }
            if (isset($_POST['TipoOrigami']) AND $_POST['TipoOrigami'] != "") {
                $_SESSION['TipoOrigami'] = trim($_POST['TipoOrigami']);
            }
            if (isset($_POST['Abilitato']) AND $_POST['Abilitato'] != "") {
                $_SESSION['Abilitato'] = trim($_POST['Abilitato']);
            }
            
            begin();
            $sql = selectMacchinaSp(
                    $_SESSION['IdMacchina'], $_SESSION['CodStab'], $_SESSION['DescriStab'],$_SESSION['VersCloudFab'],$_SESSION['TipoOrigami'],$_SESSION['Abilitato'], $_SESSION['Gruppo'], $_SESSION['Geografico'], $_SESSION['Filtro'], $strUtentiAziende);
            $trovati = mysql_num_rows($sql);
            $sqlGruppo = selectGruppiFromAnMac($strUtentiAziende);
            $sqlGeo = selectGeoFromAnMac($strUtentiAziende);
            commit();
            
            include('./moduli/visualizza_macchine.php');
            
            ?> 
            <div id="msgLog">
                <?php
                
                if ($DEBUG) {

                    echo "</br>actionOnLoad : " . $actionOnLoad;
                    echo "</br>Tab macchina : Utenti e aziende visibili " . $strUtentiAziende;
                }
                ?>
            </div>
        </div>

    </body>
</html>
