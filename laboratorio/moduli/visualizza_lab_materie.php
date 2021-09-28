<?php
    $wid1 = "15%";
    $wid2 = "15%";
    $wid3 = "10%";
    $wid4 = "25%";
    $wid5 = "20%";
    $wid6 = "10%";
    $wid7 = "5%"; 
    ?>
<script language="javascript">   
    
    function AggiornaSelect(num) {       
     
        var string='?condizioneSelect='+num;
        
        document.forms["VediMatPri"].action = "gestione_lab_materie.php";
        document.forms["VediMatPri"].submit();
        location.href=string;
        
    }
</script>
<div style="float:right;padding-right:5px;
    border-width: 1px 1px 1px 1px;
    border-style: solid;
    border-color: #CCCCCC #CCCCCC #CCCCCC #CCCCCC;">
     <table>
            <tr>
                <td class="cella2"><a href="#" onclick="AggiornaSelect(1)" title="<?php echo $titleMostraColori ?>"><?php echo $filtroPigmenti  ?></a></td>
                <td class="cella1"><a href="#" onclick="AggiornaSelect(2)" title="<?php echo $titleMostraDrymix ?>"><?php echo $filtroDrymix  ?></a></td>
                <td class="cella2"><a href="#" onclick="AggiornaSelect(3)" title="<?php echo $titleMostraCompound ?>"><?php echo $filtroBreveCompound  ?></a></td>
                <td class="cella1"><a href="#" onclick="AggiornaSelect(4)" title="<?php echo $titleMostraCompound ?>"><?php echo $filtroAdditivi  ?></a></td>
                <td class="cella2"><a href="#" onclick="AggiornaSelect(5)" title="<?php echo $titleMostraTutto ?>"><?php echo $mostraTutto  ?></a></td>
            </tr>
        </table>
</div>
<div style="float:none;">
<table class="table3">
    <tr>
        <th colspan="6"><?php echo $titoloPaginaLabMateriePrime ?></th>
    </tr>
    <tr>
        <td  colspan="6" style="text-align:center;"> 
            <a name="32" href="carica_lab_materia.php"><?php echo $nuovaLabMatPrima ?></a><br/>
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
         <td  colspan="6" style="text-align:center;"> 
                      <a href="genera_cod_barre_all.php">
                        <img src="/CloudFab/images/pittogrammi/stampa_G.png" class="icone"  title="<?php echo $filtroStampaTuttiCodici ?>"/></a>
        </td>
    </tr>
