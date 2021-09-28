<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    
    <?php
   //############## GESTIONE UTENTI ############################################
    $elencoFunzioni = array("91","92");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);
    ?>    
    <body onLoad="<?php echo $actionOnLoad ?>">    
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_bolla.php');
            include('../sql/script_macchina.php');

            if (isset($_GET['IdMacchina']))
                $_SESSION['IdMacchina'] = $_GET['IdMacchina'];

            $_SESSION['CodProdotto'] = "";
            $_SESSION['Prodotto'] = "";
            $_SESSION['CodKit'] = "";
            $_SESSION['CodLotto'] = "";
            $_SESSION['Ddt'] = "";
            $_SESSION['DtDdt'] = "";

            $_SESSION['CodProdottoList'] = "";
            $_SESSION['ProdottoList'] = "";
            $_SESSION['CodKitList'] = "";
            $_SESSION['CodLottoList'] = "";
            $_SESSION['DdtList'] = "";
            $_SESSION['DtDdtList'] = "";

            if (isset($_POST['CodProdotto'])) {
                $_SESSION['CodProdotto'] = trim($_POST['CodProdotto']);
            }
            if (isset($_POST['CodProdottoList']) AND $_POST['CodProdottoList'] != "") {
                $_SESSION['CodProdotto'] = trim($_POST['CodProdottoList']);
            }
            if (isset($_POST['Prodotto'])) {
                $_SESSION['Prodotto'] = trim($_POST['Prodotto']);
            }
            if (isset($_POST['ProdottoList']) AND $_POST['ProdottoList'] != "") {
                $_SESSION['Prodotto'] = trim($_POST['ProdottoList']);
            }
            if (isset($_POST['CodKit'])) {
                $_SESSION['CodKit'] = trim($_POST['CodKit']);
            }
            if (isset($_POST['CodKitList']) AND $_POST['CodKitList'] != "") {
                $_SESSION['CodKit'] = trim($_POST['CodKitList']);
            }
            if (isset($_POST['CodLotto'])) {
                $_SESSION['CodLotto'] = trim($_POST['CodLotto']);
            }
            if (isset($_POST['CodLottoList']) AND $_POST['CodLottoList'] != "") {
                $_SESSION['CodLotto'] = trim($_POST['CodLottoList']);
            }
            if (isset($_POST['Ddt'])) {
                $_SESSION['Ddt'] = trim($_POST['Ddt']);
            }
            if (isset($_POST['DdtList']) AND $_POST['DdtList'] != "") {
                $_SESSION['Ddt'] = trim($_POST['DdtList']);
            }
            if (isset($_POST['DtDdt'])) {
                $_SESSION['DtDdt'] = trim($_POST['DtDdt']);
            }
            if (isset($_POST['DtDdtList']) AND $_POST['DtDdtList'] != "") {
                $_SESSION['DtDdt'] = trim($_POST['DtDdtList']);
            }

            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #################
            $_SESSION['Filtro'] = "b.dt_bolla";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }

            begin();
            $KitTotali = "";
            $DescriStab = "";
            if (isSet($_SESSION['IdMacchina']) AND $_SESSION['IdMacchina'] != "") {
                $sql = selectMagOriByIdMac($_SESSION['Filtro'],$_SESSION['IdMacchina'],$_SESSION['CodProdotto'],
                        $_SESSION['Prodotto'],$_SESSION['CodKit'], $_SESSION['CodLotto'],$_SESSION['Ddt'],$_SESSION['DtDdt']);
                $KitTotali = mysql_num_rows($sql);

                $sqlMac = findMacchinaById($_SESSION['IdMacchina']);
                while ($rowStab = mysql_fetch_array($sqlMac)) {
                    $DescriStab = $rowStab['descri_stab'];
                }
            }
            commit();
            
            include('./moduli/visualizza_magazzino_stab.php');
            
            ?>

        </div>

    </body>
</html>
