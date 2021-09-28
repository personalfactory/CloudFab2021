<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript">
        function disabilitaOperazioni() {
            
                document.getElementById('Duplica').style.display = "none";
            
            for (i = 0; i < document.getElementsByName('ModificaMat').length; i++) {
                document.getElementsByName('ModificaMat')[i].style.display = "none";
            }
        }
    </script>
            <?php
           
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('./sql/script_lab_formula.php');
            include('./sql/script_lab_esperimento.php');
            include('./sql/script_lab_matpri_teoria.php');
            include('./sql/script_lab_parametro_teoria.php');
            include('./sql/script.php');

            $Pagina = "dettaglio_lab_formula";

            $CodLabFormula = $_GET['CodLabFormula'];
            //QUERY AL DB
            begin();
            $sqlFormula = findFormulaByCodice($CodLabFormula);
            $sqlProva = selectMaxNumEsperimento($CodLabFormula);
            $sqlListaProve = selectEsperimentiByFormula($CodLabFormula);
            $sqlMtPr = findMatCompFormulaByCodice($CodLabFormula);
            $sqlMatPrime = findMatPriFormulaByCodice($CodLabFormula);
            $sqlComp = findCompFormulaByCodice($CodLabFormula);
            $sqlPar = findParFormulaByCodice($CodLabFormula);
            commit();

            //####################### ANAGRAFE FORMULA #########################
            while ($rowFormula = mysql_fetch_array($sqlFormula)) {
                $CodiceFormula = $rowFormula['cod_lab_formula'];
                $DataFormula = $rowFormula['dt_lab_formula'];
                $ProdOb = $rowFormula['prod_ob'];
                $Normativa = $rowFormula['normativa'];
                $Utente = $rowFormula['utente'];
                $GruppoLavoro = $rowFormula['gruppo_lavoro'];
                $IdUtenteProp = $rowFormula['id_utente'];
                $IdAzienda = $rowFormula['id_azienda'];
            }
            $NomeAzienda = getNomeAziendaById($_SESSION['objUtility'], $IdAzienda);
            //######################################################################
            //#################### GESTIONE UTENTI #################################
            //######################################################################            
            //Si recupera il proprietario della prove e si verifica se l'utente 
            //corrente ha il permesso di editare  i dati di quell'utente proprietario 
            //nelle tabelle lab_formula
            //Se non ha il permesso bisogna disabilitare i pulsanti di salvataggio...
            //############# VERIFICA PERMESSO DI SCRITTURA E MODIFICA ##############
            $actionOnLoad = "";
            $arrayTabelleCoinvolte = array("lab_formula");
            if ($IdUtenteProp != $_SESSION['id_utente']) {

                //Se il proprietario del dato è un utente diverso dall'utente 
                //corrente si verifica il permesso 3
                if ($DEBUG)
                    echo "</br>Eseguita verifica permesso di tipo 3";
                $actionOnLoad = $actionOnLoad . verificaPermModifica3($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte, $IdUtenteProp, $IdAzienda);
            }
            //####################### NUM PROVE EFFETTUATE #####################         
            while ($rowProva = mysql_fetch_array($sqlProva)) {
                $TotEsperimenti = $rowProva['num_prova_tot'];
            }

            //####################### TOTALE QTA E COSTI #######################
            //Inizializzo le variabili numeriche
            $TotaleQta = 0;
            $CostoTotale = 0;
            //La variabile seguente serve per calcolare 
            //subito il totale ai fini del calcolo della percentuale 
            //Alla fine di tutti i cicli coincide con la variabile precedente
            $CostoPercentuale = 0;
            $CostoTotalePerc = 0;

            $TotalePercentuale = 0;
            $CostoTotalePercentuale = 0;

            //Calcolo il totale delle quantita e del costo di materie prime e componenti
            //per poter calcolare il valore ed il costo percentuale di ogni singola qta 
            $NMtPr = 1;
            while ($rowMtPr = mysql_fetch_array($sqlMtPr)) {
                //Serve per il calcolo delle quantita in percentuale
                $TotaleQta = $TotaleQta + $rowMtPr['qta_teo'];
                //Serve per il calcolo del costo in percentuale
                $CostoTotalePerc = $CostoTotalePerc + ($rowMtPr['qta_teo'] * $rowMtPr['prezzo']);

                $NMtPr++;
            }//End while totale quantita
            ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
