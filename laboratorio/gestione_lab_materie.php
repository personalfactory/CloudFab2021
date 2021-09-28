<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    
    <?php
    if ($DEBUG) ini_set(display_errors, "1");

    //##########################################################################            
    //NOTE GESTIONE UTENTI
    //1) Si verifica se l'utente ha il permesso di visualizzare la lista delle materie prime 28
    //2) Si verifica se l'utente ha il permesso di visualizzare il dettaglio delle materie prime 29
    //3) Si verifica se l'utente ha il permesso di scrittura 2 sulla tabella lab_materie_prime 32
    //############# VERIFICA PERMESSI ##########################################
    $actionOnLoad = "";
    $elencoFunzioni = array("28", "29", "32");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);


    //############# STRINGA UTENTI - AZIENDE VIS ###############################
    $strUtentiAziendeLabMat = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_materie_prime');
    //##########################################################################
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('sql/script.php');
            include('sql/script_lab_materie_prime.php');

            $Pagina = "gestione_lab_materie";

            
            $_SESSION['stringaUtentiAziende']=$strUtentiAziendeLabMat;
            
            $_SESSION['Famiglia'] = "";
            $_SESSION['Tipo'] = "";
            $_SESSION['Codice'] = "";
            $_SESSION['Descri'] = "";
            $_SESSION['Fornitore'] = "";
            $_SESSION['DtAbilitato'] = "";

            $_SESSION['FamigliaList'] = "";
            $_SESSION['TipoList'] = "";
            $_SESSION['CodiceList'] = "";
            $_SESSION['DescriList'] = "";
            $_SESSION['FornitoreList'] = "";
            $_SESSION['DtAbilitatoList'] = "";


            if (isset($_POST['Famiglia'])) {
                $_SESSION['Famiglia'] = trim($_POST['Famiglia']);
            }
            if (isset($_POST['FamigliaList']) AND $_POST['FamigliaList'] != "") {
                $_SESSION['Famiglia'] = trim($_POST['FamigliaList']);
            }
            if (isset($_POST['Tipo'])) {
                $_SESSION['Tipo'] = trim($_POST['Tipo']);
            }
            if (isset($_POST['TipoList']) AND $_POST['TipoList'] != "") {
                $_SESSION['Tipo'] = trim($_POST['TipoList']);
            }
            if (isset($_POST['Codice'])) {
                $_SESSION['Codice'] = trim($_POST['Codice']);
            }
            if (isset($_POST['CodiceList']) AND $_POST['CodiceList'] != "") {
                $_SESSION['Codice'] = trim($_POST['CodiceList']);
            }
            if (isset($_POST['Descri'])) {
                $_SESSION['Descri'] = trim($_POST['Descri']);
            }
            if (isset($_POST['DescriList']) AND $_POST['DescriList'] != "") {
                $_SESSION['Descri'] = trim($_POST['DescriList']);
            }

            if (isset($_POST['Fornitore'])) {
                $_SESSION['Fornitore'] = trim($_POST['Fornitore']);
            }
            if (isset($_POST['FornitoreList']) AND $_POST['FornitoreList'] != "") {
                $_SESSION['Fornitore'] = trim($_POST['FornitoreList']);
            }
            if (isset($_POST['DtAbilitato'])) {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
            }
            if (isset($_POST['DtAbilitatoList']) AND $_POST['DtAbilitatoList'] != "") {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitatoList']);
            }

            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #######################
            $_SESSION['Filtro'] = "cod_mat";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }
            //######################## CONDIZIONE DELLA SELECT ########################################
            $_SESSION['condizioneSelect'] = "1=1";
            if (isset($_POST['condizioneSelect']) AND $_POST['condizioneSelect'] != "") {
                $_SESSION['condizioneSelect'] = trim($_POST['condizioneSelect']);
            }     
           
            if (isset($_GET['condizioneSelect']) AND $_GET['condizioneSelect'] != "") {                
                switch ($_GET['condizioneSelect']) {
                    case 1:
                        //Seleziona solo i colori
                        $_SESSION['condizioneSelect'] = "tipo2='$valTipo2Pigment'";
                        break;
                    case 2:
                        //Seleziona solo i drymix
                        $_SESSION['condizioneSelect'] = "tipo3='$valTipo3Drymix' AND tipo2='$valTipo2RawMaterial'";
                        break;
                    case 3:
                        //Seleziona solo COMPOUND
                        $_SESSION['condizioneSelect'] = "tipo3='$valTipo3Compound'";
                        break;
                     case 4:
                        //Seleziona solo ADDITIVI
                        $_SESSION['condizioneSelect'] = "tipo2='$valTipo2Additivo'";
                        break;
                    case 5:
                        //Seleziona tutto
                        $_SESSION['condizioneSelect'] = "1=1";
                        break;
                    
                }
            }
            //########################################################################################

            begin();
            $sql = selectLabMatPrimeByFiltri($_SESSION['Filtro'], "cod_mat", $_SESSION['Codice'], $_SESSION['Descri'], $_SESSION['Famiglia'], $_SESSION['Tipo'], $_SESSION['Fornitore'], $_SESSION['DtAbilitato'], $strUtentiAziendeLabMat,$_SESSION['condizioneSelect']);
            $sqlFamiglia = selectLabMatPrimeByFiltri("famiglia", "famiglia", $_SESSION['Codice'], $_SESSION['Descri'], $_SESSION['Famiglia'], $_SESSION['Tipo'], $_SESSION['Fornitore'], $_SESSION['DtAbilitato'], $strUtentiAziendeLabMat,$_SESSION['condizioneSelect']);
            $sqlTipo = selectLabMatPrimeByFiltri("tipo", "tipo", $_SESSION['Codice'], $_SESSION['Descri'], $_SESSION['Famiglia'], $_SESSION['Tipo'], $_SESSION['Fornitore'], $_SESSION['DtAbilitato'], $strUtentiAziendeLabMat,$_SESSION['condizioneSelect']);
            $sqlCodice = selectLabMatPrimeByFiltri("cod_mat", "cod_mat", $_SESSION['Codice'], $_SESSION['Descri'], $_SESSION['Famiglia'], $_SESSION['Tipo'], $_SESSION['Fornitore'], $_SESSION['DtAbilitato'], $strUtentiAziendeLabMat,$_SESSION['condizioneSelect']);
            $sqlDescri = selectLabMatPrimeByFiltri("descri_materia", "descri_materia", $_SESSION['Codice'], $_SESSION['Descri'], $_SESSION['Famiglia'], $_SESSION['Tipo'], $_SESSION['Fornitore'], $_SESSION['DtAbilitato'], $strUtentiAziendeLabMat,$_SESSION['condizioneSelect']);
            $sqlForn = selectLabMatPrimeByFiltri("fornitore", "fornitore", $_SESSION['Codice'], $_SESSION['Descri'], $_SESSION['Famiglia'], $_SESSION['Tipo'], $_SESSION['Fornitore'], $_SESSION['DtAbilitato'], $strUtentiAziendeLabMat,$_SESSION['condizioneSelect']);
            $sqlDtAbil = selectLabMatPrimeByFiltri("dt_abilitato", "dt_abilitato", $_SESSION['Codice'], $_SESSION['Descri'], $_SESSION['Famiglia'], $_SESSION['Tipo'], $_SESSION['Fornitore'], $_SESSION['DtAbilitato'], $strUtentiAziendeLabMat,$_SESSION['condizioneSelect']);

            commit();
            $trovati = mysql_num_rows($sql);

            include('./moduli/visualizza_lab_materie.php');
            ?> 
            <div id="msgLog">
            <?php
            if ($DEBUG) {

                echo "</br>actionOnLoad :" . $actionOnLoad;
                echo "</br>Tab lab_materie_prime : Utenti e aziende visibili " . $strUtentiAziendeLabMat;
            }
            ?>
            </div>
        </div>
    </body>
</html>
