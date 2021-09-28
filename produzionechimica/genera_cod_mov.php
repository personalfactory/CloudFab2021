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
    
    ini_set("display_errors", "1");

    $IdMov = $_GET['IdMov'];
    $CodMat = $_GET['CodMat'];
    $DtDoc = $_GET['DtDoc'];
    $NomeMat = $_GET['NomeMat'];

    $DtMov = eliminaTrattini($DtDoc);

    $CodMov = $CodMat . "." . $IdMov . "." . $DtMov;

    $insertCodMov = true;

//VERIFICA ESISTENZA CODICE MOVIMENTO SU SERVERDB
    $sqlCodEsiste = findMovMagazzinoByCodMov($CodMov);
    if (mysql_num_rows($sqlCodEsiste) == 0) {

        begin();

        $insertCodMov = inserisciCodMov($CodMov, $valStatoCodMovNuovo, $CodMov);
        if (!$insertCodMov) {

            rollback();

            echo '<div id="msgErr">' . $msgErroreVerificato . '' . $msgErrContattareAdmin . ' <a href="gestione_gaz_movmag.php">' . $msgOk . '</a></div>';
        } else {

            commit();
            ?>
            <body onLoad='printpage();
                    history.back()'>

                <body onLoad='printpage();
                    history.back()'>          
                    <div   style="width:90%; 
                       margin:0 auto; 
                       margin-top: 50px; 
                       margin-bottom: 5px;
                       font-family: Verdana, Arial, Helvetica, sans-serif;
                       font-size: 30px;text-align:center;"><?php echo $NomeMat ?>
                </div>
                <div  id="barcode" style="text-align:center">
                        <img  src="/CloudFab/object/barcode/barcode.php?Codice=<?php echo $CodMov ?>" alt="barcode"/>
                    </div>
                </body>
                <?php
            }
        } else {
            ?>
            <body onLoad='printpage();
                history.back()'>          
                <div   style="width:90%; 
                       margin:0 auto; 
                       margin-top: 50px; 
                       margin-bottom: 5px;
                       font-family: Verdana, Arial, Helvetica, sans-serif;
                       font-size: 30px;text-align:center;"><?php echo $NomeMat ?>
                </div>
                <div  id="barcode" style="text-align:center">
                    <img  src="/CloudFab/object/barcode/barcode.php?Codice=<?php echo $CodMov ?>" alt="barcode" />

                </div>
            </body>
        <?php }
        ?>





</html>
