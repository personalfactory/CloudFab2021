<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <?php
    if($DEBUG) ini_set('display_errors', "1");
    //############# STRINGHE UTENTI - AZIENDE VISIBILI###########################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    //Si verifica se l'utente ha il permesso di editare la tabella lab_esperimenti (116)
    $strUtentiAziendeEsper = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_esperimento');
    $strUtentiAziendeAccessori = getStrUtAzVisib($_SESSION['objPermessiVis'], 'accessorio');
    
    //########## AZIENDE SCRIVIBILI ############################################
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'lab_esperimento');
    ?>
    <body onload="document.getElementById('CodiceBarre').focus()">
        <div id="labContainer">
            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../include/gestione_date.php');
            include('../include/precisione.php');
            include('../include/funzioni.php');
            include('./sql/script.php');
            include('./sql/script_lab.php');
            include('./sql/script_lab_peso.php');
            include('./sql/script_lab_esperimento.php');
            include('./sql/script_lab_bilancia.php');
            include('./sql/script_lab_risultato_matpri.php');
            ?>
<script language="javascript" src="../js/popup.js"></script>
            <script language="javascript">
        function Carica() {
            document.forms["InserisciLabEsperimento"].action = "carica_lab_primo_esperimento2.php";
            document.forms["InserisciLabEsperimento"].submit();
        }
        function AggiornaCalcoli() {
            document.forms["InserisciLabEsperimento"].action = "carica_lab_esperimento.php";
            document.forms["InserisciLabEsperimento"].submit();
        }
        //Funzioni per la visualizzazione del form relativo al tipo
        function visualizzaListBoxTipoEsistente() {
            document.getElementById("TipoEs").style.visibility = "visible";
            document.getElementById("TipoNu").style.visibility = "hidden";

        }
        function visualizzaFormNuovoTipo() {
            document.getElementById("TipoEs").style.visibility = "hidden";
            document.getElementById("TipoNu").style.visibility = "visible";

        }
        function preparaEsperimentoTablet() {
            document.forms["InserisciLabEsperimento"].action = "carica_lab_esperimento_per_tablet.php";
            document.forms["InserisciLabEsperimento"].submit();
        }
            </script>

            <?php
