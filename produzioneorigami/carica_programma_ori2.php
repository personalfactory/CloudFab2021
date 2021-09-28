<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php
    include('../object/OrdineOri.php');
    include('../include/validator.php');
    ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
           // if ($DEBUG)
               // ini_set('display_errors', 1);

            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../include/funzioni.php');
            include('../Connessioni/serverdb.php');
            include('../include/precisione.php');
            include('../sql/script.php');
            include('../sql/script_ordine_elenco.php');
            include('../sql/script_ordine_sing_mac.php');
            include('../sql/script_parametro_ordine.php');
            include('../sql/script_parametro_glob_mac.php');
            include('../sql/script_valore_par_ordine.php');

            list($idMacchina, $DescriStab) = explode('-', $_POST['Stabilimento']);
            $dtProgrammata = $_POST['AnnoOrdine'] . "-" . $_POST['MeseOrdine'] . "-" . $_POST['GiornoOrdine'];

            $note = "";
            $note = str_replace("'", "''", $_POST['Note']);
            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);

            //Ricalcolo la data corrente  
            //Data di inserimento dell'ordine 
            $dtOrdine = dataCorrenteInserimento();
            $dtAbilitato = dataCorrenteInserimento();

            $costo = 0; //al momento non gestito
            $stato = $valStatoInsOrdineOri; //0
            $descriStato = $valDescriStatoInsOrdineOri; // da produrre
            $abilitato = 1;

            
            $sqlParGlob = findParGlobMac();
            $parCarSeparazione2="";
            $parSeparatore="";
            while ($rowParGlob = mysql_fetch_array($sqlParGlob)) {

                switch ($rowParGlob['id_par_gm']) {
                    
                    case 22:
                        // _ PARAMETRO SEPARAZIONE 2
                        $parCarSeparazione2 = $rowParGlob['valore_variabile'];
                        break;
                    
                    case 156:
                        //,
                        $parSeparatore = $rowParGlob['valore_variabile'];
                        break;

                    default:
                        break;
                }
            }
            
            
            
//##############################################################################
//################## SALVATAGGIO ORDINE ########################################
//##############################################################################
            $erroreTransazione = false;
            $insertOrdine = true;
            $insertOrdineDettaglio = true;

            begin();
            $SelectPar = findAllParametriOrdine("id_par_ordine");

            $insertOrdine = inserisciOrdine($idMacchina, $dtOrdine, $dtProgrammata, $costo, $stato, $descriStato, $note, $abilitato, $dtAbilitato, $_SESSION['id_utente'], $IdAzienda);

            $idOrdine = 0;
            $sqlIdOrdine = findLastIdOrdine($idMacchina, $_SESSION['id_utente'], $IdAzienda);
            while ($rowIdOrdine = mysql_fetch_array($sqlIdOrdine)) {
                $idOrdine = $rowIdOrdine['id_ordine'];
            }

