<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
            ini_set('display_errors', '1');
            include('../include/menu.php');
            include('../include/precisione.php');
            include('../include/funzioni.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../Connessioni/origamidb.php');
            include('../sql/script.php');
            include('../sql/script_macchina.php');
            include('../sql/script_anagrafe_macchina.php');
            include('../sql/script_parametro_sing_mac.php');
            include('../sql/script_componente.php');
            include('../sql/script_parametro_comp_prod.php');
            include('../sql/script_valore_par_comp.php');
            include('../sql/script_valore_par_sing_mac.php');
            include('../sql/script_prodotto.php');
            include('../sql/script_parametro_prod_mac.php');
            include('../sql/script_valore_par_prod_mac.php');
            include('../sql/script_anagrafe_prodotto.php');
            include('../sql/script_macchina_ori.php');
            include('../sql/script_aggiornamento_config_ori.php');


            //INIZIALIZZAZIONE VARIABILI
            $TipoRiferimento = "";
            $LivelloGruppo = "";
            $CodiceStabilimento = 0;
            $DescrizioneStabilimento = "";
            $IdMacchina = 0;
            $IdClienteGaz = 0;
            $Ragso1 = "";
            $IdLingua = 0;
            $UserOrigami = "";//Versione cloudFab
            $PassOrigami = "";//=2 se macchina passa da Cloudfab2 a CloudFab3--- altrimenti=3 se la macchina viene installata con Cloudfab3
//            $ConfermaPassOrigami = "";
            $UserServer = ""; //versione Origami
            $PassServer = ""; //Al momento vuoto
//            $ConfermaPassServer = "";
            $UserFtp = "";
            $PassFtp = "";
            $ConfermaPassFtp = "";
            $PassZip = "";
            $ConfermaPassZip = "";

//################################################################################
//Recupero dei valori dei campi tipo_riferimento e geografico mandati tramite POST
//################################################################################

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
//##########################################################################	
//Recupero dei valori dei campi livello_gruppo e gruppo mandati tramite POST
//##########################################################################  

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
                $Gruppo = "Universale";
//$Gruppo = $_POST['SestoLivello'];
            }

            $IdMacchina = str_replace("'", "''", $_POST['IdMacchina']);
            $CodiceStabilimento = str_replace("'", "''", $_POST['CodiceStabilimento']);
            $DescrizioneStabilimento = str_replace("'", "''", $_POST['DescrizioneStabilimento']);
            $IdClienteGaz = str_replace("'", "''", $_POST['IdClienteGaz']);
            $Ragso1 = str_replace("'", "''", $_POST['Ragso1']);
            $Geografico = str_replace("'", "''", $Geografico);
            $Gruppo = str_replace("'", "''", $Gruppo);
            $IdLingua = str_replace("'", "''", $_POST['Lingua']);
            $UserOrigami = str_replace("'", "''", $_POST['UserOrigami']);//Versione CloudFab
            $PassOrigami=$UserOrigami; //Per le nuove macchine con versione CloudFab3
            
//            $PassOrigami = str_replace("'", "''", $_POST['PassOrigami']);            
//            $ConfermaPassOrigami = str_replace("'", "''", $_POST['ConfermaPassOrigami']);
//            $PassServer = str_replace("'", "''", $_POST['PassServer']);
//            $ConfermaPassServer = str_replace("'", "''", $_POST['ConfermaPassServer']);
            
            $UserServer = str_replace("'", "''", $_POST['UserServer']); //Versione Origami
            $PassServer="";
            $UserFtp = str_replace("'", "''", $_POST['UserFtp']);
            $PassFtp = str_replace("'", "''", $_POST['PassFtp']);
            $ConfermaPassFtp = str_replace("'", "''", $_POST['ConfermaPassFtp']);
            $PassZip = str_replace("'", "''", $_POST['PassZip']);
            $ConfermaPassZip = str_replace("'", "''", $_POST['ConfermaPassZip']);

            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);

