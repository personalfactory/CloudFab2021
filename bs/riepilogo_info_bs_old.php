
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript">
        function AggiornaPagina() {

            document.forms["RiepilogoBs"].action = "riepilogo_info_bs.php";
            document.forms["RiepilogoBs"].submit();
        }
    </script>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php
            //GESTIONE VALUTA
##################################################################

            $_SESSION['aggPagRiepilogo'] ++;
//Mi conservo in una variabile la valuta e il cambio iniziale al primo caricamento della pagina
            if ($_SESSION['aggPagRiepilogo'] == 1) {

                $_SESSION['valutaInizioPag'] = $_SESSION['valutaBs'];

                $_SESSION['aggCambio'] = 0;
            }
            //Conta il numero di volte che si cambia la valuta
            $cambioValuta = 0;

            if (isset($_POST['valutaBs'])) {

                foreach ($_POST['valutaBs'] as $key => $value) {

                    $valutaBsPost = $key;
                }
               
                if ($valutaBsPost != $_SESSION['valutaBs']) {
                    $cambioValuta = 1;
                    $_SESSION['aggCambio'] ++;
                }

                $_SESSION['valutaBs'] = $valutaBsPost;
            }

            if (isSet($_SESSION['valutaBs'])) {
                switch ($_SESSION['valutaBs']) {
                    case 1:
                        $_SESSION['cambio'] = 1;
                        $_SESSION['filtro'] = "filtroEuro";
                        break;
                    case 2:
                        if(isSet($_SESSION['cambioIniziale']))
                        $_SESSION['cambio'] = $_SESSION['cambioIniziale'];
                        $_SESSION['filtro'] = "filtroDollaro";
                        break;
                }
            }
            $filtroValuta = "{${$_SESSION['filtro']}}";
            //Stabilisce se le valute vanno moltiplicate o divise per il cambio 
            //a seconda della valuta iniziale e del numerod di volte che si aggiorna la pagina    
            if ($_SESSION['valutaInizioPag'] == 1) {
                //se agg pagina è dispari moltiplico e se è pari divido per il cambio
                ( $_SESSION['aggCambio'] & 1 ) ? $oper = "*" : $oper = "/";
            } else {
                //se agg pagina è dispari divido e se è pari moltiplico per il cambio
                ( $_SESSION['aggCambio'] & 1 ) ? $oper = "/" : $oper = "*";
            }
 
            //Per fare la conversione nella valuta corretta si distinguono due casi:
            //1)I dati che vengono recuperati dal db si moltiplicano semplicemente per il 
            //tasso di cambio attuale perchè vengono sempre salvati in euro
            //2) Per i dati che vengono recuperati dalla sessione bisogna considerare 
            //il tasso e la valuta iniziale e moltiplicare o dividere a seconda della valuta selezionata
            if ($cambioValuta) {
                $datoValuta = $_SESSION['CostoProduzioneTot'];
                $datoValuta = $datoValuta . $oper . $_SESSION['cambioIniziale'];
                eval("\$datoValuta = $datoValuta;");
                $_SESSION['CostoProduzioneTot'] = $datoValuta;

                $datoValuta = $_SESSION['RicaviTot'];
                $datoValuta = $datoValuta . $oper . $_SESSION['cambioIniziale'];
                eval("\$datoValuta = $datoValuta;");
                $_SESSION['RicaviTot'] = $datoValuta;

                $datoValuta = $_SESSION['MarginePrimoLivTot'];
                $datoValuta = $datoValuta . $oper . $_SESSION['cambioIniziale'];
                eval("\$datoValuta = $datoValuta;");
                $_SESSION['MarginePrimoLivTot'] = $datoValuta;

                $datoValuta = $_SESSION['AltreSpese'];
                $datoValuta = $datoValuta . $oper . $_SESSION['cambioIniziale'];
                eval("\$datoValuta = $datoValuta;");
                $_SESSION['AltreSpese'] = $datoValuta;

                $datoValuta = $_SESSION['CostoAmmImpianto'];
                $datoValuta = $datoValuta . $oper . $_SESSION['cambioIniziale'];
                eval("\$datoValuta = $datoValuta;");
                $_SESSION['CostoAmmImpianto'] = $datoValuta;

                $datoValuta = $_SESSION['CostoAmmAltriInv'];
                $datoValuta = $datoValuta . $oper . $_SESSION['cambioIniziale'];
                eval("\$datoValuta = $datoValuta;");
                $_SESSION['CostoAmmAltriInv'] = $datoValuta;


                $datoValuta = $_SESSION['SecondoMargine'];
                $datoValuta = $datoValuta . $oper . $_SESSION['cambioIniziale'];
                eval("\$datoValuta = $datoValuta;");
                $_SESSION['SecondoMargine'] = $datoValuta;

                $datoValuta = $_SESSION['Ebita'];
                $datoValuta = $datoValuta . $oper . $_SESSION['cambioIniziale'];
                eval("\$datoValuta = $datoValuta;");
                $_SESSION['Ebita'] = $datoValuta;
            }

