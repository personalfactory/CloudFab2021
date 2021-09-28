<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <?php
    //############# VERIFICA PERMESSO VISUALIZZAZIONE LISTA ####################    
    
    $elencoFunzioni = array("44");//Vedere lista segnalazioni
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni,$_SESSION['objPermessiVis']);
    
    //Stringa contentente gli utenti proprietari e le aziende di cui visualizzare le macchine
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'macchina');
    ?>

    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">

            <?php
            if($DEBUG) ini_set("display_errors", "1");

            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_info_origami.php');

            $_SESSION['Priorita'] = "";
            $_SESSION['DescriStab'] = "";
            $_SESSION['TipoInfo'] = "";
            $_SESSION['SottoTipo'] = "";
            $_SESSION['Info'] = "";
            $_SESSION['Posizione'] = "";
            $_SESSION['DtAbilitato'] = "";
            $_SESSION['Utente'] = "";

            $_SESSION['PrioritaList'] = "";
            $_SESSION['DescriStabList'] = "";
            $_SESSION['TipoInfoList'] = "";
            $_SESSION['SottoTipoList'] = "";
            $_SESSION['InfoList'] = "";
            $_SESSION['PosizioneList'] = "";
            $_SESSION['DtAbilitatoList'] = "";
            $_SESSION['UtenteList'] = "";


            if (isset($_POST['Priorita'])) {
                $_SESSION['Priorita'] = trim($_POST['Priorita']);
            }
            if (isset($_POST['PrioritaList']) AND $_POST['PrioritaList'] != "") {
                $_SESSION['Priorita'] = trim($_POST['PrioritaList']);
            }
            if (isset($_POST['DescriStab'])) {
                $_SESSION['DescriStab'] = trim($_POST['DescriStab']);
            }
            if (isset($_POST['DescriStabList']) AND $_POST['DescriStabList'] != "") {
                $_SESSION['DescriStab'] = trim($_POST['DescriStabList']);
            }
            if (isset($_POST['TipoInfo'])) {
                $_SESSION['TipoInfo'] = trim($_POST['TipoInfo']);
            }
            if (isset($_POST['TipoInfoList']) AND $_POST['TipoInfoList'] != "") {
                $_SESSION['TipoInfo'] = trim($_POST['TipoInfoList']);
            }
            if (isset($_POST['SottoTipo'])) {
                $_SESSION['SottoTipo'] = trim($_POST['SottoTipo']);
            }
            if (isset($_POST['SottoTipoList']) AND $_POST['SottoTipoList'] != "") {
                $_SESSION['SottoTipo'] = trim($_POST['SottoTipoList']);
            }
            if (isset($_POST['Info'])) {
                $_SESSION['Info'] = trim($_POST['Info']);
            }
            if (isset($_POST['InfoList']) AND $_POST['InfoList'] != "") {
                $_SESSION['Info'] = trim($_POST['InfoList']);
            }
            if (isset($_POST['Posizione'])) {
                $_SESSION['Posizione'] = trim($_POST['Posizione']);
            }
            if (isset($_POST['PosizioneList']) AND $_POST['PosizioneList'] != "") {
                $_SESSION['Posizione'] = trim($_POST['PosizioneList']);
            }
            if (isset($_POST['DtAbilitato'])) {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
            }
            if (isset($_POST['DtAbilitatoList']) AND $_POST['DtAbilitatoList'] != "") {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitatoList']);
            }

            if (isset($_POST['Utente']) AND $_POST['Utente'] != "") {
                $_SESSION['Utente'] = trim($_POST['Utente']);
            }
            if (isset($_POST['UtenteList']) AND $_POST['UtenteList'] != "") {
                $_SESSION['Utente'] = trim($_POST['UtenteList']);
            }

            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #################
            $_SESSION['Filtro'] = "i.id_macchina";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }

            begin();
            $sql = selectInfoOrigamiByFiltri($_SESSION['Filtro'], "id", $_SESSION['Priorita'], $_SESSION['DescriStab'], $_SESSION['TipoInfo'], $_SESSION['SottoTipo'], $_SESSION['Posizione'], $_SESSION['Info'], $_SESSION['DtAbilitato'], $_SESSION['Utente'],$strUtentiAziende);
            $sqlPri = selectInfoOrigamiByFiltri("priorita", "priorita", $_SESSION['Priorita'], $_SESSION['DescriStab'], $_SESSION['TipoInfo'], $_SESSION['SottoTipo'], $_SESSION['Posizione'], $_SESSION['Info'], $_SESSION['DtAbilitato'], $_SESSION['Utente'],$strUtentiAziende);
            $sqlDescriStab = selectInfoOrigamiByFiltri("descri_stab", "descri_stab", $_SESSION['Priorita'], $_SESSION['DescriStab'], $_SESSION['TipoInfo'], $_SESSION['SottoTipo'], $_SESSION['Posizione'], $_SESSION['Info'], $_SESSION['DtAbilitato'], $_SESSION['Utente'],$strUtentiAziende);
            $sqlTipoInfo = selectInfoOrigamiByFiltri("tipo_info", "tipo_info", $_SESSION['Priorita'], $_SESSION['DescriStab'], $_SESSION['TipoInfo'], $_SESSION['SottoTipo'], $_SESSION['Posizione'], $_SESSION['Info'], $_SESSION['DtAbilitato'], $_SESSION['Utente'],$strUtentiAziende);
            $sqlSottoTipo = selectInfoOrigamiByFiltri("sotto_tipo", "sotto_tipo", $_SESSION['Priorita'], $_SESSION['DescriStab'], $_SESSION['TipoInfo'], $_SESSION['SottoTipo'], $_SESSION['Posizione'], $_SESSION['Info'], $_SESSION['DtAbilitato'], $_SESSION['Utente'],$strUtentiAziende);
            $sqlInfo = selectInfoOrigamiByFiltri("info", "info", $_SESSION['Priorita'], $_SESSION['DescriStab'], $_SESSION['TipoInfo'], $_SESSION['SottoTipo'], $_SESSION['Posizione'], $_SESSION['Info'], $_SESSION['DtAbilitato'], $_SESSION['Utente'],$strUtentiAziende);
            $sqlPosizione = selectInfoOrigamiByFiltri("posizione", "posizione", $_SESSION['Priorita'], $_SESSION['DescriStab'], $_SESSION['TipoInfo'], $_SESSION['SottoTipo'], $_SESSION['Posizione'], $_SESSION['Info'], $_SESSION['DtAbilitato'], $_SESSION['Utente'],$strUtentiAziende);
            $sqlDt = selectInfoOrigamiByFiltri("dt_abil", "dt_abil", $_SESSION['Priorita'], $_SESSION['DescriStab'], $_SESSION['TipoInfo'], $_SESSION['SottoTipo'], $_SESSION['Posizione'], $_SESSION['Info'], $_SESSION['DtAbilitato'], $_SESSION['Utente'],$strUtentiAziende);
            $sqlUt = selectInfoOrigamiByFiltri("utente", "utente", $_SESSION['Priorita'], $_SESSION['DescriStab'], $_SESSION['TipoInfo'], $_SESSION['SottoTipo'], $_SESSION['Posizione'], $_SESSION['Info'], $_SESSION['DtAbilitato'], $_SESSION['Utente'],$strUtentiAziende);
            commit();

            $trovati = mysql_num_rows($sql);

            include('./moduli/visualizza_info_origami.php');
            ?>

        </div>
    </body>
</html>
