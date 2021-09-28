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
        <th colspan="8"><?php echo $titoloPaginaValParProdotto ?> </th>
    </tr>
    <tr>
        <td  colspan="8" style="text-align:center;"> 
            <p><a href="associa_parametro_categorie.php"><?php echo $msgAssociaParACategorie ?></a></p>
            <p>&nbsp;</p>
            <p><a href="associa_categoria_parametri.php"><?php echo $msgAssociaCatAParametri ?></a></p>
            <p>&nbsp;</p>
        </td>
    </tr>   
</table>
     <!--################## MOTORE DI RICERCA ###################################-->
<form  name="VediParProd" id="VediParProd" action="" method="POST">
  <table class="table3" >
    <tr>
      <td><input style="width:100%" type="text" name="IdValParProd" value="<?php echo $_SESSION['IdValParProd'] ?>" onChange="document.forms['VediParProd'].submit();"/></td>
      <td><input style="width:100%" type="text" name="IdParProd" value="<?php echo $_SESSION['IdParProd'] ?>" onChange="document.forms['VediParProd'].submit();"/></td>
      <td><input style="width:100%" type="text" name="NomeVariabile" value="<?php echo $_SESSION['NomeVariabile'] ?>" onChange="document.forms['VediParProd'].submit();"/></td>
      <td><input style="width:100%" type="text" name="NomeCategoria" value="<?php echo $_SESSION['NomeCategoria'] ?>"onChange="document.forms['VediParProd'].submit();" /></td>
      <td><input style="width:100%" type="text" name="ValoreVariabile" value="<?php echo $_SESSION['ValoreVariabile'] ?>"onChange="document.forms['VediParProd'].submit();"/></td>
      <td><input style="width:100%" type="text" name="DtAbilitato" value="<?php echo $_SESSION['DtAbilitato'] ?>" onChange="document.forms['VediParProd'].submit();"/></td>
    </tr>
 <!--################## RICERCA CON LIST BOX ################################-->
    <tr>      
      <td><select  style="width:100%" name="IdValParProdList" id="IdValParSacList"  onChange="document.forms['VediParProd'].submit();">
          <option  value="<?php echo $_SESSION['IdValParProdList'] ?>" selected="<?php echo $_SESSION['IdValParProdList'] ?>"></option>
          <?php
          $sqlIdVal =  selectValParProdottoByFiltri($_SESSION['IdValParProd'],
                                        $_SESSION['IdParProd'],
                                        $_SESSION['NomeVariabile'],
                                        $_SESSION['NomeCategoria'],
                                        $_SESSION['ValoreVariabile'],
                                        $_SESSION['DtAbilitato'],
                                        $_SESSION['Filtro'],
                                        'id_val_par_pr');
          while ($rowIdVal = mysql_fetch_array($sqlIdVal)) {
            ?>
            <option value="<?php echo $rowIdVal['id_val_par_pr']; ?>"><?php echo $rowIdVal['id_val_par_pr']; ?></option>
          <?php } ?>
        </select> </td>
      <td><select style="width:100%" name="IdParProdList" id="IdParProdList" onChange="document.forms['VediParProd'].submit();">
          <option value="<?php echo $_SESSION['IdParProdList'] ?>" selected="<?php echo $_SESSION['IdParProdList'] ?>"></option>
          <?php
          $sqlIdPar = selectValParProdottoByFiltri($_SESSION['IdValParProd'],
                                        $_SESSION['IdParProd'],
                                        $_SESSION['NomeVariabile'],
                                        $_SESSION['NomeCategoria'],
                                        $_SESSION['ValoreVariabile'],
                                        $_SESSION['DtAbilitato'],
                                        $_SESSION['Filtro'],
                                        'id_par_prod');
          while ($rowIdPar = mysql_fetch_array($sqlIdPar)) {
            ?>
            <option value="<?php echo $rowIdPar['id_par_prod']; ?>"><?php echo $rowIdPar['id_par_prod']; ?></option>
          <?php } ?>
        </select></td>
      <td><select style="width:100%" name="NomeVariabileList" id="NomeVariabileList" onChange="document.forms['VediParProd'].submit();">
          <option value="<?php echo $_SESSION['NomeVariabileList'] ?>" selected="<?php echo $_SESSION['NomeVariabileList'] ?>"></option>
          <?php
          $sqlPar = selectValParProdottoByFiltri($_SESSION['IdValParProd'],
                                        $_SESSION['IdParProd'],
                                        $_SESSION['NomeVariabile'],
                                        $_SESSION['NomeCategoria'],
                                        $_SESSION['ValoreVariabile'],
                                        $_SESSION['DtAbilitato'],
                                        $_SESSION['Filtro'],
                                        'nome_variabile');
          while ($rowPar = mysql_fetch_array($sqlPar)) {
            ?>
            <option value="<?php echo $rowPar['nome_variabile']; ?>"><?php echo $rowPar['nome_variabile']; ?></option>
          <?php } ?>
        </select></td>
        <td><select style="width:100%" name="NomeCategoriaList" id="NomeCategoriaList" onChange="document.forms['VediParProd'].submit();">
          <option value="<?php echo $_SESSION['NomeCategoriaList'] ?>" selected="<?php echo $_SESSION['NomeCategoriaList'] ?>"></option>
          <?php
          $sqlCat =  selectValParProdottoByFiltri($_SESSION['IdValParProd'],
                                        $_SESSION['IdParProd'],
                                        $_SESSION['NomeVariabile'],
                                        $_SESSION['NomeCategoria'],
                                        $_SESSION['ValoreVariabile'],
                                        $_SESSION['DtAbilitato'],
                                        $_SESSION['Filtro'],
                                        'nome_categoria');
          while ($rowCat = mysql_fetch_array($sqlCat)) {
            ?>
            <option value="<?php echo $rowCat['nome_categoria']; ?>"><?php echo $rowCat['nome_categoria']; ?></option>
          <?php } ?>
        </select></td>
        <td><select style="width:100%" name="ValoreVariabileList" id="NumSacchettiList" onChange="document.forms['VediParProd'].submit();">
          <option value="<?php echo $_SESSION['ValoreVariabileList'] ?>" selected="<?php echo $_SESSION['ValoreVariabileList'] ?>"></option>
          <?php
          $sqlVal = selectValParProdottoByFiltri($_SESSION['IdValParProd'],
                                        $_SESSION['IdParProd'],
                                        $_SESSION['NomeVariabile'],
                                        $_SESSION['NomeCategoria'],
                                        $_SESSION['ValoreVariabile'],
                                        $_SESSION['DtAbilitato'],
                                        $_SESSION['Filtro'],
                                        'valore_variabile');
          while ($rowVal = mysql_fetch_array($sqlVal)) {
            ?>
            <option value="<?php echo $rowVal['valore_variabile']; ?>"><?php echo $rowVal['valore_variabile']; ?></option>
          <?php } ?>
        </select></td>
      <td><select style="width:100%" name="DtAbilitatoList" id="DtAbilitatoList" onChange="document.forms['VediParProd'].submit();">
          <option value="<?php echo $_SESSION['DtAbilitatoList'] ?>" selected="<?php echo $_SESSION['DtAbilitatoList'] ?>"></option>
          <?php
          $sqlDt = selectValParProdottoByFiltri($_SESSION['IdValParProd'],
                                        $_SESSION['IdParProd'],
                                        $_SESSION['NomeVariabile'],
                                        $_SESSION['NomeCategoria'],
                                        $_SESSION['ValoreVariabile'],
                                        $_SESSION['DtAbilitato'],
                                        $_SESSION['Filtro'],
                                        'dt_abilitato');
          while ($rowDt = mysql_fetch_array($sqlDt)) {
            ?>
            <option value="<?php echo $rowDt['dt_abilitato']; ?>"><?php echo $rowDt['dt_abilitato']; ?></option>
          <?php } ?>
        </select></td>
        <td width="<?php echo $wid10 ?>"> <img src="/CloudFab/images/icone/lente_piccola.png" onClick="document.forms['VediParProd'].submit();" title="<?php echo $titleRicerca ?>"/></td>
    </tr>
           
    <!--################## ORDINAMENTO ########################################-->
    <tr>    
      <td class="cella3" width="<?php echo $wid1 ?>"><div id="OrdinaIdValPar"><?php echo $filtroId; ?>
          <button name="Filtro" type="submit" value="id_val_par_pr" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
            <img src="/CloudFab/images/arrow3.png" /></button></div>
      </td>
      <td class="cella3" width="<?php echo $wid2 ?>"><div id="OrdinaIdPar"><?php echo $filtroIdPar; ?>
          <button name="Filtro" type="submit" value="id_par_prod" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
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
      <td class="cella3"  width="<?php echo $wid5 ?>"><div id="OrdinaVal"><?php echo $filtroValore; ?>
          <button name="Filtro" type="submit" value="valore_variabile" class="button3" title="<?php echo $titleOrdinaCresc; ?>">
            <img src="/CloudFab/images/arrow3.png" /></button></div>
      </td>
      <td class="cella3" width="<?php echo $wid6 ?>"><div id="OrdinaDtabil"><?php echo $filtroDt; ?>
          <button name="Filtro" type="submit" value="dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
            <img src="/CloudFab/images/arrow3.png" /></button></div>
      </td>
   </tr>
   
    <?php
   echo "<br/>" . $msgRecordTrovati . $trovati . "<br/>";
   echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";
       
    $colore = 1;
    while ($row = mysql_fetch_array($sql)) {
        if ($colore == 1) {
            ?>
            <tr>
                <td class="cella1" width="<?php echo $wid1 ?>"><?php echo ($row['id_val_par_pr']) ?></td>
                <td class="cella1" width="<?php echo $wid2 ?>"><?php echo ($row['id_par_prod']) ?></td>
                <td class="cella1" width="<?php echo $wid3 ?>" title="<?php echo($row['descri_variabile']) ?>">
                    <a href="modifica_valore_par_prod.php?IdParametro=<?php echo($row['id_par_prod']) ?>"><?php echo($row['nome_variabile']) ?></a></td>
                    <td class="cella1" width="<?php echo $wid4 ?>"title="<?php echo ($row['descri_categoria'])?>">
                    <a href="modifica_valore_categoria.php?IdCategoria=<?php echo($row['id_cat']) ?>"><?php echo($row['nome_categoria']) ?></a></td>
                <td class="cella1" width="<?php echo $wid5 ?>"><?php echo($row['valore_variabile']) ?></td>
                <td class="cella1" width="<?php echo $wid6 ?>"><?php echo($row['dt_abilitato']) ?></td>
            </tr>
            <?php
            $colore = 2;
        } else {
            ?>
            <tr>
                <td class="cella2" width="<?php echo $wid1 ?>"><?php echo ($row['id_val_par_pr']) ?></td>
                <td class="cella2" width="<?php echo $wid2 ?>"><?php echo ($row['id_par_prod']) ?></td>
                <td class="cella2" width="<?php echo $wid3 ?>" title="<?php echo($row['descri_variabile']) ?>">
                    <a href="modifica_valore_par_prod.php?IdParametro=<?php echo($row['id_par_prod']) ?>"><?php echo($row['nome_variabile']) ?></a></td>
                <td class="cella2" width="<?php echo $wid4 ?>" title="<?php echo ($row['descri_categoria'])?>">
                    <a href="modifica_valore_categoria.php?IdCategoria=<?php echo($row['id_cat']) ?>"><?php echo($row['nome_categoria']) ?></a></td>
                <td class="cella2" width="<?php echo $wid5 ?>"><?php echo($row['valore_variabile']) ?></td>
                <td class="cella2" width="<?php echo $wid6 ?>"><?php echo($row['dt_abilitato']) ?></td>
            </tr>
            <?php
            $colore = 1;
        }
      
    }
    ?>
</table>