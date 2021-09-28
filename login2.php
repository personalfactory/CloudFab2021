<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <?php
        ini_set('display_errors', 1);
        include('./include/header.php');
        $DEBUG = 1;
        ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
            //##################################################################
            if (isset($_POST['username']) && $_POST['password']) {

                //Apro la connessione al db
                include('./Connessioni/serverdb.php');
                include('./sql/script_utente.php');
                include('./sql/script_figura.php');
                include('include/gestione_date.php');
                //############ MENU #############################
                //include('./Connessioni/dbutente.php');
                include('./permessi/recupero_permessi_menu.php');
                include('./permessi/classi_permessi_menu.php');
                include('./sql/script_permessi_menu.php');
                //########### PERMESSI ##########################
                include('./sql/script_permessi_utente.php');
                include('./permessi/classi_permessi_utente.php');
                include('./permessi/recupero_permessi_utente.php');

                //Inizializzazione variabili
                $sessioniAssociate = false;
                $credenzialiCorrette = false;
                $tempoSessioneScaduto = false;

                //##############################################################
                //############## CODIFICA DELLA PASSWORD #######################
                //##############################################################

                $username = str_replace("'", "''", $_POST['username']);
                $password = str_replace("'", "''", $_POST['password']);
                ########################################################
                $lingua = $_POST['lingua'];
                switch ($lingua) {
                    case 1:
                        include ('./lingue/it.php');
                        break;
                    case 2:
                        include ('./lingue/en.php');
                        break;
                    case 3:
                        include ('./lingue/fr.php');
                        break;
                }
                ########################################################

                $Salt = "tupelle";
                $password = crypt($password, $Salt);

                $sqlUtente = validaUtente($username, $password);

                if (mysql_num_rows($sqlUtente) != 0) {
                    //Se username e password corretti
                    $credenzialiCorrette = true;

                    //Recupero dal db l'id utente 
                    $row = mysql_fetch_assoc($sqlUtente);
                    $idUtente = $row['id_utente'];
                    $nominativo = $row['nome'] . " " . $row['cognome'];
                    //####################################################################
                    //### CONTROLLO SE CI SONO ALTRE SESSIONI ASSOCIATE ALL'UTENTE NEL DB 
                    //####################################################################

                    $sqlSess = verificaEsistenzaSessione($idUtente);
                    if (mysql_num_rows($sqlSess) != 0) { //Se esistono altre sessioni per lo stesso utente
                        $sessioniAssociate = true;

                        //###############################################################
                        //############### CONTROLLO TEMPO DI INATTIVITA DELL'UTENTE #####
                        //###############################################################

                        $sqlUtente = verificaTempoSessione($idUtente);
                        //Controllo sull'ultimo accesso dell'utente
                        while ($rowTime = mysql_fetch_array($sqlUtente)) {
                            $dtUltimaModifica = $rowTime['dt_ultima_modifica'];
                            $dtNow = $rowTime['now'];
                            $timeInattivita = $rowTime['tempo_inattivita'];
                        }

                        //############ SE TEMPO NON SCADUTO (SESSIONE ATTIVA) ##########          
                        if ($timeInattivita < 10) {

//                            echo "</br>Data di ultima modifica della sessione :" . $dtUltimaModifica;
//                            echo "</br>Data attuale : " . $dtNow;
                            echo '</br>' . $msgUtenteLoggato;
                            echo '</br>' . $msgAttendere . ' ' . '<a href="/CloudFab/login.php"> ' . $msgLogin . ' </a>';
                        } else {

                            $tempoSessioneScaduto = true;
                            //##### SE LA VECCHIA SESSIONE ASSOCIATA ALL'UTENTE E' SCADUTA ###   
                            //Elimino dal db l'associazione vecchia sessione - id_utente
                            eliminaSessioneOldDb($idUtente);
                        }
                    }
                    //##############################################################
                    //############# CREAZIONE NUOVA SESSIONE #######################
                    //##############################################################

                    if (($credenzialiCorrette AND $sessioniAssociate AND $tempoSessioneScaduto) OR
                            ($credenzialiCorrette AND !$sessioniAssociate)) {

                        session_start();
                        session_unset();
                        session_destroy();
                        session_start(); //Apro una nuova sessione	

                        $_SESSION['dt_accesso'] = dataCorrenteInserimento();
                        $_SESSION['username'] = $username;
                        $_SESSION['password'] = $password;
                        $_SESSION['id_utente'] = $idUtente;
                        $_SESSION['nominativo_utente'] = $nominativo;
                        $_SESSION['aggiornamento'] = 0;
                        $_SESSION['lingua'] = $lingua;


                        //include('./include/header.php');

                        //Seleziono il gruppo di appartenenza dell'utente 
                        $sqlGruppo = findGruppoUtenteByIdUtente($_SESSION['id_utente']);
                        while ($rowGruppo = mysql_fetch_array($sqlGruppo)) {

                            $_SESSION['id_gruppo_utente'] = $rowGruppo['id_gruppo_utente'];
                            $_SESSION['nome_gruppo_utente'] = $rowGruppo['nome_gruppo_utente'];
                        }
                        //#############################################################    
                        //###################### RECUPERO IL GRUPPO E RIF GEO #########
                        ////###########################################################
                        //Recupero del gruppo e del riferimento geo nel caso in cui l'utente 
                        //che effettua il login sia un operatore macchina  
                        //Si cerca nella tabella utente_figura l'associazione con l'operatore
                        //Se esiste si settano le variabili di sessione che altrimenti restano vuote
                        $_SESSION['GruppoOperatore'] = "";
                        $_SESSION['GeograficoOperatore'] = "";
                        $sqlGrupGeoOp = selectUtenteFigura($_SESSION['id_utente']);
                        while ($rowGruppoOp = mysql_fetch_array($sqlGrupGeoOp)) {

                            $_SESSION['GruppoOperatore'] = $rowGruppoOp['gruppo'];
                            $_SESSION['GeograficoOperatore'] = $rowGruppoOp['geografico'];
                        }

                        //###############################################################       
                        //########## SALVO LA NUOVA SESSIONE SUL DB #####################
                        //############################################################### 
                        $lastNumAccesso=0;
                        $sqlAccesso=selectNumAccessoByUtente($_SESSION['id_utente']);
                        while ($row1 = mysql_fetch_array($sqlAccesso)) {
                            $lastNumAccesso=$row1['num_accesso'];
                        }
                        $lastNumAccesso=$lastNumAccesso+1;
                        
                        aggiornaNumAccesso($_SESSION['id_utente'],$lastNumAccesso);
                        
                        
                        inserisciNuovaSessioneDb($_SESSION['id_utente'], session_id());

                        //##############################################################
                        //################# GENERAZIONE MENU ###########################
                        //##############################################################
			include('./Connessioni/dbutente.php');
                        $_SESSION['objectMenuUtente'] = generaMenuUtenteCorrente($idUtente, $username);

                        //######################################################
                        //############ RECUPERO PERMESSI #######################
                        //######################################################
//                        echo "inizio recupero permessi";
                        $_SESSION['objPermessiVis'] = getObjectPermessiVisualizzazione($idUtente);
//                        echo "fine recupero permessi";
                        $_SESSION['objUtility'] = getObjectDataUtility();
                        
                        //Recupero l'azienda di appartenenza dell'utente loggato
                        $_SESSION['id_azienda'] = $_SESSION['objPermessiVis']->getObjAziendaAppartenenza()->getIdAzienda();
                        $_SESSION['nome_azienda'] = $_SESSION['objPermessiVis']->getObjAziendaAppartenenza()->getNomeAzienda();
                        $_SESSION['visibilita_utente'] = $_SESSION['objPermessiVis']->getVisibilita();
//                       
//LOG ########################################################################
//                        if ($DEBUG) {
                             
//                            echo "</br>############ objectPermessiVisualizzazione ##############";
//                                                        
//                            echo "</br>############ Elenco dei permessi dell'utente corrente #########</br>";
//                            echo "ID_UTENTE CORRENTE : " . $_SESSION['objPermessiVis']->getIdUtente()
//                            . "  -- NOME UTENTE CORRENTE : " . $_SESSION['objPermessiVis']->getNomeUtente() 
//                            . "  -- VISIBILITA UTENTE CORRENTE : " . $_SESSION['objPermessiVis']->getVisibilita() . "</br>";
//                            echo "arrayUtentiProprietariPerTabella </br>";
//                            $arrayTab = $_SESSION['objPermessiVis']->getArrayTabelleProprietari();
////  print_r($arrayTab);
//                            for ($i = 0; $i < count($arrayTab); $i++) {
//                                echo "i=" . $i . "</br> ID_TABELLA:"
//                                . $arrayTab[$i]->getIdTabella()
//                                . "  -- NOME : " . $arrayTab[$i]->getNomeTabella() . "  ";
//
//                                $nomeTabella = $arrayTab[$i]->getNomeTabella();
//                                echo " -- STRINGA CONTENENTE GLI ID : " . $_SESSION['objPermessiVis']->getMysqlStringUtentiProprietariPerTabella($nomeTabella) . "</br>";
//
//                                $arrayUt = $arrayTab[$i]->getArrayUtentiPropVisib();
//
//                                for ($k = 0; $k < count($arrayUt); $k++) {
//
//                                    echo $arrayUt[$k]->getNomeUtente()." visibilità: ".$arrayUt[$k]->getVisibilita()."</br>";
//                                }
//                            }
//                            echo "</br>#############################################################</br>";
//                        }
                        ?>
                        <script type="text/javascript">
                            location.href = "/CloudFab/index.php?lingua=<?php echo $_SESSION['lingua'] ?>";
                        </script>
                        <?php
                    }
                } else {
                    //###############################################################       
                    //########### USERNAME E PASSWORD NON TROVATE NEL DB  ###########
                    //###############################################################

                    echo $msgErrUserPass . ' <a href="/CloudFab/login.php">' . $msgRicontrollaDati . '</a>';
                }
            } else {
                //##############################################################       
                //########### USERNAME E PASSWORD NON DIGITATE  ################
                //##############################################################
                ?>
                <script type="text/javascript">
                    location.href = "/CloudFab/login.php";
                </script>
                <?php
            }
            ?>
        </div>
    </body>
</html>
