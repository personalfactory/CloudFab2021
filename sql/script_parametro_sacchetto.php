<?php

function selectParSacchettoByFiltri($idParSac,
        $nomeVariabile,
        $descriVariabile,
        $valoreBase,
        $abilitato,
        $dtAbilitato,
        $filtro){
  
  $sql=mysql_query("SELECT * FROM serverdb.parametro_sacchetto 
      WHERE 
        id_par_sac LIKE '%".$idParSac."%' 
        AND 
        nome_variabile LIKE '%".$nomeVariabile."%'
        AND
        descri_variabile LIKE '%".$descriVariabile."%'
        AND
        valore_base LIKE '%".$valoreBase."%'
        AND
        abilitato LIKE '%".$abilitato."%'
          AND
        dt_abilitato LIKE '%".$dtAbilitato."%'
          
ORDER BY ".$filtro) 
		or die("ERROR IN script_parametro_sacchetto - FUNCTION selectParSacchettoByFiltri - SELECT * FROM parametro_sacchetto : " . mysql_error());
  
  return $sql;
}






/**
 * Seleziona un record per id e nome
 * @param unknown $idParametro
 * @param unknown $nomeParametro
 * @param unknown $connessione
 * @return resource
 */
function findParSacchettoByIdNome($idParametro, $nomeParametro, $connessione){
	$sqlString= "SELECT * FROM serverdb.parametro_sacchetto 
          WHERE 
            id_par_sac=" . $idParametro . " 
          OR 
            nome_variabile = '" . $nomeParametro . "'";

	$sql = mysql_query($sqlString, $connessione)
	or die("ERROR IN script_parametro_sacchetto - FUNCTION findParSacchettoByIdNome - ".$sqlString ." ". mysql_error());
	return $sql;
}





/**
 * Inserisce un nuovo record abilitato
 * @param unknown $idParametro
 * @param unknown $nomeParametro
 * @param unknown $descriParametro
 * @param unknown $valoreBase
 * @param unknown $dataCorrente
 * @return resource
 */
function insertNewParSacchetto($idParametro, $nomeParametro, $descriParametro, $valoreBase, $dataCorrente){
	$sqlString= "INSERT INTO serverdb.parametro_sacchetto (id_par_sac,nome_variabile,descri_variabile,valore_base,abilitato,dt_abilitato) 
				VALUES ( 
            " . $idParametro . ",
            '" . $nomeParametro . "',
						'" . $descriParametro . "',
						'" . $valoreBase . "',
						1,
						'" . $dataCorrente . "')";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_sacchetto - FUNCTION insertNewParSacchetto - ".$sqlString ." ". mysql_error());
	return $sql;
}






/**
 * Seleziona un record per id
 * @param unknown $idParametro
 * @return resource
 */
function findParSacchettoById($idParametro){
	$sqlString= "SELECT * FROM serverdb.parametro_sacchetto WHERE id_par_sac=" . $idParametro;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_sacchetto - FUNCTION findParSacchettoById - ".$sqlString ." ". mysql_error());
	return $sql;
}






/**
 * Seleziona un record per id, nome e descrizione
 * @param unknown $idParametro
 * @param unknown $nomeParametro
 * @param unknown $descriVariabile
 * @param unknown $connessione
 * @return resource
 */
function findParSacchettoByIdNomeDescri($idParametro, $nomeParametro, $descriVariabile , $connessione){
	$sqlString= "SELECT * FROM serverdb.parametro_sacchetto 
				WHERE 
					id_par_sac = " . $idParametro . "
        AND
          nome_variabile ='" . $nomeParametro. "'
        AND
          descri_variabile='" . $descriVariabile . "'";

	$sql = mysql_query($sqlString, $connessione)
	or die("ERROR IN script_parametro_sacchetto - FUNCTION findParSacchettoByIdNomeDescri - ".$sqlString ." ". mysql_error());
	return $sql;
}





/**
 * Inserisce un nuovo record nello storico
 * @param unknown $idParametroOld
 * @return resource
 */
function insertStoricoParSacchetto($idParametroOld){
	$sqlString= "INSERT INTO storico.parametro_sacchetto 						 										
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
								id_par_sac='" . $idParametroOld . "'";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_sacchetto - FUNCTION insertStoricoParSacchetto - ".$sqlString ." ". mysql_error());
	return $sql;
}






/**
 * Aggiorna un record in serverdb.parametro_sacchetto 
 * @param unknown $idParametro
 * @param unknown $nomeVariabile
 * @param unknown $descriVariabile
 * @param unknown $valoreBase
 * @param unknown $dataCorrente
 * @param unknown $idParametroOld
 * @return resource
 */
function updateServerDBParSacchetto($idParametro, $nomeVariabile, $descriVariabile, $valoreBase, $dataCorrente, $idParametroOld){
	$sqlString= "UPDATE serverdb.parametro_sacchetto 
						SET 
              id_par_sac=" . $idParametro . ",
							nome_variabile='" . $nomeVariabile . "',
							descri_variabile='" . $descriVariabile . "',
							valore_base='" . $valoreBase . "',
							dt_abilitato='" . $dataCorrente . "'
						WHERE 
							id_par_sac=" . $idParametroOld;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_sacchetto - FUNCTION updateServerDBParSacchetto - ".$sqlString ." ". mysql_error());
	return $sql;
}




/**
 * Seleziona tutti i record e li ordina per descrizione
 * @return resource
 */
function findAllParSacchettoOrderByDescri(){
	$sqlString= "SELECT * FROM serverdb.parametro_sacchetto ORDER BY descri_variabile";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_sacchetto - FUNCTION findAllParSacchettoOrderByDescri - ".$sqlString ." ". mysql_error());
	return $sql;
}






/**
 * Seleziona tutti i record e li ordina per nome
 * @return resource
 */
function findAllParSacchettoOrderByNome(){
	$sqlString= "SELECT * FROM serverdb.parametro_sacchetto ORDER BY nome_variabile";

	$sql = mysql_query($sqlString);
	//or die("ERROR IN script_parametro_sacchetto - FUNCTION findAllParSacchettoOrderByNome - ".$sqlString ." ". mysql_error());
	return $sql;
}







/**
 * Conta il numero di record
 * @return resource
 */
function selectCountParSac(){
	$sqlString= "SELECT COUNT(id_par_sac) AS num_par 
                                            FROM 
                                                serverdb.parametro_sacchetto ";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_sacchetto - FUNCTION selectCountParSac - ".$sqlString ." ". mysql_error());
	return $sql;
}
?>
