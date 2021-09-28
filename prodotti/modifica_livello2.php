<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
//            ini_set(display_errors,"1");
            include('../include/menu.php');
            include('../include/gestione_date.php');

            $IdGruppo = $_POST['IdGruppo'];
            $SecondoLivello = str_replace("'", "''", $_POST['SecondoLivello']);
            $TerzoLivello = str_replace("'", "''", $_POST['TerzoLivello']);
            $QuartoLivello = str_replace("'", "''", $_POST['QuartoLivello']);
            $QuintoLivello = str_replace("'", "''", $_POST['QuintoLivello']);
            $SestoLivello = str_replace("'", "''", $_POST['SestoLivello']);

//########### CONTROLLO INPUT ############################################
            $errore = false;
            $messaggio = $msgErroreVerificato . '<br />';

            if (!isset($SecondoLivello) || trim($SecondoLivello) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroSecondoLivello . '!<br />';
            }
            if (!isset($TerzoLivello) || trim($TerzoLivello) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroTerzoLivello . '!<br />';
            }
            if (!isset($QuartoLivello) || trim($QuartoLivello) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroQuartoLivello . '!<br />';
            }
            if (!isset($QuintoLivello) || trim($QuintoLivello) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroQuintoLivello . '!<br />';
            }
            if (!isset($SestoLivello) || trim($SestoLivello) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroSestoLivello . '!<br />';
            }


            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';


            if ($errore) {
                //Ci sono errori quindi non salvo
                echo '<div id="msgErr>"' . $messaggio . '</div>';
            } else {
                //Vado avanti, non ci sono errori
                //Seleziono il vecchio record  dei gruppi,  in questo caso particolare (a differenza della tabella comuni)  verr� effettuato l'inserimento nella tabella storica [gruppo].
                //Verranno  inoltre conservati i corrispondenti record delle anagrafe prodotto e macchina

                include('../Connessioni/serverdb.php');
                include('../sql/script.php');
                include('../sql/script_gruppo.php');
                include('../sql/script_anagrafe_prodotto.php');
                include('../sql/script_anagrafe_macchina.php');
                //############ INIZIO TRANSAZIONE ######################################
                begin();
                $erroreTransazione = false;
                $storicizzoGruppo = true;
                $storicizzoAnProd = true;
                $modificaAnProdSecLiv = true;
                $modificaAnProdTerzoLiv = true;
                $modificaAnProdQuartoLiv = true;
                $modificaAnProdQuintoLiv = true;
                $modificaAnProdSestoLiv = true;

                $storicizzoAnMacchina = true;
                $modificoAnMacLiv2 = true;
                $modificoAnMacLiv3 = true;
                $modificoAnMacLiv4 = true;
                $modificoAnMacLiv5 = true;
                $modificoAnMacLiv6 = true;

                $modificaGruppoLiv2 = true;
                $modificaGruppoLiv3 = true;
                $modificaGruppoLiv4 = true;
                $modificaGruppoLiv5 = true;
                $modificaGruppoLiv6 = true;



                $sqlGruppo = findGruppoById($IdGruppo);
                while ($rowGruppo = mysql_fetch_array($sqlGruppo)) {
                    $id_gruppo_old = $rowGruppo['id_gruppo'];
                    $livello_1_old = $rowGruppo['livello_1'];
                    $livello_2_old = $rowGruppo['livello_2'];
                    $livello_3_old = $rowGruppo['livello_3'];
                    $livello_4_old = $rowGruppo['livello_4'];
                    $livello_5_old = $rowGruppo['livello_5'];
                    $livello_6_old = $rowGruppo['livello_6'];
                    $abilitato = $rowGruppo['abilitato'];
                    $dt_abilitato = $rowGruppo['dt_abilitato'];
                }

                include('../Connessioni/storico.php');

                //############### STORICIZZO GRUPPO ####################################
                //Inserisco in storico di gruppo
                $storicizzoGruppo = insertStoricoGruppo($id_gruppo_old, $livello_1_old, $livello_2_old, $livello_3_old, $livello_4_old, $livello_5_old, $livello_6_old, $abilitato, dataCorrenteInserimento());


                //Seleziono i record da modificare in anagrafe_prodotto, 
                //ovvero quelli contenenti il gruppo da modificare 	
                $sqlAnProd = selectAnagrafeProdottoByLivelliSuperiori($livello_2_old, $livello_3_old, $livello_4_old, $livello_5_old, $livello_6_old, $connessione);
                //Inizio ciclo di inserimento di record nello storico e modifica di anagrafe_prodotto su serverdb
                while ($row = mysql_fetch_array($sqlAnProd)) {
                    $id_prodotto = $row['id_prodotto'];
                    $colorato = $row['colorato'];
                    $lim_colore = $row['lim_colore'];
                    $fattore_div = $row['fattore_div'];
                    $fascia = $row['fascia'];
                    $id_mazzetta = $row['id_mazzetta'];
                    $id_codice = $row['id_codice'];
                    $geografico = $row['geografico'];
                    $tipo_riferimento = $row['tipo_riferimento'];
                    $gruppo = $row['gruppo'];
                    $livello_gruppo = $row['livello_gruppo'];
                    $id_cat = $row['id_cat'];
                    $abilitato = $row['abilitato'];
                    $dt_abilitato = $row['dt_abilitato'];

                    //Inserisco nello storico dell'anagrafe_prodotti i valori appena memorizzati del  record contenente il vecchio gruppo	

                    $storicizzoAnProd = insertStoricoAnagrafeProdotto($id_prodotto, $colorato, $lim_colore, $fattore_div, $fascia, $id_mazzetta,$id_codice, $geografico, $tipo_riferimento, $gruppo, $livello_gruppo, $id_cat, $abilitato, $dt_abilitato);

                    //############### MODIFICO ANAGRAFE PRODOTTO ###################
                    //Modifico il campo gruppo nella tabella anagrafe_prodotto di serverdb
                    $modificaSecLiv = updateGruppoAnagrafeProdotto($SecondoLivello, $livello_2_old, "SecondoLivello", dataCorrenteInserimento());
                    $modificaTerzoLiv = updateGruppoAnagrafeProdotto($TerzoLivello, $livello_3_old, "TerzoLivello", dataCorrenteInserimento());
                    $modificaQuartoLiv = updateGruppoAnagrafeProdotto($QuartoLivello, $livello_4_old, "QuartoLivello", dataCorrenteInserimento());
                    $modificaQuintoLiv = updateGruppoAnagrafeProdotto($QuintoLivello, $livello_5_old, "QuintoLivello", dataCorrenteInserimento());
                    $modificaSestoLiv = updateGruppoAnagrafeProdotto($SestoLivello, $livello_6_old, "SestoLivello", dataCorrenteInserimento());

                    //Controllo errori
                    if (!$storicizzoAnProd OR !$modificaAnProdSecLiv OR !$modificaAnProdTerzoLiv OR !$modificaAnProdQuartoLiv OR !$modificaAnProdQuintoLiv OR !$modificaAnProdSestoLiv)
                        $erroreTransazione = true;
                }//End ciclo di inserimento in anagrafe_prodotto storico e modifica di anagrafe_prodotto su serverdb
                //############# STORICIZZO ANAGRAFE MACCHINA #######################

                $sqlAnStab = selectAnagrafeMacchinaByLivelliSuperiori($livello_2_old, $livello_3_old, $livello_4_old, $livello_5_old, $livello_6_old, $connessione);
                //Inizio ciclo di inserimento di record nello storico 
                while ($row = mysql_fetch_array($sqlAnStab)) {
                    $id_macchina = $row['id_macchina'];
                    $id_lingua = $row['id_lingua'];
                    $id_cliente_gaz = $row['id_cliente_gaz'];
                    $geografico = $row['geografico'];
                    $tipo_riferimento = $row['tipo_riferimento'];
                    $gruppo = $row['gruppo'];
                    $livello_gruppo = $row['livello_gruppo'];
                    $abilitato = $row['abilitato'];
                    $dt_abilitato = $row['dt_abilitato'];

                    //Inserisco nello storico dell'anagrafe_macchina i valori appena memorizzati del  record contenente il vecchio gruppo		
                    $storicizzoAnMacchina = insertStoricoAnMacchina($id_macchina, $id_lingua, $id_cliente_gaz, $geografico, $tipo_riferimento, $gruppo, $livello_gruppo, $abilitato, $dt_abilitato);

                    //############# MODIFICO ANAGRAFE MACCHINA #############
                    //Modifico il campo gruppo nella tabella anagrafe_macchina di serverdb
                    $modificoAnMacLiv2 = updateAnMacchinaGruppo($SecondoLivello, $livello_2_old, "SecondoLivello", dataCorrenteInserimento());
                    $modificoAnMacLiv3 = updateAnMacchinaGruppo($TerzoLivello, $livello_3_old, "TerzoLivello", dataCorrenteInserimento());
                    $modificoAnMacLiv4 = updateAnMacchinaGruppo($QuartoLivello, $livello_4_old, "QuartoLivello", dataCorrenteInserimento());
                    $modificoAnMacLiv5 = updateAnMacchinaGruppo($QuintoLivello, $livello_5_old, "QuintoLivello", dataCorrenteInserimento());
                    $modificoAnMacLiv6 = updateAnMacchinaGruppo($SestoLivello, $livello_6_old, "SestoLivello", dataCorrenteInserimento());

                    //Controllo errori
                    if (!$storicizzoAnMacchina OR !$modificoAnMacLiv2 OR !$modificoAnMacLiv3 OR !$modificoAnMacLiv4 OR !$modificoAnMacLiv5 OR !$modificoAnMacLiv6)
                        $erroreTransazione = true;
                }//End ciclo di inserimento in anagrafe_macchina storico e modifica di anagrafe_prodotto su serverdb
                

                //################ MODIFICO GRUPPO #############################
                
                //Modifico la tabella corrente gruppo di serverdb

                $modificaGruppoLiv2 = updateCampoGruppo("livello_2", $SecondoLivello, $livello_2_old);
                $modificaGruppoLiv3 = updateCampoGruppo("livello_3", $TerzoLivello, $livello_3_old);
                $modificaGruppoLiv4 = updateCampoGruppo("livello_4", $QuartoLivello, $livello_4_old);
                $modificaGruppoLiv5 = updateCampoGruppo("livello_5", $QuintoLivello, $livello_5_old);
                $modificaGruppoLiv6 = updateCampoGruppo("livello_6", $SestoLivello, $livello_6_old);

                if ($erroreTransazione OR
                        !$storicizzoGruppo OR
                        !$modificaGruppoLiv2 OR
                        !$modificaGruppoLiv3 OR
                        !$modificaGruppoLiv4 OR
                        !$modificaGruppoLiv5 OR
                        !$modificaGruppoLiv6
                ) {

                    rollback();
                    echo $msgErroreVerificato . " " . $msgErrContactAdmin;
                } else {

                    commit();
                    echo $msgInfoTransazioneRiuscita . "</br>";
                }
                ?>
                <a href="gestione_gruppi.php"><?php echo $msgTornaAiGruppi ?></a>	
            <?php }
            ?>
