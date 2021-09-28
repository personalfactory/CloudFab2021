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
            include('../include/precisione.php');

//###################### GESTIONE ERRORI SULLE QUERY #########################
            $insertStoricoPar = true;
            $updateServerdbPar = true;
            $updateServerdbVal = true;
            $erroreResult = false;
            
            $insertStoricoNewPar =true;
            $updateServerdbParametroProd=true;
            $updateDtValoreProdotto=true;
            

//######################## RECUPERO POST ######################################
            $IdParametroOld = $_POST['IdParametroOld'];
            $IdParametro = $_POST['IdParametro'];
            $NomeVariabile = str_replace("'", "''", $_POST['NomeVariabile']);
            $DescriVariabile = str_replace("'", "''", $_POST['DescriVariabile']);
            $ValoreBase = str_replace("'", "''", $_POST['ValoreBase']);

//############## CONTROLLO INPUT DATI MODIFICATI ###############################

            $errore = false;
            $messaggio = $msgErroreVerificato . '<br/>';

            if (!isset($IdParametro) || trim($IdParametro) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErrCampoIdParVuoto . '<br />';
            }
            if (!isset($NomeVariabile) || trim($NomeVariabile) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErrCampoNomeParVuoto . '<br />';
            }
            if (!isset($DescriVariabile) || trim($DescriVariabile) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErrCampoDescriParVuoto . '<br />';
            }
            //Verifica tipo di dati
            if (!is_numeric($IdParametro)) {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $filtroId . $msgErrDeveEssereIntero . '<br />';
            }


//Verifica esistenza 
//Verifico che non ci sia in tabella un record con gli stessi valori(descrizioni) e
// con Id diverso da quello che si sta modificando
            include('../Connessioni/storico.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            //include('../sql/script_parametro_prodotto.php');
            //include('../sql/script_valore_par_prod.php');
            include('../sql/script_parametro_prod.php');
            include('../sql/script_valore_prodotto.php');

            //$result = findParProdottoByIdNomeDescriVal($IdParametro, $NomeVariabile, $DescriVariabile, $ValoreBase, $connessione);

            //if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che il valore inserito esiste nel db
                //$errore = true;
                //$messaggio = $messaggio . $msgDuplicaRecord . '<br />';
            //}

            //##################################################################
            //########## NUOVI PARAMETRI DEL PRODOTTO ##########################
            //##################################################################
            //PARTE NUOVA : 5 ottobre 2015
            $result2 = findParametroProdByIdNomeDescriVal($IdParametro, $NomeVariabile, $DescriVariabile, $ValoreBase);

            if (mysql_num_rows($result2) != 0) {
                //Se entro nell'if vuol dire che il valore inserito esiste nel db
                $errore = true;
                $messaggio = $messaggio . $msgDuplicaRecord . '<br />';
            }
            //##################################################################

            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {



                //######################### INIZIO TRANSAZIONE ###############################
                
                //######################### STORICIZZO #######################################

                begin();

                //$insertStoricoPar = insertStoricoParProd($IdParametroOld);
                
                //NOTA
                //05-Ottobre 2015 :Disabilitata la storicizzazione dei valori_par_prod

                //######################### MODIFICO SU SERVERDB #############################

                //$updateServerdbPar = updateServerDBParProdotto($IdParametro, $NomeVariabile, $DescriVariabile, $ValoreBase, dataCorrenteInserimento(), $IdParametroOld);

                //Modifico su serverdb la dt_abilitato nella tabella valore_par_prod se cambia l'id del parametro
                //$updateServerdbVal = updateDaraParProd($IdParametro, $IdParametroOld);



                //##################################################################
                //########## NUOVI PARAMETRI DEL PRODOTTO ##########################
                //##################################################################
                //PARTE NUOVA : 5 ottobre 2015
                
                //Storicizzo il parametro
                $insertStoricoNewPar = insertStoricoParametroProd($IdParametroOld,$valAbilitato);
                
                //NOTA: non storicizzo i valori_prodotto
                
                //Modifico su serverdb parametro_prod
                $updateServerdbParametroProd = updateServerdbParametroProd($IdParametro, $NomeVariabile, $DescriVariabile, $ValoreBase, dataCorrenteInserimento(), $IdParametroOld);

                //Modifico su serverdb la dt_abilitato nella tabella valore_prodotto se cambia l'id del parametro
                $updateDtValoreProdotto= updateParametroProdData($IdParametro, $IdParametroOld);
                
                //##################################################################
                       
                


                if ($erroreResult
                        OR ! $insertStoricoPar                     
                        OR ! $updateServerdbPar
                        OR ! $updateServerdbVal
                        OR ! $insertStoricoNewPar
                        OR ! $updateServerdbParametroProd
                        OR ! $updateDtValoreProdotto
                        ) {

                    rollback();
                   
                    echo $msgTransazioneFallita . ' <a href="gestione_parametri_prodotto.php">' . $msgErrContactAdmin . '</a><br/>';
                } else {

                    commit();
                    mysql_close();
                  echo $msgModificaCompletata . ' <a href="gestione_parametri_prodotto.php">' . $msgOk. '</a><br/>';
    }
}
?>
        </div>
    </body>
</html>