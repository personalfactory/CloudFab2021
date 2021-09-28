<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php
        include("/var/www/CloudFab/lingue/gestore.php");
//        include('../include/header.php'); 
        ?>
    </head>
    <script>
        function printpage()
        {
            window.print()
        }
    </script>
    <?php
//include('../include/menu.php');
    include('../Connessioni/serverdb.php');
    include('../sql/script_mov_magazzino.php');
    include('../sql/script.php');
    include('../include/precisione.php');
    include('../include/gestione_date.php');
    include('sql/script_lab_materie_prime.php');
    
    ini_set("display_errors", "1");


    
    $sql = selectLabMatPrimeByFiltri($_SESSION['Filtro'], "cod_mat", $_SESSION['Codice'], $_SESSION['Descri'], $_SESSION['Famiglia'], $_SESSION['Tipo'], $_SESSION['Fornitore'], $_SESSION['DtAbilitato'], $_SESSION['stringaUtentiAziende'],$_SESSION['condizioneSelect']);
    
    
    ?>
    <body onLoad='printpage(); history.back()' style="font-family: Verdana, Arial, Helvetica, sans-serif;">
<?php 
        
        while ($row = mysql_fetch_array($sql)) {
        
        ?>
        

        <div style="width:80%; 
             margin:0 auto; 
             margin-top: 50px; 
             margin-bottom: 10px;
             font-size: 35px;
             text-align:center;page-break-before: always
             "><b>
<?php echo $row['descri_materia'] ?></b>
        </div>
        <div style="
             margin:0 auto; 
             margin-bottom: 10px;                 
             font-size: 15px;">                

            <table border="1px solid;" style="border-collapse:collapse;width:70%;margin:0 auto;">
                <tr>
                    <td text-align="left"><?php echo $filtroFamiglia ?></td>
                    <td text-align="right"><nobr><?php echo $row['famiglia'] ?></nobr></td>
                </tr>
                <tr>
                    <td text-align="left"><?php echo $filtroLabSottoTipo ?></td>
                    <td text-align="right"><nobr><?php echo $row['tipo'] ?></nobr></td>
                </tr>
                <tr>
                    <td text-align="left"><?php echo $filtroLabFornitore ?></td>
                    <td text-align="right"><nobr><?php echo $row['fornitore'] ?></nobr></td></tr>

                <tr>
                    <td text-align="left"><?php echo $filtroLabScaffale ?></td>
                    <td text-align="right"><nobr><?php echo $row['scaffale'] ?></nobr></td>
                </tr>
                <tr>
                    <td text-align="left"><?php echo $filtroLabRipiano ?></td>
                    <td text-align="right"><nobr><?php echo $row['ripiano'] ?></nobr></td>
                </tr>
                <tr>
                    <td text-align="left"><?php echo $filtroLabNote ?></td>
                    <td text-align="right"><?php echo $row['note'] ?></td>
                </tr>
                <tr>
                    <td text-align="left"><?php echo $filtroDtInserimento?></td>
                    <td text-align="right"><?php echo dataEstraiVisualizza($row['dt_abilitato']) ?></td>
                </tr>
            </table>
        </div>
        
        
        
        <div id="barcode" style="text-align:center;">
            <img width="300px" src="/CloudFab/object/barcode/barcode.php?Codice=<?php echo $row['cod_mat'] ?>" alt="barcode"/>
        </div>
        
        
        <?php } ?>
    </body>
</html>
