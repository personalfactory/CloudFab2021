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


//gestione degli errori
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
            if (!isset($_POST['ValoreBase']) || trim($_POST['ValoreBase']) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErrCampoValBaseVuoto.'<br />';
            }
            //Verifica tipo di dati
            if (!is_numeric($_POST['IdParametro'])) {

                $errore = true;
                $messaggio = $messaggio . ' - '.$filtroId .$msgErrDeveEssereIntero.'<br />';
            }

//Verifica esistenza

/*
      $query = "SELECT * FROM parametro_sacchetto 
          WHERE 
            id_par_sac=" . $IdParametro . " 
          OR 
            nome_variabile = '" . $NomeParametro . "'";


      $result = mysql_query($query, $connessione) or die("ERRORE 1 SELECT FROM serverdb.parametro_sacchetto : " . mysql_error());
  */    

      	if ($errore) {
      		 
      		//####################### RECUPERO POST ########################################
      		//Ci sono errori quindi non salvo
      		echo  $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
      	
      	} else { //Non ci sono errori quindi salvo
      	
//####################### RECUPERO POST ########################################

      $IdParametro = $_POST['IdParametro'];
      $NomeParametro = str_replace("'", "''", $_POST['NomeParametro']);
      $DescriParametro = str_replace("'", "''", $_POST['DescriParametro']);
      $ValoreBase = str_replace("'", "''", $_POST['ValoreBase']);
      	
      
      
      //Apro la connessione al db
      include('../Connessioni/serverdb.php');
      include('../sql/script_parametro_sacchetto.php');
      	
      		$result = findParSacchettoByIdNome($IdParametro, $NomeParametro, $connessione);
      		 
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
        mysql_query("INSERT INTO parametro_sacchetto (id_par_sac,nome_variabile,descri_variabile,valore_base,abilitato,dt_abilitato) 
				VALUES ( 
            " . $IdParametro . ",
            '" . $NomeParametro . "',
						'" . $DescriParametro . "',
						'" . $ValoreBase . "',
						1,
						'" . dataCorrenteInserimento() . "')")
                or die("ERRORE 2 INSERT INTO SERVERDB.parametro_sacchetto" . mysql_error());
*/                
       insertNewParSacchetto($IdParametro, $NomeParametro, $DescriParametro, $ValoreBase, dataCorrenteInserimento());

        /* //Memorizzo l'id_par_sac del parametro appena creato per passarlo alla pagina associa parametro a categorie per riferimento
          $sqlPar=mysql_query("SELECT id_par_sac FROM parametro_sacchetto WHERE nome_variabile='".$NomeParametro."'")
          or die("Errore: 132".mysql_error());

          while($rowParametro=mysql_fetch_array($sqlPar)){
          $IdParametro=$rowParametro['id_par_sac'];
          }

          mysql_close(); */

        echo $msgInserimentoCompletato.' '
        ?>
              <a href="associa_parametro_sac_categorie.php"><?php echo $msgAssociaIlParAlleCat?></a>
        <br/>

<?php }
      	} ?>
        
    </div>
  </body>
</html>
