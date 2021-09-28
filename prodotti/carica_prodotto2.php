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
            include('../include/precisione.php');
            include('../include/funzioni.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_anagrafe_prodotto.php');
            include('../sql/script_codice.php');
            include('../sql/script_componente.php');
            include('../sql/script_componente_prodotto.php');
            include('../sql/script_prodotto.php');
            include('../sql/script_parametro_prod.php');
            include('../sql/script_valore_prodotto.php');
            include('../sql/script_parametro_prod_mac.php');
            
            include('../sql/script_valore_par_prod_mac.php');
            include('../sql/script_macchina.php');
            include('../sql/script_dizionario.php');
            include('../sql/script_lingua.php');
            include('../sql/script_parametro_comp_prod.php');
            include('../sql/script_valore_par_comp.php');
            
            include('../sql/script_componente_pesatura.php');
            include('../sql/script_parametro_glob_mac.php');

            $Pagina = "carica_prodotto2";
            
            $strUtentiAziendeProd = getStrUtAzVisib($_SESSION['objPermessiVis'], 'prodotto');

//##############################################################################
//######## INFORMAZIONI ANAGRAFICHE DEL PRODOTTO  ##############################
//##############################################################################
//
//Ricavo il valore dei campi tipo_riferimento e geografico mandati tramite POST
            $TipoRiferimento = $_POST['scegli_geografico'];
            $Geografico = "";
            if ($TipoRiferimento == "Mondo") {
                $Geografico = "Mondo";
            } else if ($TipoRiferimento == "Continente") {
                $Geografico = $_POST['Continente'];
            } else if ($TipoRiferimento == "Stato") {
                $Geografico = $_POST['Stato'];
            } else if ($TipoRiferimento == "Regione") {
                $Geografico = $_POST['Regione'];
            } else if ($TipoRiferimento == "Provincia") {
                $Geografico = $_POST['Provincia'];
            } else if ($TipoRiferimento == "Comune") {
                $Geografico = $_POST['Comune'];
            }

//Ricavo il valore dei campi livello_gruppo e gruppo mandati tramite POST
            $LivelloGruppo = $_POST['scegli_gruppo'];
            $Gruppo = "";
            if ($LivelloGruppo == "PrimoLivello") {
                $Gruppo = $_POST['PrimoLivello'];
            } else if ($LivelloGruppo == "SecondoLivello") {
                $Gruppo = $_POST['SecondoLivello'];
            } else if ($LivelloGruppo == "TerzoLivello") {
                $Gruppo = $_POST['TerzoLivello'];
            } else if ($LivelloGruppo == "QuartoLivello") {
                $Gruppo = $_POST['QuartoLivello'];
            } else if ($LivelloGruppo == "QuintoLivello") {
                $Gruppo = $_POST['QuintoLivello'];
            } else if ($LivelloGruppo == "SestoLivello") {
//                $Gruppo = $_POST['SestoLivello'];
                $Gruppo = "Universale";
            }


            $CodiceProdotto = str_replace("'", "''", $_POST['CodiceProdotto']);
            $TipoCodice = substr($CodiceProdotto, 0, 3);
            $NomeProdotto = str_replace("'", "''", $_POST['NomeProdotto']);
            $IdProdottoPadre = str_replace("'", "''", $_POST['IdProdottoPadre']);
            $CodProdottoPadre = str_replace("'", "''", $_POST['CodProdottoPadre']);
            $LimiteColore = str_replace("'", "''", $_POST['LimiteColore']);
            $FattoreDivisore = str_replace("'", "''", $_POST['FattoreDivisore']);
            $Fascia = str_replace("'", "''", $_POST['Fascia']);
            $PostMazzetta = str_replace("'", "''", $_POST['Mazzetta']);
            $Geografico = str_replace("'", "''", $Geografico);
            $Gruppo = str_replace("'", "''", $Gruppo);
            
            //Il campo tipo specifica che si tratta di un prodotto e non di un colore
            $tipo="";
            
            $sqlTipo=findParGlobMacById($valIdParGlobTipoProd);
            while ($row = mysql_fetch_array($sqlTipo)) {
                $tipo = $row['valore_variabile'];
            }
            
            $serieColore="";
            $serieAdditivo="";
            $sqlSerie=findParGlobMacById($valIdParGlobSerie);
            while ($row = mysql_fetch_array($sqlSerie)) {
                $serieColore = $row['valore_variabile'];
                $serieAdditivo= $row['valore_variabile'];
            }
            
             if (isSet($_POST['SerieColore']))
                    $serieColore = str_replace("'", "", $_POST['SerieColore']);
                if (isSet($_POST['SerieAdditivo']))
                    $serieAdditivo = str_replace("'", "", $_POST['SerieAdditivo']);
            
            
            /**
            $sqlParGlob = findParGlobMac();
             while ($rowParGlob = mysql_fetch_array($sqlParGlob)) {

                switch ($rowParGlob['id_par_gm']) {

                 
                    case 157:
                        //CARATTERE SEPARATORE SERIE COLORE
                        $carattereSeparatoreSerieColore = $rowParGlob['valore_variabile'];
                        
                        break;
                     case 158:
                        //CARATTERE SEPARATORE SERIE ADDITIVI
                        $carattereSeparatoreSerieAdditivo= $rowParGlob['valore_variabile'];
                        
                        break;
                    default:
                        break;
                }
            }
            
           $stringaSerieColore="";
            $sqlSerieColore = findAllSerieVisibiliAbilitati("serie_colore", "serie_colore", $strUtentiAziendeProd);
            $k=1;
            while ($rowSerieColori = mysql_fetch_array($sqlSerieColore)) {
             if (isset($_POST['SerieColore' . $k]) AND $_POST['SerieColore' . $k]!="") {
                 
                 if($k=1) $stringaSerieColore=$_POST['SerieColore' . $k];
                 
                 else
                 
                 $stringaSerieColore=$stringaSerieColore.$carattereSeparatoreSerieColore.$_POST['SerieColore' . $k];
                 
             }
            $k++;
             
             }*/
            

            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);

            $strUtentiAziendeComp = getStrUtAzVisib($_SESSION['objPermessiVis'], 'componente');
            
            //Recupero l'id del tipo di  codice dalla tabella codice
            $sqlTipoCodice = findCodiceByTipo($TipoCodice);
            
            //$sqlComponente = selectComponentiVis($strUtentiAziendeComp, "descri_componente");
            $sqlComponente = selectCompVisByDizionarioAndTipo2($strUtentiAziendeComp,"descri_componente", $_SESSION['lingua'],$valTipo2RawMaterial);


            while ($rowTipoCodice = mysql_fetch_array($sqlTipoCodice)) {
                $IdCodice = $rowTipoCodice['id_codice'];
            }