//##############################################################################
//################## SALVATAGGIO ORDINE DETTAGLO ###############################
//##############################################################################
            //Estraggo l'elenco dei prodotti presenti nell' oggetto OrdineOri
            $ordineProduzione = 1;
            for ($j = 0; $j < count($_SESSION['OrdineOri']); $j++) {

                //Memorizzo nelle rispettive variabili le Quantità di materia_prime
                $idProdotto = $_SESSION['OrdineOri'][$j]->getIdProdotto();
                $numPezziTot = $_SESSION['OrdineOri'][$j]->getNumPezzi()*$_SESSION['OrdineOri'][$j]->getMoltiplicatore() ;
                $numPezzi= $_SESSION['OrdineOri'][$j]->getNumPezzi();
                $pezzoKg = $_SESSION['OrdineOri'][$j]->getPezzoKg();
                $ordineProduzione=$_SESSION['OrdineOri'][$j]->getOrdineProduzione();
                $contatore = 0;
                $stato = "0";
                $abilitato = 1;

                $insertProd = inserisciOrdineSingMac($idOrdine, $idProdotto, $ordineProduzione, $numPezziTot, $pezzoKg, $contatore, $stato, $valDescriStatoInsOrdineOri, $abilitato, $dtProgrammata, $dtAbilitato);

                if (!$insertProd) {
                    $erroreTransazione = true;
                }

                //Verifico il numero di componenti che sono stati sostituiti nella formula
                //per stabilire se il parametro "cambioCemento" deve essere impostato a true o false
                $numCambiComp=0;
                $arrayComp = explode($parSeparatore, $_SESSION['OrdineOri'][$j]->getStringaComponenti());
                
                for ($i = 0; $i < count($arrayComp); $i++) {
                    list($idCompOriginale,$idCompAlt)=  explode($parCarSeparazione2, $arrayComp[$i]);
                  
                    
                    if($idCompOriginale!=$idCompAlt) $numCambiComp++;
                   
                }
                
                
//#######################################################################
//########## SALVO I PARAMETRI DELL ORDINE PER OGNI PRODOTTO ############
//#######################################################################
                //PARAMETRO ORDINE
                //id_par_ordine=1 - tipo chimica
                //id_par_ordine=2 - numero_confezioni_miscela
                //id_par_ordine=3 - peso_confezione
                //id_par_ordine=4 - tipo_confezione
                //id_par_ordine=5 - disabilita_ribalta_confezione
                //id_par_ordine=6 - cliente
                //id_par_ordine=7 - cambio_cemento
                //id_par_ordine=8 - prodotto_colorato
                //id_par_ordine=9 - cambio_bilancia 


                $p = 0;
                $arrayParOrdine = array();
                $arrayParOrdine[0] = "0";
                $arrayParOrdine[1] = $_SESSION['OrdineOri'][$j]->getTipoChimica();
                $arrayParOrdine[2] = $numPezzi;
                $arrayParOrdine[3] = $_SESSION['OrdineOri'][$j]->getPezzoKg();
                $arrayParOrdine[4] = $_SESSION['OrdineOri'][$j]->getTipoConfezione();
                $arrayParOrdine[5] = $_SESSION['OrdineOri'][$j]->getRibalta();
                $arrayParOrdine[6] = $_SESSION['OrdineOri'][$j]->getCliente();
                
                $arrayParOrdine[7] = "false"; //cambio cemento                
                if($numCambiComp>0) $arrayParOrdine[7] = "true";
                
                $arrayParOrdine[8] = "false";
                if($_SESSION['OrdineOri'][$j]->getIdRicettaColore()!=0 )  $arrayParOrdine[8] ="true";
                 
                $arrayParOrdine[9] = $_SESSION['OrdineOri'][$j]->getCambioBilancia();
                
                $arrayParOrdine[10] = "false";//prodotto con additivo
                if($_SESSION['OrdineOri'][$j]->getIdRicettaAdditivo()!=0 )  $arrayParOrdine[10] = "true";
                
                $arrayParOrdine[11] = $_SESSION['OrdineOri'][$j]->getIdRicettaColore();//id_colore
                $arrayParOrdine[12] = $_SESSION['OrdineOri'][$j]->getIdRicettaAdditivo();//id_additivo
                $arrayParOrdine[13]= $_SESSION['OrdineOri'][$j]->getStringaComponenti();// comp sostitutivi

                $NParOrdine = 1;
                mysql_data_seek($SelectPar, 0);
                $erroreInsertValoreParOrdine = "false";
                while ($rowPar = mysql_fetch_array($SelectPar)) {

                    //Per ogni prodotto presente nell'ordine devo recuperare l'id_ordine_sm per inserirlo nella tabella valore_par_ordine
                    $IdOrdineSm = 0;
                    $sqlIdOrdineSm = findOrdineSmByIdOrdineProdotto($idOrdine, $idProdotto, $_SESSION['OrdineOri'][$j]->getIdProdotto());
                    while ($rowSm = mysql_fetch_array($sqlIdOrdineSm)) {

                        $IdOrdineSm = $rowSm['id_ordine_sm'];
                    }


                    //Salvo nella tabella [valore_par_ordine]
                    $insertValoreParOrdine = insertValoreParOrdine($rowPar['id_par_ordine'], $idMacchina, $IdOrdineSm, $arrayParOrdine[$NParOrdine], $valAbilitato, dataCorrenteInserimento());

                    $NParOrdine++;

                    if (!$insertValoreParOrdine) {
                        $erroreInsertValoreParOrdine = true;
                    }
                    
                }// End while finiti i parametri 

                
            }// End While finiti i prodotti


            if ($erroreTransazione OR ! $insertOrdine OR ! $erroreInsertValoreParOrdine) {

                rollback();
                echo "</br>" . $msgTransazioneFallita;
            } else {

                commit();
                echo $msgInserimentoCompletato . ' <a href="gestione_ordini.php">' . "VEDI ORDINI" . '</a>';
            }
            ?>
        </div>
    </body>
</html>
