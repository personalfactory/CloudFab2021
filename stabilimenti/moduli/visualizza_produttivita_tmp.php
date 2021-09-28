

<!--################## MOTORE DI RICERCA ###################################-->
<form  name="VediProcesso" id="VediProcesso" action="" method="POST">
    <table class="table3">
        <tr>
            <td><input type="text" name="DescriStab" value="<?php echo $_SESSION['DescriStab'] ?>" onChange="document.forms['VediProcesso'].submit();"/></td>
            <td><input type="text" name="IdProcesso" value="<?php echo $_SESSION['IdProcesso'] ?>" onChange="document.forms['VediProcesso'].submit();"/></td>
            <td><input type="text" name="CodProdotto" value="<?php echo $_SESSION['CodProdotto'] ?>" onChange="document.forms['VediProcesso'].submit();"/></td>
            <td><input type="text" name="NomeProdotto" value="<?php echo $_SESSION['NomeProdotto'] ?>" onChange="document.forms['VediProcesso'].submit();"/></td>
            <td><input type="text" name="CodChimica" value="<?php echo $_SESSION['CodChimica'] ?>" onChange="document.forms['VediProcesso'].submit();"/></td>
            <td><input type="text" name="CodSacco" value="<?php echo $_SESSION['CodSacco'] ?>" onChange="document.forms['VediProcesso'].submit();"/></td>
            <td><input type="text" name="prec" value="<?php echo $_SESSION['prec'] ?>" onChange="document.forms['VediProcesso'].submit();"/></td>
            <td><input type="text" name="att" value="<?php echo $_SESSION['att'] ?>" onChange="document.forms['VediProcesso'].submit();"/></td>
            <td><input type="text" name="Nominativo" value="<?php echo $_SESSION['Nominativo'] ?>" onChange="document.forms['VediProcesso'].submit();" /></td>
            <td><input type="button" value="<?php echo $valueButtonCerca ?>" onClick="document.forms['VediProcesso'].submit();"/></td>
        </tr>



        <!--################## ORDINAMENTO ########################################-->
        <tr>
            <td class="cella3"><div id="OrdinaDescriStab"><?php echo $filtroStabilimento; ?>
                    <button name="Filtro" type="submit" value="descri_stab" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3"><div id="OrdinaIdProc"><?php echo $filtroIdProcesso; ?>
                    <button name="Filtro" type="submit" value="id_processo" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>

            <td class="cella3"><div id="OrdinaCodProd"><?php echo $filtroCodice; ?>
                    <button name="Filtro" type="submit" value="cod_prodotto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3"><div id="OrdinaNomeProd"><?php echo $filtroProdotto; ?>
                    <button name="Filtro" type="submit" value="nome_prodotto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3"><div id="OrdinaKit"><?php echo $filtroKitChim; ?>
                    <button name="Filtro" type="submit" value="cod_chimica" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3"><div id="OrdinaCodSacco"><?php echo $filtroSacco; ?>
                    <button name="Filtro" type="submit" value="cod_sacco" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3"><div id="OrdinaDtPrec"><?php echo $filtroDtProdPrec; ?>
                    <button name="Filtro" type="submit" value="prec" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3"><div id="OrdinaDtProd"><?php echo $filtroDtProd; ?>
                    <button name="Filtro" type="submit" value="att" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3"><div id="OrdinaOper"><?php echo $filtroOperatore; ?>
                    <button name="Filtro" type="submit" value="operatore" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>

        </tr>
        <?php
        $i = 1;
        $colore = 1;
        while ($row = mysql_fetch_array($sql)) {
            if ($colore == 1) {
                ?>
                <tr>
                    <td class="cella1"><?php echo($row['descri_stab']) ?></td>
                    <td class="cella1"><?php echo($row['id_processo']) ?></td>
                    <td class="cella1"><?php echo($row['cod_prodotto']) ?></td>
                    <td class="cella1"><a href="/CloudFab/prodotti/vista_prodotto_formula.php?Prodotto=<?php echo $row['id_prodotto'] ?>">
                        <?php echo($row['nome_prodotto']) ?></a></td>
                    <td class="cella1"><a href="/CloudFab/produzionechimica/dettaglio_chimica.php?Chimica=<?php echo $row['cod_chimica'] ?>">
                        <?php echo($row['cod_chimica']) ?></a></td>
                    <td class="cella1"><a href="/CloudFab/produzionechimica/dettaglio_sacchetto.php?Sacco=<?php echo($row['cod_sacco']) ?>"><?php echo($row['cod_sacco']) ?></a></td>
                    <td class="cella1"><?php echo($row['prec']) ?></td>
                    <td class="cella1"><?php echo($row['att']) ?></td>
                    <td class="cella1"><?php echo($row['nominativo']) ?></td> 
                </tr>
                <?php
                $colore = 2;
            } else {
                ?>
                <tr>
                    <td class="cella2"><?php echo($row['descri_stab']) ?></td>
                    <td class="cella2"><?php echo($row['id_processo']) ?></td>
                    <td class="cella2"><?php echo($row['cod_prodotto']) ?></td>
                    <td class="cella2"><a href="/CloudFab/prodotti/vista_prodotto_formula.php?Prodotto=<?php echo $row['id_prodotto'] ?>">
                        <?php echo($row['nome_prodotto']) ?></a></td>
                    <td class="cella2"><a href="/CloudFab/produzionechimica/dettaglio_chimica.php?Chimica=<?php echo $row['cod_chimica'] ?>">
                        <?php echo($row['cod_chimica']) ?></a></td>
                    <td class="cella2"><a href="/CloudFab/produzionechimica/dettaglio_sacchetto.php?Sacco=<?php echo($row['cod_sacco']) ?>"><?php echo($row['cod_sacco']) ?></a></td>
                    <td class="cella2"><?php echo($row['prec']) ?></td>
                    <td class="cella2"><?php echo($row['att']) ?></td>
                    <td class="cella2"><?php echo($row['nominativo']) ?></td> 
                </tr>
                <?php
                $colore = 1;
            }
            $i = $i + 1;
        }
        ?>

    </table>
</form>