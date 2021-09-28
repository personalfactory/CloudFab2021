<table class="table3">
    <tr>
        <th colspan="7"><?php echo $titoloValSM?></th>
    </tr>
    <?php
    include('../include/funzioni.php');
//    formRicerca("cerca_val_sm.php");
 
    //########### VARIABILI UTILE ALLA SCELTA ORDINAMENTO ######################
    $IdParametro = "id_par_sm";
    $IdValore = "id_val_par_sm";
    $NomeParametro = "nome_variabile";
    $DescriStab = "descri_stab";
    $ValoreVariabile = "valore_variabile";
    $Data = "dt_abilitato";
    //#########################################################################
     
    ?>
   
    <tr>
        <th class="cella3">
            <a href="<?php echo $_SERVER['PHP_SELF']?>?NomeCampo=<?php echo $IdValore ?>"><?php echo $filtroIdValore?></a></th>
        <th class="cella3">
            <a href="<?php echo $_SERVER['PHP_SELF']?>?NomeCampo=<?php echo $IdParametro ?>"><?php echo $filtroId?></a></th>
        <th class="cella3">
            <a href="<?php echo $_SERVER['PHP_SELF']?>?NomeCampo=<?php echo $NomeParametro ?>"><?php echo $filtroPar ?></a></th>
        <th class="cella3">
            <a href="<?php echo $_SERVER['PHP_SELF']?>?NomeCampo=<?php echo $DescriStab ?>"><?php echo $filtroStabilimento ?></a></th>
        <th class="cella3">
            <a href="<?php echo $_SERVER['PHP_SELF']?>?NomeCampo=<?php echo $ValoreVariabile ?>"><?php echo $filtroValore?></a></th>
        <th class="cella3">
            <a href="<?php echo $_SERVER['PHP_SELF']?>?NomeCampo=<?php echo $Data ?>"><?php echo $filtroDt?></a></th>
        <th class="cella3">Operazioni</th>

    </tr>
    <?php
    $i = 1;
    $colore = 1;
    while ($row = mysql_fetch_array($sql)) {
        if ($colore == 1) {
            ?>
            <tr>
                <td class="cella1"><?php echo($row['id_val_par_sm']) ?></td>
                <td class="cella1"><?php echo($row['id_par_sm']) ?></td>
                <td class="cella1" title="<?php echo($row['descri_variabile']) ?>"><?php echo($row['nome_variabile']) ?></td>
                <td class="cella1">
                    <a href="modifica_valore_par_mac.php?IdMacchina=<?php echo($row['id_macchina']) ?>"><?php echo($row['descri_stab']) ?></a></td>
                <td class="cella1"><?php echo($row['valore_variabile']) ?></td>
                <td class="cella1"><?php echo($row['dt_abilitato']) ?></td>
                <td class="cella1"style="width:90px">
                    <a href="modifica_valore_par_sm.php?IdParametro=<?php echo($row['id_par_sm']) ?>">
                        <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone"  title="<?php echo $titleModifica?>"/>
                    </a>
                </td>
            </tr>
            <?php
            $colore = 2;
        } else {
            ?>
            <tr>

                <td class="cella2"><?php echo($row['id_val_par_sm']) ?></td>
                <td class="cella2"><?php echo($row['id_par_sm']) ?></td>
                <td class="cella2" title="<?php echo($row['descri_variabile']) ?>"><?php echo($row['nome_variabile']) ?></td>
                <td class="cella2">
                    <a href="modifica_valore_par_mac.php?IdMacchina=<?php echo($row['id_macchina']) ?>"><?php echo($row['descri_stab']) ?></a></td>
                </td>
                <td class="cella2"><?php echo($row['valore_variabile']) ?></td>
                <td class="cella2"><?php echo($row['dt_abilitato']) ?></td>
                <td class="cella2"style="width:90px">
                    <a href="modifica_valore_par_sm.php?IdParametro=<?php echo($row['id_par_sm']) ?>">
                        <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica?>"/>
                    </a>

                </td>
            </tr>
            <?php
            $colore = 1;
        }
        $i = $i + 1;
    }
    ?>
</table>