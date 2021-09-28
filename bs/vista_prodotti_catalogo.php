<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php
        include('../include/header.php');
        ?>
    </head>
    <?php
    if ($DEBUG)
        ini_set('display_errors', 1);
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">

        <div id="mainContainer" >
            <?php
            include('../include/menu.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_bs_prodotto.php');
            include('../sql/script_componente_prodotto.php');
            include('../sql/script_bs_comp_cliente.php');
            //##################################################################
            begin();
            $sql = selectProdottiCatalogoMarie();
            $trovati = mysql_num_rows($sql);
            commit();

//TOTALE 1170px
            ?>
            <div style="width:600px; margin:15px auto;" >
                <table class="table3" >
                    <tr>
                        <th colspan="6"><?php echo $filtroCatalogo ?></th>
                    </tr>
                </table>
<!--                <td><a href="">
                        <img src="/CloudFab/images/pittogrammi/download_G.png" class="icone"  title="ESPORTA IN EXCEL" /></a></td>-->
                </tr>
                <!--################## ORDINAMENTO ########################################-->

                <?php
                echo "<br/> ".$filtroProdTotali." : " . $trovati . "<br/>";

                //Creo un array per ogni prodotto con le info base
               
                $arrayProd = array();
                $arrayProd['productCode'] = array();
                $arrayProd['productName'] = array();
                $arrayProd['nKit'] = array();
                $arrayProd['nBox'] = array();
                $arrayProd['priceList'] = array();
                $arrayProd['weightKit'] = array();
                $arrayProd['productionCost'] = array();
                $arrayProd['suggestedPriceList'] = array();
                $arrayProd['suggestedPriceListBag'] = array();
                $i = 0;
                while ($row = mysql_fetch_array($sql)) {
                    $costoDrymix = 0;
                    $costoTrasp = 0;
                    $costoOperaioMiscela = 0;
                    $costoElettricitaMix = 0;
                    $costoSacchiTot = 0;
                    $altriCosti = 0;
                    $costoDrymixTot = 0;
                    $costoProduzioneQ = 0;

                    $arrayProd['productCode' . $i] = $row['product_code'];
                    $arrayProd['productName' . $i] = $row['product_name'];
                    $arrayProd['nKit' . $i] = $row['n_kit'];
                    $arrayProd['nBox' . $i] = $row['n_box'];
                    $arrayProd['priceList' . $i] = $row['price_list'];
                    $arrayProd['weightKit' . $i] = $row['weight_kit'];

                    //############## LISTINO KIT SCONTATO  ############################
                    $listinoKitScontato = $row['price_list'] - ($row['price_list'] * $_SESSION['ScontoKit'] / 100);

                    //############## COSTO DRYMIX  ####################################
                    //#################### NUOVA SIMULAZIONE ##########################
                    if ($_SESSION['TODO_bs'] == "NEW" AND $_SESSION['NumSimulazione'] == 1) {
                        //Si selezionano i prezzi del drymix dalla tabella materia_prima        
                        $sqlCompProd = selectComponentiPrezzoByIdProdotto($row['id_product'], $_SESSION['lingua'], $valAbilitato);
                    } else if ($_SESSION['TODO_bs'] == "NEW" AND $_SESSION['NumSimulazione'] != 1) {
                        //Si selezionano i prezzi del drymix salvati la volta precedente         
                        $sqlCompProd = selectBSCompClienteByIdProdotto($_SESSION['id_cliente'], $row['id_product'], $_SESSION['lingua'], $valAbilitato);
                    } else if ($_SESSION['TODO_bs'] == "MODIFY") {
                        //########### SIMULAZIONE ESISTENTE  ##########################                                  
                        //Si selezionano i prezzi del drymix salvati la volta precedente         
                        $sqlCompProd = selectBSCompClienteByIdProdotto($_SESSION['id_cliente'], $row['id_product'], $_SESSION['lingua'], $valAbilitato);
                    }

                    while ($rowC = mysql_fetch_array($sqlCompProd)) {

                        $costoDrymix = $costoDrymix + ($rowC['pre_acq'] * $rowC['quantita']) / 1000;
                    }
                    //########### COSTO TRASPORTO ########################################## 
                    if ($row['num_kit_tot'] > 0)
                        $costoTrasp = $_SESSION['CostoTrasporto'] / $row['num_kit_tot'];

                    //##### COSTO OPERAIO - COSTO ELETTRICITA #############################
                    if ($_SESSION['Produttivita'] > 0) {
                        $costoOperaioMiscela = $_SESSION['CostoOperaio'] / $_SESSION['Produttivita'];
                        //Consumo orario di Origami 7 kw
                        $costoElettricitaMix = ($_SESSION['CostoElettricita'] * 7) / $_SESSION['Produttivita'];
                    }

                    //########### COSTO SACCHI ############################################
                    $costoSacchiTot = $_SESSION['CostoSacco'] * 4;

                    $altriCosti = $costoSacchiTot + $costoOperaioMiscela + $costoElettricitaMix;

                    $costoDrymixTot = $costoDrymix + $listinoKitScontato;

                    $costoProduzioneQ = $costoDrymixTot + $costoTrasp + $altriCosti;

                    $arrayProd['productionCost' . $i] = $costoProduzioneQ / 100;
                    //##########################################################

                    $generatoreListino = $valGeneratoreListinoPF;
                    if (isSet($_POST['GeneratoreListino' . $row['product_code']]) AND $_POST['GeneratoreListino' . $row['product_code']] != 0) {
                        $generatoreListino = $_POST['GeneratoreListino' . $row['product_code']];
                    }
                    $listinoSuggProdFinitoQ = $costoProduzioneQ * $generatoreListino;

                    $arrayProd['suggestedPriceList' . $i] = $listinoSuggProdFinitoQ / 100;
                    $arrayProd['suggestedPriceListBag' . $i] = $arrayProd['suggestedPriceList' . $i] * 25;
                    $i++;
                }
