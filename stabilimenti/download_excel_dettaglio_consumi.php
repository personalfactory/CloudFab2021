<?php
include('../include/gestione_date.php');
$filename = "production_details" . "" . dataCorrenteFileExcel() . ".xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: inline; filename=$filename");

include('../include/validator.php');
include('../Connessioni/serverdb.php');
include('../sql/script_movimento_sing_mac.php');
include('../sql/script_parametro_glob_mac.php');
include('../sql/script_prodotto.php');
include('../sql/script_componente.php');
include('../sql/script_ciclo_processo.php');
include('../sql/script_ciclo.php');
include('../sql/script_processo.php');

include("../lingue/gestore.php");

$IdMacchina = $_GET['IdMacchina'];
$dataInf = $_POST['DataInf'];
$dataSup = $_POST['DataSup'];

$strTipoMovWareHOut = "";
$sqlParGlob = findParGlobMac();
while ($rowParGlob = mysql_fetch_array($sqlParGlob)) {

    switch ($rowParGlob['id_par_gm']) {

        case 119:
            //WAREHOUSE OUT
            $strTipoMovWareHOut = $rowParGlob['valore_variabile'];
            break;

        default:
            break;
    }
}

$sqlElencoProd = findProdottiInCicli($IdMacchina, $dataInf, $dataSup, $strTipoMovWareHOut, "c.id_ciclo", "c.id_ciclo,p.nome_prodotto");
$sqlMatPrime = findMateriePrimeConsumateMacchina($IdMacchina, $dataInf, $dataSup, $strTipoMovWareHOut, "id_materiale", "descri_componente");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang=it>
    <head>

    </head>
    <body>   
        <table>
           
            <tr><td>
                    <div style="float:left;">    
                        <table>
                            <tr> 
                                <td></td>
                                <td></td>
                            </tr>
                            <tr> 
                                <td><b>Date</b></td>
                                <td><b>Heure</b></td>
                                <td><b><?php echo "Produit fini" ?></b></td>
                            </tr>
                            <?php
                            while ($row0 = mysql_fetch_array($sqlElencoProd)) {
                                ?>
                                <tr>
                                    <td><?php echo substr( $row0['dt_abilitato'] , 0 , 10 ); ?></td>
                                    <td><?php echo substr( $row0['dt_abilitato'] , 11 , 19 ); ?></td>
                                    <td><?php echo $row0['id_prodotto'] . " - " . $row0['nome_prodotto'] ?></td>
                                </tr> 
                            <?php } ?>
                        </table> 
                    </div>
                </td>
                <?php
                //Seleziono tutte le materie prime movimentate nell'intervallo di tempo
                $i = 1;
                while ($row1 = mysql_fetch_array($sqlMatPrime)) {
                    ?>
                    <td>
                        <div style="float:right;">  
                            <table>
                                <tr>
                                    <td colspan="4" text-align="center"><b><?php echo "MP" . $i . " - " . $row1['descri_componente'] ?></b></td>                  
                                </tr>
                                <tr>
                                    <td style="bacground-color: #99CCCC"><b><?php echo "Nom" ?></b></td>                  
                                    <td style="bacground-color: #99CCCC"><b><?php echo "Lot" ?></b></td>
                                    <td style="bacground-color: #99CCCC"><b><?php echo "g" ?></b></td>
                                    <td style="bacground-color: #99CCCC"><b><?php echo "%" ?></b></td>
                                </tr>
                                <?php
                                if (mysql_num_rows($sqlElencoProd) > 0)
                                    mysql_data_seek($sqlElencoProd, 0);
                                while ($rowProd = mysql_fetch_array($sqlElencoProd)) {
                                    //Calcolo il totale materie prime di ogni prodotto per calcolare la quantità percentuale di ogni materia prima
                                    $totQtaMat = 0;
                                    $sqlTotMat = findTotMateriePrimeInCiclo($IdMacchina, $rowProd['id_prodotto'], $rowProd['id_ciclo'], $strTipoMovWareHOut);
                                    while ($rowTotMat = mysql_fetch_array($sqlTotMat)) {
                                        $totQtaMat = $totQtaMat + $rowTotMat['quantita'];
                                    }
                                    ?>
                                    <tr> 
                                        <?php
                                        $quantitaConsumata = 0;
                                        $quantitaPerc = 0;
                                        $codIngressoComp = "";
                                        //Cerco il consumo di ogni materia prima nel ciclo
                                        $sqlConsumo = findConsumoMateriaPrimaInCiclo($IdMacchina, $row1['id_materiale'], $rowProd['id_prodotto'], $rowProd['id_ciclo'], $strTipoMovWareHOut);

                                        while ($row2 = mysql_fetch_array($sqlConsumo)) {
                                            $codIngressoComp = $row2['cod_ingresso_comp'];
                                            $quantitaConsumata = $row2['quantita'];
                                            if ($totQtaMat > 0)
                                                $quantitaPerc = ($quantitaConsumata * 100) / $totQtaMat;
                                        }
                                        if ($quantitaConsumata != 0) {
                                            ?>
                                            <td><?php echo $row1['descri_componente'] ?></td>                  
                                            <td style="text-align: right"><?php echo $codIngressoComp ?></td>                                 
                                            <td style="text-align: right"><?php echo $quantitaConsumata ?></td>
                                            <td style="text-align: right"><?php echo number_format($quantitaPerc, "2", ",", ".") ?></td>

                                        <?php } else { ?>
                                            <td></td>                 
                                            <td></td>                                 
                                            <td></td>
                                            <td></td>                                     
                                        <?php }
                                        ?> 
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>  
                        </div>
                    </td>
                    <?php
                    $i++;
                }
                ?>
                <!-- ################################### MISCELA ######################################-->
                <td>
                    <div style="float:left;">    
                        <table>
                            <tr> 
                                <td colspan="4"><b> <?php echo "M&eacute;lange" ?></b></td>
                            </tr>
                            <tr> 
                                <td style="bacground-color: #99CCCC"><b><?php echo "Temps m&eacute;lange" ?></b></td>                  
                                <td style="bacground-color: #99CCCC"><b><?php echo "Vitesse" ?></b></td>
                                <td style="bacground-color: #99CCCC"><b><?php echo "Num&eacute;ro" ?></b></td>
                                <td style="bacground-color: #99CCCC"><b><?php echo "g" ?></b></td>
                            </tr>
                            <?php
                            if (mysql_num_rows($sqlElencoProd))
                                mysql_data_seek($sqlElencoProd, 0);
                            while ($row4 = mysql_fetch_array($sqlElencoProd)) {
                                //Calcolo il totale materie prime di ogni prodotto
                                $totQtaMat = 0;
                                $sqlTotMat = findTotMateriePrimeInCiclo($IdMacchina, $row4['id_prodotto'], $row4['id_ciclo'], $strTipoMovWareHOut);
                                while ($rowTotMat = mysql_fetch_array($sqlTotMat)) {
                                    $totQtaMat = $totQtaMat + $rowTotMat['quantita'];
                                }
                                
                                ?>
                                <tr>
                                    <td><?php echo $row4['tempo_mix'] ?></td>
                                    <td><?php echo $row4['velocita_mix'] ?></td>
                                    <td><?php echo $row4['id_ciclo'] ?></td>
                                    <td><?php echo $totQtaMat ?></td>
                                </tr> 
                            <?php } ?>
                        </table> 
                    </div>
                </td>
                <!-- ################################### SACCHI ######################################-->

                <?php
                $maxNumSacchi = 0;
                //Seleziono il massimo numero di sacchi dalla tabella ciclo
                $sqlNumSacchiMax = findMaxNumSacchiInCiclo($IdMacchina, $dataInf, $dataSup);
                while ($rowSac = mysql_fetch_array($sqlNumSacchiMax)) {
                    $maxNumSacchi = $rowSac['num_sacchi_max'];
                }
                ?>
                <td>
                    <div style="float:right;">  
                        <table>
                            <tr> 
                                <td colspan="<?php echo $maxNumSacchi ?>"><b><?php echo "Conditionnement" ?></b></td>
                            </tr>
                            <tr>
                                <?php for ($j = 1; $j <= $maxNumSacchi; $j++) { ?>
                                <td><b><?php echo "g (n " . $j . ")" ?></b></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php
                                if (mysql_num_rows($sqlElencoProd))
                                    mysql_data_seek($sqlElencoProd, 0);
                                while ($row5 = mysql_fetch_array($sqlElencoProd)) {
                                    $sqlSacchi = findInfoProcessiByIdCiclo($IdMacchina, $row5['id_ciclo'], $row5['id_prodotto']);

                                    //Se non ci sono sacchi associati al ciclo
                                    if (mysql_num_rows($sqlSacchi) == 0) {
                                        for ($j = 1; $j <= $maxNumSacchi; $j++) {
                                            ?>
                                            <td></td>
                                        <?php
                                        }
                                    }
                                    while ($rowSacchi = mysql_fetch_array($sqlSacchi)) {
                                        ?>
                                        <td>
                                            <div style="float:right;">  
                                                <table>
                                                    <tr>
                                                        <td style="bacground-color: #99CCCC"><?php echo $rowSacchi['peso_reale_sacco'] ?></td>
                                                    </tr>
                                                </table>  
                                            </div>
                                        </td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
        <!------------------------------------------------------------------------>
    </body>
</html>
