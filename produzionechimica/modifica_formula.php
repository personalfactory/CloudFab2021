<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>   
    <script language="javascript" src="../js/visualizza_elementi.js"></script>
    <?php
    if ($DEBUG)
        ini_set(display_errors, 1);
    include('../Connessioni/serverdb.php');
    include('../include/precisione.php');
    include('../sql/script.php');
    include('../sql/script_accessorio.php');
    include('../sql/script_accessorio_formula.php');
    include('../sql/script_formula.php');
    include('../sql/script_generazione_formula.php');
    include('../sql/script_prodotto.php');

    $Pagina = "modifica_formula";
    ?>

    <script language="javascript">

        function AggiornaCalcoli() {

            document.forms["ModificaFormula"].action = "modifica_formula.php";
            document.forms["ModificaFormula"].submit();
        }
        function Modifica() {
            document.forms["ModificaFormula"].action = "modifica_formula2.php";
            document.forms["ModificaFormula"].submit();
        }
        function Duplica() {
            document.forms["ModificaFormula"].action = "duplica_formula.php";
            document.forms["ModificaFormula"].submit();
        }

        function disabilitaOperazioni() {

            document.getElementById('AggiungiAccessorio').disabled = true;
            document.getElementById('AggiungiMatPrima').disabled = true;
            document.getElementById('Aggiorna').disabled = true;
            document.getElementById('Salva').disabled = true;

            for (i = 0; i < document.getElementsByName('EliminaMat').length; i++) {
                document.getElementsByName('EliminaMat')[i].removeAttribute('href');
            }
        }


    </script>
    <?php
    //#############  AZIENDE SCRIVIBILI  #######################################
    //Array contenente le aziende di cui l'utente può editare i dati nella tabella formula
    $actionOnLoad = "";
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'formula');
    //##########################################################################

    if (!isset($_POST['CodiceFormula']) && isset($_GET['CodiceFormula'])) {

        //Vuol dire che il cod formula proviene dalla pagina di gestione delle formule
        $CodiceFormula = $_GET['CodiceFormula'];

        //Select dei dati relativi alla formula da modificare dalle tabelle [formula], 
        //[accessorio_formula] e [generazione_formula]
        begin();
        $sqlFormula = findAnFormulaByCodice($CodiceFormula);
        $sqlAccessori = findAccessoriFormulaByCodFormula($CodiceFormula);
//                findAccessFormByCodFormula($CodiceFormula, "scatLot", "eticLot", "sacCh", "eticCh", "OPER");
        $sqlMtPr = findMaterieFormulaByCodice($CodiceFormula, "descri_mat");
        commit();

        while ($rowFormula = mysql_fetch_array($sqlFormula)) {
            $DataFormula = $rowFormula['dt_formula'];
            $DescriFormula = $rowFormula['descri_formula'];
            $NumSacchettiTot = $rowFormula['num_sac'];
            $QtaSacchetto = $rowFormula['qta_sac'];
            $Abilitato = $rowFormula['abilitato'];
            $Data = $rowFormula['dt_abilitato'];
            $IdAzienda = $rowFormula['id_azienda'];
            $IdUtenteProp = $rowFormula['id_utente'];
            $NumeroLotti = $rowFormula['num_lotti'];
            $QtaMiscelaInserita = $rowFormula['qta_tot_miscela'];
            $PesoLotto = $rowFormula['qta_lotto'];
            $NumeroKitSacchetti = $rowFormula['num_sac_in_lotto'];
            $MetodoCalcolo = $rowFormula['metodo_calcolo'];
        }
        $NomeAzienda = getNomeAziendaById($_SESSION['objUtility'], $IdAzienda);

        //A secondo del metodo calcolo con cui è stata salvata l'ultima volta la formula
        //stabilisco il valore di default del campo checkbox che indica appunto il metodo di calcolo        
        if ($MetodoCalcolo == $valMetodoLottiKit) {
            //Primo metodo di calcolo : impostati num lotti e kit e calcolata qta totale di miscela
            $checkedLottiKit = "checked";
            $checkedMiscelaTot = "";
        } else if ($MetodoCalcolo == $valMetodoMiscelaTot) {
            //Secondo metodo di calcolo : impostata qta tott di miscela e peso lotto e calcolati num lotti e kit            $checkedLottiKit = "checked";
            $checkedMiscelaTot = "checked";
            $checkedLottiKit = "";
        }
        //######################################################################
        //#################### GESTIONE UTENTI #################################
        //######################################################################            
        //Si recupera il proprietario della formula e si verifica se l'utente 
        //corrente ha il permesso di editare  i dati di quell'utente proprietario 
        //nelle tabelle formula, generazione_formula e accessorio_formula
        //Se non ha il permesso bisogna disabilitare i pulsanti di salvataggio...
        //############# VERIFICA PERMESSO DI SCRITTURA E MODIFICA ##############

        $arrayTabelleCoinvolte = array("formula");
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
                    <form id="ModificaFormula" name="ModificaFormula" method="POST">
                        <table width="100%" >
                            <tr>
                                <td height="42"  colspan="6" class="cella3"><?php echo $titoloPaginaModificaFormula ?></td>
                            </tr>
                            <input type="hidden" name="IdUtenteProp" id="IdUtenteProp" value="<?php echo $IdUtenteProp; ?>"></input>

                            <input type="hidden" name="DataFormula" id="DataFormula" value="<?php echo $DataFormula; ?>"></input>
                            <tr>
                                <td class="cella4"><?php echo $filtroDt ?></td>
                                <td class="cella1"><?php echo $DataFormula ?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroCodice ?></td>
                                <td class="cella1"><?php echo $CodiceFormula ?></td>
                                <input type="hidden" name="CodiceFormula" id="CodiceFormula" value="<?php echo $CodiceFormula; ?>"></input>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroDescrizione ?></td>
                                <td class="cella1"><input type="text" style="width:50%" name="DescriFormula" id="DescriFormula" value="<?php echo $DescriFormula; ?>"/></td>
                            </tr>                    
                            <tr>
                                <td class="cella4"><?php echo $filtroAbilitato ?></td>
                                <td class="cella1"><?php echo $Abilitato ?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroDt ?></td>
                                <td class="cella1"><?php echo $Data ?></td>
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
                                            if ($idAz <> $IdAzienda) {
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
                        <!--############################################################################
                            ######################## ACCESSORI #########################################
                            ############################################################################-->
                       <?php
                       $CostoTotaleAccessori = 0;
                       if (mysql_num_rows($sqlAccessori) > 0){?>
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
                                $QtaAccessorio = $rowAccessori['quantita'];
                                if ($QtaAccessorio > 0)
                                    $CostoTotaleAccessori = $CostoTotaleAccessori + number_format($QtaAccessorio * $rowAccessori['pre_acq'], 2, '.', '');
                                ?>
                                <tr>
                                    <td class="cella4"><?php echo($rowAccessori['codice']) ?></td>
                                    <td class="cella4"><?php echo($rowAccessori['descri']) ?></td>
                                    <td class="cella4"><?php echo number_format($rowAccessori['pre_acq'], 3, '.', '') . " " . $filtroEuro ?></td>
                                    <td class="cella4"><input type="text" name="QtaAcc<?php echo($NAcc); ?>" id="QtaAcc<?php echo($NAcc); ?>" value="<?php echo $QtaAccessorio; ?>" /><?php echo $rowAccessori['uni_mis'] ?></td>
                                    <td class="cella4"><?php echo number_format($QtaAccessorio * $rowAccessori['pre_acq'], 2, '.', '') . " " . $filtroEuro ?></td>
                                </tr>
                                <?php
                                $NAcc++;
                            }//End while Accessori
                            ?>
                            <tr>
                                <td class="dataRigWhite" colspan="4"><?php echo $filtroCostoTotale . " " . $filtroConfezionamento ?></td>
                                <td class="dataRigWhite"><?php echo number_format($CostoTotaleAccessori, 2, ',', '') . " " . $filtroEuro ?></td>
                            </tr>
                        </table>
                       <?php }?>

                        <!--######################################################################## -->
                        <!--###################### MATERIE PRIME ################################### -->
                        <!--######################################################################## -->   
                        <table width="100%">
                            <tr>
                                <td class="cella3" colspan="2"><?php echo $filtroMaterieCompound ?></td>
                                <td class="cella3"><?php echo $filtroCosto . " " . $filtroEuroKg ?></td>
                                <td class="cella3"><?php echo $filtroQuantita . " " . $filtroPerc ?></td>
                                <td class="cella3"><?php echo $filtroQtaPerKit ?></td>           
                                <td class="cella3"><?php echo $filtroCostoPerKit ?></td>
                                <td class="cella3"><?php echo $filtroQtaPerMiscela ?></td>
                                <td class="cella3"><?php echo $filtroCostoPerMiscela ?></td>
                                <td class="cella3"></td>
                            </tr> 
                            <?php
                            //Inizializzo le variabili numeriche utili al calcolo dei totali   
                            $CostoKitMatCompoundTotale = 0;
                            $CostoMiscelaMtTotale = 0;
                            $TotaleQtaKit = 0;
                            $TotaleQtaMiscela = 0;
                            $TotalePercentuale = 0;
                            $QuantitaPercentuale = 0;

                            //#########################################################################################
                            //Calcolo il totale delle quantita' di mat prime per poter calcolarne il valore percentuale
                            //#########################################################################################
                            $NMtPr = 1;
                            while ($rowMtPr = mysql_fetch_array($sqlMtPr)) {

                                //Quantità di materia prima per kit chimico = quantità per miscela 
                                //diviso il numero di sacchetti per il numero di scatole per lotto
//                                $QuantitaKit = $rowMtPr['quantita'] / $NumSacchettiTot;
                                $QuantitaKit = $rowMtPr['qta_kit'];
                                $TotaleQtaKit = $TotaleQtaKit + $QuantitaKit;

                                $NMtPr++;
                            }//End while calcolo totale quantita
                            //###################################################################################
                            //Visualizzo l'elenco delle materie prime PRESENTI nella tabella [generazione_formula]
                            //###################################################################################
                            $NMatPri = 1;
                            if(mysql_num_rows($sqlMtPr)>0)
                            mysql_data_seek($sqlMtPr, 0);
                            while ($rowMatPrime = mysql_fetch_array($sqlMtPr)) {

                                //Inizio prezzo
                                $CostoUnitarioKg = $rowMatPrime['pre_acq'];
                                $CostoUnitario = $rowMatPrime['pre_acq'] / 1000;

                                $QuantitaMiscela = $rowMatPrime['quantita'];
                                $CostoMiscela = $QuantitaMiscela * $CostoUnitario;

                                $CostoMiscelaMtTotale = $CostoMiscelaMtTotale + $CostoMiscela;

//                                
//                                $QuantitaKit = number_format($QuantitaMiscela / ($NumeroLotti * $NumeroKitSacchetti), 2, '.', '');
//                                $QuantitaKit = $QuantitaMiscela / ($NumeroLotti * $NumeroKitSacchetti);
                                $QuantitaKit = $rowMatPrime['qta_kit'];
                                $CostoKit = $QuantitaKit * $CostoUnitario;
                                $CostoKitMatCompoundTotale = $CostoKitMatCompoundTotale + $CostoKit;

                                //Trasformo le qta in percentuale
                                if ($TotaleQtaKit > 0)
                                    $QuantitaPercentuale = ($QuantitaKit * 100) / $TotaleQtaKit;
                                $TotalePercentuale = $TotalePercentuale + $QuantitaPercentuale;
                                ?>
                                <tr>
                                    <td  class="cella4"><?php echo $rowMatPrime['cod_mat'] ?></td>
                                    <td width="300px" class="cella4"><?php echo $rowMatPrime['descri_mat'] ?></td>
                                    <td class="cella1"><?php echo number_format($CostoUnitarioKg, 3, '.', '') . " " . $filtroEuro ?></td>
                                    <td class="cella1"><?php echo number_format($QuantitaPercentuale, 2, '.', '') . " " . $filtroPerc ?></td>
                                    <td class="cella1">
                                        <input type="text" style="width: 70px;" name="Qta<?php echo($NMatPri); ?>" id="Qta<?php echo($NMatPri); ?>" value="<?php echo $QuantitaKit ?>" /><?php echo $filtrogBreve ?>
                                    </td>
                                    <td class="cella1"><?php echo number_format($CostoKit, 2, '.', '') . " " . $filtroEuro ?></td>
                                    <td class="cella1"><?php echo $QuantitaMiscela . " " . $filtrogBreve; ?></td>	
                                    <input type="hidden" name="QtaMiscela<?php echo($NMatPri); ?>" id="QtaMiscela<?php echo($NMatPri); ?>" value="<?php echo $QuantitaMiscela; ?>"/>
                                    <td class="cella1"><?php echo number_format($CostoMiscela, 2, '.', '') . " " . $filtroEuro ?></td>
                                    <td class="cella1">
                                        <a name="EliminaMat" href="cancella_materia_prima.php?CodiceMatPrima=<?php echo($rowMatPrime['cod_mat']) ?> && CodiceFormula=<?php echo $CodiceFormula ?>&DescriMat=<?php echo $rowMatPrime['descri_mat'] ?>">
                                            <img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="<?php echo $titleElimina ?>" title="<?php echo $titleElimina ?> "/></a></td>
                                </tr>
                                <?php
                                $TotaleQtaMiscela = $TotaleQtaMiscela + $QuantitaMiscela;
                                $NMatPri++;
                            }//End While Materie Prima
                            //Visualizzazione  Costi totali e Quantita' totali
                            ?>     	
                            <tr>
                                <td width="100px" class="dataRigWhite" colspan="3"><?php echo $filtroTotali ?>
                                <td width="100px" class="dataRigWhite"><?php echo $TotalePercentuale . " " . $filtroPerc ?></td>
                                <td width="100px" class="dataRigWhite"><?php echo number_format($TotaleQtaKit, 2, '.', '') . " " . $filtrogBreve ?></td>
                                <td width="70px"  class="dataRigWhite"><?php echo number_format($CostoKitMatCompoundTotale, 2, '.', '') . " " . $filtroEuro ?></td>
                                <td width="100px" class="dataRigWhite"><?php echo $TotaleQtaMiscela . " " . $filtrogBreve ?></td>
                                <td width="70px"  class="dataRigWhite" colspan="2"><?php echo number_format($CostoMiscelaMtTotale, 2, '.', '') . " " . $filtroEuro ?></td>
                            </tr>
                        </table>

                        <?php include('../include/tabella_costi_formula.php'); ?>    

                        <table width="100%">       
                            <tr class="cella2" style="text-align: right ">
                                <td>
                                    <input type="reset"  onClick="javascript:history.back();" value="<?php echo $valueButtonAnnulla ?>"/>
                                    <input type="button" id="AggiungiAccessorio" onClick="location.href = 'aggiungi_accessorio_formula.php?CodiceFormula=<?php echo $CodiceFormula ?>'" value="<?php echo $valueButtonAggiungiAccessorio ?>" />
                                    <input type="button" id="AggiungiMatPrima" onClick="location.href = 'aggiungi_matprima_formula.php?CodiceFormula=<?php echo $CodiceFormula ?>'" value="<?php echo $valueButtonAggiungiMatPrima ?>" />
                                    <input type="button" id="Aggiorna" onclick="javascript:AggiornaCalcoli();" value="<?php echo $valueButtonAggiorna ?>" title="<?php echo $titleAggiorna ?>"/>
                                    <input type="button" id="Salva" onclick="javascript:AggiornaCalcoli();
                Modifica();" value="<?php echo $valueButtonSalva ?>" title="<?php echo $titleAggiorna ?>"/>
                                    <!--<input type="button" onclick="javascript:Duplica();" value="<?php echo $valueButtonDuplica ?>" />-->
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

                <?php
//End prima visualizzazione modifica
            } else { //Se il codice formula non e' arrivato tramite GET ma tramite POST
//##############################################################################
//////////////////////////INIZIO AGGIORNAMENTO//////////////////////////////////
//##############################################################################
                //Recupero il valore dei campi arrivati tramite POST
                $CodiceFormula = $_POST['CodiceFormula'];
                $DataFormula = $_POST['DataFormula']; //Serve per verificare l'esistenza
                $DescriFormula = str_replace("'", "''", $_POST['DescriFormula']);

                $IdUtenteProp = str_replace("'", "''", $_POST['IdUtenteProp']);

                list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);


                $MetodoCalcolo = $_POST['MetodoCalcolo'];
                foreach ($MetodoCalcolo as $key => $value) {
//                    echo "Hai selezionato il metodo: $key con valore: $value<br />";
                    $MetodoCalcolo = $value;
                }

                begin();
                $sqlAccessori = findAccessoriFormulaByCodFormula($CodiceFormula);
