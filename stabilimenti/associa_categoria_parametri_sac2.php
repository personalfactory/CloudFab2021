<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
        <?php include('../include/menu.php');  
        include('../include/gestione_date.php'); 
        
//############## Gestione degli errori sulle query #############################
            $erroreResult = false;
            $sqlPar = true;
            $sqlNumSac = true;
            $insertValoreParSac = true;


//############## Gestione degli errori sull'input ##############################

            $errore = false;
            $messaggio = $msgErroreVerificato.'<br />';

            if (!isset($_POST['Categoria']) || trim($_POST['Categoria']) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - '.$labelOptionCatDefault.'!<br />';
            }
//################### Verifica esistenza #######################################
//Bisogna verificare che la categoria sia associata a tutti i parametri esistenti

            if (isset($_POST['Categoria']) && trim($_POST['Categoria']) != "") {

                list($IdCategoria, $NomeCategoria) = explode(';', $_POST['Categoria']);

                include('../Connessioni/serverdb.php');
                include('../sql/script_valore_par_sacchetto.php');
                include('../sql/script_parametro_sacchetto.php');
                include('../sql/script_num_sacchetto.php');
                include('../sql/script.php');

                ////////////////Controllo che il numero di parametri 
                //associati già associati alla categoria sia diverso dal num totale di parametri

                /*
                $sqlNumPar = mysql_query("SELECT COUNT(id_par_sac) AS num_par 
                                            FROM 
                                                parametro_sacchetto ")
                        or die("ERRORE SELECT COUNT FROM parametro_sacchetto: " . mysql_error());
                */
                $sqlNumPar = selectCountParSac();
                
                while ($rowNumPar = mysql_fetch_array($sqlNumPar)) {

                    $NumPar = $rowNumPar['num_par'];
                }
/*
                $sqlParAssociati = mysql_query("SELECT COUNT(id_par_sac) AS num_par_ass
                                            FROM 
                                                valore_par_sacchetto 
                                            WHERE 
						id_cat='" . $IdCategoria . "'
                                            GROUP BY 
                                                id_par_sac")
                        or die("ERRORE SELECT COUNT FROM valore_par_sacchetto: " . mysql_error());
 */               
                $sqlParAssociati = selectCountValParSaccByIdCat($IdCategoria);
            
                while ($rowParAss = mysql_fetch_array($sqlParAssociati)) {

                    $NumParAss = $rowParAss['num_par_ass'];
                }

//                if ($NumParAss == $NumPar) {
                if (mysql_num_rows($sqlParAssociati) == $NumPar) {
                    //Se entro nell'if vuol dire che il valore inserito esiste gi� nel db
                    $errore = true;

                    $messaggio = $messaggio . $msgErrCatGiaAssociataAiPar .'<br />';
                    //potrebbe esserci un problema se dopo si crea un nuovo parametro
                }
            }
            //################### FINE Verifica esistenza ###################################
            
            $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {

                //############ INIZIO TRANSAZIONE ##############################

                begin();

                //Ricavo le varie soluzioni di num_sacchetti associati alla categoria, 
                //nella tabella [num_sacchetto] e inserisco tutto nella tab [valore_par_sacchetto] con valore base			
                $NPar = 1;
//                $sqlPar = mysql_query("SELECT * FROM parametro_sacchetto ORDER BY nome_variabile");
//                        or die("ERRORE SELECT FROM parametro_sacchetto : " . mysql_error());

                $sqlPar = findAllParSacchettoOrderByNome();
                while ($rowPar = mysql_fetch_array($sqlPar)) {
/*
                    $sqlNumSac = mysql_query("SELECT id_num_sac,num_sacchetti 
                                            FROM 
                                                num_sacchetto 
                                            INNER JOIN 
						categoria 
					    ON 
                                                num_sacchetto.id_cat=categoria.id_cat
                                            WHERE 
						num_sacchetto.id_cat='" . $IdCategoria . "'
                                            ORDER BY 
                                                num_sacchetti");
//                            or die("ERRORE SELECT FROM num_sacchetto : " . mysql_error());
 * 
 */

                    $sqlNumSac = selectIdNumSacByIdCat($IdCategoria);

                    while ($rowNumSac = mysql_fetch_array($sqlNumSac)) {

                        $IdNumSacchetti = $rowNumSac['id_num_sac'];
                        $NumSacchetti = $rowNumSac['num_sacchetti'];
                        //Per ogni parametro presente nella tab [parametro_sacchetto] 
                        //e per ogni soluzione di num_sacchetti associata alla categoria 
                        //nella tab [num_sacchetti] si esegue il ciclo seguente
                        for ($i = 1; $i <= $NumSacchetti; $i++) {

                            //Salvo i valori  nella tabella valore_par_sacchetto
                            /*
                            $insertValoreParSac = mysql_query("INSERT INTO valore_par_sacchetto
                                                (	
                                                id_par_sac,
                                                id_cat,
                                                id_num_sac,
                                                sacchetto,
                                                valore_variabile,
                                                abilitato,
                                                dt_abilitato)
                                        VALUES(
                                            " . $rowPar['id_par_sac'] . ",
                                                " . $IdCategoria . ",
                                                " . $IdNumSacchetti . ",
                                                " . $i . ",
                                                '" . $rowPar['valore_base'] . "',
                                                1,
                                                '" . dataCorrenteInserimento() . "')");
//                                    or die("ERRRORE INSERT valore_par_sacchetto : " . mysql_error());
*/
                            $insertValoreParSac = insertNewValoreParSac($rowPar['id_par_sac'], $IdCategoria, $IdNumSacchetti, $i, $rowPar['valore_base'], dataCorrenteInserimento());
                            if (!$insertValoreParSac) {
                                $erroreResult = true;
                            }
                        }//End for
                    }//End while num sacchetti di una categoria
                    $NPar++;
                }//End while parametri

                if ($erroreResult
                        OR !$sqlPar
                        OR !$sqlNumSac) {

                    rollback();

                    echo $msgTransazioneFallita." ".$msgErrContattareAdmin;
                    echo "</br>erroreResult : " . $erroreResult;
                    echo "</br>sqlPar : " . $sqlPar;
                    echo "</br>sqlNumSac : " . $sqlNumSac;
                    echo "</br>insertValoreParSac : " . $insertValoreParSac;
                
                    
                } else {

                    commit();
                    mysql_close();
                    ?>
                    <script language="javascript">
                       window.location.href="modifica_valore_categoria.php?IdCategoria=<?php echo $IdCategoria ?>";
                    </script>
                    <?php
                }
            }//End if($errore) controllo degli input relativo al parametro 
            ?>

        </div>
    </body>
</html>
