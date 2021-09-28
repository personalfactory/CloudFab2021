<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php
        include('../include/header.php');        
        ?>
    </head>
    <?php
    if($DEBUG) ini_set('display_errors', '1');
    
    //################## GESTIONE UTENTE #######################################
    $elencoFunzioni = array("94","96","98");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni,$_SESSION['objPermessiVis']);

    //############# STRINGA UTENTI-AZIENDE VISIBILI ############################
    $strUtAziendeMac = getStrUtAzVisib($_SESSION['objPermessiVis'], 'macchina');
    $strUtAzGruppo = getStrUtAzVisib($_SESSION['objPermessiVis'], 'gruppo');
    
   
    //##########################################################################
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <script language="javascript">
//                function disabilitaAction94() {
//                    //PERMESSO CALCOLO PRODUTTIVITA
//                    location.href = '../permessi/avviso_permessi_visualizzazione.php'
//                }
//                function disabilitaAction96() {
//                    //PERMESSO VISUALIZZAZIONE DESESTO LIVELLO DEI GRUPPI
//                    document.getElementById("96").style.display="none";
//
//                }
//                function disabilitaAction98() {
//                    //PERMESSO VISUALIZZAZIONE DEI GRUPPI
//                    document.getElementById("98").style.display="none";
//
//                }
                function Calcola() {

                    document.forms["Produttivita"].action = "gestione_produttivita.php";
                    document.forms["Produttivita"].submit();
                }
                function aggiornaScelte(){
                    
                    window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + document.forms["Produttivita"].date3.value +
                                '&Data4=' + document.forms["Produttivita"].date4.value +
                                '&Stabilimento=' + document.forms["Produttivita"].Stabilimento.value +
                                '&OreDaEscludere=' + document.forms["Produttivita"].OreDaEscludere.value +
                                '&Inattivita=' + document.forms["Produttivita"].Inattivita.value +
                                '&Operatore=' + document.forms["Produttivita"].Operatore.value +
                                '&Prodotto=' + document.forms["Produttivita"].Prodotto.value +
                                '&Submit=1', 'SettaVar');
                    
                }
            </script>
            <link href="../object/calendar/calendar.css" rel="stylesheet" type="text/css" />
            <script language="javascript" src="../object/calendar/calendar.js"></script>
            <script language="javascript" src="../js/visualizza_elementi.js"></script>
            <script language="javascript" src="../js/popup.js"></script>
            
            <?php
            $pagina = "gestione_produttivita.php";

            include('../include/menu.php');
            include('../include/funzioni.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_macchina.php');
            include('../sql/script_figura.php');
            include('../sql/script_processo.php');
            include('../sql/script_gruppo.php');
            include('../sql/script_comune.php');

            include_once('../object/calendar/classes/tc_calendar.php');
            include_once('../object/calendar/calendar_func.php');

            include('./oggetti/StabGrupGeo.php');
            include('./oggetti/Produttivita.php');
            include('./oggetti/TempoInsacco.php');

            if (!isset($_SESSION['Submit']) OR $_SESSION['Submit'] == "") {

//Inizializzazzione delle variabili di sessione
                $_SESSION['Data3'] = "";
                $_SESSION['Data4'] = "";
                $_SESSION['IdMacchina'] = "";
                $_SESSION['Stabilimento'] = "";
                $_SESSION['OreDaEscludere'] = "";
                $_SESSION['Inattivita'] = "";
                $_SESSION['Operatore'] = "";
                $_SESSION['CodOperatore'] = "";
                $_SESSION['Nominativo'] = "";
                $_SESSION['Prodotto'] = "";
                $_SESSION['DescriStab'] = "";
                $_SESSION['Gruppo'] = "Universale";
                $_SESSION['LivelloGruppo'] = "SestoLivello";
                $_SESSION['Geografico'] = "Mondo";
                $_SESSION['TipoRiferimento'] = "Mondo";
                $_SESSION['Submit'] = "";

                //#################### INIZIO TRANSAZIONE ##############################
                begin();

                //############## Seleziono gli stabilimenti da visualizzare ############
                $sqlSta = selectStabByGruppoGeoVis($_SESSION['Gruppo'], $_SESSION['Geografico'], $strUtAziendeMac);
//                $sqlSta = selectStabByGruppoGeo($_SESSION['Gruppo'], $_SESSION['Geografico']);
                //############### Costruisco un array di oggetti StabGrupGeo ###########
                //Inizializzo l'oggetto con tutti gli stab appartenenti al gruppo Universale e rif geo Mondo
                $_SESSION['objStabGrupGeo'] = array();
                $i = 0;
                while ($rowSta = mysql_fetch_array($sqlSta)) {
                    $_SESSION['objStabGrupGeo'] [$i] = new StabGrupGeo($rowSta['id_macchina'], $rowSta['descri_stab'], $rowSta['gruppo'], $rowSta['geografico']);
                    $i++;
                }

                //############### Seleziono gli operatori da visualizzare ##############
//                $sqlOp = selectFigureByGruppoGeoTipo($_SESSION['Gruppo'], $_SESSION['Geografico'], 1);
                $sqlOp = selectFigureByGruppoGeoTipoVis($_SESSION['Gruppo'], $_SESSION['Geografico'], 1, $strUtAzGruppo);

                //############### Seleziono i prodotti da visualizzare #################
                if (count($_SESSION['objStabGrupGeo']) > 0)
                    $sqlProd = selectProdottiFromProcessoByStab($_SESSION['objStabGrupGeo']);

                //##################### FINE TRANSAZIONE ###############################        
                commit();
                ?>

                <div id="container" style="width:80%; margin:15px auto;">
                    <form id="Produttivita" name="Produttivita" method="post" action="">
                        <table style="width:100%;">
                            <tr>
                                <td class="cella3" colspan="2"><?php echo $titoloPaginaProduttivita; ?></td>
                            </tr>
                            <tr id="98">
                                    <td class="cella2" style="width:30%"><?php echo $filtroGruppo; ?> </td>
                                    <td class="cella1" ><?php include('./moduli/visualizza_form_gruppo.php'); ?></td>
                                </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroGeografico; ?> </td>
                                <td class="cella1"><?php include('./moduli/visualizza_form_geografico.php'); ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroStabilimento; ?> </td>
                                <td class="cella1">
                                     <select name="Stabilimento" id="Stabilimento" onChange="javascript:aggiornaScelte()">
                                        <option value="<?php echo "0;" . $labelOptionStabDefault; ?>"> <?php echo $labelOptionStabDefault; ?></option>
                                        <?php
                                        for ($i = 0; $i < count($_SESSION['objStabGrupGeo']); $i++) {
                                            ?>
                                            <option value="<?php echo $_SESSION['objStabGrupGeo'] [$i]->getId_macchina() . ";" . $_SESSION['objStabGrupGeo'] [$i]->getDescri_stab() ?>"><?php echo $_SESSION['objStabGrupGeo'] [$i]->getDescri_stab(); ?></option>
                                        <?php } ?>
                                    </select> 
<!--                                    <select name="Stabilimento" id="Stabilimento" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Submit=1', 'SettaVar');">
                                        <option value="<?php echo "0;" . $labelOptionStabDefault; ?>"> <?php echo $labelOptionStabDefault; ?></option>
                                        <?php
                                        for ($i = 0; $i < count($_SESSION['objStabGrupGeo']); $i++) {
                                            ?>
                                            <option value="<?php echo $_SESSION['objStabGrupGeo'] [$i]->getId_macchina() . ";" . $_SESSION['objStabGrupGeo'] [$i]->getDescri_stab() ?>"><?php echo $_SESSION['objStabGrupGeo'] [$i]->getDescri_stab(); ?></option>
                                        <?php } ?>
                                    </select> -->
                                </td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroOperatore; ?> </td>
                                <td class="cella1">
                                    <select name="Operatore" id="Operatore" onChange="javascript:aggiornaScelte();">
                                        <option value=""><?php echo $labelOptionOperDefault ?></option>
                                        <?php while ($rowOp = mysql_fetch_array($sqlOp)) { ?>
                                            <option value="<?php echo $rowOp['codice'] . ";" . $rowOp['nominativo']; ?>"><?php echo $rowOp['nominativo']; ?></option>
                                        <?php } ?>
                                    </select> 
                                </td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroProdotto ?></td>
                                <td class="cella1">
                                    <select name="Prodotto" id="Prodotto" onChange="javascript:aggiornaScelte();">
                                        <option value=""><?php echo $labelOptionProdDefault ?></option>
                                        <?php while ($rowProd = mysql_fetch_array($sqlProd)) { ?>
                                            <option value="<?php echo $rowProd['cod_prodotto'] . ";" . $rowProd['nome_prodotto']; ?>"><?php echo $rowProd['cod_prodotto'] . " " . $rowProd['nome_prodotto']; ?></option>
                                        <?php } ?>
                                    </select> 
                                </td>
                            </tr>
                            <tr>
                                <td class="cella2" title="<?php echo $titlePeriodoRif ?>"><?php echo $filtroPeriodoDiRif ?></td>
                                <td class="cella1">
                                    <!--############################ CALENDARIO ##########################-->
                                    <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                        <tr>
                                            <div style="float: left;">
                                                <div style="float: left; padding-right: 3px; line-height: 18px;"><?php echo $calendarioFrom ?> :</div>
                                                <div style="float: left;">
                                                    <?php
                                                    //Inizializzo le due date che vengono visualizzate inizialmente
                                                    //corrispondono alla data di inizio e fine della settimana in corso
                                                    $thisweek = date('W');
                                                    $thisyear = date('Y');
                                                    $dayTimes = getDaysInWeek($thisweek, $thisyear);
                                                    //Data iniziale
                                                    $_SESSION['Data3'] = date('Y-m-d', $dayTimes[0]);
                                                    //Data finale
                                                    $_SESSION['Data4'] = date('Y-m-d', $dayTimes[(sizeof($dayTimes) - 1)]);
                                                    visualizzaPrimoCalendario($_SESSION['Data3'], $_SESSION['Data4']);
                                                    ?>
                                                </div>
                                            </div>
                                            <div style="float: left;">
                                                <div style="float: left; padding-left: 3px; padding-right: 3px; line-height: 18px;"><?php echo $calendarioTo ?> :</div>
                                                <div style="float: left;">
                                                    <?php visualizzaSecondoCalendario($_SESSION['Data3'], $_SESSION['Data4']); ?>
                                                </div>
                                            </div>
                                        </tr>
                                    </table>
                                    <!--##################### FINE CALENDARIO ##########################-->
                                </td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroOreLavorative ?> </td>
                                <td class="cella1"><input type="text" name="OreDaEscludere" id="OreDaEscludere" title="<?php echo $titleOreLavorative ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroOreInattivita; ?></td>
                                <td class="cella1"><input type="text" name="Inattivita" id="Inattivita" title="<?php echo $titleOreInattivita ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="cella2" style="text-align: right " colspan="2">
                                    <input type="reset"  onClick="javascript:window.open('/CloudFab/produttivita/reset_var_produttivita.php');" value="<?php echo $valueButtonReset ?>"/>
                                    <input type="button" onClick="javascript:aggiornaScelte();" value="<?php echo $valueButtonCalcola ?>" />
                                    </table>  
                                    </form>
                                    </div>
                                    <?php
                                } else {
                                    //#####################################################################
                                    //####################### IF SUBMIT ###################################
                                    //#####################################################################

                                    list($_SESSION['IdMacchina'], $_SESSION['DescriStab']) = explode(';', $_SESSION['Stabilimento']);

                                    if (!isset($_SESSION['OreDaEscludere']) OR $_SESSION['OreDaEscludere'] == "") {
                                        $_SESSION['OreDaEscludere'] = 24;
                                    }

                                    if (!isset($_SESSION['Inattivita']) OR $_SESSION['Inattivita'] == "") {
                                        $_SESSION['Inattivita'] = 24;
                                    }

                                    if (!isset($_SESSION['Operatore']) OR $_SESSION['Operatore'] == "") {
                                        $_SESSION['Nominativo'] = $labelOptionOperDefault;
                                        $_SESSION['CodOperatore'] = "";
                                    } else {
                                        list($_SESSION['CodOperatore'], $_SESSION['Nominativo']) = explode(';', $_SESSION['Operatore']);
                                    }

                                    if (!isset($_SESSION['Prodotto']) OR $_SESSION['Prodotto'] == "") {
                                        $_SESSION['CodProdotto'] = "";
                                        $_SESSION['NomeProdotto'] = $labelOptionProdDefault;
                                    } else {
                                        list($_SESSION['CodProdotto'], $_SESSION['NomeProdotto']) = explode(';', $_SESSION['Prodotto']);
                                    }

                                    //Trasformo l'input relativo ai tempi... in secondi
                                    $SecondiDaEscludere = $_SESSION['OreDaEscludere'] * 3600;
                                    $SecondiInattivita = $_SESSION['Inattivita'] * 3600;


                                    //############## INIZIO TRANSAZIONE #######################
                                    begin();

                                    //#########################################################
                                    //########## OGGETTO stabGruppoGeo ########################
                                    //#########################################################
                                    // Ridefinisco l'oggetto stabGrupGeo in base alle scelte fatte dall'utente
                                    $_SESSION['objStabGrupGeo'] = array();

                                    //Se è stato selezionato un singolo stabilimento ricavo le informazioni 
                                    //ad esso relative dalla tabella macchina ed inserisco lo 
                                    //stabilimento nell'oggetto stabGrupGeo
                                    if ($_SESSION['IdMacchina'] != 0) {
                                        $sqlSt = selectMacchina($_SESSION['IdMacchina']);
                                        $i = 0;
                                        while ($rowSt = mysql_fetch_array($sqlSt)) {
                                            $_SESSION['objStabGrupGeo'] [$i] = new StabGrupGeo($rowSt['id_macchina'], $rowSt['descri_stab'], $_SESSION['Gruppo'], $_SESSION['Geografico']);
//                                                   echo "</br> i= " . $i . " id_macchina : " . $_SESSION['objStabGrupGeo'] [$i]->getId_macchina() . "</br>";
                                            $i++;
                                        }
                                        //Se non è stato selezionato un particolare stabilimento ma un gruppo 
                                        //di stab eseguo una select facendo un join della 
                                        //tab macchina con le tab gruppo e comune
                                    } else if ($_SESSION['IdMacchina'] == 0) {

                                        //Inserisco nell'oggetto stabGrupGeo l'elenco degli stabilimenti selezionati
//                                        $sqlStab = selectStabByGruppoGeo($_SESSION['Gruppo'], $_SESSION['Geografico']);
                                        $sqlStab = selectStabByGruppoGeoVis($_SESSION['Gruppo'], $_SESSION['Geografico'], $strUtAziendeMac);
                                        $i = 0;
                                        while ($rowStab = mysql_fetch_array($sqlStab)) {
                                            $_SESSION['objStabGrupGeo'] [$i] = new StabGrupGeo($rowStab['id_macchina'], $rowStab['descri_stab'], $rowStab['gruppo'], $rowStab['geografico']);
//                                          echo "</br> i= " . $i . " id_macchina : " . $_SESSION['objStabGrupGeo'] [$i]->getId_macchina() . "</br>";
                                            $i++;
                                        }
                                    }

                                    //Seleziono gli operatori ed i prodotti in relazione alle scelte effettuate
//                                    $sqlOper = selectFigureByGruppoGeoTipo($_SESSION['Gruppo'], $_SESSION['Geografico'], 1);
                                    $sqlOper = selectFigureByGruppoGeoTipoVis($_SESSION['Gruppo'], $_SESSION['Geografico'], 1, $strUtAzGruppo);
                                    if (count($_SESSION['objStabGrupGeo']) > 0)
                                        $sqlProd = selectProdottiFromProcessoByStab($_SESSION['objStabGrupGeo']);

                                    //############################################################################
                                    //###################### OGGETTO PRODUTTIVITA ################################
                                    //############################################################################
                                    //L'oggetto produttività contiene tutti i dati dei processi selezionati 
                                    //in base alle scelte fatte dall'utente                                    
                                    $_SESSION['objProduttivita'] = array();
                                    $sqlProdut = "";
                                    if (count($_SESSION['objStabGrupGeo']) > 0) {

                                        $sqlProdut = selectCreateProduttivita($_SESSION['Data3'], $_SESSION['Data4'], $_SESSION['CodOperatore'], $_SESSION['CodProdotto'], $_SESSION['objStabGrupGeo']);
                                        //############### Creazione dell'oggetto produttivita ########
                                        $k = 0;
                                        while ($rowProdut = mysql_fetch_array($sqlProdut)) {
                                            $_SESSION['objProduttivita'] [$k] = new Produttivita(
                                                    $rowProdut['dt_produzione_mac'], $rowProdut['dt_produzione_mac'], $rowProdut['id_macchina'], $rowProdut['id_processo'], $rowProdut['cod_prodotto'], $rowProdut['cod_chimica'], $rowProdut['cod_sacco'], $rowProdut['cod_operatore']);
                                            $k++;
                                        }
                                    }
                                    //################## FINE TRANSAZIONE ########################
                                    commit();
                                    //###########Creazione delle date di inizio e fine processo ###########
                                    //(rispettivamente data prec e data att)
                                    for ($k = 0; $k < count($_SESSION['objProduttivita']) - 1; $k++) {
                                        $x = $k + 1;
                                        $_SESSION['objProduttivita'][$k]->setDt_att($_SESSION['objProduttivita'][$x]->getDt_prec());
//                                        echo $_SESSION['objProduttivita'] [$k]->toString();
                                    }

                                    //################## CALCOLO PRODUTTIVITA ###########################
                                    $NumSecInServizio = 0;
                                    $NumSecondiInat = 0;
                                    $NumSecondiProd = 1;
                                    $NumSac = 0;
                                    $NumOre = 1;
                                    $Produttivita = 0;
                                    $sumDiffProcessiAttivi = 0;

                                    //Calcolo della differenza fra le date di inizio e fine processo
                                    for ($k = 0; $k < count($_SESSION['objProduttivita']); $k++) {
//                                              
                                        $dataPrec = $_SESSION['objProduttivita'] [$k]->getDt_prec();
                                        $dataAtt = $_SESSION['objProduttivita'] [$k]->getDt_att();
                                        $_SESSION['objProduttivita'] [$k]->setDiff(data_diff($dataPrec, $dataAtt));

                                        //Calcolo dei giorni,ore,minuti                                          
                                        $_SESSION['objProduttivita'] [$k]->setTime();
//
                                        $_SESSION['objProduttivita'] [$k]->setTimeTot($_SESSION['objProduttivita'] [$k]->getGiorni(), $_SESSION['objProduttivita'] [$k]->getOre(), $_SESSION['objProduttivita'] [$k]->getMinuti(), $_SESSION['objProduttivita'] [$k]->getSecondi());

                                        $diff = intval($_SESSION['objProduttivita'] [$k]->getDiff());

                                        //Intervalli di tempo in servizio
                                        if ($diff < $SecondiDaEscludere) {
                                            $_SESSION['objProduttivita'] [$k]->setIn_servizio(1);
                                        } else {
                                            $_SESSION['objProduttivita'] [$k]->setIn_servizio(0);
                                        }
                                        //Intervalli di tempo in attivita
                                        if ($diff < $SecondiInattivita) {
                                            $_SESSION['objProduttivita'] [$k]->setAttivo(1);
                                        } else {
                                            $_SESSION['objProduttivita'] [$k]->setAttivo(0);
                                        }
//                                       
                                        //##################### IN SERVIZIO ##############################
                                        if ($_SESSION['objProduttivita'][$k]->getIn_servizio() == 1) {
                                            $NumSecInServizio = $NumSecInServizio + $diff;
                                        }
                                        //##################### INATTIVITA ############################### 
                                        if ($_SESSION['objProduttivita'] [$k]->getAttivo() == 0 AND $_SESSION['objProduttivita'] [$k]->getIn_servizio() == 1) {
                                            $NumSecondiInat = $NumSecondiInat + $diff;
                                        }

                                        //############### PRODUZIONE EFFETTIVA ###########################
                                        if ($_SESSION['objProduttivita'] [$k]->getAttivo() == 1 AND $_SESSION['objProduttivita'] [$k]->getIn_servizio() == 1) {
                                            $NumSecondiProd = $NumSecondiProd + $diff;
                                        }

//                                        echo $_SESSION['objProduttivita'] [$k]->toString();             
//                                                                                     
                                    }


                                    $NumOreInServizio = floor($NumSecInServizio / 3600) . " " . $ore . " " .
                                            floor(fmod($NumSecInServizio, 3600) / 60) . " " . $minuti;

                                    $NumOreInat = floor($NumSecondiInat / 3600) . " " . $ore . " " .
                                            floor(fmod($NumSecondiInat, 3600) / 60) . " " . $minuti;

                                    $NumOreProd = floor($NumSecondiProd / 3600) . " " . $ore . " " .
                                            floor(fmod($NumSecondiProd, 3600) / 60) . " " . $minuti;

                                    $NumSac = count($_SESSION['objProduttivita']);

                                    //Le ore di produttività vanno calcolate sottraendo alle ore totali 
                                    //che ci sono fra le due date, le ore da escludere ed il tempo di inattivita
                                    if ($NumSecondiProd > 0) {
                                        $Produttivita = number_format(($NumSac / $NumSecondiProd) * 3600, 2);
                                    }

                                    //##################################################################
                                    //##################### TEMPO MEDIO INSACCO ########################
                                    //##################################################################
                                    $TempoMedioInsaccoOre = 0;
                                    //Solo se è stato selezionato un singolo stabilimento si calcola
                                    //il tempo medio di insacco
                                    //Creazione dell'oggetto TempoInsacco 
                                    //contenente i processi raggruppati per cod_chimica
                                    $objTempoInsacco = array();
                                    $objProcessiAttivi = array();
                                    if ($_SESSION['IdMacchina'] != "0") {

                                        //####### COSTRUISCO ARRAY DEI PROCESSI ATTIVI PER IL SINGOLO STAB ###
                                        $y = 0;
                                        for ($k = 0; $k < count($_SESSION['objProduttivita']); $k++) {
//                                              
                                            if ($_SESSION['objProduttivita'] [$k]->getAttivo() == 1 AND
                                                    $_SESSION['objProduttivita'] [$k]->getId_macchina() == $_SESSION['IdMacchina']) {

                                                $objProcessiAttivi[$y] = new Produttivita(
                                                        $_SESSION['objProduttivita'] [$k]->getDt_prec(), $_SESSION['objProduttivita'] [$k]->getDt_att(), $_SESSION['objProduttivita'] [$k]->getId_macchina(), $_SESSION['objProduttivita'] [$k]->getId_processo(), $_SESSION['objProduttivita'] [$k]->getCod_prodotto(), $_SESSION['objProduttivita'] [$k]->getCod_chimica(), $_SESSION['objProduttivita'] [$k]->getCod_sacco(), $_SESSION['objProduttivita'] [$k]->getCod_operatore());

                                                $objProcessiAttivi[$y]->setDiff($_SESSION['objProduttivita'] [$k]->getDiff());
//                                                echo $objProcessiAttivi[$y]->toString();
                                                $y++;
                                            }
                                        }
//                                      
                                        if (count($objProcessiAttivi) > 0) {
                                            $sqlTempIns = selectCreateTempoMedioInsacco($objProcessiAttivi);
                                            $j = 0;
                                            while ($rowTemp = mysql_fetch_array($sqlTempIns)) {
//                                                                                      
                                                $objTempoInsacco[$j] = new TempoInsacco($_SESSION['IdMacchina'], $rowTemp['dt_produzione_mac'], $rowTemp['cod_operatore'], $rowTemp['cod_prodotto'], $rowTemp['cod_chimica']);

//                                                echo $objTempoInsacco[$j]->toString();
                                                $j++;
                                            }

                                            //####### PER OGNI CODICE CHIMICA CALCOLO IL TEMPO MEDIO DI INSACCO  ####

                                            $sumMediePesate = 0;
                                            for ($j = 0; $j < count($objTempoInsacco); $j++) {
                                                $sommaDiff[$j] = 0;
                                                $numSac[$j] = 0;
                                                for ($i = 0; $i < count($objProcessiAttivi); $i++) {
                                                    if ($objTempoInsacco[$j]->getCod_chimica() == $objProcessiAttivi[$i]->getCod_chimica()) {

                                                        $sommaDiff[$j] = $sommaDiff[$j] + $objProcessiAttivi [$i]->getDiff();
                                                        $numSac[$j]++;

                                                        //Calcolo la media aritmetica del tempo di insacco relativo a ciascun codice chimica
                                                        $objTempoInsacco[$j]->setSomma_tempo_sec($sommaDiff[$j]);
                                                        $objTempoInsacco[$j]->setNum_sac($numSac[$j]);
                                                        $objTempoInsacco[$j]->medieAritPerCodChim();

                                                        //######### MEDIA PESATA DELLE MEDIE ARITMETICHE DEI TEMPI DI INSACCO DEI CODICI CHIMICA
                                                        //Calcolo il numeratore della formula per il calcolo della media pesata calcolata 
                                                        //sulle medie aritmetiche dei tempo di insacco dei singoli codici chimica
                                                        $objTempoInsacco[$j]->mediePesate();
                                                        $sumMediePesate = $sumMediePesate + $objTempoInsacco[$j]->mediePesate();

//                                                    $sumMediePesate=$sumMediePesate+($sommaDiff[$j]*$numSac[$j]);
                                                    }
                                                }
                                            }

                                            $TempoMedioInsaccoSec = $sumMediePesate / count($objProcessiAttivi);
                                            $TempoMedioInsaccoOre = floor($TempoMedioInsaccoSec / 3600) . " " . $ore . " " . floor(fmod($TempoMedioInsaccoSec, 3600) / 60) . " " . $minuti;
                                        }
                                    }//END CALCOLO TEMPO MEDIO INSACCO
                                    ?>

                                    <div id = "container" style = "width:80%; margin:15px auto;">
                                        <form id = "Produttivita" name = "Produttivita" method ="post" >
                                            <table style = "width:100%;">
                                                <tr>
                                                    <td class = "cella3" colspan = "2"><?php echo $titoloPaginaProduttivita ?></td>
                                                </tr>
                                                <tr id="98">
                                                    <td class="cella2" style="width:30%"><?php echo $filtroGruppo ?> </td>
                                                    <td class="cella1"><?php include('./moduli/visualizza_form_modifica_gruppo.php'); ?></td>
                                                </tr>
                                                  
                                                <td class="cella2"><?php echo $filtroGeografico ?> </td>
                                                <td class="cella1"><?php include('./moduli/visualizza_form_modifica_geografico.php'); ?>
                                                </td>
                                                </tr>
                                                <tr>
                                                    <td class = "cella2"><?php echo $filtroStabilimento ?> </td>
                                                    <td class = "cella1">
                                                        <select name="Stabilimento" id="Stabilimento" onChange="javascript:aggiornaScelte()">
                                                            <option value="<?php echo "0;" . $labelOptionStabDefault ?>"> <?php echo $labelOptionStabDefault ?></option>
                                                            <option value="<?php echo $_SESSION['IdMacchina'] . ";" . $_SESSION['DescriStab'] ?>" selected=" "><?php echo $_SESSION['DescriStab'] ?></option>
                                                            <?php
//Visualizzo sempre tutti gli stab del gruppo e rif geografico 
//anche se si è selezionato un unico stab
                                                            for ($i = 0; $i < count($_SESSION['objStabGrupGeo']); $i++) {
                                                                ?>
                                                                <option value="<?php echo $_SESSION['objStabGrupGeo'] [$i]->getId_macchina() . ";" . $_SESSION['objStabGrupGeo'] [$i]->getDescri_stab() ?>"><?php echo $_SESSION['objStabGrupGeo'] [$i]->getDescri_stab(); ?></option>
                                                            <?php } ?>
                                                        </select> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="cella2"><?php echo $filtroOperatore ?> </td>
                                                    <td class="cella1">
                                                        <select name="Operatore" id="Operatore" onChange="javascript:aggiornaScelte();">
                                                            <option value=""><?php echo $labelOptionOperDefault ?></option>
                                                            <option value="<?php echo $_SESSION['CodOperatore'] . ";" . $_SESSION['Nominativo'] ?>" selected=""><?php echo $_SESSION['Nominativo'] ?></option>
                                                            <?php while ($rowOper = mysql_fetch_array($sqlOper)) { ?>
                                                                <option value="<?php echo ($rowOper['codice'] . ";" . $rowOper['nominativo'] ) ?>"><?php echo ($rowOper['nominativo']) ?></option>
                                                            <?php } ?>
                                                        </select> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="cella2" ><?php echo $filtroProdotto ?></td>
                                                    <td class="cella1">
                                                        <select name="Prodotto" id="Prodotto" onChange="javascript:aggiornaScelte()">
                                                            <option value=""><?php echo $labelOptionProdDefault ?></option>
                                                            <option value="<?php echo $_SESSION['CodProdotto'] . ";" . $_SESSION['NomeProdotto'] ?>" selected=""><?php echo $_SESSION['CodProdotto'] . " " . $_SESSION['NomeProdotto'] ?></option>
                                                            <?php while ($rowProd = mysql_fetch_array($sqlProd)) { ?>
                                                                <option value="<?php echo $rowProd['cod_prodotto'] . ";" . $rowProd['nome_prodotto']; ?>"><?php echo $rowProd['cod_prodotto'] . " " . $rowProd['nome_prodotto']; ?></option>
                                                            <?php } ?>
                                                        </select> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class = "cella2" title = "<?php echo $titlePeriodoRif ?>"><?php echo $filtroPeriodoDiRif ?></td>
                                                    <td class = "cella1">
                                                        <!--############################ CALENDARIO ##########################-->
                                                        <table width = "100%" border = "0" cellspacing = "0" cellpadding = "5">
                                                            <tr>
                                                                <div style = "float: left;">
                                                                    <div style = "float: left; padding-right: 3px; line-height: 18px;"><?php echo $calendarioFrom ?>:</div>
                                                                    <div style = "float: left;">
                                                                        <?php visualizzaPrimoCalendario($_SESSION['Data3'], $_SESSION['Data4']); ?>
                                                                    </div>
                                                                </div>
                                                                <div style="float: left;">
                                                                    <div style="float: left; padding-left: 3px; padding-right: 3px; line-height: 18px;"><?php echo $calendarioTo ?>:</div>
                                                                    <div style="float: left;">
                                                                        <?php visualizzaSecondoCalendario($_SESSION['Data3'], $_SESSION['Data4']); ?>
                                                                    </div>
                                                            </tr>
                                                        </table>
                                                        <!--##################### FINE CALENDARIO ##########################-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="cella2"><?php echo $filtroOreLavorative ?></td>
                                                    <td class="cella1"> <input type="text" name="OreDaEscludere" id="OreDaEscludere" value="<?php echo $_SESSION['OreDaEscludere'] ?>" title="<?php echo $titleOreLavorative ?>"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="cella2"><?php echo $filtroOreInattivita ?></td>
                                                    <td class="cella1"> <input type="text" name="Inattivita" id="Inattivita" value="<?php echo $_SESSION['Inattivita'] ?>" title="<?php echo $titleOreInattivita ?>"/>
                                                    </td>
                                                </tr>
                                            </table>
                                            <!--#########################################################################-->                      
                                            <!--###################################### RISULTATI ########################-->
                                            <!--#########################################################################-->
                                            <table style="width:100%;">
                                                <tr>
                                                    <td class="cella3" colspan="3"><?php echo $filtroRisultati; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="cella2" style="width:30%" ><?php echo $titoloPaginaProduttivita; ?></td>
                                                    <td class="cella1" colspan='2'><?php echo $Produttivita . " " . $sacOra; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="cella2" ><?php echo $filtroOreTotLavoro; ?></td>
                                                    <td class="cella1" colspan='2'><?php echo $NumOreInServizio; ?> </td>
                                                </tr>
                                                <tr>
                                                    <td class="cella2" ><?php echo $filtroOreTotProduzione ?></td>
                                                    <td class="cella1" colspan='2'><?php echo $NumOreProd; ?> </td>
                                                </tr>
                                                <tr>
                                                    <td class="cella2" ><?php echo $filtroTempoMedInsacco ?> </td>
                                                    <td class="cella1" colspan='2'><?php echo $TempoMedioInsaccoOre; ?></br>

                                                </tr>
                                                <tr>
                                                    <td class="cella2" ><?php echo $filtroSacchiProdotti ?></td>
                                                    <td class="cella1"><?php echo $NumSac; ?> </td>
                                                    <?php if (count($_SESSION['objProduttivita']) > 0) { ?>
                                                        <td class="cella1" width="30px">

                                                            <a target="_blank" href='gestione_produttivita_tmp.php?IdMacchina=<?php echo $_SESSION['IdMacchina']; ?>&DataFrom=<?php echo $_SESSION['Data3']; ?>&DataTo=<?php echo $_SESSION['Data4']; ?>&CodProdotto=<?php echo $_SESSION['CodProdotto']; ?>&Nominativo=<?php echo $_SESSION['Nominativo']; ?>&InServizio=&Attivo=&ObjProduttivita=<?php echo $_SESSION['objProduttivita'] ?>&ObjStabGrupGeo=<?php echo $_SESSION['objStabGrupGeo'] ?>'>
                                                                <img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone" title="<?php echo $titleViewDetails ?>"/></a></td>

                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td class="cella2" ><?php echo $filtroTotInattivita ?></td>
                                                    <td class="cella1" colspan="2"><?php echo $NumOreInat; ?>
                                                   <!--     <td class="cella2" width="30px">
    <a href="JavaScript:openWindow('gestione_produttivita_tmp.php?IdMacchina=<?php echo $_SESSION['IdMacchina']; ?>&DataFrom=<?php echo $_SESSION['Data3']; ?>&DataTo=<?php echo $_SESSION['Data4']; ?>&CodProdotto=<?php echo $_SESSION['CodProdotto']; ?>&Nominativo=<?php echo $_SESSION['Nominativo']; ?>&Attivo=0&InServizio=1')">
                                                                <img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone" title="<?php echo $titleViewDetails ?>"/></a></td>-->
                                                </tr>
                                                <tr>
                                                    <td class="cella2" style="text-align: right " colspan="3">
                                                        <input type="reset"  onClick="javascript:window.open('/CloudFab/produttivita/reset_var_produttivita.php');" value="<?php echo $valueButtonReset ?>"/>
                                                        <input type="button" onClick="javascript:aggiornaScelte();" value="<?php echo $valueButtonCalcola ?>" /></td>
                                                </tr>
                                            </table>  
                                        </form>
                                    </div>
                                <?php }
                                ?>


                                <div id="msgLog"> <?php
                                    if ($DEBUG) {

                                        echo "</br>actionOnLoad :" . $actionOnLoad;
                                        echo "</br>Tab macchina : Utenti e aziende visibili " . $strUtAziendeMac;
                                        echo "</br>Tab gruppo : Utenti e aziende visibili " . $strUtAzGruppo;
                                        //########### LOG ######################################################
                                        echo "</br>SESSION['Data3'] : " . $_SESSION['Data3'];
                                        echo "</br>SESSION['Data4'] : " . $_SESSION['Data4'];
                                        echo "</br>SESSION['Stabilimento'] : " . $_SESSION['Stabilimento'];
                                        echo "</br>SESSION['OreDaEscludere'] : " . $_SESSION['OreDaEscludere'];
                                        echo "</br>SESSION['Inattivita'] : " . $_SESSION['Inattivita'];
                                        echo "</br>SESSION['Operatore'] : " . $_SESSION['Operatore'];
                                        echo "</br>SESSION['CodOperatore'] : " . $_SESSION['CodOperatore'];
                                        echo "</br>SESSION['Nominativo'] : " . $_SESSION['Nominativo'];
                                        echo "</br>SESSION['Prodotto'] : " . $_SESSION['Prodotto'];
                                        echo "</br>SESSION['IdMacchina'] : " . $_SESSION['IdMacchina'];
                                        echo "</br>SESSION['DescriStab'] : " . $_SESSION['DescriStab'];
                                        echo "</br>SESSION['Gruppo'] : " . $_SESSION['Gruppo'];
                                        echo "</br>SESSION['LivelloGruppo'] : " . $_SESSION['LivelloGruppo'];
                                        echo "</br>SESSION['Geografico'] : " . $_SESSION['Geografico'];
                                        echo "</br>SESSION['TipoRiferimento'] : " . $_SESSION['TipoRiferimento'];
                                        echo "</br>SESSION['Submit'] : " . $_SESSION['Submit'];
                                    }
                                    ?></div>                                
                                </div><!--mainContainer-->
                                </body>




                                </html> 
