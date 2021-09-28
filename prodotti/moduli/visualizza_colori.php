<table class="table3">
    <tr>
        <th colspan="6"><?php echo $labelMenuColoriProd?></th>
    </tr>
    <tr>
        <td  colspan="6" style="text-align:center;"> 
            <p><a id="12" href="carica_colore.php"><?php echo $titoloNewColor?></a></p>
            <p>&nbsp;</p>
        </td>
    </tr>
    <tr>
        <th class="cella3"><?php echo $filtroId?> </th>
        <th class="cella3"><?php echo $filtroColore?></th>
        <th class="cella3"><?php echo $filtroCodice?></th>
        <th class="cella3"><?php echo $filtroAbilitato?></th>
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
                <td class="cella1"><?php echo($row['id_colore']) ?></td>
                <td class="cella1"><?php echo($row['nome_colore']) ?></td>
                <td class="cella1"><?php echo($row['cod_colore']) ?></td>
                <td class="cella1"><?php echo($row['abilitato']) ?></td>
                <td class="cella1"><?php echo($row['dt_abilitato']) ?></td>
                <td class="cella1"style="width:90px">
<!--                    <a href="cancella_colore.php?Colore=<?php echo($row['id_colore']) ?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="Elimina" title="Clicca per cancellare il colore"/></a> -->
                    <a name='Modifica' href="modifica_colore.php?Colore=<?php echo($row['id_colore']) ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica?>"/></a>
                </td>
            </tr>
            <?php
            $colore = 2;
        } else {
            ?>
            <tr>
                <td class="cella2"><?php echo($row['id_colore']) ?></td>
                <td class="cella2"><?php echo($row['nome_colore']) ?></td>
                <td class="cella2"><?php echo($row['cod_colore']) ?></td>
                <td class="cella2"><?php echo($row['abilitato']) ?></td>
                <td class="cella2"><?php echo($row['dt_abilitato']) ?></td>
                <td class="cella2" style="width:90px">
<!--                    <a href="cancella_colore.php?Colore=<?php echo($row['id_colore']) ?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="Elimina" title="Clicca per cancellare il colore"/></a> -->
                    <a name='Modifica' href="modifica_colore.php?Colore=<?php echo($row['id_colore']) ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica?>"/></a>
                </td>
            </tr>
            <?php
            $colore = 1;
        }
        $i = $i + 1;
    }
    ?>
</table>