<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id = "tracciabilitaContainer">
            <?php
            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../include/funzioni.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_gaz_movmag.php');
            include('../sql/script_lotto_artico.php');
            include('../sql/script_lotto.php');
            include('../sql/script_chimica.php');
            include('../sql/script_sacchetto_chimica.php');
            include('../sql/script_produzione_miscela.php');
            include('../sql/script_miscela_contenitore.php');           
            include('../sql/script_persona.php');

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
            $CodChimicaSfusa = $_SESSION['CodiceChimica'];
            $DataAttuale = dataCorrenteInserimento();

            $resultInsertLottoServerdb = true;
            $resultInsertChimicaServerdb = true;
            $resultInsertSacChimicaServerdb = true;
            $resultInsertGazMovMag = true;
            $resultAggLotto = true;

//Inizio transazione
            begin();

            //######################################################################
            //########### SALVATAGGIO SU SERVERDB ##################################
            //######################################################################
            //Salvo il codice lotto nella tabella lotto
            $resultInsertLottoServerdb = inserisciNuovoLotto($CodLotto, $DescriLotto, $DataAttuale,$valStatoLottoDisponibile);

//Salvo il codice chimica nella tabella chimica
            $resultInsertChimicaServerdb = inserisciNuovoKit($CodChimicaSfusa, $DescriFormula, $DataAttuale, $CodProdotto, $CodLotto);
//           
//Salvo l'associazioe codici chimica - miscela nella tabella sacchetto_chimica
            $resultInsertSacChimicaServerdb = inserisciSacchettoChimica($CodChimicaSfusa, $IdMiscela);
//                  
//##############################################################################
//########### SALVATAGGIO SU GAZ_MOVMAG ########################################
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
            //########## INCREMENTO IL NUMERO DI LOTTI SALVATI #########################
            //##########################################################################

            $_SESSION['NumLottiSalvati'] = $_SESSION['NumLottiSalvati'] + 1;

            //##########################################################################
            //######### AZZERO LE VARIABILI DI SESSIONE PER IL LOTTO SUCCESSIVO ########
            //##########################################################################
            if ($_SESSION['NumLottiSalvati'] < $_SESSION['NumLottiTot']) {

                $_SESSION['NumLottiDaSalvare'] = $_SESSION['NumLottiTot'] - $_SESSION['NumLottiSalvati'];

                //Azzero la variabile codice chimica per il nuovo lotto forse non serve?
                $_SESSION['CodiceChimica'] = "";

                if (!$resultInsertLottoServerdb OR !$resultInsertChimicaServerdb OR !$resultInsertSacChimicaServerdb OR !$resultInsertGazMovMag OR !$resultAggLotto) {

                    rollback();
                    echo $msgErroreVerificato . " " . $msgErrContactAdmin;
                    echo "</br>resultInsertLottoServerdb : " . $resultInsertLottoServerdb;
                    echo "</br>resultInsertChimicaServerdb : " . $resultInsertChimicaServerdb;
                    echo "</br>resultInsertSacChimicaServerdb : " . $resultInsertSacChimicaServerdb;
                    echo "</br>resultInsertGazMovMag : " . $resultInsertGazMovMag;
                   
                } else {

                    commit();
                    ?>
                    <script type="text/javascript">
                        location.href = "tracciabilita_sfusa_carica_lotto.php?Contenitore=<?php echo $Contenitore; ?>"
                    </script>
                    <?php
                }

                //########################################################################
                //################### FINE LOTTI - SVUOTA CONTENITORE ####################
                //########################################################################
            } else if ($_SESSION['NumLottiSalvati'] == $_SESSION['NumLottiTot']) {

                //Svuota produzione_miscela
                $resultDeleteProdMiscela = deleteProdMiscelaById($IdMiscela);
                
                //Sblocca contenitore
                $resultSbloccaContenitore = updateContenitore("1", $Contenitore);


                if (!$resultInsertLottoServerdb OR !$resultInsertChimicaServerdb OR !$resultInsertSacChimicaServerdb OR !$resultInsertGazMovMag OR !$resultDeleteProdMiscela OR !$resultSbloccaContenitore) {

                    rollback();
                    echo $msgErroreVerificato . " " . $msgErrContactAdmin;
                    echo "</br>resultInsertLottoServerdb : " . $resultInsertLottoServerdb;
                    echo "</br>resultInsertChimicaServerdb : " . $resultInsertChimicaServerdb;
                    echo "</br>resultInsertSacChimicaServerdb : " . $resultInsertSacChimicaServerdb;
                    echo "</br>resultInsertGazMovMag : " . $resultInsertGazMovMag;
                    echo "</br>resultDeleteProdMiscela : " . $resultDeleteProdMiscela;
                    echo "</br>resultSbloccaContenitore : " . $resultSbloccaContenitore;
                } else {

                    commit();
                    mysql_close();
                    echo $msgInfoTransazioneRiuscita . "</br>";
                }
                ?>
                <a href="/CloudFab/produzionechimica/gestione_chimica.php"><?php echo $filtroVediLotti ?></a>		 



<?php } ?>
        </div>
    </body>
</html>
