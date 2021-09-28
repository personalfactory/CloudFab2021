<?php
//include('../calendar/visualizza_calendario.php');
//Larghezza colonne 
$wid0 = "100px";
$wid1 = "300px"; // +10px padding (l+r)
$wid2 = "200px"; // +10px padding (l+r)
$wid3 = "200px"; // +10px padding (l+r)
$wid4 = "300px"; // +10px padding (l+r)
$wid5 = "100px";
//TOTALE 1170px
?>

<div style="margin:15px auto ;">
    <form  name="VediProdOri" id="VediProdOri" action="" method="POST">
        <table width="100%">
            <tr>
                <th colspan="6"><?php echo $titoloPaginaProdOri ?></th>
            </tr>
            
            <tr>
                <td  colspan="14" style="text-align:center;"> 
                </td>
            </tr>

            <!--################## ORDINAMENTO ########################################-->
            <tr>              
                <td class="cella3" width="<?php echo $wid0 ?>"><div id="OrdinaId"><?php echo $filtroId; ?>
                        <button name="Filtro" type="submit" value="m.id_macchina ASC" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid1 ?>"><div id="OrdinaSta"><?php echo $filtroStabilimento; ?>
                        <button name="Filtro" type="submit" value="m.descri_stab ASC" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid2 ?>"><div id="OrdinaProcTot"><?php echo $filtroProcTot; ?>
                        <button name="Filtro" type="submit" value="processi_tot DESC" class="button3"  title="<?php echo $titleOrdinaDecr; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid3 ?>"><div id="OrdinaTipo"><?php echo $filtroKitUsati; ?>
                        <button name="Filtro" type="submit" value="chim_usate DESC" class="button3"  title="<?php echo $titleOrdinaDecr; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid4 ?>"><div id="OrdinaSoTipo"><?php echo $filtroDtUltimaProd; ?>
                        <button name="Filtro" type="submit" value="dt_produzione_mac DESC" class="button3"  title="<?php echo $titleOrdinaDecr; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>

                <td class="cella3" style="width: <?php echo $wid5 ?>"><?php echo $filtroOperazioni; ?></td>

            </tr>
            <?php
            $i = 1;
            $colore = 1;
            $totProcessi=0;
            $totChimicaUsata=0;
            while ($row = mysql_fetch_array($sql)) {
                $totProcessi=$totProcessi+$row['processi_tot'];
                $totChimicaUsata=$totChimicaUsata+$row['chim_usate'];
                
                if ($colore == 1) {
                    ?>
                    <tr>
                        <td class="cella1" width="<?php echo $wid0 ?>"><?php echo($row['id_macchina']) ?></td>
                        <td class="cella1" width="<?php echo $wid1 ?>"><?php echo($row['descri_stab']) ?></td>
                        <td class="cella1" style="text-align: right" width="<?php echo $wid2 ?>"><?php echo number_format($row['processi_tot'],0,",",".") ?></td>
                        <td class="cella1" style="text-align: right" width="<?php echo $wid3 ?>"><?php echo number_format($row['chim_usate'],0,",",".") ?></td>
                        <td class="cella1" width="<?php echo $wid4 ?>"><?php echo dataEstraiVisualizza($row['dt_produzione_mac']) ?></td>
                        <td class="cella1" width="<?php echo $wid5 ?>">
                    <nobr> <a href="gestione_magazzino_stab.php?IdMacchina=<?php echo($row['id_macchina']) ?>&DescriStab=<?php echo ($row['descri_stab']) ?>">
                            <img src="/CloudFab/images/pittogrammi/macchina_R.png" class="icone" title="<?php echo $titleMagazzinoOri ?>"/></a>
                        <a href="gestione_processo.php?IdMacchina=<?php echo($row['id_macchina']) ?>&DescriStab=<?php echo ($row['descri_stab']) ?>&Filtro=id_processo">
                            <img src="/CloudFab/images/pittogrammi/insacco_G.png" class="icone"  title="<?php echo $titleVediProc ?>"/></a>
                        <a name="144" href="../produzioneorigami/gestione_valore_allarme.php?IdMacchina=<?php echo($row['id_macchina']) ?>&DescriStab=<?php echo ($row['descri_stab']) ?>&Filtro=id_processo ?>">
                            <img src="/CloudFab/images/pittogrammi/alert_R.png" class="icone"  title="<?php echo $titleVediAllarmi ?>"/></a>
                            <a name="139" href="/CloudFab/produzioneorigami/gestione_movimento_sing_mac.php?IdMacchina=<?php echo ($row['id_macchina']) ?>&DescriStab=<?php echo ($row['descri_stab']) ?>">
                            <img src="/CloudFab/images/pittogrammi/componenti_G.png" class="icone" style="border-radius: 5px 5px 5px 5px" alt="<?php echo $altMovMaterieOri ?>" title="<?php echo $titleMovMateriePrimeOri ?>"/></a>
                        <a name="145" href="./esporta_consumi.php?IdMacchina=<?php echo($row['id_macchina']) ?>">


                            <img src="/CloudFab/images/pittogrammi/download_G.png" class="icone"  title="<?php echo $titleEsportaDati ?>"/></a></nobr>
                    </td>

                    </tr>
                    <?php
                    $colore = 2;
                } else {
                    ?>
                    <tr>
                        <td class="cella2" width="<?php echo $wid0 ?>"><?php echo($row['id_macchina']) ?></td>
                        <td class="cella2" width="<?php echo $wid1 ?>"><?php echo($row['descri_stab']) ?></td>
                        <td class="cella2" style="text-align: right" width="<?php echo $wid2 ?>"><?php echo number_format($row['processi_tot'],0,",",".") ?></td>
                        <td class="cella2" style="text-align: right" width="<?php echo $wid3 ?>"><?php echo number_format($row['chim_usate'],0,",",".") ?></td>
                        <td class="cella2" width="<?php echo $wid4 ?>"><?php echo dataEstraiVisualizza($row['dt_produzione_mac']) ?></td>
                        <td class="cella2" width="<?php echo $wid5 ?>">
                    <nobr><a href="gestione_magazzino_stab.php?IdMacchina=<?php echo($row['id_macchina']) ?>&DescriStab=<?php echo ($row['descri_stab']) ?>">
                            <img src="/CloudFab/images/pittogrammi/macchina_R.png" class="icone" title="<?php echo $titleMagazzinoOri ?>"/></a>
                        <a href="gestione_processo.php?IdMacchina=<?php echo($row['id_macchina']) ?>&DescriStab=<?php echo ($row['descri_stab']) ?>&Filtro=id_processo">
                            <img src="/CloudFab/images/pittogrammi/insacco_G.png" class="icone"  title="<?php echo $titleVediProc ?>"/></a>
                        <a name="144" href="../produzioneorigami/gestione_valore_allarme.php?IdMacchina=<?php echo($row['id_macchina']) ?>&DescriStab=<?php echo ($row['descri_stab']) ?>&Filtro=id_processo">
                            <img src="/CloudFab/images/pittogrammi/alert_R.png" class="icone"  title="<?php echo $titleVediAllarmi ?>"/></a>
                       <a name="139" href="/CloudFab/produzioneorigami/gestione_movimento_sing_mac.php?IdMacchina=<?php echo ($row['id_macchina']) ?>&DescriStab=<?php echo ($row['descri_stab']) ?>">
                            <img src="/CloudFab/images/pittogrammi/componenti_G.png" class="icone" style="border-radius: 5px 5px 5px 5px" alt="<?php echo $altMovMaterieOri ?>" title="<?php echo $titleMovMateriePrimeOri ?>"/></a>
                        <a name="145" href="./esporta_consumi.php.php?IdMacchina=<?php echo($row['id_macchina']) ?>">


                            <img src="/CloudFab/images/pittogrammi/download_G.png" class="icone"  title="<?php echo $titleEsportaDati ?>"/></a></nobr>
                    </td>

                    </tr>
                    <?php
                    $colore = 1;
                }
                $i = $i + 1;
            }?>
             <tr>
                        <td class="dataRigGreen" colspan="2"><?php echo $filtroTotali ?></td>
                        <td class="dataRigGreen" style="text-align: right"><?php echo number_format($totProcessi,0,",",".") ?></td>
                        <td class="dataRigGreen" style="text-align: right"><?php echo number_format($totChimicaUsata,0,",",".") ?></td>
                        <td class="dataRigGreen" colspan="3"</td>
                        
            
             </tr>
        </table>
    </form>
</div>   
