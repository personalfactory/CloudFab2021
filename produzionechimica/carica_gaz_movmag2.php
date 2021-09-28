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
        include('../include/gestione_date.php');
        include('../Connessioni/serverdb.php');
        include('../sql/script_gaz_movmag.php');
        include('../sql/script_materia_prima.php');
        include('../sql/script.php');
        include('../include/precisione.php');
        include('../include/funzioni.php');
        
            ini_set(display_errors, "1");
//##############################################################################
//################### NUOVA MATERIA PRIMA ######################################
//##############################################################################

            $errore = false;
            $messaggio = $msgErroreVerificato . '<br/>';

            list($Operazione, $Causale) = explode(";", $_POST['TipoMov']);

            switch ($Causale) {
                case $valCaricoPerAcq:
                    $TipoDoc = $valTipoDocDdtAcq;
                    $NumDoc = $_POST['NumDoc'];
                    $DesDoc = $valDesDocDdtAcq;
                    $DtDoc = $_POST['AnnoDoc'] . "-" . $_POST['MeseDoc'] . "-" . $_POST['GiornoDoc'];
                    $DtArrivoMerce = $_POST['AnnoArr'] . "-" . $_POST['MeseArr'] . "-" . $_POST['GiornoArr'];
                    break;
                case $valCaricoPerInv:
                    $TipoDoc = $valTipoDocInv;
                    $NumDoc = $valNumDocInv;
                    $DesDoc = $valDesDocInv;
                    $DtDoc = dataCorrenteInserimento();
                    $DtArrivoMerce =$valDefaultDtArrMerce;
                    break;
                case $valScaricoPerInv:
                    $TipoDoc = $valTipoDocInv;
                    $NumDoc = $valNumDocInv;
                    $DesDoc = $valDesDocInv;
                    $DtDoc = dataCorrenteInserimento();
                    $DtArrivoMerce =$valDefaultDtArrMerce;
                    break;
            }


            $Clfoco = $valClfocoPF;
            $NumOrdine = $valDefaultNumOrdine;
            $DtOrdine = $valDefaultDtOrdine;
            list($Artico, $DescriArtico) = explode(";", $_POST['Articolo']);
            $Quantita = $_POST['Quantita'];
            
            $Fornitore = '';
            if (isset($_POST['Fornitore']) AND trim($_POST['Fornitore']) != "") {
                $Fornitore = str_replace("'", "''", $_POST['Fornitore']);
            }
            $CodArticoForn = "";
            if (isset($_POST['CodiceArticoloFornitore']) AND trim($_POST['CodiceArticoloFornitore']) != "") {
                $CodArticoForn = str_replace("'", "''", $_POST['CodiceArticoloFornitore']);
            }
            $Merce = $_POST['Merce'];
            foreach ($Merce as $key => $value) {
//    echo "Hai selezionato la Merce: $key con valore: $value<br />"; 
                $MerceConforme = $value;
            }
            $Stabilita = $_POST['Stabilita'];
            foreach ($Stabilita as $key => $value) {
//    echo "Hai selezionato Stabilita: $key con valore: $value<br />"; 
                $StabilitaConforme = $value;
            }
            $Procedura = $_POST['Procedura'];
            foreach ($Procedura as $key => $value) {
//    echo "Hai selezionato Procedura: $key con valore: $value<br />"; 
                $ProceduraAdottata = $value;
            }
            $Operatore = $_POST['Operatore'];
            $RespProduzione = $_POST['RespProduzione'];
            $RespQualita = $_POST['RespQualita'];
            $ConsTecnico = $_POST['ConsTecnico'];
            $Note = "";
            if (isset($_POST['Note']) AND trim($_POST['Note']) != "") {
                $Note = str_replace("'", "''", $_POST['Note']);
            }
            $destNomeFileDdt = "";

            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo '<div id="msgErr">' . $messaggio . '</div>';
            } else {

                //########### UPLOAD DEL FILE ##################################
                if (isset($_FILES['user_file']) AND $_FILES['user_file'] != "") {
                    //GENERAZIONE DEL NOME DEL FILE DDT DA CARICARE SUL SERVER
                    $destNomeFileDdt = $preFileDdt . "_" . $NumDoc . "_" . $DtDoc;

                    $uploadEffettuato = uploadFile($_FILES['user_file'], $destDdtUploadDir, $destNomeFileDdt, $estFileDdt);
                    //Se il file non viene caricato in tabella si salva un valore vuoto
                    if ($uploadEffettuato)
                        echo $msgInfoDocCaricato;
                    else
                        $destNomeFileDdt = '';
                }

                //########### SALVATAGGIO MOVIMENTO ############################
                $insertMovMagazzino = true;
                //Valori di default
                $Prezzo = $valDefaultPrezzo;
                $DtMovimento =  dataCorrenteInserimento();
                begin();

                $insertMovMagazzino = inserisciMovimento($DtMovimento,$Operazione, $Causale, $TipoDoc, $NumDoc, $DesDoc, $DtDoc, $Clfoco, $Artico, $DescriArtico, $valCatMerMatPrime,$Quantita, $Prezzo, $Fornitore, $CodArticoForn, $valUniMisKg, $DtArrivoMerce, $MerceConforme, $StabilitaConforme, $ProceduraAdottata, $Operatore, $RespProduzione, $RespQualita, $ConsTecnico, $Note, $destNomeFileDdt, $NumOrdine, $DtOrdine);


                //######## GIACENZA ATTUALE ##################################
                 $GiacenzaAttuale = calcolaGiacenzaArticolo($Artico, $valCatMerMatPrime, $valCarico, $valScarico, $valDataDefault, $valCatMerLotti,$valCatMerMatPrime);
                
                //###########  Aggiorno la giacenza e il fornitore #############
                //########### nella tabella materia_prima ######################              
                $aggMatPrima = aggiornaGiacMatPrima($Artico, $Fornitore, $GiacenzaAttuale);

                if (!$insertMovMagazzino OR !$aggMatPrima) {

                    rollback();

                    echo '<div id="msgErr">' . $msgErroreVerificato . '' . $msgErrContattareAdmin . ' <a href="gestione_gaz_movmag.php">' . $msgOk . '</a></div>';
                } else {

                    commit();

                    echo "<br/>" . $msgInserimentoCompletato . ' <a href="gestione_gaz_movmag.php">' . $msgOk . '</a>';
                }
            }//End if errore
            ?>
        </div>
    </body>
</html>
