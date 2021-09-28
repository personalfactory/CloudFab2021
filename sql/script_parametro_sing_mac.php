<?php
/**
 * Seleziona tutti i parametri dalla tabella parametro_sing_mac in base ai filtri
 * @param type $idParSm
 * @param type $nomeVariabile
 * @param type $descriVariabile
 * @param type $valoreBase
 * @param type $abilitato
 * @param type $dtAbilitato
 * @param type $filtro
 * @return type
 */
function selectParSingMacByFiltri($idParSm,$nomeVariabile,$descriVariabile,$valoreBase,$abilitato,$dtAbilitato,$filtro){
  
   $sql = mysql_query("SELECT * FROM serverdb.parametro_sing_mac  
      WHERE
        id_par_sm LIKE '%".$idParSm."%' 
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
          
ORDER BY ".$filtro)  or die("ERROR IN script_parametro_sing_mac - FUNCTION selectParsingMacByFiltri - SELECT * FROM parametro_sing_mac : " . mysql_error());
  return $sql;
}



/**
 * Seleziona un record per id
 * @param unknown $idParametro
 * @return resource
 */
function findParSMById($idParametro){
	$sqlString= "SELECT * FROM serverdb.parametro_sing_mac WHERE id_par_sm=" . $idParametro;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_sing_mac - FUNCTION findParSMById - ".$sqlString ." ". mysql_error());
	return $sql;
}



/**
 * Seleziona una record per id, nome e descrizione
 * @param unknown $idParametro
 * @param unknown $nomeVariabile
 * @param unknown $descriVariabile
 * @return resource
 */
function findParSMByIdNomeDescri($idParametro, $nomeVariabile, $descriVariabile,$valoreBase){
	$sqlString= "SELECT * FROM serverdb.parametro_sing_mac 
			WHERE 
				id_par_sm = " . $idParametro . "
                            AND 
				nome_variabile ='" . $nomeVariabile . "'
                            AND
                                descri_variabile='" . $descriVariabile . "'
                            AND
                                valore_base='" . $valoreBase . "'";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_sing_mac - FUNCTION findParSMByIdNomeDescri - ".$sqlString ." ". mysql_error());
	return $sql;
}




/**
 * Inserisce un nuovo record nello storico
 * @param unknown $idParametro
 * @return resource
 */
function insertStoricoParSM($idParametro){
	$sqlString= "INSERT INTO storico.parametro_sing_mac					 										
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
								id_par_sm='" . $idParametro . "'";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_sing_mac - FUNCTION insertStoricoParSM - ".$sqlString ." ". mysql_error());
	return $sql;
}







/**
 * Aggiorna un record
 * @param unknown $idParametro
 * @param unknown $nomeVariabile
 * @param unknown $descriVariabile
 * @param unknown $valoreBase
 * @param unknown $dataCorrente
 * @param unknown $idParametroOld
 * @return resource
 */
function updateServerDBParSM($idParametro, $nomeVariabile, $descriVariabile, $valoreBase, $dataCorrente, $idParametroOld){
	$sqlString= "UPDATE serverdb.parametro_sing_mac 
						SET 
                                                        id_par_sm=" . $idParametro . ",
							nome_variabile='" . $nomeVariabile . "',
							descri_variabile='" . $descriVariabile . "',
							valore_base='" . $valoreBase . "',
							dt_abilitato='" . $dataCorrente . "'
						WHERE 
							id_par_sm='" . $idParametroOld. "'";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_sing_mac - FUNCTION updateServerDBParSM - ".$sqlString ." ". mysql_error());
	return $sql;
}




/**
 * Seleziona un record per  id oppure per nome
 * @param unknown $idParametro
 * @param unknown $nomeParametro
 * @param unknown $connessione
 * @return resource
 */
function findParSMByIdNome($idParametro, $nomeParametro){
	$sqlString= "SELECT * FROM serverdb.parametro_sing_mac 
                WHERE 
                  id_par_sm=".$idParametro." 
                OR 
                  nome_variabile = '" . $nomeParametro . "'";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_sing_mac - FUNCTION findParSMByIdNome - ".$sqlString ." ". mysql_error());
	return $sql;
}




/**
 * Inserisce un nuovo record
 * @param unknown $idParametro
 * @param unknown $nomeVariabile
 * @param unknown $descriVariabile
 * @param unknown $valoreBase
 * @param unknown $dataCorrente
 * @return resource
 */
function insertNewParSM($idParametro, $nomeVariabile, $descriVariabile, $valoreBase, $dataCorrente){
	$sqlString= "INSERT INTO serverdb.parametro_sing_mac 
                      (id_par_sm,nome_variabile,descri_variabile,valore_base,abilitato,dt_abilitato) 
                     VALUES ( 
                          ".$idParametro.",
                          '" . $nomeVariabile . "',
                          '" . $descriVariabile . "',
                          '" . $valoreBase . "',
                          1,
                          '" . $dataCorrente . "')";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_sing_mac - FUNCTION insertNewParSM - ".$sqlString ." ". mysql_error());
	return $sql;
}

/**
 * Seleziona tutti i parametri singola macchina 
 * @param type $campoOrdine
 * @return type
 */
function findAllParametriSm($campoOrdine){
    $sqlString="SELECT * FROM serverdb.parametro_sing_mac ORDER BY ".$campoOrdine;

   $sql = mysql_query($sqlString) 
           or die("ERROR IN script_parametro_sing_mac - FUNCTION findAllParametriSm - ".$sqlString ." ". mysql_error());
   return $sql;
}


?>