//                echo "count i: " . $i;
//                echo "<br/> " . count($arrayProd['productionCost']); 

                for ($i = 0; $i < (count($arrayProd)/9)-1; $i++) {
                    ?>
                    <table class="table3">
                        <tr>
                            <td colspan="4" class="dataRigWhite"><?php echo $arrayProd['productCode' . $i] . " " . $arrayProd['productName' . $i] ?></td>
                        </tr>                                      

                        <tr>           
                            <td class="cella2" ></td>
                            <td class="cella2" ><?php echo "n° kit" ?></td>
                            <td class="cella2" ><?php echo "n° box" ?></td>
                            <td class="cella2" ><?php echo "price list" ?></td>
<!--                            <td class="cella2" ><?php echo "packaging" ?></td>              -->
                        </tr>                                                                  
                        <tr>
                            <td class="cella1" ><?php echo "kit" ?></td>                    
                            <td class="cella1" ><?php echo "1" ?></td>
                            <td class="cella1" ><?php echo "-" ?></td>                        
                            <td class="cella1" ><?php echo number_format($arrayProd['priceList' . $i], 2, ',', '.') . " " . $filtroEuro ?></td>  
                            <!--<td class="cella1" ><?php echo "0,00 €" ?></td>-->
                        </tr>
                        <tr>
                            <td class="cella1" ><?php echo "box" ?></td>                    
                            <td class="cella1" ><?php echo $arrayProd['nKit' . $i] ?></td>
                            <td class="cella1" ><?php echo "1" ?></td>                        
                            <td class="cella1" ><?php echo number_format($arrayProd['priceList' . $i] * $arrayProd['nKit' . $i], 2, ',', '.') . " " . $filtroEuro ?></td>  
                            <!--<td class="cella1" ><?php echo "4,00 €" ?></td>-->
                        </tr>
                        <tr>
                            <td class="cella1" ><?php echo "pallet" ?></td>                    
                            <td class="cella1" ><?php echo $arrayProd['nKit' . $i] * $arrayProd['nBox' . $i] ?></td>
                            <td class="cella1" ><?php echo $arrayProd['nBox' . $i] ?></td>                        
                            <td class="cella1" ><?php echo number_format($arrayProd['priceList' . $i] * $arrayProd['nKit' . $i] * $arrayProd['nBox' . $i], 2, ',', '.') . " " . $filtroEuro ?></td>  
                            <!--<td class="cella1" ><?php echo "20,00 €" ?></td>-->
                        </tr>
                        <tr>
                            <td class="cella1" ><?php echo "woodbox" ?></td>                    
                            <td class="cella1" ><?php echo $arrayProd['nKit' . $i] * $arrayProd['nBox' . $i] * 3 ?></td>
                            <td class="cella1" ><?php echo $arrayProd['nBox' . $i] * 3 ?></td>                        
                            <td class="cella1" ><?php echo number_format($arrayProd['priceList' . $i] * $arrayProd['nKit' . $i] * $arrayProd['nBox' . $i] * 3, 2, ',', '.') . " " . $filtroEuro ?></td>  
                            <!--<td class="cella1" ><?php echo "39,00 €" ?></td>-->
                        </tr>
                    </table>
                    <table class="table3">
                        <tr>
                            <td class="dataRigWhite"><?php echo "production cost " ?></td>
                            <td class="dataRigWhite" style="text-align:right"><?php echo number_format($arrayProd['productionCost' . $i], 2, ',', '.') . " €/" . $filtroKgBreve ?></td>
                            <td class="dataRigWhite"><?php echo "kit's weight" ?></td>
                            <td class="dataRigWhite" style="text-align:right"><?php echo number_format($arrayProd['weightKit' . $i],0,',','.') . " " . $filtrogBreve ?></td>
                        </tr>
                    </table>
                    <table class="table3">
                        <tr>
                            <td class="cella2"><?php echo "suggested price list " ?></td>
                            <td class="cella1" style="text-align:right"><?php echo number_format($arrayProd['suggestedPriceList' . $i], 2, ',', '.') . " €/" . $filtroKgBreve ?></td>
                            <td class="cella1" style="text-align:right"><?php echo number_format($arrayProd['suggestedPriceListBag' . $i], 2, ',', '.') . " €/bag (25kg)" ?></td>
                        </tr>
                    </table>
                    <br/>
                    <br/>
                    <?php
                }
                ?>



            </div>
        </div>
    </body>
</html>
