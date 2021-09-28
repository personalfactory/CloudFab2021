<?php $arrayMsgErrPhp = array($msgErrQtaNumerica); ?>
<!--<table>
    <tr>
        <td  class="dataRigWhite"><?php echo $msgInfoRiordinoLotti ?></td>
    </tr>
</table>-->
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
</script>
<table class="table3">
    <tr>
        <th colspan="6"><?php echo $titoloPaginaMatPrime ?></th>
    </tr>
    <tr>
        <td colspan="6" style="text-align:center;"> 
            <a href="carica_materia.php"><?php echo $nuovaMatPrima ?></a>&nbsp;&nbsp;
           
            <a href="gestione_mov_magazzino.php"><?php echo $filtroCodiciMov ?></a>
        </td>
    </tr>
</table>
<!--################## MOTORE DI RICERCA ###################################-->
<form  name="VediMatPri" id="VediMatPri"  method="POST" onsubmit="return controllaCampi(arrayMsgErrJs)">
    <table class="table3">
        <tr>
            <td><input style="width:110px" type="text" name="Famiglia" value="<?php echo $_SESSION['Famiglia'] ?>" /></td>
            <td><input style="width:110px" type="text" name="Codice" value="<?php echo $_SESSION['Codice'] ?>" /></td>
            <td><input style="width:294px" type="text" name="Descri" value="<?php echo $_SESSION['Descri'] ?>" /></td>
            <td><input style="width:122px" type="text" name="PreAcq" value="<?php echo $_SESSION['PreAcq'] ?>" /></td>
            <td><input style="width:140px" type="text" name="Giacenza" value="<?php echo $_SESSION['Giacenza'] ?>" /></td>
            <td><input style="width:110px" type="text" name="ScortaMinima" value="<?php echo $_SESSION['ScortaMinima'] ?>" /></td>
            <td><input style="width:142px" type="text" name="DtAbilitato" value="<?php echo $_SESSION['DtAbilitato'] ?>" /></td>

        </tr>
        <!--################## RICERCA CON LIST BOX ###############################-->
        <tr>
            <td>
                <select style="width:110px" name="FamigliaList" id="FamigliaList" onChange="AggiornaScript()">
                    <option value="<?php echo $_SESSION['FamigliaList'] ?>" selected="<?php echo $_SESSION['FamigliaList'] ?>"></option>
                    <?php
                    while ($rowFamiglia = mysql_fetch_array($sqlFamiglia)) {
                        ?>
                        <option value="<?php echo $rowFamiglia['famiglia']; ?>"><?php echo $rowFamiglia['famiglia']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:110px" name="CodiceList" id="CodiceList" onChange="AggiornaScript()">
                    <option value="<?php echo $_SESSION['CodiceList'] ?>" selected="<?php echo $_SESSION['CodiceList'] ?>"></option>
                    <?php
                    while ($rowCodice = mysql_fetch_array($sqlCodice)) {
                        ?>
                        <option value="<?php echo $rowCodice['cod_mat']; ?>"><?php echo $rowCodice['cod_mat']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select style="width:294px" name="DescriList" id="DescriList" onChange="AggiornaScript()">
                    <option value="<?php echo $_SESSION['DescriList'] ?>" selected="<?php echo $_SESSION['DescriList'] ?>"></option>
                    <?php
                    while ($rowDescri = mysql_fetch_array($sqlDescri)) {
                        ?>
                        <option value="<?php echo $rowDescri['descri_mat']; ?>"><?php echo $rowDescri['descri_mat']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select style="width:122px" name="PreAcqList" id="PreAcqList" onChange="AggiornaScript()">
                    <option value="<?php echo $_SESSION['PreAcqList'] ?>" selected="<?php echo $_SESSION['PreAcqList'] ?>"></option>
                    <?php
                    while ($rowPreAcq = mysql_fetch_array($sqlPreAcq)) {
                        ?>
                        <option value="<?php echo $rowPreAcq['pre_acq']; ?>"><?php echo $rowPreAcq['pre_acq']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select style="width:140px" name="GiacenzaList" id="GiacenzaList" onChange="AggiornaScript()">
                    <option value="<?php echo $_SESSION['GiacenzaList'] ?>" selected="<?php echo $_SESSION['GiacenzaList'] ?>"></option>
                    <?php
                    while ($rowGiac = mysql_fetch_array($sqlGiac)) {
                        ?>
                        <option value="<?php echo $rowGiac['giacenza_attuale']; ?>"><?php echo $rowGiac['giacenza_attuale']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:110px" name="ScortaMinimaList" id="ScortaMinimaList" onChange="AggiornaScript()">
                    <option value="<?php echo $_SESSION['ScortaMinimaList'] ?>" selected="<?php echo $_SESSION['ScortaMinimaList'] ?>"></option>
                    <?php
                    while ($rowScortaMinima = mysql_fetch_array($sqlScortaMinima)) {
                        ?>
                        <option value="<?php echo $rowScortaMinima['scorta_minima']; ?>"><?php echo $rowScortaMinima['scorta_minima']; ?></option>
                    <?php } ?>
                </select></td>


            <td><select  style="width:142px"  name="DtAbilitatoList" id="DtAbilitatoList" onChange="AggiornaScript()">
                    <option value="<?php echo $_SESSION['DtAbilitatoList'] ?>" selected="<?php echo $_SESSION['DtAbilitatoList'] ?>"></option>
                    <?php
                    while ($rowDtAbil = mysql_fetch_array($sqlDtAbil)) {
                        ?>
                        <option value="<?php echo $rowDtAbil['dt_abilitato']; ?>"><?php echo $rowDtAbil['dt_abilitato']; ?></option>
                    <?php } ?>
                </select></td>
            <td ><input type="button" value="<?php echo $valueButtonCerca ?>" onClick="document.forms['VediMatPri'].submit();" style="width: 80px"/></td>
        </tr>
        <!--################## ORDINAMENTO ########################################-->
        <tr>              
            <td class="cella3" width="110px"><div id="OrdinaFamiglia"><?php echo $filtroFamiglia; ?>
                    <button name="Filtro" type="submit" value="famiglia" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="110px"><div id="OrdinaCodice"><?php echo $filtroCodice; ?>
                    <button name="Filtro" type="submit" value="cod_mat" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="294px"><div id="OrdinaDescri"><?php echo $filtroDescrizione; ?>
                    <button name="Filtro" type="submit" value="descri_mat" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="122px"><div id="OrdinaPreAcq"><?php echo $filtroPrezzoAcq; ?>
                    <button name="Filtro" type="submit" value="pre_acq" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="140px"><div id="OrdinaGiacenza"><?php echo $filtroGiacenza; ?>
                    <button name="Filtro" type="submit" value="giacenza_attuale" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="110px"><div id="OrdinaScortaMinima"><?php echo $filtroScortaMinima; ?>
                    <button name="Filtro" type="submit" value="scorta_minima" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="142px"><div id="OrdinaDtabil"><?php echo $filtroDt; ?>
                    <button name="Filtro" type="submit" value="dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="80px"><?php echo $filtroOperazioni; ?></td>
        </tr>
        
         <li class='dataRigLightGray' ><?php echo $msgNumMateriePrime  ?><font color="#A00028"><?php echo $trovati?></font></li>
        <li class='dataRigLightGray' ><?php echo $msgTotConsumo ?><font color="#A00028"><?php echo number_format($Consumo , $PrecisioneQta, '.', ' ') . "  " . $filtroKgBreve ?></font></li>
        
       <?php
         echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";


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
            ?>
            <tr>
                <td class="<?php echo $nomeClasse; ?>" width="110px"><?php echo($row['famiglia']) ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="110px" title="<?php echo $nomeTitle ?>"><?php echo($row['cod_mat']) ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="294px" title="<?php echo $nomeTitle ?>"><?php echo($row['descri_mat']) ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="122px"><?php echo($row['pre_acq']) . " " . $filtroEuro ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="120px"><input style="width:90px" class="<?php echo $nomeClasse ?>" type="text" name="QtaInv<?php echo($i); ?>" id="QtaInv<?php echo($i); ?>" value="<?php echo $row['giacenza_attuale'] ?>" ><?php echo $row['uni_mis'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="110px"><input style="width:70px" class="<?php echo $nomeClasse ?>" type="text" name="QtaScorta<?php echo($i); ?>" id="QtaScorta<?php echo($i); ?>" value="<?php echo($row['scorta_minima']) ?>" ><?php echo $filtroPz ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="142px"><?php echo($row['dt_abilitato']) ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="80px">
                    <a href="modifica_materia_prima.php?Codice=<?php echo($row['cod_mat']) ?>">
                        <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="<?php echo $titleModifica ?>" title="<?php echo $titleModifica ?>"/>
                    </a>
                </td>
            </tr>

            <?php
            $i++;
        }
        ?>

        <tr>
            <td class="cella2" style="text-align: right; " colspan="8">
                <input type="submit" name="submit1" onClick="SalvaGiacenza()" title ="<?php echo $titleSalvaGiac ?>" value="<?php echo $valueButtonSalvaGiac ?>" />
                <input type="submit" name="submit2" onClick="SalvaScortaMinima()" title ="<?php echo $titleSalvaScortaMinima ?>" value="<?php echo $valueButtonSalvaScortaMinima ?>" />

        </tr >
    </table>
