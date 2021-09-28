<?php

$filename = "materie_prime.xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: inline; filename=$filename");

session_start();
include('../Connessioni/serverdb.php');
include('../sql/script_materia_prima.php');
include("../lingue/gestore.php");
include("./oggetti/ChimicaGiacenza.php");

$strUtentiAziende = $_POST['StringaUtAziende'];
$dataInf = $_POST['DataInf'];
$dataSup = $_POST['DataSup'];

//$_SESSION['ChimicaGiacenza'] = array();

$sqlMat =findAllMatPrime("cod_mat",$strUtentiAziende);

$i = 0;
while ($row = mysql_fetch_array($sqlMat)) {
           
    $artico=$row['cod_mat'];
    $descri_artico=$row['descri_mat'];
    
    //Inventario
    $inventario=$row['inventario'];
    $dtInventario=$row['dt_inventario'];
    $prezzo=$row['pre_acq'];    
    
    //############################################################
    //Calcolo della giacenza alla data inf
    //Acquisti fatti dall'inizio inventario alla data inf
    $sqlAcq=sommaMovimentiTotMat($artico,$dtInventario, $dataInf, "2","1");
    while ($rowA = mysql_fetch_array($sqlAcq)) {
        $acq=$rowA['somma_mov'];
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
    }
    //Consumi
    $sqlConsumi=sommaMovimentiTotMat($artico,$dataInf, $dataSup, "2","-1");
    while ($rowC = mysql_fetch_array($sqlConsumi)) {
    
        $consumi=$rowC['somma_mov'];
    }
    $giacenza=0;
    $valorizzazione=0;
    
    $giacenza=$inventario+$acquisti-$consumi;
    $valorizzazione=$giacenza*$prezzo;
    
    //Se la data inf è successiva alla data dell'inventario
    if($dataInf>$dtInventario)
         $giacenza=$giacenzaInf+$acquisti-$consumi;
          
    $_SESSION['ChimicaGiacenza'][$i] = new ChimicaGiacenza($artico, $descri_artico,$inventario,$dtInventario,$giacenzaInf, $consumi,$acquisti,$giacenza,$prezzo,$valorizzazione);
    
    $i++;
    
}
$dtInventario=  substr($dtInventario, 0,10);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang=it>
    <head>
    <title></title>
    </head>
    <body>        
        <table>
            <th colspan="9">PERIODO DI TEMPO DAL <?php echo $dataInf ?>AL <?php echo $dataSup ?></th>
            <tr> 
                 
                <td><?php echo $filtroCodice ?></td>
                <td><?php echo $filtroMateriaPrima ?></td>
                <td><?php echo $filtroInventario.' ('. $dtInventario.')'?></td>
                <td><?php echo $filtroGiacenza.' ('. $dataInf.')'?></td>
                <td><?php echo $filtroAcquisti ?></td>
                <td><?php echo $filtroConsumo ?></td>
                <td><?php echo $filtroGiacenza.' ('. $dataSup.')' ?></td>
                <td><?php echo $filtroPrezzo ?></td> 
                <td><?php echo $filtroValore ?>&nbsp; &euro;</td> 
            
<?php for($j=0;$j<count($_SESSION['ChimicaGiacenza']);$j++) { ?>
                <tr>
                    <td><?php echo ($_SESSION['ChimicaGiacenza'][$j]->getArtico()) ?></td>
                    <td><?php echo ($_SESSION['ChimicaGiacenza'][$j]->getDescri_artico()) ?></td>
                    <td><?php echo ($_SESSION['ChimicaGiacenza'][$j]->getInventario()) ?></td>                    
                    <td><?php echo ($_SESSION['ChimicaGiacenza'][$j]->getGiacenzaIni()) ?></td>                    
                    <td><?php echo ($_SESSION['ChimicaGiacenza'][$j]->getAcquisti()) ?></td>
                    <td><?php echo ($_SESSION['ChimicaGiacenza'][$j]->getConsumi()) ?></td>
                    <td><?php echo ($_SESSION['ChimicaGiacenza'][$j]->getGiacenzaFin()) ?></td>
                    <td><?php echo ($_SESSION['ChimicaGiacenza'][$j]->getPrezzo()) ?></td>
                    <td><?php echo ($_SESSION['ChimicaGiacenza'][$j]->getValorizzazione()) ?></td>
                </tr>
<?php } ?>
        </table>
    </body>
</html>
