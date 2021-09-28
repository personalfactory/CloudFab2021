<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>        
        <div id="mainContainer">
            <?php
            if ($DEBUG)
                ini_set('display_errors', 1);

            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_dizionario_tipo.php');
            include('../sql/script_prodotto.php');
            include('../sql/script_dizionario.php');
            include('../sql/script_lingua.php');
            include('../sql/script_colore.php');
            include('../sql/script_colore_base.php');
            include('../sql/script_componente.php');
            include('../sql/script_messaggio_macchina.php');
            include('../sql/script_codice.php');

//Setto il tempo massimo di esecuzione dello script 
            set_time_limit(120);

//######## VARIABILI PER LA GESTIONE DEGLI ERRORI SULLE QUERY  #################

            $sqlLingua = true;
            $sqlDizTipo = true;

            $erroreResultProdotti = false;
            $sqlProdotto = true;
            $sqlDizProdotto = true;
            $insertProdotti = true;

            $erroreResultColBase = false;
            $sqlColoreBase = true;
            $sqlDizColore = true;
            $insertColoriBase = true;

            $erroreResultComponente = false;
            $sqlComponente = true;
            $sqlDizComponente = true;
            $insertComponenti = true;

            $erroreResultMessaggio = false;
            $sqlMessaggio = true;
            $sqlDizMessaggio = true;
            $insertMessaggi = true;

            $erroreResultDescriCodice = false;
            $sqlDescriCodice = true;
            $sqlDizDescriCodice = true;
            $insertDescriCodice = true;

            //Contatori dei vocaboli aggiornati
            $numProdottoAgg = 0;           
            $numColoriBaseAgg = 0;
            $numComponentiAgg = 0;
            $numMessaggiMacAgg = 0;
            $numFamiglieAgg = 0;
            
            //############### INIZIO TRANSAZIONE ###############################       

            begin();

//##############################################################################
//################ PRODOTTI ####################################################
//##############################################################################
            //Seleziono l'id_diz_tipo dei nomi prodotti           
            $sqlDizTipo = selectIDDizionarioTipoByNomeProdotto();

            while ($rowDizTipo = mysql_fetch_array($sqlDizTipo)) {
                $IdDizProdotto = $rowDizTipo['id_diz_tipo'];
            }

            //Seleziono l'id  prodotto ed il codice prodotto che non sono ancora 
            //stati inseriti nel dizionario
            //SELEZIONE DI TUTTI I PRODOTTI
            $sqlProdotto = selectIDNomeProdotto();
            while ($rowProdotto = mysql_fetch_array($sqlProdotto)) {

                //Per ciascun id_prodotto si verifica se è stato inserito o meno nel dizionario
                $sqlDizProdotto = selectIdVocabolo($IdDizProdotto, $rowProdotto['id_prodotto']);

                //Se l'id del prodotto non è ancora stato inserito nel dizionario
                if (mysql_num_rows($sqlDizProdotto) == 0) {

                    $IdProdotto = $rowProdotto['id_prodotto'];
                    $NomeProdotto = $rowProdotto['nome_prodotto'];
                    $numProdottoAgg++;
                    //Per ogni lingua inserisco il vocabolo                    
                    $sqlLingua = findAllLingua();
                    while ($rowLingua = mysql_fetch_array($sqlLingua)) {
                        //Inserisco nel dizionario id e nome del prodotto                         
                        $insertProdotti = insertNewDizionario($rowLingua['id_lingua'], $IdDizProdotto, $IdProdotto, $NomeProdotto, dataCorrenteInserimento());
                        
                        if (!$insertProdotti) {
                            $erroreResultProdotti = true;
                        }
                    }//End while lingue
                }//End if non esiste vobabolo in dizionario
            }//End while
