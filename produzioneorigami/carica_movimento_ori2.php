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

            $Componente = str_replace("'", "''", $_POST['IdComponente']);

            list($IdComponente, $NomeComp) = explode(';', $Componente);

            if (isSet($_POST['TipoMat']))
                $tipoMat = $_POST['TipoMat'];
            $proceduraAdottata = "";
            if (isSet($_POST['Procedura']))
                $proceduraAdottata = $_POST['Procedura'];
            if (isSet($_POST['Silo']))
                $silo = $_POST['Silo'];
            if (isSet($_POST['TipoConf']))
                $TipoConf = $_POST['TipoConf'];
            $PesoConf = 0;
            if (isSet($_POST['PesoConf']) AND $_POST['PesoConf'] > 0)
                $PesoConf = $_POST['PesoConf'];
            $NumeroConf = 0;
            if (isSet($_POST['NumConf']) AND $_POST['NumConf'] > 0)
                $NumeroConf = $_POST['NumConf'];

            $Quantita = str_replace("'", "''", $_POST['Quantita']);

            $Fornitore = str_replace("'", "''", $_POST['Fornitore']);


            $CodiceIntegrazione = "";
            if (isSet($_POST['CodiceIntegrazione']) AND $_POST['CodiceIntegrazione'] != "")
                $CodiceIntegrazione = str_replace("'", "''", $_POST['CodiceIntegrazione']);

            list($IdMacchina, $DescriStab) = explode(';', $_POST['Stabilimento']);

            list($Operazione, $DescriMov, $TipoMov) = explode(";", $_POST['InfoMov']);

            $CodOperatore = str_replace("'", "''", $_POST['Operatore']);

            $NumDoc = "";
            $DtDoc = $valDataDefault;
            if (isSet($_POST['NumDoc']) AND $_POST['NumDoc'] != "") {
                $NumDoc = str_replace("'", "''", $_POST['NumDoc']);
                $DtDoc = $_POST['AnnoDoc'] . "-" . $_POST['MeseDoc'] . "-" . $_POST['GiornoDoc'];
            }




            $DtArrivoMerce = $valDataDefault;
            if ($_POST['GiornoArrivoMerce'] != "" AND $_POST['AnnoArrivoMerce'] != "") {
                $DtArrivoMerce = $_POST['AnnoArrivoMerce'] . "-" . $_POST['MeseArrivoMerce'] . "-" . $_POST['GiornoArrivoMerce'];
            }



//################ VALORI CHECKBOX ########################################

            $MarchioCeConforme = $_POST['MarchioCe'];

            $MerceConforme = $_POST['Merce'];

            $StabilitaConforme = $_POST['Stabilita'];

            $origineMov = $_POST['origineMov'];

//#########################################################################
            $Note = str_replace("'", "''", $_POST['Note']);
            $CodiceCE = str_replace("'", "''", $_POST['CodiceCE']);
            $RespProduzione = str_replace("'", "''", $_POST['RespProduzione']);
            $RespQualita = str_replace("'", "''", $_POST['RespQualita']);
            $ConsTecnico = str_replace("'", "''", $_POST['ConsTecnico']);
            $CodiceIntegrazione = str_replace("'", "''", $_POST['CodiceIntegrazione']);

            $DataMov = dataCorrenteInserimento();

//Gestione degli errori
//Inizializzazione dell'errore e del messaggio di errore
            $errore = false;
            $messaggio = '';

//Verifica esistenza
//Apro la connessione al db
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_movimento_sing_mac.php');
            include('../sql/script_allegato_mov_ori.php');

