      
<?php
include_once('../sql/script_materia_prima.php');
include_once('../sql/script_accessorio.php');

//#############  TABELLA DEI COSTI #############################
$CostoLotto = 0;
$PrezzoLotto = 0;
$CostoFinale = 0;
$CostoMaterie = 0;
$ListinoLotto = 0;
$CostoOper=0;
$CostoSacProdFin=0;

$CostoProdIntProdFinito = 0;
$CostoFinaleCliente = 0;
$ListinoProdFinCliente = 0;
$CostoIntSacChimica = 0;
$CostoKitChimico = 0;

//########## COSTO UNITARIO OPERATORE ##########################################
$sqlCostoOper = findAccessorioByCodice("OPER");
while ($rowCostoOper = mysql_fetch_array($sqlCostoOper)) {
    $CostoOper = $rowCostoOper["pre_acq"];
}
//########## COSTO UNITARIO SACCO DI PRODOTTO FINITO ###########################
$sqlCostoSacProdFin = findAccessorioByCodice("bag1");
while ($rowCostoSacProdFin = mysql_fetch_array($sqlCostoSacProdFin)) {
    $CostoSacProdFin = $rowCostoSacProdFin["pre_acq"];
}

$NumeroLottiTotale = $NumeroLotti;
//Numero di kit in un lotto
$NumSacchetti = $NumeroKitSacchetti;

//########### COSTO LOTTO ######################################################
if ($NumeroLottiTotale>0)
    $CostoLotto = ($CostoTotaleAccessori + $CostoMiscelaMtTotale) / $NumeroLottiTotale;

//################### PREZZO DEL LOTTO #########################################
//Calcolo il prezzo Lotto		 
$PrezzoLotto = $CostoLotto * 2.1;

//################### PREZZO DI LISTINO DEL LOTTO ##############################
$ListinoLotto = $CostoLotto * 3;

//###################### COSTO KIT CHIMICO #####################################
if ($NumSacchetti > 0)
    $CostoKitChimico = $CostoLotto / $NumSacchetti;

// NB:Quando si crea una nuova formula, poichè il relativo prodotto viene caricato dopo di essa, 
//i costi relativi ai componenti del prodotto ( Costo Materia, Costo Finale, Listino Prodotto) 
//non si possono ancora calcolare. 
//Quindi verranno calcolati e visualizzati solo nella pagina di modifica della formula e 
//volendo nelle pagine del prodotto
//##############################################################################
//############## MODIFICA FORMULA -- VISTA PRODOTTO FORMULA ####################
//##############################################################################

$CostoCompProd = 0;
if ($Pagina == "modifica_formula" || $Pagina == "vista_prodotto_formula") {

//Calcolo il costo dei componenti del prodotto
    $CostoCompProd = 0;
    $CodProdotto = substr($CodiceFormula, 1, 5);
    $sqlProdotto = findProdottoByCodice($CodProdotto);

    while ($rowProdotto = mysql_fetch_array($sqlProdotto)) {

        $IdProdotto = $rowProdotto["id_prodotto"];

        $sqlCostoCompProd = findPrezzoCompProdotto($IdProdotto);

        while ($rowCostoCompProd = mysql_fetch_array($sqlCostoCompProd)) {
            $Preacq = $rowCostoCompProd["pre_acq"] / 1000;
            $CostComp = $Preacq * $rowCostoCompProd["quantita"];
            $CostoCompProd = $CostoCompProd + $CostComp;
        }
        
    }//End while select id_prodotto

}

//Calcolo il Costo di produzione interno per prodotto finito
$CostoProdIntProdFinito = $CostoKitChimico + ($CostoOper * 6) + ($CostoSacProdFin * 4) + $CostoCompProd;
//Per 4 sacchi di prodotto finito/// MARILISA ????????????????????????
//    $CostoFinaleCliente = 2.1 * ($CostoKitChimico + ($CostoOper * 6) + ($CostoSacProdFin * 4) + $CostoCompProd);
//    $ListinoProdFinCliente = $CostoProdIntProdFinito * 3;
$CostoMaterie = $CostoCompProd + $CostoKitMatCompoundTotale;
$CostoFinale = $CostoKitChimico + $CostoCompProd;

