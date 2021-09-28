 <?php
//Larghezza colonne 
$wid1 = "15%"; // +10px padding (l+r)
$wid2 = "5%"; // +10px padding (l+r)
$wid3 = "10%"; // +10px padding (l+r)
$wid4 = "20%"; // +10px padding (l+r)
$wid5 = "12%"; // +10px padding (l+r)
$wid6 = "12%"; // +10px padding (l+r)
$wid7 = "13%"; // +10px padding (l+r)
$wid8 = "10%"; // +10px padding (l+r)
//TOTALE 1170px
?>
<!--################## MOTORE DI RICERCA ###################################-->
<form  name="VediProcesso" id="VediProcesso" action="" method="POST">
    <table class="table3">
        <tr>
            <td><input style="width:100%" type="text" name="DescriStab" value="<?php echo $_SESSION['DescriStab'] ?>" onChange="document.forms['VediProcesso'].submit();"/></td>
            <td><input style="width:100%" type="text" name="IdProcesso" value="<?php echo $_SESSION['IdProcesso'] ?>" onChange="document.forms['VediProcesso'].submit();"/></td>
            <td><input style="width:100%" type="text" name="CodProdotto" value="<?php echo $_SESSION['CodProdotto'] ?>" onChange="document.forms['VediProcesso'].submit();"/></td>
            <td><input style="width:100%" type="text" name="NomeProdotto" value="<?php echo $_SESSION['NomeProdotto'] ?>" onChange="document.forms['VediProcesso'].submit();"/></td>
            <td><input style="width:100%" type="text" name="CodChimica" value="<?php echo $_SESSION['CodChimica'] ?>" onChange="document.forms['VediProcesso'].submit();"/></td>
            <td><input style="width:100%" type="text" name="CodSacco" value="<?php echo $_SESSION['CodSacco'] ?>" onChange="document.forms['VediProcesso'].submit();"/></td>
            <td><input style="width:100%" type="text" name="DataProd" value="<?php echo $_SESSION['DataProd'] ?>" onChange="document.forms['VediProcesso'].submit();"/></td>
            <td><input style="width:100%" type="text" name="Nominativo" value="<?php echo $_SESSION['Nominativo'] ?>" onChange="document.forms['VediProcesso'].submit();" /></td>
             <td><img src="/CloudFab/images/icone/lente_piccola.png" title="<?php echo $titleRicerca ?>" onClick="document.forms['VediProcesso'].submit();"/></td>
        </tr>
        <!--################## ORDINAMENTO ########################################-->
        <tr>
            <td class="cella3" style="width:<?php echo $wid1 ?>"><div id="OrdinaDescriStab"><?php echo $filtroStabilimento; ?>
                    <button name="Filtro" type="submit" value="descri_stab" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" style="width:<?php echo $wid2 ?>"><div id="OrdinaIdProc"><?php echo $filtroIdProcesso; ?>
                    <button name="Filtro" type="submit" value="id_processo" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>

            <td class="cella3" style="width:<?php echo $wid3 ?>"><div id="OrdinaCodProd"><?php echo $filtroCodice; ?>
                    <button name="Filtro" type="submit" value="cod_prodotto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" style="width:<?php echo $wid4 ?>"><div id="OrdinaNomeProd"><?php echo $filtroProdotto; ?>
                    <button name="Filtro" type="submit" value="nome_prodotto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" style="width:<?php echo $wid5 ?>"><div id="OrdinaKit"><?php echo $filtroKitChim; ?>
                    <button name="Filtro" type="submit" value="cod_chimica" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" style="width:<?php echo $wid6 ?>"><div id="OrdinaCodSacco"><?php echo $filtroSacco; ?>
                    <button name="Filtro" type="submit" value="cod_sacco" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" style="width:<?php echo $wid7 ?>"><div id="OrdinaDtPrec"><?php echo $filtroDtProd; ?>
                    <button name="Filtro" type="submit" value="dt_produzione_mac" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" style="width:<?php echo $wid8 ?>"><div id="OrdinaOper"><?php echo $filtroOperatore; ?>
                    <button name="Filtro" type="submit" value="operatore" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
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
                    <td class="cella1" style="width:<?php echo $wid1 ?>"><?php echo($row['descri_stab']) ?></td>
                    <td class="cella1" style="width:<?php echo $wid2 ?>"><?php echo($row['id_processo']) ?></td>
                    <td class="cella1" style="width:<?php echo $wid3 ?>"><?php echo($row['cod_prodotto']) ?></td>
                    <td class="cella1" style="width:<?php echo $wid4 ?>"><?php echo($row['nome_prodotto']) ?></td>
                    <td class="cella1" style="width:<?php echo $wid5 ?>"><a href="/CloudFab/produzionechimica/dettaglio_chimica.php?Chimica=<?php echo $row['cod_chimica'] ?>">
                        <?php echo($row['cod_chimica']) ?></a></td>
                    <td class="cella1" style="width:<?php echo $wid6 ?>"><a href="/CloudFab/produzionechimica/dettaglio_sacchetto.php?IdProcesso=<?php echo($row['id_processo']) ?>&IdMacchina=<?php echo($row['id_macchina']) ?>"><?php echo($row['cod_sacco']) ?></a></td>
                    <td class="cella1" style="width:<?php echo $wid7 ?>"><?php echo($row['dt_produzione_mac']) ?></td>
                    <td class="cella1" style="width:<?php echo $wid8 ?>"><?php echo($row['nominativo']) ?></td> 
                </tr>
                <?php
                $colore = 2;
            } else {
                ?>
                <tr>
                    <td class="cella2" style="width:<?php echo $wid1 ?>"><?php echo($row['descri_stab']) ?></td>
                    <td class="cella2" style="width:<?php echo $wid2 ?>"><?php echo($row['id_processo']) ?></td>
                    <td class="cella2" style="width:<?php echo $wid3 ?>"><?php echo($row['cod_prodotto']) ?></td>
                    <td class="cella2" style="width:<?php echo $wid4 ?>"><?php echo($row['nome_prodotto']) ?></td>
                    <td class="cella2" style="width:<?php echo $wid5 ?>"><a href="/CloudFab/produzionechimica/dettaglio_chimica.php?Chimica=<?php echo $row['cod_chimica'] ?>">
                        <?php echo($row['cod_chimica']) ?></a></td>
                    <td class="cella2" style="width:<?php echo $wid6 ?>"><a href="/CloudFab/produzionechimica/dettaglio_sacchetto.php?IdProcesso=<?php echo($row['id_processo']) ?>&IdMacchina=<?php echo($row['id_macchina']) ?>"><?php echo($row['cod_sacco']) ?></a></td>
                    <td class="cella2" style="width:<?php echo $wid7 ?>"><?php echo($row['dt_produzione_mac']) ?></td>
                    <td class="cella2" style="width:<?php echo $wid8 ?>"><?php echo($row['nominativo']) ?></td> 
                </tr>
                <?php
                $colore = 1;
            }
            $i = $i + 1;
        }
        ?>

    </table>
</form>
