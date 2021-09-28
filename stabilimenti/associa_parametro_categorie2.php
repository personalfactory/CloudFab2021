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
            include('../sql/script_valore_par_prod.php');
            include('../sql/script.php');
            include('../sql/script_categoria.php');

//################## ERRORI SULLA TRANSAZIONE ##################################
            $insertAssCat = true;
            $selectCategorie = true;
            $erroreResult = false;
//################## GESTIONE DEGLI ERRORI SULL' INPUT #########################

            $errore = false;
            $ErroreValore = 0;

            $messaggio = $msgErroreVerificato . '<br />';
            $messaggioVal = $msgErroreVerificato . '<br />';

            if (!isset($_GET['ParametroProdotto']) || trim($_GET['ParametroProdotto']) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $labelOptionParDefault . '!<br />';
            }

            //Verifica esistenza
            //Se è stato settato il parametro ne verifico l'esistenza 
            //Apro la connessione al db
            if (isset($_GET['ParametroProdotto']) && trim($_GET['ParametroProdotto']) != "") {

                list($IdParametro, $DescriParametro, $ValoreBase) = explode(';', $_GET['ParametroProdotto']);

                include('../Connessioni/serverdb.php');
                /*
                  $query = "SELECT * FROM valore_par_prod
                  WHERE
                  id_par_prod = " . $IdParametro;

                  $result = mysql_query($query, $connessione) or die("Errore 114: " . mysql_error());
                 */
                $result = findValoreParProdByIdPar($IdParametro, $connessione);

                if (mysql_num_rows($result) != 0) {
                    //Se entro nell'if vuol dire che il valore inserito esiste gi� nel db
                    $errore = true;
                    $messaggio = $messaggio . $msgParametroAssociatoCat . '<br />';
                    //potrebbe esserci un problema se dopo si crea una nuova categoria
                }
            }
            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {

                //Ricavo l'elenco delle categorie			
                $NCat = 1;
                /*
                  $sql = mysql_query("SELECT * FROM categoria ORDER BY nome_categoria")
                  or die("Errore 113: " . mysql_error());
                 */
                $sql = findAllCategoriaOrderByNome();

                while ($row = mysql_fetch_array($sql)) {

                    $Valore = $_GET['Valore' . $NCat];

//                    //Effettuo il controllo input del valore
//                    if (!is_numeric($Valore)) {
//                        $ErroreValore++;
//                        $messaggioVal = $messaggioVal . " " . $filtroValore . ' : ' . $row['nome_categoria'] . ' ' . $msgNumerico . "<br />";
//                    }
                    if (trim($Valore) == "") {
                        $ErroreValore++;
                        $messaggioVal = $messaggioVal . " " . $filtroValore . ' : ' . $row['nome_categoria'] . ' ' . $msgVuoto . "<br />";
                    }
                    $NCat++;
                }
                $messaggioVal = $messaggioVal . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

                if ($ErroreValore > 0) {
                    //Ci sono errori quindi non salvo
                    echo $messaggioVal;
                } else {

                    //################### INIZIO TRANSAZIONE ####################

                    begin();

                    //Vado avanti perch� non ci sono errori
                    //Ricavo l'elenco delle categorie			
                    $NCat = 1;
                    /*
                      $selectCategorie = mysql_query("SELECT * FROM categoria ORDER BY nome_categoria")
                      or die("Errore 113: " . mysql_error());
                     */
                    $selectCategorie = findAllCategoriaOrderByNome();

                    while ($row = mysql_fetch_array($selectCategorie)) {

                        $Valore = $_GET['Valore' . $NCat];

                        //Salvo i valori  nella tabella valore_par_prod
                        /*
                          $insertAssCat = mysql_query("INSERT INTO valore_par_prod
                          (id_par_prod,
                          id_cat,
                          valore_variabile,
                          abilitato,
                          dt_abilitato)
                          VALUES("
                          . $IdParametro . ","
                          . $row['id_cat'] . ","
                          . $Valore . ",
                          1,'"
                          . dataCorrenteInserimento() . "')")
                          or die("Errore 116: " . mysql_error());
                         */
                        $insertAssCat = insertValoreParProd($IdParametro, $row['id_cat'], $Valore, dataCorrenteInserimento());

                        if (!$insertAssCat) {
                            $erroreResult = true;
                        }

                        $NCat++;
                    }// end while finite le categorie 

                    if ($erroreResult OR !$selectCategorie) {

                        rollback();
                        echo $msgTransazioneFallita . "! " . $msgErrContattareAdmin;
                    } else {

                        commit();
                        mysql_close();
                        ?>
                        <script language="javascript">
                            window.location.href = "/CloudFab/stabilimenti/gestione_valori_par_prod.php";
                        </script>
                        <?php
                    }
                }
            }
            ?>
        </div>
    </body>
</html>
