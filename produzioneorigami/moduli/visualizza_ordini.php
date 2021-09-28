<?php
    $wid1 = "5%";
    $wid2 = "10%";
    $wid3 = "20%";
    $wid4 = "30%";
    $wid5 = "10%";
    $wid6 = "10%";
    $wid7 = "10%"; 
    $wid8 = "5%"; 
    ?>

<div style="float:center;align:center">
<table class="table3">
    <tr>
        <th colspan="7"><?php echo $titoloPaginaProgrammazioneOrdini ?></th>
    </tr>
    <tr>
        <td  colspan="7" style="text-align:center;"> 
            <p><a name="142" href="carica_programma_ori.php"><?php echo $filtroNuovoOrdine ?></a></p>
        </td>
    </tr>
</table>
    
</div>
    <!--################## MOTORE DI RICERCA ###################################-->
    <form  name="VediOrdini" id="VediOrdini" action="" method="POST">
        <table class="table3">
            <tr>
                <td><input type="text" style="width:100%" name="IdOrdine" value="<?php echo $_SESSION['IdOrdine'] ?>" /></td>
                <td><input type="text" style="width:100%" name="DtProgrammata"  value="<?php echo $_SESSION['DtProgrammata']?>" /></td>
                <td><input type="text" style="width:100%" name="DescriStab"  value="<?php echo $_SESSION['DescriStab'] ?>" /></td>
                <td><input type="text" style="width:100%" name="NomeProdotto" value="<?php echo $_SESSION['NomeProdotto'] ?>" /></td>
                <td><input type="text" style="width:100%" name="NumPezzi" value="<?php echo $_SESSION['NumPezzi'] ?>" /></td>
                <td><input type="text" style="width:100%" name="OrdineProduzione" value="<?php echo $_SESSION['OrdineProduzione'] ?>" /></td>
                <td><input type="text" style="width:100%" name="Stato" value="<?php echo $_SESSION['DescriStato'] ?>" /></td>
            </tr>
            <!--################## RICERCA CON LIST BOX ###############################-->
        
            
            <tr>
                <td><select style="width:100%" name="IdOrdineList" id="IdOrdineList" onChange="document.forms['VediOrdini'].submit();">
                        <option value="<?php echo $_SESSION['IdOrdineList'] ?>" selected="<?php echo $_SESSION['IdOrdineList'] ?>"></option>
                        <?php
                        while ($row = mysql_fetch_array($sqlId)) {
                            ?>
                            <option value="<?php echo $row['id_ordine']; ?>"><?php echo $row['id_ordine']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select  style="width:100%" name="DtProgrammataList" id="DtDocList" onChange="document.forms['VediOrdini'].submit();">
                        <option value="<?php echo $_SESSION['DtProgrammataList'] ?>" selected="<?php echo $_SESSION['DtProgrammataList'] ?>"></option>
                        <?php
                        while ($row = mysql_fetch_array($sqlDtProgrammata)) {
                            ?>
                            <option value="<?php echo $row['dt_programmata']; ?>"><?php echo $row['dt_programmata']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select  style="width:100%"  name="DescriStabList" id="DescriStabList" onChange="document.forms['VediOrdini'].submit();">
                        <option value="<?php echo $_SESSION['DescriStabList'] ?>" selected="<?php echo $_SESSION['DescriStabList'] ?>"></option>
                        <?php
                        while ($rowStab = mysql_fetch_array($sqlStab)) {
                            ?>
                            <option value="<?php echo $rowStab['descri_stab']; ?>"><?php echo $rowStab['descri_stab']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select style="width:100%" name="NomeProdottoList" id="NomeProdottoList" onChange="document.forms['VediOrdini'].submit();">
                        <option value="<?php echo $_SESSION['NomeProdottoList'] ?>" selected="<?php echo $_SESSION['NomeProdottoList'] ?>"></option>
                        <?php
                        while ($row = mysql_fetch_array($sqlProd)) {
                            ?>
                            <option value="<?php echo $row['nome_prodotto']; ?>"><?php echo $row['nome_prodotto']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select  style="width:100%"  name="NumPezziList" id="NumPezziList" onChange="document.forms['VediOrdini'].submit();">
                        <option value="<?php echo $_SESSION['NumPezziList'] ?>" selected="<?php echo $_SESSION['NumPezziList'] ?>"></option>
                        <?php
                        while ($row = mysql_fetch_array($sqlNumPezzi)) {
                            ?>
                            <option value="<?php echo $row['num_pezzi']; ?>"><?php echo $row['num_pezzi']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select  style="width:100%"  name="OrdineProduzioneList" id="OrdineProduzioneList" onChange="document.forms['VediOrdini'].submit();">
                        <option value="<?php echo $_SESSION['OrdineProduzioneList'] ?>" selected="<?php echo $_SESSION['OrdineProduzioneList'] ?>"></option>
                        <?php
                        while ($row = mysql_fetch_array($sqlOrdineProd)) {
                            ?>
                            <option va$_SESSION['Filtro']lue="<?php echo $row['ordine_produzione']; ?>"><?php echo $row['ordine_produzione']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select  style="width:100%"  name="DescriStatoList" id="StatoList" onChange="document.forms['VediOrdini'].submit();">
                        <option value="<?php echo $_SESSION['DescriStatoList'] ?>" selected="<?php echo $_SESSION['DescriStatoList'] ?>"></option>
                        <?php
                        while ($row = mysql_fetch_array($sqlStato)) {
                            ?>
                            <option value="<?php echo $row['descri_stato']; ?>"><?php echo $row['descri_stato']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><input type="button" value="<?php echo $valueButtonCerca ?>" onClick="document.forms['VediOrdini'].submit();" style="width: 90px"/></td>
            </tr>

            <!--################## ORDINAMENTO ########################################-->
            <tr>              

                <td class="cella3" style="width:<?php echo $wid1 ?>"><div id="OrdinaNumDoc"><?php echo $filtroIdOrdine; ?>
                        <button name="Filtro" type="submit" value="o.id_ordine" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $wid2 ?>"><div id="OrdinaDtDoc"><?php echo $filtroDtProgrammata; ?>
                        <button name="Filtro" type="submit" value="dt_programmata" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $wid3 ?>"><div id="OrdinaDesStab"><?php echo $filtroStabilimento; ?>
                        <button name="Filtro" type="submit" value="descri_stab" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $wid4 ?>"><div id="OrdinaProd"><?php echo $filtroProdotto; ?>
                        <button name="Filtro" type="submit" value="nome_prodotto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $wid5 ?>"><div id="NumPezziArtico"><?php echo $filtroNumPezzi ?>
                        <button name="Filtro" type="submit" value="num_pezzi" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $wid6 ?>"><div id="OrdinaOrdineProd"><?php echo $filtroOrdineProduzione; ?>
                        <button name="Filtro" type="submit" value="ordine_produzione" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $wid7 ?>"><div id="OrdinaStato"><?php echo $filtroStato; ?>
                        <button name="Filtro" type="submit" value="s.descri_stato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $wid8 ?>"><?php echo $filtroOperazioni; ?></td>
            </tr>
            <?php
            echo "<br/>" . $msgRecordTrovati . $trovati . "<br/>";
            echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";


            while ($row = mysql_fetch_array($sql)) {
                
                $nomeClasse = "dataRigGray";
                $nomeTitle = "";
                
//Ordine da evadere
                if ($row['stato']==0){
                    $nomeClasse = "dataRigWhite";
                    $nomeTitle = "";
                };
                ?>
                <tr>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid1 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['id_ordine'] ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid2 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['dt_programmata'] ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid3 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['descri_stab'] ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid4 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['nome_prodotto'] ?></td>
                    <td class="<?php echo $nomeClasse; ?>" style="text-align: center" width="<?php echo $wid5 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['num_pezzi']." ".$filtroPz." ".$filtroDa." ".$row['kg_pezzo'] ." ".$filtroKgBreve?></td>
                    <td class="<?php echo $nomeClasse; ?>" style="text-align: center" width="<?php echo $wid6 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['ordine_produzione'] ?></td>
                    <td class="<?php echo $nomeClasse; ?>" style="text-align: center" width="<?php echo $wid7 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['descri_stato'] ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid8 ?>">    
                <nobr>
                   <a name="2" href="disabilita_ordine_sm.php?Tabella=ordine_sm&idOrdine=<?php echo $row['id_ordine'] ?>&idOrdineSm=<?php echo $row['id_ordine_sm'] ?>&RefBack=gestione_ordini.php"><img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone" title="<?php echo $titleElimina ?> "/></a>
                         <a name="2" href="salta_ordine_sm.php?Tabella=ordine_sm&idOrdine=<?php echo $row['id_ordine'] ?>&idOrdineSm=<?php echo $row['id_ordine_sm'] ?>&RefBack=gestione_ordini.php&stato=<?php echo $row['stato']?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleCambioStato ?> "/></a>
                         <a href="dettaglio_ordine.php?IdOrdine=<?php echo($row['id_ordine']) ?>">
                    <img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone"  title="<?php echo $titleDettaglio ?>"/></a>
                </nobr>
                    </td>   
                </tr>
                <?php
            }
            ?>
        </table>
