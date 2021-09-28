<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php
    include('./oggetti/LabMatpriTeoria.php');
    include('../include/validator.php');
    ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
            if ($DEBUG)
                ini_set('display_errors', 1);

            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../include/funzioni.php');
            include('../Connessioni/serverdb.php');
            include('../include/precisione.php');

            //###### INCLUSIONE DEI FILE PRESENTI NELLA CARTELLA laboratoro/sql ###########
            include('sql/script.php');
            include('sql/script_lab_materie_prime.php');
            include('sql/script_lab_parametro.php');
            include('sql/script_lab_formula.php');
            include('sql/script_lab_matpri_teoria.php');
            include('sql/script_lab_parametro_teoria.php');


            $strUtentiAziendeParam = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_parametro');


//##############################################################################
//################# GESTIONE DEGLI ERRORI ######################################
//##############################################################################
//Inizializzo l'errore relativo ai campi della tabella lab_formula
            $errore = false;

//Inizializzo le variabili che contano il numero di errori fatti sulle 
//quantita dei parametri
            $NumErrorePar = 0;
            $NumErroreAcqua = 0;
            $ErroreEsisteFormula = false; //errore relativo all'esistenza della composizione della formula
            $messaggio = '';

            //QUERY AL DB
            begin();
            $sqlPar = findParametriByTipoVis($PercentualeNO, "nome_parametro", $strUtentiAziendeParam);
            $sqlParAc = findParametriByTipoVis($PercentualeSI, "nome_parametro", $strUtentiAziendeParam);
//            $sqlCodEsistenza = findFormuleByUtenteGruppo("cod_lab_formula", $_SESSION['username'], $_SESSION['nome_gruppo_utente']);
            commit();

//##############################################################################
//################# CONTROLLO INPUT ANAGRAFE FORMULA ###########################
//##############################################################################

            if (!isset($_POST['CodiceFormula']) || trim($_POST['CodiceFormula']) == "") {

                $errore = true;
                $messaggio = $messaggio . " " . $msgErrCodice . '<br/>';
            }

            if (!isset($_POST['Normativa']) || trim($_POST['Normativa']) == "") {

                $errore = true;
                $messaggio = $messaggio . " " . $msgErrSelectNormativa . '<br/>';
            }
            if (!isset($_POST['NomeProdObEs']) AND ! isset($_POST['NomeProdObNuovo'])) {

                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrProdOb . '<br />';
            }
            if (!isset($_POST['VisibilitaFormula']) OR $_POST['VisibilitaFormula'] == "" OR $_POST['VisibilitaFormula'] > $_SESSION['visibilita_utente']) {
                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrVisibilita . ' ' . $titleVisibilita . ' ' . $_SESSION['visibilita_utente'] . '<br />';
            }
            //Costruzione del codice esistenza della formula corrente 
            //con i codici delle materie prime e le loro quantita percentuali
            $CodiceEsistenza = "";
            $CodiceEsistenza = generaCodiceEsistenzaLabFormula($_SESSION['LabMatpriTeoria'], $PrecCodEsistenza);

            if ($CodiceEsistenza == "") {
                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrCodEsistenza . '<br />';
            }


            //Verifica esistenza caricamento formula Non serve			
            if ($errore) {
                //Ci sono errori quindi non salvo
                $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                echo '<div id="msgErr">' . $messaggio . '</div>';
            } else {
                //Vado avanti perche' non ci sono errori
                //Ricavo il valore dei campi tramite POST
                $CodiceFormula = str_replace("'", "''", $_POST['CodiceFormula']);
                $Normativa = str_replace("'", "''", $_POST['Normativa']);

                list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);

                $VisibilitaFormula = str_replace("'", "''", $_POST['VisibilitaFormula']);

//                $ProdOb = str_replace("'", "''", $_POST['ProdOb']);
                $TipoProdOb = $_POST['scegli_target'];
                $ProdOb = "";
                if ($TipoProdOb == "NomeProdObEs") {
                    $ProdOb = $_POST['NomeProdObEs'];
                } else if ($TipoProdOb == "NomeProdObNuovo") {
                    $ProdOb = $_POST['NomeProdObNuovo'];
                }

                //Ricalcolo la data corrente  
                $DataFormula = dataCorrenteInserimento();


