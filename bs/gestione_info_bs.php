<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php
        include('../include/header.php');
        //Costruzione dell'array contenente i vari msg di errore
        $arrayMsgErrPhp = array($msgErrTassoCambio,//0
             $msgAlertTassoCambio//1
        );
        ?>
    </head>
    <script language="javascript" type="text/javascript">
        function BloccaTastoInvio(evento)
        {
            codice_tasto = evento.keyCode ? evento.keyCode : evento.which ? evento.which : evento.charCode;
            if (codice_tasto == 13)
            {
                event.returnValue = false;
            }

        }
        function AggiornaPagina() {

            document.forms['VediBSRiepilogo'].submit();
        }
        //Trasformo l'array da php a js
        var arrayMsgErrJs = new Array("<?= join('", "', $arrayMsgErrPhp) ?>");
        function controllaCampi(arrayMsgErrJs) {

            var rv = true;
            var msg = "";

            if (isNaN(document.getElementById('Cambio').value) ||
                    document.getElementById('Cambio').value === "" ||
                    document.getElementById('Cambio').value === "0") {
                rv = false;
                msg = msg + ' ' + arrayMsgErrJs[0];
            }

            if (!rv) {

                alert(msg);
                rv = false;
            }
            return rv;
        }
        function AlertValuta(){
                alert(arrayMsgErrJs[1]);
            }
    </script>
    <?php
    if ($DEBUG)
        ini_set('display_errors', 1);

    //########################### GESTIONE UTENTI ##############################            
    //1) Si verifica se l'utente ha il permesso di visualizzare la lista delle simulazioni
    //2) Si verifica se l'utente ha il permesso di creare nuove simulazioni
    //3) Si verifica se l'utente ha il permesso di modificare le simulazioniesistenti
    $actionOnLoad = "";
    $elencoFunzioni = array("128", "129", "130");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);

    //############# STRINGA UTENTI - AZIENDE VIS ###############################
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'bs_riepilogo');

    //##########################################################################
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_bs_riepilogo.php');
            include('../sql/script.php');
            
            $_SESSION['Nominativo'] = "";
            $_SESSION['Venduto'] = "";
            $_SESSION['CostiVariabili'] = "";
            $_SESSION['Ricavi'] = "";
            $_SESSION['PrimoMargine'] = "";
            $_SESSION['AltreSpese'] = "";
            $_SESSION['SecondoMargine'] = "";
            $_SESSION['CostiAmmImpianto'] = "";
            $_SESSION['CostiAmmInv'] = "";
            $_SESSION['Ebita'] = "";
            $_SESSION['SaturazioneImp'] = "";
            $_SESSION['Anno'] = "";

            $_SESSION['NominativoList'] = "";
            $_SESSION['VendutoList'] = "";
            $_SESSION['CostiVariabiliList'] = "";
            $_SESSION['RicaviList'] = "";
            $_SESSION['PrimoMargineList'] = "";
            $_SESSION['AltreSpeseList'] = "";
            $_SESSION['SecondoMargineList'] = "";
            $_SESSION['CostiAmmImpiantoList'] = "";
            $_SESSION['CostiAmmInvList'] = "";
            $_SESSION['EbitaList'] = "";
            $_SESSION['SaturazioneImpList'] = "";
            $_SESSION['AnnoList'] = "";

            if (isset($_POST['Nominativo'])) {
                $_SESSION['Nominativo'] = trim($_POST['Nominativo']);
            }
            if (isset($_POST['NominativoList']) AND $_POST['NominativoList'] != "") {
                $_SESSION['Nominativo'] = trim($_POST['NominativoList']);
            }
            if (isset($_POST['Venduto'])) {
                $_SESSION['Venduto'] = trim($_POST['Venduto']);
            }
            if (isset($_POST['VendutoList']) AND $_POST['VendutoList'] != "") {
                $_SESSION['Venduto'] = trim($_POST['VendutoList']);
            }
            if (isset($_POST['CostiVariabili'])) {
                $_SESSION['CostiVariabili'] = trim($_POST['CostiVariabili']);
            }
            if (isset($_POST['CostiVariabiliList']) AND $_POST['CostiVariabiliList'] != "") {
                $_SESSION['CostiVariabili'] = trim($_POST['CostiVariabiliList']);
            }
            if (isset($_POST['Ricavi'])) {
                $_SESSION['Ricavi'] = trim($_POST['Ricavi']);
            }
            if (isset($_POST['RicaviList']) AND $_POST['RicaviList'] != "") {
                $_SESSION['Ricavi'] = trim($_POST['RicaviList']);
            }
            if (isset($_POST['PrimoMargine'])) {
                $_SESSION['PrimoMargine'] = trim($_POST['PrimoMargine']);
            }
            if (isset($_POST['PrimoMargineList']) AND $_POST['PrimoMargineList'] != "") {
                $_SESSION['PrimoMargine'] = trim($_POST['PrimoMargineList']);
            }
            if (isset($_POST['AltreSpese'])) {
                $_SESSION['AltreSpese'] = trim($_POST['AltreSpese']);
            }
            if (isset($_POST['AltreSpeseList']) AND $_POST['AltreSpeseList'] != "") {
                $_SESSION['AltreSpese'] = trim($_POST['AltreSpeseList']);
            }
            if (isset($_POST['SecondoMargine'])) {
                $_SESSION['SecondoMargine'] = trim($_POST['SecondoMargine']);
            }
            if (isset($_POST['SecondoMargineList']) AND $_POST['SecondoMargineList'] != "") {
                $_SESSION['SecondoMargine'] = trim($_POST['SecondoMargineList']);
            }
            if (isset($_POST['CostiAmmImpianto'])) {
                $_SESSION['CostiAmmImpianto'] = trim($_POST['CostiAmmImpianto']);
            }
            if (isset($_POST['CostiAmmImpiantoList']) AND $_POST['CostiAmmImpiantoList'] != "") {
                $_SESSION['CostiAmmImpianto'] = trim($_POST['CostiAmmImpiantoList']);
            }
            if (isset($_POST['CostiAmmInv'])) {
                $_SESSION['CostiAmmInv'] = trim($_POST['CostiAmmInv']);
            }
            if (isset($_POST['CostiAmmInvList']) AND $_POST['CostiAmmInvList'] != "") {
                $_SESSION['CostiAmmInv'] = trim($_POST['CostiAmmInvList']);
            }
            if (isset($_POST['Ebita'])) {
                $_SESSION['Ebita'] = trim($_POST['Ebita']);
            }
            if (isset($_POST['EbitaList']) AND $_POST['EbitaList'] != "") {
                $_SESSION['Ebita'] = trim($_POST['EbitaList']);
            }
            if (isset($_POST['SaturazioneImp'])) {
                $_SESSION['SaturazioneImp'] = trim($_POST['SaturazioneImp']);
            }
            if (isset($_POST['SaturazioneImpList']) AND $_POST['SaturazioneImpList'] != "") {
                $_SESSION['SaturazioneImp'] = trim($_POST['SaturazioneImpList']);
            }
            if (isset($_POST['Anno'])) {
                $_SESSION['Anno'] = trim($_POST['Anno']);
            }
            if (isset($_POST['AnnoList']) AND $_POST['AnnoList'] != "") {
                $_SESSION['Anno'] = trim($_POST['AnnoList']);
            }

