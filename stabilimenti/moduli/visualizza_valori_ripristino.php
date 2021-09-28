<table class="table3">
  <tr>
    <th colspan="8"><?php echo $titoloValoriRipristino?></th>
  </tr>
  <?php
  include('../include/funzioni.php');
//  formRicerca("cerca_val_ripristino.php");

  //########### VARIABILI UTILE ALLA SCELTA ORDINAMENTO ######################
  $IdParametro = "id_par_ripristino";
  $IdValore = "id_valore_ripristino";
  $NomeParametro = "nome_variabile";
  $CodStab = "cod_stab";
  $DescriStab = "descri_stab";
  $ValoreVariabile = "valore_variabile";
  $DataAbilitato = "dt_abilitato";
  $DataRegistrato = "dt_registrato";
  $DataAggMac = "dt_agg_mac";
  //##########################################################################
  ?>
  <tr>
    <th class="cella3">
      <a href="<?php echo $_SERVER['PHP_SELF'] ?>?NomeCampo=<?php echo $DescriStab ?>"><?php echo $filtroStabilimento ?></a></th>
    <th class="cella3">
      <a href="<?php echo $_SERVER['PHP_SELF'] ?>?NomeCampo=<?php echo $IdValore ?>"><?php echo $filtroIdValore?></a></th>
    <th class="cella3">
      <a href="<?php echo $_SERVER['PHP_SELF'] ?>?NomeCampo=<?php echo $IdParametro ?>"><?php echo $filtroId?></a></th>
    <th class="cella3">
      <a href="<?php echo $_SERVER['PHP_SELF'] ?>?NomeCampo=<?php echo $NomeParametro ?>"><?php echo $filtroPar?></a></th>

    <th class="cella3">
      <a href="<?php echo $_SERVER['PHP_SELF'] ?>?NomeCampo=<?php echo $ValoreVariabile ?>"><?php echo $filtroValore?></a></th>
    <th class="cella3">
      <a href="<?php echo $_SERVER['PHP_SELF'] ?>?NomeCampo=<?php echo $DataRegistrato ?>"><?php echo $filtroDtRegMac?></a></th>
    <th class="cella3">
      <a href="<?php echo $_SERVER['PHP_SELF'] ?>?NomeCampo=<?php echo $DataAbilitato ?>"><?php echo $filtroDtModServer?></a></th>
    <th class="cella3">
      <a href="<?php echo $_SERVER['PHP_SELF'] ?>?NomeCampo=<?php echo $DataAggMac ?>"><?php echo $filtroDtDownloadAgg?></a></th>
    <th class="cella3">Operazioni</th>

  </tr>
  <?php
  $i = 1;
  $colore = 1;
  while ($row = mysql_fetch_array($sql)) {
    if ($colore == 1) {
      ?>
      <tr>
        <td class="cella1"><?php echo($row['descri_stab']) ?></td> 
        <td class="cella1"><?php echo($row['id_valore_ripristino']) ?></td>
        <td class="cella1"><?php echo($row['id_par_ripristino']) ?></td>
        <td class="cella1"><?php echo($row['nome_variabile']) ?></td>
        <td class="cella1"><?php echo($row['valore_variabile']) ?></td>
        <td class="cella1"><?php echo dataEstraiVisualizza($row['dt_registrato']) ?></td>
        <td class="cella1"><?php echo dataEstraiVisualizza($row['dt_abilitato']) ?></td>
        <td class="cella1"><?php echo dataEstraiVisualizza($row['dt_agg_mac']) ?></td>
        <td class="cella1"style="width:90px">
          <a href="modifica_valore_ripristino.php?IdMacchina=<?php echo($row['id_macchina']) ?>">
            <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica?>"/></a>
        </td>
      </tr>
      <?php
      $colore = 2;
    } else {
      ?>
      <tr>
        <td class="cella2"><?php echo($row['descri_stab']) ?></td>
        <td class="cella2"><?php echo($row['id_valore_ripristino']) ?></td>
        <td class="cella2"><?php echo($row['id_par_ripristino']) ?></td>
        <td class="cella2"><?php echo($row['nome_variabile']) ?></td>
        <td class="cella2"><?php echo($row['valore_variabile']) ?></td>
        <td class="cella2"><?php echo dataEstraiVisualizza($row['dt_registrato']) ?></td>
        <td class="cella2"><?php echo dataEstraiVisualizza($row['dt_abilitato']) ?></td>
        <td class="cella1"><?php echo dataEstraiVisualizza($row['dt_agg_mac']) ?></td>
        <td class="cella2"style="width:90px">
          <a href="modifica_valore_ripristino.php?IdMacchina=<?php echo($row['id_macchina']) ?>">
            <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica?>"/></a>
        </td>
      </tr>
      <?php
      $colore = 1;
    }
    $i = $i + 1;
  }
  ?>
</table>