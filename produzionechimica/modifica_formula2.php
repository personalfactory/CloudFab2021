<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
            if($DEBUG)  ini_set(display_errors, "1");
            
            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../Connessioni/storico.php');
            include('../sql/script_formula.php');
            include('../sql/script_accessorio.php');
            include('../sql/script_accessorio_formula.php');
            include('../sql/script_generazione_formula.php');
            include('../sql/script.php');
            
            $Pagina = "modifica_formula2";

//############# ANAGRAFE FORMULA #######################################
            $CodiceFormula = $_POST['CodiceFormula'];
            $DataFormula = $_POST['DataFormula'];
            $DescriFormula = str_replace("'", "''", $_POST['DescriFormula']);
           //Numero di sacchetti in un lotto
            $NumeroKitSacchetti = str_replace("'", "''", $_POST['NumeroKitSacchetti']);
            $NumeroLotti = str_replace("'", "''", $_POST['NumeroLotti']);
            $PesoLotto = str_replace("'", "''", $_POST['PesoLotto']);
            $QtaMiscelaInserita = str_replace("'", "''", $_POST['QtaMiscelaInserita']);
            $TotQtaKit = str_replace("'", "''", $_POST['TotQtaKit']);
            $NumSacchetti=$NumeroKitSacchetti*$NumeroLotti;
           
            
            $MetodoCalcolo = $_POST['MetodoCalcolo'];
                foreach ($MetodoCalcolo as $key => $value) {
//                    echo "Hai selezionato il metodo: $key con valore: $value<br />";
                    $MetodoCalcolo = $value;
                }
            
            
            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
            
//#################### GESTIONE ERRORI ###################################
//Inizializzo l'errore relativo ai campi della tabella formula
            $errore = false;
