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
                ini_set(display_errors, "1");

            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_formula.php');
            include('../sql/script_accessorio.php');
            include('../sql/script_accessorio_formula.php');
            include('../sql/script_materia_prima.php');
            include('../sql/script_generazione_formula.php');
            include('../include/precisione.php');
            $Pagina = "carica_formula2";

            $strUtentiAziendeAcc = getStrUtAzVisib($_SESSION['objPermessiVis'], 'accessorio');
            $strUtentiAziendeMatPri = getStrUtAzVisib($_SESSION['objPermessiVis'], 'materia_prima');

//Ricavo il valore dei campi tramite arrivati POST
            $CodiceFormula = str_replace("'", "''", $_POST['CodiceFormula']);
            $DescriFormula = str_replace("'", "''", $_POST['DescriFormula']);
            //Numero di sacchetti in un lotto
            $NumeroKitSacchetti = str_replace("'", "''", $_POST['NumeroKitSacchetti']);
            $NumeroLotti = str_replace("'", "''", $_POST['NumeroLotti']);
            $PesoLotto = str_replace("'", "''", $_POST['PesoLotto']);
            $QtaMiscelaInserita = str_replace("'", "''", $_POST['QtaMiscelaInserita']);
            $TotQtaKit = str_replace("'", "''", $_POST['TotQtaKit']);
            $NumSacchetti=$NumeroKitSacchetti*$NumeroLotti;
            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
            
            $MetodoCalcolo = $_POST['MetodoCalcolo'];
                foreach ($MetodoCalcolo as $key => $value) {
//                    echo "Hai selezionato il metodo: $key con valore: $value<br />";
                    $MetodoCalcolo = $value;
                }
            
            
//Ricalcolo la data corrente  
            $DataFormula = dataCorrenteInserimento();

