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
            include('../include/precisione.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('sql/script.php');
            include('sql/script_lab_esperimento.php');
            include('sql/script_lab_risultato_car.php');
            include('sql/script_lab_risultato_matpri.php');
            include('sql/script_lab_risultato_par.php');
            include('sql/script_lab_allegato.php');
            include('oggetti/Risultato.php');

            if ($DEBUG)
                ini_set("display_errors", 1);

            $CodiceFormula = $_POST['CodiceFormula'];
            $NumEsperimento = $_POST['TotEsperimenti'];

            //#################### Gestione degli errori #######################
            //Inizializzo l'errore relativo ai campi della tabella lab_formula
            $errore = false;
            $messaggio = '';
            //Verifico se è stata selezionata una prova principale da salvare
            if (!isset($_POST['Prova'])) {
                $errore = true;
                $messaggio = $messaggio . '' . $mgsLabErrSelectEspPrinc . '!<br />';
            }
            //Verifico se è stato scelto almeno un esperimento per il merge
            if (!isset($_POST['ProvaMerge'])) {
                $errore = true;
                $messaggio = $messaggio . '  ' . $mgsLabErrSelectEspMerge . '!<br />';
            }
            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
            //########### GENERAZIONE DEL CODICE DEL NUOVO ESP MERGE ###########
            //Il nuovo esperimento merge non avrà un codice a barre ma un codice alfanumerico
            //con prefisso M-codice
            $sqlEsisteCod = true;
            $sqlCod = generaCodice($lenghtCodMerge);
            $rowCod = mysql_fetch_array($sqlCod);

//          CODICE ESPERIMENTO MERGE  
            $Codice = $preCodEspMerge . $rowCod['codice'];
            $sqlEsisteCod = verificaEsistenzaCodice($Codice);
            //Se nella tabella è presente un'altro esperimento con lo stesso codice, 
            //viene generato un nuovo codice finchè non risulta 
            //diverso da tutti quelli già salvati
            while (mysql_num_rows($sqlEsisteCod) > 0) {
                $sqlCod = generaCodice();
                $rowCod = mysql_fetch_array($sqlCod);
                $Codice = $preCodEspMerge . $rowCod['codice'];
                $sqlEsisteCod = verificaEsistenzaCodice($Codice);
            }

            //TO DO : sarà possibile creare diversi esperimenti merge... ma bisogna 
            //trovare il modo di tenere traccia degli esperimenti considerati.

            if ($errore) {
                //Ci sono errori quindi non salvo
                $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                echo $messaggio;
            } else {

                //Recupero l'esperimento principale da cui prendere le qta di materie prime
                //e salvarle come esperimento merge
                $IdEspPrincipale = 0;
//                echo "</br>ESPERIMENTO PRINCIPALE: " . 
                $IdEspPrincipale = $_POST['Prova'];

                //Creo un array contenente l'elenco degli id degli esperimenti 
                //di cui fare il merge
                $k = 0;
                $arrayProveMerge = array();
                foreach ($_POST['ProvaMerge'] as $key => $value) {

                    $arrayProveMerge[$k][1] = $value;
                    $k++;
                }

                //##############################################################
                //################## SALVATAGGIO QTA ESPERIMENTO ###############
                //##############################################################
                $insertNewEsp = true;
                $insertMarPri = true;
                $insertPar = true;
                $inserRisCar = true;
                $insertRisCarTxt = true;
                $insertAllegato = true;
                $erroreTransazione = false;
                begin();
                if ($errore == false) {

                    //############ SALVO L'ESPERIMENTO #########################
                    $insertNewEsp = insertNewEsperimento($CodiceFormula, $valTipoLabMerge, $NumEsperimento, $Codice, dataCorrenteInserimento(), OraAttuale(), $_SESSION['id_utente'], $IdAzienda);

                    //Estraggo l'id del nuovo esperimento
                    $sqlEsper = findIdEsperimentoByCod($Codice);
                    $rowEsper = mysql_fetch_array($sqlEsper);
                    $IdEsperimento = $rowEsper['id_esperimento'];

                    // 2 . ############## MATERIE PRIME ########################
                    $sqlMatPrime = findMatEsperimentoById($IdEspPrincipale, "id_mat");
                    while ($rowMatPrime = mysql_fetch_array($sqlMatPrime)) {
                        // Salvo le quantita nella tabella lab_risultato_matpri	
                        $insertMarPri = insertRisultatoMatPri($IdEsperimento, $rowMatPrime['id_mat'], $rowMatPrime['qta_reale'], dataCorrenteInserimento(), OraAttuale());

                        if (!$insertMarPri) {
                            $erroreTransazione = true;
                        }
                    }// End While finite le materie prime e componenti
                    //3	.###### PARAMETRI ######################################

                    $sqlParAc = findRisParByIdEsp($IdEspPrincipale);
                    while ($rowParAc = mysql_fetch_array($sqlParAc)) {

                        // Salvo la quantita di acqua nella tabella lab_risultato_par	
                        $insertPar = insertRisultatoPar($rowParAc['id_par'], $IdEsperimento, $rowParAc['valore_reale'], dataCorrenteInserimento(), OraAttuale());
                        if (!$insertPar)
                            $erroreTransazione = true;
                    }//End While parametri 
                    //##############################################################
                    //#########  MERGE RISULTATI ###################################
                    //##############################################################
                    //Recupero l'elenco delle caratteristiche definite in tutte le prove
                    //prese una sola volta
                    //############## PER OGNI CARATTERISTICA ############################
                    $sqlCarFormula = findAllCarUnionFormula($arrayProveMerge);
                    $numCar = 0;
                    $countRisTxt = 0;

                    while ($rowListaCar = mysql_fetch_array($sqlCarFormula)) {

                        echo "</br>CARATTERISTICA: " . $rowListaCar['caratteristica'] . " (" . $rowListaCar['id_carat'] . ") tipo: " . $rowListaCar['tipo_dato'] . "</br>";

                        $objRisNum = array();
                        $objMergeTxt = array();
                        $objMergeNum = array();
                        //############## PER OGNI ESPERIMENTO ###############################
                        //Numero totale di risultati numerici per una singola caratteristica
                        $countRisNum = 0;

                        for ($j = 0; $j < count($arrayProveMerge); $j++) {

                            //############## PER OGNI VALORE REGISTRATO #####################
                            $sqlRisCar = findRisultatoSingolaCarByIdEspIdCar($arrayProveMerge[$j][1], $rowListaCar['id_carat']);
                            while ($rowRisCar = mysql_fetch_array($sqlRisCar)) {

//                              Seleziono tutti gli allegati alla caratteristica corrente 
//                              e li inserisco nel nuovo esperimento merge 
                                $sqlAllegati = findAllegatiByIdRifCar($arrayProveMerge[$j][1], $rowListaCar['id_carat'], $valRifEsperimento, "lab_caratteristica");
                                while ($rowAll = mysql_fetch_array($sqlAllegati)) {
                                    $insertAllegato = inserisciNuovoAllegato($rowAll['id_carat'], $IdEsperimento, $rowAll['descri'], $rowAll['link'], $rowAll['tipo_rif'], str_replace("'", "''", $rowAll['note']));
                                    if (!$insertAllegato)
                                        $erroreTransazione = true;
                                }


                                if ($rowListaCar['tipo_dato'] == $valCarNum) {

                                    $objRisNum[$countRisNum] = new Risultato($arrayProveMerge[$j][1], $rowListaCar['id_carat'], $rowRisCar['valore_caratteristica'], $rowRisCar['valore_dimensione'], str_replace("'", "''", $rowRisCar['note']));
//                                    echo "<div style='background:#E1E1E1'></br>j= " . $j . " numRis=" . $countRisNum .
//                                    " " . $objRisNum [$countRisNum]->getIdEsperimento() .
//                                    " " . $objRisNum [$countRisNum]->getIdCaratteristica() .
//                                    " " . $objRisNum [$countRisNum]->getValoreCar() .
//                                    " " . $objRisNum [$countRisNum]->getValoreDim() .
//                                    " " . $objRisNum [$countRisNum]->getNote() . "</div>";

                                    $countRisNum++;
                                }
                            }//End valori risultati caratteristica 
                        } //End esperimenti   
//#################### RISULTATI NUMERICI ##########################
                        for ($y = 0; $y < $countRisNum; $y++) {

                            if ($objRisNum[$y]->getValoreDim() != '') {

                                $num = 1; //denominatore media
                                $totVal = $objRisNum[$y]->getValoreCar(); //numeratore media

                                for ($z = $y + 1; $z < $countRisNum; $z++) {

                                    if ($objRisNum[$y]->getValoreDim() == $objRisNum [$z]->getValoreDim()) {

                                        $totVal = $totVal + $objRisNum[$z]->getValoreCar();
                                        $num = $num + 1;

                                        $objRisNum[$z]->setValoreDim('');
                                    }
                                }
                                $mediaVal = number_format($totVal / $num, $PrecisioneQtaRis, '.', '');


                                $objMergeNum[$y] = new Risultato(
                                        $objRisNum [$y]->getIdEsperimento(), $objRisNum [$y]->getIdCaratteristica(), $mediaVal, $objRisNum [$y]->getValoreDim(), $objRisNum[$y]->getNote());

//                                echo "<div style='background:#F9F6E5'></br>y= " . $y . " "
//                                . $objMergeNum [$y]->getIdEsperimento() . " "
//                                . $objMergeNum [$y]->getIdCaratteristica() . " "
//                                . $objMergeNum [$y]->getValoreCar() . " "
//                                . $objMergeNum [$y]->getValoreDim() . " "
//                                . $objMergeNum [$y]->getNote() . "</div>";

                                $inserRisCar = inserisciCaratteristicaProva(
                                        $IdEsperimento, $objMergeNum [$y]->getIdCaratteristica(), $objMergeNum [$y]->getValoreCar(), $objMergeNum [$y]->getValoreDim(), $objMergeNum[$y]->getNote());

                                if (!$inserRisCar)
                                    $erroreTransazione = true;
                            }
                        }
//#################### RISULTATI TESTO ###########################


                        if ($rowListaCar['tipo_dato'] == $valCarTxt) {


                            if (isSet($_POST['RisTxt' . $countRisTxt])) {

                                echo 'countRisTxt' . $countRisTxt;
                                $carTxtScelte = $_POST['RisTxt' . $countRisTxt];
                                
                                print_r($_POST['RisTxt' . $countRisTxt]);
                                $numCarScelte = count($carTxtScelte);

                                for ($i = 0; $i < $numCarScelte; $i++) {
                                    $IdEsper = "";
                                    $IdCarat = "";
                                    $ValoreCar = "";
                                    $Note = "";
                                    $strindValoreTxt = "";
                                    $stringValoreNote = "";
                                    list($IdEsper[$i], $IdCarat[$i], $ValoreCar[$i], $Note[$i]) = explode(";", $carTxtScelte[$i]);


                                    echo "</br>i: ".$i." - hai selezionato la caratteristica: " . $IdCarat[$i] . " con valore:" . $ValoreCar[$i] . "</br>";
                                    
                                    $strindValoreTxt = $strindValoreTxt . "  " . $ValoreCar[$i];
                                    $stringValoreNote = $stringValoreNote . "  " . $Note[$i];


                                    //NB:
                                    //In questo modo se vengono selezionati più valori 
                                    //per la stessa caratteristica relativi ad esperimenti diversi
                                    //vengono salvate come caratteristiche diverse ovvero come record diversi
                                    //Si potrebbe anche costruire una unica stringa e salvarla come unica caratteristica dell'esperimento

                                    $objMergeTxt = new Risultato($IdEsper[$i], $IdCarat[$i], $strindValoreTxt, 0, $stringValoreNote);
                                    echo "<div style='background:#CCFF99'></br>k= " . $countRisTxt .
                                    " " . $objMergeTxt->getIdEsperimento() .
                                    " " . $objMergeTxt->getIdCaratteristica() .
                                    " " . $objMergeTxt->getValoreCar() .
                                    " " . $objMergeTxt->getValoreDim() .
                                    " " . $objMergeTxt->getNote() . "</div>";

                                    $insertRisCarTxt = inserisciCaratteristicaProva(
                                            $IdEsperimento, $objMergeTxt->getIdCaratteristica(), $objMergeTxt->getValoreCar(), $objMergeTxt->getValoreDim(), $objMergeTxt->getNote());
                                    if (!$insertRisCarTxt)
                                        $erroreTransazione = true;
                                }
                                $countRisTxt++;
                            }
                        }


                        $numCar++;
                    }



                    if ($erroreTransazione OR ! $insertNewEsp) {

                        rollback();
                        echo "</br>" . $msgTransazioneFallita;
                    } else {

                        commit();
                        echo $msgLabMergeCompletato . ' <a href="dettaglio_lab_formula_prove.php?CodLabFormula=' . $CodiceFormula . '">' . $msgOk . '</a>';
                    }
                }//End if nessun  errore
            }//End if ($errore) 
            ?>
            </table>
        </div>
    </body>
</html>