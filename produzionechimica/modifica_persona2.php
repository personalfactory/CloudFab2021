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
            include('../sql/script.php');
            include('../sql/script_persona.php');
            
//            ini_set(display_errors, "1");

//Gestione degli errori relativa ai nuovi dati modificati
//Verifico che i nuovi valori siano stati settati e non nulli
            $errore = false;
            $messaggio = $msgErroreVerificato . '<br />';


            if (!isset($_POST['IdPersona']) || trim($_POST['IdPersona']) == "") {

                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrCodice . '<br />';
            }
            if (!isset($_POST['Nominativo']) || trim($_POST['Nominativo']) == "") {

                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrDescri . '<br />';
            }

//Ricavo i nuovi valori dei campi mandati tramite POST
            $IdPersona = str_replace("'", "''", $_POST['IdPersona']);
            $Nominativo = str_replace("'", "''", $_POST['Nominativo']);
            $Tipo = str_replace("'", "''", $_POST['Tipo']);
            $Descrizione = str_replace("'", "''", $_POST['Descrizione']);
           
            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
            

            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo '<div id="msgErr">' . $messaggio . '</div>';
            } else {

                $modificaPersona = true;

                begin();
                
                $modificaPersona = updatePersona($IdPersona, $Nominativo, $Descrizione, $Tipo, $IdAzienda);

                if (!$modificaPersona) {

                    rollback();

                    echo '<div id="msgErr">' . $msgErroreVerificato . '' . $msgErrContattareAdmin . ' <a href="gestione_persona.php">' . $msgOk . '</a></div>';
                } else {

                    commit();

                    echo $msgModificaCompletata . ' <a href="gestione_persona.php">' . $msgOk . '</a>';
                }
            }
            ?>
        </div>
    </body>
</html>