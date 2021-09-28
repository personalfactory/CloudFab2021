<?php
//Larghezza colonne 
$wid1 = "10%"; // +10px padding (l+r)
$wid2 = "20%"; // +10px padding (l+r)
$wid3 = "10%"; // +10px padding (l+r)
$wid4 = "10%"; // +10px padding (l+r)
$wid5 = "10%"; // +10px padding (l+r)
$wid6 = "10%"; // +10px padding (l+r)
$wid7 = "10%"; // +10px padding (l+r)
$wid8 = "10%"; // +10px padding (l+r)
$widOp = "5%"; // +10px padding (l+r)
//TOTALE 1170px
?>
<table class="table3">
    <tr>
        <th colspan="6"><?php echo $titoloPaginaProdottiBs ?></th>
    </tr>
    <tr>
        <td  colspan="6" style="text-align:center;"> 
            <p><a name="135" href="carica_prodotto_bs.php?ToDo=NuovoProdotto"><?php echo $nuovoBsProdottoPF ?></a></p>
            <br/>
            <p><a name="135" href="carica_altro_prodotto_bs.php?ToDo=NuovoProdotto"><?php echo $nuovoBsProdottoAltro ?></a></p>
        </td>
    </tr>
</table>

<form  name="VediBSProdotti" id="VediBSProdotti" action="" method="POST">
    <table class="table3">
        <tr>
            <td><input style="width:100%" type="text" name="CodProdotto" value="<?php echo $_SESSION['CodProdotto'] ?>"/></td>
            <td><input style="width:100%" type="text" name="NomeProd" value="<?php echo $_SESSION['NomeProd'] ?>"/></td>
            <td><input style="width:100%" type="text" name="Classificazione" value="<?php echo $_SESSION['Classificazione'] ?>"/></td>
            <td><input style="width:100%" type="text" name="NumKit" value="<?php echo $_SESSION['NumKit'] ?>"/></td>
            <td><input style="width:100%" type="text" name="NumLotti" value="<?php echo $_SESSION['NumLotti'] ?>"/></td>
            <td><input style="width:100%" type="text" name="ListinoKit" value="<?php echo $_SESSION['ListinoKit'] ?>"/></td>
            <td><input style="width:100%" type="text" name="ListinoLotto" value="<?php echo $_SESSION['ListinoLotto'] ?>"/></td>
            <td><input style="width:100%" type="text" name="Rating" value="<?php echo $_SESSION['Rating'] ?>"/></td>
        </tr>
        <!--################## RICERCA CON LIST BOX ###############################-->
        <tr>
            <td><select style="width:100%" name="CodProdottoList" id="CodProdottoList" onChange="document.forms['VediBSProdotti'].submit();">
                    <option value="<?php echo $_SESSION['CodProdottoList'] ?>" selected="<?php echo $_SESSION['CodProdottoList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlCod)) {
                        ?>
                        <option value="<?php echo $row['cod_prodotto']; ?>"><?php echo $row['cod_prodotto']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%"  name="NomeProdList" id="NomeProdList" onChange="document.forms['VediBSProdotti'].submit();">
                    <option value="<?php echo $_SESSION['NomeProdList'] ?>" selected="<?php echo $_SESSION['NomeProdList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlNome)) {
                        ?>
                        <option value="<?php echo $row['nome_prodotto']; ?>"><?php echo $row['nome_prodotto']; ?></option>
                    <?php } ?>
                </select></td> 
            <td><select  style="width:100%"  name="ClassificazioneList" id="ClassificazioneList" onChange="document.forms['VediBSProdotti'].submit();">
                    <option value="<?php echo $_SESSION['ClassificazioneList'] ?>" selected="<?php echo $_SESSION['ClassificazioneList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlClas)) {
                        ?>
                        <option value="<?php echo $row['classificazione']; ?>"><?php echo $row['classificazione']; ?></option>
                    <?php } ?>
                </select></td> 
                <td><select  style="width:100%" name="NumKitList" id="NumKitList" onChange="document.forms['VediBSProdotti'].submit();">
                    <option value="<?php echo $_SESSION['NumKitList'] ?>" selected="<?php echo $_SESSION['NumKitList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlNumKit)) {
                        ?>
                        <option value="<?php echo $row['num_sac_in_lotto']; ?>"><?php echo $row['num_sac_in_lotto']; ?></option>
                    <?php } ?>
                </select></td>
                <td><select  style="width:100%" name="NumLottiList" id="NumLottiList" onChange="document.forms['VediBSProdotti'].submit();">
                    <option value="<?php echo $_SESSION['NumLottiList'] ?>" selected="<?php echo $_SESSION['NumLottiList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlNumLotti)) {
                        ?>
                        <option value="<?php echo $row['num_lotti']; ?>"><?php echo $row['num_lotti']; ?></option>
                    <?php } ?>
                </select></td>
                <td>
                    <select  style="width:100%" name="ListinoKitList" id="NumKitList" onChange="document.forms['VediBSProdotti'].submit();">
                    <option value="<?php echo $_SESSION['ListinoKitList'] ?>" selected="<?php echo $_SESSION['ListinoKitList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlListinoKit)) {
                        $listinoKit=number_format($row['listino']/$row['num_sac_in_lotto'],2,'.','');
                        ?>
                        <option value="<?php echo $listinoKit; ?>"><?php echo $listinoKit; ?></option>
                    <?php } ?>
                </select>
                </td>
            <td><select  style="width:100%" name="ListinoLottoList" id="ListinoLottoList" onChange="document.forms['VediBSProdotti'].submit();">
                    <option value="<?php echo $_SESSION['ListinoLottoList'] ?>" selected="<?php echo $_SESSION['ListinoLottoList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlListino)) {
                        $listinoLotto=number_format($row['listino'],2,'.','');
                        ?>
                        <option value="<?php echo $listinoLotto; ?>"><?php echo $listinoLotto; ?></option>
                    <?php } ?>
                </select></td>
                
                
            <td><select  style="width:100%"  name="RatingList" id="RatingList" onChange="document.forms['VediBSProdotti'].submit();">
                    <option value="<?php echo $_SESSION['RatingList'] ?>" selected="<?php echo $_SESSION['RatingList'] ?>"></option>
                    <?php
                    while ($rowRat = mysql_fetch_array($sqlRating)) {
                        ?>
                        <option value="<?php echo $rowRat['rating']; ?>"><?php echo $rowRat['rating']; ?></option>
                    <?php } ?>
                </select></td>


            <td><img src="/CloudFab/images/icone/lente_piccola.png" onClick="document.forms['VediBSProdotti'].submit();" title="<?php echo $titleRicerca ?>"/>
            <a name="135" href="download_excel_prodotti_bs.php?StringaUtAziende=<?php echo $strUtentiAziende?>">
                <img src="/CloudFab/images/pittogrammi/download_G.png" class="icone"  title="ESPORTA IN EXCEL" /></a></td>
        </tr>
        <!--################## ORDINAMENTO ########################################-->
        <tr>           

            <td class="cella3" width="<?php echo $wid1 ?>"><div id="OrdinaCod"><?php echo $filtroCodice; ?>
                    <button name="Filtro" type="submit" value="cod_prodotto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid2 ?>"><div id="OrdinaNome"><?php echo $filtroNome; ?>
                    <button name="Filtro" type="submit" value="nome_prodotto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid3 ?>"><div id="OrdinaClas"><?php echo $filtroClassificazione ?>
                    <button name="Filtro" type="submit" value="classificazione" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid4 ?>"><div id="OrdinaNumKit"><?php echo $filtroNumKitInLotto?>
                    <button name="Filtro" type="submit" value="num_sac_in_lotto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid5 ?>"><div id="OrdinaNumLotti"><?php echo $filtroNumLotti?>
                    <button name="Filtro" type="submit" value="num_lotti" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid6 ?>"><div id="OrdinaListinoKit"><?php echo $filtroListino." ".$filtroKitChim ?>
                    <button name="Filtro" type="submit" value="listino" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid7 ?>"><div id="OrdinaListino"><?php echo $filtroListinoLotto ?>
                    <button name="Filtro" type="submit" value="listino" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>              

            <td class="cella3" width="<?php echo $wid8 ?>"><div id="OrdinaRat"><?php echo $filtroRating; ?>
                    <button name="Filtro" type="submit" value="rating" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>

            <td class="cella3" style="width: <?php echo $widOp ?>"><?php echo $filtroOperazioni; ?></td>

        </tr>
        
        <?php
        echo "<br/>" . $msgRecordTrovati . $trovati . "<br/>";
        echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";


        while ($row = mysql_fetch_array($sql)) {
            $hrefSchedaTecnica="";
            $hrefPresentazione="";
        
             if($row['link_scheda_tecnica']!=''){ $hrefSchedaTecnica= $radicePercorsoSchedeTecnicheSito . "/" . $row['link_scheda_tecnica'];}
             if($row['link_presentazione_prod']!=''){ $hrefPresentazione="/CloudFab/bs/schede/presentazione/download/".$row['link_presentazione_prod'];}            
            
            $strFineDes = "";
//            if (strlen($row['descri_categoria']) > 80) {
//                $strFineDes = $filtroPuntini;
//            }
            $listinoKit=0;
            if($row['num_sac_in_lotto']>0)
                $listinoKit=number_format($row['listino']/$row['num_sac_in_lotto'],2,'.','');
            
            $listinoLotto=0;
            if($row['listino']>0)
                    $listinoLotto=number_format($row['listino'],2,'.','');
            
            $classTd = "cella1";
            $hrefModifica="carica_altro_prodotto_bs.php?ToDo=ModificaProdotto&IdProdotto=".$row['id_prodotto'];
            $hrefElimina="elimina_bs_dato.php?Tabella=bs_altri_prodotti&IdRecord=".$row['id_prodotto']."&NomeId=id_prodotto&RefBack=gestione_prodotti_bs.php";
            if($row['tipo']==$valBsTipoProdPf){
                // Vuol dire che si tratta di prodotti personal caricati dalla tabella prodotto
                 $classTd = "cella2";
                $hrefModifica="carica_prodotto_bs.php?ToDo=ModificaProdotto&IdProdotto=".$row['id_prodotto'];
                $hrefElimina="elimina_bs_dato.php?Tabella=bs_prodotto&IdRecord=".$row['id_prodotto']."&NomeId=id_prodotto&RefBack=gestione_prodotti_bs.php";
            }
            
                ?>
                <tr>
                     <?php if($row['link_scheda_tecnica']!=""){ ?>
                    
                    
                    <td class="<?php echo $classTd ?>" style="width: <?php echo $wid1 ?>"><a target="_blank" href="<?php echo $hrefSchedaTecnica ?>" title="<?php echo $titleVediSchedaTecnica ?>"> <?php echo($row['cod_prodotto']) ?></a></td>
                                       
                   <?php } else { ?>
                        
                        <td class="<?php echo $classTd ?>" style="width: <?php echo $wid1 ?>"><?php echo($row['cod_prodotto']) ?></td>
               <?php     }
?>  
                    
                    
                    <?php if($row['link_presentazione_prod']!=""){ ?>
                    <td class="<?php echo $classTd ?>" style="width: <?php echo $wid2 ?>"><a target="_blank" href="<?php echo $hrefPresentazione ?>" title="<?php echo $titleVediPresProdotto ?>"><?php echo($row['nome_prodotto']) ?></a></td>
                    <?php } else { ?>
                        
                        <td class="<?php echo $classTd ?>" style="width: <?php echo $wid2 ?>"><?php echo($row['nome_prodotto']) ?></td>
               <?php     }
?>
                    <td class="<?php echo $classTd ?>" style="width: <?php echo $wid3 ?>"><?php echo($row['classificazione']) ?></td>
                    <td class="<?php echo $classTd ?>" style="width: <?php echo $wid4 ?>;text-align:right"><?php echo($row['num_sac_in_lotto']) ?></td>
                    <td class="<?php echo $classTd ?>" style="width: <?php echo $wid5 ?>;text-align:right"><?php echo($row['num_lotti']) ?></td>
                    <td class="<?php echo $classTd ?>" style="width: <?php echo $wid6 ?>;text-align:right"><?php echo $listinoKit . " " . $filtroEuro ?></td>
                    <td class="<?php echo $classTd ?>" style="width: <?php echo $wid7 ?>;text-align:right"><?php echo $listinoLotto. " " . $filtroEuro ?></td>
                    <td class="<?php echo $classTd ?>" style="width: <?php echo $wid8 ?>;text-align:right"><?php echo($row['rating']) ?></td>
                    <td class="<?php echo $classTd ?>" style="width: <?php echo $widOp ?>">
                        <a name="136" href="<?php echo $hrefModifica ?>">
                            <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone"  title="<?php echo $titleModifica ?>"/></a>
                            <a name="135" href="<?php echo $hrefElimina ?>">
                            <img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone"  title="<?php echo $titleElimina ?>"/></a>
                    </td>
                </tr>
                <?php
            
        }
        ?>
    </table>
</form>