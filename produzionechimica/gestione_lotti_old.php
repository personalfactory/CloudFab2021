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
include('../include/funzioni.php'); 
include('../Connessioni/serverdb.php');
include('../sql/script.php');
include('../sql/script_lotto_artico.php');
    
ini_set(display_errors, "1");

            $_SESSION['Listino'] = "";
            $_SESSION['Codice'] = "";
            $_SESSION['Descri'] = "";
            $_SESSION['Costo'] = "";
            $_SESSION['Giacenza'] = "";
            $_SESSION['ScortaMinima'] = "";
            $_SESSION['DtAbilitato'] = "";
                        
            $_SESSION['ListinoList'] = "";
            $_SESSION['CodiceList'] = "";
            $_SESSION['DescriList'] = "";
            $_SESSION['CostoList'] = "";
            $_SESSION['GiacenzaList'] = "";
            $_SESSION['ScortaMinimaList'] = "";
            $_SESSION['DtAbilitatoList'] = "";

            
            if (isset($_POST['Listino'])) {
                $_SESSION['Listino'] = trim($_POST['Listino']);
            }
            if (isset($_POST['ListinoList']) AND $_POST['ListinoList']!="") {
                $_SESSION['Listino'] = trim($_POST['ListinoList']);
            }
            if (isset($_POST['Codice'])) {
                $_SESSION['Codice'] = trim($_POST['Codice']);
            }
            if (isset($_POST['CodiceList']) AND $_POST['CodiceList']!="") {
                $_SESSION['Codice'] = trim($_POST['CodiceList']);
            }
            if (isset($_POST['Descri'])) {
                $_SESSION['Descri'] = trim($_POST['Descri']);
            }
            if (isset($_POST['DescriList']) AND $_POST['DescriList']!="") {
                $_SESSION['Descri'] = trim($_POST['DescriList']);
            }
            if (isset($_POST['Costo'])) {
                $_SESSION['Costo'] = trim($_POST['Costo']);
            }
            if (isset($_POST['CostoList']) AND $_POST['CostoList']!="") {
                $_SESSION['Costo'] = trim($_POST['CostoList']);
            }
            if (isset($_POST['ScortaMinima'])) {
                $_SESSION['ScortaMinima'] = trim($_POST['ScortaMinima']);
            }
            if (isset($_POST['ScortaMinimaList']) AND $_POST['ScortaMinimaList']!="") {
                $_SESSION['ScortaMinima'] = trim($_POST['ScortaMinimaList']);
            }
            if (isset($_POST['Giacenza'])) {
                $_SESSION['Giacenza'] = trim($_POST['Giacenza']);
            }
            if (isset($_POST['GiacenzaList']) AND $_POST['GiacenzaList']!="") {
                $_SESSION['Giacenza'] = trim($_POST['GiacenzaList']);
            }
            if (isset($_POST['DtAbilitato'])) {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
            }
            if (isset($_POST['DtAbilitatoList']) AND $_POST['DtAbilitatoList']!="") {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitatoList']);
            }
            
            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #######################
            $_SESSION['Filtro'] = "codice";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }


begin();
$sql = selectLottoArticoByFiltri($_SESSION['Filtro'],"codice",$_SESSION['Codice'], 
    $_SESSION['Descri'], $_SESSION['Listino'],$_SESSION['Costo'],$_SESSION['Giacenza'],
    $_SESSION['ScortaMinima'],$_SESSION['DtAbilitato']);
        
     
$sqlListino=selectLottoArticoByFiltri("listino","listino",$_SESSION['Codice'], 
        $_SESSION['Descri'], $_SESSION['Listino'],$_SESSION['Costo'],$_SESSION['Giacenza'],
        $_SESSION['ScortaMinima'],$_SESSION['DtAbilitato']);
$sqlCodice=selectLottoArticoByFiltri("codice","codice",$_SESSION['Codice'], 
        $_SESSION['Descri'], $_SESSION['Listino'],$_SESSION['Costo'],$_SESSION['Giacenza'],
        $_SESSION['ScortaMinima'],$_SESSION['DtAbilitato']);
$sqlDescri=selectLottoArticoByFiltri("descri","descri",$_SESSION['Codice'], 
        $_SESSION['Descri'], $_SESSION['Listino'],$_SESSION['Costo'],$_SESSION['Giacenza'],
        $_SESSION['ScortaMinima'],$_SESSION['DtAbilitato']);
$sqlCosto=selectLottoArticoByFiltri("costo","costo",$_SESSION['Codice'], 
        $_SESSION['Descri'], $_SESSION['Listino'],$_SESSION['Costo'],$_SESSION['Giacenza'],
        $_SESSION['ScortaMinima'],$_SESSION['DtAbilitato']);
$sqlGiac=selectLottoArticoByFiltri("giacenza_attuale","giacenza_attuale",$_SESSION['Codice'], 
        $_SESSION['Descri'], $_SESSION['Listino'],$_SESSION['Costo'],$_SESSION['Giacenza'],
        $_SESSION['ScortaMinima'],$_SESSION['DtAbilitato']);
$sqlScortaMinima=selectLottoArticoByFiltri("scorta_minima","scorta_minima",$_SESSION['Codice'], 
        $_SESSION['Descri'], $_SESSION['Listino'],$_SESSION['Costo'],$_SESSION['Giacenza'],
        $_SESSION['ScortaMinima'],$_SESSION['DtAbilitato']);
$sqlDtAbil=selectLottoArticoByFiltri("dt_abilitato","dt_abilitato",$_SESSION['Codice'], 
        $_SESSION['Descri'], $_SESSION['Listino'],$_SESSION['Costo'],$_SESSION['Giacenza'],
        $_SESSION['ScortaMinima'],$_SESSION['DtAbilitato']);

commit();
$trovati = mysql_num_rows($sql);

include('./moduli/visualizza_lotti.php');?>

</div>
</body>
</html>
