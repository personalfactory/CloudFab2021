<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_gaz_movmag.php');

             if($DEBUG) ini_set("display_errors", "1");
            
            //Calcolo l'anno ed il mese corrente
             $now = getdate();
            $annoCorrente = $now["year"];
            $meseCorrente = $now["mon"];
            if ($meseCorrente < 10) {
                $meseCorrente = "0" . $meseCorrente;
            }
            $_SESSION['NumDoc'] = "";
            $_SESSION['DtDoc'] = "";
            $_SESSION['DescriStab'] = "";
            $_SESSION['Artico'] = "";
            $_SESSION['DescriArtico'] = "";
            $_SESSION['Quantita'] = "";
            $_SESSION['DtMov'] = $annoCorrente."-".$meseCorrente;


            $_SESSION['NumDocList'] = "";
            $_SESSION['DtDocList'] = "";
            $_SESSION['DescriStabList'] = "";
            $_SESSION['ArticoList'] = "";
            $_SESSION['DescriArticoList'] = "";
            $_SESSION['QuantitaList'] = "";
            $_SESSION['DtMovList'] = "";


            if (isset($_POST['TipDoc'])) {
                $_SESSION['TipDoc'] = trim($_POST['TipDoc']);
            }
            if (isset($_POST['TipDocList']) AND $_POST['TipDocList'] != "") {
                $_SESSION['TipDoc'] = trim($_POST['TipDocList']);
            }
            if (isset($_POST['NumDoc'])) {
                $_SESSION['NumDoc'] = trim($_POST['NumDoc']);
            }
            if (isset($_POST['NumDocList']) AND $_POST['NumDocList'] != "") {
                $_SESSION['NumDoc'] = trim($_POST['NumDocList']);
            }
            if (isset($_POST['DtDoc'])) {
                $_SESSION['DtDoc'] = trim($_POST['DtDoc']);
            }
            if (isset($_POST['DtDocList']) AND $_POST['DtDocList'] != "") {
                $_SESSION['DtDoc'] = trim($_POST['DtDocList']);
            }
            if (isset($_POST['Artico'])) {
                $_SESSION['Artico'] = trim($_POST['Artico']);
            }
            if (isset($_POST['ArticoList']) AND $_POST['ArticoList'] != "") {
                $_SESSION['Artico'] = trim($_POST['ArticoList']);
            }
            if (isset($_POST['DescriArtico'])) {
                $_SESSION['DescriArtico'] = trim($_POST['DescriArtico']);
            }
            if (isset($_POST['DescriArticoList']) AND $_POST['DescriArticoList'] != "") {
                $_SESSION['DescriArtico'] = trim($_POST['DescriArticoList']);
            }
            if (isset($_POST['DescriStab'])) {
                $_SESSION['DescriStab'] = trim($_POST['DescriStab']);
            }
            if (isset($_POST['DescriStabList']) AND $_POST['DescriStabList'] != "") {
                $_SESSION['DescriStab'] = trim($_POST['DescriStabList']);
            }
            if (isset($_POST['DtMov'])) {
                $_SESSION['DtMov'] = trim($_POST['DtMov']);
            }
            if (isset($_POST['DtMovList']) AND $_POST['DtMovList'] != "") {
                $_SESSION['DtMov'] = trim($_POST['DtMovList']);
            }


            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #######################
            $_SESSION['Filtro'] = "id_mov";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }

            begin();
            $sql = findMovJoinBollaByFiltri($_SESSION['Filtro'], "id_mov", $valCatMerLotti, $valTipoDocDdtVen, $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['DescriStab'], $_SESSION['Artico'], $_SESSION['DescriArtico'], $_SESSION['Quantita'], $_SESSION['DtMov']);

            
            $sqlNumDoc = findMovJoinBollaByFiltri("num_doc", "num_doc", $valCatMerLotti, $valTipoDocDdtVen, $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['DescriStab'], $_SESSION['Artico'], $_SESSION['DescriArtico'], $_SESSION['Quantita'], $_SESSION['DtMov']);
            $sqlDtDoc = findMovJoinBollaByFiltri("dt_doc", "dt_doc", $valCatMerLotti, $valTipoDocDdtVen, $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['DescriStab'], $_SESSION['Artico'], $_SESSION['DescriArtico'], $_SESSION['Quantita'], $_SESSION['DtMov']);
            $sqlDesStab = findMovJoinBollaByFiltri("descri_stab", "descri_stab", $valCatMerLotti, $valTipoDocDdtVen, $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['DescriStab'], $_SESSION['Artico'], $_SESSION['DescriArtico'], $_SESSION['Quantita'], $_SESSION['DtMov']);
            $sqlArticolo = findMovJoinBollaByFiltri("artico", "artico", $valCatMerLotti, $valTipoDocDdtVen, $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['DescriStab'], $_SESSION['Artico'], $_SESSION['DescriArtico'], $_SESSION['Quantita'], $_SESSION['DtMov']);
            $sqlDescriArt = findMovJoinBollaByFiltri("descri_artico", "descri_artico", $valCatMerLotti, $valTipoDocDdtVen, $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['DescriStab'], $_SESSION['Artico'], $_SESSION['DescriArtico'], $_SESSION['Quantita'], $_SESSION['DtMov']);
            $sqlQta = findMovJoinBollaByFiltri("quanti", "quanti", $valCatMerLotti, $valTipoDocDdtVen, $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['DescriStab'], $_SESSION['Artico'], $_SESSION['DescriArtico'], $_SESSION['Quantita'], $_SESSION['DtMov']);
            $sqlDtMov = findMovJoinBollaByFiltri("dt_mov", "dt_mov", $valCatMerLotti, $valTipoDocDdtVen, $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['DescriStab'], $_SESSION['Artico'], $_SESSION['DescriArtico'], $_SESSION['Quantita'], $_SESSION['DtMov']);
            commit();


            $trovati = mysql_num_rows($sql);
            include('./moduli/visualizza_bolle.php');
            ?>

        </div>
    </body>
</html>
