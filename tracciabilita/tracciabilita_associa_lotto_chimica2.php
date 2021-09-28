<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="tracciabilitaContainer">
            <?php
            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../include/precisione.php');
            include('../include/funzioni.php');
            include('../sql/script_gaz_movmag.php');
            include('../sql/script_lotto_artico.php');
            include('../sql/script_persona.php');
            include('../sql/script_chimica.php');
            include('../sql/script_lotto.php');
            include('../sql/script_sacchetto_chimica.php');
            include('../sql/script_produzione_miscela.php');
            include('../sql/script_miscela_contenitore.php');


            $erroreResult = false;
            $resultInsertLottoServerdb = true;
            $resultInsertLottoLocaldb = true;
            $InsertGazieMovMag = true;
            $resultDeleteFromProdMiscela = true;
            $resultSbloccaContenitore = true;
            $resultInsertChimicaServerdb = true;
            $resultInsertSacChimicaServerdb = true;
            $resultInsertChimicaLocaldb = true;
            $resultAggLotto = true;

//##############################################################################     
//################ VARIABILI DI SESSIONE #######################################
//##############################################################################

            $Contenitore = $_SESSION['Contenitore'];
            $DataMiscela = $_SESSION['DataMiscela'];
            $IdMiscela = $_SESSION['IdMiscela'];
            $CodFormula = $_SESSION['CodFormula'];
            $DescriFormula = $_SESSION['DescriFormula'];
            $CodFormulaDescri = $_SESSION['CodFormulaDescri'];
            $CodProdotto = substr($CodFormula, 1, 5);
            $DescriLotto = "LOTTO " . $DescriFormula;
            $CodLotto = $_SESSION['CodiciLotto'][$_SESSION['NumLottiSalvati']];
            $PrefissoCodLotto = substr($CodLotto, 0, 6);
            $DataAttuale = dataCorrenteInserimento();

//######################################################################
//########### SALVATAGGIO SU SERVERDB ##################################
//######################################################################

            mysql_query("BEGIN");

//Salvo il codice lotto nella tabella lotto
            $resultInsertLottoServerdb = inserisciNuovoLotto($CodLotto, $DescriLotto, $DataAttuale,$valStatoLottoDisponibile);


            for ($i = 0; $i < $_SESSION['NumCodiciChimicaTot']; $i++) {

                $CodiceChimica = $_SESSION['CodiciChimica'][$i];

                //Salvo i codici chimica nella tabella chimica
                $resultInsertChimicaServerdb = inserisciNuovoKit($CodiceChimica, $DescriFormula, $DataAttuale, $CodProdotto, $CodLotto);
          
                //Salvo l'associazione codici chimica - miscela nella tabella sacchetto_chimica
                $resultInsertSacChimicaServerdb = inserisciSacchettoChimica($CodiceChimica, $IdMiscela);


                if (!$resultInsertChimicaServerdb OR !$resultInsertSacChimicaServerdb) {
                    $erroreResult = true;
                }
            }



//##############################################################################
//########### SALVATAGGIO SU GAZIE #############################################
//##############################################################################
//TODO : Inserire il movimento nella nuova tabella gaz_movmag di serverdb
//Inserisco su gazie il movimento di magazzino relativo al lotto di chimica caricato
//CONTROLLARE TUTTI I PARAMETRI
            $DtMovimento = $DataAttuale;
            $Operazione = $valCarico;
            $Causale = $valCaricoPerLav;
            $TipoDoc = $valTipoDocProdIn;
            $NumDoc = $valNumDocProIn;
            $DesDoc = $valDesDocProdIn;
            $DtDoc = $DataAttuale;
            $Clfoco = $valClfocoPF;
            $Artico = $PrefissoCodLotto;
            $DescriArtico = $DescriLotto;
            $Quantita = 1; //??
            $Prezzo = 0; //??
            $Fornitore = $valFornitoreLotti;
            $CodArticoForn = $PrefissoCodLotto;
            $valUniMisKg = $valUniMisPz;
            $DtArrivoMerce = $DataAttuale;
            $MerceConforme = $valConforme;
            $StabilitaConforme = $valStabile;
            $ProceduraAdottata = $valDesDocProdIn; //??
            $Operatore = $_SESSION['nominativo_utente']; ///?
            $RespProduzione = ""; //?
            $RespQualita = ""; //?
            $ConsTecnico = ""; //?
            $Note = ""; //?
            $destNomeFileDdt = ""; //?
            $NumOrdine = $valDefaultNumOrdine;
            $DtOrdine = $valDefaultDtOrdine;

//Recupero il costo del lotto dalla tabella lotto_artico
            $sqlCosto = findLottoArticoByCodice($Artico);
            while ($rowCosto = mysql_fetch_array($sqlCosto)) {
                $Prezzo = $rowCosto['costo'];
            }
//Recupero il nominativo del resp di produzione
            $sqlRespProd = selectPersoneByTipo($valRespProd, "nominativo");
            while ($rowRespProd = mysql_fetch_array($sqlRespProd)) {
                $RespProduzione = $rowRespProd['nominativo'];
            }
