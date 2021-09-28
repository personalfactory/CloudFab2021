<?php

/**
 * Calcola il nuovo codice di un prodotto (figlio) prendendo il massimo codice 
 * fra i codici prodotto ed i codici formula 
 */
function calcolaNuovoCodiceProdotto($codiceFamiglia, $iniziale) {
    include_once('../sql/script_prodotto.php');
    include_once('../sql/script_formula.php');

    $MaxNumCodice = 0;
    $MaxNumCodForm = 0;
    $MaxNumCodProd = 0;
    $PrefissoCodFormula = $iniziale . $codiceFamiglia;

    $sqlMaxCodice = selectMaxNumCodice($PrefissoCodFormula);
    while ($rowMaxCodice = mysql_fetch_array($sqlMaxCodice)) {

        $MaxNumCodForm = $rowMaxCodice['num_max'];
    }
    $sqlMaxNumCodProd = selectMaxNumCodProd($codiceFamiglia);
    while ($rowMaxCodPr = mysql_fetch_array($sqlMaxNumCodProd)) {

        $MaxNumCodProd = $rowMaxCodPr['num_max_cod_prod'];
    }

    //Recupero il numero più grande tra il massimo numero dei codici formula
    //ed il massimo numero dei codici prodotto
    if ($MaxNumCodForm > $MaxNumCodProd)
        $MaxNumCodice = $MaxNumCodForm;
    else if ($MaxNumCodProd > $MaxNumCodForm)
        $MaxNumCodice = $MaxNumCodProd;
    else if ($MaxNumCodForm == $MaxNumCodProd)
        $MaxNumCodice = $MaxNumCodForm;

    //Se la parte numerica del codice è <9 si incrementa di 1 
    //e si aggiunge prima uno zero 	
    if (intval($MaxNumCodice) < 9) {
        $NumCodice = intval($MaxNumCodice) + 1;
        $Codice = $codiceFamiglia . '0' . $NumCodice;
    }
    //Se la parte numerica del codice è >=9 si incrementa di 1
    if (intval($MaxNumCodice) >= 9) {
        $NumCodice = intval($MaxNumCodice) + 1;
        $Codice = $codiceFamiglia . $NumCodice;
    }

    return $Codice;
}

/**
 * Calcola la giacenza attuale di un articolo facendo la differenza fra 
 * tutti i carichi e gli scarichi a partire dall'inventario
 * @param type $Artico
 * @param type $catMer
 * @param type $valCarico
 * @param type $valScarico
 * @param type $valDataDefault
 * @param type $valCatMerLotti
 * @return type
 */
function calcolaGiacenzaArticolo($Artico, $catMer, $valCarico, $valScarico, $valDataDefault, $valCatMerLotti, $valCatMerMatPrime) {

    include_once('../sql/script_materia_prima.php');
    include_once('../sql/script_lotto_artico.php');
    include_once('../sql/script_gaz_movmag.php');

    $sqlInv = "";
    $GiacenzaAttuale = 0;
    $QtaInventario = 0;
    $DtInventario = $valDataDefault; //1970-01-02 00:00:00
    $TotCarico = 0;
    $TotScarico = 0;

    //######## TOTALE QTA E DATA ULTIMO INVENTARIO ################
    if ($catMer == $valCatMerLotti) {
        $sqlInv = findLottoArticoByCodice($Artico);
    } else if ($catMer == $valCatMerMatPrime) {
        $sqlInv = findMatPrimaByCodice($Artico);
    }

    while ($rowInv = mysql_fetch_array($sqlInv)) {
        $QtaInventario = $rowInv['inventario'];
        $DtInventario = $rowInv['dt_inventario'];
    }
//######## TOTALE QTA CARICATA ###############################
    $sqlCarico = calcolaQtaOperTot($Artico, $valCarico, $DtInventario);
    while ($rowCar = mysql_fetch_array($sqlCarico)) {
        $TotCarico = $rowCar['qta_tot'];
    }
//######## TOTALE QTA SCARICATA ##############################
    $sqlScarico = calcolaQtaOperTot($Artico, $valScarico, $DtInventario);
    while ($rowScar = mysql_fetch_array($sqlScarico)) {
        $TotScarico = $rowScar['qta_tot'];
    }
//######## GIACENZA ATTUALE ##################################
    return $GiacenzaAttuale = $QtaInventario + $TotCarico - $TotScarico;

//###########  Aggiorno la giacenza in lotto_artico #############
#$aggLotto = aggiornaGiacLotto($Artico, $GiacenzaAttuale);
}

