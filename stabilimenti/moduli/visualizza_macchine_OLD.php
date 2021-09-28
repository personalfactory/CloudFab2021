<?php
$wid1 = "3%"; //Id macchina
$wid2 = "7%"; //Cod stab
$wid3 = "20%"; //descri stab
$wid4 = "15%"; //gruppo
$wid5 = "15%"; //rif geografico
$wid6 = "5%"; //parametri
$wid7 = "10%"; //strumenti
$wid8 = "5%"; //versione software
$wid9 = "7%"; //tipo origami
$wid10 = "3%"; //abilitato
?>
<table class="table3">
    <tr>
        <th colspan="8"><?php echo $labelMenuElencoStab ?></th>
    </tr>
    <tr>
        <td  colspan="8" style="text-align:center;"> 
            <a id="40" href="carica_macchina.php"><?php echo $nuovoStabilimento ?></a>      
        </td>
    </tr>
</table>
<form  name="VediMacchine" id="VediMacchine" action="" method="POST">
    <table class="table3" width="100%">
        <!--###################### RICERCA ######################################-->
        <tr>           
            <td><input style="width:100%" type="text" name="IdMacchina" value="<?php echo $_SESSION['IdMacchina'] ?>"/></td>
            <td><input style="width:100%" type="text" name="CodStab"    value="<?php echo $_SESSION['CodStab'] ?>" /></td>
            <td><input style="width:100%" type="text" name="DescriStab" value="<?php echo $_SESSION['DescriStab'] ?>" /></td>
            <td><input style="width:100%" type="text" name="VersCloudFab" value="<?php echo $_SESSION['VersCloudFab'] ?>" /></td>
            <td><input style="width:100%" type="text" name="TipoOrigami" value="<?php echo $_SESSION['TipoOrigami'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Abilitato" value="<?php echo $_SESSION['Abilitato'] ?>" /></td>
            <td>
                <select  style="width:100%" name="Gruppo" id="Gruppo" onChange="document.forms['VediMacchine'].submit();">
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
                <select style="width:100%" name="Geografico" id="Geografico" onChange="document.forms['VediMacchine'].submit();">
                    <option value="Mondo"><?php echo $mostraTutto ?></option>
                    <option value="<?php echo $_SESSION['Geografico'] ?>" selected="<?php echo $_SESSION['Geografico'] ?>"><?php echo $_SESSION['Geografico'] ?></option>
                    <?php

                    while ($rowGeo = mysql_fetch_array($sqlGeo)) {
                        ?>
                        <option value="<?php echo $rowGeo['geografico']; ?>"><?php echo $rowGeo['geografico']; ?></option>
                    <?php } ?>
                </select>
            </td>           
            <td><img src="/CloudFab/images/icone/lente_piccola.png" onClick="document.forms['VediMacchine'].submit();" title="<?php echo $titleRicerca ?>"/></td>
        </tr>
        <!--################## ORDINAMENTO ######################################-->
        <tr>        
            <td class="cella3" style="width:<?php echo $wid1 ?>"><div id="OrdinaIdMac"><?php echo $filtroId; ?>
                    <button name="Filtro" type="submit" value="id_macchina" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" style="width:<?php echo $wid2 ?>"><div id="OrdinaCodStab"><?php echo $filtroCodice; ?>
                    <button name="Filtro" type="submit" value="cod_stab" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" style="width:<?php echo $wid3 ?>"><div id="OrdinaDescriStab"><?php echo $filtroStabilimento; ?>
                    <button name="Filtro" type="submit" value="descri_stab" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" style="width:<?php echo $wid8 ?>"><div id="OrdinaVersCloudFab"><?php echo $filtroVersioneCloudFab; ?>
                    <button name="Filtro" type="submit" value="user_origami" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" style="width:<?php echo $wid9 ?>"><div id="OrdinaTipoOrigami"><?php echo $filtroTipo; ?>
                    <button name="Filtro" type="submit" value="user_server" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" style="width:<?php echo $wid10 ?>"><div id="OrdinaAbilitato"><?php echo $filtroAbilitato; ?>
                    <button name="Filtro" type="submit" value="m.abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" style="width:<?php echo $wid4 ?>"><div id="OrdinaGruppo"><?php echo $filtroGruppo; ?>
                    <button name="Filtro" type="submit" value="gruppo" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" style="width:<?php echo $wid5 ?>"><div id="OrdinaGeo"><?php echo $filtroGeografico; ?>
                    <button name="Filtro" type="submit" value="geografico" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" colspan="4" style="width:<?php echo $wid6 ?>"><?php echo $filtroParMacchina ?></td>
            <td class="cella3" style="width:<?php echo $wid7 ?>"><?php echo $filtroOperazioni ?></td> 

        </tr>
        <!--#########################################################################-->


        <?php
        echo "<br/>" . $msgRecordTrovati . $trovati . "<br/>";
        echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";
        $i = 1;
        $colore = 1;
        while ($row = mysql_fetch_array($sql)) {
            if ($colore == 1) {
                ?>
                <tr>

                    <td class="cella1" style="width:<?php echo $wid1 ?>"><?php echo($row['id_macchina']) ?></td>
                    <td class="cella1" style="width:<?php echo $wid2 ?>"><?php echo($row['cod_stab']) ?></td>
                    <td class="cella1" style="width:<?php echo $wid3 ?>"><?php echo ($row['descri_stab']) ?></td>
                    <td class="cella1" style="width:<?php echo $wid8 ?>"><?php echo ($row['user_origami']) ?></td>
                    <td class="cella1" style="width:<?php echo $wid9 ?>"><?php echo ($row['user_server']) ?></td>
                    <td class="cella1" style="width:<?php echo $wid10 ?>"><?php echo ($row['abilitato']) ?></td>
                    <td class="cella1" style="width:<?php echo $wid4 ?>"><?php echo($row['gruppo']) ?></td>
                    <td class="cella1" style="width:<?php echo $wid5 ?>"><?php echo($row['geografico']) ?></td>
                    <td class="cella1">
                        <a name="37" href="modifica_valore_par_prod_mac.php?IdMacchina=<?php echo($row['id_macchina']) ?>&FromMenu=1">
                            <img src="/CloudFab/images/pittogrammi/sacchi3_R.png" class="icone" title="<?php echo $titleValParProdMac ?>"/></a></td>
                    <td class="cella1">
                        <a name="37" href="modifica_valore_par_comp_stab.php?IdMacchina=<?php echo($row['id_macchina']) ?>&FromMenu=1">
                            <img src="/CloudFab/images/pittogrammi/componenti_G.png" class="icone" title="<?php echo $filtroParComponenti ?>"/></a></td>
                    <td class="cella1" >
                        <a name="38" href="modifica_valore_par_mac.php?IdMacchina=<?php echo($row['id_macchina']) ?>&FromMenu=1">
                            <img src="/CloudFab/images/pittogrammi/macchina_R.png" class="icone" title="<?php echo $filtroParSingMac ?>"/></a></td>
                    <td class="cella1">  
                        <a name="39" href="modifica_valore_ripristino.php?IdMacchina=<?php echo($row['id_macchina']) ?>&FromMenu=1">
                            <img src="/CloudFab/images/pittogrammi/ripristina_G.png" class="icone" title="<?php echo $filtroParRipristino ?>"/></a></td>
                    <td class="cella1" style="width:<?php echo $wid7 ?>"><nobr>
                        <a name="35" href="modifica_macchina.php?Macchina=<?php echo($row['id_macchina']) ?>">
                            <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="<?php echo $titleModificaStab ?>" title="<?php echo $titleModificaStab ?>"/></a>
                        <a name="36" href="gestione_processo.php?IdMacchina=<?php echo($row['id_macchina']) ?>&DescriStab=<?php echo ($row['descri_stab']) ?>&Filtro=id_processo">
                            <img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone" alt="<?php echo $titleVediProduzione ?>" title="<?php echo $titleVediProduzione ?>"/></a>
                         
                        <a name="140" href="/CloudFab/ftp/gestione_ftp_macchina.php?IdMacchina=<?php echo ($row['id_macchina']) ?>">
                            <img src="/CloudFab/images/ftp4.png" class="icone" style="border-radius: 5px 5px 5px 5px" alt="<?php echo $altFtp ?>" title="<?php echo $titleServerFtp ?>"/></a>
                           
                            </nobr>
                    </td>
                </tr>
                <?php
                $colore = 2;
            } else {
                ?>
                <tr>

                    <td class="cella2" style="width:<?php echo $wid1 ?>"><?php echo($row['id_macchina']) ?></td>
                    <td class="cella2" style="width:<?php echo $wid2 ?>"><?php echo($row['cod_stab']) ?></td>
                    <td class="cella2" style="width:<?php echo $wid3 ?>"><?php echo($row['descri_stab']) ?></td>
                    <td class="cella2" style="width:<?php echo $wid8 ?>"><?php echo($row['user_origami']) ?></td>
                    <td class="cella2" style="width:<?php echo $wid9 ?>"><?php echo($row['user_server']) ?></td>
                    <td class="cella2" style="width:<?php echo $wid10 ?>"><?php echo($row['abilitato']) ?></td>
                    <td class="cella2" style="width:<?php echo $wid4 ?>"><?php echo($row['gruppo']) ?></td>
                    <td class="cella2" style="width:<?php echo $wid5 ?>"><?php echo($row['geografico']) ?></td>
                    <td class="cella2">  
                        <a name="37" href="modifica_valore_par_prod_mac.php?IdMacchina=<?php echo($row['id_macchina']) ?>&FromMenu=1">
                            <img src="/CloudFab/images/pittogrammi/sacchi3_R.png" class="icone" title="<?php echo $filtroCorrettivi ?>"/></a></td>
                    <td class="cella2">    
                        <a name="37" href="modifica_valore_par_comp_stab.php?IdMacchina=<?php echo($row['id_macchina']) ?>&FromMenu=1">
                            <img src="/CloudFab/images/pittogrammi/componenti_G.png" class="icone" title="<?php echo $filtroParComponenti ?>" /></a></td>
                    <td class="cella2">
                        <a name="38" href="modifica_valore_par_mac.php?IdMacchina=<?php echo($row['id_macchina']) ?>&FromMenu=1">
                            <img src="/CloudFab/images/pittogrammi/macchina_R.png" class="icone" title="<?php echo $filtroParSingMac ?>"/></a></td>
                    <td class="cella2">  
                        <a name="39" href="modifica_valore_ripristino.php?IdMacchina=<?php echo($row['id_macchina']) ?>&FromMenu=1">
                        <img src="/CloudFab/images/pittogrammi/ripristina_G.png" class="icone" title="<?php echo $filtroParRipristino ?>"/></a></td>
                        <td class="cella2" style="width:<?php echo $wid7 ?>">
                <nobr>
                        <a name="35" href="modifica_macchina.php?Macchina=<?php echo($row['id_macchina']) ?>">
                            <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="<?php echo $titleModificaStab ?>" title="<?php echo $titleModificaStab ?>"/></a>
                        <a name="36" href="gestione_processo.php?IdMacchina=<?php echo($row['id_macchina']) ?>&DescriStab=<?php echo ($row['descri_stab']) ?>&Filtro=id_processo">
                            <img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone" alt="<?php echo $titleVediProduzione ?>" title="<?php echo $titleVediProduzione ?>"/></a>
                        <a name="140" href="/CloudFab/ftp/gestione_ftp_macchina.php?IdMacchina=<?php echo ($row['id_macchina']) ?>">
                            <img src="/CloudFab/images/ftp4.png" class="icone" style="border-radius: 5px 5px 5px 5px" alt="<?php echo $altFtp ?>" title="<?php echo $titleServerFtp ?>"/></a>
                        
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
