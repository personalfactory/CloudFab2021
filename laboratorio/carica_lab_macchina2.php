<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="labContainer">
            <?php
             if($DEBUG) ini_set(display_errors, "1"); 
            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('sql/script_lab_macchina.php');

            $Nome = str_replace("'", "''", $_POST['Nome']);
            $Descrizione = str_replace("'", "''", $_POST['Descrizione']);

//############## CONTROLLO INPUT  #############################
            $errore = false;
            $messaggio = '';

            if (!isset($Nome) || trim($Nome) == "") {

                $errore = true;
                $messaggio = $$messaggio . ' ' . $msgErroreNome . '<br />';
            }
            if (!isset($Descrizione) || trim($Descrizione) == "") {

                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrDescri . '<br />';
            }

//############# VERIFICA ESISTENZA ##############################
            $result = findRosettaByNome($Nome);

            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che esiste
                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrNomeEsist . '<br />';
            }

            if ($errore) {
                $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                echo '<div id="msgErr">' . $messaggio . '</div>';
            } else {
                list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);

                $result = true;
                $result = inserisciNuovaMacchina($Nome, $Descrizione, $valAbilitato, $valRosetLibera, "", dataCorrenteInserimento(),$_SESSION['id_utente'],$IdAzienda);

                if (!$result)
                    echo $msgErroreVerificato . '<a href="gestione_lab_macchine.php">' . $msgErrContactAdmin . '</a><br/>';
                else {
                    ?> 

                    <script language="javascript">
                        location.href = "gestione_lab_macchine.php";
                    </script>
        <?php
    }
}
?>
        </div>
    </body>
</html>