//##############################################################################
//####################### GESTIONE ERRORI ######################################
//##############################################################################
            //VARIABILI RELATIVE AD ERRORI SULLA TRANSAZIONE
            $InsertMacchina = true;
            $InsertAnagrafeMacchina = true;
            $InsertValoreParProdMac = true;

            $erroreInsertValoreSingMac = false;
            $erroreInsertValoreParComp = false;
            $erroreInsertValoreParProdMac = false;

            $InizializzaOrigamiDb = true;
            $AzzeraMacchinaOri = true;
            $InizializzaAggConfigOri1 = true;
            $InizializzaAggConfigOri2 = true;
            $InizializzaAggConfigOri3 = true;
            $CreazioneBackupFile = true;
            $CreaDirFTPInviaFile = true;

            //VARIABILI RELATIVE AD ERRORI SULL'INPUT
            $errore = false;
            $messaggio = '';

            //##################################################################
            //#################### VERIFICA ESISTENZA ##########################
            //##################################################################

            if ($IdMacchina != '') {
                $sqlEsMacchina = verificaEsistenzaMacchina($IdMacchina, $CodiceStabilimento, $DescrizioneStabilimento);

                if (mysql_num_rows($sqlEsMacchina) != 0) {
                    //Se entro nell'if vuol dire che il valore inserito esiste nel db
                    $errore = true;
                    $messaggio = $messaggio . ' ' . $msgErrEsisteMacchina . '!<br />';
                }
            }
            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo '<div id="msgErr">' . $messaggio . '</div>';
            } else {

                //##############################################################
                //######################### SALVATAGGIO SUL DB #################
                //##############################################################
                $SelectValoreSm = findAllParametriSm("id_par_sm");
                $SelectParametroCp = findAllParametriComp("id_par_comp");
                $SelectParametroPr = findAllParametriProdMac("id_par_pm");


                //AZZERO IL DATABASE ORIGAMIDB 
                //NOTA l'istruzione ALTER TABLE non può essere inserita nella transazione
                $InizializzaAggConfigOri1 = deleteAggiornamentoConfigOri();
                $InizializzaAggConfigOri2 = setAutoincrementAggConfigOri();

                //############## INSERIMENTO NUOVA MACCHINA ####################

                begin();

                $InsertMacchina = insertNewMacchina($IdMacchina, $CodiceStabilimento, $DescrizioneStabilimento, $Ragso1, "1", dataCorrenteInserimento(), $UserOrigami, $UserServer, $PassOrigami, $PassServer, $UserFtp, $PassFtp, $PassZip, $_SESSION['id_utente'], $IdAzienda);

                $InsertAnagrafeMacchina = insertNewAnMac($IdClienteGaz, $Geografico, $TipoRiferimento, $Gruppo, $LivelloGruppo, $IdLingua, "1", dataCorrenteInserimento(), $CodiceStabilimento);


                //Memorizzo in una variabile l'id_macchina della macchina appena inserita			
                $SelectIdMacchina = findMacchinaByCodice($CodiceStabilimento);

                while ($row = mysql_fetch_array($SelectIdMacchina)) {
                    $IdMacchina = $row['id_macchina'];
                }

                //######################################################################
                //################### PARAMETRI SINGOLA MACCHINA  ######################
                //######################################################################
                //Salvo i valori dei parametri singola macchina il cui valore base 
                $NParSm = 1;
                mysql_data_seek($SelectValoreSm, 0);
                while ($rowValore = mysql_fetch_array($SelectValoreSm)) {

                    $ValoreSm = $rowValore['valore_base'];
                    //Salvo nella tabella [valore_par_sing_mac]
                    $InsertValoreSingMac = insertValoreParSingMac($rowValore['id_par_sm'], $ValoreSm, $ValoreSm, dataCorrenteInserimento(), $ValoreSm, $IdMacchina, "1", dataCorrenteInserimento());

                    $NParSm++;

                    if (!$InsertValoreSingMac) {
                        $erroreInsertValoreSingMac = true;
                    }
                }// end while finiti i parametri singola macchina 
                //##############################################################
                //### SELEZIONE DEI COMPONENTI PER GRUPPO E RIFERIMENTO GEO ####
                //##############################################################
                
                echo "</br>" . $filtroGeografico . ": " . $Geografico;
                echo "</br>" . $filtroGruppoAcquisto . ": " . $Gruppo . "</br>";

                $arrayCompPerMac = trovaComponentiAssegnatiAMacchina($IdMacchina);
                if (count($arrayCompPerMac) > 0) {

                    echo "COMPONENTI ASSEGANTI ALLA MACCHINA :<br />";
                }
                for ($i = 0; $i < count($arrayCompPerMac); $i++) {

                    echo $arrayCompPerMac[$i] . " - ";
                }

                //##############################################################
                //################### PARAMETRI COMPONENTI PROD  ###############
                //##############################################################

                $NParCp = 1;

                mysql_data_seek($SelectParametroCp, 0);

                while ($rowParametroCp = mysql_fetch_array($SelectParametroCp)) {

                    $IdParComp = $rowParametroCp['id_par_comp'];

                    //##################### CICLO COMPONENTI #########################

                    for ($i = 0; $i < count($arrayCompPerMac); $i++) {

                        $ValoreComp = $rowParametroCp['valore_base'];

                        $InsertValoreParComp = insertNewRecordValoreParComp($IdParComp, $arrayCompPerMac[$i], $ValoreComp, $ValoreComp, dataCorrenteInserimento(), " ", $IdMacchina, $valAbilitato, dataCorrenteInserimento());

                        if (!$InsertValoreParComp) {
                            $erroreInsertValoreParComp = true;
                        }
                    }

                    $NParCp++;
                }//End while fine parametri componente 
                
                //##############################################################
                //### SELEZIONE DEI PRODOTTI PER GRUPPO E RIFERIMENTO GEO ######
                //##############################################################

                $arrayProdPerMac = trovaProdottiAssegnatiAMacchina($IdMacchina);
                
                if (count($arrayProdPerMac) > 0) {
                    echo "<br /><br /> PRODOTTI ASSEGANTI ALLA MACCHINA : <br />";
                }
                for ($i = 0; $i < count($arrayProdPerMac); $i++) {

                    echo $arrayProdPerMac[$i] . " - ";
                }


                //######################################################################
                //################### PARAMETRI PRODOTTO MACCHINA ######################
                //######################################################################
                $NParPr = 1;
                mysql_data_seek($SelectParametroPr, 0);
                while ($rowParametroPr = mysql_fetch_array($SelectParametroPr)) {

                    $IdParPrM = $rowParametroPr['id_par_pm'];
                    $ValoreProd = $rowParametroPr['valore_base'];

                    //########## CICLO PRODOTTI PER GRUPPO E RIF GEO ##################                   
                    for ($z = 0; $z < count($arrayProdPerMac); $z++) {

                        $InsertValoreParProdMac = insertValoriProdottoMacchina($IdParPrM, $arrayProdPerMac[$z], $IdMacchina, $ValoreProd);

                        if (!$InsertValoreParProdMac) {
                            $erroreInsertValoreParProdMac = true;
                        }
                    }
                    $NParPr++;
                }//End while fine parametri prodotto macchina 
                
                //##############################################################
                //################ INIZIALIZZA DATABASE MACCHINA ###############
                //##############################################################
                
                $backupFilePath = $destBackupOrigamiDBFileDir.'macchina'.$IdMacchina.'/';
//                $backupFileName = $prefixFileName . $IdMacchina . '.sql';
                $backupFileName = $prefixFileName . '.sql';


                $AzzeraMacchinaOri = deleteMacchinaOri();
                $InizializzaOrigamiDb = inizializzaNewMacchinaOri($IdMacchina, $CodiceStabilimento, $DescrizioneStabilimento, $Ragso1, $valAbilitato, dataCorrenteInserimento(), $UserOrigami, $UserServer, $PassOrigami, $PassServer, $UserFtp, $PassFtp, $PassZip);

                $InizializzaAggConfigOri3 = inizializzaAggiornamentoConfigOri();


                if ($erroreInsertValoreSingMac
                        OR $erroreInsertValoreParComp
                        OR $erroreInsertValoreParProdMac
                        OR ! $InsertMacchina
                        OR ! $InsertAnagrafeMacchina
                        OR ! $AzzeraMacchinaOri
                        OR ! $InizializzaOrigamiDb
                        OR ! $InizializzaAggConfigOri3
                ) {

                    rollback();

                    echo "</br>InsertMacchina : " . $InsertMacchina;
                    echo "</br>InsertAnagrafeMacchina : " . $InsertAnagrafeMacchina;
                    echo "</br>erroreInsertValoreSingMac : " . $erroreInsertValoreSingMac;
                    echo "</br>erroreInsertValoreParComp : " . $erroreInsertValoreParComp;
                    echo "</br>erroreInsertValoreParProdMac : " . $erroreInsertValoreParProdMac;

                    echo "</br>AzzeraMacchinaOri : " . $AzzeraMacchinaOri;
                    echo "</br>InizializzaOrigamiDb : " . $InizializzaOrigamiDb;
                    echo "</br>InizializzaAggConfigOri1 : " . $InizializzaAggConfigOri1;
                    echo "</br>InizializzaAggConfigOri2 : " . $InizializzaAggConfigOri2;
                    echo "</br>InizializzaAggConfigOri3 : " . $InizializzaAggConfigOri3;

                    echo '</br></br>' . $msgTransazioneFallita . ' <a href="gestione_macchine.php"> ' . $msgOk . '</a>';
                } else {

                    commit();

                    if ($InizializzaAggConfigOri1 AND $InizializzaAggConfigOri2) {
                        echo "</br>" . $msgAzzeramentoOrigamidb . "</br>";
                    } else {
                        echo "</br>" . $msgErrAzzeramentoOrigamidb . "</br>";
                    }
                       
                    
                    //########## CREAZIONE FILE BACKUP DB MACCHINA E INVIO SU FTP #######
                    $stringCmd1 = 'mkdir '.$destBackupOrigamiDBFileDir.'macchina'.$IdMacchina;
                    shell_exec($stringCmd1);
                    $completeBackupFilePath=$backupFilePath.$prefixFileName .'.sql';
                    $stringCmd = 'mysqldump -B --user=' . $username_origamidb . ' --password=' . $password_origamidb . ' --host=' . $hostname_origamidb . ' ' . $database_origamidb . ' > ' . $completeBackupFilePath;

                    echo $msgCreazioneBkpFile . $CreazioneBackupFile = shell_exec($stringCmd);

                    if (!file_exists($completeBackupFilePath)) {
                        echo "<br/>" . $msgErrCreazioneBkpFile;
                    } else {
                        //###################### CREA CARTELLE FTP E INVIO BACKUP ###################
                        $backupFilePath=$destBackupOrigamiDBFileDir . 'macchina'.$IdMacchina.'/';
                        echo "<br/>" . $msgInizializzazioneFtp . $CreaDirFTPInviaFile = shell_exec('sh ../dbmacchina/creaDirFtp.sh ' . $IdMacchina . ' ' . $UserFtp . ' ' . $backupFilePath.' '. $backupFileName. ' '.$PassZip);
                    }

                    echo "<br/>" . $msgInfoNuovoStab . "<br/>";
                    echo $msgInfoParSmInizializzati . "<br/>";
                    echo $msgInfoParCompInizializzati . "<br/>";
                    echo $msgInfoParProdMacInizializzati . "<br/>";
                    echo $msgInfoTransazioneRiuscita . " ";
                    echo '<a href="gestione_macchine.php">' . $msgOk . '</a>';

//                    echo '<br /><a href="../dbmacchina/downloadBackup.php?IdMacchina=' . $IdMacchina . '">' . $msgDownLoadBackup . '</a>';
                    echo '<br /><a href="../dbmacchina/macchina'.$IdMacchina.'/origamidb.zip">' . $msgDownLoadBackup . '</a>';
                }
            }//End if errore
            ?>

        </div>
    </body>
</html>
