<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    
    <?php
     if ($DEBUG)
                ini_set("display_errors", "1");

            //############# VERIFICA PERMESSO VISUALIZZAZIONE LISTA ####################
            $actionOnLoad = "";
            $elencoFunzioni = array("142");
            $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);
            
            
            //############# STRINGHE UTENTI - AZIENDE VISIBILI###########################
            //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
            //dall'utente loggato   
            $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'ordine_elenco');
            
            ?>
    
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_ordine_elenco.php');
            include('../sql/script_ordine_sing_mac.php');
          
            //Calcolo l'anno ed il mese corrente
            $now = getdate();
            $annoCorrente = $now["year"];
            $meseCorrente = $now["mon"];
            if ($meseCorrente < 10) {
                $meseCorrente = "0" . $meseCorrente;
            }
            
            $_SESSION['IdOrdine'] = "";
            $_SESSION['DtProgrammata'] = "";
            $_SESSION['DescriStab'] = "";
            $_SESSION['NomeProdotto'] = "";
            $_SESSION['NumPezzi'] = "";
            $_SESSION['OrdineProduzione'] = "";
            $_SESSION['DescriStato'] = "";

            //$_SESSION['OrdineProduzione'] = $annoCorrente."-".$meseCorrente;

            $_SESSION['IdOrdineList'] = "";
            $_SESSION['DtProgrammataList'] = "";
            $_SESSION['DescriStabList'] = "";
            $_SESSION['NomeProdottoList'] = "";
            $_SESSION['NumPezziList'] = "";
            $_SESSION['OrdineProduzioneList'] = "";
            $_SESSION['DescriStatoList'] = "";


            if (isset($_POST['IdOrdine'])) {
                $_SESSION['IdOrdine'] = trim($_POST['IdOrdine']);
            }
            if (isset($_POST['IdOrdineList']) AND $_POST['IdOrdineList'] != "") {
                $_SESSION['IdOrdine'] = trim($_POST['IdOrdineList']);
            }
            if (isset($_POST['DtProgrammata'])) {
                $_SESSION['DtProgrammata'] = trim($_POST['DtProgrammata']);
            }
            if (isset($_POST['DtProgrammataList']) AND $_POST['DtProgrammataList'] != "") {
                $_SESSION['DtProgrammata'] = trim($_POST['DtProgrammataList']);
            }
            if (isset($_POST['DescriStab'])) {
                $_SESSION['DescriStab'] = trim($_POST['DescriStab']);
            }
            if (isset($_POST['DescriStabList']) AND $_POST['DescriStabList'] != "") {
                $_SESSION['DescriStab'] = trim($_POST['DescriStabList']);
            }
            if (isset($_POST['NomeProdotto'])) {
                $_SESSION['NomeProdotto'] = trim($_POST['NomeProdotto']);
            }
            if (isset($_POST['NomeProdottoList']) AND $_POST['NomeProdottoList'] != "") {
                $_SESSION['NomeProdotto'] = trim($_POST['NomeProdottoList']);
            }
            if (isset($_POST['NumPezzi'])) {
                $_SESSION['NumPezzi'] = trim($_POST['NumPezzi']);
            }
            if (isset($_POST['NumPezziList']) AND $_POST['NumPezziList'] != "") {
                $_SESSION['NumPezzi'] = trim($_POST['NumPezziList']);
            }
            if (isset($_POST['OrdineProduzione'])) {
                $_SESSION['OrdineProduzione'] = trim($_POST['OrdineProduzione']);
            }
            if (isset($_POST['OrdineProduzioneList']) AND $_POST['OrdineProduzioneList'] != "") {
                $_SESSION['OrdineProduzione'] = trim($_POST['OrdineProduzioneList']);
            }
            if (isset($_POST['DescriStato'])) {
                $_SESSION['DescriStato'] = trim($_POST['DescriStato']);
            }
            if (isset($_POST['DescriStatoList']) AND $_POST['DescriStatoList'] != "") {
                $_SESSION['DescriStato'] = trim($_POST['DescriStatoList']);
            }


            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #######################
            $_SESSION['Filtro'] = "id_ordine_sm";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }

            begin();
            $sql = findOrdiniOriByFiltri($_SESSION['Filtro'], "id_ordine_sm", $_SESSION['IdOrdine'], $_SESSION['DtProgrammata'], $_SESSION['DescriStab'], $_SESSION['NomeProdotto'], $_SESSION['NumPezzi'], $_SESSION['OrdineProduzione'], $_SESSION['DescriStato'], $strUtentiAziende);
            $sqlId = findOrdiniOriByFiltri("o.id_ordine", "o.id_ordine", $_SESSION['IdOrdine'], $_SESSION['DtProgrammata'], $_SESSION['DescriStab'], $_SESSION['NomeProdotto'], $_SESSION['NumPezzi'], $_SESSION['OrdineProduzione'], $_SESSION['DescriStato'], $strUtentiAziende);
            $sqlDtProgrammata = findOrdiniOriByFiltri("s.dt_programmata", "s.dt_programmata", $_SESSION['IdOrdine'], $_SESSION['DtProgrammata'], $_SESSION['DescriStab'], $_SESSION['NomeProdotto'], $_SESSION['NumPezzi'], $_SESSION['OrdineProduzione'], $_SESSION['DescriStato'], $strUtentiAziende);
            $sqlStab = findOrdiniOriByFiltri("descri_stab", "descri_stab", $_SESSION['IdOrdine'], $_SESSION['DtProgrammata'], $_SESSION['DescriStab'], $_SESSION['NomeProdotto'], $_SESSION['NumPezzi'], $_SESSION['OrdineProduzione'], $_SESSION['DescriStato'], $strUtentiAziende);
            $sqlProd = findOrdiniOriByFiltri("nome_prodotto", "nome_prodotto", $_SESSION['IdOrdine'], $_SESSION['DtProgrammata'], $_SESSION['DescriStab'], $_SESSION['NomeProdotto'], $_SESSION['NumPezzi'], $_SESSION['OrdineProduzione'], $_SESSION['DescriStato'], $strUtentiAziende);
            $sqlNumPezzi = findOrdiniOriByFiltri("num_pezzi", "num_pezzi", $_SESSION['IdOrdine'], $_SESSION['DtProgrammata'], $_SESSION['DescriStab'], $_SESSION['NomeProdotto'], $_SESSION['NumPezzi'], $_SESSION['OrdineProduzione'], $_SESSION['DescriStato'], $strUtentiAziende);
            $sqlOrdineProd = findOrdiniOriByFiltri("ordine_produzione", "ordine_produzione", $_SESSION['IdOrdine'], $_SESSION['DtProgrammata'], $_SESSION['DescriStab'], $_SESSION['NomeProdotto'], $_SESSION['NumPezzi'], $_SESSION['OrdineProduzione'], $_SESSION['DescriStato'], $strUtentiAziende);
            $sqlStato = findOrdiniOriByFiltri("s.descri_stato", "s.descri_stato", $_SESSION['IdOrdine'], $_SESSION['DtProgrammata'], $_SESSION['DescriStab'], $_SESSION['NomeProdotto'], $_SESSION['NumPezzi'], $_SESSION['OrdineProduzione'], $_SESSION['DescriStato'], $strUtentiAziende);
            commit();

            $trovati = mysql_num_rows($sql);
            include('./moduli/visualizza_ordini.php');
            ?>

        </div>
    </body>
</html>
