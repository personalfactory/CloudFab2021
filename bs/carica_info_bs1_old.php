<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php');
        ?>
    </head>
    <script language="javascript">

        function BloccaTastoInvio(evento)
        {
            codice_tasto = evento.keyCode ? evento.keyCode : evento.which ? evento.which : evento.charCode;
            if (codice_tasto == 13)
            {
                event.returnValue = false;
            }

        }

        function AggiornaPagina() {

            document.forms["CaricaBs"].action = "carica_info_bs1.php";
            document.forms["CaricaBs"].submit();
        }
        function VediRiepilogo() {
            document.forms["CaricaBs"].action = "salva_info_bs1.php";
            document.forms["CaricaBs"].submit();
        }
        function VediCatalogo() {
            document.forms["CaricaBs"].action = "vista_prodotti_catalogo.php";
            document.forms["CaricaBs"].submit();
        }

        function mostraDettaglioCostiVar() {

            for (i = 0; i < document.getElementsByName('tdCostiVar').length; i++) {
                document.getElementsByName('tdCostiVar')[i].style.display = "table-cell";
            }

            var y1 = document.getElementById("riga1").colSpan;
            var y2 = document.getElementById("riga2").colSpan;
            var y3 = document.getElementById("riga3").colSpan;

            document.getElementById("rigaTotali").colSpan = 5 + 7;
            if (y1 === 12 || y1 === 23) {
                document.getElementById("riga1").colSpan = y1 + 7;
                document.getElementById("riga2").colSpan = y2 + 7;
                document.getElementById("riga3").colSpan = y3 + 7;

            }
            document.getElementById("container").style.width = "120%";

        }

        function nascondiDettaglioCostiVar() {

            for (i = 0; i < document.getElementsByName('tdCostiVar').length; i++) {
                document.getElementsByName('tdCostiVar')[i].style.display = "none";
            }

            document.getElementById("rigaTotali").colSpan = 12 - 7;
            var y1 = document.getElementById("riga1").colSpan;
            var y2 = document.getElementById("riga2").colSpan;
            var y3 = document.getElementById("riga3").colSpan;

            if (y1 === 19 || y1 === 30) {
                document.getElementById("riga1").colSpan = y1 - 7;
                document.getElementById("riga2").colSpan = y2 - 7;
                document.getElementById("riga3").colSpan = y3 - 7;
                document.getElementById("container").style.width = "90%";
            }

        }

        function mostraAltreInfoProdotti() {
            for (i = 0; i < document.getElementsByName('altreInfoPr').length; i++) {
                document.getElementsByName('altreInfoPr')[i].style.display = "table-cell";
            }

            var y1 = document.getElementById("riga1").colSpan;
            var y2 = document.getElementById("riga2").colSpan;
            var y3 = document.getElementById("riga3").colSpan;


            if (y1 === 12 || y1 === 19) {
                document.getElementById("riga1").colSpan = y1 + 11;
                document.getElementById("riga2").colSpan = y2 + 11;
                document.getElementById("riga3").colSpan = y3 + 11;
            }
            document.getElementById("container").style.width = "120%";
        }

        function nascondiAltreInfoProdotti() {
            for (i = 0; i < document.getElementsByName('altreInfoPr').length; i++) {
                document.getElementsByName('altreInfoPr')[i].style.display = "none";

            }
            var y1 = document.getElementById("riga1").colSpan;
            var y2 = document.getElementById("riga2").colSpan;
            var y3 = document.getElementById("riga3").colSpan;


            if (y1 === 23 || y1 === 30) {
                document.getElementById("riga1").colSpan = y1 - 11;
                document.getElementById("riga2").colSpan = y2 - 11;
                document.getElementById("riga3").colSpan = y3 - 11;
                document.getElementById("container").style.width = "90%";
            }
        }
    </script>
    <?php
    $wid1 = "7%"; //codice
    $wid2 = "10%"; //descrizione
    $wid3 = "2%"; //listino kit
    $wid28 = "2%"; //num kit
    $wid29 = "2%"; //num lotti
    //#############
    $wid4 = "2%"; //kit scontato
    $wid5 = "2%"; // costo produzione
    $wid6 = "2%"; // costo drymix
    $wid7 = "2%"; // costo trasporto
    $wid8 = "2%"; // altri costi

    $wid30 = "2%"; // generatore listino
    $wid9 = "2%"; // listino suggerito
    $wid10 = "2%"; // venduto privato
    $wid11 = "2%"; // venduto imprese
    $wid12 = "2%"; // venduto rivenditore
    //##############

    $wid13 = "5%"; // prezzo medio
    $wid14 = "5%"; // ricavi
    $wid15 = "5%"; // costi variabili
    $wid16 = "5%"; // primo margine
    //##############
    $wid17 = "10%"; // features
    $wid18 = "5%"; // corrispettivo 1
    $wid19 = "2%"; // prezzo 1
    $wid20 = "5%"; // note 1
    $wid21 = "5%"; // corrispettivo 2
    $wid22 = "2%"; // prezzo 2
    $wid23 = "5%"; // note 2 
    $wid24 = "5%"; // corrispettivo 3
    $wid25 = "2%"; // prezzo 3
    $wid26 = "5%"; // note 3
    $wid27 = "5%"; // data


    if ($DEBUG)
        ini_set('display_errors', '1');

    //##################### VERIFICA PERMESSI ##################################
    $actionOnLoad = "";
    $elencoFunzioni = array("137"); //137 vedi catalogo marie
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);
    $strUtentiAziendesPr = getStrUtAzVisib($_SESSION['objPermessiVis'], 'bs_prodotto');
    //##########################################################################

    include('../Connessioni/serverdb.php');
    include('../include/precisione.php');
    include('../include/gestione_date.php');
    include('../sql/script_bs_prodotto.php');
    include('../sql/script_bs_valore_dato.php');
    include('../sql/script_bs_prodotto_cliente.php');
    include('../sql/script_bs_cliente.php');
    include('../sql/script_bs_comp_cliente.php');
    include('../sql/script_bs_riepilogo.php');
    include('../sql/script_componente.php');
    include('../sql/script_componente_prodotto.php');
    include('../sql/script_lotto_artico.php');
    include('../sql/script_formula.php');


    //GESTIONE VALUTA
    //In questa pagina il cambio di valuta è un pò diverso dalla pagina precedente
    //perchè i dati li recupero sempre dal db e sempre in euro (anche se la valuta 
    //corrente selezionata pò essere dollaro)
    ////########################################################################

    $_SESSION['aggPagVenduto'] ++;

    if (isset($_POST['valutaBs'])) {
        foreach ($_POST['valutaBs'] as $key => $value) {
            $_SESSION['valutaBs'] = $key;
        }
    }

    if (isSet($_SESSION['valutaBs'])) {
        switch ($_SESSION['valutaBs']) {
            case 1:

                $_SESSION['cambio'] = 1;
                $_SESSION['filtro'] = "filtroEuro";
                break;
            case 2:
                if(isSet( $_SESSION['cambioIniziale']))
                $_SESSION['cambio'] = $_SESSION['cambioIniziale'];
                
                
                $_SESSION['filtro'] = "filtroDollaro";
                break;
        }
    }
    
    $filtroValuta = "{${$_SESSION['filtro']}}";


