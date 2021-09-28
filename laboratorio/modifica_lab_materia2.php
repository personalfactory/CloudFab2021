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
                ini_set(display_errors, 1);
            include('../include/menu.php');
            include('../include/precisione.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('./sql/script.php');
            include('./sql/script_lab_materie_prime.php');
            include('../sql/script_materia_prima.php');
            include('../sql/script_componente.php');
            include('../sql/script_dizionario.php');

//Ricavo i nuovi valori dei campi mandati tramite POST
            $IdMateria = $_POST['IdMateria'];
//La seguente variabile è utile al fine di conoscere la pagina da cui viene richiesto di inserire la nota, 
//la richiesta può provenire dalla pagina "carica_lab_formula" oppure dalla pagina "gestione_lab_materie"
            $PaginaProvenienza = $_POST['PaginaProvenienza'];

            $messaggio = $msgErroreVerificato . '<br />';

            $Prezzo = 0;
            $Note = "";
            $Fornitore = "Assente";
            $UnitaMisura = $valUniMisKg;
            $Descri = "";

            if (isset($_POST['Note'])) {
                $Note = str_replace("'", "''", $_POST['Note']);
            }
            if (isset($_POST['Fornitore'])) {
                $Fornitore = str_replace("'", "''", $_POST['Fornitore']);
            }
            if (isset($_POST['Prezzo'])) {
                $Prezzo = str_replace("'", "''", $_POST['Prezzo']);
            }
            if (isset($_POST['PrezzoBs'])) {
                $PrezzoBs = str_replace("'", "''", $_POST['PrezzoBs']);
            }
            if (!is_numeric($_POST['Prezzo'])) {
                echo '<div id="msgErr">' . $messaggio . ' ' . $msgErrPrezzo . '<br /></div>';
            }
//            if (isset($_POST['Famiglia'])) {
//                $Famiglia = str_replace("'", "''", $_POST['Famiglia']);
//            }
            if (isset($_POST['Descri'])) {
                $Descri = str_replace("'", "''", $_POST['Descri']);
            }
            $DescrizioneOld = $_POST['DescrizioneOld'];

            $TipoFamiglia = $_POST['scegli_target'];
            $Famiglia = "";
            if ($TipoFamiglia == "FamigliaEs") {
                $Famiglia = $_POST['FamigliaEs'];
            } else if ($TipoFamiglia == "FamigliaNu") {
                $Famiglia = str_replace("'", "''", $_POST['FamigliaNu']);
            }

            $PostSottoTipo = $_POST['scegli_sottotipo'];
            $SottoTipo = "";
            if ($PostSottoTipo == "SottoTipoEs") {
                $SottoTipo = $_POST['SottoTipoEs'];
            } else if ($PostSottoTipo == "SottoTipoNu") {
                $SottoTipo = str_replace("'", "''", $_POST['SottoTipoNu']);
            }
            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
            $Codice = $_POST['Codice'];
            $TipoMat = $_POST['TipoMat'];

            
            $Scaffale = "";
            if (isset($_POST['Scaffale']) && trim($_POST['Scaffale']) != "") {
                $Scaffale = str_replace("'", "''", $_POST['Scaffale']);
            }
            
            $Ripiano = "";
            if (isset($_POST['Ripiano']) && trim($_POST['Ripiano']) != "") {
                $Ripiano = str_replace("'", "''", $_POST['Ripiano']);
            }


            $updateMatPrima = true;
            $updateMatInProduzione = true;
            $updateCompInStabilimenti = true;
            $updateServerdbDizionario = true;
//Modifico il record nella tabella corrente [lab_materia_prima] di serverdb
            begin();

            //################ MODIFICA MAT PRIMA LAB ##########################
            $updateMatPrima = updateMateriaPrima($IdMateria, $SottoTipo, $Famiglia, $Descri, $Note, $Fornitore, $Prezzo,$PrezzoBs, $UnitaMisura, $IdAzienda,$Scaffale,$Ripiano);

            if ($DescrizioneOld != $Descri) {
                //################ MODIFICA MAT PRIMA IN PRODUZIONE ################
                $updateMatInProduzione = aggiornaDescriMat($Codice, $Descri);

                if (substr($Codice, 0, 4) == $prefissoCodComp) {
                    //################ MODIFICA MAT PRIMA IN STABILIMENTI ##############
                    $updateCompInStabilimenti = aggiornaDescriComp($Codice, $Descri);
                    $IdComp = "";
                    $sqlIdComp = findComponenteByCod($Codice);
                    while ($row = mysql_fetch_array($sqlIdComp)) {

                        $IdComp = $row['id_comp'];
                    }
                    //##################### AGGIORNA SUL DIZIONARIO ##################
                    //Se la descrizione modificata era già stato caricata sul dizionario, 
                    //allora bisogna andare a modificarla anke nel dizionario 
                    //il vocabolo deve essere modificato e coincide in tutte le lingue 
                    //finchè non verrà nuovamente tradotto            
                    $updateServerdbDizionario = updateServerDBDizionario($IdComp, $Descri, 4);
                }
                //################## FINE AGGIORNAMENTO DIZIONARIO ################
            }


            if (!$updateMatPrima) {

                rollback();
                if ($PaginaProvenienza == "carica_lab_formula" ||
                        $PaginaProvenienza == "duplica_lab_formula" ||
                        $PaginaProvenienza == "dettaglio_lab_formula") {

                    echo '<div id="msgErr">' . $msgErroreVerificato . '' . $msgErrContattareAdmin . ' <a href="javascript:window.opener.location.reload();window.close();">' . $msgOk . '</a></div>';
                } else {
                    echo '<div id="msgErr">' . $msgErroreVerificato . '' . $msgErrContattareAdmin . ' <a href="gestione_lab_materie.php">' . $msgOk . '</a></div>';
                }
            } else {


                if ($PaginaProvenienza == "carica_lab_formula" ||
                        $PaginaProvenienza == "duplica_lab_formula" ||
                        $PaginaProvenienza == "dettaglio_lab_formula") {

                    echo $msgModificaCompletata . ' <a href="javascript:window.opener.location.reload();window.close();">' . $msgOk . '</a>';
                } else {

                    echo $msgModificaCompletata . ' <a href="gestione_lab_materie.php">' . $msgOk . '</a>';
                }
                commit();
            }
            ?>
        </div>
    </body>


</html>