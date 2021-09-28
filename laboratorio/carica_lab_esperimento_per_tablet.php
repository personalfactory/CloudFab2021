<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <?php
    if ($DEBUG)
        ini_set(display_errors, "1");
    
    //############# STRINGHE UTENTI - AZIENDE VISIBILI###########################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende proprietarie visibili 
    //dall'utente loggato   
    //Si verifica se l'utente ha il permesso di editare la tabella lab_esperimenti (116)
    $strUtentiAziendeEsper = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_esperimento');
    $strUtentiAziendeAccessori = getStrUtAzVisib($_SESSION['objPermessiVis'], 'accessorio');

    //########## AZIENDE SCRIVIBILI ############################################
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'lab_esperimento');
    ?>
    <body >
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


            if ((isset($_POST['CodiceBarreOld']) && $_POST['CodiceBarreOld'] != "")) {

                //Incremento la variabile aggiornamento per aggiornare la sessione e mantenerla in vita pi� a lungo.
                $_SESSION['aggiornamento'] ++;
                //Incremento la variabile che indica il numero di aggiornamenti fatti sulla pagina
                //Utile per le azioni da eseguire solo al primo aggiornamento 
                $_SESSION['carica_pagina'] ++;

                $errore = false;
                $erroreTransazione = false;
                $messaggio = "";

                if (!isset($_POST['scegli_tipo']) || $_POST['scegli_tipo'] == "") {
                    $errore = true;
                    $messaggio = $messaggio . " " . $msgErrTipo . '<br/>';
                }

                $CodiceBarreOld = $_POST['CodiceBarreOld'];
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

                if ($errore) {
                    $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                    echo '<div id="msgErr">' . $messaggio . '</div>';
                } else {

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
                    $_SESSION['PesoMiscela'] = $QtaTotMiscela;

                    if ($_SESSION['carica_pagina'] == 1) {

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
                        $initAccessori = true;

                        begin();
                        //Azzero la tabella [lab_peso] 
                        $delete = deleteLabPeso($_SESSION['lab_macchina']);

                        $initMatVar = inizializzaLabPesoMatPriKeVaria($QtaTotMiscela, $CodiceBarreOld, $IdEsperimento, $QtaTotMiscela, $_SESSION['lab_macchina'], $CodiceFormula, $valTipoMatCompound, $Tipo, $_SESSION['id_utente'], $IdAzienda);

                        $initCompVar = inizializzaLabPesoCompKeVaria($QtaTotMiscela, $CodiceBarreOld, $IdEsperimento, $QtaTotMiscela, $_SESSION['lab_macchina'], $CodiceFormula, $valTipoMatDryMix, $Tipo, $_SESSION['id_utente'], $IdAzienda);

                        $initPar = inizializzaLabPesoPar($QtaTotMiscela, $CodiceBarreOld, $IdEsperimento, $_SESSION['lab_macchina'], $QtaTotMiscela, $CodiceFormula, $PercentualeSI, $Tipo, $_SESSION['id_utente'], $IdAzienda);

                        $initParNoPerc = inizializzaLabPesoParPercNO($QtaTotMiscela, $CodiceBarreOld, $IdEsperimento, $_SESSION['lab_macchina'], $QtaTotMiscela, $CodiceFormula, $PercentualeNO, $Tipo, $_SESSION['id_utente'], $IdAzienda);

                        $initAccessori = inizializzaLabPesoAccessori($_SESSION['lab_macchina'], $CodiceFormula, $CodiceBarreOld, $valTipoAccessori, $QtaTotMiscela, $Tipo, $_SESSION['id_utente'], $IdAzienda, $strUtentiAziendeAccessori);


                        if (!$delete OR !$initMatVar OR !$initCompVar OR !$initPar OR !$initParNoPerc OR !$initAccessori) {

                              rollback();       
                            //IMPOSSIBILE AVVIARE LA PROCEDURA DI PESA
                           echo "deleteLabPeso : ".$delete;
                           echo "</br>initMatVar : ".$initMatVar;
                           echo "</br>initCompVar : ".$initCompVar;
                           echo "</br>initPar : ".$initPar;
                           echo "</br>initParNoPerc : ".$initParNoPerc;
                           echo "</br>initAccessori : ".$initAccessori;
                           
                            echo '<div id="msgErr">' . $msgErrLabInitPeso . '</div>';
                            echo '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                            
                        } else {
                            
                          
                            
                            commit();
                        }
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

                    <div id="container" style="width:80%; margin:15px auto;">
                        <form id="InserisciLabEsperimento" name="InserisciLabEsperimento" method="post" >
                            <table  style="width:100%;">
                                <th  colspan="2" class="cella3"><?php echo $titoloLabPagNuovaProva . ": " . $CodiceFormula; ?></th>
                                <tr>
                                    <td class="cella2" width="40%"><?php echo $filtroLabTipo ?></td>
                                    <td class="cella1" width="60%"><?php echo $Tipo ?></td>
                                </tr>
                                <tr>
                                    <td class="cella2"><?php echo $filtroLabCodBarre ?></td>
                                    <td class="cella1"><?php echo $CodiceBarreOld; ?></td>
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
                                    <td class="cella4"><?php echo $filtroAzienda ?></td>
                                    <td class="cella1"><?php echo $NomeAzienda ?></td>
                                </tr>

                            </table>
                            <!--################################################################################-->            
                            <!--### Visualizzo le materie prime associate alla formula con le qta relative #####-->
                            <!--### al primo esperimento fatto sulla stessa formula ############################-->  
                            <!--################################################################################-->    
                            <table  style="width:100%;"> 
                                <tr>
                                    <th class="cella3" width="55%" colspan="2"><?php echo $filtroMaterieCompound ?></th>
                                    <td class="cella3" width="15%" title="<?php echo $titleLabQtaTeo ?>"><?php echo $filtroLabQtaPercTeorica ?></td>
                                    <td class="cella3" width="15%" title="<?php echo $titleLabQtaPercReale ?>"><?php echo $filtroLabQtaPercReale ?></td>
                                    <td class="cella3" width="15%" ><?php echo $filtroLabPesoReale ?></td>
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
                                        <td class="cella1"><?php echo $rowMatPrime['peso'] . " " . $filtrogBreve ?> </td>	      
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
                                    <th class="cella3" width="55%" colspan="2"><?php echo $filtroMaterieDrymix ?></th>
                                    <td class="cella3" width="15%" title="<?php echo $titleLabQtaTeo ?>"><?php echo $filtroLabQtaPercTeorica ?></td>
                                    <td class="cella3" width="15%" title="<?php echo $titleLabQtaPercReale ?>"><?php echo $filtroLabQtaPercReale ?></td>
                                    <td class="cella3" width="15%" ><?php echo $filtroLabPesoReale ?></td>
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
                                        <td class="cella1"><?php echo $rowComp['peso'] . " " . $filtrogBreve ?></td>

                                    </tr>
            <?php
            $QuantitaRealeTot = $QuantitaRealeTot + $rowComp['peso'];

            $NComp++;
        }//End While materie prime 
        ?>
                                <tr>
                                    <td class="cella2" colspan="4"><?php echo $filtroLabQtaTotMiscela ?> </td>
                                    <td class="cella2" colspan="2"><?php echo $QuantitaRealeTot . " " . $filtrogBreve; ?></td>
                                </tr>



                            </table>
                            <!--################################################################################-->            
                            <!--### Visualizzo i parametri di tipo PercentualeSI con le qta relative ###########-->
                            <!--### al primo esperimento fatto sulla stessa formula ############################-->  
                            <!--################################################################################--> 
                            <table style="width:100%;">    	
                                <tr>
                                    <th class="cella3" width="45%"><?php echo $filtroLabParametri ?></th>
                                    <td class="cella3" width="10%"><?php echo $filtroLabUnMisura ?></td>
                                    <td class="cella3" width="15%" title="<?php echo $titleLabQtaTeo ?>"><?php echo $filtroLabValoreTeo ?></td>
                                    <td class="cella3" width="15%" title="<?php echo $titleLabQtaPercReale ?>"><?php echo $filtroLabValoreReale ?></td>
                                    <td class="cella3" width="15%" ><?php echo $filtroLabValore ?></td>

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
                                        <td class="cella1"><?php echo $rowParAcqua['peso']; ?></td>

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
                                        <td class="cella1"colspan="2"><?php echo ($rowPar['qta']); ?></td>
                                    </tr>                         
            <?php
            $NPar++;
        }//End While parametri PercentualeNO
        ?>

                                <tr>
                                    <td class="cella2" style="text-align:right" colspan="6"><?php echo $valueButtonTablet ?></td>

                                </tr>
                            </table>
                        </form>
                    </div>
        <?php

    }//If errore esistenza codice a barre
}
?>
            <div id="msgLog">
            <?php
            if ($DEBUG) {

                echo "</br>Tabella lab_esperimento : Utenti e aziende visibili " . $strUtentiAziendeEsper;
                echo "</br>Tabella lab_esperimento : AZIENDE SCRIVIBILI: ";
                for ($i = 0; $i < count($arrayAziendeScrivibili); $i++) {
                    echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
                }
            }
            ?>
            </div>
        </div><!--mainContainer-->

    </body>
</html>
