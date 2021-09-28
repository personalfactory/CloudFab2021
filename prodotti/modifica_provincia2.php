<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../include/gestione_date.php');

           

            $IdComune = $_POST['IdComune'];
            $CodiceProvincia = str_replace("'", "''", $_POST['CodiceProvincia']);
            $Provincia = str_replace("'", "''", $_POST['Provincia']);
            $CodiceRegione = str_replace("'", "''", $_POST['CodiceRegione']);
            $Regione = str_replace("'", "''", $_POST['Regione']);
            $CodiceStato = str_replace("'", "''", $_POST['CodiceStato']);
            $Stato = str_replace("'", "''", $_POST['Stato']);
            $Continente = str_replace("'", "''", $_POST['Continente']);
            $Mondo = str_replace("'", "''", $_POST['Mondo']);

//Gestione degli errori
            $errore = false;
            $messaggio = $msgErroreVerificato . '<br />';

            if (!isset($CodiceProvincia) || trim($CodiceProvincia) == "") {
                $CodiceProvincia = "_";
            }
            if (!isset($Provincia) || trim($Provincia) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroProvincia . '!<br />';
            }
            if (!isset($CodiceRegione) || trim($CodiceRegione) == "") {
                $CodiceRegione = "_";
            }
            if (!isset($Regione) || trim($Regione) == "") {
                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroRegione . '!<br />';
            }
            if (!isset($CodiceStato) || trim($CodiceStato) == "") {
                $CodiceStato = "_";
            }
            if (!isset($Stato) || trim($Stato) == "") {
                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroStato . '!<br />';
            }
            if (!isset($Continente) || trim($Continente) == "") {
                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroContinente . '!<br />';
            }


