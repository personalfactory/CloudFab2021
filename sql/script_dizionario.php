<?php

function selectDizionarioByFiltri($lingua,$idDiz,$dizionarioTipo,$idvocabolo,$vocabolo,$dtAbilitato,$filtro,$var){
 mysql_query("SET @var='".$var."'");
  $sql = mysql_query("SELECT
                        dizionario.id_dizionario,
                        lingua.lingua,
                        dizionario_tipo.dizionario_tipo,
                        dizionario.id_vocabolo,
                        dizionario.vocabolo,
                        dizionario.dt_abilitato
                FROM
                        serverdb.dizionario
                INNER JOIN serverdb.dizionario_tipo 
                ON 
                        dizionario.id_diz_tipo = dizionario_tipo.id_diz_tipo
                INNER JOIN serverdb.lingua 
                ON 
                        dizionario.id_lingua = lingua.id_lingua
                WHERE 
                        lingua LIKE '%" . $lingua . "%'
                    AND
                    id_dizionario LIKE '%" . $idDiz . "%'
                    AND
                    dizionario_tipo LIKE '%" . $dizionarioTipo . "%'
                    AND
                    id_vocabolo LIKE '%" . $idvocabolo . "%'
                    AND
                    vocabolo LIKE '%" . $vocabolo . "%'
                    AND
                    dizionario.dt_abilitato LIKE '%" . $dtAbilitato . "%' 
                GROUP BY 
                          CASE WHEN @var='id_dizionario' THEN id_dizionario END ,
                          CASE WHEN @var='lingua' THEN lingua END ,
                          CASE WHEN @var='dizionario_tipo' THEN dizionario_tipo END ,
                          CASE WHEN @var='id_vocabolo' THEN id_vocabolo END ,
                          CASE WHEN @var='vocabolo' THEN vocabolo END ,
                          CASE WHEN @var='dt_abilitato' THEN dizionario.dt_abilitato END      
                ORDER BY
                  " . $filtro) 
        or die("ERROR IN script_dizionario - FUNCTION selectDizionarioByFiltri - SELECT FROM dizionario: " . mysql_error());

return $sql;
}

function selectDizonarioGroupByIdDiz(){
   
  $sql=mysql_query ("SELECT * FROM serverdb.dizionario GROUP BY id_dizionario") 
          or die("ERROR IN script_dizionario - FUNCTION selectDizonarioGroupByIdDiz - SELECT FROM dizionario: " . mysql_error());
  return $sql;
  
}
function selectDizonarioGroupByDizTipo(){
   
  $sql=mysql_query ("SELECT t.dizionario_tipo FROM serverdb.dizionario d JOIN serverdb.dizionario_tipo t ON d.id_diz_tipo=t.id_diz_tipo 
     GROUP BY d.id_diz_tipo") 
          or die("ERROR IN script_dizionario - FUNCTION selectDizonarioGroupByDizTipo - SELECT FROM dizionario: " . mysql_error());
  return $sql;
  
}


function selectDizonarioGroupByDt(){
  
 
  $sql=mysql_query ("SELECT * FROM serverdb.dizionario  GROUP BY dt_abilitato") 
          or die("ERROR IN script_dizionario - FUNCTION selectDizonarioGroupByDt - SELECT FROM dizionario: " . mysql_error());
  return $sql;
  
}

function selectDizonarioGroupByIdVocabolo(){
  
 
  $sql=mysql_query ("SELECT * FROM serverdb.dizionario  GROUP BY id_vocabolo") 
          or die("ERROR IN script_dizionario - FUNCTION selectDizonarioGroupByIdVocabolo - SELECT FROM dizionario: " . mysql_error());
  return $sql;
  
}

function selectDizonarioGroupByVocabolo($lingua){
   
  $sql=mysql_query ("SELECT * FROM serverdb.dizionario d JOIN serverdb.lingua l
                       ON d.id_lingua=l.id_lingua
                        WHERE lingua LIKE '%" . $lingua . "%' 
                        GROUP BY vocabolo") 
          or die("ERROR IN script_dizionario - FUNCTION selectDizonarioGroupByVocabolo - SELECT FROM dizionario: " . mysql_error());
  return $sql;
  
}

function selectDizonarioGroupByLingua(){
   
  $sql=mysql_query ("SELECT * FROM serverdb.dizionario d JOIN serverdb.lingua l
    ON d.id_lingua=d.id_lingua GROUP BY l.lingua") 
          or die("ERROR IN script_dizionario - FUNCTION selectDizonarioGroupByLingua - SELECT FROM dizionario: " . mysql_error());
  return $sql;
  
}

function selectDizionarioByIdDiz($idDizionario){
$sql = mysql_query("SELECT
						dizionario.id_dizionario,
						dizionario.id_diz_tipo,
						dizionario.id_lingua,
						lingua.lingua,						
						dizionario_tipo.dizionario_tipo,
						dizionario.id_vocabolo,
						dizionario.vocabolo,
						dizionario.dt_abilitato
					FROM
						serverdb.dizionario
					INNER JOIN serverdb.dizionario_tipo 
					ON 
						dizionario.id_diz_tipo = dizionario_tipo.id_diz_tipo
					INNER JOIN serverdb.lingua 
					ON 
						dizionario.id_lingua = lingua.id_lingua
					WHERE 
						id_dizionario=" . $idDizionario . "
					ORDER BY
						dizionario_tipo.dizionario_tipo") 
        or die("ERROR IN script_dizionario - FUNCTION selectDizionarioByIdDiz - SELECT FROM dizionario: " . mysql_error());

return $sql;
}



function selectLingueFromDizionario($idLingua,$idVocabolo,$idDizTipo){
  $sql = mysql_query("SELECT
                                            dizionario.id_dizionario,
                                            dizionario.id_diz_tipo,
                                            dizionario.id_lingua,
                                            lingua.lingua,						
                                            dizionario_tipo.dizionario_tipo,
                                            dizionario.id_vocabolo,
                                            dizionario.vocabolo,
                                            dizionario.dt_abilitato
                                    FROM
                                            serverdb.dizionario
                                    INNER JOIN serverdb.dizionario_tipo 
                                    ON 
                                            dizionario.id_diz_tipo = dizionario_tipo.id_diz_tipo
                                    INNER JOIN serverdb.lingua 
                                    ON 
                                            dizionario.id_lingua = lingua.id_lingua
                                        WHERE 
                                             dizionario.id_lingua<>'" . $idLingua . "'
                                        AND
                                                    id_vocabolo=" . $idVocabolo . "
                                        AND 
                                                dizionario.id_diz_tipo=" . $idDizTipo . "
                                        ORDER BY 
                                               lingua")
                              or die("ERROR IN script_dizionario - FUNCTION selectLingueFromDizionario - SELECT FROM dizionario: " . mysql_error());
  return $sql;
}


/**
 * Inserisce nella tabella dizionario una nuova lingua
 * @param unknown $lingua
 * @param unknown $dataCorrente
 * @param unknown $connessione
 * @return resource
 */
function insertLinguaIntoDizionario($lingua, $dataCorrente){
	$sqlString="INSERT INTO serverdb.dizionario (
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
					 	'" . $dataCorrente . "'
				 FROM 
				 		serverdb.lingua,serverdb.dizionario
				WHERE  
						lingua.lingua='" . $lingua . "'
						AND
						dizionario.id_lingua=1;";
	$sql = mysql_query($sqlString)
	or die("ERROR IN script_dizionario.php - FUNCTION insertLinguaIntoDizionario - ".$sqlString ." ". mysql_error());
	return $sql;
}



/**
 * Seleziona il campo vocabolo dalla tabella dizionario del db server per id_vocabolo corrispondente
 * @param unknown $idVocabolo
 * @param unknown $tipoDiz
 * @return resource
 */
//function selectVocaboloByID($idVocabolo,$tipoDiz){
//	$sqlString="SELECT vocabolo FROM serverdb.dizionario
//                                            WHERE 
//                                                id_diz_tipo=".$tipoDiz."
//                                            AND
//                                                id_vocabolo=" . $idVocabolo ;
//	$sql = mysql_query($sqlString)
//	or die("ERROR IN script_dizionario.php - FUNCTION selectVocaboloByID - ".$sqlString ." ". mysql_error());
//	return $sql;
//}



/**
 * Aggiorna il campo vocabolo nel record corrispondente all'id nella tabella dizionario del db server
 * @param unknown $idVocabolo
 * @param unknown $vocabolo
 * @param unknown $tipoDiz
 * @return resource
 */
function updateServerDBDizionario($idVocabolo,$vocabolo, $tipoDiz){
	$sqlString="UPDATE serverdb.dizionario 
						SET 
                                                  vocabolo= '" . $vocabolo . "'
                                                WHERE 
                                                       id_vocabolo=" . $idVocabolo . "
                                                     AND 
                                                       id_diz_tipo = ".$tipoDiz;
	$sql = mysql_query($sqlString);
	//or die("ERROR IN script_dizionario.php - FUNCTION updateServerDBDizionario - ".$sqlString ." ". mysql_error());
	return $sql;
}


/**
 * Seleziona id_vocabolo e vocabolo per id
 * @param unknown $idDizProdotto
 * @param unknown $id_prodotto
 * @return resource
 */
function selectIdVocabolo($idDizProdotto, $id_prodotto){
	$sqlString = "SELECT 
                                id_vocabolo,
                                vocabolo
                        FROM 
                                serverdb.dizionario
                        WHERE
                                id_diz_tipo=" . $idDizProdotto."
                        AND
                                id_vocabolo='" . $id_prodotto . "'";
	$sql = mysql_query($sqlString)
	or die("ERROR IN script_dizionario.php - FUNCTION selectIdVocabolo - ".$sqlString ." ". mysql_error());
	return $sql;
}






/**
 * Inserisce un nuovo record nella tabella dizionario
 * @param unknown $idLingua
 * @param unknown $idDizProdotto
 * @param unknown $idProdotto
 * @param unknown $nomeProdotto
 * @param unknown $dataCorrente
 * @return resource
 */
function insertNewDizionario($idLingua, $idDizProdotto, $idProdotto, $nomeProdotto, $dataCorrente ){
	$sqlString = "INSERT INTO serverdb.dizionario 
					(id_lingua,id_diz_tipo,id_vocabolo,vocabolo,abilitato,dt_abilitato) 
                                    VALUES(
                                        " . $idLingua . ",
                                        " . $idDizProdotto . ",
                                        " . $idProdotto . ",
                                        '" . $nomeProdotto . "',
                                        1,
                                '" . $dataCorrente . "')";
	$sql = mysql_query($sqlString);
//	or die("ERROR IN script_dizionario.php - FUNCTION insertNewDizionario - ".$sqlString ." ". mysql_error());
	return $sql;
}





/**
 * 
 * @param unknown $idDizionario
 * @return resource
 */
function selectDizionarioByID($idDizionario ){
	$sqlString = "SELECT 
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
                                                        id_dizionario='" . $idDizionario . "'";
	$sql = mysql_query($sqlString)
	or die("ERROR IN script_dizionario.php - FUNCTION selectDizionarioByID - ".$sqlString ." ". mysql_error());
	return $sql;
}













/**
 * Aggiorna il campo vocabolo del record della tabella dizionario selezionato per id
 * @param unknown $idDizionario
 * @param unknown $vocaboloPost
 * @return resource
 */
function updateVocaboloByID($idDizionario, $vocaboloPost ){
	$sqlString = "UPDATE serverdb.dizionario 
                                                    SET 
							vocabolo=if(vocabolo!='" . $vocaboloPost . "','" . $vocaboloPost . "',vocabolo)
                                                    WHERE 
							id_dizionario='" . $idDizionario . "'";
	$sql = mysql_query($sqlString)
	or die("ERROR IN script_dizionario.php - FUNCTION updateVocaboloByID - ".$sqlString ." ". mysql_error());
	return $sql;
}




/**
 * Aggiorna la traduzione del vocabolo selezionato per id
 * @param unknown $idVocabolo
 * @param unknown $idLingua
 * @param unknown $idDizTipo
 * @param unknown $traduzione
 * @return resource
 */
function updateTraduzione($idVocabolo, $idLingua, $idDizTipo, $traduzione){
	$sqlString = "UPDATE serverdb.dizionario 
                                                    SET 
                                                         vocabolo=if(vocabolo!='" . $traduzione . "','" . $traduzione . "',vocabolo)
                                                     WHERE 
                                                            id_vocabolo='" . $idVocabolo . "'
                                                            AND
                                                            id_lingua='" . $idLingua . "'
                                                            AND 
                                                            dizionario.id_diz_tipo=" . $idDizTipo;
	$sql = mysql_query($sqlString)
	or die("ERROR IN script_dizionario.php - FUNCTION updateTraduzione - ".$sqlString ." ". mysql_error());
	return $sql;
}


function selectVocaboloByIdTipoLingua($idvocabolo,$idLingua, $idDizProdotto){
	$sqlString = "SELECT 
                                *
                        FROM 
                                serverdb.dizionario
                        WHERE
                                id_diz_tipo=" . $idDizProdotto."
                        AND
                                id_vocabolo='" . $idvocabolo . "'
                        AND
                                id_lingua='" . $idLingua . "'";
	$sql = mysql_query($sqlString)
	or die("ERROR IN script_dizionario.php - FUNCTION selectVocaboloByIdTipoLingua - ".$sqlString ." ". mysql_error());
	return $sql;
}

?>
