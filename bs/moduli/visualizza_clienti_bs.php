<?php
//Larghezza colonne 
$wid1 = "10%"; // +10px padding (l+r)
$wid2 = "20%"; // +10px padding (l+r)
$wid3 = "20%"; // +10px padding (l+r)
$wid4 = "15%"; // +10px padding (l+r)
$wid5 = "15%"; // +10px padding (l+r)
$widOp = "5%"; // +10px padding (l+r)
//TOTALE 1170px
?>
<table class="table3">
    <tr>
        <th colspan="6"><?php echo $titoloPaginaClientiInBs ?></th>
    </tr>
    <tr>
        <td  colspan="6" style="text-align:center;"> 
            <p><a name="82" href="carica_cliente_bs.php?ToDo=NuovoCliente"><?php echo $titoloPaginaNuovoClienteInBs ?></a></p>
            <p>&nbsp;</p>
        </td>
    </tr>
</table>

<form  name="VediBsClienti" id="VediBsClienti" action="" method="POST">
    <table class="table3">
        <tr>
            <td><input style="width:100%" type="text" name="IdCliente" value="<?php echo $_SESSION['IdCliente'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Nominativo" value="<?php echo $_SESSION['Nominativo'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Descrizione" value="<?php echo $_SESSION['Descrizione'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Note" value="<?php echo $_SESSION['Note'] ?>" /></td>
            <td><input style="width:100%" type="text" name="DtAbilitato" value="<?php echo $_SESSION['DtAbilitato'] ?>" /></td>
        </tr>
        <!--################## RICERCA CON LIST BOX ###############################-->
        <tr>
            <td><select style="width:100%" name="IdClienteList" id="IdClienteList" onChange="document.forms['VediBsClienti'].submit();">
                    <option value="<?php echo $_SESSION['IdClienteList'] ?>" selected="<?php echo $_SESSION['IdClienteList'] ?>"></option>
                    <?php
                    while ($rowId = mysql_fetch_array($sqlId)) {
                        ?>
                        <option value="<?php echo $rowId['id_cliente']; ?>"><?php echo $rowId['id_cliente']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%"  name="NominativoList" id="NominativoList" onChange="document.forms['VediBsClienti'].submit();">
                    <option value="<?php echo $_SESSION['NominativoList'] ?>" selected="<?php echo $_SESSION['NominativoList'] ?>"></option>
                    <?php
                    while ($rowNome = mysql_fetch_array($sqlNome)) {
                        ?>
                        <option value="<?php echo $rowNome['nominativo']; ?>"><?php echo $rowNome['nominativo']; ?></option>
                    <?php } ?>
                </select></td> 
            <td><select  style="width:100%"  name="DescrizioneList" id="DescrizioneList" onChange="document.forms['VediBsClienti'].submit();">
                    <option value="<?php echo $_SESSION['DescrizioneList'] ?>" selected="<?php echo $_SESSION['DescrizioneList'] ?>"></option>
                    <?php
                    while ($rowDes = mysql_fetch_array($sqlDescri)) {
                        ?>
                        <option value="<?php echo $rowDes['descrizione']; ?>"><?php echo $rowDes['descrizione']; ?></option>
                    <?php } ?>
                </select></td> 
            <td><select  style="width:100%" name="NoteList" id="NoteList" onChange="document.forms['VediBsClienti'].submit();">
                    <option value="<?php echo $_SESSION['NoteList'] ?>" selected="<?php echo $_SESSION['NoteList'] ?>"></option>
                    <?php
                    while ($rowNote = mysql_fetch_array($sqlNote)) {
                        ?>
                        <option value="<?php echo $rowNote['note']; ?>"><?php echo $rowNote['note']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%"  name="DtAbilitatoList" id="DtAbilitatoList" onChange="document.forms['VediBsClienti'].submit();">
                    <option value="<?php echo $_SESSION['DtAbilitatoList'] ?>" selected="<?php echo $_SESSION['DtAbilitatoList'] ?>"></option>
                    <?php
                    while ($rowDtAb = mysql_fetch_array($sqlDtAb)) {
                        ?>
                        <option value="<?php echo $rowDtAb['dt_abilitato']; ?>"><?php echo $rowDtAb['dt_abilitato']; ?></option>
                    <?php } ?>
                </select></td>


            <td><img src="/CloudFab/images/icone/lente_piccola.png" onClick="document.forms['VediBsClienti'].submit();" title="<?php echo $titleRicerca ?>"/></td>
        </tr>
        <!--################## ORDINAMENTO ########################################-->
        <tr>              

            <td class="cella3" width="<?php echo $wid1 ?>"><div id="OrdinaId"><?php echo $filtroId; ?>
                    <button name="Filtro" type="submit" value="id_cliente" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid2 ?>"><div id="OrdinaNome"><?php echo $filtroNome; ?>
                    <button name="Filtro" type="submit" value="nominativo" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid3 ?>"><div id="OrdinaDescri"><?php echo $filtroDescrizione ?>
                    <button name="Filtro" type="submit" value="descrizione" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            
            <td class="cella3" width="<?php echo $wid4 ?>"><div id="OrdinaNote"><?php echo $filtroNote; ?>
                    <button name="Filtro" type="submit" value="note" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
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
            $strFineDes = "";
            if (strlen($row['note']) > 100) {
                $strFineDes = $filtroPuntini;
            }
            if ($colore == 1) {
                ?>
                <tr>
                    <td class="cella1" style="width: <?php echo $wid1 ?>"><?php echo($row['id_cliente']) ?></td>
                    <td class="cella1" style="width: <?php echo $wid2 ?>"><?php echo($row['nominativo']) ?></td>
                    <td class="cella1" style="width: <?php echo $wid3 ?>"><?php echo($row['descrizione']) ?></td>
                    <td class="cella1" style="width: <?php echo $wid5 ?>"><?php echo substr($row['note'], 0, 95) . $strFineDes ?></td>
                    <td class="cella1" style="width: <?php echo $wid6 ?>"><?php echo($row['dt_abilitato']) ?></td>
                    <td class="cella1" style="width: <?php echo $widOp ?>">
                     <a name="136" href="carica_cliente_bs.php?ToDo=ModificaCliente&IdCliente=<?php echo($row['id_cliente']) ?>">
                            <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone"  title="<?php echo $titleModifica ?>"/></a>
                        <a name="135" href="elimina_bs_dato.php?Tabella=bs_cliente&IdRecord=<?php echo($row['id_cliente']) ?>&NomeId=id_cliente&RefBack=gestione_clienti_bs.php">
                            <img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone"  title="<?php echo $titleElimina ?>"/></a></td>
                </tr>
                <?php
                $colore = 2;
            } else {
                ?>
                <tr>
                    <td class="cella2" style="width: <?php echo $wid1 ?>"><?php echo($row['id_cliente']) ?></td>
                    <td class="cella2" style="width: <?php echo $wid2 ?>"><?php echo($row['nominativo']) ?></td>
                    <td class="cella2" style="width: <?php echo $wid3 ?>"><?php echo($row['descrizione']) ?></td>
                    <td class="cella2" style="width: <?php echo $wid5 ?>"><?php echo substr($row['note'], 0, 95) . $strFineDes ?></td>
                    <td class="cella2" style="width: <?php echo $wid6 ?>"><?php echo($row['dt_abilitato']) ?></td>
                    <td class="cella2" style="width: <?php echo $widOp ?>">
                   <a name="136" href="carica_cliente_bs.php?ToDo=ModificaCliente&IdCliente=<?php echo($row['id_cliente']) ?>">
                            <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone"  title="<?php echo $titleModifica ?>"/></a>
                        <a name="135" href="elimina_bs_dato.php?Tabella=bs_cliente&IdRecord=<?php echo($row['id_cliente']) ?>&NomeId=id_cliente&RefBack=gestione_clienti_bs.php">
                            <img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone"  title="<?php echo $titleElimina ?>"/></a></td>
                </tr>
                <?php
                $colore = 1;
            }
            $i = $i + 1;
        }
        ?>
    </table>
</form>