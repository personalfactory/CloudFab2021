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
            include('../sql/script_categoria.php');
            include('../sql/script.php');

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
            if (!isset($SoluzioniTot) || trim($SoluzioniTot) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgSolSaccVuoto . '!<br/>';
            }
//Controllo input sulle soluzioni di num sacchetti presenti nella tab 
//[num_sacchetto] eventualmente modificate

            $NSac = 1;
            $sqlSac = findNumSacchettiByIdCat($IdCategoria);
            while ($rowSac = mysql_fetch_array($sqlSac)) {

                $Soluzione = str_replace("'", "''", $_POST['Soluzione' . $NSac]);

                if ((!is_numeric($Soluzione) && trim($Soluzione) != "") || $Soluzione < 0 || trim($Soluzione) == "") {

                    $errore = true;
                    $messaggio = $messaggio . ' - ' . $filtroCampoSolSacc . ' ' . $NSac . ' ' . $msgNumerico . '!<br />';
                }
                $NSac++;
            }
            //Controllo input delle eventuali nuove soluzioni di num sacchetto
            for ($i = $NSac; $i <= $SoluzioniTot; $i++) {

                $Soluzione = str_replace("'", "''", $_POST['Soluzione' . $i]);
                if ((!is_numeric($Soluzione) && trim($Soluzione) != "") || $Soluzione < 0 || trim($Soluzione) == "") {

                    $errore = true;
                    $messaggio = $messaggio . ' - ' . $filtroCampoSolSacc . ' ' . $NSac . ' ' . $msgNumerico . '!<br />';
                }
            }

//Verifica esistenza 
//verifico che non ci sia nella tabella [categoria] un record con lo stesso nome 
//e con id diverso da quello che si sta modificando

            $result = findCatByNomeAndID($IdCategoria, $NomeCategoria);

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

                begin();
                //Storicizzo
                $insertStoricoCategoria = insertStoricoCategoria($IdCategoria);
          
                //Modifico il record nella tabella corrente [categoria] di serverdb
                $updateServerdbCategoria = updateServerDBCategoria($IdCategoria, $NomeCategoria, $DescriCategoria,$IdAzienda);
                

                if (!$updateServerdbCategoria || !$insertStoricoCategoria) {

                    rollback();
                    echo '<div id="msgErr">' . $msgTransazioneFallita . ' ' . $msgErrContactAdmin . '!</div>';
                    echo ' <a href="gestione_categorie.php">' . $msgTornaAlleCategorie . '</a>';
                
                } else {

                    commit();
                    mysql_close();
                    echo $msgModificaCompletata . ' <a href="gestione_categorie.php">' . $msgTornaAlleCategorie . '</a>';
                   
                }
            }
            ?>

        </div>
    </body>
</html>