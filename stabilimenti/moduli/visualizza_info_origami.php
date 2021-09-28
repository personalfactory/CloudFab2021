<?php
//Larghezza colonne 
$widPri = "5%";// +10px padding (l+r)
$widPosb = "15%";// +10px padding (l+r)
$widTip = "10%";// +10px padding (l+r)
$widSTip = "10%";// +10px padding (l+r)
$widInf = "20%";// +10px padding (l+r)
$widPos = "10%";// +10px padding (l+r)
$widDt = "15%";// +10px padding (l+r)
$widUt = "10%";// +10px padding (l+r)
$widOp ="5%";// +10px padding (l+r)
//TOTALE 1170px
?>
<table class="table3">
    <tr>
        <th colspan="7"><?php echo $titoloPaginaGestioneInfoOri ?></th>
    </tr>
    <tr>
        <td  colspan="9" style="text-align:center;"> 
            <p><a href="carica_info_origami.php"><?php echo $nuovaInfoOri ?></a></p>
            <p>&nbsp;</p>
        </td>
    </tr>
    <!--################## MOTORE DI RICERCA ###################################-->
</table>
<form  name="VediInfoOri" id="VediInfoOri" action="" method="POST">
    <table class="table3">
        <tr>
            <td><input style="width:100%" type="text" name="Priorita" value="<?php echo $_SESSION['Priorita'] ?>" /></td>
            <td><input style="width:100%" type="text" name="DescriStab" value="<?php echo $_SESSION['DescriStab'] ?>" /></td>
            <td><input style="width:100%" type="text" name="TipoInfo" value="<?php echo $_SESSION['TipoInfo'] ?>" /></td>
            <td><input style="width:100%" type="text" name="SottoTipo" value="<?php echo $_SESSION['SottoTipo'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Info" value="<?php echo $_SESSION['Info'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Posizione" value="<?php echo $_SESSION['Posizione'] ?>" /></td>
            <td><input style="width:100%" type="text" name="DtAbilitato" value="<?php echo $_SESSION['DtAbilitato'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Utente" value="<?php echo $_SESSION['Utente'] ?>" /></td>
        </tr>
        <!--################## RICERCA CON LIST BOX ###############################-->
        <tr>
            <td><select style="width:100%" name="PrioritaList" id="PrioritaList" onChange="document.forms['VediInfoOri'].submit();">
                    <option value="<?php echo $_SESSION['PrioritaList'] ?>" selected="<?php echo $_SESSION['PrioritaList'] ?>"></option>
                    <?php
                    while ($rowPri = mysql_fetch_array($sqlPri)) {
                        ?>
                        <option value="<?php echo $rowPri['priorita']; ?>"><?php echo $rowPri['priorita']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select style="width:100%" name="DescriStabList" id="DescriStabList" onChange="document.forms['VediInfoOri'].submit();">
                    <option value="<?php echo $_SESSION['DescriStabList'] ?>" selected="<?php echo $_SESSION['DescriStabList'] ?>"></option>
                    <?php
                    while ($rowDesStab = mysql_fetch_array($sqlDescriStab)) {
                        ?>
                        <option value="<?php echo $rowDesStab['descri_stab']; ?>"><?php echo $rowDesStab['descri_stab']; ?></option>
                    <?php } ?>
                </select></td> 
            <td><select style="width:100%" name="TipoInfoList" id="TipoInfoList" onChange="document.forms['VediInfoOri'].submit();">
                    <option value="<?php echo $_SESSION['TipoInfoList'] ?>" selected="<?php echo $_SESSION['TipoInfoList'] ?>"></option>
                    <?php
                    while ($rowTipo = mysql_fetch_array($sqlTipoInfo)) {
                        ?>
                        <option value="<?php echo $rowTipo['tipo_info']; ?>"><?php echo $rowTipo['tipo_info']; ?></option>
                    <?php } ?>
                </select></td> 
            <td><select style="width:100%" name="SottoTipoList" id="SottoTipoList" onChange="document.forms['VediInfoOri'].submit();">
                    <option value="<?php echo $_SESSION['SottoTipoList'] ?>" selected="<?php echo $_SESSION['SottoTipoList'] ?>"></option>
                    <?php
                    while ($rowSoTipo = mysql_fetch_array($sqlSottoTipo)) {
                        ?>
                        <option value="<?php echo $rowSoTipo['sotto_tipo']; ?>"><?php echo $rowSoTipo['sotto_tipo']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select style="width:100%"  name="InfoList" id="InfoList" onChange="document.forms['VediInfoOri'].submit();">
                    <option value="<?php echo $_SESSION['InfoList'] ?>" selected="<?php echo $_SESSION['InfoList'] ?>"></option>
                    <?php
                    while ($rowInfo = mysql_fetch_array($sqlInfo)) {
                        ?>
                        <option value="<?php echo $rowInfo['info']; ?>"><?php echo $rowInfo['info']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select style="width:100%"  name="PosizioneList" id="PosizioneList" onChange="document.forms['VediInfoOri'].submit();">
                    <option value="<?php echo $_SESSION['PosizioneList'] ?>" selected="<?php echo $_SESSION['PosizioneList'] ?>"></option>
                    <?php
                    while ($rowPosizione = mysql_fetch_array($sqlPosizione)) {
                        ?>
                        <option value="<?php echo $rowPosizione['posizione']; ?>"><?php echo $rowPosizione['posizione']; ?></option>
                    <?php } ?>
                </select></td>

            <td><select style="width:100%" name="DtAbilitatoList" id="DtAbilitatoList" onChange="document.forms['VediInfoOri'].submit();">
                    <option value="<?php echo $_SESSION['DtAbilitatoList'] ?>" selected="<?php echo $_SESSION['DtAbilitatoList'] ?>"></option>
                    <?php
                    while ($rowData = mysql_fetch_array($sqlDt)) {
                        ?>
                        <option value="<?php echo $rowData['dt_abil']; ?>"><?php echo $rowData['dt_abil']; ?></option>
                    <?php } ?>
                </select></td>   
            <td><select style="width:100%" name="UtenteList" id="UtenteList" onChange="document.forms['VediInfoOri'].submit();">
                    <option value="<?php echo $_SESSION['UtenteList'] ?>" selected="<?php echo $_SESSION['UtenteList'] ?>"></option>
                    <?php
                    while ($rowUt = mysql_fetch_array($sqlUt)) {
                        ?>
                        <option value="<?php echo $rowUt['utente']; ?>"><?php echo $rowUt['utente']; ?></option>
                    <?php } ?>
                </select></td>  

            <td><input style="width:100%" type="button" value="<?php echo $valueButtonCerca ?>" onClick="document.forms['VediInfoOri'].submit();" /></td>
        </tr>

        <!--################## ORDINAMENTO ########################################-->
        <tr>              

            <td class="cella3" width="<?php echo $widPri ?>"><div id="OrdinaId"><?php echo $filtroPriorita; ?>
                    <button name="Filtro" type="submit" value="priorita" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $widPosb ?>"><div id="OrdinaDes"><?php echo $filtroStabilimento; ?>
                    <button name="Filtro" type="submit" value="descri_stab" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $widTip ?>"><div id="OrdinaTipo"><?php echo $filtroTipo; ?>
                    <button name="Filtro" type="submit" value="tipo_info" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $widSTip ?>"><div id="OrdinaSoTipo"><?php echo $filtroSottoTipo; ?>
                    <button name="Filtro" type="submit" value="sotto_tipo" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $widInf ?>"><div id="OrdinaInfo"><?php echo $filtroInfo; ?>
                    <button name="Filtro" type="submit" value="info" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $widPos ?>"><div id="OrdinaPosizione"><?php echo $filtroPosizione; ?>
                    <button name="Filtro" type="submit" value="posizione" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $widDt ?>"><div id="OrdinaDt"><?php echo $filtroDt; ?>
                    <button name="Filtro" type="submit" value="dt_abil" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $widUt ?>"><div id="OrdinaUt"><?php echo $filtroUtente; ?>
                    <button name="Filtro" type="submit" value="utente" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" style="width: <?php echo $widOp ?>"><?php echo $filtroOperazioni; ?></td>

        </tr>
        <?php
        echo "<br/>" . $msgRecordTrovati . $trovati . "<br/>";
        echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";

        $nomeClasse = "dataRigGray";
        $nomeTitle = "";
        while ($row = mysql_fetch_array($sql)) {
            $Info = $row['info'];
            $DescriSt = $row['descri_stab'];
            $TipInf=$row['tipo_info'];
            $STip=$row['sotto_tipo'];
            $Posizione=$row['posizione'];
            $DtAbil=$row['dt_abil'];
            $Utente=$row['utente'];
//            if (strlen($row['info']) > 22)
//                $Info = substr($row['info'], 0, 22) . $filtroPuntini;
            if (strlen($row['descri_stab']) > 20)
                $DescriSt = substr($row['descri_stab'], 0, 20) . $filtroPuntini;
            if (strlen($row['tipo_info']) > 12)
                $TipInf = substr($row['tipo_info'], 0, 12) . $filtroPuntini;
            if (strlen($row['sotto_tipo']) > 12)
                $STip = substr($row['sotto_tipo'], 0, 12) . $filtroPuntini;
            if (strlen($row['posizione']) > 11)
                $Posizione = substr($row['posizione'], 0, 11) . $filtroPuntini;
            if (strlen($row['dt_abil']) > 16)
                $DtAbil = substr($row['dt_abil'], 0, 16) . $filtroPuntini;
            if (strlen($row['utente']) > 18)
                $Utente = substr($row['utente'], 0, 18) . $filtroPuntini;
            ?>
            <tr>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $widPri ?>"  title="<?php echo $nomeTitle ?>"><?php echo $row['priorita'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $widPosb ?>" title="<?php echo $nomeTitle ?>"><?php echo $DescriSt ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $widTip ?>" title="<?php echo $row['tipo_info'] ?>"><?php echo $TipInf ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $widSTip ?>" title="<?php echo  $row['sotto_tipo'] ?>"><?php echo $STip ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $widInf ?>" title="<?php echo $row['info'] ?>"><area style="background-color: #E1E1E1;"><?php echo $Info ?></area></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $widPos ?>"  title="<?php echo $row['posizione'] ?>"><?php echo $Posizione ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $widDt ?>" title="<?php echo $row['dt_abil'] ?>"><?php echo $DtAbil ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $widUt ?>" title="<?php echo  $row['utente'] ?>"><?php echo $Utente ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $widOp ?>">    
                    <a href="modifica_info_origami.php?Id=<?php echo($row['id']) ?>">
                        <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php $titleModifica ?>"/></a>
                        <a href="elimina_dato.php?NomeId=Id&Tabella=info_origami&IdRecord=<?php echo $row['id'] ?>&RefBack=gestione_info_origami.php">
                        <img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" title="<?php $titleElimina ?>"/></a>
                </td>

                </td>
            </tr>
            <?php
        }
        ?>
    </table>
