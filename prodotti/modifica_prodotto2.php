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
                ini_set("display_errors", "1");

            include('../include/menu.php');
            include('../include/precisione.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../Connessioni/storico.php');
            include('../sql/script.php');
            include('../sql/script_prodotto.php');
            include('../sql/script_anagrafe_prodotto.php');
            include('../sql/script_codice.php');
            include('../sql/script_componente_prodotto.php');
            include('../sql/script_dizionario.php');
            include('../sql/script_valore_prodotto.php');
            include('../sql/script_valore_par_prod_mac.php');
            include('../sql/script_parametro_prod_mac.php');
            include('../sql/script_macchina.php');
            include('../sql/script_parametro_comp_prod.php');
            include('../sql/script_valore_par_comp.php');
            include('../sql/script_parametro_glob_mac.php');

            include('../sql/script_componente_pesatura.php');

            $Pagina = "modifica_prodotto2";

            
            $serieAdditivo="";
            $serieColore="";
            $sqlParGlob = findParGlobMac();    
            while ($rowParGlob = mysql_fetch_array($sqlParGlob)) {

                switch ($rowParGlob['id_par_gm']) {

                      case 155:
                       //NONE
                        $serieColoreDefault = $rowParGlob['valore_variabile'];
                        $serieAdditivoDefault = $rowParGlob['valore_variabile'];
                     
                        break;
                    
                    
                    default:
                        break;
                }
            }
            
            
            
            
//##############################################################################
//######################### ANAGRAFE PRODOTTO ##################################
//##############################################################################
//Ricavo il valore dei campi tipo_riferimento e geografico mandati tramite POST
            ####################################################################
            //Conservo gruppo e rif geo del prodotto prima della modifica
            //se vengono modificati bisogna rigenerare i valori par comp mac
            $TipoRiferimentoOld = $_POST['TipoRiferimentoOld'];
            $LivelloGruppoOld = $_POST['LivelloGruppoOld'];
            $GeograficoOld = $_POST['GeograficoOld'];
            $GruppoOld = $_POST['GruppoOld'];
            ####################################################################

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
//		$Gruppo = $_POST['SestoLivello'];
                $Gruppo = "Universale";
            }

//Ricavo i valori dei campi mandati tramite post
            $IdProdotto = $_POST['IdProdotto'];
            $CodiceProdotto = str_replace("'", "''", $_POST['CodiceProdotto']);
            $TipoCodice = substr($CodiceProdotto, 0, 3);
            $NomeProdotto = str_replace("'", "''", $_POST['NomeProdotto']);
            $CodProdottoPadre = str_replace("'", "''", $_POST['CodProdottoPadre']);
            $LimiteColore = str_replace("'", "''", $_POST['LimiteColore']);
            $FattoreDivisore = str_replace("'", "''", $_POST['FattoreDivisore']);
            $Fascia = str_replace("'", "''", $_POST['Fascia']);
            $PostMazzetta = str_replace("'", "''", $_POST['Mazzetta']);
            $Geografico = str_replace("'", "''", $Geografico);
            $Gruppo = str_replace("'", "''", $Gruppo);
            $ProdAbilitato = str_replace("'", "''", $_POST['ProdAbilitato']);

            $SerieColore = $serieColoreDefault;
                $SerieAdditivo = $serieAdditivoDefault;

                if (isSet($_POST['SerieColore']))
                    $SerieColore = str_replace("'", "", $_POST['SerieColore']);
                if (isSet($_POST['SerieAdditivo']))
                    $SerieAdditivo = str_replace("'", "", $_POST['SerieAdditivo']);
            
            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);

//##############################################################################
//################## CONTROLLO ERRORI SULLE QUERY ##############################    
            $erroreResult = false;
            $erroreValParCompResult = false;
            $sqlProd = true;
            $sqlAnProd = true;
            $insertStoricoProd = true;
            $insertStoricoAnProd = true;
            $updateServerdbProd = true;
            $updateServerdbAnProd = true;
            $sqlComp = true;
            $insertStoricoCompPr = true;
            $updateServerdbCompProd = true;
            $updateServerdbDizionario = true;
            $updateValoreProdotto = true;
            $insertIntoStoricoValProdotto = true;
            $insertIntoValParProdMac = true;
            $InsertValoreParComp = true;

//##############################################################################
//################## CONTROLLO INPUT ###########################################
//##############################################################################
//Verifico che i parametri siano stati settati e che non siano vuoti
            $errore = false;
//Inizializzo la variabile che conta il numero di errori fatti sui campi quantita e presa
            $NumErrore = 0;

            include('./include/controllo_input_prodotto.php');

