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
        include('../sql/script_num_sacchetto.php');    
        include('../sql/script_parametro_sacchetto.php'); 
        include('../sql/script_valore_par_sacchetto.php'); 
           

 //################### GESTIONE ERRORI SULLE QUERY #############################      
           
            $insertNumSacchetto = true;
            $sqlPar = true;
            $insertValParSac = true;
            
//######## Gestione degli errori sull'input ####################################
            
            $errore = false;
            $messaggio = $msgErroreVerificato.'<br />';

            if (!isset($_POST['NumSacchetti']) || trim($_POST['NumSacchetti']) == "") {

                $errore = true;
                $messaggio = $messaggio .' '. $msgErrNumSacchi.'<br />';
            }
            if (!is_numeric($_POST['NumSacchetti'])) {
                $errore = true;
                $messaggio = $messaggio . ' ' .$msgErrNumSacchi . ' '.$msgNumerico.'<br />';
            }

//Verifica esistenza
//Apro la connessione al db
           $messaggio=$messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {
                
                $IdCategoria = $_POST['IdCategoria'];
                $NumSacchetti = $_POST['NumSacchetti'];
                //Inserisco nella tabella num_sacchetto la nuova soluzione
                begin();
                $insertNumSacchetto = insertNumSacchetto($IdCategoria, $NumSacchetti);

                $IdNumSacchetti = 0;
                $selectIdNumSac = findSoluzioneByIdCat($IdCategoria,$NumSacchetti);
//                        mysql_query("SELECT id_num_sac 
//                                                FROM 
//                                                    num_sacchetto
//                                                WHERE
//                                                    id_cat=" . $IdCategoria . "
//                                                        AND
//                                                        num_sacchetti = '" . $NumSacchetti . "'");
//                        or die("Errore 116: " . mysql_error());
                while ($rowNumSac = mysql_fetch_array($selectIdNumSac)) {

                    $IdNumSacchetti = $rowNumSac['id_num_sac'];
                }

                //Ricavo le varie soluzioni di num_sacchetti associati alla categoria, 
                //nella tabella [num_sacchetto] e inserisco tutto nella tab [valore_par_sacchetto] con valore base			
                $NPar = 1;
                $sqlPar = findAllParSacchettoOrderByNome();
                        //mysql_query("SELECT * FROM parametro_sacchetto ORDER BY nome_variabile");
//                        or die("Errore 113: " . mysql_error());
                while ($rowPar = mysql_fetch_array($sqlPar)) {

                    for ($i = 1; $i <= $NumSacchetti; $i++) {

                        //Salvo i valori  nella tabella valore_par_sacchetto
                        $insertValParSac = insertNewValoreParSac($rowPar['id_par_sac'], $IdCategoria, $IdNumSacchetti, $i, $rowPar['valore_base'], dataCorrenteInserimento());
//                                mysql_query("INSERT INTO valore_par_sacchetto
//								(	
//							 	id_par_sac,
//								id_cat,
//								id_num_sac,
//								sacchetto,
//								valore_variabile,
//								abilitato,
//								dt_abilitato)
//							VALUES(
//                                                               " . $rowPar['id_par_sac'] . ",
//                                                                " . $IdCategoria . ",
//                                                                " . $IdNumSacchetti . ",
//                                                                " . $i . ",
//                                                                '" . $rowPar['valore_base'] . "',
//                                                                1,
//                                                                '" . dataCorrenteInserimento() . "')");
//                                or die("Errore 116: " . mysql_error());
                        
                        if(!$insertValParSac){$erroreResult=true;}
                        
                    }//End for
                    $NPar++;
                }//End while parametri
                
               if ($erroreResult OR !$insertNumSacchetto) {

                   rollback();
                        
                        echo '<div id="msgErr">' . $msgTransazioneFallita . '! ' . $msgErrContactAdmin . '!</div>';
                        echo "</br>erroreResult : ".$erroreResult;
                        echo "</br>sqlPar : ".$sqlPar;
                        echo "</br>selectIdNumSac : ".$selectIdNumSac;
                        echo "</br>insertNumSacchetto : ".$insertNumSacchetto;
                           
                    } else {

                        commit();
                        mysql_close();
                        echo($msgModificaCompletata . ' <a href="/CloudFab/stabilimenti/modifica_valore_categoria_sac.php?IdCategoria='.$IdCategoria. '">' . $msgOk . '</a>');
                       
                    }
                
            }//fine primo if($errore) controllo degli input relativo al prodotto 
            ?>
           
        </div>
    </body>
</html>
