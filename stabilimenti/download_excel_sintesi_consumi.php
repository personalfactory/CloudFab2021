<?php
include('../include/gestione_date.php');
$filename = "production_summary_" . "" . dataCorrenteFileExcel() . ".xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: inline; filename=$filename");

include('../include/validator.php');
include('../Connessioni/serverdb.php');
include('../sql/script_movimento_sing_mac.php');
include('../sql/script_parametro_glob_mac.php');
include('../sql/script_prodotto.php');
include('../sql/script_componente.php');
include('../sql/script_ciclo_processo.php');
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

$sqlElencoProd = findProdottiInCicli($IdMacchina, $dataInf, $dataSup, $strTipoMovWareHOut, "id_prodotto", "cod_prodotto");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang=it>
    <head>

    </head>
    <body>   
        <table>
            <th> 
                <b><?php echo "Consommations des MP" ?></b>
            </th>
            <tr><td>
                    <div style="float:left;">    
                        <table>
                            <tr> 
                                <td></td>
                            </tr>
                            <?php
                            //Seleziono tutte le materie prime movimentate per la produzione
                            $sqlMatPrime = findMateriePrimeConsumateMacchina($IdMacchina, $dataInf, $dataSup, $strTipoMovWareHOut, "id_materiale", "descri_componente");
                            while ($row0 = mysql_fetch_array($sqlMatPrime)) {
                                ?>
                                <tr> 
                                    <td><?php echo $row0['id_materiale'] . " - " . $row0['descri_componente'] ?></td>
                                </tr> 
                            <?php } ?>
                        </table> 
                    </div>
                </td>
                <?php
                while ($rowProd = mysql_fetch_array($sqlElencoProd)) {
                    ?>
                    <td>
                        <div style="float:right;">  
                            <table>
                                <tr>
                                    <td><b><?php echo "Produits finis" ?></b></td>                  
                                    <td><b><?php echo "Lot" ?> </b></td>
                                    <td><b><?php echo "quantit&eacute; (g)" ?></b></td>
                                </tr>
                                <?php
                                //Seleziono tutte le materie prime movimentate per la produzione
                                $sqlMatPrime = findMateriePrimeConsumateMacchina($IdMacchina, $dataInf, $dataSup, $strTipoMovWareHOut, "id_materiale", "descri_componente");
                                while ($row0 = mysql_fetch_array($sqlMatPrime)) {
                                    //Per ogni materia prima cerco il consumo
                                    ?>
                                    <tr> 
                                        <?php
                                        $sqlConsumo = findConsumoMateriePrime($IdMacchina, $rowProd['id_prodotto'], $row0['id_materiale'], $dataInf, $dataSup, $strTipoMovWareHOut);
                                        while ($row2 = mysql_fetch_array($sqlConsumo)) {
                                            $quantitaConsumata = 0;
                                            if ($row2['quantitaTot'] > 0)
                                                $quantitaConsumata = $row2['quantitaTot'];
                                            ?>
                                            <td style="text-align: center"><?php echo $rowProd['nome_prodotto'] ?></td>
                                            <td style="text-align: right"><?php echo $row2['cod_ingresso_comp'] ?></td>
                                            <td style="text-align: right"><?php echo number_format($quantitaConsumata, "3", ",", "") ?></td>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>  
                        </div>
                    </td>
                <?php } ?>
            </tr>
        </table>
        <table>
            <th> 
                <b><?php echo "Productions Origami" ?></b>
            </th>
            <tr><td>
                    <div style="float:left;">    
                        <table>
                            <tr> 
                                <td></td>
                            </tr>
                            <?php
                            //Seleziono tutti prodotti
                            if (mysql_num_rows($sqlElencoProd) > 0)
                                mysql_data_seek($sqlElencoProd, "0");
                            while ($row3 = mysql_fetch_array($sqlElencoProd)) {
                                ?>
                                <tr> 
                                    <td><?php echo $row3['nome_prodotto'] ?></td>
                                </tr>

                            <?php } ?>
                        </table> 
                    </div>
                </td>
                <td>
                    <div style="float:right;">  
                        <table>
                            <tr>
                                <td><b><?php echo "packaging type"?></b></td>           
                                <td><b><?php echo "quantit&eacute;"?></b></td>
                                <td><b><?php echo "packaging type"?></b></td>           
                                <td><b><?php echo "quantit&eacute;"?></b></td>
                            </tr>
                            <?php
                            if (mysql_num_rows($sqlElencoProd) > 0)
                                mysql_data_seek($sqlElencoProd, "0");
                            while ($rowProd = mysql_fetch_array($sqlElencoProd)) {                          

                                //Caso 1 : produzione con un ordine interno di riferimento 
                                // è possibile distinguere fra secchi e sacchi                                
                                $sqlSacchiConsumo = findTotSacchiINProcesso($IdMacchina, $rowProd['id_prodotto'], $dataInf, $dataSup, "4", "false");
                                $numSacchi = 0;
                                $numSacchi = mysql_num_rows($sqlSacchiConsumo);

                                $sqlSecchiConsumo = findTotSacchiINProcesso($IdMacchina, $rowProd['id_prodotto'], $dataInf, $dataSup, "4", "true");
                                $numSecchi = 0;
                                $numSecchi = mysql_num_rows($sqlSecchiConsumo);
                                
                                //Caso 2 : produzione senza un ordine di riferimento
                                // in questo caso non è possibile distinguere fra secchi e sacchi
                                if($numSacchi==0 AND $numSecchi==0){
                                    
                                    $sqlProcessi=findTotProcessiSenzaOrdine($IdMacchina,$rowProd['id_prodotto'], $dataInf, $dataSup);
                                    $numSacchi=mysql_num_rows($sqlProcessi);
                                    
                                }
                                
                                ?>
                                <tr> 
                                    <td style="text-align: right"><?php echo $filtroTipoConfSacco ?></td>
                                    <td style="text-align: right"><?php echo $numSacchi ?></td>
                                    <td style="text-align: right"><?php echo $filtroTipoConfSecchio ?></td>
                                    <td style="text-align: right"><?php echo $numSecchi ?></td>
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
