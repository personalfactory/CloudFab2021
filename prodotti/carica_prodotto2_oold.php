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
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_anagrafe_prodotto.php');
            include('../sql/script_codice.php');
            include('../sql/script_componente.php');
            include('../sql/script_componente_prodotto.php');
            include('../sql/script_prodotto.php');           
            
            $Pagina = "carica_prodotto2";

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
            
            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
            
//            $strUtentiVisComp = getUtentiPropVisib($_SESSION['objPermessiVis'], 'componente');
//            $strAziendeVisComp = getAziendeVisib($_SESSION['objPermessiVis'], 'componente');
            $strUtentiAziendeComp = getStrUtAzVisib($_SESSION['objPermessiVis'], 'componente');
//Recupero l'id del tipo di  codice dalla tabella codice
            $sqlTipoCodice = findCodiceByTipo($TipoCodice);
            $sqlComponente = selectComponentiVis($strUtentiAziendeComp,"descri_componente");
            
//                    mysql_query("SELECT id_codice FROM serverdb.codice WHERE tipo_codice='" . $TipoCodice . "'");
//                    or die("Errore 1 : SELECT  serverdb.codice" . mysql_error());

            while ($rowTipoCodice = mysql_fetch_array($sqlTipoCodice)) {
                $IdCodice = $rowTipoCodice['id_codice'];
            }

//#################### Gestione degli errori sulle query #######################         

            $erroreResult = false;
            $sqlComp = true;
            $sqlIdProd = true;
            $insertIntoAnagrafeProdotto = true;
            $insertIntoProdotto = true;

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
//                $sql = mysql_query("SELECT * FROM componente ORDER BY descri_componente");
                //or die("Errore 1 : SELECT  serverdb.componente" . mysql_error());
                //Memorizzo nelle rispettive variabili la quantita e la presa dei componenti relativi al prodotto da inserire mandati tramite POST
                while ($row = mysql_fetch_array($sqlComponente)) {

                    $QuantitaDaInserire = $_POST['Qta' . $NComp];

                    //Controllo degli input quantita e presa inseriti
                    if (!is_numeric($QuantitaDaInserire)) {
                        $NumErrore++;
                        $messaggioQta = $messaggioQta . " " . $row['descri_componente'] . " : " . $msgErrQtaNumerica ."<br/>";
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
                    //Vado avanti e salvo
                    //Salvo nella tabella prodotto
                    $insertIntoProdotto = insertNuovoProdotto($CodiceProdotto, $NomeProdotto,"1", dataCorrenteInserimento(), $_SESSION['id_utente'], $IdAzienda);
	
                    if($IdProdottoPadre==0) $IdProdottoPadre=mysql_insert_id();

                    $insertIntoAnagrafeProdotto=insertNuovoAnProd($CodiceProdotto,
                            $IdProdottoPadre,$LimiteColore,$FattoreDivisore,
                            $Fascia,$Mazzetta,$IdCodice,
                            $Geografico,$TipoRiferimento,$Gruppo,$LivelloGruppo,
                            $Categoria,"1", dataCorrenteInserimento());
                    

//Memorizzo in una variabile l'id_prodotto del prodotto appena inserito			
                    $sqlIdProd = findProdottoByCodice($CodiceProdotto);
                    while ($rowIdProd = mysql_fetch_array($sqlIdProd)) {
                        $IdProdotto = $rowIdProd['id_prodotto'];
                    }

                    // Salvo le quantità  nella tabella componente_prodotto	
                    //Seleziono le componenti presenti in componente
                    $NComp = 1;
                    mysql_data_seek($sqlComponente, 0);
                    
                    //Memorizzo nelle rispettive variabili la quantita e la 
                    //presa dei componenti relativi al prodotto da inserire 
                    //mandati tramite POST
                    while ($row = mysql_fetch_array($sqlComponente)) {

                        $QuantitaDaInserire = $_POST['Qta' . $NComp];
                        $SalvaQta = false;


                        //Quantita >0
                        if ($QuantitaDaInserire > 0 && $QuantitaDaInserire != "" && isset($QuantitaDaInserire)) {
                            $SalvaQta = true;
                        }
                        if ($SalvaQta == true) {
                            // Non ci sono errori quindi posso andare avanti

                            $insertIntoCompProd = insertNuovoComponenteProd($IdProdotto,$row['id_comp'],$QuantitaDaInserire,
                                    "1",  dataCorrenteInserimento());
                                    
                            if (!$insertIntoCompProd) {
                                $erroreResult = true;
                            }
                        }
                        $NComp++;
                    }//End while componenti

                    if ($erroreResult OR !$sqlComp OR !$sqlIdProd OR !$insertIntoAnagrafeProdotto OR !$insertIntoProdotto
                    ) {

                        rollback();
                        echo "</br>".$msgTransazioneFallita;
                        echo "</br>erroreResult : " . $erroreResult;
                        echo "</br>sqlComp : " . $sqlComp;
                        echo "</br>sqlIdProd : " . $sqlIdProd;
                        echo "</br>insertIntoAnagrafeProdotto : " . $insertIntoAnagrafeProdotto;
                        echo "</br>insertIntoProdotto : " . $insertIntoProdotto;
                    } else {

                        commit();
                        mysql_close();
                        ?>
                        <script language="javascript">
                            window.location.href = "gestione_anagrafe_prodotti.php";
                        </script>
                        <?php
                    }
                }//End if ($NumErrore) controllo degli input relativo alle quantita componenti 
            }//End if ($errore) controllo degli input relativo al prodotto 	
            ?>
        </div>
    </body>
</html>
