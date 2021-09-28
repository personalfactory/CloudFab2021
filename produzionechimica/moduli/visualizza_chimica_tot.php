<table>
    <tr>
        <td  class="dataRigWhite"><?php echo $filtroLegendaLottiVenduti ?></td>
        <td  class="dataRigGray"><?php echo $filtroLegendaLottiDisponibili ?></td>
    </tr>
</table>
<table class="table3">
    <tr>
        <th colspan="7"><?php echo $titoloPaginaGestioneChimica ?></th>
    </tr>
    
    <!--################## MOTORE DI RICERCA ###################################-->

    <form  name="VediKitChimici" id="VediKitChimici" action="" method="POST">
        <table class="table3">
            <tr>
                <td><input type="text" name="CodProdotto" size="10" value="<?php echo $_SESSION['CodProdotto'] ?>" /></td>
                <td><input type="text" name="Descrizione" size="33" value="<?php echo $_SESSION['Descrizione'] ?>" /></td>
                <td><input type="text" name="CodLotto" size="23" value="<?php echo $_SESSION['CodLotto'] ?>" /></td>
                <td><input type="text" name="CodChimica" size="23" value="<?php echo $_SESSION['CodChimica'] ?>" /></td>
                <td><input type="text" name="Data" size="15" value="<?php echo $_SESSION['Data'] ?>" /></td>
                <td><input type="text" name="DtAbilitato" size="15" value="<?php echo $_SESSION['DtAbilitato'] ?>" /></td>
            </tr>


            <!--################## RICERCA CON LIST BOX ###############################-->
            <tr>
                <td><select style="width:95px" name="CodProdottoList" id="CodProdottoList" onChange="document.forms['VediKitChimici'].submit();">
                        <option value="<?php echo $_SESSION['CodProdottoList'] ?>" selected="<?php echo $_SESSION['CodProdottoList'] ?>"></option>
                        <?php
                        while ($rowProd = mysql_fetch_array($sqlProd)) {
                            ?>
                            <option value="<?php echo $rowProd['cod_prodotto']; ?>"><?php echo $rowProd['cod_prodotto']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select  style="width:280px" name="DescrizioneList" id="DescrizioneList" onChange="document.forms['VediKitChimici'].submit();">
                        <option value="<?php echo $_SESSION['DescrizioneList'] ?>" selected="<?php echo $_SESSION['DescrizioneList'] ?>"></option>
                        <?php
                        while ($rowDescri = mysql_fetch_array($sqlDescri)) {
                            ?>
                            <option value="<?php echo $rowDescri['descri_formula']; ?>"><?php echo $rowDescri['descri_formula']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select  style="width:200px"  name="CodLottoList" id="CodLottoList" onChange="document.forms['VediKitChimici'].submit();">
                        <option value="<?php echo $_SESSION['CodLottoList'] ?>" selected="<?php echo $_SESSION['CodLottoList'] ?>"></option>
                        <?php
                        while ($rowCodLot = mysql_fetch_array($sqlCodLot)) {
                            ?>
                            <option value="<?php echo $rowCodLot['cod_lotto']; ?>"><?php echo $rowCodLot['cod_lotto']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select style="width:200px" name="CodChimicaList" id="CodChimicaList" onChange="document.forms['VediKitChimici'].submit();">
                        <option value="<?php echo $_SESSION['CodChimicaList'] ?>" selected="<?php echo $_SESSION['CodChimicaList'] ?>"></option>
                        <?php
                        while ($rowCodChim = mysql_fetch_array($sqlCodChim)) {
                            ?>
                            <option value="<?php echo $rowCodChim['cod_chimica']; ?>"><?php echo $rowCodChim['cod_chimica']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select  style="width:135px"  name="DataList" id="DataList" onChange="document.forms['VediKitChimici'].submit();">
                        <option value="<?php echo $_SESSION['DataList'] ?>" selected="<?php echo $_SESSION['DataList'] ?>"></option>
                        <?php
                        while ($rowData = mysql_fetch_array($sqlData)) {
                            ?>
                            <option value="<?php echo $rowData['data']; ?>"><?php echo $rowData['data']; ?></option>
                        <?php } ?>
                    </select></td>
                <td><select  style="width:135px"  name="DtAbilitatoList" id="DtAbilitatoList" onChange="document.forms['VediKitChimici'].submit();">
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

                <td class="cella3" width="95px"><div id="OrdinaProd"><?php echo $filtroProdotto; ?>
                        <button name="Filtro" type="submit" value="cod_prodotto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="280px"><div id="OrdinaDescri"><?php echo $filtroDescrizione; ?>
                        <button name="Filtro" type="submit" value="descri_formula" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="200px"><div id="OrdinaCodLotto"><?php echo $filtroCodLotto; ?>
                        <button name="Filtro" type="submit" value="cod_lotto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="200px"><div id="OrdinaCodChimica"><?php echo $filtroKitChim; ?>
                        <button name="Filtro" type="submit" value="cod_chimica" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="135px"><div id="OrdinaData"><?php echo $filtroDt; ?>
                        <button name="Filtro" type="submit" value="data" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="135px"><div id="OrdinaDtabil"><?php echo $filtroDtAbilitato; ?>
                        <button name="Filtro" type="submit" value="dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3"><?php echo $filtroOperazioni; ?></td>
            </tr>
            <?php
            echo "<br/>" . $msgRecordTrovati . $trovati . "<br/>";
            echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";           
            
            while ($row = mysql_fetch_array($sql)) {
                $NumDoc='';
                $sqlBolla=findLottoByCodLotto($row['cod_lotto']);
                $rowBolla=mysql_fetch_assoc($sqlBolla);    
                $NumDoc=$rowBolla['num_bolla'];  
                                
                $nomeClasse = "dataRigGray";
                $nomeTitle = $msgInfoLottoNonAssociato;

                if (is_numeric($NumDoc)) {
                    $nomeClasse = "dataRigWhite";
                    $nomeTitle = $msgInfoLottoAssociato;
                };
                ?>
                <tr>
                    <td class="<?php echo $nomeClasse; ?>" width="95px" title="<?php echo $nomeTitle ?>"><?php echo $row['cod_prodotto'] ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="280px" title="<?php echo $nomeTitle ?>"><?php echo $row['descri_formula'] ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="200px" title="<?php echo $nomeTitle ?>"><?php echo $row['cod_lotto'] ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="200px" title="<?php echo $nomeTitle ?>"><?php echo $row['cod_chimica'] ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="135px" title="<?php echo $nomeTitle ?>"><?php echo $row['data'] ?></td>
                    <td class="<?php echo $nomeClasse; ?>" width="135px" title="<?php echo $nomeTitle ?>"><?php echo $row['dt_abilitato'] ?></td>
                    <td class="<?php echo $nomeClasse; ?>"style="width:90px"> 
                         <a href="dettaglio_lotto.php?Lotto=<?php echo $row['cod_lotto'] ?>">
          <img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone" alt="<?php echo $titleDettaglio ?>" title="<?php echo $titleDettaglio ?>"/></a>
                        
                    </td>   
                </tr>
                <?php
            }
            ?>
        </table>
