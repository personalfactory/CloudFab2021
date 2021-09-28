<?php

/**
 * Seleziona tutte le persone diverse da un certo tipo
 * @param type $tipo
 * @param type $ordine
 * @return type
 */
function selectPersoneDiverseDa($tipo,$ordine) {

  $sql = mysql_query("SELECT * FROM serverdb.persona WHERE tipo <>'".$tipo."'
                          ORDER BY ".$ordine) 
          or die("ERROR IN script_persona - FUNCTION selectAllPersoneDiverseDa - SELECT * FROM serverdb.persona WHERE tipo <> : " . mysql_error());

  return $sql;
}


/**
 * Seleziona tutte le persone di un certo tipo
 * @param type $tipo
 * @param type $ordine
 * @param type $strUtentiAziende
 * @return type
 */
function findPersoneByTipoVis($tipo,$ordine,$strUtentiAziende) {

    $stringSql="SELECT * FROM serverdb.persona 
                        WHERE 
                                tipo ='".$tipo."' 
                            AND 
                                (id_utente,id_azienda) IN ".$strUtentiAziende." 
                            
                        ORDER BY ".$ordine;
  $sql = mysql_query($stringSql) 
          or die("ERROR IN script_persona - FUNCTION selectPersoneByTipo - " .$stringSql. " - ".mysql_error());

  return $sql;
}


/**
 * Seleziona tutte le persone di un certo tipo
 * @param type $tipo
 * @param type $ordine
 * @return type
 */
function selectPersoneByTipo($tipo,$ordine) {

  $sql = mysql_query("SELECT * FROM serverdb.persona WHERE tipo ='".$tipo."'
                          ORDER BY ".$ordine) 
          or die("ERROR IN script_persona - FUNCTION selectPersoneByTipo - SELECT * FROM serverdb.persona  : " . mysql_error());

  return $sql;
}







/**
 * Seleziona tutti i tipi di persona
 * @return resource
 */
function findAllTipoPersona(){
	$stringSql ="SELECT	*
			FROM
                            serverdb.persona
                        GROUP BY tipo
                        ORDER BY tipo ";
	$sql=  mysql_query($stringSql)
	or die("ERROR IN script_persona - FUNCTION findAllTipoPersona - " .$stringSql." - ". mysql_error());
	return $sql;
}





/**
 * Verifica se esiste già un nominativo presente nel db server
 * @param unknown $nome
 * @return resource
 */
function verificaEsistenzaNominativo($nome){
	$stringSql = "SELECT * FROM serverdb.persona
        WHERE nominativo = '" . $nome."'";
	
	$sql= mysql_query($stringSql);
	//   or  die("ERROR IN script_persona - FUNCTION verificaEsistenzaNominativo - " .$stringSql." - ". mysql_error());

	return $sql;
}


/**
 * Inserisce un nuovo record
 * @param unknown $tipo
 * @param unknown $nome
 * @param unknown $descrizione
 * @param unknown $data
 * @return resource
 */
function insertPersona($tipo, $nome, $descrizione, $data,$idUtente,$idAzienda){
	$stringSql ="INSERT INTO serverdb.persona
			(tipo, nominativo, descrizione, dt_abilitato,id_utente,id_azienda)
			VALUES 	   ('" . $tipo . "',
                        '" . $nome . "',
                        '" . $descrizione . "',
                        '" . $data . "',
                            ".$idUtente.",
                                ".$idAzienda.")"; 
	
	$sql=  mysql_query($stringSql)
	or die("ERROR IN script_persona - FUNCTION insertPersona - " .$stringSql." - ". mysql_error());
	return $sql;
}


function selectPersoneByFiltri($campoOrdine, $campoGroupBy, $idPersona, $nominativo, $descrizione, $tipo, $dtAbilitato,$strUtentiAziende) {

    $stringSql="SELECT * FROM serverdb.persona p
         WHERE
            id_persona LIKE '%" . $idPersona . "%'
         AND
            nominativo LIKE '%" . $nominativo . "%'
         AND
            descrizione LIKE '%" . $descrizione . "%'
         AND
            tipo LIKE '%" . $tipo . "%'
         AND
            dt_abilitato LIKE '%" . $dtAbilitato . "%'
         AND 
            (id_utente,id_azienda) IN ".$strUtentiAziende."
          
         GROUP BY " . $campoGroupBy . "
         ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_persona - FUNCTION selecPersoneByFiltri - ". $stringSql." - ". mysql_error());

    return $sql;
}

/**
 * Elimina un record nella tabella persona
 * @param type $idPersona
 * @return type
 */
function eliminaPersonaById($idPersona){
$stringSql="DELETE FROM serverdb.persona WHERE id_persona=".$idPersona;

 $sql=mysql_query($stringSql); 
          //or die("ERROR IN script_persona.php - FUNCTION eliminaPersonaById - " .$stringSql." - " .mysql_error());
          
          return $sql;


}


/**
 * Trova un record nella tabella persona
 * @param type $idPersona
 * @return type
 */
function findPersonaById($idPersona){
$stringSql="SELECT * FROM serverdb.persona WHERE id_persona=".$idPersona;

 $sql=mysql_query($stringSql); 
          //or die("ERROR IN script_persona.php - FUNCTION findPersonaById - " .$stringSql." - " .mysql_error());
          
          return $sql;


}


  
/**
 * Trova un record nella tabella persona
 * @param type $idPersona
 * @return type
 */
function  updatePersona($idPersona, $nominativo, $descrizione, $tipo, $idAzienda){
$stringSql="UPDATE serverdb.persona SET nominativo='".$nominativo."',descrizione='".$descrizione."',"
        . "tipo='".$tipo."',id_azienda='".$idAzienda."' WHERE id_persona=".$idPersona;

 $sql=mysql_query($stringSql); 
          //or die("ERROR IN script_persona.php - FUNCTION findPersonaById - " .$stringSql." - " .mysql_error());
          
          return $sql;


}


?>