//    echo "<br/>aggPagVenduto: " . $_SESSION['aggPagVenduto'];
//    echo "<br/>valutaIniziale: " . $_SESSION['valutaIniziale'];
//    echo "<br/>cambioIniziale: " . $_SESSION['cambioIniziale'];
//    echo "<br/>valutaAttuale: " . $_SESSION['valutaBs'];
//    echo "<br/>cambioAttuale: " . $_SESSION['cambio'];
//    echo "<br/>filtro: " . $_SESSION['filtro'];
    //#######################################################
    //##########################################################################
    //Questi post servono??
    if (isset($_POST['Anno'])) {
        $_SESSION['Anno'] = trim($_POST['Anno']);
    }
    if (isset($_POST['ScontoKit'])) {
        $_SESSION['ScontoKit'] = trim($_POST['ScontoKit']);
    }
    if (isset($_POST['PrezzoMacchina'])) {
        $_SESSION['PrezzoMacchina'] = trim($_POST['PrezzoMacchina']);
    }
    if (isset($_POST['CostoOperaio'])) {
        $_SESSION['CostoOperaio'] = trim($_POST['CostoOperaio']);
    }
    if (isset($_POST['Produttivita'])) {
        $_SESSION['Produttivita'] = trim($_POST['Produttivita']);
    }
    if (isset($_POST['CostoElettricita'])) {
        $_SESSION['CostoElettricita'] = trim($_POST['CostoElettricita']);
    }
    if (isset($_POST['AnniAmmortamentoMac'])) {
        $_SESSION['AnniAmmortamentoMac'] = trim($_POST['AnniAmmortamentoMac']);
    }
    if (isset($_POST['CostoSacco'])) {
        $_SESSION['CostoSacco'] = trim($_POST['CostoSacco']);
    }
    if (isset($_POST['CostoTrasporto'])) {
        $_SESSION['CostoTrasporto'] = trim($_POST['CostoTrasporto']);
    }
    if (isset($_POST['SpeseMarketing'])) {
        $_SESSION['SpeseMarketing'] = trim($_POST['SpeseMarketing']);
    }
    if (isset($_POST['CostiAnno'])) {
        $_SESSION['CostiAnno'] = trim($_POST['CostiAnno']);
    }
    if (isset($_POST['AnniAmmAltriInv'])) {
        $_SESSION['AnniAmmAltriInv'] = trim($_POST['AnniAmmAltriInv']);
    }
    if (isset($_POST['AltriInvestimenti'])) {
        $_SESSION['AltriInvestimenti'] = trim($_POST['AltriInvestimenti']);
    }
    if (isset($_POST['ScontoPrivato'])) {
        $_SESSION['ScontoPrivato'] = trim($_POST['ScontoPrivato']);
    }
    if (isset($_POST['ScontoImpresa'])) {
        $_SESSION['ScontoImpresa'] = trim($_POST['ScontoImpresa']);
    }
    if (isset($_POST['ScontoRivenditore'])) {
        $_SESSION['ScontoRivenditore'] = trim($_POST['ScontoRivenditore']);
    }
    if (isset($_POST['NumeroOreLavorabili'])) {
        $_SESSION['NumeroOreLavorabili'] = trim($_POST['NumeroOreLavorabili']);
    }


    //TODO_bs può essere NEW oppure MODIFY
    if (isSet($_GET['TODO_bs']))
        $_SESSION['TODO_bs'] = $_GET['TODO_bs'];


    $sqlProdotti = "";
    if ($_SESSION['TODO_bs'] == "NEW") {

        $sqlProdotti = findBSProdottiUnion($strUtentiAziendesPr);

        //##################### MODIFICA SIMULAZIONE ESISTENTE #####################    
    } else if ($_SESSION['TODO_bs'] == "MODIFY") {
        if (isSet($_GET['IdCliente']) AND isSet($_GET['IdAzienda']) AND isSet($_GET['Anno'])) {
            $_SESSION['id_cliente'] = $_GET['IdCliente'];
            $_SESSION['id_azienda'] = $_GET['IdAzienda'];
            $_SESSION['Anno'] = $_GET['Anno'];
        }

        $sqlProdotti = findBSProdottiByClienteUnion($_SESSION['Anno'], $_SESSION['id_cliente']);
    }
//Recupero i valori dati dalla tabella bs_valore_dati
    $sqlDati = findValoriDatiByCliente($_SESSION['id_cliente'], "ordine", $_SESSION['lingua']);
    while ($rowDati = mysql_fetch_array($sqlDati)) {

        $_SESSION[$rowDati['nome_dato']] = $rowDati['valore'];
        if ($rowDati['tipo1'] == "valuta") {
            $_SESSION[$rowDati['nome_dato']] = $rowDati['valore'] * $_SESSION['cambio'];
        }
    }
    $_SESSION['nome_cliente_bs'] = "";

    //Recupero il nominativo del cliente da visualizzare
    $sqlNomeCliente = findClienteBsById($_SESSION['id_cliente']);
    while ($rowNome = mysql_fetch_array($sqlNomeCliente)) {

        $_SESSION['nome_cliente_bs'] = $rowNome['nominativo'];
    }

    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">

        <div id="mainContainer" style="width:100%">

            <div  style="width:1320px;margin: 0 auto;"><?php include('../include/menu.php'); ?></div>

            <div id="container" style="width:80%;margin:15px auto;">

                <form id="CaricaBs" name="CaricaBs" method="post"  >
                <table style="border-radius: 10px 10px 10px 10px;"> 
