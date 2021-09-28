<?php
$wid1 = "5%"; //codice
$wid2 = "15%"; //descrizione
$wid3 = "5%"; //costo
$wid4 = "5%"; //costo attuale

$wid5 = "6%"; //listino lotto
$wid6 = "6%"; //Giacenza
$wid7 = "6%"; //scorta minima

$wid8 = "8%"; //data
$wid9 = "4%"; //rapporto
$wid10 = "4%"; //diff
//    $wid11 = "5%";
$wid12 = "4%"; //num kit
$wid13 = "5%"; //peso kit
$wid14 = "5%"; //peso scatola
$wid15 = "5%"; //listino kit

$wid16 = "5%"; //listino kg

$arrayMsgErrPhp = array($msgErrQtaNumerica, $msgErrAggCostoLotto);
?>

<script language="javascript">

    var arrayMsgErrJs = new Array("<?= join('", "', $arrayMsgErrPhp) ?>");

    function controllaCampi(arrayMsgErrJs) {

        var rv = true;
        var error = false;
        var lotto = "";
        var i = 1;
<?php
$codLotto = "";
mysql_data_seek($sql, 0);
while ($row = mysql_fetch_array($sql)) {
    $codLotto = $row['codice'];
    ?>
            error = false;
            if (document.getElementById('QtaInv' + i).value === ""
                    || isNaN(document.getElementById('QtaInv' + i).value)
                    || document.getElementById('QtaList' + i).value === ""
                    || isNaN(document.getElementById('QtaList' + i).value)
                    || document.getElementById('QtaScorta' + i).value === ""
                    || isNaN(document.getElementById('QtaScorta' + i).value)) {
                error = true;
            }
            if (error) {
                lotto = "<?= $codLotto ?>";
                rv = false;
            }
            i++;
<?php } ?>
        if (!rv) {
            alert(lotto + '  ' + arrayMsgErrJs[0]);
        }

        return rv;
    }
    //Salva le modifiche sul catalogo
    function AggiornaCatalogo() {
        document.forms["VediLotti"].action = "modifica_lotto_artico.php?ToDo=AggiornaCatalogo";
    }
    //Salva le giacenze eventualmente modificate
    function SalvaGiacenza() {
        document.forms["VediLotti"].action = "modifica_lotto_artico.php?ToDo=SalvaGiacenze";
    }
    //Salva i prezzi di listino eventualmente modificati
    function SalvaListino() {
        document.forms["VediLotti"].action = "modifica_lotto_artico.php?ToDo=SalvaListino";
    }
    //Salva la scorta minima  eventualmente modificata
    function SalvaScortaMinima() {
        document.forms["VediLotti"].action = "modifica_lotto_artico.php?ToDo=SalvaScortaMinima";
    }
    //Aumenta i prezzi di listino di un dato valore percentuale
    function AggiornaListino() {
        document.forms["VediLotti"].action = "aggiorna_lotto_listino.php";
    }
    //Aggiorna lo script tenendo presente i vari filtri di ricerca impostati
    function AggiornaScript() {
        document.forms["VediLotti"].action = "gestione_lotti.php";
        document.forms["VediLotti"].submit();
    }
    //Aggiorna il campo costo di tutti i lotti ricalcolandolo
    function AggiornaCostoLotti() {
        var costoAggiornato = true;
<?php
$costoAggiornato = true;
$aggiornaCosto = true;
mysql_data_seek($sql, 0);
while ($row = mysql_fetch_array($sql)) {
    $aggiornaCosto = aggiornaCostoLotto($row['codice'], calcolaCostoLottoNew($row['codice']));
    if (!$aggiornaCosto)
        $costoAggiornato = false;
}
?>
        costoAggiornato = "<?= $costoAggiornato ?>";

        if (!costoAggiornato) {
            alert('Errore nell aggiornamento costi');
        } else {
            alert('Costi aggiornati');
        }
        document.forms["VediLotti"].action = "gestione_lotti.php";

        return costoAggiornato;
    }


</script>


