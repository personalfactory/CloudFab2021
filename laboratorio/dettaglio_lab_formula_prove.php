<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript">

        function disabilitaOperazioni() {
            for (i = 0; i < document.getElementsByName('Merge').length; i++) {
                document.getElementsByName('Merge')[i].style.display = "none";
            }
            for (i = 0; i < document.getElementsByName('ModificaMat').length; i++) {
                document.getElementsByName('ModificaMat')[i].style.display = "none";
            }
            for (i = 0; i < document.getElementsByName('SalvaModificaFormula').length; i++) {
                document.getElementsByName('SalvaModificaFormula')[i].style.display = "none";
                document.getElementsByName('VisibilitaFormula')[i].removeAttribute('input');
            }
            for (i = 0; i < document.getElementsByName('DuplicaFormula').length; i++) {
                document.getElementsByName('DuplicaFormula')[i].style.display = "none";
            }
        }



        function salvaLabFormula(visUtente, msgErrVisibilita) {
            
            var visImpostata = Number(document.getElementById('VisibilitaFormula').value);
            var visUtente = Number(visUtente);
            
            if (visImpostata > visUtente) {
//                alert('VisibilitaFormula: '+ document.getElementById('VisibilitaFormula').value+'>'+visUtente);
                alert(msgErrVisibilita);
            } else {                

                document.forms["ModificaLabFormula"].method = "POST";
                document.forms["ModificaLabFormula"].action = "dettaglio_lab_formula_prove.php?ToDo=SalvaVisAziendaLabFormula";
                document.forms["ModificaLabFormula"].submit();
            }
            
        }
        
        function mergeLabFormula(codLabFormula) {
            location.href = "merge_lab_esperimenti.php?CodLabFormula=" + codLabFormula;
        }

    </script>
    <?php
    if ($DEBUG)
        ini_set('display_errors', 1);
    //############# STRINGHE UTENTI - AZIENDE VISIBILI##########################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato       
    $strUtentiAziendeEsp = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_esperimento');
    //Si verifica il permesso di fare il merge sugli esperimenti visibili di una formula

    include('../include/precisione.php');
    include('../Connessioni/serverdb.php');
    include('sql/script_lab_formula.php');
    include('sql/script_lab_esperimento.php');
    include('sql/script_lab_matpri_teoria.php');
    include('sql/script_lab_parametro_teoria.php');
    include('sql/script_lab_risultato_car.php');
    include('sql/script_lab_risultato_matpri.php');
    include('sql/script_lab_risultato_par.php');
    include('sql/script_lab_allegato.php');
    include('./sql/script.php');

    $Pagina = "dettaglio_lab_formula_prove";


    if (isSet($_GET['CodLabFormula']))
        $_SESSION['CodLabFormula'] = $_GET['CodLabFormula'];


    //################################################################
    //############## MODIFICA VISIBILITA E AZIENDA ###################
    //################################################################
    if (isSet($_GET['ToDo']) AND $_GET['ToDo'] == 'SalvaVisAziendaLabFormula') {

        list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);


        if (isSet($_POST['VisibilitaFormula']))
            $Visibilita = $_POST['VisibilitaFormula'];

        //Modifico la visibilità e/o l'azienda della formula
        begin();
        updateLabFormulaByCodice($_SESSION['CodLabFormula'], $IdAzienda, $Visibilita);
        commit();
    }
    //##################################################################
    //################## QUERY AL DB ###################################
    begin();
    $sqlFormula = findFormulaByCodice($_SESSION['CodLabFormula']);
    $sqlProva = selectMaxNumEsperimento($_SESSION['CodLabFormula']);
    $sqlListaProve = selectEsperimentiVisByFormula($_SESSION['CodLabFormula'], $strUtentiAziendeEsp);
    $sqlMtPr = findMatCompFormulaByCodice($_SESSION['CodLabFormula']);
    $sqlMatPrime = findMatPriFormulaByCodice($_SESSION['CodLabFormula']);
    $sqlComp = findCompFormulaByCodice($_SESSION['CodLabFormula']);
    $sqlPar = findParFormulaByCodice($_SESSION['CodLabFormula']);