//????????????????????????????????? FRANCESCO ?????????????????????????
   $CostoFinaleCliente = (2.1 * $CostoKitChimico) + ($CostoSacProdFin * 4) + ($CostoOper * 6) + $CostoCompProd;
   $ListinoProdFinCliente = $CostoFinaleCliente * 3;   
    ?>


    <table width="100%">
        <tr>
            <td height="42" colspan="6" class="cella3"><?php echo $filtroCostiInterni ?></td>
        </tr>
        <tr>
            <td class="cella1" width="20%" title="<?php echo $titleCostoLotto2 ?>"><?php echo $filtroCostoLotto ?></td>
            <td class="cella1" width="20%" title="<?php echo $titleCostoIntKitChim ?>"><?php echo $filtroCostoIntKitChim ?></td>            
            <td class="cella2" width="20%" title="<?php echo $titleCostoMatCompoundProdFinito?>"><?php echo $filtroCostoMatCompoundProdFinito ?></td>
            <td class="cella2" width="20"  title="<?php echo $titleCostoMatDrymixProdFinito?>"><?php echo $filtroCostoMatDrymixProdFinito ?></td>
            <td class="cella1" width="20%" title="<?php echo $titleCostoProduzioneIntProdFinito ?>"><?php echo $filtroCostoProduzioneIntProdFinito ?></td>
        </tr>
        <tr>           
            <td class="cella1"><?php echo number_format($CostoLotto, 2, '.', ''). " ".$filtroEuro; ?></td>
            <td class="cella1"><?php echo number_format($CostoKitChimico, 2, '.', ''). " ".$filtroEuro ; ?></td>
            <td class="cella2"><?php echo $CostoKitMatCompoundTotale. " ".$filtroEuro; ?></td>
            <td class="cella2"><?php echo number_format($CostoCompProd, 2, '.', ''). " ".$filtroEuro; ?></td>
            <td class="cella1"><?php echo number_format($CostoProdIntProdFinito, 2, '.', ''). " ".$filtroEuro; ?></td> 
        </tr> 
    </table> 
    <table width="100%">
        <tr>
            <td height="42" colspan="6"  class="cella3"><?php echo $filtroCostiCliente ?></td>
        </tr>  
        <tr>
            <td class="cella2" width="50%" title="<?php echo $titlePrezzoLottoScontatoSugg ?>"><?php echo $filtroPrezzoLottoScontatoSugg ?></td>
            <td class="cella1" width="50%" title="<?php echo $titleCostoFinaleCLienteTeo ?>"><?php echo $filtroCostoFinaleCLienteTeo ?></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo number_format($PrezzoLotto, 2, '.', ''). " ".$filtroEuro; ?></td>
            <td class="cella1"><?php echo number_format($CostoFinaleCliente, 2, '.', ''). " ".$filtroEuro; ?></td>
        </tr>   
        <tr>
            <td height="42" colspan="6" class="cella3"><?php echo $filtroListino ?></td>
        </tr>   
        <tr>
            <td class="cella2" width="50%" title="<?php echo $titleListLottoSugg ?>"><?php echo $filtroListLottoSugg ?></td>
            <td class="cella1" width="50%" title="<?php echo $titleListProdottoFinale ?>"><?php echo $filtroListProdottoFinale ?></td>
        </tr>  
        <tr>	
            <td class="cella2"><?php echo number_format($ListinoLotto, 2, '.', ''). " ".$filtroEuro; ?></td>
            <td  class="cella1"><?php echo number_format($ListinoProdFinCliente, 2, '.', ''). " ".$filtroEuro; ?></td>
        </tr>
    </table>


    