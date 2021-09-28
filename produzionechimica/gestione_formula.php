<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
   
    
    <?php
    if($DEBUG) ini_set('display_errors', 1);
    //##########################################################################            
    //NOTE GESTIONE UTENTI
    //1) Si verifica se l'utente ha il permesso di visualizzare la lista delle formule
    //2) Si verifica se l'utente ha il permesso di visualizzare il dettaglio di una formula
    //3) Si verifica se l'utente ha il persmesso di editare la tabella formula
    //4) Si verifica se l'utente ha il permesso di visualizzare il dettaglio di una formula + prodotto
    //############# VERIFICA PERMESSI ##########################################
    $actionOnLoad="";
    $elencoFunzioni = array("17","18","3","20");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni,$_SESSION['objPermessiVis']);
    //############# STRINGHE UTENTI - AZIENDE VISIBILI###########################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'formula');   
    
    //##########################################################################
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
       
<?php 

include('../include/menu.php'); 
include('../Connessioni/serverdb.php');
include('../sql/script.php');
include('../sql/script_formula.php');
include('../sql/script_lotto_artico.php');
    
            $_SESSION['DtFormula'] = "";
            $_SESSION['CodFormula'] = "";
            $_SESSION['Descrizione'] = "";
            $_SESSION['NumSacInLotto'] = "";
            $_SESSION['NumLotti'] = "";
            $_SESSION['Famiglia'] = "";
            $_SESSION['DtAbilitato'] = "";
                        
            $_SESSION['DtFormulaList'] = "";
            $_SESSION['CodFormulaList'] = "";
            $_SESSION['DescrizioneList'] = "";
            $_SESSION['NumSacInLottoList'] = "";
            $_SESSION['NumLottiList'] = "";
            $_SESSION['FamigliaList'] = "";
            $_SESSION['DtAbilitatoList'] = "";

            
            if (isset($_POST['DtFormula'])) {
                $_SESSION['DtFormula'] = trim($_POST['DtFormula']);
            }
            if (isset($_POST['DtFormulaList']) AND $_POST['DtFormulaList']!="") {
                $_SESSION['DtFormula'] = trim($_POST['DtFormulaList']);
            }
            if (isset($_POST['CodFormula'])) {
                $_SESSION['CodFormula'] = trim($_POST['CodFormula']);
            }
            if (isset($_POST['CodFormulaList']) AND $_POST['CodFormulaList']!="") {
                $_SESSION['CodFormula'] = trim($_POST['CodFormulaList']);
            }
            if (isset($_POST['Descrizione'])) {
                $_SESSION['Descrizione'] = trim($_POST['Descrizione']);
            }
            if (isset($_POST['DescrizioneList']) AND $_POST['DescrizioneList']!="") {
                $_SESSION['Descrizione'] = trim($_POST['DescrizioneList']);
            }
            if (isset($_POST['NumSacInLotto'])) {
                $_SESSION['NumSacInLotto'] = trim($_POST['NumSacInLotto']);
            }
            if (isset($_POST['NumSacInLottoList']) AND $_POST['NumSacInLottoList']!="") {
                $_SESSION['NumSacInLotto'] = trim($_POST['NumSacInLottoList']);
            }
            if (isset($_POST['NumLotti'])) {
                $_SESSION['NumLotti'] = trim($_POST['NumLotti']);
            }
            if (isset($_POST['NumLottiList']) AND $_POST['NumLottiList']!="") {
                $_SESSION['NumLotti'] = trim($_POST['NumLottiList']);
            }            
            if (isset($_POST['Famiglia'])) {
                $_SESSION['Famiglia'] = trim($_POST['Famiglia']);
            }
            if (isset($_POST['FamigliaList']) AND $_POST['FamigliaList']!="") {
                $_SESSION['Famiglia'] = trim($_POST['FamigliaList']);
            }
            if (isset($_POST['DtAbilitato'])) {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
            }
            if (isset($_POST['DtAbilitatoList']) AND $_POST['DtAbilitatoList']!="") {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitatoList']);
            }
            
            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #######################
            $_SESSION['Filtro'] = "cod_formula";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }


begin();
$sql =selectFormuleByFiltri($_SESSION['Filtro'], "cod_formula", 
        $_SESSION['CodFormula'], $_SESSION['Descrizione'], $_SESSION['Famiglia'], 
        $_SESSION['NumLotti'],$_SESSION['NumSacInLotto'], $_SESSION['DtFormula'], $_SESSION['DtAbilitato'],$strUtentiAziende) ;
$sqlFam=selectFormuleByFiltri("descrizione","descrizione",
        $_SESSION['CodFormula'], $_SESSION['Descrizione'], $_SESSION['Famiglia'], 
        $_SESSION['NumLotti'],$_SESSION['NumSacInLotto'],$_SESSION['DtFormula'], $_SESSION['DtAbilitato'],$strUtentiAziende);
$sqlCodFormula=selectFormuleByFiltri("cod_formula", "cod_formula", 
        $_SESSION['CodFormula'], $_SESSION['Descrizione'], $_SESSION['Famiglia'], 
        $_SESSION['NumLotti'],$_SESSION['NumSacInLotto'],$_SESSION['DtFormula'], $_SESSION['DtAbilitato'],$strUtentiAziende);
$sqlDescrizione=selectFormuleByFiltri("descri_formula", "descri_formula", 
        $_SESSION['CodFormula'], $_SESSION['Descrizione'], $_SESSION['Famiglia'], 
        $_SESSION['NumLotti'],$_SESSION['NumSacInLotto'],$_SESSION['DtFormula'], $_SESSION['DtAbilitato'],$strUtentiAziende);
$sqlDtFormula=selectFormuleByFiltri("dt_formula", "cod_formula", 
        $_SESSION['CodFormula'], $_SESSION['Descrizione'], $_SESSION['Famiglia'], 
        $_SESSION['NumLotti'],$_SESSION['NumSacInLotto'],$_SESSION['DtFormula'], $_SESSION['DtAbilitato'],$strUtentiAziende);
$sqlNumSac=selectFormuleByFiltri("num_sac_in_lotto", "num_sac_in_lotto",
        $_SESSION['CodFormula'], $_SESSION['Descrizione'], $_SESSION['Famiglia'], 
        $_SESSION['NumLotti'],$_SESSION['NumSacInLotto'],$_SESSION['DtFormula'], $_SESSION['DtAbilitato'],$strUtentiAziende);
$sqlNumLotti=selectFormuleByFiltri("num_lotti", "num_lotti",
        $_SESSION['CodFormula'], $_SESSION['Descrizione'], $_SESSION['Famiglia'], 
        $_SESSION['NumLotti'],$_SESSION['NumSacInLotto'],$_SESSION['DtFormula'], $_SESSION['DtAbilitato'],$strUtentiAziende);
$sqlDt=selectFormuleByFiltri("dt_abil", "dt_abil", 
        $_SESSION['CodFormula'], $_SESSION['Descrizione'], $_SESSION['Famiglia'], 
        $_SESSION['NumLotti'],$_SESSION['NumSacInLotto'],$_SESSION['DtFormula'], $_SESSION['DtAbilitato'],$strUtentiAziende);
commit();
$trovati = mysql_num_rows($sql);

include('./moduli/visualizza_formula.php');?>
<div id="msgLog">
                <?php
                  if ($DEBUG) {
                        echo "actionOnLoad :" . $actionOnLoad;
                        echo "</br>Tab formula : Nuova stringa unica utenti e aziende visibili : " . $strUtentiAziende;
                    }
                 ?>
            </div>
</div>
</body>
</html>
