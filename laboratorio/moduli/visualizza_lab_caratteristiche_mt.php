<?php
//Larghezza colonne 
$wid1 = "5%"; // +10px padding (l+r)
$wid2 = "20%"; // +10px padding (l+r)
$wid3 = "20%"; // +10px padding (l+r)
$wid4 = "10%"; // +10px padding (l+r)
$wid5 = "10%"; // +10px padding (l+r)
$wid6 = "5%"; // +10px padding (l+r)
$wid7 = "15%";
$wid8 = "13%";
$widOp ="2%";
//TOTALE 1170px
?>
<table class="table3">
    <tr>
        <th colspan="6"><?php echo $titoloPaginaLabProprietaMt ?></th>
    </tr>
    <tr>
        <td  colspan="6" style="text-align:center;"> 
            <a name="122" href="carica_lab_caratteristica_mt.php"><?php echo $nuovaLabProprieta ?></a>
        </td>
    </tr>    
</table>
<!--################## MOTORE DI RICERCA ###################################-->
<form  name="VediLabCarMt" id="VediLabCarMt" action="" method="POST">
    <table class="table3">
        <tr>
            <td><input style="width:100%" type="text" name="IdCarat" value="<?php echo $_SESSION['IdCarat'] ?>" /></td>            
            <td><input style="width:100%" type="text" name="Caratteristica" value="<?php echo $_SESSION['Caratteristica'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Descrizione" value="<?php echo $_SESSION['Descrizione'] ?>" /></td>
            <td><input style="width:100%" type="text" name="UniMisCar" value="<?php echo $_SESSION['UniMisCar'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Dimensione" value="<?php echo $_SESSION['Dimensione'] ?>" /></td>
            <td><input style="width:100%" type="text" name="UniMisDim" value="<?php echo $_SESSION['UniMisDim'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Metodologia" value="<?php echo $_SESSION['Metodologia'] ?>" /></td>
            <td><input style="width:100%" type="text" name="DtAbilitato"  value="<?php echo $_SESSION['DtAbilitato'] ?>" /></td>
        </tr>
        <!--################## RICERCA CON LIST BOX ###############################-->
        <tr>
            
            <td><select style="width:100%" name="IdCaratList" id="IdCaratList" onChange="document.forms['VediLabCarMt'].submit();">
                    <option value="<?php echo $_SESSION['IdCaratList'] ?>" selected="<?php echo $_SESSION['IdCaratList'] ?>"></option>
                    <?php                    
                    while($rowId=mysql_fetch_array($sqlId)){
                        ?>
                        <option value="<?php echo $rowId['id_carat']; ?>"><?php echo $rowId['id_carat']; ?></option>
                    <?php } ?>
                </select></td>                 
           
                <td><select style="width:100%" name="CaratteristicaList" id="CaratteristicaList" onChange="document.forms['VediLabCarMt'].submit();">
                    <option value="<?php echo $_SESSION['CaratteristicaList'] ?>" selected="<?php echo $_SESSION['CaratteristicaList'] ?>"></option>
                    <?php                    
                    while($rowCar=mysql_fetch_array($sqlLabCar)){
                        ?>
                        <option value="<?php echo $rowCar['caratteristica']; ?>"><?php echo $rowCar['caratteristica']; ?></option>
                    <?php } ?>
                </select></td>
                <td><select style="width:100%" name="DescrizioneList" id="DescrizioneList" onChange="document.forms['VediLabCarMt'].submit();">
                    <option value="<?php echo $_SESSION['DescrizioneList'] ?>" selected="<?php echo $_SESSION['DescrizioneList'] ?>"></option>
                        <?php                    
                    while($rowDescri=mysql_fetch_array($sqlLabDescri)){
                        ?>
                        <option value="<?php echo $rowDescri['descri_caratteristica']; ?>"><?php echo $rowDescri['descri_caratteristica']; ?></option>
                    <?php } ?>
                </select></td>
                 <td><select style="width:100%" name="UniMisCarList" id="UniMisCarList" onChange="document.forms['VediLabCarMt'].submit();">
                    <option value="<?php echo $_SESSION['UniMisCarList'] ?>" selected="<?php echo $_SESSION['UniMisCarList'] ?>"></option>
                    <?php                    
                    while($rowUniCar=mysql_fetch_array($sqlUniCar)){
                        ?>
                        <option value="<?php echo $rowUniCar['uni_mis_car']; ?>"><?php echo $rowUniCar['uni_mis_car']; ?></option>
                    <?php } ?>
                </select></td>
                 <td><select style="width:100%" name="DimensioneList" id="DimensioneList" onChange="document.forms['VediLabCarMt'].submit();">
                    <option value="<?php echo $_SESSION['DimensioneList'] ?>" selected="<?php echo $_SESSION['DimensioneList'] ?>"></option>
                    <?php                    
                    while($rowDim=mysql_fetch_array($sqlDim)){
                        ?>
                        <option value="<?php echo $rowDim['dimensione']; ?>"><?php echo $rowDim['dimensione']; ?></option>
                    <?php } ?>
                </select></td>
                 <td><select style="width:100%" name="UniMisDimList" id="MetodologiaList" onChange="document.forms['VediLabCarMt'].submit();">
                    <option value="<?php echo $_SESSION['UniMisDimList'] ?>" selected="<?php echo $_SESSION['UniMisDimList'] ?>"></option>
                    <?php                    
                    while($rowUnMis=mysql_fetch_array($sqlUnDim)){
                        ?>
                        <option value="<?php echo $rowUnMis['uni_mis_dim']; ?>"><?php echo $rowUnMis['uni_mis_dim']; ?></option>
                    <?php } ?>
                </select></td>
                 <td><select style="width:100%" name="MetodologiaList" id="MetodologiaList" onChange="document.forms['VediLabCarMt'].submit();">
                    <option value="<?php echo $_SESSION['MetodologiaList'] ?>" selected="<?php echo $_SESSION['MetodologiaList'] ?>"></option>
                    <?php                    
                    while($rowMetodo=mysql_fetch_array($sqlMetodo)){
                        ?>
                        <option value="<?php echo $rowMetodo['metodologia']; ?>"><?php echo $rowMetodo['metodologia']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%" name="DtAbilitatoList" id="DtAbilitatoList" onChange="document.forms['VediLabCarMt'].submit();">
                    <option value="<?php echo $_SESSION['DtAbilitatoList'] ?>" selected="<?php echo $_SESSION['DtAbilitatoList'] ?>"></option>
                    <?php
                    while ($rowDt = mysql_fetch_array($sqlLabData)) {
                        ?>
                        <option value="<?php echo $rowDt['dt_abilitato']; ?>"><?php echo $rowDt['dt_abilitato']; ?></option>
                    <?php } ?>
                </select></td>
                <td><img src="/CloudFab/images/icone/lente_piccola.png" onClick="document.forms['VediLabCarMt'].submit();" title="<?php echo $titleRicerca ?>"/></td>
            
          </tr>
<!-- ################## ORDINAMENTO ######################################## -->
        <tr>  
            <td class="cella3" style="width:<?php echo $wid1 ?>"><div id="OrdinaId"><?php  echo $filtroLabId; ?>
                    <button name="Filtro" type="submit" value="id_carat" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div></td>           
           
            <td class="cella3" style="width:<?php echo $wid2 ?>"><div id="OrdinaCar"><?php  echo $filtroLabCaratteristica; ?>
                    <button name="Filtro" type="submit" value="caratteristica" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" style="width:<?php echo $wid3 ?>px"><div id="OrdinaDescri"><?php  echo $filtroLabDescri; ?>
                    <button name="Filtro" type="submit" value="descri_caratteristica" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" style="width:<?php echo $wid4 ?>px"><div id="OrdinaUnMisCar"><?php  echo $filtroLabUnMisura; ?>
                    <button name="Filtro" type="submit" value="uni_mis_car" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" style="width:<?php echo $wid5 ?>px"><div id="OrdinaDim"><?php  echo $filtroLabDimensione; ?>
                    <button name="Filtro" type="submit" value="dimensione" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" style="width:<?php echo $wid6 ?>px"><div id="OrdinaUnMisDim"><?php  echo $filtroLabUnMisura ." ".$filtroLabDimensione; ?>
                    <button name="Filtro" type="submit" value="uni_mis_dim" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
             <td class="cella3" style="width:<?php echo $wid7 ?>"><div id="OrdinaMet"><?php  echo $filtroLabMetodologia; ?>
                    <button name="Filtro" type="submit" value="metodologia" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" style="width:<?php echo $wid8 ?>"><div id="OrdinaData"><?php  echo $filtroLabData; ?>
                    <button name="Filtro" type="submit" value="dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
           
          <td name="121" class="cella3" style="width: <?php echo $widOp ?>"><?php echo $filtroOperazioni; ?></td>

        </tr>
        <?php
        echo "<br/>" . $msgLabProprietaTrovate . mysql_num_rows($sql) . "<br/>";
        echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";
    
			$i = 1;
			$colore = 1;
        	while($row=mysql_fetch_array($sql)){
                    $strFineDes = "";
            if (strlen($row['descri_caratteristica']) > 35) {
                $strFineDes = $filtroPuntini;
            }
            if($colore==1){
		?>
        <tr>
            <td class="cella1" style="width:<?php echo $wid1 ?>"><?php echo($row['id_carat'])?></td>
            <td class="cella1" style="width:<?php echo $wid2 ?>"><?php echo($row['caratteristica'])?></td>
            <td class="cella1" style="width:<?php echo $wid3 ?>" title="<?php echo($row['descri_caratteristica'])?>"><?php echo substr($row['descri_caratteristica'], 0, 30) . $strFineDes ?></td>
            <td class="cella1" style="width:<?php echo $wid4 ?>"><?php echo($row['uni_mis_car'])?></td>
            <td class="cella1" style="width:<?php echo $wid5 ?>"><?php echo($row['dimensione'])?></td>
            <td class="cella1" style="width:<?php echo $wid6 ?>"><?php echo($row['uni_mis_dim'])?></td>
            <td class="cella1" style="width:<?php echo $wid7 ?>"><?php echo($row['metodologia'])?></td>
            <td class="cella1" style="width:<?php echo $wid8 ?>"><?php echo($row['dt_abilitato'])?></td>
            <td name="121"class="cella1" style="width:<?php echo $widOp ?>">
                <a name="121" href="modifica_lab_caratteristica_mt.php?IdCaratteristica=<?php echo($row['id_carat'])?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="Modifica" title="Clicca per modificare"/></a>
            </td>
        </tr>
        <?php 
			$colore = 2;
		}else{ ?>
        <tr>
            <td class="cella2" style="width:<?php echo $wid1 ?>"><?php echo($row['id_carat'])?></td>
            <td class="cella2" style="width:<?php echo $wid2 ?>"><?php echo($row['caratteristica'])?></td>
            <td class="cella2" style="width:<?php echo $wid3 ?>" title="<?php echo($row['descri_caratteristica'])?>"><?php echo substr($row['descri_caratteristica'], 0, 30) . $strFineDes?></td>
            <td class="cella2" style="width:<?php echo $wid4 ?>"><?php echo($row['uni_mis_car'])?></td>
            <td class="cella2" style="width:<?php echo $wid5 ?>"><?php echo($row['dimensione'])?></td>
            <td class="cella2" style="width:<?php echo $wid6 ?>"><?php echo($row['uni_mis_dim'])?></td>
            <td class="cella2" style="width:<?php echo $wid7 ?>"><?php echo($row['metodologia'])?></td>
            <td class="cella2" style="width:<?php echo $wid8 ?>"><?php echo($row['dt_abilitato'])?></td>
             <td name="121" class="cella2" style="width:<?php echo $widOp ?>">
                <a name="121" href="modifica_lab_caratteristica_mt.php?IdCaratteristica=<?php echo($row['id_carat'])?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="Modifica" title="Clicca per modificare"/></a>
            </td>
            
        </tr>
        <?php 
			$colore =1;
			}
		 $i=$i+1;
		}?>
    </table>