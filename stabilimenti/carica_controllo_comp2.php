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

            $Componente = str_replace("'", "''", $_POST['IdComponente']);
            
            list($IdComponente, $NomeComp) = explode(';', $Componente);
//            $CodiceIngressoComp = str_replace("'", "''", $_POST['CodiceIngressoComp']);
            $Quantita = str_replace("'", "''", $_POST['Quantita']);

            $Fornitore = str_replace("'", "''", $_POST['Fornitore']);
            $IdMacchina = $_POST['Stabilimento'];

            list($IdMacchina, $DescriStab) = explode(';', $_POST['Stabilimento']);

            $CodOperatore = str_replace("'", "''", $_POST['Operatore']);
//            if($_POST['Operatore']=="") $CodOperatore=$defaultCodOperatore;
//################ VALORI CHECKBOX ########################################

            $MarchioCe = $_POST['MarchioCe'];
            foreach ($MarchioCe as $key => $value) {
                $MarchioCeConforme = $value;
            }

            $Merce = $_POST['Merce'];
            foreach ($Merce as $key => $value) {
                $MerceConforme = $value;
            }

            $Stabilita = $_POST['Stabilita'];
            foreach ($Stabilita as $key => $value) {
                $StabilitaConforme = $value;
            }

            $Procedura = $_POST['Procedura'];
            foreach ($Procedura as $key => $value) {
                $ProceduraAdottata = $value;
            }

//#########################################################################
            $Note = str_replace("'", "''", $_POST['Note']);
            $CodiceCE = str_replace("'", "''", $_POST['CodiceCE']);
            $RespProduzione = str_replace("'", "''", $_POST['RespProduzione']);
            $RespQualita = str_replace("'", "''", $_POST['RespQualita']);
            $ConsTecnico = str_replace("'", "''", $_POST['ConsTecnico']);
            $DataMov = dataCorrenteInserimento();

//Gestione degli errori
//Inizializzazione dell'errore e del messaggio di errore
            $errore = false;
            $messaggio = '';

//Verifica esistenza
//Apro la connessione al db
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_componente_controllo.php');

//            $DataMov = eliminaTrattini($DataMov);
            
            $DataMov=timestampToString($DataMov);
            
            //CODICE DEL MOVIMENTO: d della macchina.Id del componente . timestamp
           
            $CodiceIngressoComp = $IdMacchina . "." . $IdComponente . "." . $DataMov;

            //Verifica esistenza relativa al codice  
            $result = findControlloCompByCodice($CodiceIngressoComp);

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
                $insertControlloComp = insertNewMateriaPrimaIngresso($IdComponente, $CodOperatore, $Fornitore, $MarchioCeConforme, $MerceConforme, $StabilitaConforme, $ProceduraAdottata, $CodiceIngressoComp, $CodiceCE, $Quantita, $RespProduzione, $RespQualita, $ConsTecnico, $Note, $IdMacchina, $DataMov);


                if (!$insertControlloComp) {

                    rollback();
                    echo "</br>" . $msgTransazioneFallita;
                } else {

                    commit();
                    echo "</br>".$msgInfoTransazioneRiuscita . " ";
                    echo '<a href="carica_controllo_comp.php">' . $msgOk . '</a>';
                    echo '</br><br/>'.$filtroStampaCodice.' &nbsp;<a href="genera_cod_matpri_silos.php?CodiceIngressoComp=' . $CodiceIngressoComp . '&NomeComp='.$NomeComp.'"><img src="/CloudFab/images/pittogrammi/stampa_G.png" class="icone"  title="'.$filtroStampaCodice.'"/></a>';
                }
            }
            ?>
        </div>
    </body>
</html>
