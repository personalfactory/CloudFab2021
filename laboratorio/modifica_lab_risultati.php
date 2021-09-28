<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <?php
    include('../include/gestione_date.php');
    include('../Connessioni/serverdb.php');
    include('sql/script.php');
    include('sql/script_lab_esperimento.php');
    include('sql/script_lab_risultato_matpri.php');
    include('sql/script_lab_risultato_par.php');
    include('sql/script_lab_risultato_car.php');
    include('sql/script_lab_allegato.php');
    include('../include/precisione.php');
    ?>
    <!--############ FUNZIONI JAVASCRIPT ############################-->
    <script language="javascript">
        function Salva() {
            document.forms["ModificaRisultato"].action = "modifica_lab_risultati2.php";
            document.forms["ModificaRisultato"].submit();
        }
        function GeneraFormula(idEsperimento, codFormula) {
            document.forms["ModificaRisultato"].action = "carica_lab_formula_da_prova.php?IdEsperimento=" + idEsperimento + "&CodiceFormulaOld=" + codFormula;
            document.forms["ModificaRisultato"].submit();
        }
        function disabilitaOperazioni() {

            document.getElementById('AggiungiCar').disabled = true;
            document.getElementById('SalvaRisultati').disabled = true;
            for (i = 0; i < document.getElementsByName('EliminaCaratteristica').length; i++) {
                document.getElementsByName('EliminaCaratteristica')[i].style.display = "none";
            }
        }
    </script>

    <?php
    $IdEsperimento = $_GET['IdEsperimento'];
    //##################################################################
    //############## QUERY AL DB #######################################
    //##################################################################
    begin();
    $sqlEsperimento = findProdTargetByEsperimento($IdEsperimento);
    $sqlTotQtaReale = findQtaEsperimento($IdEsperimento);
    $sqlMatPri = findMatPrimeByIdEsperimento($IdEsperimento);
    $sqlComp = findComponentiByIdEsperimento($IdEsperimento);
    $sqlTotReale = findRisultatiParByIdEspAndTipo($IdEsperimento, $PercentualeSI);
    $sqlPar = findRisultatiParByIdEsperimento($IdEsperimento);
    $sqlCar = findRisultatoCarByIdEsperimento($IdEsperimento);
    $sqlCarAll = findAllegatiCarByIdRif($IdEsperimento, $valRifEsperimento);
    commit();

