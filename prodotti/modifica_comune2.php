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
            include('../sql/script_comune.php');
            include('../sql/script_anagrafe_prodotto.php');
            include('../sql/script_anagrafe_macchina.php');

            $IdComune = $_POST['IdComune'];
            $Cap = str_replace("'", "''", $_POST['Cap']);
            $CodiceCatastale = str_replace("'", "''", $_POST['CodiceCatastale']);
            $CodiceIstat = str_replace("'", "''", $_POST['CodiceIstat']);
            $Comune = str_replace("'", "''", $_POST['Comune']);
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

            if (!isset($Cap) || trim($Cap) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroCap . '!<br />';
            }
            if (!isset($CodiceCatastale) || trim($CodiceCatastale) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroCatasto . '!<br />';
            }
            if (!isset($CodiceIstat) || trim($CodiceIstat) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroIstat . '!<br />';
            }
            if (!isset($Comune) || trim($Comune) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroComune . '!<br />';
            }
            if (!isset($CodiceProvincia) || trim($CodiceProvincia) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroCodProvincia . '!<br />';
            }
            if (!isset($Provincia) || trim($Provincia) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroProvincia . '!<br />';
            }
            if (!isset($CodiceRegione) || trim($CodiceRegione) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroCodRegione . '!<br />';
            }
            if (!isset($Regione) || trim($Regione) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroRegione . '!<br />';
            }
            if (!isset($CodiceStato) || trim($CodiceStato) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroCodStato . '!<br />';
            }
            if (!isset($Stato) || trim($Stato) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroStato . '!<br />';
            }
            if (!isset($Continente) || trim($Continente) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroContinente . '!<br />';
            }