//##############################################################################
//################ COLORI BASE #################################################
//##############################################################################      
            //Seleziono l'id_diz_tipo dei nomi colori base

            $sqlDizTipo = selectIDDizionarioTipoByNomeColoreBase();
            while ($rowDizTipo = mysql_fetch_array($sqlDizTipo)) {
                $IdDizColore = $rowDizTipo['id_diz_tipo'];
            }

            //Seleziono id e nome di tutti i colori base
            $sqlColoreBase = findIdNomeColoreBase();
            while ($rowColoreBase = mysql_fetch_array($sqlColoreBase)) {

                //Per ciascun colore verifico se l'id è presente nel dizionario
                $sqlDizColore = selectIdVocabolo($IdDizColore, $rowColoreBase['id_colore_base']);

                //Se il nome colore non e' ancora presente nel dizionario
                if (mysql_num_rows($sqlDizColore) == 0) {

                    $IdColoreBase = $rowColoreBase['id_colore_base'];
                    $NomeColoreBase = $rowColoreBase['nome_colore_base'];
                    $numColoriBaseAgg++;
                    //Per ogni lingua inserisco id e nome del vocabolo
                    $sqlLingua = findAllLingua();
                    while ($rowLingua = mysql_fetch_array($sqlLingua)) {

                        $insertColoriBase = insertNewDizionario($rowLingua['id_lingua'], $IdDizColore, $IdColoreBase, $NomeColoreBase, dataCorrenteInserimento());
                        
                        if (!$insertColoriBase) {
                            $erroreResultColBase = true;
                        }
                    }//End lingue
                }//End if non esiste vobabolo in dizionario 
            }//End while
//##############################################################################
//################ COMPONENTI ##################################################
//##############################################################################
            //Seleziono l'id_diz_tipo dei nomi componenti
            $sqlDizTipo = selectIDDizionarioTipoByNomeComponente();

            while ($rowDizTipo = mysql_fetch_array($sqlDizTipo)) {
                $IdDizComponente = $rowDizTipo['id_diz_tipo'];
            }

            //Seleziono id e nome di tutti i componenti           
            $sqlComponente = findIdAndDescriComponente();
            while ($rowComponente = mysql_fetch_array($sqlComponente)) {
                //Per ciascun componente verifico se l'id è presente nel dizionario
                $sqlDizComponente = selectIdVocabolo($IdDizComponente, $rowComponente['id_comp']);

                //Se il componente non è ancora presente nel dizionario
                if (mysql_num_rows($sqlDizComponente) == 0) {

                    $IdComponente = $rowComponente['id_comp'];
                    $NomeComponente = $rowComponente['descri_componente'];
                    $numComponentiAgg++;
                    //Per ogni lingua inserisco id e nome del vocabolo 
                    $sqlLingua = findAllLingua();

                    while ($rowLingua = mysql_fetch_array($sqlLingua)) {
                        //Inserisco nel dizionario la descrizione del componente in italiano

                        $insertComponenti = insertNewDizionario($rowLingua['id_lingua'], $IdDizComponente, $IdComponente, $NomeComponente, dataCorrenteInserimento());
                        
                        if (!$insertComponenti) {
                            $erroreResultComponente = true;
                        }
                    }//End Lingue
                }//End if non esiste vobabolo in dizionario
            }//End while
//##############################################################################
//################ MESSAGGI MACCHINA ###########################################
//##############################################################################
            //Seleziono l'id_diz_tipo dei messaggi

            $sqlDizTipo = selectIDDizionarioTipoByMessaggioMacchina();

            while ($rowDizTipo = mysql_fetch_array($sqlDizTipo)) {
                $IdDizMessaggio = $rowDizTipo['id_diz_tipo'];
            }

            //Seleziono tutti i messaggi macchina           
            $sqlMessaggio = findIdAndMessaggio();
            while ($rowMessaggio = mysql_fetch_array($sqlMessaggio)) {
                //Elimino l'apice singolo		
                $Msg = str_replace("'", "''", $rowMessaggio['messaggio']);
                //Per ogni messaggio verifico se è prensente nel dizionario
                $sqlDizMessaggio = selectIdVocabolo($IdDizMessaggio, $rowMessaggio['id_messaggio']);

                if (mysql_num_rows($sqlDizMessaggio) == 0) {
                    $IdMessaggio = $rowMessaggio['id_messaggio'];
                    $Messaggio = $Msg;
                    $numMessaggiMacAgg++;
                    //Per ogni lingua inserisco id e vocabolo 
                    $sqlLingua = findAllLingua();
                    while ($rowLingua = mysql_fetch_array($sqlLingua)) {
                        //Inserisco nel dizionario i messaggi 

                        $insertMessaggi = insertNewDizionario($rowLingua['id_lingua'], $IdDizMessaggio, $IdMessaggio, $Messaggio, dataCorrenteInserimento());
                        
                        if (!$insertMessaggi) {
                            $erroreResultMessaggio = true;
                        }
                    }//End lingue
                }//End if non esiste messaggio in dizionario
            }//End while
