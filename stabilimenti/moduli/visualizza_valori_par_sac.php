<?php
$wid1 = "10%";
$wid2 = "10%";
$wid3 = "20%";
$wid4 = "20%";
$wid5 = "20%";
$wid6 = "18%";
$wid7 = "1%";

?>
<table class="table3">
    <tr>
        <th colspan="8"><?php echo $titoloPaginaGestioneParInsacco ?></th>
    </tr>
    <tr>
        <td  colspan="8" style="text-align:center;"> 
            <p><a href="associa_parametro_sac_categorie.php"><?php echo $msgAssociaParACategorie ?></a></p>
            <p>&nbsp;</p>
            <p><a href="associa_categoria_parametri_sac.php"><?php echo $msgAssociaCatAParametri ?></a></p>
            <p>&nbsp;</p>
        </td>
    </tr>
</table>
 <!--################## MOTORE DI RICERCA ###################################-->
<form  name="VediParSac" id="VediParSac" action="" method="POST">
  <table class="table3">
    <tr>
      <td><input style="width:100%" type="text" name="IdValParSac" value="<?php echo $_SESSION['IdValParSac'] ?>" onChange="document.forms['VediParSac'].submit();"/></td>
      <td><input style="width:100%" type="text" name="IdParSac" value="<?php echo $_SESSION['IdParSac'] ?>" onChange="document.forms['VediParSac'].submit();"/></td>
      <td><input style="width:100%" type="text" name="NomeVariabile" value="<?php echo $_SESSION['NomeVariabile'] ?>" onChange="document.forms['VediParSac'].submit();"/></td>
      <td><input style="width:100%" type="text" name="NomeCategoria" value="<?php echo $_SESSION['NomeCategoria'] ?>"onChange="document.forms['VediParSac'].submit();" /></td>
      <td><input style="width:100%" type="text" name="NumSacchi" value="<?php echo $_SESSION['NumSacchi'] ?>" onChange="document.forms['VediParSac'].submit();"/></td>
      <td><input style="width:100%" type="text" name="DtAbilitato" value="<?php echo $_SESSION['DtAbilitato'] ?>" onChange="document.forms['VediParSac'].submit();"/></td>
    </tr>
 <!--################## RICERCA CON LIST BOX ################################-->
    <tr>      
      <td><select  style="width:100%" name="IdValParSacList" id="IdValParSacList"  onChange="document.forms['VediParSac'].submit();">
          <option  value="<?php echo $_SESSION['IdValParSacList'] ?>" selected="<?php echo $_SESSION['IdValParSacList'] ?>"></option>
          <?php
          $sqlIdVal = selectValParSacchettoByFiltri( $_SESSION['IdValParSac'],
                                        $_SESSION['IdParSac'],
                                        $_SESSION['NomeVariabile'],
                                        $_SESSION['NomeCategoria'],
                                        $_SESSION['NumSacchi'],
                                        $_SESSION['DtAbilitato'],
                                        'id_val_par_sac',
                                        'id_val_par_sac');
          while ($rowIdVal = mysql_fetch_array($sqlIdVal)) {
            ?>
            <option value="<?php echo $rowIdVal['id_val_par_sac']; ?>"><?php echo $rowIdVal['id_val_par_sac']; ?></option>
          <?php } ?>
        </select> </td>
      <td><select style="width:100%" name="IdParSacList" id="IdParSacList" onChange="document.forms['VediParSac'].submit();">
          <option value="<?php echo $_SESSION['IdParSacList'] ?>" selected="<?php echo $_SESSION['IdParSacList'] ?>"></option>
          <?php
          $sqlIdPar = selectValParSacchettoByFiltri( $_SESSION['IdValParSac'],
                                        $_SESSION['IdParSac'],
                                        $_SESSION['NomeVariabile'],
                                        $_SESSION['NomeCategoria'],
                                        $_SESSION['NumSacchi'],
                                        $_SESSION['DtAbilitato'],
                                        'id_par_sac',
                                        'id_par_sac');
          while ($rowIdPar = mysql_fetch_array($sqlIdPar)) {
            ?>
            <option value="<?php echo $rowIdPar['id_par_sac']; ?>"><?php echo $rowIdPar['id_par_sac']; ?></option>
          <?php } ?>
        </select></td>
      <td><select style="width:100%" name="NomeVariabileList" id="NomeVariabileList" onChange="document.forms['VediParSac'].submit();">
          <option value="<?php echo $_SESSION['NomeVariabileList'] ?>" selected="<?php echo $_SESSION['NomeVariabileList'] ?>"></option>
          <?php
          $sqlPar = selectValParSacchettoByFiltri( $_SESSION['IdValParSac'],
                                        $_SESSION['IdParSac'],
                                        $_SESSION['NomeVariabile'],
                                        $_SESSION['NomeCategoria'],
                                        $_SESSION['NumSacchi'],
                                        $_SESSION['DtAbilitato'],
                                        'nome_variabile',
                                        'nome_variabile');
          while ($rowPar = mysql_fetch_array($sqlPar)) {
            ?>
            <option value="<?php echo $rowPar['nome_variabile']; ?>"><?php echo $rowPar['nome_variabile']; ?></option>
          <?php } ?>
        </select></td>
        <td><select style="width:100%" name="NomeCategoriaList" id="NomeCategoriaList" onChange="document.forms['VediParSac'].submit();">
          <option value="<?php echo $_SESSION['NomeCategoriaList'] ?>" selected="<?php echo $_SESSION['NomeCategoriaList'] ?>"></option>
          <?php
          $sqlCat = selectValParSacchettoByFiltri( $_SESSION['IdValParSac'],
                                        $_SESSION['IdParSac'],
                                        $_SESSION['NomeVariabile'],
                                        $_SESSION['NomeCategoria'],
                                        $_SESSION['NumSacchi'],
                                        $_SESSION['DtAbilitato'],
                                        'nome_categoria',
                                        'nome_categoria');
          while ($rowCat = mysql_fetch_array($sqlCat)) {
            ?>
            <option value="<?php echo $rowCat['nome_categoria']; ?>"><?php echo $rowCat['nome_categoria']; ?></option>
          <?php } ?>
        </select></td>
        <td><select style="width:100%" name="NumSacchiList" id="NumSacchettiList" onChange="document.forms['VediParSac'].submit();">
          <option value="<?php echo $_SESSION['NumSacchiList'] ?>" selected="<?php echo $_SESSION['NumSacchiList'] ?>"></option>
          <?php
          $sqlNumSac = selectValParSacchettoByFiltri( $_SESSION['IdValParSac'],
                                        $_SESSION['IdParSac'],
                                        $_SESSION['NomeVariabile'],
                                        $_SESSION['NomeCategoria'],
                                        $_SESSION['NumSacchi'],
                                        $_SESSION['DtAbilitato'],
                                        'num_sacchetti',
                                        'num_sacchetti');
          while ($rowNumSac = mysql_fetch_array($sqlNumSac)) {
            ?>
            <option value="<?php echo $rowNumSac['num_sacchetti']; ?>"><?php echo $rowNumSac['num_sacchetti']; ?></option>
          <?php } ?>
        </select></td>
      <td><select style="width:100%" name="DtAbilitatoList" id="DtAbilitatoList" onChange="document.forms['VediParSac'].submit();">
          <option value="<?php echo $_SESSION['DtAbilitatoList'] ?>" selected="<?php echo $_SESSION['DtAbilitatoList'] ?>"></option>
          <?php
          $sqlDt = selectValParSacchettoByFiltri( $_SESSION['IdValParSac'],
                                        $_SESSION['IdParSac'],
                                        $_SESSION['NomeVariabile'],
                                        $_SESSION['NomeCategoria'],
                                        $_SESSION['NumSacchi'],
                                        $_SESSION['DtAbilitato'],
                                        'dt_abilitato',
                                        'dt_abilitato');
          while ($rowDt = mysql_fetch_array($sqlDt)) {
            ?>
            <option value="<?php echo $rowDt['dt_abilitato']; ?>"><?php echo $rowDt['dt_abilitato']; ?></option>
          <?php } ?>
        </select></td>
        <td width="<?php echo $wid10 ?>"> <img src="/CloudFab/images/icone/lente_piccola.png" onClick="document.forms['VediParSac'].submit();" title="<?php echo $titleRicerca ?>"/></td>
    </tr>
       
    
    <!--################## ORDINAMENTO ########################################-->
    <tr>    
      <td class="cella3" width="<?php echo $wid1 ?>"><div id="OrdinaIdValPar"><?php echo $filtroId; ?>
          <button name="Filtro" type="submit" value="id_val_par_sac" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
            <img src="/CloudFab/images/arrow3.png" /></button></div>
      </td>
      <td class="cella3" width="<?php echo $wid2 ?>"><div id="OrdinaIdPar"><?php echo $filtroIdPar; ?>
          <button name="Filtro" type="submit" value="id_par_sac" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
            <img src="/CloudFab/images/arrow3.png" /></button></div>
      </td>
      <td class="cella3" width="<?php echo $wid3 ?>"><div id="OrdinaNomeVar"><?php echo $filtroPar; ?>
          <button name="Filtro" type="submit" value="nome_variabile" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
            <img src="/CloudFab/images/arrow3.png" /></button></div>
      </td>
      <td class="cella3" width="<?php echo $wid4 ?>"><div id="OrdinaCat"><?php echo $filtroCategoria; ?>
          <button name="Filtro" type="submit" value="nome_categoria" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
            <img src="/CloudFab/images/arrow3.png" /></button></div>
      </td>
      <td class="cella3"  width="<?php echo $wid5 ?>"><div id="OrdinaVal"><?php echo $filtroNumSacchi; ?>
          <button name="Filtro" type="submit" value="num_sacchetti" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
            <img src="/CloudFab/images/arrow3.png" /></button></div>
      </td>
      <td class="cella3" width="<?php echo $wid6 ?>"><div id="OrdinaDtabil"><?php echo $filtroDt; ?>
          <button name="Filtro" type="submit" value="dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
            <img src="/CloudFab/images/arrow3.png" /></button></div>
      </td>
      
    </tr>
    <?php
    echo "<br/>".$msgRecordTrovati.$trovati."<br/>";
    echo "<br/>".$msgSelectListCriteriRicerca."<br/>";

    $i = 1;
    $colore = 1;
    while ($row = mysql_fetch_array($sql)) {
        if ($colore == 1) {
            ?>
            <tr>
                <td class="cella1" width="<?php echo $wid1 ?>"><?php echo($row['id_val_par_sac']) ?></td>
                <td class="cella1" width="<?php echo $wid2 ?>"><?php echo($row['id_par_sac']) ?></td>
                <td class="cella1" width="<?php echo $wid3 ?>"><a href="modifica_valore_par_sac.php?IdValPar=<?php echo($row['id_val_par_sac']) ?>"><?php echo($row['nome_variabile']) ?></a></td>
                <td class="cella1" width="<?php echo $wid4 ?>"><a href="../prodotti/modifica_categoria.php?IdCategoria=<?php echo($row['id_cat']) ?>"><?php echo($row['nome_categoria']) ?></a></td>
                <td class="cella1" width="<?php echo $wid5 ?>"><?php echo($row['num_sacchetti']) ?></td>
                <td class="cella1" width="<?php echo $wid6 ?>"><?php echo($row['dt_abilitato']) ?></td>
            </tr>
        <?php
        $colore = 2;
    } else {
        ?>
            <tr>
                <td class="cella2" width="<?php echo $wid1 ?>"><?php echo($row['id_val_par_sac']) ?></td>
                <td class="cella2" width="<?php echo $wid2 ?>"><?php echo($row['id_par_sac']) ?></td>
                <td class="cella2" width="<?php echo $wid3 ?>"><a href="modifica_valore_par_sac.php?IdValPar=<?php echo($row['id_val_par_sac'])?>"><?php echo($row['nome_variabile']) ?></a></td>
                <td class="cella2" width="<?php echo $wid4 ?>"><a href="../prodotti/modifica_categoria.php?IdCategoria=<?php echo($row['id_cat']) ?>"><?php echo($row['nome_categoria']) ?></a></td>
                <td class="cella2" width="<?php echo $wid5 ?>"><?php echo($row['num_sacchetti']) ?></td>
                <td class="cella2" width="<?php echo $wid6 ?>"><?php echo($row['dt_abilitato']) ?></td>
            </tr>
            <?php
            $colore = 1;
        }
        $i = $i + 1;
    }
    ?>
</table>