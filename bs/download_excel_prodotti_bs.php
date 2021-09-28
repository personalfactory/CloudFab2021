<?php

$filename = "sheet.xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: inline; filename=$filename");


include('../Connessioni/serverdb.php');
include('../sql/script_bs_prodotto.php');
include("../lingue/gestore.php");

session_start();
$strUtentiAziende = $_GET['StringaUtAziende'];

$sql = findProdottiBsVisByFiltriUnion("id_prodotto", $_SESSION['Filtro'], $_SESSION['CodProdotto'], $_SESSION['NomeProd'], $_SESSION['Classificazione'], $_SESSION['ListinoLotto'], $_SESSION['NumKit'],$_SESSION['ListinoKit'], $_SESSION['Rating'], $strUtentiAziende);
//        $sql = findProdottiBsVisByFiltri("p.id_prodotto", "rating", $_SESSION['CodProdotto'], $_SESSION['NomeProd'], $_SESSION['Classificazione'], $_SESSION['ListinoLotto'], $_SESSION['NumKit'], $_SESSION['ListinoKit'], $_SESSION['Rating'], $strUtentiAziende);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang=it><head>        
<!--<title><?php echo $titoloPaginaProdottiBs ?></title></head>-->
    <body>
        <table>
            <tr>        
                <td>CODICE</td>
                <td>NOME</td>
                <td>CLASSIFICAZIONE</td>
                <td>NUM KIT IN LOTTO</td>
                <td>NUM LOTTI</td>
                <td>LISTINO KIT</td>
                <td>LISTINO LOTTO</td>              
            </tr>
            <?php while ($row = mysql_fetch_array($sql)) {
                ?>
                <tr>
                    <td><?php echo($row['cod_prodotto']) ?></td>
                    <td><?php echo($row['nome_prodotto']) ?></td>
                    <td><?php echo($row['classificazione']) ?></td>
                    <td><?php echo($row['num_sac_in_lotto']) ?></td>
                    <td><?php echo($row['num_lotti']) ?></td>
                    <td><?php echo number_format($row['listino'] / $row['num_sac_in_lotto'], 2, '.', '') . " " . $filtroEuro ?></td>
                    <td><?php echo number_format($row['listino'], 2, '.', '') . " " . $filtroEuro ?></td>
                </tr>
            <?php } ?>
        </table>
    </body>
</html>
<!--  <td><?php echo $filtroCodice; ?></td>
                <td><?php echo $filtroNome; ?></td>
                <td><?php echo $filtroClassificazione ?></td>
                <td><?php echo $filtroNumKitInLotto ?></td>
                <td><?php echo $filtroNumLotti ?></td>
                <td><?php echo $filtroListino . " " . $filtroKitChim ?></td>
                <td><?php echo $filtroListinoLotto ?></td>              
                <td><?php echo $filtroRating; ?></td>-->