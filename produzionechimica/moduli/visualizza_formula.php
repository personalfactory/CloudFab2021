<?php
    $wid1 = "10%";
    $wid2 = "15%";
    $wid3 = "20%";
    $wid4 = "15%";
    $wid5 = "10%";
    $wid6 = "15%";
    $wid7 = "5%";    
    ?>
<table>
    <tr>
        <td  class="dataRigGray" ><?php echo $filtroLegendaFormuleProd ?></td>
        <td  class="dataRigWhite" ><?php echo $filtroLegendaFormuleNonProd ?></td>
    </tr>
</table>
<table class="table3">
    <tr>
        <th colspan="7"><?php echo $titoloPaginaGestioneFormule ?></th>
    </tr>
    </tr>
   		<tr>
        	<td  colspan="9" style="text-align:center;"> 
            	<p><a name="20" href="carica_formula.php"><?php echo $nuovaFormula ?></a></p>
       	    	<p>&nbsp;</p>
            </td>
        </tr>
    <!--################## MOTORE DI RICERCA ###################################-->
</table>
<form  name="VediFormula" id="VediFormula" action="" method="POST">
    <table class="table3">
        <tr>
            <td><input type="text" style="width:100%" name="Famiglia"  value="<?php echo $_SESSION['Famiglia'] ?>" /></td>
            <td><input type="text" style="width:100%" name="CodFormula" value="<?php echo $_SESSION['CodFormula'] ?>" /></td>
            <td><input type="text" style="width:100%" name="Descrizione" value="<?php echo $_SESSION['Descrizione'] ?>" /></td>
            <td><input type="text" style="width:100%" name="DtFormula" value="<?php echo $_SESSION['DtFormula'] ?>" /></td>
            <td><input type="text" style="width:100%" name="NumLotti" value="<?php echo $_SESSION['NumLotti'] ?>" /></td>
            <td><input type="text" style="width:100%" name="NumSacInLotto" value="<?php echo $_SESSION['NumSacInLotto'] ?>" /></td>            
            <td><input type="text" style="width:100%" name="DtAbilitato" value="<?php echo $_SESSION['DtAbilitato'] ?>" /></td>
        </tr>
        <!--################## RICERCA CON LIST BOX ###############################-->
        <tr>
            <td><select style="width:100%" name="FamigliaList" id="FamigliaList" onChange="document.forms['VediFormula'].submit();">
                    <option value="<?php echo $_SESSION['FamigliaList'] ?>" selected="<?php echo $_SESSION['FamigliaList'] ?>"></option>
                    <?php
                    while ($rowFam = mysql_fetch_array($sqlFam)) {
                        ?>
                        <option value="<?php echo $rowFam['descrizione']; ?>"><?php echo $rowFam['descrizione']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%"  name="CodFormulaList" id="CodFormulaList" onChange="document.forms['VediFormula'].submit();">
                    <option value="<?php echo $_SESSION['CodFormulaList'] ?>" selected="<?php echo $_SESSION['CodFormulaList'] ?>"></option>
                    <?php
                    while ($rowCod = mysql_fetch_array($sqlCodFormula)) {
                        ?>
                        <option value="<?php echo $rowCod['cod_formula']; ?>"><?php echo $rowCod['cod_formula']; ?></option>
                    <?php } ?>
                </select></td> 
            <td><select  style="width:100%"  name="DescrizioneList" id="DescrizioneList" onChange="document.forms['VediFormula'].submit();">
                    <option value="<?php echo $_SESSION['DescrizioneList'] ?>" selected="<?php echo $_SESSION['DescrizioneList'] ?>"></option>
                    <?php
                    while ($rowDescri = mysql_fetch_array($sqlDescrizione)) {
                        ?>
                        <option value="<?php echo $rowDescri['descri_formula']; ?>"><?php echo $rowDescri['descri_formula']; ?></option>
                    <?php } ?>
                </select></td> 
            <td><select  style="width:100%" name="DtFormulaList" id="DtFormulaList" onChange="document.forms['VediFormula'].submit();">
                    <option value="<?php echo $_SESSION['DtFormulaList'] ?>" selected="<?php echo $_SESSION['DtFormulaList'] ?>"></option>
                    <?php
                    while ($rowDtForm = mysql_fetch_array($sqlDtFormula)) {
                        ?>
                        <option value="<?php echo $rowDtForm['dt_formula']; ?>"><?php echo $rowDtForm['dt_formula']; ?></option>
                    <?php } ?>
                </select></td>
                <td><select  style="width:100%"  name="NumLottiList" id="NumLottiList" onChange="document.forms['VediFormula'].submit();">
                    <option value="<?php echo $_SESSION['NumLottiList'] ?>" selected="<?php echo $_SESSION['NumLottiList'] ?>"></option>
                    <?php
                    while ($rowLotti = mysql_fetch_array($sqlNumLotti)) {
                        ?>
                        <option value="<?php echo $rowLotti['num_lotti']; ?>"><?php echo $rowLotti['num_lotti']; ?></option>
                    <?php } ?>
                </select></td>
                <td><select  style="width:100%"  name="NumSacInLottoList" id="NumSacList" onChange="document.forms['VediFormula'].submit();">
                    <option value="<?php echo $_SESSION['NumSacInLottoList'] ?>" selected="<?php echo $_SESSION['NumSacInLottoList'] ?>"></option>
                    <?php
                    while ($rowNumSac = mysql_fetch_array($sqlNumSac)) {
                        ?>
                        <option value="<?php echo $rowNumSac['num_sac_in_lotto']; ?>"><?php echo $rowNumSac['num_sac_in_lotto']; ?></option>
                    <?php } ?>
                </select></td>
            
            <td><select style="width:100%" name="DtAbilitatoList" id="DtAbilitatoList" onChange="document.forms['VediFormula'].submit();">
                    <option value="<?php echo $_SESSION['DtAbilitatoList'] ?>" selected="<?php echo $_SESSION['DtAbilitatoList'] ?>"></option>
                    <?php
                    while ($rowData = mysql_fetch_array($sqlDt)) {
                        ?>
                        <option value="<?php echo $rowData['dt_abil']; ?>"><?php echo $rowData['dt_abil']; ?></option>
                    <?php } ?>
                </select></td>          

            <td><input type="button" value="<?php echo $valueButtonCerca ?>" onClick="document.forms['VediFormula'].submit();" style="width: 90px"/></td>
        </tr>

        <!--################## ORDINAMENTO ########################################-->
        <tr>             

            <td class="cella3" width="<?php echo $wid1 ?>"><div id="Ordina1"><?php echo $filtroFamiglia; ?>
                    <button name="Filtro" type="submit" value="descrizione" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid2 ?>"><div id="Ordina2"><?php echo $filtroCodice; ?>
                    <button name="Filtro" type="submit" value="cod_formula" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid3 ?>"><div id="Ordina3"><?php echo $filtroDescrizione; ?>
                    <button name="Filtro" type="submit" value="descri_formula" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid4 ?>"><div id="Ordina4"><?php echo $filtroDtFormula; ?>
                    <button name="Filtro" type="submit" value="dt_formula" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid5 ?>"><div id="Ordina5"><?php echo $filtroNumLotti; ?>
                    <button name="Filtro" type="submit" value="num_lotti" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid6 ?>"><div id="Ordina6"><?php echo $filtroNumKitPerLotto; ?>
                    <button name="Filtro" type="submit" value="num_sac_in_lotti" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid7 ?>"><div id="Ordina7"><?php echo $filtroDt; ?>
                    <button name="Filtro" type="submit" value="f.dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid8 ?>"><?php echo $filtroOperazioni; ?></td>

        </tr>
        <?php
        echo "<br/>" . $msgRecordTrovati . $trovati . "<br/>";
        echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";
        //Distinguiamo fra le formule in produzione o meno visualizzandole in colori differenti
        $nomeClasse = "dataRigWhite";
        $styleHref="dataWhite";
        $nomeTitle = "";
        while ($row = mysql_fetch_array($sql)) {
            $lottoArtico=0;
            $lottoArtico=findLottoArticoByCodice("L".  substr($row['cod_formula'], 1));
            if(mysql_num_rows(findLottoArticoByCodice("L".  substr($row['cod_formula'], 1)))>0){
                    $nomeClasse="dataRigGray";
                    $styleHref="dataGray";
            }
            ?>
            <tr>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid1 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['descrizione'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid2 ?>" title="<?php echo $nomeTitle ?>"><a name="3" href="/CloudFab/prodotti/vista_prodotto_formula.php?CodiceFormula=<?php echo($row['cod_formula']) ?>" title="<?php echo $titleDettaglio?>"><?php echo $row['cod_formula'] ?></a></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid3 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['descri_formula'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid4 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['dt_formula'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid5 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['num_lotti'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid5 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['num_sac_in_lotto'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid6 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['dt_abil'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid7 ?>">    
                    <a name="18" href="modifica_formula.php?CodiceFormula=<?php echo($row['cod_formula']) ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica ?>"/></a>
                    <a name="20" href="cancella_formula.php?CodiceFormula=<?php echo($row['cod_formula']) ?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" title="<?php echo $titleElimina ?>"/></a>
                </td>

                </td>
            </tr>
            <?php
        }
        ?>
    </table>
