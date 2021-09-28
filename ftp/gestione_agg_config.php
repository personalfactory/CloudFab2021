<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_aggiornamento_config.php');

            $_SESSION['Id'] = "";
            $_SESSION['Parametro'] = "";
            $_SESSION['Valore'] = "";
            $_SESSION['Tipo'] = "";
            $_SESSION['Descrizione'] = "";
            $_SESSION['Abilitato'] = "";
            $_SESSION['DtAbilitato'] = "";

            $_SESSION['IdList'] = "";
            $_SESSION['ParametroList'] = "";
            $_SESSION['ValoreList'] = "";
            $_SESSION['TipoList'] = "";
            $_SESSION['DescrizioneList'] = "";
            $_SESSION['AbilitatoList'] = "";
            $_SESSION['DtAbilitatoList'] = "";


            if (isset($_POST['Id'])) {
                $_SESSION['Id'] = trim($_POST['Id']);
            }
            if (isset($_POST['IdList']) AND $_POST['IdList'] != "") {
                $_SESSION['Id'] = trim($_POST['IdList']);
            }
            if (isset($_POST['Parametro'])) {
                $_SESSION['Parametro'] = trim($_POST['Parametro']);
            }
            if (isset($_POST['ParametroList']) AND $_POST['ParametroList'] != "") {
                $_SESSION['Parametro'] = trim($_POST['ParametroList']);
            }
            
            if (isset($_POST['Valore'])) {
                $_SESSION['Valore'] = trim($_POST['Valore']);
            }
            if (isset($_POST['ValoreList']) AND $_POST['ValoreList'] != "") {
                $_SESSION['Valore'] = trim($_POST['ValoreList']);
            }
            if (isset($_POST['Tipo'])) {
                $_SESSION['Tipo'] = trim($_POST['Tipo']);
            }
            if (isset($_POST['TipoList']) AND $_POST['TipoList'] != "") {
                $_SESSION['Tipo'] = trim($_POST['TipoList']);
            }
            if (isset($_POST['Descrizione'])) {
                $_SESSION['Descrizione'] = trim($_POST['Descrizione']);
            }
            if (isset($_POST['DescrizioneList']) AND $_POST['DescrizioneList'] != "") {
                $_SESSION['Descrizione'] = trim($_POST['DescrizioneList']);
            }
            if (isset($_POST['Abilitato'])) {
                $_SESSION['Abilitato'] = trim($_POST['Abilitato']);
            }
            if (isset($_POST['AbilitatoList']) AND $_POST['AbilitatoList'] != "") {
                $_SESSION['Abilitato'] = trim($_POST['AbilitatoList']);
            }
            if (isset($_POST['DtAbilitato'])) {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
            }
            if (isset($_POST['DtAbilitatoList']) AND $_POST['DtAbilitatoList'] != "") {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitatoList']);
            }

            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #######################
            $_SESSION['Filtro'] = "id";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }
            
            
            begin();
            $sql = findAllAggCongifByFiltri($_SESSION['Filtro'], "id", $_SESSION['Id'], $_SESSION['Parametro'],  $_SESSION['Valore'], $_SESSION['Tipo'],$_SESSION['Descrizione'],$_SESSION['Abilitato'], $_SESSION['DtAbilitato']);
            $sqlId = findAllAggCongifByFiltri("id", "id", $_SESSION['Id'], $_SESSION['Id'], $_SESSION['Parametro'],  $_SESSION['Valore'], $_SESSION['Tipo'],$_SESSION['Descrizione'],$_SESSION['Abilitato'], $_SESSION['DtAbilitato']);
            $sqlParametro = findAllAggCongifByFiltri("parametro", "parametro", $_SESSION['Id'], $_SESSION['Parametro'],  $_SESSION['Valore'], $_SESSION['Tipo'],$_SESSION['Descrizione'],$_SESSION['Abilitato'], $_SESSION['DtAbilitato']);
            $sqlTipo = findAllAggCongifByFiltri("tipo", "tipo", $_SESSION['Id'], $_SESSION['Parametro'],  $_SESSION['Valore'], $_SESSION['Tipo'],$_SESSION['Descrizione'],$_SESSION['Abilitato'], $_SESSION['DtAbilitato']);
            $sqlValore = findAllAggCongifByFiltri("valore", "valore", $_SESSION['Id'], $_SESSION['Parametro'],  $_SESSION['Valore'], $_SESSION['Tipo'],$_SESSION['Descrizione'],$_SESSION['Abilitato'], $_SESSION['DtAbilitato']);
            $sqlDescrizione = findAllAggCongifByFiltri("descrizione", "descrizione", $_SESSION['Id'], $_SESSION['Parametro'],  $_SESSION['Valore'], $_SESSION['Tipo'],$_SESSION['Descrizione'],$_SESSION['Abilitato'], $_SESSION['DtAbilitato']);
            $sqlAbilitato = findAllAggCongifByFiltri("abilitato", "abilitato", $_SESSION['Id'], $_SESSION['Parametro'],  $_SESSION['Valore'], $_SESSION['Tipo'],$_SESSION['Descrizione'],$_SESSION['Abilitato'], $_SESSION['DtAbilitato']);
            $sqlDtAbilitato= findAllAggCongifByFiltri("dt_abilitato", "dt_abilitato", $_SESSION['Id'], $_SESSION['Parametro'],  $_SESSION['Valore'], $_SESSION['Tipo'],$_SESSION['Descrizione'],$_SESSION['Abilitato'], $_SESSION['DtAbilitato']);
            commit();
            $trovati = mysql_num_rows($sql);

            include('./moduli/visualizza_agg_config.php');
            ?>
            <div id="msgLog">
                <?php
                if ($DEBUG) {
                    echo "actionOnLoad :" . $actionOnLoad;
                    echo "</br>Tab formula : Nuova stringa unica utenti e aziende visibili : " . $strUtentiAziende;
                }
                ?>
            </div>
        </div>
    </body>
</html>
