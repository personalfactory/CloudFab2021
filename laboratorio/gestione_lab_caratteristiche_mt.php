<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
 <?php
     if($DEBUG) ini_set('display_errors', '1'); 
    //##########################################################################            
    //NOTE GESTIONE UTENTI
    //1) Si verifica se l'utente ha il permesso di visualizzare la lista delle carat (30) Per ora commentato
    //2) Si verifica se l'utente ha il permesso di modificare la tabella lab_caratteristica_mt(121)
    //3) Si verifica se l'utente ha il permesso di inserire dati nella tabella lab_caratteristica_mt(122)
    //############# VERIFICA PERMESSI ##########################################
    $actionOnLoad="";
    $elencoFunzioni = array("121","122");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni,$_SESSION['objPermessiVis']);
    //############# STRINGHE UTENTI - AZIENDE VISIBILI###########################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziendeCarMt = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_caratteristica_mt');   
        
    //##########################################################################
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">

<div id="labContainer" >
<?php 
include('../include/menu.php'); 
include('../Connessioni/serverdb.php');
include('sql/script.php');
include('sql/script_lab_caratteristica_mt.php');


            $_SESSION['IdCarat'] = "";
            $_SESSION['Caratteristica'] = "";
            $_SESSION['Descrizione'] = "";
            $_SESSION['UniMisCar'] = "";
            $_SESSION['Dimensione'] = "";
            $_SESSION['UniMisDim'] = "";
            $_SESSION['Metodologia'] = "";       
            $_SESSION['DtAbilitato'] = "";             
            
            $_SESSION['IdCaratList'] = "";
            $_SESSION['CaratteristicaList'] = "";
            $_SESSION['DescrizioneList'] = "";            
            $_SESSION['UniMisCarList'] = "";
            $_SESSION['DimensioneList'] = "";
            $_SESSION['UniMisDimList'] = "";
            $_SESSION['MetodologiaList'] = "";  
            $_SESSION['DtAbilitatoList'] = "";

            if (isset($_POST['IdCarat'])) {
                $_SESSION['IdCarat'] = trim($_POST['IdCarat']);
            }
            if (isset($_POST['IdCaratList']) AND $_POST['IdCaratList'] != "") {
                $_SESSION['IdCarat'] = trim($_POST['IdCaratList']);
            }
             if (isset($_POST['Caratteristica'])) {
                $_SESSION['Caratteristica'] = trim($_POST['Caratteristica']);
            }
            if (isset($_POST['CaratteristicaList']) AND $_POST['CaratteristicaList'] != "") {
                $_SESSION['Caratteristica'] = trim($_POST['CaratteristicaList']);
            }
            if (isset($_POST['Descrizione'])) {
                $_SESSION['Descrizione'] = trim($_POST['Descrizione']);
            }
            if (isset($_POST['DescrizioneList']) AND $_POST['DescrizioneList'] != "") {
                $_SESSION['Descrizione'] = trim($_POST['DescrizioneList']);
            }
            if (isset($_POST['UniMisCar'])) {
                $_SESSION['UniMisCar'] = trim($_POST['UniMisCar']);
            }
            if (isset($_POST['UniMisCarList']) AND $_POST['UniMisCarList'] != "") {
                $_SESSION['UniMisCar'] = trim($_POST['UniMisCarList']);
            }
            if (isset($_POST['Dimensione'])) {
                $_SESSION['Dimensione'] = trim($_POST['Dimensione']);
            }
            if (isset($_POST['DimensioneList']) AND $_POST['DimensioneList'] != "") {
                $_SESSION['Dimensione'] = trim($_POST['DimensioneList']);
            }
             if (isset($_POST['UniMisDim'])) {
                $_SESSION['UniMisDim'] = trim($_POST['UniMisDim']);
            }
            if (isset($_POST['UniMisDimList']) AND $_POST['UniMisDimList'] != "") {
                $_SESSION['UniMisDim'] = trim($_POST['UniMisDimList']);
            }            
            if (isset($_POST['Metodologia'])) {
                $_SESSION['Metodologia'] = trim($_POST['Metodologia']);
            }
            if (isset($_POST['MetodologiaList']) AND $_POST['MetodologiaList'] != "") {
                $_SESSION['Metodologia'] = trim($_POST['MetodologiaList']);
            }
            if (isset($_POST['DtAbilitato'])) {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
            }
            if (isset($_POST['DtAbilitatoList']) AND $_POST['DtAbilitatoList'] != "") {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitatoList']);
            }
            

            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #############################
            $_SESSION['Filtro'] = "caratteristica";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }

            $_SESSION['GroupBy'] = "id_carat";


