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

//##### Id del parametro di cui modificare i valori mandato tramite post #######
            $IdParametro = $_POST['IdParametro'];

//######### GESTIONE ERRORI SU INPUT ###########################################
            $errore = false;
            $messaggio = $msgErroreVerificato.'<br />';
            
//######### Variabili utili a gestire gli errori sulle query ###################
            $erroreResult = false;
            $sqlCatEr = true;
            $sqlCat = true;
            $insertStorico = true;
            $updateServerdb = true;

//##############################################################################
            include('../Connessioni/serverdb.php');
            include('../Connessioni/storico.php');
            include('../sql/script.php');
            include('../sql/script_valore_par_prod.php');

//################### INIZIO TRANSAZIONE #######################################            
            begin();

//Estraggo la descrizione delle categorie associate al parametro per visualizzarne eventuali errori.
            $NCatEr = 1;
            /*
            $sqlCatEr = mysql_query("SELECT 
            	    	                    categoria.id_cat,
                                            categoria.nome_categoria,
                                            categoria.descri_categoria,
                                            valore_par_prod.valore_variabile,
                                            valore_par_prod.dt_abilitato 
                                       FROM
                                            serverdb.valore_par_prod
                                       INNER JOIN 
                                            serverdb.categoria 
                                          ON 
                                            valore_par_prod.id_cat = categoria.id_cat
                                       INNER JOIN 
                                            serverdb.parametro_prodotto 
                                          ON 
                                            valore_par_prod.id_par_prod = parametro_prodotto.id_par_prod
                                       WHERE 
                                            valore_par_prod.id_par_prod=".$IdParametro."
                                       ORDER BY 
                                            nome_categoria")
                    or die("Errore 121: " . mysql_error());
            */
            $sqlCatEr = selectCategoriaValoreByIdPar($IdParametro);

//Memorizzo nelle rispettive variabili i valori (arrivate tramite POST) relativi alle categorie selezionate 
            while ($rowCatEr = mysql_fetch_array($sqlCatEr)) {

                $Valore = $_POST['Valore' . $NCatEr];

                //Controllo degli input valori eventualmente modificati 
                if (!isset($Valore) || trim($Valore) == "") {

                    $errore = true;
                    $messaggio = $messaggio . $msgValParVuotoCat." (" . $rowCatEr['nome_categoria'] . ") !<br />";
                }
                $NCatEr++;
            }

            $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
            if ($errore) {
                //Ci sono errori quindi non effettuo la modifica e visualizzo il messaggio di errore
                echo $messaggio;
            } else {
                // Non ci sono errori quindi posso andare avanti
                //Inserisco nello storico i vecchi record relativi all'associazione parametro-categorie che si sta modificando 

                $NCat = 1;
                /*
                $sqlCat = mysql_query("SELECT 
                                            valore_par_prod.id_val_par_pr,
                                            valore_par_prod.id_par_prod,
            	    	                    categoria.id_cat,
                                            categoria.nome_categoria,
                                            categoria.descri_categoria,
                                            valore_par_prod.valore_variabile,
                                            valore_par_prod.dt_abilitato 
                                       FROM
                                            serverdb.valore_par_prod
                                       INNER JOIN 
                                            serverdb.categoria 
                                          ON 
                                            valore_par_prod.id_cat = categoria.id_cat
                                       INNER JOIN 
                                            serverdb.parametro_prodotto 
                                          ON 
                                            valore_par_prod.id_par_prod = parametro_prodotto.id_par_prod
                                       WHERE 
                                            valore_par_prod.id_par_prod=".$IdParametro."
                                       ORDER BY 
                                            nome_categoria")
                        or die("Errore 121: " . mysql_error());
                */
                $sqlCat = selectValoreParProdCategoriaByIdPar($IdParametro);

                //Memorizzo nelle rispettive variabili i valori (arrivate tramite POST) relativi alle categorie selezionate 
                while ($rowCat = mysql_fetch_array($sqlCat)) {

                    $Valore = $_POST['Valore' . $NCat];
					/*
                    $insertStorico = mysql_query("INSERT INTO storico.valore_par_prod	
							(id_val_par_pr,id_par_prod,id_cat,valore_variabile,abilitato,dt_abilitato)
                                                    VALUES(
                                                            " . $rowCat['id_val_par_pr'] . ",
                                                            " . $IdParametro . ",
                                                            '" . $rowCat['id_cat'] . "',
                                                            '" . $rowCat['valore_variabile'] . "',
                                                            1,
                                                            '" . $rowCat['dt_abilitato'] . "')")
                            or die("Errore 122 : " . mysql_error());
                    */
                    $insertStorico = insertStoricoValoreParProd($rowCat['id_val_par_pr'], $IdParametro, $rowCat['id_cat'], $rowCat['valore_variabile'], $rowCat['dt_abilitato']);

                    //Salvo la modifica nella tabella valore_par_prod
                    /*
                    $updateServerdb = mysql_query("UPDATE serverdb.valore_par_prod 
                                                SET 
                                                    dt_abilitato=if(valore_variabile != '" . $Valore . "','" . dataCorrenteInserimento() . "',dt_abilitato),
                                                    valore_variabile=if(valore_variabile != '" . $Valore . "','" . $Valore . "',valore_variabile)
                                                WHERE
                                                        id_par_prod=" . $IdParametro . "
                                                AND
                                                        id_cat=" . $rowCat['id_cat'])
                            or die("Errore 123: " . mysql_error());
                    */
                    $updateServerdb = updateDtValoreParProd($IdParametro, $rowCat['id_cat'], $Valore, dataCorrenteInserimento());
                    
                    if (!$insertStorico OR !$updateServerdb) {
                        $erroreResult = true;
                    }
                    $NCat++;
                }//end while finite le categore
                 if ($erroreResult
                        OR !$updateServerdb
                        OR !$insertStorico
                        OR !$sqlCat
                        OR !$sqlCatEr
                ) {
                    rollback();
                    echo $msgTransazioneFallita."! ".$msgErrContattareAdmin;
                    } else {

                    commit();
                    mysql_close();
                  
                     ?>
                    <script type="text/javascript">
                        location.href="modifica_valore_par_prod.php?IdParametro=<?php echo($IdParametro) ?>"
                    </script> 
            
                <?php
                }
            }
            ?>

        </div>
    </body>
</html>
