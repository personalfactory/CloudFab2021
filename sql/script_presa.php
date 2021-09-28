<?php
	/**
	 * Seleziona tutti i record dalla tabella presa
	 * @return resource
	 */
	function findAllFromPresa(){
		$sqlString= "SELECT * FROM serverdb.presa ORDER BY presa";
		
		$sql = mysql_query($sqlString)
		or die("ERROR IN script_presa.php - FUNCTION findAllFromPresa - ".$sqlString ." ". mysql_error());
 		return $sql;
	}
	
	
	
	
	
	/**
	 * Seleziona il record con id= $idPresa dalla tabella presa
	 * @param unknown $idPresa
	 * @return resource
	 */
	function findPresaById($idPresa){
		$sqlString= "SELECT * FROM serverdb.presa WHERE id_presa=".$idPresa;
		
		$sql = mysql_query($sqlString)
		or die("ERROR IN script_presa.php - FUNCTION findPresaById - ".$sqlString ." ". mysql_error());
		return $sql;
		
	}
	
	
	
	
	
	/**
	 * Seleziona la presa con nome=$nomePresa e id<>$idPresa dalla tabella presa
	 * 
	 * @param unknown $idPresa
	 * @param unknown $nomePresa
	 * @param unknown $connessione
	 * @return resource
	 */
	function findPresaByNomeNonId($idPresa, $nomePresa, $connessione){
		$sqlString = "SELECT * FROM serverdb.presa WHERE presa = '" . $nomePresa . "' AND
			id_presa<>" . $idPresa;
		$result = mysql_query($sqlString, $connessione)
		or die("ERROR IN script_presa.php - FUNCTION findPresaByNomeNonId - ".$sqlString ." ". mysql_error());
		return $result;
	}
	
	
	
	
	
	/**
	 * Seleziona la presa con nome=$nomePresa dalla tabella presa
	 * @param unknown $nomePresa
	 * @return resource
	 */
	function findPresaByNome($nomePresa){
		$sqlString = "SELECT * FROM serverdb.presa WHERE presa = '" . $nomePresa . "'";
		
		$result = mysql_query($sqlString)
		or die("ERROR IN script_presa.php - FUNCTION findPresaByNome - ".$sqlString ." ". mysql_error());
		return $result;
	}
	
	
	
	
	/**
	 * Inserisce un nuovo record nella tabella presa
	 * @param unknown $nomePresa
	 * @param unknown $dataCorrente
	 * @return resource
	 */
	function insertPresa($nomePresa, $dataCorrente){
		$sqlString = "INSERT INTO serverdb.presa (presa,abilitato,dt_abilitato) 
				VALUES ('" . $nomePresa .
                        "',1,
						   '" . $dataCorrente . "')";
	
		$result = mysql_query($sqlString)
		or die("ERROR IN script_presa.php - FUNCTION insertPresa - ".$sqlString ." ". mysql_error());
		return $result;
	}
	
	
	
	
	
	
	
	/**
	 * Inserisce un nuovo record nella tabella presa del db storico
	 * @param unknown $idPresa
	 * @return resource
	 */
	function insertStoricoPresa($idPresa){
		$sqlString = "INSERT INTO storico.presa 						 										
                                        (id_presa,
                                        presa,
                                        abilitato,
                                        dt_abilitato) 
                                SELECT 
                                        id_presa,
                                        presa,
                                        abilitato,
                                        dt_abilitato
                                FROM 
                                        serverdb.presa
                                WHERE 
                                        id_presa='" . $idPresa . "'";
	
		$result = mysql_query($sqlString)
		or die("ERROR IN script_presa.php - FUNCTION insertStoricoPresa - ".$sqlString ." ". mysql_error());
		return $result;
	}
	
	
	
	
	
	/**
	 * Aggiorna il record della tabella presa del db server selezionato per id
	 * @param unknown $idPresa
	 * @param unknown $nomePresa
	 * @return resource
	 */
	function updateServerDBPresa($idPresa, $nomePresa){
		$sqlString = "UPDATE serverdb.presa
						SET 
                      	presa=if(presa!='" . $nomePresa . "','" . $nomePresa . "',presa)
						WHERE 
						id_presa='" . $idPresa . "'";
	
		$result = mysql_query($sqlString)
		or die("ERROR IN script_presa.php - FUNCTION updateServerDBPresa - ".$sqlString ." ". mysql_error());
		return $result;
	}

?>