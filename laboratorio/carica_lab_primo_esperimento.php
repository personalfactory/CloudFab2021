<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <?php
    if ($DEBUG)
        ini_set('display_errors', 1);
    //############# STRINGHE UTENTI - AZIENDE VISIBILI###########################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziendeFormula = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_formula');
    $strUtentiAziendeEsper = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_esperimento');
    $strUtentiAziendeAccessori = getStrUtAzVisib($_SESSION['objPermessiVis'], 'accessorio');
    //TO DO completare la gestione utenti dbutente aggiungere alla funzione di creazione esperimento
    //la tabella accessorio
    //########## AZIENDE SCRIVIBILI ############################################
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'lab_esperimento');
    ?>
    <body onload="document.getElementById('CodiceBarre').focus()">

        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../include/gestione_date.php');
            include('../include/precisione.php');
            include('../include/funzioni.php');
            include('./sql/script.php');
            include('./sql/script_lab.php');
            include('./sql/script_lab_formula.php');
            include('./sql/script_lab_esperimento.php');
            include('./sql/script_lab_peso.php');
            include('../sql/script_accessorio.php');
            ?>

            <script type="text/javascript" src="../js/popup.js"></script>

            <script language="javascript">
        function Carica() {
            document.forms["InserisciLabMiscela"].action = "carica_lab_primo_esperimento2.php";
            document.forms["InserisciLabMiscela"].submit();
        }
        function AggiornaCalcoli() {
            document.forms["InserisciLabMiscela"].action = "carica_lab_primo_esperimento.php";
            document.forms["InserisciLabMiscela"].submit();
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
            </script>

            <?php
//##############################################################################
//##################### INIZIO PRIMO CARICAMENTO PAGINA ########################
//##############################################################################
//Se il codice formula non e'stato settato allora viene visualizzata la form di inserimento vuota
            if ((!isset($_POST['Formula']) || $_POST['Formula'] == "")) {

                $_SESSION['carica_pagina'] = 0;

                

                $_SESSION['FiltroCodLabFormula']="";
                if (isset($_POST['FiltroCodLabFormula']) AND $_POST['FiltroCodLabFormula'] != "") {
                    $_SESSION['FiltroCodLabFormula'] = trim($_POST['FiltroCodLabFormula']);
                }
//                $_SESSION['QtaMiscela']=0;
//                if (isset($_POST['QtaMiscela']) AND $_POST['QtaMiscela'] != "") {
//                    $_SESSION['QtaMiscela'] = trim($_POST['QtaMiscela']);
//                }
//                $_SESSION['CodiceBarre']="";
//                if (isset($_POST['CodiceBarre']) AND $_POST['CodiceBarre'] != "") {
//                    $_SESSION['CodiceBarre'] = trim($_POST['CodiceBarre']);
//                }
//                $_SESSION['scegli_tipo']="";
//                if (isset($_POST['scegli_tipo']) AND $_POST['scegli_tipo'] != "") {
//                    $_SESSION['scegli_tipo'] = trim($_POST['scegli_tipo']);
//                }
                
                                

                $sqlCodFormula = findAllLabFormuleByCod("cod_lab_formula", $strUtentiAziendeFormula, $_SESSION['FiltroCodLabFormula'],$_SESSION['visibilita_utente']);
//                    $sqlCodFormula = findAllLabFormule("cod_lab_formula",$strUtentiAziendeFormula);
                /* if ($_SESSION['nome_gruppo_utente'] == 'Amministrazione') {

                  $sqlCodFormula = findAllLabFormule("cod_lab_formula",$strUtentiAziendeFormula);
                  } else {//Altrimenti visualizza solo i codici formula dell'utente o del gruppo dell'utente
                  $sqlCodFormula = findFormuleVisByGruppo("cod_lab_formula", $_SESSION['username'], $_SESSION['nome_gruppo_utente'],$strUtentiAziendeFormula);
                  } */
                $sqlTipoProva = findAllEspVis("tipo", "tipo", $strUtentiAziendeEsper);
                ?>

                <div id="container" style="width:70%; margin:15px ; ">
                    <form id="InserisciLabMiscela" name="InserisciLabMiscela" method="post" >
                        <input type="hidden" name="starttime" id="starttime"  />
                        <table style="width:100%">

                            <th  colspan="2" class="cella3"><?php echo $titoloLabPagNuovaProva ?></th>
                            <tr>
                                <td  class="cella2"><?php echo $filtroLabFormula ?></td>
                                <td class="cella1">
                                    <select name="Formula" id="Formula">
                                        <option value="" selected="selected"><?php echo $labelOptionSelectFormula ?></option>
                                        <?php
                                        while ($rowCodFormula = mysql_fetch_array($sqlCodFormula)) {
                                            ?>
                                            <option value="<?php echo ($rowCodFormula['cod_lab_formula']) ?>"><?php echo ($rowCodFormula['cod_lab_formula']); ?></option>
                                        <?php }//End while codici formula    ?>
                                    </select> 
                                    <input type="text" name="FiltroCodLabFormula" value="<?php echo $_SESSION['FiltroCodLabFormula'] ?>" placeholder="<?php echo $placeHolderCercaFormula ?>" />
                                    <img src="/CloudFab/images/icone/lente_piccola.png" onClick="AggiornaCalcoli();" title="<?php echo $titleRicerca ?>"/></td>
                            </tr>
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
                                <td class="cella2"><?php echo $filtroLabQtaTotMiscela ?></td>
                                <td class="cella1"><input type="text" name="QtaMiscela" id="QtaMiscela" value=""/><?php echo $filtrogBreve ?></td>
                            </tr>
                            <tr>
                                <td  class="cella2" ><?php echo $filtroLabCodBarre ?></td>
                                <td class="cella1"><input type="text" name="CodiceBarre" id="CodiceBarre" /></td>
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
                                <td class="cella2" colspan="2" style="text-align:right">
                                    <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                    <input type="button" value="<?php echo $valueButtonConferma ?>"  onclick="javascript:AggiornaCalcoli();" /></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <?php
            }// End primo caricamento pagina
//##############################################################################
//####################### INIZIO AGGIORNAMENTO PAGINA ##########################
//##############################################################################
//Se il codice  formula e' stato settato tramite POST allora viene effettuato l'aggiornamento della pagina
//Vengono calcolate e visualizzate le Quantita delle materie prime della formula scelta

            if (isset($_POST['Formula']) && $_POST['Formula'] != "") {
                $errore = false;
                $messaggio = "";
                $erroreInit = false;
                $messaggioInit = "";
                
                if (!isset($_POST['CodiceBarre']) || $_POST['CodiceBarre'] == "") {
                    $errore = true;
                    $messaggio = $messaggio . " " . $msgErrCodice . '<br/>';
                }
                if (!isset($_POST['QtaMiscela']) || $_POST['QtaMiscela'] == "") {
                    $errore = true;
                    $messaggio = $messaggio . " " . $msgErrQtaMiscela . '<br/>';
                }
                if (!isset($_POST['scegli_tipo']) || $_POST['scegli_tipo'] == "") {
                    $errore = true;
                    $messaggio = $messaggio . " " . $msgErrTipo . '<br/>';
                }

                
                //Incremento la variabile aggiornamento per aggiornare la sessione 
                $_SESSION['aggiornamento'] ++;
                //Definisco la variabile che indica il numero di aggiornamenti fatti sulla pagina
                $_SESSION['carica_pagina'] ++;

                //Ricavo il valore dei campi arrivati tramite POST 
                $CodiceFormula = $_POST['Formula'];
                $QtaMiscela = $_POST['QtaMiscela'];
                $CodiceBarre = $_POST['CodiceBarre'];
                $PostTipo = $_POST['scegli_tipo'];
                $Tipo = "";
                if ($PostTipo == "TipoEs") {
                    $Tipo = $_POST['TipoEs'];
                } else if ($PostTipo == "TipoNu") {
                    $Tipo = str_replace("'", "''", $_POST['TipoNu']);
                }

                //Verifica esistenza codice a barre
                $sqlCodEsiste = verificaEsistenzaCodice($CodiceBarre);

                if (mysql_num_rows($sqlCodEsiste) != 0) {
                    //Se entro nell'if vuol dire che esiste                   
                    $errore = true;
                    $messaggio = $messaggio . " " . $msgErrCodBarre . '<br/>';
                }
                list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
                
                
                if ($errore) {

                    $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                    echo '<div id="msgErr">' . $messaggio . '</div>';
                } else {
                
//################################################################
//##################### INIZIALIZZAZIONE PESA ####################
//################################################################                        
                //Solo al primo aggiornamento avviene l'azzeramento della tabella [lab_peso] e 
                //l'inizializzazione della stessa con i codici delle materie prime relativi 
                //alla formula selezionata e con le quantita nulle.
                $delete = true;
                $initMat = true;
                $initComp = true;
                $initPar = true;
                $initParNO = true;
                $initAccessori = true;

                if ($_SESSION['carica_pagina'] == 1) {


                    begin();
                    $delete = deleteLabPeso($_SESSION['lab_macchina']);

                    $initMat = inizializzaLabPesoCodMat($CodiceBarre, $CodiceFormula, $_SESSION['lab_macchina'], $valDefaultLabPeso, $valTipoMatCompound, $QtaMiscela, $Tipo, $_SESSION['id_utente'], $IdAzienda);

                    $initComp = inizializzaLabPesoComp($CodiceBarre, $CodiceFormula, $_SESSION['lab_macchina'], $valDefaultLabPeso, $valTipoMatDryMix, $QtaMiscela, $Tipo, $_SESSION['id_utente'], $IdAzienda);

                    $initPar = inizializzaLabPesoParametri($CodiceBarre, $CodiceFormula, $PercentualeSI, $_SESSION['lab_macchina'], $valDefaultLabPeso, $QtaMiscela, $Tipo, $_SESSION['id_utente'], $IdAzienda);
                    $initParNO = inizializzaLabPesoParametri($CodiceBarre, $CodiceFormula, $PercentualeNO, $_SESSION['lab_macchina'], $valDefaultLabPeso, $QtaMiscela, $Tipo, $_SESSION['id_utente'], $IdAzienda);


                    $initAccessori = inizializzaLabPesoAccessori($_SESSION['lab_macchina'], $CodiceFormula, $CodiceBarre, $valTipoAccessori, $QtaMiscela, $Tipo, $_SESSION['id_utente'], $IdAzienda, $strUtentiAziendeAccessori);

                    if (!$delete OR ! $initMat OR ! $initComp OR ! $initPar OR ! $initParNO OR ! $initAccessori) {

                        $erroreInit = true;
                        $messaggioInit = $messaggioInit . " " . $msgErrLabInitPeso . '<br/>';
                    } else {
                        commit();
                    }
                }
                //#############################################################
                if ($erroreInit) {

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

                $sqlMatPrime = findPeso($CodiceFormula, $_SESSION['lab_macchina'], $valTipoMatCompound);
                $sqlComp = findPeso($CodiceFormula, $_SESSION['lab_macchina'], $valTipoMatDryMix);
                $sqlParAcqua = findPeso($CodiceFormula, $_SESSION['lab_macchina'], $PercentualeSI);
                $sqlPar = findPeso($CodiceFormula, $_SESSION['lab_macchina'], $PercentualeNO);
                ?>
                <!--################################################################-->            
                <!--############## ANAGRAFE ESPERIMENTO ############################-->
                <!--################################################################-->   
                <div id="container" style="width:70%; margin:15px;">
                    <form id="InserisciLabMiscela" name="InserisciLabMiscela" method="post" >

                        <table  style="width:100%;">
                            <th  colspan="2" class="cella3"> <?php echo $filtroLabPrimaProva . ": " . $CodiceFormula; ?></th>
                            <input type="hidden" name="Formula" id="Formula" value="<?php echo $CodiceFormula; ?>"/>
                            <input type="hidden" name="Tipo" id="Tipo" value="<?php echo $Tipo ?>"/>
                            <tr>
                                <td class="cella2" width="40%"><?php echo $filtroLabTipo ?></td>
                                <td class="cella1" width="60%"><?php echo $Tipo ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroLabCodBarre ?></td>
                                <td class="cella1"><?php echo $CodiceBarre; ?>
                                    <input type="hidden" name="CodiceBarre" id="CodiceBarre" value="<?php echo $CodiceBarre; ?>"/></td>
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
                                <td class="cella1"><?php echo $QtaMiscela; ?>
                                    <input type="hidden" name="QtaMiscela" id="QtaMiscela" value="<?php echo $QtaMiscela; ?>" /><?php echo $filtrogBreve ?></td>
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

                        <!--############################################################################-->            
                        <!--###### Visualizzo le materie prime associate alla formula pesate e non #####-->
                        <!--############################################################################-->             
                        <table  style="width:100%;"> 
                            <tr>
                                <th class="cella3" width="50%" colspan="2"><?php echo $filtroMaterieCompound ?></th>
                                <td class="cella3" width="15%" title="<?php echo $titleLabQtaTeo ?>"><?php echo $filtroLabQta . " " . $filtroLabTeo ?></td>
                                <td class="cella3" width="15%" title="<?php echo $titleLabQtaTeoGram ?>"><?php echo $filtroLabPesoTeo ?></td>
                                <td class="cella3" width="20%" colspan="2" ><?php echo $filtroLabPesoReale ?></td>
                            </tr> 
                            <?php
                            $QuantitaRealeTot = 0;

                            $NMatPri = 1;
                            while ($rowMatPrime = mysql_fetch_array($sqlMatPrime)) {
//Calcolo della qta di mat prima in base al totale di miscela digitato 
//ed alle percentuali definite nella formula
                                $QtaTeoNew = number_format(($rowMatPrime['qta'] * $QtaMiscela) / 100, $PrecisioneQta, '.', '');
                                ?>

                                <tr>
                                    <td class="cella4" ><?php echo($rowMatPrime['codice']) ?></td>
                                    <td class="cella4" ><?php echo($rowMatPrime['descri']) ?></td>
                                    <td class="cella2" ><?php echo number_format($rowMatPrime['qta'], $PrecisioneQta, '.', '') . " " . $filtroLabPerc ?></td>
                                    <td class="cella2" ><?php echo $QtaTeoNew . " " . $filtrogBreve ?></td>	
                                    <td class="cella1" width="95px">
                                        <input type="text" style="width: 70px;" name="Qta<?php echo($NMatPri); ?>" id="Qta<?php echo($NMatPri); ?>" value="<?php echo $rowMatPrime['peso']; ?>"/><?php echo $filtrogBreve ?></td>
                                    <!--######################################################
                                    ### Passaggio per riferimento dei dati utili alla Pesa ### 
                                    ########################################################-->		
                                    <td class="cella1">
                                        <a href="JavaScript:openWindow('carica_lab_peso.php?DatiPesa=<?php echo ($rowMatPrime['descri']) . ";" . ($rowMatPrime['codice']) . ";" . $QtaTeoNew . ";" . $valMateriaPrima; ?>')">
                                            <img src="/CloudFab/images/pittogrammi/bilancia_media_R.png" class="icone" title="<?php echo $titleLabPesaMat ?>"/></a>
                                    </td>	      
                                </tr>
                                <?php
                                $QuantitaRealeTot = $QuantitaRealeTot + $rowMatPrime['peso'];

                                $NMatPri++;
                            }//End While materie prime 
                            ?>
                            <!--############################################################################-->            
                            <!--###### Visualizzo i componenti associati alla formula pesate e non #########-->
                            <!--############################################################################-->     
                            <tr>     
                                <th class="cella3" width="50%" colspan="2"><?php echo $filtroMaterieDrymix ?></th>
                                <td class="cella3" width="15%" title="<?php echo $titleLabQtaTeo ?>"><?php echo $filtroLabQta . " " . $filtroLabTeo ?></td>
                                <td class="cella3" width="15%" title="<?php echo $titleLabQtaTeoGram ?>"><?php echo $filtroLabPesoTeo ?></td>
                                <td class="cella3" width="20%" colspan="2"><?php echo $filtroLabPesoReale ?></td>
                            </tr> 
                            <?php
                            $NComp = 1;
                            while ($rowComp = mysql_fetch_array($sqlComp)) {
//Calcolo della qta di mat prima in base al totale di miscela digitato 
//ed alle percentuali definite nella formula
                                $QtaTeoNew = number_format(($rowComp['qta'] * $QtaMiscela) / 100, $PrecisioneQta, '.', '');
                                ?>
                                <tr>
                                    <td class="cella4"><?php echo($rowComp['codice']) ?></td>
                                    <td class="cella4"><?php echo($rowComp['descri']) ?></td>
                                    <td class="cella2"><?php echo number_format($rowComp['qta'], $PrecisioneQta, '.', '') . " " . $filtroLabPerc; ?></td>
                                    <td class="cella2"><?php echo $QtaTeoNew . " " . $filtrogBreve; ?></td>	
                                    <td class="cella1" width="95px">
                                        <input type="text" style="width: 70px;" name="QtaComp<?php echo($NComp); ?>" id="QtaComp<?php echo($NComp); ?>" value="<?php echo $rowComp['peso']; ?>"/><?php echo $filtrogBreve ?>
                                    </td>
                                    <!--######################################################
                                   ### Passaggio per riferimento dei dati utili alla Pesa ### 
                                   ########################################################-->		
                                    <td class="cella1">
                                        <a href="JavaScript:openWindow('carica_lab_peso.php? DatiPesa=<?php echo ($rowComp['descri']) . ";" . ($rowComp['codice']) . ";" . $QtaTeoNew . ";" . $valMateriaPrima; ?>')">
                                            <img src="/CloudFab/images/pittogrammi/bilancia_media_R.png" class="icone" title="Clicca per pesare"/></a>
                                    </td>	      
                                </tr>
                                <?php
                                $QuantitaRealeTot = $QuantitaRealeTot + $rowComp['peso'];

                                $NComp++;
                            }//End While comp
                            ?>
                            <tr>
                                <td colspan="4" class="cella2" ><?php echo $filtroLabQtaTotMiscela ?> </td>
                                <td class="cella2" colspan="2"><?php echo $QuantitaRealeTot . " " . $filtrogBreve; ?></td>
                            </tr>
                        </table>

                        <!--#################################################################################-->            
                        <!--## Visualizzo i parametri di tipo PercentualeSI associati alla Formula #########-->
                        <!--#################################################################################-->     

                        <!-- Le variabili contenenti la stringa Ac si riferiscono ai parametri di tipo PercentualeSI -->

                        <table  style="width:100%;">   	
                            <tr>
                                <th class="cella3" widht="300px"><?php echo $filtroLabParametri ?></th>
                                <td class="cella3" widht="100px"><?php echo $filtroLabUnMisura ?></td>
                                <td class="cella3" widht="80px"><?php echo $filtroLabValoreTeo ?></td>
                                <td class="cella3" widht="100px" colspan="2" ><?php echo $filtroLabValoreReale ?></td>

                            </tr> 
                            <?php
                            $NParAcqua = 1;
                            while ($rowParAcqua = mysql_fetch_array($sqlParAcqua)) {
                                $QtaAcNew = ($rowParAcqua['qta_teo'] * $QtaMiscela) / 100;
                                ?>
                                <tr>
                                    <td class="cella4" widht="300px"><?php echo($rowParAcqua['codice']) ?></td>
                                    <td class="cella2" widht="100px"><?php echo($rowParAcqua['uni_mis']); ?></td>
                                    <td class="cella2" widht="80px"><?php echo number_format($QtaAcNew, $PrecisioneQta, '.', ''); ?></td>
                                    <td class="cella1">
                                        <input type="text" style="width: 90px;" name="QtaAc<?php echo($NParAcqua); ?>" id="QtaAc<?php echo($NParAcqua); ?>" value="<?php echo $rowParAcqua['peso']; ?>"/>
                                    </td>
                                    <!--Passaggio per riferimento dei dati relativi alla pesa dell'acqua -->
                                    <td class="cella1">
                                        <a href="JavaScript:openWindow('carica_lab_peso.php? DatiPesa=<?php echo ($rowParAcqua['descri']) . ";" . ($rowParAcqua['codice']) . ";" . $QtaAcNew . ";" . $valParametro; ?>')">
                                            <img src="/CloudFab/images/pittogrammi/bilancia_media_R.png" class="icone" title="Clicca per pesare"/></a>
                                    </td>	
                                </tr>
                                <?php
                                $NParAcqua++;
                            }//End While parametri
//###########################################################################################            
//## Visualizzo i parametri di tipo PercentualeNO associati alla Formula ###################
//###########################################################################################   
                            $NPar = 1;
                            while ($rowPar = mysql_fetch_array($sqlPar)) {
                                ?>
                                <tr>
                                    <td class="cella4" widht="300px"><?php echo($rowPar['codice']) ?></td>
                                    <td class="cella2" widht="100px"><?php echo($rowPar['uni_mis']); ?></td>
                                    <td class="cella2" widht="80px"><?php echo($rowPar['qta_teo']); ?></td>
                                    <td class="cella1" colspan="2"><input type="text" style="width: 90px;" name="Valore<?php echo($NPar); ?>" id="Valore<?php echo($NPar); ?>" value="0"/></td>
                                </tr>
                                <?php
                                $NPar++;
                            }//End While parametri 
                            ?>

                            <tr>
                                <td class="cella2" style="text-align:right" colspan="5">
                                    <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="location.href = 'gestione_lab_esperimenti.php';"/>
                                    <input type="button" value="<?php echo $valueButtonSalva ?>" onClick="javascript:Carica();"  /></td>

                            </tr>
                        </table>
                    </form>
                </div>
                <?php
}//End if Controllo input
            }//End Aggiornamento $_POST[Formula]
            ?>
            <div id="msgLog">
                <?php
                if ($DEBUG) {

                    echo "</br>Tab lab_formula : Utenti e aziende visibili " . $strUtentiAziendeFormula;
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