<?php
//Scelta valuta
include('../include/scelta_valuta.php');
?><br/><br/><br/><br/>

                    <tr>
                        <td id="riga1" class="cella3" colspan="12"> <?php echo $filtroAnnoRif . ": <span style='font-size: 20px'>" . $_SESSION['Anno'] . "</span> &nbsp;&nbsp;&nbsp;&nbsp;" . $filtroCliente . ": <span style='font-size: 20px'>" . $_SESSION['nome_cliente_bs'] . "</span> " ?></td>
                    </tr> 
                    <tr>
                        <td id="riga2" class="cella2" colspan="12">
                            <div style="text-align:left">
                                <input type="reset" value="<?php echo $valueButtonIndietro ?>" onClick="location.href='carica_info_bs.php'"/>
                                <input type="submit" name="submit1"  onClick="AggiornaPagina()" title ="<?php echo $titleAggCalcoli ?>" value="<?php echo $valueButtonAggiornaCalcoli ?>" />
                                <input type="submit" name="riepilogo" onClick="VediRiepilogo()" value="<?php echo $valueButtonRiepilogo ?>" />&nbsp;
                                <input type="submit" name="137" onClick="VediCatalogo()" value="<?php echo $valueButtonCatalogo ?>" />&nbsp;
                            </div>

                            <div style="text-align:right">
                                <input type="button" value="+" onClick="mostraAltreInfoProdotti();" title="<?php echo $titleMostraAltreInfoProd ?>"></input>
                                <input type="button" value="-" onClick="nascondiAltreInfoProdotti();" title="<?php echo $titleNascondiAltreInfoProd ?>"></input>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="cella3Light" width="<?php echo $wid1 ?>"><?php echo $filtroCodice ?></td>
                        <td class="cella3Light" width="<?php echo $wid2 ?>"><?php echo $filtroNomeProdotto ?></td>
                        <td class="cella3Light" width="<?php echo $wid5 ?>"  title="<?php echo $titleCostoProduzione ?>">
<?php echo $filtroCostoProduzione . " " . $filtroValuta . "/" . $filtroQuintaleBreve ?>
                            <input class="button6" type="button" value="+" onClick="mostraDettaglioCostiVar();" title="<?php echo $titleMostraDettaglioCostiProduzione ?>"></input>
                            <input class="button6" type="button" value="-" onClick="nascondiDettaglioCostiVar();" title="<?php echo $titleNascondiDettaglioCostiProduzione ?>"></input>
                        </td>
                        <td style="display:none" name="tdCostiVar" class="cella1" width="<?php echo $wid28 ?>" ><?php echo $filtroNumKitMin ?></td>
                        <td style="display:none" name="tdCostiVar" class="cella1" width="<?php echo $wid29 ?>" ><?php echo $filtroNumLottiMin ?></td>
                        <td style="display:none" name="tdCostiVar" class="cella1" width="<?php echo $wid3 ?>" title="<?php echo $titleListinoKit ?>"><?php echo $filtroListinoKitMin ?></td>
                        <td style="display:none" name="tdCostiVar" class="cella1" width="<?php echo $wid4 ?>"><?php echo $filtroListinoKitScontMin ?></td>
                        <td style="display:none" name="tdCostiVar" class="cella1" width="<?php echo $wid6 ?>"><?php echo $filtroCostoDrymix ?></td>
                        <td style="display:none" name="tdCostiVar" class="cella1" width="<?php echo $wid7 ?>" title="<?php echo $titleCostoTrasporto ?>"><?php echo $filtroCostoTrasporto ?></td>
                        <td style="display:none" name="tdCostiVar" class="cella1" width="<?php echo $wid8 ?>" title="<?php echo $titleAltriCosti ?>"><?php echo $filtroAltriCosti ?></td>

                        <td class="cella3Light" width="<?php echo $wid30 ?>" title="<?php echo $titleValoreGeneraListino ?>"><?php echo $filtroValGeneraListino ?></td>
                        <td class="cella3Light" width="<?php echo $wid9 ?>"  title="<?php echo $titleListinoSuggerito ?>"><?php echo $filtroListinoSuggerito . " " . $filtroValuta . "/" . $filtroQuintaleBreve ?></td>
                        <td class="cella3Light" width="<?php echo $wid10 ?>" title="<?php echo $titleVendutoPrivati ?>"><?php echo $filtroTonVendutoPrivato ?></td>
                        <td class="cella3Light" width="<?php echo $wid11 ?>" title="<?php echo $titleVendutoImprese ?>"><?php echo $filtroTonVendutoImprese ?></td>
                        <td class="cella3Light" width="<?php echo $wid12 ?>" title="<?php echo $titleVendutoRivenditori ?>"><?php echo $filtroTonVendutoRivenditore ?></td>
                        <td class="cella3Light" width="<?php echo $wid13 ?>" title="<?php echo $titlePrezzoVenditaMedio ?>"><?php echo $filtroPrezzoVenditaMedio . " " . $filtroValuta . "/" . $filtroQuintaleBreve ?></td>
                        <td class="cella3Light" width="<?php echo $wid14 ?>" title="<?php echo $titleRicaviVenduto ?>"><?php echo $filtroRicavi ?></td>
                        <td class="cella3Light" width="<?php echo $wid15 ?>" title="<?php echo $titleCostiVariabiliVenduto ?>"><?php echo $filtroCostiVariabili ?></td>
                        <td class="cella3Light" width="<?php echo $wid16 ?>" title="<?php echo $titlePrimoMargine ?>"><?php echo $filtroPrimoMargine ?></td>                            

                        <td style="display:none" name="altreInfoPr" class="cella1" width="<?php echo $wid17 ?>"><?php echo $filtroFeatures ?></td>
                        <td style="display:none" name="altreInfoPr" class="cella1" width="<?php echo $wid18 ?>"><?php echo $filtroCorrispettivo1 ?></td>
                        <td style="display:none" name="altreInfoPr" class="cella1" width="<?php echo $wid19 ?>"><?php echo $filtroPrezzo1 ?></td>
                        <td style="display:none" name="altreInfoPr" class="cella1" width="<?php echo $wid20 ?>"><?php echo $filtroNote1 ?></td>
                        <td style="display:none" name="altreInfoPr" class="cella1" width="<?php echo $wid21 ?>"><?php echo $filtroCorrispettivo2 ?></td>
                        <td style="display:none" name="altreInfoPr" class="cella1" width="<?php echo $wid22 ?>"><?php echo $filtroPrezzo2 ?></td>
                        <td style="display:none" name="altreInfoPr" class="cella1" width="<?php echo $wid23 ?>"><?php echo $filtroNote2 ?></td>
                        <td style="display:none" name="altreInfoPr" class="cella1" width="<?php echo $wid24 ?>"><?php echo $filtroCorrispettivo3 ?></td>
                        <td style="display:none" name="altreInfoPr" class="cella1" width="<?php echo $wid25 ?>"><?php echo $filtroPrezzo3 ?></td>
                        <td style="display:none" name="altreInfoPr" class="cella1" width="<?php echo $wid26 ?>"><?php echo $filtroNote3 ?></td>
                        <td style="display:none" name="altreInfoPr" class="cella1" width="<?php echo $wid27 ?>"><?php echo $filtroDt ?></td>

                    </tr> 
