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




//Recupero dei campi tramite POST
            $IdColoreBase = $_POST['IdColoreBase'];
            $CodiceColoreBase = str_replace("'", "''", $_POST['CodiceColoreBase']);
            $NomeColoreBase = str_replace("'", "''", $_POST['NomeColoreBase']);
            $NomeColoreBaseOld = str_replace("'", "''", $_POST['NomeColoreBaseOld']);
            $CostoColoreBase = str_replace("'", "''", $_POST['CostoColoreBase']);
            $Tolleranza = str_replace("'", "''", $_POST['Tolleranza']);
            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
//################## Gestione errori sulle query ###############################

            $insertStorico = true;
            $updateServerdb = true;

//############# Gestione degli errori relativa ai nuovi dati modificati ########
            $errore = false;
            $messaggio = $msgErroreVerificato . ':<br />';

            if (!isset($CodiceColoreBase) || trim($CodiceColoreBase) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCodColBaseVuoto . '!<br />';
            }
            if (!isset($NomeColoreBase) || trim($NomeColoreBase) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgNomeColBaseVuoto . '!<br />';
            }
            if (!isset($CostoColoreBase) || trim($CostoColoreBase) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCostoColBaseVuoto . '!<br />';
            }
            if (!is_numeric($CostoColoreBase)) {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $filtroCosto . ' ' . $filtroColoreBase . ' : ' . $msgErrValoreNumerico . '!<br />';
            }
            if (!isset($Tolleranza) || trim($Tolleranza) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroTolleranza . '!<br />';
            }
            if (!is_numeric($Tolleranza)) {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $filtroTolleranza . ' : ' . $msgErrValoreNumerico . '!<br />';
            }
//Verifica esistenza 
//Verifico che non ci sia in tabella un record con gli stessi valori(descrizioni) e con Id diverso da quello che si sta modificando
            include('../Connessioni/serverdb.php');
            include('../sql/script_colore_base.php');
            include('../sql/script.php');
            include('../sql/script_dizionario.php');

            /*
              $query="SELECT * FROM colore_base
              WHERE
              cod_colore_base = '".$CodiceColoreBase."'
              AND
              nome_colore_base = '".$NomeColoreBase."'
              AND
              id_colore_base<>".$IdColoreBase;
              $result=mysql_query($query) or die(" Errore: 120 ".mysql_error());
             */
            $result = findAllColoreByCodName($IdColoreBase, $NomeColoreBase, $CodiceColoreBase);

            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che esiste
                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgDuplicaRecord . '!<br />';
            }
            mysql_close();
            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {
//Inserisco il vecchio record nello storico  prima di modificarlo nella tabella corrente su serverdb
                include('../Connessioni/storico.php');
                include('../Connessioni/serverdb.php');

                //####################### INIZIO TRANSAZIONE ###################
                begin();
                $updateServerdb = true;
                $insertStorico = true;
                $updateServerdbDizionario=true;
                /*
                  $insertStorico = mysql_query("INSERT INTO storico.colore_base
                  (id_colore_base,cod_colore_base,nome_colore_base,costo_colore_base,toll_perc,abilitato,dt_abilitato)
                  SELECT
                  id_colore_base,
                  cod_colore_base,
                  nome_colore_base,
                  costo_colore_base,
                  toll_perc,
                  abilitato,
                  dt_abilitato
                  FROM
                  serverdb.colore_base
                  WHERE
                  id_colore_base=".$IdColoreBase) ;

                  //		or die("ERRORE INSERT INTO storico.colore_base  : " . mysql_error());
                 */
                $insertStorico = insertStoricoColoreBase($IdColoreBase);

//Modifico il record nella tabella corrente [colore_base] di serverdb
                /*
                  $updateServerdb = mysql_query("UPDATE serverdb.colore_base
                  SET
                  cod_colore_base=if(cod_colore_base!='".$CodiceColoreBase."','".$CodiceColoreBase."',cod_colore_base),
                  nome_colore_base=if(cod_colore_base!='".$NomeColoreBase."','".$NomeColoreBase."',cod_colore_base),
                  costo_colore_base=if(cod_colore_base!='".$CostoColoreBase."','".$CostoColoreBase."',cod_colore_base),
                  toll_perc=if(toll_perc!='".$Tolleranza."','".$Tolleranza."',toll_perc)

                  WHERE
                  id_colore_base=".$IdColoreBase."");
                  //		or die("ERRORE UPDATE serverdb.colore_base: " . mysql_error());
                 */
                $updateServerdb = updateServerDBColoreBase($CodiceColoreBase, $NomeColoreBase, $CostoColoreBase, $Tolleranza, $IdColoreBase, $IdAzienda);


                //##################### OPERAZIONI SUL DIZIONARIO ##############################
                if ($NomeColoreBaseOld != $NomeColoreBase) {

                    //Se la descrizione modificato era già stato caricata sul dizionario, 
                    //allora bisogna andare a modificarla anke nel dizionario 
                    //il vocabolo deve essere modificato in tutte le lingue 
                    //e coincide finchè non verrà nuovamente tradotto                
                    $updateServerdbDizionario = updateServerDBDizionario($IdColoreBase, $NomeColoreBase, 2);
                }
//################## FINE AGGIORNAMENTO DIZIONARIO #############################


                if (!$updateServerdb OR !$insertStorico OR !$updateServerdbDizionario) {

                    rollback();
                    echo '<div id="msgErr">' . $msgTransazioneFallita . '! ' . $msgErrContactAdmin . '!</div>';
                    echo '<a href="gestione_colori_base.php">' . $msgTornaAiColoriBase . '</a>';
                    if ($DEBUG) {
                        echo "<br/>insertStorico" . $insertStorico;
                        echo "<br/>updateServerdb" . $updateServerdb;
                        echo "<br/>updateServerdbDizionario" . $updateServerdbDizionario;
                    }
                } else {

                    commit();
                    mysql_close();
                    echo $msgModificaCompletata . ' ';
                    echo '<a href="gestione_colori_base.php">' . $msgTornaAiColoriBase . '</a>';
                    /*
                      ?>
                      <script language="javascript">
                      window.location.href="gestione_colori_base.php";
                      </script>
                      <?php */
                }
            }
            ?>
