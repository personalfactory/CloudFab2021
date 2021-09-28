<?php
//Larghezza colonne 
$wid1 = "10%";// +10px padding (l+r)
$wid2 = "20%";// +10px padding (l+r)
$wid3 = "30%";// +10px padding (l+r)
$wid4 = "10%";// +10px padding (l+r)
$wid5 = "20%";// +10px padding (l+r)
$widOp ="10%";// +10px padding (l+r)
//TOTALE 1170px
?>
<script language="javascript">
   
    
    function AggiornaSelect(num) {       
     
        var string='?condizioneSelect='+num;
        
        document.forms["VediComponenti"].action = "gestione_componenti.php";
        document.forms["VediComponenti"].submit();
        location.href=string;
        
    }
</script>
<div style="float:right;padding-right:5px;
    border-width: 1px 1px 1px 1px;
    border-style: solid;
    border-color: #CCCCCC #CCCCCC #CCCCCC #CCCCCC;">
     <table>
            <tr>
                <td class="cella2"><a href="#" onclick="AggiornaSelect(1)" title="<?php echo $titleMostraColori ?>"><?php echo $filtroDrymix ?></a></td>
                <td class="cella1"><a href="#" onclick="AggiornaSelect(2)" title="<?php echo $titleMostraDrymix ?>"><?php echo $filtroPigmenti  ?></a></td>
                <td class="cella2"><a href="#" onclick="AggiornaSelect(3)" title="<?php echo $titleMostraTutto ?>"><?php echo $filtroAdditivi  ?></a></td>
                <td class="cella1"><a href="#" onclick="AggiornaSelect(4)" title="<?php echo $titleMostraTutto ?>"><?php echo $mostraTutto  ?></a></td>
            </tr>
     </table>
</div>
<table class="table3" >
    <tr>
        <th colspan="6"><?php echo $labelMenuComponenti?></th>
    </tr>
    <tr>
        <td colspan="6"style="text-align:center;" > 
            <p><a id="8" href="carica_componente.php?tipo2=1"><?php echo $linkPaginaComponente?></a></p>
            <p>&nbsp;</p>
        
            <p><a id="8" href="carica_componente.php?tipo2=2"><?php echo  $linkNuovoColore?></a>
                &nbsp;&nbsp;&nbsp;&nbsp;
        <a id="8" href="carica_componente.php?tipo2=3"><?php echo  $linkNuovoAdditivo ?></a></p>
            <p>&nbsp;</p>
        </td>
    </tr>
