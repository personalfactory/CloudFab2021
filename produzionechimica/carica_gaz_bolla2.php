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
            include('../include/precisione.php');
            include('../include/funzioni.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_gaz_movmag.php');
            include('../sql/script_lotto_artico.php');
//            include('../sql/script_utente.php');
            include('../sql/script_persona.php');

            ini_set(display_errors, "1");
//            echo "ciao";
//##############################################################################
//################### NUOVA MATERIA PRIMA ######################################
//##############################################################################

            $errore = false;
            $messaggio = $msgErroreVerificato . '<br/>';

            $NumDoc = str_replace("'", "''", $_POST['NumDoc']);
            $DtDoc = $_POST['AnnoDoc'] . "-" . $_POST['MeseDoc'] . "-" . $_POST['GiornoDoc'];
            $NumOrdine = $valDefaultNumOrdine;
            $DtOrdine = $valDefaultDtOrdine;
            if (isset($_POST['NumOrdine']) AND $_POST['NumOrdine'] != "") {
                $NumOrdine = str_replace("'", "''", $_POST['NumOrdine']);
                $DtOrdine = $_POST['AnnoOrdine'] . "-" . $_POST['MeseOrdine'] . "-" . $_POST['GiornoOrdine'];
            }
            list($IdMacchina, $CodStab, $DescriStab) = explode(" - ", $_POST['Stabilimento']);
            $NumArticoli = str_replace("'", "''", $_POST['NumArticoli']);

            $Note = "";
            if (isset($_POST['Note']) AND trim($_POST['Note']) != "") {
                $Note = str_replace("'", "''", $_POST['Note']);
            }

            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo '<div id="msgErr">' . $messaggio . '</div>';
            } else {

                //########### UPLOAD DEL FILE ##################################
                $destNomeFileDdt = "";
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

                //########### SALVATAGGIO DDT ############################
                $insertDdt = true;
                $aggLotto = true;
                $erroreTransazione = false;


                $Artico = "";
                $DescriArticolo = "";
                $QtaArticolo = 0;
                $UniMis = $valUniMisPz;
                $DtMovimento=  dataCorrenteInserimento();
                $Operazione = $valScarico;
                $Causale = $valScaricoPerVen;
                $TipoDoc = $valTipoDocDdtVen;
                $DesDoc = $valDesDocDdtVen;
                $Clfoco = $CodStab;
                $Fornitore = $valFornitoreLotti;
                $DtArrivoMerce = $valDefaultDtArrMerce;
                $ProceduraAdottata = $valDesDocDdtVen; //??
                $Operatore = $_SESSION['nominativo_utente'];
                $RespProduzione = "";
                $RespQualita = "";
                $ConsTecnico = "";


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

                begin();
                for ($i = 1; $i <= $NumArticoli; $i++) {
                    //TODO : la gestione errori sugli articoli viene fatta nella pagine precedente
                    $Articolo = str_replace("'", "''", $_POST['Articolo' . $i]);
                    list($Artico, $DescriArticolo) = explode(";", $Articolo);
                     $QtaArticolo = str_replace("'", "''", $_POST['QtaArticolo' . $i]);

                    $CostoArticolo = 0;
                    $sqlCosto = findLottoArticoByCodice($Artico);
                    while ($rowCosto = mysql_fetch_array($sqlCosto)) {
                        $CostoArticolo = $rowCosto['costo'];
                    }
                    if ($QtaArticolo > 0) {

                        $insertDdt = inserisciMovimento($DtMovimento,$Operazione, $Causale, $TipoDoc, $NumDoc, $DesDoc, $DtDoc, $Clfoco, $Artico, $DescriArticolo, $valCatMerLotti, $QtaArticolo, $CostoArticolo, $Fornitore, $Artico, $UniMis, $DtArrivoMerce, $valConforme, $valStabile, $ProceduraAdottata, $Operatore, $RespProduzione, $RespQualita, $ConsTecnico, $Note, $destNomeFileDdt, $NumOrdine, $DtOrdine);

                        if (!$insertDdt)
                            $erroreTransazione = true;

                        //######## GIACENZA ATTUALE ##################################
                        $GiacenzaAttuale = calcolaGiacenzaArticolo($Artico, $valCatMerLotti, $valCarico, $valScarico, $valDataDefault, $valCatMerLotti, $valCatMerMatPrime);

//###########  Aggiorno la giacenza in lotto_artico #############
                        $aggLotto = aggiornaGiacLotto($Artico, $GiacenzaAttuale);

                        if (!$aggLotto)
                            $erroreTransazione = true;
                    }
                }

                if ($erroreTransazione) {

                    rollback();

                    echo '<div id="msgErr">' . $msgErroreVerificato . '' . $msgErrContattareAdmin . ' <a href="gestione_bolle.php">' . $msgOk . '</a></div>';
                } else {

                    commit();

                    echo "<br/>" . $msgInserimentoCompletato . ' <a href="gestione_bolle.php">' . $msgOk . '</a>';
                }
            }//End if errore
            ?>
        </div>
    </body>
</html>
