<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript">
        function Carica() {
            document.forms["InserisciFormula"].action = "carica_formula2.php";
            document.forms["InserisciFormula"].submit();
        }
        function AggiornaCalcoli() {
            document.forms["InserisciFormula"].action = "carica_formula.php";
            document.forms["InserisciFormula"].submit();
        }
        
    </script>
    <?php
    if ($DEBUG)
        ini_set(display_errors, "1");

    //############ UTENTI VISIBILI  ############################################    
    $strUtentiAziendeFam = getStrUtAzVisib($_SESSION['objPermessiVis'], 'codice');
    $strUtentiAziendeAcc = getStrUtAzVisib($_SESSION['objPermessiVis'], 'accessorio');
    $strUtentiAziendeMatPri = getStrUtAzVisib($_SESSION['objPermessiVis'], 'materia_prima');
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'formula');
    
    ?>
    <script language="javascript" src="../js/visualizza_elementi.js"></script>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer" >
            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../include/gestione_date.php');
            include('../include/funzioni.php');
            include('../include/precisione.php');
            include('../sql/script.php');
            include('../sql/script_codice.php');
            include('../sql/script_materia_prima.php');
            include('../sql/script_accessorio.php');
            include('../sql/script_formula.php');
            include('../sql/script_prodotto.php');
                        
            $Pagina = "carica_formula";

            begin();
            $sqlCodice = findAllCodiceVis("descrizione", $strUtentiAziendeFam);
            $sqlAccessori = findAllAccessori("ordine", $strUtentiAziendeAcc);