</table>
    <form  name="VediComponenti" id="VediComponenti" action="" method="POST">
    <table class="table3">
        <tr>
            <td><input style="width:100%" type="text" name="Id" value="<?php echo $_SESSION['Id'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Codice" value="<?php echo $_SESSION['Codice'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Descrizione" value="<?php echo $_SESSION['Descrizione'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Abilitato" value="<?php echo $_SESSION['Abilitato'] ?>" /></td>
            <td><input style="width:100%" type="text" name="DtAbilitato" value="<?php echo $_SESSION['DtAbilitato'] ?>" /></td>
        </tr>
     <!--################## RICERCA CON LIST BOX ###############################-->
        <tr>
            <td><select style="width:100%" name="IdList" id="IdList" onChange="document.forms['VediComponenti'].submit();">
                    <option value="<?php echo $_SESSION['IdList'] ?>" selected="<?php echo $_SESSION['IdList'] ?>"></option>
                    <?php
                    while ($rowId = mysql_fetch_array($sqlId)) {
                        ?>
                        <option value="<?php echo $rowId['id_comp']; ?>"><?php echo $rowId['id_comp']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%"  name="CodiceList" id="CodiceList" onChange="document.forms['VediComponenti'].submit();">
                    <option value="<?php echo $_SESSION['CodiceList'] ?>" selected="<?php echo $_SESSION['CodiceList'] ?>"></option>
                    <?php
                    while ($rowCod = mysql_fetch_array($sqlCodice)) {
                        ?>
                        <option value="<?php echo $rowCod['cod_componente']; ?>"><?php echo $rowCod['cod_componente']; ?></option>
                    <?php } ?>
                </select></td> 
            <td><select  style="width:100%"  name="DescrizioneList" id="DescrizioneList" onChange="document.forms['VediComponenti'].submit();">
                    <option value="<?php echo $_SESSION['DescrizioneList'] ?>" selected="<?php echo $_SESSION['DescrizioneList'] ?>"></option>
                    <?php
                    while ($rowDes = mysql_fetch_array($sqlDescri)) {
                        ?>
                        <option value="<?php echo $rowDes['descri_componente']; ?>"><?php echo $rowDes['descri_componente']; ?></option>
                    <?php } ?>
                </select></td> 
            <td><select  style="width:100%" name="AbilitatoList" id="AbilitatoList" onChange="document.forms['VediComponenti'].submit();">
                    <option value="<?php echo $_SESSION['AbilitatoList'] ?>" selected="<?php echo $_SESSION['AbilitatoList'] ?>"></option>
                    <?php
                    while ($rowAb = mysql_fetch_array($sqlAb)) {
                        ?>
                        <option value="<?php echo $rowAb['abilitato']; ?>"><?php echo $rowAb['abilitato']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%"  name="DtAbilitatoList" id="DtAbilitatoList" onChange="document.forms['VediComponenti'].submit();">
                    <option value="<?php echo $_SESSION['DtAbilitatoList'] ?>" selected="<?php echo $_SESSION['DtAbilitatoList'] ?>"></option>
                    <?php
                    while ($rowDtAb = mysql_fetch_array($sqlDtAb)) {
                        ?>
                        <option value="<?php echo $rowDtAb['dt_abilitato']; ?>"><?php echo $rowDtAb['dt_abilitato']; ?></option>
                    <?php } ?>
                </select></td>           

            <td><img src="/CloudFab/images/icone/lente_piccola.png" onClick="document.forms['VediComponenti'].submit();" title="<?php echo $titleRicerca ?>"/></td>
        </tr>
        <!--################## ORDINAMENTO ########################################-->
        <tr>              
            <td class="cella3" width="<?php echo $wid1 ?>"><div id="OrdinaId"><?php echo $filtroId; ?>
                    <button name="Filtro" type="submit" value="id_comp" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid2 ?>"><div id="OrdinaCod"><?php echo $filtroCodice; ?>
                    <button name="Filtro" type="submit" value="cod_componente" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid3 ?>"><div id="OrdinaTipo"><?php echo $filtroDescrizione; ?>
                    <button name="Filtro" type="submit" value="descri_componente" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid4 ?>"><div id="OrdinaSoTipo"><?php echo $filtroAbilitato; ?>
                    <button name="Filtro" type="submit" value="c.abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid5 ?>"><div id="OrdinaDt"><?php echo $filtroDt; ?>
                    <button name="Filtro" type="submit" value="c.dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>          
            <td class="cella3" style="width: <?php echo $widOp ?>"><?php echo $filtroOperazioni; ?></td>
        </tr>
        <?php
        echo "<br/>" . $msgRecordTrovati . $trovati . "<br/>";
        echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";
    
    $i = 1;
    $colore = 1;
    while ($row = mysql_fetch_array($sql)) {
        if ($colore == 1) {
            ?>
            <tr>
                <td class="cella1" style="width: <?php echo $wid1 ?>"><?php echo($row['id_comp']) ?></td>
                <td class="cella1" style="width: <?php echo $wid2 ?>"><?php echo($row['cod_componente']) ?></td>
                <td class="cella1" style="width: <?php echo $wid3 ?>"><?php echo($row['descri_componente']) ?></td>
                <td class="cella1" style="width: <?php echo $wid4 ?>"><?php echo($row['abilitato']) ?></td>
                <td class="cella1" style="width: <?php echo $wid5 ?>"><?php echo($row['dt_abilitato']) ?></td>
                <td class="cella1" style="width: <?php echo $widOp ?>">
<a name="Modifica" href="modifica_componente.php?Componente=<?php echo($row['id_comp']) ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica ?>"/></a>
            </td>
            </tr>
        <?php
        $colore = 2;
    } else {
        ?>
            <tr>
                <td class="cella2" style="width: <?php echo $wid1 ?>"><?php echo($row['id_comp']) ?></td>
                <td class="cella2" style="width: <?php echo $wid2 ?>"><?php echo($row['cod_componente']) ?></td>
                <td class="cella2" style="width: <?php echo $wid3 ?>"><?php echo($row['descri_componente']) ?></td>
                <td class="cella2" style="width: <?php echo $wid4 ?>"><?php echo($row['abilitato']) ?></td>
                <td class="cella2" style="width: <?php echo $wid5 ?>"><?php echo($row['dt_abilitato']) ?></td>
<td class="cella2" style="width: <?php echo $widOp ?>">
<a name="Modifica" href="modifica_componente.php?Componente=<?php echo($row['id_comp']) ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica ?>"/></a>
            </td>
            </tr>
            <?php
            $colore = 1;
        }
        $i = $i + 1;
    }
    ?>
</table>
    </form>