//##############################################################################
//############################# ANAGRAFE ESPERIMENTO ###########################
//##############################################################################


    while ($rowEsper = mysql_fetch_array($sqlEsperimento)) {

        $CodiceFormula = $rowEsper['cod_lab_formula'];
        $CodiceBarre = $rowEsper['cod_barre'];
        $NumeroProva = $rowEsper['num_prova'];
        $DataProva = $rowEsper['dt_prova'];
        $OraProva = $rowEsper['ora_prova'];
        $Normativa = $rowEsper['normativa'];
        $ProdOb = $rowEsper['prod_ob'];
        $Tipo = $rowEsper['tipo'];
        $IdAzienda = $rowEsper['azienda'];
        $IdUtenteProp = $rowEsper['utente'];
    }
    $NomeAzienda = getNomeAziendaById($_SESSION['objUtility'], $IdAzienda);

    //######################################################################
    //#################### GESTIONE UTENTI #################################
    //######################################################################            
    //Si recupera il proprietario della prove e si verifica se l'utente 
    //corrente ha il permesso di editare  i dati di quell'utente proprietario 
    //nelle tabelle lab_esperimento
    //Se non ha il permesso bisogna disabilitare i pulsanti di salvataggio...
    //############# VERIFICA PERMESSO DI SCRITTURA E MODIFICA ##############
    $actionOnLoad = "";
    $arrayTabelleCoinvolte = array("lab_esperimento");
    if ($IdUtenteProp != $_SESSION['id_utente']) {

        //Se il proprietario del dato è un utente diverso dall'utente 
        //corrente si verifica il permesso 3
        if ($DEBUG)
            echo "</br>Eseguita verifica permesso di tipo 3";
        $actionOnLoad = $actionOnLoad . verificaPermModifica3($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte, $IdUtenteProp, $IdAzienda);
    }

    //######################################################################
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php include('../include/menu.php'); ?>
            <div id="container" style="width:100%; margin:15px auto;">
                <form id="ModificaRisultato" name="ModificaRisultato" method="post" >
                    <input type="hidden" name="IdEsperimento" id="IdEsperimento" value="<?php echo $IdEsperimento; ?>"/>
                    <table width="100%">
                        <tr>
                            <th class="cella3" colspan="2"><?php echo $titoloPaginaLabRisultatiProva ?></th>
                        </tr>
                        <tr>
                            <td width="300" class="cella4"><?php echo $filtroLabTipo ?></td>
                            <td class="cella1"><?php echo $Tipo ?></td>
                        </tr> 
                        <tr>
                            <td width="300" class="cella4"><?php echo $filtroLabNorma ?></td>
                            <td class="cella1"><?php echo $Normativa ?></td>
                        </tr> 
                        <tr>
                            <td width="300" class="cella4"><?php echo $filtroLabProdottoObiet ?></td>
                            <td class="cella1"><?php echo $ProdOb ?></td>
                        </tr> 

                        <tr>
                            <td class="cella4"><?php echo $filtroLabCodFormula ?></td>
                            <td class="cella1"><?php echo $CodiceFormula; ?></td>
                            <!--############## Campi utili per la creazione della formula a partire dall'esperimento #####################-->
                            <input type="hidden" name="CodiceFormulaOld" id="CodiceFormulaOld" value="<?php echo $CodiceFormula; ?>"/>
                        </tr>
                        <tr >
                            <td class="cella4" width="300px"><?php echo $filtroLabCodBarre ?></td>
                            <td class="cella1"><?php echo $CodiceBarre; ?></td>
                        </tr>
                        <tr> 
                            <td class="cella4" ><?php echo $filtroLabNumProva ?></td>
                            <td class="cella1"><?php echo $NumeroProva; ?></td>
                        </tr>
                        <tr>
                            <td class="cella4" ><?php echo $filtroLabData ?></td>
                            <td class="cella1"><?php echo $DataProva; ?></td>
                        </tr>
                        <tr >
                            <td class="cella4" ><?php echo $filtroLabOra ?></td>
                            <td class="cella1"><?php echo $OraProva; ?></td>
                        </tr>
                        <tr >
                            <td class="cella4" ><?php echo $filtroAzienda ?></td>
                            <td class="cella1"><?php echo $NomeAzienda; ?></td>
                        </tr>
                    </table>
                    <table width="100%">
                        <?php
