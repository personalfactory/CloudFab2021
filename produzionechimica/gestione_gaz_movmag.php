<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <?php
   // funzione 145 : creare un nuovo movimento di magazzino
    $elencoFunzioni = array("145");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);
    
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_gaz_movmag.php');
            include('../sql/script.php');
            include('../include/precisione.php');

            if($DEBUG) ini_set('display_errors', "1");
            
            //Calcolo l'anno ed il mese corrente
             $now = getdate();
            $annoCorrente = $now["year"];
            $meseCorrente = $now["mon"];
            if ($meseCorrente < 10) {
                $meseCorrente = "0" . $meseCorrente;
            }
            
            $_SESSION['IdMov']="";
            $_SESSION['Causale'] = "";
            $_SESSION['TipDoc'] = "";
            $_SESSION['NumDoc'] = "";
            $_SESSION['DtDoc'] = "";
            $_SESSION['Artico'] = "";
            $_SESSION['DescriArtico'] = "";
            $_SESSION['Quantita'] = "";
            $_SESSION['DtMov'] = $annoCorrente . "-" . $meseCorrente;
            
            $_SESSION['IdMovList']="";
            $_SESSION['CausaleList'] = "";
            $_SESSION['TipDocList'] = "";
            $_SESSION['NumDocList'] = "";
            $_SESSION['DtDocList'] = "";
            $_SESSION['ArticoList'] = "";
            $_SESSION['DescriArticoList'] = "";
            $_SESSION['QuantitaList'] = "";
            $_SESSION['DtMovList'] = "";
            
            
            if (isset($_POST['IdMov'])) {
                $_SESSION['IdMov'] = trim($_POST['IdMov']);
            }
            if (isset($_POST['IdMovList']) AND $_POST['IdMovList'] != "") {
                $_SESSION['IdMov'] = trim($_POST['IdMovList']);
            }

            if (isset($_POST['Causale'])) {
                $_SESSION['Causale'] = trim($_POST['Causale']);
            }
            if (isset($_POST['CausaleList']) AND $_POST['CausaleList'] != "") {
                $_SESSION['Causale'] = trim($_POST['CausaleList']);
            }
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
            if (isset($_POST['Quantita'])) {
                $_SESSION['Quantita'] = trim($_POST['Quantita']);
            }
            if (isset($_POST['QuantitaList']) AND $_POST['QuantitaList'] != "") {
                $_SESSION['Quantita'] = trim($_POST['QuantitaList']);
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


            //#######################################################################

            begin();
            $sql = selectGazMovMagByFiltri($_SESSION['Filtro'], "id_mov", $_SESSION['Causale'], $_SESSION['TipDoc'], $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['Artico'], $_SESSION['DescriArtico'], $valCatMerMatPrime, $_SESSION['Quantita'], $_SESSION['DtMov']);
            $sqlIdMov = selectGazMovMagByFiltri("id_mov", "id_mov", $_SESSION['Causale'], $_SESSION['TipDoc'], $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['Artico'], $_SESSION['DescriArtico'], $valCatMerMatPrime, $_SESSION['Quantita'], $_SESSION['DtMov']);
            $sqlCausale = selectGazMovMagByFiltri("causale", "causale", $_SESSION['Causale'], $_SESSION['TipDoc'], $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['Artico'], $_SESSION['DescriArtico'], $valCatMerMatPrime, $_SESSION['Quantita'], $_SESSION['DtMov']);
            $sqlTipDoc = selectGazMovMagByFiltri("tip_doc", "tip_doc", $_SESSION['Causale'], $_SESSION['TipDoc'], $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['Artico'], $_SESSION['DescriArtico'], $valCatMerMatPrime, $_SESSION['Quantita'], $_SESSION['DtMov']);
            $sqlNumDoc = selectGazMovMagByFiltri("num_doc", "num_doc", $_SESSION['Causale'], $_SESSION['TipDoc'], $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['Artico'], $_SESSION['DescriArtico'], $valCatMerMatPrime, $_SESSION['Quantita'], $_SESSION['DtMov']);
            $sqlDtDoc = selectGazMovMagByFiltri("dt_doc", "dt_doc", $_SESSION['Causale'], $_SESSION['TipDoc'], $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['Artico'], $_SESSION['DescriArtico'], $valCatMerMatPrime, $_SESSION['Quantita'], $_SESSION['DtMov']);
            $sqlArticolo = selectGazMovMagByFiltri("artico", "artico", $_SESSION['Causale'], $_SESSION['TipDoc'], $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['Artico'], $_SESSION['DescriArtico'], $valCatMerMatPrime, $_SESSION['Quantita'], $_SESSION['DtMov']);
            $sqlDescriArt = selectGazMovMagByFiltri("descri_artico", "descri_artico", $_SESSION['Causale'], $_SESSION['TipDoc'], $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['Artico'], $_SESSION['DescriArtico'], $valCatMerMatPrime, $_SESSION['Quantita'], $_SESSION['DtMov']);
            $sqlQta = selectGazMovMagByFiltri("quanti", "quanti", $_SESSION['Causale'], $_SESSION['TipDoc'], $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['Artico'], $_SESSION['DescriArtico'], $valCatMerMatPrime, $_SESSION['Quantita'], $_SESSION['DtMov']);
            $sqlDtMov = selectGazMovMagByFiltri("dt_mov", "dt_mov", $_SESSION['Causale'], $_SESSION['TipDoc'], $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['Artico'], $_SESSION['DescriArtico'], $valCatMerMatPrime, $_SESSION['Quantita'], $_SESSION['DtMov']);

            commit();

            $trovati = mysql_num_rows($sql);

            include('./moduli/visualizza_gaz_movmag.php');
            ?> 

        </div>

    </body>
</html>