<div id="container" style="width:90%; margin:15px auto;align:center;">

    <div style="align:center;">
        <table  style="witdh:20%;margin:15px auto;" >
            <tr>
                <th colspan="2"><?php echo $titoloPaginaGestioneLotti ?></th>
            </tr>
            <tr>
                <td><a style="margin-right: 10px;" href="carica_lotto_artico.php"><?php echo $nuovoLottoArtico ?></a></td>
                <td><a style="margin-right: 10px;" href="gestione_bolle.php"><?php echo $filtroMovimentiLotti ?></a></td>
                <td><a style="margin-right: 10px;" href="verifica_ordine.php"><?php echo "VERIFICA ORDINE" ?></a></td>
            </tr>
        </table>
    </div>
    <div style="float:right;width:20%">
        <ul style=" font-size:12px; width:100%">
            <li class="dataRigYell"><?php echo $filtroLegendaRapporto ?></li>
            <li class="dataRigRed"><?php echo $filtroLegendaVariazione ?></li>   
            <li class="dataRigWhite"><?php echo $msgInfoRiordinoLotti ?></li>
            <li class="dataRigLight"><?php echo $msgInfoFuoriCatalogo ?></li>
        </ul>
    </div>
    <!--################## MOTORE DI RICERCA ###################################-->
    <form  name="VediLotti" id="VediLotti" method="POST" onsubmit="return controllaCampi(arrayMsgErrJs)">
        <table class="table3" >
            <tr>
                <td ><input style="width:100%" type="text" name="Codice" value="<?php echo $_SESSION['Codice'] ?>" /></td>
                <td ><input style="width:100%"type="text" name="Descri" value="<?php echo $_SESSION['Descri'] ?>" /></td>
                <td ><input style="width:100%" type="text" name="NumKit" value="<?php echo $_SESSION['NumKit'] ?>" /></td>
                <td ><input style="width:100%" type="text" name="QtaKit" value="<?php echo $_SESSION['QtaKit'] ?>" /></td>
                <td ><input style="width:100%" type="text" name="PesoLotto" value="<?php echo $_SESSION['PesoLotto'] ?>" /></td>
                <td colspan="2"><input style="width:100%" type="text" name="Costo" value="<?php echo $_SESSION['Costo'] ?>" /></td>
                <td ><input style="width:100%" type="text" name="Listino" value="<?php echo $_SESSION['Listino'] ?>" /></td>
                <td ><input style="width:100%" type="text" name="ListinoKit" value="<?php echo "" ?>" disabled="true"/></td>
                <td ><input style="width:100%" type="text" name="ListinoKg" value="<?php echo "" ?>" disabled="true"/></td>
                <td ><input style="width:100%" type="text" name="Giacenza" value="<?php echo $_SESSION['Giacenza'] ?>" /></td>
                <td ><input style="width:100%" type="text" name="ScortaMinima" value="<?php echo $_SESSION['ScortaMinima'] ?>" /></td>
                <td ><input style="width:100%" type="text" name="DtAbilitato" value="<?php echo $_SESSION['DtAbilitato'] ?>" /></td>

            </tr>
            <!--################## RICERCA CON LIST BOX ###############################-->
            <tr>
                <td><select  style="width:100%" name="CodiceList" id="CodiceList" onChange="AggiornaScript()">
                        <option value="<?php echo $_SESSION['CodiceList'] ?>" selected="<?php echo $_SESSION['CodiceList'] ?>"></option>
                        <?php
                        while ($rowCodice = mysql_fetch_array($sqlCodice)) {
                            ?>
                            <option value="<?php echo $rowCodice['codice']; ?>"><?php echo $rowCodice['codice']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select style="width:100%" name="DescriList" id="DescriList" onChange="AggiornaScript()">
                        <option value="<?php echo $_SESSION['DescriList'] ?>" selected="<?php echo $_SESSION['DescriList'] ?>"></option>
                        <?php
                        while ($rowDescri = mysql_fetch_array($sqlDescri)) {
                            ?>
                            <option value="<?php echo $rowDescri['descri']; ?>"><?php echo $rowDescri['descri']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select style="width:100%" name="NumKitList" id="NumKitList" onChange="AggiornaScript()">
                        <option value="<?php echo $_SESSION['NumKitList'] ?>" selected="<?php echo $_SESSION['NumKitList'] ?>"></option>
                        <?php
                        while ($rowNumKit = mysql_fetch_array($sqlNumKit)) {
                            ?>
                            <option value="<?php echo $rowNumKit['num_sac_in_lotto']; ?>"><?php echo $rowNumKit['num_sac_in_lotto']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select style="width:100%" name="QtaKitList" id="QtaKitList" onChange="AggiornaScript()">
                        <option value="<?php echo $_SESSION['QtaKitList'] ?>" selected="<?php echo $_SESSION['QtaKitList'] ?>"></option>
                        <?php
                        while ($rowQtaKit = mysql_fetch_array($sqlQtaKit)) {
                            ?>
                            <option value="<?php echo $rowQtaKit['qta_sac']; ?>"><?php echo $rowQtaKit['qta_sac']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select style="width:100%" name="PesoLottoList" id="PesoLottoList" onChange="AggiornaScript()">
                        <option value="<?php echo $_SESSION['PesoLottoList'] ?>" selected="<?php echo $_SESSION['PesoLottoList'] ?>"></option>
                        <?php
                        while ($rowPesoLot = mysql_fetch_array($sqlPesoLotto)) {
                            ?>
                            <option value="<?php echo $rowPesoLot['qta_lotto']; ?>"><?php echo $rowPesoLot['qta_lotto']; ?></option>
                        <?php } ?>
                    </select></td>
                <td colspan="2"><select style="width:100%" name="CostoList" id="CostoList" onChange="AggiornaScript()">
                        <option value="<?php echo $_SESSION['CostoList'] ?>" selected="<?php echo $_SESSION['CostoList'] ?>"></option>
                        <?php
                        while ($rowCosto = mysql_fetch_array($sqlCosto)) {
                            $costo = number_format($rowCosto['costo'], 2, '.', '');
                            ?>
                            <option value="<?php echo $costo; ?>"><?php echo $costo; ?></option>
                        <?php } ?>
                    </select></td>
                <td>
                    <select style="width:100%" name="ListinoList" id="ListinoList" onChange="AggiornaScript()">
                        <option value="<?php echo $_SESSION['ListinoList'] ?>" selected="<?php echo $_SESSION['ListinoList'] ?>"></option>
                        <?php
                        while ($rowListino = mysql_fetch_array($sqlListino)) {
                            $listino = number_format($rowListino['listino'], 2, '.', '');
                            ?>
                            <option value="<?php echo $listino; ?>"><?php echo $listino; ?></option>
                        <?php } ?>
                    </select></td>
                <td>
                    <select style="width:100%" disabled="true">
                        <option value="" selected="" ></option>

                    </select>
                </td>
                <td>
                    <select style="width:100%" disabled="true">
                        <option value="" selected="" ></option>

                    </select>
                </td>
                <td><select style="width:100%"  name="GiacenzaList" id="GiacenzaList" onChange="AggiornaScript()">
                        <option value="<?php echo $_SESSION['GiacenzaList'] ?>" selected="<?php echo $_SESSION['GiacenzaList'] ?>"></option>
                        <?php
                        while ($rowGiac = mysql_fetch_array($sqlGiac)) {
                            ?>
                            <option value="<?php echo $rowGiac['giacenza_attuale']; ?>"><?php echo $rowGiac['giacenza_attuale']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select style="width:100%" name="ScortaMinimaList" id="ScortaMinimaList" onChange="AggiornaScript()">
                        <option value="<?php echo $_SESSION['ScortaMinimaList'] ?>" selected="<?php echo $_SESSION['ScortaMinimaList'] ?>"></option>
                        <?php
                        while ($rowScorta = mysql_fetch_array($sqlScortaMinima)) {
                            ?>
                            <option value="<?php echo $rowScorta['scorta_minima']; ?>"><?php echo $rowScorta['scorta_minima']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select  style="width:100%"  name="DtAbilitatoList" id="DtAbilitatoList" onChange="AggiornaScript()">
                        <option value="<?php echo $_SESSION['DtAbilitatoList'] ?>" selected="<?php echo $_SESSION['DtAbilitatoList'] ?>"></option>
                        <?php
                        while ($rowDtAbil = mysql_fetch_array($sqlDtAbil)) {
                            ?>
                            <option value="<?php echo $rowDtAbil['dt_abilitato']; ?>"><?php echo $rowDtAbil['dt_abilitato']; ?></option>
                        <?php } ?>
                    </select></td>
                <td colspan="2"><input type="button"  value="<?php echo $valueButtonCerca ?>" onClick="AggiornaScript()" style="width: 80px"/></td>
            </tr>
            <!--################## ORDINAMENTO ########################################-->
            <tr>              
                <td class="cella3" width="<?php echo $wid1 ?>"><div id="OrdinaCodice"><?php echo $filtroCodice; ?>
                        <button name="Filtro" type="submit" value="codice" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid2 ?>"><div id="OrdinaDescri"><?php echo $filtroDescrizione; ?>
                        <button name="Filtro" type="submit" value="descri" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid12 ?>"><div id="OrdinaNumKit"><?php echo $filtroNumKit; ?>
                        <button name="Filtro" type="submit" value="num_sac_in_lotto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid13 ?>"><div id="OrdinaPesoKit"><?php echo $filtroPesoKit; ?>
                        <button name="Filtro" type="submit" value="qta_sac" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid14 ?>"><div id="OrdinaPesoLotto"><?php echo $filtroPesoScatola; ?>
                        <button name="Filtro" type="submit" value="qta_lotto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid3 ?>"><div id="OrdinaCosto"><?php echo $filtroCostoLotto ?>
                        <button name="Filtro" type="submit" value="costo" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid4 ?>"><?php echo $filtroCostoAtt; ?></td>

                <td class="cella3" width="<?php echo $wid5 ?>"><div id="OrdinaListino"><?php echo $filtroListinoLotto; ?>
                        <button name="Filtro" type="submit" value="listino" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid15 ?>"><div id="OrdinaListino"><?php echo $filtroListino . " " . $filtroKitChim; ?>
                    </div>
                </td>
                <td class="cella3" width="<?php echo $wid16 ?>"><div id="OrdinaListKg"><?php echo $filtroListinoProdKg; ?>
                    </div>
                </td>
                <td class="cella3" width="<?php echo $wid6 ?>"><div id="OrdinaGiacenza"><?php echo $filtroGiacenza; ?>
                        <button name="Filtro" type="submit" value="giacenza_attuale" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid7 ?>" ><div id="OrdinaScortaMinima"><?php echo $filtroScortaMinima; ?>
                        <button name="Filtro" type="submit" value="scorta_minima" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid8 ?>"><div id="OrdinaDtabil"><?php echo $filtroDt; ?>
                        <button name="Filtro" type="submit" value="l.dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid9 ?>"><?php echo $filtroRapp ?></td>
                <td class="cella3" width="<?php echo $wid10 ?>"><?php echo $filtroDiff ?></td>
                <td class="cella3" width="<?php echo $wid11 ?>"><?php echo $filtroVenduto ?></td>
                <td class="cella3" width="<?php echo $wid10 ?>"><?php echo $filtroCapacitaProd ?></td>
            </tr>
            <?php
            echo "<br/>" . $msgRecordTrovati . $trovati . "<br/>";
            echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";


            $k = 1;
            if (mysql_num_rows($sql) > 0)
                mysql_data_seek($sql, 0);

            while ($row = mysql_fetch_array($sql)) {

                $rapp = floatval(0);
                $diff = floatval(0);
                if ($row['costo'] > 0) {
                    $rapp = number_format(($row['listino'] / $row['costo']), 2);
                    $diff = number_format(($row['listino'] - $row['costo']), 2);
                }

                $costo = number_format(doubleval($row['costo']), 2);
                $costoAgg = number_format(doubleval(calcolaCostoLottoNew($row['codice'])), 2);
                $listinoKit = 0;
                if ($row['num_sac_in_lotto'] > 0)
                    $listinoKit = number_format($row['listino'] / $row['num_sac_in_lotto'], 2, '.', '');

                $listinoKg = 0;
                $pesoLottoKg = 0;
                if ($row['qta_lotto'] > 0) {

                    $pesoLottoKg = $row['qta_lotto'] / 1000;

                    $listinoKg = number_format($row['listino'] / $pesoLottoKg, 2, '.', '');
                }
                //############# GESTIONE DEI COLORI ############################
                
                
                $nomeTitle = "";
                $nomeClasse = "dataRigGray";

                //###### variazione di costo ################
                if ($costo > 0 AND ( $costo != $costoAgg)) {

                    $nomeClasse = "dataRigRed";
                    $nomeTitle = "";
                }
                //###### prodotto sotto costo ################
                if ($rapp < 2) {
                    $nomeClasse = "dataRigYell";
                    $nomeTitle = "";
                }
                //###### giacenza inferiore alla scorta minima ######
                if ($row['giacenza_attuale'] > 0 AND $row['giacenza_attuale'] < $row['scorta_minima']) {
                    $nomeClasse = "dataRigWhite";
                    $nomeTitle = $msgInfoRiordinoLotti;
                }

                //###### prodotto fuori catalogo ################
                if ($row['catalogo'] == $valCatalogoNo) {
                    $nomeClasse = "dataRigLight";
                    $nomeTitle = "Includi nel catalogo";
                }
                
                //##############################################################
                //############## Calcolo della capacità produttiva #############
                //tabelle formula,generazione_formula,materia_prima
                $qtaMatLot = 0;
                $giacenza = 0;
                $capacitaProd = 0;
                $arrayCapMat = array();
                $i = 0;
                $codFormula = 'K' . substr($row['codice'], 1);
                $sqlMat = findMateriePriFormulaByCod($codFormula, 'm.cod_mat');
                while ($rowM = mysql_fetch_array($sqlMat)) {
                    //Per ogni materia prima cerco la qta nella formula per 1 lotto ,e  la quantità in giacenza
                    //Calcolo la quantità della materia prima corrente che va in un singolo lotto
                    if ($row['qta_tot_miscela'] > 0)
                        $qtaMatLot = ($rowM['qta_lotto'] * $rowM['quantita']) / $row['qta_tot_miscela']; //g

                    $giacenza = $rowM['giacenza_attuale']; //kg
//                    echo "<br/>####################";
//                    echo "<br/>".$row['codice'];
//                    echo "<br/>".$rowM['cod_mat'];
//                    echo "<br/>".$rowM['quantita'];
//                    echo "<br/>qta_lotto " .$qtaLotto;
//                    echo "<br/>giacenza " .$giacenza;

                    if ($qtaMatLot > 0)
                        $arrayCapMat[$i] = number_format($giacenza * 1000 / $qtaMatLot, '0', ',', '');
                    $i++;
                }


                if (count($arrayCapMat) > 0) {
                    sort($arrayCapMat);
//                print_r($arrayCapMat);
                    //Prendo la prima capacità dell'array perchè è la minima possibile
                    $capacitaProd = $arrayCapMat[0];
                    
                    if($capacitaProd<0) $capacitaProd=0;
                }
                //##############################################################
                
                
                $idProdotto = 0;
                if ($row['codice'] != '') {
                    $sqlProd = findProdottoByCodice(substr($row['codice'],1));
                    while ($rowP = mysql_fetch_array($sqlProd)) {
                        $idProdotto = $rowP['id_prodotto'];
                    }
                }
                //########### LOTTI VENDUTI ####################################
                $lottiVenduti=0;
                $sqlVenduti=findLottiVenduti($row['codice'],$_SESSION['DtAbilitato']);
                while ($rowV = mysql_fetch_array($sqlVenduti)) {
                
                    $lottiVenduti=$rowV['lotti_venduti'];
                }
                
                
                //##############################################################
                ?>
                <tr>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid1 ?>" >
                <?php if ($row['catalogo'] == $valCatalogoSi) {
                    $nomeTitle = $titleEliminaDaCatalogo;
                    ?>                       
                            <input type="checkbox" name='catalogo<?php echo $k ?>' value='si' checked='' title="<?php echo $nomeTitle ?>"/>
                            <?php
                        } else {
                            ?>
                            <input type="checkbox" name='catalogo<?php echo $k ?>' value='no' title="<?php echo $nomeTitle ?>"/>
                            <?php }
                        ?>
                        <a name="3" href="../prodotti/vista_prodotto_formula.php?Prodotto=<?php echo $idProdotto ?>"><?php echo $row['codice'] ?></a>
                    </td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid2 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['descri']?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid12 ?>" align="right" title="<?php echo $nomeTitle ?>"><?php echo $row['num_sac_in_lotto'] ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid13 ?>" align="right"  title="<?php echo $nomeTitle ?>"><?php echo $row['qta_sac'] . " " . $filtrogBreve ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid14 ?>" align="right" title="<?php echo $nomeTitle ?>"><?php echo $row['qta_lotto'] . " " . $filtrogBreve ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid3 ?>" align="right"><?php echo $costo . " " . $filtroEuro ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid4 ?>" align="right"><?php echo $costoAgg . " " . $filtroEuro ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid5 ?>"><input class="<?php echo $nomeClasse; ?>" style="width:70%;text-align:right" type="text" name="QtaList<?php echo($k); ?>" id="QtaList<?php echo($k); ?>" value="<?php echo number_format($row['listino'], 2, '.', '') ?>" ><?php echo $filtroEuro ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid15 ?>" align="right"><?php echo $listinoKit . " " . $filtroEuro ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid16 ?>" align="right"><?php echo $listinoKg . " " . $filtroEuro . "/" . $filtroKgBreve ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid6 ?>"><input  class="<?php echo $nomeClasse; ?>" style="width:60%;text-align:right" type="text" name="QtaInv<?php echo($k); ?>" id="QtaInv<?php echo($k); ?>" value="<?php echo $row['giacenza_attuale'] ?>" ><?php echo $row['uni_mis'] ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid7 ?>"><input  class="<?php echo $nomeClasse; ?>" style="width:60%;text-align:right" type="text" name="QtaScorta<?php echo($k); ?>" id="QtaScorta<?php echo($k); ?>" value="<?php echo $row['scorta_minima'] ?>" ><?php echo $filtroPz ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid8 ?>"><?php echo $row['dt_abilitato'] ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid9 ?>" align="right" title="<?php echo $titleRappListCosto ?>"> <?php echo $rapp ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid10 ?>" align="right" title="<?php echo $titleDiffListCosto ?>"> <?php echo $diff ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid10 ?>" align="right" title="<?php echo $titleNumLottiVenduti ?>"><b> <?php  echo  $lottiVenduti." ".$filtroPz     ?></b></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid10 ?>" align="right" ><nobr> <?php echo $capacitaProd . ' ' . $filtroPz ?></nobr></td>
                </tr>
    <?php
    $k++;
}
?>
            <tr>
                <td class="cella2" style="text-align: right;" colspan="17">
                    <input type="submit" name="submit1" onClick="AggiornaCatalogo()" title ="<?php echo $titleAggiornaCatalogo ?>" value="<?php echo $valueButtonAggiornaCatalogo ?>" />
                    <input type="submit" name="submit1" onClick="AggiornaCostoLotti()" title ="<?php echo $titleAggiornaCostoLotti ?>" value="<?php echo $valueButtonAggiornaCostoLotti ?>" />
                    <input type="submit" name="submit2" onClick="AggiornaListino()" title ="<?php echo $titleAggiornaListinoLotti ?>" value="<?php echo $valueButtonAggiornaListinoLotti ?>" />
                    <input type="submit" name="submit3" onClick="SalvaListino()" title ="<?php echo $titleSalvaListino ?>" value="<?php echo $valueButtonSalvaListino ?>" />
                    <input type="submit" name="submit4" onClick="SalvaGiacenza()" title ="<?php echo $titleSalvaGiac ?>" value="<?php echo $valueButtonSalvaGiac ?>" />
                    <input type="submit" name="submit5" onClick="SalvaScortaMinima()" title ="<?php echo $titleSalvaScortaMinima ?>" value="<?php echo $valueButtonSalvaScortaMinima ?>" />


            </tr>
        </table>
    </form>
</div>