//            $sqlAccessori=findAccessoriDiversiDa("scatLot", "eticLot", "eticCh", "sacCh", "OPER", $strUtentiAziendeAcc);
            $sqlMatPrime = findAllMatPrimeByTipoCod($prefissoCodComp, "descri_mat", $strUtentiAziendeMatPri);
            commit();

            //##########################################################################
            //############## PRIMO CARICAMENTO #########################################
            //##########################################################################
            //Se il codice formula e la descrizione non sono stati settati 
            //allora viene visualizzato il form di inserimento vuota
            if (!isset($_POST['CodiceFormula']) && !isset($_POST['DescriFormula'])) {
                //Variabile utile ai fini del calcolo del nuovo codice della formula
                //Il calcolo deve avvenire solo al primo aggiornamento dello script
                $_SESSION['AggiornamentoScript'] = 0;

//                //#### OGGETTO LabMatpriTeoria ############################
//                $_SESSION['MateriePrimeFormula'] = array();
//                //Contatore delle materie prime con qta >0 
//                //da aggiungere alla formula e salvare nell'oggetto
//                $k = 0;
////                echo "########### k: " . $k;
                ?>
                <div id="container" style="width:90%; margin:15px auto; ">
                    <form id="InserisciFormula" name="InserisciFormula" method="post" >
                        <table width="100%">
                            <tr>
                                <td colspan="2" class="cella3"><?php echo $titoloPaginaNuovaFormula ?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroDt ?></td>
                                <td class="cella11"><?php echo dataCorrenteVisualizza(); ?></td>
                            </tr>
                            <tr>
                                <td width="50%" class="cella4"><?php echo $filtroAster . " " . $filtroFamiglia ?></td>
                                <td width="50%" class="cella11">
                                    <select name="CodiceFormula" id="CodiceFormula">
                                        <option value="" selected=""><?php echo $labelOptionSelectTipoCodice ?></option>
                                        <?php
                                        //La tipologia del codice prodotto viene selezionata dalla tabella codice 
                                        while ($rowCodice = mysql_fetch_array($sqlCodice)) {
                                            ?>
                                            <option value="<?php echo ($rowCodice['tipo_codice']); ?>"><?php echo $rowCodice['descrizione'] . " ".$valPrimaLetteraCod . $rowCodice['tipo_codice']; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroAster . " " . $filtroDescrizione ?></td>
                                <td class="cella11"><input type="text" name="DescriFormula" id="DescriFormula" size="40"/></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroAzienda ?></td>
                                <td class="cella1">
                                    <select name="Azienda" id="Azienda"> 
                                        <option value="<?php echo $_SESSION['id_azienda'] . ";" . $_SESSION['nome_azienda'] ?>" selected="selected"><?php echo $_SESSION['nome_azienda'] ?></option>
                                        <?php
                                        //Si selezionano solo le aziende che l'utente ha il permesso di editare
                                        for ($a = 0; $a < count($arrayAziendeScrivibili); $a++) {
                                            $idAz = $arrayAziendeScrivibili[$a]->getIdAzienda();
                                            $nomeAz = $arrayAziendeScrivibili[$a]->getNomeAzienda();
                                            if ($idAz != $_SESSION['id_azienda']) {
                                                ?>
                                                <option value="<?php echo( $idAz . ';' . $nomeAz); ?>"><?php echo($nomeAz) ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select> 
                                </td>
                            </tr>
                            </table>
                            <table width="100%">
                            <tr>
                                <td colspan="3" class="cella3"><?php echo $filtroMetodoCalcolo ?></td>
                            </tr>
                            <tr title="<?php echo $titleMetodoCalcoloMiscNumLotti ?>">
                                <td id="E" class="cella4"><input type="checkbox" id="MetodoCalcolo[LottiKit]" name="MetodoCalcolo[LottiKit]" value="<?php echo $valMetodoLottiKit ?>" onChange="visualizzaFormNumLotti()" checked ></input></td>
                                <td id="A" class="cella4" width="50%"><?php echo $filtroNumKitPerLotto ?> 
                                    <input onChange="visualizzaFormNumLotti()"  style="width:20%" type="text" name="NumeroKitSacchetti" id="NumeroKitSacchetti"  value="0" ><?php echo $filtroPz ?></input></td>                                  
                                <td id="B" class="cella4" width="50%" ><?php echo $filtroNumLotti ?>
                                    <input onChange="visualizzaFormNumLotti()" style="width:20%" type="text" name="NumeroLotti" id="NumeroLotti"  value="0" ><?php echo $filtroPz ?></input></td>

                            </tr>
                            <tr title="<?php echo $titleMetodoCalcoloMiscTot ?>">
                                <td id="F" class="cella4"><input type="checkbox" id="MetodoCalcolo[MiscelaTot]"  name="MetodoCalcolo[MiscelaTot]" value="<?php echo $valMetodoMiscelaTot ?>" onChange="visualizzaFormQtaMiscelaTot()" ></input></td>
                                <td id="C" class="cella4" width="50%" title="<?php echo $titleMetodoCalcoloMiscTot ?>"><?php echo $filtroQtaTotaleMiscela ?>
                                    <input onChange="visualizzaFormQtaMiscelaTot()" style="width:20%" type="text" name="QtaMiscelaInserita" id="QtaMiscelaInserita" value="0"><?php echo $filtrogBreve ?></input>
                                </td>
                                <td id="D" class="cella4" width="50%"><?php echo $filtroPesoLotto ?>
                                    <input onChange="visualizzaFormQtaMiscelaTot()" style="width:20%;  " type="text" name="PesoLotto" id="PesoLotto" value="0"><?php echo $filtrogBreve ?></input>
                                </td>
                            </tr>
                            <tr class="cella2" style="text-align: right;">
                                <td colspan="3">
                                    <input type="button" onclick="javascript:AggiornaCalcoli();" value="<?php echo $valueButtonAggiorna ?>" />
                                </td>
                            </tr>
                        </table>
                        <?php if (mysql_num_rows($sqlAccessori) > 0) { ?>
                            <table width="100%"> 
                                <tr>
                                    <td class="cella3" colspan="2"><?php echo $filtroConfezionamento ?></td>
                                    <td class="cella3"><?php echo $filtroCosto ?></td>
                                    <td class="cella3"><?php echo $filtroQuantita ?></td>
                                </tr>
                                <?php
                                //Visualizzo i campi di input relativi agli accessori 
                                //presenti nella tabella gaz_001artico di gazie catmer 4 
                                //escludendo quelli già visualizzati singolarmente nel form
                                $NAcc = 1;
                                while ($rowAccessori = mysql_fetch_array($sqlAccessori)) {
                                    ?>
                                    <tr>
                                        <td width="10%" class="cella4"><?php echo($rowAccessori['codice']) ?></td>
                                        <td width="50%" class="cella4"><?php echo($rowAccessori['descri']) ?></td>
                                        <td width="20%" class="cella4"><?php echo($rowAccessori['pre_acq']) . " " . $filtroEuro ?></td>
                                        <td class="cella11"><input style="width:30%" type="text" name="QtaAcc<?php echo($NAcc); ?>" id="QtaAcc<?php echo($NAcc); ?>" value="0" /><?php echo " " . $rowAccessori['uni_mis'] ?></td>
                                    </tr>
                                    <?php
                                    $NAcc++;
                                }
                                ?>
                            </table>
                        <?php } ?>
                        <table width="100%"> 
                            <tr>
                                <td class="cella3" colspan="2" width="60%"><?php echo $filtroMaterieCompound ?></td>
                                <td class="cella3" width="20%"><?php echo $filtroCosto . " " . $filtroEuroKg ?></td>
                                <td class="cella3"><?php echo $filtroQtaPerKit ?></td>
                            </tr> 
                            <?php
                            //TODO : creare un array di oggetti materia prima e poi leggerli dall'oggetto 
                            //Visualizzo i campi di input relativi alle materie prime presenti nella tabella materia_prima
                            $NMatPri = 1;
                            while ($rowMatPrime = mysql_fetch_array($sqlMatPrime)) {
                                //Inizio prezzo
                                //Visualizzo il costo unitario delle materie prime
                                $CostoUnitarioKg = number_format($rowMatPrime['pre_acq'], 4, '.', '');
//                                $CostoUnitario = number_format($rowMatPrime['pre_acq'] / 1000, 4, '.', '');
                                ?> <tr>
                                    <td class="cella4" width="10%"><?php echo($rowMatPrime['cod_mat']) ?></td>
                                    <td class="cella4" width="50%"><?php echo($rowMatPrime['descri_mat']) ?></td>
                                    <td class="cella4" width="20%"><?php echo $CostoUnitarioKg . " " . $filtroEuro ?></td>
                                    <td class="cella1"><input style="width:30%" type="text" name="Qta<?php echo($NMatPri); ?>" id="Qta<?php echo($NMatPri); ?>" value="0" /><?php echo " " . $filtrogBreve ?>			
                                    </td>
                                </tr>
                                <?php
                                $NMatPri++;
                            }//End While materie prime 
                            ?>
                        </table>
                        <table width="100%">       
                            <tr class="cella2" style="text-align: right ">
                                <td>
                                    <input type="reset"  onClick="javascript:history.back();" value="<?php echo $valueButtonAnnulla ?>"/>
                                    <input type="button" onclick="javascript:AggiornaCalcoli();" value="<?php echo $valueButtonAggiorna ?>" />
                                    <!--<input type="button" onclick=javascript:Carica();" value="<?php echo $valueButtonSalva ?>" />-->
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <?php
            } else {

//##############################################################################
//############## INIZIO AGGIORNAMENTO ##########################################
//##############################################################################
                $CodiceFormula = $_POST['CodiceFormula'];
                $DescriFormula = str_replace("'", "''", $_POST['DescriFormula']);
                list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);

                $MetodoCalcolo = $_POST['MetodoCalcolo'];
                foreach ($MetodoCalcolo as $key => $value) {
//                    echo "Hai selezionato il metodo: $key con valore: $value<br />";
                    $MetodoCalcolo = $value;
                }
//##############################################################################
//################## GENERAZIONE DEL CODICE FORMULA ############################
//##############################################################################
//NB. La generazione del codice funziona solo al primo aggiornamento !!!!!!!!!!!!!!!!
                $_SESSION['AggiornamentoScript'] = $_SESSION['AggiornamentoScript'] + 1;

                //Vengono estratte le prime 3 lettere del codice arrivato tramite POST es. KCOL
                //che indicano la famiglia

                if ($_SESSION['AggiornamentoScript'] == 1) {
                    $codiceFamiglia = $CodiceFormula;
                    $CodiceFormula = $valPrimaLetteraCod.calcolaNuovoCodiceProdotto($codiceFamiglia, $valPrimaLetteraCod);
                }
//#################### FINE GENERAZIONE CODICE FORMULA #########################
                //##########################################################################
                //################ METODO DI CALCOLO #######################################
                //##########################################################################

                $TotaleQtaKit = 0;
                //Calcolo il totale delle quantità per poter calcolare il valore percentuale 
                //di ogni singola qta inserita
                $NMtPr = 1;
                if (mysql_num_rows($sqlMatPrime) > 0)
                    mysql_data_seek($sqlMatPrime, 0);
                while ($rowMatPrime = mysql_fetch_array($sqlMatPrime)) {
                    if (isset($_POST['Qta' . $NMtPr])) {
                        $TotaleQtaKit = $TotaleQtaKit + $_POST['Qta' . $NMtPr];
                    }
                    $NMtPr++;
                }//End while totale quantita
                //################ CHIMICA SFUSA ###########################################
                //Se si inserisce la quantita totale di miscela ed il peso di un lotto
                //vengono calcolati il numero di lotti ed il numero di kit in un lotto
                $NumeroLotti = 0;
                $NumeroKitSacchetti = 0;
                $QtaMiscelaInserita = 0;
                $checkedMiscelaTot = "";
                $checkedLottiKit = "";
                $PesoLotto = 0;
//                if ($_POST['QtaMiscelaInserita'] > 0) {
                if ($MetodoCalcolo == $valMetodoMiscelaTot) {

                    
                    $checkedMiscelaTot = "checked";
                    $checkedLottiKit = "";
                    
                    $QtaMiscelaInserita = str_replace("'", "''", $_POST['QtaMiscelaInserita']);
                    $PesoLotto = str_replace("'", "''", $_POST['PesoLotto']);
                    
                    
                    if ($PesoLotto > 0)
                        $NumeroLotti = $QtaMiscelaInserita / $PesoLotto;
                    if ($TotaleQtaKit > 0)
                    //Numero di kit contenuti in un lotto
                        $NumeroKitSacchetti = $PesoLotto / $TotaleQtaKit; //???????????????
                    
//################ CHIMICA CLASSICA IN KIT E LOTTI #####################
                    //Se si inseriscono il numero di kit in un lotto ed il numero di lotti
                    //Vengono calcolati il peso di un lotto e la quantità totale di miscela
//                } else if ($_POST['NumeroKitSacchetti'] > 0 && $_POST['NumeroLotti'] > 0) {
                    } else if ($MetodoCalcolo == $valMetodoLottiKit) {
                        
                        $checkedMiscelaTot = "";
                    $checkedLottiKit = "checked";
                    
                    $NumeroKitSacchetti = str_replace("'", "''", $_POST['NumeroKitSacchetti']);
                    $NumeroLotti = str_replace("'", "''", $_POST['NumeroLotti']);

                    $PesoLotto = $TotaleQtaKit * $NumeroKitSacchetti;
                    $QtaMiscelaInserita = $TotaleQtaKit * $NumeroKitSacchetti * $NumeroLotti;
                }

                //FORMATTAZIONE CIFRE
                $NumeroLotti = number_format($NumeroLotti, 1, '.', '');
//                $NumeroKitSacchetti = number_format($NumeroKitSacchetti, 1, '.', '');


                //##########################################################################
                //################ GESTIONE ERRORI #########################################
                //##########################################################################
                // TO DO !!!!!!
                $errore = false;
                //Durante l'aggiornamento effettuo solo il controllo degli input della tabella formula 
                //e non quello sulle quantita degli accessori non spuri e delle materie prime 
                //che comunque viene sempre effettuato prima di salvare la formula
                include('./include/controllo_input_formula.php');

                if ($errore) {
                    echo '<div id="msgErr">' . $messaggio . '</div>';
                }
                ?>
                <div id="container" style="width:100%; margin:15px auto;">
                    <form id="InserisciFormula" name="InserisciFormula" method="post" >
                        <table width="100%" >
                            <tr>
                                <td colspan="6" class="cella3"><?php echo $titoloPaginaNuovaFormula ?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroDt ?></td>
                                <td class="cella1"><?php echo dataCorrenteVisualizza(); ?></td>
                            </tr>
                            <tr>
                                <td width="50%" class="cella4"><?php echo $filtroCodice ?></td>
                                <td width="50%" class="cella1"><?php echo $CodiceFormula; ?></td>
                                <input type="hidden" name="CodiceFormula" id="CodiceFormula" value="<?php echo $CodiceFormula; ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroAster . " " . $filtroDescrizione ?></td>
                                <td class="cella1"><input type="text" name="DescriFormula" id="DescriFormula" value="<?php echo $DescriFormula; ?>"/></td>
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
                            </table>
                            <table width="100%" >
                            <tr>
                                <td colspan="3" class="cella3"><?php echo $filtroMetodoCalcolo ?></td>
                            </tr>
                            <tr title="<?php echo $titleMetodoCalcoloMiscNumLotti ?>">
                               <td id="E" class="cella4"><input type="checkbox" id="MetodoCalcolo[LottiKit]" name="MetodoCalcolo[LottiKit]" value="<?php echo $valMetodoLottiKit ?>" onChange="visualizzaFormNumLotti()" <?php echo $checkedLottiKit ?>></input></td>
                                <td id="A" class="cella4" width="50%"><?php echo $filtroNumKitPerLotto ?> 
                                    <input  onChange="visualizzaFormNumLotti()" style="width:20%" type="text" name="NumeroKitSacchetti" id="NumeroKitSacchetti"  value="<?php echo $NumeroKitSacchetti ?>" ><?php echo $filtroPz ?></input></td>                                  
                                <td id="B" class="cella4" width="50%" ><?php echo $filtroNumLotti ?>
                                    <input  onChange="visualizzaFormNumLotti()" style="width:20%" type="text" name="NumeroLotti" id="NumeroLotti"  value="<?php echo $NumeroLotti ?>" ><?php echo $filtroPz ?></input></td>
                            </tr>
                            <tr title="<?php echo $titleMetodoCalcoloMiscTot ?>">
                                <td id="F" class="cella4"><input type="checkbox" id="MetodoCalcolo[MiscelaTot]"  name="MetodoCalcolo[MiscelaTot]" value="<?php echo $valMetodoMiscelaTot ?>" onChange="visualizzaFormQtaMiscelaTot()" <?php echo $checkedMiscelaTot ?>></input></td>
                                <td id="C" class="cella4" width="50%" title="<?php echo $titleMetodoCalcoloMiscTot ?>"><?php echo $filtroQtaTotaleMiscela ?>
                                    <input onChange="visualizzaFormQtaMiscelaTot()" style="width:20%" type="text" name="QtaMiscelaInserita" id="QtaMiscelaInserita" value="<?php echo $QtaMiscelaInserita ?>"><?php echo $filtrogBreve ?></input>
                                </td>
                                <td id="D" class="cella4" width="50%"><?php echo $filtroPesoLotto ?>
                                    <input onChange="visualizzaFormQtaMiscelaTot()" style="width:20%" type="text" name="PesoLotto" id="PesoLotto" value="<?php echo $PesoLotto ?>"><?php echo $filtrogBreve ?></input>
                                </td>
                            </tr>
                            <tr class="cella2" style="text-align: right;">
                                <td colspan="3">
                                    <input type="button" onclick="javascript:AggiornaCalcoli();" value="<?php echo $valueButtonAggiorna ?>" />
                                </td>
                            </tr>
                        </table>
                        <?php
                        $CostoAccessorio = 0;
                        $CostoTotaleAccessori = 0;
                        if (mysql_num_rows($sqlAccessori) > 0) {
                            ?>
                            <table width="100%"> 
                                <tr>
                                    <td class="cella3" colspan="2"><?php echo $filtroConfezionamento ?></td>
                                    <td class="cella3"><?php echo $filtroCostoUn ?></td>
                                    <td class="cella3"><?php echo $filtroQuantita ?></td>
                                    <td class="cella3"><?php echo $filtroCosto ?></td>
                                </tr>
                                <?php
                                $NAcc = 1;

                                if (mysql_num_rows($sqlAccessori) > 0)
                                    mysql_data_seek($sqlAccessori, 0);

                                while ($rowAccessori = mysql_fetch_array($sqlAccessori)) {
                                    $QtaAccessorio = 0;
                                    $nomeClasseCella = "dataRigGray";

                                    if (isset($_POST['QtaAcc' . $NAcc]))
                                        $QtaAccessorio = $_POST['QtaAcc' . $NAcc];

                                    $CostoAccessorio = $QtaAccessorio * $rowAccessori['pre_acq'];
                                    $CostoTotaleAccessori = $CostoTotaleAccessori + $CostoAccessorio;

                                    //FORMATTO LE CIFRE
                                    $PrezzoAcquistoAcc = number_format($rowAccessori['pre_acq'], 3, '.', '');
                                    $CostoAccessorio = number_format($CostoAccessorio, 2, ',', '');
                                    $CostoTotaleAccessori = number_format($CostoTotaleAccessori, 2, ',', '');

                                    if ($QtaAccessorio > 0)
                                        $nomeClasseCella = "dataRigWhite";
                                    ?>
                                    <tr>
                                        <td class="<?php echo $nomeClasseCella ?>"><?php echo($rowAccessori['codice']) ?></td>
                                        <td class="<?php echo $nomeClasseCella ?>"><?php echo($rowAccessori['descri']) ?></td>
                                        <td class="<?php echo $nomeClasseCella ?>"><?php echo $PrezzoAcquistoAcc . " " . $filtroEuro ?></td>
                                        <td class="<?php echo $nomeClasseCella ?>"><input type="text" name="QtaAcc<?php echo($NAcc); ?>" id="QtaAcc<?php echo($NAcc); ?>" value="<?php echo $QtaAccessorio; ?>" /><?php echo $rowAccessori['uni_mis'] ?></td>
                                        <td class="<?php echo $nomeClasseCella ?>"><?php echo $CostoAccessorio . " " . $filtroEuro ?></td>
                                    </tr>
                                    <?php
                                    $NAcc++;
                                }//End while Accessori
                                ?>
                                <tr>
                                    <td class="dataRigWhite" colspan="4"><?php echo $filtroCostoTotale . " " . $filtroConfezionamento ?></td>
                                    <td class="dataRigWhite"><?php echo $CostoTotaleAccessori . " " . $filtroEuro ?></td>
                                </tr>
                            </table>
                        <?php } ?>
                        <table width="100%"> 
                            <tr>
                                <td class="cella3" colspan="2"><?php echo $filtroMaterieCompound ?></td>
                                <td width="80px" class="cella3"><?php echo $filtroCosto . " " . $filtroEuroKg ?></td>
                                <td width="50px" class="cella3"><?php echo $filtroQuantita . " " . $filtroPerc ?></td>
                                <td width="100px" class="cella3"><?php echo $filtroQtaPerKit ?> </td>           
                                <td class="cella3"><?php echo $filtroCostoPerKit ?></td>
                                <td class="cella3"><?php echo $filtroQtaPerMiscela ?></td>
                                <td class="cella3"><?php echo $filtroCostoPerMiscela ?></td>
                            </tr> 
                            <?php
                            //Inizializzo le variabili numeriche dei totali 
                            $QuantitaMiscela = 0;
                            $TotaleQtaMiscela = 0;
                            $CostoMiscela = 0;
                            $CostoMiscelaMtTotale = 0;
                            $TotalePercentuale = 0;
                            $QuantitaPercentuale = 0;
                            $CostoUnitarioKg = 0;
                            $CostoKit = 0;
                            $CostoKitMatCompoundTotale = 0;

//Visualizzo l'elenco delle materie prime presenti nella tabella materia_prima con i relativi costi aggiornati e ricevo il post delle quantit�
                            $NMatPri = 1;
                            if (mysql_num_rows($sqlMatPrime) > 0)
                                mysql_data_seek($sqlMatPrime, 0);
                            while ($rowMatPrime = mysql_fetch_array($sqlMatPrime)) {
                                $nomeClasse = "dataRigGray";

                                $CostoUnitarioKg = $rowMatPrime['pre_acq'];
                                $CostoUnitario = $rowMatPrime['pre_acq'] / 1000;

                                if (isset($_POST['Qta' . $NMatPri])) {
                                    $CostoKit = $_POST['Qta' . $NMatPri] * $CostoUnitario;


                                    $CostoKitMatCompoundTotale = $CostoKitMatCompoundTotale + $CostoKit;

                                    //############ MODIFICA 25-11-2014 #################################
                                    //################# METODO DI CALCOLO 1 ############################
                                    //Se si selezionano il num di kit e di lotti da realizzare
                                    //le quantità delle varie materie prime per miscela si calcolano
                                    //moltiplicando la qta per kit per il numero di lotti e per il num di kit
                                    $QuantitaMiscela = $_POST['Qta' . $NMatPri] * $NumeroKitSacchetti * $NumeroLotti;

                                    //################ METODO DI CALCOLO 2 #############################
                                    //Se si seleziona la quantità totale della miscela da realizzare
                                    //le quantità delle varie materie prime per miscela si calcolano
                                    //in percentuale in base alla qta per kit inserita
                                    if ($QtaMiscelaInserita > 0 && $TotaleQtaKit > 0) {

                                        $QuantitaMiscela = ($_POST['Qta' . $NMatPri] * $QtaMiscelaInserita) / $TotaleQtaKit;
                                    }

                                    //########################################################
                                    $CostoMiscela = $QuantitaMiscela * $CostoUnitario;
                                    $CostoMiscelaMtTotale = $CostoMiscelaMtTotale + $CostoMiscela;

                                    //Trasformo le qta in percentuale
                                    $QuantitaPercentuale = 0;
                                    if ($TotaleQtaKit > 0) {
                                        $QuantitaPercentuale = ($_POST['Qta' . $NMatPri] * 100) / $TotaleQtaKit;
                                        $TotalePercentuale = $TotalePercentuale + $QuantitaPercentuale;
                                    }

                                    //FORMATTO CIFRE
                                    $CostoUnitarioKg = number_format($CostoUnitarioKg, 3, ',', '');
                                    $QuantitaPercentuale = number_format($QuantitaPercentuale, 2, ',', '');
                                    $CostoKit = number_format($CostoKit, 2, ',', '');
                                    $CostoMiscela = number_format($CostoMiscela, 2, ',', '');

                                    if ($_POST['Qta' . $NMatPri] > 0)
                                        $nomeClasse = "dataRigWhite";
                                    ?>
                                    <tr>
                                        <td class="<?php echo $nomeClasse; ?>"><?php echo $rowMatPrime['cod_mat'] ?></td>
                                        <td class="<?php echo $nomeClasse; ?>"><?php echo $rowMatPrime['descri_mat'] ?></td>
                                        <!--Il valore che devo salvare nella tabella generazione_formula è QuantitaMiscela quindi lo mando come post -->
                                        <td class="<?php echo $nomeClasse; ?>" ><?php echo $CostoUnitarioKg . " " . $filtroEuro ?></td>
                                        <td class="<?php echo $nomeClasse; ?>" ><?php echo $QuantitaPercentuale . " " . $filtroPerc; ?></td>
                                        <td class="<?php echo $nomeClasse; ?>"><input type="text" style="width: 70px;" name="Qta<?php echo($NMatPri); ?>" id="Qta<?php echo($NMatPri); ?>" value="<?php echo $_POST['Qta' . $NMatPri]; ?>"/><?php echo $filtrogBreve ?></td>
                                        <td class="<?php echo $nomeClasse; ?>" width="100px"><?php echo $CostoKit . " " . $filtroEuro ?></td>
                                        <td class="<?php echo $nomeClasse; ?>" width="100px"><?php echo $QuantitaMiscela . " " . $filtrogBreve ?></td>	    
                                        <input type="hidden" style="width: 70px;" name="QtaMiscela<?php echo($NMatPri); ?>" id="QtaMiscela<?php echo($NMatPri); ?>" value="<?php echo $QuantitaMiscela; ?>"/>
                                        <td class="<?php echo $nomeClasse; ?>" width="100px"><?php echo $CostoMiscela . " " . $filtroEuro ?></td>
                                    </tr>
                                    <?php
                                }//End if isset Post di quantità mat prime
                                $TotaleQtaMiscela = $TotaleQtaMiscela + $QuantitaMiscela;
                                $NMatPri++;
                            }//End While Materie Prime presenti nella tabella materia_prima
                            //FORMATTA CIFRE

                            $TotaleQtaMiscela = number_format($TotaleQtaMiscela, 2, ',', '');
                            $TotalePercentuale = number_format($TotalePercentuale, 2, ',', '');
                            $CostoKitMatCompoundTotale = number_format($CostoKitMatCompoundTotale, 2, ',', '');
                            $CostoMiscelaMtTotale = number_format($CostoMiscelaMtTotale, 2, ',', '');
                            ?>
                            <tr>
                                <td width="100px" class="cella3" colspan="3"><?php echo $filtroTotali ?></td>
                                <td width="100px" class="cella3"><?php echo $filtroTotPerc ?></td>
                                <td width="100px" class="cella3"><?php echo $filtroQtaPerKit ?></td>
                                <td width="70px"  class="cella3"><?php echo $filtroCostoPerKit ?> </td>
                                <td width="100px" class="cella3"><?php echo $filtroQtaPerMiscela ?> </td>
                                <td width="70px"  class="cella3"><?php echo $filtroCostoPerMiscela ?></td>
                            </tr>	
                            <tr>
                                <td width="100px" class="dataRigWhite" colspan="3">  </td>
                                <td width="100px" class="dataRigWhite"><?php echo $TotalePercentuale . " " . $filtroPerc ?></td>
                                <td width="100px" class="dataRigWhite"><?php echo $TotaleQtaKit . " " . $filtrogBreve ?></td>
                                <td width="70px"  class="dataRigWhite"><?php echo $CostoKitMatCompoundTotale . " " . $filtroEuro ?></td>
                                <td width="100px" class="dataRigWhite"><?php echo $TotaleQtaMiscela . " " . $filtrogBreve ?></td>
                                <td width="70px"  class="dataRigWhite"><?php echo $CostoMiscelaMtTotale . " " . $filtroEuro ?></td>
                            </tr>	
                            <input type="hidden" id="TotQtaKit" name="TotQtaKit" value="<?php echo $TotaleQtaKit ?>" /> 
                        </table>
                        <?php include('../include/tabella_costi_formula.php'); ?>
                        <table width="100%">       
                            <tr class="cella2" style="text-align: right ">
                                <td>
                                    <input type="reset"  onClick="javascript:history.back();" value="<?php echo $valueButtonAnnulla ?>">
                                        <input type="button" onclick="javascript:AggiornaCalcoli();" value="<?php echo $valueButtonAggiorna ?>" />
                                        <input type="button" onclick="javascript:Carica();" value="<?php echo $valueButtonSalva ?>" />
                                </td>
                            </tr>
                        </table>
                        <?php
                    }//End Aggiornamento
                    ?>
                </form>
            </div>
            <div id="msgLog">
                <?php
                if ($DEBUG) {

                    echo "</br>Tab codice : Utenti e aziende visibili " . $strUtentiAziendeFam;
                    echo "</br>Tab accessorio : Utenti e aziende visibili " . $strUtentiAziendeAcc;
                    echo "</br>Tab materie prime : Utenti e aziende visibili " . $strUtentiAziendeMatPri;

                    echo "</br>Tabella formula: AZIENDE SCRIVIBILI: ";
                    for ($i = 0; $i < count($arrayAziendeScrivibili); $i++) {

                        echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
                    }
                }
                ?>
            </div>
        </div><!--mainContainer-->
    </body>

</html>
