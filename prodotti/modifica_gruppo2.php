<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
            ini_set(display_errors, "1");
            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../Connessioni/storico.php');
            include('../sql/script.php');
            include('../sql/script_gruppo.php');
            include('../sql/script_anagrafe_prodotto.php');
            include('../sql/script_anagrafe_macchina.php');

            $IdGruppo = $_POST['IdGruppo'];
            $PrimoLivello = str_replace("'", "''", $_POST['PrimoLivello']);
            $SecondoLivello = str_replace("'", "''", $_POST['SecondoLivello']);
            $TerzoLivello = str_replace("'", "''", $_POST['TerzoLivello']);
            $QuartoLivello = str_replace("'", "''", $_POST['QuartoLivello']);
            $QuintoLivello = str_replace("'", "''", $_POST['QuintoLivello']);
            $SestoLivello = str_replace("'", "''", $_POST['SestoLivello']);

            //########### CONTROLLO INPUT ######################################
            $errore = false;
            $messaggio = $msgErroreVerificato . '<br />';

            if (!isset($PrimoLivello) || trim($PrimoLivello) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroPrimoLivello . '!<br />';
            }
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

            //##################### VERIFICA ESISTENZA #########################

            $result = findGruppoByLivAndId($IdGruppo, $PrimoLivello);

            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che il valore appena inserito esiste 
                //in archivio
                $errore = true;
                $messaggio = $messaggio . ' ' . $msgDuplicaRecord . '!<br />';
            }


            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo '<div id="msgErr">' . $messaggio . '</div>';
            } else {

                //############## INIZIO TRANSAZIONE ################################
                begin();
                $erroreTransazione = false;
                $storicizzoGruppo = true;
                $storicizzoAnProd = true;
                $modificoAnProd = true;
                $storicizzoAnMac = true;
                $modificoAnMac = true;
                $modificoGruppo = true;

                //#################### STORICIZZO IL GRUPPO ########################

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


                //Inserisco in storico di gruppo
                $storicizzoGruppo = insertStoricoGruppo($id_gruppo_old, $livello_1_old, $livello_2_old, $livello_3_old, $livello_4_old, $livello_5_old, $livello_6_old, $abilitato, dataCorrenteInserimento());

                //#################### STORICIZZO ANAGRAFE PRODOTTO ############
                //Seleziono i/il record contenente il vecchio gruppo, 
                //da inserire nello storico dell'anagrafe_prodotto 
                //e memorizzo il contenuto dei vari campi
                //Devo verificare il livello_gruppo in anagrafe prodotto

                $sqlAnProd = selectAnProdByLivAndGruppo("PrimoLivello", $livello_1_old);
                while ($rowAnProd = mysql_fetch_array($sqlAnProd)) {

                    $id_prodotto = $rowAnProd['id_prodotto'];
                    $colorato = $rowAnProd['colorato'];
                    $lim_colore = $rowAnProd['lim_colore'];
                    $fattore_div = $rowAnProd['fattore_div'];
                    $fascia = $rowAnProd['fascia'];
                    $id_mazzetta = $rowAnProd['id_mazzetta'];
                    $id_codice = $rowAnProd['id_codice'];
                    $geografico = $rowAnProd['geografico'];
                    $tipo_riferimento = $rowAnProd['tipo_riferimento'];
                    $gruppo = $rowAnProd['gruppo'];
                    $livello_gruppo = $rowAnProd['livello_gruppo'];
                    $id_cat = $rowAnProd['id_cat'];
                    $abilitato = $rowAnProd['abilitato'];
                    $dt_abilitato = $rowAnProd['dt_abilitato'];

                    //Inserisco nello storico dell'anagrafe_prodotti                   
                    $storicizzoAnProd = insertStoricoAnagrafeProdotto($id_prodotto, $colorato, $lim_colore, $fattore_div, $fascia, $id_mazzetta, $id_codice,$geografico, $tipo_riferimento, $gruppo, $livello_gruppo, $id_cat, $abilitato, $dt_abilitato);
                    if (!$storicizzoAnProd)
                        $erroreTransazione = true;
                }//End while an_prod
                //############### MODIFICO ANAGRAFE PRODOTTO ###################
                //Modifico il campo gruppo nella tabella anagrafe_prodotto 
                //di serverdb solo se si tratta di 'PrimoLivello'
                $modificoAnProd = updateGruppoAnagrafeProdotto($PrimoLivello, $livello_1_old, "PrimoLivello", dataCorrenteInserimento());

                //#################### STORICIZZO ANAGRAFE MACCHINA ############
                //Devo verificare il tipo riferimento in anagrafe macchina

                $sqlAnStab = selectAnMacchinaByLivAndGruppo($livello_1_old,"PrimoLivello");                       

                while ($rowAnStab = mysql_fetch_array($sqlAnStab)) {

                    $id_macchina = $rowAnStab['id_macchina'];
                    $id_lingua = $rowAnStab['id_lingua'];
                    $id_cliente_gaz = $rowAnStab['id_cliente_gaz'];
                    $geografico = $rowAnStab['geografico'];
                    $tipo_riferimento = $rowAnStab['tipo_riferimento'];
                    $gruppo = $rowAnStab['gruppo'];
                    $livello_gruppo = $rowAnStab['livello_gruppo'];
                    $abilitato = $rowAnStab['abilitato'];
                    $dt_abilitato = $rowAnStab['dt_abilitato'];

                    //Inserisco nello storico dell'anagrafe_macchina i valori appena memorizzati del  record contenente il vecchio comune	
                    $storicizzoAnMac = insertStoricoAnMacchina($id_macchina, $id_lingua, $id_cliente_gaz, $geografico, $tipo_riferimento, $gruppo, $livello_gruppo, $abilitato, $dt_abilitato);
                    if (!$storicizzoAnMac)
                        $erroreTransazione = true;
                }//End while an_stab
                
                //############# MODIFICO ANAGRAFE MACCHINA #####################

                $modificoAnMac = updateAnMacchinaGruppo($PrimoLivello, $livello_1_old,"PrimoLivello", dataCorrenteInserimento());

                //############# MODIFICO GRUPPO ################################                
                $modificoGruppo = updateServerDBGruppo($IdGruppo, $PrimoLivello, $SecondoLivello, $TerzoLivello, $QuartoLivello, $QuintoLivello, $SestoLivello, dataCorrenteInserimento());

//occorre andare a modificare il campo gruppo nelle tabelle [anagrafe_macchina] e [anagrafe_prodotto] 	


                if ($erroreTransazione OR
                        !$storicizzoGruppo OR
                        !$storicizzoAnProd OR
                        !$modificoAnProd OR
                        !$storicizzoAnMac OR
                        !$modificoAnMac OR
                        !$modificoGruppo
                ) {

                    rollback();
                     echo $msgErroreVerificato." ". $msgErrContactAdmin;
                    echo "</br>erroreTransazione : " . $erroreTransazione;
                    echo "</br>storicizzazioneGruppo : " . $storicizzoGruppo;
                    echo "</br>storicizzazioneAnagrafeProd : " . $storicizzoAnProd;
                    echo "</br>modificaAnagrafeProd : " . $modificoAnProd;
                    echo "</br>storicizzazioneAnagrafeMacchina : " . $storicizzoAnMac;
                    echo "</br>modificaAnagrafeMacchina : " . $modificoAnMac;
                    echo "</br>modificaGruppo : " . $modificoGruppo."</br>";
                   
                } else {

                    commit();
                   echo $msgInfoTransazioneRiuscita."</br>";
                }?>
                <a href="/CloudFab/prodotti/gestione_gruppi.php"><?php echo $msgTornaAiGruppi ?></a>	
            <?php }
            ?>