//            echo "<br/>cambioValuta: " . $cambioValuta;
//            echo "<br/>aggCambio: " . $_SESSION['aggCambio'];
//            echo "<br/>aggPagRiepilogo: " . $_SESSION['aggPagRiepilogo'];
//            echo "<br/>valutaInizioPag: " . $_SESSION['valutaInizioPag'];
//            echo "<br/>aggPagVenduto: " . $_SESSION['aggPagVenduto'];
//            echo "<br/>valutaIniziale: " . $_SESSION['valutaIniziale'];
//            echo "<br/>cambioIniziale: " . $_SESSION['cambioIniziale'];
//            echo "<br/>valutaAttuale: " . $_SESSION['valutaBs'];
//            echo "<br/>cambioAttuale: " . $_SESSION['cambio'];
//            echo "<br/>filtro: " . $_SESSION['filtro'];

            //#######################################################

            $wid1 = "5%"; //codice
            $wid2 = "25%"; //descrizione
            $wid3 = "10%"; //costo produzione
            $wid4 = "10%"; //prezzo di vendita
            $wid5 = "10%"; //venduto
            $wid6 = "10%"; //costi variabili
            $wid7 = "10%"; //primo margine

            include('../include/menu.php');
            include('../include/precisione.php');
            include('../sql/script_bs_prodotto_cliente.php');
            include('../sql/script_bs_valore_dato.php');
            include('../sql/script_formula.php');
            include('../sql/script_bs_comp_cliente.php');
            include('../sql/script_bs_cliente.php');
            include('../sql/script_lotto_artico.php');


            if ($DEBUG)
                ini_set('display_errors', '1');


            $_SESSION['PercMargineI'] = 0;
            $_SESSION['PercMargineII'] = 0;
            if ($_SESSION['RicaviTot'] > 0) {
                $_SESSION['PercMargineI'] = ($_SESSION['MarginePrimoLivTot'] * 100) / $_SESSION['RicaviTot'];
                $_SESSION['PercMargineII'] = ($_SESSION['SecondoMargine'] * 100) / $_SESSION['RicaviTot'];
            }


            $sqlProdotti = findBSProdottiByClienteUnion($_SESSION['Anno'], $_SESSION['id_cliente']);

            //Recupero i valori dati dalla tabella bs_valore_dati
            $sqlDati = findValoriDatiByCliente($_SESSION['id_cliente'], "ordine", $_SESSION['lingua']);
            while ($rowDati = mysql_fetch_array($sqlDati)) {

                $_SESSION[$rowDati['nome_dato']] = $rowDati['valore'];
                if ($rowDati['tipo1'] == "valuta") {
                    $_SESSION[$rowDati['nome_dato']] = $rowDati['valore'] * $_SESSION['cambio'];
                }
            }
            ?>
            <form id="RiepilogoBs" name="RiepilogoBs" method="POST"  action="salva_riepilogo_bs.php">
                <div id="container" style="width:80%; margin:15px auto;">  
                    <!--Scelta valuta-->
