<?php
//Larghezza colonne 
$wid1 = "5%"; // +10px padding (l+r)
$wid2 = "5%"; // +10px padding (l+r)
$wid3 = "30%"; // +10px padding (l+r)
$wid4 = "10%"; // +10px padding (l+r)
$wid5 ="10";
$wid6 = "10%"; // +10px padding (l+r)
$wid7 = "2%"; // +10px padding (l+r)
$wid8 = "10%"; // +10px padding (l+r)
$wid9 = "10%"; // +10px padding (l+r)

?>
<script language="javascript">
    function Aggiorna() {
        document.forms["VediColori"].action = "gestione_anagrafe_colori.php";
        document.forms["VediColori"].submit();
    }
    
    
</script>

<div style="float:none;">
<table class="table3">
    <th colspan="14"><?php echo $labelMenuRicetteColori ?></th>
    <tr>
        <td colspan="14" style="text-align:center;"> 
            <a id="148" name="148" href="carica_colore_new.php" ><?php echo $titoloNewColor ?></a>      
        </td>
    </tr>
</table>
    </div>
<div>  
    <!--################## MOTORE DI RICERCA ###################################-->
    <form  name="VediColori" id="VediColori" action="" method="POST">
        <table class="table3">
            <tr>
                <td><input style="width:100%" type="text" name="IdProdotto" value="<?php echo $_SESSION['IdProdotto'] ?>" /></td>
                <td><input style="width:100%" type="text" name="Codice" value="<?php echo $_SESSION['Codice'] ?>" /></td>
                <td><input style="width:100%" type="text" name="Nome" value="<?php echo $_SESSION['Nome'] ?>" /></td>
                 <td><input style="width:100%" type="text" name="SerieColore" value="<?php echo $_SESSION['SerieColore'] ?>" /></td>
                <td><input style="width:100%" type="text" name="Gruppo" value="<?php echo $_SESSION['Gruppo'] ?>" /></td>
                <td><input style="width:100%" type="text" name="Geografico" value="<?php echo $_SESSION['Geografico'] ?>" /></td>
                <td><input style="width:100%" type="text" name="Abilitato" value="<?php echo $_SESSION['Abilitato'] ?>" /></td>
                <td><input style="width:100%" type="text" name="DtAbilitato" value="<?php echo $_SESSION['DtAbilitato'] ?>" /></td>
                <input  type="hidden" name="condizioneSelectProdotti" value="<?php echo $_SESSION['condizioneSelectProdotti'] ?>" />
            </tr>
            <!--################## RICERCA CON LIST BOX ###############################-->  
            <tr>
                <td><select style="width:100%" name="IdProdottoList" id="IdProdottoList" onChange="Aggiorna();">
                        <option value="<?php echo $_SESSION['IdProdottoList'] ?>" selected="<?php echo $_SESSION['IdProdottoList'] ?>"></option>
                        <?php
                        while ($rowId = mysql_fetch_array($sqlId)) {
                            ?>
                            <option value="<?php echo $rowId['id_prodotto']; ?>"><?php echo $rowId['id_prodotto']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select  style="width:100%"  name="CodiceList" id="CodiceList" onChange="Aggiorna()">
                        <option value="<?php echo $_SESSION['CodiceList'] ?>" selected="<?php echo $_SESSION['CodiceList'] ?>"></option>
                        <?php
                        while ($rowCod = mysql_fetch_array($sqlCod)) {
                            ?>
                            <option value="<?php echo $rowCod['cod_prodotto']; ?>"><?php echo $rowCod['cod_prodotto']; ?></option>
                        <?php } ?>
                    </select></td> 
                <td><select  style="width:100%"  name="NomeList" id="NomeList" onChange="Aggiorna();">
                        <option value="<?php echo $_SESSION['NomeList'] ?>" selected="<?php echo $_SESSION['NomeList'] ?>"></option>
                        <?php
                        while ($rowNome = mysql_fetch_array($sqlNome)) {
                            ?>
                            <option value="<?php echo $rowNome['nome_prodotto']; ?>"><?php echo $rowNome['nome_prodotto']; ?></option>
                        <?php } ?>
                    </select></td> 
               
                     <td><select   style="width:100%" name="SerieColoreList" id="SerieColoreList" onChange="Aggiorna();">
                        <option value="<?php echo $_SESSION['SerieColoreList'] ?>" selected="<?php echo $_SESSION['SerieColoreList'] ?>"></option>
                        <?php
                        while ($rowSerie = mysql_fetch_array($sqlSerie)) {
                            ?>
                            <option value="<?php echo $rowSerie['serie_colore']; ?>"><?php echo $rowSerie['serie_colore']; ?></option>
                        <?php } ?>
                    </select></td>
                    <td><select  style="width:100%"  name="GruppoList" id="GruppoList" onChange="Aggiorna();">
                        <option value="<?php echo $_SESSION['GruppoList'] ?>" selected="<?php echo $_SESSION['GruppoList'] ?>"></option>
                        <?php
                        while ($rowGru = mysql_fetch_array($sqlGru)) {
                            ?>
                            <option value="<?php echo $rowGru['gruppo']; ?>"><?php echo $rowGru['gruppo']; ?></option>
                        <?php } ?>
                    </select></td>               
               
                <td><select  style="width:100%"  name="GeograficoList" id="GeograficoList" onChange="Aggiorna();">
                        <option value="<?php echo $_SESSION['GeograficoList'] ?>" selected="<?php echo $_SESSION['GeograficoList'] ?>"></option>
                        <?php
                        while ($rowGeo = mysql_fetch_array($sqlGeo)) {
                            ?>
                            <option value="<?php echo $rowGeo['geografico']; ?>"><?php echo $rowGeo['geografico']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select  style="width:100%"  name="AbilitatoList" id="AbilitatoList" onChange="Aggiorna();">
                        <option value="<?php echo $_SESSION['AbilitatoList'] ?>" selected="<?php echo $_SESSION['AbilitatoList'] ?>"></option>
                        <?php
                        while ($rowAb = mysql_fetch_array($sqlAbil)) {
                            ?>
                            <option value="<?php echo $rowAb['abilitato']; ?>"><?php echo $rowAb['abilitato']; ?></option>
                        <?php } ?>
                    </select></td>

                <td><select style="width:100%" name="DtAbilitatoList" id="DtAbilitatoList" onChange="Aggiorna();">
                        <option value="<?php echo $_SESSION['DtAbilitatoList'] ?>" selected="<?php echo $_SESSION['DtAbilitatoList'] ?>"></option>
                        <?php
                        while ($rowData = mysql_fetch_array($sqlDt)) {
                            ?>
                            <option value="<?php echo $rowData['dt_abilitato']; ?>"><?php echo $rowData['dt_abilitato']; ?></option>
                        <?php } ?>
                    </select></td>   
                <td><input  type="button" value="<?php echo $valueButtonCerca ?>" onClick="Aggiorna();" /></td>
            </tr>
            <!--################## ORDINAMENTO ########################################-->
            <tr> 
                <td class="cella3" width="<?php echo $widId ?>"><div id="OrdinaId"><?php echo $filtroId; ?>
                        <button name="Filtro" type="submit" value="p.id_prodotto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $widCod ?>"><div id="OrdinaCod"><?php echo $filtroCodice; ?>
                        <button name="Filtro" type="submit" value="cod_prodotto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $widNome ?>"><div id="OrdinaNome"><?php echo $filtroRicettaColore; ?>
                        <button name="Filtro" type="submit" value="nome_prodotto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
              
                <td class="cella3" width="<?php echo $widPad ?>"><div id="OrdinaPad"><?php echo $filtroSerieColore; ?>
                        <button name="Filtro" type="submit" value="serie_colore" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $widGru ?>"><div id="OrdinaGru"><?php echo $filtroGruppo; ?>
                        <button name="Filtro" type="submit" value="gruppo" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                
                <td class="cella3" width="<?php echo $widCat ?>"><div id="OrdinaGeo"><?php echo $filtroGeografico; ?>
                        <button name="Filtro" type="submit" value="geografico" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $widAb ?>"><div id="OrdinaAb"><?php echo $filtroAbilitato; ?>
                        <button name="Filtro" type="submit" value="a.abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $widDt ?>"><div id="OrdinaDt"><?php echo $filtroDt; ?>
                        <button name="Filtro" type="submit" value="dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width: <?php echo $widOp ?>"><?php echo $filtroOperazioni; ?></td>
            </tr>
            <?php
            echo "<br/>" . $msgRecordTrovati . $trovati . "<br/>";
            echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";



            $colore = 1;
            while ($row = mysql_fetch_array($sql)) {
                $classTd = "cella1";
  
               
                    ?>
                    <tr>
                        <td class="<?php echo $classTd ?>" style="width:<?php echo $wid1 ?>"><?php echo ($row['id_prodotto']) ?></td>
                        <td class="<?php echo $classTd ?>" style="width:<?php echo $wid2 ?>"><?php echo ($row['cod_prodotto']) ?></td>
                        <td class="<?php echo $classTd ?>" style="width:<?php echo $wid3 ?>"><?php echo ($row['nome_prodotto']) ?></td>
                        <td class="<?php echo $classTd ?>" style="width:<?php echo $wid4 ?>"><?php echo ($row['serie_colore']) ?></td>
                        <td class="<?php echo $classTd ?>" style="width:<?php echo $wid5 ?>"><?php echo $row['gruppo'] ?></td>
                        <td class="<?php echo $classTd ?>" style="width:<?php echo $wid6 ?>"><?php echo ($row['geografico']) ?></td>
                        <td class="<?php echo $classTd ?>" style="width:<?php echo $wid7 ?>"><?php echo ($row['abilitato']) ?></td>
                        <td class="<?php echo $classTd ?>" style="width:<?php echo $wid8 ?>"><?php echo ($row['dt_abilitato']) ?></td>
                        <td class="<?php echo $classTd ?>" style="width:<?php echo $wid9 ?>">
                            <a name="148" href="modifica_colore_new.php?Prodotto=<?php echo($row['id_prodotto']) ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica ?> "/></a>
                            <a name="148" href="disabilita_prodotto.php?Tabella=anagrafe_prodotto&IdProdotto=<?php echo $row['id_prodotto'] ?>&RefBack=gestione_anagrafe_colori.php">
                                <img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone"  title="<?php echo $titleDisabilitaProd ?>"/></a>	
                        </td>
                    </tr>
        <?php
       
    
}
?>
        </table>