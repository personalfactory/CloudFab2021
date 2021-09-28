<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>

    <?php
    //Se la variabile debug =1 viene visualizzato il log

    if ($DEBUG)
        ini_set("display_errors", 1);
    //##########################################################################            
    //####################  GESTIONE UTENTI ####################################
    //1) Si verifica se l'utente ha il permesso di visualizzare la lista dei colori 147
    //2) Si verifica se l'utente ha il permesso di editare un colore 148
  
    //############# VERIFICA PERMESSO VISUALIZZAZIONE LISTA ####################
    $actionOnLoad = "";
    $elencoFunzioni = array( "148");
     $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);
    //############# STRINGHE UTENTI - AZIENDE VISIBILI###########################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'prodotto');

    //##########################################################################
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php
//## TO DO non urgente : AGGIUNGERE IL FILTRO RICERCA SUL PRODOTTO PADRE 

            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_prodotto.php');
            include('../sql/script_parametro_glob_mac.php');

            $_SESSION['IdProdotto'] = "";
            $_SESSION['Codice'] = "";
            $_SESSION['Nome'] = "";
            $_SESSION['SerieColore'] = "";
            $_SESSION['Gruppo'] = "";
            $_SESSION['Geografico'] = "";
            $_SESSION['Abilitato'] = "";
            $_SESSION['DtAbilitato'] = "";

            $_SESSION['IdProdottoList'] = "";
            $_SESSION['CodiceList'] = "";
            $_SESSION['NomeList'] = "";
            $_SESSION['SerieColoreList'] = "";
            $_SESSION['GruppoList'] = "";
            $_SESSION['GeograficoList'] = "";
            $_SESSION['AbilitatoList'] = "";
            $_SESSION['DtAbilitatoList'] = "";
            


            if (isset($_POST['IdProdotto'])) {
                $_SESSION['IdProdotto'] = trim($_POST['IdProdotto']);
            }
            if (isset($_POST['IdProdottoList']) AND $_POST['IdProdottoList'] != "") {
                $_SESSION['IdProdotto'] = trim($_POST['IdProdottoList']);
            }
            if (isset($_POST['Codice'])) {
                $_SESSION['Codice'] = trim($_POST['Codice']);
            }
            if (isset($_POST['CodiceList']) AND $_POST['CodiceList'] != "") {
                $_SESSION['Codice'] = trim($_POST['CodiceList']);
            }
            if (isset($_POST['Nome'])) {
                $_SESSION['Nome'] = trim($_POST['Nome']);
            }
            if (isset($_POST['NomeList']) AND $_POST['NomeList'] != "") {
                $_SESSION['Nome'] = trim($_POST['NomeList']);
            }
            if (isset($_POST['SerieColore'])) {
                $_SESSION['SerieColore'] = trim($_POST['SerieColore']);
            }
            if (isset($_POST['SerieColoreList']) AND $_POST['SerieColoreList'] != "") {
                $_SESSION['SerieColore'] = trim($_POST['SerieColoreList']);
            }
           
            if (isset($_POST['Geografico'])) {
                $_SESSION['Geografico'] = trim($_POST['Geografico']);
            }
            if (isset($_POST['GeograficoList']) AND $_POST['GeograficoList'] != "") {
                $_SESSION['Geografico'] = trim($_POST['GeograficoList']);
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
            if (isset($_POST['Gruppo'])) {
                $_SESSION['Gruppo'] = trim($_POST['Gruppo']);
            }
            if (isset($_POST['GruppoList']) AND $_POST['GruppoList'] != "") {
                $_SESSION['Gruppo'] = trim($_POST['GruppoList']);
            }

//########### VARIABILE DI ORDINAMENTO DELLA QUERY #######################
            $_SESSION['Filtro'] = "cod_prodotto";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }

            $strTipoProdotto = "";
            $sqlParGlob = findParGlobMac();
            while ($rowParGlob = mysql_fetch_array($sqlParGlob)) {

                switch ($rowParGlob['id_par_gm']) {

                    case 153:
                        //COLOR
                        $strTipoProdotto = $rowParGlob['valore_variabile'];
                        break;

                    default:
                        break;
                }
            }

            begin();

            //Visualizzazione tutti i colori
            $sql = findColoriByFiltri($_SESSION['Filtro'], "p.id_prodotto", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_SESSION['SerieColore'],  $_SESSION['Geografico'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $strTipoProdotto, $strUtentiAziende);
            $sqlId = findColoriByFiltri("p.id_prodotto", "p.id_prodotto", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_SESSION['SerieColore'],  $_SESSION['Geografico'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $strTipoProdotto, $strUtentiAziende);
            $sqlCod = findColoriByFiltri("cod_prodotto", "cod_prodotto", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_SESSION['SerieColore'], $_SESSION['Geografico'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $strTipoProdotto, $strUtentiAziende);
            $sqlNome = findColoriByFiltri("nome_prodotto", "nome_prodotto", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_SESSION['SerieColore'],  $_SESSION['Geografico'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $strTipoProdotto, $strUtentiAziende);
            $sqlGeo = findColoriByFiltri("geografico", "geografico", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_SESSION['SerieColore'], $_SESSION['Geografico'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $strTipoProdotto, $strUtentiAziende);
            $sqlAbil = findColoriByFiltri("a.abilitato", "a.abilitato", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_SESSION['SerieColore'],  $_SESSION['Geografico'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $strTipoProdotto, $strUtentiAziende);
            $sqlDt = findColoriByFiltri("a.dt_abilitato", "a.dt_abilitato", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_SESSION['SerieColore'],  $_SESSION['Geografico'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $strTipoProdotto, $strUtentiAziende);
            $sqlSerie = findColoriByFiltri("serie_colore", "serie_colore", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_SESSION['SerieColore'],  $_SESSION['Geografico'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $strTipoProdotto, $strUtentiAziende);
            $sqlGru = findColoriByFiltri("gruppo", "gruppo", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_SESSION['SerieColore'],  $_SESSION['Geografico'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $strTipoProdotto, $strUtentiAziende);

            commit();
            $trovati = mysql_num_rows($sql);

            include('./moduli/visualizza_anagrafe_colori.php');
            ?> 
            <div id="msgLog">
                <?php
                if ($DEBUG) {
                    echo "actionOnLoad :" . $actionOnLoad;
                    echo "</br>Tab prodotto : Nuova stringa unica utenti e aziende visibili : " . $strUtentiAziende;
                }
                ?>
            </div>
        </div>
    </body>
</html>