function calcolaCostoLottoNew($CodiceLotto) {

    include_once('../sql/script.php');
    include_once('../sql/script_materia_prima.php');
    include_once('../sql/script_accessorio.php');
    include_once('../sql/script_accessorio_formula.php');
    include_once('../sql/script_formula.php');
    include_once('../sql/script_generazione_formula.php');

    $CodiceFormula = "K" . substr($CodiceLotto, 1);

    $NumKit = 0;
    $NumLotti = 0;
    $MinOper = 0;

    $CostoSacKit = 0;
    $CostoScatola = 0;
    $CostoOper = 0;
    $CostoEticLotto = 0;
    $CostoEticCh = 0;

    $CostoUnitarioKg = 0;
    $QuantitaMiscela = 0;
    $QuantitaPerKit = 0;
    $CostoKit = 0;
    $CostoKitTotale = 0;

    $CostoLotto = 0;
    $NumeroLotti = 0;
    $CostoTotAccessoriMiscela = 0;
    $CostoMiscelaMtCompoundTotale = 0;

    begin();
    $sqlFormula = findAnFormulaByCodice($CodiceFormula);
    $sqlAccessori = findAccessoriFormulaByCodFormula($CodiceFormula);
    $sqlMtPr = findMaterieFormulaByCodice($CodiceFormula, "descri_mat");
    commit();


    while ($rowFormula = mysql_fetch_array($sqlFormula)) {
//            $DataFormula = $rowFormula['dt_formula'];
//            $DescriFormula = $rowFormula['descri_formula'];
//            $NumSacchettiTot = $rowFormula['num_sac'];
//            $QtaSacchetto = $rowFormula['qta_sac'];
//            $Abilitato = $rowFormula['abilitato'];
//            $Data = $rowFormula['dt_abilitato'];
//            $IdAzienda = $rowFormula['id_azienda'];
//            $IdUtenteProp = $rowFormula['id_utente'];
        $NumeroLotti = $rowFormula['num_lotti'];
//            $QtaMiscelaInserita = $rowFormula['qta_tot_miscela'];
//            $PesoLotto = $rowFormula['qta_lotto'];
//            $NumeroKitSacchetti = $rowFormula['num_sac_in_lotto'];
    }



    while ($rowAccessori = mysql_fetch_array($sqlAccessori)) {

        $CostoTotAccessoriMiscela = $CostoTotAccessoriMiscela + $rowAccessori['quantita'] * $rowAccessori['pre_acq'];
    }

//############ COSTO KIT TOTALE DELLE MATERIE PRIME ####################
    while ($rowMatPrime = mysql_fetch_array($sqlMtPr)) {

        $CostoMiscelaMtCompoundTotale = $CostoMiscelaMtCompoundTotale + $rowMatPrime['quantita'] * ($rowMatPrime['pre_acq'] / 1000);
    }


//########### COSTO LOTTO ######################################################
    $CostoLotto = 0;
    if ($NumeroLotti > 0)
        $CostoLotto = ($CostoTotAccessoriMiscela + $CostoMiscelaMtCompoundTotale) / $NumeroLotti;

    return $CostoLotto;
}

/**
 * Calcola il costo di un lotto di chimica
 * @param type $CodiceFormula
 */
