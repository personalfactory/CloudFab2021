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
     // ini_set(display_errors,"1");
//######################## RECUPERO POST ######################################

      $IdParametroOld = $_POST['IdParametroOld'];
      $IdParametro = $_POST['IdParametro'];
      $NomeVariabile = str_replace("'", "''", $_POST['NomeVariabile']);
      $DescriVariabile = str_replace("'", "''", $_POST['DescriVariabile']);
      $ValoreBase = str_replace("'", "''", $_POST['ValoreBase']);

//############## CONTROLLO INPUT DATI MODIFICATI ###############################

      $errore = false;
      $messaggio = $msgErroreVerificato.'<br/>';
      
      if (!isset($IdParametro) || trim($IdParametro) == "") {

        $errore = true;
        $messaggio = $messaggio . $msgErrCampoIdParVuoto.'<br />';
      }
      if (!isset($NomeVariabile) || trim($NomeVariabile) == "") {

        $errore = true;
        $messaggio = $messaggio . $msgErrCampoNomeParVuoto.'<br />';
      }
      if (!isset($DescriVariabile) || trim($DescriVariabile) == "") {

        $errore = true;
        $messaggio = $messaggio . $msgErrCampoDescriParVuoto.'<br />';
      }
      //Verifica tipo di dati
      if (!is_numeric($IdParametro)) {

        $errore = true;
        $messaggio = $messaggio . ' - '.$filtroId .$msgErrDeveEssereIntero.'<br />';
      }

//##################### VERIFICA ESISTENZA #####################################
      include('../Connessioni/serverdb.php');
      include('../sql/script_parametro_sing_mac.php');
      include('../sql/script_valore_par_sing_mac.php');
      
      
/*
      $result = mysql_query("SELECT * FROM parametro_sing_mac 
			WHERE 
				id_par_sm = " . $IdParametro . "
      AND 
				nome_variabile ='" . $NomeVariabile . "'
      AND
        descri_variabile='" . $DescriVariabile . "'");
*/	
      $result = findParSMByIdNomeDescri($IdParametro, $NomeVariabile, $DescriVariabile,$ValoreBase);
      
      if (mysql_num_rows($result) != 0) {
        //Se entro nell'if vuol dire che il valore inserito esiste gi� nel db
        $errore = true;
        $messaggio = $messaggio . $msgDuplicaRecord .'<br />';
      }

      if ($IdParametro != $IdParametroOld) {

      //  $result2 = mysql_query("SELECT * FROM parametro_sing_mac WHERE id_par_sm = " . $IdParametro);
        
        $result2 = findParSMById($IdParametro);

        if (mysql_num_rows($result2) != 0) {
          //Se entro nell'if vuol dire che il valore inserito esiste gi� nel db
          $errore = true;
          $messaggio = $messaggio . $msgErrIdParEsistente.'<br/>';
        }
      }




      $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
      
      if ($errore) {
        //Ci sono errori quindi non salvo
        echo $messaggio;
      } else {

        //############################################################################
        //######################### STORICIZZO #######################################
        //############################################################################
        //Inserisco il vecchio record nello storico prima di modificarlo nella tabella corrente su serverdb
        include('../Connessioni/storico.php');
/*
        mysql_query("INSERT INTO storico.parametro_sing_mac					 										
								(id_par_sm,
								nome_variabile,
								descri_variabile,
								valore_base,
								abilitato,
								dt_abilitato) 
							SELECT 
								id_par_sm,
								nome_variabile,
								descri_variabile,
								valore_base,
								abilitato,
								dt_abilitato
							FROM 
								serverdb.parametro_sing_mac
							WHERE 
								id_par_sm='" . $IdParametroOld . "'") or die("ERRORE 2 INSERT INTO storico.parametro_sing_mac	: " . mysql_error());
*/
        insertStoricoParSM($IdParametroOld);
        // Seleziono i record relativi al parametro che si vuole modificare dalla tabella [valore_par_sing_mac] e 					 		memorizzo il contenuto dei vari campi per poi storicizzarli
/*
        $queryValParSm = "SELECT 	
							id_val_par_sm,
							id_par_sm,
							id_macchina,
							valore_variabile
						FROM 
							serverdb.valore_par_sing_mac 
						WHERE 
							id_par_sm=" . $IdParametroOld;

        $sqlValParSm = mysql_query($queryValParSm, $connessione) or die("ERRORE 3 SELECT FROM serverdb.valore_par_sing_mac : " . mysql_error());
		*/
        
        $sqlValParSm  = selectIdValSMById($IdParametroOld, $connessione);
        
        while ($rowValParSm = mysql_fetch_array($sqlValParSm)) {

          $IdValParSm = $rowValParSm['id_val_par_sm'];
          $IdMacchina = $rowValParSm['id_macchina'];
          $ValoreVariabile = $rowValParSm['valore_variabile'];


          // 	Inserisco nello storico dei valori parametri singola macchina i vecchi record 

       /*mysql_query("INSERT INTO storico.valore_par_sing_mac	
									(id_val_par_sm,
									id_par_sm,
									id_macchina,
									valore_variabile,
									abilitato,
									dt_abilitato)
								VALUES(
									   " . $IdValParSm . ",
									   '" . $IdParametroOld . "',
									   '" . $IdMacchina . "',
									   '" . $ValoreVariabile . "',
									   0,
									   '" . dataCorrenteInserimento() . "')") or die("ERRORE 4  INSERT INTO storico.valore_par_sing_mac : " . mysql_error());
        
		*/
        
        insertStoricoValoreParSM($IdValParSm, $IdParametroOld, $IdMacchina, $ValoreVariabile, "0",dataCorrenteInserimento());
        }
      //  insertStoricoValoreParSM($IdValParSm, $IdParametroOld, $IdMacchina, $ValoreVariabile, dataCorrenteInserimento());
      
      //    insertIntoValParCompStorico($IdValParSm, $IdParametroOld, $IdMacchina, $ValoreVariabile, 0, dataCorrenteInserimento());
        //############################################################################
        //######################### MODIFICO SU SERVERDB #############################
        //############################################################################
        /*
        mysql_query("UPDATE serverdb.parametro_sing_mac 
						SET 
              id_par_sm=" . $IdParametro . ",
							nome_variabile='" . $NomeVariabile . "',
							descri_variabile='" . $DescriVariabile . "',
							valore_base='" . $ValoreBase . "',
							dt_abilitato='" . dataCorrenteInserimento() . "'
						WHERE 
							id_par_sm='" . $IdParametroOld . "'") or die("ERRORE 5 UPDATE serverdb.parametro_sing_mac : " . mysql_error());
*/
       updateServerDBParSM($IdParametro, $NomeVariabile, $DescriVariabile, $ValoreBase, dataCorrenteInserimento(), $IdParametroOld);

        mysql_close();

        echo $msgModificaCompletata.' <a href="gestione_parametri_singola.php">'.$msgTornaAiPar.'</a>';
      
      }
      ?>
    </div>
  </body>
</html>