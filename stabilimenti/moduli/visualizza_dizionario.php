<?php
    $wid1 = "5%";
    $wid2 = "15%";
    $wid3 = "15%";
    $wid4 = "15%";
    $wid5 = "10%";
    $wid6 = "35%";
    $wid7 = "5%";
   
      
    ?>	

<script type="text/javascript" src="../js/popup.js"></script>
<table class="table3">

    <tr>
        <th colspan="5"><?php echo $filtroDizionario ?></th>
    </tr>
</tr>
<tr>
    <td  colspan="6" style="text-align:center;"> 
        <p><a href="aggiorna_dizionario.php"><?php echo $msgAggiornaDizionario ?></a></p>
        <p>&nbsp;</p>
    </td>
</tr>
 <!--################## MOTORE DI RICERCA ###################################-->
<form  name="VediDiz" id="VediDiz" action="" method="GET">
  <table class="table3">
    <tr>
      <td><input type="text" style="width:100%" name="IdDiz" value="<?php echo $_SESSION['IdDiz'] ?>" /></td>
      <td><input type="text" style="width:100%" name="DtAbilitato" value="<?php echo $_SESSION['DtAbilitato'] ?>" /></td>
      <td><input type="text" style="width:100%" name="DizionarioTipo" value="<?php echo $_SESSION['DizionarioTipo'] ?>" /></td>
      <td><input type="text" style="width:100%" name="LinguaScelta" value="<?php echo $_SESSION['LinguaScelta'] ?>" /></td>
      <td><input type="text" style="width:100%" name="IdVocabolo" value="<?php echo $_SESSION['IdVocabolo'] ?>" /></td>
      <td><input type="text" style="width:100%" name="Vocabolo" value="<?php echo $_SESSION['Vocabolo'] ?>" /></td>
      
    </tr>
    
    <!--################## RICERCA CON LIST BOX ###############################-->
    <tr>      
      <td><select  style="width:100%" name="IdDizList" id="IdDizList"  onChange="document.forms['VediDiz'].submit();">
          <option  value="<?php echo $_SESSION['IdDizList'] ?>" selected="<?php echo $_SESSION['IdDizList'] ?>"></option>
          <?php
          $sqlIdDiz = selectDizionarioByFiltri( $_SESSION['LinguaScelta'],
              $_SESSION['IdDiz'],
              $_SESSION['DizionarioTipo'],
              $_SESSION['IdVocabolo'],
              $_SESSION['Vocabolo'],
              $_SESSION['DtAbilitato'],
              $_SESSION['Filtro'],
              'id_dizionario');
          while ($rowIdDiz = mysql_fetch_array($sqlIdDiz)) {
            ?>
            <option value="<?php echo $rowIdDiz['id_dizionario']; ?>"><?php echo $rowIdDiz['id_dizionario']; ?></option>
          <?php } ?>
        </select> </td>
        <td><select  style="width:100%" name="DtAbilitatoList" id="DtAbilitatoList" onChange="document.forms['VediDiz'].submit();">
          <option value="<?php echo $_SESSION['DtAbilitatoList'] ?>" selected="<?php echo $_SESSION['DtAbilitatoList'] ?>"></option>
          <?php
          $sqlDt =  selectDizionarioByFiltri( $_SESSION['LinguaScelta'],
              $_SESSION['IdDiz'],
              $_SESSION['DizionarioTipo'],
              $_SESSION['IdVocabolo'],
              $_SESSION['Vocabolo'],
              $_SESSION['DtAbilitato'],
              $_SESSION['Filtro'],
              'dt_abilitato');
          while ($rowDt = mysql_fetch_array($sqlDt)) {
            ?>
            <option value="<?php echo $rowDt['dt_abilitato']; ?>"><?php echo $rowDt['dt_abilitato']; ?></option>
          <?php } ?>
        </select></td>
      <td><select  style="width:100%" name="DizionarioTipoList" id="DizionarioTipoList" onChange="document.forms['VediDiz'].submit();">
          <option value="<?php echo $_SESSION['DizionarioTipoList'] ?>" selected="<?php echo $_SESSION['DizionarioTipoList'] ?>"></option>
          <?php
          $sqlDizTipo = selectDizionarioByFiltri( $_SESSION['LinguaScelta'],
              $_SESSION['IdDiz'],
              $_SESSION['DizionarioTipo'],
              $_SESSION['IdVocabolo'],
              $_SESSION['Vocabolo'],
              $_SESSION['DtAbilitato'],
              $_SESSION['Filtro'],
              'dizionario_tipo');
          while ($rowTipo = mysql_fetch_array($sqlDizTipo)) {
            ?>
            <option value="<?php echo $rowTipo['dizionario_tipo']; ?>"><?php echo $rowTipo['dizionario_tipo']; ?></option>
          <?php } ?>
        </select></td>
        <td><select  style="width:100%" name="LinguaSceltaList" id="LinguaSceltaList" onChange="document.forms['VediDiz'].submit();">
          <option value="<?php echo $_SESSION['LinguaSceltaList'] ?>" selected="<?php echo $_SESSION['LinguaSceltaList'] ?>"></option>
          <?php
          $sqlLingua = selectDizionarioByFiltri( $_SESSION['LinguaScelta'],
              $_SESSION['IdDiz'],
              $_SESSION['DizionarioTipo'],
              $_SESSION['IdVocabolo'],
              $_SESSION['Vocabolo'],
              $_SESSION['DtAbilitato'],
              $_SESSION['Filtro'],
              'lingua');
          while ($rowLingua = mysql_fetch_array($sqlLingua)) {
            ?>
            <option value="<?php echo $rowLingua['lingua']; ?>"><?php echo $rowLingua['lingua']; ?></option>
          <?php } ?>
        </select></td>
      <td><select style="width:100%"  name="IdVocaboloList" id="IdVocaboloList" onChange="document.forms['VediDiz'].submit();">
          <option value="<?php echo $_SESSION['IdVocaboloList'] ?>" selected="<?php echo $_SESSION['IdVocaboloList'] ?>"></option>
          <?php
          $sqlIdVoc = selectDizionarioByFiltri( $_SESSION['LinguaScelta'],
              $_SESSION['IdDiz'],
              $_SESSION['DizionarioTipo'],
              $_SESSION['IdVocabolo'],
              $_SESSION['Vocabolo'],
              $_SESSION['DtAbilitato'],
              $_SESSION['Filtro'],
              'id_vocabolo');
          while ($rowIdVoc = mysql_fetch_array($sqlIdVoc)) {
            ?>
            <option value="<?php echo $rowIdVoc['id_vocabolo']; ?>"><?php echo $rowIdVoc['id_vocabolo']; ?></option>
          <?php } ?>
        </select></td>
        <td><select  style="width:100%" name="VocaboloList" id="VocaboloList" onChange="document.forms['VediDiz'].submit();">
          <option value="<?php echo $_SESSION['VocaboloList'] ?>" selected="<?php echo $_SESSION['VocaboloList'] ?>"></option>
          <?php
          $sqlVoc= selectDizionarioByFiltri( $_SESSION['LinguaScelta'],
              $_SESSION['IdDiz'],
              $_SESSION['DizionarioTipo'],
              $_SESSION['IdVocabolo'],
              $_SESSION['Vocabolo'],
              $_SESSION['DtAbilitato'],
              $_SESSION['Filtro'],
              'vocabolo');
          while ($rowVoc = mysql_fetch_array($sqlVoc)) {
            ?>
            <option value="<?php echo $rowVoc['vocabolo']; ?>"><?php echo $rowVoc['vocabolo']; ?></option>
          <?php } ?>
        </select></td>
      <td><input type="button" value="<?php echo $valueButtonCerca ?>" onClick="document.forms['VediDiz'].submit();"/></td>
    </tr>
    
    <!--################## ORDINAMENTO ########################################-->
    <tr>              
      <td class="cella3" width="<?php echo $wid1 ?>"><div id="OrdinaIdDiz"><?php echo $filtroIdDiz; ?>
          <button name="Filtro" type="submit" value="id_dizionario" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
            <img src="/CloudFab/images/arrow3.png" /></button></div>
      </td>
        <td class="cella3"  width="<?php echo $wid2 ?>"><div id="OrdinaDtabil"><?php echo $filtroDt; ?>
          <button name="Filtro" type="submit" value="dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
            <img src="/CloudFab/images/arrow3.png" /></button></div>
      </td>
      <td class="cella3" width="<?php echo $wid3 ?>"><div id="OrdinaDizTipo"><?php echo $filtroDizTipo; ?>
          <button name="Filtro" type="submit" value="dizionario_tipo" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
            <img src="/CloudFab/images/arrow3.png" /></button></div>
      </td>
       <td class="cella3" width="<?php echo $wid4 ?>"><div id="OrdinaLingua"><?php echo $filtroLingua; ?>
          <button name="Filtro" type="submit" value="lingua" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
            <img src="/CloudFab/images/arrow3.png" /></button></div>
      </td>
      <td class="cella3" width="<?php echo $wid5 ?>"><div id="OrdinaIdVocabolo"><?php echo $filtroIdVocabolo; ?>
          <button name="Filtro" type="submit" value="id_vocabolo" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
            <img src="/CloudFab/images/arrow3.png" /></button></div>
      </td>
      <td class="cella3" width="<?php echo $wid6 ?>"><div id="OrdinaVocabolo"><?php echo $filtroVocabolo; ?>
          <button name="Filtro" type="submit" value="vocabolo" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
            <img src="/CloudFab/images/arrow3.png" /></button></div>
      </td>
    
      <td class="cella3" width="<?php echo $wid6 ?>"><?php echo $filtroTraduzione; ?></td>
    </tr>
    <?php
    echo "<br/>".$msgRecordTrovati.$trovati."<br/>";
     echo "<br/>".$msgSelectListCriteriRicerca."<br/>";