//          Creo una matrice contenente tutti gli esperimenti (visibili) della formula                                    
//          gli id degli esperimenti vengono salvati
//          sulla prima colonna e i codici a barre sulla seconda.
    if (mysql_num_rows($sqlListaProve) > 0) {

        $k = 0;
        $arrayEsperimenti = array();
        while ($rowListaEsp = mysql_fetch_array($sqlListaProve)) {

            $arrayEsperimenti[$k][1] = $rowListaEsp['id_esperimento'];
            $arrayEsperimenti[$k][2] = $rowListaEsp['cod_barre'];
            $k++;
        }
        //Recupero l'elenco delle caratteristiche definite in tutte le prove
        //prese una sola volta
        $sqlCarFormula = findAllCarUnionFormula($arrayEsperimenti);
    }
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
        $Visibilita = $rowFormula['visibilita'];
    }
    $NomeAzienda = getNomeAziendaById($_SESSION['objUtility'], $IdAzienda);
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'lab_formula');

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
    $TotEsperimenti = 0;
    while ($rowProva = mysql_fetch_array($sqlProva)) {
        $TotEsperimenti = $rowProva['num_prova_tot'];
    }

    //####################### TOTALE QTA E COSTI #######################
    //Inizializzo le variabili numeriche
    $TotaleQta = 0;
    $CostoTotale = 0;
    //La variabile seguente serve per calcolare 
    //subito il totale ai fini del calcolo della percentuale 
    //Alla fine di tutti i  cicli coincide con la variabile precedente
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

    $colspanRis = 2;
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php include('../include/menu.php'); ?>
            <form id="ModificaLabFormula" name="ModificaLabFormula" >
                <div id="container" style="width:100%; margin:15px auto;">

                    <table width="100%" >
                        <th colspan="2" class="cella3"><?php echo $titoloLabFormula ?></th>
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
                            <td class="cella1">
                                <select name="Azienda" id="Azienda"> 
                                    <option value="<?php echo $IdAzienda . ';' . $NomeAzienda; ?>" selected=""><?php echo $NomeAzienda; ?></option>
                                    <?php
//Si selezionano solo le aziende scrivibili dall'utente
                                    for ($a = 0; $a < count($arrayAziendeScrivibili); $a++) {
                                        $idAz = $arrayAziendeScrivibili[$a]->getIdAzienda();
                                        $nomeAz = $arrayAziendeScrivibili[$a]->getNomeAzienda();
                                        if ($idAz != $IdAzienda) {
                                            ?>
                                            <option value="<?php echo( $idAz . ';' . $nomeAz); ?>"><?php echo($nomeAz) ?></option>                                       
                                            <?php
                                        }
                                    }
                                    ?>
                                </select> 
                            </td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroVisibilita . " " . $filtroLabFormula ?></td>
                            <td class="cella1"><input class="cella1" type="text" id="VisibilitaFormula" name="VisibilitaFormula" value="<?php echo $Visibilita ?>"/><span class="commentiStyle"><?php echo $titleVisibilita . ' ' . $_SESSION['visibilita_utente'] . ' ' . $titleVisibilita2 ?></span></td>
                        </tr>
                        <tr>
                            <td class="cella4" colspan="2" style="text-align:right;">                                
                            <input type="button" name="DuplicaFormula" onClick="location.href='duplica_lab_formula.php?CodiceFormulaOld=<?php echo $CodiceFormula ?>'" value="<?php echo $titleDuplica ?>"/>
                            <input type="button" name="SalvaModificaFormula"  title="<?php echo $titleSalvaVisibilitaAzienda ?>" onClick="salvaLabFormula('<?php echo $_SESSION['visibilita_utente'] ?>', '<?php echo $msgErrVisibilita . ': ' . $titleVisibilita . ' ' . $_SESSION['visibilita_utente'] ?>')" value="<?php echo $valueButtonSalva ?>"/></td>
                        </tr>
                    </table>                
                    <!--############################################################-->
                    <!--############### MATERIE PRIME ##############################-->
                    <!--############################################################-->
                    <table width="100%">
