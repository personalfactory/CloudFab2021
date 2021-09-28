<table class="table3">

    <tr>
        <th colspan="5"><?php echo $titoloMazzetteColori?></th>
    </tr>

    <tr>
        <td  colspan="5" style="text-align:center;"> 
            <p><a name="15" href="carica_mazzetta.php"><?php echo $linkNuovaMazzetta?></a></p>
            <p>&nbsp;</p>
        </td>
    </tr>
    <tr>
        <td  colspan="5" style="text-align:center;"> 
            <p><a name="15" href="associa_mazzetta_colore.php"><?php echo $linkDefinisciColori?></a></p>
            <p>&nbsp;</p>
        </td>
    </tr>
    <tr>
        <th class="cella3">N</th>
        <th class="cella3"><?php echo $filtroCodice?></th>
        <th class="cella3"><?php echo $filtroMazzetta ?></th>
        <th class="cella3"><?php echo $filtroDt?></th>
        <th class="cella3"><?php echo $filtroOperazioni?></th>

    </tr>
    <?php
    $i = 1;
    $colore = 1;
    while ($row = mysql_fetch_array($sql)) {
        if ($colore == 1) {
            ?>
            <tr>
                <td class="cella1"><?php echo($i) ?></td>
                <td class="cella1" ><?php echo($row['cod_mazzetta']) ?></td>
                <td class="cella1"><?php echo($row['nome_mazzetta']) ?></td>
                <td class="cella1"><?php echo($row['dt_abilitato']) ?></td>
                <td class="cella1"style="width:90px">
                    <a name="14" href="modifica_mazzetta.php?Mazzetta=<?php echo($row['id_mazzetta']) ?>">
                         <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModificaNomeMaz?>"/></a>
                    <a name="14" href="modifica_mazzetta_colorata.php?IdMazzetta=<?php echo($row['id_mazzetta']) ?>&&NomeMazzetta=<?php echo($row['nome_mazzetta']) ?>">
                        <img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone" title="<?php echo $titleModificaComposizione?>"/></a>
                </td>
            </tr>
            <?php
            $colore = 2;
        } else {
            ?>
            <tr>
                <td class="cella2"><?php echo($i) ?></td>
                <td class="cella2"><?php echo($row['cod_mazzetta']) ?></td>
                <td class="cella2"><?php echo($row['nome_mazzetta']) ?></td>
                <td class="cella2"><?php echo($row['dt_abilitato']) ?></td>
                <td class="cella2"style="width:90px">
                    <a name="14" href="modifica_mazzetta.php?Mazzetta=<?php echo($row['id_mazzetta']) ?>">
                        <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModificaNomeMaz ?>"/></a>
                    <a name="14" href="modifica_mazzetta_colorata.php?IdMazzetta=<?php echo($row['id_mazzetta']) ?>&&NomeMazzetta=<?php echo($row['nome_mazzetta']) ?>">
                        <img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone" title="<?php echo $titleModificaComposizione ?>"/></a>
                </td>
            </tr>
            <?php
            $colore = 1;
        }
        $i = $i + 1;
    }
    ?>
</table>