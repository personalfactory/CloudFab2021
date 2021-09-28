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
        
            $Lingua = str_replace("'", "''", $_POST['Lingua']);

//gestione degli errori
            $errore = false;
            $messaggio = $msgErroreVerificato.'<br />';
            
            $query = true;
            $query2 = true;


            if (!isset($Lingua) || trim($Lingua) == "") {

                $errore = true;
                $messaggio = $messaggio . ' '.$msgErrCampoLinguaVuoto.'<br />';
            }
//Verifica esistenza
//Apro la connessione al db
            include('../Connessioni/serverdb.php');
            include('../sql/script_lingua.php');
            include('../sql/script_dizionario.php');
            include('../sql/script.php');

			/*
            $query = "SELECT * FROM lingua WHERE lingua = '" . $Lingua . "'";
            $result = mysql_query($query, $connessione) or die(mysql_error());
            */
            $result = findLinguaByLingua($Lingua, $connessione);

            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che esiste
                $errore = true;
                $messaggio = $messaggio . ' '.$msgDuplicaRecord.'<br />';
            }

            mysql_close();

            $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
            

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {
                //Inserisco perch� non ci sono errori
                include('../Connessioni/serverdb.php');

                begin();
                /*
                $query = "INSERT INTO lingua (lingua,abilitato,dt_abilitato) 
				VALUES ( 
						'" . $Lingua . "',
						1,
						'" . dataCorrenteInserimento() . "')";
                mysql_query($query, $connessione) or die("Errore 140 :" . mysql_error());
				*/
                $query = insertLingua($Lingua, dataCorrenteInserimento(), $connessione);
                /*
                $query2 = mysql_query("INSERT INTO dizionario (
                                        id_lingua,
                                        id_diz_tipo,
                                        id_vocabolo,
                                        vocabolo,
                                        dt_abilitato) 
				 SELECT 
				 		lingua.id_lingua,
					 	dizionario.id_diz_tipo,
						id_vocabolo,
						vocabolo,
					 	'" . dataCorrenteInserimento() . "'
				 FROM 
				 		lingua,dizionario
				WHERE  
						lingua.lingua='" . $Lingua . "'
						AND
						dizionario.id_lingua=1;");
				*/
//		 or die("Errore 141 :".mysql_error());

                $query2 = insertLinguaIntoDizionario($Lingua, dataCorrenteInserimento());
                
                
                if (!$query OR !$query2) {

                    rollback();
                    echo $msgTransazioneFallita.'! '.$msgErrContactAdmin .'!';
                }
                commit();
                mysql_close();



                echo($msgInserimentoCompletato.'</br><a href="gestione_lingue.php">'.$msgTornaAlleLingue.'</a>');
            }
            ?>
        </div>
    </body>
</html>
