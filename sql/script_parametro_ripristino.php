<?php
function selectParRipristinoByFiltri(
        $idParRip,
        $nomeVariabile,
        $descriVariabile,
        $abilitato,
        $dtAbilitato,
        $filtro){
  
   $sql = mysql_query("SELECT * FROM serverdb.parametro_ripristino  
      WHERE
        id_par_ripristino LIKE '%".$idParRip."%' 
        AND 
        nome_variabile LIKE '%".$nomeVariabile."%'
        AND
        descri_variabile LIKE '%".$descriVariabile."%'
        AND
        abilitato LIKE '%".$abilitato."%'
          AND
        dt_abilitato LIKE '%".$dtAbilitato."%'
      ORDER BY ".$filtro)  
   or die("ERROR IN script_parametro_ripristino - FUNCTION selectRipristinoByFiltri - SELECT * FROM parametro_ripristino : " . mysql_error());
  return $sql;
}





/**
 * Seleziona un record da parametro_ripristino per id
 * @param unknown $idParametro
 * @return resource
 */
function findAllParRipristinoById($idParametro){
	$sqlString= "SELECT * FROM serverdb.parametro_ripristino WHERE id_par_ripristino=" . $idParametro;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_ripristino - FUNCTION findAllParRipristinoById - ".$sqlString ." ". mysql_error());
	return $sql;
}









/**
 * Seleziona un record da parametro_ripristino per id , nome e descrizione
 * @param unknown $idParametro
 * @param unknown $nomeVariabile
 * @param unknown $descriVariabile
 * @param unknown $connessione
 * @return resource
 */
function findParRipristinoByIdNomeDescri($idParametro, $nomeVariabile, $descriVariabile, $connessione){
	$sqlString= "SELECT * FROM serverdb.parametro_ripristino 
			WHERE 
					 id_par_ripristino= " . $idParametro . "
        AND
          nome_variabile ='" . $nomeVariabile . "'
        AND
          descri_variabile='" . $descriVariabile . "'";

	$sql = mysql_query($sqlString, $connessione)
	or die("ERROR IN script_parametro_ripristino - FUNCTION findParRipristinoByIdNomeDescri - ".$sqlString ." ". mysql_error());
	return $sql;
}








/**
 * Inserisce un nuovo record nello storico
 * @param unknown $idParametro
 * @return resource
 */
function insertStoricoParRipristino($idParametro){
	$sqlString= "INSERT INTO storico.parametro_ripristino				 										
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
								id_par_ripristino='" . $idParametro . "'";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_ripristino - FUNCTION insertStoricoParRipristino - ".$sqlString ." ". mysql_error());
	return $sql;
}







/**
 * Aggiorna un record in serverdb.parametro_ripristino
 * @param unknown $idParametro
 * @param unknown $nomeVariabile
 * @param unknown $descriVariabile
 * @param unknown $dataCorrente
 * @param unknown $idParametroOld
 * @return resource
 */
function updateServerDBParRipristino($idParametro, $nomeVariabile, $descriVariabile, $dataCorrente, $idParametroOld){
	$sqlString= "UPDATE serverdb.parametro_ripristino 
						SET 
            id_par_ripristino =" . $idParametro . ",
							nome_variabile='" . $nomeVariabile . "',
							descri_variabile='" . $descriVariabile . "',
							dt_abilitato='" . $dataCorrente . "'
						WHERE 
							id_par_ripristino='" . $idParametroOld . "'";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_ripristino - FUNCTION updateServerDBParRipristino - ".$sqlString ." ". mysql_error());
	return $sql;
}







/**
 * Seleziona un record di parametro_ripristino per id o nome
 * @param unknown $idParametro
 * @param unknown $nomeParametro
 * @param unknown $connessione
 * @return resource
 */
function findParRipristinoByIdOrNome($idParametro, $nomeParametro, $connessione){
	$sqlString= "SELECT * FROM serverdb.parametro_ripristino 
                WHERE 
                  id_par_ripristino=" . $idParametro . " 
                OR 
                  nome_variabile = '" . $nomeParametro . "'";

	$sql = mysql_query($sqlString, $connessione)
	or die("ERROR IN script_parametro_ripristino - FUNCTION findParRipristinoByIdOrNome - ".$sqlString ." ". mysql_error());
	return $sql;
}











/**
 * Inserisce un nuovo record in parametro_ripristino
 * @param unknown $idParametro
 * @param unknown $nomeParametro
 * @param unknown $descriParametro
 * @param unknown $dataCorrente
 * @return resource
 */
function insertNewParRipristino($idParametro, $nomeParametro, $descriParametro, $dataCorrente){
	$sqlString= "INSERT INTO serverdb.parametro_ripristino (id_par_ripristino,nome_variabile,descri_variabile,abilitato,dt_abilitato) 
				VALUES ( 
            " . $idParametro . ",
            '" . $nomeParametro . "',
						'" . $descriParametro . "',
						1,
						'" . $dataCorrente . "')";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_ripristino - FUNCTION insertNewParRipristino - ".$sqlString ." ". mysql_error());
	return $sql;
}
?>