//Recupero il nominativo del resp di qualita
            $sqlRespQua = selectPersoneByTipo($valRespQualita, "nominativo");
            while ($rowRespQu = mysql_fetch_array($sqlRespQua)) {
                $RespQualita = $rowRespQu['nominativo'];
            }
//Recupero il nominativo del consulente tecnico
            $sqlCons = selectPersoneByTipo($valConsTecnico, "nominativo");
            while ($rowCons = mysql_fetch_array($sqlCons)) {
                $ConsTecnico = $rowCons['nominativo'];
            }


            $InsertGazieMovMag = inserisciMovimento($DtMovimento, $Operazione, $Causale, $TipoDoc, $NumDoc, $DesDoc, $DtDoc, $Clfoco, $Artico, $DescriArtico, $valCatMerLotti, $Quantita, $Prezzo, $Fornitore, $CodArticoForn, $valUniMisKg, $DtArrivoMerce, $MerceConforme, $StabilitaConforme, $ProceduraAdottata, $Operatore, $RespProduzione, $RespQualita, $ConsTecnico, $Note, $destNomeFileDdt, $NumOrdine, $DtOrdine);


//##########################################################################
//##########  AGGIORNO GIACENZA IN LOTTO ARTICO ############################
//##########################################################################
//######## GIACENZA ATTUALE ##################################
            $GiacenzaAttuale = calcolaGiacenzaArticolo($Artico, $valCatMerLotti, $valCarico, $valScarico, $valDataDefault, $valCatMerLotti, $valCatMerMatPrime);

//###########  Aggiorno la giacenza in lotto_artico #############

            $resultAggLotto = aggiornaGiacLotto($Artico, $GiacenzaAttuale);


//##########################################################################
//##########INCREMENTO IL NUMERO DI LOTTI SALVATI ##########################
//##########################################################################

            $_SESSION['NumLottiSalvati'] = $_SESSION['NumLottiSalvati'] + 1;

//##########################################################################
//######### AZZERO LE VARIABILI DI SESSIONE PER IL LOTTO SUCCESSIVO ########
//##########################################################################

            if ($_SESSION['NumLottiSalvati'] < $_SESSION['NumLottiTot']) {

                $_SESSION['NumLottiDaSalvare'] = $_SESSION['NumLottiTot'] - $_SESSION['NumLottiSalvati'];

                $_SESSION['NumCodiciChimicaInseriti'] = 0;
                $_SESSION['CodiciChimica'] = array();

                for ($j = 0; $j < $_SESSION['NumCodiciChimicaTot']; $j++) {
                    $_SESSION['CodiciChimica'][$j] = "";
                }

                if ($erroreResult OR !$resultInsertLottoServerdb OR !$InsertGazieMovMag OR !$resultAggLotto) {
                    
                    mysql_query("ROLLBACK");
                    echo $msgErroreVerificato . " " . $msgErrContactAdmin;
                    echo "</br>erroreResult : " . $erroreResult;
                    echo "</br>resultInsertLottoServerdb : " . $resultInsertLottoServerdb;
                    echo "</br>InsertGazieMovMag : " . $InsertGazieMovMag;
                    echo "</br>resultAggLotto : " . $resultAggLotto;
                } else {
                    
                    mysql_query("COMMIT");
                    ?>
                    <script type="text/javascript">
                        location.href = "tracciabilita_associa_lotto_chimica.php?Contenitore=<?php echo $Contenitore; ?>"
                    </script>
                    <?php
                }

                //########################################################################
                //################### FINE LOTTI - SVUOTA CONTENITORE ####################
                //########################################################################
            } else if ($_SESSION['NumLottiSalvati'] == $_SESSION['NumLottiTot']) {

                //Svuota produzione_miscela
                $resultDeleteFromProdMiscela = deleteProdMiscelaById($IdMiscela);

                //Sblocca contenitore
                $resultSbloccaContenitore = updateContenitore("1", $Contenitore);


                if ($erroreResult OR !$resultInsertLottoServerdb OR !$InsertGazieMovMag OR !$resultDeleteFromProdMiscela OR !$resultSbloccaContenitore) {
                    
                    mysql_query("ROLLBACK");
                    echo $msgErroreVerificato . " " . $msgErrContactAdmin;
                    echo "</br>erroreResult : " . $erroreResult;
                    echo "</br>resultInsertLottoServerdb : " . $resultInsertLottoServerdb;
                    echo "</br>InsertGazieMovMag : " . $InsertGazieMovMag;
                    echo "</br>resultDeleteFromProdMiscela : " . $resultDeleteFromProdMiscela;
                    echo "</br>resultSbloccaContenitore : " . $resultSbloccaContenitore;
                } else {

                    mysql_query("COMMIT");
                    echo $msgInfoTransazioneRiuscita . "</br>";
                }
                ?>
                <a href="/CloudFab/produzionechimica/gestione_chimica.php"><?php echo $filtroVediLotti ?></a>		  


        <!--<script type="text/javascript">
          location.href="/CloudFab/gestione_lotti.php"
        </script>-->



<?php } ?>
        </div>
    </body>
</html>