//                        findAccessFormByCodFormula($CodiceFormula, "scatLot", "eticLot", "sacCh", "eticCh", "OPER");
                $sqlMtPr = findMaterieFormulaByCodice($CodiceFormula, "descri_mat");
                commit();

                //##############################################################################
//#################### CALCOLO TOTALE MAT PRIME ################################
//##############################################################################
                //Calcolo il totale delle quantita per poter calcolare il valore percentuale 
                //di ogni singola qta inserita
                $TotaleQtaKit = 0;
                $NMtPr = 1;
                while ($rowMatPrime = mysql_fetch_array($sqlMtPr)) {

                    $TotaleQtaKit = $TotaleQtaKit + $_POST['Qta' . $NMtPr];
                    $NMtPr++;
                }//End while totale quantita

                $checkedMiscelaTot = "";
                $checkedLottiKit = "";
                $NumeroLotti = 0;
                $NumeroKitSacchetti = 0;
                //################ CHIMICA SFUSA ###########################################
//                if ($_POST['QtaMiscelaInserita'] > 0) {
                if ($MetodoCalcolo == $valMetodoMiscelaTot) {

                    $QtaMiscelaInserita = str_replace("'", "''", $_POST['QtaMiscelaInserita']);
                    $PesoLotto = str_replace("'", "''", $_POST['PesoLotto']);

                    $checkedMiscelaTot = "checked";
                    $checkedLottiKit = "";

                    if ($PesoLotto > 0)
                        $NumeroLotti = number_format($QtaMiscelaInserita / $PesoLotto, 2, '.', '');
                    if ($TotaleQtaKit > 0)
                        $NumeroKitSacchetti = number_format($PesoLotto / $TotaleQtaKit, 1, '.', '');
                    //################ CHIMICA CLASSICA IN KIT E LOTTI #####################
//                } else if ($_POST['NumeroKitSacchetti'] > 0 && $_POST['NumeroLotti'] > 0) {
                } else if ($MetodoCalcolo == $valMetodoLottiKit) {

                    $checkedMiscelaTot = "";
                    $checkedLottiKit = "checked";

                    $NumeroKitSacchetti = str_replace("'", "''", $_POST['NumeroKitSacchetti']);
                    $NumeroLotti = str_replace("'", "''", $_POST['NumeroLotti']);

                    $PesoLotto = $TotaleQtaKit * $NumeroKitSacchetti;
                    $QtaMiscelaInserita = $TotaleQtaKit * $NumeroKitSacchetti * $NumeroLotti;
                }


                //####################################################################
                //######### Gestione degli errori relativa all'aggiornamento  ########
                //####################################################################
                //Inizializzazione dell'errore relativo ai campi della tabella formula
                $errore = false;

                //Inizializzazione delle variabile che contano il numero di errori fatti sui campi quantita accessori e qta materia prima
                $NumErroreAcc = 0;
                $NumErroreMt = 0;

                include('./include/controllo_input_formula.php');

                if ($errore) {
                    $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                }
                //Stampo eventuali messaggi di errore oppure il messaggio vuoto
                echo $messaggio;
                ?>
                <body onLoad="<?php echo $actionOnLoad ?>">
                    <div id="mainContainer">

                        <?php include('../include/menu.php'); ?>
                        <div id="container" style="width:100%; margin:15px auto;">
                            <form id="ModificaFormula" name="ModificaFormula" method="post" >
                                <table width="100%" >
                                    <tr>
                                        <td height="42" colspan="6" class="cella3"><?php echo $titoloPaginaModificaFormula ?></td>
                                    </tr>
                                    <tr>
                                        <input type="hidden" name="IdUtenteProp" id="IdUtenteProp" value="<?php echo $IdUtenteProp; ?>"></input>
                                        <input type="hidden" name="DataFormula" id="DataFormula" value="<?php echo $DataFormula; ?>"/></input>
                                        <td class="cella4"><?php echo $filtroDt ?></td>
                                        <td class="cella1"><?php echo $DataFormula ?></td>
                                    </tr>
                                    <tr>
                                        <input type="hidden" name="CodiceFormula" id="CodiceFormula" value="<?php echo $CodiceFormula; ?>"/></input>
                                        <td class="cella4"><?php echo $filtroCodice ?></td>
                                        <td class="cella1"><?php echo $CodiceFormula ?></td>
                                    </tr>
                                    <tr>
                                        <td class="cella4"><?php echo $filtroDescrizione ?></td>
                                        <td class="cella1"><input type="text" name="DescriFormula" id="DescriFormula" style="width:50%" value="<?php echo $DescriFormula; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="cella4"><?php echo $filtroAzienda ?></td>
                                        <td class="cella1">
                                            <select name="Azienda" id="Azienda"> 
                                                <option value="<?php echo $IdAzienda . ';' . $NomeAzienda; ?>" selected=""><?php echo $NomeAzienda; ?></option>
                                                <?php
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
                                <table width="100%">
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
                                <!--############################################################################
                                ######################## ACCESSORI #########################################
                                ############################################################################-->
                                <?php 
                                $CostoTotaleAccessori = 0;
                                if(mysql_num_rows($sqlAccessori)>0){
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
                                        if (isset($_POST['QtaAcc' . $NAcc]))
                                            $QtaAccessorio = $_POST['QtaAcc' . $NAcc];
                                        if ($QtaAccessorio > 0) {
                                            $CostoTotaleAccessori = $CostoTotaleAccessori + number_format($QtaAccessorio * $rowAccessori['pre_acq'], 2, '.', '');
                                        }
                                        ?>
                                        <tr>
                                            <td class="cella4"><?php echo($rowAccessori['codice']) ?></td>
                                            <td class="cella4"><?php echo($rowAccessori['descri']) ?></td>
                                            <td class="cella4"><?php echo number_format($rowAccessori['pre_acq'], 3, '.', '') . " " . $filtroEuro ?></td>
                                            <td class="cella4"><input type="text" name="QtaAcc<?php echo($NAcc); ?>" id="QtaAcc<?php echo($NAcc); ?>" value="<?php echo $QtaAccessorio; ?>" /><?php echo $rowAccessori['uni_mis'] ?></td>
                                            <td class="cella4"><?php echo number_format($QtaAccessorio * $rowAccessori['pre_acq'], 2, '.', '') . " " . $filtroEuro ?></td>
                                        </tr>
                                        <?php
                                        $NAcc++;
                                    }//End while Accessori
                                    ?>
                                    <tr>
                                        <td class="dataRigWhite" colspan="4"><?php echo $filtroCostoTotale . " " . $filtroConfezionamento ?></td>
                                        <td class="dataRigWhite"><?php echo number_format($CostoTotaleAccessori, 2, '.', '') . " " . $filtroEuro ?></td>
                                    </tr>
                                </table>
                                <?php } ?>

                                <!--############################################################################# -->
                                <!--######################### MATERIE PRIME ##################################### -->
                                <!--############################################################################# -->
                                <table width="100%">
                                    <tr>
                                        <td class="cella3" colspan="2"><?php echo $filtroMaterieCompound ?></td>
                                        <td class="cella3"><?php echo $filtroCosto . " " . $filtroEuroKg ?></td>
                                        <td class="cella3"><?php echo $filtroQuantita . " " . $filtroPerc ?></td>
                                        <td class="cella3"><?php echo $filtroQtaPerKit ?> </td>           
                                        <td class="cella3"><?php echo $filtroCostoPerKit ?></td>
                                        <td class="cella3"><?php echo $filtroQtaPerMiscela ?></td>
                                        <td class="cella3"><?php echo $filtroCostoPerMiscela ?></td>
                                        <td class="cella3"></td>
                                    </tr> 
                                    <?php
                                    //Inizializzazione le variabili numeriche utili al calcolo Costi e Totali
                                    $CostoKitMatCompoundTotale = 0;
                                    $CostoMiscelaMtTotale = 0;
                                    $TotaleQtaMiscela = 0;

                                    $TotalePercentuale = 0;
                                    $QuantitaPercentuale = 0;
                                    $QuantitaMiscela = 0;

                                    //##################################################################################
                                    //Visualizzo l'elenco delle materie prime PRESENTI nella tabella generazione_formula
                                    //##################################################################################

                                    $NMatPri = 1;
                                    if(mysql_num_rows($sqlMtPr)>0)
                                    mysql_data_seek($sqlMtPr, 0);
                                    while ($rowMatPrime = mysql_fetch_array($sqlMtPr)) {
                                        ?>
                                        <tr>
                                            <td class="cella4"> <?php echo($rowMatPrime['cod_mat']) ?></td>
                                            <td width="300px"class="cella4"> <?php echo($rowMatPrime['descri_mat']) ?></td>

                                            <?php
                                            //Inizio prezzo

                                            $CostoUnitarioKg = $rowMatPrime['pre_acq'];
                                            $CostoUnitario = $rowMatPrime['pre_acq'] / 1000;
                                            $CostoKit = $_POST['Qta' . $NMatPri] * $CostoUnitario;
                                            if ($_POST['Qta' . $NMatPri] > 0)
                                                $CostoKitMatCompoundTotale = $CostoKitMatCompoundTotale + $CostoKit;

                                            //############ MODIFICA 25-11-2014 #################################
                                            //################ METODO DI CALCOLO 2 #############################
                                            //Se si seleziona la quantità totale della miscela da realizzare
                                            //le quantità delle varie materie prime per miscela si calcolano
                                            //in percentuale in base alla qta per kit inserita
                                            if ($MetodoCalcolo == $valMetodoMiscelaTot) {
//        if ($QtaMiscelaInserita > 0 && $TotaleQtaKit > 0) {

                                                $QuantitaMiscela = ($_POST['Qta' . $NMatPri] * $QtaMiscelaInserita) / $TotaleQtaKit;
                                            } else if ($MetodoCalcolo == $valMetodoLottiKit) {

                                                //################# METODO DI CALCOLO 1 ############################
                                                //Se si selezionano il num di kit e di lotti da realizzare
                                                //le quantità delle varie materie prime per miscela si calcolano
                                                //moltiplicando la qta per kit per il numero di lotti e per il num di kit
                                                $QuantitaMiscela = $_POST['Qta' . $NMatPri] * $NumeroKitSacchetti * $NumeroLotti;
                                            }


                                            $CostoMiscela = $QuantitaMiscela * $CostoUnitario;
                                            $CostoMiscelaMtTotale = $CostoMiscelaMtTotale + $CostoMiscela;

                                            //Trasformo le qta in percentuale
                                            if ($TotaleQtaKit > 0)
                                                $QuantitaPercentuale = ($_POST['Qta' . $NMatPri] * 100) / $TotaleQtaKit;
                                            $TotalePercentuale = $TotalePercentuale + $QuantitaPercentuale;

                                            //FORMATTO CIFRE
                                            $CostoUnitarioKg = number_format($CostoUnitarioKg, 2, '.', '');
                                            $QuantitaPercentuale = number_format($QuantitaPercentuale, 2, '.', '');
                                            $CostoKit = number_format($CostoKit, 2, '.', '');
//                                            $QuantitaMiscela = number_format($QuantitaMiscela, 2, '.', '');
                                            $CostoMiscela = number_format($CostoMiscela, 2, '.', '');
                                            ?>                                                
                                            <td class="cella1"><?php echo $CostoUnitarioKg . " " . $filtroEuro ?></td>
                                            <td class="cella1"><?php echo $QuantitaPercentuale . " " . $filtroPerc ?></td>
                                            <td class="cella1">
                                                <input type="text" style="width:70px;"name="Qta<?php echo($NMatPri); ?>" id="Qta<?php echo($NMatPri); ?>" value="<?php echo $_POST['Qta' . $NMatPri]; ?>" /><?php echo $filtrogBreve ?></td>
                                            <td class="cella1" width="100px"><?php echo $CostoKit . " " . $filtroEuro ?></td>
                                            <td class="cella1" width="100px"><?php echo number_format($QuantitaMiscela , 2, '.', ''). " " . $filtrogBreve ?></td>
                                            <input type="hidden" name="QtaMiscela<?php echo($NMatPri); ?>" id="QtaMiscela<?php echo($NMatPri); ?>" value="<?php echo $QuantitaMiscela; ?>"/>
                                            <td class="cella1" width="100px"><?php echo $CostoMiscela . " " . $filtroEuro ?></td>
                                            <td class="cella1"><a name="EliminaMat" href="cancella_materia_prima.php?CodiceMatPrima=<?php echo($rowMatPrime['cod_mat']) ?> && CodiceFormula=<?php echo $CodiceFormula ?>&DescriMat=<?php echo $rowMatPrime['descri_mat'] ?>">
                                                    <img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="<?php echo $titleElimina ?>" title="<?php echo $titleElimina ?> "/></a>
                                            </td>

                                        </tr>
        <?php
        $TotaleQtaMiscela = $TotaleQtaMiscela + $QuantitaMiscela;
        $NMatPri++;
    }//End While Materie Prima
    ?>

                                    <tr>
                                        <td width="100px" class="dataRigWhite" colspan="3"><?php echo $filtroTotali ?></td>
                                        <td width="100px" class="dataRigWhite"><?php echo number_format($TotalePercentuale, 2, '.', '') . " " . $filtroPerc ?></td>
                                        <td width="100px" class="dataRigWhite"><?php echo $TotaleQtaKit . " " . $filtrogBreve ?></td>
                                        <td width="70px"  class="dataRigWhite"><?php echo number_format($CostoKitMatCompoundTotale, 2, '.', '') . " " . $filtroEuro ?></td>
                                        <td width="100px" class="dataRigWhite"><?php echo $TotaleQtaMiscela . " " . $filtrogBreve ?></td>
                                        <td width="70px"  class="dataRigWhite" colspan="2"><?php echo number_format($CostoMiscelaMtTotale, 2, '.', '') . " " . $filtroEuro ?></td>
                                    </tr>
                                    <input type="hidden" id="TotQtaKit" name="TotQtaKit" value="<?php echo $TotaleQtaKit ?>" /> 
                                </table>

    <?php include('../include/tabella_costi_formula.php'); ?>  

                                <table width="100%">       
                                    <tr class="cella2" style="text-align: right ">
                                        <td>
                                            <input type="reset"  onClick="javascript:history.back();" value="<?php echo $valueButtonAnnulla ?>"/>
                                            <input type="button" id="AggiungiAccessorio" onClick="location.href = 'aggiungi_accessorio_formula.php?CodiceFormula=<?php echo $CodiceFormula ?>'" value="<?php echo $valueButtonAggiungiAccessorio ?>" />
                                            <input type="button" id="AggiungiMatPrima" onClick="location.href = 'aggiungi_matprima_formula.php?CodiceFormula=<?php echo $CodiceFormula ?>&NumSacTot=<?php echo $NumeroKitSacchetti * $NumeroLotti ?>'" value="<?php echo $valueButtonAggiungiMatPrima ?>" />
                                            <input type="button" id="Aggiorna" onclick="javascript:AggiornaCalcoli();" value="<?php echo $valueButtonAggiorna ?>" title="<?php echo $titleAggiorna ?>"/>
                                            <input type="button" id="Salva" onclick="AggiornaCalcoli();
                Modifica();" value="<?php echo $valueButtonSalva ?>" title="<?php echo $titleAggiorna ?>"/>
                                            <!--<input type="button" onclick="javascript:Duplica();" value="<?php echo $valueButtonDuplica ?>" />-->
                                        </td>
                                    </tr>
                                </table>

                            </form>
                        </div>


    <?php
}//End Aggiornamento
?>
                    <div id="msgLog">
                    <?php
                    if ($DEBUG) {
                        echo "</br>ActionOnLoad : " . $actionOnLoad;

                        echo "</br>Id utente prop del dato: " . $IdUtenteProp;
                        echo "</br>Id azienda proprietaria del dato: " . $IdAzienda;
                        echo "</br>Tabella formula: Aziende scrivibili: </br>";

                        for ($i = 0; $i < count($arrayAziendeScrivibili); $i++) {

                            echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
                        }
                    }
                    ?>
                    </div>
                </div><!--mainContainer-->

            </body>
            </html>














