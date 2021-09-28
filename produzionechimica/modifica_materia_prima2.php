<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>

        <div id="mainContainer">
            <?php
            if($DEBUG) ini_set(display_errors, 1);

            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_materia_prima.php');
            include('../sql/script_gaz_movmag.php');
            include('../laboratorio/sql/script_lab_materie_prime.php');
            
//Ricavo i nuovi valori dei campi mandati tramite POST
            $Codice = $_POST['Codice'];
            $Descrizione = str_replace("'", "''", $_POST['Descrizione']);
            $Fornitore = str_replace("'", "''", $_POST['Fornitore']);
            $UniMisura = $valUniMisKg;
            $PrezzoMed = $_POST['PreMed'];
            $PreAcq = $_POST['PreAcq'];
            $ScortaMinima = $_POST['ScortaMinima'];
            $GiacenzaAttuale = $_POST['GiacenzaAttuale'];
            $Inventario = $_POST['Inventario'];
            $DtInventario = $_POST['DtInventario'];
                    
            $Note = str_replace("'", "''", $_POST['Note']);
            

            $modificaMatPrima = true;
            $aggiornaPrezzoMov = true;
            $aggiornaPrezzoMedioMat = true;
            $aggiornaLab = true;

            begin();
            $modificaMatPrima = modificaMateriaPrima($Codice, $Descrizione, $UniMisura, $PreAcq, $PrezzoMed, $Fornitore, $ScortaMinima, $Inventario,$DtInventario,$GiacenzaAttuale, $Note);

            //Se il prezzo è diverso da zero si aggiornano i prezzi relativi 
            //ai movimenti della materia prima che nella tabella gaz_movmag sono uguali a zero
            if ($PreAcq != 0.00000)
                $aggiornaPrezzoMov = aggiornaPrezzoMovimenti($Codice, $PreAcq, $valDefaultPrezzo);

            //################ CALCOLO DEL PREZZO MEDIO PONDERATO #############
            $qtaPerPrezzo = 0;
            $qtaTot = 0;
            $prezzoMedPon=0;
            $sqlCarichi = findMovimentiByArtico($valCarico, $Codice);
            while ($rowMed = mysql_fetch_array($sqlCarichi)) {

                $qtaPerPrezzo = $qtaPerPrezzo + ($rowMed['quanti'] * $rowMed['prezzo']);
                $qtaTot = $qtaTot + $rowMed['quanti'];
            }
            
            if ($qtaTot != 0) {
                $prezzoMedPon = $qtaPerPrezzo / $qtaTot;
                $aggiornaPrezzoMedioMat = aggiornaPrezzoMedioMat($Codice, $prezzoMedPon);
            }
            
            //################# AGGIORNO PREZZO E FORNITORE IN LABORATORIO #####
            $aggiornaLab=aggiornaLabPreForn($Codice,$Fornitore,$PreAcq);
            
            if (!$modificaMatPrima OR !$aggiornaPrezzoMov OR !$aggiornaPrezzoMedioMat OR !$aggiornaLab) {

                rollback();

                echo '<div id="msgErr">' . $msgErroreVerificato . '' . $msgErrContattareAdmin . ' <a href="gestione_materie_prime.php">' . $msgOk . '</a></div>';
            } else {

                commit();

                echo $msgModificaCompletata . ' <a href="gestione_materie_prime.php">' . $msgOk . '</a>';
            }
            ?>
        </div>
    </body>
</html>