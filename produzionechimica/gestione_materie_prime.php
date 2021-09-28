<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript">
        
        function disabilitaScrittura() {
            //CASO: PERMESSO DI SCRITTURA NEGATO
            //Disabilito la creazione di un nuovo dato            
            document.getElementById('Nuovo').removeAttribute('href');
            document.getElementById('VediCodMov').removeAttribute('href');

            //Disabilita l'eliminzione dei prodotti 
            for (i = 0; i < document.getElementsByName('Modifica').length; i++) {
                document.getElementsByName('Modifica')[i].removeAttribute('href');
            }
        }
    </script>
    <?php
     if($DEBUG) ini_set('display_errors', "1");
    //##########################################################################            
    //NOTE GESTIONE UTENTI
    //1) Si verifica se l'utente ha il permesso di visualizzare la lista dei dati 23
    //2) Si verifica se l'utente ha il permesso di visualizzare il dettaglio di una mat 24
    //3) Si verifica se l'utente ha il permesso di editare la tabella materia_prima 27
    //4) Si verifica se l'utente ha il permesso di visualizzare i codici dei movimenti 103
    //############# VERIFICA PERMESSI ##########################################
    $actionOnLoad="";
    $elencoFunzioni = array("23","24","27","103");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni,$_SESSION['objPermessiVis']);
    //############# STRINGHE UTENTI - AZIENDE VISIBILI###########################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'materia_prima');   
    
    //##########################################################################
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <!--<div id="mainContainer" >-->
             <div id="bigMainContainer" >
            
            <?php            
            include('../include/menu.php');
            include('../include/precisione.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_materia_prima.php');
            include('../sql/script_gaz_movmag.php');
            include('../sql/script_generazione_formula.php');

            $_SESSION['Famiglia'] = "";
            $_SESSION['Codice'] = "";
            $_SESSION['Descri'] = "";
            $_SESSION['ScortaMinima'] = "";
            $_SESSION['Giacenza'] = "";
            $_SESSION['PreAcq'] = "";
            $_SESSION['DtAbilitato'] = "";
            $_SESSION['DtFinePeriodo']=  dataCorrenteInserimento();
            

            $_SESSION['FamigliaList'] = "";
            $_SESSION['CodiceList'] = "";
            $_SESSION['DescriList'] = "";
            $_SESSION['ScortaMinimaList'] = "";
            $_SESSION['GiacenzaList'] = "";
            $_SESSION['PreAcqList'] = "";
            $_SESSION['DtAbilitatoList'] = "";


            if (isset($_POST['Famiglia'])) {
                $_SESSION['Famiglia'] = trim($_POST['Famiglia']);
            }
            if (isset($_POST['FamigliaList']) AND $_POST['FamigliaList'] != "") {
                $_SESSION['Famiglia'] = trim($_POST['FamigliaList']);
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
            if (isset($_POST['ScortaMinima'])) {
                $_SESSION['ScortaMinima'] = trim($_POST['ScortaMinima']);
            }
            if (isset($_POST['ScortaMinimaList']) AND $_POST['ScortaMinimaList'] != "") {
                $_SESSION['ScortaMinima'] = trim($_POST['ScortaMinimaList']);
            }
            if (isset($_POST['PreAcq'])) {
                $_SESSION['PreAcq'] = trim($_POST['PreAcq']);
            }
            if (isset($_POST['PreAcqList']) AND $_POST['PreAcqList'] != "") {
                $_SESSION['PreAcq'] = trim($_POST['PreAcqList']);
            }
            if (isset($_POST['Giacenza'])) {
                $_SESSION['Giacenza'] = trim($_POST['Giacenza']);
            }
            if (isset($_POST['GiacenzaList']) AND $_POST['GiacenzaList'] != "") {
                $_SESSION['Giacenza'] = trim($_POST['GiacenzaList']);
            }
            if (isset($_POST['DtAbilitato'])) {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
            }
            if (isset($_POST['DtAbilitatoList']) AND $_POST['DtAbilitatoList'] != "") {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitatoList']);
            }
            if (isset($_POST['DtFinePeriodo'])) {
                $_SESSION['DtFinePeriodo'] = trim($_POST['DtFinePeriodo']);
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
                        //Seleziona solo le materie prime in produzione
                        $_SESSION['condizioneSelect'] = "cod_mat IN (SELECT cod_mat FROM serverdb.generazione_formula)";
                        break;
                    case 2:
                        //Seleziona solo le materie prime fuori produzione
                        $_SESSION['condizioneSelect'] = "cod_mat NOT IN (SELECT cod_mat FROM serverdb.generazione_formula)";
                        break;
                    case 3:
                        //Seleziona solo le materie prime che sono in produzione con giacenza al di sotto della scorta minima
                        $_SESSION['condizioneSelect'] = "cod_mat IN (SELECT cod_mat FROM serverdb.generazione_formula) AND giacenza_attuale<scorta_minima";
                        break;
                    case 4:
                        //Seleziona tutte le materie prime
                        $_SESSION['condizioneSelect'] = "1=1";
                        break;
                    
                }
            }
            //########################################################################################
            
            
            
            begin();
            $arrayMatInFormule=array();
            $sqlMatInFormule=selectMatPrimeInFormule("cod_mat", "cod_mat",$strUtentiAziende);
            while ($row = mysql_fetch_array($sqlMatInFormule)) {
                $arrayMatInFormule[$i] = $row['cod_mat'];
                $i++;
            }            
            
            $sql = selectMatPrimeByFiltri($_SESSION['Filtro'], "cod_mat", $_SESSION['Codice'], $_SESSION['Descri'], $_SESSION['Famiglia'], $_SESSION['ScortaMinima'], $_SESSION['PreAcq'], $_SESSION['Giacenza'], $_SESSION['DtAbilitato'],$strUtentiAziende,$_SESSION['condizioneSelect']);
            $sqlFamiglia = selectMatPrimeByFiltri("famiglia", "famiglia", $_SESSION['Codice'], $_SESSION['Descri'], $_SESSION['Famiglia'], $_SESSION['ScortaMinima'], $_SESSION['PreAcq'], $_SESSION['Giacenza'], $_SESSION['DtAbilitato'],$strUtentiAziende,$_SESSION['condizioneSelect']);
            $sqlCodice = selectMatPrimeByFiltri("cod_mat", "cod_mat", $_SESSION['Codice'], $_SESSION['Descri'], $_SESSION['Famiglia'], $_SESSION['ScortaMinima'], $_SESSION['PreAcq'], $_SESSION['Giacenza'], $_SESSION['DtAbilitato'],$strUtentiAziende,$_SESSION['condizioneSelect']);
            $sqlDescri = selectMatPrimeByFiltri("descri_mat", "descri_mat", $_SESSION['Codice'], $_SESSION['Descri'], $_SESSION['Famiglia'], $_SESSION['ScortaMinima'], $_SESSION['PreAcq'], $_SESSION['Giacenza'], $_SESSION['DtAbilitato'],$strUtentiAziende,$_SESSION['condizioneSelect']);
            $sqlScortaMinima = selectMatPrimeByFiltri("scorta_minima", "scorta_minima", $_SESSION['Codice'], $_SESSION['Descri'], $_SESSION['Famiglia'], $_SESSION['ScortaMinima'], $_SESSION['PreAcq'], $_SESSION['Giacenza'], $_SESSION['DtAbilitato'],$strUtentiAziende,$_SESSION['condizioneSelect']);
            $sqlPreAcq = selectMatPrimeByFiltri("pre_acq", "pre_acq", $_SESSION['Codice'], $_SESSION['Descri'], $_SESSION['Famiglia'], $_SESSION['ScortaMinima'], $_SESSION['PreAcq'], $_SESSION['Giacenza'], $_SESSION['DtAbilitato'],$strUtentiAziende,$_SESSION['condizioneSelect']);
            $sqlGiac = selectMatPrimeByFiltri("giacenza_attuale", "giacenza_attuale", $_SESSION['Codice'], $_SESSION['Descri'], $_SESSION['Famiglia'], $_SESSION['ScortaMinima'], $_SESSION['PreAcq'], $_SESSION['Giacenza'], $_SESSION['DtAbilitato'],$strUtentiAziende,$_SESSION['condizioneSelect']);
            $sqlDtAbil = selectMatPrimeByFiltri("dt_abilitato", "dt_abilitato", $_SESSION['Codice'], $_SESSION['Descri'], $_SESSION['Famiglia'], $_SESSION['ScortaMinima'], $_SESSION['PreAcq'], $_SESSION['Giacenza'], $_SESSION['DtAbilitato'],$strUtentiAziende,$_SESSION['condizioneSelect']);

            $arrayMat = array();
            $i = 0;
            while ($row = mysql_fetch_array($sql)) {
                $arrayMat[$i] = $row['cod_mat'];
                $i++;
            }
//          print_r($arrayMat);
            
            $operazione = "-1";
            $Consumo = 0;
            $Spesa = 0;
            $sqlConsumo = "";
            if (count($arrayMat) > 0) {
                $sqlConsumo = trovaConsumoByArtico($arrayMat, $operazione, $_SESSION['DtAbilitato']);
                $rowConsumo = mysql_fetch_row($sqlConsumo);
                $Consumo = $rowConsumo[0];
                $Spesa = $rowConsumo[1];
            }
            commit();
            
            $trovati = mysql_num_rows($sql);

            include('./moduli/visualizza_materie_prime.php');
            ?>
<div id="msgLog">
            <?php
            if ($DEBUG) {

                echo "</br>actionOnLoad :" . $actionOnLoad;
                echo "</br>Tab materia_prima : Utenti e aziende visibili " . $strUtentiAziende;
            }
            ?>
            </div>
        </div>
    </body>
</html>
