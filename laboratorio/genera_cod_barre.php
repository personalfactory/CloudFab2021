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
            window.print();
        }
    </script>
    <?php
//include('../include/menu.php');
    include('../Connessioni/serverdb.php');
    include('../sql/script_mov_magazzino.php');
    include('../sql/script.php');
    include('../include/precisione.php');
    include('../include/gestione_date.php');

    ini_set("display_errors", "1");

    $strInfoCodiceBarre = $_GET['strInfoCodiceBarre'];

    list($CodMat, $NomeMat, $tipo, $famiglia, $fornitore, $prezzo, $scaffale, $ripiano, $note, $dtAbilitato) = explode(';', $strInfoCodiceBarre);
    ?>
    <!--<body onLoad='printpage();history.back()' style="font-family: Verdana, Arial, Helvetica, sans-serif;">-->
<body onLoad='printpage();' style="font-family: Verdana, Arial, Helvetica, sans-serif;">

        <div style="width:80%; 
             margin:0 auto; 
             margin-top: 50px; 
             margin-bottom: 10px;
             font-size: 35px;
             text-align:center;">
            <b><?php echo $NomeMat ?></b>
        </div>
        <div style="margin:0 auto; 
             margin-bottom: 10px;                 
             font-size: 15px;">                

            <table border="1px solid;" style="border-collapse:collapse;width:70%;margin:0 auto;">
                <tr>
                    <td  text-align="left"><?php echo $filtroFamiglia ?></td>
                    <td  text-align="right"><nobr><?php echo $famiglia ?></nobr></td></tr>
                <tr>
                    <td  text-align="left"><?php echo $filtroLabSottoTipo ?></td>
                    <td text-align="right"><nobr><?php echo $tipo ?></nobr></td>
                </tr>
                <tr>
                    <td text-align="left"><?php echo $filtroLabFornitore ?></td>
                    <td text-align="right"><nobr><?php echo $fornitore ?></nobr></td></tr>

                <tr>
                    <td text-align="left"><?php echo $filtroLabScaffale ?></td>
                    <td text-align="right"><nobr><?php echo $scaffale ?></nobr></td>
                </tr>
                <tr>
                    <td text-align="left"><?php echo $filtroLabRipiano ?></td>
                    <td text-align="right"><nobr><?php echo $ripiano ?></nobr></td>
                </tr>
                <tr>
                    <td text-align="left"><?php echo $filtroLabNote ?></td>
                    <td text-align="right"><?php echo $note ?></td>
                </tr>
                <tr>
                    <td text-align="left"><?php echo $filtroDtInserimento ?></td>
                    <td text-align="right"><?php echo dataEstraiVisualizza($dtAbilitato) ?></td>
                </tr>
            </table>
        </div>
        <div id="barcode" style="text-align:center;">
            <img width="300px" src="/CloudFab/object/barcode/barcode.php?Codice=<?php echo $CodMat ?>" alt="barcode"/>
        </div>
    </body>
</html>
