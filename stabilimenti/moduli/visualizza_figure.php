<?php 
$wid1="20%";//Nominativo
$wid2="15%";//Figura
$wid3="13%";//Codice
$wid4="12%";//DtAbilitato
$wid5="20%";//Gruppo
$wid6="20%";//RifGeografico
?>
<table class="table3">
    <tr>
        <th colspan="4"><?php echo $titoloPaginaFigura; ?></th>
    </tr>
    <tr>
        <td  colspan="4" style="text-align:center;"> 
            <p><a id="Nuova" href="carica_figura.php"><?php echo $nuovoDipendente; ?></a></p>
        </td>
    </tr>
</table>
<form  name="VediFigure" id="VediFigure" action="" method="POST">
    <table class="table3" width="100%">
        <!--################## RICERCA CON INPUT TEXT ###############################-->
        <tr>           
            <td><input style="width:100%" type="text" name="Nominativo" value="<?php echo $_SESSION['Nominativo'] ?>" onChange="document.forms['VediFigure'].submit();"/></td>
            <td><input style="width:100%" type="text" name="Figura" value="<?php echo $_SESSION['Figura'] ?>" onChange="document.forms['VediFigure'].submit();"/></td>
            <td><input style="width:100%" type="text" name="Codice" value="<?php echo $_SESSION['Codice'] ?>" onChange="document.forms['VediFigure'].submit();"/></td>
            <td><input style="width:100%" type="text" name="DtAbilitato" value="<?php echo $_SESSION['DtAbilitato'] ?>" onChange="document.forms['VediFigure'].submit();"/></td>
            <td></td>
            <td></td>
        </tr>
        <!--################## RICERCA CON LIST BOX ###############################-->
        <tr>
            <td><select style=" width:100%;" name="NominativoList" id="NominativoList" onChange="document.forms['VediFigure'].submit();">
                    <option value="<?php echo $_SESSION['NominativoList'] ?>" selected="<?php echo $_SESSION['NominativoList'] ?>"><?php // echo $SelezionaNominativo     ?></option>
                    <?php
                    while ($rowNome = mysql_fetch_array($sqlNome)) {
                        ?>
                        <option value="<?php echo $rowNome['nominativo']; ?>"><?php echo $rowNome['nominativo']; ?></option>
                    <?php } ?>
                </select> </td>
            <td><select  style=" width:100%;" name="FiguraList" id="FiguraList" onChange="document.forms['VediFigure'].submit();">
                    <option value="<?php echo $_SESSION['FiguraList'] ?>" selected="<?php echo $_SESSION['FiguraList'] ?>"><?php // echo $SelezionaFigura     ?></option>
                    <?php
                    while ($rowFigura = mysql_fetch_array($sqlFigura)) {
                        ?>
                        <option value="<?php echo $rowFigura['figura']; ?>"><?php echo $rowFigura['figura']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select style=" width:100%" name="CodiceList" id="CodiceList" onChange="document.forms['VediFigure'].submit();">
                    <option value="<?php echo $_SESSION['CodiceList'] ?>" selected="<?php echo $_SESSION['CodiceList'] ?>"><?php // echo $SelezionaFigura     ?></option>
                    <?php
                    while ($rowCodice = mysql_fetch_array($sqlCodice)) {
                        ?>
                        <option value="<?php echo $rowCodice['codice']; ?>"><?php echo $rowCodice['codice']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select style="width:100%" name="DtAbilitatoList" id="DtAbilitatoList" onChange="document.forms['VediFigure'].submit();">
                    <option value="<?php echo $_SESSION['DtAbilitatoList'] ?>" selected="<?php echo $_SESSION['DtAbilitatoList'] ?>"><?php // echo $SelezionaFigura     ?></option>
                    <?php
                    while ($rowDt = mysql_fetch_array($sqlDt)) {
                        ?>
                        <option value="<?php echo $rowDt['dt_abilitato']; ?>"><?php echo $rowDt['dt_abilitato']; ?></option>
                    <?php } ?>
                </select></td>
                
            <td>
                <select style="width:100%" name="Gruppo" id="Gruppo" onChange="document.forms['VediFigure'].submit();">
                    <option value="Universale"><?php echo $mostraTutto ?></option>
                    <option value="<?php echo $_SESSION['Gruppo'] ?>" selected="<?php echo $_SESSION['Gruppo'] ?>"><?php echo $_SESSION['Gruppo'] ?></option>
                    <?php
                    while ($rowGruppo = mysql_fetch_array($sqlGruppo)) {
                        ?>
                        <option value="<?php echo $rowGruppo['gruppo']; ?>"><?php echo $rowGruppo['gruppo']; ?></option>
                    <?php } ?>
                </select> 
            </td>
            <td>
                <select style="width:100%" name="Geografico" id="Geografico" onChange="document.forms['VediFigure'].submit();">
                    <option value="Mondo"><?php echo $mostraTutto ?></option>
                    <option value="<?php echo $_SESSION['Geografico'] ?>" selected="<?php echo $_SESSION['Geografico'] ?>"><?php echo $_SESSION['Geografico'] ?></option>
                    <?php
                    while ($rowGeo = mysql_fetch_array($sqlGeo)) {
                        ?>
                        <option value="<?php echo $rowGeo['geografico']; ?>"><?php echo $rowGeo['geografico']; ?></option>
                    <?php } ?>
                </select>
            </td>
                <td><img src="/CloudFab/images/icone/lente_piccola.png" onClick="document.forms['VediFigure'].submit();" title="<?php echo $titleRicerca ?>"/></td>
        </tr>
        <!--################## VISUALIZZAZIONE RISULTATI  ########################--> 
        <!--################### ORDINAMENTO ######################################-->
        <tr>
            
            <td class="cella3" style="width:<?php echo $wid1 ?>"><div id="OrdinaNome"><?php echo $filtroNominativo; ?>
                    <button name="Filtro" type="submit" value="nominativo" class="button3" title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" style="width:<?php echo $wid2 ?>"><div id="OrdinaFigura"><?php echo $filtroFigura; ?>
                    <button name="Filtro" type="submit" value="figura" class="button3" title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>  
            </td>
            <td class="cella3"style="width:<?php echo $wid3 ?>"><div id="OrdinaCodice"><?php echo $filtroCodice; ?>
                    <button name="Filtro" type="submit" value="codice" class="button3" title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>  
            </td>
            <td class="cella3" style="width:<?php echo $wid4 ?>"><div id="OrdinaFiltroDt"><?php echo $filtroDt; ?>
                    <button name="Filtro" type="submit" value="dt_abilitato" class="button3" title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>  
            </td>
            <td class="cella3" style="width:<?php echo $wid5 ?>"><div id="OrdinaGruppo"><?php echo $filtroGruppo; ?>
                    <button name="Filtro" type="submit" value="gruppo" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" style="width:<?php echo $wid6 ?>"><div id="OrdinaGeo"><?php echo $filtroGeografico; ?>
                    <button name="Filtro" type="submit" value="geografico" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3"><?php echo $filtroOperazioni; ?></td>
        </tr>
        <?php
        $trovati = mysql_num_rows($sql);

        echo "<br/>" . $msgRecordTrovati . $trovati . "<br/>";
        echo "<br/>" . $msgSelectListCriteriRicerca . "<br/>";

        $i = 1;
        $colore = 1;
        while ($row = mysql_fetch_array($sql)) {
            if ($colore == 1) {
                ?>
                <tr>
                   
                    <td class="cella1"><?php echo($row['nominativo']) ?></td>
                    <td class="cella1"><?php echo($row['figura']) ?></td>
                    <td class="cella1"><?php echo($row['codice']) ?></td>
                    <td class="cella1"><?php echo($row['dt_abilitato']) ?></td>
                     <td class="cella1"><?php echo($row['gruppo']) ?></td>
                    <td class="cella1"><?php echo($row['geografico']) ?></td>
                    <td class="cella1"style="width:90px"><nobr>
<a target="_blank" href="genera_cod_operatore.php?Codice=<?php echo $row['codice'] ?>&Nome=<?php echo $row['nominativo'] ?>">
    <img src="/CloudFab/images/pittogrammi/stampa_G.png" class="icone"  title="<?php echo $filtroStampaCodice ?>"/></a>
    <a href="../produzioneorigami/disabilita_record.php?Tabella=figura&IdRecord=<?php echo $row['id_figura'] ?>&RefBack=../stabilimenti/gestione_figure.php">
                                <img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone"  title="<?php echo $titleElimina ?>"/></a>
                        <!--<a href="modifica_figura.php?IdFigura=<?php echo($row['id_figura']) ?>">
                            <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone"  title="<?php echo $titleModifica ?>"/>
                        </a>-->
                </nobr></td>
                </tr>
                <?php
                $colore = 2;
            } else {
                ?>
                <tr>
                    
                    <td class="cella2"><?php echo($row['nominativo']) ?></td>
                    <td class="cella2"><?php echo($row['figura']) ?></td>
                    <td class="cella2"><?php echo($row['codice']) ?></td>
                    <td class="cella2"><?php echo($row['dt_abilitato']) ?></td>
                    <td class="cella2"><?php echo($row['gruppo']) ?></td>
                    <td class="cella2"><?php echo($row['geografico']) ?></td>
                    <td class="cella2"style="width:90px"><nobr>
<a target="_blank" href="genera_cod_operatore.php?Codice=<?php echo $row['codice'] ?>&Nome=<?php echo $row['nominativo'] ?>">
    <img src="/CloudFab/images/pittogrammi/stampa_G.png" class="icone"  title="<?php echo $filtroStampaCodice ?>"/></a>
    <a href="../produzioneorigami/disabilita_record.php?Tabella=figura&IdRecord=<?php echo $row['id_figura'] ?>&RefBack=../stabilimenti/gestione_figure.php">
                                <img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone"  title="<?php echo $titleElimina ?>"/></a>
                       <!-- <a href="modifica_figura.php?IdFigura=<?php echo($row['id_figura']) ?>">
                            <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone"  title="<?php echo $titleModifica ?>"/>
                        </a>-->
                   </nobr> </td>
                </tr>
                <?php
                $colore = 1;
            }
            $i = $i + 1;
        }
        ?>
    </table>
</form>