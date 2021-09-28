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
            include('../sql/script_categoria.php');
            include('../sql/script_parametro_prodotto.php');
            include('../sql/script_valore_par_prod.php');
            include('../sql/script_valore_par_sacchetto.php');
            include('../sql/script_parametro_sacchetto.php');
         

            $NomeCategoria = str_replace("'", "''", $_POST['NomeCategoria']);
            $DescriCategoria = str_replace("'", "''", $_POST['DescriCategoria']);
            $SoluzioniTot = str_replace("'", "''", $_POST['SoluzioniTot']);
            
            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
//############## GESTIONE ERRORI SULLE QUERY ###################################

            $erroreResult = false;
            $insertIntoCategoria = true;
            $sqlIdCat = true;
            $insertNumSacchetto = true;

//############### Gestione degli errori sull' input ############################
            $errore = false;
            $messaggio = $msgErroreVerificato.'<br />';

            if (!isset($NomeCategoria) || trim($NomeCategoria) == "") {

                $errore = true;
                $messaggio = $messaggio ." ". $msgErroreNome.' !<br />';
            }
            if (!isset($DescriCategoria) || trim($DescriCategoria) == "") {

                $errore = true;
                $messaggio = $messaggio ." ". $msgErrDescri.' !<br />';
            }
            if (!isset($SoluzioniTot) || trim($SoluzioniTot) == "") {

                $errore = true;
                $messaggio = $messaggio ." ". $msgInsertSolSacc.'<br />';
            }

            for ($i = 1; $i <= $SoluzioniTot; $i++) {

                $Soluzione = str_replace("'", "''", $_POST['Soluzione' . $i]);

                if ((!is_numeric($Soluzione) && trim($Soluzione) != "") || $Soluzione < 0 || trim($Soluzione) == "") {
                    $errore = true;
                    $messaggio = $messaggio . ' - '.$filtroSolSacchetto.' ' . $i . ' '.$msgErrValoreNumerico.'<br />';
                }
            }


			
            $result=findCatByNomeOrDescr($NomeCategoria, $DescriCategoria, $connessione);
  //          $query = "SELECT * FROM categoria WHERE nome_categoria = '" . $NomeCategoria . "' OR descri_categoria = '" . $DescriCategoria . "'";
  //          $result = mysql_query($query, $connessione) or die(" Errore: 128 " . mysql_error());

            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che esiste
                $errore = true;
                $messaggio = $messaggio . $msgDuplicaRecord .'<br />';
            }

           
     
            
            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {

                //################### INIZIO TRANSAZIONE #######################
                begin();
				
                $insertIntoCategoria = insertCategoria($NomeCategoria, $DescriCategoria,$_SESSION['id_utente'], $IdAzienda);
               
                //Seleziono l'id cat della categoria appena inserita
                $sqlIdCat = selectMaxIdCategoria();
                
                while ($rowIdCat = mysql_fetch_array($sqlIdCat)) {
                    $IdCategoria = $rowIdCat['id_cat'];
                }

                //##############################################################
                //########### PARAMETRI DI INSACCO #############################
                //##############################################################
                for ($i = 1; $i <= $SoluzioniTot; $i++) {

                    $Soluzione = str_replace("'", "''", $_POST['Soluzione' . $i]);

                    if ($Soluzione > 0) {
                    	
                    	$insertNumSacchetto = insertNumSacchetto($IdCategoria, $Soluzione);
                    	
                        if (!$insertNumSacchetto) {
                            $erroreResult = true;
                        }
                    }
                }//End for

                
                 $NParSac = 1;
                $sqlPar = findAllParSacchettoOrderByNome();
                while ($rowPar = mysql_fetch_array($sqlPar)) {

                    $sqlNumSac = selectIdNumSacByIdCat($IdCategoria);

                    while ($rowNumSac = mysql_fetch_array($sqlNumSac)) {

                        $IdNumSacchetti = $rowNumSac['id_num_sac'];
                        $NumSacchetti = $rowNumSac['num_sacchetti'];
                        //Per ogni parametro presente nella tab [parametro_sacchetto] 
                        //e per ogni soluzione di num_sacchetti associata alla categoria 
                        //nella tab [num_sacchetti] si esegue il ciclo seguente
                        for ($i = 1; $i <= $NumSacchetti; $i++) {

                            //Salvo i valori  nella tabella valore_par_sacchetto
                            $insertValoreParSac = insertNewValoreParSac($rowPar['id_par_sac'], $IdCategoria, $IdNumSacchetti, $i, $rowPar['valore_base'], dataCorrenteInserimento());
                            if (!$insertValoreParSac) {
                                $erroreResult = true;
                            }
                        }//End for
                    }//End while num sacchetti di una categoria
                    $NParSac++;
                }//End while parametri di insacco
                
                
                
                
                //############ PARAMETRI DELLA CATEGORIA #######################
                //Ricavo l'elenco dei parametri dalla tabella parametro_prodotto
                //##############################################################
                    $NComp = 1;
                    $selectPar = true;
                    $insertValPar = true;
                    
                    $selectPar = findAllParametroProdottoAbilitatoOrderById();

                    //Memorizzo nelle rispettive variabili i valori relativi 
                    while ($rowValPar = mysql_fetch_array($selectPar)) {

                        $Valore = $rowValPar['valore_base'];

                        //Salvo i valori  nella tabella valore_par_prod                        
                        $insertValPar = insertValoreParProd($rowValPar['id_par_prod'], $IdCategoria, $Valore, dataCorrenteInserimento());

                        if (!$insertValPar) {
                            $erroreResult = true;
                        }
                        $NComp++;
                    }// end while parametri
                   

                               
                
                if ($erroreResult
                        OR !$insertIntoCategoria
                        OR !$sqlIdCat
                        OR !$selectPar
                        OR !$sqlNumSac) {

                    rollback();

                    echo $msgTransazioneFallita.'! '.$msgErrContactAdmin .'!';
                    echo "</br>insertIntoCategoria : " . $insertIntoCategoria;
                    echo "</br>sqlIdCat : " . $sqlIdCat;
                    echo "</br>erroreResult : " . $erroreResult;
                    echo "</br>insertNumSacchetto : " . $insertNumSacchetto;
                    echo "</br>selectParProdotto : " . $selectPar;
                    echo "</br>selectNumSacchetto : " . $sqlNumSac;
                
                    
                } else {

                    commit();
                    mysql_close();

                    
                    ?>
                        <script language="javascript">
                            window.location.href="/CloudFab/prodotti/gestione_categorie.php";
                        </script>
            <?php
                    
                    //echo($msgInserimentoCompletato.'<br/> <br/>
		//	 <a href="/CloudFab/stabilimenti/associa_categoria_parametri.php"> '.$msgDefParPro.'</a>
		//	  <br/> <br/> 
		//	 <a href="/CloudFab/stabilimenti/associa_categoria_parametri_sac.php">'.$msgDefParIns.'</a>');
                }
            }
            ?>
        </div>
    </body>
</html>
