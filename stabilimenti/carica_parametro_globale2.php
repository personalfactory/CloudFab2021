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
    

      
//################# CONTROLLO ERRORI SULLE QUERY ###############################
 $insertParGlobale = true;
 
//####################### CONTROLLO INPUT ######################################
     
      
      $errore = false;
      $erroreEs = false;
      $messaggio = $msgErroreVerificato.'<br/>';
      $messaggioES = $msgErroreVerificato.'<br/>';

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
            if (!isset($_POST['Valore']) || trim($_POST['Valore']) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErrCampoValBaseVuoto.'<br />';
            }
            //Verifica tipo di dati
            if (!is_numeric($_POST['IdParametro'])) {

                $errore = true;
                $messaggio = $messaggio . ' - '.$filtroId .$msgErrDeveEssereIntero.'<br />';
            }

//Verifica esistenza
//Apro la connessione al db

/*
      $query = "SELECT * FROM parametro_glob_mac 
                WHERE 
                  id_par_gm=" . $IdParametro . " 
                OR 
                  nome_variabile = '" . $NomeParametro . "'";

      $result = mysql_query($query, $connessione) or die("ERRORE 1 SELECT FROM serverdb.parametro_glob_mac : " . mysql_error());
 */     

      	
      	if ($errore) {
      		 
      		//####################### RECUPERO POST ########################################
      		//Ci sono errori quindi non salvo
      		echo  $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
      	
      	} else { //Non ci sono errori quindi salvo

      		include('../Connessioni/serverdb.php');
      		include('../sql/script_parametro_glob_mac.php');
      		include('../sql/script.php');
      	
      		$IdParametro = $_POST['IdParametro'];
      		$NomeParametro = str_replace("'", "''", $_POST['NomeParametro']);
      		$DescriParametro = str_replace("'", "''", $_POST['DescriParametro']);
      		$Valore = str_replace("'", "''", $_POST['Valore']);
      	
      	
      		$result = findParGlobMacByIdOrNome($IdParametro, $NomeParametro, $connessione);
      		 
      		if (mysql_num_rows($result) != 0) {
      			//Se entro nell'if vuol dire che esiste
      			$erroreEs = true;
      			$messaggioEs = $messaggioEs . $msgDuplicaRecord .'<br />';
      		}
      		 
      		if($erroreEs){
      	
      			echo $messaggioEs. '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
      	      	
      		} else {
      	
   //################### INIZIO TRANSAZIONE SALVATAGGIO NEL DB #################            

          begin();     
 /*         
          $insertParGlobale = mysql_query("INSERT INTO parametro_glob_mac (id_par_gm,nome_variabile,descri_variabile,valore_variabile,abilitato,dt_abilitato) 
				VALUES ( 
                " . $IdParametro . ",
                '" . $NomeParametro .
                "','" . $DescriParametro .
                "','" . $Valore .
                "',1,
		'" . dataCorrenteInserimento() . "')");
    //or die("ERRORE 2 INSERT INTO serverdb.parametro_glob_mac" . mysql_error());
  */  
          $insertParGlobale = insertNewParGlobMac($IdParametro, $NomeParametro, $DescriParametro, $Valore, dataCorrenteInserimento() );
       if (!$insertParGlobale) {

                    rollback();
                    echo $msgTransazioneFallita." ".$msgErrContattareAdmin;
                } else {

                    commit();
                    mysql_close();
                    ?>

      <script language="javascript">
        window.location.href="/CloudFab/stabilimenti/gestione_parametri_globali.php";
      </script>
        
      <?php }
      		
      }
      }?>
    </div>
  </body>
</html>
