<?php
//Tabelle coinvolte 
//gruppo
/*
//############# VERIFICA PERMESSO VISUALIZZAZIONE ##############################
//verificaPermessoVisualizzazione($_SESSION['objPermessiVis'], 'gruppo');
//Stringa contenente l'elenco degli id degli utenti prop visibili dall'utente loggato
echo "</br>Utenti proprietari visibili tab gruppo: ".
        $_SESSION['strUtentiVis']=getUtentiPropVisib($_SESSION['objPermessiVis'], 'gruppo');
        
//Stringa contenente l'elenco degli id delle aziende visibili dall'utente loggato
echo "</br>Aziende visibili tab gruppo : ". 
        $_SESSION['strAziendeVis']=getAziendeVisib($_SESSION['objPermessiVis'], 'gruppo');
//##############################################################################
*/
/**
 * Seleziona tutti i record della tabella gruppo visibili
 * @param type $livello1
 * @param type $livello2
 * @param type $livello3
 * @param type $livello4
 * @param type $livello5
 * @param type $livello6
 * @param type $strUtentiAziende
 * @return type
 */
function findGruppiByFiltri($livello1,$livello2,$livello3,$livello4,$livello5,$livello6,$abilitato,$dtAbilitato,$filtro,$strUtentiAziende){
	$sqlString="SELECT * FROM serverdb.gruppo WHERE (id_utente,id_azienda) IN ".$strUtentiAziende."
                
                 AND
                  livello_1 LIKE '%".$livello1."%' 
                AND 
                  livello_2 LIKE '%".$livello2."%'
                AND
                  livello_3 LIKE '%".$livello3."%'
                AND
                  livello_4 LIKE '%".$livello4."%'
                AND
                  livello_5 LIKE '%".$livello5."%'
                AND
                  livello_6 LIKE '%".$livello6."%'      
                AND
                  abilitato LIKE '%".$abilitato."%'
                AND
                  dt_abilitato LIKE '%".$dtAbilitato."%'
                 ORDER BY ".$filtro;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_gruppo.php - FUNCTION findAllFromGruppi - ".$sqlString ." ". mysql_error());
	return $sql;
}

/**
 * Seleziona il record della tabella gruppo con id=$idGruppo
 * @param unknown $idGruppo
 * @return resource
 */
function findGruppoById($idGruppo){
	$sqlString="SELECT * FROM serverdb.gruppo WHERE id_gruppo=".$idGruppo;
	
	$sql = mysql_query($sqlString)
	or die("ERROR IN script_gruppo.php - FUNCTION findGruppoById - ".$sqlString ." ". mysql_error());
	return $sql;
	
}

/**
 * Seleziona il record della tabella gruppo con primo livello=$primoLivello
 * @param unknown $primoLivello
 * @param unknown $connessione
 * @return resource
 */
function findGruppoByLiv($primoLivello, $connessione){
	$sqlString="SELECT * FROM serverdb.gruppo WHERE livello_1 = '".$primoLivello."'"; 

	$result=mysql_query($sqlString, $connessione)
	or die("ERROR IN script_gruppo.php - FUNCTION findGruppoByLiv - ".$sqlString ." ". mysql_error());
	return $result;

}

/**
 * Inserisce un nuovo recordo nella tabella gruppo
 * @param unknown $primoLivello
 * @param unknown $secondoLivello
 * @param unknown $terzoLivello
 * @param unknown $quartoLivello
 * @param unknown $quintoLivello
 * @param unknown $sestoLivello
 * @param unknown $dataCorrente
 * @param unknown $connessione
 * @return resource
 */
function insertGroup($primoLivello, $secondoLivello, $terzoLivello, $quartoLivello, $quintoLivello, $sestoLivello, $dataCorrente,$idUtente,$idAzienda){
	$sqlString="INSERT INTO serverdb.gruppo (livello_1,livello_2,livello_3,livello_4,livello_5,livello_6,abilitato,dt_abilitato,id_utente,id_azienda) 
				VALUES ( '".$primoLivello.
						"','".$secondoLivello.
						"','".$terzoLivello.
						"','".$quartoLivello.
						"','".$quintoLivello.
						"','".$sestoLivello.
						"',1,
						'".$dataCorrente."',".$idUtente.",".$idAzienda.")";

	$result=mysql_query($sqlString);
	//or die("ERROR IN script_gruppo.php - FUNCTION insertGroup - ".$sqlString ." ". mysql_error());
	return $result;

}




