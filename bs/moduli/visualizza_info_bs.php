<?php
$wid1 = "15%"; //Cliente
$wid2 = "2%"; // venduto
$wid3 = "7%"; // costi variabili
$wid4 = "7%"; // ricavi 
$wid5 = "7%"; // primo margine
$wid6 = "7%"; // altro spese
$wid7 = "7%"; // secondo margine
$wid8 = "7%"; // costi amm impianto
$wid9 = "7"; // costi amm investimenti
$wid10 = "7%"; // ebita
$wid11 = "5%"; // saturazione impianto
$wid12 = "2%"; // anno
$wid13 = "10%"; // operazioni
$wid14 = "2%"; // ultimo cambio
$wid15 = "2%"; // username
?>
<form  name="VediBSRiepilogo" id="VediBSRiepilogo" action="" method="POST" onsubmit="return controllaCampi(arrayMsgErrJs)">
    <?php include('../include/scelta_valuta.php'); ?>
    <div style="float:right;" >
        <?php echo $filtroTassoCambio ?>
        <input type="text" id="Cambio" name="Cambio" title="<?php echo $titleTassoCambio ?>" style="text-align:right;width:50px"  value="<?php echo $_SESSION['cambio'] ?>" onkeypress="BloccaTastoInvio(event)" onchange="AlertValuta()"/>

    </div>
    <table class="table3">
        <tr>
            <th colspan="15"><?php echo $titoloPaginaSimulazioni ?></th>
        </tr>
        <tr>
            <td colspan="15" style="text-align:center;"> 
                <p><a name="129" href="carica_bs.php?TODO_bs=NEW"><?php echo $nuovaSimulazione ?></a></p>
                <p>&nbsp;</p>
            </td>
        </tr>
    </table>

    <table class="table3" style="width:110%">
        <tr>
            <td><input style="width:100%" type="text" name="Nominativo" value="<?php echo $_SESSION['Nominativo'] ?>"/></td>
            <td><input style="width:100%" type="text" name="Anno" value="<?php echo $_SESSION['Anno'] ?>"/></td>
            <td ><img src="/CloudFab/images/icone/lente_piccola.png" onClick="document.forms['VediBSRiepilogo'].submit();" title="<?php echo $titleRicerca ?>"/></td>
        </tr>


        <!--################## RICERCA CON LIST BOX ###############################-->
        <tr>
            <td><select style="width:100%" name="NominativoList" id="NominativoList" onChange="document.forms['VediBSRiepilogo'].submit();">
                    <option value="<?php echo $_SESSION['NominativoList'] ?>" selected="<?php echo $_SESSION['NominativoList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlNomi)) {
                        ?>
                        <option value="<?php echo $row['nominativo']; ?>"><?php echo $row['nominativo']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%"  name="AnnoList" id="AnnoList" onChange="document.forms['VediBSRiepilogo'].submit();">
                    <option value="<?php echo $_SESSION['AnnoList'] ?>" selected="<?php echo $_SESSION['AnnoList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlAnno)) {
                        ?>
                        <option value="<?php echo $row['anno']; ?>"><?php echo $row['anno']; ?></option>
                    <?php } ?>
                </select></td>


            <td colspan="3"><?php echo $titleFiltraClienteAnno ?></td>
        </tr>
        <!--################## ORDINAMENTO ########################################-->
        <tr>              

            <td class="cella3" width="<?php echo $wid1 ?>"><div id="Ordina1"><?php echo $filtroCliente; ?>
                    <button name="Filtro" type="submit" value="nominativo,anno" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid12 ?>" ><div id="Ordina12"><?php echo $filtroAnno; ?>
                    <button name="Filtro" type="submit" value="anno,nominativo" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid2 ?>"><div id="Ordina2"><?php echo $filtroVenduto; ?>
                    <button name="Filtro" type="submit" value="venduto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button>
                </div>
            </td>
            <td class="cella3" width="<?php echo $wid3 ?>" title="<?php echo $titleCostiVariabili ?>"><div id="Ordina3"><?php echo $filtroCostiVariabili ?>
                    <button name="Filtro" type="submit" value="costi_variabili" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid4 ?>" title="<?php echo $titleRicavi ?>"><div id="Ordina4"><?php echo $filtroRicavi ?>
                    <button name="Filtro" type="submit" value="ricavi" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid5 ?>" title="<?php echo $titlePrimoMargine ?>"><div id="Ordina5"><?php echo $filtroPrimoMargine ?>
                    <button name="Filtro" type="submit" value="primo_margine" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid6 ?>" title="<?php echo $titleAltreSpese ?>"><div id="Ordina6"><?php echo $filtroAltreSpese; ?>
                    <button name="Filtro" type="submit" value="altre_spese" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid7 ?>" title="<?php echo $titleSecondoMargine ?>"><div id="Ordina7"><?php echo $filtroSecondoMargine; ?>
                    <button name="Filtro" type="submit" value="secondo_margine" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid8 ?>" title="<?php echo $titleCostiAmmImpianto ?>"><div id="Ordina8"><?php echo $filtroCostiAmmImpianto; ?>
                    <button name="Filtro" type="submit" value="costi_amm_impianto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid9 ?>" title="<?php echo $titleCostiAmmInvestimento ?>"><div id="Ordina9"><?php echo $filtroCostiAmmInvestimenti; ?>
                    <button name="Filtro" type="submit" value="costi_amm_inv" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid10 ?>" title="<?php echo $titleEbita ?>"><div id="Ordina10"><?php echo $filtroEbita; ?>
                    <button name="Filtro" type="submit" value="ebita" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid11 ?>" ><div id="Ordina11"><?php echo $filtroSaturazioneImpianto; ?>
                    <button name="Filtro" type="submit" value="saturazione_impianto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid14 ?>" ><div id="Ordina14"><?php echo $filtroUltimoTasso; ?>
                    <button name="Filtro" type="submit" value="cambio" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid15 ?>" ><div id="Ordina14"><?php echo $filtroUtente; ?>
                    <button name="Filtro" type="submit" value="username" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>


            <td class="cella3" style="width: <?php echo $wid13 ?>"><?php echo $filtroOperazioni; ?></td>

        </tr>



        <?php
        $totaleVenduto = 0;
        $totaleCostiVar = 0;
        $totaleRicavi = 0;
        $totalePrimoMargine = 0;
        $totaleCostiAmmImp = 0;
        $totaleCostiAmmInv = 0;
        $totaleSecMargine = 0;
        $totaleAltreSpese = 0;
        $totaleEbita = 0;
        while ($row = mysql_fetch_array($sql)) {
            $totaleVenduto = $totaleVenduto + $row['venduto'];
            $totaleCostiVar = $totaleCostiVar + $row['costi_variabili'];
            $totaleRicavi = $totaleRicavi + $row['ricavi'];
            $totalePrimoMargine = $totalePrimoMargine + $row['primo_margine'];
            $totaleCostiAmmImp = $totaleCostiAmmImp + $row['costi_amm_impianto'];
            $totaleCostiAmmInv = $totaleCostiAmmInv + $row['costi_amm_inv'];
            $totaleSecMargine = $totaleSecMargine + $row['secondo_margine'];
            $totaleAltreSpese = $totaleAltreSpese + $row['altre_spese'];
            $totaleEbita = $totaleEbita + $row['ebita'];
            $saturazioneImpianto = $row['saturazione_impianto'];
            ?>
            <tr>
                <td class="cella1" style="width:<?php echo $wid1 ?>"><?php echo($row['nominativo']) ?></td>
                <td class="cella1Right" style="width:<?php echo $wid12 ?>"><?php echo $row['anno'] ?></td>
                <td class="cella1Right" style="width:<?php echo $wid2 ?>"><?php echo number_format($row['venduto'], '0', ',', '.') . " t" ?></td>
                <td class="cella1Right" style="width:<?php echo $wid3 ?>"><?php echo number_format($row['costi_variabili'] * $_SESSION['cambio'], '0', ',', '.') . " " . $filtroValuta ?></td>
                <td class="cella1Right" style="width:<?php echo $wid4 ?>"><?php echo number_format($row['ricavi'] * $_SESSION['cambio'], '0', ',', '.') . " " . $filtroValuta ?></td>
                <td class="cella1Right" style="width:<?php echo $wid5 ?>"><?php echo number_format($row['primo_margine'] * $_SESSION['cambio'], '0', ',', '.') . " " . $filtroValuta ?></td>
                <td class="cella1Right" style="width:<?php echo $wid6 ?>"><?php echo number_format($row['altre_spese'] * $_SESSION['cambio'], '0', ',', '.') . " " . $filtroValuta ?></td>
                <td class="cella1Right" style="width:<?php echo $wid7 ?>"><?php echo number_format($row['secondo_margine'] * $_SESSION['cambio'], '0', ',', '.') . " " . $filtroValuta ?></td>
                <td class="cella1Right" style="width:<?php echo $wid8 ?>"><?php echo number_format($row['costi_amm_impianto'] * $_SESSION['cambio'], '0', ',', '.') . " " . $filtroValuta ?></td>
                <td class="cella1Right" style="width:<?php echo $wid9 ?>"><?php echo number_format($row['costi_amm_inv'] * $_SESSION['cambio'], '0', ',', '.') . " " . $filtroValuta ?></td>
                <td class="cella1Right" style="width:<?php echo $wid10 ?>"><?php echo number_format($row['ebita'] * $_SESSION['cambio'], '0', ',', '.') . " " . $filtroValuta ?></td>
                <td class="cella1Right" style="width:<?php echo $wid11 ?>"><?php echo number_format($row['saturazione_impianto'], '2', ',', '.') . " " . $filtroPerc ?></td>
                <td class="cella1Right" style="width:<?php echo $wid14 ?>"><?php echo number_format($row['cambio'], '2', ',', '.')  ?></td>
                <td class="cella1Right" style="width:<?php echo $wid15 ?>"><?php echo $row['username'] ?></td>
                <td class="cella1" style="width:<?php echo $wid13 ?>">
                    <a name="130" href="carica_info_bs1.php?TODO_bs=MODIFY&IdCliente=<?php echo($row['id_cliente']) ?>&IdAzienda=<?php echo($row['id_azienda']) ?>&Anno=<?php echo $row['anno'] ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica ?>"/></a>
                    <a name="130" href="elimina_bs_simulazione.php?IdCliente=<?php echo($row['id_cliente']) ?>&Anno=<?php echo $row['anno'] ?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" title="<?php echo $titleElimina ?>"/></a>
                    <a name="130" href="carica_info_bs.php?IdCliente=<?php echo($row['id_cliente']) ?>&Anno=<?php echo $row['anno'] ?>&IdAzienda=<?php echo $row['id_azienda'] ?>&TODO_bs=MODIFY"><img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone" /></a>
                    <!--<img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone"  title="<?php echo $row['note_simulazione'] ?>"/>-->
                </td>
            </tr>
        <?php }
        ?>
        <tr>
            <td class="dataRigWhite"></td>
            <td class="dataRigWhite"></td>
            <td class="dataRigWhite" style="text-align:right"><?php echo number_format($totaleVenduto * $_SESSION['cambio'], '0', ',', '.') . " t" ?></td>
            <td class="dataRigWhite" style="text-align:right"><?php echo number_format($totaleCostiVar * $_SESSION['cambio'], '0', ',', '.') . " " . $filtroValuta ?></td>
            <td class="dataRigWhite" style="text-align:right"><?php echo number_format($totaleRicavi * $_SESSION['cambio'], '0', ',', '.') . " " . $filtroValuta ?></td>
            <td class="dataRigWhite" style="text-align:right"><?php echo number_format($totalePrimoMargine * $_SESSION['cambio'], '0', ',', '.') . " " . $filtroValuta ?></td>
            <td class="dataRigWhite" style="text-align:right"><?php echo number_format($totaleAltreSpese * $_SESSION['cambio'], '0', ',', '.') . " " . $filtroValuta ?></td>
            <td class="dataRigWhite" style="text-align:right"><?php echo number_format($totaleSecMargine * $_SESSION['cambio'], '0', ',', '.') . " " . $filtroValuta ?></td>
            <td class="dataRigWhite" style="text-align:right"><?php echo number_format($totaleCostiAmmImp * $_SESSION['cambio'], '0', ',', '.') . " " . $filtroValuta ?></td>
            <td class="dataRigWhite" style="text-align:right"><?php echo number_format($totaleCostiAmmInv * $_SESSION['cambio'], '0', ',', '.') . " " . $filtroValuta ?></td>
            <td class="dataRigWhite" style="text-align:right"><?php echo number_format($totaleEbita * $_SESSION['cambio'], '0', ',', '.') . " " . $filtroValuta ?></td>
            <td class="dataRigWhite" colspan="4"></td>

        </tr>

    </table>

</form>