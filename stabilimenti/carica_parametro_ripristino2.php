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
    
//####################### CONTROLLO INPUT ######################################
      
            $errore = false;
            $erroreEs=false;
      		$messaggio = $msgErroreVerificato.'<br/>';
      		$messaggioEs = $msgErroreVerificato.'<br/>';
            
            if (!isset($_POST['IdParametro']) || trim($_POST['IdParametro']) == "") {

                $errore = true;
        		$messaggio = $messaggio . $msgErrCampoIdParVuoto.'<br />';
            }
            if (!isset($_POST['NomeParametro']) || trim($_POST['NomeParametro']) == "") {

                $errore = true;
        		$messaggio = $messaggio . $msgErrCampoNomeParVuoto.'<br />';
            }
            if (!isset($_POST['DescriParametro']) || trim($_POST['DescriParametro']) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErrCampoDescriParVuoto.'<br />';
            }
            //Verifica tipo di dati
            if (!is_numeric($_POST['IdParametro'])) {

                $errore = true;
                $messaggio = $messaggio . ' - '.$filtroId .$msgErrDeveEssereIntero.'<br />';
            }
      

/*
      $query = "SELECT * FROM parametro_ripristino 
                WHERE 
                  id_par_ripristino=" . $IdParametro . " 
                OR 
                  nome_variabile = '" . $NomeParametro . "'";

      $result = mysql_query($query, $connessione) or die("ERRORE 1 SELECT FROM serverdb.parametro_ripristino:" . mysql_error());
     */ 
      	if ($errore) {
      		echo  $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
      	
      	} else { //Non ci sono errori quindi salvo
      		
      		//Apro la connessione al db
      		include('../Connessioni/serverdb.php');
      		include('../sql/script_parametro_ripristino.php');
      		include('../sql/script_valore_ripristino.php');
      	
   			$IdParametro = $_POST['IdParametro'];
  			$NomeParametro = str_replace("'", "''", $_POST['NomeParametro']);
   			$DescriParametro = str_replace("'", "''", $_POST['DescriParametro']);
      	
      	
      		$result = findParRipristinoByIdOrNome($IdParametro, $NomeParametro, $connessione);
      		 
      		if (mysql_num_rows($result) != 0) {
      			//Se entro nell'if vuol dire che esiste
      			$erroreEs = true;
      			$messaggioEs = $messaggioEs . $msgDuplicaRecord .'<br />';
      		}
      		 
      		if($erroreEs){
      	
      			echo $messaggioEs. '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
      	
      	
      		} else {
      
//###################### SALVATAGGIO NEL DB ####################################
       
/*
        mysql_query("INSERT INTO parametro_ripristino (id_par_ripristino,nome_variabile,descri_variabile,abilitato,dt_abilitato) 
				VALUES ( 
            " . $IdParametro . ",
            '" . $NomeParametro . "',
						'" . $DescriParametro . "',
						1,
						'" . dataCorrenteInserimento() . "')")
                or die("ERRORE 2 INSERT INTO serverdb.parametro_ripristino:" . mysql_error());
*/                
        insertNewParRipristino($IdParametro, $NomeParametro, $DescriParametro, dataCorrenteInserimento());

        //N.B. La data di registrazione, l'id del processo in corso e il valore li comunica la macchina durante l'aggiornamento
       /*
       mysql_query("INSERT INTO valore_ripristino (id_par_ripristino,id_macchina,abilitato,dt_abilitato) 
						SELECT  
							parametro_ripristino.id_par_ripristino,
							macchina.id_macchina,
							1,
							'" . dataCorrenteInserimento() . "'
						FROM 
							parametro_ripristino,macchina
						WHERE 
							parametro_ripristino.nome_variabile='" . $NomeParametro . "'")
                or die("ERRORE 3 INSERT INTO serverdb.valore_ripristino: " . mysql_error());
       */
        
//        insertValRipristino($NomeParametro, dataCorrenteInserimento());
        
        mysql_close();

//        echo('Inserimento completato con successo! <a href="gestione_parametri_ripristino.php">Torna ai Parametri di Ripristino</a>');

      ?>

       <script language="javascript">
        window.location.href="/CloudFab/stabilimenti/gestione_parametri_ripristino.php";
      </script>
      <?php 
      		      }
    }?>
      
    </div>
  </body>
</html>
