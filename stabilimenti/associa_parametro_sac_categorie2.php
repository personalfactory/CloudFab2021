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
        
//################## Gestione degli errori sulle query #########################
            $erroreResult = false;
            $sqlCategoria = true;
            $sqlNumSac = true;
            $insertValoreParSac = true;
           


//################## Gestione degli errori sull'input ##########################
//Verifico che il parametro sia stato settato e che non sia vuoto
            $errore = false;
            $messaggio = $msgErroreVerificato.'<br />';

            if (!isset($_POST['Parametro']) || trim($_POST['Parametro']) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - '.$labelOptionParDefault.'!<br />';
            }
//Verifica esistenza
            if (isset($_POST['Parametro']) && trim($_POST['Parametro']) != "") {
                list($IdParametro, $DescriParametro, $ValoreBase) = explode(';', $_POST['Parametro']);

                include('../Connessioni/serverdb.php');
                include('../sql/script_categoria.php');
                include('../sql/script_valore_par_sacchetto.php');
                include('../sql/script_num_sacchetto.php');
                include('../sql/script.php');
                //Bisogna verificare che il parametro non sia associato a tutte le categorie
/*
                $sqlNumCat = mysql_query("SELECT COUNT(id_cat) AS num_cat 
                                            FROM 
                                                categoria ")
                        or die("ERRORE SELECT COUNT FROM categoria: " . mysql_error());
 */               
                $sqlNumCat = selectCountCategorie();
                
                while ($rowNumCat = mysql_fetch_array($sqlNumCat)) {

                    $NumCat = $rowNumCat['num_cat'];
                }
/*
                $sqlCatAssociate = mysql_query("SELECT COUNT(id_cat) AS num_cat_ass
                                            FROM 
                                                valore_par_sacchetto 
                                            WHERE 
						id_par_sac='" . $IdParametro . "'
                                            GROUP BY 
                                                id_cat")
                        or die("ERRORE SELECT COUNT FROM valore_par_sacchetto: " . mysql_error());
 */               
                $sqlCatAssociate = selectCountValParSaccByIdPar($IdParametro);

                while ($rowCatAss = mysql_fetch_array($sqlCatAssociate)) {

                    $NumCatAss = $rowCatAss['num_cat_ass'];
                }

                if (mysql_num_rows($sqlCatAssociate) == $NumCat) {
                    //Se entro nell'if vuol dire che il valore inserito esiste gi� nel db
                    $errore = true;
                    $messaggio = $messaggio . $msgParametroAssociatoCat .'<br />';
                    //potrebbe esserci un problema se dopo si crea un nuovo parametro
                }
            }


            $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';


            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {


                //################## INIZIO TRANSAZIONE ####################################
                //Per ogni categoria ricavo la combinazioni di num_sacchetti associati, 
                //nella tabella num_sacchetto e inserisco tutto nella tab 
                //valore_par_sacchetto con valore base			
                $NCat = 1;
//               $sqlCategoria = mysql_query("SELECT * FROM categoria ORDER BY nome_categoria");
//                        or die("Errore 113: " . mysql_error());

                $sqlCategoria = findAllCategoriaOrderByNome();
                while ($rowCategoria = mysql_fetch_array($sqlCategoria)) {
/*
                    $sqlNumSac = mysql_query("SELECT id_num_sac,num_sacchetti FROM num_sacchetto 
                                            INNER JOIN 
                                                            categoria 
                                                    ON num_sacchetto.id_cat=categoria.id_cat
                                            WHERE 
                                                    num_sacchetto.id_cat='" . $rowCategoria['id_cat'] . "'
                                            ORDER BY num_sacchetti");
//                            or die("Errore 114: " . mysql_error());
*/
                    $sqlNumSac = selectIdNumSacByIdCat($rowCategoria['id_cat']);
                    
                    while ($rowNumSac = mysql_fetch_array($sqlNumSac)) {
                        $IdNumSacchetti = $rowNumSac['id_num_sac'];
                        $NumSacchetti = $rowNumSac['num_sacchetti'];

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
								   " . $IdParametro . ",
									" . $rowCategoria['id_cat'] . ",
									" . $IdNumSacchetti . ",
									" . $i . ",
									'" . $ValoreBase . "',
									1,
									'" . dataCorrenteInserimento() . "')");
//                                    or die("Errore 116: " . mysql_error());
*/
                            $insertValoreParSac = insertNewValoreParSac($IdParametro, $rowCategoria['id_cat'], $IdNumSacchetti, $i, $ValoreBase, dataCorrenteInserimento());
                            
                            $IdValPar=0;
                            /*
                             $sqlIdValPar=mysql_query("SELECT * FROM valore_par_sacchetto
								WHERE
							 	id_par_sac=" . $IdParametro . "
                                                                    AND 
                                                                	id_cat=" . $rowCategoria['id_cat'] );      
*/
                             $sqlIdValPar = findValoreParSacByIdParIdCat($IdParametro, $rowCategoria['id_cat']);
                             
                                                 while ($rowIdVal = mysql_fetch_array($sqlIdValPar)) {
                                                     $IdValPar=$rowIdVal['id_val_par_sac'];
                                                     
                                                 }

                             if (!$insertValoreParSac OR !$sqlNumSac OR !$sqlCategoria) {
                                                                            
                                $erroreResult = true;
                            }
                        }//End for
                    }//End while num sacchetti di una categoria
                    $NCat++;
                }//End while categorie



                if ($erroreResult) {

                    rollback();

                    echo $msgTransazioneFallita." ".$msgErrContattareAdmin;
                    
                    echo "</br>erroreResult : " . $erroreResult;
                    echo "</br>insertValoreParSac : " . $insertValoreParSac;
                    echo "</br>sqlNumSac : " . $sqlNumSac;
                    echo "</br>sqlCategoria : " . $sqlCategoria;
                } else {

                    commit();
                    mysql_close();
                    ?>
                    <script language="javascript">
                        window.location.href="/CloudFab/prodotti/gestione_categorie.php";
                    </script>
        <?php
    }
}//End if($errore) controllo degli input relativo al parametro 
?>

        </div>
    </body>
</html>