<?php include('../include/scelta_valuta.php'); ?><br/><br/><br/>
                    <table width="100%"> 
                        <tr>
                            <td class="cella3" colspan="3"><?php echo $filtroRiepilogo . " &nbsp;&nbsp;&nbsp;&nbsp;" . $filtroAnnoRif . ": " . $_SESSION['Anno'] . " &nbsp;&nbsp;&nbsp;&nbsp;" . $filtroCliente . ": " . $_SESSION['nome_cliente_bs'] ?></td>
                        </tr> 
                        <tr>
                            <td class="cella1" style="width:40%" title="<?php echo $titleVenduto ?>"><?php echo $filtroVenduto ?></td>
                            <td class="cella2" colspan="2"><?php echo $_SESSION['TonnellateVendute'] . " <span class='uniMisStyle'>" . $filtroTonBreve . "</span>" ?></td>
                        </tr> 
                        <tr>
                            <td class="cella1" title="<?php echo $titleCostiVariabili ?>"><?php echo $filtroCostiVariabili ?></td>
                            <td class="cella2" colspan="2"><?php echo number_format($_SESSION['CostoProduzioneTot'], '0', ',', '.') . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                        </tr> 
                        <tr>
                            <td class="cella1" title="<?php echo $titleRicavi ?>"><?php echo $filtroRicavi ?></td>
                            <td class="cella2"colspan="2"><?php echo number_format($_SESSION['RicaviTot'], '0', ',', '.') . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                        </tr> 
                        <tr>
                            <td class="cella1" title="<?php echo $titlePrimoMargine ?>"><?php echo $filtroPrimoMargine ?></td>
                            <td class="cella2" ><?php echo number_format($_SESSION['MarginePrimoLivTot'], '0', ',', '.') . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                            <td class="cella2" ><?php echo number_format($_SESSION['PercMargineI'], '2', ',', '.') . " <span class='uniMisStyle'>" . $filtroPerc . "</span> " . $filtroDeiRicavi ?></td>
                        </tr> 
                        <tr>
                            <td class="cella1" title="<?php echo $titleAltreSpese ?>"><?php echo $filtroAltreSpese ?></td>
                            <td class="cella2" colspan="2"><?php echo number_format($_SESSION['AltreSpese'], '0', ',', '.') . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                        </tr> 
                        <tr>
                            <td class="cella1" title="<?php echo $titleSecondoMargine ?>" ><?php echo $filtroSecondoMargine ?></td>
                            <td class="cella2"><?php echo number_format($_SESSION['SecondoMargine'], '0', ',', '.') . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                            <td class="cella2"><?php echo number_format($_SESSION['PercMargineII'], '2', ',', '.') . " <span class='uniMisStyle'>" . $filtroPerc . "</span> " . $filtroDeiRicavi ?></td>
                        </tr> 
                        <tr>
                            <td class="cella1" title="<?php echo $titleCostiAmmImpianto ?>" ><?php echo $filtroCostiAmmortamentoImpianto ?></td>
                            <td class="cella2" colspan="2"><?php echo number_format($_SESSION['CostoAmmImpianto'], '0', ',', '.') . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                        </tr> 
                        <tr>
                            <td class="cella1" title="<?php echo $titleCostiAmmInvestimento ?>" ><?php echo $filtroCostiAmmortamentoInvestimenti ?></td>
                            <td class="cella2" colspan="2"><?php echo number_format($_SESSION['CostoAmmAltriInv'], '0', ',', '.') . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                        </tr>
                        <tr>
                            <td class="cella1" title="<?php echo $titleEbita ?>"><?php echo $filtroEbita ?></td>
                            <td class="cella2" colspan="2"><?php echo number_format($_SESSION['Ebita'], '0', ',', '.') . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                        </tr> 
                        <tr>
                            <td class="cella1" title="<?php echo $titleSaturazioneImpianto ?>"><?php echo $filtroSaturazioneImpianto ?></td>
                            <td class="cella2" colspan="2"><?php echo number_format($_SESSION['SaturazioneImpianto'], '2', ',', '.') . " <span class='uniMisStyle'>" . $filtroPerc . "</span>" ?></td>
                        </tr> 
                        <tr>
                            <td class="cella1" ><?php echo $filtroNote ?></td>
                            <td class="cella2" colspan="2"><textarea class="dataRigGray" type="text" name="NoteSimulazione" value="" ></textarea></td>
                        </tr> 
                    </table>               
                </div>
                <div id="container" style="width:80%;margin:15px auto;">

                    <table width="100%">              

                        <tr>
                            <td class="cella3" width="<?php echo $wid1 ?>"><?php echo $filtroCodice ?></td>
                            <td class="cella3" width="<?php echo $wid2 ?>"><?php echo $filtroDescrizione ?></td>                           
                            <td class="cella3" width="<?php echo $wid3 ?>"><?php echo $filtroCostoProduzione . " " . $filtroValuta . "/" . $filtroQuintaleBreve ?></td>                        
                            <td class="cella3" width="<?php echo $wid4 ?>" title="<?php echo $titlePrezzoVenditaMedio ?>"><?php echo $filtroPrezzoVenditaMedio . " " . $filtroValuta . "/" . $filtroQuintaleBreve ?></td>
                            <td class="cella3" width="<?php echo $wid5 ?>"><?php echo $filtroTonVendutoPrivato ?></td>
                            <td class="cella3" width="<?php echo $wid5 ?>"><?php echo $filtroTonVendutoImprese ?></td>
                            <td class="cella3" width="<?php echo $wid5 ?>"><?php echo $filtroTonVendutoRivenditore ?></td>
                            <td class="cella3" width="<?php echo $wid6 ?>" title="<?php echo $titleCostiVariabiliVenduto ?>"><?php echo $filtroCostiVariabili ?></td>
                            <td class="cella3" width="<?php echo $wid7 ?>" title="<?php echo $titlePrimoMargine ?>"><?php echo $filtroPrimoMargine ?></td>
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
    $totOreLavorate = 0;

    $generatoreListino = $valGeneratoreListinoPF;
    if ($row['tipo'] == $valBsTipoProdPf) {
        //################# PRODOTTI PF ##################################
        $sqlFormula = findAnFormulaByCodice("K" . $row['cod_prodotto']);
        while ($rowF = mysql_fetch_array($sqlFormula)) {

            $numSacInLotto = $rowF['num_sac_in_lotto'];
            $numSacTot = $rowF['num_sac'];
            $numLotti = $rowF['num_lotti'];
            $sacchiVendutiPrivato = 0;
            $sacchiVendutiImpresa = 0;
            $sacchiVendutiRivenditore = 0;
//                                $generatoreListino = $valGeneratoreListinoPF;
        }

        //########### SIMULAZIONE ESISTENTE  ###############                                  
        //Si selezionano i prezzi del drymix salvati la volta precedente         
        $sqlCompProd = selectBSCompClienteByIdProdotto($_SESSION['id_cliente'], $row['id_prodotto'], $_SESSION['lingua'], $valAbilitato);




//#####################################################################################
        //########### LISTINO LOTTO ######################### 
        $sqlListinoLotto = findLottoArticoByCodice("L" . $row['cod_prodotto']);
        while ($rowL = mysql_fetch_array($sqlListinoLotto)) {

            $listinoLotto = $rowL['listino'] * $_SESSION['cambio'];
        }

        if ($numSacInLotto > 0)
            $listinoKit = $listinoLotto / $numSacInLotto;
        $listinoKitScontato = $listinoKit - ($listinoKit * $_SESSION['ScontoKit'] / 100);


        //############## COSTO DRYMIX  #####################
        if (mysql_num_rows($sqlCompProd) > 0)
            mysql_data_seek($sqlCompProd, 0);
        while ($rowC = mysql_fetch_array($sqlCompProd)) {

            $costoUnitarioKg = $rowC['pre_acq'] * $_SESSION['cambio'];
            ?>
                                    <?php
                                    $costoDrymix = $costoDrymix + ($costoUnitarioKg * $rowC['quantita']) / 1000;
                                }
                                //##################################################
                                //########### COSTO TRASPORTO ###################### 
                                if ($numSacTot > 0)
                                    $costoTrasp = $_SESSION['CostoTrasporto'] / $numSacTot;

                                //##### COSTO OPERAIO - COSTO ELETTRICITA ##########
                                if ($_SESSION['Produttivita'] > 0) {
                                    $costoOperaioMiscela = $_SESSION['CostoOperaio'] / $_SESSION['Produttivita'];
                                    //Consumo orario di Origami 7 kw
                                    $costoElettricitaMix = ($_SESSION['CostoElettricita'] * 7) / $_SESSION['Produttivita'];
                                }

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


                            $listinoSuggProdFinitoQ = $costoProduzioneQ * $generatoreListino;

                            $prezzoPrivato = $listinoSuggProdFinitoQ * (1 - $_SESSION['ScontoPrivato'] / 100);
                            $prezzoImpresa = $listinoSuggProdFinitoQ * (1 - $_SESSION['ScontoImpresa'] / 100);
                            $prezzoRivenditore = $listinoSuggProdFinitoQ * (1 - $_SESSION['ScontoRivenditore'] / 100);


                            //Si seleziona il venduto dalla tabella bs_prodotto_cliente
                            $sacchiVendutiPrivato = $row['venduto_privato'];
                            $sacchiVendutiImpresa = $row['venduto_impresa'];
                            $sacchiVendutiRivenditore = $row['venduto_rivenditore'];
                            $generatoreListino = $row['generatore_listino'];

                            $totSacchiVenduti = $sacchiVendutiPrivato + $sacchiVendutiImpresa + $sacchiVendutiRivenditore;


                            if ($totSacchiVenduti > 0) {
                                $prezzoMedioEquivalente = ($prezzoPrivato * $sacchiVendutiPrivato + $prezzoImpresa * $sacchiVendutiImpresa + $prezzoRivenditore * $sacchiVendutiRivenditore) / $totSacchiVenduti;

                                //NON SONO SACCHI ORA MA TONNELLATE
                                $ricavi = $totSacchiVenduti * $prezzoMedioEquivalente * 10;

                                $costiVariabili = ($costoProduzioneQ * 10 * $totSacchiVenduti);

                                $marginePrimoLiv = $ricavi - $costiVariabili;

                                //##############################################
                            }

                            $totNumeratorePrezzoMedioPesato = $totNumeratorePrezzoMedioPesato + ($totSacchiVenduti * $prezzoMedioEquivalente);

//############## CALCOLO TOTALI ###############################################

                            $sacchiVendutiPrivatoTot = $sacchiVendutiPrivatoTot + $sacchiVendutiPrivato;
                            $sacchiVendutiImpresaTot = $sacchiVendutiImpresaTot + $sacchiVendutiImpresa;
                            $sacchiVendutiRivenditoreTot = $sacchiVendutiRivenditoreTot + $sacchiVendutiRivenditore;
                            $ricaviTot = $ricaviTot + $ricavi;
                            $margineTot = $margineTot + $marginePrimoLiv;
                            $costoProduzioneTot = $ricaviTot - $margineTot;

                            //FORMATTO
                            $costoProduzioneQ = number_format($costoProduzioneQ, 2, ',', '.');
                            $prezzoMedioEquivalente = number_format($prezzoMedioEquivalente, 2, ',', '.');
                            $costiVariabili = number_format($costiVariabili, 0, ',', '.');
                            $marginePrimoLiv = number_format($marginePrimoLiv, 0, ',', '.');


                            $classTdLeft = "cella1";
                            $classTdRight = "cella1Right";
                            if ($row['tipo'] == $valBsTipoProdPf) {
                                $classTdLeft = "cella4";
                                $classTdRight = "cella4Right";
                            }

                            if ($totSacchiVenduti > 0) {
                                ?>
                                <tr>
                                    <td class="<?php echo $classTdLeft ?>"  width="<?php echo $wid1 ?>" ><?php echo($row['cod_prodotto']) ?></td>
                                    <td class="<?php echo $classTdLeft ?>"  width="<?php echo $wid2 ?>" ><?php echo($row['nome_prodotto']) ?></td>                                
                                    <td class="<?php echo $classTdRight ?>" width="<?php echo $wid3 ?>" ><?php echo $costoProduzioneQ . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                                    <td class="<?php echo $classTdRight ?>" width="<?php echo $wid4 ?>" ><?php echo $prezzoMedioEquivalente . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                                    <td class="<?php echo $classTdRight ?>" width="<?php echo $wid5 ?>" ><?php echo $sacchiVendutiPrivato . " <span class='uniMisStyle'>" . $filtroTonBreve . "</span>" ?></td>
                                    <td class="<?php echo $classTdRight ?>" width="<?php echo $wid5 ?>" ><?php echo $sacchiVendutiImpresa . " <span class='uniMisStyle'>" . $filtroTonBreve . "</span>" ?></td>
                                    <td class="<?php echo $classTdRight ?>" width="<?php echo $wid5 ?>" ><?php echo $sacchiVendutiRivenditore . " <span class='uniMisStyle'>" . $filtroTonBreve . "</span>" ?></td>
                                    <td class="<?php echo $classTdRight ?>" width="<?php echo $wid6 ?>" ><?php echo $costiVariabili . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                                    <td class="<?php echo $classTdRight ?>" width="<?php echo $wid7 ?>" ><?php echo $marginePrimoLiv . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                                </tr>
        <?php
        $N++;
    }
}//End While prodotti
//################# ALTRI TOTALI ##############################################
$totTonnellateVendute = $sacchiVendutiPrivatoTot + $sacchiVendutiImpresaTot + $sacchiVendutiRivenditoreTot;
if ($totTonnellateVendute > 0) {
    $totPrezzoMedioPesato = $totNumeratorePrezzoMedioPesato / $totTonnellateVendute;
}
?>
                        <tr>
                            <td  id="rigaTotali" class="dataRigWhite" colspan="3"><?php echo $filtroTotali ?></td>
                            <td  class="dataRigWhite" style="text-align:right"><?php echo number_format($totPrezzoMedioPesato, '0', ',', '.') . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                            <td  class="dataRigWhite" style="text-align:right"><?php echo $sacchiVendutiPrivatoTot . " <span class='uniMisStyle'>" . $filtroTonBreve . "</span>" ?></td>
                            <td  class="dataRigWhite" style="text-align:right"><?php echo $sacchiVendutiImpresaTot . " <span class='uniMisStyle'>" . $filtroTonBreve . "</span>" ?></td>
                            <td  class="dataRigWhite" style="text-align:right"><?php echo $sacchiVendutiRivenditoreTot . " <span class='uniMisStyle'>" . $filtroTonBreve . "</span>" ?></td>
                            <td  class="dataRigWhite" style="text-align:right"><?php echo number_format($costoProduzioneTot, '0', ',', '.') . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                            <td  class="dataRigWhite" style="text-align:right"><?php echo number_format($margineTot, '0', ',', '.') . " <span class='uniMisStyle'>" . $filtroValuta . "</span>" ?></td>
                            <td  style="display:none" name="altreInfoPr" class="dataRigWhite" colspan="13"></td>
                        </tr>
                        <tr>
                            <td class="cella2" style="text-align: right " colspan="9">
                                <input type="reset" value="<?php echo $valueButtonIndietro ?>" onClick="location.href='carica_info_bs1.php'"/>
                                <input type="button" onClick="location.href = 'elimina_bs_simulazione.php?IdCliente=<?php echo $_SESSION['id_cliente'] ?>&Anno=<?php echo $_SESSION['Anno'] ?>'" title="<?php echo $titleChiudiSenzaSalvare ?>" value="<?php echo $valueButtonChiudiSenzaSalvare ?>" />
                                <input type="submit"  value="<?php echo $valueButtonSalva ?>" /></td>
                        </tr>
                    </table>

                </div>
            </form>
        </div>
        </div><!--mainContainer-->