//#######################################################################################
//# NB: la quantita reale dell' esperimento diventa la quantita teorica della formula ###
//#######################################################################################
                        //Inizializzo varibili di costo
                        $CostoGrammi = 0;
                        $CostoPerQta = 0;
                        $CostoTotale = 0;
                        $CostoTotalePerc = 0;
                        $CostoTotalePercentuale = 0;
                        $CostoPercentuale = 0;
                        //Inizializzo i totali
                        $QuantitaPercReale = 0;
                        $QuantitaPercTotReale = 0;
                        $QuantitaPercTot = 0;
                        $QuantitaTeoTot = 0;
                        $QuantitaRealeTot = 0;
                        $Quantita100kgTot = 0;
                        $qtaPer100Kg = 0;


                        $totQtaTeoPercCompound = 0;
                        $totQtaRealePercCompound = 0;
                        $totQtaRealeCompound = 0;
                        $totQtaPer100KgCompound = 0;
                        $totCosto100KgCompound = 0;
                        $totCostoPercCompound = 0;



                        //Calcolo il totale delle quantita' reale 
                        while ($rowTotQtaRea = mysql_fetch_array($sqlTotQtaReale)) {

                            $QuantitaRealeTot = $QuantitaRealeTot + $rowTotQtaRea['qta_reale'];
                            //Serve per il calcolo del costo in percentuale
                            $CostoTotalePerc = $CostoTotalePerc + ($rowTotQtaRea['qta_reale'] * $rowTotQtaRea['prezzo'] / $fatConvKgGrammi);
                        }




                        //##############################################################################
                        //########################### MATERIE PRIME CHIMICA ############################
                        //##############################################################################
                        if (mysql_num_rows($sqlMatPri) > 0) {
                            ?>
                            <tr>
                                <th class="cella3"><?php echo $filtroLabMtCompound ?></th>
                                <th class="cella3" title="<?php echo $titleLabCostoKgMat ?>"><?php echo $filtroLabCostoUnit ?></th>
                                <th class="cella3" title="<?php echo $titleLabQtaTeo ?>"><?php echo $filtroLabQtaPercTeorica ?></th>
                                <th class="cella3" title="<?php echo $titleLabQtaPercReale ?>"><?php echo $filtroLabQtaPercReale ?></th>
                                <th class="cella3" title="<?php echo $titleLabQtaReale ?>"><?php echo $filtroLabQtaReale ?></th>
                                <th class="cella3" title="<?php echo $titleLabQta100Kg ?>"><?php echo $filtroLabQta100Kg ?></th>
                                <th class="cella3" title="<?php echo $titleLabCosto100Kg ?>"><?php echo $filtroLabCosto100Kg ?></th>
                                <th class="cella3" title="<?php echo $titleLabCostoPerc ?>"><?php echo $filtroLabCosto . " " . $filtroLabPerc ?></th>
                            </tr>
                            <?php
                            while ($rowMatPri = mysql_fetch_array($sqlMatPri)) {
                                $DescriMateria = $rowMatPri['descri_materia'];

                                $QuantitaTeo = $rowMatPri['qta_teo'];
                                $QuantitaTeoTot = $QuantitaTeoTot + $QuantitaTeo;

                                $QuantitaPerc = $rowMatPri['qta_teo_perc']; //Quantita percentuale teorica
                                $QuantitaPercTot = $QuantitaPercTot + $QuantitaPerc; //Quantita percentuale teorica totale
                                if ($QuantitaRealeTot > 0)
                                    $QuantitaPercReale = ($rowMatPri['qta_reale'] * 100) / $QuantitaRealeTot; //Quantita percentuale reale
                                $QuantitaPercTotReale = $QuantitaPercTotReale + $QuantitaPercReale; //Quantita percentuale reale totale
                                //COSTO
                                $CostoGrammi = $rowMatPri['prezzo'] / $fatConvKgGrammi;

                                //######### QTA PER PER 100KG ########
                                if ($QuantitaRealeTot > 0)
                                    $qtaPer100Kg = (100000 * $rowMatPri['qta_reale']) / $QuantitaRealeTot;
                                $costoPerQtaPer100Kg = $qtaPer100Kg * $CostoGrammi;

                                $Quantita100kgTot = $Quantita100kgTot + $qtaPer100Kg;


                                $CostoPerQta = $rowMatPri['qta_reale'] * $CostoGrammi;
                                $CostoTotale = $CostoTotale + $costoPerQtaPer100Kg;

                                if ($CostoTotalePerc > 0) {
                                    $CostoPercentuale = ($CostoPerQta * 100) / $CostoTotalePerc;
                                }
                                $CostoTotalePercentuale = $CostoTotalePercentuale + $CostoPercentuale;
                                ?>		
                                <tr >
                                    <td class="cella4" width="300px"><?php echo $DescriMateria; ?></td>
                                    <td class="cella1" style="width:100px;text-align:right"><?php echo number_format($rowMatPri['prezzo'], $PrecisioneCosti, '.', '') . " " . $filtroLabEuro; ?></td>
                                    <td class="cella1" style="text-align:right"><?php echo number_format($QuantitaPerc, $PrecisioneQta, '.', '') . " " . $filtroLabPerc; ?></td>
                                    <td class="cella1" style="text-align:right"><?php echo number_format($QuantitaPercReale, $PrecisioneQta, '.', '') . " " . $filtroLabPerc; ?></td>
                                    <td class="cella1" style="text-align:right"><?php echo $rowMatPri['qta_reale'] . " " . $filtroLabGrammo ?></td>
                                    <td class="cella1" style="text-align:right"><?php echo number_format($qtaPer100Kg, $Prec100Kg, '.', '') . " " . $filtroLabGrammo ?></td>
                                    <td class="cella1" style="width:100px;text-align:right"><?php echo number_format($costoPerQtaPer100Kg, $Prec100Kg, '.', '') . " " . $filtroLabEuro; ?></td>
                                    <td class="cella1" style="width:100px;text-align:right"><?php echo number_format($CostoPercentuale, $PrecisioneCosti, '.', '') . " " . $filtroLabPerc; ?></td>

                                </tr>
                                <?php
                                $totQtaTeoPercCompound = $totQtaTeoPercCompound + $QuantitaPerc;
                                $totQtaRealePercCompound = $totQtaRealePercCompound + $QuantitaPercReale;
                                $totQtaRealeCompound = $totQtaRealeCompound + $rowMatPri['qta_reale'];
                                $totQtaPer100KgCompound = $totQtaPer100KgCompound + $qtaPer100Kg;
                                $totCosto100KgCompound = $totCosto100KgCompound + $costoPerQtaPer100Kg;
                                $totCostoPercCompound = $totCostoPercCompound + $CostoPercentuale;
                            }//End While materie prime   
                            ?>
                        <!--###############  TOTALI COMPOUND ###############-->

                            <tr >
                                <td class="dataRigWhite" style="width:300px;"></td>
                                <td class="dataRigWhite" style="width:100px;"></td>
                                <td class="dataRigWhite" style="text-align:right;font-size:15px"><?php echo number_format($totQtaTeoPercCompound, $PrecisioneQta, '.', '') . " " . $filtroLabPerc; ?></td>
                                <td class="dataRigWhite" style="text-align:right;font-size:15px"><?php echo number_format($totQtaRealePercCompound, $PrecisioneQta, '.', '') . " " . $filtroLabPerc; ?></td>
                                <td class="dataRigWhite" style="text-align:right;font-size:15px"><?php echo $totQtaRealeCompound . " " . $filtroLabGrammo ?></td>
                                <td class="dataRigWhite" style="text-align:right;font-size:15px"><?php echo number_format($totQtaPer100KgCompound, $Prec100Kg, '.', '') . " " . $filtroLabGrammo ?></td>
                                <td class="dataRigWhite" style="width:100px;text-align:right;font-size:15px"><?php echo number_format($totCosto100KgCompound, $Prec100Kg, '.', '') . " " . $filtroLabEuro; ?></td>
                                <td class="dataRigWhite" style="width:100px;text-align:right;font-size:15px"><?php echo number_format($totCostoPercCompound, $PrecisioneCosti, '.', '') . " " . $filtroLabPerc; ?></td>

                            </tr> 





    <?php
}
//                     ################################################################################
//                     ########################### COMPONENTI #########################################
//                     ################################################################################

