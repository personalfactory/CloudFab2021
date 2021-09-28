<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php ini_set('display_errors', 1);
    include('../include/validator.php');
    ?>
    <head>
<?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../include/funzioni.php');
            include('../sql/script.php');
            include('../sql/script_macchina.php');
            include('../sql/script_anagrafe_macchina.php');
            include('../sql/script_valore_par_prod_mac.php');
            include('../sql/script_parametro_prod_mac.php');
            include('../sql/script_parametro_comp_prod.php');
            include('../sql/script_valore_par_comp.php');

            //INIZIALIZZAZIONE VARIABILI
            $TipoRiferimento = "";
            $LivelloGruppo = "";
            $CodiceStabilimento = 0;
            $DescrizioneStabilimento = "";
            $IdClienteGaz = 50;
            $Ragso1 = "";
            $IdLingua = 0;
            $UserOrigami = "";
            $PassOrigami = "";//=2 se macchina passa da Cloudfab2 a CloudFab3--- altrimenti=3 se la macchina viene installata con Cloudfab3
//            $ConfermaPassOrigami = "";
            $UserServer = "";//Versione CloudFab
            $PassServer = "";
//            $ConfermaPassServer = "";
            $UserFtp = "";
            $PassFtp = "";
            $ConfermaPassFtp = "";
            $PassZip = "";
            $ConfermaPassZip = "";

            ####################################################################
            //Conservo gruppo e rif geo della macchina prima della modifica
            //se vengono modificati bisogna rigenerare i valori par comp mac
            $TipoRiferimentoOld = $_POST['TipoRiferimentoOld'];
            $LivelloGruppoOld = $_POST['LivelloGruppoOld'];
            $GeograficoOld = $_POST['GeograficoOld'];
            $GruppoOld = $_POST['GruppoOld'];
            ####################################################################
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
//################################################################################
//Recupero dei valori dei campi livello_gruppo e gruppo mandati tramite POST
//################################################################################      
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
//                $Gruppo = $_POST['SestoLivello'];
                $Gruppo = "Universale";
            }
//################################################################################
//Recupero dei valori dei campi mandati tramite post
//################################################################################
            $IdMacchina = $_POST['IdMacchina'];
            $CodiceStabilimento = str_replace("'", "''", $_POST['CodiceStab']);
            $DescrizioneStabilimento = str_replace("'", "''", $_POST['DescriStab']);
            $Ragso1 = str_replace("'", "''", $_POST['Ragso1']);
            $IdClienteGaz = str_replace("'", "''", $_POST['IdClienteGaz']);
            $Lingua = str_replace("'", "''", $_POST['Lingua']);
            $UserOrigami = str_replace("'", "''", $_POST['UserOrigami']);
            $UserServer = str_replace("'", "''", $_POST['UserServer']);            
            $PassOrigami = str_replace("'", "''", $_POST['PassOrigami']);
            
//            $ConfermaPassOrigami = str_replace("'", "''", $_POST['ConfermaPassOrigami']);
//            $PassServer = str_replace("'", "''", $_POST['PassServer']);
//            $ConfermaPassServer = str_replace("'", "''", $_POST['ConfermaPassServer']);
            $Geografico = str_replace("'", "''", $Geografico);
            $Gruppo = str_replace("'", "''", $Gruppo);
            $UserFtp = str_replace("'", "''", $_POST['UserFtp']);
            $PassFtp = str_replace("'", "''", $_POST['PassFtp']);
            $ConfermaPassFtp = str_replace("'", "''", $_POST['ConfermaPassFtp']);
            $PassZip = str_replace("'", "''", $_POST['PassZip']);
            $ConfermaPassZip = str_replace("'", "''", $_POST['ConfermaPassZip']);
            $Abilitato = str_replace("'", "''", $_POST['Abilitato']);

            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
//##############################################################################     
//############ VARIABILI RELATIVE AD ERRORI SULLA TRANSAZIONE ##################
//##############################################################################
            $errore = false;
            $messaggio = $msgErroreVerificato . '<br/>';

            $erroreTransazione = false;
            
            $insertStoricoMac = true;
            $insertStoricoAnMac = true;
            $updateServerdbMac = true;
            $updateServerdbAnMac = true;
            
            $erroreInsertValoreParComp=false;
            $InsertValoreParComp=true;

