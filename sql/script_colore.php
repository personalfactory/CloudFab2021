<?php

//Tabelle coinvolte
//colore

/**
 * Seleziona tutti i colori visibili all'utente dalla tabella colore
 * @param type $strUtentiVis
 * @param type $strAziendeVis
 * @param type $campoOrdine
 * @return type
 */
function findAllColoreVis($strUtentiAziende,$campoOrdine){
	$sqlString="SELECT * FROM serverdb.colore 
            WHERE (id_utente,id_azienda) IN ".$strUtentiAziende."
               
            ORDER BY ".$campoOrdine;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_colore.php - FUNCTION findAllColoreVis - ".$sqlString ." ". mysql_error());
	return $sql;
}
/**
 * Seleziona tutti i record della tabella colore ordinati per nome
 * @return resource
 */
function findAllColore(){
	$sqlString="SELECT * FROM serverdb.colore ORDER BY nome_colore";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_colore.php - FUNCTION findAllFromColore - ".$sqlString ." ". mysql_error());
	return $sql;
}





/**
 * Seleziona il record della tabella colore con cod_colore = $codiceColoreo nome_colore = $nomeColore
 * @param unknown $nomeColore
 * @param unknown $codiceColore
 * @param unknown $connessione
 * @return resource
 */
function findColoreByNameOrCod($nomeColore, $codiceColore, $connessione){
	$sqlString="SELECT * FROM serverdb.colore 
                WHERE 
                    nome_colore = '" . $nomeColore . "' 
                OR 
                    cod_colore = '" . $codiceColore . "'";

	$sql = mysql_query($sqlString, $connessione)
	or die("ERROR IN script_colore.php - FUNCTION findColoreByNameOrCod - ".$sqlString ." ". mysql_error());
	return $sql;
}





/**
 * Seleziona un record dalla tabella colore con id_colore=$IdColore
 * @param unknown $idColore
 * @return resource
 */
function findColoreId($idColore){
	$sqlString="SELECT * FROM serverdb.colore WHERE id_colore=" . $idColore;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_colore.php - FUNCTION findColoreId - ".$sqlString ." ". mysql_error());
	return $sql;
}





/**
 * Seleziona tutti i record della tabella colore con cod_colore = $codiceColore e nome_colore = $nomeColore
 * @param unknown $idColore
 * @param unknown $nomeColore
 * @param unknown $codiceColore
 * @param unknown $connessione
 * @return resource
 */
function findColoreByCodiceAndName($idColore, $nomeColore, $codiceColore, $connessione){
	$sqlString="SELECT * FROM serverdb.colore 
				WHERE 
					cod_colore = '".$codiceColore."' 
				AND 
					nome_colore = '".$nomeColore."'
				AND 
					id_colore<>".$idColore;

	$sql = mysql_query($sqlString, $connessione)
	or die("ERROR IN script_colore.php - FUNCTION findColoreByCodiceAndName - ".$sqlString ." ". mysql_error());
	return $sql;
}




/**
 * Inserisce un nuovo record nella tabella colore del db storico
 * @param unknown $idColore
 * @return resource
 */
function insertStoricoColore($idColore){
	$sqlString="INSERT INTO storico.colore 						 										
				(id_colore,cod_colore,nome_colore,abilitato,dt_abilitato) 
					SELECT 
						id_colore,
						cod_colore,
						nome_colore,
						abilitato,
						dt_abilitato
					FROM 
						serverdb.colore
					WHERE
						id_colore='".$idColore."'";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_colore.php - FUNCTION insertStoricoColore - ".$sqlString ." ". mysql_error());
	return $sql;
}

/**
 * Aggiorna il record nella tabella colore di serverdb selezionato per ID
 * @param unknown $IdColore
 * @param unknown $NomeColore
 * @param unknown $CodiceColore
 * @return resource
 */
function updateServerDBColore($IdColore, $NomeColore, $CodiceColore,$idAzienda){
	$sqlString= "UPDATE serverdb.colore 
						SET 
                                                    cod_colore=if(cod_colore!='".$CodiceColore."','".$CodiceColore."',cod_colore),
                                                    nome_colore=if(nome_colore!='".$NomeColore."','".$NomeColore."',nome_colore),
                                                    id_azienda=if(id_azienda!='".$idAzienda."','".$idAzienda."',id_azienda)
						WHERE 
                                                    id_colore='".$IdColore."'";
	
	$sql = mysql_query($sqlString)
	or die("ERROR IN script_colore.php - FUNCTION updateServerDBColore - ".$sqlString ." ". mysql_error());
	return $sql;
	
}





/**
 * Inserisce un nuovo colore nella tabella colore
 * @param type $nomeColore
 * @param type $codiceColore
 * @param type $dataCorrente
 * @param type $idUtente
 * @param type $idAzienda
 * @return type
 */
function insertColore($nomeColore, $codiceColore, $dataCorrente,$idUtente,$idAzienda){
	$sqlString="INSERT INTO serverdb.colore (cod_colore, nome_colore,abilitato,dt_abilitato,id_utente,id_azienda) 
				VALUES ( '" . $codiceColore .
                                        "','" . $nomeColore .
                                        "',1,
                                        '" . $dataCorrente . "',
                                            ".$idUtente.",".$idAzienda.")";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_colore.php - FUNCTION insertColore - ".$sqlString ." ". mysql_error());
	return $sql;
}





?>