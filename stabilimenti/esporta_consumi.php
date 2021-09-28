<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); 
        
        $arrayMsgErrPhp = array($msgErrDataInfNonValida,$msgErrDataSupNonValida);
        
        $IdMacchina=$_GET['IdMacchina'];
        ?>
    </head>
    <script language="javascript" type="text/javascript">

        

function EsportaExcelSintesi() {
        document.forms["EsportaConsumi"].action = "download_excel_sintesi_consumi.php?IdMacchina=<?php echo $IdMacchina ?>";
        document.forms["EsportaConsumi"].submit();
    }
    
    function EsportaExcelDettaglio() {
        document.forms["EsportaConsumi"].action = "download_excel_dettaglio_consumi.php?IdMacchina=<?php echo $IdMacchina ?>";
        document.forms["EsportaConsumi"].submit();
    }
    
    function controllaData(arrayMsgErrJs) {

        var rv = true;
        var msg = "";

        if (!isValidDate(document.getElementById('DataInf').value)) {
            rv = false;
            msg = msg + ' ' + arrayMsgErrJs[0];
        }
        if (!isValidDate(document.getElementById('DataSup').value)) {
            rv = false;
            msg = msg + ' ' + arrayMsgErrJs[1];
        }
        
        if (!rv) {
            alert(msg);
            rv = false;
        }
        return rv;
    }
    </script>
    
    <?php
    
    if ($DEBUG)
        ini_set('display_errors', 1);
    //############ GESTIONE UTENTI #############################################
    
    ?>

    <body>
        <div id="mainContainer">
            <?php include('../include/menu.php'); ?>
            <div align="center" style="margin-top:10%">
    <form id="EsportaConsumi" name="EsportaConsumi" method="Post"  onsubmit="return controllaData(arrayMsgErrJs)" >
       
        <table style="font-size:20px; width:50%;">
            <tr>
                <td class="cella2" colspan='2'><?php echo $filtroPeriodoRifConsumi ?></td>
            </tr>
            <tr>
                <td class="cella1">
                    <?php echo $filtroDal ?>
                    <input style="width:30%;font-size:20px" type="text" name="DataInf" id="DataInf" placeholder="yyyy-mm-dd"/>
                    <?php echo $filtroAl ?>
                    <input style="width:30%;font-size:20px" type="text" name="DataSup" id="DataSup" placeholder="yyyy-mm-dd"/>&nbsp;
                </td>
                </tr>
            <tr>
                <td class="cella1" style="text-align:right">
                    <input type="button"  onClick="EsportaExcelSintesi()" value="<?php echo $valueEsportaSintesiConsumi?>" />
                    <input type="button"  onClick="EsportaExcelDettaglio()" value="<?php echo $valueEsportaDettaglioConsumi?>" />
                </td>
            </tr>
        </table>
    </form>
</div>
           
        </div><!--mainContainer-->

    </body>
</html>
