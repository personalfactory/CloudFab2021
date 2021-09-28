<?php
$wid0 = "5%"; //IdMov
$wid1 = "5%"; //CodMateriale
$wid2 = "20%"; //DescriMateriale
$wid3 = "5%"; //TipoMateriale
$wid4 = "5%"; //Quantita
$wid5 = "5%"; //PesoTeo
$wid6 = "10%"; //CodIngresso
$wid7 = "5%"; //NumDoc   
$wid8 = "8%"; //DtDoc
$wid9 = "5%"; //TipoMov  
$wid10 = "20%"; //DescriMov   
$wid11 = "10%"; //DtMov
$wid12 = "15%";
?>
<table class="table3">
    <tr>
        <th colspan="8"><?php echo $titoloPaginaGestioneMovimentiOrigami ?></th>
    </tr>
     <tr>
        <th colspan="8"><?php echo $_SESSION['DescriStab'] ?></th>
    </tr>
    
    <tr>
        <td colspan="8" style="text-align:center;"> 
            <p><a name="143" href="carica_movimento_ori.php"><?php echo $nuovoMovimentoMag ?></a></a></p>
            <p>&nbsp;</p>
        </td>
    </tr>
</table>
<!--################## MOTORE DI RICERCA ###################################-->
<form  name="VediMovSingMacOri" id="VediMovSingMacOri" action="" method="POST">
    <table class="table3">
        <tr>
            <td ><input type="text" style="width:100%" name="IdMov" value="<?php echo $_SESSION['IdMov'] ?>" /></td>
            <td ><input type="text" style="width:100%" name="CodMateriale" value="<?php echo $_SESSION['CodMateriale'] ?>" /></td>
            <td ><input type="text" style="width:100%" name="DescriMateriale"  value="<?php echo $_SESSION['DescriMateriale'] ?>" /></td>
            <td ><input type="text" style="width:100%" name="TipoMateriale"  value="<?php echo $_SESSION['TipoMateriale'] ?>" /></td>
            <td ><input type="text" style="width:100%" name="Quantita"   value="<?php echo $_SESSION['Quantita'] ?>" /></td>
            <td ><input type="text" style="width:100%" name="PesoTeo"  value="<?php echo $_SESSION['PesoTeo'] ?>" /></td>
            <td ><input type="text" style="width:100%" name="CodIngresso" value="<?php echo $_SESSION['CodIngresso'] ?>" /></td>
            <td ><input type="text" style="width:100%" name="NumDoc"  value="<?php echo $_SESSION['NumDoc'] ?>" /></td>
            <td ><input type="text" style="width:100%" name="DtDoc"  value="<?php echo $_SESSION['DtDoc'] ?>" /></td>
            <td ><input type="text" style="width:100%" name="TipoMov" value="<?php echo $_SESSION['TipoMov'] ?>" /></td>
            <td ><input type="text" style="width:100%" name="DescriMov"  value="<?php echo $_SESSION['DescriMov'] ?>" /></td>
            <td ><input type="text" style="width:100%" name="DtMov"  value="<?php echo $_SESSION['DtMov'] ?>" /></td>
        </tr>
        <!--################## RICERCA CON LIST BOX ###############################-->
        <tr>
            <td><select style="width:100%" name="IdMovList" id="IdMovList" onChange="document.forms['VediMovSingMacOri'].submit();">
                    <option value="<?php echo $_SESSION['IdMovList'] ?>" selected="<?php echo $_SESSION['IdMovList'] ?>"></option>
                    <?php
                    while ($rowId = mysql_fetch_array($sqlIdMov)) {
                        ?>
                        <option value="<?php echo $rowId['id_mov']; ?>"><?php echo $rowId['id_mov']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select style="width:100%" name="CodMaterialeList" id="CodMaterialeList" onChange="document.forms['VediMovSingMacOri'].submit();">
                    <option value="<?php echo $_SESSION['CodMaterialeList'] ?>" selected="<?php echo $_SESSION['CodMaterialeList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlCodMat)) {
                        ?>
                        <option value="<?php echo $row['cod_componente']; ?>"><?php echo $row['cod_componente']; ?></option>
                    <?php } ?>
                </select></td>
            <td ><select style="width:100%" name="DescriMaterialeList" id="DescriMaterialeList" onChange="document.forms['VediMovSingMacOri'].submit();">
                    <option value="<?php echo $_SESSION['DescriMaterialeList'] ?>" selected="<?php echo $_SESSION['DescriMaterialeList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlDescriMat)) {
                        ?>
                        <option value="<?php echo $row['descri_componente']; ?>"><?php echo $row['descri_componente']; ?></option>
                    <?php } ?>
                </select></td>
            <td ><select style="width:100%" name="TipoMaterialeList" id="DescriMaterialeList" onChange="document.forms['VediMovSingMacOri'].submit();">
                    <option value="<?php echo $_SESSION['TipoMaterialeList'] ?>" selected="<?php echo $_SESSION['TipoMaterialeList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlTipoMat)) {
                        ?>
                        <option value="<?php echo $row['tipo_materiale']; ?>"><?php echo $row['tipo_materiale']; ?></option>
                    <?php } ?>
                </select></td>
            <td ><select  style="width:100%"  name="QuantitaList" id="QuantitaList" onChange="document.forms['VediMovSingMacOri'].submit();">
                    <option value="<?php echo $_SESSION['QuantitaList'] ?>" selected="<?php echo $_SESSION['QuantitaList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlQuanti)) {
                        ?>
                        <option value="<?php echo $row['quantita']; ?>"><?php echo $row['quantita']; ?></option>
                    <?php } ?>
                </select></td>
            <td ><select  style="width:100%"  name="PesoTeoList" id="QuantitaList" onChange="document.forms['VediMovSingMacOri'].submit();">
                    <option value="<?php echo $_SESSION['PesoTeoList'] ?>" selected="<?php echo $_SESSION['PesoTeoList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlPesoTeo)) {
                        ?>
                        <option value="<?php echo $row['peso_teorico']; ?>"><?php echo $row['peso_teorico']; ?></option>
                    <?php } ?>
                </select></td>
            <td ><select  style="width:100%"  name="CodIngressoList" id="QuantitaList" onChange="document.forms['VediMovSingMacOri'].submit();">
                    <option value="<?php echo $_SESSION['CodIngressoList'] ?>" selected="<?php echo $_SESSION['CodIngressoList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlCodIngresso)) {
                        ?>
                        <option value="<?php echo $row['cod_ingresso_comp']; ?>"><?php echo $row['cod_ingresso_comp']; ?></option>
                    <?php } ?>
                </select></td>
            <td ><select style="width:100%" name="NumDocList" id="NumDocList" onChange="document.forms['VediMovSingMacOri'].submit();">
                    <option value="<?php echo $_SESSION['NumDocList'] ?>" selected="<?php echo $_SESSION['NumDocList'] ?>"></option>
                    <?php
                    while ($rowNumDoc = mysql_fetch_array($sqlNumDoc)) {
                        ?>
                        <option value="<?php echo $rowNumDoc['num_doc']; ?>"><?php echo $rowNumDoc['num_doc']; ?></option>
                    <?php } ?>
                </select></td>
            <td ><select  style="width:100%" name="DtDocList" id="DtDocList" onChange="document.forms['VediMovSingMacOri'].submit();">
                    <option value="<?php echo $_SESSION['DtDocList'] ?>" selected="<?php echo $_SESSION['DtDocList'] ?>"></option>
                    <?php
                    while ($rowDtDoc = mysql_fetch_array($sqlDtDoc)) {
                        ?>
                        <option value="<?php echo $rowDtDoc['dt_doc']; ?>"><?php echo $rowDtDoc['dt_doc']; ?></option>
                    <?php } ?>
                </select></td>
            <td ><select  style="width:100%"  name="TipoMovList" id="TipoMovList" onChange="document.forms['VediMovSingMacOri'].submit();">
                    <option value="<?php echo $_SESSION['TipoMovList'] ?>" selected="<?php echo $_SESSION['TipoMovList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlTipoMov)) {
                        ?>
                        <option value="<?php echo $row['tipo_mov']; ?>"><?php echo $row['tipo_mov']; ?></option>
                    <?php } ?>
                </select></td>
            <td ><select  style="width:100%"  name="DescriMovList" id="TipoMovList" onChange="document.forms['VediMovSingMacOri'].submit();">
                    <option value="<?php echo $_SESSION['DescriMovList'] ?>" selected="<?php echo $_SESSION['DescriMovList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlDescriMov)) {
                        ?>
                        <option value="<?php echo $row['descri_mov']; ?>"><?php echo $row['descri_mov']; ?></option>
                    <?php } ?>
                </select></td>
            <td ><select  style="width:100%"  name="DtMovList" id="DtMovList" onChange="document.forms['VediMovSingMacOri'].submit();">
                    <option value="<?php echo $_SESSION['DtMovList'] ?>" selected="<?php echo $_SESSION['DtMovList'] ?>"></option>
                    <?php
                    while ($rowDtMov = mysql_fetch_array($sqlDtMov)) {
                        ?>
                        <option value="<?php echo $rowDtMov['dt_mov']; ?>"><?php echo $rowDtMov['dt_mov']; ?></option>
                    <?php } ?>
                </select></td>
            <td><input type="button" value="<?php echo $valueButtonCerca ?>" onClick="document.forms['VediMovSingMacOri'].submit();" style="width: 90px"/></td>
        </tr>
        <!--###################################### ORDINAMENTO ########################################-->
        <tr>   
            <td class="cella3" width="<?php echo $wid0 ?>" ><div id="OrdinaId"><?php echo $filtroIdMov; ?>
                    <button name="Filtro" type="submit" value="id_mov_inephos" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid1 ?>" ><div id="OrdinaCodMateriale"><?php echo $filtroCodice; ?>
                    <button name="Filtro" type="submit" value="cod_componente" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid2 ?>"><div id="OrdinaDescriMateriale"><?php echo $filtroDescrizione; ?>
                    <button name="Filtro" type="submit" value="descri_componente" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid3 ?>"><div id="OrdinaTipoMat"><?php echo $filtroTipo; ?>
                    <button name="Filtro" type="submit" value="tipo_materiale" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid4 ?>"><div id="OrdinaQuantita"><?php echo $filtroQuantita; ?>
                    <button name="Filtro" type="submit" value="quantita" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid5 ?>"><div id="OrdinaPesoTeo"><?php echo $filtroPesoTeo; ?>
                    <button name="Filtro" type="submit" value="peso_teorico" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>2017-12
            <td class="cella3" width="<?php echo $wid6 ?>"><div id="OrdinaCodIngresso"><?php echo $filtroCodMov; ?>
                    <button name="Filtro" type="submit" value="cod_ingresso_comp" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid7 ?>"><div id="OrdinaNumDoc"><?php echo $filtroNumDoc; ?>
                    <button name="Filtro" type="submit" value="num_doc" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid8 ?>"><div id="OrdinaDtDoc"><?php echo $filtroDataDoc; ?>
                    <button name="Filtro" type="submit" value="dt_doc" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid9 ?>"><div id="OrdinaTipoMov"><?php echo $filtroTipoMovimento; ?>
                    <button name="Filtro" type="submit" value="tipo_mov" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid10 ?>"><div id="OrdinaDescriMov"><?php echo $filtroDescriMovimento; ?>
                    <button name="Filtro" type="submit" value="descri_mov" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid11 ?>"><div id="OrdinaDtMov"><?php echo $filtroDataMov; ?>
                    <button name="Filtro" type="submit" value="dt_mov" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid12 ?>"><?php echo $filtroOperazioni; ?></td>
        </tr>
        <?php
        echo "<br/>" . $msgRecordTrovati . $trovati . "<br/>";
        echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";

        $i = 1;
        $colore = 1;
        $quantiTot = 0;

        while ($row = mysql_fetch_array($sql)) {
            $quantiTot = $quantiTot + $row['quantita']*$row['operazione'];

            $arrayCicli = array();

            //TO DO : selezionare tutti gli id_ciclo associati al cod_ingresso_com 
            //inserirli in un array e passarli alla pagina di gestione dei processi
            $sqlCicli = findCicliByMacCodCompPeso($row['id_macchina'], $row['cod_ingresso_comp']);
            $c = 0;
            while ($rowCiclo = mysql_fetch_array($sqlCicli)) {

                $arrayCicli[$c] = $rowCiclo['id_ciclo'];
                $c++;
            }
            $stringaCicli = "(0)";
            if (count($arrayCicli) > 0) {
                $stringaCicli = "(";
            
            for ($s = 0; $s < count($arrayCicli); $s++) {
                if ($s > 0) {
                    $stringaCicli .= " , ";
                }
                $stringaCicli .= $arrayCicli[$s];
            }

            $stringaCicli .= ")";
        }


        if ($colore == 1) {
            ?>
            <tr>
            <td class="cella1" width="<?php echo $wid0 ?>"><?php echo($row['id_mov_inephos']) ?></td>
            <td class="cella1" width="<?php echo $wid1 ?>"><?php echo($row['cod_componente']) ?></td>
            <td class="cella1" width="<?php echo $wid2 ?>"><?php echo($row['descri_componente']) ?></td>
            <td class="cella1" width="<?php echo $wid3 ?>"><?php echo($row['tipo_materiale']) ?></td>
            <td class="cella1" width="<?php echo $wid4 ?>"><nobr><?php echo($row['quantita']) . " " . $filtrogBreve ?></nobr></td>
            <td class="cella1" width="<?php echo $wid5 ?>"><nobr><?php echo($row['peso_teorico']) . " " . $filtrogBreve ?></nobr></td>
            <td class="cella1" width="<?php echo $wid6 ?>"><?php echo($row['cod_ingresso_comp']) ?></td>
            <td class="cella1" width="<?php echo $wid7 ?>"><?php echo($row['num_doc']) ?></td>
            <td class="cella1" width="<?php echo $wid8 ?>"><?php echo($row['dt_doc']) ?></td>               
            <td class="cella1" width="<?php echo $wid9 ?>"><nobr><?php echo($row['tipo_mov']) ?></nobr></td>
            <td class="cella1" width="<?php echo $wid10 ?>"><?php echo($row['descri_mov']) ?></td>
            <td class="cella1" width="<?php echo $wid11 ?>"><?php echo($row['dt_mov']) ?></td>
            <td class="cella1" width="<?php echo $wid12 ?>">
            <nobr>
                <a name="143" href="disabilita_record.php?Tabella=movimento_sing_mac&IdRecord=<?php echo $row['id_mov_inephos'] ?>&RefBack=gestione_movimento_sing_mac.php">
                    <img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone"  title="<?php echo $titleElimina ?>"/></a>
                <a href="../produzionechimica/dettaglio_movimento_sing_mac.php?IdMovInephos=<?php echo $row['id_mov_inephos'] ?>">
                    <img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone"  title="<?php echo $titleDettaglio ?>"/></a>

                
<?php if ($row['descri_mov']== $strDescriMovLoadPurchase) { ?>
                <a target="_blank" href="genera_cod_movimento_silos.php?CodiceIngressoComp=<?php echo $row['cod_ingresso_comp'] ?>&NomeComp=<?php echo $row['descri_componente'] ?>">
                    <img src="/CloudFab/images/pittogrammi/stampa_G.png" class="icone"  title="<?php echo $titleGeneraCodiceMov ?>"/></a>
                   <?php } 
                   if (count($arrayCicli) > 0) { ?>       
                    <a href="../stabilimenti/gestione_processo.php?IdMacchina=<?php echo($row['id_macchina']) ?>&DescriStab=<?php echo $_SESSION['DescriStab'] ?>&Filtro=id_processo&strCicli=<?php echo $stringaCicli ?>">
                        <img src="/CloudFab/images/pittogrammi/insacco_G.png" class="icone"  title="<?php echo $titleVediProc ?>"/></a>
    <?php } ?>
              
            </nobr> 
    </td>
            </td>
            </tr>
    <?php
    $colore = 2;
} else {
    ?>
            <tr>
                <td class="cella1" width="<?php echo $wid0 ?>"><?php echo($row['id_mov_inephos']) ?></td>
                <td class="cella1" width="<?php echo $wid1 ?>"><?php echo($row['cod_componente']) ?></td>
                <td class="cella1" width="<?php echo $wid2 ?>"><?php echo($row['descri_componente']) ?></td>
                <td class="cella1" width="<?php echo $wid3 ?>"><?php echo($row['tipo_materiale']) ?></td>
                <td class="cella1" width="<?php echo $wid4 ?>"><nobr><?php echo($row['quantita']) . " " . $filtrogBreve ?></nobr></td>
                <td class="cella1" width="<?php echo $wid5 ?>"><nobr><?php echo($row['peso_teorico']) . " " . $filtrogBreve ?></nobr></td>
                <td class="cella1" width="<?php echo $wid6 ?>"><?php echo($row['cod_ingresso_comp']) ?></td>
                <td class="cella1" width="<?php echo $wid7 ?>"><?php echo($row['num_doc']) ?></td>
                <td class="cella1" width="<?php echo $wid8 ?>"><?php echo($row['dt_doc']) ?></td>               
                <td class="cella1" width="<?php echo $wid9 ?>"><nobr><?php echo($row['tipo_mov']) ?></nobr></td>
                <td class="cella1" width="<?php echo $wid10 ?>"><?php echo($row['descri_mov']) ?></td>
                <td class="cella1" width="<?php echo $wid11 ?>"><?php echo($row['dt_mov']) ?></td>
                <td class="cella1" width="<?php echo $wid12 ?>">
            <nobr> 
                <a name="143" href="disabilita_record.php?Tabella=movimento_sing_mac&IdRecord=<?php echo $row['id_mov_inephos'] ?>&RefBack=gestione_movimento_sing_mac.php">
                    <img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone"  title="<?php echo $titleElimina ?>"/></a>
                <a href="../produzionechimica/dettaglio_movimento_sing_mac.php?IdMovInephos=<?php echo $row['id_mov_inephos']  ?>">
                    <img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone"  title="<?php echo $titleDettaglio ?>"/></a>

              <?php if ($row['descri_mov']== $strDescriMovLoadPurchase) { ?>  
                <a target="_blank" href="genera_cod_movimento_silos.php?CodiceIngressoComp=<?php echo $row['cod_ingresso_comp'] ?>&NomeComp=<?php echo $row['descri_componente'] ?>">
                    <img src="/CloudFab/images/pittogrammi/stampa_G.png" class="icone"  title="<?php echo $titleGeneraCodiceMov ?>"/></a>
 <?php } 
 if (count($arrayCicli) > 0) { ?>       
                    <a href="../stabilimenti/gestione_processo.php?IdMacchina=<?php echo($row['id_macchina']) ?>&DescriStab=<?php echo $_SESSION['DescriStab'] ?>&Filtro=id_processo&strCicli=<?php echo $stringaCicli ?>">
                        <img src="/CloudFab/images/pittogrammi/insacco_G.png" class="icone"  title="<?php echo $titleVediProc ?>"/>
                    </a>
    <?php } ?>               
            </nobr></td>
            </tr>
    <?php
    $colore = 1;
}
$i = $i + 1;
}
?>
        <tr>
            <td class="dataRigYellBig" style="text-align: right; " colspan="4"></td>
            <td class="dataRigYellBig" style="text-align: right; " title="<?php ?>"><nobr><?php echo number_format($quantiTot / 1000, '0', '.', ' ') . " " . $filtroKgBreve ?></nobr></td><!--tot inventario -->
            <td class="dataRigYellBig" style="text-align: right; " colspan="8"></td>
        </tr>
    </table>
</form>