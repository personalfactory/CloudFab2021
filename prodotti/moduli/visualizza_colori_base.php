<table class="table3">
    <tr>
        <th colspan="8"><?php echo $labelMenuColoriBase?></th>
    </tr>
    <tr>
        <td  colspan="8" style="text-align:center;"> 
            <p><a id="10" href="carica_colore_base.php"><?php echo $linkNuovoColore?></a></p>
            <p>&nbsp;</p>
        </td>
    </tr>
    <tr>
        <th class="cella3"><?php echo $filtroId?></th>
        <th class="cella3"><?php echo $filtroColoreBase?></th>
        <th class="cella3"><?php echo $filtroCodice?></th>
        <th class="cella3"><?php echo $filtroCosto?></th>
        <th class="cella3"><?php echo $filtroTolleranza ." ".$filtroPerc ?></th>        
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
                <td class="cella1"><?php echo($row['id_colore_base']) ?></td>
                <td class="cella1"><?php echo($row['nome_colore_base']) ?></td>
                <td class="cella1"><?php echo($row['cod_colore_base']) ?></td>
                <td class="cella1"><?php echo($row['costo_colore_base']) ?></td>
                <td class="cella1"><?php echo($row['toll_perc']) ?></td>
                <td class="cella1"><?php echo($row['abilitato']) ?></td>
                <td class="cella1"><?php echo($row['dt_abilitato']) ?></td>
                <td class="cella1"style="width:90px">
<!--                    <a href="cancella_colore_base.php?ColoreBase=<?php echo($row['id_colore_base']) ?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="Elimina" title="Clicca per cancellare il colore"/></a> -->
                    <a name='Modifica' href="modifica_colore_base.php?ColoreBase=<?php echo($row['id_colore_base']) ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica?>"/></a>
                </td>
            </tr>
            <?php
            $colore = 2;
        } else {
            ?>
            <tr>
                <td class="cella2"><?php echo($row['id_colore_base']) ?></td>
                <td class="cella2"><?php echo($row['nome_colore_base']) ?></td>
                <td class="cella2"><?php echo($row['cod_colore_base']) ?></td>
                <td class="cella2"><?php echo($row['costo_colore_base']) ?></td>
                <td class="cella2"><?php echo($row['toll_perc']) ?></td>
                <td class="cella2"><?php echo($row['abilitato']) ?></td>
                <td class="cella2"><?php echo($row['dt_abilitato']) ?></td>
                <td class="cella2" style="width:90px">
<!--                    <a href="cancella_colore_base.php?ColoreBase=<?php echo($row['id_colore_base']) ?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="Elimina" title="Clicca per cancellare il colore"/></a> -->
                    <a name='Modifica' href="modifica_colore_base.php?ColoreBase=<?php echo($row['id_colore_base']) ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica?>"/></a>
                </td>
            </tr>
            <?php
            $colore = 1;
        }
        $i = $i + 1;
    }
    ?>
</table>