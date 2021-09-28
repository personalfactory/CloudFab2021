<?php

$filename = "production.xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: inline; filename=$filename");

include('../include/validator.php'); 

include('../Connessioni/serverdb.php');
include('../sql/script_processo.php');
include("../lingue/gestore.php");


$IdMacchina=$_GET['IdMacchina'];
$dataInf = $_POST['DataInf'];
$dataSup = $_POST['DataSup'];

$sqlProcessi = findInfoProcessiEsporta($IdMacchina,$dataInf,$dataSup);
       
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang=it>
    <head>
    
    </head>
    <body>        
        <table>
            <tr> 
                
                <td><b><?php echo $filtroIdCiclo ?></b></td>
                <td><b><?php echo $filtroTipo ?></b></td>
                <td><b><?php echo $filtroDtInizioCiclo ?></b></td> 
                <td><b><?php echo $filtroDtFineCiclo ?></b></td>
                <td><b><?php echo $filtroIdOrdine?></b></td>               
                <td><b><?php echo $filtroCodProdotto  ?></b></td>
                <td><b><?php echo $filtroNomeProdotto  ?></b></td>
                <td><b><?php echo $filtroCodKit?></b></td>
                <td><b><?php echo $filtroCliente?></b></td>
                <td><b><?php echo $filtroOperatore ?></b></td>
                <td><b><?php echo $filtroIdCat?></b></td>
                <td><b><?php echo $filtroCategoria ?></b></td>                
                <td><b><?php echo $filtroVelocitaMiscelazione ?></b></td>
                <td><b><?php echo $filtroTempoMiscelazione ?></b></td>
                <td><b><?php echo $filtroNumSacchiMiscela ?></b></td>
                <td><b><?php echo $filtroNumSacAggiuntivi ?></b></td>
                <td><b><?php echo $filtroVibro ?></b></td>
                <td><b><?php echo $filtroAriaCondScarico ?></b></td>
                <td><b><?php echo $filtroAriaInternoValvola ?></b></td>
                <td><b><?php echo $filtroAriaPulisciValvola ?></b></td>
                <td><b><?php echo $filtroProcesso?></b></td>
                <td><b><?php echo $filtroDtInizioProcesso ?></b></td>
                <td><b><?php echo $filtroDtFineProcesso ?></b></td>
                <td><b><?php echo $filtroCodSacco ?></b></td>
                <td><b><?php echo $filtroNumSacco ?></b></td>
                <td><b><?php echo $filtroPesoRealeSacco ?></b></td>
                <td><b><?php echo $filtroPesoTeoSacco ?></b></td>
                <td><b><?php echo $filtroErrSacco ?></b></td>
                 <td><b><?php echo $filtroIdMateriaPrima ?></b></td>
                 <td><b><?php echo $filtroCodiceMatPri ?></b></td>
                 <td><b><?php echo $filtroNomeMateriaPrima ?></b></td>
                 <td><b><?php echo $filtroTipoMt ?></b></td>
                 <td><b><?php echo $filtroQtaRealeMat ?></b></td>
                 <td><b><?php echo $filtroQtaTeoMat ?></b></td>
                 <td><b><?php echo $filtroCodiciMov ?></b></td>
                 <td><b><?php echo $filtroDataMov ?></b></td>
                 <td><b><?php echo $filtroSilo ?></b></td>
                 <td><b><?php echo $filtroDescriMovimento?></b></td>
      
                
            </tr>
<?php $i = 0;
while ($row = mysql_fetch_array($sqlProcessi)) {
    $numSacco=0;
    $pesoTeoSac=0;
    $erroreSacco=0;
    
    list($numSacco,$pesoTeoSac,$erroreSacco)=  explode("_", $row['info3']);
           ?>
  <tr> 
                
                <td><?php echo $row['id_ciclo'] ?></td>
                <td><?php echo $row['tipo_ciclo'] ?></td>
                <td><?php echo $row['dt_inizio_ciclo'] ?></td> 
                <td><?php echo $row['dt_fine_ciclo'] ?></td>
                <td><?php echo $row['id_ordine']?></td>
                <td><?php echo $row['cod_prodotto']  ?></td>
                <td><?php echo $row['nome_prodotto']  ?></td>
                <td><?php echo $row['cod_chimica']?></td>
                <td><?php echo $row['cliente']?></td>
                <td><?php echo $row['cod_operatore'] ?></td>
                <td><?php echo $row['id_cat'] ?></td>
                <td><?php echo $row['nome_categoria'] ?></td>
                <td><?php echo $row['velocita_mix'] ?></td>
                <td><?php echo $row['tempo_mix'] ?></td>
                <td><?php echo $row['num_sacchi'] ?></td>
                <td><?php echo $row['num_sacchi_aggiuntivi'] ?></td>
                <td><?php echo $row['vibro_attivo'] ?></td>
                <td><?php echo $row['aria_cond_scarico'] ?></td>
                <td><?php echo $row['aria_interno_valvola'] ?></td>
                <td><?php echo $row['aria_pulisci_valvola'] ?></td>
                <td><?php echo $row['id_processo'] ?></td>
                <td><?php echo $row['dt_inizio_processo'] ?></td>
                <td><?php echo $row['dt_fine_processo'] ?></td>
                <td><?php echo $row['cod_sacco'] ?></td>
                <td><?php echo $numSacco?></td>                
                <td><?php echo $row['peso_reale_sacco'] ?></td>
                <td><?php echo $pesoTeoSac?></td>
                 <td><?php echo $erroreSacco?></td>
                 <td><?php echo $row['id_materiale']?></td>
                 <td><?php echo $row['cod_componente']?></td>
                 <td><?php echo $row['descri_componente']?></td>
                 <td><?php echo $row['tipo_materiale']?></td>
                 <td><?php echo $row['quantita']?></td>
                  <td><?php echo $row['peso_teorico']?></td>
                   <td><?php echo $row['cod_ingresso_comp']?></td>
                   <td><?php echo $row['dt_mov']?></td>
                   <td><?php echo $row['silo']?></td>
                    <td><?php echo $row['descri_mov']?></td>
                 
                 
                 
                 
       


    
    
    <?php
}

?>
              
        </table>
    </body>
</html>