//#################### Gestione degli errori sulle query #######################         

            $erroreResult = false;

            $sqlComp = true;
            $sqlIdProd = true;

            $insertIntoAnagrafeProdotto = true;
            $insertIntoProdotto = true;
            $insertIntoValProdotto = true;
            $insertIntoValParProdMac = true;
            $insertProdottoInDizionario = true;

            $insertIntoCompProd=true;
            $insertIntoCompPesatura=true;
            
            
            $InsertValoreParComp = true;
            $erroreValParCompResult = false;


//#################### Gestione degli errori sull'input ########################

            $errore = false; //errore relativo ai campi delle tabelle prodotto e anagrafe_prodotto
//Inizializzo la variabile che conta il numero di errori fatti sui campi quantita e presa
            $NumErrore = 0;

            include('./include/controllo_input_prodotto.php');

            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {
                //Vado avanti perche non ci sono errori 

                list($Mazzetta, $NomeMazzetta) = explode(';', $_POST['Mazzetta']);
                list($Categoria, $NomeCategoria) = explode(';', $_POST['Categoria']);

//##############################################################################
//###################### COMPONENTI DEL PRODOTTO  ##############################
//##############################################################################   
                //Seleziono le componenti presenti in componente
                $NComp = 1;
                $NCompPrecedente = 0;
                $messaggioQta = "";
                //Memorizzo nelle rispettive variabili la quantita e la presa dei componenti relativi al prodotto da inserire mandati tramite POST
                while ($row = mysql_fetch_array($sqlComponente)) {

                    $QuantitaDaInserire = $_POST['Qta' . $NComp];
                    $ordineDos = $_POST['OrdineDos' . $NComp];
                    $tollEcc =$_POST['TollEcc' . $NComp];
                    $tollDif=$_POST['TollDif' . $NComp];
                    $fluidificazione=$_POST['Fluidificazione' . $NComp];
                            
                    //Controllo degli input quantita e presa inseriti
                    if (!is_numeric($QuantitaDaInserire) OR !is_numeric($ordineDos) OR !is_numeric($tollEcc) OR !is_numeric($tollDif) OR !is_numeric($fluidificazione)) {
                        $NumErrore++;
                        $messaggioQta = $messaggioQta . " " . $row['descri_componente'] . " : " . $msgErrQtaNumerica . "<br/>";
                    }

                    $NComp++;
                }// End While finiti i componenti 
                //Controllo sull'errore
                if ($NumErrore > 0) {
                    //Ci sono errori quindi non salvo
                    $messaggioQta = $messaggioQta . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                    echo '<div id="msgErr">' . $messaggioQta . '</div>';
                } else {

                    //######################################################################
                    //########## INIZIO TRANSAZIONE ########################################
                    //######################################################################

                    begin();
                    //###### Seleziono le macchine che vedono il prodotto ################
                    $selectMacchine = selectStabAbilitatiByGruppoGeo($Gruppo, $Geografico);
                    $SelectParametroCp = findAllParametriComp("id_par_comp");

                    //Vado avanti e salvo
                    //Salvo nella tabella prodotto
                    $insertIntoProdotto = insertNuovoProdotto($CodiceProdotto, $NomeProdotto, "1", dataCorrenteInserimento(), $_SESSION['id_utente'], $IdAzienda,$tipo,$serieColore,$serieAdditivo);

                    if ($IdProdottoPadre == 0)
                        $IdProdottoPadre = mysql_insert_id();

                    $insertIntoAnagrafeProdotto = insertNuovoAnProd($CodiceProdotto, $IdProdottoPadre, $LimiteColore, $FattoreDivisore, $Fascia, $Mazzetta, $IdCodice, $Geografico, $TipoRiferimento, $Gruppo, $LivelloGruppo, $Categoria, "1", dataCorrenteInserimento());


                    //Memorizzo in una variabile l'id_prodotto del prodotto appena inserito			
                    $sqlIdProd = findProdottoByCodice($CodiceProdotto);
                    while ($rowIdProd = mysql_fetch_array($sqlIdProd)) {
                        $IdProdotto = $rowIdProd['id_prodotto'];
                    }

                    //Salvo le quantità  nella tabella componente_prodotto	
                    //Seleziono le componenti presenti in componente
                    $NComp = 1;
                    $i = 0;
                    $arrayCompProd = array();
                    mysql_data_seek($sqlComponente, 0);

                    //Memorizzo nelle rispettive variabili la quantita e la 
                    //presa dei componenti relativi al prodotto da inserire 
                    //mandati tramite POST
                    while ($row = mysql_fetch_array($sqlComponente)) {
                        
                        $metodoPesa=$_POST['MetodoPesa' . $NComp];
                        $QuantitaDaInserire = $_POST['Qta' . $NComp];
                        $ordineDos = $_POST['OrdineDos' . $NComp];
                        $tollEcc =$_POST['TollEcc' . $NComp];
                        $tollDif=$_POST['TollDif' . $NComp];
                        $fluidificazione=0;
                        $valoreFluidificazione=0;
                        if($_POST['Fluidificazione' . $NComp]>0){
                                $fluidificazione=1;
                                $valoreFluidificazione=$_POST['Fluidificazione' . $NComp];
                        }
                        $note="";
                        $stepDosaggio=1;
                        
                        $SalvaQta = false;

                        //Quantita >0
                        if ($QuantitaDaInserire > 0 && $QuantitaDaInserire != "" && isset($QuantitaDaInserire)){                 
                            
                            $SalvaQta = true;
                        }
                        if ($SalvaQta == true) {
                            // Non ci sono errori quindi posso andare avanti

                            $insertIntoCompProd = insertNuovoComponenteProd($IdProdotto, $row['id_comp'], $QuantitaDaInserire, $valAbilitato, dataCorrenteInserimento());
                           
                            $insertIntoCompPesatura= insertNuovoComponentePesatura($IdProdotto, $row['id_comp'], $metodoPesa,$stepDosaggio,$ordineDos,
                                    $tollEcc,$tollDif,$fluidificazione,$valoreFluidificazione,$QuantitaDaInserire,$note, $valAbilitato, dataCorrenteInserimento());
                            
                            $arrayCompProd[$i] = $row['id_comp'];
                            $i++;
                            //TO DO Vedo a quali macchine va il prodotto e verifico
                            //per ogni macchina che nella tab valore_par_comp ci siano i parametri relativi ai componenti del prodotto 
                            if (!$insertIntoCompProd OR !$insertIntoCompPesatura) {
                                $erroreResult = true;
                            }
                        }
                        $NComp++;
                    }//End while componenti
                    
                    //##########################################################
                    //########### CREAZIONE VALORI PRODOTTO ####################
                    //##########################################################

                    $sqlParProd = findAllParametriProd("id_par_prod");
                    //Per ogni parametro inserisce un valore nella tabella valore_prodotto
                    while ($rowPar = mysql_fetch_array($sqlParProd)) {

                        $valorePar = $_POST['Valore' . $rowPar['id_par_prod']];

                        $insertIntoValProdotto = insertValoriProdotto($rowPar['id_par_prod'], $IdProdotto, $valorePar);
                        if (!$insertIntoValProdotto)
                            $erroreResult = true;
                    }//End While parametri
                    
                    //##########################################################
                    //###### CREAZIONE DEI VALORI PRODOTTO MACCHINA ############
                    //##########################################################
                    //Vengono generati i valori par prod mac per tutte le macchine 
                    //che appartengono al gruppo e rif geo del prodotto
                    if (mysql_num_rows($selectMacchine) > 0)
                        mysql_data_seek($selectMacchine, 0);
                    $j=0;
                    $arrayMac=array();
                    while ($rowMac = mysql_fetch_array($selectMacchine)) {
                        
                        $arrayMac[$j] = $rowMac['id_macchina'];
                        $j++;
                        $idMacchina = $rowMac['id_macchina'];

                        $sqlParPrMac = findAllParametriProdMac("id_par_pm");
                        //Per ogni parametro inserisce un valore nella tabella valore_par_prod_mac
                        while ($rowParMac = mysql_fetch_array($sqlParPrMac)) {

                            $insertIntoValParProdMac = insertValoriProdottoMacchina($rowParMac['id_par_pm'], $IdProdotto, $idMacchina, $rowParMac['valore_base']);
                            if (!$insertIntoValParProdMac)
                                $erroreResult = true;
                        }//End While parametri
                    }

                    //##########################################################
                    //###### INSERIMENTO NEL DIZIONARIO ########################
                    //##########################################################
                    //Per ogni lingua inserisco il vocabolo                    
                    $sqlLingua = findAllLingua();
                    while ($rowLingua = mysql_fetch_array($sqlLingua)) {
                        //Inserisco nel dizionario id e nome del prodotto                         
                        $insertProdotti = insertNewDizionario($rowLingua['id_lingua'], "1", $IdProdotto, $NomeProdotto, dataCorrenteInserimento());

                        if (!$insertProdottoInDizionario) {
                            $erroreResult = true;
                        }
                    }//End while lingue
                    
                    //##########################################################
                    //###### VERIFICA VALORI PAR COMP ##########################
                    //##########################################################
                    //Vengono selezionate le macchine che vedono il prodotto
                    //Per ogni macchina, per ogni componente e per ogni parametro_comp_prod si inserisce nella tabella
                    //valore_par_comp solo se l'asociazione id_comp-id_par_comp id_macchina non esiste
//                    print_r($arrayCompProd);
                    
                     for ($j = 0; $j < count($arrayMac); $j++) {
                        echo "id_macchina :" . $arrayMac[$j]."<br />"; 

                        for ($i = 0; $i < count($arrayCompProd); $i++) {
                            echo "id_comp :".$arrayCompProd[$i]."<br />";
                        
                            if (mysql_num_rows($SelectParametroCp) > 0)
                                mysql_data_seek($SelectParametroCp, 0);
                            while ($rowPar = mysql_fetch_array($SelectParametroCp)) {
                                echo "id_par_comp :" . $rowPar['id_par_comp']."<br /><br />";
                            
                                $InsertValoreParComp = insertIfNotExistValParComp($arrayCompProd[$i], $rowPar['id_par_comp'], $rowPar['valore_base'], $arrayMac[$j], dataCorrenteInserimento());
                                if (!$InsertValoreParComp)
                                    $erroreValParCompResult = true;
                            }
                        }
                    }


                    if ($erroreResult OR
                            $erroreValParCompResult OR ! $sqlComp OR ! $sqlIdProd OR ! $insertIntoAnagrafeProdotto OR ! $insertIntoProdotto) {

                        rollback();
                        echo $msgTransazioneFallita . '<a href="gestione_anagrafe_prodotti.php">' . $msgOk . '</a><br/></br>';

                        echo "</br>erroreResult : " . $erroreResult;
                        echo "</br>sqlComp : " . $sqlComp;
                        echo "</br>sqlIdProd : " . $sqlIdProd;
                        echo "</br>insertIntoAnagrafeProdotto : " . $insertIntoAnagrafeProdotto;
                        echo "</br>insertIntoProdotto : " . $insertIntoProdotto;
                        echo "</br>erroreValParCompResult : " . $erroreValParCompResult;
                    } else {

                        
                        /**echo $msgInserimentoValoreParProdComp." <br />";

                        if (mysql_num_rows($selectMacchine) > 0)
                            mysql_data_seek($selectMacchine, 0);
                        while ($rowMac = mysql_fetch_array($selectMacchine)) {

                            echo $rowMac['id_macchina'] . " " . $rowMac['descri_stab'] . "<br />";
                        }*/
                        echo $msgInserimentoCompletato . ' <a href="gestione_anagrafe_prodotti.php">' . $msgOk . '</a><br/>';
                        commit();
                        mysql_close();



//<!--                        <script language="javascript">
//                            window.location.href = "gestione_anagrafe_prodotti.php";
//                        </script>-->
                    }
                }//End if ($NumErrore) controllo degli input relativo alle quantita componenti 
            }//End if ($errore) controllo degli input relativo al prodotto 	
            ?>
        </div>
    </body>
</html>
