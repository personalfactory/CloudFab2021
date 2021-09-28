<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
            <div id="tracciabilitaContainer" style=" width:900px; margin:50px auto;">
            <?php
            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../include/precisione.php');
            include('../include/funzioni.php');
            include('../sql/script.php');
            include('../sql/script_gaz_movmag.php');
            include('../sql/script_lotto_artico.php');
            include('../sql/script_persona.php');
            include('../sql/script_chimica.php');
            include('../sql/script_lotto.php');
            include('../sql/script_sacchetto_chimica.php');
            include('../sql/script_produzione_miscela.php');
            include('../sql/script_miscela_contenitore.php');


            $erroreResult = false;
            $resultUpdateLottoServerdb = true;        
            $InsertGazieMovMag = true;         
            $resultAggLotto = true;

//##############################################################################     
//################ VARIABILI DI SESSIONE #######################################
//##############################################################################


            $CodLotto = $_SESSION['CodiciLotto'][$_SESSION['NumLottiSalvati']];
            $PrefissoCodLotto = substr($CodLotto, 0, 6);
            $DataAttuale = dataCorrenteInserimento();

//######################################################################
//########### SALVATAGGIO SU SERVERDB ##################################
//######################################################################

            begin();
//TO DO aggiorna lotto come usato scaricato
            //Lotto usato=0 ; lotto disponibile=1
            //Viene aggiornata anche il cmapo dt_bolla con la data attuale
            $resultUpdateLottoServerdb = updateStatoLotto($CodLotto,$valStatoLottoVenduto);

      

//##############################################################################
//########### SALVATAGGIO SU GAZIE #############################################
//##############################################################################
//TODO : Inserire il movimento nella nuova tabella gaz_movmag di serverdb
//Inserisco su gazie il movimento di magazzino relativo al lotto di chimica caricato
//CONTROLLARE TUTTI I PARAMETRI
            $DtMovimento = $DataAttuale;
            $Operazione = $valScarico;
            $Causale = $_SESSION['Causale'];
            $TipoDoc = $_SESSION['TipDoc'];
            $NumDoc = $_SESSION['NumDoc'];
            $DesDoc = $_SESSION['DesDoc'];
            $DtDoc = $_SESSION['DtDoc'];
            $Clfoco = $_SESSION['Cliente'];;
            $Artico = $PrefissoCodLotto;
            $DescriArtico = $_SESSION['DescriLotto'] ;
            $catMer=$valCatMerLotti;
            $Quantita = 1; //??
            $Prezzo = 0; 
            $Fornitore = $valFornitoreLotti;
            $CodArticoForn = $CodLotto;
            $valUniMisKg = $valUniMisPz;
            $DtArrivoMerce = $DataAttuale;
            $MerceConforme = $valConforme;
            $StabilitaConforme = $valStabile;
            $ProceduraAdottata = $_SESSION['ProcAdottata']; 
            $Operatore = $_SESSION['nominativo_utente']; 
            $RespProduzione = ""; //?
            $RespQualita = ""; //?
            $ConsTecnico = ""; //?
            $Note = $_SESSION['Note']; 
            $destNomeFileDdt = ""; //
            $NumOrdine = $_SESSION['NumOrdine'];
            $DtOrdine = $_SESSION['DtOrdine'];

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


           $InsertGazieMovMag = inserisciMovimento($DtMovimento, $Operazione, $Causale, $TipoDoc, $NumDoc, $DesDoc, $DtDoc, $Clfoco, $Artico, $DescriArtico, $catMer, $Quantita, $Prezzo, $Fornitore, $CodArticoForn, $valUniMisKg, $DtArrivoMerce, $MerceConforme, $StabilitaConforme, $ProceduraAdottata, $Operatore, $RespProduzione, $RespQualita, $ConsTecnico, $Note, $destNomeFileDdt, $NumOrdine, $DtOrdine);
           //TO DO: valutare se inserire un solo movimento per ogni tipo di prodotto sommando il numero di lotti totale.
           

//##########################################################################
//##########  AGGIORNO GIACENZA IN LOTTO ARTICO ############################
//##########################################################################
//######## GIACENZA ATTUALE ################################################
            $GiacenzaAttuale = calcolaGiacenzaArticolo($Artico, $valCatMerLotti, $valCarico, $valScarico, $valDataDefault, $valCatMerLotti, $valCatMerMatPrime);

//###########  Aggiorno la giacenza in lotto_artico ########################

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
               

                if ( !$resultUpdateLottoServerdb OR !$InsertGazieMovMag OR !$resultAggLotto) {
                    
                    rollback();
                    echo $msgErroreVerificato . " " . $msgErrContactAdmin;
                    echo "</br>resultInsertLottoServerdb : " . $resultUpdateLottoServerdb;
                    echo "</br>InsertGazieMovMag : " . $InsertGazieMovMag;
                    echo "</br>resultAggLotto : " . $resultAggLotto;
                } else {
                    
                    commit();
                    ?>
                    <script type="text/javascript">
                        location.href = "carica_mov_lotto1.php"
                    </script>
                    <?php
                }

                //########################################################################
                //################### FINE LOTTI - SVUOTA CONTENITORE ####################
                //########################################################################
            } else if ($_SESSION['NumLottiSalvati'] == $_SESSION['NumLottiTot']) {


                if (!$resultUpdateLottoServerdb OR !$InsertGazieMovMag OR !$resultAggLotto) {
                    
                    rollback();
                    echo $msgErroreVerificato . " " . $msgErrContactAdmin;
                    echo "</br>resultInsertLottoServerdb : " . $resultUpdateLottoServerdb;
                    echo "</br>insertGazieMovMag : " . $InsertGazieMovMag;
                    echo "</br>resultAggLotto : " . $resultAggLotto;
                } else {

                    commit();
                    echo $msgLottiScaricati ;
                }
                ?>
                &nbsp;
                <a href="/CloudFab/produzionechimica/gestione_chimica.php"><?php echo $msgOk ?></a>		  
                </div>
            
       
<?php } ?>
        </div>
    </body>
</html>
