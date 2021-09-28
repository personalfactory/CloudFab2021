<?php
//Larghezza colonne 
$wid1 = "25%"; // +10px padding (l+r)
$wid2 = "30%"; // +10px padding (l+r)
$wid3 = "10%"; // +10px padding (l+r)
$wid4 = "15%"; // +10px padding (l+r)
$wid5 = "15%"; // +10px padding (l+r)
$widOp = "5%"; // +10px padding (l+r)
//TOTALE 1170px
?>
<table class="table3">
    <tr>
        <th colspan="6"><?php echo $titoloPaginaLabParametri ?></th>
    </tr>
    <tr>
        <td  colspan="6" style="text-align:center;"> 
            <a name="111" href="carica_lab_parametro.php"><?php echo $nuovoLabPar ?></a>
        </td>
    </tr>
    
</table>
<form  name="VediParametri" id="VediParametri" action="" method="POST">
<table class="table3">
        <tr>
            <td><input style="width:100%" type="text" name="Nome" value="<?php echo $_SESSION['Nome'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Descri" value="<?php echo $_SESSION['Descri'] ?>" /></td>
            <td><input style="width:100%" type="text" name="UnMisura" value="<?php echo $_SESSION['UnMisura'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Tipo" value="<?php echo $_SESSION['Tipo'] ?>" /></td>
            <td><input style="width:100%" type="text" name="DtAbilitato" value="<?php echo $_SESSION['DtAbilitato'] ?>" /></td>
        </tr>
         <!--################## RICERCA CON LIST BOX ###############################-->
        <tr>
            <td><select style="width:100%" name="NomeList" id="NomeList" onChange="document.forms['VediParametri'].submit();">
                    <option value="<?php echo $_SESSION['NomeList'] ?>" selected="<?php echo $_SESSION['NomeList'] ?>"></option>
                    <?php
                    while ($rowNome = mysql_fetch_array($sqlNome)) {
                        ?>
                        <option value="<?php echo $rowNome['nome_parametro']; ?>"><?php echo $rowNome['nome_parametro']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%"  name="DescriList" id="DescriList" onChange="document.forms['VediParametri'].submit();">
                    <option value="<?php echo $_SESSION['DescriList'] ?>" selected="<?php echo $_SESSION['DescriList'] ?>"></option>
                    <?php
                    while ($rowDes = mysql_fetch_array($sqlDescri)) {
                        ?>
                        <option value="<?php echo $rowDes['descri_parametro']; ?>"><?php echo $rowDes['descri_parametro']; ?></option>
                    <?php } ?>
                </select></td> 
            <td><select  style="width:100%"  name="UnMisuraList" id="UnMisuraList" onChange="document.forms['VediParametri'].submit();">
                    <option value="<?php echo $_SESSION['UnMisuraList'] ?>" selected="<?php echo $_SESSION['UnMisuraList'] ?>"></option>
                    <?php
                    while ($rowUnMi = mysql_fetch_array($sqlUnMis)) {
                        ?>
                        <option value="<?php echo $rowUnMi['unita_misura']; ?>"><?php echo $rowUnMi['unita_misura']; ?></option>
                    <?php } ?>
                </select></td> 
            <td><select  style="width:100%" name="TipoList" id="TipoList" onChange="document.forms['VediParametri'].submit();">
                    <option value="<?php echo $_SESSION['TipoList'] ?>" selected="<?php echo $_SESSION['TipoList'] ?>"></option>
                    <?php
                    while ($rowTi = mysql_fetch_array($sqlTipo)) {
                        ?>
                        <option value="<?php echo $rowTi['tipo']; ?>"><?php echo $rowTi['tipo']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%"  name="DtAbilitatoList" id="DtAbilitatoList" onChange="document.forms['VediParametri'].submit();">
                    <option value="<?php echo $_SESSION['DtAbilitatoList'] ?>" selected="<?php echo $_SESSION['DtAbilitatoList'] ?>"></option>
                    <?php
                    while ($rowDtAb = mysql_fetch_array($sqlDtAb)) {
                        ?>
                        <option value="<?php echo $rowDtAb['dt_abilitato']; ?>"><?php echo $rowDtAb['dt_abilitato']; ?></option>
                    <?php } ?>
                </select></td>


            <td><img src="/CloudFab/images/icone/lente_piccola.png" onClick="document.forms['VediParametri'].submit();" title="<?php echo $titleRicerca ?>"/></td>
        </tr>
        <!--################## ORDINAMENTO ########################################-->
        <tr>              

            <td class="cella3" width="<?php echo $wid1 ?>"><div id="OrdinaNomr"><?php echo $filtroLabParametro; ?>
                    <button name="Filtro" type="submit" value="nome_parametro" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid2 ?>"><div id="OrdinaDescri"><?php echo $filtroLabDescri; ?>
                    <button name="Filtro" type="submit" value="descri_parametro" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid3 ?>"><div id="OrdinaUnMi"><?php echo $filtroLabUnMisura; ?>
                    <button name="Filtro" type="submit" value="unita_misura" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid4 ?>"><div id="OrdinaTipo"><?php echo $filtroLabTipo; ?>
                    <button name="Filtro" type="submit" value="tipo" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>

            <td class="cella3" width="<?php echo $wid5 ?>"><div id="OrdinaDt"><?php echo $filtroLabData; ?>
                    <button name="Filtro" type="submit" value="dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>

            <td class="cella3" style="width: <?php echo $widOp ?>"><?php echo $filtroOperazioni; ?></td>

        </tr>
        <?php
        echo "<br/>" . $msgLabParametriTrovati . mysql_num_rows($sql) . "<br/>";
        echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";
    
    $colore = 1;
    while ($row = mysql_fetch_array($sql)) {
        if ($colore == 1) {
            ?>
            <tr>
                <td class="cella1" style="width: <?php echo $wid1 ?>"><?php echo($row['nome_parametro']) ?></td>
                <td class="cella1" style="width: <?php echo $wid2 ?>"><?php echo($row['descri_parametro']) ?></td>
                <td class="cella1" style="width: <?php echo $wid3 ?>"><?php echo($row['unita_misura']) ?></td>
                <td class="cella1" style="width: <?php echo $wid4 ?>"><?php echo($row['tipo']) ?></td>            
                <td class="cella1" style="width: <?php echo $wid5 ?>"><?php echo($row['dt_abilitato']) ?></td>
                <td class="cella1" style="width: <?php echo $widOp ?>">
                    <!--<a href="cancella_lab_parametro.php?IdParametro=<?php echo($row['id_par']) ?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="Elimina" title="Clicca per cancellare "/></a>&nbsp;-->
                    <a name="111" href="modifica_lab_parametro.php?IdParametro=<?php echo($row['id_par']) ?>">
                        <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="<?php echo $titleModifica?>" title="<?php echo $titleModifica?>"/></a>&nbsp;
                </td>
            </tr>
            <?php
            $colore = 2;
        } else {
            ?>
            <tr>
                <td class="cella2" style="width: <?php echo $wid1 ?>"><?php echo($row['nome_parametro']) ?></td>
                <td class="cella2" style="width: <?php echo $wid2 ?>"><?php echo($row['descri_parametro']) ?></td>
                <td class="cella2" style="width: <?php echo $wid3 ?>"><?php echo($row['unita_misura']) ?></td>
                <td class="cella2" style="width: <?php echo $wid4 ?>"><?php echo($row['tipo']) ?></td>  
                <td class="cella2" style="width: <?php echo $wid5 ?>"><?php echo($row['dt_abilitato']) ?></td>
                <td class="cella2" style="width: <?php echo $widOp ?>">
                    <!--<a href="cancella_lab_parametro.php?IdParametro=<?php echo($row['id_par']) ?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="Elimina" title="Clicca per cancellare "/></a>&nbsp;-->
                    <a name="111" href="modifica_lab_parametro.php?IdParametro=<?php echo($row['id_par']) ?>">
                        <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="<?php echo $titleModifica?>" title="<?php echo $titleModifica?>"/></a>&nbsp;

                </td>
            </tr>
            <?php
            $colore = 1;
        }
    }
    ?>
</table>
</form>