//            $DataMov = eliminaTrattini($DataMov);

            $DataMov = timestampToString($DataMov);

            //CODICE DEL MOVIMENTO: d della macchina.Id del componente . timestamp
            //$CodiceIngressoComp = $IdMacchina . "." . $IdComponente . "." . $DataMov;
            //Seleziono l'ultimo id nella tabella movimento_sing_mac

            $lastIdMov = 0;
            $sqlLastIdMov = findLastIdMovIn();
            while ($row = mysql_fetch_array($sqlLastIdMov)) {
                $lastIdMov = $row['last_id'];
            }

            $idMov = $lastIdMov + 1;

            $CodiceIngressoComp = $IdMacchina . "." . $IdComponente . "." . $idMov;


            //Verifica esistenza relativa al codice  
            $result = findMovimentoByCodice($CodiceIngressoComp);

            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che esiste
                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrCodiceEsiste . ' <br />';
            }

            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            //Controllo sulla variabile errore
            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {




                $insertControlloComp = true;
                $insertControlloComp = insertNewMovimentoSingMac($valIdMovOri, $IdComponente, $tipoMat, $Quantita, $CodiceIngressoComp, $CodOperatore, $Operazione, $proceduraAdottata, $TipoMov, $DescriMov, $DataMov, $silo, $TipoConf, $PesoConf, $NumeroConf, $RespProduzione, $RespQualita, $ConsTecnico, $Note, $MerceConforme, $StabilitaConforme, $MarchioCeConforme, $CodiceCE, $Fornitore, $DataMov, $IdMacchina, $Quantita, $valIdCicloDefault, $DataMov, $DataMov, $valAbilitato, $origineMov, $NumDoc, $DtDoc, $CodiceIntegrazione, $DtArrivoMerce);



                //########### UPLOAD DEL FILE ##################################
                $uploadEffettuato = false;
                $inserisciAllegato = true;
                $destNomeFile = "";
//TO DO inserire ciclo for

                for ($i = 1; $i < 5; $i++) {
                    if (isset($_FILES['user_file' . $i]) AND $_FILES['user_file' . $i] != "") {

                        $destFileName = $preFileMovOri . "_" . dataCorrenteFile() . "_" . $_FILES['user_file' . $i]['name'];

                        //var/www/CloudFab/dbmacchina/
                        $destUploadDir = $destUploadDirMovOri . $preDirMacchina . $IdMacchina . "/";

                        //GENERAZIONE DEL NOME DEL FILE DA CARICARE SUL SERVER

                        $uploadEffettuato = uploadFile($_FILES['user_file' . $i], $destUploadDir, $destFileName, "");
                        //Se il file viene caricato si salva il link nella tabella allegato_mov_ori
                        if ($uploadEffettuato) {

                            $inserisciAllegato = inserisciNuovoAllegatoMov($IdMacchina, $idMov, $destFileName);
                            echo $destFileName . " " . $msgInfoDocCaricato . '<br/>';
                            //echo ' <a href="gestione_movimento_sing_mac.php?IdMacchina="' . $IdMacchina . '"&DescriStab="' . $DescriStab . '">"' . $msgOk . ' </a>';
                        }


                        /*                         * else {
                          $destNomeFile = "";
                          echo $msgErrDocNonCaricato;
                          echo ' <a href="gestione_movimento_sing_mac.php?IdMacchina="'. $IdMacchina . '"&DescriStab="' . $DescriStab . '">"' . $msgOk . ' </a>';
                          } */
                    }
                }
                if (!$insertControlloComp OR ! $inserisciAllegato) {

                    rollback();
                    echo "</br>" . $msgTransazioneFallita . ' <a href="gestione_movimento_sing_mac.php?IdMacchina="' . $IdMacchina . '"&DescriStab="' . $DescriStab . '">"' . $msgOk . ' </a>';
                } else {
                    commit();

                    if ($destNomeFile = "" AND ! $uploadEffettuato) {

                        echo $msgErrDocNonCaricato;
                        echo ' <a href="gestione_movimento_sing_mac.php?IdMacchina=' . $IdMacchina . '&DescriStab=' . $DescriStab . '">' . $msgOk . '</a>';
                    } else {

                        //echo "</br>".$msgInfoTransazioneRiuscita . " ";
                        //echo '<a href="gestione_movimento_sing_mac.php?IdMacchina='.$IdMacchina.'">' . $msgOk . '</a>';
                        //echo '</br><br/>'.$filtroStampaCodice.' &nbsp;<a target="_blank" href="genera_cod_movimento_silos.php?CodiceIngressoComp=' . $CodiceIngressoComp . '&NomeComp='.$NomeComp.'"><img src="/CloudFab/images/pittogrammi/stampa_G.png" class="icone"  title="'.$filtroStampaCodice.'"/></a>';
                        ?>
                        <script language="javascript">
                            window.location.href = "gestione_movimento_sing_mac.php?IdMacchina=<?php echo $IdMacchina ?>&DescriStab=<?php echo $DescriStab ?>";
                        </script>
                        <?php
                    }
                }
            }
            ?>
        </div>
    </body>
</html>
