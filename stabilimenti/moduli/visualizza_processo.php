
<?php
$wid1 = "5%";
$wid2 = "5%";
$wid3 = "20%";
$wid4 = "10%";
$wid5 = "10%";
$wid6 = "5%";
$wid7 = "20%";
$wid8 = "4%";
$wid9 = "10%";
$wid10 = "1%";
?>
<!--################## MOTORE DI RICERCA ###################################-->
<form  name="VediProcesso" id="VediProcesso" action="" method="POST">
    <table class="table3">
        <tr>
            <td><input style="width:100%" type="text" name="IdProcesso" value="<?php echo $_SESSION['IdProcesso'] ?>" /></td>
            <td><input style="width:100%" type="text" name="CodProdotto" value="<?php echo $_SESSION['CodProdotto'] ?>" /></td>
            <td><input style="width:100%" type="text" name="NomeProdotto" value="<?php echo $_SESSION['NomeProdotto'] ?>" /></td>
            <td><input style="width:100%" type="text" name="CodChimica" value="<?php echo $_SESSION['CodChimica'] ?>" /></td>
            <td><input style="width:100%" type="text" name="CodSacco" value="<?php echo $_SESSION['CodSacco'] ?>" /></td>
            <td><input style="width:100%" type="text" name="PesoReale" value="<?php echo $_SESSION['PesoReale'] ?>" /></td>
            <td><input style="width:100%" type="text" name="QtaMiscela"  value="<?php echo "" ?>" /></td>
            <td><input style="width:100%" type="text" name="NumSacchi"  value="<?php echo "" ?>" /></td>
            <td><input style="width:100%" type="text" name="DataProd" value="<?php echo $_SESSION['DataProd'] ?>" /></td>
        </tr>
        <!--################## RICERCA CON LIST BOX ###############################-->
        <tr>      
            <td><select  style="width:100%" name="IdProcessoList" id="IdProcessoList" onChange="document.forms['VediProcesso'].submit();">
                    <option value="<?php echo $_SESSION['IdProcessoList'] ?>" selected="<?php echo $_SESSION['IdProcessoList'] ?>"></option>
                    <?php
                    while ($rowIdProc = mysql_fetch_array($sqlIdProc)) {
                        ?>
                        <option value="<?php echo $rowIdProc['id_processo']; ?>"><?php echo $rowIdProc['id_processo']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select   style="width:100%" name="CodProdottoList" id="CodProdottoList" onChange="document.forms['VediProcesso'].submit();">
                    <option value="<?php echo $_SESSION['CodProdottoList'] ?>" selected="<?php echo $_SESSION['CodProdottoList'] ?>"></option>
                    <?php
                    while ($rowCodProd = mysql_fetch_array($sqlCodProd)) {
                        ?>
                        <option value="<?php echo $rowCodProd['cod_prodotto']; ?>"><?php echo $rowCodProd['cod_prodotto']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%" name="NomeProdottoList" id="NomeProdottoList" onChange="document.forms['VediProcesso'].submit();">
                    <option value="<?php echo $_SESSION['NomeProdottoList'] ?>" selected="<?php echo $_SESSION['NomeProdottoList'] ?>"></option>
                    <?php
                    while ($rowNomeProd = mysql_fetch_array($sqlNomeProd)) {
                        ?>
                        <option value="<?php echo $rowNomeProd['nome_prodotto']; ?>"><?php echo $rowNomeProd['nome_prodotto']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select   style="width:100%" name="CodChimicaList" id="CodChimicaList" onChange="document.forms['VediProcesso'].submit();">
                    <option value="<?php echo $_SESSION['CodChimicaList'] ?>" selected="<?php echo $_SESSION['CodChimicaList'] ?>"></option>
                    <?php
                    while ($rowCodChim = mysql_fetch_array($sqlCodChim)) {
                        ?>
                        <option value="<?php echo $rowCodChim['cod_chimica']; ?>"><?php echo $rowCodChim['cod_chimica']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select   style="width:100%" name="CodSaccoList" id="CodSaccoList" onChange="document.forms['VediProcesso'].submit();">
                    <option value="<?php echo $_SESSION['CodSaccoList'] ?>" selected="<?php echo $_SESSION['CodSaccoList'] ?>"></option>
                    <?php
                    while ($rowCodSac = mysql_fetch_array($sqlCodSac)) {
                        ?>
                        <option value="<?php echo $rowCodSac['cod_sacco']; ?>"><?php echo $rowCodSac['cod_sacco']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select   style="width:100%" name="PesoRealeList" id="CodSaccoList" onChange="document.forms['VediProcesso'].submit();">
                    <option value="<?php echo $_SESSION['PesoRealeList'] ?>" selected="<?php echo $_SESSION['PesoRealeList'] ?>"></option>
                    <?php
                    while ($rowPesoReale = mysql_fetch_array($sqlPesoReale)) {
                        ?>
                        <option value="<?php echo $rowPesoReale['peso_reale_sacco']; ?>"><?php echo $rowPesoReale['peso_reale_sacco']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select style="width:100%" disabled="disabled"></select></td>
            <td><select style="width:100%" disabled="disabled"></select></td>
            <td><select style="width:100%"  name="DataProdList" id="DataProdList" onChange="document.forms['VediProcesso'].submit();">
                    <option value="<?php echo $_SESSION['DataProdList'] ?>" selected="<?php echo $_SESSION['DataProdList'] ?>"></option>
                    <?php
                    while ($rowNomi = mysql_fetch_array($sqlNomi)) {
                        ?>
                        <option value="<?php echo $rowNomi['dt_produzione_mac']; ?>"><?php echo $rowNomi['dt_produzione_mac']; ?></option>
                    <?php } ?>
                </select></td>
            <td width="<?php echo $wid10 ?>"> <img src="/CloudFab/images/icone/lente_piccola.png" onClick="document.forms['VediProcesso'].submit();" title="<?php echo $titleRicerca ?>"/></td>

        </tr>

        <!--################## ORDINAMENTO ########################################-->
        <tr>              
            <td class="cella3" width="<?php echo $wid1 ?>"><div id="OrdinaIdProc"><?php echo $filtroIdProcesso; ?>
                    <button name="Filtro" type="submit" value="id_processo" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid2 ?>"><div id="OrdinaCodProd"><?php echo $filtroCodice; ?>
                    <button name="Filtro" type="submit" value="cod_prodotto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid3 ?>"><div id="OrdinaNomeProd"><?php echo $filtroProdotto; ?>
                    <button name="Filtro" type="submit" value="nome_prodotto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid4 ?>"><div id="OrdinaKit"><?php echo $filtroKitChim; ?>
                    <button name="Filtro" type="submit" value="cod_chimica" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid5 ?>"><div id="OrdinaCodSacco"><?php echo $filtroSacco; ?>
                    <button name="Filtro" type="submit" value="cod_sacco" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid6 ?>"><div id="OrdinaPeso"><?php echo $filtroPesoSacco; ?>
                    <button name="Filtro" type="submit" value="peso_reale_sacco" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid7 ?>"><?php echo $filtroMatPriQtaMiscela ?></td>
            <td class="cella3" width="<?php echo $wid8 ?>"><?php echo $filtroNumSacchiInMiscela; ?></td>

            <td class="cella3" width="<?php echo $wid9 ?>"><div id="OrdinaDtProd"><?php echo $filtroDtProd; ?>
                    <button name="Filtro" type="submit" value="dt_produzione_mac" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid10 ?>"><?php echo $filtroOperazioni; ?></td>
        </tr>
        <?php
//####### Array contenente tutti i codici chimica ############################## 
//Utile per la gestione di colori delle righe
        $arrayCodChimica = array();
        $i = 0;
        while ($rowA = mysql_fetch_array($sql)) {

            $arrayCodChimica[$i] = $rowA['cod_chimica'];

            $i++;
        }
//#########################################################################
        //Per recuperare il numero di sacchi fatti con un kit
        $tmp = array_count_values($arrayCodChimica);

        if (mysql_num_rows($sql) > 0)
            mysql_data_seek($sql, 0);

        $j = 0;
        $classeCella = "cella1";
        while ($row = mysql_fetch_array($sql)) {

            //############# Gestione colore righe ##############################    
            if ($j > 0) {
                //Se il codice chimica è diverso dal precedente cambio il colore delle righe
                //in questo modo ottengo righe dello stesso colore per ogni kit chimico
                if ($row['cod_chimica'] != $arrayCodChimica[$j - 1]) {
                    if ($classeCella == "cella2")
                        $classeCella = "cella1";
                    else if ($classeCella == "cella1")
                        $classeCella = "cella2";
                }
            }


            //##################################################################
            //Recupero il peso reale delle materie prime dal codice cod_comp_peso
            //Se il primo carattere non è un numero vuol dire che 
            //il codice non può essere splittato, è un codice vecchio (origami4)
            $CodiceComponentiPeso = $row['cod_comp_peso'];

            //numero di sacchi fatti con un kit
            $numSacchiPerKit = $tmp[$row['cod_chimica']];
            $pesoRealeSacco = number_format($row['peso_reale_sacco'], '0', ',', ' ');

            
           if($row['info2']!='') {
            
           list($idCat,$numSacTot,$velMix,$tempoMix,$vibroAttivo,$ariaCondScarico,$ariaInternoValvola,$ariaPulisciValvola)=  explode("_", $row['info2']);
           $numSacchiPerKit=$numSacTot;
           
           }
            ?>
            <tr>
                <td class="<?php echo $classeCella ?>" width="<?php echo $wid1 ?>"><?php echo($row['id_processo']) ?></td>
                <td class="<?php echo $classeCella ?>" width="<?php echo $wid2 ?>"><?php echo($row['cod_prodotto']) ?></td>
                <td class="<?php echo $classeCella ?>" width="<?php echo $wid3 ?>"><?php echo($row['nome_prodotto']) ?></td>
                <td class="<?php echo $classeCella ?>" width="<?php echo $wid4 ?>"><?php echo($row['cod_chimica']) ?></td>
                <td class="<?php echo $classeCella ?>" width="<?php echo $wid5 ?>" ><?php echo($row['cod_sacco']) ?></td>
                <td class="<?php echo $classeCella ?>" width="<?php echo $wid6 ?>">
                    <?php echo($pesoRealeSacco) . " " . $filtrogBreve ?>                       
                </td>
                <td class="<?php echo $classeCella ?>" width="<?php echo $wid7 ?>">
                    <div style="font-size:10px; ">
                        <table style="width:98%;">

                            <?php
                            //Per i codici nuovi
                            if (is_numeric(substr($CodiceComponentiPeso, 0, 1))) {

                                $Comp = array();
                                $ListaComponenti = array();
                                $ListaComponenti = explode('.', $CodiceComponentiPeso);

                                for ($i = 0; $i < count($ListaComponenti); $i++) {
                                    //Estraggo la formula del prodotto ovvero le quantita effettivamente 
                                    //utilizzate delle materie prima drymix
                                    $Comp = explode('_', $ListaComponenti[$i]);
                                    $IdComp = $Comp[0];
                                    $QtaCompMiscela = number_format($Comp[1], '0', ',', ' ');
//                                    if ($numSacchiPerKit > 0)
//                    $QtaCompSacco=  number_format ($QtaCompMiscela/$numSacchiPerKit, '0', ',', ' ');
                                    $sqlNomeComp = selectVocaboloByIdTipoLingua($IdComp, $_SESSION['lingua'], "4");
                                    while ($rowDescriComp = mysql_fetch_array($sqlNomeComp)) {
                                        $DescriComp = $rowDescriComp['vocabolo'];
                                    }
                                    ?>
                                    <tr >
                                        <td ><?php echo $DescriComp ?> </td>
                                        <td align="right"><nobr><?php echo $QtaCompMiscela . " " . $filtrogBreve ?></nobr></td>
                                        <!--<td><?php //  echo $QtaCompSacco . " " .<a href="../produzionechimica/dettaglio_movimento_sing_mac.php?CodCompIn=<?php echo($row['cod_ingresso_comp']) ?>"> $filtrogBreve   ?></td>-->
                                    </tr>                                           
                                    <?php
                                }
                            } else {
                                //Codice componente peso vecchio
                                ?>

                                <tr>
                                    <td ><?php echo $CodiceComponentiPeso ?> </td>

                                </tr>           

                            <?php } ?>                
                        </table>
                    </div></td>
                <td class="<?php echo $classeCella ?>" width="<?php echo $wid8 ?>"><?php echo $numSacchiPerKit ?></td>
                <td class="<?php echo $classeCella ?>" width="<?php echo $wid9 ?>"><?php echo($row['dt_produzione_mac']) ?></td>
                
                <td class="<?php echo $classeCella ?>" width="<?php echo $wid10 ?>"><nobr><a href="/CloudFab/produzionechimica/dettaglio_sacchetto.php?IdProcesso=<?php echo($row['id_processo']) ?>&IdMacchina=<?php echo($_SESSION['IdMacchina']) ?>">
                    <img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone"  title="<?php echo $titleDettaglio ?>"/></a>

               
               
          
                    <!--<a href="modifica_valore_categoria.php?IdCategoria=<?php echo ($row['id_cat']) ?>">
                        <img src="/CloudFab/images/pittogrammi/macchina_R.png" class="icone"  title="<?php echo $titleMostraParametriCat ?>"/></a>-->
  

               
            </nobr> </td>

                
            </tr>
            <?php
            $j++;
        }
        ?>
    </table>
</form>
