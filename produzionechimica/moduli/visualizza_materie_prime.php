<?php
$wid1 = "10%";
$wid2 = "10%";
$wid3 = "25%";
$wid4 = "5%";
$wid5 = "8%";
$wid6 = "8%";
$wid7 = "7%";
$wid8 = "7%";
$wid9 = "10%";
$wid10 = "5%";
$arrayMsgErrPhp = array($msgErrQtaNumerica,$msgErrDataInfNonValida,$msgErrDataSupNonValida);
?>

<script language="javascript">
    var arrayMsgErrJs = new Array("<?= join('", "', $arrayMsgErrPhp) ?>");
    function controllaCampi(arrayMsgErrJs) {

        var rv = true;
        var error = false;
        var lotto = "";
        var i = 1;
<?php
$codMat = "";
mysql_data_seek($sql, 0);
while ($row = mysql_fetch_array($sql)) {
    $codMat = $row['cod_mat'];
    ?>
            error = false;
            if (document.getElementById('QtaInv' + i).value === ""
                    || isNaN(document.getElementById('QtaInv' + i).value)
                    || document.getElementById('QtaScorta' + i).value === ""
                    || isNaN(document.getElementById('QtaScorta' + i).value)) {
                error = true;
            }
            if (error) {
                mat = "<?= $codMat ?>";
                rv = false;
            }
            i++;
<?php } ?>
        if (!rv) {
            alert(mat + '  ' + arrayMsgErrJs[0]);
        }

        return rv;
    }
    //Aggiorna lo script tenendo presente i vari filtri di ricerca impostati
    function AggiornaScript() {
        document.forms["VediMatPri"].action = "gestione_materie_prime.php";
        document.forms["VediMatPri"].submit();
    }
    //Salva le giacenze eventualmente modificate
    function SalvaGiacenza() {
        document.forms["VediMatPri"].action = "modifica_matpri_giac.php?ToDo=SalvaGiacenze";
    }
    //Salva la scorta minima  eventualmente modificata
    function SalvaScortaMinima() {
        document.forms["VediMatPri"].action = "modifica_matpri_giac.php?ToDo=SalvaScortaMinima";
    }

    function isValidDate(dateString) {
        var regEx = /^\d{4}-\d{2}-\d{2}$/;
        return dateString.match(regEx) != null;
    }

    function EsportaExcel() {
        document.forms["EsportaConsumi"].action = "download_excel_consumi.php";
        document.forms["EsportaConsumi"].submit();
    }
    function controllaData(arrayMsgErrJs) {

        var rv = true;
        var msg = "";

        if (!isValidDate(document.getElementById('DataInf').value)) {
            rv = false;
            msg = msg + ' ' + arrayMsgErrJs[1];
        }
        if (!isValidDate(document.getElementById('DataSup').value)) {
            rv = false;
            msg = msg + ' ' + arrayMsgErrJs[2];
        }
        
        if (!rv) {
            alert(msg);
            rv = false;
        }
        return rv;
    }
    function AggiornaSelect(num) {       
     
        var string='?condizioneSelect='+num;
        
        document.forms["VediMatPri"].action = "gestione_materie_prime.php";
        document.forms["VediMatPri"].submit();
        location.href=string;
        
    }

</script>
<div align="right">
    <ul style="text-align:left; font-size:12px; width:25%">
        <li class="dataRigGray"><a href="#" onclick="AggiornaSelect(1)" ><?php echo $msgInfoMatPrimaInProduzione ?></a></li>
        <li class="dataRigLightGray12"><a href="#" onclick="AggiornaSelect(2)" ><?php echo $msgInfoMatPrimaNotInProd ?></a></li>
        <li class="dataRigWhite"><a href="#" onclick="AggiornaSelect(3)" ><?php echo $msgInfoRiordinoLotti ?></a></li>
        <li class="dataRigGray"><a href="#" onclick="AggiornaSelect(4)" ><?php echo $mostraTutto ?></a></li>
    </ul>
</div>
<table class="table3" style=" width:1500px;">
    <tr>
        <th colspan="6"><?php echo $titoloPaginaMatPrime ?></th>
    </tr>
    <tr>
        <td colspan="6" style="text-align:center;"> 
            <a name="27"  href="carica_materia.php"><?php echo $nuovaMatPrima ?></a>&nbsp;&nbsp;
            <a name="103" href="gestione_mov_magazzino.php"><?php echo $filtroCodiciMov ?></a>
        </td>
    </tr>
