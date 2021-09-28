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

            $IdCategoria = $_POST['Categoria'];

//################# GESTIONE ERRORI SULLE QUERY ################################

            $erroreResult = false;
            $selectPar = true;
            $insertValPar = true;

//Gestione degli errori
//Verifico che la categoria sia stata settata e che non sia vuota
            $errore = false;
            $messaggio = $msgErroreVerificato.'<br />';
            $erroreVal = false;
            $messaggioVal = $msgErroreVerificato.'<br />';
            
            if (!isset($IdCategoria) || trim($IdCategoria) == "" || $IdCategoria == 0) {

                $errore = true;
                $messaggio = $messaggio . $msgSelectCatAssociaPar.'<br />';
            }

//Verifica esistenza
//Apro la connessione al db

            include('../Connessioni/serverdb.php');
            include('../sql/script_valore_par_prod.php');
            include('../sql/script_parametro_prodotto.php');
            include('../sql/script.php');
			
            /*
            $query = "SELECT * FROM valore_par_prod 
                WHERE 
                        id_cat = " . $IdCategoria;

            $result = mysql_query($query, $connessione) or die("Errore 114: " . mysql_error());
			*/
            $result = findValoreParProdByIdCat($IdCategoria, $connessione);
            
            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che il valore inserito esiste gi� nel db
                $errore = true;
                $messaggio = $messaggio . $msgErrCatGiaAssociataAiPar.'<br />';
                //potrebbe esserci un problema se dopo si crea una nuova categoria
            }

            mysql_close();

            $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
            
            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {
                //Vado avanti perch� non ci sono errori
                //controllo sull'input valori
                include('../Connessioni/serverdb.php');
                $NComp = 1;
                /*
                $sql = mysql_query("SELECT * FROM parametro_prodotto ORDER BY nome_variabile")
                        or die("Errore 113: " . mysql_error());
                */
                $sql = findAllParametroProdottoOrderByNome();

                //Memorizzo nelle rispettive variabili i valori relativi al id_cat selezionato
                while ($row = mysql_fetch_array($sql)) {

                    $Valore = $_POST['Valore' . $NComp];
                    if (!isset($Valore) || trim($Valore == "")) {
                        $erroreVal = true;
                        $messaggioVal = $messaggioVal . $filtroValore.' : ' . $row['descri_variabile'] .' '.$msgNonValido. '<br/>';
                    }
                    $NComp++;
                }

            $messaggioVal = $messaggioVal . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
                
                if ($erroreVal) {
                    //Ci sono errori quindi non salvo
                    echo $messaggioVal;
                } else {

                    //################### INIZIO TRANSAZIONE ####################

                    begin();

                    //Ricavo l'elenco dei parametri			
                    $NComp = 1;
                    /*
                    $selectPar = mysql_query("SELECT * FROM parametro_prodotto ORDER BY nome_variabile")
                            or die("Errore 113: " . mysql_error());
                    */
                    $selectPar = findAllParametroProdottoOrderByNome();

                    //Memorizzo nelle rispettive variabili i valori relativi al id_cat selezionato
                    while ($row = mysql_fetch_array($selectPar)) {

                        $Valore = $_POST['Valore' . $NComp];

                        //Salvo i valori  nella tabella valore_par_prod
                        /*
                        $insertValPar = mysql_query("INSERT INTO valore_par_prod 
                                                        (id_par_prod,id_cat,valore_variabile,abilitato,dt_abilitato) 
                                                        VALUES("
                                . $row['id_par_prod'] . ","
                                . $IdCategoria . ","
                                . $Valore . ",1,'"
                                . dataCorrenteInserimento() . "')")
                                or die("Errore 116: " . mysql_error());
                        */
                        $insertValPar = insertValoreParProd($row['id_par_prod'], $IdCategoria, $Valore, dataCorrenteInserimento());

                        if (!$insertValPar) {
                            $erroreResult = true;
                        }
                        $NComp++;
                    }// end while finite le categorie 
                    if ($erroreResult OR !$selectPar) {

                        rollback();
                    echo $msgTransazioneFallita."! ".$msgErrContattareAdmin;
                    } else {

                        commit();
                        mysql_close();
                      
                        ?>
                        <script language="javascript">
                            window.location.href="/CloudFab/stabilimenti/gestione_valori_par_prod.php";
                        </script>
            <?php
        }       
    }//End if erroreVal
}//fine primo if($errore) controllo degli input relativo al prodotto 
?>

        </div>
    </body>
</html>
