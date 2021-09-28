<?php
//Larghezza colonne 
$wid1 = "10%";// +10px padding (l+r)
$wid2 = "25%";// +10px padding (l+r)
$wid3 = "20%";// +10px padding (l+r)
$wid4 = "20%";// +10px padding (l+r)
$wid5 = "10%";// +10px padding (l+r)
$wid6 = "15%px";// +10px padding (l+r)

//TOTALE 1170px
?>
<table class="table3">
  <tr>
    <th colspan="6"> <?php echo $titoloPaginaMagOri ?></th>
  </tr>  
   <tr>
    <th colspan="6"> <?php echo $DescriStab ?></th>
  </tr> 
  <tr>
    <td><?php echo $filtroKitNonUsati." : " . $KitTotali ?></td>
  </tr>
  <?php
  include('../include/funzioni.php');
  include('../include/gestione_date.php');

  ?>
  <form  name="VediMagOri" id="VediMagOri" action="" method="POST">
    <table class="table3">
        <tr>
            <td><input style="width:100%" type="text" name="CodProdotto" value="<?php echo $_SESSION['CodProdotto'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Prodotto" value="<?php echo $_SESSION['Prodotto'] ?>" /></td>
            <td><input style="width:100%" type="text" name="CodKit" value="<?php echo $_SESSION['CodKit'] ?>" /></td>
            <td><input style="width:100%" type="text" name="CodLotto" value="<?php echo $_SESSION['CodLotto'] ?>" /></td>
            <td><input style="width:100%" type="text" name="Ddt" value="<?php echo $_SESSION['Ddt'] ?>" /></td>
            <td><input style="width:100%" type="text" name="DtDdt" value="<?php echo $_SESSION['DtDdt'] ?>" /></td>
            <td><img src="/CloudFab/images/icone/lente_piccola.png" onClick="document.forms['VediMagOri'].submit();" title="<?php echo $titleRicerca?>"/></td>
        </tr>
        
        <!--################## ORDINAMENTO ########################################-->
        <tr>              

            <td class="cella3" width="<?php echo $wid1 ?>"><div id="OrdinaCod"><?php echo $filtroCodice; ?>
                    <button name="Filtro" type="submit" value="cod_prodotto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid2 ?>"><div id="OrdinaDes"><?php echo $filtroProdotto; ?>
                    <button name="Filtro" type="submit" value="descri_formula" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid3 ?>"><div id="OrdinaKit"><?php echo $filtroKitChim; ?>
                    <button name="Filtro" type="submit" value="cod_chimica" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid4 ?>"><div id="OrdinaLotto"><?php echo $filtroLottoChimica; ?>
                    <button name="Filtro" type="submit" value="cod_lotto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid5 ?>"><div id="OrdinaDdt"><?php echo $filtroNumDdt; ?>
                    <button name="Filtro" type="submit" value="b.num_bolla" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid6 ?>"><div id="OrdinaDtDdt"><?php echo $filtroDtDdt; ?>
                    <button name="Filtro" type="submit" value="b.dt_bolla" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
                      

        </tr>
  
  <?php
  $i = 1;
  $colore = 1;
  while ($row = mysql_fetch_array($sql)) {

    if ($colore == 1) {
      ?>
      <tr>        
        <td class="cella1" width="<?php echo $wid1 ?>"><?php echo($row['cod_prodotto']) ?></td>
        <td class="cella1" width="<?php echo $wid2 ?>"><?php echo($row['descri_formula']) ?></td>
        <td class="cella1" width="<?php echo $wid3 ?>"><a name="91" href="/CloudFab/produzionechimica/dettaglio_chimica.php?Chimica=<?php echo ($row['cod_chimica']) ?>"><?php echo($row['cod_chimica']) ?></a></td>
        <td class="cella1" width="<?php echo $wid4 ?>"><a name="92" href="/CloudFab/produzionechimica/dettaglio_lotto.php?Lotto=<?php echo($row['cod_lotto']) ?>"><?php echo($row['cod_lotto']) ?></a></td>
        <td class="cella1" width="<?php echo $wid5 ?>"><?php echo($row['num_bolla']) ?></td>
        <td class="cella1" width="<?php echo $wid6 ?>"><?php echo($row['dt_bolla']) ?></td>
      </tr>
      <?php
      $colore = 2;
    } else {
      ?>
      <tr>        
        <td class="cella2" width="<?php echo $wid1 ?>"><?php echo($row['cod_prodotto']) ?></td>
        <td class="cella2" width="<?php echo $wid2 ?>"><?php echo($row['descri_formula']) ?></td>
        <td class="cella2" width="<?php echo $wid3 ?>"><a name="91" href="/CloudFab/produzionechimica/dettaglio_chimica.php?Chimica=<?php echo($row['cod_chimica']) ?>"><?php echo($row['cod_chimica']) ?></a></td>
        <td class="cella2" width="<?php echo $wid4 ?>"><a name="92" href="/CloudFab/produzionechimica/dettaglio_lotto.php?Lotto=<?php echo($row['cod_lotto']) ?>"><?php echo($row['cod_lotto']) ?></a></td>
        <td class="cella2" width="<?php echo $wid5 ?>"><?php echo($row['num_bolla']) ?></td>
        <td class="cella2" width="<?php echo $wid6 ?>"><?php echo($row['dt_bolla']) ?></td>
      </tr>
      <?php
      $colore = 1;
    }
    $i = $i + 1;
  }
  ?>
</table>