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
            $ValoreVariabile = str_replace("'", "''", $_POST['ValoreVariabile']);

//######### Variabili utili a gestire gli errori sulle query ###################

            $insertStorico = true;
            $updateServerdb = true;

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
            if (!isset($ValoreVariabile) || trim($ValoreVariabile) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErrCampoValParVuoto. '<br />';
            }
            //Verifica tipo di dati
            if (!is_numeric($IdParametro)) {

                $errore = true;
                $messaggio = $messaggio . ' - '.$filtroId .$msgErrDeveEssereIntero.'<br />';
            }

            include('../Connessioni/serverdb.php');
            include('../sql/script_parametro_glob_mac.php');
/*
            $query = "SELECT * FROM parametro_glob_mac 
                     WHERE       
                        id_par_gm = " . $IdParametro . " 
                    AND  
                        nome_variabile='" . $NomeVariabile . "'
                    AND 
                        valore_variabile='" . $ValoreVariabile . "'
		   AND 
                        descri_variabile='" . $DescriVariabile . "'";


            $result = mysql_query($query, $connessione)
                    or die("ERRORE 1 SELECT FROM SERVERDB.parametro_glob_mac: " . mysql_error());
 */           
            $result = findParGlobMacByIdNomeValDescri($IdParametro, $NomeVariabile, $ValoreVariabile, $DescriVariabile, $connessione);

            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che il valore inserito esiste gi� nel db
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
                //######################### INIZIO TRANSAZIONE ###############################
                //############################################################################
                include('../Connessioni/storico.php');
                include('../Connessioni/serverdb.php');
                include('../sql/script.php');
                
                          
                begin();

                //################### STORICIZZO ####################################### 
                /*
                $insertStorico = mysql_query("INSERT INTO storico.parametro_glob_mac 						 										
                                (id_par_gm,
                                nome_variabile,
                                descri_variabile,
                                valore_variabile,
                                abilitato,
                                dt_abilitato) 
                        SELECT 
                                id_par_gm,
                                nome_variabile,
                                descri_variabile,
                                valore_variabile,
                                abilitato,
                                dt_abilitato
                        FROM 
                                serverdb.parametro_glob_mac
                        WHERE 
                                id_par_gm=" . $IdParametroOld);
//                or die("ERRORE 2  INSERT INTO storico.parametro_glob_mac : " . mysql_error());
*/
                //$insertStorico = insertStoricoParGlobMac($IdParametroOld);
               
                //######################### MODIFICO SU SERVERDB #############################
 /*              
                $updateServerdb = mysql_query("UPDATE serverdb.parametro_glob_mac 
					SET 
                                        id_par_gm=if(id_par_gm != '" . $IdParametro . "',
                                                    '" . $IdParametro . "',
                                                    id_par_gm),
                                        nome_variabile=if(nome_variabile != '" . $NomeVariabile . "',
                                                        '" . $NomeVariabile . "',
                                                        nome_variabile),
                                        descri_variabile=if(descri_variabile != '" . $DescriVariabile . "',
                                                        '" . $DescriVariabile . "',
                                                            descri_variabile),							
                                        valore_variabile=if(valore_variabile != '" . $ValoreVariabile . "',
                                                        '" . $ValoreVariabile . "',
                                                            valore_variabile)
                                        WHERE 
                                            id_par_gm='" . $IdParametroOld . "'");
//                or die("ERRORE 3 UPDATE serverdb.parametro_glob_mac: " . mysql_error());
*/
                $updateServerdb = updateServerDBParGlobMac($IdParametro, $NomeVariabile, $ValoreVariabile, $DescriVariabile, $IdParametroOld);
//NOTA : Il campo dt_abilitato essendo timestamp si aggiorna automaticamente q
//uando viene modificato il valore di almeno un campo del record considerato

                if (!$updateServerdb ) {

                    rollback();
                    echo $msgTransazioneFallita." ".$msgErrContattareAdmin;
                } else {

                    commit();
                    mysql_close();
                    ?>
                   <script language="javascript">
        window.location.href="/CloudFab/stabilimenti/gestione_parametri_globali.php";
      </script>

        <?php
    }
}
?>
        </div>
    </body>
</html>
