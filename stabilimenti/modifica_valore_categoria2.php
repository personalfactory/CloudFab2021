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

//Ricavo il valore dell'id categoria per cui modificare i valori dei parametri mandato tramite post
            $IdCategoria = $_POST['IdCategoria'];
            
//######### GESTIONE ERRORI SU INPUT ###########################################
            $errore = false;
            $messaggio = $msgErroreVerificato.'<br/>';

//######### Variabili utili a gestire gli errori sulle query ###################
            $erroreResult = false;
            $selectParEr = true;
            $selectPar = true;
            $insertStorico = true;
            $updateServerdb = true;
            
//##############################################################################
            include('../Connessioni/serverdb.php');
            include('../Connessioni/storico.php');
            include('../sql/script.php');
            include('../sql/script_valore_par_prod.php');
            

//################### INIZIO TRANSAZIONE #######################################            
            begin();
                      
//Estraggo la descrizione dei parametri per visualizzare eventuali errori sui valori.
            $NParEr = 1;
            /*
            $selectParEr = mysql_query("SELECT 
                            valore_par_prod.id_val_par_pr,
                            parametro_prodotto.id_par_prod,
                            parametro_prodotto.nome_variabile,
                            parametro_prodotto.descri_variabile,
                            categoria.id_cat,
                            categoria.nome_categoria,
                            valore_par_prod.valore_variabile,
                            valore_par_prod.abilitato,
                            valore_par_prod.dt_abilitato 
                        FROM
                            serverdb.valore_par_prod
                        INNER JOIN serverdb.categoria 
                        ON 
                            valore_par_prod.id_cat = categoria.id_cat
                        INNER JOIN 
                            serverdb.parametro_prodotto 
                        ON 
                            valore_par_prod.id_par_prod = parametro_prodotto.id_par_prod
                        WHERE 
                            valore_par_prod.id_cat=" . $IdCategoria . "
                        ORDER BY 
                            nome_variabile")
                    or die("ERRORE 1 SELECT FROM serverdb.valore_par_prod : " . mysql_error());
            */
            $selectParEr = selectValoreParByIdCat($IdCategoria);

//Memorizzo nelle rispettive variabili i valori (arrivate tramite form) relativi ai parametri ed effettuo il controllo input
            while ($rowParEr = mysql_fetch_array($selectParEr)) {

                $Valore = $_POST['Valore' . $NParEr];

                //Controllo degli input valori eventualmente modificati 
                if (!isset($Valore) || trim($Valore) == "") {
                    $errore = true;
                    $messaggio = $messaggio . $msgCampoValore . $rowParEr['nome_variabile'] .' '.$msgVuoto. "!<br />";
                }
                $NParEr++;
            }
            
            $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
            
            if ($errore) {
                //Ci sono errori quindi non effettuo la modifica e visualizzo il messaggio di errore
                echo $messaggio;
            } else {
                // Non ci sono errori quindi posso andare avanti
                $NPar = 1;
                /*             
                $selectPar = mysql_query("SELECT 
                            valore_par_prod.id_val_par_pr,
                            parametro_prodotto.id_par_prod,
                            parametro_prodotto.nome_variabile,
                            parametro_prodotto.descri_variabile,
                            categoria.id_cat,
                            categoria.nome_categoria,
                            valore_par_prod.valore_variabile,
                            valore_par_prod.abilitato,
                            valore_par_prod.dt_abilitato 
                        FROM
                            serverdb.valore_par_prod
                        INNER JOIN serverdb.categoria 
                        ON 
                            valore_par_prod.id_cat = categoria.id_cat
                        INNER JOIN 
                            serverdb.parametro_prodotto 
                        ON 
                            valore_par_prod.id_par_prod = parametro_prodotto.id_par_prod
                        WHERE 
                            valore_par_prod.id_cat=" . $IdCategoria . "
                        ORDER BY 
                            nome_variabile")
                        or die("ERRORE 2 SELECT FROM serverdb.valore_par_prod : " . mysql_error());
                */
                $selectPar = selectValoreParByIdCat($IdCategoria);

//Memorizzo nelle rispettive variabili i valori (arrivate tramite form) relativi ai parametri selezionate ed effettuo il controllo input
                while ($rowPar = mysql_fetch_array($selectPar)) {

                   $Valore = $_POST['Valore' . $NPar];

                    //Per ogni parametro inserisco nello storico i vecchi record relativi all'associazione categoria-parametri che si sta modificando 
                    /*
                    $insertStorico =  mysql_query("INSERT INTO storico.valore_par_prod	
				(id_val_par_pr,id_par_prod,id_cat,valore_variabile,abilitato,dt_abilitato)
                            VALUES(
                                    " . $rowPar['id_val_par_pr'] . ",
                                    " . $rowPar['id_par_prod'] . ",
                                    '" . $IdCategoria . "',
                                    " . $rowPar['valore_variabile'] . ",
                                    " . $rowPar['abilitato'] . ",
                                    '" . $rowPar['dt_abilitato'] . "')")
                            or die("ERRORE 3  INSERT INTO storico.valore_par_prod : " . mysql_error());
                    */
                    $insertStorico = insertStoricoValoreParProdConAbilitazione($rowPar['id_val_par_pr'], $rowPar['id_par_prod'],
                    		 $IdCategoria, $rowPar['valore_variabile'], $rowPar['abilitato'] , $rowPar['dt_abilitato'] );
                   
                    //Per ogni parametro salvo la modifica nella tabella valore_par_prod
                    /*
                    $updateServerdb = mysql_query("UPDATE serverdb.valore_par_prod 
                                SET 
                                    dt_abilitato=if(valore_variabile != '" . $Valore . "','" . dataCorrenteInserimento() . "',dt_abilitato),
                                    valore_variabile=if(valore_variabile != '" . $Valore . "','" . $Valore . "',valore_variabile)
                                WHERE
                                    id_par_prod=" . $rowPar['id_par_prod'] . "
                                AND
                                    id_cat=" . $IdCategoria)
                            or die("ERRORE 4 UPDATE serverdb.valore_par_prod : " . mysql_error());
                    */
                    $updateServerdb = updateDtValoreParProd($rowPar['id_par_prod'], $IdCategoria, $Valore, dataCorrenteInserimento());
                       
                                   
                       if (!$insertStorico OR !$updateServerdb) {
                        $erroreResult = true;
                    }
                    $NPar++;
                }// end while finiti i parametri
                
                if ($erroreResult
                        OR !$updateServerdb
                        OR !$insertStorico
                        OR !$selectPar
                        OR !$selectParEr
                ) {
                    rollback();
                    echo $msgTransazioneFallita."! ".$msgErrContattareAdmin;
                   } else {

                    commit();
                    mysql_close();
                  
                     ?>
                    <script type="text/javascript">
                        location.href="modifica_valore_categoria.php?IdCategoria=<?php echo($IdCategoria) ?>"
                    </script> 
            
                <?php
                }
            }//End if errore
            ?>
               
        </div>
    </body>
</html>
