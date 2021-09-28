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
////Verifica tipo di dati
//if(!is_numeric($ValoreBase)){
//
//	$errore=true;
//	$messaggio=$messaggio.' - Campo Valore deve essere un numero!<br />';
//}
//Verifica esistenza 
//Verifico che non ci sia in tabella un record con gli stessi valori(descrizioni) e con Id diverso da quello che si sta modificando
      include('../Connessioni/serverdb.php');
      include('../sql/script_parametro_sacchetto.php');
      include('../sql/script_valore_par_sacchetto.php');
      
      
/*
      $query = "SELECT * FROM serverdb.parametro_sacchetto 
				WHERE 
					id_par_sac = " . $IdParametro . "
        AND
          nome_variabile ='" . $NomeVariabile . "'
        AND
          descri_variabile='" . $DescriVariabile . "'";

      $result = mysql_query($query, $connessione) or die(" ERRORE 2 SELECT FROM serverdb.parametro_sacchetto :  " . mysql_error());
 */     
      $result = findParSacchettoByIdNomeDescri($IdParametro, $NomeVariabile, $DescriVariabile , $connessione);

      if (mysql_num_rows($result) != 0) {
        //Se entro nell'if vuol dire che il valore inserito esiste gia nel db
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
        mysql_query("INSERT INTO storico.parametro_sacchetto 						 										
								(id_par_sac,
								nome_variabile,
								descri_variabile,
								valore_base,
								abilitato,
								dt_abilitato) 
							SELECT 
								id_par_sac,
								nome_variabile,
								descri_variabile,
								valore_base,
								abilitato,
								dt_abilitato
							FROM 
								serverdb.parametro_sacchetto
							WHERE 
								id_par_sac='" . $IdParametroOld . "'")
                or die("ERRORE 3 INSERT INTO storico.parametro_sacchetto : " . mysql_error());
*/
         insertStoricoParSacchetto($IdParametroOld);
                
        //Seleziono ora i vecchi record presenti nella tabella [valore_par_sacchetto] 
        //relativi all'id_par_sac da modificare;
/*
        $sqlValPar = mysql_query("SELECT   
									valore_par_sacchetto.id_val_par_sac,
									valore_par_sacchetto.id_par_sac,
									valore_par_sacchetto.id_num_sac,
									valore_par_sacchetto.sacchetto,
									valore_par_sacchetto.id_cat,
									valore_par_sacchetto.valore_variabile,
									valore_par_sacchetto.dt_abilitato								
								FROM 
									serverdb.valore_par_sacchetto 
								WHERE 
									id_par_sac=" . $IdParametroOld)
                or die("ERRORE 4 SELECT FROM serverdb.valore_par_sacchetto : " . mysql_error());
 */       
        $sqlValPar = selectValoreParSacByIdParSac($IdParametroOld);

        while ($rowValPar = mysql_fetch_array($sqlValPar)) {
          $IdValorePar = $rowValPar['id_val_par_sac'];
          $IdCategoria = $rowValPar['id_cat'];
          $IdNumSac = $rowValPar['id_num_sac'];
          $Sacchetto = $rowValPar['sacchetto'];
          $Valore = $rowValPar['valore_variabile'];
          $DataAbilitato = $rowValPar['dt_abilitato'];


//	Inserisco i vecchi record appena selezionati nello storico della tabella [valore_par_sacchetto]  
/*
          mysql_query("INSERT INTO storico.valore_par_sacchetto 	
								(id_val_par_sac,id_par_sac,id_num_sac,sacchetto,id_cat,valore_variabile,abilitato,dt_abilitato)
							VALUES(
								   " . $IdValorePar . ",
									" . $IdParametroOld . ",
									" . $IdNumSac . ",
									'" . $Sacchetto . "',
									" . $IdCategoria . ",
									" . $Valore . ",1,
									'" . $DataAbilitato . "')")
                  or die("ERRORE 5 INSERT INTO storico.valore_par_sacchetto : " . mysql_error());
        
*/
       insertStoricoValoreParSac($IdValorePar, $IdParametroOld, $IdCategoria, $IdNumSac, $Sacchetto, $Valore, '1', $DataAbilitato);
        }
        //############################################################################
        //######################### MODIFICO SU SERVERDB #############################
        //############################################################################        
        /*
        mysql_query("UPDATE serverdb.parametro_sacchetto 
						SET 
              id_par_sac=" . $IdParametro . ",
							nome_variabile='" . $NomeVariabile . "',
							descri_variabile='" . $DescriVariabile . "',
							valore_base='" . $ValoreBase . "',
							dt_abilitato='" . dataCorrenteInserimento() . "'
						WHERE 
							id_par_sac=" . $IdParametroOld)
                or die("ERRORE 6 UPDATE serverdb.parametro_sacchetto  : " . mysql_error());
  */      
       updateServerDBParSacchetto($IdParametro, $NomeVariabile, $DescriVariabile, $ValoreBase, dataCorrenteInserimento(), $IdParametroOld);

         //####### DA TESTARE #################################################
         /*
        mysql_query("UPDATE serverdb.valore_par_sacchetto 
						SET 
              id_par_sac = " . $IdParametro . "
						WHERE 
							id_par_sac='" . $IdParametroOld . "'")
                or die("ERRORE 7 UPDATE serverdb.valore_par_sacchetto : " . mysql_error());
        */
       updateIdParSacValSac($IdParametro, $IdParametroOld);

        mysql_close();

        echo $msgModificaCompletata.' <a href="gestione_parametri_sacchetto.php">'.$msgTornaAiParSac.'</a>';
              }
      ?>
    </div>
  </body>
</html>