<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <script language="javascript">
                function Carica() {
                    document.forms["CaricaFormulaDaEsperimento"].action = "carica_lab_formula_da_prova2.php";
                    document.forms["CaricaFormulaDaEsperimento"].submit();
                }
                function AggiornaCalcoli() {
                    document.forms["CaricaFormulaDaEsperimento"].action = "carica_lab_formula_da_prova.php";
                    document.forms["CaricaFormulaDaEsperimento"].submit();
                }
            </script>
            <?php
            
            ///////////////// DA SISTEMARE !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            //Bisognerebbe fare in modo che dall'esperimento calcolasse le quantità 
            //di ogni materia prima in percentuale su 100 kg.
            
            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('sql/script.php');
            include('sql/script_lab_risultato_matpri.php');
            include('sql/script_lab_risultato_par.php');
            include('sql/script_lab_formula.php');
            include('sql/script_lab_esperimento.php');

            $Pagina = "carica_lab_formula_da_prova";


//##############################################################################
////////////////////////////// INIZIO CARICAMENTO  /////////////////////////////
//##############################################################################
//Se il codice formula non e' stato settato allora viene visualizzato il form di
// inserimento con il codice vuoto 
            if (!isset($_POST['CodiceFormula']) || $_POST['CodiceFormula'] == "" & isset($_POST['IdEsperimento'])) {

                $IdEsperimento = str_replace("'", "''", $_POST['IdEsperimento']);

                $CodFormulaOld = str_replace("'", "''", $_POST['CodiceFormulaOld']);


                //################ QUERY AL DB ############################################
                begin();
                $sqlForm = findFormulaByCodice($CodFormulaOld);
                $sqlMatPrime = findMatPriByEsperUnionAll($IdEsperimento);
                $sqlComp = findCompByEsperUnionAll($IdEsperimento);
                $sqlParAc = findRisParByIdEspTipoUnionAll($IdEsperimento, $PercentualeSI);
                $sqlPar = findRisParByIdEspTipoUnionAll($IdEsperimento, $PercentualeNO);
                commit();

                while ($rowForm = mysql_fetch_array($sqlForm)) {

                    $Normativa = $rowForm['normativa'];
                    $ProdOb = $rowForm['prod_ob'];
                }
                ?>
                <div id="container" style="width:80%; margin:15px auto;">
                    <form id="CaricaFormulaDaEsperimento" name="CaricaFormulaDaEsperimento" method="post">
                        <table width="100%" >
                            <tr>
                                <th  colspan="2" class="cella3"><?php echo $titoloPaginaCreaFormulaDaProva ?></th>
                            </tr>
                            <input type="hidden" name="IdEsperimento" id="IdEsperimento" value="<?php echo $IdEsperimento; ?>"/>
                            <tr>
                                <td width="300" class="cella4"><?php echo $filtroLabNorma ?></td>
                                <td class="cella1"><?php echo $Normativa ?></td>
                                <input type="hidden" name="Normativa" id="Normativa" value="<?php echo $Normativa; ?>"/>
                            </tr> 
                            <tr>
                                <td width="300" class="cella4"><?php echo $filtroLabProdottoObiet ?></td>
                                <td class="cella1"><?php echo $ProdOb ?></td>
                                <input type="hidden" name="ProdOb" id="ProdOb" value="<?php echo $ProdOb; ?>"/>
                            </tr> 
                           
                            <tr>
                                <td class="cella4" width="300px"><?php echo $filtroCodice ?></td>
                                <td class="cella1"><input type="text" name="CodiceFormula" id="CodiceFormula" maxlenght="5"/></td>
                            </tr>
                            <tr>
                                <td class="cella4" width="300px"><?php echo $filtroUtente ?></td>
                                <td class="cella1"><?php echo $_SESSION['username'] ?></td>
                            </tr>
                            <tr>
                                <td class="cella4" width="300px"><?php echo $filtroGruppo ?></td>
                                <td class="cella1"><?php echo $_SESSION['nome_gruppo_utente'] ?></td>
                            </tr>
                             <tr>
                                <td class="cella4" width="300px"><?php echo $filtroDt ?></td>
                                <td class="cella1"><?php echo dataCorrenteVisualizza() ?></td>
                            </tr>
                        </table>
                        <!--###########################################################################-->
                        <!--################################ MATERIE PRIME ############################-->
                        <!--###########################################################################-->
                        <table width="100%" >
                            <tr>
                                <th class="cella3" width="300px"><?php echo $filtroMaterieCompound ?></th>
                                <td class="cella3"><?php echo $filtroUniMisura ?></td>
                                <td class="cella3"><?php echo $filtroCostoUn ?></td>
                                <td class="cella3"><?php echo $filtroQuantita ?> </td>
                                <td class="cella3" title="<?php echo $titleLabCampoVar ?>"><?php echo $filtroLabVariabile ?></td>
                                <td class="cella3"></td>
                            </tr>
                            <?php
                            //Visualizzo l'elenco materie prime presenti 
                            //nella tabella lab_risultato_matpri relative alla prova
                            $NMatPri = 1;
                            while ($rowMatPrime = mysql_fetch_array($sqlMatPrime)) {

                                $CostoUnitarioMt = number_format($rowMatPrime['prezzo'], $PrecisioneCosti, '.', '');
                                ?>
                                <tr>
                                    <td class="cella4"><?php echo $rowMatPrime['descri_materia'] ?></td>
                                    <td class="cella1"><?php echo $rowMatPrime['unita_misura'] ?></td>
                                    <td class="cella1"><?php echo $CostoUnitarioMt . " " . $filtroEuro; ?></td>
                                    <td class="cella1"><input type="text" size="10px" name="QtaMt<?php echo($NMatPri); ?>" id="QtaMt<?php echo($NMatPri); ?>" value="<?php echo $rowMatPrime['qta_reale']; ?>" /><?php echo $filtrogBreve ?> </td>
                                    <td class="cella1" title="<?php echo $titleLabCampoVar ?>"><input type="checkbox" id="MatKeVaria<?php echo($NMatPri); ?>" name="MatKeVaria<?php echo($NMatPri); ?>"  value="Y"/></td>
                                    <td class="cella1" width="40">
                                        <a href="modifica_lab_materia.php?IdMateria=<?php echo $rowMatPrime['id_mat'] ?>&Pagina=<?php echo $Pagina; ?>"> 
                                            <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica ?>"/>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                $NMatPri++;
                            }//End While materie prime 
                            //###########################################################################
                            //################################ COMPONENTI ###############################
                            //###########################################################################
                            ?>
                            <tr>
                                <th class="cella3" width="300"><?php echo $filtroMaterieDrymix ?></th>
                                <td class="cella3"><?php echo $filtroUniMisura ?></td>
                                <td class="cella3"><?php echo $filtroCostoUn ?></td>
                                <td class="cella3"><?php echo $filtroQuantita ?> </td>
                                <td class="cella3" title="<?php echo $titleLabCampoVar ?>"><?php echo $filtroLabVariabile ?></td>
                                <td class="cella3"></td>
                            </tr>
                            <?php
                            //Visualizzo l'elenco dei componenti presenti nella tabella 
                            //lab_risultato_matpri relativi alla prova
                            $NComp = 1;
                            while ($rowComp = mysql_fetch_array($sqlComp)) {
                                $CostoUnitarioComp = number_format($rowComp['prezzo'], $PrecisioneCosti, '.', '');
                                ?>
                                <tr>
                                    <td class="cella4"><?php echo($rowComp['descri_materia']) ?></td>
                                    <td class="cella2"><?php echo($rowComp['unita_misura']) ?></td>
                                    <td class="cella1" ><?php echo $CostoUnitarioComp . " " . $filtroEuro ?></td>
                                    <td class="cella1"><input type="text" size="15px" name="QtaComp<?php echo($NComp); ?>" id="QtaComp<?php echo($NComp); ?>" value="<?php echo $rowComp['qta_reale']; ?>"  /><?php echo $filtrogBreve ?></td>
                                    <td class="cella1" title="<?php echo $titleLabCampoVar ?>"><input type="checkbox" id="CompKeVaria<?php echo($NComp); ?>" name="CompKeVaria<?php echo($NComp); ?>" value="Y"/></td>
                                    <td class="cella1"><a href="modifica_lab_materia.php?IdMateria=<?php echo($rowComp['id_mat']) ?>&Pagina=<?php echo $Pagina; ?>"> 
                                            <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica ?>"/></a></td>
                                </tr>
                                <?php
                                $NComp++;
                            }//End While componenti prodotto 
                            ?>
                        </table>
                        <!--#################################################################################################-->
                        <!--################################ PARAMETRI ######################################################-->
                        <!--#################################################################################################-->
                        <table width="100%" >
                            <tr>
                                <td class="cella3"><?php echo $filtroLabParametro ?> </td>
                                <td class="cella3"><?php echo $filtroLabUnMisura ?></td>
                                <td class="cella3"><?php echo $filtroLabValore ?></td>
                            </tr>
                            <?php
                            //Visualizzo i parametri Acqua calda e Acqua fredda 
                            //presenti nella tabella lab_risultato_par associati 
                            //alla prova con input text per il valore
                            $NParAc = 1;
                            while ($rowParAc = mysql_fetch_array($sqlParAc)) {
                                ?>
                                <tr>
                                    <td class="cella4"><?php echo($rowParAc['nome_parametro']); ?></td>
                                    <td class="cella4"><?php echo ($rowParAc['unita_misura']); ?> </td>
                                    <td class="cella1"><input type="text" name="QtaTeo<?php echo($NParAc); ?>" id="QtaTeo<?php echo($NParAc); ?>" value="<?php echo ($rowParAc['valore_reale']); ?>" /></td>
                                </tr>
                                <?php
                                $NParAc++;
                            }//End While parametri ACQUA
                            //Visualizzo l'elenco dei parametri presenti nella tabella lab_parametro 
                            //diversi dall'Acqua associati alla prova
                            $NPar = 1;
                            while ($rowPar = mysql_fetch_array($sqlPar)) {
                                ?>
                                <tr>
                                    <td class="cella4"><?php echo($rowPar['nome_parametro']); ?></td>
                                    <td class="cella4"><?php echo ($rowPar['unita_misura']); ?></td>
                                    <td class="cella1"><input type="text" name="QtaPar<?php echo($NPar); ?>" id="QtaPar<?php echo($NPar); ?>" value="<?php echo ($rowPar['valore_reale']); ?>" /></td>
                                </tr>
                                <?php
                                $NPar++;
                            }//End While parametri 
                            ?>
                            <tr>
                                <td class="cella2" style="text-align: right " colspan="3">
                                    <input type="reset"  onClick="javascript:history.back();" value="<?php echo $valueButtonAnnulla ?>">
                                        <input type="button" onclick="javascript:AggiornaCalcoli();" value="<?php echo $valueButtonVerifica ?>" />
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <?php
            } else {

//###########################################################################
//####################### AGGIORNAMENTO PAGINA  ############################
//###########################################################################
//Se il codice formula e' settato allora viene ricaricata la pagina
                //Inizializzo l'errore relativo ai campi della tabella lab_formula
                $errore = false;
                $messaggio = '';

                //Ricavo il valore dei campi arrivati tramite POST
                //il CodiceFormulaOld è il codice relativo alla formula di partenza dell'esperimento
                //che è diverso dal codice formula nuovo con cui si deve salvare la formula
                //$CodiceFormulaOld = str_replace("'","''",$_POST['CodiceFormulaOld']);
                $IdEsperimento = str_replace("'", "''", $_POST['IdEsperimento']);
                $CodiceFormula = str_replace("'", "''", $_POST['CodiceFormula']);
                $Normativa = str_replace("'", "''", $_POST['Normativa']);
                $ProdOb = str_replace("'", "''", $_POST['ProdOb']);

                if (!isset($CodiceFormula) || trim($CodiceFormula) == "") {

                    $errore = true;
                    $messaggio = $messaggio . ' - Campo Codice Formula non valido!<br />';
                }
                if (!isset($IdEsperimento) || trim($IdEsperimento) == "") {

                    $errore = true;
                    $messaggio = $messaggio . ' - Campo IdEsperimento non valido!<br />';
                }

                //Verifica esistenza codice formula durante l'aggiornamento 
                //Verifico che non ci sia una formula con lo stesso codice per l'utente corrente			
                $result = verificaEsistenzaFormula($CodiceFormula);

                if (mysql_num_rows($result) != 0) {
                    //Se entro nell'if vuol dire che il valore inserito esiste gi� nel db
                    $errore = true;
                    $messaggio = $messaggio . ' - Il codice formula digitato � gi� presente nel database!<br />';
                }
                if ($errore) {
                    //Ci sono errori quindi non salvo
                    $messaggio = $messaggio . '<a href="javascript:history.back()">Ricontrollare i dati</a>';
                    echo '<div id="msg">' . $messaggio . '</div>';
                } else {



                    $sqlEsperimento = selectMaxNumEsperimento($CodiceFormula);
                    while ($rowEsperimento = mysql_fetch_array($sqlEsperimento)) {
                        $NumeroEsperimento = $rowEsperimento['num_prova_tot'] + 1;
                    }

                    //########### QHUERY AL DB #################################
                    begin();
                    $sqlMtPr = findMatPriByEsperUnionAll($IdEsperimento);
                    $sqlComponente = findCompByEsperUnionAll($IdEsperimento);
                    $sqlParamAc = findRisParByIdEspTipoUnionAll($IdEsperimento, $PercentualeSI);
                    $sqlParam = findRisParByIdEspTipoUnionAll($IdEsperimento, $PercentualeNO);
                    commit();


                    //######################################################################
                    //################## CALCOLO DEI COSTI #################################
                    //######################################################################
//Inizializzo le variabili numeriche

                    $TotaleQtaMt = 0;
                    $CostoTotaleMt = 0;

                    $TotaleQtaComp = 0;
                    $CostoTotaleComp = 0;

                    $TotaleQta = 0;
                    $CostoTotale = 0;

                    //La variabile seguente serve per calcolare subito il totale ai fini del calcolo della percentuale ma alla fine di tutti i  cicli coincide con la variabile precedente
                    $CostoTotalePercMt = 0;
                    $TotalePercentualeMt = 0;

                    $CostoTotalePercentualeMt = 0;

                    $CostoTotalePercComp = 0;
                    $TotalePercentualeComp = 0;

                    $CostoTotalePercentualeComp = 0;

                    $CostoTotalePerc = 0;
                    $TotalePercentuale = 0;

                    $CostoTotalePercentuale = 0;

                    //Calcolo il totale delle quantita e del costo per poter calcolare 
                    //il valore ed il costo percentuale di ogni singola qta inserita
                    $NMtPr = 1;
                    while ($rowMatPrime = mysql_fetch_array($sqlMtPr)) {

                        if (isset($_POST['QtaMt' . $NMtPr]) && $_POST['QtaMt' . $NMtPr] != "") {

                            //Serve per il calcolo delle quantita in percentuale
                            $TotaleQtaMt = $TotaleQtaMt + $_POST['QtaMt' . $NMtPr];

                            //Serve per il calcolo del costo in percentuale
                            $CostoTotalePercMt = $CostoTotalePercMt + ($_POST['QtaMt' . $NMtPr] * ($rowMatPrime['prezzo']) / 1000);
                        }

                        $NMtPr++;
                    }//End while totale quantita
                    //Calcolo il totale delle quantita e del costo per poter calcolare il 
                    //valore ed il costo percentuale di ogni singola qta inserita
                    $NComponente = 1;
                    while ($rowComponente = mysql_fetch_array($sqlComponente)) {
                        if (isset($_POST['QtaComp' . $NComponente]) && $_POST['QtaComp' . $NComponente] != "") {

                            //Serve per il calcolo delle quantitA in percentuale
                            $TotaleQtaComp = $TotaleQtaComp + $_POST['QtaComp' . $NComponente];

                            //Serve per il calcolo del costo in percentuale
                            $CostoTotalePercComp = $CostoTotalePercComp + ($_POST['QtaComp' . $NComponente] * ($rowComponente['prezzo']) / 100000);
                        }
                        $NComponente++;
                    }//End while totale quantita
                    //Totali di Materie prime + componenti prodotto		
                    $TotaleQta = $TotaleQtaMt + $TotaleQtaComp;
                    $CostoTotalePerc = $CostoTotalePercMt + $CostoTotalePercComp;
                    $CostoTotale = $CostoTotalePercMt + $CostoTotalePercComp;
                    ?>

                    <div id="container" style="width:90%; margin:15px auto;">
                        <form id="CaricaFormulaDaEsperimento" name="CaricaFormulaDaEsperimento" method="post" >
                            <table width="100%" >
                                <tr>
                                    <td height="42" colspan="6" class="cella3"><?php echo $titoloPaginaCreaFormulaDaProva ?></td>
                                </tr>
                                <input type="hidden" name="IdEsperimento" id="IdEsperimento" value="<?php echo $IdEsperimento; ?>"/>
                                <!--##########################################################################################-->
                                <!--######################### ANAGRAFE DELLA FORMULA #########################################-->
                                <!--##########################################################################################-->
                                <tr>
                                    <td width="300" class="cella4"><?php echo $filtroLabNorma ?></td>
                                    <td class="cella1"><?php echo $Normativa ?></td>
                                    <input type="hidden" name="Normativa" id="Normativa" value="<?php echo $Normativa; ?>"/>
                                </tr> 
                                <tr>
                                    <td width="300" class="cella4"><?php echo $filtroLabProdottoObiet ?></td>
                                    <td class="cella1"><?php echo $ProdOb ?></td>
                                    <input type="hidden" name="ProdOb" id="ProdOb" value="<?php echo $ProdOb; ?>"/>
                                </tr> 
                               
                                <input type="hidden" name="NumeroEsperimento" id="NumeroEsperimento" value="<?php echo $NumeroEsperimento; ?>"/>
                                <tr>
                                    <td width="300px" class="cella4"><?php echo $filtroCodice ?></td>
                                    <td class="cella1"><input type="text" name="CodiceFormula" id="CodiceFormula" value="<?php echo $CodiceFormula; ?>"/></td>
                                </tr>
                                <tr>
                                    <td class="cella4"><?php echo $filtroUtente ?></td>
                                    <td class="cella1"><?php echo $_SESSION['username'] ?></td>
                                </tr>
                                <tr>
                                    <td class="cella4"><?php echo $filtroGruppo ?></td>
                                    <td class="cella1"><?php echo $_SESSION['nome_gruppo_utente'] ?></td>
                                </tr>
                                 <tr>
                                    <td class="cella4"><?php echo $filtroDt ?></td>
                                    <td class="cella1"><?php echo dataCorrenteVisualizza() ?></td>
                                </tr>
                            </table>
                            <!--############################################################################################################-->
                            <!--######################### MATERIE PRIME ####################################################################-->
                            <!--############################################################################################################-->
                            <table width="100%">
                                <tr>
                                    <th class="cella3" width="300px"><?php echo $filtroMaterieCompound ?></th>
                                    <td class="cella3"><?php echo $filtroUniMisura ?></td>
                                    <td class="cella3"><?php echo $filtroLabCostoUnit ?></td>
                                    <td class="cella3"><?php echo $filtroQuantita ?></td>
                                    <td class="cella3"><?php echo $filtroLabCosto ?> </td>
                                    <td class="cella3"><?php echo $filtroLabQta . " " . $filtroLabPerc ?></td>
                                    <td class="cella3"><?php echo $filtroLabCosto . " " . $filtroLabPerc ?></td>
                                    <td class="cella3" width="40"><?php echo $filtroLabVariabile ?></td>
                                    <td class="cella3" width="30"></td>
                                </tr>
        <?php
        //Visualizzo l'elenco delle materie associate all'esperimento e
        // quelle presenti nella tabella [lab_materia_prima]
        $NMatPri = 1;
        mysql_data_seek($sqlMtPr, 0);
        while ($rowMatPrime = mysql_fetch_array($sqlMtPr)) {

            $QuantitaMatPrima = $_POST['QtaMt' . $NMatPri];
            $CostoUnitarioMt = $rowMatPrime['prezzo'];
            $CostoGrammiMt = $rowMatPrime['prezzo'] / 1000;
            ?>
                                    <tr>
                                        <td class="cella4"><?php echo($rowMatPrime['descri_materia']) ?></td>
                                        <td class="cella1"><?php echo($rowMatPrime['unita_misura']) ?></td>
            <?php
            if (isset($_POST['QtaMt' . $NMatPri]) || $_POST['MatKeVaria' . $NMatPri] == "Y") {

                $CostoQuintaleMt = $_POST['QtaMt' . $NMatPri] * $CostoGrammiMt;
                $CostoTotaleMt = $CostoTotaleMt + $CostoQuintaleMt;

                //Trasformo le qta in percentuale
                $QuantitaPercentualeMt = ($_POST['QtaMt' . $NMatPri] * 100) / $TotaleQta;
                $TotalePercentuale = $TotalePercentuale + $QuantitaPercentualeMt;

                //Trasformo i costi in percentuale
                $CostoPercentualeMt = ($CostoQuintaleMt * 100) / $CostoTotalePerc;
                $CostoTotalePercentuale = $CostoTotalePercentuale + $CostoPercentualeMt;
                ?>
                                            <td class="cella1"><?php echo number_format($CostoUnitarioMt, $PrecisioneCosti, '.', '') . " " . $filtroLabEuro ?></td>
                                            <td class="cella1"><input type="text" style="width: 70px;"name="QtaMt<?php echo($NMatPri); ?>" id="QtaMt<?php echo($NMatPri); ?>" value="<?php echo $_POST['QtaMt' . $NMatPri]; ?>"/><?php echo $filtroLabGrammo ?></td>
                                            <td class="cella1"><?php echo number_format($CostoQuintaleMt, $PrecisioneCosti, '.', '') . " " . $filtroLabEuro ?> </td>
                                            <td class="cella1"><?php echo number_format($QuantitaPercentualeMt, $PrecisioneQta, '.', '') . " " . $filtroLabPerc ?></td>
                                            <input type="hidden" style="width: 70px;"name="QtaPercMt<?php echo($NMatPri); ?>" id="QtaPercMt<?php echo($NMatPri); ?>" value="<?php echo $QuantitaPercentualeMt; ?>"/>
                                            <!--<?php echo number_format($QuantitaPercentualeMt, $PrecisioneQta, '.', ''); ?> -->
                                            <td class="cella1" width="65"><?php echo number_format($CostoPercentualeMt, $PrecisioneCosti, '.', '') . " " . $filtroLabPerc ?> </td>
                <?php
                if (isset($_POST['MatKeVaria' . $NMatPri])) {
                    $MatKeVaria = $_POST['MatKeVaria' . $NMatPri]
                    ?>
                                                <td class="cella1" width="64"><input type="checkbox" id="MatKeVaria<?php echo($NMatPri); ?>" name="MatKeVaria<?php echo($NMatPri); ?>" value="<?php echo $_POST['MatKeVaria' . $NMatPri]; ?>" checked="checked"/></td>
                                            <?php } else { ?>
                                                <td class="cella1" ><input type="checkbox" id="MatKeVaria<?php echo($NMatPri); ?>" name="MatKeVaria<?php echo($NMatPri); ?>" value="Y" /></td>
                                            <?php } ?>
                                            <td class="cella1"><a href="modifica_lab_materia.php?IdMateria=<?php echo($rowMatPrime['id_mat']) ?>&Pagina=<?php echo $Pagina; ?>">
                                                    <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="Modifica" title="Inserisci nota"/></a></td>
                                        </tr>
                <?php
            }//End if

            if (!isset($_POST['QtaMt' . $NMatPri])) {
                ?>
                                        <td class="cella1" ><?php echo number_format($CostoUnitarioMt, $PrecisioneCosti, '.', '') . " " . $filtroLabEuro ?></td>
                                        <td class="cella1"><input type="text" style="width: 70px;"name="QtaMt<?php echo($NMatPri); ?>" id="QtaMt<?php echo($NMatPri); ?>" value="0"/>
                <?php echo $filtroLabGrammo ?></td>
                                        <td class="cella1" ><?php echo "0" . $filtroLabEuro ?></td>
                                        <td class="cella1" width="108"><?php echo "0" . $filtroLabEuro ?></td>
                                        <td class="cella1" width="51"><?php echo "0" . $filtroLabEuro ?></td>
                                        </tr>
                <?php
            }//End if			

            $NMatPri++;
        }//End While Materie Prima
        ?>

                                <!--#############################################################################################################-->
                                <!--######################### COMPONENTI PRODOTTO ###############################################################-->
                                <!--#############################################################################################################-->
                                <tr>
                                    <th class="cella3"><?php echo $filtroMaterieDrymix ?></th>
                                    <td class="cella3"><?php echo $filtroUniMisura ?></td>
                                    <td class="cella3"><?php echo $filtroCostoUn ?></td>
                                    <td class="cella3"><?php echo $filtroQuantita ?></td>
                                    <td class="cella3"><?php echo $filtroLabCosto ?> </td>
                                    <td class="cella3"><?php echo $filtroLabQta . " " . $filtroLabPerc ?></td>
                                    <td class="cella3"><?php echo $filtroLabCosto . " " . $filtroLabPerc ?></td>
                                    <td class="cella3" width="40"><?php echo $filtroLabVariabile ?></td>
                                    <td class="cella3" width="30"></td>
                                </tr>
        <?php
        //Visualizzo l'elenco dei componenti associati all'esperimento e poi 
        //quelli presenti nella tabella [lab_materia_prima]
        $NComp = 1;
        mysql_data_seek($sqlComponente, 0);
        while ($rowComp = mysql_fetch_array($sqlComponente)) {

            $QuantitaComp = $_POST['QtaComp' . $NComp];
            $CostoUnitarioComp = $rowComp['prezzo'];
            $CostoGrammiComp = $rowComp['prezzo'] / 100000;
            ?>
                                    <tr>
                                        <td class="cella4"><?php echo($rowComp['descri_materia']) ?></td>
                                        <td class="cella1"><?php echo($rowComp['unita_misura']) ?></td>
            <?php
            if (isset($_POST['QtaComp' . $NComp])) {
                $CostoQuintaleComp = $_POST['QtaComp' . $NComp] * $CostoGrammiComp;
                $CostoTotaleComp = $CostoTotaleComp + $CostoQuintaleComp;

                //Trasformo le qta in percentuale
                $QuantitaPercentualeComp = ($_POST['QtaComp' . $NComp] * 100) / $TotaleQta;
                $TotalePercentuale = $TotalePercentuale + $QuantitaPercentualeComp;

                //Trasformo i costi in percentuale
                $CostoPercentualeComp = ($CostoQuintaleComp * 100) / $CostoTotalePerc;
                $CostoTotalePercentuale = $CostoTotalePercentuale + $CostoPercentualeComp;
                ?>
                                            <td class="cella1" ><?php echo number_format($CostoUnitarioComp, $PrecisioneCosti, '.', '') . " " . $filtroLabEuro ?></td>
                                            <td class="cella1"><input type="text" style="width: 70px;"name="QtaComp<?php echo($NComp); ?>" id="QtaComp<?php echo($NComp); ?>" value="<?php echo $_POST['QtaComp' . $NComp]; ?>"/><?php echo $filtroLabGrammo ?></td>
                                            <td class="cella1" ><?php echo number_format($CostoQuintaleComp, $PrecisioneCosti, '.', '') . " " . $filtroLabEuro ?></td>
                                            <td class="cella1" ><?php echo number_format($QuantitaPercentualeComp, $PrecisioneQta, '.', '') . " " . $filtroLabPerc ?> </td>
                                            <input type="hidden" style="width: 70px;"name="QtaPercComp<?php echo($NComp); ?>" id="QtaPercComp<?php echo($NComp); ?>" value="<?php echo $QuantitaPercentualeComp; ?>"/>
                                    <!--value="<?php echo number_format($QuantitaPercentualeComp, $PrecisioneQta, '.', ''); ?>"-->
                                            <td class="cella1" ><?php echo number_format($CostoPercentualeComp, $PrecisioneCosti, '.', '') . " " . $filtroLabPerc ?></td>
                <?php
                if (isset($_POST['CompKeVaria' . $NComp])) {
                    $CompKeVaria = $_POST['CompKeVaria' . $NComp];
                    ?>
                                                <td class="cella1" width="64"><input type="checkbox" id="MatKeVaria<?php echo($NComp); ?>" name="CompKeVaria<?php echo($NComp); ?>" value="<?php echo $_POST['CompKeVaria' . $NComp]; ?>" checked="checked"/></td>
                                            <?php } else {
                                                ?>
                                                <td class="cella1" ><input type="checkbox" id="CompKeVaria<?php echo($NComp); ?>" name="CompKeVaria<?php echo($NComp); ?>" value="Y" /></td>
                                            <?php }
                                            ?>
                                            <td class="cella1"><a href="modifica_lab_materia.php?IdMateria=<?php echo($rowComp['id_mat']) ?>&Pagina=<?php echo $Pagina; ?>"> 
                                                    <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="Modifica" title="Inserisci nota"/></a></td>
                                        </tr>
                <?php
            }//End if

            if (!isset($_POST['QtaComp' . $NComp])) {
                ?>
                                        <td class="cella1"><?php echo number_format($CostoUnitarioComp, $PrecisioneCosti, '.', '') . " " . $filtroLabEuro ?></td>
                                        <td class="cella1"><input type="text" style="width: 70px;"name="QtaComp<?php echo($NComp); ?>" id="QtaComp<?php echo($NComp); ?>" value="0"/><?php echo $filtroLabGrammo ?></td>
                                        <td class="cella1"><?php echo "0" . $filtroLabEuro ?></td>
                                        <td class="cella1"><?php echo "0" . $filtroLabEuro ?></td>
                                        <td class="cella1"><?php echo "0" . $filtroLabEuro ?></td>
                                        </tr>
                <?php
            }//End if			

            $NComp++;
        }//End While Componenti
        ?>
                                <tr>
                                    <td class="cella2" colspan="3"><?php echo $filtroLabTotale ?></td>
                                    <td class="cella2"><?php echo number_format($TotaleQta, $PrecisioneQta, '.', '') . " " . $filtroLabGrammo ?></td>
                                    <td class="cella2"><?php echo number_format($CostoTotale, $PrecisioneCosti, '.', '') . " " . $filtroLabEuro ?></td>
                                    <td class="cella2"><?php echo number_format($TotalePercentuale, $PrecisioneQta, '.', '') . " " . $filtroLabPerc ?></td>
                                    <td class="cella2"><?php echo number_format($CostoTotalePercentuale, $PrecisioneCosti, '.', '') . " " . $filtroLabPerc ?></td>
                                    <td class="cella2" colspan="2"></td>
                                </tr>
                            </table>
                            <!----------Fine componenti------------------------------------------------------------------------------------------>

                            <!--####################################################################-->
                            <!--######################### PARAMETRI ################################-->
                            <!--####################################################################-->
                            <table width="100%">
                                <tr>
                                    <td class="cella3"><?php echo $filtroLabParametro ?></td>
                                    <td class="cella3"><?php echo $filtroLabUnMisura ?></td>
                                    <td class="cella3"><?php echo $filtroLabQta ?></td>
                                    <td class="cella3"><?php echo $filtroLabQta . " " . $filtroLabPerc ?></td>
                                </tr>
        <?php
        //Visualizzo i parametri acqua calda e acqua fredda presenti nella tabella lab_parametro
        $NParAc = 1;
        while ($rowParAc = mysql_fetch_array($sqlParamAc)) {
            //Calcolo la percentuale e mando direttamente il risultato al post
            $QtaAcNew = number_format(($_POST['QtaTeo' . $NParAc] * 100) / $TotaleQta, $PrecisioneQta, '.', '');
            ?>
                                    <tr>
                                        <td class="cella4"><?php echo($rowParAc['nome_parametro']); ?></td>
                                        <td class="cella1" ><?php echo ($rowParAc['unita_misura']); ?> </td>
                                        <td class="cella1"><input type="text" name="QtaTeo<?php echo($NParAc); ?>" id="QtaTeo<?php echo($NParAc); ?>" value="<?php echo $_POST['QtaTeo' . $NParAc]; ?>" /></td>
                                        <td class="cella1"><input type="text" name="QtaPercAc<?php echo($NParAc); ?>" id="QtaPercAc<?php echo($NParAc); ?>" value="<?php echo $QtaAcNew; ?>" /></td>
                                    </tr>
            <?php
            $NParAc++;
        }//End While parametri ACQUA
        //Visualizzo l'elenco dei parametri  presenti nella tabella lab_parametro esclusa l'acqua
        $NPar = 1;
        while ($rowPar = mysql_fetch_array($sqlParam)) {
            ?>
                                    <tr>
                                        <td class="cella4"><?php echo($rowPar['nome_parametro']); ?></td>
                                        <td class="cella1" ><?php echo ($rowPar['unita_misura']); ?> </td>
                                        <td class="cella1"><input type="text" name="QtaPar<?php echo($NPar); ?>" id="QtaPar<?php echo($NPar); ?>" value="<?php echo $_POST['QtaPar' . $NPar]; ?>" /></td>
                                        <td class="cella1"></td>
                                    </tr>
            <?php
            $NPar++;
        }//End While parametri 
        ?>
                                <tr>
                                    <td class="cella2" style="text-align: right " colspan="4">
                                        <input type="reset"  onClick="javascript:history.back();" value="<?php echo $valueButtonAnnulla ?>" />
                                        <input type="button" onclick="javascript:AggiornaCalcoli();" value="<?php echo $valueButtonVerifica ?>" />
                                        <input type="button" onclick="javascript:Carica();" value="<?php echo $valueButtonSalva ?>" />
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>

        <?php
    }//End if errore sull'aggiornamento
}//End Aggiornamento
?>

        </div>
        <!--mainContainer-->
    </body>
</html>
