<?php
    $wid0 = "5%";
    $wid1 = "15%";
    $wid2 = "8%";
    $wid3 = "8%";
    $wid4 = "8%";
    $wid5 = "10%";
    $wid6 = "25%";
    $wid7 = "5%";   
    $wid8 = "10%";
    $wid9 = "5%";   
    ?>
<table class="table3">
    <tr>
        <th colspan="8"><?php echo $titoloPaginaGestioneGazMovMag ?></th>
    </tr>
    <tr>
        <td  colspan="8" style="text-align:center;"> 
            <p><a name="146" href="carica_gaz_movmag.php"><?php echo $nuovoMovimentoMag ?></a></a></p>
            <p>&nbsp;</p>
        </td>
    </tr>
</table>
    <!--################## MOTORE DI RICERCA ###################################-->
    <form  name="VediGazMovMag" id="VediGazMovMag" action="" method="POST">
        <table class="table3">
            <tr>
                <td ><input type="text" style="width:100%" name="IdMov" value="<?php echo $_SESSION['IdMov'] ?>" /></td>
                <td ><input type="text" style="width:100%" name="Causale" value="<?php echo $_SESSION['Causale'] ?>" /></td>
                <td ><input type="text" style="width:100%" name="TipDoc"  value="<?php echo $_SESSION['TipDoc'] ?>" /></td>
                <td ><input type="text" style="width:100%" name="NumDoc"  value="<?php echo $_SESSION['NumDoc'] ?>" /></td>
                <td ><input type="text" style="width:100%" name="DtDoc"   value="<?php echo $_SESSION['DtDoc'] ?>" /></td>
                <td ><input type="text" style="width:100%" name="Artico"  value="<?php echo $_SESSION['Artico'] ?>" /></td>
                <td ><input type="text" style="width:100%" name="DescriArtico" value="<?php echo $_SESSION['DescriArtico'] ?>" /></td>
                <td ><input type="text" style="width:100%" name="Quantita"  value="<?php echo $_SESSION['Quantita'] ?>" /></td>
                <td ><input type="text" style="width:100%" name="DtMov"  value="<?php echo $_SESSION['DtMov'] ?>" /></td>
                
            </tr>
            <!--################## RICERCA CON LIST BOX ###############################-->
            <tr>
                <td><select style="width:100%" name="IdMovList" id="IdMovList" onChange="document.forms['VediGazMovMag'].submit();">
                        <option value="<?php echo $_SESSION['IdMovList'] ?>" selected="<?php echo $_SESSION['IdMovList'] ?>"></option>
                        <?php
                        while ($rowId = mysql_fetch_array($sqlIdMov)) {
                            ?>
                            <option value="<?php echo $rowId['id_mov']; ?>"><?php echo $rowId['id_mov']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select style="width:100%" name="CausaleList" id="CausaleList" onChange="document.forms['VediGazMovMag'].submit();">
                        <option value="<?php echo $_SESSION['CausaleList'] ?>" selected="<?php echo $_SESSION['CausaleList'] ?>"></option>
                        <?php
                        while ($rowCausale = mysql_fetch_array($sqlCausale)) {
                            ?>
                            <option value="<?php echo $rowCausale['causale']; ?>"><?php echo $rowCausale['causale']; ?></option>
                        <?php } ?>
                    </select></td>
                <td ><select style="width:100%" name="TipDocList" id="TipDocList" onChange="document.forms['VediGazMovMag'].submit();">
                        <option value="<?php echo $_SESSION['TipDocList'] ?>" selected="<?php echo $_SESSION['TipDocList'] ?>"></option>
                        <?php
                        while ($rowTipDoc = mysql_fetch_array($sqlTipDoc)) {
                            ?>
                            <option value="<?php echo $rowTipDoc['tip_doc']; ?>"><?php echo $rowTipDoc['tip_doc']; ?></option>
                        <?php } ?>
                    </select></td>
                <td ><select style="width:100%" name="NumDocList" id="NumDocList" onChange="document.forms['VediGazMovMag'].submit();">
                        <option value="<?php echo $_SESSION['NumDocList'] ?>" selected="<?php echo $_SESSION['NumDocList'] ?>"></option>
                        <?php
                        while ($rowNumDoc = mysql_fetch_array($sqlNumDoc)) {
                            ?>
                            <option value="<?php echo $rowNumDoc['num_doc']; ?>"><?php echo $rowNumDoc['num_doc']; ?></option>
                        <?php } ?>
                    </select></td>
                <td ><select  style="width:100%" name="DtDocList" id="DtDocList" onChange="document.forms['VediGazMovMag'].submit();">
                        <option value="<?php echo $_SESSION['DtDocList'] ?>" selected="<?php echo $_SESSION['DtDocList'] ?>"></option>
                        <?php
                        while ($rowDtDoc = mysql_fetch_array($sqlDtDoc)) {
                            ?>
                            <option value="<?php echo $rowDtDoc['dt_doc']; ?>"><?php echo $rowDtDoc['dt_doc']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select style="width:100%" name="ArticoList" id="ArticoList" onChange="document.forms['VediGazMovMag'].submit();">
                        <option value="<?php echo $_SESSION['ArticoList'] ?>" selected="<?php echo $_SESSION['ArticoList'] ?>"></option>
                        <?php
                        while ($rowArt = mysql_fetch_array($sqlArticolo)) {
                            ?>
                            <option value="<?php echo $rowArt['artico']; ?>"><?php echo $rowArt['artico']; ?></option>
                        <?php } ?>
                    </select></td>
                <td ><select  style="width:100%"  name="DescriArticoList" id="DescriArticoList" onChange="document.forms['VediGazMovMag'].submit();">
                        <option value="<?php echo $_SESSION['DescriArticoList'] ?>" selected="<?php echo $_SESSION['DescriArticoList'] ?>"></option>
                        <?php
                        while ($rowDescriArt = mysql_fetch_array($sqlDescriArt)) {
                            ?>
                            <option value="<?php echo $rowDescriArt['descri_artico']; ?>"><?php echo $rowDescriArt['descri_artico']; ?></option>
                        <?php } ?>
                    </select></td>
                <td ><select  style="width:100%"  name="QuantitaList" id="QuantitaList" onChange="document.forms['VediGazMovMag'].submit();">
                        <option value="<?php echo $_SESSION['QuantitaList'] ?>" selected="<?php echo $_SESSION['QuantitaList'] ?>"></option>
                        <?php
                        while ($rowQta = mysql_fetch_array($sqlQta)) {
                            ?>
                            <option value="<?php echo $rowQta['quanti']; ?>"><?php echo $rowQta['quanti']; ?></option>
                        <?php } ?>
                    </select></td>
                <td ><select  style="width:100%"  name="DtMovList" id="DtMovList" onChange="document.forms['VediGazMovMag'].submit();">
                        <option value="<?php echo $_SESSION['DtMovList'] ?>" selected="<?php echo $_SESSION['DtMovList'] ?>"></option>
                        <?php
                        while ($rowDtMov = mysql_fetch_array($sqlDtMov)) {
                            ?>
                            <option value="<?php echo $rowDtMov['dt_mov']; ?>"><?php echo $rowDtMov['dt_mov']; ?></option>
                        <?php } ?>
                    </select></td>
                    <td><input type="button" value="<?php echo $valueButtonCerca ?>" onClick="document.forms['VediGazMovMag'].submit();" style="width: 90px"/></td>
            </tr>

            <!--################## ORDINAMENTO ########################################-->
            <tr>   
                <td class="cella3" width="<?php echo $wid0 ?>" ><div id="OrdinaId"><?php echo $filtroIdMov; ?>
                        <button name="Filtro" type="submit" value="id_mov" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid1 ?>" ><div id="OrdinaCausale"><?php echo $filtroOperazione; ?>
                        <button name="Filtro" type="submit" value="causale" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid2 ?>"><div id="OrdinaTipDoc"><?php echo $filtroTipoDoc; ?>
                        <button name="Filtro" type="submit" value="tip_doc" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid3 ?>"><div id="OrdinaNumDoc"><?php echo $filtroNumDoc; ?>
                        <button name="Filtro" type="submit" value="num_doc" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid4 ?>"><div id="OrdinaDtDoc"><?php echo $filtroDataDoc; ?>
                        <button name="Filtro" type="submit" value="dt_doc" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid5 ?>"><div id="OrdinaArtico"><?php echo $filtroArticolo; ?>
                        <button name="Filtro" type="submit" value="artico" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid6 ?>"><div id="OrdinaDescriArtico"><?php echo $filtroDescrizione; ?>
                        <button name="Filtro" type="submit" value="descri_artico" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid7 ?>"><div id="OrdinaQuantita"><?php echo $filtroQuantita; ?>
                        <button name="Filtro" type="submit" value="quanti" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid8 ?>"><div id="OrdinaDtMov"><?php echo $filtroDt; ?>
                        <button name="Filtro" type="submit" value="dt_mov" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid9 ?>"><?php echo $filtroOperazioni; ?></td>
            </tr>
            <?php
            echo "<br/>" . $msgRecordTrovati . $trovati . "<br/>";
            echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";

            $i = 1;
            $colore = 1;
            $quantiTot=0;
            
            while ($row = mysql_fetch_array($sql)) {
                $quantiTot=$quantiTot+$row['quanti'];
                if ($colore == 1) {
                    ?>
                    <tr>
                        <td class="cella1" width="<?php echo $wid0 ?>"><?php echo($row['id_mov']) ?></td>
                        <td class="cella1" width="<?php echo $wid1 ?>"><?php echo($row['causale']) ?></td>
                        <td class="cella1" width="<?php echo $wid2 ?>"><?php echo($row['tip_doc']) ?></td>
                        <td class="cella1" width="<?php echo $wid3 ?>"><?php echo($row['num_doc']) ?></td>
                        <td class="cella1" width="<?php echo $wid4 ?>"><?php echo($row['dt_doc']) ?></td>
                        <td class="cella1" width="<?php echo $wid5 ?>"><?php echo($row['artico']) ?></td>
                        <td class="cella1" width="<?php echo $wid6 ?>"><?php echo($row['descri_artico']) ?></td>
                        <td class="cella1" style="width:'<?php echo $wid7 ?>';text-align:right"><?php echo($row['quanti'])." ".$filtroKgBreve ?></td>
                        <td class="cella1" width="<?php echo $wid8 ?>"><?php echo($row['dt_mov']) ?></td>
                        <td class="cella1" width="<?php echo $wid9 ?>">
                           <?php if($row['tip_doc']==$valTipoDocDdtAcq || $row['tip_doc']==$valTipDocProMix){?> 
                            <a href="modifica_gaz_movmag.php?IdMov=<?php echo($row['id_mov']) ?>">
                                <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone"  title="<?php echo $titleModifica ?>"/></a>
                                <a href="genera_cod_mov.php?IdMov=<?php echo $row['id_mov'] ?>&CodMat=<?php echo$row['artico'] ?>&DtDoc=<?php echo$row['dt_doc'] ?>&NomeMat=<?php echo $row['descri_artico']?>">
                                <img src="/CloudFab/images/pittogrammi/stampa_G.png" class="icone"  title="<?php echo $titleGeneraCodiceMov ?>"/></a>
                <?php } ?>
                        </td>
                    </tr>
                    <?php
                    $colore = 2;
                } else {
                    ?>
                    <tr>
                        <td class="cella2" width="<?php echo $wid0 ?>"><?php echo($row['id_mov']) ?></td>
                        <td class="cella2" width="<?php echo $wid1 ?>"><?php echo($row['causale']) ?></td>
                        <td class="cella2" width="<?php echo $wid2 ?>"><?php echo($row['tip_doc']) ?></td>
                        <td class="cella2" width="<?php echo $wid3 ?>"><?php echo($row['num_doc']) ?></td> 
                        <td class="cella2" width="<?php echo $wid4 ?>"><?php echo($row['dt_doc']) ?></td>
                        <td class="cella2" width="<?php echo $wid5 ?>"><?php echo($row['artico']) ?></td>
                        <td class="cella2" width="<?php echo $wid6 ?>"><?php echo($row['descri_artico']) ?></td>
                        <td class="cella2" style="width:'<?php echo $wid7 ?>';text-align:right"><?php echo($row['quanti']) ." ".$filtroKgBreve?></td>
                        <td class="cella2" width="<?php echo $wid8 ?>"><?php echo($row['dt_mov']) ?></td>
                        <td class="cella2" width="<?php echo $wid9 ?>">
                        <?php if($row['tip_doc']==$valTipoDocDdtAcq || $row['tip_doc']==$valTipDocProMix){?> 
                            <a href="modifica_gaz_movmag.php?IdMov=<?php echo($row['id_mov']) ?>">
                                <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone"  title="<?php echo $titleModifica ?>"/></a>
                                <a href="genera_cod_mov.php?IdMov=<?php echo $row['id_mov'] ?>&CodMat=<?php echo$row['artico'] ?>&DtDoc=<?php echo$row['dt_doc'] ?>&NomeMat=<?php echo $row['descri_artico']?>">
                                <img src="/CloudFab/images/pittogrammi/stampa_G.png" class="icone"  title="<?php echo $titleGeneraCodiceMov ?>"/></a>
                <?php } ?>
                        </td>
                    </tr>
                    <?php
                    $colore = 1;
                }
                $i = $i + 1;
            }
            ?>
                    <tr>
            <td class="dataRigYellBig" style="text-align: right; " colspan="7"></td>
            <td class="dataRigYellBig" style="text-align: right; " title="<?php  ?>"><nobr><?php echo number_format($quantiTot, '0', '.', ' ') . " " . $filtroKgBreve ?></nobr></td><!--tot inventario -->
            <td class="dataRigYellBig" style="text-align: right; " colspan="2"></td>
        </tr>
        </table>