<?php
    $wid1 = "10%";
    $wid2 = "15%";
    $wid3 = "20%";
    $wid4 = "25%";
    $wid5 = "10%";
    $wid6 = "5%";
       
    ?>
<!--################## MOTORE DI RICERCA ###################################-->
<form  name="VediLabCar" id="VediLabCar" action="" method="POST">
    <table class="table3">
        <tr>
            <td><input style="width:100%" type="text" name="Normativa" value="<?php echo $_SESSION['Normativa'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Metodo" value="<?php echo $_SESSION['Metodo'] ?>" /></td>
            <td><input style="width:100%"type="text" name="Caratteristica" value="<?php echo $_SESSION['Caratteristica'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Descrizione" value="<?php echo $_SESSION['Descrizione'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Data"  value="<?php echo $_SESSION['Data'] ?>" /></td>
            
        </tr>
        <!--################## RICERCA CON LIST BOX ###############################-->
        <tr>
            
            <td><select style="width:100%" name="NormativaList" id="NormativaList" onChange="document.forms['VediLabCar'].submit();">
                    <option value="<?php echo $_SESSION['NormativaList'] ?>" selected="<?php echo $_SESSION['NormativaList'] ?>"></option>
                    <?php                    
                    while($rowNorma=mysql_fetch_array($sqlLabNorma)){
                        ?>
                        <option value="<?php echo $rowNorma['normativa']; ?>"><?php echo $rowNorma['normativa']; ?></option>
                    <?php } ?>
                </select></td>
                 
            <td><select style="width:100%" name="MetodoList" id="MetodoList" onChange="document.forms['VediLabCar'].submit();">
                    <option value="<?php echo $_SESSION['MetodoList'] ?>" selected="<?php echo $_SESSION['MetodoList'] ?>"></option>
                    <?php                    
                    while($rowMetodo=mysql_fetch_array($sqlLabMetodo)){
                        ?>
                        <option value="<?php echo $rowMetodo['metodologia']; ?>"><?php echo $rowMetodo['metodologia']; ?></option>
                    <?php } ?>
                </select></td>
                <td><select style="width:100%" name="CaratteristicaList" id="CaratteristicaList" onChange="document.forms['VediLabCar'].submit();">
                    <option value="<?php echo $_SESSION['CaratteristicaList'] ?>" selected="<?php echo $_SESSION['CaratteristicaList'] ?>"></option>
                    <?php                    
                    while($rowCar=mysql_fetch_array($sqlLabCar)){
                        ?>
                        <option value="<?php echo $rowCar['caratteristica']; ?>"><?php echo $rowCar['caratteristica']; ?></option>
                    <?php } ?>
                </select></td>
                <td><select style="width:100%" name="DescrizioneList" id="DescrizioneList" onChange="document.forms['VediLabCar'].submit();">
                    <option value="<?php echo $_SESSION['DescrizioneList'] ?>" selected="<?php echo $_SESSION['DescrizioneList'] ?>"></option>
                        <?php                    
                    while($rowDescri=mysql_fetch_array($sqlLabDescri)){
                        ?>
                        <option value="<?php echo $rowDescri['descri_caratteristica']; ?>"><?php echo $rowDescri['descri_caratteristica']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%" name="DataList" id="DataList" onChange="document.forms['VediLabCar'].submit();">
                    <option value="<?php echo $_SESSION['DataList'] ?>" selected="<?php echo $_SESSION['DataList'] ?>"></option>
                    <?php
                    while ($rowDt = mysql_fetch_array($sqlLabData)) {
                        ?>
                        <option value="<?php echo $rowDt['dt_abilitato']; ?>"><?php echo $rowDt['dt_abilitato']; ?></option>
                    <?php } ?>
                </select></td>
                <td><input type="button" value="<?php echo $valueButtonCerca ?>" onClick="document.forms['VediLabCar'].submit();"/></td>
            
          </tr>
<!-- ################## ORDINAMENTO ######################################## -->
        <tr>  
            <td class="cella3" width="<?php echo $wid1 ?>"><div id="OrdinaNormativa"><?php  echo $filtroLabNorma; ?>
                    <button name="Filtro" type="submit" value="normativa" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div></td>
            
            <td class="cella3" width="<?php echo $wid2 ?>"><div id="OrdinaMetodo"><?php  echo $filtroLabMetodologia; ?>
                    <button name="Filtro" type="submit" value="metodologia" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid3 ?>"><div id="OrdinaCar"><?php  echo $filtroLabCaratteristica; ?>
                    <button name="Filtro" type="submit" value="caratteristica" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid4 ?>"><div id="OrdinaDescri"><?php  echo $filtroLabDescri; ?>
                    <button name="Filtro" type="submit" value="descri_caratteristica" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid5 ?>"><div id="OrdinaData"><?php  echo $filtroLabData; ?>
                    <button name="Filtro" type="submit" value="dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
           
            <td class="cella3" width="<?php echo $wid6 ?>"><?php echo $filtroOperazioni ?></td>
        <?php
            $i = 1;
            $colore = 1;
            while($row=mysql_fetch_array($sql))
            {
                if($colore==1){
		?>
        <tr height="30px">
            <td class="cella1" width="<?php echo $wid1 ?>"><?php echo($row['normativa'])?></td>
            <td class="cella1" width="<?php echo $wid2 ?>" ><?php echo($row['metodologia'])?></td>
            <td class="cella1" width="<?php echo $wid3 ?>"><?php echo($row['caratteristica'])?></td>
            <td class="cella1" width="<?php echo $wid4 ?>"><?php echo($row['descri_caratteristica'])?></td>
            <td class="cella1" width="<?php echo $wid5 ?>"><?php echo($row['dt_abilitato'])?></td>
            <td class="cella1" width="<?php echo $wid6 ?>">
                    <a name="119" href="elimina_lab_dato.php?Tabella=lab_caratteristica&NomeId=id_carat&IdRecord=<?php echo $row['id_carat'] ?>&RefBack=gestione_lab_caratteristiche.php">
                    <img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone"  title="<?php echo $titleElimina ?> "/></a>&nbsp;
                <a name="119" href="modifica_lab_caratteristica.php?IdCaratteristica=<?php echo($row['id_carat'])?>">
                    <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone"  title="<?php echo $titleModifica ?>"/> </a>   
            </td>
        </tr>
        <?php 
		$colore = 2;
		} else { ?>
        <tr height="30px">
            <td class="cella2" width="<?php echo $wid1 ?>"><?php echo($row['normativa'])?></td>
            <td class="cella2" width="<?php echo $wid2 ?>"><?php echo($row['metodologia'])?></td>
            <td class="cella2" width="<?php echo $wid3 ?>"><?php echo($row['caratteristica'])?></td>
            <td class="cella2" width="<?php echo $wid4 ?>"><?php echo($row['descri_caratteristica'])?></a></td>
            <td class="cella2" width="<?php echo $wid5 ?>"><?php echo($row['dt_abilitato'])?></td>
             <td class="cella2" width="<?php echo $wid6 ?>">
               <a name="119" href="elimina_lab_dato.php?Tabella=lab_caratteristica&NomeId=id_carat&IdRecord=<?php echo $row['id_carat'] ?>&RefBack=gestione_lab_caratteristiche.php">
                    <img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone"  title="<?php echo $titleElimina ?> "/></a>&nbsp;
                <a name="119" href="modifica_lab_caratteristica.php?IdCaratteristica=<?php echo($row['id_carat'])?>"/>
                    <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone"  title="<?php echo $titleModifica ?>"/></a>    
            </td>
        </tr>
        <?php 
                $colore =1;
                }
            $i=$i+1;
            }?>
    </table>