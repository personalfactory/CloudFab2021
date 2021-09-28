<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
            //############# STRINGHE UTENTI  AZIENDE VISIBILI###########################
            //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
            //dall'utente loggato   
            $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'materia_prima');   
            //##########################################################################

            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_materia_prima.php');

            ini_set('display_errors', '1');
            //TO DO : controllo input
            $_GET['ToDo'];

            $update = true;
            $erroreTransazione = false;
            begin();

            $sql = selectMatPrimeByFiltri($_SESSION['Filtro'], "cod_mat", $_SESSION['Codice'], $_SESSION['Descri'], $_SESSION['Famiglia'], $_SESSION['ScortaMinima'], $_SESSION['PreAcq'], $_SESSION['Giacenza'], $_SESSION['DtAbilitato'],$strUtentiAziende,$_SESSION['condizioneSelect']);
            $i = 1;
            while ($row = mysql_fetch_array($sql)) {
                if ($_GET['ToDo'] == "SalvaGiacenze") {
//                    echo $_POST['QtaInv' . $i] . "</br>";
                    $update = aggiornaInvGiacMatPri($row['cod_mat'], $_POST['QtaInv' . $i], dataCorrenteInserimento());

//                else if ($_GET['ToDo'] == "SalvaListino") {
//                    $update = aggiornaListinoLotto($row['codice'], $_POST['QtaList' . $i]);
                } else if ($_GET['ToDo'] == "SalvaScortaMinima") {
                    $update = aggiornaScortaMinimaMat($row['cod_mat'], $_POST['QtaScorta' . $i]);
                }

                if (!$update)
                    $erroreTransazione = true;

                $i++;
            }

            if ($erroreTransazione) {

                rollback();

                echo '<div id="msgErr">' . $msgErroreVerificato . '' . $msgErrContattareAdmin . ' <a href="gestione_lotti.php">' . $msgOk . '</a></div>';
            } else {

                commit();

                echo $msgModificaCompletata . ' <a href="gestione_materie_prime.php">' . $msgOk . '</a>';
            }
            ?>
        </div>
    </body>
</html>