//#################### Gestione degli errori ###################################
//Inizializzo l'errore relativo ai campi della tabella formula
            $errore = false;
            $NumErroreAcc = 0;
            $NumErroreMt = 0;

            include('./include/controllo_input_formula.php');

            if ($errore) {
                //Ci sono errori quindi stampo il messaggio
                $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                echo $messaggio;
            } else {
                //Vado avanti perchè non ci sono errori
                $NAcc = 1;
                $messaggioQtaAcc = "";
                $sqlAccessori = findAllAccessori("ordine", $strUtentiAziendeAcc);
//                        $sqlAccessori =findAccessoriDiversiDa("scatLot", "eticLot", "eticCh", "sacCh", "OPER",$strUtentiAziendeAcc);
                while ($rowAccessori = mysql_fetch_array($sqlAccessori)) {

                    $QuantitaAccessorio = $_POST['QtaAcc' . $NAcc];

                    if (!is_numeric($QuantitaAccessorio)) {
                        $NumErroreAcc++;
                        $messaggioQtaAcc = $messaggioQtaAcc . " " . $rowAccessori['descri'] . " : " . $msgErrQtaNumerica . "<br/>";
                    }
                    if ($QuantitaAccessorio < 0) {
                        $NumErroreAcc++;
                        $messaggioQtaAcc = $messaggioQtaAcc . " " . $rowAccessori['descri'] . " : " . $msgErrQtaMagZero . "<br/>";
                    }

                    $NAcc++;
                }//End While Accessori
                //Effettuo il controllo sulla variabile NumErroreAcc
                if ($NumErroreAcc > 0) {
                    $messaggioQtaAcc = $messaggioQtaAcc . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                    echo $messaggioQtaAcc;
                } else {


                    /////Vado avanti perchè non ci sono errori sulle quantità di accessori
                    //Inizializzo la variabile che controlla se è stata inserita almeno una quantità >0
                    //Se esiste almeno una qta >0 diventa true
                    $AlmenoUnaQta = false;

                    $NMatPri = 1;
                    $messaggioQtaMatPri = "";
                    $sqlMatPrime = findAllMatPrimeByTipoCod($prefissoCodComp, "descri_mat", $strUtentiAziendeMatPri);
                    while ($rowMatPrime = mysql_fetch_array($sqlMatPrime)) {

                        //Memorizzo nelle rispettive variabili le quantità di materia_prime per miscela e per kit
                        $QuantitaMatPrima = $_POST['QtaMiscela' . $NMatPri];
                        $QuantitaMPKit = $_POST['Qta' . $NMatPri];

                        //Verifico che sia stata inserita almeno una quantità
                        if ($QuantitaMatPrima > 0 OR $QuantitaMPKit>0) {
                            $AlmenoUnaQta = true;
                        }

                        //Controllo input quantità 
                        if (!is_numeric($QuantitaMatPrima) OR !is_numeric($QuantitaMPKit)) {
                            $NumErroreMt++;
                            echo $QuantitaMatPrima."--";
                            $messaggioQtaMatPri = $messaggioQtaMatPri . " " . $rowMatPrime['descri_mat'] . " : " . $msgErrQtaNumerica . "<br/>";
                        }
                        if ($QuantitaMatPrima < 0 OR $QuantitaMPKit <0) {
                            $NumErroreMt++;
                            $messaggioQtaMatPri = $messaggioQtaMatPri . " " . $rowMatPrime['descri_mat'] . " : " . $msgErrQtaMagZero . "<br/>";
                        }
                        $NMatPri++;
                    }// End While finite le materie prime 

                    if ($NumErroreMt > 0) {
                        $messaggioQtaMatPri = $messaggioQtaMatPri . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                        echo $messaggioQtaMatPri;
                    } else {

                        //Controllo che esista almeno una qta >0
                        if ($AlmenoUnaQta == false) {
                            echo $msgErrNessunaMat . ' <a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                        } else {
                            $insertAnFormula = true;
                            $insertAccessorio = true;
                            $insertGenerazFormula = true;
                            $erroreTransazione = false;

////////////////////////Vado avanti perchè non ci sono errori sulle quantità di materie prime					
////////////////////////Se sono arrivata fin qui vuol dire che non si sono verificati errori di nessun genere quindi posso salvare			
                            if ($errore == false && $NumErroreAcc == 0 && $NumErroreMt == 0) {
                                // 1 . Salvo nella tabella prodotto
                                $insertAnFormula = inserisciAnagrafeFormula(
                                        $CodiceFormula, 
                                        $DescriFormula, 
                                        dataCorrenteInserimento(), 
                                        $NumSacchetti, 
                                        $TotQtaKit, 
                                        $NumeroKitSacchetti,
                                        $NumeroLotti,
                                        $PesoLotto,
                                        $QtaMiscelaInserita,
                                        1,
                                        dataCorrenteInserimento(), 
                                        $MetodoCalcolo,
                                        $_SESSION['id_utente'],                                        
                                        $IdAzienda);

                                // 2.7.  Salvo le quantità nella tabella accessorio_formula ripetendo il ciclo fatto in precedenza
                                //Estraggo l'elenco degli accessori presenti nella tabella gaz_001artico di gazie catmer 4
                                $NAcc = 1;
                                mysql_data_seek($sqlAccessori, 0);
                                while ($rowAccessori = mysql_fetch_array($sqlAccessori)) {

                                    //Memorizzo nelle rispettive variabili le quantità di accessori
                                    $QuantitaAccessorio = $_POST['QtaAcc' . $NAcc];
                                    $SalvaQtaAcc = false;

                                    //Controllo la variabile che mi dice se salvare o meno le quantità accessori
                                    if (!isset($QuantitaAccessorio)) {
                                        $SalvaQtaAcc = false;
                                    }
                                    if (is_numeric($QuantitaAccessorio) && $QuantitaAccessorio > 0 && $QuantitaAccessorio != "" && isset($QuantitaAccessorio)) {
                                        $SalvaQtaAcc = true;
                                    }

                                    if ($SalvaQtaAcc == true) {

                                        $insertAccessorio = inserisciAccFormula($CodiceFormula, $rowAccessori['codice'], $QuantitaAccessorio, 1, dataCorrenteInserimento());
                                    }
                                    if (!$insertAccessorio)
                                        $erroreTransazione = true;
                                    $NAcc++;
                                }//End While Accessori	
                                // 3. Salvo nella tabella generazione_formula ripetendo il ciclo
                                $NMatPri = 1;
                                mysql_data_seek($sqlMatPrime, 0);
                                while ($rowMatPrime = mysql_fetch_array($sqlMatPrime)) {

                                    //Memorizzo nelle rispettive variabili le quantità di materia_prime
                                    $QuantitaMatPrima = $_POST['QtaMiscela' . $NMatPri];
                                    $QuantitaMPKit = $_POST['Qta' . $NMatPri];
                                    $SalvaQtaMatPrima = false;

                                    //Controllo input quantità accessori
                                    if (!isset($QuantitaMatPrima) OR !isset($QuantitaMPKit)) {
                                        $SalvaQtaMatPrima = false;
                                    }
                                    if (is_numeric($QuantitaMatPrima) && $QuantitaMatPrima > 0 && $QuantitaMatPrima != "" && isset($QuantitaMatPrima) &&
                                            is_numeric($QuantitaMPKit) && $QuantitaMPKit > 0 && $QuantitaMPKit != "" && isset($QuantitaMPKit)) {
                                        $SalvaQtaMatPrima = true;
                                    }
                                    if ($SalvaQtaMatPrima == true) {
                                        // Salvo le quantità nella tabella generazione formula	
                                        $insertGenerazFormula = inserisciGenerazioneFormula($rowMatPrime['cod_mat'], $CodiceFormula, $QuantitaMatPrima, $QuantitaMPKit,dataCorrenteInserimento(), 1, dataCorrenteInserimento());
                                    }
                                    if (!$insertGenerazFormula)
                                        $erroreTransazione = true;
                                    $NMatPri++;
                                }// End While finite le materie prime

                                if ($erroreTransazione OR !$insertAnFormula) {

                                    rollback();
                                    echo $msgTransazioneFallita . ' <a href="gestione_formula.php">' . $msgErrContactAdmin . '</a><br/>';
                                } else {

                                    commit();

                                    echo $msgInserimentoCompletato . ' <a href="gestione_formula.php">' . $msgTornaAlleFormule . '</a><br/>
                                    <br/> <a href="/CloudFab/prodotti/carica_prodotto.php">' . $msgInfoCreaProdotto;
                                }
                            }//End if Almeno una quantita>0
                        }//End if nessun errore
                    }//End if NumErroreAcc
                }//End if NumErroreMt
            }//End if ($errore) controllo degli input relativo alla FORMULA 
            ?>
        </div>
    </body>
</html>
