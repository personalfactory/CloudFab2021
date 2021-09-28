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
    //1) Si verifica se l'utente ha il permesso di visualizzare la lista dei prodotti
    //2) Si verifica se l'utente ha il permesso di visualizzare il dettaglio dei prodotti
    //3) Si verifica se l'utente ha il permesso di visualizzare il dettaglio dei prodotti + formula
    //4) Si verifica se l'utente ha il permesso di scrittura 2 (Nuovo prodotto)sulla tabella prodotto
    //5) Si verifica se l'utente ha il permesso creare nuovo prodotto figlio 
    //6) Si verifica se l'utente ha il permesso di disabilitare un prodotto
    //############# VERIFICA PERMESSO VISUALIZZAZIONE LISTA ####################
    $actionOnLoad = "";
    $elencoFunzioni = array("1", "2", "3", "4", "100", "101");
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

            $_SESSION['IdProdotto'] = "";
            $_SESSION['Codice'] = "";
            $_SESSION['Nome'] = "";
            $_SESSION['ProdPadre'] = "";
            $_SESSION['Famiglia'] = "";
            $_SESSION['Categoria'] = "";
            $_SESSION['Abilitato'] = "";
            $_SESSION['DtAbilitato'] = "";
            $_SESSION['Gruppo'] = "";

            $_SESSION['IdProdottoList'] = "";
            $_SESSION['CodiceList'] = "";
            $_SESSION['NomeList'] = "";
            $_SESSION['ProdPadreList'] = "";
            $_SESSION['FamigliaList'] = "";
            $_SESSION['CategoriaList'] = "";
            $_SESSION['AbilitatoList'] = "";
            $_SESSION['DtAbilitatoList'] = "";
            $_SESSION['GruppoList'] = "";


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
            if (isset($_POST['ProdPadre'])) {
                $_SESSION['ProdPadre'] = trim($_POST['ProdPadre']);
            }
            if (isset($_POST['ProdPadreList']) AND $_POST['ProdPadreList'] != "") {
                $_SESSION['ProdPadre'] = trim($_POST['ProdPadreList']);
            }
            if (isset($_POST['Famiglia'])) {
                $_SESSION['Famiglia'] = trim($_POST['Famiglia']);
            }
            if (isset($_POST['FamigliaList']) AND $_POST['FamigliaList'] != "") {
                $_SESSION['Famiglia'] = trim($_POST['FamigliaList']);
            }
            if (isset($_POST['Categoria'])) {
                $_SESSION['Categoria'] = trim($_POST['Categoria']);
            }
            if (isset($_POST['CategoriaList']) AND $_POST['CategoriaList'] != "") {
                $_SESSION['Categoria'] = trim($_POST['CategoriaList']);
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

            
            //######################## CONDIZIONE DELLA SELECT ########################################
            $_SESSION['condizioneSelectProdotti'] = "colorato=colorato";
            if (isset($_POST['condizioneSelectProdotti']) AND $_POST['condizioneSelectProdotti'] != "") {
                $_SESSION['condizioneSelectProdotti'] = trim($_POST['condizioneSelectProdotti']);
            }     
           
            if (isset($_GET['condizioneSelectProdotti']) AND $_GET['condizioneSelectProdotti'] != "") {                
                switch ($_GET['condizioneSelectProdotti']) {
                    case 1:
                        //Seleziona solo i prodotti standard
                        $_SESSION['condizioneSelectProdotti'] = "colorato=p.id_prodotto";
                        break;
                    case 2:
                        //Seleziona solo i prodotti derivati
                        $_SESSION['condizioneSelectProdotti'] = "colorato<>p.id_prodotto";
                        break;
                    case 3:
                        //Seleziona solo tutti i prodotti standard e derivati
                        $_SESSION['condizioneSelectProdotti'] = "colorato=colorato";
                        break;
                    
                }
            }
            //########################################################################################


            begin();
            if ($_SESSION['ProdPadre'] != "") {
                $sqlCodProdPadre = findProdottoByCodice($_SESSION['ProdPadre']);
                while ($rowProdPadre = mysql_fetch_array($sqlCodProdPadre)) {
                    echo $_SESSION['ProdPadre'] = $rowProdPadre['id_prodotto'];
                }
            }

            if (!isset($_GET['IdProdottoPadre']) OR $_GET['IdProdottoPadre'] == "") {
                //Visualizzazione tutti i prodotti

                $sql = findProdottiByFiltri($_SESSION['Filtro'], "p.id_prodotto", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_SESSION['ProdPadre'], $_SESSION['Famiglia'], $_SESSION['Categoria'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $_SESSION['condizioneSelectProdotti'], $strUtentiAziende);
                $sqlId = findProdottiByFiltri("p.id_prodotto", "p.id_prodotto", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_SESSION['ProdPadre'], $_SESSION['Famiglia'], $_SESSION['Categoria'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $_SESSION['condizioneSelectProdotti'], $strUtentiAziende);
                $sqlCod = findProdottiByFiltri("cod_prodotto", "cod_prodotto", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_SESSION['ProdPadre'], $_SESSION['Famiglia'], $_SESSION['Categoria'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $_SESSION['condizioneSelectProdotti'], $strUtentiAziende);
                $sqlNome = findProdottiByFiltri("nome_prodotto", "nome_prodotto", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_SESSION['ProdPadre'], $_SESSION['Famiglia'], $_SESSION['Categoria'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $_SESSION['condizioneSelectProdotti'], $strUtentiAziende);
                $sqlPad = findProdottiByFiltri("p.id_prodotto", "p.id_prodotto", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_SESSION['ProdPadre'], $_SESSION['Famiglia'], $_SESSION['Categoria'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $_SESSION['condizioneSelectProdotti'], $strUtentiAziende);
                $sqlFam = findProdottiByFiltri("cod.descrizione", "cod.descrizione", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_SESSION['ProdPadre'], $_SESSION['Famiglia'], $_SESSION['Categoria'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $_SESSION['condizioneSelectProdotti'], $strUtentiAziende);
                $sqlCat = findProdottiByFiltri("nome_categoria", "nome_categoria", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_SESSION['ProdPadre'], $_SESSION['Famiglia'], $_SESSION['Categoria'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $_SESSION['condizioneSelectProdotti'], $strUtentiAziende);
                $sqlAbil = findProdottiByFiltri("p.abilitato", "p.abilitato", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_SESSION['ProdPadre'], $_SESSION['Famiglia'], $_SESSION['Categoria'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $_SESSION['condizioneSelectProdotti'], $strUtentiAziende);
                $sqlDt = findProdottiByFiltri("p.dt_abilitato", "p.dt_abilitato", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_SESSION['ProdPadre'], $_SESSION['Famiglia'], $_SESSION['Categoria'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $_SESSION['condizioneSelectProdotti'], $strUtentiAziende);
                $sqlGru = findProdottiByFiltri("gruppo", "gruppo", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_SESSION['ProdPadre'], $_SESSION['Famiglia'], $_SESSION['Categoria'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $_SESSION['condizioneSelectProdotti'], $strUtentiAziende);
            
                
            } else if (isset($_GET['IdProdottoPadre']) AND $_GET['IdProdottoPadre'] != "") {

                //Visualizzazzione dei prodotti figli
                $sql = findProdottiFigliByFiltri($_SESSION['Filtro'], "p.id_prodotto", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_GET['IdProdottoPadre'], $_SESSION['Famiglia'], $_SESSION['Categoria'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $strUtentiAziende);
                $sqlId = findProdottiFigliByFiltri("p.id_prodotto", "p.id_prodotto", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_GET['IdProdottoPadre'], $_SESSION['Famiglia'], $_SESSION['Categoria'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $strUtentiAziende);
                $sqlCod = findProdottiFigliByFiltri("cod_prodotto", "cod_prodotto", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_GET['IdProdottoPadre'], $_SESSION['Famiglia'], $_SESSION['Categoria'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $strUtentiAziende);
                $sqlNome = findProdottiFigliByFiltri("nome_prodotto", "nome_prodotto", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_GET['IdProdottoPadre'], $_SESSION['Famiglia'], $_SESSION['Categoria'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $strUtentiAziende);
                $sqlPad = findProdottiFigliByFiltri("p.id_prodotto", "p.id_prodotto", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_GET['IdProdottoPadre'], $_SESSION['Famiglia'], $_SESSION['Categoria'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $strUtentiAziende);
                $sqlFam = findProdottiFigliByFiltri("cod.descrizione", "cod.descrizione", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_GET['IdProdottoPadre'], $_SESSION['Famiglia'], $_SESSION['Categoria'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $strUtentiAziende);
                $sqlCat = findProdottiFigliByFiltri("nome_categoria", "nome_categoria", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_GET['IdProdottoPadre'], $_SESSION['Famiglia'], $_SESSION['Categoria'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $strUtentiAziende);
                $sqlAbil = findProdottiFigliByFiltri("p.abilitato", "p.abilitato", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_GET['IdProdottoPadre'], $_SESSION['Famiglia'], $_SESSION['Categoria'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $strUtentiAziende);
                $sqlDt = findProdottiFigliByFiltri("p.dt_abilitato", "p.dt_abilitato", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_GET['IdProdottoPadre'], $_SESSION['Famiglia'], $_SESSION['Categoria'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $strUtentiAziende);
                $sqlGru = findProdottiFigliByFiltri("a.gruppo", "a.gruppo", $_SESSION['IdProdotto'], $_SESSION['Codice'], $_SESSION['Nome'], $_GET['IdProdottoPadre'], $_SESSION['Famiglia'], $_SESSION['Categoria'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Gruppo'], $strUtentiAziende);
            }

            commit();
            $trovati = mysql_num_rows($sql);


            include('./moduli/visualizza_anagrafe_prodotti.php');
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