<?php include('../include/menu.php'); ?>
            <div id="container" style="width:95%; margin:15px auto;">
                <form id="ModificaFormula" name="ModificaFormula" method="GET" action="duplica_lab_formula.php">
                    <table width="100%" >
                        <th colspan="2" class="cella3"><?php echo $titoloLabFormula ?></th>

                        <input type="hidden" name="DataFormula" id="DataFormula" value="<?php echo $DataFormula; ?>"></input>
                        <input type="hidden" name="CodiceFormulaOld" id="CodiceFormulaOld" value="<?php echo $CodiceFormula; ?>"></input>
                        <tr>
                            <td class="cella4" width="250px"><?php echo $filtroLabProdottoObiet ?></td>
                            <td class="cella1"><?php echo $ProdOb; ?></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroLabNorma ?></td>
                            <td class="cella1"><?php echo $Normativa; ?></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroLabCodice ?></td>
                            <td class="cella1"><?php echo $CodiceFormula; ?></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroLabData ?></td>
                            <td class="cella1"><?php echo $DataFormula; ?></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroLabUtente ?></td>
                            <td class="cella1"><?php echo $Utente; ?></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroLabGruppo ?></td>
                            <td class="cella1"><?php echo $GruppoLavoro; ?></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroLabEsperimentiFatti ?></td>
                            <td class="cella1"><?php echo $TotEsperimenti; ?></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroAzienda ?></td>
                            <td class="cella1"><?php echo $NomeAzienda; ?></td>
                        </tr>
                    </table>  
                    <!--############################################################-->
                    <!--############### MATERIE PRIME ##############################-->
                    <!--############################################################-->
                    <table width="100%">
                        <tr>
                            <th class="cella3" colspan="2"><?php echo $filtroLabMatPrimeChimica ?></th>
                            <td class="cella3"><?php echo $filtroLabUnMisura ?></td>
                            <td class="cella3"><?php echo $filtroLabCostoUnit ?></td>
                            <td class="cella3"><?php echo $filtroLabQta ?> </td>           
                            <td class="cella3"><?php echo $filtroLabCosto ?></td>
                            <td class="cella3"><?php echo $filtroLabQta . " " . $filtroLabPerc ?> </td>
                            <td class="cella3"><?php echo $filtroLabCosto . " " . $filtroLabPerc ?></td>
                        </tr> 
                        <?php
                        $NMatPri = 1;
                        while ($rowMatPrime = mysql_fetch_array($sqlMatPrime)) {
                            $QuantitaMatPrima = $rowMatPrime['qta_teo'];
                            $CostoUnitario = $rowMatPrime['prezzo'];
                            $CostoGrammi = $rowMatPrime['prezzo'] / $fatConvKgGrammi;

                            $CostoPerQta = $rowMatPrime['qta_teo'] * $CostoGrammi;
                            $CostoTotale = $CostoTotale + $CostoPerQta;

                            //Trasformo le qta in percentuale
                            $QuantitaPercentuale = ($rowMatPrime['qta_teo'] * 100) / $TotaleQta;
                            $TotalePercentuale = $TotalePercentuale + $QuantitaPercentuale;
                            //Trasformo i costi in percentuale
                            if ($CostoTotalePerc > 0) {
                                $CostoPercentuale = ($CostoPerQta * 100) / $CostoTotalePerc;
                            }
                            $CostoTotalePercentuale = $CostoTotalePercentuale + $CostoPercentuale;
                            ?>
                            <tr>
                                <td class="cella4">
                                    <a name="ModificaMat" target="blank" href="modifica_lab_materia.php?IdMateria=<?php echo($rowMatPrime['id_mat']) ?>&Pagina=<?php echo $Pagina; ?>">
                                        <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleLabInsNota ?>"/></a></td>
                                <td class="cella4"><?php echo $rowMatPrime['descri_materia'] ?></td>
                                <td class="cella1"><?php echo $rowMatPrime['unita_misura']; ?></td>
                                <td class="cella1"><?php echo number_format($CostoUnitario, $PrecisioneCosti, '.', '') . " " . $filtroLabEuro; ?></td>
                                <td class="cella1"><?php echo $rowMatPrime['qta_teo'] . " " . $filtroLabGrammo ?></td>
                                <td class="cella1"><?php echo number_format($CostoPerQta, $PrecisioneCosti, '.', '') . " " . $filtroLabEuro; ?></td>
                                <td class="cella1"><?php echo number_format($QuantitaPercentuale, $PrecisioneQta, '.', '') . " " . $filtroLabPerc; ?></td>
                                <td class="cella1"><?php echo number_format($CostoPercentuale, $PrecisioneCosti, '.', '') . " " . $filtroLabPerc ?></td>
                            </tr>
                            <?php
                            $NMatPri++;
                        }//End While Materie Prima
                        ?>
                        <!--############################################################-->
                        <!--############### COMPONENTI #################################-->
                        <!--############################################################-->
                        <tr>
                            <th class="cella3" colspan="2"><?php echo $filtroLabComponente ?></th>
                            <td class="cella3"><?php echo $filtroLabUnMisura ?></td>
                            <td class="cella3"><?php echo $filtroLabCostoUnit ?></td>
                            <td class="cella3"><?php echo $filtroLabQta ?> </td>           
                            <td class="cella3"><?php echo $filtroLabCosto ?></td>
                            <td class="cella3"><?php echo $filtroLabQta . " " . $filtroLabPerc ?> </td>
                            <td class="cella3"><?php echo $filtroLabCosto . " " . $filtroLabPerc ?></td>
                        </tr> 
                        <?php
                        $NComp = 1;
                        while ($rowComp = mysql_fetch_array($sqlComp)) {
                            $QuantitaComp = $rowComp['qta_teo'];
                            $CostoUnitario = $rowComp['prezzo'];
                            $CostoGrammi = $rowComp['prezzo'] / $fatConvKgGrammi;

                            $CostoPerQta = $rowComp['qta_teo'] * $CostoGrammi;
                            $CostoTotale = $CostoTotale + $CostoPerQta;

                            //Trasformo le qta in percentuale
                            $QuantitaPercentuale = ($rowComp['qta_teo'] * 100) / $TotaleQta;
                            $TotalePercentuale = $TotalePercentuale + $QuantitaPercentuale;
                            //Trasformo i costi in percentuale
                            if ($CostoTotalePerc > 0) {
                                $CostoPercentuale = ($CostoPerQta * 100) / $CostoTotalePerc;
                            }
                            $CostoTotalePercentuale = $CostoTotalePercentuale + $CostoPercentuale;
                            ?>
                            <tr>
                                <td class="cella4">
                                    <a name="ModificaMat" href="modifica_lab_materia.php?IdMateria=<?php echo($rowComp['id_mat']) ?>&Pagina=<?php echo $Pagina; ?>">
                                        <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone"  title="<?php echo $titleLabInsNota ?>"/></a></td>
                                <td class="cella4"><?php echo $rowComp['descri_materia'] ?></td>
                                <td class="cella1"><?php echo $rowComp['unita_misura'] ?></td>
                                <td class="cella1"><?php echo number_format($CostoUnitario, $PrecisioneCosti, '.', '') . " " . $filtroLabEuro; ?></td>
                                <td class="cella1"><?php echo $rowComp['qta_teo'] . " " . $filtroLabGrammo ?></td>
                                <td class="cella1"><?php echo number_format($CostoPerQta, $PrecisioneCosti, '.', '') . " " . $filtroLabEuro; ?></td>
                                <td class="cella1"><?php echo number_format($QuantitaPercentuale, $PrecisioneQta, '.', '') . " " . $filtroLabPerc; ?></td>
                                <td class="cella1"><?php echo number_format($CostoPercentuale, $PrecisioneCosti, '.', '') . " " . $filtroLabPerc ?></td>

                            </tr>
                            <?php
                            $NComp++;
                        }//End While Componenti
                        ?>
                        <!--############################################################-->
                        <!--############### TOTALI QTA E COSTI #########################-->
                        <!--############################################################-->
                        <tr>
                            <td width="100px" class="cella2" colspan="4"><?php echo $filtroLabTotale ?></td>
                            <td width="100px" class="cella2"><?php echo number_format($TotaleQta, $PrecisioneQta, '.', '') . " " . $filtroLabGrammo ?></td>
                            <td width="70px"  class="cella2"><?php echo number_format($CostoTotale, $PrecisioneCosti, '.', '') . " " . $filtroLabEuro ?></td>
                            <td width="100px" class="cella2"><?php echo number_format($TotalePercentuale, $PrecisioneQta, '.', '') . " " . $filtroLabPerc ?></td>
                            <td width="100px" class="cella2"><?php echo number_format($CostoTotalePercentuale, $PrecisioneCosti, '.', '') . " " . $filtroLabPerc ?></td>
                        </tr>	
                    </table>
                    <!--############################################################-->
                    <!--######################### PARAMETRI ########################-->
                    <!--############################################################-->
                    <table width="100%"> 
                        <tr>
                            <th class="cella3"><?php echo $filtroLabParametri ?></th>
                            <td class="cella3"><?php echo $filtroLabUnMisura ?></td>
                            <td class="cella3"><?php echo $filtroLabValore ?></td>
                        </tr> 
                        <?php
                        $NPar = 1;
                        while ($rowPar = mysql_fetch_array($sqlPar)) {
                            if ($rowPar['tipo'] == $PercentualeSI
                            ) {
                                ?>
                                <tr>
                                    <td class="cella4"><?php echo($rowPar['nome_parametro']); ?></td>
                                    <td class="cella1"><?php echo ($rowPar['unita_misura']); ?></td>
                                    <td class="cella1"><?php echo ($rowPar['valore_teo']) . " " . $filtroLabPerc ?></td>
                                </tr>
                            <?php } else {
                                ?>
                                <tr>
                                    <td class="cella4"><?php echo($rowPar['nome_parametro']); ?></td>
                                    <td class="cella1"><?php echo ($rowPar['unita_misura']); ?></td>
                                    <td class="cella1"><?php echo ($rowPar['valore_teo']); ?></td>
                                </tr>
                                <?php
                            }
                            $NPar++;
                        }//End While parametri 
                        //############################################################
                        //########################## ESPERIMENTI FATTI ###############
                        //############################################################
                        if ($TotEsperimenti > 0) {
                            ?>
                            <table width="100%">                        
                                <th colspan="4" class="cella3"><?php echo $filtroLabEsperimentiFatti ?></th>
                                <tr> 
                                    <td class="cella4"><?php echo $filtroLabNumProva ?></td>
                                    <td class="cella4"><?php echo $filtroLabCodBarre ?></td>
                                    <td class="cella4"><?php echo $filtroLabData ?> </td>           
                                    <td class="cella4"><?php echo $filtroLabOra ?></td>
                                </tr>
                                <?php
                                while ($rowListaProve = mysql_fetch_array($sqlListaProve)) {
                                    ?>
                                    <tr> 
                                        <td class="cella1"><?php echo $rowListaProve['num_prova'] ?></td>
                                        <td class="cella1"><a target="blank" href="modifica_lab_risultati.php?IdEsperimento=<?php echo $rowListaProve['id_esperimento'] ?>"><?php echo $rowListaProve['cod_barre'] ?></a></td>
                                        <td class="cella1"><?php echo $rowListaProve['dt_prova'] ?> </td>           
                                        <td class="cella1"><?php echo $rowListaProve['ora_prova'] ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            <tr>
                                <td class="cella2" style="text-align: right " colspan="4">
                                    <input type="reset"  onClick="javascript:history.back();" value="<?php echo $valueButtonAnnulla ?>"/>
                                    <input id="Duplica" type="submit" value="<?php echo $valueButtonDuplica ?>" />
                                </td>
                            </tr>
                        </table>
                </form>
            </div>
        </div><!--mainContainer-->
    </body>
</html>