<?php
//TODO : creare un array di oggetti materia prima e poi leggerli dall'oggetto 
//Visualizzo i campi di input relativi alle materie prime presenti nella tabella materia_prima
//TOTALI
$costoProduzioneTot = 0;
$sacchiVendutiPrivatoTot = 0;
$sacchiVendutiImpresaTot = 0;
$sacchiVendutiRivenditoreTot = 0;
$ricaviTot = 0;
$margineTot = 0;
$totPrezzoMedioPesato = 0;
$totNumeratorePrezzoMedioPesato = 0;
$totTonnellateVendute = 0;
$saturazioneMacchina = 0;

//Variabili tonnellate vendute solo di prodotti personal factory
$vendutoPFPrivatoTot = 0;
$vendutoPFImpresaTot = 0;
$vendutoPFRivenditoreTot = 0;


 $totChimicaVenduta=0;
 $totChimicaFatturata=0;

$N = 1;
while ($row = mysql_fetch_array($sqlProdotti)) {
    $costoDrymix = 0;
    $costoDrymixTot = 0;
    $listinoLotto = 0;
    $listinoKit = 0;
    $costoTrasp = 0;
    $costoSacchiTot = 0;
    $costoOperaioMiscela = 0;
    $altriCosti = 0;
    $costoProduzioneQ = 0;
    $costiVariabili = 0;
    $listinoSuggProdFinitoQ = 0;
    $totSacchiVenduti = 0;
    $prezzoMedioEquivalente = 0;
    $marginePrimoLiv = 0;
    $ricavi = 0;
    $costoElettricitaMix = 0;
    $numSacInLotto = 0;
    $numLotti = 0;
    $numSacTot = 0;
    $pesoKit = 0;
    $totOreLavorate = 0;
    $tipoProd = "";
    $listinoKitScontato = 0;
   
    //###############################################################################
    //Di default per le nuove simulazioni si prende il generatore di listino dal file precisione.php
    $generatoreListino = $valGeneratoreListinoPF;
    $sacchiVendutiPrivato = 0;
    $sacchiVendutiImpresa = 0;
    $sacchiVendutiRivenditore = 0;

    //Tonnellate vendute solo di prodotti personal factory
    $vendutoPFPrivato = 0;
    $vendutoPFImpresa = 0;
    $vendutoPFRivenditore = 0;
    $totVendutoPF = 0;
    ####################################################

    if ($row['tipo'] == $valBsTipoProdPf) {
        //################# PRODOTTI PF ##################################

        $sqlFormula = findAnFormulaByCodice("K" . $row['cod_prodotto']);
        while ($rowF = mysql_fetch_array($sqlFormula)) {

            $numSacInLotto = $rowF['num_sac_in_lotto'];
            $numSacTot = $rowF['num_sac'];
            $numLotti = $rowF['num_lotti'];
            $pesoKit = $rowF['qta_sac'];
        }

        //#################### NUOVA SIMULAZIONE ##########################
        if ($_SESSION['TODO_bs'] == "NEW" AND $_SESSION['NumSimulazione'] == 1) {
            //Si selezionano i prezzi del drymix dalla tabella materia_prima        
            $sqlCompProd = selectComponentiPrezzoByIdProdotto($row['id_prodotto'], $_SESSION['lingua'], $valAbilitato);
        } else if ($_SESSION['TODO_bs'] == "NEW" AND $_SESSION['NumSimulazione'] != 1) {
            //Si selezionano i prezzi del drymix salvati la volta precedente         
            $sqlCompProd = selectBSCompClienteByIdProdotto($_SESSION['id_cliente'], $row['id_prodotto'], $_SESSION['lingua'], $valAbilitato);
        } else if ($_SESSION['TODO_bs'] == "MODIFY") {
            //########### SIMULAZIONE ESISTENTE  ##########################                                  
            //Si selezionano i prezzi del drymix salvati la volta precedente         
            $sqlCompProd = selectBSCompClienteByIdProdotto($_SESSION['id_cliente'], $row['id_prodotto'], $_SESSION['lingua'], $valAbilitato);
        }

        //######################################################################
        //############## LISTINO LOTTO  ########################################
        $sqlListinoLotto = findLottoArticoByCodice("L" . $row['cod_prodotto']);
        while ($rowL = mysql_fetch_array($sqlListinoLotto)) {

            $listinoLotto = $rowL['listino'] * $_SESSION['cambio'];
        }

        if ($numSacInLotto > 0)
            $listinoKit = $listinoLotto / $numSacInLotto;
        $listinoKitScontato = $listinoKit - ($listinoKit * $_SESSION['ScontoKit'] / 100);

        
        //############## COSTO DRYMIX  #########################################
        if (mysql_num_rows($sqlCompProd) > 0)
            mysql_data_seek($sqlCompProd, 0);
        while ($rowC = mysql_fetch_array($sqlCompProd)) {

            $costoUnitarioKg = $rowC['pre_acq'] * $_SESSION['cambio'];
            ?>
                                <input type="hidden" name="CostoComp<?php echo ($rowC['id_comp']); ?>" id="CostoComp<?php echo ($rowC['id_comp']); ?>" value="<?php echo $costoUnitarioKg ?>"/>
                                <?php
                                $costoDrymix = $costoDrymix + ($costoUnitarioKg * $rowC['quantita']) / 1000;
                            }


                            //########### COSTO TRASPORTO ########################################## 
                            if ($numSacTot > 0)
                                $costoTrasp = $_SESSION['CostoTrasporto'] / $numSacTot;

                            //##### COSTO OPERAIO - COSTO ELETTRICITA ##########
                            if ($_SESSION['Produttivita'] > 0) {
                                $costoOperaioMiscela = $_SESSION['CostoOperaio'] / $_SESSION['Produttivita'];
                                //Consumo orario di Origami 7 kw
                                $costoElettricitaMix = ($_SESSION['CostoElettricita'] * 7) / $_SESSION['Produttivita'];
                            }

                            //########### COSTO SACCHI ############################################
                            $costoSacchiTot = $_SESSION['CostoSacco'] * 4;

                            $altriCosti = $costoSacchiTot + $costoOperaioMiscela + $costoElettricitaMix;

                            $costoDrymixTot = $costoDrymix + $listinoKitScontato;

                            $costoProduzioneQ = $costoDrymixTot + $costoTrasp + $altriCosti;
                        
                            
                            } else if ($row['tipo'] == $valBsTipoProdNotPf) {

                            //################# ALTRI PRODOTTI NOT PF   ##################################
                            //Se il prodotto non è personal factory il costo di produzione si legge dalla tabella
                            $costoProduzioneQ = $row['costo'] * $_SESSION['cambio'];

                            //Quale deve essere??
                            $listinoKitScontato = 0;
                        }
                        if ($_SESSION['TODO_bs'] == "MODIFY") {

                            //Si seleziona il venduto dalla tabella bs_prodotto_cliente - bs_altri_prodotti_cliente
                            $sacchiVendutiPrivato = $row['venduto_privato'];
                            $sacchiVendutiImpresa = $row['venduto_impresa'];
                            $sacchiVendutiRivenditore = $row['venduto_rivenditore'];
                            //Si seleziona il generatore listino dalla tabella bs_prodotto_cliente - bs_altri_prodotti_cliente
                            $generatoreListino = $row['generatore_listino'];

                            //Utile per il calcolo del totale di tonnellate vendute di prodotti solo personalfactory
                            if ($row['tipo'] == $valBsTipoProdPf) {
                                $vendutoPFPrivato = $row['venduto_privato'];
                                $vendutoPFImpresa = $row['venduto_impresa'];
                                $vendutoPFRivenditore = $row['venduto_rivenditore'];
                            }
                        }
                        if (isSet($_POST['SacchiVenPrivato' . $row['cod_prodotto']]) AND $_POST['SacchiVenPrivato' . $row['cod_prodotto']] >= 0) {
                            $sacchiVendutiPrivato = $_POST['SacchiVenPrivato' . $row['cod_prodotto']];
                            if ($row['tipo'] == $valBsTipoProdPf) {
                                $vendutoPFPrivato = $_POST['SacchiVenPrivato' . $row['cod_prodotto']];
                            }
                        }
                        if (isSet($_POST['SacchiVenImpresa' . $row['cod_prodotto']]) AND $_POST['SacchiVenImpresa' . $row['cod_prodotto']] >= 0) {
                            $sacchiVendutiImpresa = $_POST['SacchiVenImpresa' . $row['cod_prodotto']];
                            if ($row['tipo'] == $valBsTipoProdPf) {
                                $vendutoPFImpresa = $_POST['SacchiVenImpresa' . $row['cod_prodotto']];
                            }
                        }
                        if (isSet($_POST['SacchiVenRivenditore' . $row['cod_prodotto']]) AND $_POST['SacchiVenRivenditore' . $row['cod_prodotto']] >= 0) {
                            $sacchiVendutiRivenditore = $_POST['SacchiVenRivenditore' . $row['cod_prodotto']];
                            if ($row['tipo'] == $valBsTipoProdPf) {
                                $vendutoPFRivenditore = $_POST['SacchiVenRivenditore' . $row['cod_prodotto']];
                            }
                        }

                        if (isSet($_POST['GeneratoreListino' . $row['cod_prodotto']]) AND $_POST['GeneratoreListino' . $row['cod_prodotto']] != 0) {
                            $generatoreListino = $_POST['GeneratoreListino' . $row['cod_prodotto']];
                            if ($generatoreListino < 2.5) {
                                $generatoreListino = 2.5;
                                ?>
                                <script language="javascript">alert("<?php echo $msgErrValGeneratoreListino ?>");</script> 
                                <?php
                            }
                        }
                        //Calcolo del listino prodotto finito tenendo conto del fattore moltiplicativo
                        $listinoSuggProdFinitoQ = $costoProduzioneQ * $generatoreListino;

                        $prezzoPrivato = $listinoSuggProdFinitoQ * (1 - $_SESSION['ScontoPrivato'] / 100);
                        $prezzoImpresa = $listinoSuggProdFinitoQ * (1 - $_SESSION['ScontoImpresa'] / 100);
                        $prezzoRivenditore = $listinoSuggProdFinitoQ * (1 - $_SESSION['ScontoRivenditore'] / 100);

                        $totSacchiVenduti = $sacchiVendutiPrivato + $sacchiVendutiImpresa + $sacchiVendutiRivenditore;

                        if ($totSacchiVenduti > 0) {
                            $prezzoMedioEquivalente = ($prezzoPrivato * $sacchiVendutiPrivato + $prezzoImpresa * $sacchiVendutiImpresa + $prezzoRivenditore * $sacchiVendutiRivenditore) / $totSacchiVenduti;

                            //NON SONO SACCHI ORA MA TONNELLATE
                            $ricavi = $totSacchiVenduti * $prezzoMedioEquivalente * 10;

                            $costiVariabili = ($costoProduzioneQ * 10 * $totSacchiVenduti);

                            $marginePrimoLiv = $ricavi - $costiVariabili;
                            
                            //Il num di kit venduti = tot kg venduti / 100kg
                            $totChimicaVenduta=$totSacchiVenduti*10;
                            
                            $totChimicaFatturata=$totChimicaFatturata+($totChimicaVenduta*$listinoKitScontato);
                            
                        }

                        $totNumeratorePrezzoMedioPesato = $totNumeratorePrezzoMedioPesato + ($totSacchiVenduti * $prezzoMedioEquivalente);

//############## CALCOLO TOTALI ###############################################

                        $sacchiVendutiPrivatoTot = $sacchiVendutiPrivatoTot + $sacchiVendutiPrivato;
                        $sacchiVendutiImpresaTot = $sacchiVendutiImpresaTot + $sacchiVendutiImpresa;
                        $sacchiVendutiRivenditoreTot = $sacchiVendutiRivenditoreTot + $sacchiVendutiRivenditore;

                        //Totali tonnellate vendute solo prodotti personal factory
                        //Utile ai fini del calcolo della saturazione impianto
                        $vendutoPFPrivatoTot = $vendutoPFPrivatoTot + $vendutoPFPrivato;
                        $vendutoPFImpresaTot = $vendutoPFImpresaTot + $vendutoPFImpresa;
                        $vendutoPFRivenditoreTot = $vendutoPFRivenditoreTot + $vendutoPFRivenditore;
                        //###################################################

                        $ricaviTot = $ricaviTot + $ricavi;
                        $margineTot = $margineTot + $marginePrimoLiv;
                        $costoProduzioneTot = $ricaviTot - $margineTot;

                        //FORMATTO
                        $costoDrymix = number_format($costoDrymix, 2, ',', '.');
                        $listinoKit = number_format($listinoKit, 2, ',', '.');
                        $listinoKitScontato = number_format($listinoKitScontato, 2, ',', '.');
                        $costoTrasp = number_format($costoTrasp, 2, ',', '.');
                        $altriCosti = number_format($altriCosti, 2, ',', '.');
                        $costoProduzioneQ = number_format($costoProduzioneQ, 2, ',', '.');
                        $listinoSuggProdFinitoQ = number_format($listinoSuggProdFinitoQ, 2, ',', '.');
                        $prezzoMedioEquivalente = number_format($prezzoMedioEquivalente, 2, ',', '.');
                        $ricavi = number_format($ricavi, 0, ',', '.');
                        $costiVariabili = number_format($costiVariabili, 0, ',', '.');
                        $marginePrimoLiv = number_format($marginePrimoLiv, 0, ',', '.');

                        $strFineFea = "";
                        if (strlen($row['features']) > 50) {
                            $strFineFea = $filtroPuntini;
                        }
                        $strFineN1 = "";
                        if (strlen($row['note_1']) > 50) {
                            $strFineN1 = $filtroPuntini;
                        }
                        $strFineN2 = "";
                        if (strlen($row['note_2']) > 50) {
                            $strFineN2 = $filtroPuntini;
                        }
                        $strFineN3 = "";
                        if (strlen($row['note_3']) > 50) {
                            $strFineN3 = $filtroPuntini;
                        }


                        $classTdLeft = "cella1";
                        $classTdRight = "cella1Right";
                        if ($row['tipo'] == $valBsTipoProdPf) {
                            $classTdLeft = "cella4";
                            $classTdRight = "cella4Right";
                        }
                        ?>
                        <tr>

                            <td class="<?php echo $classTdLeft ?>" width="<?php echo $wid1 ?>"><nobr>

    <?php
    //Solo se il prodotto è di tipo personal factory si visualizza la sua formula con i conponenti
    if ($row['tipo'] == $valBsTipoProdPf) {
        ?>
                                        <a class="thumbnail" href="#"><img src="/CloudFab/images/icone/lente_piccola.png" />
                                            <div style="width:500px">
                                                <table width="99%" border="1" cellspacing="0">
                                        <?php
                                        if (mysql_num_rows($sqlCompProd) > 0)
                                            mysql_data_seek($sqlCompProd, 0);
                                        while ($row1 = mysql_fetch_array($sqlCompProd)) {
                                            ?>
                                                        <tr>
                                                            <td><?php echo $row1['vocabolo'] ?> </td>
                                                            <td><?php echo $row1['quantita'] . " " . $filtrogBreve ?></td>
                                                        </tr>                                           
        <?php } ?>
                                                    <tr>
                                                        <td><?php echo $filtroPesoKitChimicoMinus ?></td>
                                                        <td><?php echo $pesoKit . " " . $filtrogBreve ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </a>    <?php } ?>
                                    <a target="_blank" style="color:#000000" title="<?php echo $titleVediSchedaTecnica ?>" href="<?php echo $radicePercorsoSchedeTecnicheSito . "/" . $row['link_scheda_tecnica'] ?>"> <?php echo($row['cod_prodotto']) ?></a>
                                </nobr>
                            </td>
                            <td class="<?php echo $classTdLeft ?>" width="<?php echo $wid2 ?>" title="<?php echo $titleVediPresProdotto ?>"><nobr><a target="_blank" style="color:#000000" href="/CloudFab/bs/schede/presentazione/download/<?php echo $row['link_presentazione_prod'] ?>"><?php echo($row['nome_prodotto']) ?></a></nobr></td>

                            <td class="<?php echo $classTdRight ?>" width="<?php echo $wid5 ?>"><?php echo $costoProduzioneQ . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                            <td class="<?php echo $classTdRight ?>" style="display:none" name="tdCostiVar" width="<?php echo $wid28 ?>"><nobr><?php echo $numSacInLotto . " <span class='uniMisStyle'>" . $filtroPz . "</span>" ?></nobr></td>
                            <td class="<?php echo $classTdRight ?>" style="display:none" name="tdCostiVar" width="<?php echo $wid29 ?>"><nobr><?php echo $numLotti . " <span class='uniMisStyle'>" . $filtroPz . "</span>" ?></nobr></td>
                            <td class="<?php echo $classTdRight ?>" style="display:none" name="tdCostiVar" width="<?php echo $wid3 ?>"><nobr><?php echo $listinoKit . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></nobr></td>
                            <td class="<?php echo $classTdRight ?>" style="display:none" name="tdCostiVar" width="<?php echo $wid4 ?>"><nobr><?php echo $listinoKitScontato . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></nobr></td>
                            <td class="<?php echo $classTdRight ?>" style="display:none" name="tdCostiVar" width="<?php echo $wid6 ?>"><nobr><?php echo $costoDrymix . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></nobr></td>                                    
                            <td class="<?php echo $classTdRight ?>" style="display:none" name="tdCostiVar" width="<?php echo $wid7 ?>"><nobr><?php echo $costoTrasp . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></nobr></td>
                            <td class="<?php echo $classTdRight ?>" style="display:none" name="tdCostiVar" width="<?php echo $wid8 ?>"><nobr><?php echo $altriCosti . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></nobr></td>

                            <td class="<?php echo $classTdRight ?>" width="<?php echo $wid30 ?>"><input type="text" style="text-align:right" name="GeneratoreListino<?php echo ($row['cod_prodotto']); ?>" id="GeneratoreListino<?php echo ($row['cod_prodotto']); ?>" size ="8" value="<?php echo $generatoreListino ?>" onChange="AggiornaPagina()"/></td>
                            <td class="<?php echo $classTdRight ?>" width="<?php echo $wid9 ?>"><nobr><?php echo $listinoSuggProdFinitoQ . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></nobr></td>
                            <td class="<?php echo $classTdRight ?>" width="<?php echo $wid10 ?>"><nobr><input onkeypress="BloccaTastoInvio(event)" type="text" style="text-align:right" name="SacchiVenPrivato<?php echo ($row['cod_prodotto']); ?>" id="SacchiVenPrivato<?php echo ($row['cod_prodotto']); ?>" size ="8" value="<?php echo $sacchiVendutiPrivato ?>" onChange="AggiornaPagina()"/>&nbsp;<span class='uniMisStyle'><?php echo $filtroTonBreve ?></span></nobr></td>
                            <td class="<?php echo $classTdRight ?>" width="<?php echo $wid11 ?>"><nobr><input onkeypress="BloccaTastoInvio(event)" type="text" style="text-align:right" name="SacchiVenImpresa<?php echo ($row['cod_prodotto']); ?>" id="SacchiVenImpresa<?php echo ($row['cod_prodotto']); ?>" size ="8" value="<?php echo $sacchiVendutiImpresa ?>" onChange="AggiornaPagina()"/>&nbsp;<span class='uniMisStyle'><?php echo $filtroTonBreve ?></span></td>
                            <td class="<?php echo $classTdRight ?>" width="<?php echo $wid12 ?>"><nobr><input onkeypress="BloccaTastoInvio(event)" type="text" style="text-align:right" name="SacchiVenRivenditore<?php echo ($row['cod_prodotto']); ?>" id="SacchiVenRivenditore<?php echo ($row['cod_prodotto']); ?>" size ="8" value="<?php echo $sacchiVendutiRivenditore ?>" onChange="AggiornaPagina()"/>&nbsp;<span class='uniMisStyle'><?php echo $filtroTonBreve ?></span></td>
                            <td class="<?php echo $classTdRight ?>" width="<?php echo $wid13 ?>"><nobr><?php echo $prezzoMedioEquivalente . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></nobr></td>
                            <td class="<?php echo $classTdRight ?>" width="<?php echo $wid14 ?>"><nobr><?php echo $ricavi . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></nobr></td>
                            <td class="<?php echo $classTdRight ?>" width="<?php echo $wid15 ?>"><nobr><?php echo $costiVariabili . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></nobr></td>
                            <td class="<?php echo $classTdRight ?>" width="<?php echo $wid16 ?>"><nobr><?php echo $marginePrimoLiv . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></nobr></td>

                            <td class="<?php echo $classTdLeft ?>" style="display:none" name="altreInfoPr" width="<?php echo $wid17 ?>" title="<?php echo $row['features'] ?>"><?php echo substr($row['features'], 0, 45) . $strFineFea ?></td>
                            <td class="<?php echo $classTdLeft ?>" style="display:none" name="altreInfoPr" width="<?php echo $wid18 ?>"><?php echo $row['corrispettivo_1'] ?></td>
                            <td class="<?php echo $classTdRight ?>" style="display:none;text-align:right" name="altreInfoPr" width="<?php echo $wid19 ?>" ><?php echo $row['prezzo_1'] . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                            <td class="<?php echo $classTdLeft ?>" style="display:none" name="altreInfoPr" width="<?php echo $wid20 ?>"><?php echo $row['note_1'] ?></td>
                            <td class="<?php echo $classTdLeft ?>" style="display:none" name="altreInfoPr" width="<?php echo $wid21 ?>"><?php echo $row['corrispettivo_2'] ?></td>
                            <td class="<?php echo $classTdRight ?>" style="display:none;text-align:right" name="altreInfoPr" class="cella2" width="<?php echo $wid22 ?>"><?php echo $row['prezzo_2'] . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                            <td class="<?php echo $classTdLeft ?>" style="display:none" name="altreInfoPr" width="<?php echo $wid23 ?>"><?php echo $row['note_2'] ?></td>
                            <td class="<?php echo $classTdLeft ?>" style="display:none" name="altreInfoPr" width="<?php echo $wid24 ?>"><?php echo $row['corrispettivo_3'] ?></td>
                            <td class="<?php echo $classTdRight ?>" style="display:none;text-align:right" name="altreInfoPr" width="<?php echo $wid25 ?>"><?php echo $row['prezzo_3'] . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                            <td class="<?php echo $classTdLeft ?>" style="display:none" name="altreInfoPr" width="<?php echo $wid26 ?>"><?php echo $row['note_3'] ?></td>
                            <td class="<?php echo $classTdRight ?>" style="display:none" name="altreInfoPr" width="<?php echo $wid27 ?>"><?php echo $row['dt_abilitato'] ?></td>
                        </tr>
    <?php
    $N++;
}//End While prodotti
//################# ALTRI TOTALI ##############################################
$totTonnellateVendute = $sacchiVendutiPrivatoTot + $sacchiVendutiImpresaTot + $sacchiVendutiRivenditoreTot;
if ($totTonnellateVendute > 0) {
    $totPrezzoMedioPesato = $totNumeratorePrezzoMedioPesato / $totTonnellateVendute;

//########################## SATURAZIONE IMPIANTO ##############################
//Totale delle tonnellate vendute solo di prodotti personalfactory
    $totTonnVendutePF = $vendutoPFPrivatoTot + $vendutoPFImpresaTot + $vendutoPFRivenditoreTot;

    //Tonnellate prodotte in un'ora= (numero di miscele/h *100kg)/1000
    //si considerano 300 giorni lavorativi in un anno

    $tonProdotteOra = $_SESSION['Produttivita'] / 10;
    $totOreLavorabiliAnno = $_SESSION['NumeroOreLavorabili'] * 300;
    if ($tonProdotteOra > 0 AND $totOreLavorabiliAnno > 0)
//        $totOreLavorate = $totTonnellateVendute / $tonProdotteOra;
        $totOreLavorate = $totTonnVendutePF / $tonProdotteOra;
    $saturazioneMacchina = ($totOreLavorate * 100) / $totOreLavorabiliAnno;
}
//############### PER IL RIEPILOGO #############################################
$costoAmmortamentoImpianto = 0;
$costoAmmAltriInvestimenti = 0;
$secondoMargine = 0;
$altreSpese = 0;
if ($_SESSION['AnniAmmortamentoMac'] > 0)
    $costoAmmortamentoImpianto = $_SESSION['PrezzoMacchina'] / $_SESSION['AnniAmmortamentoMac'];

