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
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_valore_par_sacchetto.php');

//Ricavo il valore dell'id_cat che si vuole modificare
        $IdCategoria = $_POST['IdCategoria'];
            
//#################### GESTIONE ERRORI SULLE QUERY #############################
        $erroreResult = false;
        $sqlPar = true;
        $sqlValSac = true;
        $insertStoricoValSac = true;
        $updateServerdbValSac = true;
        
//################# Gestione degli errori sull'input ###########################

//Inizializzo l'errore sui valori dei parametri
            $NumErrore = 0;
            $messaggio = $msgErroreVerificato.'<br/>';
            
//Inizializzo due contatori
/////////////Eseguo i cicli una prima volta solo per controllare gli errori sui valori

            $NParEr = 1; //Contatore dei parametri associati alla categoria
            $NSacEr = 1; //Contatore dei num_sacchetti associati alle categorie
          
           
           $sqlParEr = findParametriByCat($IdCategoria);
            while ($rowParEr = mysql_fetch_array($sqlParEr)) {
                //Seleziono le soluzioni di num_sacchetti associati all' id_par_sac 
                //corrente ed alla categoria che si sta modificando
                $sqlValSacEr = findValSacByParCat($rowParEr['id_par_sac'], $IdCategoria);
                //Memorizzo il valore (arrivato tramite POST) relativa al num_sacchetti  
                while ($rowValSacEr = mysql_fetch_array($sqlValSacEr)) {

                    $ValoreDaInserire = $_POST['Valore' . $NSacEr];
                    //Controllo quantita eventualmente modificata 
                    if (!isset($ValoreDaInserire) || trim($ValoreDaInserire) == "") {

                        $NumErrore++;
                        $messaggio = $messaggio . " ".$titleValParNumSac." " . $rowParEr['nome_variabile'] . " ".$msgVuoto."!<br />";
                    }
                    $NSacEr++;
                }// End while finiti i num sachhetti
                 //echo "</br>IdPar=".$rowParEr['id_par_sac']."</br>";
                $NParEr++;
            }//End while finite le categorie
           
            $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
                      
            if ($NumErrore > 0) {
               
                echo $messaggio;
            } else {
                 include('../Connessioni/storico.php');

                //##############################################################
                //########## INIZIO TRANSAZIONE ################################
                //##############################################################
                begin();
                
                $NPar = 1; //Contatore dei parametri associati alla categoria
                $NSac = 1; //Contatore dei num_sacchetti associati alle categorie
                $sqlPar = findParametriByCat($IdCategoria);
                while ($rowPar = mysql_fetch_array($sqlPar)) {
                    //Seleziono le soluzioni di num_sacchetti associati all' id_cat corrente ed al parametro che si sta modificando
                    //Per ogni parametro scorro i num_sacchetti, sacchetto, valore e dt_abilitato presenti nella tabella [valore_par_sacchetto]
                   $sqlValSac=findValSacByParCat($rowPar['id_par_sac'], $IdCategoria);


                    //Per ogni soluzione sacchetto visualizzo i valori di tutti i sacchetti correnti
                    while ($rowValSac = mysql_fetch_array($sqlValSac)) {

                        $ValoreDaInserire = $_POST['Valore' . $NSac];

                        //Inserisco nello storico i vecchi record relativi all'associazione 
                        //categoria-parametri-num_sacchetto_sacchetto che si sta modificando 
                        /*
                        $insertStoricoValSac = mysql_query("INSERT INTO storico.valore_par_sacchetto	
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
                                                        " . $rowPar['id_par_sac'] . ",
                                                        " . $IdCategoria . ",
                                                        " . $rowValSac['id_num_sac'] . ",
                                                        '" . $rowValSac['sacchetto'] . "',
                                                        '" . $rowValSac['valore_variabile'] . "',
                                                        " . $rowValSac['abilitato'] . ",
                                                        '" . $rowValSac['dt_abilitato'] . "')");
//                                or die("Errore 15: " . mysql_error());
 * 
 */

                        $insertStoricoValSac = insertStoricoValoreParSac($rowValSac['id_val_par_sac'], $rowPar['id_par_sac'], $IdCategoria, $rowValSac['id_num_sac'],
                        		$rowValSac['sacchetto'], $rowValSac['valore_variabile'], $rowValSac['abilitato'], $rowValSac['dt_abilitato'] );
                        
                        //Salvo la modifica nella tabella valore_par_sacchetto
						/*
                        $updateServerdbValSac = mysql_query("UPDATE serverdb.valore_par_sacchetto 
                                SET 
                                        valore_variabile=if(valore_variabile!='" . $ValoreDaInserire . "','" . $ValoreDaInserire . "',valore_variabile)
                                WHERE
                                        id_par_sac=" . $rowPar['id_par_sac'] . "
                                AND
                                        id_cat=" . $IdCategoria . "
                                AND
                                        id_num_sac=" . $rowValSac['id_num_sac'] . "
                                AND
                                        sacchetto='" . $rowValSac['sacchetto'] . "'");
//                                or die("Errore 16: " . mysql_error());
 * 
 */
                        $updateServerdbValSac = updateServerdbValSac($rowPar['id_par_sac'], $IdCategoria, $rowValSac['id_num_sac'], $rowValSac['sacchetto'], $ValoreDaInserire);
                        
                        if(!$sqlValSac OR !$updateServerdbValSac OR !$insertStoricoValSac){$erroreResult = true;}
                        
                        $NSac++;
                    }// End while finiti i num sachhetti
                    $NPar++;
                }//End while finite le categorie

                 if ($erroreResult OR !$sqlPar ) {

                        rollback();
                        
                    	echo $msgTransazioneFallita."! ".$msgErrContattareAdmin;
                        echo "</br>insertComponente : ".$insertComponente;
                        echo "</br>sqlIdComp : ".$sqlIdComp;
                        echo "</br>insertValComp : ".$insertValComp;
                           
                    } else {

                        commit();
                        mysql_close();
                        ?>
                        <script language="javascript">
                            window.location.href="gestione_valori_par_sac.php";
                        </script>
                        <?php
                    }
                    
            }//fine  if($NumErrore) controllo input valore
            
            ?>

        </div>
    </body>
</html>
