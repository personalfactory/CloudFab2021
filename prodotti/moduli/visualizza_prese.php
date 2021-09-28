<table class="table3">
    <tr>
        <th colspan="5"><?php echo $titoloPaginaPresa ?></th>
    </tr>
    <tr>
        <td  colspan="5" style="text-align:center;"> 
            <p><a href="carica_presa.php"><?php echo $linkPaginaPresa ?></a></p>
            <p>&nbsp;</p>
        </td>
    </tr>
    <tr>
        <th class="cella3"><?php echo $filtroId ?></th>
        <th class="cella3"><?php echo $filtroPresa ?></th>
        <th class="cella3"><?php echo $filtroAbilitato?></th>
        <th class="cella3"><?php echo $filtroDt ?></th>
        <th class="cella3"><?php echo $filtroOperazioni ?></th>
    </tr>
    <?php
    $i = 1;
    $colore = 1;
    while ($row = mysql_fetch_array($sql)) {
        if ($colore == 1) {
            ?>
            <tr>
                <td class="cella1"><?php echo($row['id_presa']) ?></td>
                <td class="cella1"><?php echo($row['presa']) ?></td>
                <td class="cella1"><?php echo($row['abilitato']) ?></td>
                <td class="cella1"><?php echo($row['dt_abilitato']) ?></td>
                <td class="cella1"style="width:90px">
                    <!--<a href="cancella_presa.php?Presa=<?php echo($row['id_presa']) ?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="Elimina" title="Clicca per cancellare la presa"/></a>--> 
                    <a href="modifica_presa.php?Presa=<?php echo($row['id_presa']) ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica?>"/></a>
                </td>
            </tr>
            <?php
            $colore = 2;
        } else {
            ?>
            <tr>
                <td class="cella2"><?php echo($row['id_presa']) ?></td>
                <td class="cella2"><?php echo($row['presa']) ?></td>
                <td class="cella2"><?php echo($row['abilitato']) ?></td>
                <td class="cella2"><?php echo($row['dt_abilitato']) ?></td>
                <td class="cella2" style="width:90px">
                    <!--<a href="cancella_presa.php?Presa=<?php echo($row['id_presa']) ?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="Elimina" title="Clicca per cancellare la presa"/></a> -->

                    <a href="modifica_presa.php?Presa=<?php echo($row['id_presa']) ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica?>"/></a>
                </td>
            </tr>
            <?php
            $colore = 1;
        }
        $i = $i + 1;
    }
    ?>
</table>