/**
 * Seleziona il record della tabella gruppo con primo livello=$primoLivello e id_gruppo<>".$idGruppo
 * @param unknown $IdGruppo
 * @param unknown $PrimoLivello
 * @param unknown $connessione
 * @return resource
 */
function findGruppoByLivAndId($idGruppo, $primoLivello){
	$sqlString="SELECT * FROM serverdb.gruppo 
				WHERE 
					livello_1 = '".$primoLivello."'
				AND
					id_gruppo<>".$idGruppo;

	$result=mysql_query($sqlString)
	or die("ERROR IN script_gruppo.php - FUNCTION findGruppoByLivAndId - ".$sqlString ." ". mysql_error());
	return $result;

}


/**
 * Inserisce un nuovo record nel db storico
 * @param unknown $id_gruppo_old
 * @param unknown $livello_1_old
 * @param unknown $livello_2_old
 * @param unknown $livello_3_old
 * @param unknown $livello_4_old
 * @param unknown $livello_5_old
 * @param unknown $livello_6_old
 * @param unknown $abilitato
 * @param unknown $dataCorrente
 * @return resource
 */
function insertStoricoGruppo($id_gruppo_old, $livello_1_old, $livello_2_old, $livello_3_old,
		 $livello_4_old, $livello_5_old, $livello_6_old, $abilitato, $dataCorrente){
	$sqlString="INSERT INTO storico.gruppo						 										
								(id_gruppo,
								livello_1,
								livello_2,
								livello_3,
								livello_4,
								livello_5,
								livello_6,
								abilitato,
								dt_abilitato) 
						VALUES(".$id_gruppo_old.",
							   '".$livello_1_old."',
							   '".$livello_2_old."',
							   '".$livello_3_old."',
							   '".$livello_4_old."',
							   '".$livello_5_old."',
							   '".$livello_6_old."',
							   '".$abilitato."',
							   '".$dataCorrente."')";

	$result=mysql_query($sqlString);
	//or die("ERROR IN script_gruppo.php - FUNCTION insertStoricoGruppo - ".$sqlString ." ". mysql_error());
	return $result;

}


/**
 * Modifico il record nella tabella corrente [gruppo] di serverdb
 * @param unknown $idGruppo
 * @param unknown $primoLivello
 * @param unknown $secondoLivello
 * @param unknown $terzoLivello
 * @param unknown $quartoLivello
 * @param unknown $quintoLivello
 * @param unknown $sestoLivello
 * @param unknown $dataCorrente
 * @return resource
 */
function updateServerDBGruppo($idGruppo, $primoLivello, $secondoLivello, $terzoLivello, $quartoLivello, $quintoLivello, $sestoLivello, $dataCorrente ){
	$sqlString="UPDATE serverdb.gruppo
					SET 
						livello_1='".$primoLivello."',
						livello_2='".$secondoLivello."',
						livello_3='".$terzoLivello."',
						livello_4='".$quartoLivello."',
						livello_5='".$quintoLivello."',
						livello_6='".$sestoLivello."',
						dt_abilitato='".$dataCorrente."'
					WHERE 
						id_gruppo='".$idGruppo."'";

	$result=mysql_query($sqlString);
	//or die("ERROR IN script_gruppo.php - FUNCTION updateServerDBGruppo - ".$sqlString ." ". mysql_error());
	return $result;

}



/**
 * Aggiorna il campo secondo livello del record della tabella gruppo del db server
 * @param unknown $secondoLivello
 * @param unknown $livello_2_old
 * @return resource
 */
function updateSecondoLivelloGruppo($secondoLivello, $livello_2_old ){
	$sqlString="UPDATE serverdb.gruppo
						SET 
							livello_2='".$secondoLivello."'
						WHERE 
							livello_2='".$livello_2_old."'";

	$result=mysql_query($sqlString)
	or die("ERROR IN script_gruppo.php - FUNCTION updateSecondoLivelloGruppo - ".$sqlString ." ". mysql_error());
	return $result;
}

