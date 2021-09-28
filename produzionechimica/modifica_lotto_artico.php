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
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_lotto_artico.php');


            if ($DEBUG)
                ini_set('display_errors', 1);
            //TO DO : controllo input
            $_GET['ToDo'];

            $update = true;
            $erroreTransazione = false;
            begin();

            $sql = selectLottoArticoByFiltri($_SESSION['Filtro'], "codice", $_SESSION['Codice'], $_SESSION['Descri'], $_SESSION['Listino'], $_SESSION['Costo'], $_SESSION['Giacenza'], $_SESSION['ScortaMinima'], $_SESSION['NumKit'], $_SESSION['QtaKit'], $_SESSION['PesoLotto'], $_SESSION['DtAbilitato']);
            $i = 1;
            while ($row = mysql_fetch_array($sql)) {
                if ($_GET['ToDo'] == "SalvaGiacenze") {
                    $update = aggiornaInventarioLotto($row['codice'], $_POST['QtaInv' . $i], dataCorrenteInserimento());
                } else if ($_GET['ToDo'] == "SalvaListino") {
                    $update = aggiornaListinoLotto($row['codice'], $_POST['QtaList' . $i]);
                } else if ($_GET['ToDo'] == "SalvaScortaMinima") {
                    $update = aggiornaScortaMinimaLotto($row['codice'], $_POST['QtaScorta' . $i]);
                } else if ($_GET['ToDo'] == "AggiornaCatalogo") {
                    
                   $valCatalogo=$valCatalogoSi;
                   if(!isSet($_POST['catalogo' . $i])){
                       $valCatalogo=$valCatalogoNo;
                   }
                   
                                           
                        $update = modificaCatalogoLottoArtico($row['codice'], $valCatalogo);
//                    
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

                echo $msgModificaCompletata . ' <a href="gestione_lotti.php">' . $msgOk . '</a>';
            }
            ?>
        </div>
    </body>
</html>