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
        
//######################## RECUPERO POST ######################################

            $IdParametroOld = $_POST['IdParametroOld'];
            $IdParametro = $_POST['IdParametro'];
            $NomeVariabile = str_replace("'", "''", $_POST['NomeVariabile']);
            $DescriVariabile = str_replace("'", "''", $_POST['DescriVariabile']);
            $ValoreBase = str_replace("'", "''", $_POST['ValoreBase']);
//######### Variabili utili a gestire gli errori sulle query ###################

            $insertStoricoPar = true;
            $selectValParComp = true;
            $insertStoricoValore = true;
            $updateServerdbPar = true;
            $updateServerdbValore = true;

//############## CONTROLLO INPUT DATI MODIFICATI ###############################

            $errore = false;
            $messaggio = $msgErroreVerificato.'<br/>';

            if (!isset($IdParametro) || trim($IdParametro) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErrCampoIdParVuoto.'<br />';
            }
            if (!isset($NomeVariabile) || trim($NomeVariabile) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErrCampoNomeParVuoto.'<br />';
            }
            if (!isset($DescriVariabile) || trim($DescriVariabile) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErrCampoDescriParVuoto.'<br />';
            }
//Verifica tipo di dati
            if (!is_numeric($IdParametro)) {

                $errore = true;
                $messaggio = $messaggio . ' - '.$filtroId .$msgErrDeveEssereIntero.'<br />';
            }

//Verifica esistenza 
            include('../Connessioni/serverdb.php');
            include('../sql/script_parametro_comp_prod.php');
