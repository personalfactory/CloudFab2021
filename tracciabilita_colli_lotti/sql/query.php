<?php

/**
 * Restituisce la lista dei colli
 * @param 
 * @return $sql
 */
function recuperaElencoColli() {
	global $dbname;
    
	mysql_query("USE ".$dbname . mysql_error());
	$stringSql = "SELECT * FROM colli where abilitato=1"; 
    $sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  recuperaElencoColli - " . $stringSql . " - " . mysql_error());
    return $sql;
} 


function recuperaDateBolla($numDoc) {
	global $dbname;
    
	mysql_query("USE ".$dbname . mysql_error());
	$stringSql = "SELECT * FROM serverdb.gaz_movmag WHERE num_doc=".$numDoc.";";
    $sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  recuperaDateBolla - " . $stringSql . " - " . mysql_error());
    return $sql;
} 

function recuperaIdMaxColli() {
	global $dbname;
    
	 mysql_query("USE ".$dbname . mysql_error());
	$stringSql = "SELECT * FROM serverdb.colli WHERE id = (SELECT MAX(id) FROM serverdb.colli);"; 
    $sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  recuperaIdMaxColli - " . $stringSql . " - " . mysql_error()); 
	

    return $sql;
} 
 

function insertCollo($idCollo, $codiceCollo, 
						$dataCollo,
						$altezzaCollo,
						$larghezzaCollo, 
						$profonditaCollo,
						$pesoCollo,
						$info1collo,
						$info2collo,
						$info3collo,
						$info4collo,
						$info5collo,
						$idUtente, 
						$idAzienda) {
	
	date_default_timezone_set('UTC'); 
	$dt_abilitato =  date('y-m-d h:i:s');
	
	$stringSql = "INSERT INTO serverdb.colli VALUES(
					$idCollo, 
					'$codiceCollo', 
					'$dataCollo', 
					'$dt_abilitato', 
					'0', 
					'', 
					'', 
					'1', 
					'$altezzaCollo', 
					'$larghezzaCollo',
					'$profonditaCollo',
					'$pesoCollo', 
					'$info1collo',
					'$info2collo', 
					'$info3collo', 
					'$info4collo', 
					'$info5collo', 
					'$idUtente', 
					'$idAzienda');"; 
	 
	$sql1 = $stringSql; 
    $sql = mysql_query($stringSql)
            or die("ERROR IN query.php - FUNCTION insertCollo - " . $stringSql . " - " . mysql_error());
    return $sql1;
}
 
function updateCollo($idCollo,
					 $codiceCollo, 
						$dataCollo,
						$altezzaCollo,
						$larghezzaCollo, 
						$profonditaCollo,
						$pesoCollo,
						$info1Collo,
						$info2Collo,
						$info3Collo,
						$info4Collo,
						$info5Collo) {
	
	date_default_timezone_set('UTC'); 
	$dt_abilitato =  date('y-m-d h:i:s'); 
	
	$stringSql = "UPDATE serverdb.colli SET codice_collo = '$codiceCollo', 
					data = '$dataCollo',
					dt_abilitato = '$dt_abilitato',   
					altezza = '$altezzaCollo', 
					larghezza = '$larghezzaCollo', 
					profondita = '$profonditaCollo',
					peso = '$pesoCollo',
					info1 = '$info1Collo', 
					info2 = '$info2Collo', 
					info3 = '$info3Collo', 
					info4 = '$info4Collo',
					info5 = '$info5Collo' WHERE id = '$idCollo'";
	  
    $sql = mysql_query($stringSql)
            or die("ERROR IN query.php - FUNCTION insertCollo - " . $stringSql . " - " . mysql_error());
    return $sql;
}


function disabilitaCollo($idCollo) {
	
	$stringSql = "UPDATE serverdb.collo_lotti SET abilitato = 0 WHERE id_collo='$idCollo'";
	  
    $sql = mysql_query($stringSql)
            or die("ERROR IN query.php - FUNCTION disabilitaCollo - " . $stringSql . " - " . mysql_error());
	  
	$stringSql = "UPDATE serverdb.colli SET abilitato = 0 WHERE id='$idCollo'";
	  
    $sql = mysql_query($stringSql)
            or die("ERROR IN query.php - FUNCTION disabilitaCollo - " . $stringSql . " - " . mysql_error());
	
	 
    return $sql;
}