</table>
</div>
    <!--################## MOTORE DI RICERCA ###################################-->
    <form  name="VediMatPri" id="VediMatPri" action="" method="POST">
        <table class="table3">
            <tr>
                <td ><input style="width:100%" type="text" name="Famiglia" value="<?php echo $_SESSION['Famiglia'] ?>" /></td>
                <td ><input style="width:100%" type="text" name="Tipo" value="<?php echo $_SESSION['Tipo'] ?>" /></td>
                <td ><input style="width:100%" type="text" name="Codice" value="<?php echo $_SESSION['Codice'] ?>" /></td>
                <td ><input style="width:100%" type="text" name="Descri" value="<?php echo $_SESSION['Descri'] ?>" /></td>
                <td ><input style="width:100%" type="text" name="Fornitore" value="<?php echo $_SESSION['Fornitore'] ?>" /></td>
                <td ><input style="width:100%" type="text" name="DtAbilitato" value="<?php echo $_SESSION['DtAbilitato'] ?>" /></td>
            </tr>
            <!--################## RICERCA CON LIST BOX ###############################-->
            <tr>
                <td>
                    <select style="width:100%" name="FamigliaList" id="FamigliaList" onChange="document.forms['VediMatPri'].submit();">
                        <option value="<?php echo $_SESSION['FamigliaList'] ?>" selected="<?php echo $_SESSION['FamigliaList'] ?>"></option>
                        <?php
                        while ($rowFamiglia = mysql_fetch_array($sqlFamiglia)) {
                            ?>
                            <option value="<?php echo $rowFamiglia['famiglia']; ?>"><?php echo $rowFamiglia['famiglia']; ?></option>
                        <?php } ?>
                    </select></td>
                    <td>
                    <select style="width:100%" name="TipoList" id="TipoList" onChange="document.forms['VediMatPri'].submit();">
                        <option value="<?php echo $_SESSION['TipoList'] ?>" selected="<?php echo $_SESSION['TipoList'] ?>"></option>
                        <?php
                        while ($rowTipo = mysql_fetch_array($sqlTipo)) {
                            ?>
                            <option value="<?php echo $rowTipo['tipo']; ?>"><?php echo $rowTipo['tipo']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select  style="width:100%" name="CodiceList" id="CodiceList" onChange="document.forms['VediMatPri'].submit();">
                        <option value="<?php echo $_SESSION['CodiceList'] ?>" selected="<?php echo $_SESSION['CodiceList'] ?>"></option>
                        <?php
                        while ($rowCodice = mysql_fetch_array($sqlCodice)) {
                            ?>
                            <option value="<?php echo $rowCodice['cod_mat']; ?>"><?php echo $rowCodice['cod_mat']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select style="width:100%" name="DescriList" id="DescriList" onChange="document.forms['VediMatPri'].submit();">
                        <option value="<?php echo $_SESSION['DescriList'] ?>" selected="<?php echo $_SESSION['DescriList'] ?>"></option>
                        <?php
                        while ($rowDescri = mysql_fetch_array($sqlDescri)) {
                            ?>
                            <option value="<?php echo $rowDescri['descri_materia']; ?>"><?php echo $rowDescri['descri_materia']; ?></option>
                        <?php } ?>
                    </select></td>
                
                <td><select style="width:100%" name="FornitoreList" id="FornitoreList" onChange="document.forms['VediMatPri'].submit();">
                        <option value="<?php echo $_SESSION['FornitoreList'] ?>" selected="<?php echo $_SESSION['FornitoreList'] ?>"></option>
                        <?php
                        while ($rowForn = mysql_fetch_array($sqlForn)) {
                            ?>
                            <option value="<?php echo $rowForn['fornitore']; ?>"><?php echo $rowForn['fornitore']; ?></option>
                        <?php } ?>
                    </select></td>
                    
                <td><select  style="width:100%"  name="DtAbilitatoList" id="DtAbilitatoList" onChange="document.forms['VediMatPri'].submit();">
                        <option value="<?php echo $_SESSION['DtAbilitatoList'] ?>" selected="<?php echo $_SESSION['DtAbilitatoList'] ?>"></option>
                        <?php
                        while ($rowDtAbil = mysql_fetch_array($sqlDtAbil)) {
                            ?>
                            <option value="<?php echo $rowDtAbil['dt_abilitato']; ?>"><?php echo $rowDtAbil['dt_abilitato']; ?></option>
                        <?php } ?>
                    </select></td>
                    <td ><input type="button" value="<?php echo $valueButtonCerca ?>" onClick="document.forms['VediMatPri'].submit();" style="width: 80px"/></td>
            </tr>
            <!--################## ORDINAMENTO ########################################-->
            <tr>              
                <td class="cella3" width="<?php echo $wid1 ?>"><div id="OrdinaFamiglia"><?php echo $filtroFamiglia; ?>
                        <button name="Filtro" type="submit" value="famiglia" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid2 ?>"><div id="OrdinaTipo"><?php echo $filtroLabSottoTipo; ?>
                        <button name="Filtro" type="submit" value="tipo" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid3 ?>"><div id="OrdinaCodice"><?php echo $filtroLabCodice; ?>
                        <button name="Filtro" type="submit" value="cod_mat" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid4 ?>"><div id="OrdinaDescri"><?php echo $filtroLabNome; ?>
                        <button name="Filtro" type="submit" value="descri_materia" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                
                <td class="cella3" width="<?php echo $wid5 ?>"><div id="OrdinaFornitore"><?php echo $filtroLabFornitore; ?>
                        <button name="Filtro" type="submit" value="fornitore" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                
                <td class="cella3" width="<?php echo $wid6 ?>"><div id="OrdinaDtabil"><?php echo $filtroLabData; ?>
                        <button name="Filtro" type="submit" value="dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid7 ?>"><?php echo $filtroOperazioni; ?></td>
            </tr>
            <?php
            echo "<br/>" . $msgLabMaterieTrovate . $trovati . "<br/>";
            echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";         
            
    $colore = 1;
    $strInfoCodiceBarre="";
    while ($row = mysql_fetch_array($sql)) {
        $strInfoCodiceBarre="";
        $strInfoCodiceBarre=$row['cod_mat'].";".$row['descri_materia'].";".$row['tipo'].";".$row['famiglia'].";".$row['fornitore'].";".$row['prezzo'].";".$row['scaffale'].";".$row['ripiano'].";".$row['note'].";".$row['dt_abilitato'];
        
        if ($colore == 1) {
            ?>
            <tr>
                <td class="cella1" width="<?php echo $wid1 ?>"><?php echo($row['famiglia']) ?></td> 
                <td class="cella1" width="<?php echo $wid2 ?>"><?php echo($row['tipo']) ?></td> 
                <td class="cella1" width="<?php echo $wid3 ?>"><?php echo($row['cod_mat']) ?></td>  
                <td class="cella1" width="<?php echo $wid4 ?>"><?php echo($row['descri_materia']) ?></td>
                <td class="cella1" width="<?php echo $wid5 ?>"><?php echo($row['fornitore']) ?></td>
                <td class="cella1" width="<?php echo $wid6 ?>"><?php echo($row['dt_abilitato']) ?></td>
                <td class="cella1" width="<?php echo $wid7 ?>">
                    <!--<a href="cancella_lab_materia.php?IdMateria=<?php echo($row['id_mat']) ?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="Elimina" title="Clicca per cancellare "/></a>&nbsp;-->                    
                    <a name="29" href="modifica_lab_materia.php?IdMateria=<?php echo($row['id_mat']) ?>&Pagina=<?php echo $Pagina; ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="<?php echo $titleModifica?>" title="<?php echo $titleModifica?>"/></a>
                    <a target="_blank" href="genera_cod_barre.php?strInfoCodiceBarre=<?php echo $strInfoCodiceBarre?>">
                        <img src="/CloudFab/images/pittogrammi/stampa_G.png" class="icone"  title="<?php echo $titleGeneraCodiceBarre ?>"/></a>
                    
                </td>
            </tr>
            <?php
            $colore = 2;
        } else {
            ?>
            <tr>
                <td class="cella2" width="<?php echo $wid1 ?>"><?php echo($row['famiglia']) ?></td> 
                <td class="cella2" width="<?php echo $wid2 ?>"><?php echo($row['tipo']) ?></td> 
                <td class="cella2" width="<?php echo $wid3 ?>"><?php echo($row['cod_mat']) ?></td>
                <td class="cella2" width="<?php echo $wid4 ?>"><?php echo($row['descri_materia']) ?></td>
                <td class="cella2" width="<?php echo $wid5 ?>"><?php echo($row['fornitore']) ?></td>
                <td class="cella2" width="<?php echo $wid6 ?>"><?php echo($row['dt_abilitato']) ?></td>
                <td class="cella2" width="<?php echo $wid7 ?>">
                    <!--<a href="cancella_lab_materia.php?IdMateria=<?php echo($row['id_mat']) ?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="Elimina" title="Clicca per cancellare "/></a>&nbsp;-->
                    <a name="29" href="modifica_lab_materia.php?IdMateria=<?php echo($row['id_mat']) ?>&Pagina=<?php echo $Pagina; ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="<?php echo $titleModifica?>" title="<?php echo $titleModifica?>"/></a>
                    <a target="_blank" href="genera_cod_barre.php?strInfoCodiceBarre=<?php echo $strInfoCodiceBarre?>">
                    <img src="/CloudFab/images/pittogrammi/stampa_G.png" class="icone"  title="<?php echo $titleGeneraCodiceBarre ?>"/></a>
                </td>
            </tr>
            <?php
            $colore = 1;
        }
    }
    ?>
</table>