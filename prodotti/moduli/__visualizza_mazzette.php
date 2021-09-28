<table class="table3">
    <tr>
        <th colspan="6">MAZZETTE</th>
    </tr>
    <tr>
        <td  colspan="6" style="text-align:center;"> 
            <p><a href="carica_mazzetta.php">NUOVA MAZZETTA</a></p>
            <p>&nbsp;</p>
        </td>
    </tr>
    <tr>

        <th class="cella3">ID</th>
        <th class="cella3">MAZZETTA</th>
        <th class="cella3">CODICE</th>
        <th class="cella3">ABILITATO</th>
        <th class="cella3">DATA</th>
        <th class="cella3">Operazioni</th>

    </tr>
    <?php
    $i = 1;
    $colore = 1;
    while ($row = mysql_fetch_array($sql)) {
        if ($colore == 1) {
            ?>
            <tr>
                <td class="cella1"><?php echo($row['id_mazzetta']) ?></td>
                <td class="cella1"><?php echo($row['nome_mazzetta']) ?></td>
                <td class="cella1"><?php echo($row['cod_mazzetta']) ?></td>
                <td class="cella1"><?php echo($row['abilitato']) ?></td>
                <td class="cella1"><?php echo($row['dt_abilitato']) ?></td>
                 <td class="cella1"style="width:90px">
                <!--<a href="cancella_mazzetta.php?Mazzetta=<?php echo($row['id_mazzetta']) ?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="Elimina" title="Clicca per cancellare la mazzetta"/></a> -->
                    <a href="modifica_mazzetta.php?Mazzetta=<?php echo($row['id_mazzetta']) ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="Modifica"title="Clicca per modificare la mazzetta"/></a>
                </td>
            </tr>
            <?php
            $colore = 2;
        } else {
            ?>
            <tr>
                <td class="cella2"><?php echo($row['id_mazzetta']) ?></td>
                <td class="cella2"><?php echo($row['nome_mazzetta']) ?></td>
                <td class="cella2"><?php echo($row['cod_mazzetta']) ?></td>
                <td class="cella2"><?php echo($row['abilitato']) ?></td>
                <td class="cella2"><?php echo($row['dt_abilitato']) ?></td>
                <td class="cella2"style="width:90px">
                    <!--<a href="cancella_mazzetta.php?Mazzetta=<?php echo($row['id_mazzetta']) ?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="Elimina" title="Clicca per cancellare la mazzetta"/></a> -->
                    <a href="modifica_mazzetta.php?Mazzetta=<?php echo($row['id_mazzetta']) ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="Modifica"title="Clicca per modificare la mazzetta"/></a>
                </td>
            </tr>
            <?php
            $colore = 1;
        }
        $i = $i + 1;
    }
    ?>
</table>