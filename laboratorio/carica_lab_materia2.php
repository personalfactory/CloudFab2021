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
            include('../include/precisione.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('sql/script_lab_materie_prime.php');
            include('../sql/script_parametro_glob_mac.php');
            include('sql/script.php');

            if ($DEBUG)
                ini_set("display_errors", 1);

//##############################################################################
//################### NUOVA MATERIA PRIMA  #####################################
//##############################################################################


            $errore = false;
            $messaggio = $msgErroreVerificato . '<br/>';

            if ((isset($_POST['scegli_tipo']) AND $_POST['scegli_tipo'] == "4") AND ( !isset($_POST['Compound']) OR $_POST['Compound'] == "" OR $_POST['Compound'] == $filtroLabDigitaCod)) {

                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrCodice . '<br />';
            }

            if (!isset($_POST['FamigliaEs']) AND ! isset($_POST['FamigliaNu'])) {

                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrFamiglia . '<br />';
            }

            $Nome = str_replace("'", "''", $_POST['Nome']);
            
            $Nome=strtoupper($Nome);
            
            $UnitaMisura = $valUniMisKg;
            $Note = str_replace("'", "''", $_POST['Note']);

            $Prezzo = 0;
            if (isset($_POST['Prezzo']) && trim($_POST['Prezzo']) != "") {

                $Prezzo = str_replace("'", "''", $_POST['Prezzo']);
            }
            $PrezzoBs = 0;
            if (isset($_POST['PrezzoBs']) && trim($_POST['PrezzoBs']) != "") {

                $PrezzoBs = str_replace("'", "''", $_POST['PrezzoBs']);
            }

            $Fornitore = "";
            if (isset($_POST['Fornitore']) && trim($_POST['Fornitore']) != "") {
                $Fornitore = str_replace("'", "''", $_POST['Fornitore']);
            }

            $Scaffale = "";
            if (isset($_POST['Scaffale']) && trim($_POST['Scaffale']) != "") {
                $Scaffale = str_replace("'", "''", $_POST['Scaffale']);
            }

            $Ripiano = "";
            if (isset($_POST['Ripiano']) && trim($_POST['Ripiano']) != "") {
                $Ripiano = str_replace("'", "''", $_POST['Ripiano']);
            }


            $tipo2 = ""; //RAW MATERIAL - COLOR
            $tipo3 = ""; //DRYMIX - COMPOUND
            //################ CODICE COMPOUND ##############################
            $TipoMt = $_POST['scegli_tipo'];
            $Codice = "";

            switch ($TipoMt) {
                                
                //Nei casi 1,2 e 3 il codice viene generato automaticamente come comp_ _
                case 1 :
                    //DRYMIX
                    $tipo2 = $valTipo2RawMaterial; //RAW MATERIAL
                    $tipo3 = $valTipo3Drymix; //DRYMIX
                    break;
                 
                case 2:
                         
                    //PIGMENT
                    $tipo2 = $valTipo2Pigment; //PIGMENT
                    $tipo3 = $valTipo3Drymix; //DRYMIX
                    break;
                
                case 3:
                    //ADDITIVE
                    $tipo2 = $valTipo2Additivo; //ADDITIVE
                    $tipo3 = $valTipo3Drymix; //DRYMIX
                    break;
                
                case 4:
                    //COMPOUND
                    $Codice = str_replace("'", "''", $_POST['Compound']);
                    $tipo2 = $valTipo2RawMaterial; //RAW MATERIAL
                    $tipo3 = $valTipo3Compound; //COMPOUND
                    break;
                
                default:

                    break;
            }

            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);

            //############ GENERAZIONE DEL CODICE COMP #######################
            //Se il tipo è un componente prodotto
            $maxNumCod = 0;
            if ($TipoMt !=4) {

                $sqlMaxNumCod = estraiMaxNumCodComp("comp");
                while ($rowMaxNumCod = mysql_fetch_array($sqlMaxNumCod)) {
                    $maxNumCod = $rowMaxNumCod['max_num_cod'];
                }
                $Codice = "comp" . ($maxNumCod + 1);
            }


            //######### VERIFICA ESISTENZA #################################
            $result = verificaEsistenzaMatPrima($Codice, $Nome);

            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che esiste
                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrMatPrimaEsistente . '<br />';
            }

            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo '<div id="msgErr">' . $messaggio . '</div>';
            } else {


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

                $insertMatPrima = true;

                begin();

                $insertMatPrima = insertMateriaPrima($Famiglia, $SottoTipo, $Codice, $Nome, dataCorrenteInserimento(), $UnitaMisura, $Prezzo, $PrezzoBs, $Fornitore, $Note, $_SESSION['id_utente'], $IdAzienda, $Scaffale, $Ripiano, $tipo2, $tipo3);

                if (!$insertMatPrima) {

                    rollback();

                    echo '<div id="msgErr">' . $msgErroreVerificato . '' . $msgErrContattareAdmin . ' <a href="gestione_lab_materie.php">' . $msgOk . '</a></div>';
                } else {

                    commit();
                    echo "Materia prima inserita con codice = " . $Codice . "</br>";
                    echo $msgInserimentoCompletato . ' <a href="gestione_lab_materie.php">' . $msgOk . '</a>';
                }
            }//End if errore
            ?>
        </div>
    </body>
</html>