//Verifica esistenza

            /* 	$query="SELECT * FROM comune WHERE comune = '".$Comune."'
              AND
              id_comune<>".$IdComune ;

              $result=mysql_query($query,$connessione) or die(mysql_error());
             */
            $result = findComuneByNomeNonId($IdComune, $Comune, $Provincia);

            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che esiste
                $errore = true;
                $messaggio = $messaggio . ' ' . $msgComuneEsiste . '<br />';
            }


            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';


            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {
                //Non ci sono errori
                //Seleziono il vecchio comune		
                $sqlComune = selectComuneById($IdComune);
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

                while ($rowComune = mysql_fetch_array($sqlComune)) {

                    $id_comune_old = $rowComune['id_comune'];
                    $cap_old = $rowComune['cap'];
                    $cod_cat_old = $rowComune['cod_cat'];
                    $cod_istat_old = $rowComune['cod_istat'];
                    $comune_old = $rowComune['comune'];
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

                //Inserisco in storico di comune

                begin();

                $insStoCom = true;
                $insStoAnProd = true;
                $updateGeoAnProd = true;
                $insStoAnMac = true;
                $updateComAnMac = true;
                $updateSerDBCom = true;

                /* mysql_query("INSERT INTO storico.comune (id_comune,cap,cod_cat,cod_istat,comune,cod_prov,provincia,cod_reg,regione,cod_stat,stato,continente,mondo,abilitato, dt_abilitato)
                  VALUES(".$id_comune_old.",
                  '".$cap_old."',
                  '".$cod_cat_old."',
                  '".$cod_istat_old."',
                  '".$comune_old."',
                  '".$cod_prov_old."',
                  '".$provincia_old."',
                  '".$cod_reg_old."',
                  '".$regione_old."',
                  '".$cod_stat_old."',
                  '".$stato_old."',
                  '".$continente_old."',
                  '".$mondo_old."',
                  '".$abilitato."',
                  '".dataCorrenteInserimento()."')")
                  or die("Errore 116: " . mysql_error()); */

                $insStoCom = insertStoricoComune($id_comune_old, $cap_old, $cod_cat_old, $cod_istat_old, $comune_old, $cod_prov_old, $provincia_old, $cod_reg_old, $regione_old, $cod_stat_old, $stato_old, $continente_old, $mondo_old, $abilitato, dataCorrenteInserimento());

//////////////////////PRODOTTI/////////////////////////		
                //Seleziono il record contenente il vecchio comune, da inserire nello storico dell'anagrafe_prodotto e memorizzo il contenuto dei vari campi
                //Devo verificare il tipo riferimento in anagrafe prodotto
                /*
                  $queryAnProd="SELECT
                  id_prodotto,colorato,lim_colore,fattore_div,fascia,id_mazzetta,
                  geografico,tipo_riferimento,gruppo,livello_gruppo,
                  id_cat,abilitato,dt_abilitato
                  FROM
                  serverdb.anagrafe_prodotto
                  WHERE
                  (tipo_riferimento='Comune' AND geografico='".$comune_old."')";


                  $sqlAnProd=mysql_query($queryAnProd,$connessione) or die("Errore 116: " . mysql_error());
                 */
                $sqlAnProd = selectAnProdByTipoRifAndGeo("Comune", $comune_old);

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

                    $insStoAnProd = insertStoricoAnagrafeProdotto($id_prodotto, $colorato, $lim_colore, $fattore_div, $fascia, $id_mazzetta,$id_codice, $geografico, $tipo_riferimento, $gruppo, $livello_gruppo, $id_cat, $abilitato, $dt_abilitato);

                    //Modifico il campo geografico nella tabella anagrafe_prodotto di serverdb 
                    //solo se si tratta di 'Comune'
                    /* 		mysql_query("UPDATE serverdb.anagrafe_prodotto
                      SET
                      geografico ='".$Comune."',
                      dt_abilitato='".dataCorrenteInserimento()."'
                      WHERE
                      tipo_riferimento='Comune'
                      AND
                      geografico='".$comune_old."'")
                      or die("Query 70 fallita: " . mysql_error());
                     */
                    $updateGeoAnProd = updateGeograficoAnagrafeProdotto($Comune, $comune_old, "Comune", dataCorrenteInserimento());
                }//End while an_prod
//////////////////////MACCHINE/////////////////////////			
//Seleziono il record contenente il vecchio comune, 
//da inserire nello storico dell'anagrafe_macchina e memorizzo il contenuto dei vari campi
                //Devo verificare il tipo riferimento in anagrafe macchina
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
                  (tipo_riferimento='Comune' AND geografico='".$comune_old."')";


                  $sqlAnStab=mysql_query($queryAnStab,$connessione) or die("Errore 146: " . mysql_error());
                 */
                $sqlAnStab = selectAnagrafeMacchinaByComune($comune_old);

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
                    /* 			mysql_query("INSERT INTO storico.anagrafe_macchina 
                      (   id_macchina,
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
                      or die("Errore 147: " . mysql_error());

                     */

                    $insStoAnMac = insertStoricoAnagrafeMacchina($id_macchina, $id_lingua, $id_cliente_gaz, $geografico, $tipo_riferimento, $gruppo, $livello_gruppo, $abilitato, $dt_abilitato);


                    $updateComAnMac = updateGeograficoAnMacchina($Comune, $comune_old, "Comune", dataCorrenteInserimento());
                    //Modifico il campo geografico nella tabella anagrafe_macchina di serverdb solo se si tratta di 'Comune'
                    /* 		mysql_query("UPDATE serverdb.anagrafe_macchina
                      SET
                      geografico ='".$Comune."',
                      dt_abilitato='".dataCorrenteInserimento()."'
                      WHERE
                      tipo_riferimento='Comune'
                      AND
                      geografico='".$comune_old."'")
                      or die("Query 148 fallita: " . mysql_error());
                     */
                }//End while an_stab     
                //Modifico la tabella corrente comune di serverdb
                //Modifico il singolo comune
                /*
                  mysql_query("UPDATE serverdb.comune
                  SET
                  cap='".$Cap."',
                  cod_cat='".$CodiceCatastale."',
                  cod_istat='".$CodiceIstat."',
                  comune='".$Comune."',
                  cod_prov='".$CodiceProvincia."',
                  provincia='".$Provincia."',
                  cod_reg='".$CodiceRegione."',
                  regione='".$Regione."',
                  cod_stat='".$CodiceStato."',
                  stato='".$Stato."',
                  continente='".$Continente."',
                  Mondo='".$Mondo."',
                  dt_abilitato='".dataCorrenteInserimento()."'
                  WHERE
                  id_comune='".$IdComune."'")
                  or die("Query 75 fallita: " . mysql_error());
                 */

                $updateSerDBCom = updateServerDBComuneById($Cap, $CodiceCatastale, $CodiceIstat, $Comune, $CodiceProvincia, $Provincia, $CodiceRegione, $Regione, $CodiceStato, $Stato, $Continente, $Mondo, dataCorrenteInserimento(), $IdComune);

                //Occorre andare a modificare il campo comune nelle tabelle [anagrafe_macchina] e [anagrafe_prodotto] 	



                if (!$insStoCom || !$insStoAnProd || !$updateGeoAnProd 
                        || !$insStoAnMac || !$updateComAnMac || !$updateSerDBCom) {


                    echo "insStoCom" . $insStoCom . '</br>';
                    echo "insStoAnProd" . $insStoAnProd . '</br>';
                    echo "updateGeoAnProd" . $updateGeoAnProd . '</br>';
                    echo "insStoAnMac" . $insStoAnMac . '</br>';
                    echo "updateComAnMac" . $updateComAnMac . '</br>';
                    echo "updateSerDBCom" . $updateSerDBCom . '</br>';

                    rollback();
                    echo '<div id="msgErr">' . $msgTransazioneFallita . ' ' . $msgErrContactAdmin . '!</div>';
                    echo '<a href="gestione_comuni.php">' . $msgTornaAiRiferimenti . '</a>';
                } else {

                    commit();
                    mysql_close();
                    echo($msgModificaCompletata . ' <a href="gestione_comuni.php">' . $msgTornaAiRiferimenti . '</a>');
                }
            }
            ?>