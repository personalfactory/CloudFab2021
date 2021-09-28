<?php
include("./oggetti/ChimicaGiacenza.php");
$filename = "materie_prime.xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: inline; filename=$filename");

include('../include/validator.php'); 

include('../Connessioni/serverdb.php');
include('../sql/script_materia_prima.php');
include("../lingue/gestore.php");
//include("./oggetti/ChimicaGiacenza.php");

$_SESSION['ChimicaGiacenza']=array();


$strUtentiAziende = $_POST['StringaUtAziende'];
$dataInf = $_POST['DataInf'];
$dataSup = $_POST['DataSup'];



$sqlMat = selectMatPrimeByFiltri($_SESSION['Filtro'], "cod_mat", $_SESSION['Codice'], $_SESSION['Descri'], $_SESSION['Famiglia'], $_SESSION['ScortaMinima'], $_SESSION['PreAcq'], $_SESSION['Giacenza'], $_SESSION['DtAbilitato'],$strUtentiAziende,$_SESSION['condizioneSelect']);
        //findAllMatPrime("cod_mat",$strUtentiAziende);

$i = 0;
while ($row = mysql_fetch_array($sqlMat)) {
           
    $artico=$row['cod_mat'];
    $descri_artico=$row['descri_mat'];
    
    //Inventario
    $inventario=  $row['inventario'];
    $dtInventario=$row['dt_inventario'];
    $prezzo=$row['pre_acq'];    
    
    //############################################################
    //Calcolo della giacenza alla data inf
    //Acquisti fatti dall'inizio inventario alla data inf
    $sqlAcq=sommaMovimentiTotMat($artico,$dtInventario, $dataInf, "2","1");
    while ($rowA = mysql_fetch_array($sqlAcq)) {
        $acq=number_format($rowA['somma_mov'],0);
    }
    //Consumi fatti dall'inizio inventario alla data inf
    $sqlCons=sommaMovimentiTotMat($artico,$dtInventario, $dataInf, "2","-1");
    while ($rowC = mysql_fetch_array($sqlCons)) {
    
        $cons=$rowC['somma_mov'];
    }
    $giacenzaInf=0;
    $giacenzaInf=$inventario+$acq-$cons;
        
    //############################################################
        
    //Acquisti
    $sqlAcquisti=sommaMovimentiTotMat($artico,$dataInf, $dataSup, "2","1");
    while ($rowA = mysql_fetch_array($sqlAcquisti)) {
        $acquisti=$rowA['somma_mov'];
        $valoreAcquisti=$acquisti*$prezzo;
    }
    //Consumi
    $sqlConsumi=sommaMovimentiTotMat($artico,$dataInf, $dataSup, "2","-1");
    while ($rowC = mysql_fetch_array($sqlConsumi)) {
    
        $consumi=$rowC['somma_mov'];
        $valoreConsumi=$consumi*$prezzo;
    }
    $giacenza=0;
    $valorizzazione=0;
    
    $giacenza=$inventario+$acquisti-$consumi;
    $valorizzazione=$giacenza*$prezzo;
    
    
    
    
    //Se la data inf è successiva alla data dell'inventario
    if($dataInf>$dtInventario)
         $giacenza=$giacenzaInf+$acquisti-$consumi;
         
                
         //Formattazione
         $inventario = number_format($inventario,'2',',','');         
         $giacenzaInf = number_format($giacenzaInf,'2',',','');
         $consumi = number_format($consumi,'2',',','');
         $acquisti = number_format($acquisti,'2',',','');
         $giacenza = number_format($giacenza,'2',',','');
         $prezzo = number_format($prezzo,'2',',','');
         $valorizzazione = number_format($valorizzazione,'2',',','');
         
         $valoreAcquisti=number_format($valoreAcquisti,'2',',','');
         $valoreConsumi=number_format($valoreConsumi,'2',',','');

         
         
    $_SESSION['ChimicaGiacenza'][$i] = new ChimicaGiacenza($artico, $descri_artico,$inventario,$dtInventario,$giacenzaInf,$consumi,$acquisti,$giacenza,$prezzo,$valorizzazione,$valoreAcquisti,$valoreConsumi);
    
    $i++;
    
}
$dtInventario=  substr($dtInventario, 0,10);
$totInventario=0;
$totGiacenzaIni=0;
$totAcquisti=0;
$totValoreAcquisti=0;
$totConsumi=0;
$totValoreConsumi=0;
$totGiacenzaFin=0;
$totValorizzazione=0;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang=it>
    <head>
    
    </head>
    <body>        
        <table>
            <th colspan="9"><?php echo $filtroPeriodo.' '.$filtroDal.' '.$dataInf . ' '.$filtroAl.''. $dataSup ?></th>
            <tr> 
                
                <td><b><?php echo $filtroCodice ?></b></td>
                <td><b><?php echo $filtroMateriaPrima ?></b></td>
                <td><b><?php echo $filtroPrezzo .'&nbsp;&euro;/'.$filtroKgBreve ?></b></td> 
                <td><b><?php echo $filtroInventario.' '.$filtroKgBreve.' ('. $dtInventario.') '?></b></td>
                <td><b><?php echo $filtroGiacenza.' '.$filtroKgBreve.' ('. $dataInf.') '?></b></td>
                <td><b><?php echo $filtroAcquisti.' '.$filtroKgBreve ?></b></td>
                <td><b><?php echo $filtroValore. ' '.$filtroAcquisti  ?>&nbsp; &euro;</b></td>
                <td><b><?php echo $filtroConsumo .' '.$filtroKgBreve?></b></td>
                <td><b><?php echo $filtroValore. ' '.$filtroConsumo ?>&nbsp; &euro;</b></td>
                <td><b><?php echo $filtroGiacenza.' '.$filtroKgBreve.' ('. $dataSup.') ' ?></b></td>
                <td><b><?php echo $filtroValore.' '.$filtroGiacenza ?>&nbsp; &euro;</b></td>
                
            </tr>
