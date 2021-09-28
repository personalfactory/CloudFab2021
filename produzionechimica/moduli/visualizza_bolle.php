<?php
    $wid1 = "5%";
    $wid2 = "10%";
    $wid3 = "20%";
    $wid4 = "10%";
    $wid5 = "25%";
    $wid6 = "10%";
    $wid7 = "15%"; 
    $wid8 = "5%"; 
    ?>
<div style="float:right">
<ul style="font-size:12px; ">
        <li class="dataRigWhite"><?php echo $filtroLegendaDdtAss ?></li>
        <li class="dataRigGray"><?php echo $filtroLegendaDaAss ?></li>   
    </ul>
</div>
<div style="float:center;align:center">
<table class="table3">
    <tr>
        <th colspan="7"><?php echo $titoloPaginaGestioneBolle ?></th>
    </tr>
    <tr>
        <td  colspan="7" style="text-align:center;"> 
            <p><a href="carica_gaz_bolla.php"><?php echo $nuovoDdtVendita ?></a></a></p>
        </td>
    </tr>
</table>
</div>
    <!--################## MOTORE DI RICERCA ###################################-->
    <form  name="VediGazMovMag" id="VediGazMovMag" action="" method="POST">
        <table class="table3">
            <tr>
                <td><input type="text" style="width:100%" name="NumDoc" value="<?php echo $_SESSION['NumDoc'] ?>" /></td>
                <td><input type="text" style="width:100%" name="DtDoc"  value="<?php echo $_SESSION['DtDoc'] ?>" /></td>
                <td><input type="text" style="width:100%" name="DescriStab"  value="<?php echo $_SESSION['DescriStab'] ?>" /></td>
                <td><input type="text" style="width:100%" name="Artico" value="<?php echo $_SESSION['Artico'] ?>" /></td>
                <td><input type="text" style="width:100%" name="DescriArtico" value="<?php echo $_SESSION['DescriArtico'] ?>" /></td>
                <td><input type="text" style="width:100%" name="Quantita" value="<?php echo $_SESSION['Quantita'] ?>" /></td>
                <td><input type="text" style="width:100%" name="DtMov" value="<?php echo $_SESSION['DtMov'] ?>" /></td>
            </tr>
            <!--################## RICERCA CON LIST BOX ###############################-->
            <tr>
                <td><select style="width:100%" name="NumDocList" id="NumDocList" onChange="document.forms['VediGazMovMag'].submit();">
                        <option value="<?php echo $_SESSION['NumDocList'] ?>" selected="<?php echo $_SESSION['NumDocList'] ?>"></option>
                        <?php
                        while ($rowNumDoc = mysql_fetch_array($sqlNumDoc)) {
                            ?>
                            <option value="<?php echo $rowNumDoc['num_doc']; ?>"><?php echo $rowNumDoc['num_doc']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select  style="width:100%" name="DtDocList" id="DtDocList" onChange="document.forms['VediGazMovMag'].submit();">
                        <option value="<?php echo $_SESSION['DtDocList'] ?>" selected="<?php echo $_SESSION['DtDocList'] ?>"></option>
                        <?php
                        while ($rowDtDoc = mysql_fetch_array($sqlDtDoc)) {
                            ?>
                            <option value="<?php echo $rowDtDoc['dt_doc']; ?>"><?php echo $rowDtDoc['dt_doc']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select  style="width:100%"  name="DescriStabList" id="DescriStabList" onChange="document.forms['VediGazMovMag'].submit();">
                        <option value="<?php echo $_SESSION['DescriStabList'] ?>" selected="<?php echo $_SESSION['DescriStabList'] ?>"></option>
                        <?php
                        while ($rowStab = mysql_fetch_array($sqlDesStab)) {
                            ?>
                            <option value="<?php echo $rowStab['descri_stab']; ?>"><?php echo $rowStab['descri_stab']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select style="width:100%" name="ArticoList" id="ArticoList" onChange="document.forms['VediGazMovMag'].submit();">
                        <option value="<?php echo $_SESSION['ArticoList'] ?>" selected="<?php echo $_SESSION['ArticoList'] ?>"></option>
                        <?php
                        while ($rowArt = mysql_fetch_array($sqlArticolo)) {
                            ?>
                            <option value="<?php echo $rowArt['artico']; ?>"><?php echo $rowArt['artico']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select  style="width:100%"  name="DescriArticoList" id="DescriArticoList" onChange="document.forms['VediGazMovMag'].submit();">
                        <option value="<?php echo $_SESSION['DescriArticoList'] ?>" selected="<?php echo $_SESSION['DescriArticoList'] ?>"></option>
                        <?php
                        while ($rowDescriArt = mysql_fetch_array($sqlDescriArt)) {
                            ?>
                            <option value="<?php echo $rowDescriArt['descri_artico']; ?>"><?php echo $rowDescriArt['descri_artico']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select  style="width:100%"  name="QuantitaList" id="QuantitaList" onChange="document.forms['VediGazMovMag'].submit();">
                        <option value="<?php echo $_SESSION['QuantitaList'] ?>" selected="<?php echo $_SESSION['QuantitaList'] ?>"></option>
                        <?php
                        while ($rowQta = mysql_fetch_array($sqlQta)) {
                            ?>
                            <option value="<?php echo $rowQta['quanti']; ?>"><?php echo $rowQta['quanti']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select  style="width:100%"  name="DtMovList" id="DtMovList" onChange="document.forms['VediGazMovMag'].submit();">
                        <option value="<?php echo $_SESSION['DtMovList'] ?>" selected="<?php echo $_SESSION['DtMovList'] ?>"></option>
                        <?php
                        while ($rowDtMov = mysql_fetch_array($sqlDtMov)) {
                            ?>
                            <option value="<?php echo $rowDtMov['dt_mov']; ?>"><?php echo $rowDtMov['dt_mov']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><input type="button" value="<?php echo $valueButtonCerca ?>" onClick="document.forms['VediGazMovMag'].submit();" style="width: 90px"/></td>
            </tr>

            <!--################## ORDINAMENTO ########################################-->
            <tr>              

                <td class="cella3" style="width:<?php echo $wid1 ?>"><div id="OrdinaNumDoc"><?php echo $filtroNumDoc; ?>
                        <button name="Filtro" type="submit" value="num_doc" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $wid2 ?>"><div id="OrdinaDtDoc"><?php echo $filtroDataDoc; ?>
                        <button name="Filtro" type="submit" value="dt_doc" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $wid3 ?>"><div id="OrdinaDesStab"><?php echo $filtroStabilimento; ?>
                        <button name="Filtro" type="submit" value="descri_stab" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $wid4 ?>"><div id="OrdinaArtico"><?php echo $filtroArticolo; ?>
                        <button name="Filtro" type="submit" value="artico" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $wid5 ?>"><div id="OrdinaDescriArtico"><?php echo $filtroDescrizione; ?>
                        <button name="Filtro" type="submit" value="descri_artico" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $wid6 ?>"><div id="OrdinaQta"><?php echo $filtroQuantita; ?>
                        <button name="Filtro" type="submit" value="quanti" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $wid7 ?>"><div id="OrdinaDtMov"><?php echo $filtroDt; ?>
                        <button name="Filtro" type="submit" value="dt_mov" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $wid8 ?>"><?php echo $filtroOperazioni; ?></td>
            </tr>
            <?php
            echo "<br/>" . $msgRecordTrovati . $trovati . "<br/>";
            echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";

            $totQuantita=0;
            while ($row = mysql_fetch_array($sql)) {
                $totQuantita=$totQuantita+$row['quanti'];
                
                $nomeClasse = "dataRigWhite";
                $nomeTitle = $msgInfoDdtAssociato;

                if (!is_numeric($row['id_bolla'])) {
                    $nomeClasse = "dataRigGray";
                    $nomeTitle = $msgInfoDdtNonAssociato;
                };

if($row['descri_stab']!="")  $descriStab=$row['descri_stab'];
else $descriStab=$filtroAltroCliente;
                ?>
                <tr>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid1 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['num_doc'] ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid2 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['dt_doc'] ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid3 ?>" title="<?php echo $nomeTitle ?>"><?php echo $descriStab ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid4 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['artico'] ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid5 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['descri_artico'] ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid6 ?>" style="text-align:center" title="<?php echo $nomeTitle ?>"><?php echo $row['quanti'] . " ".$filtroPz?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid7 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['dt_mov'] ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid8 ?>">    
                        

                            <?php if (!is_numeric($row['id_bolla'])) { ?>
                            <a href="elimina_ddt_vendita.php?NumDoc=<?php echo $row['num_doc'] ?>&DatDoc=<?php echo $row['dt_doc'] ?>">
                                <img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone"  title="<?php echo $titleElimina ?> "/></a>&nbsp;
                <?php } else {?>
                    
                    <a href="dettaglio_bolla.php?NumBolla=<?php echo($row['num_doc']) ?>&DtBolla=<?php echo($row['dt_doc']) ?>">
                            <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="Modifica" title="MODIFICA"/></a>
                    
                <?php }?>
                    </td>   
                </tr>
                
                <?php
            }
            ?>
                
                <tr>
                    <td class="dataRigYellBig" colspan="5"></td>
                    <td class="dataRigYellBig" style="text-align:center" ><?php echo $totQuantita . " ".$filtroPz?></td>
                    <td class="dataRigYellBig" colspan="2"></td>
                </tr> 
        </table>
