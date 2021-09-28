<?php 
    $wid1 = "6%";
    $wid2 = "25%";
    $wid3 = "7%";
    $wid4 = "7%";
    
    $wid5 = "10%";
    $wid6 = "10%";
    $wid7 = "10%";
    
    $wid8 = "10%";
    $wid9 = "5%";
    $wid10 = "5%";
    $wid11 = "5%";
    
    
    $arrayMsgErrPhp = array($msgErrQtaNumerica, $msgErrAggCostoLotto); ?>
<table>
    <tr>
        <td  class="dataRigYell"><?php echo $filtroLegendaRapporto ?></td>
        <td  class="dataRigRed"><?php echo $filtroLegendaVariazione ?></td>
        <td  class="dataRigWhite"><?php echo $msgInfoRiordinoLotti ?></td>
    </tr>
</table>
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

<table  style="witdh:300px;margin:15px auto;" >
    <tr >
        <th colspan="2"><?php echo $titoloPaginaGestioneLotti ?></th>
    </tr>
    <tr>
        <td><a style="margin-right: 10px;" href="carica_lotto_artico.php"><?php echo $nuovoLottoArtico ?></a></td>
        <td><a style="margin-right: 10px;" href="gestione_bolle.php"><?php echo $filtroMovimentiLotti ?></a></td>
    </tr>
</table>
<!--################## MOTORE DI RICERCA ###################################-->
<form  name="VediLotti" id="VediLotti" method="POST" onsubmit="return controllaCampi(arrayMsgErrJs)">
    <table class="table3">
        <tr>
            <td ><input style="width:100%" type="text" name="Codice" value="<?php echo $_SESSION['Codice'] ?>" /></td>
            <td ><input style="width:100%"type="text" name="Descri" value="<?php echo $_SESSION['Descri'] ?>" /></td>
            <td colspan="2"><input style="width:100%"type="text" name="Costo" value="<?php echo $_SESSION['Costo'] ?>" /></td>
            <td ><input style="width:100%" type="text" name="Listino" value="<?php echo $_SESSION['Listino'] ?>" /></td>
            <td ><input style="width:100%" type="text" name="Giacenza" value="<?php echo $_SESSION['Giacenza'] ?>" /></td>
            <td ><input style="width:100%"  type="text" name="ScortaMinima" value="<?php echo $_SESSION['ScortaMinima'] ?>" /></td>
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
            <td colspan="2"><select style="width:100%" name="CostoList" id="CostoList" onChange="AggiornaScript()">
                    <option value="<?php echo $_SESSION['CostoList'] ?>" selected="<?php echo $_SESSION['CostoList'] ?>"></option>
                    <?php
                    while ($rowCosto = mysql_fetch_array($sqlCosto)) {
                        ?>
                        <option value="<?php echo $rowCosto['costo']; ?>"><?php echo $rowCosto['costo']; ?></option>
                    <?php } ?>
                </select></td>
            <td>
                <select style="width:100%" name="ListinoList" id="ListinoList" onChange="AggiornaScript()">
                    <option value="<?php echo $_SESSION['ListinoList'] ?>" selected="<?php echo $_SESSION['ListinoList'] ?>"></option>
                    <?php
                    while ($rowListino = mysql_fetch_array($sqlListino)) {
                        ?>
                        <option value="<?php echo $rowListino['listino']; ?>"><?php echo $rowListino['listino']; ?></option>
                    <?php } ?>
                </select></td>

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
            <td class="cella3" width="<?php echo $wid3 ?>"><div id="OrdinaCosto"><?php echo $filtroCosto ?>
                    <button name="Filtro" type="submit" value="costo" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid4 ?>"><?php echo $filtroCostoAtt; ?>
                    </td>
            <td class="cella3" width="<?php echo $wid5 ?>"><div id="OrdinaListino"><?php echo $filtroListino; ?>
                    <button name="Filtro" type="submit" value="listino" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
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
                    <button name="Filtro" type="submit" value="dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid9 ?>"><?php echo $filtroRapp ?></td>
            <td class="cella3" width="<?php echo $wid10 ?>"><?php echo $filtroDiff ?></td>
            <td class="cella3" width="<?php echo $wid11 ?>"><?php echo $filtroVenduto ?></td>
        </tr>
        <?php
        echo "<br/>" . $msgRecordTrovati . $trovati . "<br/>";
        echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";



