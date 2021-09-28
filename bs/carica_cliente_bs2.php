<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
            if ($DEBUG)
                ini_set(display_errors, "1");

            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include ('../sql/script_bs_cliente.php');
            include ('../sql/script.php');

            $ToDo = $_POST['ToDo'];
            $IdCliente = str_replace("'", "''", $_POST['IdCliente']);
            $Nominativo = str_replace("'", "''", $_POST['Nominativo']);
            $Descrizione = str_replace("'", "''", $_POST['Descrizione']);
            $Note = str_replace("'", "''", $_POST['Note']);
            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);

//Gestione degli errori
//Inizializzazione dell'errore e del messaggio di errore
            $errore = false;
            $messaggio = $msgErroreVerificato . '<br />';

//Verifica che il nominativo sia settato e non vuoto
            if (!isset($Nominativo) || trim($Nominativo) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroTipoCodice . ' !<br/>';
            }

            //Verifica esistenza relativa al nominativo  
            $result = "";
            if ($ToDo == "NuovoCliente") {
                $result = findClienteBsByNominativo($Nominativo);
            } else if ($ToDo == "ModificaCliente"){
                $result = findClienteBsByNominativoID($IdCliente, $Nominativo);
            }
            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che esiste
                $errore = true;
                $messaggio = $messaggio . $msgDuplicaRecord . '<br />';
            }

            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';


            //Controllo sulla variabile errore
            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {
                $messagioFine="";
                $insertCliente = true;
                $insertClienteUtente = true;

                //Inserisco perche non ci sono errori
                begin();
                //Se si tratta di un nuovo cliente da inserire
                if ($ToDo == "NuovoCliente") {

                    $insClienteBs = inserisciClienteBs($Nominativo, $Descrizione, $Note, dataCorrenteInserimento(), $_SESSION['id_utente'], $IdAzienda);
                    $idClienteNew = "";

                    $messagioFine=$msgInserimentoCompletato;
//              

                    //Se si tratta di un nuovo cliente da inserire
                } else if ($ToDo == "ModificaCliente") {

                    $insClienteBs = updateBSClienteById($IdCliente, $Nominativo, $Descrizione, $Note, dataCorrenteInserimento(), $IdAzienda);
                    $messagioFine=$msgModificaCompletata;
                }



                if (!$insertCliente) {

                    rollback();
                    echo '<div id="msgErr">' . $msgTransazioneFallita . '! ' . $msgErrContactAdmin . '!</div>';
                    echo '<a href="gestione_clienti_bs.php">' . $msgOk . '</a><br/>';
                } else {

                    commit();
                    mysql_close();
                    echo($messagioFine . ' <a href="gestione_clienti_bs.php">' . $msgOk . '</a><br/>');
                }
            }
            ?>
        </div>
    </body>
</html>