//Verifica esistenza niente

            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';


            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {
                //Vado avanti, non ci sono errori
                //Seleziono il vecchio record  dei comuni, ma in questo caso particolare (relativo alla tabella comuni) non verr� effettuato l'inserimento nella tabella storica [comune], verranno invece conservati i corrispondenti record delle anagrafe prodotto e macchina

                include('../Connessioni/storico.php');
                include('../Connessioni/serverdb.php');
                include('../sql/script.php');
                include('../sql/script_comune.php');
                include('../sql/script_anagrafe_prodotto.php');
                include('../sql/script_anagrafe_macchina.php');



                begin();

                $insStoAnProd = true;
                $updateProvinciaAnProd = true;
                $updateRegioneAnProd = true;
                $updateStatoAnProd = true;
                $updateContinenteAnProd = true;

                $insStoAnMac = true;
                $updateProvinciaAnMac = true;
                $updateRegioneAnMac = true;
                $updateStatoAnMac = true;
                $updateContinenteAnMac = true;

                $updateProvinciaInComune = true;
                $updateRegioneInComune = true;
                $updateStatoInComune = true;
                $updateContinenteInComune = true;

                /*
                  $selectComune="SELECT
                  id_comune,
                  cap,
                  cod_cat,
                  cod_istat,
                  comune,
                  cod_prov,
                  provincia,
                  cod_reg,
                  regione,
                  cod_stat,
                  stato,
                  continente,
                  mondo,
                  abilitato,
                  dt_abilitato
                  FROM
                  serverdb.comune
                  WHERE
                  id_comune='".$IdComune."'";
                  $sqlComune=mysql_query($selectComune,$connessione) or die("Errore 116: " . mysql_error());
                 */
                $sqlComune = selectComuneById($IdComune);

                while ($rowComune = mysql_fetch_array($sqlComune)) {

                    $id_comune_old = $rowComune['id_comune'];
                    $cod_prov_old = $rowComune['cod_prov'];
                    $provincia_old = $rowComune['provincia'];
                    $cod_reg_old = $rowComune['cod_reg'];
                    $regione_old = $rowComune['regione'];
                    $cod_stat_old = $rowComune['cod_stat'];
                    $stato_old = $rowComune['stato'];
                    $continente_old = $rowComune['continente'];
                    $mondo_old = $rowComune['mondo'];
                    $abilitato = $rowComune['abilitato'];
                    $dt_abilitato = $rowComune['dt_abilitato'];
                }

/////////////////////PRODOTTI///////////////////////////////////////////////////		
                //Seleziono i record da modificare in anagrafe_prodotto, ovvero quelli contenenti il rif geografico da modificare 
                /*
                  $queryAnProd="SELECT
                  id_prodotto,colorato,lim_colore,fattore_div,fascia,id_mazzetta,
                  geografico,tipo_riferimento,gruppo,livello_gruppo,
                  id_cat,abilitato,dt_abilitato
                  FROM
                  serverdb.anagrafe_prodotto
                  WHERE
                  (tipo_riferimento='Provincia' AND geografico='".$provincia_old."')
                  OR
                  (tipo_riferimento='Regione' AND geografico='".$regione_old."')
                  OR
                  (tipo_riferimento='Stato' AND geografico='".$stato_old."')
                  OR
                  (tipo_riferimento='Continente' AND geografico='".$continente_old."')
                  OR
                  (tipo_riferimento='Mondo' AND geografico='".$mondo_old."')";


                  $sqlAnProd=mysql_query($queryAnProd,$connessione) or die("Errore 117: " . mysql_error());
                 */
                $sqlAnProd = selectAnagrafeProdottoByRiferimentiSuperiori($provincia_old, $regione_old, $stato_old, $continente_old, $mondo_old);


                //Inizio ciclo di inserimento di record nello storico e modifica di anagrafe_prodotto su serverdb
                while ($row = mysql_fetch_array($sqlAnProd)) {

                    $id_prodotto = $row['id_prodotto'];
                    $colorato = $row['colorato'];
                    $lim_colore = $row['lim_colore'];
                    $fattore_div = $row['fattore_div'];
                    $fascia = $row['fascia'];
                    $id_mazzetta = $row['id_mazzetta'];
                    $geografico = $row['geografico'];
                    $tipo_riferimento = $row['tipo_riferimento'];
                    $gruppo = $row['gruppo'];
                    $livello_gruppo = $row['livello_gruppo'];
                    $id_cat = $row['id_cat'];
                    $abilitato = $row['abilitato'];
                    $dt_abilitato = $row['dt_abilitato'];


                    //Inserisco nello storico dell'anagrafe_prodotti i valori appena memorizzati del  record contenente il vecchio comune	



                    /*
                      mysql_query("INSERT INTO storico.anagrafe_prodotto
                      (id_prodotto,colorato,lim_colore,fattore_div,fascia,id_mazzetta,
                      geografico,tipo_riferimento,gruppo,livello_gruppo,
                      id_cat,abilitato,dt_abilitato)
                      VALUES(
                      ".$id_prodotto.",
                      '".$colorato."',
                      ".$lim_colore.",
                      ".$fattore_div.",
                      ".$fascia.",
                      ".$id_mazzetta.",
                      '".$geografico."',
                      '".$tipo_riferimento."',
                      '".$gruppo."',
                      '".$livello_gruppo."',
                      ".$id_cat.",
                      ".$abilitato.",
                      '".$dt_abilitato."')")
                      or die("Errore 118: " . mysql_error());
                     */
                    $insStoAnProd = insertStoricoAnagrafeProdotto($id_prodotto, $colorato, $lim_colore, $fattore_div, $fascia, $id_mazzetta, $geografico, $tipo_riferimento, $gruppo, $livello_gruppo, $id_cat, $abilitato, $dt_abilitato);

                    //Modifico il campo geografico nella tabella anagrafe_prodotto di serverdb



                    $updateProvinciaAnProd = updateGeograficoAnagrafeProdotto($Provincia, $provincia_old, "Provincia", dataCorrenteInserimento());
                    $updateRegioneAnProd = updateGeograficoAnagrafeProdotto($Regione, $regione_old, "Regione", dataCorrenteInserimento());
                    $updateStatoAnProd = updateGeograficoAnagrafeProdotto($Stato, $stato_old, "Stato", dataCorrenteInserimento());
                    $updateContinenteAnProd = updateGeograficoAnagrafeProdotto($Continente, $continente_old, "Continente", dataCorrenteInserimento());


                    /*

                      mysql_query("UPDATE serverdb.anagrafe_prodotto
                      SET
                      geografico ='".$Provincia."',
                      dt_abilitato='".dataCorrenteInserimento()."'
                      WHERE
                      (tipo_riferimento ='Provincia' AND geografico='".$provincia_old."')")
                      or die("Query 71 fallita: " . mysql_error());
                      mysql_query("UPDATE serverdb.anagrafe_prodotto
                      SET
                      geografico ='".$Regione."',
                      dt_abilitato='".dataCorrenteInserimento()."'
                      WHERE
                      (tipo_riferimento='Regione' AND geografico='".$regione_old."')")
                      or die("Query 72 fallita: " . mysql_error());
                      mysql_query("UPDATE serverdb.anagrafe_prodotto
                      SET
                      geografico ='".$Stato."',
                      dt_abilitato='".dataCorrenteInserimento()."'
                      WHERE
                      (tipo_riferimento='Stato' AND geografico='".$stato_old."')" )
                      or die("Query 73 fallita: " . mysql_error());
                      mysql_query("UPDATE serverdb.anagrafe_prodotto
                      SET
                      geografico ='".$Continente."',
                      dt_abilitato='".dataCorrenteInserimento()."'
                      WHERE
                      (tipo_riferimento='Continente' AND geografico='".$continente_old."')")
                      or die("Query 74 fallita: " . mysql_error());

                     */
                }//End ciclo di inserimento in anagrafe_prodotto storico e modifica di anagrafe_prodotto su serverdb
/////////////////////MACCHINE////////////////////////////
//Seleziono i record da modificare in anagrafe_macchina, ovvero quelli contenenti il rif geografico da modificare 
                /*
                  $queryAnStab="SELECT
                  id_macchina,
                  id_lingua,
                  id_cliente_gaz,
                  geografico,
                  tipo_riferimento,
                  gruppo,
                  livello_gruppo,
                  abilitato,
                  dt_abilitato
                  FROM
                  serverdb.anagrafe_macchina
                  WHERE
                  (tipo_riferimento='Provincia' AND geografico='".$provincia_old."')
                  OR
                  (tipo_riferimento='Regione' AND geografico='".$regione_old."')
                  OR
                  (tipo_riferimento='Stato' AND geografico='".$stato_old."')
                  OR
                  (tipo_riferimento='Continente' AND geografico='".$continente_old."')
                  OR
                  (tipo_riferimento='Mondo' AND geografico='".$mondo_old."')";


                  $sqlAnStab=mysql_query($queryAnStab,$connessione) or die("Errore 137: " . mysql_error());
                 */
                $sqlAnStab = selectAnagrafeMacchinaByRiferimentiSuperiori($provincia_old, $regione_old, $stato_old, $continente_old, $mondo_old);

                //Inizio ciclo di inserimento di record nello storico e modifica di anagrafe_macchina su serverdb
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


                    //Inserisco nello storico dell'anagrafe_macchina i valori appena memorizzati del  record contenente il vecchio comune		
                    /*
                      mysql_query("INSERT INTO storico.anagrafe_macchina
                      (id_macchina,
                      id_lingua,
                      id_cliente_gaz,
                      geografico,
                      tipo_riferimento,
                      gruppo,
                      livello_gruppo,
                      abilitato,
                      dt_abilitato)
                      VALUES(
                      ".$id_macchina.",
                      '".$id_lingua."',
                      ".$id_cliente_gaz.",
                      '".$geografico."',
                      '".$tipo_riferimento."',
                      '".$gruppo."',
                      '".$livello_gruppo."',
                      ".$abilitato.",
                      '".$dt_abilitato."')")
                      or die("Errore 138: " . mysql_error());
                     */
                    $insStoAnMac = insertStoricoAnMacchina($id_macchina, $id_lingua, $id_cliente_gaz, $geografico, $tipo_riferimento, $gruppo, $livello_gruppo, $abilitato, $dt_abilitato);

                    //Modifico il campo geografico nella tabella anagrafe_macchina di serverdb
                    $updateProvinciaAnMac = updateGeograficoAnMacchina($Provincia, $provincia_old, "Provincia", dataCorrenteInserimento());
                    $updateRegioneAnMac = updateGeograficoAnMacchina($Regione, $regione_old, "Regione", dataCorrenteInserimento());
                    $updateStatoAnMac = updateGeograficoAnMacchina($Stato, $stato_old, "Stato", dataCorrenteInserimento());
                    $updateContinenteAnMac = updateGeograficoAnMacchina($Continente, $continente_old, "Continente", dataCorrenteInserimento());

                    /*
                      mysql_query("UPDATE serverdb.anagrafe_macchina
                      SET
                      geografico ='".$Provincia."',
                      dt_abilitato='".dataCorrenteInserimento()."'
                      WHERE
                      (tipo_riferimento ='Provincia' AND geografico='".$provincia_old."')")
                      or die("Query 91 fallita: " . mysql_error());
                      mysql_query("UPDATE serverdb.anagrafe_macchina
                      SET
                      geografico ='".$Regione."',
                      dt_abilitato='".dataCorrenteInserimento()."'
                      WHERE
                      (tipo_riferimento='Regione' AND geografico='".$regione_old."')")
                      or die("Query 92 fallita: " . mysql_error());
                      mysql_query("UPDATE serverdb.anagrafe_macchina
                      SET
                      geografico ='".$Stato."',
                      dt_abilitato='".dataCorrenteInserimento()."'
                      WHERE
                      (tipo_riferimento='Stato' AND geografico='".$stato_old."')" )
                      or die("Query 93 fallita: " . mysql_error());
                      mysql_query("UPDATE serverdb.anagrafe_macchina
                      SET
                      geografico ='".$Continente."',
                      dt_abilitato='".dataCorrenteInserimento()."'
                      WHERE
                      (tipo_riferimento='Continente' AND geografico='".$continente_old."')")
                      or die("Query 94 fallita: " . mysql_error());
                     */
                }//End ciclo di inserimento in anagrafe_macchina storico e modifica di anagrafe_prodotto su serverdb
                //Modifico la tabella corrente comune di serverdb
                //Modifico tutti i record relativi a quella provincia/regione/stato/continente

                $updateProvinciaInComune = updateProvinciaServerDBComune($CodiceProvincia, $Provincia, $provincia_old);

                $updateRegioneInComune = updateRegioneServerDBComune($CodiceRegione, $Regione, $regione_old);

                $updateStatoInComune = updateStatoServerDBComune($CodiceStato, $Stato, $stato_old);

                $updateContinenteInComune = updateContinenteServerDBComune($Continente, $continente_old);

                /*
                  mysql_query("UPDATE serverdb.comune
                  SET
                  cod_prov='".$CodiceProvincia."',
                  provincia='".$Provincia."'
                  WHERE
                  provincia='".$provincia_old."'")
                  or die("Query 75 fallita: " . mysql_error());
                  mysql_query("UPDATE serverdb.comune
                  SET
                  cod_reg='".$CodiceRegione."',
                  regione='".$Regione."'
                  WHERE
                  regione='".$regione_old."'")
                  or die("Query 76 fallita: " . mysql_error());
                  mysql_query("UPDATE serverdb.comune
                  SET
                  cod_stat='".$CodiceStato."',
                  stato='".$Stato."'
                  WHERE
                  stato='".$stato_old."'")
                  or die("Query 77 fallita: " . mysql_error());
                  mysql_query("UPDATE serverdb.comune
                  SET
                  continente='".$Continente."'
                  WHERE
                  continente='".$continente_old."'")
                  or die("Query 78 fallita: " . mysql_error());

                 */


                //Occorre andare a modificare il campo comune nelle tabelle [anagrafe_macchina] e [anagrafe_prodotto] 	



                if (!$insStoAnProd ||
                        !$updateProvinciaAnProd ||
                        !$updateRegioneAnProd ||
                        !$updateStatoAnProd ||
                        !$updateContinenteAnProd ||
                        
                        !$insStoAnMac ||
                        !$updateProvinciaAnMac ||
                        !$updateRegioneAnMac ||
                        !$updateStatoAnMac ||
                        !$updateContinenteAnMac ||
                        
                        !$updateProvinciaInComune ||
                        !$updateRegioneInComune ||
                        !$updateStatoInComune ||
                        !$updateContinenteInComune) {

                    if ($DEBUG) {

                        echo "insStoAnProd : " . $insStoAnProd . '</br>';

                        echo "updateProvinciaAnProd : " . $updateProvinciaAnProd . '</br>';
                        echo "updateRegioneAnProd : " . $updateRegioneAnProd . '</br>';
                        echo "updateStatoAnProd : " . $updateStatoAnProd . '</br>';
                        echo "updateContinenteAnProd : " . $updateContinenteAnProd . '</br>';

                        echo "insStoAnMac : " . $insStoAnMac . '</br>';

                        echo "updateProvinciaAnMac" . $updateProvinciaAnMac . '</br>';
                        echo "updateRegioneAnMac" . $updateRegioneAnMac . '</br>';
                        echo "updateStatoAnMac" . $updateStatoAnMac . '</br>';
                        echo "updateContnenteAnMac" . $updateContinenteAnMac . '</br>';

                        echo "updateProvinciaInComune" . $updateProvinciaInComune . '</br>';
                        echo "updateRegioneInComune" . $updateRegioneInComune . '</br>';
                        echo "updateStatoInComune" . $updateStatoInComune . '</br>';
                        echo "updateContinenteInComune" . $updateContinenteInComune . '</br>';
                    }


                    rollback();
                    echo '<div id="msgErr">' . $msgTransazioneFallita . '! ' . $msgErrContactAdmin . '!</div>';
                    echo '<a href="gestione_comuni.php">' . $msgTornaAiComuni . '</a>';
                } else {

                    commit();
                    mysql_close();
                    echo($msgModificaCompletata . '! <a href="gestione_comuni.php">' . $msgTornaAiComuni . '</a>');
                }
            }
            ?>