/**
 * Aggiorna il campo terzo livello del record della tabella gruppo del db server
 * @param unknown $terzoLivello
 * @param unknown $livello_3_old
 * @return resource
 */
function updateTerzoLivelloGruppo($terzoLivello, $livello_3_old ){
	$sqlString="UPDATE serverdb.gruppo
						SET
							livello_3='".$terzoLivello."'
						WHERE
							livello_3='".$livello_3_old."'";

	$result=mysql_query($sqlString)
	or die("ERROR IN script_gruppo.php - FUNCTION updateTerzoLivelloGruppo - ".$sqlString ." ". mysql_error());
	return $result;
}

/**
 * Aggiorna il campo quarto livello del record della tabella gruppo del db server
 * @param unknown $quartoLivello
 * @param unknown $livello_4_old
 * @return resource
 */
function updateQuartoLivelloGruppo($quartoLivello, $livello_4_old ){
	$sqlString="UPDATE serverdb.gruppo
						SET
							livello_4='".$quartoLivello."'
						WHERE
							livello_4='".$livello_4_old."'";

	$result=mysql_query($sqlString)
	or die("ERROR IN script_gruppo.php - FUNCTION updateQuartoLivelloGruppo - ".$sqlString ." ". mysql_error());
	return $result;
}

/**
 * Aggiorna il campo quinto livello del record della tabella gruppo del db server
 * @param unknown $quintoLivello
 * @param unknown $livello_5_old
 * @return resource
 */
function updateQuintoLivelloGruppo($quintoLivello, $livello_5_old ){
	$sqlString="UPDATE serverdb.gruppo
						SET
							livello_5='".$quintoLivello."'
						WHERE
							livello_5='".$livello_5_old."'";

	$result=mysql_query($sqlString)
	or die("ERROR IN script_gruppo.php - FUNCTION updateQuintoLivelloGruppo - ".$sqlString ." ". mysql_error());
	return $result;
}

/**
 * Aggiorna il campo sesto livello del record della tabella gruppo del db server
 * @param unknown $sestoLivello
 * @param unknown $livello_6_old
 * @return resource
 */
function updateSestoLivelloGruppo($sestoLivello, $livello_6_old ){
	$sqlString="UPDATE serverdb.gruppo
						SET
							livello_6='".$sestoLivello."'
						WHERE
							livello_6='".$livello_6_old."'";

	$result=mysql_query($sqlString)
	or die("ERROR IN script_gruppo.php - FUNCTION updateSestoLivelloGruppo - ".$sqlString ." ". mysql_error());
	return $result;
}


/**
 * Seleziona un dato campo dalla tabella gruppo raggruppando
 * @param type $campo
 * @return type
 */
function selectCampoByNome($campo,$stringUtAziende){
    
$sqlString="SELECT DISTINCT(".$campo.")AS ".$campo." 
        FROM serverdb.gruppo 
    WHERE 
        ".$campo." IS NOT NULL 
     AND 
        ".$campo."<>'' 
     AND 
        (id_utente,id_azienda) IN ".$stringUtAziende."       
    ORDER BY ".$campo.""; 
        $result=mysql_query($sqlString)
	or die("ERROR IN script_gruppo.php - FUNCTION selectCampoByNome - ".$sqlString ." ". mysql_error());
	return $result;                      
}


/**
 * Aggiorna un dato campo della tabella gruppo del db server
 * @param unknown $nomeCampo
 * @param unknown $valore
 * @param unknown $valoreOld
 * @return resource
 */
function updateCampoGruppo($nomeCampo,$valore, $valoreOld ){
	$sqlString="UPDATE serverdb.gruppo
                    SET
                            ".$nomeCampo."='".$valore."'
                    WHERE
                            ".$nomeCampo."='".$valoreOld."'";

	$result=mysql_query($sqlString);
	//or die("ERROR IN script_gruppo.php - FUNCTION updateCampoGruppo - ".$sqlString ." ". mysql_error());
	return $result;
}
?>