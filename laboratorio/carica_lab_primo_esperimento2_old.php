<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body >
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('./sql/script.php');
            include('./sql/script_lab_peso.php');
            include('./sql/script_lab_esperimento.php');
            include('./sql/script_lab_risultato_matpri.php');
            include('./sql/script_lab_risultato_par.php');

//###################### NOTA BENE #############################################
//Le variabili contenenti la stringa "acqua" o "ac" si riferiscono a tutti i 
//parametri di tipo PercentualeSI
//##############################################################################
//Ricavo il valore dei campi arrivati tramite POST 
            $Formula = $_POST['Formula'];
            $CodiceFormula = $_POST['Formula'];
//$QtaMiscela=$_POST['QtaMiscela'];
            $CodiceBarre = $_POST['CodiceBarre'];
            $Tipo = $_POST['Tipo'];

            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);

//Gestione degli errori
//Inizializzo le variabili che contano il numero di errori fatti sulle quantita di materia prima, sui valori dei parametri, sull'acqua
            $NumErroreMt = 0;
            $NumErroreComp = 0;
            $NumErrorePar = 0;
            $NumErroreAcqua = 0;
            $messaggio = '';


            $sqlMatPrime = findPeso($CodiceFormula, $_SESSION['lab_macchina'], $valTipoMatCompound);
            $sqlComp = findPeso($CodiceFormula, $_SESSION['lab_macchina'], $valTipoMatDryMix);
            $sqlParAc = findPeso($CodiceFormula, $_SESSION['lab_macchina'], $PercentualeSI);
            $sqlPar = findPeso($CodiceFormula, $_SESSION['lab_macchina'], $PercentualeNO);

            //Calcolo del numero dell'esperimento corrente relativo alla formula selezionata
            $sqlEsper = selectMaxNumEsperimento($CodiceFormula);
            $NumEsperimento = 0;
            while ($rowEsper = mysql_fetch_array($sqlEsper)) {
                $NumEsperimento = $rowEsper['num_prova_tot'];
            }
            $NumEsperimento = $NumEsperimento + 1;


            //Ricavo dal POST le quantita di materie prime da controllare
            $NMatPri = 1;
            $messaggioQtaMatPri = "";
            //Variabile utile per controllare che venga salvata almeno una materia prima
            $numMatDaSalvare = 0;
            while ($rowMatPrime = mysql_fetch_array($sqlMatPrime)) {

                //Memorizzo nelle rispettive variabili le qta di materia_prime
                $QuantitaMatPrima = $_POST['Qta' . $NMatPri];

                //Controllo input qta materie prime
                if (!is_numeric($QuantitaMatPrima)) {
                    $NumErroreMt++;
                    $messaggioQtaMatPri = $messaggioQtaMatPri . " " . $rowMatPrime['descri_materia'] . " : " . $msgErrQtaNumerica . "<br/>";
                }
                if ($QuantitaMatPrima < 0) {
                    $NumErroreMt++;
                    $messaggioQtaMatPri = $messaggioQtaMatPri . " " . $rowMatPrime['descri_materia'] . " : " . $msgErrQtaMagZero . "<br/>";
                }

                ///######## AGGIUNTO 04-12-2014 ################################
                if (is_numeric($QuantitaMatPrima) && $QuantitaMatPrima != "" && isset($QuantitaMatPrima)) {
                    $numMatDaSalvare = $numMatDaSalvare + 1;
                }
                //##############################################################

                $NMatPri++;
            }// End While finite le materie prime 

            if ($NumErroreMt > 0) {
                $messaggioQtaMatPri = $messaggioQtaMatPri . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                echo '<div id="msgErr">' . $messaggioQtaMatPri . '</div>';
            } else {

                ////////////////////////Vado avanti non ci sono errori sulle qta di componenti
                //Ricavo tramite POST le qta di componenti da controllare
                $NComp = 1;
                $messaggioQtaComp = "";

                while ($rowComp = mysql_fetch_array($sqlComp)) {

                    //Memorizzo nelle rispettive variabili le quantita di Comp
                    $QuantitaComp = $_POST['QtaComp' . $NComp];

                    //Controllo input quantita materie prime
                    if (!is_numeric($QuantitaComp)) {
                        $NumErroreComp++;
                        $messaggioQtaComp = $messaggioQtaComp . " " . $rowComp['descri_materia'] . " : " . $msgErrQtaNumerica . "<br/>";
                    }
                    if ($QuantitaComp < 0) {
                        $NumErroreComp++;
                        $messaggioQtaComp = $messaggioQtaComp . " " . $rowComp['descri_materia'] . " : " . $msgErrQtaMagZero . "<br/>";
                    }
                    ///######## AGGIUNTO 04-12-2014 ################################
                    if (is_numeric($QuantitaComp) && $QuantitaComp != "" && isset($QuantitaComp)) {
                        $numMatDaSalvare = $numMatDaSalvare + 1;
                    }
                    //##############################################################
                    $NComp++;
                }// End While finite i componenti
                
                //Se non ci sono materie prime da salvare viene segnalato un errore
                if($numMatDaSalvare==0 || (mysql_num_rows($sqlMatPrime)==0 && mysql_num_rows($sqlComp)==0)){
                    $NumErroreComp++;
                    $messaggioQtaComp = $messaggioQtaComp . "NON RISULTA NESSUNA MATERIA PRIMA DA SALVARE!!<br/>";
                }
                
                if ($NumErroreComp > 0) {
                    $messaggioQtaComp = $messaggioQtaComp . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                    echo '<div id="msgErr">' . $messaggioQtaComp . '</div>';
                } else {

                    ////////Verifico l'input dei parametri
                    //Recupero la quantita' dei parametri di tipo PercentualeSI relativa alla formula
                    $NParAc = 1;
                    $messaggioAcqua = "";

                    while ($rowParAc = mysql_fetch_array($sqlParAc)) {
                        //Memorizzo nelle rispettive variabili la quantit� di acqua
                        $QtaAc = $_POST['QtaAc' . $NParAc];

                        //Controllo input qta
                        if (!is_numeric($QtaAc) && $QtaAc != "") {

                            $NumErroreAcqua++;
                            $messaggioAcqua = $messaggioAcqua . " " . $rowParAc['descri_parametro'] . " : " . $msgErrQtaNumerica . "<br/>";
                        }
                        if ($QtaAc < 0) {
                            $NumErroreAcqua++;
                            $messaggioAcqua = $messaggioAcqua . " " . $rowParAc['descri_parametro'] . " : " . $msgErrQtaMagZero . "<br/>";
                        }
                        $NParAc++;
                    }//End While ACQUA

                    if ($NumErroreAcqua > 0) {

                        $messaggioAcqua = $messaggioAcqua . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                        echo '<div id="msgErr">' . $messaggioAcqua . '</div>';
                    } else {


                        //Recupero i valori dei parametri di tipo PercentualeNO tramite POST relativi alla formula 

                        $NPar = 1;
                        $messaggioPar = "";
                        while ($rowPar = mysql_fetch_array($sqlPar)) {
                            //Memorizzo nelle rispettive variabili le quantita di materia_prime
                            $Valore = $_POST['Valore' . $NPar];

                            //Controllo input valori
                            if (!is_numeric($Valore) && $Valore != "") {
                                $NumErrorePar++;
                                $messaggioPar = $messaggioPar . " " . $rowPar['descri_parametro'] . " : " . $msgErrQtaNumerica . "<br/>";
                            }
                            if ($Valore < 0) {
                                $NumErrorePar++;
                                $messaggioPar = $messaggioPar . " " . $rowPar['descri_parametro'] . " : " . $msgErrQtaMagZero . "<br/>";
                            }

                            $NPar++;
                        }//End While parametri

                        if ($NumErrorePar > 0) {
                            $messaggioPar = $messaggioPar . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                            echo '<div id="msgErr">' . $messaggioPar . '</div>';
                        } else {
                            $erroreTransazione = false;
                            $insertEsp = true;
                            $insertRisMat = true;
                            $insertRisComp = true;
                            $svuotaPeso = true;
                            ///////////Se sono arrivata fin qui vuol dire che non si sono 
                            //verificati errori di nessun genere quindi posso salvare			

                            begin();

                            $insertEsp = insertNewEsperimento($CodiceFormula, $Tipo, $NumEsperimento, $CodiceBarre, dataCorrenteInserimento(), OraAttuale(), $_SESSION['id_utente'], $IdAzienda);

                            //Estraggo l'id del nuovo esperimento
                            $sqlEsper = findMaxIdEsperimentoByCod($CodiceFormula);
                            $rowEsper = mysql_fetch_array($sqlEsper);
                            $IdEsperimento = $rowEsper['id_esperimento'];

                            // 2 . Salvo nella tabella lab_risultato_matpri									
                            //Estraggo le qta delle materie prime arrivate tramite POST
                            $NMatPri = 1;
                            mysql_data_seek($sqlMatPrime, 0);
                            while ($rowMatPrime = mysql_fetch_array($sqlMatPrime)) {

                                //Memorizzo nelle rispettive variabili le quantita di materia_prime
                                $QuantitaMatPrima = $_POST['Qta' . $NMatPri];
                                $SalvaQtaMatPrima = false;

                                //Controllo input quantita materie prime
                                if (!isset($QuantitaMatPrima)) {
                                    $SalvaQtaMatPrima = false;
                                }

                                if (is_numeric($QuantitaMatPrima) && $QuantitaMatPrima != "" && isset($QuantitaMatPrima)) {
                                    $SalvaQtaMatPrima = true;
                                }

                                if ($SalvaQtaMatPrima == true) {
                                    $insertRisMat = insertRisultatoMatPri($IdEsperimento, $rowMatPrime['id'], $QuantitaMatPrima, dataCorrenteInserimento(), OraAttuale());
                                }
                                if (!$insertRisMat)
                                    $erroreTransazione = true;
                                $NMatPri++;
                            }// End While finite le materie prime 
                            //Estraggo le quantit� di componenti arrivate tramite POST
                            $NComp = 1;
                            mysql_data_seek($sqlComp, 0);
                            while ($rowComp = mysql_fetch_array($sqlComp)) {

                                //Memorizzo nelle rispettive variabili le quantit� di materia_prime
                                $QuantitaComp = $_POST['QtaComp' . $NComp];
                                $SalvaQtaComp = false;

                                //Controllo input quantit� materie prime
                                if (!isset($QuantitaComp)) {
                                    $SalvaQtaComp = false;
                                }

                                if (is_numeric($QuantitaComp) && $QuantitaComp != "" && isset($QuantitaComp)) {
                                    $SalvaQtaComp = true;
                                }

                                if ($SalvaQtaComp == true) {
                                    $insertRisComp = insertRisultatoMatPri($IdEsperimento, $rowComp['id'], $QuantitaComp, dataCorrenteInserimento(), OraAttuale());
                                }
                                if (!$insertRisComp)
                                    $erroreTransazione = true;
                                $NComp++;
                            }// End While finiti i componenti
                            //3	.	Carico Acqua e parametri
                            //Carico l'ACQUA
                            $NParAc = 1;
                            mysql_data_seek($sqlParAc, 0);
                            while ($rowParAc = mysql_fetch_array($sqlParAc)) {

                                //Memorizzo nelle rispettive variabili le quantit� di materia_prime
                                $QtaAc = $_POST['QtaAc' . $NParAc];
                                $SalvaQtaAc = false;

                                //Controllo input quantit� materie prime
                                if (!isset($QtaAc)) {
                                    $SalvaQtaAc = false;
                                }
                                if (is_numeric($QtaAc) && $QtaAc != "" && isset($QtaAc)) {
                                    $SalvaQtaAc = true;
                                }
                                if ($SalvaQtaAc == true) {
                                    $insertRisParAc = insertRisultatoPar($rowParAc['id'], $IdEsperimento, $QtaAc, dataCorrenteInserimento(), OraAttuale());
                                }
                                if (!$insertRisParAc)
                                    $erroreTransazione = true;
                                $NParAc++;
                            }//End While parametri 
                            //Carico i valori dei parametri arrivati dal POST
                            $NPar = 1;
                            mysql_data_seek($sqlPar, 0);
                            while ($rowPar = mysql_fetch_array($sqlPar)) {

                                //Memorizzo nelle rispettive variabili le qta di materia_prime
                                $Valore = $_POST['Valore' . $NPar];
                                $SalvaValore = false;

                                //Controllo input qta materie prime
                                if (!isset($Valore)) {
                                    $SalvaValore = false;
                                }
                                if (is_numeric($Valore) && $Valore != "" && isset($Valore)) {
                                    $SalvaValore = true;
                                }
                                if ($SalvaValore == true) {
                                    $insertRisPar = insertRisultatoPar($rowPar['id'], $IdEsperimento, $Valore, dataCorrenteInserimento(), OraAttuale());
                                }
                                if (!$insertRisPar)
                                    $erroreTransazione = true;
                                $NPar++;
                            }//End While parametri 
//								
                            //#########################################################################
                            //######### PULIZIA TABELLE DEL PESO ######################################
                            //#########################################################################
                            //Svuoto la tabella [lab_peso] 
                            $svuotaPeso = deleteLabPeso($_SESSION['lab_macchina']);

                            if ($erroreTransazione OR !$insertEsp OR !$svuotaPeso) {

                                rollback();
                                echo "</br>" . $msgTransazioneFallita;
                            } else {

                                commit();
                                echo $msgInserimentoCompletato . ' <a href="gestione_lab_esperimenti.php">' . $msgOk . '</a>';
                            }
                        }//End if errore acqua
                    }//End if NumErrorePar relativo ai valori dei parametri
                }//End if errore componenti
            }//End if NumErroreMt relativo alle materie prime
            ?>
        </div>
    </body>
</html>