//        $nomeClasse = "cella4";
//        $nomeTitle = "";
        $i = 1;
        if (mysql_num_rows($sql) > 0)
            mysql_data_seek($sql, 0);

        while ($row = mysql_fetch_array($sql)) {

            $nomeTitle = "";
            $nomeClasse = "dataRigGray";
            $rapp = floatval(0);
            $diff = floatval(0);
            if ($row['costo'] > 0) {
                $rapp = number_format(($row['listino'] / $row['costo']),2);
                $diff = number_format(($row['listino'] - $row['costo']),2);
            }   
                     
            $costo=number_format(doubleval($row['costo']),2);
            $costoAgg=number_format(doubleval(calcolaCostoLottoNew($row['codice'])),2);
            if($costo > 0 AND ($costo!=$costoAgg)){
                
                $nomeClasse = "dataRigRed";
                $nomeTitle="";
                
            }
             if ( $rapp < 2){
                $nomeClasse = "dataRigYell";
                $nomeTitle="";
            }
            if ($row['giacenza_attuale'] > 0 AND $row['giacenza_attuale'] < $row['scorta_minima']) {
                $nomeClasse = "dataRigWhite";
                $nomeTitle = $msgInfoRiordinoLotti;
            }
            ?>
            <tr>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid1 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['codice'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid2 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['descri']?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid3 ?>"><?php echo $costo. " " . $filtroEuro ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid4 ?>"><?php echo $costoAgg . " " . $filtroEuro ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid5 ?>"><input style="width:70px" class="<?php echo $nomeClasse; ?>" type="text" name="QtaList<?php echo($i); ?>" id="QtaList<?php echo($i); ?>" value="<?php echo number_format($row['listino'],2,'.','') ?>" ><?php echo $filtroEuro ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid6 ?>"><input style="width:70px" class="<?php echo $nomeClasse; ?>" type="text" name="QtaInv<?php echo($i); ?>" id="QtaInv<?php echo($i); ?>" value="<?php echo $row['giacenza_attuale'] ?>" ><?php echo $row['uni_mis'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid7 ?>"><input style="width:50px" class="<?php echo $nomeClasse; ?>" type="text" name="QtaScorta<?php echo($i); ?>" id="QtaScorta<?php echo($i); ?>" value="<?php echo($row['scorta_minima']) ?>" ><?php echo $filtroPz ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid8 ?>"><?php echo $row['dt_abilitato'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid9 ?>" title="<?php echo $titleRappListCosto ?>"> <?php echo $rapp ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid10 ?>" title="<?php echo $titleDiffListCosto ?>"> <?php echo $diff ?></td>
             <!--  <td class="<?php echo $nomeClasse; ?>" width="10px" title="<?php echo $titleNumLottiVenduti ?>"><b> <?php // echo  $row['venduti']." ".$filtroPz ?></b></td>-->
 <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid10 ?>" title="<?php echo $titleNumLottiVenduti ?>"><b> <?php echo  " "?></b></td>
            </tr>
            <?php
            $i++;
        }
        ?>
        <tr>
            <td class="cella2" style="text-align: right; " colspan="11">
                <input type="submit" name="submit1" onClick="AggiornaCostoLotti()" title ="<?php echo $titleAggiornaCostoLotti ?>" value="<?php echo $valueButtonAggiornaCostoLotti ?>" />
                <input type="submit" name="submit2" onClick="AggiornaListino()" title ="<?php echo $titleAggiornaListinoLotti ?>" value="<?php echo $valueButtonAggiornaListinoLotti ?>" />
                <input type="submit" name="submit3" onClick="SalvaListino()" title ="<?php echo $titleSalvaListino ?>" value="<?php echo $valueButtonSalvaListino ?>" />
                <input type="submit" name="submit4" onClick="SalvaGiacenza()" title ="<?php echo $titleSalvaGiac ?>" value="<?php echo $valueButtonSalvaGiac ?>" />
                <input type="submit" name="submit5" onClick="SalvaScortaMinima()" title ="<?php echo $titleSalvaScortaMinima ?>" value="<?php echo $valueButtonSalvaScortaMinima ?>" />


        </tr >

    </table>
</form>