$totQtaTeoPercDrymix = 0;
$totQtaRealePercDrymix = 0;
$totQtaRealeDrymix = 0;
$totQtaPer100KgDrymix = 0;
$totCosto100KgDrymix = 0;
$totCostoPercDrymix = 0;

if (mysql_num_rows($sqlComp) > 0) {
    ?>

                            <tr >
                                <th class="cella3"><?php echo $filtroLabMtDrymix ?></th>
                                <th class="cella3" title="<?php echo $titleLabCostoKgMat ?>"><?php echo $filtroLabCostoUnit ?></th>
                                <th class="cella3" title="<?php echo $titleLabQtaTeo ?>"><?php echo $filtroLabQtaPercTeorica ?></th>
                                <th class="cella3" title="<?php echo $titleLabQtaPercReale ?>"><?php echo $filtroLabQtaPercReale ?></th>
                                <th class="cella3" title="<?php echo $titleLabQtaReale ?>"><?php echo $filtroLabQtaReale ?></th>
                                <th class="cella3" title="<?php echo $titleLabQta100Kg ?>"><?php echo $filtroLabQta100Kg ?></th>
                                <th class="cella3" title="<?php echo $titleLabCosto100Kg ?>"><?php echo $filtroLabCosto100Kg ?></th>
                                <th class="cella3" title="<?php echo $titleLabCostoPerc ?>"><?php echo $filtroLabCosto . " " . $filtroLabPerc ?></th>
                            </tr>
    <?php
    while ($rowComp = mysql_fetch_array($sqlComp)) {
        $DescriComp = $rowComp['descri_materia'];

        $QuantitaTeo = $rowComp['qta_teo'];
        $QuantitaTeoTot = $QuantitaTeoTot + $QuantitaTeo;

        $QuantitaPerc = $rowComp['qta_teo_perc']; //Quantità perc teorica
        $QuantitaPercTot = $QuantitaPercTot + $QuantitaPerc; //Quantità perc teorica totale
        if ($QuantitaRealeTot > 0)
            $QuantitaPercReale = ($rowComp['qta_reale'] * 100) / $QuantitaRealeTot; //Quantita percentuale reale
        $QuantitaPercTotReale = $QuantitaPercTotReale + $QuantitaPercReale; //Quantita percentuale reale totale
//####################  COSTO   ####################
        $CostoGrammi = $rowComp['prezzo'] / $fatConvKgGrammi;
        //######### QTA PER PER 100KG ########
        if ($QuantitaRealeTot > 0)
            $qtaPer100Kg = (100000 * $rowComp['qta_reale']) / $QuantitaRealeTot;
        $costoPerQtaPer100Kg = $qtaPer100Kg * $CostoGrammi;

        $Quantita100kgTot = $Quantita100kgTot + $qtaPer100Kg;


        $CostoPerQta = $rowComp['qta_reale'] * $CostoGrammi;
        $CostoTotale = $CostoTotale + $costoPerQtaPer100Kg;

        if ($CostoTotalePerc > 0) {
            $CostoPercentuale = ($CostoPerQta * 100) / $CostoTotalePerc;
        }
        $CostoTotalePercentuale = $CostoTotalePercentuale + $CostoPercentuale;
        ?>		
                                <tr >
                                    <td class="cella4" width="300px"><?php echo $DescriComp; ?></td>
                                    <td class="cella1" style="width:100px;text-align:right;"><?php echo number_format($rowComp['prezzo'], $PrecisioneCosti, '.', '') . " " . $filtroLabEuro; ?></td>
                                    <td class="cella1" style="text-align:right"><?php echo number_format($QuantitaPerc, $PrecisioneQta, '.', '') . " " . $filtroLabPerc; ?></td>
                                    <td class="cella1" style="text-align:right"><?php echo number_format($QuantitaPercReale, $PrecisioneQta, '.', '') . " " . $filtroLabPerc; ?></td>
                                    <td class="cella1" style="text-align:right"><?php echo $rowComp['qta_reale'] . " " . $filtroLabGrammo; ?></td>
                                    <td class="cella1" style="text-align:right"><?php echo number_format($qtaPer100Kg, $Prec100Kg, '.', '') . " " . $filtroLabGrammo; ?></td>
                                    <td class="cella1" style="width:100px;text-align:right"><?php echo number_format($costoPerQtaPer100Kg, $Prec100Kg, '.', '') . " " . $filtroLabEuro; ?></td>
                                    <td class="cella1" style="width:100px;text-align:right"><?php echo number_format($CostoPercentuale, $PrecisioneCosti, '.', '') . " " . $filtroLabPerc; ?></td>
                                </tr>
        <?php
        $totQtaTeoPercDrymix = $totQtaTeoPercDrymix+$QuantitaPerc;
        $totQtaRealePercDrymix = $totQtaRealePercDrymix+$QuantitaPercReale;
        $totQtaRealeDrymix = $totQtaRealeDrymix+$rowComp['qta_reale'];
        $totQtaPer100KgDrymix = $totQtaPer100KgDrymix+$qtaPer100Kg;
        $totCosto100KgDrymix = $totCosto100KgDrymix+$costoPerQtaPer100Kg;
        $totCostoPercDrymix = $totCostoPercDrymix+$CostoPercentuale;
    }//End Componenti 
    ?>
                        <!--###############  TOTALI DRYMIX ###############-->
                         <tr >
                                    <td class="dataRigWhite" width="300px" ></td>
                                    <td class="dataRigWhite" style="width:100px;"></td>
                                    <td class="dataRigWhite" style="text-align:right;font-size:15px"><?php echo number_format($totQtaTeoPercDrymix, $PrecisioneQta, '.', '') . " " . $filtroLabPerc; ?></td>
                                    <td class="dataRigWhite" style="text-align:right;font-size:15px"><?php echo number_format($totQtaRealePercDrymix, $PrecisioneQta, '.', '') . " " . $filtroLabPerc; ?></td>
                                    <td class="dataRigWhite" style="text-align:right;font-size:15px"><?php echo $totQtaRealeDrymix . " " . $filtroLabGrammo; ?></td>
                                    <td class="dataRigWhite" style="text-align:right;font-size:15px"><?php echo number_format($totQtaPer100KgDrymix, $Prec100Kg, '.', '') . " " . $filtroLabGrammo; ?></td>
                                    <td class="dataRigWhite" style="width:100px;text-align:right;font-size:15px"><?php echo number_format($totCosto100KgDrymix, $Prec100Kg, '.', '') . " " . $filtroLabEuro; ?></td>
                                    <td class="dataRigWhite" style="width:100px;text-align:right;font-size:15px"><?php echo number_format($totCostoPercDrymix, $PrecisioneCosti, '.', '') . " " . $filtroLabPerc; ?></td>
                                </tr>
                        
                            <?php
                        //############# Totali quantità delle materie prime #############
                        }
                        ?>
                        <tr>
                            <td class="cella2" width="300px" colspan="2"><?php echo $filtroLabTotale ?></td>
                            <td class="cella2" style="text-align:right"><?php echo number_format($QuantitaPercTot, $PrecTotali, '.', '') . " " . $filtroLabPerc; ?></td>
                            <td class="cella2" style="text-align:right"><?php echo number_format($QuantitaPercTotReale, $PrecTotali, '.', '') . " " . $filtroLabPerc; ?></td>
                            <td class="cella2" style="text-align:right"><?php echo number_Format($QuantitaRealeTot, $PrecTotali, '.', '') . " " . $filtroLabGrammo; ?></td>
                            <td class="cella2" style="text-align:right"><?php echo number_Format($Quantita100kgTot, $PrecTotali, '.', '') . " " . $filtroLabGrammo; ?></td>
                            <td class="cella2" style="width:100px;text-align:right"><?php echo number_format($CostoTotale, $PrecTotali, '.', '') . " " . $filtroLabEuro; ?></td>
                            <td class="cella2" style="width:100px;text-align:right"><?php echo number_format($CostoTotalePercentuale, $PrecTotali, '.', '') . " " . $filtroLabPerc; ?></td>

                        </tr>
                    </table>
                    <!--############################################################################
                    ########################### PARAMETRI ##########################################
                    ##############################################################################-->