</table>
<div align="right">
    <form id="EsportaConsumi" name="EsportaConsumi" method="Post"  onsubmit="return controllaData(arrayMsgErrJs)" >
        <input type="hidden" name="StringaUtAziende" id="StringaUtAziende" value="<?php echo $strUtentiAziende ?>"/>
        <table style="text-align:left; font-size:12px; width:25%;">
            <tr>
                <td class="dataRigGray" colspan='2'><?php echo $filtroPeriodoRifConsumi ?></td>
            </tr>
            <tr>
                <td class="dataRigLightGray12">
                    <?php echo $filtroDal ?>
                    <input style="width:30%;" type="text" name="DataInf" id="DataInf" placeholder="yyyy-mm-dd"/>
                    <?php echo $filtroAl ?>
                    <input style="width:30%;" type="text" name="DataSup" id="DataSup" placeholder="yyyy-mm-dd"/>&nbsp;
                </td>
                <td class="dataRigLightGray12">
                    <input type="image" src="/CloudFab/images/pittogrammi/download_G.png"  style="height:40px; width:40px;"  onClick="EsportaExcel()" title="<?php echo $titleEsportaDati?>" />
                </td>
            </tr>
        </table>
    </form>
</div>
<!--################## MOTORE DI RICERCA ###################################-->
<form  name="VediMatPri" id="VediMatPri"  method="POST" onsubmit="return controllaCampi(arrayMsgErrJs)">
    <table class="table3" >
        <tr>
            <td><input style="width:100%" type="text" name="Famiglia" value="<?php echo $_SESSION['Famiglia'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Codice" value="<?php echo $_SESSION['Codice'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Descri" value="<?php echo $_SESSION['Descri'] ?>" /></td>
            <td><input style="width:100%" type="text" name="PreAcq" value="<?php echo $_SESSION['PreAcq'] ?>" /></td>
            <td><input style="width:100%" type="text" name="ScortaMinima" value="<?php echo $_SESSION['ScortaMinima'] ?>" /></td>
            <td></td><!--qta inventario--> 
            <td></td><!--acquisti-->
            <td></td><!--consumi-->
            <td></td><!--giacenza-->
           <!--<td><input style="width:100%" type="text" name="Giacenza" value="<?php echo $_SESSION['Giacenza'] ?>" /></td>-->
            <td></td><!--valore €-->
            <!--<td></td>DtAbilitato-->
            <!--<td><input style="width:100%" type="text" name="DtAbilitato" value="<?php echo $_SESSION['DtAbilitato'] ?>" /></td>-->
        </tr>
        <!--################## RICERCA CON LIST BOX ###############################-->
        <tr>
            <td>
                <select style="width:100%" name="FamigliaList" id="FamigliaList" onChange="AggiornaScript()">
                    <option value="<?php echo $_SESSION['FamigliaList'] ?>" selected="<?php echo $_SESSION['FamigliaList'] ?>"></option>
                    <?php
                    while ($rowFamiglia = mysql_fetch_array($sqlFamiglia)) {
                        ?>
                        <option value="<?php echo $rowFamiglia['famiglia']; ?>"><?php echo $rowFamiglia['famiglia']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%" name="CodiceList" id="CodiceList" onChange="AggiornaScript()">
                    <option value="<?php echo $_SESSION['CodiceList'] ?>" selected="<?php echo $_SESSION['CodiceList'] ?>"></option>
                    <?php
                    while ($rowCodice = mysql_fetch_array($sqlCodice)) {
                        ?>
                        <option value="<?php echo $rowCodice['cod_mat']; ?>"><?php echo $rowCodice['cod_mat']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select style="width:100%" name="DescriList" id="DescriList" onChange="AggiornaScript()">
                    <option value="<?php echo $_SESSION['DescriList'] ?>" selected="<?php echo $_SESSION['DescriList'] ?>"></option>
                    <?php
                    while ($rowDescri = mysql_fetch_array($sqlDescri)) {
                        ?>
                        <option value="<?php echo $rowDescri['descri_mat']; ?>"><?php echo $rowDescri['descri_mat']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select style="width:100%" name="PreAcqList" id="PreAcqList" onChange="AggiornaScript()">
                    <option value="<?php echo $_SESSION['PreAcqList'] ?>" selected="<?php echo $_SESSION['PreAcqList'] ?>"></option>
                    <?php
                    while ($rowPreAcq = mysql_fetch_array($sqlPreAcq)) {
                        ?>
                        <option value="<?php echo $rowPreAcq['pre_acq']; ?>"><?php echo $rowPreAcq['pre_acq']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select style="width:100%" name="ScortaMinimaList" id="ScortaMinimaList" onChange="AggiornaScript()">
                    <option value="<?php echo $_SESSION['ScortaMinimaList'] ?>" selected="<?php echo $_SESSION['ScortaMinimaList'] ?>"></option>
                    <?php
                    while ($rowScortaMinima = mysql_fetch_array($sqlScortaMinima)) {
                        ?>
                        <option value="<?php echo $rowScortaMinima['scorta_minima']; ?>"><?php echo $rowScortaMinima['scorta_minima']; ?></option>
                    <?php } ?>
                </select></td>
                 <td><img src="/CloudFab/images/icone/lente_piccola.png" onClick="document.forms['VediMatPri'].submit();" title="<?php echo $titleRicerca ?>"/></td>
            <td></td><!--qta inventario-->
            <td></td><!--acquisti-->
            <td></td><!--consumi-->
            <td></td><!--giacenza-->
<!--             <td><select style="width:100%" name="GiacenzaList" id="GiacenzaList" onChange="AggiornaScript()">
                    <option value="<?php echo $_SESSION['GiacenzaList'] ?>" selected="<?php echo $_SESSION['GiacenzaList'] ?>"></option>
            <?php
            while ($rowGiac = mysql_fetch_array($sqlGiac)) {
                ?>
                 <option value="<?php echo $rowGiac['giacenza_attuale']; ?>"><?php echo $rowGiac['giacenza_attuale']; ?></option>
            <?php } ?>
                </select></td>-->

            <td></td><!--valore euro-->
            <!--<td><input style="width:100%" type="text" name="DtFinePeriodo" value="<?php echo $_SESSION['DtFinePeriodo'] ?>" /></td>-->
            <td></td>
            
<!--             <td><select  style="width:100%"  name="DtAbilitatoList" id="DtAbilitatoList" onChange="AggiornaScript()">
                     <option value="<?php echo $_SESSION['DtAbilitatoList'] ?>" selected="<?php echo $_SESSION['DtAbilitatoList'] ?>"></option>
            <?php
            while ($rowDtAbil = mysql_fetch_array($sqlDtAbil)) {
                ?>
                                                     <option value="<?php echo $rowDtAbil['dt_abilitato']; ?>"><?php echo $rowDtAbil['dt_abilitato']; ?></option>
            <?php } ?>
                 </select></td>-->
            
           
            
        </tr>
        <!--################## ORDINAMENTO ########################################-->
        <tr>              
            <td class="cella3" width="<?php echo $wid1 ?>"><div id="OrdinaFamiglia"><?php echo $filtroFamiglia; ?>
                    <button name="Filtro" type="submit" value="famiglia" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid2 ?>"><div id="OrdinaCodice"><?php echo $filtroCodice; ?>
                    <button name="Filtro" type="submit" value="cod_mat" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid3 ?>"><div id="OrdinaDescri"><?php echo $filtroDescrizione; ?>
                    <button name="Filtro" type="submit" value="descri_mat" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid4 ?>"><div id="OrdinaPreAcq"><?php echo $filtroPrezzo ?>
                    <button name="Filtro" type="submit" value="pre_acq" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid6 ?>"><div id="OrdinaScortaMinima"><?php echo $filtroScortaMinima; ?>
                    <button name="Filtro" type="submit" value="scorta_minima" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3"><?php echo $filtroInventario ?></td><!--inventario-->
            <td class="cella3"><?php echo $filtroAcquisti ?></td><!--acquisti-->
            <td class="cella3"><?php echo $filtroConsumo ?></td><!--consumi-->
            <td class="cella3" width="<?php echo $wid5 ?>"><div id="OrdinaGiacenza"><?php echo $filtroGiacenza; ?>
                    <button name="Filtro" type="submit" value="giacenza_attuale" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3"><?php echo $filtroValore .' '.$filtroGiacenza ?>&nbsp;&euro;</td>
            <td class="cella3" width="<?php echo $wid7 ?>"><div id="OrdinaDtabil"><?php echo $filtroDt; ?>
                    <button name="Filtro" type="submit" value="dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid8 ?>"><?php echo $filtroOperazioni; ?></td>
        </tr>
        <ul type="circle">
            <li><?php echo $msgNumMateriePrime . " " ?><font color="#A00028"><?php echo $trovati ?></font></li>
            <li><?php echo $msgTotConsumo . " " ?><font color="#A00028"><?php echo number_format($Consumo, $PrecisioneQta, '.', ' ') . "  " . $filtroKgBreve ?></font></li>
            <li><?php echo $msgTotSpesa . " " ?><font color="#A00028"><?php echo number_format($Spesa, $PrecisioneCosti, '.', ' ') . "  " . $filtroEuro; ?></font></li>
        </ul>
        <?php
        echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";

        $totInventario = 0;
        $totAcquisti = 0;
        $totComsumi = 0;
        $totGiacenze = 0;
        $totValore = 0;

        $i = 1;
        if (mysql_num_rows($sql) > 0)
            mysql_data_seek($sql, 0);
        while ($row = mysql_fetch_array($sql)) {
            $nomeClasse = "dataRigGray";

            $nomeTitle = "";
            if ($row['giacenza_attuale'] > 0 AND $row['scorta_minima'] > 0 AND $row['giacenza_attuale'] < $row['scorta_minima']) {
                $nomeClasse = "dataRigWhite";
                $nomeTitle = $msgInfoRiordino;
            }

            if (!in_array($row['cod_mat'], $arrayMatInFormule)) {
                $nomeClasse = "dataRigLightGray12";
                $nomeTitle = $msgInfoMatPrimaNotInProd;
            }
            //##################################################################
            if (isset($_POST['condizioneSelect']) AND $_POST['condizioneSelect'] != "") {
                $_SESSION['condizioneSelect'] = trim($_POST['condizioneSelect']);
            }     
           
            if (isset($_GET['condizioneSelect']) AND $_GET['condizioneSelect'] != "") {                
                switch ($_GET['condizioneSelect']) {
                    case 1:
                        //Seleziona solo le materie prime in produzione
                        $nomeClasse = "dataRigGray";
                        $nomeTitle = "";
                        break;
                    case 2:
                        //Seleziona solo le materie prime fuori produzione
                         $nomeClasse = "dataRigLightGray12";
                         $nomeTitle = $msgInfoMatPrimaNotInProd;
                        break;
                    case 3:
                        //Seleziona solo le materie prime con giacenza al di sotto della scorta minima
                        $nomeClasse = "dataRigWhite";
                        $nomeTitle = $msgInfoRiordino;
                        break;
                    
                }
            }
            //##################################################################
            
            
            //############ CONSUMI_ACQUISTI ###################################
            //begin();
            //Acquisti
            $acquisti = 0;
            $consumi = 0;
            $sqlAcquisti = sommaMovimentiTotMat($row['cod_mat'], $row['dt_inventario'], $_SESSION['DtFinePeriodo'], "2", "1");
            while ($rowA = mysql_fetch_array($sqlAcquisti)) {
                if ($rowA['somma_mov'] > 0)
                    $acquisti = $rowA['somma_mov'];
            }

            //Consumi
            $sqlConsumi = sommaMovimentiTotMat($row['cod_mat'], $row['dt_inventario'], $_SESSION['DtFinePeriodo'], "2", "-1");
            while ($rowC = mysql_fetch_array($sqlConsumi)) {
                if ($rowC['somma_mov'] > 0)
                    $consumi = $rowC['somma_mov'];
            }
            commit();
            $giacenza = 0;
            $valorizzazione = 0;

            $giacenza = $row['inventario'] + $acquisti - $consumi;
            $valorizzazione = $giacenza * $row['pre_acq'];

            //TOTALI
            $totInventario = $totInventario + $row['inventario'];
            $totAcquisti = $totAcquisti + $acquisti;
            $totComsumi = $totComsumi + $consumi;
            $totGiacenze = $totGiacenze + $giacenza;
            $totValore = $totValore + $valorizzazione;

            //##################################################################
            ?>
            <tr>
            <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid1 ?>"><?php echo($row['famiglia']) ?></td>
            <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid2 ?>" title="<?php echo $nomeTitle ?>"><?php echo($row['cod_mat']) ?></td>
            <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid3 ?>" title="<?php echo $nomeTitle ?>"><?php echo($row['descri_mat']) ?></td>
            <td class="<?php echo $nomeClasse; ?>" style="width:<?php echo $wid4 ?>;text-align:right"><?php echo number_format($row['pre_acq'], '2', '.', '') . " " . $filtroEuro ?></td>
            <td class="<?php echo $nomeClasse; ?>" style="width:<?php echo $wid6 ?>;text-align:right"><nobr><input style="width:75%;text-align:right" class="<?php echo $nomeClasse ?>" type="text" name="QtaScorta<?php echo($i); ?>" id="QtaScorta<?php echo($i); ?>" value="<?php echo($row['scorta_minima']) ?>" ><?php echo $filtroKgBreve ?></nobr></td>
            <td class="<?php echo $nomeClasse; ?>" style="width:<?php echo $wid7 ?>;text-align:right"><?php echo number_format($row['inventario'], '2', '.', '') . " " . $filtroKgBreve ?></td>
            <td class="<?php echo $nomeClasse; ?>" style="width:<?php echo $wid7 ?>;text-align:right"><?php echo number_format($acquisti, '2', '.', '') . " " . $filtroKgBreve ?></td>
            <td class="<?php echo $nomeClasse; ?>" style="width:<?php echo $wid8 ?>;text-align:right"><?php echo number_format($consumi, '2', '.', '') . " " . $filtroKgBreve ?></td>
            <td class="<?php echo $nomeClasse; ?>" style="width:<?php echo $wid5 ?>;text-align:right"><nobr><input style="width:75%;text-align:right" class="<?php echo $nomeClasse ?>" type="text" name="QtaInv<?php echo($i); ?>" id="QtaInv<?php echo($i); ?>" value="<?php echo number_format($giacenza, '2', '.', '') ?>" ><?php echo $row['uni_mis'] ?></nobr></td>
    <!--    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid5 ?>"><input style="width:90px" class="<?php echo $nomeClasse ?>" type="text" name="QtaInv<?php echo($i); ?>" id="QtaInv<?php echo($i); ?>" value="<?php echo $row['giacenza_attuale'] ?>" ><?php echo $row['uni_mis'] ?></td>-->
            <td class="<?php echo $nomeClasse; ?>" style="width:<?php echo $wid4 ?>;text-align:right"><?php echo number_format($valorizzazione, '2', '.', '') . " " . $filtroEuro ?></td>
            <td class="<?php echo $nomeClasse; ?>" style="width:<?php echo $wid9 ?>;text-align:right"><?php echo($row['dt_abilitato']) ?></td>
            <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid10 ?>">
                <a name="24" href="modifica_materia_prima.php?Codice=<?php echo($row['cod_mat']) ?>">
                    <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="<?php echo $titleModifica ?>" title="<?php echo $titleModifica ?>"/>
                </a>
            </td>
            </tr>
            <?php
            $i++;
        }
        ?>
            <tr>
                <td class="cella2" colspan="5"></td>
                <td class="cella2" ><?php echo $filtroTotInventario ?></td><!--tot inventario -->
                <td class="cella2" ><?php echo $filtroTotAcquisti ?></td><!--tot acquisti -->
                <td class="cella2" ><?php echo $filtroTotConsumo ?></td><!--tot consumi -->
                <td class="cella2" ><?php echo $filtroTotGiacenza ?></td><!--tot giacenza -->
                <td class="cella2" ><?php echo $filtroTotValoreEuro ?></td><!--valore euro -->
                <td class="cella2" colspan="2"></td>
            </tr>
            <tr>
                <td class="dataRigYellBig" style="text-align: right;" colspan="5"></td>
                <td class="dataRigYellBig" style="text-align: right;" ><?php echo number_format($totInventario, '0', '.', ' ') . " " . $filtroKgBreve ?></td><!--tot inventario -->
                <td class="dataRigYellBig" style="text-align: right;" ><?php echo number_format($totAcquisti, '0', '.', ' ') . " " . $filtroKgBreve ?></td><!--tot acquisti -->
                <td class="dataRigYellBig" style="text-align: right;" ><?php echo number_format($totComsumi, '0', '.', ' ') . " " . $filtroKgBreve ?></td><!--tot consumi -->
                <td class="dataRigYellBig" style="text-align: right;" ><?php echo number_format($totGiacenze, '0', '.', ' ') . " " . $filtroKgBreve ?></td><!--tot giacenza -->
                <td class="dataRigYellBig" style="text-align: right;" ><?php echo number_format($totValore, '0', '.', ' ') . " " . $filtroEuro ?></td><!--valore euro -->
                <td class="dataRigYellBig" style="text-align: right;" colspan="2"></td>
            </tr>
        <tr>
            <td class="cella2" style="text-align: right; " colspan="12">
                <input type="submit" name="submit1" onClick="SalvaGiacenza()" title ="<?php echo $titleSalvaGiac ?>" value="<?php echo $valueButtonSalvaGiac ?>" />
                <input type="submit" name="submit2" onClick="SalvaScortaMinima()" title ="<?php echo $titleSalvaScortaMinima ?>" value="<?php echo $valueButtonSalvaScortaMinima ?>" />
        </tr>
    </table>
</form>