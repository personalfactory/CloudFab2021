<?php

/**
 * Seleziona tutti i record della tabella lingua ordinandoli
 * @return resource
 */
function selectAllLingua($campoOrdine) {
    $sqlString = "SELECT * FROM serverdb.lingua ORDER BY ".$campoOrdine;

    $sql = mysql_query($sqlString) or die("ERROR IN script_lingua.php - FUNCTION selectAllLingua - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Seleziona tutti i record della tabella lingua
 * @return resource
 */
function findAllLingua() {
    $sqlString = "SELECT * FROM serverdb.lingua";

    $sql = mysql_query($sqlString) or die("ERROR IN script_lingua.php - FUNCTION findAllLingua - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Seleziona il record della tabella lingua con lingua corrispondente al parametro
 * @param unknown $lingua
 * @param unknown $connessione
 * @return resource
 */
function findLinguaByLingua($lingua, $connessione) {
    $sqlString = "SELECT * FROM serverdb.lingua WHERE lingua = '" . $lingua . "'";

    $sql = mysql_query($sqlString, $connessione) or die("ERROR IN script_lingua.php - FUNCTION findLinguaByLingua - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Inserisce un nuovo record nella tabella lingua
 * @param unknown $lingua
 * @param unknown $dataCorrente
 * @param unknown $connessione
 * @return resource
 */
function insertLingua($lingua, $dataCorrente, $connessione) {
    $sqlString = "INSERT INTO serverdb.lingua (lingua,abilitato,dt_abilitato) 
				VALUES ( 
						'" . $lingua . "',
						1,
						'" . $dataCorrente . "')";

    $sql = mysql_query($sqlString, $connessione) or die("ERROR IN script_lingua.php - FUNCTION insertLingua - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Seleziona il record della tabella lingua con id corrispondente al parametro
 * @param unknown $idLingua
 * @return resource
 */
function findLinguaByID($idLingua) {
    $sqlString = "SELECT * FROM serverdb.lingua WHERE id_lingua=" . $idLingua;

    $sql = mysql_query($sqlString) or die("ERROR IN script_lingua.php - FUNCTION findLinguaByID - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Seleziona il record della tabella lingua con lingua corrispondente al parametro e id diverso
 * @param unknown $lingua
 * @param unknown $idLingua
 * @param unknown $connessione
 * @return resource
 */
function selectLinguaByLinguaAndID($lingua, $idLingua, $connessione) {
    $sqlString = "SELECT * FROM serverdb.lingua 
				WHERE 
					lingua = '" . $lingua . "'
				AND 
					id_lingua<>" . $idLingua;

    $sql = mysql_query($sqlString, $connessione) or die("ERROR IN script_lingua.php - FUNCTION selectLinguaByLinguaAndID - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Inserisce un nuovo record nella tabella lingua del db storico
 * @param unknown $idLingua
 * @return resource
 */
function insertStoricoLingua($idLingua) {
    $sqlString = "INSERT INTO storico.lingua						 										
				(id_lingua,lingua,abilitato,dt_abilitato) 
					SELECT 
						id_lingua,
						lingua,
						abilitato,
						dt_abilitato
					FROM 
						serverdb.lingua
					WHERE
						id_lingua='" . $idLingua . "'";

    $sql = mysql_query($sqlString) or die("ERROR IN script_lingua.php - FUNCTION insertStoricoLingua - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Aggiorna i campi lingua e data della tabella lingua del db server
 * @param unknown $lingua
 * @param unknown $idLingua
 * @param unknown $dataCorrente
 * @return resource
 */
function updateServerDBLingua($lingua, $idLingua, $dataCorrente) {
    $sqlString = "UPDATE serverdb.lingua 
						SET 
							lingua='" . $lingua . "',
							dt_abilitato='" . $dataCorrente . "'
						WHERE 
							id_lingua='" . $idLingua . "'";

    $sql = mysql_query($sqlString) or die("ERROR IN script_lingua.php - FUNCTION updateServerDBLingua - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Seleziona le lingue diverse dal parametro
 * @param unknown $lingua
 * @return resource
 */
function findAltreLingue($lingua) {
    $sqlString = "SELECT * FROM serverdb.lingua WHERE lingua <>'" . $lingua . "'ORDER BY lingua";

    $sql = mysql_query($sqlString) or die("ERROR IN script_lingua.php - FUNCTION findAltreLingue - " . $sqlString . " " . mysql_error());
    return $sql;
}

?>