<?php if (mysql_num_rows($sqlPar) > 0) { ?>
                        <table width="100%">
                            <tr >
                                <th class="cella3"><?php echo $filtroLabParametro ?></th>
                                <th class="cella3"><?php echo $filtroLabUnMisura ?></th>
                                <th class="cella3"><?php echo $filtroLabValoreTeo ?></th>
                                <th class="cella3"><?php echo $filtroLabQtaPercReale ?></th>
                                <th class="cella3"><?php echo $filtroLabValoreReale ?></th>
                            </tr>
    <?php
//Inizializzo i totali
    $ValoreTeoTot = 0;
    $ValoreRealeTot = 0;

//Calcolo il valore totale dell'acqua
    while ($rowTotReale = mysql_fetch_array($sqlTotReale)) {
        $ValoreReale = $rowTotReale['valore_reale'];
        $ValoreRealeTot = $ValoreRealeTot + $ValoreReale;
    }

    while ($rowPar = mysql_fetch_array($sqlPar)) {
        $NomeParametro = $rowPar['nome_parametro'];
        $UnitaMisura = $rowPar['unita_misura'];
        $ValoreTeo = $rowPar['valore_teo'];
        $ValoreTeoTot = $ValoreTeoTot + $ValoreTeo;

        $ValoreReale = $rowPar['valore_reale'];
        $ValorePercReale = ($rowPar['valore_reale'] * 100) / $QuantitaRealeTot;

        //###### PARAMETRI TIPO PERCENTUALE SI ###########################
        if (($rowPar['tipo']) == $PercentualeSI) {
            ?>		
                                    <tr >
                                        <td class="cella4" width="300px"><?php echo $NomeParametro; ?></td>
                                        <td class="cella1"><?php echo $UnitaMisura; ?></td>
                                        <td class="cella1"><?php echo $ValoreTeo . " " . $filtroLabPerc; ?></td>
                                        <td class="cella1"><?php echo number_format($ValorePercReale, $PrecisioneQta, '.', '') . " " . $filtroLabPerc; ?></td>
                                        <td class="cella1"><?php echo $ValoreReale; ?></td>
                                    </tr>

            <?php
        } else {
            //###### PARAMETRI TIPO PERCENTUALE NO ###########################
            ?>
                                    <tr >
                                        <td class="cella4" width="300px" ><?php echo $NomeParametro; ?></td>
                                        <td class="cella1"><?php echo $UnitaMisura; ?></td>
                                        <td class="cella1"><?php echo $ValoreTeo; ?></td>
                                        <td class="cella1"></td>
                                        <td class="cella1"><?php echo $ValoreReale; ?></td>
                                    </tr>

            <?php
        }
    }//End While parametri
//Totali valori dei parametri
}
?>
                    </table>
                    <table width="100%">
                        <!--############################################################################
                        ########################### CARATTERISTICHE ####################################
                        ##############################################################################-->
