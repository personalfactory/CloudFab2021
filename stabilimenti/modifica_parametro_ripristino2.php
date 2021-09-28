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
   
//######################## RECUPERO POST ######################################
      $IdParametroOld = $_POST['IdParametroOld'];
      $IdParametro = $_POST['IdParametro'];
      $NomeVariabile = str_replace("'", "''", $_POST['NomeVariabile']);
      $DescriVariabile = str_replace("'", "''", $_POST['DescriVariabile']);

///############## CONTROLLO INPUT DATI MODIFICATI ###############################

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

//Verifica esistenza 
      include('../Connessioni/serverdb.php');
      include('../sql/script_parametro_ripristino.php');
      include('../sql/script_valore_ripristino.php');
      
/*
      $query = "SELECT * FROM parametro_ripristino 
			WHERE 
					 id_par_ripristino= " . $IdParametro . "
        AND
          nome_variabile ='" . $NomeVariabile . "'
        AND
          descri_variabile='" . $DescriVariabile . "'";
      $result = mysql_query($query, $connessione) or die("ERRORE 1 SELECT FROM serverdb.parametro_ripristino : " . mysql_error());
*/
      
      $result = findParRipristinoByIdNomeDescri($IdParametro, $NomeVariabile, $DescriVariabile, $connessione);

      if (mysql_num_rows($result) != 0) {
        //Se entro nell'if vuol dire che il valore inserito esiste gi� nel db
        $errore = true;
        $messaggio = $messaggio . $msgDuplicaRecord .'<br />';
      }

      mysql_close();

      $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
      
      if ($errore) {
        //Ci sono errori quindi non salvo
        echo $messaggio;
      } else {
        
        //############################################################################
        //######################### STORICIZZO #######################################
        //############################################################################
        include('../Connessioni/storico.php');
        include('../Connessioni/serverdb.php');
        /*
        mysql_query("INSERT INTO storico.parametro_ripristino				 										
								(id_par_ripristino,
								nome_variabile,
								descri_variabile,
								abilitato,
								dt_abilitato) 
							SELECT 
								id_par_ripristino,
								nome_variabile,
								descri_variabile,
								abilitato,
								dt_abilitato
							FROM 
								serverdb.parametro_ripristino
							WHERE 
								id_par_ripristino='" . $IdParametroOld . "'")
        or die("ERRORE 2 INSERT INTO storico.parametro_ripristino: " . mysql_error());
        */
        insertStoricoParRipristino($idParametro);

        //############################################################################
        //######################### MODIFICO SU SERVERDB #############################
        //############################################################################
        /*
        mysql_query("UPDATE serverdb.parametro_ripristino 
						SET 
            id_par_ripristino =" . $IdParametro . ",
							nome_variabile='" . $NomeVariabile . "',
							descri_variabile='" . $DescriVariabile . "',
							dt_abilitato='" . dataCorrenteInserimento() . "'
						WHERE 
							id_par_ripristino='" . $IdParametroOld . "'")
        or die("ERRORE 3 UPDATE serverdb.parametro_ripristino: " . mysql_error());
        */
        
        updateServerDBParRipristino($IdParametro, $NomeVariabile, $DescriVariabile, dataCorrenteInserimento(), $IdParametroOld);


        //####### DA TESTARE #################################################
        /*
        mysql_query("UPDATE serverdb.valore_ripristino 
						SET 
              id_par_ripristino = " . $IdParametro . "
						WHERE 
							id_par_ripristino='" . $IdParametroOld . "'")
                or die("ERRORE 4 UPDATE serverdb.valore_ripristino : " . mysql_error());
        */        
        updateIdParRipristino($IdParametro, $IdParametroOld);
        
        mysql_close();

        echo $msgModificaCompletata.' <a href="gestione_parametri_ripristino.php">'.$msgTornaAiParRipristino.'</a>';
      }
      ?>
    </div>
  </body>
</html>