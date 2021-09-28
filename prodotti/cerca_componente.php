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
            include ('../sql/script_componente.php');
           
            //############## PRIMA RICERCA #################################
            //Recupero il valore dal post e lo salvo nella variabile di sessione
            if (isset($_POST['key']) && $_POST['key'] != "") {
                $key = trim($_POST['key']);
                $_SESSION['key'] = $key;
                //######### NESSUNA PAROLA DIGITATA ############################    
            } else if ($_SESSION['key'] == "") {
                echo $msgNessunRisultato . ' <a href="gestione_componenti.php">' . $msgTornaAiComponenti . '</a>';
            }

            //##################### ORDINAMENTO #########################
            $Filtro = "cod_componente";
            if (isset($_GET['NomeCampo']) && $_GET['NomeCampo'] != "") {

                $Filtro = $_GET['NomeCampo'];
            }
            //###########################################################
/*
            $query = "SELECT * FROM componente
                                    
			WHERE 
                                   (id_comp LIKE '%" . $_SESSION['key'] . "%')
                                OR (cod_componente LIKE '%" . $_SESSION['key'] . "%') 
				OR (descri_componente LIKE '%" . $_SESSION['key'] . "%')
				OR (dt_abilitato LIKE '%" . $_SESSION['key'] . "%')
                       ORDER BY 
                            " . $Filtro;

            $sql = mysql_query($query, $connessione) or die(mysql_error($connessione));
 */          
            $sql = findComponenteByKey($_SESSION['key'], $Filtro);
            
            $trovati = mysql_num_rows($sql);

            if ($trovati > 0) {
                echo "<br/>$msgTrovate $trovati $msgVociPerTermine <b>" . stripslashes($_SESSION['key']) . "</b></p>\n";
                ?>
                <a href="gestione_componenti.php"><?php echo $linkMostraTutti ?> </a>
                <?php
                include('./moduli/visualizza_componenti.php');
            } else {
                // Notifica in caso di mancanza di risultati
                echo $msgNessunRisultato . ' <a href="gestione_componenti.php">' . $msgTornaAiComponenti . '</a>';
            }
            ?>

        </div>
    </body>
</html>