function disabilitaColloLotti($codiceLotto)  {
	 
	$stringSql = "UPDATE serverdb.collo_lotti SET abilitato = 0 WHERE cod_lotto='$codiceLotto'";
	  
    $sql = mysql_query($stringSql)
            or die("ERROR IN query.php - FUNCTION disabilitaColloLotti - " . $stringSql . " - " . mysql_error());
    return $sql;
}
	
function insertColloLotti($idCollo, $codiceLotto) {
	
	date_default_timezone_set('UTC'); 
	$dt_abilitato =  date('y-m-d h:i:s');
	
	$stringSql = "INSERT INTO serverdb.collo_lotti VALUES(
					'', 
					'$idCollo', 
					'$codiceLotto', 
					'1',
					'$dt_abilitato');"; 
	 
	$sql1 = $stringSql; 
    $sql = mysql_query($stringSql)
            or die("ERROR IN query.php - FUNCTION insertColloLotto - " . $stringSql . " - " . mysql_error());
    return $sql1;
}
 
function recuperaInfoCollo($idCollo) {
	global $dbname;
    
	 mysql_query("USE ".$dbname . mysql_error());
	$stringSql = "SELECT * FROM serverdb.colli WHERE id ='".$idCollo."' AND abilitato = 1;"; 
    $sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  recuperaIdMaxColli - " . $stringSql . " - " . mysql_error()); 
    return $sql;
} 


function recuperaLottiCollo($idCollo) {
	global $dbname;
    
	 mysql_query("USE ".$dbname . mysql_error());
	$stringSql = "SELECT * FROM serverdb.collo_lotti WHERE id_collo ='".$idCollo."' AND abilitato=1;"; 
    $sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  recuperaLottiCollo - " . $stringSql . " - " . mysql_error()); 
    return $sql;
} 


function recuperaLottiColloCodice($codiceCollo) {
	global $dbname;
    
	 mysql_query("USE ".$dbname . mysql_error()); 
	$stringSql = "SELECT collo_lotti.* FROM colli INNER JOIN collo_lotti ON colli.id = collo_lotti.id_collo WHERE colli.codice_collo = '".$codiceCollo."' AND collo_lotti.abilitato=1;";
	$sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  recuperaLottiCollo - " . $stringSql . " - " . mysql_error()); 
    return $sql;
} 



function trovaInfoMovByDdtCatMer($numDdt,$dataEmi,$catMer){

		$stringSql = "SELECT * FROM serverdb.gaz_movmag 
                                  WHERE 
                                      num_doc='" . $numDdt . "' 
                                    AND 
                                      dt_doc='" . $dataEmi . "'
                                    AND 
                                      cat_mer='" . $catMer . "'";
     
		$sql= mysql_query($stringSql) or die("ERROR IN script_gaz_movmag - FUNCTION findInfoMovByDdtCatMer - ".$stringSql ." - ". mysql_error());
    return $sql;
    
}

function trovaMacchinaByCodice($codiceStab) {
    $stringSql = "SELECT * FROM serverdb.macchina WHERE cod_stab='" . $codiceStab . "'";
	
    $sql = mysql_query($stringSql) or die("ERROR IN FUNCTION findMacchinaByCodice - " . $stringSql . " - " . mysql_error());
	  
    return $sql;
}


function inserisciDdtInBolla($numDdt,$dataEmi,$codStab,$idMacchina){

  $stringSql = "INSERT INTO serverdb.bolla (num_bolla,dt_bolla,cod_stab,id_macchina) 
                        VALUES(
                              '" . $numDdt . "',
                              '" . $dataEmi . "',
                              '" . $codStab . "',
                              '" . $idMacchina . "')";
  
  $sql = mysql_query($stringSql)
	  or die("ERROR IN FUNCTION inserisciDdtInBolla - ". $stringSql." - ". mysql_error());

  
  return $sql;
}

function findDdtInBolla($numDdt,$dataEmi){
    $stringSql="SELECT * FROM serverdb.bolla
                                      WHERE
                                        num_bolla='" . $numDdt . "' 
                                      AND 
                                        dt_bolla='" . $dataEmi . "'";
    
     $sql = mysql_query($stringSql)
               or die("ERROR IN script_bolla.php - FUNCTION findDdtInBolla - ". $stringSql." - ". mysql_error());
     return $sql;
}


