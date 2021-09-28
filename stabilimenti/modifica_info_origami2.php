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
            include('../sql/script_info_origami.php');
            include('../sql/script.php');

           if($DEBUG) ini_set("display_errors", "1");
//##############################################################################
//################### MODIFICA INFORMAZIONE  ###################################
//##############################################################################
            $Id = $_POST['Id'];

            $errore = false;
            $messaggio = $msgErroreVerificato . '<br/>';

            $IdMacchina = 0;
            if (isSet($_POST['Stabilimento'])) {
                $IdMacchina = $_POST['Stabilimento'];
            }
            
            $Info = "";
            if (isSet($_POST['Info'])) {
                $Info = str_replace("'", "''", $_POST['Info']);                
            }
            
            $Note = "";
            if (isSet($_POST['Note'])) {
                $Note = str_replace("'", "''", $_POST['Note']);
            }
            
            $Stato = "";
            if (isset($_POST['Stato']) || trim($_POST['Stato']) != "") {
                $Stato = str_replace("'", "''", $_POST['Stato']);
            }
            
            $PosizioneOld = "";
            if (isset($_POST['PosizioneOld']) || trim($_POST['PosizioneOld']) != "") {
                $PosizioneOld = str_replace("'", "''", $_POST['PosizioneOld']);
            }
            
            $DtChiusuraOld = "";
            if (isset($_POST['DtChiusuraOld']) || trim($_POST['DtChiusuraOld']) != "") {
                $DtChiusuraOld = str_replace("'", "''", $_POST['DtChiusuraOld']);
            }
            
            $Priorita = "";
            if (isset($_POST['Priorita']) || trim($_POST['Priorita']) != "") {
                $Priorita = str_replace("'", "''", $_POST['Priorita']);
            }
            
            $OperChiusura = "";
            if (isset($_POST['OperChiusura']) || trim($_POST['OperChiusura']) != "") {
                $OperChiusura = str_replace("'", "''", $_POST['OperChiusura']);
            }
            
            $Posiz = $_POST['scegliPos'];
            $Posizione = "";
            if ($Posiz == "PosizioneAp") {
                $Posizione = $valPosAperta;
            } else if ($Posiz == "PosizioneCh") {
                $Posizione = $valPosChiusa;
            }
            
            //### NON E' POSSIBILE RIAPRIRE UNA POSIZIONE GIA'CHIUSA ###########
            if ($PosizioneOld == $valPosChiusa AND $Posizione == $valPosAperta) {

                $errore = true;
                $messaggio = $messaggio . $msgErrPosizioneChiusa . "</br>";
            }


            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo '<div id="msgErr">' . $messaggio . '</div>';
            } else {

                $Tipo = $_POST['scegli_tipo'];
                $TipoInfo = "";
                if ($Tipo == "TipoEs") {
                    $TipoInfo = $_POST['TipoEs'];
                } else if ($Tipo == "TipoNu") {
                    $TipoInfo = $_POST['TipoNu'];
                }
                $SottoTipo = $_POST['scegli_sottotipo'];
                $SottoTipoInfo = "";
                if ($SottoTipo == "SottoTipoEs") {
                    $SottoTipoInfo = $_POST['SottoTipoEs'];
                } else if ($SottoTipo == "SottoTipoNu") {
                    $SottoTipoInfo = $_POST['SottoTipoNu'];
                }


                //######### DATA DI CHIUSURA ###################################
                //Se è stata appena chiusa la posizione allora si aggiorna la data di chiusura
                //Altrimenti la data di chiusura resta invariata
                $DtChiusura = $DtChiusuraOld;
                if ($PosizioneOld == $valPosAperta AND $Posizione == $valPosChiusa)
                    $DtChiusura = dataCorrenteInserimento();
                //##############################################################

                $DtAbilitato = dataCorrenteInserimento();

                $updateInfo = true;

                begin();

                $updateInfo = updateInfoOrigami($Id, $IdMacchina, $TipoInfo, $SottoTipoInfo, $Info, $Stato, $Note, $DtAbilitato, $_SESSION['username'], $Posizione, $DtChiusura, $Priorita, $OperChiusura);

                if (!$updateInfo) {

                    rollback();

                    echo '<div id="msgErr">' . $msgErroreVerificato . '' . $msgErrContattareAdmin . ' <a href="gestione_info_origami.php">' . $msgOk . '</a></div>';
                } else {

                    commit();

                    echo $msgModificaCompletata . ' <a href="gestione_info_origami.php">' . $msgOk . '</a>';
                }
            }//End if errore
            ?>
        </div>
    </body>
</html>
