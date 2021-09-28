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
            include('../Connessioni/serverdb.php');
            include('./include/costo_lotto.php');

            //############## PRIMA RICERCA #################################
            //Recupero il valore dal post e lo salvo nella variabile di sessione
            if (isset($_POST['key']) && $_POST['key'] != "") {
                $key = trim($_POST['key']);
                $_SESSION['key'] = $key;
                //######### NESSUNA PAROLA DIGITATA ############################    
            } else if ($_SESSION['key'] == "") {
                echo 'NESSUN RISULTATO! <a href="gestione_costo_lotto.php">MOSTRA REPORT</a>';
            }


            //##################### ORDINAMENTO #########################
//                $Filtro = "cod_formula";
//                if (isset($_GET['NomeCampo']) && $_GET['NomeCampo'] != "") {
//
//                    $Filtro = $_GET['NomeCampo'];
//                }
            //###########################################################

            if (preg_match("/^[a-z0-9]+$/i", $_SESSION['key'])) {

                $query = "SELECT * FROM serverdb.formula 
                              WHERE 
				(cod_formula LIKE '%" . $_SESSION['key'] . "%') 
                                OR 	
                                (descri_formula LIKE '%" . $_SESSION['key'] . "%')";

                $row_Formula = mysql_query($query, $connessione) or die(mysql_error($connessione));
                $trovati = mysql_num_rows($row_Formula);

                if ($trovati > 0) {
                    echo "<br/>Trovate $trovati voci per il termine <b>" . stripslashes($_SESSION['key']) . "</b></p>\n";
                    ?>
                    <a href="gestione_costo_lotto.php">MOSTRA TUTTO</a>

                    <!--########################################################################################################-->                       

                    <?php
                    ('./moduli/visualizza_costo_lotto.php');
                    //###############################################################################################################
                } else {
                    // Notifica in caso di mancanza di risultati
                    echo 'NESSUN RISULTATO! <a href="gestione_costo_lotto.php">TORNA ALLE FORMULE</a>';
                }
            }
            ?>

        </div>
    </body>
</html>