function calcolaCostoLotto($CodiceLotto) {

    include_once('../sql/script.php');
    include_once('../sql/script_materia_prima.php');
    include_once('../sql/script_accessorio.php');
    include_once('../sql/script_accessorio_formula.php');
    include_once('../sql/script_formula.php');
    include_once('../sql/script_generazione_formula.php');

    $CodiceFormula = "K" . substr($CodiceLotto, 1);

    $NumKit = 0;
    $NumLotti = 0;
    $MinOper = 0;

    $CostoSacKit = 0;
    $CostoScatola = 0;
    $CostoOper = 0;
    $CostoEticLotto = 0;
    $CostoEticCh = 0;

    $CostoUnitarioKg = 0;
    $QuantitaMiscela = 0;
    $QuantitaPerKit = 0;
    $CostoKit = 0;
    $CostoKitTotale = 0;

    $CostoLotto = 0;


    begin();

    //###########  QUANTITA' ACCESSORI ##################################

    $sqlFormula = findAnFormulaByCodice($CodiceFormula);
    while ($rowFormula = mysql_fetch_array($sqlFormula)) {
        $NumKit = $rowFormula["num_sac"];
    }

    $sqlNumLot = findAccessorioInFormulaByCodice($CodiceFormula, "scatLot");
    while ($rowNumLot = mysql_fetch_array($sqlNumLot)) {
        $NumLotti = $rowNumLot["quantita"];
    }

    $sqlMinutiOper = findAccessorioInFormulaByCodice($CodiceFormula, "OPER");
    while ($rowOper = mysql_fetch_array($sqlMinutiOper)) {
        $MinOper = $rowOper["quantita"];
    }

    //###########  COSTO ACCESSORI ##################################

    $sqlCostoSac = findAccessorioByCodice("sacCh");
    while ($rowCostoSac = mysql_fetch_array($sqlCostoSac)) {
        $CostoSacKit = $rowCostoSac["pre_acq"];
    }

    $sqlCostoScatola = findAccessorioByCodice("scatLot");
    while ($rowCostoScatola = mysql_fetch_array($sqlCostoScatola)) {
        $CostoScatola = $rowCostoScatola["pre_acq"];
    }

    $sqlCostoOper = findAccessorioByCodice("OPER");
    while ($rowCostoOper = mysql_fetch_array($sqlCostoOper)) {
        $CostoOper = $rowCostoOper["pre_acq"];
    }

    $sqlCostoEticLotto = findAccessorioByCodice("eticLot");
    while ($rowCostoEticLotto = mysql_fetch_array($sqlCostoEticLotto)) {
        $CostoEticLotto = $rowCostoEticLotto["pre_acq"];
    }

    $sqlCostoEticCh = findAccessorioByCodice("eticCh");
    while ($rowCostoEticCh = mysql_fetch_array($sqlCostoEticCh)) {
        $CostoEticCh = $rowCostoEticCh["pre_acq"];
    }

//############ COSTO KIT TOTALE DELLE MATERIE PRIME ####################

    $NMatPri = 1;
    $sqlMtPr = findMaterieFormulaByCodice($CodiceFormula, "descri_mat");
    while ($rowMatPrime = mysql_fetch_array($sqlMtPr)) {

        $sqlPrezzo = findMatPrimaByCodice($rowMatPrime['cod_mat']);
        while ($rowPrezzo = mysql_fetch_array($sqlPrezzo)) {

            $CostoUnitarioKg = $rowPrezzo['pre_acq'];
            $CostoUnitario = $CostoUnitarioKg / 1000;
            //NB:La qta per miscela è quella registrata in tabella 
            $QuantitaMiscela = $rowMatPrime['quantita'];

            $QuantitaPerKit = $QuantitaMiscela / ($NumKit * $NumLotti);
            $CostoKit = $QuantitaPerKit * $CostoUnitario;
            $CostoKitTotale = $CostoKitTotale + $CostoKit;
        }//End While Prezzo 

        $NMatPri++;
    }//End While Materie Prima


    commit();

//################ COSTO LOTTO #########################
    $CostoLotto = 0;
    if ($NumLotti > 0) {
        $CostoLotto = ($NumKit * $CostoKitTotale) +
                ($CostoSacKit * $NumKit) +
                ($CostoScatola) +
                (($CostoOper * $MinOper) / $NumLotti) +
                ($CostoEticLotto * $NumLotti) +
                ($CostoEticCh * $NumKit);
    }

    return $CostoLotto;
}

