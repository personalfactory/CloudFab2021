<table class="table3">
  <tr>
    <th colspan="6"><?php echo $titoloLabPagMacchine ?></th>
  </tr>
  <tr>
    <td  colspan="6" style="text-align:center;"> 
      <p><a name="126" href="carica_lab_macchina.php"><?php echo $nuovaLabRosetta ?></a></p>
      <p>&nbsp;</p>
    </td>
  </tr>
  <tr>
    <th class="cella3"><?php echo $filtroLabNome ?></th>
    <th class="cella3"><?php echo $filtroLabDescri ?></th>
    <th class="cella3"><?php echo $filtroLabStato ?></th>
    <th class="cella3"><?php echo $filtroLabUtente ?></th>
    <th class="cella3"><?php echo $filtroLabData ?></th>
    <th name="125" class="cella3"><?php echo $filtroOperazioni  ?></th>
  </tr>
  <?php
  $i = 1;
  $colore = 1;
  while ($row = mysql_fetch_array($sql)) {
    if ($colore == 1) {
      ?>
      <tr>
        <td class="cella1"><?php echo($row['nome']) ?></td>
        <td class="cella1"><?php echo($row['descrizione']) ?></td>
        <td class="cella1"><?php
    if ($row['disponibile'] == 1){
      echo $filtroDisponibile;
    } else if ($row['disponibile'] == 0) {
      echo $filtroImpegnata;
  }?></td>
      <td class="cella1"><?php echo($row['utente']) ?></td>
      <td class="cella1"><?php echo($row['dt_abilitato']) ?></td>
      <td name="125" class="cella1"style="width:90px">
       <a name="126" href="elimina_lab_dato.php?Tabella=lab_macchina&NomeId=id_lab_macchina&IdRecord=<?php echo $row['id_lab_macchina'] ?>&RefBack=gestione_lab_macchine.php">
                    <img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone"  title="<?php echo $titleElimina ?> "/></a>
        <a name="125" href="lab_sblocca_macchina.php?IdLabMacchina=<?php echo($row['id_lab_macchina']) ?>">
            <img src="/CloudFab/images/pittogrammi/lucchetto_G.png" class="icone" 
                 title="<?php echo $titleSblocca ?>"/></a> 
      </td>
    </tr>
    <?php
    $colore = 2;
  } else{
  ?>
  <tr>
    <td class="cella2"><?php echo($row['nome']) ?></td>
    <td class="cella2"><?php echo($row['descrizione']) ?></td>
    <td class="cella2"><?php
    if ($row['disponibile'] == 1){
      echo $filtroDisponibile;
    } else if ($row['disponibile'] == 0) {
      echo $filtroImpegnata;
  }?></td>
    <td class="cella2"><?php echo($row['utente']) ?></td>
    <td class="cella2"><?php echo($row['dt_abilitato']) ?></td>
           <td name="125" class="cella2" style="width:90px">
        <a name="126" href="elimina_lab_dato.php?Tabella=lab_macchina&NomeId=id_lab_macchina&IdRecord=<?php echo $row['id_lab_macchina'] ?>&RefBack=gestione_lab_macchine.php">
                    <img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone"  title="<?php echo $titleElimina ?> "/></a>
      <a name="125" href="lab_sblocca_macchina.php?IdLabMacchina=<?php echo($row['id_lab_macchina']) ?>">
          <img src="/CloudFab/images/pittogrammi/lucchetto_G.png" class="icone" 
               title="<?php echo $titleSblocca ?>"/></a>
    </td>
  </tr>
  <?php
  $colore =1;
}
$i = $i + 1;
}
?>
</table>