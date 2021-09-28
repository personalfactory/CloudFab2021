<?php
//Larghezza colonne 
$wid1 = "5%"; // +10px padding (l+r)
$wid2 = "20%"; // +10px padding (l+r)
$wid3 = "45%"; // +10px padding (l+r)
$wid4 = "10%"; // +10px padding (l+r)
$wid5 = "10%"; // +10px padding (l+r)
$widOp = "10%"; // +10px padding (l+r)
//TOTALE 1170px
?>
<table class="table3">
    <tr>
        <th colspan="6"><?php echo $titoloPaginaCategoria ?></th>
    </tr>
    <tr>
        <td  colspan="6" style="text-align:center;"> 
            <p><a name="82" href="carica_categoria.php"><?php echo $linkPaginaCategoria ?></a></p>
            <p>&nbsp;</p>
        </td>
    </tr>
</table>

<form  name="VediCategorie" id="VediCategorie" action="" method="POST">
    <table class="table3">
        <tr>
            <td><input style="width:100%" type="text" name="Id" value="<?php echo $_SESSION['Id'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Nome" value="<?php echo $_SESSION['Nome'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Descrizione" value="<?php echo $_SESSION['Descrizione'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Abilitato" value="<?php echo $_SESSION['Abilitato'] ?>" /></td>
            <td><input style="width:100%" type="text" name="DtAbilitato" value="<?php echo $_SESSION['DtAbilitato'] ?>" /></td>
        </tr>
        <!--################## RICERCA CON LIST BOX ###############################-->
        <tr>
            <td><select style="width:100%" name="IdList" id="IdList" onChange="document.forms['VediCategorie'].submit();">
                    <option value="<?php echo $_SESSION['IdList'] ?>" selected="<?php echo $_SESSION['IdList'] ?>"></option>
                    <?php
                    while ($rowId = mysql_fetch_array($sqlId)) {
                        ?>
                        <option value="<?php echo $rowId['id_cat']; ?>"><?php echo $rowId['id_cat']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%"  name="NomeList" id="NomeList" onChange="document.forms['VediCategorie'].submit();">
                    <option value="<?php echo $_SESSION['NomeList'] ?>" selected="<?php echo $_SESSION['NomeList'] ?>"></option>
                    <?php
                    while ($rowNome = mysql_fetch_array($sqlNome)) {
                        ?>
                        <option value="<?php echo $rowNome['nome_categoria']; ?>"><?php echo $rowNome['nome_categoria']; ?></option>
                    <?php } ?>
                </select></td> 
            <td><select  style="width:100%"  name="DescrizioneList" id="DescrizioneList" onChange="document.forms['VediCategorie'].submit();">
                    <option value="<?php echo $_SESSION['DescrizioneList'] ?>" selected="<?php echo $_SESSION['DescrizioneList'] ?>"></option>
                    <?php
                    while ($rowDes = mysql_fetch_array($sqlDescri)) {
                        ?>
                        <option value="<?php echo $rowDes['descri_categoria']; ?>"><?php echo $rowDes['descri_categoria']; ?></option>
                    <?php } ?>
                </select></td> 
            <td><select  style="width:100%" name="AbilitatoList" id="AbilitatoList" onChange="document.forms['VediCategorie'].submit();">
                    <option value="<?php echo $_SESSION['AbilitatoList'] ?>" selected="<?php echo $_SESSION['AbilitatoList'] ?>"></option>
                    <?php
                    while ($rowAb = mysql_fetch_array($sqlAb)) {
                        ?>
                        <option value="<?php echo $rowAb['abilitato']; ?>"><?php echo $rowAb['abilitato']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%"  name="DtAbilitatoList" id="DtAbilitatoList" onChange="document.forms['VediCategorie'].submit();">
                    <option value="<?php echo $_SESSION['DtAbilitatoList'] ?>" selected="<?php echo $_SESSION['DtAbilitatoList'] ?>"></option>
                    <?php
                    while ($rowDtAb = mysql_fetch_array($sqlDtAb)) {
                        ?>
                        <option value="<?php echo $rowDtAb['dt_abilitato']; ?>"><?php echo $rowDtAb['dt_abilitato']; ?></option>
                    <?php } ?>
                </select></td>


            <td><img src="/CloudFab/images/icone/lente_piccola.png" onClick="document.forms['VediCategorie'].submit();" title="<?php echo $titleRicerca ?>"/></td>
        </tr>
        <!--################## ORDINAMENTO ########################################-->
        <tr>              

            <td class="cella3" width="<?php echo $wid1 ?>"><div id="OrdinaId"><?php echo $filtroId; ?>
                    <button name="Filtro" type="submit" value="id_cat" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid2 ?>"><div id="OrdinaCod"><?php echo $filtroNome; ?>
                    <button name="Filtro" type="submit" value="nome_categoria" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid3 ?>"><div id="OrdinaTipo"><?php echo $filtroDescrizione; ?>
                    <button name="Filtro" type="submit" value="descri_categoria" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid4 ?>"><div id="OrdinaSoTipo"><?php echo $filtroAbilitato; ?>
                    <button name="Filtro" type="submit" value="abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>

            <td class="cella3" width="<?php echo $wid5 ?>"><div id="OrdinaDt"><?php echo $filtroDt; ?>
                    <button name="Filtro" type="submit" value="dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
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
            $strFineDes = "";
            if (strlen($row['descri_categoria']) > 100) {
                $strFineDes = $filtroPuntini;
            }
            if ($colore == 1) {
                ?>
                <tr>
                    <td class="cella1" style="width: <?php echo $wid1 ?>"><?php echo($row['id_cat']) ?></td>
                    <td class="cella1" style="width: <?php echo $wid2 ?>"><?php echo($row['nome_categoria']) ?></td>
                    <td class="cella1" style="width: <?php echo $wid3 ?>" title="<?php echo($row['descri_categoria']) ?>"><?php echo substr($row['descri_categoria'], 0, 95) . $strFineDes ?></td>
                    <td class="cella1" style="width: <?php echo $wid4 ?>"><?php echo($row['abilitato']) ?></td>
                    <td class="cella1" style="width: <?php echo $wid5 ?>"><?php echo($row['dt_abilitato']) ?></td>
                    <td class="cella1" style="width: <?php echo $widOp ?>">
                        <a name="81" href="modifica_categoria.php?IdCategoria=<?php echo($row['id_cat']) ?>">
                            <!--<img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone"  title="<?php echo $titleModifica ?>"/></a>-->
<!--                        <a name="84" href="/CloudFab/stabilimenti/modifica_valore_categoria_sac.php?IdCategoria=<?php echo($row['id_cat']) ?>">-->
                           
                            <img src="/CloudFab/images/pittogrammi/insacco_G.png" class="icone"  title="<?php echo $titleModificaParInsacco ?>"/></a>
                        <!-- <a name="83" href="/CloudFab/stabilimenti/modifica_valore_categoria.php?IdCategoria=<?php echo($row['id_cat']) ?>">
                            <img src="/CloudFab/images/pittogrammi/sacchi3_R.png" class="icone"  title="<?php echo $titleModificaParProd ?>"/></a>-->
                            <a name="85" href="/CloudFab/prodotti/duplica_categoria.php?IdCategoria=<?php echo($row['id_cat']) ?>">
                            <img src="/CloudFab/images/pittogrammi/duplica2_G.png" class="icone"  title="<?php echo $titleDuplicaCategoria ?>"/></a>
                    </td>
                </tr>
                <?php
                $colore = 2;
            } else {
                ?>
                <tr>
                    <td class="cella2" style="width: <?php echo $wid1 ?>"><?php echo($row['id_cat']) ?></td>
                    <td class="cella2" style="width: <?php echo $wid2 ?>"><?php echo($row['nome_categoria']) ?></td>
                    <td class="cella2" style="width: <?php echo $wid3 ?>" title="<?php echo($row['descri_categoria']) ?>"><?php echo substr($row['descri_categoria'], 0, 95) . $strFineDes ?></td>
                    <td class="cella2" style="width: <?php echo $wid4 ?>"><?php echo($row['abilitato']) ?></td>
                    <td class="cella2" style="width: <?php echo $wid5 ?>"><?php echo($row['dt_abilitato']) ?></td>
                    <td class="cella2" style="width: <?php echo $widOp ?>">
                        <a name="81" href="modifica_categoria.php?IdCategoria=<?php echo($row['id_cat']) ?>">
                            <!--<img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone"  title="<?php echo $titleModifica ?>"/></a>-->            
                        <!--<a name="84" href="/CloudFab/stabilimenti/modifica_valore_categoria_sac.php?IdCategoria=<?php echo($row['id_cat']) ?>">-->
                            <img src="/CloudFab/images/pittogrammi/insacco_G.png" class="icone"  title="<?php echo $titleModificaParInsacco ?>"/></a>
                        <!--disabilitato per kerneos perchè questi parametri si modificano dal prodotto nell'ultima versine del software 
                        <a name="83" href="/CloudFab/stabilimenti/modifica_valore_categoria.php?IdCategoria=<?php echo($row['id_cat']) ?>">
                            <img src="/CloudFab/images/pittogrammi/sacchi3_R.png" class="icone"  title="<?php echo $titleModificaParProd ?>"/></a>-->
                             <a name="85" href="/CloudFab/prodotti/duplica_categoria.php?IdCategoria=<?php echo($row['id_cat']) ?>">
                            <img src="/CloudFab/images/pittogrammi/duplica2_G.png" class="icone"  title="<?php echo $titleDuplicaCategoria ?>"/></a>



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