<?php for($j=0;$j<count($_SESSION['ChimicaGiacenza']);$j++) { ?>
                <tr>
                    
                    <td><?php echo $_SESSION['ChimicaGiacenza'][$j]->getArtico() ?></td>
                    <td><?php echo $_SESSION['ChimicaGiacenza'][$j]->getDescri_artico() ?></td>
                    <td><?php echo $_SESSION['ChimicaGiacenza'][$j]->getPrezzo() ?></td>
                    <td><?php echo $_SESSION['ChimicaGiacenza'][$j]->getInventario()?></td>                    
                    <td><?php echo $_SESSION['ChimicaGiacenza'][$j]->getGiacenzaIni() ?></td>                    
                    <td><?php echo $_SESSION['ChimicaGiacenza'][$j]->getAcquisti() ?></td>
                    <td><?php echo $_SESSION['ChimicaGiacenza'][$j]->getValoreAcquisti() ?></td>                    
                    <td><?php echo $_SESSION['ChimicaGiacenza'][$j]->getConsumi() ?></td>
                    <td><?php echo $_SESSION['ChimicaGiacenza'][$j]->getValoreConsumi() ?></td>
                    <td><?php echo $_SESSION['ChimicaGiacenza'][$j]->getGiacenzaFin() ?></td>
                    <td><?php echo $_SESSION['ChimicaGiacenza'][$j]->getValorizzazione() ?></td>
                    
                </tr>
<?php 
$totInventario=$totInventario+$_SESSION['ChimicaGiacenza'][$j]->getInventario();
$totGiacenzaIni=$totGiacenzaIni+$_SESSION['ChimicaGiacenza'][$j]->getGiacenzaIni();
$totAcquisti=$totAcquisti+$_SESSION['ChimicaGiacenza'][$j]->getAcquisti();
$totValoreAcquisti=$totValoreAcquisti+$_SESSION['ChimicaGiacenza'][$j]->getValoreAcquisti();
$totConsumi=$totConsumi+$_SESSION['ChimicaGiacenza'][$j]->getConsumi();
$totValoreConsumi=$totValoreConsumi+$_SESSION['ChimicaGiacenza'][$j]->getValoreConsumi();
$totGiacenzaFin=$totGiacenzaFin+$_SESSION['ChimicaGiacenza'][$j]->getGiacenzaFin();
$totValorizzazione=$totValorizzazione+$_SESSION['ChimicaGiacenza'][$j]->getValorizzazione();
} ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b><?php echo $totInventario.' '.$filtroKgBreve?></b></td>                    
                    <td><b><?php echo $totGiacenzaIni.' '.$filtroKgBreve ?></b></td>                    
                    <td><b><?php echo $totAcquisti.' '.$filtroKgBreve ?></b></td>
                    <td><b><?php echo $totValoreAcquisti ?>&nbsp; &euro;</b></td>                    
                    <td><b><?php echo $totConsumi.' '.$filtroKgBreve ?></b></td>
                    <td><b><?php echo $totValoreConsumi ?>&nbsp; &euro;</b></td>
                    <td><b><?php echo $totGiacenzaFin.' '.$filtroKgBreve ?></b></td>
                    <td><b><?php echo $totValorizzazione ?>&nbsp; &euro;</b></td>
                    
                </tr>
        </table>
    </body>
</html>
