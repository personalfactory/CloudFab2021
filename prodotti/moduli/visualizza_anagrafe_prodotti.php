<?php
//Larghezza colonne 
$widId = "5%"; // +10px padding (l+r)
$widCod = "5%"; // +10px padding (l+r)
$widNome = "20%"; // +10px padding (l+r)
$widPad = "5%"; // +10px padding (l+r)
$widGru ="14";
$widFam = "10%"; // +10px padding (l+r)
$widCat = "17%"; // +10px padding (l+r)
$widAb = "2%"; // +10px padding (l+r)
$widDt = "10%"; // +10px padding (l+r)
$widOp = "12%"; // +10px padding (l+r)
?>
<script language="javascript">
    function Aggiorna() {
        document.forms["VediProdotti"].action = "gestione_anagrafe_prodotti.php";
        document.forms["VediProdotti"].submit();
    }
    
    function AggiornaSelect(num) {       
     
        var string='?condizioneSelectProdotti='+num;
        
        document.forms["VediProdotti"].action = "gestione_anagrafe_prodotti.php";
        document.forms["VediProdotti"].submit();
        location.href=string;
        
    }
</script>
<div style="float:right;width:35%;padding-right:5px;
    border-width: 1px 1px 1px 1px;
    border-style: solid;
    border-color: #CCCCCC #CCCCCC #CCCCCC #CCCCCC;">
     <table>
            <tr>
                <td class="cella2"><a href="#" onclick="AggiornaSelect(1)" title="<?php echo $titleProdottiStandard ?>"><?php echo $filtroProdottiStandard  ?></a></td>
                <td class="cella1"><a href="#" onclick="AggiornaSelect(2)" title="<?php echo $titleProdottiDerivati ?>"><?php echo $filtroProdottiDerivati  ?></a></td>
                <td class=""><a href="#" onclick="AggiornaSelect(3)" title="<?php echo $titleTuttiProdotti ?>"><?php echo $filtroTuttiProdotti  ?></a></td>
            </tr>
        </table>
</div>
<div style="float:none;">
<table class="table3">
    <th colspan="14"><?php echo $titoloPaginaGestioneProdotti ?></th>
    <tr>
        <td colspan="14" style="text-align:center;"> 
            <a id="4" name="4" href="carica_prodotto.php" ><?php echo $nuovoProdotto ?></a>      
        </td>
    </tr>
</table>
    </div>