//Recupero l'id del tipo di codice dalla tabella codice
            $sqlTipoCodice = findCodiceByTipo($TipoCodice);
            while ($rowTipoCodice = mysql_fetch_array($sqlTipoCodice)) {
                $IdCodice = $rowTipoCodice['id_codice'];
            }

            if ($errore) {
                //Ci sono errori quindi non salvo
                $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                echo $messaggio;
            } else {

                list($Categoria, $NomeCategoria) = explode(';', $_POST['Categoria']);
                //Vado avanti perche non ci sono errori
                //Seleziono i record relativi alle componenti associate al prodotto che si sta modificando 
                $NComp = 1;
                $sql = selectComponentiByIdProdotto($IdProdotto);

                //Memorizzo nelle rispettive variabili quantita  (arrivate tramite POST) relative alle componenti selezionate 
                $messaggioQta = "";
                while ($row = mysql_fetch_array($sql)) {
                        
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
                    $QuantitaDaInserire = $_POST['Qta' . $NComp];
//Controllo degli input quantita e presa inseriti
                    if (!is_numeric($QuantitaDaInserire) OR !is_numeric($ordineDos) OR !is_numeric($tollEcc) OR !is_numeric($tollDif) OR !is_numeric($fluidificazione)) {
                        $NumErrore++;
                        $messaggioQta = $messaggioQta . " " . $row['descri_componente'] . " : " . $msgErrQtaNumerica . "<br/>";
                    }
                    

                    $NComp++;
                }// End while finiti i componenti 

                if ($NumErrore > 0) {
                    $messaggioQta = $messaggioQta . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                    echo $messaggioQta;
                } else { //vado avanti non ci sono errori
                    //##########################################################
                    //############## INIZIO TRANSAZIONE SALVATAGGIO DATI  ######
                    //##########################################################
                    begin();
                    //Variabile utile per valutare se bisogna aggiornare il dizionario
                    $nome_prodotto_old = "";
                    //Seleziono le informazioni del prodotto
                    $sqlProd = findProdottoById($IdProdotto);
                    while ($rowProd = mysql_fetch_array($sqlProd)) {

                        $id_prodotto_old = $rowProd['id_prodotto'];
                        $cod_prodotto_old = $rowProd['cod_prodotto'];
                        $nome_prodotto_old = $rowProd['nome_prodotto'];
                        $abilitato_old = $rowProd['abilitato'];
                        $dt_abilitato_old = $rowProd['dt_abilitato'];
                    }

                    $sqlAnProd = findAnagrafeProdottoById($IdProdotto);
                    while ($rowAnProd = mysql_fetch_array($sqlAnProd)) {

                        $id_prodotto_old = $rowAnProd['id_prodotto'];
                        $colorato_old = $rowAnProd['colorato'];
                        $lim_colore_old = $rowAnProd['lim_colore'];
                        $fattore_div_old = $rowAnProd['fattore_div'];
                        $fascia_old = $rowAnProd['fascia'];
                        $id_mazzetta_old = $rowAnProd['id_mazzetta'];
                        $id_codice_old = $rowAnProd['id_codice'];
                        $geografico_old = $rowAnProd['geografico'];
                        $tipo_riferimento_old = $rowAnProd['tipo_riferimento'];
                        $gruppo_old = $rowAnProd['gruppo'];
                        $livello_gruppo_old = $rowAnProd['livello_gruppo'];
                        $id_cat_old = $rowAnProd['id_cat'];
                        $abilitato_old = $rowAnProd['abilitato'];
                        $dt_abilitato_old = $rowAnProd['dt_abilitato'];
                    }

                    //Inserisco nello storico dei prodotti i vecchi valori 
                    $insertStoricoProd = insertProdottoInStorico($id_prodotto_old, $cod_prodotto_old, $nome_prodotto_old, $abilitato_old, $dt_abilitato_old);
                    $insertStoricoAnProd = insertStoricoAnagrafeProdotto($id_prodotto_old, $colorato_old, $lim_colore_old, $fattore_div_old, $fascia_old, $id_mazzetta_old, $id_codice_old, $geografico_old, $tipo_riferimento_old, $gruppo_old, $livello_gruppo_old, $id_cat_old, $abilitato_old, dataCorrenteInserimento());

                    //##########################################################
                    //##################### SALVO LE MODIFICHE #################
                    //##########################################################
                    //Modifico il record corrispondente all' id_prodotto selezionato nella tabella prodotto
                    $updateServerdbProd = modificaProdotto($IdProdotto, $CodiceProdotto, $NomeProdotto,$SerieColore,$SerieAdditivo,$ProdAbilitato,$IdAzienda);
                    //Modifico il record corrispondente all'id_prodotto selezionato nella tabella anagrafe_prodotto
                    $updateServerdbAnProd = modificaAnagrafeProd($IdProdotto, $IdProdottoPadre, $LimiteColore, $FattoreDivisore, $Fascia, $Mazzetta, $IdCodice, $Geografico, $TipoRiferimento, $Gruppo, $LivelloGruppo, $Categoria, $ProdAbilitato);


                    //#######################################################################
                    //##################### COMPONENTI ######################################
                    //#######################################################################
                    //Effettuo le modifiche sui componenti
                    $NComp = 1;
                    $sqlComp = selectCompPesaturaByIdProdotto($IdProdotto);
                    //$sqlComp = selectComponentiPesaturaByIdProdotto($IdProdotto);

                    $arrayCompProd = array();
                    $t = 0;
                    $metodoPesa="";
                    $stepDosaggio=1;
                    $ordineDosaggio="";
                    $QuantitaDaInserire = 0;
                    $ordineDos="";
                    $tollEccesso=0;
                    $tollDifetto=0;
                    $fluidificazione=0;
                    $valResiduoFluid=0;
                    
                    //Memorizzo nelle rispettive variabili quantita e prese (arrivate tramite form) relative alle componenti selezionate 
                    while ($row = mysql_fetch_array($sqlComp)) {

                        
                        $metodoPesa=$_POST['MetodoPesa' . $NComp];
                        
                        $QuantitaDaInserire = $_POST['Qta' . $NComp];
                        $ordineDos = $_POST['OrdineDos' . $NComp];
                        $tollEccesso =$_POST['TollEcc' . $NComp];
                        $tollDifetto=$_POST['TollDif' . $NComp];
                        
                        if($_POST['Fluidificazione' . $NComp]>0){
                                $fluidificazione=1;
                                $valResiduoFluid=$_POST['Fluidificazione' . $NComp];
                        }
                        $note="";
                        $stepDosaggio=1;
                        
                        $QuantitaDaInserire = $_POST['Qta' . $NComp];
                        $CompAbilitato = $_POST['CompAbilitato' . $NComp];
                        $SalvaQta = false;

                        if ($QuantitaDaInserire > 0 && $QuantitaDaInserire != "" && isset($QuantitaDaInserire) && $CompAbilitato != "") {
                            $SalvaQta = true;
                        }

                        if ($SalvaQta == true) {

                            $arrayCompProd[$t] = $row['id_comp'];
                            $t++;

                            //Salvo le quantita e le prese nella tabella componente_prodotto di storico	
                            //$insertStoricoCompPr = inserisciInStoricoCompProd($row['id_comp_prod'], $row['id_comp'], $IdProdotto, $row['quantita'], $row['abilitato'], $row['dt_abilitato']);

                            //Salvo la modifica nella tabella componente_prodotto
                            $updateServerdbCompProd = modificaComponenteProdotto($row['id_comp'], $IdProdotto, $QuantitaDaInserire, $CompAbilitato);
                           /** if (!$insertStoricoCompPr OR ! $updateServerdbCompProd) {
                                $erroreResult = true;
                            }*/
                             if (!$updateServerdbCompProd) {
                                $erroreResult = true;
                            }
                            
                            //Salvo la modifica nella tabella componente_prodotto
                            $updateServerdbCompPesatura= modificaComponentePesatura($row['id_comp'], $IdProdotto, $metodoPesa,$stepDosaggio,$ordineDos,$tollEccesso,$tollDifetto,
        $fluidificazione,$valResiduoFluid,$QuantitaDaInserire, $CompAbilitato);
                            if (! $updateServerdbCompPesatura) {
                                $erroreResult = true;
                            }
                        }
                        $NComp++;
                    }// End while finiti i componenti 
                    //#######################################################################
                    //##################### OPERAZIONI SUL DIZIONARIO #######################
                    //#######################################################################
                    if ($nome_prodotto_old != "" AND $nome_prodotto_old != $NomeProdotto) {

                        //Se il nome del prodotto modificato era gi?? stato caricato sul dizionario, 
                        //allora bisogna andare a modificarlo anke nel dizionario 
                        //il vocabolo deve essere modificato e coincide in tutte le lingue 
                        //finch?? non verr?? nuovamente tradotto
                        $updateServerdbDizionario = updateServerDBDizionario($IdProdotto, $NomeProdotto, 1);
                    }
                    //##################### FINE OPERAZIONI DIZIONARIO ######################
                    //#######################################################################
                    //##################### PARAMETRI PRODOTTO ##############################
                    //#######################################################################
                    //############ STORICIZZO I VALORI DEI PARAMETRI PRODOTTO ###############
                    $insertIntoStoricoValProdotto = insertStoricoValoreParProdotto($IdProdotto, $valAbilitato);

                    //############ MODIFICA SU SERVERDB #####################################
                    $sqlValProd = selectValoriProdottoByIdProd($IdProdotto, "v.id_par_prod");
                    while ($rowPar = mysql_fetch_array($sqlValProd)) {

                        $valorePar = $_POST['Valore' . $rowPar['id_val_pr']];

                        $updateValoreProdotto = updateValoriProdotto($rowPar['id_val_pr'], $valorePar);
                        if (!$updateValoreProdotto)
                            $erroreResult = true;
                    }

                    //#######################################################################
                    //##################### MACCHINE CHE VEDONO IL PRODOTTO #################
                    //#######################################################################
                    
                    //echo "<br/> GRUPPO DEL PRODOTTO : ".$Gruppo;
                    //echo "<br/> RIFERIMENTO GEOGRAFICO DEL PRODOTTO : ".$Geografico."<br/>";
                    
                    
                    //costruisco l'array con le macchine che vedono il prodotto
                    $arrayMac = array();
                    $arrayMac['id_macchina']=array();
                    $arrayMac['descri_stab']=array();
                    $y = 0;
                    //Seleziono le macchine che secondo il nuovo gruppo ed il nuovo rif geo vedono il prodotto
                    $selectMacchine = selectStabAbilitatiByGruppoGeo($Gruppo, $Geografico);
                    while ($rowMac = mysql_fetch_array($selectMacchine)) {
                        $arrayMac['id_macchina'][$y] = $rowMac['id_macchina'];
                        $arrayMac['descri_stab'][$y] = $rowMac['descri_stab'];

                        $y++;
                    }
                    if (mysql_num_rows($selectMacchine) > 0) {
                        //echo $msgProdVisibileAMac." <br />";
                        for ($j = 0; $j < count($arrayMac['id_macchina']); $j++) {
                            
                             $arrayMac['id_macchina'][$j] . " - " . $arrayMac['descri_stab'][$j]."<br />";
                        }
                    }
                   
                    //#######################################################################
                    //##################### PARAMETRI PRODOTTO MACCHINA #####################
                    //#######################################################################
                    //Se si modifica il gruppo o il riferimento geografico del prodotto bisogna eventualmente creare dei nuovi parametri in 
                    // valori par prod mac

                    if ($Gruppo != $GruppoOld OR $LivelloGruppo != $LivelloGruppoOld OR $TipoRiferimento != $TipoRiferimentoOld OR $Geografico != $GeograficoOld) {

                        //CASO 1 : Se ci sono nuove macchine che vedono il prodotto bisogna aggiungere i valori par nuovi
                        //CASO 2 : Se ci sono meno macchine che vedono il prodotto, i parametri non si possono eliminare perch?? ormai 
                        //le macchine (se hanno scaricato almeno un agg) li hanno tutti i parametri. Quindi non si pu?? fare nulla
                        //Seleziona dalla tabella valore_par_prod_mac le macchine che hanno gi?? i parametri del prodotto in questione
                        //Li salvo in un array
                        $macchineOld = array();
                        $i = 0;
                        $sqlMacchineOld = selectMacchineFromValParProdMac("id_macchina", "id_macchina", $IdProdotto);
                        while ($rowMacOld = mysql_fetch_array($sqlMacchineOld)) {
                            $macchineOld[$i] = $rowMacOld['id_macchina'];
                            $i++;
                        }

                        $sqlParPrMac = findAllParametriProdMac("id_par_pm");

                        $stab = "";
                        $arrayMacCreaParProd = array();
                        $a = 0;
                        //Seleziono le macchine che secondo il nuovo gruppo ed il nuovo rif geo vedono il prodotto
                        for ($j = 0; $j < count($arrayMac['id_macchina']); $j++) {

                            if (!in_array($arrayMac['id_macchina'][$j], $macchineOld)) {

                                //Se una macchina non ?? gi?? contenuta nell'array allora si generano i parametri nella tabella valore_par_prod_mac
                                if (mysql_num_rows($sqlParPrMac) > 0)
                                    mysql_data_seek($sqlParPrMac, 0);
                                //Per ogni parametro inserisce un valore nella tabella valore_par_prod_mac
                                while ($rowParMac = mysql_fetch_array($sqlParPrMac)) {

                                    $insertIntoValParProdMac = insertValoriProdottoMacchina($rowParMac['id_par_pm'], $IdProdotto, $arrayMac['id_macchina'][$j], $rowParMac['valore_base']);

                                    $stab = $arrayMac['id_macchina'][$j] . " " . $arrayMac['descri_stab'][$j];

                                    if (!in_array($stab, $arrayMacCreaParProd)) {
                                        $arrayMacCreaParProd[$a] = $stab;
                                        $a++;
                                    }

                                    if (!$insertIntoValParProdMac)
                                        $erroreResult = true;
                                    
                                }//End While parametri
                            }
                        }
                        if (count($arrayMacCreaParProd) > 0) {
                            echo $msgGeneratiValParProdMac . "<br />";

                            for ($h = 0; $h < count($arrayMacCreaParProd); $h++) {

                                echo $arrayMacCreaParProd[$h] . "<br />";
                            }
                        }
                    }


                    //##########################################################
                    //#### VERIFICA ED EVENTUALE INSERIMENTO VALORI PAR COMP ###
                    //##########################################################
                    //Vengono selezionate le macchine che vedono il prodotto
                    //Per ogni macchina, per ogni componente e per ogni parametro_comp_prod si inserisce nella tabella
                    //valore_par_comp solo se l'associazione id_comp-id_par_com-id_macchina non esiste
//                    print_r($arrayCompProd);
                    $SelectParametroCp = findAllParametriComp("id_par_comp");
                    for ($j = 0; $j < count($arrayMac['id_macchina']); $j++) {
                       // echo "<br /><br />MACCHINA :" . $arrayMac['id_macchina'][$j] . "<br />";

                        for ($i = 0; $i < count($arrayCompProd); $i++) {
                           // echo "<br />COMPONENTE :" . $arrayCompProd[$i] . " -- ";

                            if (mysql_num_rows($SelectParametroCp) > 0)
                                mysql_data_seek($SelectParametroCp, 0);
                           // echo "<br />PARAMETRO COMP : ";
                            while ($rowParC = mysql_fetch_array($SelectParametroCp)) {
                                //echo $rowParC['id_par_comp'] . " - ";

                                $InsertValoreParComp = insertIfNotExistValParComp($arrayCompProd[$i], $rowParC['id_par_comp'], $rowParC['valore_base'], $arrayMac['id_macchina'][$j], dataCorrenteInserimento());
                                if (!$InsertValoreParComp)
                                    $erroreValParCompResult = true;
                            }
                        }
                    }

                    if (count($arrayMac) > 0) {
                        echo "<br />" . $msgVerificaValParComp . "<br /><br />";
                     
                    }
                    //##########################################################

                    if ($erroreResult OR $erroreValParCompResult
                            OR ! $insertStoricoProd
                            OR ! $insertStoricoAnProd
                            OR ! $updateServerdbProd
                            OR ! $updateServerdbAnProd
                            OR ! $updateServerdbDizionario
                            OR ! $insertIntoStoricoValProdotto) {

                        rollback();
                        echo $msgTransazioneFallita . '<a href="gestione_anagrafe_prodotti.php">' . $msgOk . '</a><br/></br>';

                        echo "<br/>erroreResult : " . $erroreResult;
                        echo "<br/>insertStoricoProd : " . $insertStoricoProd;
                        echo "<br/>insertStoricoAnProd : " . $insertStoricoAnProd;
                        echo "<br/>updateServerdbProd : " . $updateServerdbProd;
                        echo "<br/>updateServerdbAnProd : " . $updateServerdbAnProd;
                        echo "<br/>insertStoricoCompPr : " . $insertStoricoCompPr;
                        echo "<br/>updateServerdbCompPro : " . $updateServerdbCompProd;
                        echo "<br/>updateServerdbDizionario : " . $updateServerdbDizionario;
                        echo "<br/>insertIntoStoricoValProdotto : " . $insertIntoStoricoValProdotto;
                        echo "<br/>IdProdottoPadre : " . $IdProdottoPadre;
                        echo "<br/>CodProdottoPadre : " . $CodProdottoPadre;
                        echo "<br/>Mazzetta : " . $Mazzetta;
                        echo "<br/>PostMazzetta : " . $PostMazzetta;
                        echo "<br/>erroreValParCompResult : " . $erroreValParCompResult;
                    } else {


                        echo $msgModificaCompletata . ' <a href="gestione_anagrafe_prodotti.php">' . $msgOk . '</a><br/>';
                        commit();
                        mysql_close();
                    }
                }//End if Numerrore
            }//End if ($errore) controllo degli input relativo al prodotto 
            ?>
        </div>
    </body>
</html>
