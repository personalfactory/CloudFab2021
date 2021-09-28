<?php
$wid1 = "10%";
$wid2 = "20%";
$wid3 = "10%";
$wid4 = "30%";
$wid5 = "10%";
$wid6 = "15%";
?>
<table class="table3">
    <tr>
        <th colspan="6"><?php echo $titoloPaginaListaFileAgg ?></th>
    </tr>
    <!--################## MOTORE DI RICERCA ###################################-->
</table>
<form  name="VediFile" id="VediFile" action="" method="POST">
    <table class="table3">
        <tr>
            <td><input type="text" style="width:100%" name="IdMacchina"  value="<?php echo $_SESSION['IdMacchina'] ?>" /></td>
            <td><input type="text" style="width:100%" name="DescriStab" value="<?php echo $_SESSION['DescriStab'] ?>" /></td>
            <td><input type="text" style="width:100%" name="Tipo" value="<?php echo $_SESSION['Tipo'] ?>" /></td>
            <td><input type="text" style="width:100%" name="NomeFile" value="<?php echo $_SESSION['NomeFile'] ?>" /></td>
            <td><input type="text" style="width:100%" name="Versione" value="<?php echo $_SESSION['Versione'] ?>" /></td>
            <td><input type="text" style="width:100%" name="DtAggiornamento" value="<?php echo $_SESSION['DtAggiornamento'] ?>" /></td>
        </tr>
        <!--################## RICERCA CON LIST BOX ###############################-->
        <tr>
            <td><select style="width:100%" name="IdMacchinaList" id="IdMacchinaList" onChange="document.forms['VediFile'].submit();">
                    <option value="<?php echo $_SESSION['IdMacchinaList'] ?>" selected="<?php echo $_SESSION['IdMacchinaList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlIdMac)) {
                        ?>
                        <option value="<?php echo $row['id_macchina']; ?>"><?php echo $row['id_macchina']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%"  name="DescriStabList" id="DescriStabList" onChange="document.forms['VediFile'].submit();">
                    <option value="<?php echo $_SESSION['DescriStabList'] ?>" selected="<?php echo $_SESSION['DescriStabList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlDescriStab)) {
                        ?>
                        <option value="<?php echo $row['descri_stab']; ?>"><?php echo $row['descri_stab']; ?></option>
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
            <td><select  style="width:100%" name="NomeFileList" id="NomeFileList" onChange="document.forms['VediFile'].submit();">
                    <option value="<?php echo $_SESSION['NomeFileList'] ?>" selected="<?php echo $_SESSION['NomeFileList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlNomeFile)) {
                        ?>
                        <option value="<?php echo $row['nome_file']; ?>"><?php echo $row['nome_file']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%"  name="VersioneList" id="VersioneList" onChange="document.forms['VediFile'].submit();">
                    <option value="<?php echo $_SESSION['VersioneList'] ?>" selected="<?php echo $_SESSION['VersioneList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlVersione)) {
                        ?>
                        <option value="<?php echo $row['versione']; ?>"><?php echo $row['versione']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select style="width:100%" name="DtAggiornamentoList" id="DtAggiornamentoList" onChange="document.forms['VediFile'].submit();">
                    <option value="<?php echo $_SESSION['DtAggiornamentoList'] ?>" selected="<?php echo $_SESSION['DtAggiornamentoList'] ?>"></option>
                    <?php
                    while ($rowData = mysql_fetch_array($sqlDt)) {
                        ?>
                        <option value="<?php echo $rowData['dt_abil']; ?>"><?php echo $rowData['dt_abil']; ?></option>
                    <?php } ?>
                </select></td>          

            <td><input type="button" value="<?php echo $valueButtonCerca ?>" onClick="document.forms['VediFile'].submit();" style="width: 90px"/></td>
        </tr>

        <!--################## ORDINAMENTO ########################################-->
        <tr>             

            <td class="cella3" width="<?php echo $wid1 ?>"><div id="Ordina1"><?php echo $filtroIdMacchina; ?>
                    <button name="Filtro" type="submit" value="a.id_macchina" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid2 ?>"><div id="Ordina2"><?php echo $filtroStabilimento; ?>
                    <button name="Filtro" type="submit" value="descri_stab" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid3 ?>"><div id="Ordina3"><?php echo $filtroTipo; ?>
                    <button name="Filtro" type="submit" value="tipo" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid4 ?>"><div id="Ordina4"><?php echo $filtroNomeFile; ?>
                    <button name="Filtro" type="submit" value="nome_file" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid5 ?>"><div id="Ordina5"><?php echo $filtroVersione; ?>
                    <button name="Filtro" type="submit" value="versione" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
           
            <td class="cella3" width="<?php echo $wid6 ?>"><div id="Ordina6"><?php echo $filtroDt; ?>
                    <button name="Filtro" type="submit" value="dt_aggiornamento" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
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
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid1 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['id_macchina'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid2 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['descri_stab'] ?></a></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid3 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['tipo'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid4 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['nome_file'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid5 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['versione'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid6 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['dt_aggiornamento'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid7 ?>">    
                    <a href="/CloudFab/syncorigami/SyncOrigami/<?php echo($row['nome_file']) ?>"><img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone" title="<?php echo $titleVediFile?>"/></a>
                    <a href="elimina_file_tabella.php?IdRecord=<?php echo($row['id']) ?>&RefBack=gestione_lista_file.php&NomeFile=<?php echo $row['nome_file'] ?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" title="<?php echo $titleElimina ?>"/></a>
                </td>

                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</form>