<div>  
    <!--################## MOTORE DI RICERCA ###################################-->
    <form  name="VediProdotti" id="VediProdotti" action="" method="POST">
        <table class="table3">
            <tr>
                <td><input style="width:100%" type="text" name="IdProdotto" value="<?php echo $_SESSION['IdProdotto'] ?>" /></td>
                <td><input style="width:100%" type="text" name="Codice" value="<?php echo $_SESSION['Codice'] ?>" /></td>
                <td><input style="width:100%" type="text" name="Nome" value="<?php echo $_SESSION['Nome'] ?>" /></td>
                <td><input style="width:100%" type="text" name="Famiglia" value="<?php echo $_SESSION['Famiglia'] ?>" /></td>
                <td><input style="width:100%" type="text" name="Gruppo" value="<?php echo $_SESSION['Gruppo'] ?>" /></td>
                <!--//##### Momentaneamente disabilitata la ricerca sul prodotto padre-->
                <td><input style="width:100%" disabled="disabled" type="text" name="ProdPadre" value="<?php echo $_SESSION['ProdPadre'] ?>" /></td>
                <td><input style="width:100%" type="text" name="Categoria" value="<?php echo $_SESSION['Categoria'] ?>" /></td>
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
                <td><select  style="width:100%"  name="FamigliaList" id="NomeList" onChange="Aggiorna();">
                        <option value="<?php echo $_SESSION['FamigliaList'] ?>" selected="<?php echo $_SESSION['FamigliaList'] ?>"></option>
                        <?php
                        while ($rowFam = mysql_fetch_array($sqlFam)) {
                            ?>
                            <option value="<?php echo $rowFam['descrizione']; ?>"><?php echo $rowFam['descrizione']; ?></option>
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
                <!--//##### Momentaneamente disabilitata la ricerca sul prodotto padre-->
                <td><select disabled="disabled"  style="width:100%" name="ProdPadreList" id="ProdPadreList" onChange="Aggiorna();">
                        <option value="<?php echo $_SESSION['ProdPadreList'] ?>" selected="<?php echo $_SESSION['ProdPadreList'] ?>"></option>
                        <?php
                        while ($rowPad = mysql_fetch_array($sqlPad)) {
                            ?>
                            <option value="<?php echo $rowPad['colorato']; ?>"><?php echo $rowPad['colorato']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select  style="width:100%"  name="CategoriaList" id="CategoriaList" onChange="Aggiorna();">
                        <option value="<?php echo $_SESSION['CategoriaList'] ?>" selected="<?php echo $_SESSION['CategoriaList'] ?>"></option>
                        <?php
                        while ($rowCat = mysql_fetch_array($sqlCat)) {
                            ?>
                            <option value="<?php echo $rowCat['nome_categoria']; ?>"><?php echo $rowCat['nome_categoria']; ?></option>
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
                <td class="cella3" width="<?php echo $widNome ?>"><div id="OrdinaNome"><?php echo $filtroProdotto; ?>
                        <button name="Filtro" type="submit" value="nome_prodotto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $widFam ?>"><div id="OrdinaFam"><?php echo $filtroFamiglia; ?>
                        <button name="Filtro" type="submit" value="cod.descrizione" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $widGru ?>"><div id="OrdinaGru"><?php echo $filtroGruppo; ?>
                        <button name="Filtro" type="submit" value="gruppo" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $widPad ?>"><div id="OrdinaPad"><?php echo $filtroProdotto . " " . $filtroPadre; ?>
                        <button name="Filtro" type="submit" value="colorato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $widCat ?>"><div id="OrdinaCat"><?php echo $filtroCategoria; ?>
                        <button name="Filtro" type="submit" value="nome_categoria" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $widAb ?>"><div id="OrdinaAb"><?php echo $filtroAbilitato; ?>
                        <button name="Filtro" type="submit" value="a.abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $widDt ?>"><div id="OrdinaDt"><?php echo $filtroDt; ?>
                        <button name="Filtro" type="submit" value="p.dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width: <?php echo $widOp ?>"><?php echo $filtroOperazioni; ?></td>
            </tr>
            <?php
            echo "<br/>" . $msgRecordTrovati . $trovati . "<br/>";
            echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";

//            mysql_data_seek($sql,0);

            $colore = 1;
            while ($row = mysql_fetch_array($sql)) {
                $classTd = "cella1";
                //################### COD PRODOTTO PADRE ###################################
                if ($row['colorato'] == "0") {
                    $CodProdottoPadre = "0";
                } else {
                    //Recupero l'id del codice prodotto padre
                    $sqlCodProdPadre = findProdottoById($row['colorato']);
                    while ($rowProdPadre = mysql_fetch_array($sqlCodProdPadre)) {
                        $CodProdottoPadre = $rowProdPadre['cod_prodotto'];
                    }
                }
//##############################################################################

                if ($CodProdottoPadre == $row['cod_prodotto'])
                    $classTd = "cella2";
               
                    ?>
                    <tr>
                        <td class="<?php echo $classTd ?>" style="width:<?php echo $widId ?>"><?php echo ($row['id_prodotto']) ?></td>
                        <td class="<?php echo $classTd ?>" style="width:<?php echo $widCod ?>"><a name="3" href="/CloudFab/prodotti/vista_prodotto_formula.php?Prodotto=<?php echo($row['id_prodotto']) ?>" title="<?php echo $titleDettaglio?>"><?php echo ($row['cod_prodotto']) ?></a></td>
                        <td class="<?php echo $classTd ?>" style="width:<?php echo $widNome ?>"><a name="3" href="vista_prodotti_figli.php?Prodotto=<?php echo($row['id_prodotto']) ?>" title="<?php echo $titleConfrontaProdottiFigli ?>"><?php echo ($row['nome_prodotto']) ?></a></td>
                        <td class="<?php echo $classTd ?>" style="width:<?php echo $widFam ?>"><?php echo ($row['descrizione']) ?></td>
                        <td class="<?php echo $classTd ?>" style="width:<?php echo $widGru ?>"><?php echo $row['gruppo'] ?></td>
                        <td class="<?php echo $classTd ?>" style="width:<?php echo $widPad ?>"><?php echo ($CodProdottoPadre) ?></td>
                        
                        <td class="<?php echo $classTd ?>" style="width:<?php echo $widCat ?>"><?php echo ($row['nome_categoria']) ?></td>
                        <td class="<?php echo $classTd ?>" style="width:<?php echo $widAb ?>"><?php echo ($row['abilitato']) ?></td>
                        <td class="<?php echo $classTd ?>" style="width:<?php echo $widDt ?>"><?php echo ($row['dt_abilitato']) ?></td>
                        <td class="<?php echo $classTd ?>" style="width:<?php echo $widOp ?>">
                            <a name="2" href="modifica_prodotto.php?Prodotto=<?php echo($row['id_prodotto']) ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica ?> "/></a>
                            <a name="101" href="disabilita_prodotto.php?Tabella=anagrafe_prodotto&IdProdotto=<?php echo $row['id_prodotto'] ?>&RefBack=gestione_anagrafe_prodotti.php">
                                <img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone"  title="<?php echo $titleDisabilitaProd ?>"/></a>	
                            <a name="100" href="carica_prodotto.php?IdProdottoPadre=<?php echo($row['id_prodotto']) ?>&CodProdottoPadre=<?php echo($row['cod_prodotto']) ?>">
                                <img src="/CloudFab/images/pittogrammi/freccia_R.png" class="icone"  title="<?php echo $titleCreaProdFiglio ?>"/></a>
                            <a href="gestione_anagrafe_prodotti.php?IdProdottoPadre=<?php echo($row['id_prodotto']) ?>">
                                <img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone"  title="<?php echo $titleVisualizzaProdFigli ?>"/></a>
                        </td>
                    </tr>
        <?php
       
    
}
?>
        </table>