//##############################################################################
//################ FAMIGLIE DI PRODOTTI ########################################
//##############################################################################   
            //Seleziono l'id_diz_tipo della descrizione del codice dei prodotti
            $sqlDizTipo = selectIDDizionarioTipoByFamigliaProdotto();

            while ($rowDizTipo = mysql_fetch_array($sqlDizTipo)) {
                $IdDizDescriCodice = $rowDizTipo['id_diz_tipo'];
            }

            //Seleziono tutti i codici 
            $sqlDescriCodice = findAllCodice("descrizione");

            while ($rowDescriCodice = mysql_fetch_array($sqlDescriCodice)) {
                //Per ciascun codice verifico se è presente nel dizionario
                $sqlDizDescriCodice = selectIdVocabolo($IdDizDescriCodice, $rowDescriCodice['id_codice']);

                //Se il codice prodotto non è ancora stato inserito nel dizionario
                if (mysql_num_rows($sqlDizDescriCodice) == 0) {

                    $IdCodice = $rowDescriCodice['id_codice'];
                    $DescriCodice = $rowDescriCodice['descrizione'];
                    $numFamiglieAgg++;
                    //Per ogni lingua inserisco id e vocabolo 
                    $sqlLingua = findAllLingua();
                    while ($rowLingua = mysql_fetch_array($sqlLingua)) {

                        $insertDescriCodice = insertNewDizionario($rowLingua['id_lingua'], $IdDizDescriCodice, $IdCodice, $DescriCodice, dataCorrenteInserimento());
                        
                        if (!$insertDescriCodice) {
                            $erroreResultDescriCodice = true;
                        }
                    }//End lingue
                }//End if non esiste vobabolo in dizionario
            }//End while

            if (!$sqlLingua OR !$sqlDizTipo OR
                    $erroreResultProdotti OR
                    !$sqlProdotto OR
                    !$sqlDizProdotto OR
                    $erroreResultColBase OR
                    !$sqlColoreBase OR
                    !$sqlDizColore OR
                    $erroreResultComponente OR
                    !$sqlComponente OR
                    !$sqlDizComponente OR
                    $erroreResultMessaggio OR
                    !$sqlMessaggio OR
                    !$sqlDizMessaggio OR
                    $erroreResultDescriCodice OR
                    !$sqlDescriCodice OR
                    !$sqlDizDescriCodice) {

                rollback();

                echo $msgTransazioneFallita . "!</br>";
                echo $msgErrContacAdminSeProblema . "!</br>";
                echo '<a href="gestione_dizionario.php">' . $msgTornaAlDizionario . '</a>';
            } else {

                commit();

                mysql_close();
                 
                echo $msgAggiornamentoVocaboliCompletato . '<br/><br/>
                            ' . $msgSonoStatiAgg . '<br/> 
                            ' . $numProdottoAgg . ' '.$filtroNomiProdotti.'<br/>                            
                            ' . $numColoriBaseAgg . ' '.$filtroNomiColoriBase.'<br/>  
                            ' . $numComponentiAgg . ' '.$filtroNomiComponenti.'<br/>  
                            ' . $numMessaggiMacAgg . ' '.$labelMenuMessaggiMac.'<br/>  
                            ' . $numFamiglieAgg  . ' '.$filtroFamiglieProdotti.'<br/><br/> 
                            <a href="gestione_dizionario.php">' . $msgTornaAlDizionario . '</a>';
            }
            ?>
        </div>
    </body>
</html>
