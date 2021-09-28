<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>    
    <?php 
    
    //##########################################################################            
    //NOTE GESTIONE UTENTI
    //1) Si verifica se l'utente ha il permesso di visualizzare la lista dei parametri (110)
    //2) Si verifica se l'utente ha il permesso di visualizzare il dettaglio di un parametro (111)
    $elencoFunzioni = array("110", "111");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);
    
    //############# STRINGHE UTENTI - AZIENDE VISIBILI###########################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_parametro'); 
    
    ?>
    
<body onLoad="<?php echo $actionOnLoad ?>">
<div id="labContainer">

<?php 
include('../include/menu.php'); 
include('../Connessioni/serverdb.php');
include('sql/script.php');
include('sql/script_lab_parametro.php');

            
            $_SESSION['Nome'] = "";
            $_SESSION['Descri'] = "";
            $_SESSION['UnMisura'] = "";
            $_SESSION['Tipo'] = "";
            $_SESSION['DtAbilitato'] = "";

            
            $_SESSION['NomeList'] = "";
            $_SESSION['DescriList'] = "";
            $_SESSION['UnMisuraList'] = "";
            $_SESSION['TipoList'] = "";
            $_SESSION['DtAbilitatoList'] = "";

            if (isset($_POST['Tipo'])) {
                $_SESSION['Tipo'] = trim($_POST['Tipo']);
            }
            if (isset($_POST['TipoList']) AND $_POST['TipoList'] != "") {
                $_SESSION['Tipo'] = trim($_POST['TipoList']);
            }
            if (isset($_POST['Nome'])) {
                $_SESSION['Nome'] = trim($_POST['Nome']);
            }
            if (isset($_POST['NomeList']) AND $_POST['NomeList'] != "") {
                $_SESSION['Nome'] = trim($_POST['NomeList']);
            }
            if (isset($_POST['Descri'])) {
                $_SESSION['Descri'] = trim($_POST['Descri']);
            }
            if (isset($_POST['DescriList']) AND $_POST['DescriList'] != "") {
                $_SESSION['Descri'] = trim($_POST['DescriList']);
            }
            if (isset($_POST['UnMisura'])) {
                $_SESSION['UnMisura'] = trim($_POST['UnMisura']);
            }
            if (isset($_POST['UnMisuraList']) AND $_POST['UnMisuraList'] != "") {
                $_SESSION['UnMisura'] = trim($_POST['UnMisuraList']);
            }

            if (isset($_POST['DtAbilitato'])) {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
            }
            if (isset($_POST['DtAbilitatoList']) AND $_POST['DtAbilitatoList'] != "") {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitatoList']);
            }


            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #################
            $_SESSION['Filtro'] = "nome_parametro";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }
            //##################################################################




begin();
$sql = findAllParametriVisByFiltri($_SESSION['Nome'],$_SESSION['Descri'],$_SESSION['UnMisura'],$_SESSION['Tipo'],$_SESSION['DtAbilitato'],$_SESSION['Filtro'],"id_par",$strUtentiAziende);
$sqlNome=findAllParametriVisByFiltri($_SESSION['Nome'],$_SESSION['Descri'],$_SESSION['UnMisura'],$_SESSION['Tipo'],$_SESSION['DtAbilitato'],"nome_parametro","nome_parametro",$strUtentiAziende);
$sqlDescri=findAllParametriVisByFiltri($_SESSION['Nome'],$_SESSION['Descri'],$_SESSION['UnMisura'],$_SESSION['Tipo'],$_SESSION['DtAbilitato'],"descri_parametro","descri_parametro",$strUtentiAziende);
$sqlUnMis=findAllParametriVisByFiltri($_SESSION['Nome'],$_SESSION['Descri'],$_SESSION['UnMisura'],$_SESSION['Tipo'],$_SESSION['DtAbilitato'],"unita_misura","unita_misura",$strUtentiAziende);
$sqlTipo=findAllParametriVisByFiltri($_SESSION['Nome'],$_SESSION['Descri'],$_SESSION['UnMisura'],$_SESSION['Tipo'],$_SESSION['DtAbilitato'],"tipo","tipo",$strUtentiAziende);
$sqlDtAb=findAllParametriVisByFiltri($_SESSION['Nome'],$_SESSION['Descri'],$_SESSION['UnMisura'],$_SESSION['Tipo'],$_SESSION['DtAbilitato'],"dt_abilitato","dt_abilitato",$strUtentiAziende);
commit();

include('./moduli/visualizza_lab_parametro.php'); 

?> 
    
    <div id="msgLog">
                <?php
                  if ($DEBUG) {
                        echo "actionOnLoad :" . $actionOnLoad;
                        echo "</br>Tab lab_parametro : Nuova stringa unica utenti e aziende visibili : " . $strUtentiAziende;
                    }
                 ?>
            </div>
</div>
</body>
</html>
