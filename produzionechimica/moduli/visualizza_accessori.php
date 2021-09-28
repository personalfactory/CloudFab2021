<div id="container" style="margin:15px auto; width:80%">
    <table class="table3">
        <tr>
            <th colspan="6"><?php echo $titoloPaginaAccessori ?></th>
        </tr>
        <tr>
            <td colspan="6" style="text-align:center;"> 
                <a id="22" href="carica_accessorio.php"><?php echo $nuovoAccessorio ?></a>
                 <p>&nbsp;</p>
            </td>
        </tr>
       	<tr>
            <th class="cella3"><?php echo $filtroCodice ?></th>
            <th class="cella3"><?php echo $filtroDescrizione ?></th>
            <th class="cella3"><?php echo $filtroUniMisura ?></th>
            <th class="cella3"><?php echo $filtroPrezzoAcq ?></th>
            <th class="cella3"><?php echo $filtroDt ?></th>
            <th class="cella3"><?php echo $filtroOperazioni ?></th>
        </tr>
        <?php
        $colore = 1;
        while ($row = mysql_fetch_array($sql)) {
            if ($colore == 1) {
                ?>
                <tr>
                    <td class="cella11"><?php echo($row['codice']) ?></td>
                    <td class="cella11"><?php echo($row['descri']) ?></td>
                    <td class="cella11"><?php echo($row['uni_mis']) ?></td>
                    <td class="cella11"><?php echo($row['pre_acq']) ?></td>
                    <td class="cella11"><?php echo($row['dt_abilitato']) ?></td>
                    <td class="cella11" style="width:40px">
                        <a name="Modifica" href="modifica_accessorio.php?Codice=<?php echo($row['codice']) ?>">
                            <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="<?php echo $titleModifica ?>" title="<?php echo $titleModifica ?>"/>
                        </a>
                    </td>
                </tr>
                <?php
                $colore = 2;
            } else {
                ?>
                <tr>
                    <td class="cella4"><?php echo($row['codice']) ?></td>
                    <td class="cella4"><?php echo($row['descri']) ?></td>
                    <td class="cella4"><?php echo($row['uni_mis']) ?></td>
                    <td class="cella4"><?php echo($row['pre_acq']) ?></td>
                    <td class="cella4"><?php echo($row['dt_abilitato']) ?></td>
                    <td class="cella4" style="width:40px">
                        <a name="Modifica" href="modifica_accessorio.php?Codice=<?php echo($row['codice']) ?>">
                            <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="<?php echo $titleModifica ?>" title="<?php echo $titleModifica ?>"/>
                        </a>
                    </td>
                </tr>
                <?php
                $colore = 1;
            }
        }
        ?>
    </table>
</div>