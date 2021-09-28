<?php
//Tabelle coinvolte 
//codice
       

//##############################################################################
//##################### SERVERDB ###############################################
//##############################################################################

/**
 * Seleziona tutti i tipi di codici dalla tabella codice visibili all'utente
 * visibili all'utente corrente
 * @return type
 */
function findAllCodiceVis($campoOrdine,$strUtentiAziende){
$sqlString="SELECT * FROM serverdb.codice 
            WHERE
                    (id_utente,id_azienda) IN ".$strUtentiAziende."  
            ORDER BY ".$campoOrdine;
$sql = mysql_query($sqlString) 
        or die("ERROR IN script_codice.php - FUNCTION findAllCodiceVis - " .$sqlString." ". mysql_error());

return $sql;
}

/**
 * Seleziona tutti i tipi di codici dalla tabella codice
 * visibili all'utente corrente
 * @return type
 */
function findAllCodice2($campoOrdine,$strUtentiAziende){
$sqlString="SELECT * FROM serverdb.codice 
            WHERE
                    id_utente IN ".  $strUtenti."
                  AND 
                    id_azienda IN ".$strAziende."
            ORDER BY ".$campoOrdine;
$sql = mysql_query($sqlString) 
        or die("ERROR IN script_codice.php - FUNCTION findAllCodice2 - " .$sqlString." ". mysql_error());

return $sql;
}


/**
 * Seleziona tutti i tipi di codici dalla tabella codice
 * @return type
 */
function findAllCodice($campoOrdine){
$sqlString="SELECT * FROM serverdb.codice ORDER BY ".$campoOrdine;
$sql = mysql_query($sqlString) 
        or die("ERROR IN script_codice.php - FUNCTION findAllCodice - " .$sqlString." ". mysql_error());

return $sql;
}


/**
 * Seleziona una famiglia dalla tabella codice per id_codice
 * @param type $idCodice
 * @return type
 */
function findFamigliaByIdCodice($idCodice){    
    $sqlString="SELECT * FROM serverdb.codice WHERE id_codice=".$idCodice;                    
 
    $sql=mysql_query($sqlString)
   or die("ERROR IN script_codice.php - FUNCTION findFamigliaByIdCodice - " . $sqlString . mysql_error());
    return $sql;
}



/**
 * Verifica l'esistenza di una famiglia all'interno della tabella codice
 * verifica che non ci sia una famiglia con stesso codice e id diverso 
 * @param type $idCodice
 * @param type $tipoCodice
 * @return type
 */
function verificaEsistenzaFamiglia($idCodice,$tipoCodice){
    
   $sqlString="SELECT * FROM serverdb.codice 
				WHERE 
					(tipo_codice = '".$tipoCodice."' AND id_codice<>".$idCodice.")";                    
 
    $sql=mysql_query($sqlString);
     //or die("ERROR IN script_codice.php - FUNCTION verificaEsistenzaFamiglia - " . $sqlString . mysql_error());
    return $sql;
    
}


//##############################################################################
//##################### STORICO ################################################
//##############################################################################

/**
 * Inserimento di un record nella tabella codice del db storico
 * @param type $idCodice
 * @return type
 */
function insertStoricoCodice($idCodice){
    
    $sqlString="INSERT INTO storico.codice 						 										
				(id_codice,tipo_codice,descrizione,abilitato,dt_abilitato) 
					SELECT 
						id_codice,
						tipo_codice,
						descrizione,
						abilitato,
						dt_abilitato
					FROM 
						serverdb.codice
					WHERE
						id_codice='".$idCodice."'";
					  
        $sql=mysql_query($sqlString);
   //or die("ERROR IN script_codice.php - FUNCTION insertStoricoCodice - " . $sqlString . mysql_error());
    return $sql;
}


/**
 * Modifica un record della tabella codice
 * @param type $idCodice
 * @param type $tipoCodice
 * @param type $descrizione
 * @param type $dtAbilitato
 * @return type
 */
function updateCodice($idCodice,$tipoCodice,$descrizione,$dtAbilitato,$idAzienda){
    
    
    $sqlString="UPDATE serverdb.codice 
                SET 
                   tipo_codice='".$tipoCodice."',
                   descrizione='".$descrizione."',
                   dt_abilitato='".$dtAbilitato."',
                   id_azienda=".$idAzienda."    
                WHERE 
                    id_codice='".$idCodice."'";
    
     $sql=mysql_query($sqlString);
   //or die("ERROR IN script_codice.php - FUNCTION updateCodice - " . $sqlString . mysql_error());
    return $sql;   
}


//#######################FATTE DA FRANCESCO


/**
 * Seleziona i record della tabella codice con tipo_codice desiderato
 * @param unknown $tipoCodice
 * @param unknown $connessione
 * @return resource
 */
function findCodiceByTipo($tipoCodice){
	$sqlString="SELECT * FROM serverdb.codice WHERE tipo_codice = '".$tipoCodice."'";
	
	$sql=mysql_query($sqlString)
	or die("ERROR IN script_codice.php - FUNCTION findCodiceByTipo - " . $sqlString . mysql_error());
	return $sql;

}








/**
 * Inserisce un nuovo record nella tabella codice
 * @param unknown $tipoCodice
 * @param unknown $descrizione
 * @param unknown $dataCorrente
 * @param unknown $connessione
 * @return resource
 * @author FR
 */
function insertCodice($tipoCodice, $descrizione, $dataCorrente,$idUtente,$idAzienda){
	$sqlString="INSERT INTO serverdb.codice (tipo_codice, descrizione,abilitato,dt_abilitato,id_utente,id_azienda) 
				VALUES ( '".$tipoCodice.
						"','".$descrizione.
						"',1,
						   '".$dataCorrente."',
                                                       ".$idUtente.",
                                                           ".$idAzienda.")";

	$sql=mysql_query($sqlString);
	//or die("ERROR IN script_codice.php - FUNCTION insertCodice - " . $sqlString . mysql_error());
	return $sql;

}



?>
