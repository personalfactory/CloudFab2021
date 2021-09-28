<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
            if($DEBUG) ini_set("display_errors", "1");
            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_mazzetta.php');
            include('../sql/script_colore_base.php');
            include('../sql/script.php');
            
            //############# STRINGA UTENTI - AZIENDE VIS ###############################
            $strUtentiAzColB = getStrUtAzVisib($_SESSION['objPermessiVis'], 'colore_base');
            
            //################ Gestione degli errori ###########################
            //verifico che i parametri siano stati settati e che non siano vuoti
            //##################################################################
            $errore = false;
            $messaggio = $msgErroreVerificato . '<br />';

            $erroreEsiste = false;
            $messaggioEsiste = $msgErroreVerificato . '<br />';

            $erroreColore = false;
            $messaggioColore = $msgErroreVerificato . '<br />';

            if ((!isset($_POST['IdMazzetta']) || trim($_POST['IdMazzetta']) == "")) {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $labelSelezionaMazzetta . '!<br />';
            }
            if (!isset($_POST['Colore']) || trim($_POST['Colore']) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $labelSelezionaColore . '!<br />';
            }

            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {
                
                //Verifica esistenza
                //Verifico che non sia gia presente nella tabella [mazzetta_colorata] 
                //l associazione id_mazzetta-id_,colore che si 	vuole effettuare
                $IdMazzetta = $_POST['IdMazzetta'];
//                $NomeMazzetta = $_POST['NomeMazzetta']; SERVE ?????????
                $IdColore = $_POST['Colore'];


                begin();
                $selectMazCol = true;
                $sqlColoreEr = true;
                $sqlColore = true;
                $insMazzetta = true;
              
                $selectMazCol = findMazColorataByIdColoreAndIdMazzetta($IdMazzetta, $IdColore);

                if (mysql_num_rows($selectMazCol) != 0) {
                    //Se entro nell'if vuol dire che il valore inserito esiste gia nel db
                    $erroreEsiste = true;
                    $messaggioEsiste = $messaggioEsiste . ' - ' . $msgColoreAssociato . '!<br />';
                }

                $messaggioEsiste = $messaggioEsiste . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

                if ($erroreEsiste) {
                    //Ci sono errori quindi non salvo
                    echo $messaggioEsiste;
                } else {
                    
                    $sqlColoreB = findAllColoreBaseVis($strUtentiAzColB,"nome_colore_base");
                                        
                    //Verifica errore sulle quantita di colore
                    $NColoreEr = 1;                   
                    while ($rowColoreEr = mysql_fetch_array($sqlColoreB)) {

                        $Quantita = $_POST['Qta' . $NColoreEr];

                        if (!is_numeric($Quantita)) {
                            $erroreColore = true;
                            $messaggioColore = $messaggioColore . $msgQuantitaDi . ' ( ' . $rowColoreEr['nome_colore_base'] . ' ) ' . $msgNumerico . '!<br/>';
                        }
                        $NColoreEr++;
                    }

                    $messaggioColore = $messaggioColore . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

                    if ($erroreColore) {
                        //Ci sono errori quindi non salvo
                        echo $messaggioColore;
                    } else {
                        //Inserisco perche non ci sono errori	

                       $NColoreB = 1;
                       mysql_data_seek($sqlColoreB, 0);
                        //Memorizzo nelle rispettive variabili le quantita dei colori base 
                        //relative al idcolore selezionato mandate tramite POST
                        while ($rowColore = mysql_fetch_array($sqlColoreB)) {

                            $Quantita = $_POST['Qta' . $NColoreB];

                            //Inserisco la nuova associazione mazzetta-colore con le relative quantita 
                            //di colori base nella tabella mazzetta_colorata
                            $insMazzetta = insertMazzettaColorata($IdMazzetta, $IdColore, $rowColore['id_colore_base'], $Quantita, dataCorrenteInserimento());
                            $NColoreB++;
                        }


                        if (!$selectMazCol || !$sqlColore || !$sqlColoreEr || !$insMazzetta) {

                            rollback();
                            echo '<div id="msgErr">' . $msgTransazioneFallita . '! ' . $msgErrContactAdmin . '!</div>';
                            echo ' <a href="gestione_mazzette_colorate.php">' . $msgTornaAlleMazzette . '</a>';
                        } else {

                            commit();
                            mysql_close();
                            echo($msgModificaCompletata . ' <a href="gestione_mazzette_colorate.php">' . $msgTornaAlleMazzette . '</a>');
                        }
                     
                    }//End if erroreColore
                }//End if erroreEsiste
            }//End if errore
            ?>

        </div>
    </body>
</html>