//Inizializzo le variabile che contano il numero di errori 
//fatti sui campi quantita accessori e qta materia prima
            $NumErroreAcc = 0;
            $NumErroreMt = 0;

            include('./include/controllo_input_formula.php');

            if ($errore) {
                $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                echo $messaggio;
            
             } else {

                begin();
                $sqlAccessori = findAccessoriFormulaByCodFormula($CodiceFormula);
//                        findAccessFormByCodFormula($CodiceFormula, "scatLot", "eticLot", "sacCh", "eticCh", "OPER");
                $sqlMatPrime = findMaterieFormulaByCodice($CodiceFormula, "descri_mat");
                commit();

                //Vado avanti perche non ci sono errori sui campi della tabella formula
                //Estraggo l'elenco degli accessori presenti nella tabella accessorio_formula  
                //associati alla formula che si sta modificando, 
                //esclusi quelli già arrivati dal post come singoli campi
                $NAcc = 1;
                $messaggioQtaAcc = "";
                while ($rowAccessori = mysql_fetch_array($sqlAccessori)) {

                    //Memorizzo nelle rispettive variabili le quantità di accessori
                    $QuantitaAccessorio = $_POST['QtaAcc' . $NAcc];

                    //Controllo input quantità accessori
                    if (!is_numeric($QuantitaAccessorio)) {
                        $NumErroreAcc++;
                        $messaggioQtaAcc = $messaggioQtaAcc . " " . $rowAccessori['descri'] . " " . $msgErrQtaNumerica . "<br/>";
                    }
                    if ($QuantitaAccessorio < 0) {
                        $NumErroreAcc++;
                        $messaggioQtaAcc = $messaggioQtaAcc . " " . $rowAccessori['descri'] . " " . $msgErrQtaMagZero . "<br/>";
                    }
                    $NAcc++;
                }//End While Accessori di accessori_formula
                //Effettuo il controllo sulla variabile NumErroreAcc
                if ($NumErroreAcc > 0) {
                    $messaggioQtaAcc = $messaggioQtaAcc . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                    echo $messaggioQtaAcc;
                } else {
                    
                        //Vado avanti perche non ho errori sugli accessori 
                        //Estraggo l'elenco delle materie prime presenti nella generazione_formula 
                        $NMatPri = 1;
                        $messaggioQtaMatPri = "";
                        while ($rowMatPrime = mysql_fetch_array($sqlMatPrime)) {

                            //Memorizzo nelle rispettive variabili le quantita di materia_prime per miscela
                            $QuantitaMatPrima = $_POST['QtaMiscela' . $NMatPri];
                             //Memorizzo nelle rispettive variabili le quantita di materia_prime per kit
                            $QuantitaMPKit = $_POST['Qta' . $NMatPri];

                            //Controllo input quantita materie prime
                            if (!is_numeric($QuantitaMatPrima) OR !is_numeric($QuantitaMPKit) ) {
                                $NumErroreMt++;
                                $messaggioQtaMatPri = $messaggioQtaMatPri . " " . $rowMatPrime['descri_mat'] . " " . $msgErrQtaNumerica . "<br/>";
                            }
                            if ($QuantitaMatPrima < 0) {
                                $NumErroreMt++;
                                $messaggioQtaMatPri = $messaggioQtaMatPri . " " . $rowMatPrime['descri_mat'] . " " . $msgErrQtaMagZero . "<br/>";
                            }
                            $NMatPri++;
                        }// End While finite le materie prime di generazione formula
                        //Effettuo il controllo sulla variabile NumErroreMt
                        if ($NumErroreMt > 0) {
                            $messaggioQtaMatPri = $messaggioQtaMatPri . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                            echo $messaggioQtaMatPri;
                        } else {
                           
                                
                                //####################################################################
                                //######################### SALVATAGGIO ##############################
                                //####################################################################
                                $erroreTransazione = false;
                                $insertStoricoFormula = true;
                                $insertStoricoAccForm = true;
                                $insertStoricoGenForm = true;
                                $updateFormula = true;
                                                                      
                                $updateAccForm = true;
                                $insertAccForm = true;
                                $updateGenForm = true;
                                $insertGenForm = true;

                                if ($errore == false && $NumErroreAcc == 0 && $NumErroreMt == 0) {

                                    begin();
                                    
                                    $sqlFormula = findAnFormulaByCodice($CodiceFormula);
                                    $sqlAcc = findAccessoriFormulaByCodFormula($CodiceFormula);

                                    // 1 . Storicizzo e modifico formula, generazione_formula e accessorio_formula
                                    while ($rowFormula = mysql_fetch_array($sqlFormula)) {

                                        $cod_formula_old = $rowFormula['cod_formula'];
                                        $dt_formula_old = $rowFormula['dt_formula'];
                                        $descri_formula_old = $rowFormula['descri_formula'];
                                        $num_sac_old = $rowFormula['num_sac'];
                                        $qta_sac_old = $rowFormula['qta_sac'];
                                        $abilitato_old = $rowFormula['abilitato'];
                                        $dt_abilitato_old = $rowFormula['dt_abilitato'];
                                    }
                                    //Inserisco nello storico delle formule  i valori appena memorizzati del vecchio record
                                    include('../Connessioni/storico.php');
                                    $insertStoricoFormula = storicizzaAnFormula($cod_formula_old, $dt_formula_old, $descri_formula_old, $num_sac_old, $qta_sac_old, $abilitato_old, $dt_abilitato_old);
                                    while ($rowAcc = mysql_fetch_array($sqlAcc)) {

                                        $id_acces_form_old = $rowAcc['id_acces_form'];
                                        $cod_formula_old = $rowAcc['cod_formula'];
                                        $accessorio_old = $rowAcc['accessorio'];
                                        $quantita_old = $rowAcc['quantita'];
                                        $abilitato_old = $rowAcc['abilitato'];
                                        $dt_abilitato_old = $rowAcc['dt_abilitato'];

                                        $insertStoricoAccForm = storicizzaAccessorioFormula($id_acces_form_old, $cod_formula_old, $accessorio_old, $quantita_old, $abilitato_old, $dt_abilitato_old);
                                        if (!$insertStoricoAccForm)
                                            $erroreTransazione = true;
                                    }//End While accessori
                                    //Seleziono  i vecchi  record corrispondenti al codice formula 
                                    $sqlMatPri = findMatPrimeFormulaByCodFormula($CodiceFormula);
                                    while ($rowMt = mysql_fetch_array($sqlMatPri)) {

                                        $id_gen_form_old = $rowMt['id_gen_form'];
                                        $cod_formula_old = $rowMt['cod_formula'];
                                        $cod_mat_old = $rowMt['cod_mat'];
                                        $quantita_old = $rowMt['quantita'];
                                        $dt_inser_old = $rowMt['dt_inser'];
                                        $abilitato_old = $rowMt['abilitato'];
                                        $dt_abilitato_old = $rowMt['dt_abilitato'];

                                        //Inserisco nello storico di generazione_formula i valori appena memorizzati 
                                        $insertStoricoGenForm = storicizzaGenerazioneFormula($id_gen_form_old, $cod_formula_old, $cod_mat_old, $quantita_old, $dt_inser_old, $abilitato_old, $dt_abilitato_old);
                                        if (!$insertStoricoGenForm)
                                            $erroreTransazione = true;
                                    }//End While Materie prime
                                    
                                    //Modifico la tabella corrente formula
                                    $updateFormula = updateFormulaByCodice($CodiceFormula, $DescriFormula, $NumSacchetti, $TotQtaKit,
                                            $NumeroKitSacchetti,$NumeroLotti,$PesoLotto,$QtaMiscelaInserita,"1", dataCorrenteInserimento(),$MetodoCalcolo,$IdAzienda);

                                   
                                    //Estraggo l'elenco degli accessori presenti 
                                    //nella tabella accessorio_formula  associati alla formula che si sta modificando
                                    $NAcc = 1;
                                    $sqlAccessori =  $sqlAccessori = findAccessoriFormulaByCodFormula($CodiceFormula);
                                    while ($rowAccessori = mysql_fetch_array($sqlAccessori)) {

                                        //Memorizzo nelle rispettive variabili le quantità di accessori
                                        $QuantitaAccessorio = $_POST['QtaAcc' . $NAcc];
                                        $SalvaQtaAcc = false;

                                        //Controllo la variabile che mi dice se salvare o meno
                                        if (!isset($QuantitaAccessorio)) {
                                            $SalvaQtaAcc = false;
                                        }
//                                        if (is_numeric($QuantitaAccessorio) && $QuantitaAccessorio > 0 && $QuantitaAccessorio != "" && isset($QuantitaAccessorio)) {
                                        if (is_numeric($QuantitaAccessorio) && $QuantitaAccessorio != "" && isset($QuantitaAccessorio)) {  
                                        $SalvaQtaAcc = true;
                                        }
                                        if ($SalvaQtaAcc == true) {
                                            //Effettuo l'update degli accessori già esistenti in tabella
                                            $updateAccForm = modificaAccessorioFormula($CodiceFormula, $rowAccessori['accessorio'], $QuantitaAccessorio, dataCorrenteInserimento());
                                            if (!$updateAccForm)
                                                $erroreTransazione = true;
                                        }
                                        $NAcc++;
                                    }//End While modifica Accessori di accessori_formula
                                    
                                    // 4. Salvo le modifiche fatte alle materie_prime di generazione_formula 
                                    //Estraggo l'elenco delle materie prime presenti nella generazione_formula 
                                    $NMatPri = 1;
                                    $sqlMatPrime = findMaterieFormulaByCodice($CodiceFormula, "descri_mat");
                                    while ($rowMatPrime = mysql_fetch_array($sqlMatPrime)) {

                                        //Memorizzo nelle rispettive variabili le quantita di materia_prime
                                        $QuantitaMatPrima = $_POST['QtaMiscela' . $NMatPri];
                                        $QuantitaMPKit = $_POST['Qta' . $NMatPri];
                                        
                                        $SalvaQtaMatPrima = false;

                                        //Controllo variabile salva
                                        if (!isset($QuantitaMatPrima) OR !isset($QuantitaMPKit)) {
                                            $SalvaQtaMatPrima = false;
                                        }
                                        if (is_numeric($QuantitaMatPrima) && $QuantitaMatPrima > 0 && $QuantitaMatPrima != "" && isset($QuantitaMatPrima) AND
                                                is_numeric($QuantitaMPKit) && $QuantitaMPKit > 0 && $QuantitaMPKit != "" && isset($QuantitaMPKit)) {
                                            $SalvaQtaMatPrima = true;
                                        }
                                        if ($SalvaQtaMatPrima == true) {
                                            // Salvo le quantita nella tabella generazione formula	
                                            $updateGenForm = modificaGenerazioneFormula($rowMatPrime['id_gen_form'], $CodiceFormula, $QuantitaMatPrima,$QuantitaMPKit, dataCorrenteInserimento());
                                            if (!$updateGenForm)
                                                $erroreTransazione = true;
                                        }
                                        $NMatPri++;
                                    }// End While finito salvataggio delle modifiche alle materie prime di generazione formula
                                    
                                    if (
                                            $erroreTransazione OR
                                            !$insertStoricoFormula OR
                                            !$insertStoricoAccForm OR
                                            !$insertStoricoGenForm OR
                                            !$updateFormula OR
                                            !$updateAccForm OR                                            
                                            !$updateGenForm 
                                            
                                    ) {
                                        rollback();
                                           echo 'erroreTransazione : '.$erroreTransazione.'<br/>' ;
                                           echo 'insertStoricoFormula : '.$insertStoricoFormula.'<br/>' ;
                                           echo 'insertStoricoAccForm : '.$insertStoricoAccForm.'<br/>' ;
                                           echo 'insertStoricoGenForm : '.$insertStoricoGenForm.'<br/>' ;
                                           echo 'updateFormula : '.$updateFormula.'<br/>' ;
                                           echo 'updateAccForm : '.$updateAccForm.'<br/>' ;
                                           echo 'updateGenForm : '.$updateGenForm.'<br/>' ;
                                           echo $msgTransazioneFallita . ' <a href="gestione_formula.php">' . $msgErrContactAdmin . '</a><br/>';
                                    } else {
                                        commit();
                                        echo $msgModificaCompletata . ' <a href="gestione_formula.php">' . $msgTornaAlleFormule . '</a><br/>';
                                    }
                                }//End if errore totale
                            }//End if NumErroreAcc
                       }//End if NumErroreMt               
            }//End if ($errore) controllo degli input relativo alla FORMULA 
            ?>
        </div>
    </body>
</html>
