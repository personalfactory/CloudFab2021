<?php
    $wid1 = "25%";
    $wid2 = "40%";
    $wid3 = "30%";
    $wid4 = "5%";
        
    ?>
<!--################## MOTORE DI RICERCA ###################################-->
<form  name="VediLabNormativa" id="VediLabNormativa" action="" method="POST">
    <table class="table3">
        <tr>
            <td><input style="width:100%" type="text" name="Normativa" value="<?php echo $_SESSION['Normativa'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Descrizione" value="<?php echo $_SESSION['Descrizione'] ?>" /></td>
            <td><input style="width:100%" type="text"  name="Data"  value="<?php echo $_SESSION['Data'] ?>" /></td>
            
        </tr>
        <!--################## RICERCA CON LIST BOX ###############################-->
        <tr>
            
            <td><select style="width:100%" name="NormativaList" id="NormativaList" onChange="document.forms['VediLabNormativa'].submit();">
                    <option value="<?php echo $_SESSION['NormativaList'] ?>" selected="<?php echo $_SESSION['NormativaList'] ?>"></option>
                    <?php                    
                    while($rowNorma=mysql_fetch_array($sqlLabNorma)){
                        ?>
                        <option value="<?php echo $rowNorma['normativa']; ?>"><?php echo $rowNorma['normativa']; ?></option>
                    <?php } ?>
                </select></td>
                 <td><select style="width:100%" name="DescrizioneList" id="DescrizioneList" onChange="document.forms['VediLabNormativa'].submit();">
                    <option value="<?php echo $_SESSION['DescrizioneList'] ?>" selected="<?php echo $_SESSION['DescrizioneList'] ?>"></option>
                        <?php                    
                    while($rowDescri=mysql_fetch_array($sqlLabDescri)){
                        ?>
                        <option value="<?php echo $rowDescri['descri']; ?>"><?php echo $rowDescri['descri']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%" name="DataList" id="DataList" onChange="document.forms['VediLabNormativa'].submit();">
                    <option value="<?php echo $_SESSION['DataList'] ?>" selected="<?php echo $_SESSION['DataList'] ?>"></option>
                    <?php
                    while ($rowDt = mysql_fetch_array($sqlLabData)) {
                        ?>
                        <option value="<?php echo $rowDt['dt_abilitato']; ?>"><?php echo $rowDt['dt_abilitato']; ?></option>
                    <?php } ?>
                </select></td>
                <td><img src="/CloudFab/images/icone/lente_piccola.png" onClick="document.forms['VediLabNormativa'].submit();" title="<?php echo $titleRicerca ?>"/></td>
        </tr>
<!-- ################## ORDINAMENTO ######################################## -->
        <tr>  
            <td class="cella3" width="<?php echo $wid1 ?>"><div id="OrdinaNormativa"><?php  echo $filtroLabNorma; ?>
                    <button name="Filtro" type="submit" value="normativa" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid2 ?>"><div id="OrdinaDescri"><?php  echo $filtroLabDescri; ?>
                    <button name="Filtro" type="submit" value="descri" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            
            <td class="cella3" width="<?php echo $wid3 ?>"><div id="OrdinaData"><?php  echo $filtroLabData; ?>
                    <button name="Filtro" type="submit" value="dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
           
            <td name="113" class="cella3" ><?php echo $filtroOperazioni ?></td>
        <?php
            $i = 1;
            $colore = 1;
            while($row=mysql_fetch_array($sql))
            {
                if($colore==1){
		?>
        <tr height="30px">
            <td class="cella1" width="<?php echo $wid1 ?>"><?php echo($row['normativa'])?></td>
            <td class="cella1" width="<?php echo $wid2 ?>"><?php echo($row['descri'])?></td>
            <td class="cella1" width="<?php echo $wid3 ?>"><?php echo($row['dt_abilitato'])?></td>
            <td name="113" class="cella1" width="<?php echo $wid4 ?>">
                    <a name="113" href="elimina_lab_dato.php?Tabella=lab_normativa&NomeId=normativa&IdRecord=<?php echo $row['normativa'] ?>&RefBack=gestione_lab_normativa.php">
                    <img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone"  title="<?php echo $titleElimina ?> "/></a>&nbsp;
                <a name="113" href="modifica_lab_normativa.php?Normativa=<?php echo($row['normativa'])?>">
                    <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone"  title="<?php echo $titleModifica ?>"/> </a>   
            </td>
        </tr>
        <?php 
		$colore = 2;
		} else { ?>
        <tr height="30px">
            <td class="cella2" width="<?php echo $wid1 ?>"><?php echo($row['normativa'])?></td>
            <td class="cella2" width="<?php echo $wid2 ?>"><?php echo($row['descri'])?></a></td>
            <td class="cella2" width="<?php echo $wid3 ?>"><?php echo($row['dt_abilitato'])?></td>
             <td name="113" class="cella2" width="<?php echo $wid4 ?>">
                <a name="113" href="elimina_lab_dato.php?Tabella=lab_normativa&NomeId=normativa&IdRecord=<?php echo $row['normativa'] ?>&RefBack=gestione_lab_normativa.php">
                    <img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone"  title="<?php echo $titleElimina ?> "/></a>&nbsp;
                <a name="113" href="modifica_lab_normativa.php?Normativa=<?php echo($row['normativa'])?>">
                    <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone"  title="<?php echo $titleModifica ?>"/></a>    
            </td>
        </tr>
        <?php 
                $colore =1;
                }
            $i=$i+1;
            }?>
    </table>