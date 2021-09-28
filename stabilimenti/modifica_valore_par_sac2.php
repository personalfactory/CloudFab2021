<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
        <?php include('../include/menu.php');  
        include('../include/gestione_date.php'); 
//Ricavo l'identificativo del parametro selezionato a cui modificare i valori
            $IdParametro = $_POST['IdParametro'];
            $IdValPar = $_POST['IdValPar'];

//######### Variabili utili a gestire gli errori sulle query ###################

            $erroreResult = false;
            $sqlCatEr = true;
            $sqlCat = true;
            $sqlValSac = true;
            $insertStorico = true;
            $updateServerdb = true;

//################ Gestione Errori sull'input ##################################

            $NumErrore = 0;
            $messaggio = $msgErroreVerificato.'<br/>';
//Inizializzo due contatori
/////////////Eseguo i cicli una prima volta solo per controllare gli errori sul valore
            $NCatEr = 1; //Contatore delle categorie associate al parametro
            $NSacEr = 1; //Contatore dei num_sacchetti associati alle categorie

            include('../Connessioni/serverdb.php');
            include('../Connessioni/storico.php');
            include('../sql/script_valore_par_sacchetto.php');
            include('../sql/script.php');
            
			/*
            $sqlCatEr = mysql_query("SELECT 
                                valore_par_sacchetto.id_cat,
                                categoria.nome_categoria
                    FROM
                            serverdb.valore_par_sacchetto
                    INNER JOIN serverdb.categoria 
                    ON 
                            valore_par_sacchetto.id_cat = categoria.id_cat
                    WHERE 
                            valore_par_sacchetto.id_par_sac=" . $IdParametro . "
                    GROUP BY
                                categoria.nome_categoria
                    ORDER BY 
                                categoria.nome_categoria");
//             or die("Errore 11: " . mysql_error());
			*/
            $sqlCatEr = selectValoreAndNomeCatByIdPar($IdParametro);
            
            while ($rowCatEr = mysql_fetch_array($sqlCatEr)) {

                //Seleziono le soluzioni di num_sacchetti associati all' id_cat corrente ed al parametro che si sta modificando
                /*
                $sqlValSacEr = mysql_query("SELECT   
                                                        valore_par_sacchetto.id_val_par_sac,
                                                        valore_par_sacchetto.id_par_sac,
                                                        valore_par_sacchetto.id_cat,
                                                        valore_par_sacchetto.id_num_sac,
                                                        valore_par_sacchetto.sacchetto,
                                                        valore_par_sacchetto.valore_variabile,
                                                        valore_par_sacchetto.abilitato,
                                                        valore_par_sacchetto.dt_abilitato,
                                                        num_sacchetto.num_sacchetti									
                                                FROM 
                                                        serverdb.valore_par_sacchetto
                                                INNER JOIN serverdb.num_sacchetto
                                                ON
                                                        valore_par_sacchetto.id_num_sac=num_sacchetto.id_num_sac
                                                WHERE
                                                        valore_par_sacchetto.id_par_sac=" . $IdParametro . "
                                                AND
                                                        valore_par_sacchetto.id_cat=" . $rowCatEr['id_cat'] . "
                                                ORDER BY 
                                        num_sacchetto.num_sacchetti, valore_par_sacchetto.sacchetto	");
//                                    or die("Errore 12: " . mysql_error());
				*/
                $sqlValSacEr = selectValoreParSacchettoCatByIdParAndIdCat($IdParametro, $rowCatEr['id_cat']);
                
                //Memorizzo il valore (arrivato tramite POST) relativa al num_sacchetti e al sacchetto  
                while ($rowValSacEr = mysql_fetch_array($sqlValSacEr)) {

                    $Valore = $_POST['Valore' . $NSacEr];

                    //Controllo valore eventualmente modificato
                    if (!isset($Valore) || trim($Valore) == "") {

                        $NumErrore++;
                        $messaggio = $messaggio ." ". $filtroCategoria ." ". $rowCatEr['nome_categoria'] . ", ".$filtroNumSacchetti ." ". $rowValSacEr['num_sacchetti'] . ",  ".$filtroSacchetto." N. " . $rowValSacEr['sacchetto'] . ", ".$msgErrValoreVuoto."<br />";
                    }
                    $NSacEr++;
                }// End while finiti i num sachhetti
                $NCatEr++;
            }//End while finite le categorie
            $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
                        

            if ($NumErrore > 0) {
               
                echo $messaggio;
            } else {
                /////////////////Vado avanti ed eseguo nuovamente i cicli
                
//################### INIZIO TRANSAZIONE #######################################            
            begin();

                $NCat = 1; //Contatore delle categorie associate al parametro
                $NSac = 1; //Contatore dei num_sacchetti associati alle categorie
                /*
                $sqlCat = mysql_query("SELECT 
                                                    valore_par_sacchetto.id_cat,
                                                    categoria.nome_categoria
                                        FROM
                                                serverdb.valore_par_sacchetto
                                        INNER JOIN serverdb.categoria 
                                        ON 
                                                valore_par_sacchetto.id_cat = categoria.id_cat
                                        WHERE 
                                                valore_par_sacchetto.id_par_sac=" . $IdParametro . "
                                        GROUP BY
                                                    categoria.nome_categoria
                                        ORDER BY 
                                                    categoria.nome_categoria");
//					 or die("Errore 11: " . mysql_error());
 * */

				$sqlCat = selectValoreAndNomeCatByIdPar($IdParametro);
                while ($rowCat = mysql_fetch_array($sqlCat)) {
                    //Seleziono le soluzioni di num_sacchetti associati all' id_cat corrente ed al parametro che si sta modificando
                    /*
                    $sqlValSac = mysql_query("SELECT   
                                                                valore_par_sacchetto.id_val_par_sac,
                                                                valore_par_sacchetto.id_par_sac,
                                                                valore_par_sacchetto.id_cat,
                                                                valore_par_sacchetto.id_num_sac,
                                                                valore_par_sacchetto.sacchetto,
                                                                valore_par_sacchetto.valore_variabile,
                                                                valore_par_sacchetto.abilitato,
                                                                valore_par_sacchetto.dt_abilitato,
                                                                num_sacchetto.num_sacchetti									
                                                        FROM 
                                                                serverdb.valore_par_sacchetto
                                                        INNER JOIN serverdb.num_sacchetto
                                                        ON
                                                                valore_par_sacchetto.id_num_sac=num_sacchetto.id_num_sac
                                                        WHERE
                                                                valore_par_sacchetto.id_par_sac=" . $IdParametro . "
                                                        AND
                                                                valore_par_sacchetto.id_cat=" . $rowCat['id_cat'] . "
                                                        ORDER BY 
                                                num_sacchetto.num_sacchetti, valore_par_sacchetto.sacchetto	");
//								or die("Errore 12: " . mysql_error());
 * */

					$sqlValSac = selectValoreParSacchettoCatByIdParAndIdCat($IdParametro, $rowCat['id_cat']);
                    //Memorizzo la quantita (arrivata tramite POST) relativa al num_sacchetti  
                    while ($rowValSac = mysql_fetch_array($sqlValSac)) {

                        $Valore = $_POST['Valore' . $NSac];

                        //Inserisco nello storico i vecchi record relativi all'associazione parametro-categorie-numerosacchetti-sacchetto che si sta modificando 
                        /*
                        $insertStorico = mysql_query("INSERT INTO storico.valore_par_sacchetto	
                                                        (id_val_par_sac,
                                                            id_par_sac,
                                                            id_cat,
                                                            id_num_sac,
                                                            sacchetto,
                                                            valore_variabile,
                                                            abilitato,
                                                            dt_abilitato)
                                                VALUES(
                                                                " . $rowValSac['id_val_par_sac'] . ",
                                                                " . $IdParametro . ",
                                                                " . $rowCat['id_cat'] . ",
                                                                '" . $rowValSac['id_num_sac'] . "',
                                                                '" . $rowValSac['sacchetto'] . "',
                                                                " . $rowValSac['valore_variabile'] . ",
                                                                " . $rowValSac['abilitato'] . ",
                                                                '" . $rowValSac['dt_abilitato'] . "')")
					or die("Errore 13 : " . mysql_error());
					*/
					$insertStorico = insertStoricoValoreParSac($rowValSac['id_val_par_sac'], $IdParametro, $rowCat['id_cat'], $rowValSac['id_num_sac'],
							 $rowValSac['sacchetto'], $rowValSac['valore_variabile'], $rowValSac['abilitato'], $rowValSac['dt_abilitato'] );
                        //Salvo la modifica nella tabella valore_par_sacchetto
                        
/*
                        $updateServerdb = mysql_query("UPDATE serverdb.valore_par_sacchetto 
							SET 
							dt_abilitato=if(valore_variabile != '" . $Valore . "','" . dataCorrenteInserimento() . "',dt_abilitato),
                                                        valore_variabile=if(valore_variabile != '" . $Valore . "','" . $Valore . "',valore_variabile)
							WHERE
                                                                id_par_sac=" . $IdParametro . "
                                                        AND
                                                                id_cat=" . $rowCat['id_cat'] . "
                                                        AND
                                                                id_num_sac=" . $rowValSac['id_num_sac'] . "
                                                        AND
                                                                sacchetto='" . $rowValSac['sacchetto'] . "'");
//                                                or die("Errore 14: " . mysql_error());	
 * 
 */
						$updateServerdb = updateValoreVarValoreParSacchetto($IdParametro, $rowCat['id_cat'], $rowValSac['id_num_sac'], $rowValSac['sacchetto'], $Valore, dataCorrenteInserimento() );

                        if (!$insertStorico OR !$updateServerdb) {
                            $erroreResult = true;
                        }

                        $NSac++;
                    }// End while finiti i num sachhetti
                    $NCat++;
                }//End while finite le categorie

                if ($erroreResult
                        OR !$updateServerdb
                        OR !$insertStorico
                        OR !$sqlCatEr
                        OR !$sqlCat
                        OR !$sqlValSac
                ) {
                    rollback();
                    echo $msgTransazioneFallita."! ".$msgErrContattareAdmin;
                    echo "<br/>erroreResult : ".$erroreResult;
                    echo "<br/>updateServerdb : ".$updateServerdb;
                    echo "<br/>insertStorico : ".$insertStorico;
                    echo "<br/>sqlCatEr : ".$sqlCatEr;
                    echo "<br/>sqlValSac : ".$sqlValSac;
                    echo "<br/>sqlCat : ".$sqlCat;
                } else {

                    commit();
                    mysql_close(); //Chiudo serverdb
                    ?>
                    <script type="text/javascript">
                        location.href="modifica_valore_par_sac.php?IdValPar=<?php echo($IdValPar) ?>"
                    </script> 
                    <?php
                }
            }
            ?>

        </div>
    </body>
</html>