begin();
$sql = findAllCarMtVisByFiltri($_SESSION['Filtro'],
        $_SESSION['GroupBy'],
        $_SESSION['IdCarat'],
        $_SESSION['Caratteristica'],
        $_SESSION['Descrizione'],
        $_SESSION['UniMisCar'],        
        $_SESSION['Dimensione'],
        $_SESSION['UniMisDim'],        
        $_SESSION['Metodologia'],
        $_SESSION['DtAbilitato'],
        $strUtentiAziendeCarMt
        );
$sqlId = findAllCarMtVisByFiltri("id_carat",
        "id_carat",
        $_SESSION['IdCarat'],
        $_SESSION['Caratteristica'],
        $_SESSION['Descrizione'],
        $_SESSION['UniMisCar'],        
        $_SESSION['Dimensione'],
        $_SESSION['UniMisDim'],        
        $_SESSION['Metodologia'],
        $_SESSION['DtAbilitato'],
        $strUtentiAziendeCarMt
        );
$sqlLabCar=findAllCarMtVisByFiltri("caratteristica",
        "caratteristica",
        $_SESSION['IdCarat'],
        $_SESSION['Caratteristica'],
        $_SESSION['Descrizione'],
        $_SESSION['UniMisCar'],        
        $_SESSION['Dimensione'],
        $_SESSION['UniMisDim'],        
        $_SESSION['Metodologia'],
        $_SESSION['DtAbilitato'],
        $strUtentiAziendeCarMt
        );
$sqlLabDescri=findAllCarMtVisByFiltri("descri_caratteristica",
        "descri_caratteristica",
        $_SESSION['IdCarat'],
        $_SESSION['Caratteristica'],
        $_SESSION['Descrizione'],
        $_SESSION['UniMisCar'],        
        $_SESSION['Dimensione'],
        $_SESSION['UniMisDim'],        
        $_SESSION['Metodologia'],
        $_SESSION['DtAbilitato'],
        $strUtentiAziendeCarMt
        );
$sqlUniCar=findAllCarMtVisByFiltri("uni_mis_car",
        "uni_mis_car",
        $_SESSION['IdCarat'],
        $_SESSION['Caratteristica'],
        $_SESSION['Descrizione'],
        $_SESSION['UniMisCar'],        
        $_SESSION['Dimensione'],
        $_SESSION['UniMisDim'],        
        $_SESSION['Metodologia'],
        $_SESSION['DtAbilitato'],
        $strUtentiAziendeCarMt
        );
$sqlDim=findAllCarMtVisByFiltri("dimensione",
        "dimensione",
        $_SESSION['IdCarat'],
        $_SESSION['Caratteristica'],
        $_SESSION['Descrizione'],
        $_SESSION['UniMisCar'],        
        $_SESSION['Dimensione'],
        $_SESSION['UniMisDim'],        
        $_SESSION['Metodologia'],
        $_SESSION['DtAbilitato'],
        $strUtentiAziendeCarMt
        );
$sqlUnDim=findAllCarMtVisByFiltri("uni_mis_dim",
        "uni_mis_dim",
        $_SESSION['IdCarat'],
        $_SESSION['Caratteristica'],
        $_SESSION['Descrizione'],
        $_SESSION['UniMisCar'],        
        $_SESSION['Dimensione'],
        $_SESSION['UniMisDim'],        
        $_SESSION['Metodologia'],
        $_SESSION['DtAbilitato'],
        $strUtentiAziendeCarMt
        );
$sqlMetodo=findAllCarMtVisByFiltri("metodologia",
        "metodologia",
        $_SESSION['IdCarat'],
        $_SESSION['Caratteristica'],
        $_SESSION['Descrizione'],
        $_SESSION['UniMisCar'],        
        $_SESSION['Dimensione'],
        $_SESSION['UniMisDim'],        
        $_SESSION['Metodologia'],
        $_SESSION['DtAbilitato'],
        $strUtentiAziendeCarMt
        );
$sqlLabData=findAllCarMtVisByFiltri("dt_abilitato",
        "dt_abilitato",
        $_SESSION['IdCarat'],
        $_SESSION['Caratteristica'],
        $_SESSION['Descrizione'],
        $_SESSION['UniMisCar'],        
        $_SESSION['Dimensione'],
        $_SESSION['UniMisDim'],        
        $_SESSION['Metodologia'],
        $_SESSION['DtAbilitato'],
        $strUtentiAziendeCarMt
        );
commit();

include('./moduli/visualizza_lab_caratteristiche_mt.php'); ?> 
<div id="msgLog">
                <?php
                if ($DEBUG) {

                    echo "</br>actionOnLoad :" . $actionOnLoad;
                    echo "</br>Tab lab_caratteristica_mt : Utenti e aziende visibili " . $strUtentiAziendeCarMt;
                }
                ?>
            </div>
</div>
</body>
</html>
