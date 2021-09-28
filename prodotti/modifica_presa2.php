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
        
            $IdPresa = $_POST['IdPresa'];
            $NomePresa = str_replace("'", "''", $_POST['NomePresa']);

//################## Gestione errori sulle query ###############################
            $insertStorico = true;
            $updateServerdb = true;

//####### Gestione degli errori relativa ai nuovi dati modificati ##############
            $errore = false;
            $messaggio = $msgErroreVerificato.'<br />';

            if (!isset($NomePresa) || trim($NomePresa) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErroreNome.'!<br />';
            }

//Verifica esistenza
//Apro la connessione al db
            include('../Connessioni/serverdb.php');
            include('../sql/script_presa.php');
            include('../sql/script.php');
          
            $result= findPresaByNomeNonId($IdPresa, $NomePresa, $connessione);

//            $query = "SELECT * FROM presa WHERE presa = '" . $NomePresa . "' AND 
//				id_presa<>" . $IdPresa;
//            $result = mysql_query($query, $connessione) or die("ERRORE SELECT FROM serverdb.presa " . mysql_error());

            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che il valore appena inserito esiste gi�
                $errore = true;
                $messaggio = $messaggio . $msgDuplicaRecord.'!<br />';
            }
            mysql_close();

            $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {
                //Inserisco il vecchio record nello storico prima di modificarlo su serverdb
                include('../Connessioni/storico.php');
                include('../Connessioni/serverdb.php');
                
                $insertStorico = insertStoricoPresa($IdPresa);
                /*
                $insertStorico = mysql_query("INSERT INTO storico.presa 						 										
                                        (id_presa,
                                        presa,
                                        abilitato,
                                        dt_abilitato) 
                                SELECT 
                                        id_presa,
                                        presa,
                                        abilitato,
                                        dt_abilitato
                                FROM 
                                        serverdb.presa
                                WHERE 
                                        id_presa='" . $IdPresa . "'");
//                        or die("ERRORE INSERT storico.presa : " . mysql_error());
				*/
                

             $updateServerdb = updateServerDBPresa($IdPresa, $NomePresa);
       /*         
                $updateServerdb = mysql_query("UPDATE serverdb.presa
						SET 
                                                    presa=if(presa!='" . $NomePresa . "','" . $NomePresa . "',presa)
						WHERE 
							id_presa='" . $IdPresa . "'");
//                        or die("ERRORE UPDATE serverdb.presa : " . mysql_error());
		*/		
                if (!$insertStorico
                        OR !$updateServerdb) {

                    rollback();
                    echo $msgTransazioneFallita.'! '.$msgErrContactAdmin .'!';

                    echo "<br/>insertStorico" . $insertStorico;
                    echo "<br/>updateServerdb" . $updateServerdb;
                } else {

                    commit();
                    mysql_close();
                    ?>
                    <script language="javascript">
                        window.location.href="gestione_prese.php";
                    </script>
                    <?php
                }
            }
            ?>