//###################### NOTA BENE #############################################
//Le variabili contenenti la stringa "acqua" o "ac" si riferiscono a tutti i 
//parametri di tipo PercentualeSI
//##############################################################################      
//##############################################################################
//####################### INIZIO PRIMO CARICAMENTO PAGINA ######################
//##############################################################################
//Se il codice formula non e'  stato settato allora viene visualizzata la form di inserimento vuota
            if ((!isset($_POST['CodiceBarreOld']) || $_POST['CodiceBarreOld'] == "")) {

                $_SESSION['carica_pagina'] = 0;
                $sqlTipoProva = findAllEspVis("tipo", "tipo",$strUtentiAziendeEsper);
                ?>

                <div id="container" style="width:70%; margin:15px; font-size:16px">
                    <form id="InserisciLabEsperimento" name="InserisciLabEsperimento" method="post" >
                        <input type="hidden" name="starttime" id="starttime"  />
                        <table style="width:100%;">

                            <th  colspan="2" class="cella3"><?php echo $titoloLabPagNuovaProva ?></th>
                            <tr>
                                <td class="cella2"><?php echo $filtroLabTipoProva ?></td>
                                <td>
                                    <table  width="100%">
                                        <tr>
                                            <td class="cella1">
                                                <input type="radio" id="scegli_tipo" name="scegli_tipo" onclick="javascript:visualizzaListBoxTipoEsistente();" value="TipoEs" checked="checked"/><?php echo $filtroLabEsistente ?></td>
                                            <td class="cella1">
                                                <div id="NomeTipoEsistente" >
                                                    <select id="TipoEs" name="TipoEs">
                                                        <option value="" selected=""><?php echo $labelOptionSelectTipo ?> </option>
                                                        <?php
                                                        
                                                        while ($rowTipoProva = mysql_fetch_array($sqlTipoProva)) {
                                                            ?>
                                                            <option value="<?php echo($rowTipoProva['tipo']) ?>"><?php echo($rowTipoProva['tipo']) ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div></td>
                                        </tr>
                                        <tr>
                                            <td class="cella1" title="<?php echo $titleLabDigitaProdOb ?>">
                                                <input type="radio" id="scegli_tipo" name="scegli_tipo" onclick="javascript:visualizzaFormNuovoTipo();" value="TipoNu" /><?php echo $filtroLabNuovo ?></td>
                                            <td class="cella1">
                                                <div id="NomeTipoNuovo" style="visibility:hidden;" >
                                                    <textarea name="TipoNu" id="TipoNu" ROWS=1 COLS=30 title="<?php echo $titleLabDigitaTipo ?>"/></textarea>
                                                </div></td>
                                        </tr> 
                                    </table>
                                </td>
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
                            <tr>
                                <td colspan="2" class="cella2"><?php echo $msgLabInserCodBarreProvaOld ?></td> 
                            </tr>
                            <tr>
                                <td  class="cella1"><?php echo $filtroLabCodBarre ?></td>
                                <td class="cella1"><input type="text" name="CodiceBarreOld" id="CodiceBarreOld" />
                                <input type="button" value="<?php echo $valueButtonTablet?>" onClick="javascript:preparaEsperimentoTablet();" /></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="cella2"><?php echo $msgLabInserCodBarreProvaNew ?></td>
                            </tr>
                            <tr>
                                <td width="300" class="cella1"><?php echo $filtroNuovo . " " . $filtroLabCodBarre ?></td>
                                <td class="cella1"><input type="text" name="CodiceBarre" id="CodiceBarre" /></td>
                            </tr>    
                            <tr>
                                <td colspan="2" class="cella2"><?php echo $msgLabPosizionareMiscela ?></td>
                            </tr>
                           
                            <tr>
                                <td class="cella2" colspan="2" style="text-align:right">
                                    <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                    <input type="button" value="<?php echo $valueButtonConferma ?>" onClick="javascript:AggiornaCalcoli();"  />                                   
                                    
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <?php
            }// End primo caricamento pagina
//##############################################################################
//####################### AGGIORNAMENTO PAGINA #################################
//##############################################################################
//Se il codice  formula e' stato settato tramite un POST allora viene effettuato l'aggiornamento della pagina
//Vengono calcolate e visualizzate le Quantit&agrave; delle materie prime della formula scelta

            if ((isset($_POST['CodiceBarreOld']) && $_POST['CodiceBarreOld'] != "")) {

                //Incremento la variabile aggiornamento per aggiornare la sessione e mantenerla in vita pi� a lungo.
                $_SESSION['aggiornamento']++;
                //Incremento la variabile che indica il numero di aggiornamenti fatti sulla pagina
                //Utile per le azioni da eseguire solo al primo aggiornamento 
                $_SESSION['carica_pagina']++;

                $errore = false;
                $messaggio = "";

                if (!isset($_POST['CodiceBarre']) || $_POST['CodiceBarre'] == "") {

                    $errore = true;
                    $messaggio = $messaggio . " " . $msgErrCodice . '<br/>';
                }
                if (!isset($_POST['scegli_tipo']) || $_POST['scegli_tipo'] == "") {
                    $errore = true;
                    $messaggio = $messaggio . " " . $msgErrTipo . '<br/>';
                }
                
                $CodiceBarreOld = $_POST['CodiceBarreOld'];
                $CodiceBarre = $_POST['CodiceBarre'];
                $PostTipo = $_POST['scegli_tipo'];
                 $Tipo = "";
                if ($PostTipo == "TipoEs") {
                    $Tipo = $_POST['TipoEs'];
                } else if ($PostTipo == "TipoNu") {
                    $Tipo = str_replace("'", "''", $_POST['TipoNu']);
                }
                
                list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
                
                //Verifica esistenza vecchio codice a barre
                $sqlCodOldEsiste = verificaEsistenzaCodice($CodiceBarreOld);

                if (mysql_num_rows($sqlCodOldEsiste) == 0) {
                    //Se entro nell'if vuol dire che esiste
                    $errore = true;
                    $messaggio = $messaggio . " " . $msgErrCodOldBarre . '<br/>';
                }

                $sqlCodEsiste = verificaEsistenzaCodice($CodiceBarre);
                if (mysql_num_rows($sqlCodEsiste) != 0) {
                    //Se entro nell'if vuol dire che esiste
                    $errore = true;
                    $messaggio = $messaggio . " " . $msgErrCodBarre . '<br/>';
                }


                //Estraggo il codice formula dell'esperimento                
                $sqlProva = findIdEsperimentoByCod($CodiceBarreOld);
                $IdEsperimento = 0;
                $CodiceFormula = "";
                while ($rowProva = mysql_fetch_array($sqlProva)) {
                    
                    $IdEsperimento = $rowProva['id_esperimento'];
                    $CodiceFormula = $rowProva['cod_lab_formula'];
                    $IdUtente = $rowProva['id_utente'];
                    $IdAzienda = $rowProva['id_azienda'];
                }


                //Solo al primo aggiornamento avviene l'azzeramento della tabella [lab_peso] 
                //e l'inizializzazione della stessa con i codici delle materie prime 
                //oggetto di variazione relativi alla formula selezionata e le Quantita nulle 
                //e con le altre qta delle materie prime che in realta non verranno pesate 
                //ma sono considerate fisse per la formula.
            

                //Calcolo il totale reale di miscela effettuata nell'esperimento precedente 
                $QtaTotMiscela = 0;
                $sqlQtaTot = findQtaTotMatPrimeByIdEsper($IdEsperimento);
                $rowQtaTot = mysql_fetch_row($sqlQtaTot);
               
                $QtaTotMiscela = $rowQtaTot[0];


                if ($_SESSION['carica_pagina'] == 1) {

                    $_SESSION['PesoMiscela'] = 0;
                    //Leggo il peso dalla bilancia
                    $sqlPesoMiscela = findBilanciaByIdMacchina($_SESSION['lab_macchina']);
                    while ($rowPesoMiscela = mysql_fetch_array($sqlPesoMiscela)) {

                       $_SESSION['PesoMiscela'] = $rowPesoMiscela['bilancia1'] + $rowPesoMiscela['bilancia2'] + $rowPesoMiscela['bilancia3'];
                    }


                    //Calcolo il totale reale di miscela effettuata nell'esperimento precedente 
                    $QtaTotMiscela = 0;
                    $sqlQtaTot = findQtaTotMatPrimeByIdEsper($IdEsperimento);
                    $rowQtaTot = mysql_fetch_row($sqlQtaTot);
                    
                    $QtaTotMiscela = $rowQtaTot[0];

                    $delete = true;
                    $initMatVar = true;
                    $initCompVar = true;
                    $initPar = true;
                    $initParNoPerc = true;
                    $initAccessori=true;
                    
                    
                    
                    begin();
                    //Azzero la tabella [lab_peso] 
                    $delete = deleteLabPeso($_SESSION['lab_macchina']);

                    $initMatVar = inizializzaLabPesoMatPriKeVaria($QtaTotMiscela, $CodiceBarre, $IdEsperimento, $_SESSION['PesoMiscela'], $_SESSION['lab_macchina'], $CodiceFormula, $valTipoMatCompound,$Tipo,$_SESSION['id_utente'],$IdAzienda);

                    $initCompVar = inizializzaLabPesoCompKeVaria($QtaTotMiscela, $CodiceBarre, $IdEsperimento, $_SESSION['PesoMiscela'], $_SESSION['lab_macchina'], $CodiceFormula, $valTipoMatDryMix,$Tipo,$_SESSION['id_utente'],$IdAzienda);

                    $initPar = inizializzaLabPesoPar($QtaTotMiscela, $CodiceBarre, $IdEsperimento, $_SESSION['lab_macchina'], $_SESSION['PesoMiscela'], $CodiceFormula, $PercentualeSI,$Tipo,$_SESSION['id_utente'],$IdAzienda);

                    $initParNoPerc = inizializzaLabPesoParPercNO($QtaTotMiscela, $CodiceBarre, $IdEsperimento, $_SESSION['lab_macchina'], $_SESSION['PesoMiscela'], $CodiceFormula, $PercentualeNO,$Tipo,$_SESSION['id_utente'],$IdAzienda);
                    
                    $initAccessori=inizializzaLabPesoAccessori($_SESSION['lab_macchina'],$CodiceFormula,$CodiceBarre,$valTipoAccessori,$_SESSION['PesoMiscela'],$Tipo,$_SESSION['id_utente'],$IdAzienda,$strUtentiAziendeAccessori);

                    if (!$delete OR !$initMatVar OR !$initCompVar OR !$initPar OR !$initParNoPerc) {

                        $errore = true;
                        $messaggio = $messaggio . " " . $msgErrLabInitPeso . '<br/>';
                    } else {
                        commit();
                    }
                }

                if ($errore) {
                    $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                    echo '<div id="msgErr">' . $messaggio . '</div>';
                }

                //Calcolo del numero dell'esperimento corrente relativo alla formula selezionata
                $sqlEsper = selectMaxNumEsperimento($CodiceFormula);

                $NumEsperimento = 0;
                while ($rowEsper = mysql_fetch_array($sqlEsper)) {
                    $NumEsperimento = $rowEsper['num_prova_tot'];
                }
                $NumEsperimento = $NumEsperimento + 1;
                ?>
                <!--############################################################################-->            
                <!--###### Visualizzo l'anagrafe dell'esperimento ##############################-->
                <!--############################################################################-->  

                <div id="container" style="width:70%; margin:15px;">
                    <form id="InserisciLabEsperimento" name="InserisciLabEsperimento" method="post" >
                        <input type="hidden" name="Formula" id="Formula" value="<?php echo $CodiceFormula; ?>"/>
                        <input type="hidden" name="CodiceBarreOld" id="CodiceBarreOld" value="<?php echo $CodiceBarreOld; ?>"/>
                        <input type="hidden" name="Tipo" id="Tipo" value="<?php echo $Tipo ?>"/>
                        <table  style="width:100%;">
                            <th  colspan="2" class="cella3"><?php echo $titoloLabPagNuovaProva . ": " . $CodiceFormula; ?></th>
                             <tr>
                                <td class="cella2"><?php echo $filtroLabTipo ?></td>
                                <td class="cella1"><?php echo $Tipo ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroLabCodBarre ?></td>
                                <td class="cella1">
                                    <input type="text" name="CodiceBarre" id="CodiceBarre" value="<?php echo $CodiceBarre; ?>"/></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroLabDataRegistrazione ?></td>
                                <td class="cella1"><?php echo dataCorrenteVisualizza(); ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroLabEsperimentiFatti ?></td>
                                <td class="cella1"><?php echo $NumEsperimento; ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroLabQtaTotMiscela ?></td>
                                <td class="cella1"><input type="text" name="PesoMiscela" id="PesoMiscela" value="<?php echo $_SESSION['PesoMiscela']; ?>"/><?php echo $filtrogBreve?></td>
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
                        <!--################################################################################-->            
                        <!--### Visualizzo le materie prime associate alla formula con le qta relative #####-->
                        <!--### al primo esperimento fatto sulla stessa formula ############################-->  
                        <!--################################################################################-->    
                        <table  style="width:100%;"> 
                            <tr>
                                <th class="cella3" width="40%" colspan="2"><?php echo $filtroMaterieCompound ?></th>
                                <td class="cella3" width="10%" title="<?php echo $titleLabQtaTeo ?>"><?php echo $filtroLabQtaPercTeorica ?></td>
                                <td class="cella3" width="10%" title="<?php echo $titleLabQtaPercReale ?>"><?php echo $filtroLabQtaPercReale ?></td>
                                <td class="cella3" width="15%" colspan="2" ><?php echo $filtroLabPesoReale ?></td>
                            </tr> 
    <?php
    //Inizializzo i totali
    $QuantitaPercTotReale = 0;
    $QuantitaRealeTot = 0;
    $QuantitaPercReale = 0;

    $sqlMatPrime = findPeso($CodiceFormula, $_SESSION['lab_macchina'], $valTipoMatCompound);
    $sqlComp = findPeso($CodiceFormula, $_SESSION['lab_macchina'], $valTipoMatDryMix);
    $sqlParAcqua = findPeso($CodiceFormula, $_SESSION['lab_macchina'], $PercentualeSI);
    $sqlPar = findPeso($CodiceFormula, $_SESSION['lab_macchina'], $PercentualeNO);
    $NMatPri = 1;
    while ($rowMatPrime = mysql_fetch_array($sqlMatPrime)) {

        $QtaTeoNew = 0;
        ?>

                                <tr>
                                    <td class="cella4"><?php echo($rowMatPrime['codice']) ?></td>
                                    <td class="cella4"><?php echo($rowMatPrime['descri']) ?></td>
                                    <td class="cella2"><?php echo number_format($rowMatPrime['qta_teo'], $PrecisioneQta, '.', '') . " " . $filtroLabPerc ?></td>
                                    <td class="cella1"><?php echo number_format($rowMatPrime['qta'], $PrecisioneQta, '.', '') . " " . $filtroLabPerc ?></td>
                                    <td class="cella1">
                                        <input type="text" style="width: 80px;" name="Qta<?php echo($NMatPri); ?>" id="Qta<?php echo($NMatPri); ?>" value="<?php echo $rowMatPrime['peso']; ?>"/><?php echo $filtrogBreve ?> 
                                    </td>

                                    <!--Passaggio per riferimento dei dati utili alla Pesa -->		
                                    <td class="cella1">
                                        <a href="JavaScript:openWindow('carica_lab_peso.php?DatiPesa=<?php echo ($rowMatPrime['descri']) . ";" . ($rowMatPrime['codice']) . ";" . $QtaTeoNew.";".$valMateriaPrima; ?>')">
                                            <img src="/CloudFab/images/pittogrammi/bilancia_media_R.png" class="icone" title="Clicca per pesare"/></a>
                                    </td>	      
                                </tr>
        <?php
        $QuantitaRealeTot = $QuantitaRealeTot + $rowMatPrime['peso'];

        $NMatPri++;
    }//End While materie prime 
    ?>
                            <!--################################################################################-->            
                            <!--### Visualizzo i componenti associati alla formula con le qta relative #########-->
                            <!--### al primo esperimento fatto sulla stessa formula ############################-->  
                            <!--################################################################################-->   

                            <tr>     
                                <th class="cella3" width="40%" colspan="2"><?php echo $filtroMaterieDrymix ?></th>
                                <td class="cella3" width="10%" title="<?php echo $titleLabQtaTeo ?>"><?php echo $filtroLabQtaPercTeorica ?></td>
                                <td class="cella3" width="10%" title="<?php echo $titleLabQtaPercReale ?>"><?php echo $filtroLabQtaPercReale ?></td>
                                <td class="cella3" width="15%" colspan="2" ><?php echo $filtroLabPesoReale ?></td>
                            </tr> 
    <?php
    $QuantitaPercRealeComp = 0;
    $NComp = 1;
    while ($rowComp = mysql_fetch_array($sqlComp)) {
        //Calcolo della qta di mat prima in base al totale di miscela digitato ed alle percentuali definite nella formula
        $QtaTeoNew = 0;
        ?>

                                <tr>
                                    <td class="cella4"><?php echo($rowComp['codice']) ?></td>
                                    <td class="cella4"><?php echo($rowComp['descri']) ?></td>
                                    <td class="cella2"><?php echo number_format($rowComp['qta_teo'], $PrecisioneQta, '.', '') . " " . $filtroLabPerc ?></td>
                                    <td class="cella1"><?php echo number_format($rowComp['qta'], $PrecisioneQta, '.', '') . " " . $filtroLabPerc ?></td>
                                    <td class="cella1" width="95px">
                                        <input type="text" style="width:80px;" name="QtaComp<?php echo($NComp); ?>" id="QtaComp<?php echo($NComp); ?>" value="<?php echo $rowComp['peso']; ?>"/><?php echo $filtrogBreve ?>
                                    </td>
                                    <!--Passaggio per riferimento dei dati utili alla Pesa -->		
                                    <td class="cella1">
                                        <a href="JavaScript:openWindow('carica_lab_peso.php?DatiPesa=<?php echo ($rowComp['descri']) . ";" . ($rowComp['codice']) . ";" . $QtaTeoNew.";".$valMateriaPrima; ?>')">
                                            <img src="/CloudFab/images/pittogrammi/bilancia_media_R.png" class="icone" title="Clicca per pesare"/></a>
                                    </td>	      
                                </tr>
        <?php
        $QuantitaRealeTot = $QuantitaRealeTot + $rowComp['peso'];

        $NComp++;
    }//End While materie prime 
    ?>
                            <tr>
                                <td colspan="4" class="cella2" ><?php echo $filtroLabQtaTotMiscela ?> </td>
                                <td class="cella2" colspan="2"><?php echo $QuantitaRealeTot . " " . $filtrogBreve; ?></td>
                            </tr>

                            <input type="hidden" name="QtaMiscela" id="QtaMiscela" value="<?php echo $QuantitaRealeTot; ?>"/>

                        </table>
                        <!--################################################################################-->            
                        <!--### Visualizzo i parametri di tipo PercentualeSI con le qta relative ###########-->
                        <!--### al primo esperimento fatto sulla stessa formula ############################-->  
                        <!--################################################################################--> 
                        <table style="width:100%;">    	
                            <tr>
                                <th class="cella3"><?php echo $filtroLabParametri ?></th>
                                <td class="cella3"><?php echo $filtroLabUnMisura ?></td>
                                <td class="cella3" title="<?php echo $titleLabQtaTeo ?>"><?php echo $filtroLabValoreTeo ?></td>
                                <td class="cella3" title="<?php echo $titleLabQtaPercReale ?>"><?php echo $filtroLabValoreReale ?></td>
                                <td class="cella3" colspan="2"><?php echo $filtroLabValore ?></td>

                            </tr> 
    <?php
    //Visualizzo i parametri di tipo PercentualeSI presenti nella tabella [lab_risultato_par] 
    $QtaAcPercReale = 0;

    $NParAcqua = 1;
    while ($rowParAcqua = mysql_fetch_array($sqlParAcqua)) {
        $QtaAcNew = 0;

        //Percentuale reale dei parametri di tipo PercentualeSI 
        //pesata nell'esperimento di origine
        $QtaAcPercReale = number_format($rowParAcqua['qta_teo'], $PrecisioneQta, '.', '');
        $QtaPercAcqua = number_format($rowParAcqua['qta'], $PrecisioneQta, '.', '');
//Seleziono dalla FORMULA TEORICA la percentuale per visualizzarla 
        ?>

                                <tr>
                                    <td class="cella4"><?php echo($rowParAcqua['codice']) ?></td>
                                    <td class="cella2"><?php echo($rowParAcqua['uni_mis']) ?></td>
                                    <td class="cella2"><?php echo($QtaPercAcqua . " " . $filtroLabPerc); ?></td>
                                    <td class="cella2"><?php echo($QtaAcPercReale . " " . $filtroLabPerc); ?></td>
                                    <td class="cella1" width="95px">
                                        <input type="text" style="width: 80px;" name="QtaAc<?php echo($NParAcqua); ?>" id="QtaAc<?php echo($NParAcqua); ?>" value="<?php echo $rowParAcqua['peso']; ?>"/>
                                    </td>
                                    <!--Passaggio per riferimento dei dati relativi alla pesa dei parametri di tipo PercentualeSI -->
                                    <td class="cella1">
                                        <a href="JavaScript:openWindow('carica_lab_peso.php?DatiPesa=<?php echo ($rowParAcqua['descri']) . ";" . ($rowParAcqua['codice']) . ";" . $QtaAcNew.";".$valParametro; ?>')">
                                            <img src="/CloudFab/images/pittogrammi/bilancia_media_R.png" class="icone" title="Clicca per pesare"/></a>
                                    </td>	
                                </tr>
        <?php
        $NParAcqua++;
    }//End While parametri
    //
              //################################################################################-->            
    //### Visualizzo i parametridi tipo PercentualeNO  ################################-->
    //### con le qta relative al primo esperimento fatto sulla stessa formula ########-->  
    //################################################################################--> 

    $NPar = 1;
    while ($rowPar = mysql_fetch_array($sqlPar)) {
        ?>
                                <tr>
                                    <td class="cella4"><?php echo($rowPar['codice']) ?></td>
                                    <td class="cella2"><?php echo($rowPar['uni_mis']); ?></td>
                                    <td class="cella2"><?php echo($rowPar['qta_teo']); ?></td>
                                    <td class="cella2"></td>
                                    <td class="cella1"colspan="2"><input type="text" style="width: 70px;" name="Valore<?php echo($NPar); ?>" id="Valore<?php echo($NPar); ?>" value="<?php echo ($rowPar['qta']); ?>"/></td>
                                </tr>                         
        <?php
        $NPar++;
    }//End While parametri PercentualeNO
    ?>

                            <tr>
                                <td class="cella2" style="text-align:right" colspan="6">
                                    <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="location.href = 'gestione_lab_esperimenti.php';"/>
                                    <input type="button" value="<?php echo $valueButtonSalva ?>" onClick="javascript:Carica();"  /></td>
                            </tr>
                        </table>
                    </form>
                </div>
    <?php
//    }//End Aggiornamento $_POST[Formula]
}//If errore esistenza codice a barre
?>
<div id="msgLog">
                <?php
                if ($DEBUG) {
                   
                    echo "</br>Tab lab_esperimento : Utenti e aziende visibili " . $strUtentiAziendeEsper;
                   
                    echo "</br>Tabella lab_esperimento: AZIENDE SCRIVIBILI: ";
                    for ($i = 0; $i < count($arrayAziendeScrivibili); $i++) {

                        echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
                    }
                }
                ?>
            </div>
        </div><!--mainContainer-->

    </body>
</html>
