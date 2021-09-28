<?php



/**
 * 
 * @param unknown $idMessaggio
 * @param unknown $messaggio
 * @param unknown $abilitato
 * @param unknown $dtAbilitato
 * @param unknown $filtro
 * @return resource
 */
function selectMessaggioMacchina($idMessaggio, $messaggio, $abilitato, $dtAbilitato, $filtro ){
	$sqlString="SELECT * FROM serverdb.messaggio_macchina 
                    WHERE
                        id_messaggio LIKE '%" . $idMessaggio . "%'
                      AND
                        messaggio LIKE '%" . $messaggio. "%'
                      AND
                        abilitato LIKE '%" . $abilitato . "%'
                      AND
                       dt_abilitato LIKE '%" . $dtAbilitato . "%'
                      ORDER BY " . $filtro;
	$sql = mysql_query($sqlString)
	or die("ERROR IN script_messaggio_macchina.php - FUNCTION selectMessaggioMacchina - ".$sqlString ." ". mysql_error());
	return $sql;
}







/**
 * Seleziona il record della tabella messaggio_macchina con id corrispondente
 * @param unknown $idMessaggio
 * @return resource
 */
function findMessaggioByID($idMessaggio){
	$sqlString="SELECT * FROM serverdb.messaggio_macchina WHERE id_messaggio=" . $idMessaggio;
	$sql = mysql_query($sqlString)
	or die("ERROR IN script_messaggio_macchina.php - FUNCTION findMessaggioByID - ".$sqlString ." ". mysql_error());
	return $sql;
}










/**
 * Inserisce un nuovo record nella tabella messaggio_macchina del db storico 
 * @param unknown $idMessaggio
 * @return resource
 */
function insertStoricoMessaggioMacchina($idMessaggio){
	$sqlString="INSERT INTO storico.messaggio_macchina 						 										
								(id_messaggio,
								messaggio,
								abilitato,
								dt_abilitato) 
							SELECT 
								id_messaggio,
								messaggio,
								abilitato,
								dt_abilitato
							FROM 
								serverdb.messaggio_macchina
							WHERE 
								id_messaggio='" . $idMessaggio . "'";
	$sql = mysql_query($sqlString)
	or die("ERROR IN script_messaggio_macchina.php - FUNCTION insertStoricoMessaggioMacchina - ".$sqlString ." ". mysql_error());
	return $sql;
}









/**
 * Aggiorna il record selezionato per id nella tabella messaggio_macchina del db server
 * @param unknown $idMessaggio
 * @param unknown $messaggioMacchina
 * @param unknown $dataCorrente
 * @return resource
 */
function updateServerDBMessaggioMacchina($idMessaggio, $messaggioMacchina, $dataCorrente){
	$sqlString="UPDATE serverdb.messaggio_macchina 
						SET 
                                                dt_abilitato=if(messaggio != '" . $messaggioMacchina . "',
                                                    '" . $dataCorrente . "',
                                                        dt_abilitato),
                                                messaggio=if(messaggio != '" . $messaggioMacchina . "',
                                                    '" . $messaggioMacchina . "',
                                                    messaggio)
						WHERE 
                                                    id_messaggio=" . $idMessaggio;
	$sql = mysql_query($sqlString)
	or die("ERROR IN script_messaggio_macchina.php - FUNCTION updateServerDBMessaggioMacchina - ".$sqlString ." ". mysql_error());
	return $sql;
}




/**
 * Seleziona i campi id_messaggio e messaggio dalla tabella messaggio_macchina
 * @return resource
 */
function findIdAndMessaggio(){
	$sqlString="SELECT 
                                                id_messaggio,
                                                messaggio
                                        FROM 
                                                serverdb.messaggio_macchina";
	$sql = mysql_query($sqlString)
	or die("ERROR IN script_messaggio_macchina.php - FUNCTION findIdAndMessaggio - ".$sqlString ." ". mysql_error());
	return $sql;
}





/**
 * Inserisce un nuovo messaggio
 * @param unknown $messaggio
 * @param unknown $dataCorrente
 * @return resource
 */
function insertNewMessaggio($messaggio, $dataCorrente){
	$sqlString="INSERT INTO serverdb.messaggio_macchina 
                                        (messaggio,
                                        abilitato,
                                        dt_abilitato) 
				VALUES ( 
                                        '" . $messaggio .
                                        "',1,
                                        '" . $dataCorrente . "')";
	$sql = mysql_query($sqlString)
	or die("ERROR IN script_messaggio_macchina.php - FUNCTION insertNewMessaggio - ".$sqlString ." ". mysql_error());
	return $sql;
}


?>