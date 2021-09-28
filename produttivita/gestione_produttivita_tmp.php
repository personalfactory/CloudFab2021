<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php
    include('./oggetti/StabGrupGeo.php');
    include('./oggetti/Produttivita.php');
    include('../include/validator.php');
    ?>
    <head>
<?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
            ini_set('display_errors', "1");
//    include('../include/menu.php');
            include('../Connessioni/serverdb.php');
//      include('./sql_temp/script_produttivita.php');
            include('../sql/script_produttivita.php');
//      include('./oggetti/StabGrupGeo.php');
//      include('./oggetti/Produttivita.php');
//##############################################################################      
//########## Variabili dallo script gestione_produttivita.php ##################
//##############################################################################      

            if (isset($_GET['DataFrom']) && isset($_GET['DataTo'])) {

                $_SESSION['DataFrom'] = $_GET['DataFrom'];
                $_SESSION['DataTo'] = $_GET['DataTo'];
                $_SESSION['InServizio'] = $_GET['InServizio'];
                $_SESSION['Attivo'] = $_GET['Attivo'];
            }

            if (isset($_POST['DataFrom'])) {

                $_SESSION['DataFrom'] = $_POST['DataFrom'];
            }
            if (isset($_POST['DataTo'])) {

                $_SESSION['DataTo'] = $_POST['DataTo'];
            }
            if (isset($_GET['CodProdotto'])) {

                $_SESSION['CodProdotto'] = $_GET['CodProdotto'];
            }
            if (isset($_POST['CodProdotto'])) {

                $_SESSION['CodProdotto'] = trim($_POST['CodProdotto']);
            }


            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #############################
            $_SESSION['Filtro'] = "id_processo";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }

//##############################################################################
//########## Variabili che arrivano dal form di ricerca  #######################
//##############################################################################   
            
            $_SESSION['IdProcesso'] = "";
            $_SESSION['NomeProdotto'] = "";
            $_SESSION['CodChimica'] = "";
            $_SESSION['CodSacco'] = "";
            $_SESSION['DataProd'] = "";
            $_SESSION['Nominativo'] = "";
            $_SESSION['DescriStab'] = "";

            if (isset($_POST['IdProcesso'])) {
                $_SESSION['IdProcesso'] = trim($_POST['IdProcesso']);
            }
            if (isset($_POST['NomeProdotto'])) {
                $_SESSION['NomeProdotto'] = trim($_POST['NomeProdotto']);
            }
            if (isset($_POST['CodChimica'])) {
                $_SESSION['CodChimica'] = trim($_POST['CodChimica']);
            }
            if (isset($_POST['CodSacco'])) {
                $_SESSION['CodSacco'] = trim($_POST['CodSacco']);
            }
            if (isset($_POST['DataProd'])) {
                $_SESSION['DataProd'] = trim($_POST['DataProd']);
            }
            if (isset($_POST['Nominativo'])) {
                $_SESSION['Nominativo'] = trim($_POST['Nominativo']);
            }
            if (isset($_POST['DescriStab'])) {
                $_SESSION['DescriStab'] = trim($_POST['DescriStab']);
            }
            if ($_SESSION['DescriStab'] == $labelOptionStabDefault) {
                $_SESSION['DescriStab'] = "";
            }
            if ($_SESSION['NomeProdotto'] == $labelOptionProdDefault) {
                $_SESSION['NomeProdotto'] = "";
            }
            if ($_SESSION['Nominativo'] == $labelOptionOperDefault) {
                $_SESSION['Nominativo'] = "";
            }

//#################### LOG #####################################################
//      echo "</br>SESSION['DataFrom'] : ".$_SESSION['DataFrom'];
//      echo "</br>SESSION['DataTo'] : ".$_SESSION['DataTo'];
//      echo "</br>SESSION['InServizio'] : ".$_SESSION['InServizio'];
//      echo "</br>SESSION['Attivo'] : ".$_SESSION['Attivo'];
//      echo "</br>SESSION['IdProcesso'] : ".$_SESSION['IdProcesso'];
//      echo "</br>SESSION['NomeProdotto'] : ".$_SESSION['NomeProdotto'];
//      echo "</br>SESSION['CodChimica'] : ".$_SESSION['CodChimica'];
//      echo "</br>SESSION['CodSacco'] : ".$_SESSION['CodSacco'];
//      echo "</br>SESSION['DataProd'] : ".$_SESSION['DataProd'];
//      echo "</br>SESSION['prec'] : ".$_SESSION['prec'];
//      echo "</br>SESSION['att'] : ".$_SESSION['att'];
//      echo "</br>SESSION['Nominativo'] : ".$_SESSION['Nominativo'];
//      echo "</br>SESSION['DescriStab'] : ".$_SESSION['DescriStab'];
//##############################################################################

            $sql = selectProcessiTempByFiltriXX(
                    $_SESSION['objStabGrupGeo'], $_SESSION['objProduttivita'], 
                    $_SESSION['IdMacchina'], $_SESSION['DataTo'], 
                    $_SESSION['DataFrom'], $_SESSION['InServizio'], 
                    $_SESSION['Attivo'], $_SESSION['IdProcesso'], 
                    $_SESSION['CodProdotto'], $_SESSION['CodChimica'], 
                    $_SESSION['CodSacco'], $_SESSION['Nominativo'], 
                    $_SESSION['DataProd'], $_SESSION['NomeProdotto'], 
                    $_SESSION['DescriStab'], $_SESSION['Filtro']);


            $trovati = mysql_num_rows($sql);

            echo "</br>" . $msgRecordTrovati . $trovati . "</br>";
            echo "</br>" . $msgSelectCriteriRicerca . "</br>";
            ?>
        
            <?php
            include('./moduli/visualizza_produttivita_tmp.php');
            ?>
</div>

    </body>
</html>
