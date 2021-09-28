<table class="table3">
    <tr>
        <th colspan="1"><?php echo $titoloPaginaCodiciMovimento ?></th>
    <tr>
        <td  colspan="7" style="text-align:center;"> 
        <p><a href="aggiorna_movmagazzino.php"><?php echo $filtroAggMovMag ?></a></p>
            <p>&nbsp;</p>
        </td>
    </tr>
</tr>
<?php
include('../include/funzioni.php');
formRicerca("cerca_movimenti.php");
?>
<tr>
    <td class="cella3"><?php echo $filtroCodMov ?></td>
    <td class="cella3"><?php echo $filtroIdMov ?></td>
    <td class="cella3"><?php echo $filtroDataDoc ?></td>
    <td class="cella3"><?php echo $filtroMateriaPrima ?></td>            
    <td class="cella3"><?php echo $filtroStato ?></td>
    <td class="cella3"><?php echo $filtroDt ?></td>
    <td class="cella3"><?php echo $filtroOperazioni ?></td>
</tr>
<?php
$i = 1;
$colore = 1;

while ($row = mysql_fetch_array($sql)) {
    $DescriMat = "";
    $CodiceMovimento = $row['cod_mov'];
    list($CodMat, $IdMov, $Dt) = explode('.', $CodiceMovimento);
    
    $Data=  inserisciTrattini($Dt);
    $sqlMat = findMatPrimaByCodice($CodMat);
    while ($rowMat = mysql_fetch_array($sqlMat)) {
        $DescriMat = $rowMat['descri_mat'];
    }

    if ($colore == 1) {
        ?>
        <tr>
            <td class="cella1">
                <a href="modifica_gaz_movmag.php?IdMov=<?php echo $IdMov ?>"><?php echo $row['cod_mov'] ?></a></td>
            <td class="cella1"><?php echo $IdMov ?></td>
            <td class="cella1"><?php echo $Data ?></td>
            <td class="cella1"><?php echo $DescriMat ?></td>
            <td class="cella1"><?php echo $row['stato'] ?></td>
            <td class="cella1"><?php echo $row['dt_inser'] ?></td>
            <td class="cella1"style="width:90px">
                <a href="genera_cod_mov.php?IdMov=<?php echo $IdMov ?>&CodMat=<?php echo $CodMat ?>&DtDoc=<?php echo $Data ?>&NomeMat=<?php echo $DescriMat ?>">
                    <img src="/CloudFab/images/pittogrammi/stampa_G.png" class="icone"  title="<?php echo $titleGeneraCodiceMov ?>"/></a>
            </td>
        </tr>
        <?php
        $colore = 2;
    } else {
        ?>
        <tr>
            <td class="cella2">
                <a href="modifica_gaz_movmag.php?IdMov=<?php echo $IdMov ?>"><?php echo $row['cod_mov'] ?></a></td>
            <td class="cella2"><?php echo $IdMov ?></td>
            <td class="cella2"><?php echo $Data ?></td>
            <td class="cella2"><?php echo $DescriMat ?></td>
            <td class="cella2"><?php echo $row['stato'] ?></td>
            <td class="cella2"><?php echo $row['dt_inser'] ?></td>
            <td class="cella2"style="width:90px">    
                <a href="genera_cod_mov.php?IdMov=<?php echo $IdMov ?>&CodMat=<?php echo $CodMat ?>&DtDoc=<?php echo $Data ?>&NomeMat=<?php echo $DescriMat ?>">
                    <img src="/CloudFab/images/pittogrammi/stampa_G.png" class="icone"  title="<?php echo $titleGeneraCodiceMov ?>"/></a>
            </td>
        </tr>
        <?php
        $colore = 1;
    }
    $i = $i + 1;
}
?>
</table>