<?php
    $wid1 = "20%";
    $wid2 = "10%";
    $wid3 = "20%";
    $wid4 = "10%";
    $wid5 = "15%";
    $wid6 = "15%";
    $wid7 = "5%"; 
    $wid8 = "5%"; 
    ?>

<!--################## MOTORE DI RICERCA ###################################-->
<form  name="VediLabFormule" id="VediLabFormule" action="" method="POST">
    <table class="table3">
        <tr>
            <td><input style="width:100%" type="text"  name="CodLabFormula" value="<?php echo $_SESSION['CodLabFormula'] ?>" /></td>
            <td><input style="width:100%" type="text"  name="Normativa" value="<?php echo $_SESSION['Normativa'] ?>" /></td>
            <td><input style="width:100%" type="text"  name="ProdOb" value="<?php echo $_SESSION['ProdOb'] ?>" /></td>
            <td><input style="width:100%" type="text"  name="DtLabForm"  value="<?php echo $_SESSION['DtLabForm'] ?>" /></td>
            <td><input style="width:100%" type="text"  name="LabFormVisibilita"  value="<?php echo $_SESSION['LabFormVisibilita'] ?>" /></td>
            <td><input style="width:100%" type="text"  name="LabUtente" value="<?php echo $_SESSION['LabUtente'] ?>" /></td>
            <td><input style="width:100%" type="text"  name="LabGruppo"  value="<?php echo $_SESSION['LabGruppo'] ?>" /></td>
        </tr>
        <!--################## RICERCA CON LIST BOX ###############################-->
        <tr>
             <td ><select style="width:100%" name="CodLabFormulaList" id="CodLabFormulaList" onChange="document.forms['VediLabFormule'].submit();">
                    <option value="<?php echo $_SESSION['CodLabFormulaList'] ?>" selected="<?php echo $_SESSION['CodLabFormulaList'] ?>"></option>
                        <?php                    
                    while($rowCodForm=mysql_fetch_array($sqlLabCodForm)){
                        ?>
                        <option value="<?php echo $rowCodForm['cod_lab_formula']; ?>"><?php echo $rowCodForm['cod_lab_formula']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select style="width:100%" name="NormativaList" id="NormativaList" onChange="document.forms['VediLabFormule'].submit();">
                    <option value="<?php echo $_SESSION['NormativaList'] ?>" selected="<?php echo $_SESSION['NormativaList'] ?>"></option>
                    <?php                    
                    while($rowNorma=mysql_fetch_array($sqlLabNorma)){
                        ?>
                        <option value="<?php echo $rowNorma['normativa']; ?>"><?php echo $rowNorma['normativa']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select style="width:100%" name="ProdObList" id="ProdObList" onChange="document.forms['VediLabFormule'].submit();">
                    <option value="<?php echo $_SESSION['ProdObList'] ?>" selected="<?php echo $_SESSION['ProdObList'] ?>"></option>
                    <?php                    
                    while($rowProdOb=mysql_fetch_array($sqlLabProdOb)){
                        ?>
                        <option value="<?php echo $rowProdOb['prod_ob']; ?>"><?php echo $rowProdOb['prod_ob']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%" name="DtLabFormList" id="DtLabFormList" onChange="document.forms['VediLabFormule'].submit();">
                    <option value="<?php echo $_SESSION['DtLabFormList'] ?>" selected="<?php echo $_SESSION['DtLabFormList'] ?>"></option>
                    <?php
                    while ($rowDt = mysql_fetch_array($sqlLabDtForm)) {
                        ?>
                        <option value="<?php echo $rowDt['dt_lab_formula']; ?>"><?php echo $rowDt['dt_lab_formula']; ?></option>
                    <?php } ?>
                </select></td>
                <td><select style="width:100%" name="LabFormVisibilitaList" id="LabFormVisibilitaList" onChange="document.forms['VediLabFormule'].submit();">
                    <option value="<?php echo $_SESSION['LabFormVisibilitaList'] ?>" selected="<?php echo $_SESSION['LabFormVisibilitaList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlLabVis)) {
                        ?>
                        <option value="<?php echo $row['visibilita']; ?>"><?php echo $row['visibilita']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select style="width:100%" name="LabUtenteList" id="LabUtenteList" onChange="document.forms['VediLabFormule'].submit();">
                    <option value="<?php echo $_SESSION['LabUtenteList'] ?>" selected="<?php echo $_SESSION['LabUtenteList'] ?>"></option>
                    <?php
                    while ($rowLabUt = mysql_fetch_array($sqlLabUtente)) {
                        ?>
                        <option value="<?php echo $rowLabUt['utente']; ?>"><?php echo $rowLabUt['utente']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%"  name="LabGruppoList" id="LabGruppoList" onChange="document.forms['VediLabFormule'].submit();">
                    <option value="<?php echo $_SESSION['LabGruppoList'] ?>" selected="<?php echo $_SESSION['LabGruppoList'] ?>"></option>
                    <?php
                    while ($rowLabGru = mysql_fetch_array($sqlLabGruppo)) {
                        ?>
                        <option value="<?php echo $rowLabGru['gruppo_lavoro']; ?>"><?php echo $rowLabGru['gruppo_lavoro']; ?></option>
                    <?php } ?>
                </select></td>
                <td ><input  type="button" value="<?php echo $valueButtonCerca ?>" onClick="document.forms['VediLabFormule'].submit();"/></td>
          </tr>
<!-- ################## ORDINAMENTO ######################################## -->
        <tr>  
            <td class="cella3" width="<?php echo $wid1 ?>"><div id="OrdinaCodice"><?php  echo $filtroLabCodFormula; ?>
                    <button name="Filtro" type="submit" value="cod_lab_formula" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid2 ?>"><div id="OrdinaNormativa"><?php  echo $filtroLabNorma; ?>
                    <button name="Filtro" type="submit" value="normativa" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid3 ?>"><div id="OrdinaProdOb"><?php  echo $filtroLabProdottoObiet; ?>
                    <button name="Filtro" type="submit" value="prod_ob" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid4 ?>"><div id="OrdinaData"><?php  echo $filtroLabData; ?>
                    <button name="Filtro" type="submit" value="dt_lab_formula" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid8 ?>"><div id="OrdinaVis"><?php  echo $filtroVisibilita; ?>
                    <button name="Filtro" type="submit" value="visibilita" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid5 ?>"><div id="OrdinaUtente"><?php  echo $filtroLabUtente; ?>
                    <button name="Filtro" type="submit" value="utente" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid6 ?>"><div id="OrdinaGrupLav"><?php  echo $filtroLabGruppo; ?>
                    <button name="Filtro" type="submit" value="gruppo_lavoro" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid7 ?>"><?php echo $filtroOperazioni ?></td>
        <?php
            $i = 1;
            $colore = 1;
            while($row=mysql_fetch_array($sql))
            {
                if($colore==1){
		?>
        <tr height="30px">
            <td class="cella1" style="width:<?php echo $wid1 ?>"><a name="107"href="dettaglio_lab_formula_prove.php?CodLabFormula=<?php echo($row['cod_lab_formula'])?>"><?php echo($row['cod_lab_formula'])?></a></td>
            <td class="cella1" style="width:<?php echo $wid2 ?>"><?php echo($row['normativa'])?></td>
            <td class="cella1" style="width:<?php echo $wid3 ?>"><a name="108" href="dettaglio_lab_target_formule.php?ProdOb=<?php echo($row['prod_ob'])?>"><?php echo($row['prod_ob'])?></a></td>
            <td class="cella1" style="width:<?php echo $wid4 ?>"><?php echo($row['dt_lab_formula'])?></td>
            <td class="cella1" style="width:<?php echo $wid8 ?>"><?php echo $row['visibilita'] ?></td>
            <td class="cella1" style="width:<?php echo $wid5 ?>"><?php echo($row['utente'])?></td>
            <td class="cella1" style="width:<?php echo $wid6 ?>"><?php echo($row['gruppo_lavoro'])?></td>
            <td class="cella1" style="width:<?php echo $wid7 ?>">
                    <a name="109" href="elimina_lab_dato.php?Tabella=lab_formula&NomeId=cod_lab_formula&IdRecord=<?php echo $row['cod_lab_formula'] ?>&RefBack=gestione_lab_formula.php">
                    <img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone"  title="<?php echo $titleElimina ?> "/></a>&nbsp;
                <a name="109" href="duplica_lab_formula.php?CodiceFormulaOld=<?php echo($row['cod_lab_formula'])?>">
                    <img src="/CloudFab/images/pittogrammi/duplica1.png" class="icone"  title="<?php echo $titleDuplica ?>"/>    
            </td>
        </tr>
        <?php 
		$colore = 2;
		} else { ?>
        <tr height="30px">
            
            <td class="cella2" style="width:<?php echo $wid1 ?>"><a name="107" href="dettaglio_lab_formula_prove.php?CodLabFormula=<?php echo($row['cod_lab_formula'])?>"><?php echo($row['cod_lab_formula'])?></a></td>
            <td class="cella2" style="width:<?php echo $wid2 ?>"><?php echo($row['normativa'])?></a></td>
            <td class="cella2" style="width:<?php echo $wid3 ?>"><a name="108" href="dettaglio_lab_target_formule.php?ProdOb=<?php echo($row['prod_ob'])?>"><?php echo($row['prod_ob'])?></a></td>
            <td class="cella2" style="width:<?php echo $wid4 ?>"><?php echo($row['dt_lab_formula'])?></td>
            <td class="cella2" style="width:<?php echo $wid8 ?>"><?php echo $row['visibilita'] ?></td>
            <td class="cella2" style="width:<?php echo $wid5 ?>"><?php echo($row['utente'])?></td>
            <td class="cella2" style="width:<?php echo $wid6 ?>"><?php echo($row['gruppo_lavoro'])?></td>
            <td class="cella2" style="width:<?php echo $wid7 ?>">
                <a name="109" href="elimina_lab_dato.php?Tabella=lab_formula&NomeId=cod_lab_formula&IdRecord=<?php echo $row['cod_lab_formula'] ?>&RefBack=gestione_lab_formula.php">
                    <img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" title="<?php echo $titleElimina ?>"/></a>&nbsp;
                <a name="109" href="duplica_lab_formula.php?CodiceFormulaOld=<?php echo($row['cod_lab_formula'])?>">
                    <img src="/CloudFab/images/pittogrammi/duplica1.png" class="icone"  title="<?php echo $titleDuplica ?>"/> 
            </td>
        </tr>
        <?php 
                $colore =1;
                }
            $i=$i+1;
            }?>
    </table>