//########### VARIABILE DI ORDINAMENTO DELLA QUERY #################
            $_SESSION['Filtro'] = "nominativo";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }

//##################################################################
//##############  GESTIONE VALUTA ##################################
//##################################################################

            $_SESSION['aggPagDatiInput'] = 0;
            $_SESSION['aggPagVenduto'] = 0;
            $_SESSION['aggPagRiepilogo'] = 0;
            $_SESSION['TODO_bs'] = "";

            if (isset($_POST['valutaBs'])) {

                foreach ($_POST['valutaBs'] as $key => $value) {

                    $_SESSION['valutaBs'] = $key;
                    
                }
            }

            if (isSet($_SESSION['valutaBs'])) {
                switch ($_SESSION['valutaBs']) {
                    case 1:
                        $_SESSION['cambio'] = 1;
                        $_SESSION['filtro'] = "filtroEuro";
                        break;
                    case 2:
                        if (isSet($_POST['Cambio']) && $_POST['Cambio']!=""){
                           
                        $_SESSION['cambio'] = trim($_POST['Cambio']);
                        $_SESSION['filtro'] = "filtroDollaro";
                        }
                        break;
                }
            } else {
                $_SESSION['valutaBs'] = 1;
                $_SESSION['cambio'] = 1;
                $_SESSION['filtro'] = "filtroEuro";
            }
            $filtroValuta = "{${$_SESSION['filtro']}}";

//            echo "<br/>valutabs: " . $_SESSION['valutaBs'];
//            echo "<br/>cambio: " . $_SESSION['cambio'];
//            echo "<br/>filtro: " . $_SESSION['filtro'];
            //##################################################################

            begin();
            $sql = findDatiRiepilogo($_SESSION['Filtro'], "nominativo,anno", $_SESSION['Nominativo'], $_SESSION['Venduto'], $_SESSION['CostiVariabili'], $_SESSION['Ricavi'], $_SESSION['PrimoMargine'], $_SESSION['AltreSpese'], $_SESSION['SecondoMargine'], $_SESSION['CostiAmmImpianto'], $_SESSION['CostiAmmInv'], $_SESSION['Ebita'], $_SESSION['SaturazioneImp'], $_SESSION['Anno'], $strUtentiAziende);
            $sqlNomi = findDatiRiepilogo("nominativo", "nominativo", $_SESSION['Nominativo'], $_SESSION['Venduto'], $_SESSION['CostiVariabili'], $_SESSION['Ricavi'], $_SESSION['PrimoMargine'], $_SESSION['AltreSpese'], $_SESSION['SecondoMargine'], $_SESSION['CostiAmmImpianto'], $_SESSION['CostiAmmInv'], $_SESSION['Ebita'], $_SESSION['SaturazioneImp'], $_SESSION['Anno'], $strUtentiAziende);
            $sqlAnno = findDatiRiepilogo("anno", "anno", $_SESSION['Nominativo'], $_SESSION['Venduto'], $_SESSION['CostiVariabili'], $_SESSION['Ricavi'], $_SESSION['PrimoMargine'], $_SESSION['AltreSpese'], $_SESSION['SecondoMargine'], $_SESSION['CostiAmmImpianto'], $_SESSION['CostiAmmInv'], $_SESSION['Ebita'], $_SESSION['SaturazioneImp'], $_SESSION['Anno'], $strUtentiAziende);
            commit();

            include('./moduli/visualizza_info_bs.php');
            ?>

            <div id="msgLog">
                <?php
                if ($DEBUG) {
                    echo "</br>actionOnLoad :" . $actionOnLoad;
                    echo "</br>Tab bs_riepilogo : Utenti e aziende visibili " . $strUtentiAziende;
                }
                ?>
            </div>
        </div>
    </body>
</html>

