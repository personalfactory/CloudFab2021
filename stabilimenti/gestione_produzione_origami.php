<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <?php
    
    if($DEBUG) ini_set('display_errors', 1);
    
    //############# VERIFICA PERMESSO VISUALIZZAZIONE LISTA ####################
    //La variabile funzione indica il campo id_funzione della tabella funzione del dbutente
    //Vedere lista ultimi processi 
    
    $elencoFunzioni = array("102","139","144","145");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni,$_SESSION['objPermessiVis']);
    
    //################## STRINGHE UTENTI AZIENDE VISIBILI ######################
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'macchina');
    
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">

            <?php
            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_processo.php');
            
            //Azzero variabili di sessione per pagina gestione_processo
            $_SESSION['strCicli'] ="(0)";
            $_SESSION['IdCiclo']="";
            
            

            $_SESSION['Stabilimento'] = "";
            $_SESSION['ProcessiTot'] = "";
            $_SESSION['KitUsati'] = "";
            $_SESSION['DtProduzione'] = "";

            $_SESSION['StabilimentoList'] = "";
            $_SESSION['ProcessiTotList'] = "";
            $_SESSION['KitUsatiList'] = "";
            $_SESSION['DtProduzioneList'] = "";

            if (isset($_POST['Stabilimento'])) {
                $_SESSION['Stabilimento'] = trim($_POST['Stabilimento']);
            }
            if (isset($_POST['StabilimentoList']) AND $_POST['StabilimentoList'] != "") {
                $_SESSION['Stabilimento'] = trim($_POST['StabilimentoList']);
            }
            if (isset($_POST['ProcessiTot'])) {
                $_SESSION['ProcessiTot'] = trim($_POST['ProcessiTot']);
            }
            if (isset($_POST['ProcessiTotList']) AND $_POST['ProcessiTotList'] != "") {
                $_SESSION['ProcessiTot'] = trim($_POST['ProcessiTotList']);
            }
            if (isset($_POST['KitUsati'])) {
                $_SESSION['KitUsati'] = trim($_POST['KitUsati']);
            }
            if (isset($_POST['KitUsatiList']) AND $_POST['KitUsatiList'] != "") {
                $_SESSION['KitUsati'] = trim($_POST['KitUsatiList']);
            }
            if (isset($_POST['DtProduzione'])) {
                $_SESSION['DtProduzione'] = trim($_POST['DtProduzione']);
            }
            if (isset($_POST['DtProduzioneList']) AND $_POST['DtProduzioneList'] != "") {
                $_SESSION['DtProduzione'] = trim($_POST['DtProduzioneList']);
            }

            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #################
            $_SESSION['Filtro'] = "dt_produzione_mac DESC";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }


            begin();
            $sql = selectProdOrigamiByFiltri($_SESSION['Filtro'], "id_macchina", $strUtentiAziende);
            commit();
            $trovati = mysql_num_rows($sql);

            include('./moduli/visualizza_produzione_origami.php');
            
            
            
            
            
            ?>
            <div id="msgLog">
               <?php if ($DEBUG) {
       
                    echo "</br>actionOnLoad :" . $actionOnLoad;
                    echo "</br>Tab macchina : Utenti e aziende visibili " . $strUtentiAziende;
                    }
                ?>
            </div>
        </div>

    </body>
</html>
