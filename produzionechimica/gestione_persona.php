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
    //1) 25 Si verifica se l'utente ha il permesso di visualizzare la lista delle persone 
    //2) 105 Si verifica se l'utente ha il persmesso di editare la tabella persona
   
    //############# VERIFICA PERMESSI ##########################################
    $actionOnLoad="";
    $elencoFunzioni = array("25","105");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni,$_SESSION['objPermessiVis']);
    //############# STRINGHE UTENTI - AZIENDE VISIBILI###########################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'persona');   
    
    //##########################################################################
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
       
<?php 

include('../include/menu.php'); 
include('../Connessioni/serverdb.php');
include('../sql/script.php');
include('../sql/script_persona.php');

    
            $_SESSION['IdPersona'] = "";
            $_SESSION['Nominativo'] = "";
            $_SESSION['Descrizione'] = "";
            $_SESSION['Tipo'] = "";          
            $_SESSION['DtAbilitato'] = "";
            
            $_SESSION['IdPersonaList'] = "";
            $_SESSION['NominativoList'] = "";
            $_SESSION['DescrizioneList'] = "";
            $_SESSION['TipoList'] = "";          
            $_SESSION['DtAbilitatoList'] = "";            
            
           

            
            if (isset($_POST['IdPersona'])) {
                $_SESSION['IdPersona'] = trim($_POST['IdPersona']);
            }
            if (isset($_POST['IdPersonaList']) AND $_POST['IdPersonaList']!="") {
                $_SESSION['IdPersona'] = trim($_POST['IdPersonaList']);
            }
            if (isset($_POST['Nominativo'])) {
                $_SESSION['Nominativo'] = trim($_POST['Nominativo']);
            }
            if (isset($_POST['NominativoList']) AND $_POST['NominativoList']!="") {
                $_SESSION['Nominativo'] = trim($_POST['NominativoList']);
            }
            if (isset($_POST['Descrizione'])) {
                $_SESSION['Descrizione'] = trim($_POST['Descrizione']);
            }
            if (isset($_POST['DescrizioneList']) AND $_POST['DescrizioneList']!="") {
                $_SESSION['Descrizione'] = trim($_POST['DescrizioneList']);
            }
            if (isset($_POST['Tipo'])) {
                $_SESSION['Tipo'] = trim($_POST['Tipo']);
            }
            if (isset($_POST['TipoList']) AND $_POST['TipoList']!="") {
                $_SESSION['Tipo'] = trim($_POST['TipoList']);
            }
            
            if (isset($_POST['DtAbilitato'])) {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
            }
            if (isset($_POST['DtAbilitatoList']) AND $_POST['DtAbilitatoList']!="") {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitatoList']);
            }
            
            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #######################
            $_SESSION['Filtro'] = "id_persona";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }


begin();
$sql =selectPersoneByFiltri($_SESSION['Filtro'], "id_persona", $_SESSION['IdPersona'],$_SESSION['Nominativo'] , $_SESSION['Descrizione'] , $_SESSION['Tipo'] , $_SESSION['DtAbilitato'], $strUtentiAziende) ;
$sqlId=selectPersoneByFiltri($_SESSION['Filtro'], "id_persona", $_SESSION['IdPersona'],$_SESSION['Nominativo'] , $_SESSION['Descrizione'] , $_SESSION['Tipo'] , $_SESSION['DtAbilitato'], $strUtentiAziende) ;
$sqlNom=selectPersoneByFiltri($_SESSION['Filtro'], "nominativo", $_SESSION['IdPersona'],$_SESSION['Nominativo'] , $_SESSION['Descrizione'] , $_SESSION['Tipo'] , $_SESSION['DtAbilitato'], $strUtentiAziende) ;
$sqlDes=selectPersoneByFiltri($_SESSION['Filtro'], "descrizione",$_SESSION['IdPersona'], $_SESSION['Nominativo'] , $_SESSION['Descrizione'] , $_SESSION['Tipo'] , $_SESSION['DtAbilitato'], $strUtentiAziende) ;
$sqlTipo=selectPersoneByFiltri($_SESSION['Filtro'], "tipo", $_SESSION['IdPersona'],$_SESSION['Nominativo'] , $_SESSION['Descrizione'] , $_SESSION['Tipo'] , $_SESSION['DtAbilitato'], $strUtentiAziende) ;
$sqlDt=selectPersoneByFiltri($_SESSION['Filtro'], "dt_abilitato", $_SESSION['IdPersona'],$_SESSION['Nominativo'] , $_SESSION['Descrizione'] , $_SESSION['Tipo'] , $_SESSION['DtAbilitato'], $strUtentiAziende) ;
commit();
$trovati = mysql_num_rows($sql);

include('./moduli/visualizza_persona.php');?>
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