function updateLottoAssociaDdt($idBolla,$numDdt,$dataEmi,$codiceLotto,$valParent){

	$stringSql = "UPDATE serverdb.lotto 
					SET 
					id_bolla=" . $idBolla . ",
					num_bolla='" . $numDdt . "',
					dt_bolla='" . $dataEmi . "',
					parent='".$valParent."'    
					WHERE 
					cod_lotto = '" . $codiceLotto . "'
					AND 
					id_bolla is null
					AND 
					num_bolla is null
					AND 
					dt_bolla is null";


	$sql = mysql_query($stringSql)
		or die("ERROR IN script_lotto.php - FUNCTION updateLottoAssociaDdt - " . $stringSql . " " . mysql_error());

	return $sql;

}

function updateColloLotto($numDdt,$dataEmi,$codiceCollo){

	$stringSql = "UPDATE serverdb.colli SET 
						associato=1, 
						num_bolla='" . $numDdt . "', 
						dt_bolla='" . $dataEmi . "', 
						abilitato='1' 
					WHERE  
						codice_collo = '" . $codiceCollo . "'"; 
	
	$sql = mysql_query($stringSql) or die("ERROR IN script_lotto.php - FUNCTION updateColloLotto - " . $stringSql . " " . mysql_error());

	return $sql;

}

function verificaLotto($codiceLotto) {
	global $dbname;
   
	mysql_query("USE ".$dbname . mysql_error()); 
	
	$stringSql = "SELECT * FROM lotto WHERE lotto.cod_lotto ='".$codiceLotto."' AND lotto.id_bolla is null AND lotto.num_bolla is null AND lotto.dt_bolla is null;";

	$sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  verificaLotto - " . $stringSql . " - " . mysql_error()); 
    return $sql;
}

function verificaLottoImpegnato($codiceLotto) {
	global $dbname;

	mysql_query("USE ".$dbname . mysql_error());

	$stringSql = "SELECT * FROM collo_lotti WHERE cod_lotto ='".$codiceLotto."' AND abilitato=1;";

	$sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  verificaLotto - " . $stringSql . " - " . mysql_error());
    return $sql;
}
function verificaCollo($codiceCollo) {
	global $dbname;
   
	mysql_query("USE ".$dbname . mysql_error()); 
	
	$stringSql = "SELECT * FROM serverdb.colli WHERE codice_collo='".$codiceCollo."'  AND associato=0 AND abilitato=1;";
	
	$sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  verificaLotto - " . $stringSql . " - " . mysql_error()); 
    return $sql;
} 



function verificaBollaData($NumDdt,$DataEmi){

	global $dbname;
   	mysql_query("USE ".$dbname . mysql_error()); 
	 
	$stringSql =  "SELECT * FROM serverdb.bolla WHERE num_bolla='" . $NumDdt . "' AND  dt_bolla='" . $DataEmi . "'";
	 
	$sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  verificaBollaData - " . $stringSql . " - " . mysql_error()); 
	
	
      
	return $sql;
}

function getCounterColli($Data){

	global $dbname;
   	mysql_query("USE ".$dbname . mysql_error()); 
	 
	$stringSql =  "SELECT * FROM serverdb.colli WHERE colli.data LIKE '%". $Data . "%'";
	  
	 $sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  verificaBollaData - " . $stringSql . " - " . mysql_error()); 
	 
	return $sql;
}

function recuperaIdProdottoByCodice($codiceProdotto) {
	global $dbname; 
	mysql_query("USE ".$dbname . mysql_error()); 
	 
	$stringSql = "SELECT * FROM prodotto WHERE cod_prodotto='".$codiceProdotto."' AND abilitato = 1"; 
	$sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  recuperaIdProdottoByCodice - " . $stringSql . " - " . mysql_error()); 
    return $sql;
} 

function recuperaDizionarioByIdProdotto($idProdotto) {
	global $dbname; 
	mysql_query("USE ".$dbname . mysql_error()); 
	 
	$stringSql = "SELECT * FROM dizionario WHERE id_vocabolo = '".$idProdotto."' AND id_diz_tipo = 1 AND abilitato = 1"; 
	$sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  recuperaIdProdottoByCodice - " . $stringSql . " - " . mysql_error()); 
    return $sql;
}

 



?> 