//##############################################################################
//######## CONTROLLO INPUT PARAMETRI DI TIPO  PercentualeNO ####################
//##############################################################################
//Estraggo l'elenco dei parametri presenti nella tabella lab_parametro
                $NPar = 1;
                $messaggioQtaPar = "";
                while ($rowPar = mysql_fetch_array($sqlPar)) {

                    //Memorizzo nelle rispettive variabili le Quantità di materia_prime
                    $QuantitaParametro = $_POST['QtaPar' . $NPar];

                    //Controllo input Quantità parametri
                    if (!is_numeric($QuantitaParametro) && $QuantitaParametro != "") {
                        $NumErrorePar++;
                        $messaggioQtaPar = $messaggioQtaPar . " " . $rowPar['nome_parametro'] . " : " . $msgErrQtaNumerica . "<br/>";
                    }
                    if ($QuantitaParametro < 0) {
                        $NumErrorePar++;
                        $messaggioQtaPar = $messaggioQtaPar . " " . $rowPar['nome_parametro'] . " : " . $msgErrQtaMagZero . "<br/>";
                    }

                    $NPar++;
                }// End While finiti i parametri

                if ($NumErrorePar > 0) {
                    $messaggioQtaPar = $messaggioQtaPar . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                    echo '<div id="msgErr">' . $messaggioQtaPar . '</div>';
                } else {
                    ////////////////////////Vado avanti perchè non ci sono errori sulle Quantità di materie prime e parametri				
//##############################################################################
//######## CONTROLLO INPUT PARAMETRI DI TIPO  PercentualeSI ####################
//##############################################################################

                    $messaggioQtaAc = "";
                    $NParAc = 1;
                    while ($rowParAc = mysql_fetch_array($sqlParAc)) {
                        //Memorizzo nelle rispettive variabili le Quantità di materia_prime
                        $QuantitaPercAcqua = $_POST['QtaPercAc' . $NParAc];

                        //Controllo input Quantità parametri
                        if (!is_numeric($QuantitaPercAcqua) && $QuantitaPercAcqua != "") {
                            $NumErroreAcqua++;
                            $messaggioQtaAc = $messaggioQtaAc . " " . $rowPar['nome_parametro'] . ": " . $msgErrQtaNumerica . "<br/>";
                        }
                        if ($QuantitaPercAcqua < 0) {
                            $NumErroreAcqua++;
                            $messaggioQtaAc = $messaggioQtaAc . " " . $rowPar['nome_parametro'] . ": " . $msgErrQtaMagZero . "<br/>";
                        }

                        $NParAc++;
                    }// End While finiti i parametri ACQUA 

                    if ($NumErroreAcqua > 0) {
                        $messaggioQtaAc = $messaggioQtaAc . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                        echo '<div id="msgErr">' . $messaggioQtaAc . '</div>';
                    } else {


//##############################################################################
//######## CONTROLLO ESISTENZA COMPOSIZIONE FORMULA ############################
//##############################################################################


                        $messaggioEsisteFormula = "";
                        //Verifica esistenza del codice esistenza
                        $sqlCodEsistenza = findFormuleByAzienda("cod_lab_formula",$IdAzienda);
                        while ($rowCodEsistenza = mysql_fetch_array($sqlCodEsistenza)) {

                            if ($rowCodEsistenza['cod_esistenza'] == $CodiceEsistenza) {
                                $ErroreEsisteFormula = true;
                                $messaggioEsisteFormula = $msgErrEsisteFormula . " " . $rowCodEsistenza['cod_lab_formula'] . " !<br/>";
                            }
                        }

                        if ($ErroreEsisteFormula) {
                            $messaggioEsisteFormula = $messaggioEsisteFormula . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                            echo '<div id="msgErr">' . $messaggioEsisteFormula . '</div>';
                        } else {

//////////////Fine controllo esistenza formula
//##############################################################################
//################## SALVATAGGIO ANAGRAFE FORMULA ##############################
//##############################################################################
                            $erroreTransazione = false;
                            $insertAnFormula = true;
                            $insertQtaMt = true;
                            $insertQtaVarMt = true;
                            $insertParPercSi = true;
                            $insertParPercNo = true;

                            begin();

////////////////////////Se sono arrivata fin qui vuol dire che non si sono verificati 
//errori di nessun genere quindi posso salvare			
                            // 1 . Salvo nella tabella lab_formula
                            $insertAnFormula = salvaLabFormula($CodiceFormula, $DataFormula, $ProdOb, $Normativa, $CodiceEsistenza, $_SESSION['username'], $_SESSION['nome_gruppo_utente'], $_SESSION['id_utente'], $IdAzienda, $VisibilitaFormula);

//##############################################################################
//################## SALVATAGGIO MATERIE PRIME #################################
//############################################################################## 
                            //Estraggo l'elenco delle materie prime presenti nell' oggetto LabMatpriTeoria
                            for ($j = 0; $j < count($_SESSION['LabMatpriTeoria']); $j++) {

                                //Memorizzo nelle rispettive variabili le Quantità di materia_prime
                                $IdMat = $_SESSION['LabMatpriTeoria'][$j]->getIdMat();
                                $Tipo = $_SESSION['LabMatpriTeoria'][$j]->getTipo();
                                $QuantitaMatPrima = $_SESSION['LabMatpriTeoria'][$j]->getQtaTeo();
                                $QuantitaPercMatPrima = $_SESSION['LabMatpriTeoria'][$j]->getQtaTeoPerc();

                                if ($Tipo == "FIX") {
                                    // Salvo le Quantità nella tabella lab_matpri_teoria
                                    $insertQtaMt = salvaQtaFormula($IdMat, $CodiceFormula, $DataFormula, $QuantitaMatPrima, $QuantitaPercMatPrima, 'FIX');
                                }
                                //Salvo le materie prime oggetto  di variazione selezionate 
                                //tramite checkbox con qta=0
                                if ($Tipo == "VAR") {

                                    $insertQtaVarMt = salvaQtaFormula($IdMat, $CodiceFormula, $DataFormula, $QuantitaMatPrima, $QuantitaPercMatPrima, "VAR");
                                }
                                if (!$insertQtaMt OR ! $insertQtaVarMt) {
                                    $erroreTransazione = true;
                                }
                            }// End While finite le materie prime 
//##############################################################################
//################## SALVATAGGIO PARAMETRI DI TIPO PercentualeSI ###############
//############################################################################## 

                            $NParAc = 1;
                            if (mysql_num_rows($sqlParAc) > 0)
                                mysql_data_seek($sqlParAc, 0);
//                  $sqlParAc = findParametriByTipo($PercentualeSI, "nome_parametro");
                            while ($rowParAc = mysql_fetch_array($sqlParAc)) {

                                //Memorizzo nelle rispettive variabili le Quantità di parametri
                                $QuantitaPercAcqua = $_POST['QtaPercAc' . $NParAc];
                                $SalvaQtaAcqua = false;

                                if (!isset($QuantitaPercAcqua)) {
                                    $SalvaQtaAcqua = false;
                                }
                                if (is_numeric($QuantitaPercAcqua) && $QuantitaPercAcqua > 0 && $QuantitaPercAcqua != "" && isset($QuantitaPercAcqua)) {
                                    $SalvaQtaAcqua = true;
                                }

                                if ($SalvaQtaAcqua == true) {
                                    // Salvo le Quantità nella tabella lab_parametro_teoria
                                    $insertParPercSi = salvaParFormula($rowParAc['id_par'], $CodiceFormula, $DataFormula, $QuantitaPercAcqua);
                                }
                                if (!$insertParPercSi) {
                                    $erroreTransazione = true;
                                }
                                $NParAc++;
                            }// End While finiti i parametri
//##############################################################################
//################## SALVATAGGIO PARAMETRI DI TIPO PercentualeNO ###############
//############################################################################## 
                            $NPar = 1;
                            if (mysql_num_rows($sqlPar) > 0)
                                mysql_data_seek($sqlPar, 0);
//			$sqlPar = findParametriByTipo($PercentualeNO, "nome_parametro");
                            while ($rowPar = mysql_fetch_array($sqlPar)) {

                                //Memorizzo nelle rispettive variabili le quantità di materia_prime
                                $QuantitaParametro = $_POST['QtaPar' . $NPar];
                                $SalvaQtaPar = false;

                                if (!isset($QuantitaParametro)) {
                                    $SalvaQtaPar = false;
                                }
                                if (is_numeric($QuantitaParametro) && $QuantitaParametro > 0 && $QuantitaParametro != "" && isset($QuantitaParametro)) {
                                    $SalvaQtaPar = true;
                                }

                                if ($SalvaQtaPar == true) {
                                    // Salvo le quantità nella tabella lab_formula
                                    $insertParPercNo = salvaParFormula($rowPar['id_par'], $CodiceFormula, $DataFormula, $QuantitaParametro);
                                }
                                if (!$insertParPercNo) {
                                    $erroreTransazione = true;
                                }

                                $NPar++;
                            }// End While finiti i parametri

                            if ($erroreTransazione OR ! $insertAnFormula) {

                                rollback();
                                echo "</br>" . $msgTransazioneFallita;
                                echo "</br>insertAnFormula : " . $insertAnFormula;
                                echo "</br>insertQtaMt : " . $insertQtaMt;
                                echo "</br>insertQtaVarMt : " . $insertQtaVarMt;
                                echo "</br>insertParPercSi : " . $insertParPercSi;
                                echo "</br>insertParPercNo : " . $insertParPercNo;
                            } else {

                                commit();
                                echo $msgInserimentoCompletato . ' <a href="gestione_lab_formula.php">' . $msgTornaAlleFormule . '</a>';
                            }
                        }//End errore esistenza formula
                    } //End if numerrore Acqua
                }//End if ($numErrorePar)
            }//End if errore
            ?>
        </div>
    </body>
</html>