<?php if (mysql_num_rows($sqlCar) > 0 OR mysql_num_rows($sqlCarAll) > 0) { ?>
                            <tr>
                                <th  class="cella3" width="300px"><?php echo $filtroLabCaratteristica ?></th>
                                <th  class="cella3" width="60px"><?php echo $filtroLabTipo ?></th>
                                <th  class="cella3" width="160px" colspan="2"><?php echo $filtroLabValore ?></th>
                                <th  class="cella3" width="140px" colspan="2"><?php echo $filtroLabDimensione ?> </th>
                                <th  class="cella3" width="150px" ><?php echo $filtroLabNote ?> </th>
                                <th  class="cella3" width="150px"><?php echo $filtroLabDataRegistrazione ?></th>
                                <th  class="cella3" width="60px" colspan="3"><?php echo $filtroOperazioni ?></th>
                            </tr>
    <?php
    $NCar = 1;
    while ($rowCar = mysql_fetch_array($sqlCar)) {

        $sqlFile = findAllegatiByIdRifCar($IdEsperimento, $rowCar['id_carat'], $valRifEsperimento, "lab_caratteristica");
        ?>
                                <tr>
                                    <td width="300px" class="cella4" title="<?php echo $rowCar['descri_caratteristica']; ?>"><?php echo $rowCar['caratteristica']; ?></td>
                                    <td class="cella1" width="60px"><?php echo $rowCar['tipo_dato']; ?></td>
                                    <td class="cella1" width="60px"><textarea name="Valore<?php echo $NCar; ?>" id="Valore<?php echo $NCar; ?>"  ROWS="1" style="width:60px"><?php echo $rowCar['valore_caratteristica']; ?></textarea></td>
                                    <td class="cella1" width="100px"><span class="uniMisStyle"> <?php echo $rowCar['uni_mis_car'] ?></span></td>
        <?php if ($rowCar['dimensione'] != '') { ?>                                
                                        <td class="cella1" width="80px"><input style="width:70px" type="text" name="ValoreDim<?php echo $NCar; ?>" id="ValoreDim<?php echo $NCar; ?>" value="<?php echo $rowCar['valore_dimensione']; ?>"/></td>
                                        <td class="cella1" width="60px"><span class="uniMisStyle"><?php echo $rowCar['uni_mis_dim'] ?></span></td>
                                    <?php } else { ?>
                                        <td class="cella1" width="140px" colspan="2"></td>
                                    <?php } ?>
                                    <td class="cella1" width="150px" ><textarea name="Note<?php echo $NCar; ?>" id="Note<?php echo $NCar; ?>" ROWS="2" style="width:140px"><?php echo $rowCar['note']; ?></textarea></td>
                                    <td class="cella1" width="150px" ><?php echo $rowCar['dt_registrazione']; ?></td>
                                    <td class="cella1" width="30px">
                                        <a target="_blank" href="grafico_lab_caratteristica.php?IdEsperimento=<?php echo $IdEsperimento ?>&IdCar=<?php echo $rowCar['id_carat'] ?>">
                                            <img src="/CloudFab/images/pittogrammi/grafico_G.png" class="icone"  title="<?php echo $titleVediGrafico ?>"/></a></td>
                                    <td class="cella1" width="30px">
                                        <a name="EliminaCaratteristica" href='elimina_lab_dato.php?Tabella=lab_risultato_car&IdRecord=<?php echo $rowCar['id'] ?>&NomeId=id&RefBack=modifica_lab_risultati.php?IdEsperimento=<?php echo $IdEsperimento ?> ' onClick="return VisualizzaMsgConferma();" >
                                            <img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone"  title="<?php echo $titleElimina ?>"/></a>

                                    </td>
                                    <td class="cella1" width="30px">
        <?php if (mysql_num_rows($sqlFile) > 0) { ?>
                                            <a href="dettaglio_lab_allegato.php?IdRif=<?php echo $IdEsperimento ?>&IdCarat=<?php echo $rowCar['id_carat'] ?>&NomeCar=<?php echo $rowCar['caratteristica'] ?>&TipoRif=<?php echo $valRifEsperimento ?>&RefBack=modifica_lab_risultati.php?IdEsperimento=<?php echo $IdEsperimento ?>">
                                                <img src="/CloudFab/images/pittogrammi/allegato_R.png" class="icone"  title="<?php echo $titleVediAllegati ?>"/></a>
                                        <?php } ?></td>

                                    <input type="hidden" id="IdRisCar" name="IdRisCar" value="<?php echo $rowCar['id']; ?>"/>
                                </tr>
        <?php
        $NCar++;
    }//End While caratteristiche
    //##################################################################
    //Caratteristiche che hanno un allegato nella tabella lab_allegato 
    //ma non hanno un valore salvato nella tabella lab_risultato_car
    $NCarAll = 1;
    while ($rowCarAll = mysql_fetch_array($sqlCarAll)) {
        ?>		
                                <tr>
                                    <td width="300px" class="cella4" title="<?php echo $rowCarAll['descri_caratteristica']; ?>"><?php echo $rowCarAll['caratteristica']; ?></td>
                                    <td class="cella1" width="60px"><?php echo $filtroLabFile; ?></td>
                                    <td class="cella1" colspan="5"></td>
                                    <td class="cella1"  width="150px"><?php echo $rowCarAll['data_caricato'] ?></td>
                                    <td class="cella1" > </td>
                                    <td class="cella1" > </td>
                                    <td class="cella1" >
                                        <a name="EliminaCaratteristica" href="dettaglio_lab_allegato.php?IdRif=<?php echo $IdEsperimento ?>&IdCarat=<?php echo $rowCarAll['id_carat'] ?>&NomeCar=<?php echo $rowCarAll['caratteristica'] ?>&TipoRif=<?php echo $valRifEsperimento ?>&RefBack=modifica_lab_risultati.php?IdEsperimento=<?php echo $IdEsperimento ?>">
                                            <img src="/CloudFab/images/pittogrammi/allegato_R.png" class="icone"  title="<?php echo $titleVediAllegati ?>"/></a>
                                    </td>
                                </tr>
        <?php
        $NCarAll++;
    }//End While caratteristiche senza valore
} //End if 
?>
                    </table>
                    <table width="100%">
                        <tr>
                            <td class="cella2" style="text-align: right " colspan="11">
                                <input type="reset"  onClick="javascript:history.back();" value="<?php echo $valueButtonAnnulla ?>"/>
                                <input type="button" id="AggiungiCar" onClick="location.href = 'aggiungi_caratteristica1.php?IdEsperimento=<?php echo $IdEsperimento; ?>'" value="<?php echo $valueButtonDefinisciCar ?>"/>
                                <input type="button" onClick="javascript:GeneraFormula('<?php echo $IdEsperimento ?>', '<?php echo $CodiceFormula ?>');" value="<?php echo $valueButtonLabCreaFormula ?>"/>
                                <input type="button" id="SalvaRisultati" onClick="javascript:Salva();" value="<?php echo $valueButtonSalva ?>" />
                            </td>
                        </tr>
                    </table>

                </form>
            </div>
            <div id="msgLog">
<?php
if ($DEBUG) {

    echo "</br>actionOnLoad " . $actionOnLoad;
}
?>
            </div>
        </div><!--mainContainer-->
    </body>
</html>
