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
            include('../Connessioni/storico.php');
            include('../sql/script.php');
            include('../sql/script_categoria.php');
            include('../sql/script_num_sacchetto.php');
            include('../sql/script_valore_par_sacchetto.php');
            include('../sql/script_valore_par_prod.php');


//Memorizzo le variabili arrivate dal post
            $IdCategoria = $_POST['IdCategoria'];
            $DescriCategoria = str_replace("'", "''", $_POST['DescriCategoria']);
            $NomeCategoria = str_replace("'", "''", $_POST['NomeCategoria']);
            $SoluzioniTot = $_POST['SoluzioniTot'];
            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);

//################# GESTIONE ERRORI SULLE QUERY ################################      
            $insertStoricoCategoria = true;
            $insertStoricoNumSacchetto = true;
            $updateServerdbCategoria = true;

//####### Gestione degli errori relativa ai nuovi dati modificati ##############
//Verifico che i parametri siano stati settati e che non siano vuoti
            $errore = false;
            $messaggio = $msgErroreVerificato . '<br />';

            if (!isset($NomeCategoria) || trim($NomeCategoria) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgNomCatVuoto . '!<br />';
            }
            if (!isset($DescriCategoria) || trim($DescriCategoria) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgDescrCatVuoto . '!<br />';
            }
            

            

//Verifica esistenza 
//verifico che non ci sia nella tabella [categoria] un record con lo stesso nome 

            $result = findCategoriaByNome($NomeCategoria);

            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che esiste
                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgDuplicaRecord . '!<br />';
            }

            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {


                //################### INIZIO TRANSAZIONE #######################
                $erroreTransazione=false;
                $insertCategoria=true;
                $insertNumSacchetto=true;
                $duplicaSoluzione=true;
                $duplicaValParProdotto=true;
                begin();

                //TODO: 
                //--insert into categoria
                $insertCategoria = insertCategoria($NomeCategoria, $DescriCategoria, $_SESSION['id_utente'], $IdAzienda);

                // recupero id nuova categoria appena inserita
                $idCatNew = mysql_insert_id();

                //--insert into num_sacchetto
                $insertNumSacchetto = duplicaNumSacchettoByIdCat($IdCategoria, $idCatNew);




                //--insert into valore_par_sacchetto
                //conservo in un array gli id delle vecchie sol di insacco ovvero quelli della categoria di origine che si sta duplicando
                $vecchiIdNumSac = findSoluzioniByIdCat($IdCategoria, "id_num_sac");
                $arrayVecchiNumSac = array();
                $i = 0;
                while ($row = mysql_fetch_array($vecchiIdNumSac)) {

                    $arrayVecchiNumSac[$i] = $row['id_num_sac'];
                    $i++;
                }
                
                
                //Per ogni soluzione di insacco faccio un insert nella tabella valore_par_sachetto
                $nuoviIdNumSac = findSoluzioniByIdCat($idCatNew, "id_num_sac");
                $j=0;
                while ($row = mysql_fetch_array($nuoviIdNumSac)) {
                    
                    $idNumSacNew=$row['id_num_sac'];
                    
                    $duplicaSoluzione=duplicaSoluzioneInsaccoPerCategoria($IdCategoria,$arrayVecchiNumSac[$j],$idCatNew,$idNumSacNew);
                                        
                    if(!$duplicaSoluzione) $erroreTransazione=true;
                    
                    $j++;
                }




                //--insert into valore_par_prod
                
                $duplicaValParProdotto=duplicaValoriParProdByCategoria($IdCategoria,$idCatNew);
                
                
                


                if (!$insertCategoria || !$insertNumSacchetto || $erroreTransazione || !$duplicaValParProdotto) {
                    
                    rollback();
                    echo '<div id="msgErr">' . $msgTransazioneFallita . ' ' . $msgErrContactAdmin . '!</div>';
                    echo ' <a href="gestione_categorie.php">' . $msgTornaAlleCategorie . '</a>';
                } else {
                    
                    commit();
                    mysql_close();
                    echo $msgInserimentoCompletato . ' <a href="gestione_categorie.php">' . $msgTornaAlleCategorie . '</a>';
                }
            }
            ?>

        </div>
    </body>
</html>