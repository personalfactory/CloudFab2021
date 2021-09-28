<?php
$wid1 = "5%";
$wid2 = "10%";
$wid3 = "10%";
$wid4 = "10%";
$wid5 = "20%";
$wid6 = "5%";
$wid7 = "10%";
$wid8 = "5%";
?>
<table class="table3">
    <tr>
        <th colspan="8"><?php echo $titoloPaginaListaConfigAgg ?></th>
    </tr>
    <!--################## MOTORE DI RICERCA ###################################-->
</table>
<form  name="VediFile" id="VediFile" action="" method="POST">
    <table class="table3">
        <tr>
            <td><input type="text" style="width:100%" name="Id"  value="<?php echo $_SESSION['Id'] ?>" /></td>
            <td><input type="text" style="width:100%" name="Parametro" value="<?php echo $_SESSION['Parametro'] ?>" /></td>
            <td><input type="text" style="width:100%" name="Valore" value="<?php echo $_SESSION['Valore'] ?>" /></td>
            <td><input type="text" style="width:100%" name="Tipo" value="<?php echo $_SESSION['Tipo'] ?>" /></td>
            <td><input type="text" style="width:100%" name="Descrizione" value="<?php echo $_SESSION['Descrizione'] ?>" /></td>
            <td><input type="text" style="width:100%" name="Abilitato" value="<?php echo $_SESSION['Abilitato'] ?>" /></td>
            <td><input type="text" style="width:100%" name="DtAbilitato" value="<?php echo $_SESSION['DtAbilitato'] ?>" /></td>
        </tr>
        <!--################## RICERCA CON LIST BOX ###############################-->
        <tr>
            <td><select style="width:100%" name="IdList" id="IdList" onChange="document.forms['VediFile'].submit();">
                    <option value="<?php echo $_SESSION['IdList'] ?>" selected="<?php echo $_SESSION['IdList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlId)) {
                        ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['id']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%"  name="ParametroList" id="ParametroList" onChange="document.forms['VediFile'].submit();">
                    <option value="<?php echo $_SESSION['ParametroList'] ?>" selected="<?php echo $_SESSION['ParametroList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlParametro)) {
                        ?>
                        <option value="<?php echo $row['parametro']; ?>"><?php echo $row['parametro']; ?></option>
                    <?php } ?>
                </select></td> 
                <td><select  style="width:100%"  name="ValoreList" id="ValoreList" onChange="document.forms['VediFile'].submit();">
                    <option value="<?php echo $_SESSION['ValoreList'] ?>" selected="<?php echo $_SESSION['ValoreList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlValore)) {
                        ?>
                        <option value="<?php echo $row['valore']; ?>"><?php echo $row['valore']; ?></option>
                    <?php } ?>
                </select></td> 
            <td><select  style="width:100%"  name="TipoList" id="TipoList" onChange="document.forms['VediFile'].submit();">
                    <option value="<?php echo $_SESSION['TipoList'] ?>" selected="<?php echo $_SESSION['TipoList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlTipo)) {
                        ?>
                        <option value="<?php echo $row['tipo']; ?>"><?php echo $row['tipo']; ?></option>
                    <?php } ?>
                </select></td> 
            <td><select  style="width:100%" name="DescrizioneList" id="DescrizioneList" onChange="document.forms['VediFile'].submit();">
                    <option value="<?php echo $_SESSION['DescrizioneList'] ?>" selected="<?php echo $_SESSION['DescrizioneList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlDescrizione)) {
                        ?>
                        <option value="<?php echo $row['descrizione']; ?>"><?php echo $row['descrizione']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%"  name="AbilitatoList" id="AbilitatoList" onChange="document.forms['VediFile'].submit();">
                    <option value="<?php echo $_SESSION['AbilitatoList'] ?>" selected="<?php echo $_SESSION['VersioneList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlAbilitato)) {
                        ?>
                        <option value="<?php echo $row['abilitato']; ?>"><?php echo $row['abilitato']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select style="width:100%" name="DtAbilitatoList" id="DtAbilitatoList" onChange="document.forms['VediFile'].submit();">
                    <option value="<?php echo $_SESSION['DtAbilitatoList'] ?>" selected="<?php echo $_SESSION['DtAbilitatoList'] ?>"></option>
                    <?php
                    while ($rowData = mysql_fetch_array($sqlDt)) {
                        ?>
                        <option value="<?php echo $rowData['dt_abilitato']; ?>"><?php echo $rowData['dt_abilitato']; ?></option>
                    <?php } ?>
                </select></td>          
            <td><input type="button" value="<?php echo $valueButtonCerca ?>" onClick="document.forms['VediFile'].submit();" style="width: 90px"/></td>
        </tr>
        <!--################## ORDINAMENTO ########################################-->
        <tr>             
            <td class="cella3" width="<?php echo $wid1 ?>"><div id="Ordina1"><?php echo $filtroId; ?>
                    <button name="Filtro" type="submit" value="id" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid2 ?>"><div id="Ordina2"><?php echo $filtroPar; ?>
                    <button name="Filtro" type="submit" value="parametro" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid3 ?>"><div id="Ordina3"><?php echo $filtroValore; ?>
                    <button name="Filtro" type="submit" value="tipo" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid4 ?>"><div id="Ordina4"><?php echo $filtroTipo; ?>
                    <button name="Filtro" type="submit" value="valore" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid5 ?>"><div id="Ordina5"><?php echo $filtroDescrizione; ?>
                    <button name="Filtro" type="submit" value="descrizione" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid6 ?>"><div id="Ordina6"><?php echo $filtroAbilitato; ?>
                    <button name="Filtro" type="submit" value="abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid7 ?>"><div id="Ordina7"><?php echo $filtroDtAbilitato; ?>
                    <button name="Filtro" type="submit" value="dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid8 ?>"><?php echo $filtroOperazioni; ?></td>
        </tr>
        <?php
        echo "<br/>" . $msgRecordTrovati . $trovati . "<br/>";
        echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";
        
        $nomeTitle = "";
        while ($row = mysql_fetch_array($sql)) {
           
                $nomeClasse = "dataRigGray";
                $styleHref = "dataGray";
            
            ?>
            <tr>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid1 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['id'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid2 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['parametro'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid3 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['valore'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid4 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['tipo'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid5 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['descrizione'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid6 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['abilitato'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid7 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['dt_abilitato'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid8 ?>">    
                    <a href="modifica_agg_config.php?Id=<?php echo($row['id']) ?>">
                        <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica?>"/></a>
                   
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</form>