<?php if (mysql_num_rows($sqlMatPrime) > 0) { ?>

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
                            $colspanRis = 8;
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
                            <?php
                        }// End if(mysql_num_rows($sqlMatPrime)>0)
//                   ############################################################
//                   ############### COMPONENTI #################################
//                   ############################################################

                        if (mysql_num_rows($sqlComp) > 0) {
                            ?>
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
                            $colspanRis = 8;

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
                        }// END if(mysql_num_rows($sqlComp)>0)
//############################################################
//############### TOTALI QTA E COSTI #########################
//############################################################
                        if (mysql_num_rows($sqlComp) > 0 OR mysql_num_rows($sqlMatPrime) > 0) {
                            ?>

                            <tr>
                                <td width="100px" class="cella2" colspan="4"><?php echo $filtroLabTotale ?></td>
                                <td width="100px" class="cella2"><?php echo number_format($TotaleQta, $PrecisioneQta, '.', '') . " " . $filtroLabGrammo ?></td>
                                <td width="70px"  class="cella2"><?php echo number_format($CostoTotale, $PrecisioneCosti, '.', '') . " " . $filtroLabEuro ?></td>
                                <td width="100px" class="cella2"><?php echo number_format($TotalePercentuale, $PrecisioneQta, '.', '') . " " . $filtroLabPerc ?></td>
                                <td width="100px" class="cella2"><?php echo number_format($CostoTotalePercentuale, $PrecisioneCosti, '.', '') . " " . $filtroLabPerc ?></td>
                            </tr>	


                            <?php
                        }
                        ?>
                    </table>
                    <?php
//############################################################
//######################### PARAMETRI ########################
//############################################################


                    if (mysql_num_rows($sqlPar) > 0) {
                        $colspanRis = 3;
                        ?>

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
                                        <td class="cella4"><?php echo ($rowPar['nome_parametro']); ?></td>
                                        <td class="cella1"><?php echo ($rowPar['unita_misura']); ?></td>
                                        <td class="cella1"><?php echo ($rowPar['valore_teo']) . " " . $filtroLabPerc ?></td>
                                    </tr>
                                <?php } else {
                                    ?>
                                    <tr>
                                        <td class="cella4"><?php echo ($rowPar['nome_parametro']); ?></td>
                                        <td class="cella1"><?php echo ($rowPar['unita_misura']); ?></td>
                                        <td class="cella1"><?php echo ($rowPar['valore_teo']); ?></td>
                                    </tr>
                                    <?php
                                }
                                $NPar++;
                            }//End While parametri 
                        }// End  if(mysql_num_rows($sqlPar)>0) 
                        ?>
                    </table>
                </div>
                <?php
