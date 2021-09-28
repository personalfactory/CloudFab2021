
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php
        include('../include/header.php');
        ?>
    </head>
   
    <?php
    if ($DEBUG)
        ini_set('display_errors', 1);
    //L'elenco delle funzioni relative ad una voce-sottovoce in generale relativo ad una pagina
    //può essere recuperato dalla tabella voce_funzione di dbutente
    //134 : vedere lista prodoti bs
    //135 : creare- eliminare un nuovo prodotto in bs
    //136 : modificare un prodotto in bs
    $elencoFunzioni = array("134", "135", "136");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);
    //############# STRINGA UTENTI-AZIENDE VISIBILI ############################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'bs_prodotto');
    
    //NB: la tabella bs_altri_prodotti al momento non è stata inserita nella gestione utenti 
    //perchè si utilizzano gli stessi permessi della tabella bs_prodotto
    //$strUtentiAziende2 = getStrUtAzVisib($_SESSION['objPermessiVis'], 'bs_altri_prodotti');

    //##########################################################################
    ?>    
    <body onLoad="<?php echo $actionOnLoad ?>">

        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_bs_prodotto.php');

            $_SESSION['CodProdotto'] = "";
            $_SESSION['NomeProd'] = "";
            $_SESSION['Classificazione'] = "";
            $_SESSION['ListinoLotto'] = "";
            $_SESSION['NumKit'] = "";
            $_SESSION['NumLotti'] = "";
            $_SESSION['ListinoKit']="";
            $_SESSION['Rating'] = "";

            $_SESSION['CodProdottoList'] = "";
            $_SESSION['NomeProdList'] = "";
            $_SESSION['ClassificazioneList'] = "";
            $_SESSION['ListinoLottoList'] = "";
            $_SESSION['NumKitList'] = "";
            $_SESSION['NumLottiList'] = "";
            $_SESSION['ListinoKitList']="";
            $_SESSION['RatingList'] = "";

            if (isset($_POST['NomeProd'])) {
                $_SESSION['NomeProd'] = trim($_POST['NomeProd']);
            }
            if (isset($_POST['NomeProdList']) AND $_POST['NomeProdList'] != "") {
                $_SESSION['NomeProd'] = trim($_POST['NomeProdList']);
            }
            if (isset($_POST['CodProdotto'])) {
                $_SESSION['CodProdotto'] = trim($_POST['CodProdotto']);
            }
            if (isset($_POST['CodProdottoList']) AND $_POST['CodProdottoList'] != "") {
                $_SESSION['CodProdotto'] = trim($_POST['CodProdottoList']);
            }
            if (isset($_POST['Classificazione'])) {
                $_SESSION['Classificazione'] = trim($_POST['Classificazione']);
            }
            if (isset($_POST['ClassificazioneList']) AND $_POST['ClassificazioneList'] != "") {
                $_SESSION['Classificazione'] = trim($_POST['ClassificazioneList']);
            }
            if (isset($_POST['ListinoLotto'])) {
                $_SESSION['ListinoLotto'] = trim($_POST['ListinoLotto']);
            }
            if (isset($_POST['ListinoLottoList']) AND $_POST['ListinoLottoList'] != "") {
                $_SESSION['ListinoLotto'] = trim($_POST['ListinoLottoList']);
            }
            if (isset($_POST['NumKit'])) {
                $_SESSION['NumKit'] = trim($_POST['NumKit']);
            }
            if (isset($_POST['NumKitList']) AND $_POST['NumKitList'] != "") {
                $_SESSION['NumKit'] = trim($_POST['NumKitList']);
            }
            if (isset($_POST['ListinoKit'])) {
                $_SESSION['ListinoKit'] = trim($_POST['ListinoKit']);
            }
            if (isset($_POST['ListinoKitList']) AND $_POST['ListinoKitList'] != "") {
                $_SESSION['ListinoKit'] = trim($_POST['ListinoKitList']);
            }
            if (isset($_POST['Rating'])) {
                $_SESSION['Rating'] = trim($_POST['Rating']);
            }
            if (isset($_POST['RatingList']) AND $_POST['RatingList'] != "") {
                $_SESSION['Rating'] = trim($_POST['RatingList']);
            }


            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #################
            $_SESSION['Filtro'] = "cod_prodotto";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }
            //##################################################################
            begin();
            $sql = findProdottiBsVisByFiltriUnion("p.id_prodotto", $_SESSION['Filtro'], $_SESSION['CodProdotto'], $_SESSION['NomeProd'], $_SESSION['Classificazione'], $_SESSION['ListinoLotto'], $_SESSION['NumKit'],$_SESSION['ListinoKit'], $_SESSION['Rating'], $strUtentiAziende);

            $sqlCod = findProdottiBsVisByFiltriUnion("p.cod_prodotto", "cod_prodotto", $_SESSION['CodProdotto'], $_SESSION['NomeProd'], $_SESSION['Classificazione'], $_SESSION['ListinoLotto'], $_SESSION['NumKit'],$_SESSION['ListinoKit'], $_SESSION['Rating'], $strUtentiAziende);

            $sqlNome = findProdottiBsVisByFiltriUnion("nome_prodotto", "nome_prodotto", $_SESSION['CodProdotto'], $_SESSION['NomeProd'], $_SESSION['Classificazione'], $_SESSION['ListinoLotto'], $_SESSION['NumKit'],$_SESSION['ListinoKit'], $_SESSION['Rating'], $strUtentiAziende);

            $sqlClas = findProdottiBsVisByFiltriUnion("classificazione", "classificazione", $_SESSION['CodProdotto'], $_SESSION['NomeProd'], $_SESSION['Classificazione'], $_SESSION['ListinoLotto'], $_SESSION['NumKit'],$_SESSION['ListinoKit'], $_SESSION['Rating'], $strUtentiAziende);

            $sqlListino = findProdottiBsVisByFiltriUnion("listino", "listino", $_SESSION['CodProdotto'], $_SESSION['NomeProd'], $_SESSION['Classificazione'], $_SESSION['ListinoLotto'], $_SESSION['NumKit'],$_SESSION['ListinoKit'], $_SESSION['Rating'], $strUtentiAziende);

            $sqlNumKit = findProdottiBsVisByFiltriUnion("num_sac_in_lotto", "num_sac_in_lotto", $_SESSION['CodProdotto'], $_SESSION['NomeProd'], $_SESSION['Classificazione'], $_SESSION['ListinoLotto'], $_SESSION['NumKit'],$_SESSION['ListinoKit'], $_SESSION['Rating'], $strUtentiAziende);
            
            $sqlNumLotti = findProdottiBsVisByFiltriUnion("num_lotti", "num_lotti", $_SESSION['CodProdotto'], $_SESSION['NomeProd'], $_SESSION['Classificazione'], $_SESSION['ListinoLotto'], $_SESSION['NumKit'],$_SESSION['ListinoKit'], $_SESSION['Rating'], $strUtentiAziende);
            
            $sqlListinoKit = findProdottiBsVisByFiltriUnion("listino", "listino", $_SESSION['CodProdotto'], $_SESSION['NomeProd'], $_SESSION['Classificazione'], $_SESSION['ListinoLotto'], $_SESSION['NumKit'],$_SESSION['ListinoKit'], $_SESSION['Rating'], $strUtentiAziende);

            $sqlRating = findProdottiBsVisByFiltriUnion("rating", "rating", $_SESSION['CodProdotto'], $_SESSION['NomeProd'], $_SESSION['Classificazione'], $_SESSION['ListinoLotto'], $_SESSION['NumKit'],$_SESSION['ListinoKit'], $_SESSION['Rating'], $strUtentiAziende);

            $trovati = mysql_num_rows($sql);
            commit();
            include('./moduli/visualizza_prodotti_bs.php');
            ?> 
            <div id="msgLog">
            <?php
            if ($DEBUG) {
                echo "</br>actionOnLoad :" . $actionOnLoad;
                echo "</br>Tab bs_prodotto : Utenti e aziende visibili " . $strUtentiAziende;
            }
            ?>
            </div>
        </div>
    </body>
</html>