?>


<?php
$i = 1;
$colore = 1;
while ($row = mysql_fetch_array($sql)) {
    if ($colore == 1) {
        ?>
        <tr>
            <td class="cella1" width="<?php echo $wid1 ?>"><?php echo($row['id_dizionario']) ?></td>
            <td class="cella1" width="<?php echo $wid2 ?>"><?php echo($row['dt_abilitato']) ?></td>
            <td class="cella1" width="<?php echo $wid3 ?>"><?php echo($row['dizionario_tipo']) ?></td>
            <td class="cella1" width="<?php echo $wid4 ?>"><?php echo($row['lingua']) ?></td>
            <td class="cella1" width="<?php echo $wid5 ?>"><?php echo($row['id_vocabolo']) ?></td>
            <td class="cella1" width="<?php echo $wid6 ?>"><?php echo($row['vocabolo']) ?></td>
            <td class="cella1" width="<?php echo $wid7 ?>">
        <!--<a href="JavaScript:openWindow('carica_vocabolo_new.php?IdDizionario=<?php echo($row['id_dizionario']) ?>')">
        <img src="/CloudFab/images/pittogrammi/freccia_R.png" class="icone" title="Inserisci traduzione"/></a>-->
                <a href="JavaScript:openWindowDizionario('modifica_vocabolo.php?IdDizionario=<?php echo($row['id_dizionario']) ?>')">
                    <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleTraduzione?>"/></a>

            </td>
        </tr>
        <?php
        $colore = 2;
    } else {
        ?>
        <tr>
            <td class="cella2" width="<?php echo $wid1 ?>"><?php echo($row['id_dizionario']) ?></td>
            <td class="cella2" width="<?php echo $wid2 ?>"><?php echo($row['dt_abilitato']) ?></td>
            <td class="cella2" width="<?php echo $wid3 ?>"><?php echo($row['dizionario_tipo']) ?></td>
            <td class="cella2" width="<?php echo $wid4 ?>"><?php echo($row['lingua']) ?></td>
            <td class="cella2" width="<?php echo $wid5 ?>"><?php echo($row['id_vocabolo']) ?></td>
            <td class="cella2" width="<?php echo $wid6 ?>"><?php echo($row['vocabolo']) ?></td>
            <td class="cella2" width="<?php echo $wid7 ?>">
        <!--<a href="JavaScript:openWindow('carica_vocabolo_new.php?IdDizionario=<?php echo($row['id_dizionario']) ?>')">
               <img src="/CloudFab/images/pittogrammi/freccia_R.png" class="icone" title="Inserisci traduzione"/></a>-->
                 <a href="JavaScript:openWindowDizionario('modifica_vocabolo.php?IdDizionario=<?php echo($row['id_dizionario']) ?>')">
                    <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleTraduzione?>"/></a>
            </td>
        </tr>
        <?php
        $colore = 1;
    }
    $i = $i + 1;
}
?>
</table>