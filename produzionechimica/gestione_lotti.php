<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
    
<?php  if ($DEBUG) ini_set('display_errors', '1');

//############# VERIFICA PERMESSO VISUALIZZAZIONE LISTA ####################
    $actionOnLoad = "";
    $elencoFunzioni = array( "3");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);
    ?>
      
<body onLoad="<?php echo $actionOnLoad ?>">
<div id="mainContainer"><?php include('../include/menu.php'); ?></div>
<?php 
include('../include/funzioni.php'); 
include('../include/precisione.php'); 
include('../Connessioni/serverdb.php');
include('../sql/script.php');
include('../sql/script_lotto_artico.php');
include('../sql/script_formula.php');
include('../sql/script_prodotto.php');
include('../sql/script_lotto.php');
    

            $_SESSION['Listino'] = "";
            $_SESSION['Codice'] = "";
            $_SESSION['Descri'] = "";
            $_SESSION['NumKit'] = "";
            $_SESSION['QtaKit'] = "";
            $_SESSION['PesoLotto'] = "";
            $_SESSION['Costo'] = "";
            $_SESSION['Giacenza'] = "";
            $_SESSION['ScortaMinima'] = "";
            $_SESSION['DtAbilitato'] = "";
                        
            $_SESSION['ListinoList'] = "";
            $_SESSION['CodiceList'] = "";
            $_SESSION['DescriList'] = "";
            $_SESSION['NumKitList'] = "";
            $_SESSION['QtaKitList'] = "";
            $_SESSION['PesoLottoList'] = "";
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
            if (isset($_POST['NumKit'])) {
                $_SESSION['NumKit'] = trim($_POST['NumKit']);
            }
            if (isset($_POST['NumKitList']) AND $_POST['NumKitList']!="") {
                $_SESSION['NumKit'] = trim($_POST['NumKitList']);
            }
            if (isset($_POST['QtaKit'])) {
                $_SESSION['QtaKit'] = trim($_POST['QtaKit']);
            }
            if (isset($_POST['QtaKitList']) AND $_POST['QtaKitList']!="") {
                $_SESSION['QtaKit'] = trim($_POST['QtaKitList']);
            }
            if (isset($_POST['PesoLotto'])) {
                $_SESSION['PesoLotto'] = trim($_POST['PesoLotto']);
            }
            if (isset($_POST['PesoLottoList']) AND $_POST['PesoLottoList']!="") {
                $_SESSION['PesoLotto'] = trim($_POST['PesoLottoList']);
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
    $_SESSION['ScortaMinima'],$_SESSION['NumKit'],$_SESSION['QtaKit'],$_SESSION['PesoLotto'],$_SESSION['DtAbilitato']);
        
     
$sqlListino=selectLottoArticoByFiltri("listino","listino",$_SESSION['Codice'], 
        $_SESSION['Descri'], $_SESSION['Listino'],$_SESSION['Costo'],$_SESSION['Giacenza'],
        $_SESSION['ScortaMinima'],$_SESSION['NumKit'],$_SESSION['QtaKit'],$_SESSION['PesoLotto'],$_SESSION['DtAbilitato']);
$sqlCodice=selectLottoArticoByFiltri("codice","codice",$_SESSION['Codice'], 
        $_SESSION['Descri'], $_SESSION['Listino'],$_SESSION['Costo'],$_SESSION['Giacenza'],
        $_SESSION['ScortaMinima'],$_SESSION['NumKit'],$_SESSION['QtaKit'],$_SESSION['PesoLotto'],$_SESSION['DtAbilitato']);
$sqlDescri=selectLottoArticoByFiltri("descri","descri",$_SESSION['Codice'], 
        $_SESSION['Descri'], $_SESSION['Listino'],$_SESSION['Costo'],$_SESSION['Giacenza'],
        $_SESSION['ScortaMinima'],$_SESSION['NumKit'],$_SESSION['QtaKit'],$_SESSION['PesoLotto'],$_SESSION['DtAbilitato']);
$sqlNumKit=selectLottoArticoByFiltri("num_sac_in_lotto","num_sac_in_lotto",$_SESSION['Codice'], 
        $_SESSION['Descri'], $_SESSION['Listino'],$_SESSION['Costo'],$_SESSION['Giacenza'],
        $_SESSION['ScortaMinima'],$_SESSION['NumKit'],$_SESSION['QtaKit'],$_SESSION['PesoLotto'],$_SESSION['DtAbilitato']);
$sqlQtaKit=selectLottoArticoByFiltri("qta_sac","qta_sac",$_SESSION['Codice'], 
        $_SESSION['Descri'], $_SESSION['Listino'],$_SESSION['Costo'],$_SESSION['Giacenza'],
        $_SESSION['ScortaMinima'],$_SESSION['NumKit'],$_SESSION['QtaKit'],$_SESSION['PesoLotto'],$_SESSION['DtAbilitato']);
$sqlPesoLotto=selectLottoArticoByFiltri("qta_lotto","qta_lotto",$_SESSION['Codice'], 
        $_SESSION['Descri'], $_SESSION['Listino'],$_SESSION['Costo'],$_SESSION['Giacenza'],
        $_SESSION['ScortaMinima'],$_SESSION['NumKit'],$_SESSION['QtaKit'],$_SESSION['PesoLotto'],$_SESSION['DtAbilitato']);
$sqlCosto=selectLottoArticoByFiltri("costo","costo",$_SESSION['Codice'], 
        $_SESSION['Descri'], $_SESSION['Listino'],$_SESSION['Costo'],$_SESSION['Giacenza'],
        $_SESSION['ScortaMinima'],$_SESSION['NumKit'],$_SESSION['QtaKit'],$_SESSION['PesoLotto'],$_SESSION['DtAbilitato']);
$sqlGiac=selectLottoArticoByFiltri("giacenza_attuale","giacenza_attuale",$_SESSION['Codice'], 
        $_SESSION['Descri'], $_SESSION['Listino'],$_SESSION['Costo'],$_SESSION['Giacenza'],
        $_SESSION['ScortaMinima'],$_SESSION['NumKit'],$_SESSION['QtaKit'],$_SESSION['PesoLotto'],$_SESSION['DtAbilitato']);
$sqlScortaMinima=selectLottoArticoByFiltri("scorta_minima","scorta_minima",$_SESSION['Codice'], 
        $_SESSION['Descri'], $_SESSION['Listino'],$_SESSION['Costo'],$_SESSION['Giacenza'],
        $_SESSION['ScortaMinima'],$_SESSION['NumKit'],$_SESSION['QtaKit'],$_SESSION['PesoLotto'],$_SESSION['DtAbilitato']);
$sqlDtAbil=selectLottoArticoByFiltri("l.dt_abilitato","l.dt_abilitato",$_SESSION['Codice'], 
        $_SESSION['Descri'], $_SESSION['Listino'],$_SESSION['Costo'],$_SESSION['Giacenza'],
        $_SESSION['ScortaMinima'],$_SESSION['NumKit'],$_SESSION['QtaKit'],$_SESSION['PesoLotto'],$_SESSION['DtAbilitato']);

commit();
$trovati = mysql_num_rows($sql);

include('./moduli/visualizza_lotti.php');?>


</body>
</html>
