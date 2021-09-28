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
        
            $NomePresa = str_replace("'", "''", $_POST['NomePresa']);
//######################## Gestione errori sulla query #########################
            $insertPresa = true;

//########### Gestione degli errori ############################################
            $errore = false;
            $messaggio = $msgErroreVerificato.'<br />';

            if (!isset($NomePresa) || trim($NomePresa) == "") {

                $errore = true;
                $messaggio = $messaggio .' '.$msgCampoColVuoto.' !<br />';
            }
//Verifica esistenza
//Apro la connessione al db
            include('../Connessioni/serverdb.php');
            include('../sql/script_presa.php');
            include('../sql/script.php');
			
            $result=findPresaByNome($NomePresa);
//            $query = "SELECT * FROM presa WHERE presa = '" . $NomePresa . "'";
//            $result = mysql_query($query, $connessione) or die("ERRORE SELECT FROM presa :" . mysql_error());

            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che esiste
                $errore = true;
                $messaggio = $messaggio . ' '.$msgPresaEsistente.'!<br />';
            }

           

            $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';

		//	echo $errore;
            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {
               
                
                begin();
                
                $insertPresa = insertPresa($NomePresa, dataCorrenteInserimento());
                /*
                $insertPresa = mysql_query("INSERT INTO presa (presa,abilitato,dt_abilitato) 
				VALUES ('" . $NomePresa .
                        "',1,
						   '" . dataCorrenteInserimento() . "')");
//                        or die("ERRORE INSERT INTO presa " . mysql_error());
				*/
                if (!$insertPresa) {

                    rollback();
                    echo $msgTransazioneFallita.'! '.$msgErrContactAdmin .'!';

                    echo "<br/>insertPresa" . $insertPresa;
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
        </div>
    </body>
</html>