//##############################################################################
//########################## ESPERIMENTI FATTI #################################
//##############################################################################
                if ($TotEsperimenti > 0 AND mysql_num_rows($sqlListaProve) > 0) {

                    $colspanRis = mysql_num_rows($sqlListaProve) + 1;
                    $widthCont = mysql_num_rows($sqlListaProve) * 200 + 300;

                    //1111 è il 95% di 1170 che è la dimensione del mainContainer
                    if ($widthCont < 1111)
                        $widthCont = 1111;
                    ?>

                    <div id="container"  style="margin:15px auto; width:<?php echo $widthCont ?>px;">
                        <table width="100%" height="100%" >                        
                            <th class="cella3" colspan="<?php echo $colspanRis ?>"><?php echo $filtroLabEsperimentiFatti ?></th>

                            <!--######################################################################
                            //########################## MATERIE PRIME ###############################
                            //######################################################################-->

                            <tr>
                                <td class="dataRigWhite" width="400px"><?php echo $filtroLabMatPrimeCompound ?></td>
                                <?php
                                for ($j = 0; $j < count($arrayEsperimenti); $j++) {
                                    ?>
                                    <td class="dataRigWhite" width="100px" ><?php echo $filtroLabProvaBreve ?>
                                        <a target="blank" href="modifica_lab_risultati.php?IdEsperimento=<?php echo $arrayEsperimenti[$j][1] ?>">
                                    <?php echo $arrayEsperimenti[$j][2] ?></a></td>
    <?php } ?>
                            </tr>

                            <?php
                            if(mysql_num_rows($sqlMatPrime)>0)
                            mysql_data_seek($sqlMatPrime, 0);
                            //Scorro l'elenco delle materie prime definite per la formula
                            while ($rowMP = mysql_fetch_array($sqlMatPrime)) {
                                ?>
                                <tr>
                                    <td class="cella4" width="400px"><?php echo $rowMP['descri_materia'] ?></td> 
                                    <?php
                                    for ($j = 0; $j < count($arrayEsperimenti); $j++) {
                                        ?>                                    

                                        <td class="cella1" width="100px"> 
                                            <table  width="100%">
                                                <?php
                                                $qtaPerc = 0;
                                                $qtaTotale = 0;
                                                //Totale delle qta reali del singolo esperimento
                                                $sqlQtaTotReale = findQtaTotMatPrimeByIdEsper($arrayEsperimenti[$j][1]);
                                                $rowTot = mysql_fetch_row($sqlQtaTotReale);
                                                $qtaTotale = $rowTot[0];

                                                $sqlQtaReali = findQtaByIdEsperIdMat($arrayEsperimenti[$j][1], $rowMP['id_mat']);

                                                while ($rowQtaReali = mysql_fetch_array($sqlQtaReali)) {
                                                    if ($qtaTotale > 0)
                                                        $qtaPerc = ($rowQtaReali['qta_reale'] * 100 ) / $qtaTotale;
                                                    ?>

                                                                                                                                                        <!--<td class="dataRigGray" width="60px" title="<?php echo $filtroLabProvaBreve . " " . $arrayEsperimenti[$j][2] ?>"><?php echo $rowQtaReali['qta_reale'] . $filtroLabGrammo ?></td>--> 
                                                    <td  width="60px"title="<?php echo $filtroLabProvaBreve . " " . $arrayEsperimenti[$j][2] ?>"><?php echo number_format($qtaPerc, $PrecisioneQta, '.', '') . $filtroLabPerc ?></td> 

                                                    </tr>
            <?php }//End qta         ?>
                                            </table>
                                        </td>
                                <?php } //End esperimenti        ?>
                                </tr>
                            <?php } //End materie prime   
                            ?>

                            <!--######################################################################
                            //########################## COMPONENTI ##################################
                            //########################################################################-->

                            <tr>
                                <td class="dataRigWhite" colspan="<?php echo $colspanRis ?>" ><?php echo $filtroLabMtDrymix ?></td>

                            </tr>
                            <?php
                            if(mysql_num_rows($sqlComp)>0)
                            mysql_data_seek($sqlComp, 0);
                            //Scorro l'elenco delle materie prime drymix definite per la formula
                            while ($rowComp = mysql_fetch_array($sqlComp)) {
                                ?>
                                <tr>
                                    <td class="cella4" width="400px"><?php echo $rowComp['descri_materia'] ?></td> 
                                    <?php
                                    for ($j = 0; $j < count($arrayEsperimenti); $j++) {
                                        ?>                                    

                                        <td class="cella1" width="100px"> 
                                            <table  width="100%">
                                                <?php
                                                $qtaPerc = 0;
                                                $qtaTotale = 0;
                                                $sqlQtaTotReale = findQtaTotMatPrimeByIdEsper($arrayEsperimenti[$j][1]);
                                                $rowTot = mysql_fetch_row($sqlQtaTotReale);
                                                $qtaTotale = $rowTot[0];

                                                $sqlQtaReali = findQtaByIdEsperIdMat($arrayEsperimenti[$j][1], $rowComp['id_mat']);
                                                while ($rowQtaReali = mysql_fetch_array($sqlQtaReali)) {
                                                    if ($qtaTotale > 0)
                                                        $qtaPerc = ($rowQtaReali['qta_reale'] * 100 ) / $qtaTotale;
                                                    ?>
                                                                        <!--<td class="dataRigGray" width="60px" title="<?php echo $filtroLabProvaBreve . " " . $arrayEsperimenti[$j][2] ?>"><?php echo $rowQtaReali['qta_reale'] . $filtroLabGrammo ?></td>--> 
                                                    <td  width="60px" title="<?php echo $filtroLabProvaBreve . " " . $arrayEsperimenti[$j][2] ?>"><?php echo number_format($qtaPerc, $PrecisioneQta, '.', '') . $filtroLabPerc ?></td> 

                                                    </tr>
            <?php }//End qta               ?>
                                            </table>
                                        </td>
                                <?php } //End esperimenti              ?>
                                </tr>
                                <?php
                            } //End componenti drymix 
//########################################################################
//########################## PARAMETRI ###################################
//########################################################################
                            ?>  

                            <tr>
                                <td class="dataRigWhite" colspan="<?php echo $colspanRis ?>"><?php echo $filtroLabParametri ?></td>

                            </tr>
                            <?php
//Scorro l'elenco dei parametri drymix definite per la formula
                            while ($rowPar = mysql_fetch_array($sqlPar)) {
                                ?>
                                <tr>
                                    <td class="cella4" width=400px"><?php echo $rowPar['nome_parametro'] ?></td> 
                                    <?php
                                    for ($j = 0; $j < count($arrayEsperimenti); $j++) {
                                        ?>                                    

                                        <td class="cella1" width="100px"> 
                                            <table  width="100%">
                                                <?php
                                                $qtaPerc = 0;
                                                $sqlQtaReali = findQtaByIdEsperIdPar($arrayEsperimenti[$j][1], $rowPar['id_par']);
                                                while ($rowQtaReali = mysql_fetch_array($sqlQtaReali)) {
                                                    $qtaPerc = ($rowQtaReali['valore_reale'] * 100) / $TotaleQta;
                                                    if ($rowPar['tipo'] == $PercentualeSI
                                                    ) {
                                                        ?>                                      
                                                                                                        <!--<td class="dataRigGray" width="60px"></td>-->
                                                        <td  width="60px" title="<?php echo $filtroLabProvaBreve . " " . $arrayEsperimenti[$j][2] ?>"><?php echo number_format($qtaPerc, $PrecisioneQta, '.', '') . $filtroLabPerc ?></td> 
                                                    <?php } else {
                                                        ?>
                                                        <td width="60px" title="<?php echo $filtroLabProvaBreve . " " . $arrayEsperimenti[$j][2] ?>"><?php echo $rowQtaReali['valore_reale'] . $rowPar['unita_misura'] ?></td> 
                                                        <!--<td class="dataRigGray" width="60px"></td>-->
                                                    <?php }
                                                    ?>


                                                    </tr>
            <?php }//End qta        ?>
                                            </table>
                                        </td>
                                <?php } //End esperimenti          ?>
                                </tr>
                                <?php
                            } //End parametri     
//##############################################################
//################# RISULTATI ##################################
//##############################################################                               
                            ?>
                            <th class="cella3" colspan="<?php echo $colspanRis ?>"><?php echo $filtroLabRisultati ?></th>
                            <tr>
                                <td class="dataRigWhite" width="400px"><?php echo $filtroLabCaratteristiche ?></td>
                                <?php
                                for ($j = 0; $j < count($arrayEsperimenti); $j++) {
                                    ?>
                                    <td class="dataRigWhite" width="100px" ><?php echo $filtroLabProvaBreve ?>
                                        <a target="blank" href="modifica_lab_risultati.php?IdEsperimento=<?php echo $arrayEsperimenti[$j][1] ?>">
                                    <?php echo $arrayEsperimenti[$j][2] ?></a></td>
    <?php } ?>
                            </tr>

                            <?php
                            //Scorro l'elenco delle caratteristiche definite per la formula
                            while ($rowListaCar = mysql_fetch_array($sqlCarFormula)) {
                                ?>
                                <tr>
                                    <td class="cella4" width="400px"><?php echo $rowListaCar['caratteristica'] ?></td> 

        <?php for ($j = 0; $j < count($arrayEsperimenti); $j++) { ?>                                    

                                        <td class="cella1" width="100px"> 
                                            <table  width="100%">
                                                <?php
                                                $sqlRisCar = findRisultatoSingolaCarByIdEspIdCar($arrayEsperimenti[$j][1], $rowListaCar['id_carat']);
                                                while ($rowRisCar = mysql_fetch_array($sqlRisCar)) {
                                                    $TrePunti = "";
                                                    if (strlen($rowRisCar['valore_caratteristica']) > $numCarVis) {
                                                        $TrePunti = $filtroPuntini;
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td  title="<?php echo $rowRisCar['valore_caratteristica'] . " " . $rowRisCar['uni_mis_car'] . " " . $rowRisCar['note'] ?>"><nobr><?php echo substr($rowRisCar['valore_caratteristica'], 0, $numCarVis) . $TrePunti . " <span class='uniMisStyle'>" . $rowRisCar['uni_mis_car'] . "</span>" ?></nobr></td> 
                                                        <?php if ($rowRisCar['valore_dimensione'] != 0) { ?>
                                                            <td  title="<?php echo $rowRisCar['valore_caratteristica'] . " " . $rowRisCar['uni_mis_car'] . " " . $rowRisCar['note'] ?>"><nobr><?php echo $rowRisCar['valore_dimensione'] . " <span class='uniMisStyle'>" . $rowRisCar['uni_mis_dim'] . "</span>" ?></nobr></td> 
                                                        <?php } ?>
                                                        <!--</tr>-->
                                                        <?php
                                                    }//End valori risultati caratteristiche 
                                                    // ################## ALLEGATI ###########################################

                                                    $sqlFile = findAllegatiByIdRifCar($arrayEsperimenti[$j][1], $rowListaCar['id_carat'], $valRifEsperimento, "lab_caratteristica");
                                                    if (mysql_num_rows($sqlFile) > 0) {
                                                        ?>      
                                                 <!--<tr>-->        
                                                        <td width="20px">
                                                            <a href="dettaglio_lab_allegato.php?IdRif=<?php echo $arrayEsperimenti[$j][1] ?>&IdCarat=<?php echo $rowListaCar['id_carat'] ?>&NomeCar=<?php echo $rowListaCar['caratteristica'] ?>&TipoRif=<?php echo $valRifEsperimento ?>&RefBack=dettaglio_lab_formula_prove.php?CodLabFormula=<?php echo $_SESSION['CodLabFormula'] ?>">
                                                                <img src="/CloudFab/images/pittogrammi/allegato_R.png" class="icone" style="width:20px; height:20px" title="<?php echo $titleVediAllegati ?>"/></a>
                                                        </td>
            <?php } ?></tr>          
                                            </table>
                                        </td>
                                <?php } //End esperimenti       ?>
                                </tr>
                                <?php
                            }
                        ?>
                    </table>
                    <table width="100%" height="100%" >      
                        <tr>
                            <td class="cella4" style="text-align: right " colspan="<?php echo $colspanRis ?>">
                                <input type="reset"  onClick="javascript:history.back();" value="<?php echo $valueButtonAnnulla ?>"/>
                                <input name="Merge" type="button" onClick="mergeLabFormula('<?php echo $_SESSION['CodLabFormula'] ?>')" value="<?php echo $valueButtonLabMerge ?>"/>

                        </tr>
                    </table>
                        <?php } //End if numero tot esperimenti>0 
                        ?>
            </form>
        </div>
                

        <div id="msgLog">
            <?php
            if ($DEBUG) {
                echo "actionOnLoad :" . $actionOnLoad;
                echo "</br>Tab lab_esperimento : Nuova stringa unica utenti e aziende visibili : " . $strUtentiAziendeEsp;
            }
            ?>
        </div>

        </div><!--mainContainer-->
    </body>
</html>











