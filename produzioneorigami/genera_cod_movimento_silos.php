<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php // include('../include/header.php');
            include("/var/www/CloudFab/lingue/gestore.php");
        ?>
    </head>
    <script>
        function printpage()
        {
            window.print()
        }
    </script>
    <?php
      
    ini_set("display_errors", "1");
    
    $NomeComp = $_GET['NomeComp'];
    $CodMov=$_GET['CodiceIngressoComp'];
    
    
    ?>
       
            <body onLoad='printpage(); history.back()'>          
                <div style="width:90%; 
                       margin:0 auto; 
                       margin-top: 50px; 
                       margin-bottom: 10px;
                       font-family: Verdana, Arial, Helvetica, sans-serif;
                       font-size: 20px;text-align:center;"><?php echo $NomeComp ?>
                </div>
                <div  id="barcode" style="text-align:center;">
                    <img  src="/CloudFab/object/barcode/barcode.php?Codice=<?php echo $CodMov ?>" alt="barcode" />
                </div>
            </body>
       
</html>
