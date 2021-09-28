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
            include('../sql/script_aggiornamento_config.php');


//Ricavo i nuovi valori dei campi mandati tramite POST
            $Id = $_POST['Id'];
            $Parametro = $_POST['Parametro'];
            $Valore = str_replace("'", "''", $_POST['Valore']);
            $Tipo = $_POST['Tipo'];
            $Descrizione = str_replace("'", "''", $_POST['Descrizione']);
            $Abilitato = $_POST['Abilitato'];


//############ Gestione degli errori sulle query ###############################
            $updateParametro = true;

//############ Gestione degli errori relativa ai nuovi dati modificati #########
//Verifico che i nuovi valori siano stati settati e non nulli
            $errore = false;
            $messaggio = $msgErroreVerificato . ' <br />';


            if (!isset($_POST['Parametro']) || trim($_POST['Parametro']) == "") {

                $errore = true;
                $messaggio = $messaggio . 'Campo Parametro vuoto!<br />';
            }
            if (!isset($_POST['Valore']) || trim($_POST['Valore']) == "") {

                $errore = true;
                $messaggio = $messaggio . 'Campo Valore vuoto!<br />';
            }

//Verifica esistenza 
//Verifico che non ci sia in tabella un record con gli stessi valori
//(descrizioni) e con Id diverso da quello che si sta modificando
           

            $result = verificaEsistenzaParametro($Id, $Parametro);

            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che esiste
                $errore = true;
                $messaggio = $messaggio . $msgDuplicaRecord . '!<br />';
            }
            mysql_close();

            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {


              
                

//##################### INIZIO TRANSAZIONE #####################################              
                begin();


                $updateParametro = updateAggConfig($Id,$Parametro,$Valore,$Tipo,$Descrizione,$Abilitato);


                if (!$updateParametro) {

                    rollback();
                    echo $msgTransazioneFallita . '! ' . $msgErrContattareAdmin . '!';


                } else {

                    commit();
                    mysql_close();
                    ?>
                    <script language="javascript">
                        window.location.href = "gestione_agg_config.php";
                    </script>
    <?php
    }
}
?>

        </div>
    </body>
</html>