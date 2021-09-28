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
        
            $CodiceColore = str_replace("'", "''", $_POST['CodiceColore']);
            $NomeColore = str_replace("'", "''", $_POST['NomeColore']);
            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
//################## Gestione errori sulla query ###############################
            $insertColore = true;

//################### Gestione degli errori input ##############################
            $errore = false;
            $messaggio = $msgErroreVerificato.'<br />';

            if (!isset($CodiceColore) || trim($CodiceColore) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgCampoColVuoto.'!<br />';
            }
            if (!isset($NomeColore) || trim($NomeColore) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgCampoNomeColVuoto.'!<br />';
            }

//Verifica esistenza
//Apro la connessione al db
            include('../Connessioni/serverdb.php');
            include('../sql/script_colore.php');
            include('../sql/script.php');
/*
            $query = "SELECT * FROM colore 
                WHERE 
                    nome_colore = '" . $NomeColore . "' 
                OR 
                    cod_colore = '" . $CodiceColore . "'";
            $result = mysql_query($query, $connessione) or die("ERRORE SELECT FROM colore :" . mysql_error());
*/            
            $result = findColoreByNameOrCod($NomeColore, $CodiceColore, $connessione);

            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che esiste
                $errore = true;
                $messaggio = $messaggio . $msgDuplicaRecord.'<br />';
            }

            $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';


            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {

            	$insertColore = insertColore($NomeColore, $CodiceColore, dataCorrenteInserimento(),
                        $_SESSION['id_utente'],$IdAzienda);
            	/*
                $insertColore = mysql_query("INSERT INTO colore (cod_colore, nome_colore,abilitato,dt_abilitato) 
				VALUES ( '" . $CodiceColore .
                        "','" . $NomeColore .
                        "',1,
						   '" . dataCorrenteInserimento() . "')");
//  		 or die("ERRORE INSERT colore : ".mysql_error());  
			*/
                if (!$insertColore) {

                    rollback();
                    echo $msgTransazioneFallita.'! '.$msgErrContattareAdmin.'!';

                    echo "<br/>insertColore" . $insertColore;
                } else {

                    commit();
                    mysql_close();

                    ?>
                   <script language="javascript">
                        window.location.href="associa_mazzetta_colore.php";
                    </script>
  <?php              }
            }
            ?>
        </div>
    </body>
</html>
