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
            include('../sql/script_miscela.php');

             if($DEBUG) ini_set("display_errors", "1");

            $_SESSION['IdMiscela'] = "";
            $_SESSION['CodFormula'] = "";
            $_SESSION['Descrizione'] = "";
            $_SESSION['Contenitore'] = "";
            $_SESSION['DtMiscela'] = "";
            $_SESSION['PesoReale'] = "";
            
            $_SESSION['OreLavoro'] = "";

            $_SESSION['IdMiscelaList'] = "";
            $_SESSION['CodFormulaList'] = "";
            $_SESSION['DescrizioneList'] = "";
            $_SESSION['ContenitoreList'] = "";
            $_SESSION['DtMiscelaList'] = "";
            $_SESSION['PesoRealeList'] = "";


            if (isset($_POST['IdMiscela'])) {
                $_SESSION['IdMiscela'] = trim($_POST['IdMiscela']);
            }
            if (isset($_POST['IdMiscelaList']) AND $_POST['IdMiscelaList'] != "") {
                $_SESSION['IdMiscela'] = trim($_POST['IdMiscelaList']);
            }
            if (isset($_POST['CodFormula'])) {
                $_SESSION['CodFormula'] = trim($_POST['CodFormula']);
            }
            if (isset($_POST['CodFormulaList']) AND $_POST['CodFormulaList'] != "") {
                $_SESSION['CodFormula'] = trim($_POST['CodFormulaList']);
            }
            if (isset($_POST['Descrizione'])) {
                $_SESSION['Descrizione'] = trim($_POST['Descrizione']);
            }
            if (isset($_POST['DescrizioneList']) AND $_POST['DescrizioneList'] != "") {
                $_SESSION['Descrizione'] = trim($_POST['DescrizioneList']);
            }
            if (isset($_POST['Contenitore'])) {
                $_SESSION['Contenitore'] = trim($_POST['Contenitore']);
            }
            if (isset($_POST['ContenitoreList']) AND $_POST['ContenitoreList'] != "") {
                $_SESSION['Contenitore'] = trim($_POST['ContenitoreList']);
            }
            if (isset($_POST['DtMiscela'])) {
                $_SESSION['DtMiscela'] = trim($_POST['DtMiscela']);
            }
            if (isset($_POST['DtMiscelaList']) AND $_POST['DtMiscelaList'] != "") {
                $_SESSION['DtMiscela'] = trim($_POST['DtMiscelaList']);
            }
            if (isset($_POST['PesoReale'])) {
                $_SESSION['PesoReale'] = trim($_POST['PesoReale']);
            }
            if (isset($_POST['PesoRealeList']) AND $_POST['PesoRealeList'] != "") {
                $_SESSION['PesoReale'] = trim($_POST['PesoRealeList']);
            }
            if (isset($_POST['OreLavoro'])) {
                $_SESSION['OreLavoro'] = trim($_POST['OreLavoro']);
            }
            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #######################
            $_SESSION['Filtro'] = "id_miscela";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }

            begin();
            $sql = findMiscelaByFiltri($_SESSION['Filtro'], "id_miscela", $_SESSION['IdMiscela'], $_SESSION['CodFormula'], $_SESSION['Descrizione'], $_SESSION['Contenitore'], $_SESSION['DtMiscela'], $_SESSION['PesoReale']);
            $sqlId = findMiscelaByFiltri("id_miscela", "id_miscela", $_SESSION['IdMiscela'], $_SESSION['CodFormula'], $_SESSION['Descrizione'], $_SESSION['Contenitore'], $_SESSION['DtMiscela'], $_SESSION['PesoReale']);
            $sqlCodFor = findMiscelaByFiltri("m.cod_formula", "m.cod_formula", $_SESSION['IdMiscela'], $_SESSION['CodFormula'], $_SESSION['Descrizione'], $_SESSION['Contenitore'], $_SESSION['DtMiscela'], $_SESSION['PesoReale']);
            $sqlDescri = findMiscelaByFiltri("descri_formula", "descri_formula", $_SESSION['IdMiscela'], $_SESSION['CodFormula'], $_SESSION['Descrizione'], $_SESSION['Contenitore'], $_SESSION['DtMiscela'], $_SESSION['PesoReale']);
            $sqlCont = findMiscelaByFiltri("cod_contenitore", "cod_contenitore", $_SESSION['IdMiscela'], $_SESSION['CodFormula'], $_SESSION['Descrizione'], $_SESSION['Contenitore'], $_SESSION['DtMiscela'], $_SESSION['PesoReale']);
            $sqlPeso = findMiscelaByFiltri("peso_reale", "peso_reale", $_SESSION['IdMiscela'], $_SESSION['CodFormula'], $_SESSION['Descrizione'], $_SESSION['Contenitore'], $_SESSION['DtMiscela'], $_SESSION['PesoReale']);
            $sqlDt = findMiscelaByFiltri("dt_miscela", "dt_miscela", $_SESSION['IdMiscela'], $_SESSION['CodFormula'], $_SESSION['Descrizione'], $_SESSION['Contenitore'], $_SESSION['DtMiscela'], $_SESSION['PesoReale']);

            $sqlPesoTot = findSumQtaMiscelaByFiltri($_SESSION['Filtro'], "id_miscela", $_SESSION['IdMiscela'], $_SESSION['CodFormula'], $_SESSION['Descrizione'], $_SESSION['Contenitore'], $_SESSION['DtMiscela'], $_SESSION['PesoReale']);

            $trovati = mysql_num_rows($sql);

            $QtaTotPeso = 0;
            $rowQtaTot = mysql_fetch_row($sqlPesoTot);
            $QtaTotPeso = $rowQtaTot[0];

            $produttivita = 0;
            if (isSet($_SESSION['OreLavoro']) AND is_numeric($_SESSION['OreLavoro'])) {
                $produttivita = number_format(($QtaTotPeso / $fatConvKgGrammi) / $_SESSION['OreLavoro'], $PrecisioneQta, '.', ' ');
            }

            include('./moduli/visualizza_miscela.php');
            ?>

        </div>
    </body>
</html>