/* Trova il prezzo di vendita del lotto */

function prezzoLotto($cod_formula) {
    include_once('../sql/script_lotto_artico.php');

    $codLotto = "L" . substr($cod_formula, 1);

    //Prezzo di listino del lotto e costo del lotto
    $risultatoLot = findLottoArticoByCodice($codLotto);
    $rigoLot = mysql_fetch_assoc($risultatoLot);
    $ris = array($rigoLot["listino"], $rigoLot["costo"]);
    return $ris;
}

/**
 * Restituisce la data di ultima modifica di un prodotto
 * @param type $IdProdotto
 * @return type 
 */
function maxDataProdotto($IdProdotto) {

//Recupero la data effettiva di modifica del prodotto 
    $sqlMaxDt = mysql_query("SELECT MAX(componente_prodotto.dt_abilitato) AS dt_comp_prod,
                                            prodotto.dt_abilitato AS dt_prodotto,
                                            anagrafe_prodotto.dt_abilitato AS dt_an_prod
                                       FROM 
                                            serverdb.prodotto
                                       INNER JOIN serverdb.anagrafe_prodotto 
                                       ON 
                                            prodotto.id_prodotto = anagrafe_prodotto.id_prodotto
                                        INNER JOIN serverdb.componente_prodotto 
                                        ON 
                                            componente_prodotto.id_prodotto = prodotto.id_prodotto
                                        WHERE
                                             serverdb.prodotto.id_prodotto=" . $IdProdotto) or die("ERRORE SELECT FROM serverdb.prodotto : " . mysql_error());
    while ($rowMaxDt = mysql_fetch_array($sqlMaxDt)) {
        $DtProd = $rowMaxDt['dt_prodotto'];
        $DtAnProd = $rowMaxDt['dt_an_prod'];
        $DtCompProd = $rowMaxDt['dt_comp_prod'];
    }
//Calcolo la data maggiore tra le date della tabella prodotto,
//anagrafe_prodotto e componente_prodotto

    $Data = max($DtProd, $DtAnProd, $DtCompProd);

    return $Data;
}

function formRicerca($pagina) {
    ?>
    <div style="align:left">
        <form action="<?php echo $pagina; ?>" method="POST">
            <tr>
                <td><input type="text" name="key" value="" />
          <!--      <input type="image" src="/CloudFab/images/pittogrammi/lente-G.png" class="icone" alt="Cerca" class="submit" /></td>-->
                    <input type="submit" value="CERCA" class="submit" />
            </tr>
        </form>
    </div>
    </table>
    <table class="table3">
        <?php
    }

    /**
     * Funzione che inizializza la tabella lab_peso con i codici delle materie prime, 
     * questa tabella viene aggiornata con i pesi durante la procedura di pesa che si trova 
     * nella pagina carica_lab_peso.php * relativa alla prima prova di laboratorio effettuata su una formula
     * La variabile $_SESSION['lab_macchina'] identifica la macchina di laboratorio
     * @param type $CodiceFormula 
     */
    function azzeraInizializzaPesa($CodiceFormula, $CodiceBarre, $PercentualeSI) {

//Azzero la tabella [lab_peso] 
        deleteLabPeso();

        inizializzaLabPesoCodMat($CodiceBarre, $CodiceFormula);


        inizializzaLabPesoAcqua($CodiceBarre, $CodiceFormula, $PercentualeSI);
    }

    /**
     * Questa funzione si utilizza per azzerare ed inizializzare le tabelle del peso durante
     * una prova di laboratorio in cui vengono pesate le materie prime oggetto di variazione 
     * ovvero le prove di laboratorio successive alla prima.
     * @param type $IdEsperimento 
     */
    function azzeraInizializzaSecondaPesa($IdEsperimento, $CodiceBarre) {

//Azzero la tabella [lab_peso] 
        deleteLabPeso();

//Calcolo il totale reale di miscela effettuata nell'esperimento precedente 
        $QtaTotMiscela = 0;
        $QtaTotMiscela = calcolaQtaTotMiscela($IdEsperimento);

        inizializzaLabPesoMatPriKeVaria($QtaTotMiscela, $CodiceBarre, $IdEsperimento);

        inizializzaLabPesoAcquaSec($QtaTotMiscela, $CodiceBarre, $IdEsperimento, $PercentualeSI);
    }

    function getDaysInWeek($weekNumber, $year, $dayStart = 1) {
// Count from '0104' because January 4th is always in week 1
// (according to ISO 8601).
        $time = strtotime($year . '0104 +' . ($weekNumber - 1) . ' weeks');
// Get the time of the first day of the week
        $dayTime = strtotime('-' . (date('w', $time) - $dayStart) . ' days', $time);
// Get the times of days 0 -> 6
        $dayTimes = array();
        for ($i = 0; $i < 7; ++$i) {
            $dayTimes[] = strtotime('+' . $i . ' days', $dayTime);
        }
// Return timestamps for mon-sun.
        return $dayTimes;
    }

    /**
     * Carica un file sul server nella cartella $destDdtUploadDir
     * @param type $file
     * @param type $destDdtUploadDir
     * @param type $destNomeFileDdt
     * @param type $estFileDdt
     * @return boolean
     */
    function uploadFile($file, $destUploadDir, $destFileName, $estFile) {
        $upload = false;
        if ($file['error'] == UPLOAD_ERR_OK and is_uploaded_file($file['tmp_name'])) {
            move_uploaded_file($file['tmp_name'], $destUploadDir . $destFileName . $estFile);
            $upload = true;
        }

        return $upload;
    }

    function generaCodiceEsistenzaLabFormula($labMatpriTeoriaObj, $precCodEsistenza) {

        $ArrayMaterieQta = array();
        $CodiceEsistenza = "";

        $i = 0;
        for ($k = 0; $k < count($labMatpriTeoriaObj); $k++) {
            //Costruisco tante stringhe quante sono le materie prime della formula
            //Ciascuna stringa e' cosi' strutturata :    cod_mat . "=" . QtaPerc . ";"
            $ArrayMaterieQta[$i] = $labMatpriTeoriaObj[$k]->getCodMat() . "=" . number_format($labMatpriTeoriaObj[$k]->getQtaTeoPerc(), $precCodEsistenza, '.', '') . ";";
            $i++;
        }


        sort($ArrayMaterieQta);


        //Costruisco il codice esistenza della formula concatenando 
        //le stringhe ordinate in ordine alfabetico 
        for ($j = 0; $j < $i; $j++) {
            $CodiceEsistenza = $CodiceEsistenza . $ArrayMaterieQta[$j];
        }
        return $CodiceEsistenza;
    }

    /**
     * Funzione che trova i prodotti assegnati ad una macchina, facendo l'intersezione 
     * fra quelli assegnati in base al gruppo e quelli assegnati in base al riferimento geografico
     * @param type $idMacchina
     */
    function trovaProdottiAssegnatiAMacchina($idMacchina) {
        include_once('../sql/script_anagrafe_prodotto.php');

        $arrayProdottiGruppo = array();
        $arrayProdottiGeo = array();
        $arrayProdPerMac = array();

        //### SELEZIONE DEI PRODOTTI PER GRUPPO E RIFERIMENTO GEO ######
        //Bisogna selezionare tutti i prodotti che sono visibili sulla macchina
        //in base al gruppo e al riferimento geografico della macchina
        $SelectProdGruppo = findProdottiByGruppoPerMacchina($idMacchina);
        $SelectProdGeo = findProdottiByRifGeoPerMacchina($idMacchina);


        $i = 0;
        while ($row = mysql_fetch_array($SelectProdGruppo)) {
            $arrayProdottiGruppo[$i] = $row['id_prodotto'];
            $i++;
        }
        $j = 0;
        while ($rowGeo = mysql_fetch_array($SelectProdGeo)) {
            $arrayProdottiGeo[$j] = $rowGeo['id_prodotto'];
            $j++;
        }

        $arrayProdPerMac = array_intersect($arrayProdottiGruppo, $arrayProdottiGeo);
        sort($arrayProdPerMac);

//        echo "<br /><br />arrayProdottiGruppo: ";
//        print_r($arrayProdottiGruppo);
//
//        echo "<br /><br />arrayProdottiGeo ";
//        print_r($arrayProdottiGeo);
//
//        echo "<br /><br />arrayProdPerMac ";
//        print_r($arrayProdPerMac);
//        
        //INTERSEZIONE DEI PRODOTTI
        return $arrayProdPerMac;
    }
    
    
    /**
     * Funzione che trova i componenti assegnati ad una macchina, facendo l'intersezione 
     * fra quelli presenti nei prodotti assegnati in base al gruppo e quelli assegnati in base al riferimento geografico
     * @param type $dMacchina
     */
    function trovaComponentiAssegnatiAMacchina($idMacchina) {
        include_once('../sql/script_componente_prodotto.php');

        $arrayCompGruppo = array();
        $arrayCompGeo = array();
        $arrayCompPerMac = array();

        //### SELEZIONE DEI COMPONENTI DEI PRODOTTI PER GRUPPO E RIFERIMENTO GEO ######
        //Bisogna selezionare tutti i componenti dei prodotti che sono visibili sulla macchina
        //in base al gruppo e al riferimento geografico della macchina
        $SelectCompGruppo = findComponentiByGruppoPerMacchina($idMacchina);
        $SelectCompGeo = findComponentiByRifGeoPerMacchina($idMacchina);


        $i = 0;
        while ($row = mysql_fetch_array($SelectCompGruppo)) {
            $arrayCompGruppo[$i] = $row['id_comp'];
            $i++;
        }
        $j = 0;
        while ($row = mysql_fetch_array($SelectCompGeo)) {
            $arrayCompGeo[$j] = $row['id_comp'];
            $j++;
        }

        $arrayCompPerMac = array_intersect($arrayCompGruppo, $arrayCompGeo);
        sort($arrayCompPerMac);

//        echo "<br /><br />arrayCompGruppo: ";
//        print_r($arrayCompGruppo);
//
//        echo "<br /><br />arrayCompGeo ";
//        print_r($arrayCompGeo);
//
//        echo "<br /><br />arrayCompPerMac ";
//        print_r($arrayCompPerMac);
        
        //INTERSEZIONE DEI COMPONENTI
        return $arrayCompPerMac;
    }
    
    
    
    
    
     function array_remove_item($arr, $item) {
                // verifico che il valore sia compreso nell'array
                if (in_array($item, $arr)) {
                    // rimuovo il valore passando ad unset la chiave dell'item
                    // recuperata usando array_search
                    unset($arr[array_search($item, $arr)]);
                    // restituisco l'array dopo averla re-indicizzata
                    return array_values($arr);
                } else {
                    // se non trovo corrispondenze restituisco l'array così com'è
                    return $arr;
                }
            }
    ?>