//################################################################################
//##################### VERIFICA ESISTENZA #######################################
//################################################################################
//Apro la connessione al db
            include('../Connessioni/serverdb.php');

            $result = verificaModificaMacchina($IdMacchina, $CodiceStabilimento, $DescrizioneStabilimento);
            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che il valore inserito esiste nel db
                $errore = true;
                $messaggio = $messaggio . " " . $msgErrStabDuplicato . '<br />';
            }


            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {


//##############################################################################
//################### INIZIO TRANSAZIONE SALVATAGGIO E STORICIZZAZIONE #########
//##############################################################################
                //Seleziono il record  che si vuole modificare dalla tabella [macchina] e memorizzo il contenuto dei vari campi
                include('../Connessioni/storico.php');


                begin();

                //Inserisco nello storico delle macchine i valori del vecchio record
                $insertStoricoMac = storicizzaMacchina($IdMacchina);


                // Inserisco nello storico dell'anagrafe_macchina i valori del vecchio record
                $insertStoricoAnMac = storicizzaAnagrafeMacchina($IdMacchina);


//##############################################################################
//########################## MODIFICO SERVERDB #################################
//##############################################################################
                //Modifico il record corrispondente all'id_macchina selezionato nella tabella [macchina] di serverdb 
                $updateServerdbMac = modificaMacchina($CodiceStabilimento, $DescrizioneStabilimento, $Ragso1, $UserOrigami, $UserServer, $PassOrigami, $PassServer, $UserFtp, $PassFtp, $PassZip, $Abilitato, $IdMacchina, $IdAzienda);

                //Modifico il record corrispondente all'id_macchina selezionato nella tabella [anagrafe_macchina]
                $updateServerdbAnMac = modificaAnagrafeMacchina($IdClienteGaz, $Lingua, $Geografico, $TipoRiferimento, $Gruppo, $LivelloGruppo, $Abilitato, $IdMacchina);

                //#######################################################################
                //##################### PARAMETRI PRODOTTO MACCHINA #####################
                //#######################################################################
                //Se si modifica il gruppo o il riferimento geografico del prodotto bisogna eventualmente creare dei nuovi parametri in 
                // valori par prod mac

                if ($Gruppo != $GruppoOld OR $LivelloGruppo != $LivelloGruppoOld
                        OR $TipoRiferimento != $TipoRiferimentoOld OR $Geografico != $GeograficoOld) {

                    //CASO 1 : Se ci sono nuovi prodotti che sono visibili sulla macchina bisogna aggiungere i valori par nuovi
                    //CASO 2 : Se ci sono meno prodotti che sono visibili sulla macchina, i parametri non si possono eliminare perchè ormai 
                    // ci sono in tabella esulla macchina
                    //Seleziona dalla tabella valore_par_prod_mac i prodotti che hanno già i parametri relativi alla macchina in questione
                    //Li salvo in un array
                    $prodottiOld = array();
                    $i = 0;
                    $sqlProdottiOld = selectProdottiFromValParProdMac("id_prodotto", "id_prodotto", $IdMacchina);
                    while ($rowProdOld = mysql_fetch_array($sqlProdottiOld)) {
                        $prodottiOld[$i] = $rowProdOld['id_prodotto'];
                        $i++;
                    }
                    print_r($prodottiOld);

                    echo "Sono stati generati i nuovi parametri per i seguenti prodotti : <br/>";
                    $arrayProdottiAssegnati = array();
                    $sqlParPrMac = findAllParametriProdMac("id_par_pm");

                    //Seleziono i prodotti che secondo il nuovo gruppo ed il nuovo rif geo sono visibili alla macchina
                    $arrayProdottiAssegnati = trovaProdottiAssegnatiAMacchina($IdMacchina);

                    for ($i = 0; $i < count($arrayProdottiAssegnati); $i++) {
                        $IdProdotto = $arrayProdottiAssegnati[$i];

                        if (!in_array($IdProdotto, $prodottiOld)) {
                            //Se un prodotto non è già contenuta nell'array allora si generano i parametri nella tabella valore_par_prod_mac

                            if (mysql_num_rows($sqlParPrMac) > 0)
                                mysql_data_seek($sqlParPrMac, 0);
                            //Per ogni parametro inserisce un valore nella tabella valore_par_prod_mac
                            while ($rowParMac = mysql_fetch_array($sqlParPrMac)) {

                                $insertIntoValParProdMac = insertValoriProdottoMacchina($rowParMac['id_par_pm'], $IdProdotto, $IdMacchina, $rowParMac['valore_base']);

                                echo $IdProdotto . "<br />";

                                if (!$insertIntoValParProdMac)
                                    $erroreTransazione = true;
                            }//End While parametri
                        } //if prodotto non in valore_par_prod_mac
                    }

                    //################ VALORI PAR COMP #############################################
                    //##############################################################
                    //### SELEZIONE DEI COMPONENTI PER GRUPPO E RIFERIMENTO GEO ######
                    //##############################################################

                    $arrayCompPerMac = trovaComponentiAssegnatiAMacchina($IdMacchina);
                    for ($i = 0; $i < count($arrayCompPerMac); $i++) {

                        echo $arrayCompPerMac[$i] . "<br />";
                    }

                    //######################################################################
                    //################### PARAMETRI COMPONENTI PROD  #######################
                    //######################################################################

                    $NParCp = 1;
                    $SelectParametroCp = findAllParametriComp("id_par_comp");
                    mysql_data_seek($SelectParametroCp, 0);

                    while ($rowParametroCp = mysql_fetch_array($SelectParametroCp)) {

                        $IdParComp = $rowParametroCp['id_par_comp'];

                        //##################### CICLO COMPONENTI #########################

                        for ($i = 0; $i < count($arrayCompPerMac); $i++) {

                            $ValoreComp = $rowParametroCp['valore_base'];

                            $InsertValoreParComp=insertIfNotExistValParComp($arrayCompPerMac[$i], $IdParComp, $ValoreComp, $IdMacchina, dataCorrenteInserimento());

//                            $InsertValoreParComp = insertNewRecordValoreParComp($IdParComp, $arrayCompPerMac[$i], $ValoreComp, $ValoreComp, dataCorrenteInserimento(), " ", $IdMacchina, $valAbilitato, dataCorrenteInserimento());

                            if (!$InsertValoreParComp) {
                                $erroreInsertValoreParComp = true;
                            }
                        }

                        $NParCp++;
                    }//End while fine parametri componente 
                }

//                print_r($arrayProdottiAssegnati);

//############################ FINE PARAMETRI COMP PROD ########################







                if ($erroreTransazione OR $erroreInsertValoreParComp OR !$insertStoricoMac OR ! $insertStoricoAnMac OR ! $updateServerdbMac OR ! $updateServerdbAnMac) {

                    rollback();
                    echo $msgTransazioneFallita . " " . $msgErrContattareAdmin . ' <a href="gestione_macchine.php">' . $msgOk . '</a>';
                } else {

                    commit();
                    mysql_close();
                    echo $msgInfoTransazioneRiuscita;
                    echo '<a href="gestione_macchine.php">' . $msgOk . '</a>';
                }
            }//Fine primo if($errore) 
            ?>

        </div>
    </body>
</html>
