<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php
        include('../include/header.php');
        ?>
    </head>
    <script language="javascript">
//        function disabilitaAction80() {
//            //PERMESSO VISTA LISTA CATEGORIE
//            location.href = '../permessi/avviso_permessi_visualizzazione.php'
//        }
//        function disabilitaAction81() {
//            //PERMESSO VEDERE DETTAGLIO CATEGORIA 
//            //Disabilita il link alla pagina di modifica
//            for (i = 0; i < document.getElementsByName('81').length; i++) {
//                document.getElementsByName('81')[i].removeAttribute('href');
//            }
//        }
//        function disabilitaAction82() {
//            //PERMESSO SCRITTURA CATEGORIA
//             for (i = 0; i < document.getElementsByName('82').length; i++) {
//                document.getElementsByName('82')[i].removeAttribute('href');
//            }
//        }        
//        function disabilitaAction83() {
//            //PERMESSO VEDERE VALORI PARAMETRI PRODOTTO 
//            //Disabilita il link alla pagina di visualizzazione dei valori dei parametri prodotto
//            for (i = 0; i < document.getElementsByName('83').length; i++) {
//                document.getElementsByName('83')[i].removeAttribute('href');
//            }
//        }
//        function disabilitaAction84() {
//            //PERMESSO VEDERE VALORI PARAMETRI SACCHETTO
//            //Disabilita il link alla pagina di visualizzazione di valori par sacchetto
//            for (i = 0; i < document.getElementsByName('84').length; i++) {
//                document.getElementsByName('84')[i].removeAttribute('href');
//            }
//        }
    </script>
    <?php
    if ($DEBUG)
        ini_set('display_errors', 1);
    //L'elenco delle funzioni relative ad una voce-sottovoce in generale relativo ad una pagina
    //può essere recuperato dalla tabella voce_funzione di dbutente
    $elencoFunzioni = array("80", "81", "82", "83", "85");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);

    //############# STRINGA UTENTI-AZIENDE VISIBILI ############################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'categoria');

    //##########################################################################
    ?>    
    <body onLoad="<?php echo $actionOnLoad ?>">

        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_categoria.php');

            $_SESSION['Id'] = "";
            $_SESSION['Nome'] = "";
            $_SESSION['Descrizione'] = "";
            $_SESSION['Abilitato'] = "";
            $_SESSION['DtAbilitato'] = "";

            $_SESSION['IdList'] = "";
            $_SESSION['NomeList'] = "";
            $_SESSION['DescrizioneList'] = "";
            $_SESSION['AbilitatoList'] = "";
            $_SESSION['DtAbilitatoList'] = "";

            if (isset($_POST['Id'])) {
                $_SESSION['Id'] = trim($_POST['Id']);
            }
            if (isset($_POST['IdList']) AND $_POST['IdList'] != "") {
                $_SESSION['Id'] = trim($_POST['IdList']);
            }
            if (isset($_POST['Nome'])) {
                $_SESSION['Nome'] = trim($_POST['Nome']);
            }
            if (isset($_POST['NomeList']) AND $_POST['NomeList'] != "") {
                $_SESSION['Nome'] = trim($_POST['NomeList']);
            }
            if (isset($_POST['Descrizione'])) {
                $_SESSION['Descrizione'] = trim($_POST['Descrizione']);
            }
            if (isset($_POST['DescrizioneList']) AND $_POST['DescrizioneList'] != "") {
                $_SESSION['Descrizione'] = trim($_POST['DescrizioneList']);
            }
            if (isset($_POST['Abilitato'])) {
                $_SESSION['Abilitato'] = trim($_POST['Abilitato']);
            }
            if (isset($_POST['AbilitatoList']) AND $_POST['AbilitatoList'] != "") {
                $_SESSION['Abilitato'] = trim($_POST['AbilitatoList']);
            }

            if (isset($_POST['DtAbilitato'])) {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
            }
            if (isset($_POST['DtAbilitatoList']) AND $_POST['DtAbilitatoList'] != "") {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitatoList']);
            }


            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #################
            $_SESSION['Filtro'] = "nome_categoria";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }
            //##################################################################
            begin();
            $sql = findCategorieVisByFiltri("id_cat",$_SESSION['Filtro'],$strUtentiAziende,$_SESSION['Id'],$_SESSION['Nome'],$_SESSION['Descrizione'],$_SESSION['Abilitato'],$_SESSION['DtAbilitato']);
            $sqlId = findCategorieVisByFiltri("id_cat","id_cat",$strUtentiAziende,$_SESSION['Id'],$_SESSION['Nome'],$_SESSION['Descrizione'],$_SESSION['Abilitato'],$_SESSION['DtAbilitato']);
            $sqlNome = findCategorieVisByFiltri("nome_categoria","nome_categoria",$strUtentiAziende,$_SESSION['Id'],$_SESSION['Nome'],$_SESSION['Descrizione'],$_SESSION['Abilitato'],$_SESSION['DtAbilitato']);
            $sqlDescri = findCategorieVisByFiltri("descri_categoria","descri_categoria",$strUtentiAziende,$_SESSION['Id'],$_SESSION['Nome'],$_SESSION['Descrizione'],$_SESSION['Abilitato'],$_SESSION['DtAbilitato']);
            $sqlAb = findCategorieVisByFiltri("abilitato","abilitato",$strUtentiAziende,$_SESSION['Id'],$_SESSION['Nome'],$_SESSION['Descrizione'],$_SESSION['Abilitato'],$_SESSION['DtAbilitato']);
            $sqlDtAb = findCategorieVisByFiltri("dt_abilitato","dt_abilitato",$strUtentiAziende,$_SESSION['Id'],$_SESSION['Nome'],$_SESSION['Descrizione'],$_SESSION['Abilitato'],$_SESSION['DtAbilitato']);
                    
            $trovati = mysql_num_rows($sql);
            commit();
            include('./moduli/visualizza_categorie.php');
            ?> 
            <div id="msgLog">
                <?php
                if ($DEBUG) {

                    echo "</br>actionOnLoad :" . $actionOnLoad;
                    echo "</br>Tab categoria : Utenti e aziende visibili " . $strUtentiAziende;
                }
                ?>
            </div>
        </div>
    </body>
</html>
