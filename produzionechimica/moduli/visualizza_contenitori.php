<div style="margin:15px auto; width:90%">
<table class="table3" >
    <tr>
        <th colspan="10"><?php echo $titoloPaginaContenitori ?></th>
    </tr>
    <tr>       
        <td class="cella3"><?php echo $filtroContenitore ?></td>
        <td class="cella3"><?php echo $filtroStato ?></td>
        <td class="cella3"><?php echo $filtroCodProdotto ?></td>
        <td class="cella3"><?php echo $filtroProdotto ?></td>
        <td class="cella3"><?php echo $filtroMiscela ?></td>
        <td class="cella3"><?php echo $filtroPesoReale ?></td>
        <td class="cella3"><?php echo $filtroDtProd ?></td>        
        <td class="cella3"><?php echo $filtroOperazioni ?></td>
    </tr>

    <?php
    while ($row = mysql_fetch_array($sql)) {
             
            ?>
            <tr>               
                <td class="cella2"><?php echo($row['contenitore']) ?></td>
                <td class="cella2"><?php echo($row['stato']) ?></td>
                <td class="cella2"><?php echo($row['cod_formula']) ?></td>
                <td class="cella2"><?php echo($row['descri_formula']) ?></td>
                <td class="cella2"><?php echo($row['id_miscela']) ?></td>                
                <td class="cella2"><?php echo $row['peso_reale']." ".$filtrogBreve?></td>
                <td class="cella2"><?php echo($row['dt_miscela']) ?></td>
                <td class="cella2">
                    <?php if($row['stato']==0){ ?>
                    <a href="sblocca_contenitore.php?Contenitore=<?php echo $row['contenitore'] ?>&IdMiscela=<?php echo $row['id_miscela']?>&RefBack=gestione_contenitore.php">
            <img src="/CloudFab/images/pittogrammi/lucchetto_R.png" class="icone" alt="Sblocca" title="<?php echo $titleSbloccaCont ?>"/></a>
                    <?php } ?>
                </td>
            </tr>
            <?php           
    }
    ?>
</table>
</div>