<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <?php include('../include/validator.php'); ?>
  <head>
    <?php include('../include/header.php'); ?>
  </head>
  <body>

    <?php include('../include/gestione_date.php'); ?>
    <div id="mainContainer">

      <?php
//Ricavo i nuovi valori dei campi mandati tramite POST
      $IdDizionario = $_POST['IdDizionario'];

      $VocaboloPost = str_replace("'", "''", $_POST['Vocabolo']);
      $VocaboloPost = str_replace("", "", $VocaboloPost);


//################### GESTIONE DEGLI ERRORI SULLE QUERY #######################
      $selectDizionario = true;
      $insertStoricoDizionario = true;
      $updateServerdbDizionario = true;
      $selectVocaboli = true;
      $erroreResult = false;
      $updateTraduzione = true;

//#############################################################################            
//Verifico che i nuovi valori siano stati settati e non nulli
      $errore = false;
            $messaggio = $msgErroreVerificato.'<br />';

//Gestione degli errori relativa ai nuovi dati modificati
      if (!isset($_POST['Vocabolo']) || trim($_POST['Vocabolo']) == "") {
        $errore = true;
        $messaggio = $msgErrCampoTermineVuoto;
      }

      if ($errore) {
        //Ci sono errori quindi non salvo

            $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
      } else {

//Inserisco il vecchio record nello storico  prima di modificarlo nella tabella corrente su serverdb
        include('../Connessioni/storico.php');
        include('../Connessioni/serverdb.php');
        include('../sql/script.php');
        include('../sql/script_dizionario.php');

        //######################################################################
        //############################### INIZIO TRANSAZIONE ###################
        //######################################################################

        begin();
		/*
        $selectDizionario = mysql_query("SELECT 
                                                        id_dizionario,
                                                        id_diz_tipo,
                                                        id_lingua,
                                                        id_vocabolo,
                                                        vocabolo,
                                                        abilitato,
                                                        dt_abilitato
                                                FROM 
                                                        serverdb.dizionario
                                                WHERE
                                                        id_dizionario='" . $IdDizionario . "'") or die("Errore 1: " . mysql_error());
        */
        $selectDizionario = selectDizionarioByID($IdDizionario);
        
        while ($rowVocabolo = mysql_fetch_array($selectDizionario)) {
          $IdLingua = $rowVocabolo['id_lingua'];
          $IdVocabolo = $rowVocabolo['id_vocabolo'];
          $IdDizTipo = $rowVocabolo['id_diz_tipo'];
          $VocaboloOld = str_replace("'", "''", $rowVocabolo['vocabolo']);
          $Data = $rowVocabolo['dt_abilitato'];
        }

//                $insertStoricoDizionario = mysql_query("INSERT INTO storico.dizionario 						 										
//				(id_dizionario,id_diz_tipo,id_lingua,id_vocabolo,vocabolo,abilitato,dt_abilitato) 
//					VALUES(" . $IdDizionario . ",
//						   " . $IdDizTipo . ",
//						   " . $IdLingua . ",
//						   " . $IdVocabolo . ",
//						   '" . $VocaboloOld . "',
//						   1,
//						   '" . dataCorrenteInserimento() . "')")
//		or die("Errore 2: " . mysql_error());
        //Modifico il singolo record
        /*
        $updateServerdbDizionario = mysql_query("UPDATE serverdb.dizionario 
                                                    SET 
							vocabolo=if(vocabolo!='" . $VocaboloPost . "','" . $VocaboloPost . "',vocabolo)
                                                    WHERE 
							id_dizionario='" . $IdDizionario . "'") or die("Errore 3: " . mysql_error());
							*/
        $updateServerdbDizionario = updateVocaboloByID($IdDizionario, $VocaboloPost );
//Modifico il record nella tabella corrente [dizionario] di serverdb, 
//salvando i nuovi valori dei campi mandati tramite POST 
//e aggiornando il campo dt_abilitato con data corrente.
        $NLin = 1;
        /*
        $selectVocaboli = mysql_query("SELECT
                                                    dizionario.id_dizionario,
                                                    dizionario.id_diz_tipo,
                                                    dizionario.id_lingua,
                                                    lingua.lingua,						
                                                    dizionario_tipo.dizionario_tipo,
                                                    dizionario.id_vocabolo,
                                                    dizionario.vocabolo,
                                                    dizionario.dt_abilitato
                                            FROM
                                                    dizionario
                                            INNER JOIN dizionario_tipo 
                                            ON 
                                                    dizionario.id_diz_tipo = dizionario_tipo.id_diz_tipo
                                            INNER JOIN lingua 
                                            ON 
                                                    dizionario.id_lingua = lingua.id_lingua
                                        WHERE 
                                             dizionario.id_lingua<>'" . $IdLingua . "'
                                        AND
                                                    id_vocabolo=" . $IdVocabolo . "
                                        AND 
                                                dizionario.id_diz_tipo=" . $IdDizTipo . "
                                        ORDER BY 
                                               lingua") or die("Errore 4: " . mysql_error());
                                               */
        $selectVocaboli = selectLingueFromDizionario($IdLingua, $IdVocabolo, $IdDizTipo);
        while ($rowLingua = mysql_fetch_array($selectVocaboli)) {

          $Traduzione = str_replace("'", "''", $_POST['Traduzione' . $NLin]);
          $Traduzione = str_replace("", "", $Traduzione);
		/*
          $updateTraduzione = mysql_query("UPDATE serverdb.dizionario 
                                                    SET 
                                                         vocabolo=if(vocabolo!='" . $Traduzione . "','" . $Traduzione . "',vocabolo)
                                                     WHERE 
                                                            id_vocabolo='" . $IdVocabolo . "'
                                                            AND
                                                            id_lingua='" . $rowLingua['id_lingua'] . "'
                                                            AND 
                                                            dizionario.id_diz_tipo=" . $IdDizTipo) or die("Errore 5: " . mysql_error());
                                                            */
          $updateTraduzione = updateTraduzione($IdVocabolo, $rowLingua['id_lingua'], $IdDizTipo, $Traduzione);
          if (!$updateTraduzione) {
            $erroreResult = true;
          }

          $NLin++;
        }//Fine lingue		

        if ($erroreResult OR !$selectDizionario OR !$insertStoricoDizionario OR !$updateServerdbDizionario OR !$selectVocaboli
        ) {

          rollback();


          echo $msgTransazioneFallita."</br>";
          echo $msgErrContacAdminSeProblema;

          //   echo "selectDizionario : ".$selectDizionario."</br>" ;
          //   echo "insertStoricoDizionario : ".$insertStoricoDizionario."</br>" ;
          //   echo "updateServerdbDizionario : ".$updateServerdbDizionario."</br>" ;
          //   echo "selectVocaboli : ".$selectVocaboli."</br>" ;
          //   echo "updateTraduzione : ".$updateTraduzione."</br>" ;
          //   echo '<a href="javascript:history.back()">RICONTROLLARE I DATI</a></br>';
          ?>
          <input type="button" onClick="javascript:window.opener.location.reload(); window.close();" value="OK" />

          <?php
        } else {
          ?>

          <script type="text/javascript">
              location.href = "modifica_vocabolo.php?IdDizionario=<?php echo($IdDizionario) ?>"
          </script> 
          <script type="text/javascript">
            location.href = "gestione_dizionario.php?DtAbilitato=<?php echo $_SESSION['DtAbilitato'] ?>
            &IdDiz =<?php echo $_SESSION['IdDiz'] ?>
            &DizionarioTipo =<?php echo $_SESSION['DizionarioTipo'] ?>
            &LinguaScelta =<?php echo $_SESSION['LinguaScelta'] ?>
            &IdVocabolo =<?php echo $_SESSION['IdVocabolo'] ?>
            &Vocabolo =<?php echo $_SESSION['Vocabolo'] ?>
            &Filtro<?php echo $_SESSION['Filtro'] ?>"
          </script> 

    <?php
    commit();

    mysql_close();
  }
}
?>
    </div>
  </body>
</html>