/*
            $query = "SELECT * FROM parametro_comp_prod 
		WHERE       
                    id_par_comp = " . $IdParametro . "
                AND 
                    nome_variabile ='" . $NomeVariabile . "'
                AND
                    descri_variabile='" . $DescriVariabile . "'
                AND
                    valore_base='" . $ValoreBase . "'";

            $result = mysql_query($query, $connessione)
                    or die("ERRORE 1 SELECT FROM serverdb.parametro_comp_prod: " . mysql_error());
 */           
            $result = findParCompByIdNomeDescriValore($IdParametro, $NomeVariabile, $DescriVariabile, $ValoreBase, $connessione);

            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che il valore inserito esiste nel db
                $errore = true;
                $messaggio = $messaggio . $msgDuplicaRecord .'<br />';
            }

            mysql_close();

            $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {

                //############################################################################
                //################# INIZIO TRANSAZIONE SALVATAGGIO DATI #######################
                //############################################################################
                //Inserisco il vecchio record nello storico prima di modificarlo nella tabella corrente su serverdb
                include('../Connessioni/storico.php');
                include('../Connessioni/serverdb.php');
                include('../sql/script.php');
                include('../sql/script_valore_par_comp.php');

                begin();

                //#################### STORICIZZO ######################################
/*
                $insertStoricoPar = mysql_query("INSERT INTO storico.parametro_comp_prod					 										
                            (id_par_comp,
                            nome_variabile,
                            descri_variabile,
                            valore_base,
                            abilitato,
                            dt_abilitato) 
                    SELECT 
                            id_par_comp,
                            nome_variabile,
                            descri_variabile,
                            valore_base,
                            abilitato,
                            dt_abilitato
                    FROM 
                            serverdb.parametro_comp_prod
                    WHERE 
                            id_par_comp='" . $IdParametroOld . "'");
//                or die("ERRORE 2 INSERT INTO storico.parametro_comp_prod : " . mysql_error());
 * 
 */

                $insertStoricoPar = insertStoricoParComponente($IdParametroOld);
                
                // Seleziono i record relativi al parametro che si vuole modificare dalla tabella [valore_par_comp] 
                // e	memorizzo il contenuto dei vari campi per poi storicizzarli
                /*
                $selectValParComp = mysql_query("SELECT 	
                                            id_val_comp,
                                            id_par_comp,
                                            id_comp,
                                            id_macchina,
                                            valore_variabile,
                                            valore_iniziale,
                                            dt_valore_iniziale,
                                            dt_modifica_mac,
                                            dt_agg_mac,
                                            valore_mac
                                        FROM 
                                                serverdb.valore_par_comp 
                                        WHERE 
                                                id_par_comp=" . $IdParametroOld);

//       or die("ERRORE 3 SELECT FROM serverdb.valore_par_comp : " . mysql_error());
 * 
 */

                $selectValParComp = selectIdValCompByIdParComp($IdParametroOld);

                while ($rowValParComp = mysql_fetch_array($selectValParComp)) {

                    $IdValParComp = $rowValParComp['id_val_comp'];
                    $IdMacchina = $rowValParComp['id_macchina'];
                    $IdComp = $rowValParComp['id_comp'];
                    $ValoreVariabile = $rowValParComp['valore_variabile'];
                    $ValoreIniziale = $rowValParComp['valore_iniziale'];
                    $DtValoreIniziale = $rowValParComp['dt_valore_iniziale'];
                    $DtModificaMacchina = $rowValParComp['dt_modifica_mac'];
                    $DtAggMacchina = $rowValParComp['dt_agg_mac'];
                    $ValoreMacchina = $rowValParComp['valore_mac'];

                    // 	Inserisco nello storico dei valori parametri componenti i vecchi record 
/*
                    $insertStoricoValore = mysql_query("INSERT INTO storico.valore_par_comp
                                            (id_val_comp,
                                            id_par_comp,
                                            id_comp,
                                            id_macchina,
                                            valore_variabile,
                                            abilitato,
                                            dt_abilitato,
                                            valore_iniziale,
                                            dt_valore_iniziale,
                                            dt_modifica_mac,
                                            dt_agg_mac,
                                            valore_mac)
                                    VALUES(
                                                '" . $IdValParComp . "',
                                                '" . $IdParametroOld . "',
                                                '" . $IdComp . "',
                                                '" . $IdMacchina . "',
                                                '" . $ValoreVariabile . "',
                                                0,
                                                NOW(),
                                                '" . $ValoreIniziale . "',
                                                '" . $DtValoreIniziale . "',
                                                '" . $DtModificaMacchina . "',
                                                '" . $DtAggMacchina . "',
                                                '" . $ValoreMacchina . "'
                                                )");
//                  or die("ERRORE 4 INSERT INTO storico.valore_par_comp: " . mysql_error());
 * 
 */

                    $insertStoricoValore = insertStoricoValoreParComp($IdValParComp, $IdParametroOld, $IdComp, $IdMacchina, $ValoreVariabile, $ValoreIniziale,
									 $DtValoreIniziale, $DtModificaMacchina, $DtAggMacchina, $ValoreMacchina);
                    
                }//Fine storicizzazione dei parametri singola macchina
                //############################################################################
                //######################### MODIFICO SU SERVERDB #############################
                //############################################################################
/*
                $updateServerdbPar = mysql_query("UPDATE serverdb.parametro_comp_prod 
					SET 
                                        id_par_comp=if(id_par_comp != '" . $IdParametro . "',
                                                    '" . $IdParametro . "',
                                                    id_par_comp),
                                        nome_variabile=if(nome_variabile != '" . $NomeVariabile . "',
                                                        '" . $NomeVariabile . "',
                                                        nome_variabile),
                                        descri_variabile=if(descri_variabile != '" . $DescriVariabile . "',
                                                        '" . $DescriVariabile . "',
                                                            descri_variabile),							
                                        valore_base=if(valore_base != '" . $ValoreBase . "',
                                                        '" . $ValoreBase . "',
                                                            valore_base)
                                        WHERE 
                                            id_par_comp='" . $IdParametroOld . "'");

//                or die("ERRORE 5 UPDATE serverdb.parametro_comp_prod : " . mysql_error());
 * 
 */

                $updateServerdbPar = updateServerDBParComponente($IdParametro, $NomeVariabile, $DescriVariabile, $ValoreBase, $IdParametroOld);
                //####### DA TESTARE #################################################
                /*
                $updateServerdbValore = mysql_query("UPDATE serverdb.valore_par_comp 
						SET
                                                dt_abilitato=if(id_par_comp != '" . $IdParametro . "',
                                                    '" . dataCorrenteInserimento() . "',
                                                        dt_abilitato),
                                                id_par_comp=if(id_par_comp != '" . $IdParametro . "',
                                                    '" . $IdParametro . "',
                                                    id_par_comp)
						WHERE 
                                                    id_par_comp='" . $IdParametroOld . "'");
//                or die("ERRORE 6 UPDATE serverdb.valore_par_comp : " . mysql_error());
 * 
 */

                $updateServerdbValore = updateIdParAndDtByIdParComp($IdParametro, dataCorrenteInserimento() , $IdParametroOld);


                if (!$insertStoricoPar
                        OR
                        !$selectValParComp
                        OR
                        !$insertStoricoValore
                        OR
                        !$updateServerdbPar
                        OR
                        !$updateServerdbValore) {

                    rollback();
                    echo $msgTransazioneFallita." ".$msgErrContattareAdmin;
                   } else {

                    commit();
                    mysql_close();
                    ?>
                    <script type="text/javascript">
                        location.href="modifica_parametro_componente.php?Parametro=<?php echo $IdParametro ?>"
                    </script> 

        <?php
    }
}
?>


        </div>
    </body>
</html>