$altreSpese = $_SESSION['SpeseMarketing'] + $_SESSION['CostiAnno'];

$secondoMargine = $margineTot - ($altreSpese);
if ($_SESSION['AnniAmmAltriInv'] > 0)
    $costoAmmAltriInvestimenti = $_SESSION['AltriInvestimenti'] / $_SESSION['AnniAmmAltriInv'];

$ebita = $secondoMargine - $costoAmmortamentoImpianto - $costoAmmAltriInvestimenti;
//##############################################################################
?>
                    <tr>
                        <td  class="dataRigWhite" id="rigaTotali" colspan="5"><?php echo $filtroTotChimicaFatturata ." : ".number_format($totChimicaFatturata, '2', ',', '.') . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                        <td  class="dataRigWhite" style="text-align:right"><?php echo $sacchiVendutiPrivatoTot . " <span class='uniMisStyle'>" . $filtroTonBreve . "</span>" ?></td>
                        <td  class="dataRigWhite" style="text-align:right"><?php echo $sacchiVendutiImpresaTot . " <span class='uniMisStyle'>" . $filtroTonBreve . "</span>" ?></td>
                        <td  class="dataRigWhite" style="text-align:right"><?php echo $sacchiVendutiRivenditoreTot . " <span class='uniMisStyle'>" . $filtroTonBreve . "</span>" ?></td>
                        <td  class="dataRigWhite" style="text-align:right" title="<?php echo $titleTotPrezzoMedioBs ?>"/><?php echo number_format($totPrezzoMedioPesato, '0', ',', '.') . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                        <td  class="dataRigWhite" style="text-align:right"><?php echo number_format($ricaviTot, '0', ',', '.') . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                        <td  class="dataRigWhite" style="text-align:right"><?php echo number_format($costoProduzioneTot, '0', ',', '.') . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                        <td  class="dataRigWhite" style="text-align:right"><?php echo number_format($margineTot, '0', ',', '.') . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                        <td  style="display:none" name="altreInfoPr" class="dataRigWhite" colspan="12"></td>
                    </tr>
                    <tr>
                        <td id="riga3" class="dataRigWhite" colspan="12"><?php echo $filtroSaturazioneImpianto . ": " . number_format($saturazioneMacchina, '2', ',', '.') . " " . $filtroPerc ?>
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="CostoProduzioneTot" id="CostoProduzioneTot" value="<?php echo $costoProduzioneTot ?>"/>
                <input type="hidden" name="TonnellateVendute" id="TonnellateVendute" value="<?php echo $totTonnellateVendute ?>"/>
                <input type="hidden" name="RicaviTot" id="RicaviTot" value="<?php echo $ricaviTot ?>"/>
                <input type="hidden" name="MarginePrimoLivTot" id="MarginePrimoLivTot" value="<?php echo $margineTot ?>"/>
                <input type="hidden" name="CostoAmmImpianto" id="CostoAmmImpianto" value="<?php echo $costoAmmortamentoImpianto ?>"/>
                <input type="hidden" name="CostoAmmAltriInv" id="CostoAmmAltriInv" value="<?php echo $costoAmmAltriInvestimenti ?>"/>
                <input type="hidden" name="SecondoMargine" id="SecondoMargine" value="<?php echo $secondoMargine ?>"/>
                <input type="hidden" name="AltreSpese" id="AltreSpese" value="<?php echo $altreSpese ?>"/>
                <input type="hidden" name="Ebita" id="Ebita" value="<?php echo $ebita ?>"/>
                <input type="hidden" name="SaturazioneImpianto" id="SaturazioneImpianto" value="<?php echo $saturazioneMacchina ?>"/>
                </form>

<?php ?>
            </div>
        </div><!--mainContainer-->

    </body>
</html>


