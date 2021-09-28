<?php
$wid1 = "10%";
$wid2 = "15%";
$wid3 = "15%";
$wid4 = "15%";
$wid5 = "15%";
$wid6 = "15%";
$wid7 = "5%";
?>
<div style="float:right">
<table>
    <tr>
        <td class="<?php echo $nomeClasse ?>">
            <a href="<?php echo $hrefToDo ?>"><?php echo $filtroLegendaLotti ?></a></td>

    </tr>
</table>
    </div>
<table class="table3">
    <tr>
        <th colspan="7"><?php echo $titoloPagina ?></th>
    </tr>
    <tr>
        <td  colspan="7" style="text-align:center;"> 
            <p><a href="carica_mov_lotto.php"><?php echo $filtroScaricaLotti ?></a></p>
            <p>&nbsp;</p>
        </td>
    </tr>
    
    <!--################## MOTORE DI RICERCA ###################################-->
    <form  name="VediKitChimici" id="VediKitChimici" action="" method="POST">
        <table class="table3">
            <tr>
                <td><input type="text" style="width:100%" name="CodProdotto" value="<?php echo $_SESSION['CodProdotto'] ?>" /></td>
                <td><input type="text" style="width:100%" name="Descrizione" value="<?php echo $_SESSION['Descrizione'] ?>" /></td>
                <td><input type="text" style="width:100%" name="CodLotto" value="<?php echo $_SESSION['CodLotto'] ?>" /></td>
                <td><input type="text" style="width:100%" name="CodChimica" value="<?php echo $_SESSION['CodChimica'] ?>" /></td>
                <td><input type="text" style="width:100%" name="Data" value="<?php echo $_SESSION['Data'] ?>" /></td>
                <td><input type="text" style="width:100%" name="DtAbilitato" value="<?php echo $_SESSION['DtAbilitato'] ?>" /></td>
            </tr>
            <!--################## RICERCA CON LIST BOX ###############################-->
            <tr>
                <td><select style="width:100%" name="CodProdottoList" id="CodProdottoList" onChange="document.forms['VediKitChimici'].submit();">
                        <option value="<?php echo $_SESSION['CodProdottoList'] ?>" selected="<?php echo $_SESSION['CodProdottoList'] ?>"></option>
                        <?php
                        while ($rowProd = mysql_fetch_array($sqlProd)) {
                            ?>
                            <option value="<?php echo $rowProd['cod_prodotto']; ?>"><?php echo $rowProd['cod_prodotto']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select  style="width:100%" name="DescrizioneList" id="DescrizioneList" onChange="document.forms['VediKitChimici'].submit();">
                        <option value="<?php echo $_SESSION['DescrizioneList'] ?>" selected="<?php echo $_SESSION['DescrizioneList'] ?>"></option>
                        <?php
                        while ($rowDescri = mysql_fetch_array($sqlDescri)) {
                            ?>
                            <option value="<?php echo $rowDescri['descri_formula']; ?>"><?php echo $rowDescri['descri_formula']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select  style="width:100%"  name="CodLottoList" id="CodLottoList" onChange="document.forms['VediKitChimici'].submit();">
                        <option value="<?php echo $_SESSION['CodLottoList'] ?>" selected="<?php echo $_SESSION['CodLottoList'] ?>"></option>
                        <?php
                        while ($rowCodLot = mysql_fetch_array($sqlCodLot)) {
                            ?>
                            <option value="<?php echo $rowCodLot['cod_lotto']; ?>"><?php echo $rowCodLot['cod_lotto']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select style="width:100%" name="CodChimicaList" id="CodChimicaList" onChange="document.forms['VediKitChimici'].submit();">
                        <option value="<?php echo $_SESSION['CodChimicaList'] ?>" selected="<?php echo $_SESSION['CodChimicaList'] ?>"></option>
                        <?php
                        while ($rowCodChim = mysql_fetch_array($sqlCodChim)) {
                            ?>
                            <option value="<?php echo $rowCodChim['cod_chimica']; ?>"><?php echo $rowCodChim['cod_chimica']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select  style="width:100%"  name="DataList" id="DataList" onChange="document.forms['VediKitChimici'].submit();">
                        <option value="<?php echo $_SESSION['DataList'] ?>" selected="<?php echo $_SESSION['DataList'] ?>"></option>
                        <?php
                        while ($rowData = mysql_fetch_array($sqlData)) {
                            ?>
                            <option value="<?php echo $rowData['data']; ?>"><?php echo $rowData['data']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select  style="width:100%"  name="DtAbilitatoList" id="DtAbilitatoList" onChange="document.forms['VediKitChimici'].submit();">
                        <option value="<?php echo $_SESSION['DtAbilitatoList'] ?>" selected="<?php echo $_SESSION['DtAbilitatoList'] ?>"></option>
                        <?php
                        while ($rowDtAbil = mysql_fetch_array($sqlDtAbil)) {
                            ?>
                            <option value="<?php echo $rowDtAbil['dt_abilitato']; ?>"><?php echo $rowDtAbil['dt_abilitato']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><input type="button" value="<?php echo $valueButtonCerca ?>" onClick="document.forms['VediKitChimici'].submit();" style="width: 90px"/></td>
            </tr>

            <!--################## ORDINAMENTO ########################################-->
            <tr>              
                <td class="cella3" width="<?php echo $wid1 ?>"><div id="OrdinaProd"><?php echo $filtroProdotto; ?>
                        <button name="Filtro" type="submit" value="cod_prodotto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid2 ?>"><div id="OrdinaDescri"><?php echo $filtroDescrizione; ?>
                        <button name="Filtro" type="submit" value="descri_formula" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid3 ?>"><div id="OrdinaCodLotto"><?php echo $filtroCodLotto; ?>
                        <button name="Filtro" type="submit" value="cod_lotto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid4 ?>"><div id="OrdinaCodChimica"><?php echo $filtroKitChim; ?>
                        <button name="Filtro" type="submit" value="cod_chimica" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid5 ?>"><div id="OrdinaData"><?php echo $filtroDt; ?>
                        <button name="Filtro" type="submit" value="data" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid6 ?>"><div id="OrdinaDtabil"><?php echo $filtroDtAbilitato; ?>
                        <button name="Filtro" type="submit" value="dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3"width="<?php echo $wid7 ?>"><?php echo $filtroOperazioni; ?></td>
            </tr>
            <div style="float:left">
                <?php
                echo "<br/>" . $msgRecordTrovati . $numrows . "<br/>";
                echo $filtroRigheVisualizzate.": " . $trovati . "<br/>";
            echo "<br/>" .$msgSelectCriteriRicerca . "<br/>";  
                ?>

            <?php
//##################################################################
// quante pagine sono?
            $maxPage = ceil($numrows / $rowsPerPage);


// crea link per accedere ad ogni pagina
//$self = $_SERVER['PHP_SELF'];

            if ($_SESSION['ToDo'] == 1) {
                for ($page = 1; $page <= $maxPage; $page++) {

                    if ($page == $_SESSION['pageNum']) {
                        ?>
                        <button class="button4"><?php echo $page ?></button>

                    <?php } else { ?>
                        <button name="page" type="submit" value="<?php echo $page ?>" class="button5"><?php echo $page ?></button>

                        <?php
                    }
                }
            }
            ?>
            </div>
            
            <?php if ($_SESSION['ToDo'] == 2){
                //Solo se si visualizzano tutti i kit prodotti?>
            <div style="float:right">
                <ul>
                    <li><?php echo $filtroTotNumKitStandard ?><a style="color:#A00028;"><?php echo number_format($totKitStandard, "0", ',', '.') ?></a></li>
                    <li><?php echo $filtroTotNumKitSfusa?><a style="color:#A00028;"><?php echo  number_format($totKitSfusa, "0", ',', '.') ?></a></li> 
                    <li><?php echo $filtroTotKit?><a style="color:#A00028;"><?php echo  number_format($totKitSfusa+$totKitStandard, "0", ',', '.') ?></a></li> 
                </ul>
            </div>
            <?php
            }
            //##################################################################


            while ($row = mysql_fetch_array($sql)) {
//                $NumDoc='';
//                $sqlBolla=findLottoByCodLotto($row['cod_lotto']);
//                $rowBolla=mysql_fetch_assoc($sqlBolla);    
//                $NumDoc=$rowBolla['num_bolla'];  
//                $nomeClasse = "dataRigWhite";
//                $nomeTitle = $msgInfoLottoAssociato;
//                if (!is_numeric($NumDoc)) {
                ?>
                <tr>
                    <td class="<?php echo $nomeClasse ?>" width="<?php echo $wid1 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['cod_prodotto'] ?></td>
                    <td class="<?php echo $nomeClasse ?>" width="<?php echo $wid2 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['descri_formula'] ?></td>
                    <td class="<?php echo $nomeClasse ?>" width="<?php echo $wid3 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['cod_lotto'] ?></td>
                    <td class="<?php echo $nomeClasse ?>" width="<?php echo $wid4 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['cod_chimica'] ?></td>
                    <td class="<?php echo $nomeClasse ?>" width="<?php echo $wid5 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['data'] ?></td>
                    <td class="<?php echo $nomeClasse ?>" width="<?php echo $wid6 ?>" title="<?php echo $nomeTitle ?>"><?php echo $row['dt_abilitato'] ?></td>
                    <td class="<?php echo $nomeClasse ?>" width="<?php echo $wid7 ?>"> 
                        <a href="dettaglio_lotto.php?Lotto=<?php echo $row['cod_lotto'] ?>">
                            <img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone" alt="<?php echo $titleDettaglio ?>" title="<?php echo $titleDettaglio ?>"/></a>
                            <!--<a name="18" href="modifica_lotto_kit.php?Lotto=<?php echo($row['cod_lotto']) ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica . " " . $filtroCodice ?>"/></a>-->
                    </td>   
                </tr>
                <?php
//           } 
            }
            ?>
        </table>
