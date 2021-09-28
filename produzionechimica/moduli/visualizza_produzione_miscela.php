<table class="table3">
    <tr>
        <th colspan="10"><?php echo $titoloPagMisceleDaTracciare ?></th>
    </tr>
    <tr>
        <td class="cella3"><?php echo $filtroIdMiscela ?></td>
        <td class="cella3"><?php echo $filtroCodice ?></td>
        <td class="cella3"><?php echo $filtroContenitore ?></td>
        <td class="cella3"><?php echo $filtroCodMov ?></td>
        <td class="cella3"><?php echo $filtroMateriaPrima ?></td>            
        <td class="cella3"><?php echo $filtroPesoTeorico ?></td>
        <td class="cella3"><?php echo $filtroPesoReale ?></td>
        <td class="cella3"><?php echo $filtroPesoTotale ?></td>
        <td class="cella3"><?php echo $filtroDtProd ?></td>
       
    </tr>

    <?php
    $i = 1;
    $colore = 1;
    while ($row = mysql_fetch_array($sql)) {
        if ($colore == 1) {
            ?>
            <tr>
                <td class="cella1"><?php echo($row['id_miscela']) ?></td>
                <td class="cella1"><?php echo($row['cod_formula']) ?></td>
                <td class="cella1"><?php echo($row['cod_contenitore']) ?></td>
                <td class="cella1"><?php echo($row['cod_mov']) ?></td>
                <td class="cella1"><?php echo($row['descri_mat']) ?></td>
                <td class="cella1"><?php echo($row['peso_mat_teo']) ?></td>
                <td class="cella1"><?php echo($row['peso_mat']) ?></td>
                <td class="cella1"><?php echo($row['peso_tot']) ?></td>
                <td class="cella1"><?php echo($row['dt_miscela']) ?></td>
               

            </tr>
            <?php
            $colore = 2;
        } else {
            ?>
            <tr>
                <td class="cella2"><?php echo($row['id_miscela']) ?></td>
                <td class="cella2"><?php echo($row['cod_formula']) ?></td>
                <td class="cella2"><?php echo($row['cod_contenitore']) ?></td>
                <td class="cella2"><?php echo($row['cod_mov']) ?></td>
                <td class="cella2"><?php echo($row['descri_mat']) ?></td>
                <td class="cella2"><?php echo($row['peso_mat_teo']) ?></td>
                <td class="cella2"><?php echo($row['peso_mat']) ?></td>
                <td class="cella2"><?php echo($row['peso_tot']) ?></td>
                <td class="cella2"><?php echo($row['dt_miscela']) ?></td>
                 
            </tr>
            <?php
            $colore = 1;
        }
        $i = $i + 1;
    }
    ?>
</table>