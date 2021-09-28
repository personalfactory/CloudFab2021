<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>

        <div id="mainContainer">
            <script language="javascript">
                function Calcola() {

                    document.forms["Produttivita"].action = "gestione_produttivita.php";
                    document.forms["Produttivita"].submit();
                }

            </script>
            <link href="../object/calendar/calendar.css" rel="stylesheet" type="text/css" />
            <script language="javascript" src="../object/calendar/calendar.js"></script>

            <?php
            $pagina = "gestione_produttivita.php";

            include('../include/menu.php');
            include('../include/funzioni.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_produttivita.php');
            include('../sql/script_processo.php');
            include('../sql/script_macchina.php');
            include('../sql/script.php');
//            include('../sql/script_figura.php');
//            include('../sql/script_gruppo.php');
//            include('../sql/script_stab_gruppo_geo.php');
            include('../sql/script_tempo_medio_insacco.php');
            include('../js/visualizza_elementi.js');
            include('../js/popup.js');
            require_once('../object/calendar/classes/tc_calendar.php');
            require_once('../object/calendar/calendar_func.php');

            if (!isset($_SESSION['Submit']) OR $_SESSION['Submit'] == "") {

//Inizializzazzione delle variabili di sessione
                $_SESSION['Data3'] = "";
                $_SESSION['Data4'] = "";
                $_SESSION['IdMacchina'] = "";
                $_SESSION['Stabilimento'] = "";
                $_SESSION['OreDaEscludere'] = "";
                $_SESSION['Inattivita'] = "";
                $_SESSION['Prodotto'] = "";
                $_SESSION['DescriStab'] = "";
                $_SESSION['Submit'] = "";

                //########### LOG ##############################################
//                echo "</br>SESSION['Data3'] : " . $_SESSION['Data3'];
//                echo "</br>SESSION['Data4'] : " . $_SESSION['Data4'];
//                echo "</br>SESSION['Stabilimento'] : " . $_SESSION['Stabilimento'];
//                echo "</br>SESSION['OreDaEscludere'] : " . $_SESSION['OreDaEscludere'];
//                echo "</br>SESSION['Inattivita'] : " . $_SESSION['Inattivita'];
//                echo "</br>SESSION['Prodotto'] : " . $_SESSION['Prodotto'];
//                echo "</br>SESSION['IdMacchina'] : " . $_SESSION['IdMacchina'];
//                echo "</br>SESSION['DescriStab'] : " . $_SESSION['DescriStab'];
//                echo "</br>SESSION['Submit'] : " . $_SESSION['Submit'];
                //##############################################################

                $sqlSta = findMacchinaByAbilitato(1);
                $sqlProd = selectProdottiFromProcesso2($_SESSION['id_utente']);
                ?>

                <div id="container" style="width:900px; margin:15px auto;">
                    <form id="Produttivita" name="Produttivita" method="post" action="">
                        <table style="width:100%;">
                            <tr>
                                <td class="cella3" colspan="2"><?php echo $titoloPaginaProduttivita; ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroStabilimento; ?> </td>
                                <td class="cella1">
                                    <select name="Stabilimento" id="Stabilimento" >
                                        <option value="<?php echo "0;" . $labelOptionStabDefault; ?>"> <?php echo $labelOptionStabDefault; ?></option>
                                        <?php
                                        while ($rowSta = mysql_fetch_array($sqlSta)) {
                                            ?>
                                            <option value="<?php echo ($rowSta['id_macchina'] . ";" . $rowSta['descri_stab']); ?>"><?php echo ($rowSta['descri_stab']); ?></option>
                                        <?php } ?>
                                    </select> 
                                </td>
                            </tr>

                            <tr>
                                <td class="cella2"><?php echo $filtroProdotto ?></td>
                                <td class="cella1">
                                    <select name="Prodotto" id="Prodotto" >
                                        <option value=""><?php echo $labelOptionProdDefault ?></option>
                                            <?php
                                            while ($rowProd = mysql_fetch_array($sqlProd)) {
                                                ?>
                                            <option value="<?php echo $rowProd['cod_prodotto'] . ";" . $rowProd['nome_prodotto']; ?>"><?php echo $rowProd['cod_prodotto'] . " " . $rowProd['nome_prodotto']; ?></option>
                                        <?php } ?>
                                    </select> 
                                </td>
                            </tr>
                            <tr>
                                <td class="cella2" title="Time to evaluate productivity"><?php echo $filtroPeriodoDiRif ?></td>
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
                                    <input type="reset"  onClick="javascript:window.open('/CloudFab/stabilimenti/reset_var_produttivita.php');" value="<?php echo $valueButtonReset ?>"/>
                                    <input type="button" onClick="javascript:window.open('/CloudFab/stabilimenti/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Submit=1', 'SettaVar');" value="<?php echo $valueButtonCalcola ?>" />
                                    </table>  
                                    </form>
                                    </div>
    <?php
} else {

    list($_SESSION['IdMacchina'], $_SESSION['DescriStab']) = explode(';', $_SESSION['Stabilimento']);

    if (!isset($_SESSION['OreDaEscludere']) OR $_SESSION['OreDaEscludere'] == "") {

        $_SESSION['OreDaEscludere'] = 24;
    }

    if (!isset($_SESSION['Inattivita']) OR $_SESSION['Inattivita'] == "") {

        $_SESSION['Inattivita'] = 10000; //(1 anno in ore)
    }

    if (!isset($_SESSION['Prodotto']) OR $_SESSION['Prodotto'] == "") {
        $_SESSION['CodProdotto'] = "";
        $_SESSION['NomeProdotto'] = $labelOptionProdDefault;
    } else {
        list($_SESSION['CodProdotto'], $_SESSION['NomeProdotto']) = explode(';', $_SESSION['Prodotto']);
    }


    //########### LOG ######################################################
//    echo "</br>SESSION['Data3'] : " . $_SESSION['Data3'];
//    echo "</br>SESSION['Data4'] : " . $_SESSION['Data4'];
//    echo "</br>SESSION['Stabilimento'] : " . $_SESSION['Stabilimento'];
//    echo "</br>SESSION['OreDaEscludere'] : " . $_SESSION['OreDaEscludere'];
//    echo "</br>SESSION['Inattivita'] : " . $_SESSION['Inattivita'];
//    echo "</br>SESSION['Prodotto'] : " . $_SESSION['Prodotto'];
//    echo "</br>SESSION['IdMacchina'] : " . $_SESSION['IdMacchina'];
//    echo "</br>SESSION['DescriStab'] : " . $_SESSION['DescriStab'];
//    echo "</br>SESSION['Submit'] : " . $_SESSION['Submit'];


    $sqlStab = findMacchinaByAbilitato(1);

    $sqlProd = selectProdottiFromProcesso2();

    //############################################################################
    //###################### CALCOLI PRODUTTIVITA ################################
    //############################################################################

    $NumSac = 0;
    $NumOre = 1;
    $Produttivita = 0;

    begin();
    
    if ($_SESSION['IdMacchina'] != "0") {
        //POPOLAMENTO DELLA TABELLA PRODUTTIVITA'
        callDataDiffStabSp($_SESSION['IdMacchina'], $_SESSION['Data3'], $_SESSION['Data4'], $_SESSION['OreDaEscludere'], $_SESSION['CodProdotto'], $_SESSION['id_utente']);
    } else {
        //POPOLAMENTO DELLA TABELLA PRODUTTIVITA'
        callDataDiffStabAllSp($_SESSION['Data3'], $_SESSION['Data4'], $_SESSION['OreDaEscludere'], $_SESSION['CodProdotto'], $_SESSION['id_utente']);
    }
    commit();
//Trasformo l'input in secondi
    $SecondiDaEscludere = $_SESSION['OreDaEscludere'] * 3600;
    $SecondiInattivita = $_SESSION['Inattivita'] * 3600;

    //##################### Eseguo e registro i calcoli nella tabella produttivita #############################
    updateProduttivitaInServizio($SecondiDaEscludere, $_SESSION['id_utente']);
    updateProduttivitaAttivo($SecondiInattivita, $_SESSION['id_utente']);

    //##################### IN SERVIZIO #################################################################
    $sqlNumSecInServizio = selectSecInServizioFromProduttivita($_SESSION['id_utente']);

    while ($rowSecInServizio = mysql_fetch_array($sqlNumSecInServizio)) {

        $NumSecInServizio = $rowSecInServizio['num_sec_in_servizio'];
        $NumOreInServizio = floor($NumSecInServizio / 3600) . " " . $ore . " " . floor(fmod($NumSecInServizio, 3600) / 60) . " " . $minuti;
    }


    //##################### TEMPO MEDIO INSACCO ######################################################               
    //SE SI SCEGLIE UN SOLO STABILIMENTO SI ESEGUE IL CALOCOLO ALTRIMENTI NO
    if ($_SESSION['IdMacchina'] != "0") {

        deleteTempoMedioInsaccoByIdUtente($_SESSION['id_utente']);

        insertIntoTempoMedioInsacco($_SESSION['id_utente']);

        $sqlTempoMedioIns = selectTempoMedioInsacco($_SESSION['id_utente']);

        while ($rowTempoMed = mysql_fetch_array($sqlTempoMedioIns)) {
            $TempoMedioInsaccoSec = $rowTempoMed['media_pesata'];
            $TempoMedioInsaccoOre = floor($TempoMedioInsaccoSec / 3600) . " " . $ore . " " . floor(fmod($TempoMedioInsaccoSec, 3600) / 60) . " " . $minuti;
        }
    }


    //##################### INATTIVITA #################################################################               

    $sqlNumOreInat = selectSecInatFromProduttivita($_SESSION['id_utente']);
    while ($rowOreInat = mysql_fetch_array($sqlNumOreInat)) {
        $NumSecondiInat = $rowOreInat['num_sec_inat'];
        $NumOreInat = floor($NumSecondiInat / 3600) . " " . $ore . " " . floor(fmod($NumSecondiInat, 3600) / 60) . " " . $minuti;
    }


    //##################### PRODUZIONE EFFETTIVA ######################################################

    $sqlNumSecProd = selectSecProdFromProduttivita($_SESSION['id_utente']);

    while ($rowOreProd = mysql_fetch_array($sqlNumSecProd)) {
        $NumSecondiProd = $rowOreProd['num_sec_prod'];
        $NumOreProd = floor($NumSecondiProd / 3600) . " " . $ore . " " . floor(fmod($NumSecondiProd, 3600) / 60) . " " . $minuti;
    }

    //Numero di sacchi prodotti in totale fra le due date prese in considerazione
    $sqlNumSac = selectNumSacFromProduttivita($_SESSION['id_utente']);
    while ($rowSac = mysql_fetch_array($sqlNumSac)) {

        $NumSac = $rowSac['num_sac'];
    }

    //Le ore di produttività vanno calcolate sottraendo alle ore totali che ci sono fra le due date,
    // le ore da escludere ed il tempo di inattivita
    $Produttivita = number_format(($NumSac / $NumSecondiProd) * 3600, 2);
    ?>

                                    <div id = "container" style = "width:900px; margin:15px auto;">
                                        <form id = "Produttivita" name = "Produttivita" method ="post" >
                                            <table style = "width:100%;">
                                                <tr>
                                                    <td class = "cella3" colspan = "2"><?php echo $titoloPaginaProduttivita ?></td>
                                                </tr>


                                                <tr>
                                                    <td class = "cella2"><?php echo $filtroStabilimento ?> </td>
                                                    <td class = "cella1">
                                                        <select name="Stabilimento" id="Stabilimento" >
                                                            <option value="<?php echo "0;" . $labelOptionStabDefault ?>"> <?php echo $labelOptionStabDefault ?></option>
                                                            <option value="<?php echo $_SESSION['IdMacchina'] . ";" . $_SESSION['DescriStab'] ?>" selected=" "><?php echo $_SESSION['DescriStab'] ?></option>
    <?php
    while ($rowStab = mysql_fetch_array($sqlStab)) {
        ?>
                                                                <option value="<?php echo ($rowStab['id_macchina'] . ";" . $rowStab['descri_stab']); ?>"><?php echo ($rowStab['descri_stab']); ?></option>
                                                            <?php } ?>
                                                        </select> 
                                                    </td>
                                                </tr>                                                
                                                <tr>
                                                    <td class="cella2" ><?php echo $filtroProdotto ?></td>
                                                    <td class="cella1">
                                                        <select name="Prodotto" id="Prodotto" >
                                                            <option value=""><?php echo $labelOptionProdDefault ?></option>
                                                            <option value="<?php echo $_SESSION['CodProdotto'] . ";" . $_SESSION['NomeProdotto'] ?>" selected=""><?php echo $_SESSION['CodProdotto'] . " " . $_SESSION['NomeProdotto'] ?></option>
                                                                <?php
                                                                while ($rowProd = mysql_fetch_array($sqlProd)) {
                                                                    ?>
                                                                <option value="<?php echo $rowProd['cod_prodotto'] . ";" . $rowProd['nome_prodotto']; ?>"><?php echo $rowProd['cod_prodotto'] . " " . $rowProd['nome_prodotto']; ?></option>
                                                            <?php } ?>
                                                        </select> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class = "cella2" title = "Time to evaluate productivity"><?php echo $filtroPeriodoDiRif ?></td>
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
                                                    <td class="cella2" ><?php echo $titoloPaginaProduttivita; ?></td>
                                                    <td class="cella2" colspan='2'><?php echo $Produttivita . " " . $sacOra; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="cella2" ><?php echo $filtroOreTotLavoro; ?></td>
                                                    <td class="cella2" colspan='2'><?php echo $NumOreInServizio; ?> </td>
                                                </tr>
                                                <tr>
                                                    <td class="cella2" ><?php echo $filtroOreTotProduzione ?></td>
                                                    <td class="cella2" colspan='2'><?php echo $NumOreProd; ?> </td>
                                                </tr>
                                                <tr>
                                                    <td class="cella2" ><?php echo $filtroTempoMedInsacco ?> </td>
                                                    <td class="cella2" colspan='2'><?php echo $TempoMedioInsaccoOre; ?></br>

                                                </tr>
                                                <tr>
                                                    <td class="cella2" ><?php echo $filtroSacchiProdotti ?></td>
                                                    <td class="cella2"><?php echo $NumSac; ?> </td>
                                                    <td class="cella2" width="30px"><a target="_blank" href="gestione_produttivita_tmp_pubblico.php?IdMacchina=<?php echo $_SESSION['IdMacchina']; ?>&DataFrom=<?php echo $_SESSION['Data3']; ?>&DataTo=<?php echo $_SESSION['Data4']; ?>&CodProdotto=<?php echo $_SESSION['CodProdotto']; ?>&Nominativo=&InServizio=&Attivo=">
                                                        <!--<a href="JavaScript:openWindow('gestione_produttivita_tmp.php?IdMacchina=<?php echo $_SESSION['IdMacchina']; ?>&DataFrom=<?php echo $_SESSION['Data3']; ?>&DataTo=<?php echo $_SESSION['Data4']; ?>&CodProdotto=<?php echo $_SESSION['CodProdotto']; ?>&Nominativo=&InServizio=&Attivo=')">-->
                                                            <img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone" title="<?php echo $titleViewDetails ?>"/></a></td>
                                                </tr>
                                                <tr>
                                                    <td class="cella2" ><?php echo $filtroTotInattivita ?></td>
                                                    <td class="cella2"><?php echo $NumOreInat; ?>
                                                        <td class="cella2" width="30px"><a target="_blank" href="gestione_produttivita_tmp_pubblico.php?IdMacchina=<?php echo $_SESSION['IdMacchina']; ?>&DataFrom=<?php echo $_SESSION['Data3']; ?>&DataTo=<?php echo $_SESSION['Data4']; ?>&CodProdotto=<?php echo $_SESSION['CodProdotto']; ?>&Nominativo=&Attivo=0&InServizio=1">
                                                            <!--<a href="JavaScript:openWindow('gestione_produttivita_tmp.php?IdMacchina=<?php echo $_SESSION['IdMacchina']; ?>&DataFrom=<?php echo $_SESSION['Data3']; ?>&DataTo=<?php echo $_SESSION['Data4']; ?>&CodProdotto=<?php echo $_SESSION['CodProdotto']; ?>&Nominativo=&Attivo=0&InServizio=1')">-->
                                                                <img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone" title="<?php echo $titleViewDetails ?>"/></a></td>
                                                </tr>
                                                <tr>
                                                    <td class="cella2" style="text-align: right " colspan="3">

                                                        <input type="reset"  onClick="javascript:window.open('/CloudFab/stabilimenti/reset_var_produttivita.php');" value="<?php echo $valueButtonReset ?>"/>
                                                        <input type="button" onClick="javascript:window.open('/CloudFab/stabilimenti/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Submit=1', 'SettaVar');" value="<?php echo $valueButtonCalcola ?>" /></td>
                                                </tr>
                                            </table>  
                                        </form>
                                    </div>
<?php }
?>
                                </div><!--mainContainer-->
                                </body>
                                </html> 