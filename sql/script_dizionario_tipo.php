<?php
	
/**
 * Seleziona tutti i record della tabella dizionario_tipo
 * @return resource
 */
function findAllDizionarioTipo(){
	$stringSql = "SELECT * FROM serverdb.dizionario_tipo";
		
	$result = mysql_query($stringSql)
	or die("ERROR IN script_dizionario_tipo - FUNCTION  findAllDizionarioTipo - ". $stringSql." - ". mysql_error());
	return $result;
}




/**
 * Seleziona tutti i record della tabella dizionario_tipo con tipo richiesto
 * @param unknown $tipoDizionario
 * @param unknown $connessione
 * @return resource
 */
function findAllDizionarioTipoByTipoDiz($tipoDizionario, $connessione){
	$stringSql = "SELECT * FROM serverdb.dizionario_tipo WHERE dizionario_tipo = '".$tipoDizionario."'";

	$result = mysql_query($stringSql, $connessione)
	or die("ERROR IN script_dizionario_tipo - FUNCTION  findAllDizionarioTipoByTipoDiz - ". $stringSql." - ". mysql_error());
	return $result;
}





/**
 * Inserisce un nuovo record nella tabella dizionario_tipo
 * @param unknown $tipoDizionario
 * @param unknown $tabella
 * @param unknown $dataCorrente
 * @param unknown $connessione
 * @return resource
 */
function insertDizionarioTipo($tipoDizionario, $tabella, $dataCorrente, $connessione){
	$stringSql = "INSERT INTO serverdb.dizionario_tipo (dizionario_tipo, tabella,abilitato,dt_abilitato) 
				VALUES ( '".$tipoDizionario."',
						 '".$tabella."',
						 1,
						 '".$dataCorrente."')";

	$result = mysql_query($stringSql, $connessione)
	or die("ERROR IN script_dizionario_tipo - FUNCTION  findAllDizionarioTipoByTipoDiz - ". $stringSql." - ". mysql_error());
	return $result;
}






/**
 * Seleziona il campo id_diz_tipo dalla tabella dizionario_tipo con dizionario_tipo='NomeProdotto'
 * @return resource
 */
function selectIDDizionarioTipoByNomeProdotto(){
	$stringSql = "SELECT 
                                            id_diz_tipo
                                    FROM 
                                            serverdb.dizionario_tipo
                                    WHERE 
                                            dizionario_tipo='NomeProdotto'";

	$result = mysql_query($stringSql)
	or die("ERROR IN script_dizionario_tipo - FUNCTION  selectIDDizionarioTip - ". $stringSql." - ". mysql_error());
	return $result;
}







/**
 * Seleziona il campo id_diz_tipo dalla tabella dizionario_tipo con dizionario_tipo='NomeColoreBase'
 * @return resource
 */
function selectIDDizionarioTipoByNomeColoreBase(){
	$stringSql = "SELECT 
                                            id_diz_tipo
                                    FROM 
                                            serverdb.dizionario_tipo
                                    WHERE 
                                            dizionario_tipo='NomeColoreBase'";

	$result = mysql_query($stringSql)
	or die("ERROR IN script_dizionario_tipo - FUNCTION  selectIDDizionarioTipoByNomeColoreBase - ". $stringSql." - ". mysql_error());
	return $result;
}









/**
 * Seleziona il campo id_diz_tipo dalla tabella dizionario_tipo con dizionario_tipo='NomeComponente'
 * @return resource
 */
function selectIDDizionarioTipoByNomeComponente(){
	$stringSql = "SELECT 
                                                id_diz_tipo
                                        FROM 
                                                serverdb.dizionario_tipo
                                        WHERE 
                                                dizionario_tipo='NomeComponente'";

	$result = mysql_query($stringSql)
	or die("ERROR IN script_dizionario_tipo - FUNCTION  selectIDDizionarioTipoByNomeComponente - ". $stringSql." - ". mysql_error());
	return $result;
}






/**
 * Seleziona il campo id_diz_tipo dalla tabella dizionario_tipo con dizionario_tipo='MessaggioMacchina'
 * @return resource
 */
function selectIDDizionarioTipoByMessaggioMacchina(){
	$stringSql = "SELECT 
                                            id_diz_tipo
                                    FROM 
                                            serverdb.dizionario_tipo
                                    WHERE 
                                            dizionario_tipo='MessaggioMacchina'";

	$result = mysql_query($stringSql)
	or die("ERROR IN script_dizionario_tipo - FUNCTION  selectIDDizionarioTipoByMessaggioMacchina - ". $stringSql." - ". mysql_error());
	return $result;
}





/**
 * Seleziona il campo id_diz_tipo dalla tabella dizionario_tipo con dizionario_tipo='FamigliaProdotto'
 * @return resource
 */
function selectIDDizionarioTipoByFamigliaProdotto(){
	$stringSql = "SELECT 
                                                id_diz_tipo
                                        FROM 
                                                serverdb.dizionario_tipo
                                        WHERE 
                                                dizionario_tipo='FamigliaProdotto'";

	$result = mysql_query($stringSql)
	or die("ERROR IN script_dizionario_tipo - FUNCTION  selectIDDizionarioTipoByFamigliaProdotto - ". $stringSql." - ". mysql_error());
	return $result;
}
?>