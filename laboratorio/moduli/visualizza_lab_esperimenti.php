<?php
    $wid1 = "25%";
    $wid2 = "25%";
    $wid3 = "15%";
    $wid4 = "15%";
    $wid5 = "15%";
    $wid6 = "5%";
?>

<!--################## MOTORE DI RICERCA ###################################-->
<form  name="VediLabProve" id="VediLabProve" action="" method="POST">
    <table class="table3">        
        <tr>
            <td><input style="width:100%" type="text" name="CodLabFormula" value="<?php echo $_SESSION['CodLabFormula'] ?>" /></td>
            <td><input style="width:100%" type="text" name="ProdOb" value="<?php echo $_SESSION['ProdOb'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Normativa" value="<?php echo $_SESSION['Normativa'] ?>" /></td>
            <td><input style="width:100%" type="text" name="CodBarre"  value="<?php echo $_SESSION['CodBarre'] ?>" /></td>
            <td><input style="width:100%" type="text" name="DtProva"  value="<?php echo $_SESSION['DtProva'] ?>" /></td>
            <td><img src="/CloudFab/images/icone/lente_piccola.png"  onClick="document.forms['VediLabProve'].submit();" title="<?php echo $titleRicerca ?>"/></td>
        </tr>
        <!--################## RICERCA CON LIST BOX ###############################-->
        <tr>      
            <td><select style="width:100%" name="CodLabFormulaList" id="CodLabFormulaList" onChange="document.forms['VediLabProve'].submit();">
                    <option value="<?php echo $_SESSION['CodLabFormulaList'] ?>" selected="<?php echo $_SESSION['CodLabFormulaList'] ?>"></option>
                        <?php                    
                    while($rowCodForm=mysql_fetch_array($sqlLabFormula)){
                        ?>
                        <option value="<?php echo $rowCodForm['cod_lab_formula']; ?>"><?php echo $rowCodForm['cod_lab_formula']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select style="width:100%" name="ProdObList" id="ProdObList" onChange="document.forms['VediLabProve'].submit();">
                    <option value="<?php echo $_SESSION['ProdObList'] ?>" selected="<?php echo $_SESSION['ProdObList'] ?>"></option>
                    <?php                    
                    while($rowProdOb=mysql_fetch_array($sqlLabProdOb)){
                        ?>
                        <option value="<?php echo $rowProdOb['prod_ob']; ?>"><?php echo $rowProdOb['prod_ob']; ?></option>
                    <?php } ?>
                </select></td>
             <td><select style="width:100%" name="NormativaList" id="NormativaList" onChange="document.forms['VediLabProve'].submit();">
                    <option value="<?php echo $_SESSION['NormativaList'] ?>" selected="<?php echo $_SESSION['NormativaList'] ?>"></option>
                        <?php                    
                    while($rowNorma=mysql_fetch_array($sqlLabNorma)){
                        ?>
                        <option value="<?php echo $rowNorma['normativa']; ?>"><?php echo $rowNorma['normativa']; ?></option>
                    <?php } ?>
                </select></td>    
            <td><select  style="width:100%" name="CodBarreList" id="CodBarreList" onChange="document.forms['VediLabProve'].submit();">
                    <option value="<?php echo $_SESSION['CodBarreList'] ?>" selected="<?php echo $_SESSION['CodBarreList'] ?>"></option>
                    <?php
                    while ($rowCodBarre = mysql_fetch_array($sqlCodBarre)) {
                        ?>
                        <option value="<?php echo $rowCodBarre['cod_barre']; ?>"><?php echo $rowCodBarre['cod_barre']; ?></option>
                    <?php } ?>
                </select></td>
                <td><select  style="width:100%"  name="DtProvaList" id="DtProvaList" onChange="document.forms['VediLabProve'].submit();">
                    <option value="<?php echo $_SESSION['DtProvaList'] ?>" selected="<?php echo $_SESSION['DtProvaList'] ?>"></option>
                    <?php
                    while ($rowDtProva = mysql_fetch_array($sqlLabDtProva)) {
                        ?>
                        <option value="<?php echo $rowDtProva['dt_prova']; ?>"><?php echo $rowDtProva['dt_prova']; ?></option>
                    <?php } ?>
                </select></td>
                <td>
                    <image type="submit" onClick="document.forms['VediLabProve'].submit();" title ="<?php echo $titleConfermaProveRiepilogo  ?>" src="/CloudFab/images/pittogrammi/ok.png" class="icone" />
                    
                    <image type="submit" onClick="riepilogoProve()" title ="<?php echo $titleRiepilogoProve ?>" src="/CloudFab/images/pittogrammi/duplica2_G.png" class="icone" />
                   </td>
          </tr>
<!-- ################## ORDINAMENTO ######################################## -->
        <tr>
            <td class="cella3" width="<?php echo $wid1 ?>">
                <div id="OrdinaCodice"><?php  echo $filtroLabFormula; ?>
                    <button name="Filtro" type="submit" value="cod_lab_formula" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid2 ?>"><div id="OrdinaProdOb"><?php  echo $filtroLabProdottoObiet; ?>
                    <button name="Filtro" type="submit" value="prod_ob" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
             <td class="cella3" width="<?php echo $wid3 ?>"><div id="OrdinaCodice"><?php  echo $filtroLabNorma; ?>
                    <button name="Filtro" type="submit" value="normativa" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            
            <td class="cella3" width="<?php echo $wid4 ?>"><div id="OrdinaCodBarre"><?php  echo $filtroLabCodProva; ?>
                    <button name="Filtro" type="submit" value="dt_prova" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid5 ?>"><div id="OrdinaDtProva"><?php  echo $filtroLabDtProva; ?>
                    <button name="Filtro" type="submit" value="dt_prova" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid6 ?>" ><?php echo $filtroOperazioni ?></td>
        </tr>
        <?php
            $i = 1;
            $colore = 1;            
            if(mysql_num_rows($sql)>0)
                mysql_data_seek($sql,0);
            while($row=mysql_fetch_array($sql))
            {
                $idEsp=$row['id_esperimento'];
                if($colore==1){
		?>
        <tr height="30px">
            <td class="cella1" width="<?php echo $wid1 ?>"><a name="115" href="dettaglio_lab_formula_prove.php?CodLabFormula=<?php echo($row['cod_lab_formula'])?>"><?php echo($row['cod_lab_formula'])?></a></td>
            <td class="cella1" width="<?php echo $wid2 ?>"><a name="108" href="dettaglio_lab_target_formule.php?ProdOb=<?php echo($row['prod_ob'])?>"><?php echo($row['prod_ob'])?></a></td>
            <td class="cella1" width="<?php echo $wid3 ?>"><?php echo($row['normativa'])?></td>
            <td class="cella1" width="<?php echo $wid4 ?>">        
                              <?php if(isSet($_SESSION['cod'][$idEsp])){ ?>
                <input type="checkbox" checked name="<?php echo $row['cod_barre'] ?>" value="Y" title="<?php echo $titleIncludiRiepilogo  ?>"  />
                              <?php } else if(!isSet($_SESSION['cod'][$idEsp])){ ?>
                <input type="checkbox" name="<?php echo $row['cod_barre'] ?>" value="Y" title="<?php echo $titleIncludiRiepilogo  ?>"  />
                              <?php } ?>
            <?php echo($row['cod_barre'])?>
            
             <?php if(isSet($_SESSION['escludi'][$idEsp])){ ?>
                <input type="checkbox" checked name="escludi<?php echo $row['cod_barre'] ?>" value="N" onClick="document.forms['VediLabProve'].submit();" title="<?php echo $titleEscludiRiepilogo  ?>"  />
                              <?php } else if(!isSet($_SESSION['escludi'][$idEsp])){ ?>
                <input type="checkbox" name="escludi<?php echo $row['cod_barre'] ?>" value="N" onClick="document.forms['VediLabProve'].submit();" title="<?php echo $titleEscludiRiepilogo  ?>"  />
                              <?php } ?>
           </td>                        
            <td class="cella1" width="<?php echo $wid5 ?>"><?php echo($row['dt_prova'])?></td>
            <td class="cella1" width="<?php echo $wid6 ?>">
                <a name="116" href="modifica_lab_risultati.php?IdEsperimento=<?php echo($row['id_esperimento'])?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="<?php echo $titleLabModificaRisultati ?>" title="<?php echo $titleLabModificaRisultati ?>"/></a>            
                </td>
        </tr>
        <?php 
		$colore = 2;
		} else { ?>
        <tr height="30px">
            <td class="cella2" width="<?php echo $wid1 ?>"><a name="115" href="dettaglio_lab_formula_prove.php?CodLabFormula=<?php echo($row['cod_lab_formula'])?>"><?php echo($row['cod_lab_formula'])?></a></td>
            <td class="cella2" width="<?php echo $wid2 ?>"><a name="108" href="dettaglio_lab_target_formule.php?ProdOb=<?php echo($row['prod_ob'])?>"><?php echo($row['prod_ob'])?></a></td>
            <td class="cella2" width="<?php echo $wid3 ?>"><?php echo($row['normativa'])?></td>
            <td class="cella2"  width="<?php echo $wid4 ?>">
                <?php if(isSet($_SESSION['cod'][$idEsp])){ ?>
                <input type="checkbox" checked name="<?php echo $row['cod_barre'] ?>" value="Y" title="<?php echo $titleIncludiRiepilogo  ?>"  />
                <?php }  else if(!isSet($_SESSION['cod'][$idEsp])){ ?>
                <input type="checkbox" name="<?php echo $row['cod_barre'] ?>" value="Y" title="<?php echo $titleIncludiRiepilogo  ?>"  />
                              <?php } ?>
            <?php echo($row['cod_barre'])?>            
            <?php if(isSet($_SESSION['escludi'][$idEsp])){ ?>
                <input type="checkbox" checked name="escludi<?php echo $row['cod_barre'] ?>" value="N" onClick="document.forms['VediLabProve'].submit();" title="<?php echo $titleEscludiRiepilogo ?>" />
                              <?php } else if(!isSet($_SESSION['escludi'][$idEsp])){ ?>
                <input type="checkbox" name="escludi<?php echo $row['cod_barre'] ?>" value="N" onClick="document.forms['VediLabProve'].submit();" title="<?php echo $titleEscludiRiepilogo  ?>" />
                              <?php } ?>
           </td>
            <td class="cella2" width="<?php echo $wid5 ?>"><?php echo($row['dt_prova'])?></td>
            <td class="cella2" width="<?php echo $wid6 ?>">
                <a name="116"href="modifica_lab_risultati.php?IdEsperimento=<?php echo($row['id_esperimento'])?>">
                    <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="<?php echo $titleLabModificaRisultati ?>" title="<?php echo $titleLabModificaRisultati ?>"/></a>            
                </td>
        </tr>
        <?php 
                $colore =1;
                }
            $i=$i+1;
            }?>
    </table>
<!--onClick="document.forms['VediLabProve'].submit();"-->