<?php
    $wid1 = "10%";
    $wid2 = "10%";
    $wid3 = "30%";
    $wid4 = "15%";
    $wid5 = "15%";
    $wid6 = "15%";
    $wid7 = "5%";    
    ?>
<table class="table3">
    <tr>
        <th colspan="7"><?php echo $titoloPaginaGestioneMiscele ?></th>
    </tr>
    <!--################## MOTORE DI RICERCA ###################################-->
</table>
<form  name="VediMiscela" id="VediMiscela" action="" method="POST">
    <table class="table3">
        <tr>
            <td><input style="width:100%" type="text" name="IdMiscela" value="<?php echo $_SESSION['IdMiscela'] ?>" /></td>
            <td><input style="width:100%" type="text" name="CodFormula" value="<?php echo $_SESSION['CodFormula'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Descrizione" value="<?php echo $_SESSION['Descrizione'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Contenitore" value="<?php echo $_SESSION['Contenitore'] ?>" /></td>
            <td><input style="width:100%" type="text" name="PesoReale" value="<?php echo $_SESSION['PesoReale'] ?>" /></td>
            <td><input style="width:100%" type="text" name="DtMiscela" value="<?php echo $_SESSION['DtMiscela'] ?>" /></td>
        </tr>

        <!--################## RICERCA CON LIST BOX ###############################-->
        <tr>
            <td><select style="width:100%" name="IdMiscelaList" id="IdMiscelaList" onChange="document.forms['VediMiscela'].submit();">
                    <option value="<?php echo $_SESSION['IdMiscelaList'] ?>" selected="<?php echo $_SESSION['IdMiscelaList'] ?>"></option>
                    <?php
                    while ($rowMisc = mysql_fetch_array($sqlId)) {
                        ?>
                        <option value="<?php echo $rowMisc['id_miscela']; ?>"><?php echo $rowMisc['id_miscela']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%"  name="CodFormulaList" id="CodFormulaList" onChange="document.forms['VediMiscela'].submit();">
                    <option value="<?php echo $_SESSION['CodFormulaList'] ?>" selected="<?php echo $_SESSION['CodFormulaList'] ?>"></option>
                    <?php
                    while ($rowCod = mysql_fetch_array($sqlCodFor)) {
                        ?>
                        <option value="<?php echo $rowCod['cod_formula']; ?>"><?php echo $rowCod['cod_formula']; ?></option>
                    <?php } ?>
                </select></td> 
            <td><select  style="width:100%"  name="DescrizioneList" id="DescrizioneList" onChange="document.forms['VediMiscela'].submit();">
                    <option value="<?php echo $_SESSION['DescrizioneList'] ?>" selected="<?php echo $_SESSION['DescrizioneList'] ?>"></option>
                    <?php
                    while ($rowDescri = mysql_fetch_array($sqlDescri)) {
                        ?>
                        <option value="<?php echo $rowDescri['descri_formula']; ?>"><?php echo $rowDescri['descri_formula']; ?></option>
                    <?php } ?>
                </select></td> 
            <td><select  style="width:100%" name="ContenitoreList" id="ContenitoreList" onChange="document.forms['VediMiscela'].submit();">
                    <option value="<?php echo $_SESSION['ContenitoreList'] ?>" selected="<?php echo $_SESSION['ContenitoreList'] ?>"></option>
                    <?php
                    while ($rowCont = mysql_fetch_array($sqlCont)) {
                        ?>
                        <option value="<?php echo $rowCont['cod_contenitore']; ?>"><?php echo $rowCont['cod_contenitore']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%"  name="PesoRealeList" id="PesoRealeList" onChange="document.forms['VediMiscela'].submit();">
                    <option value="<?php echo $_SESSION['PesoRealeList'] ?>" selected="<?php echo $_SESSION['PesoRealeList'] ?>"></option>
                    <?php
                    while ($rowPeso = mysql_fetch_array($sqlPeso)) {
                        ?>
                        <option value="<?php echo $rowPeso['peso_reale']; ?>"><?php echo $rowPeso['peso_reale']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select style="width:100%" name="DtMiscelaList" id="DtMiscelaList" onChange="document.forms['VediMiscela'].submit();">
                    <option value="<?php echo $_SESSION['DtMiscelaList'] ?>" selected="<?php echo $_SESSION['DtMiscelaList'] ?>"></option>
                    <?php
                    while ($rowData = mysql_fetch_array($sqlDt)) {
                        ?>
                        <option value="<?php echo $rowData['dt_miscela']; ?>"><?php echo $rowData['dt_miscela']; ?></option>
                    <?php } ?>
                </select></td>          

            <td><input type="button" value="<?php echo $valueButtonCerca ?>" onClick="document.forms['VediMiscela'].submit();" style="width: 90px"/></td>
        </tr>

        <!--################## ORDINAMENTO ########################################-->
        <tr>              

            <td class="cella3" width="<?php echo $wid1 ?>"><div id="OrdinaId"><?php echo $filtroIdMiscela; ?>
                    <button name="Filtro" type="submit" value="id_miscela" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid2 ?>"><div id="OrdinaCod"><?php echo $filtroCodice; ?>
                    <button name="Filtro" type="submit" value="cod_formula" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid3 ?>"><div id="OrdinaDescri"><?php echo $filtroDescrizione; ?>
                    <button name="Filtro" type="submit" value="descri_formula" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid4 ?>"><div id="OrdinaCont"><?php echo $filtroContenitore; ?>
                    <button name="Filtro" type="submit" value="cod_contenitore" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid5 ?>"><div id="OrdinaPeso"><?php echo $filtroPesoReale; ?>
                    <button name="Filtro" type="submit" value="peso_reale" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid6 ?>"><div id="OrdinaDt"><?php echo $filtroDt; ?>
                    <button name="Filtro" type="submit" value="dt_miscela" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid7 ?>"><?php echo $filtroOperazioni; ?>&nbsp;</td>

        </tr>
     
        <li class='dataRigLightGray' ><?php echo $msgMisceleTrovate  ?><font color="#A00028"><?php echo $trovati?></font></li>
        <li class='dataRigLightGray' ><?php echo $msgTotChimicaConsumata ?><font color="#A00028"><?php echo number_format($QtaTotPeso / $fatConvKgGrammi, $PrecisioneQta, '.', ' ') . "  " . $filtroKgBreve ?></font></li>
        <li class='dataRigLightGray' ><?php echo $filtroOreLavoro ?>
            <input title="<?php echo $titleIserireOreLavoro ?> "style="color:#A00028;  width:60px; height:12px" type="text" name="OreLavoro" value="<?php echo $_SESSION['OreLavoro'] ?>" />
          <?php echo $filtroProduttivita ." : " ?><font color="#A00028"><?php echo $produttivita ." ".$filtroKgOra?>         
        </font></li>
            <?php
        
        $nomeClasse = "cella4";
        $nomeTitle = "";
        while ($row = mysql_fetch_array($sql)) {

            ?>
            <tr>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid1 ?>"  title="<?php echo $nomeTitle ?>"><?php echo $row['id_miscela'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid2 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['cod_formula'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid3 ?>" title="<?php echo $nomeTitle ?>"><?php echo($row['descri_formula']) ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid4 ?>"  title="<?php echo $nomeTitle ?>"><?php echo $row['cod_contenitore'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid5 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['peso_reale'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid6 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['dt_miscela'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid7 ?>">    
                    <a href="dettaglio_miscela.php?Miscela=<?php echo($row['id_miscela']) ?>">
                        <img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone" alt="<?php echo $titleDettaglio ?>" title="<?php echo $titleDettaglio ?>"/></a>

                </td>
            </tr>
            <?php
        }
        ?>
    </table>
