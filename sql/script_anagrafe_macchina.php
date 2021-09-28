<?php
//Tabelle coinvolte 

//##############################################################################
//##################### SERVERDB ###############################################
//##############################################################################
/**
 * Seleziona dalla tabella anagrafe_macchina di serverdb l'id di una macchina ed inserisce le 
 * informazioni anagrafiche nella tabella anagrafe_macchina
 * @param type $idClienteGaz
 * @param type $geografico
 * @param type $tipoRiferimento
 * @param type $gruppo
 * @param type $livelloGruppo
 * @param type $idLingua
 * @param type $abilitato
 * @param type $dtAbilitato
 * @param type $codiceStab
 * @return type
 */
function insertNewAnMac($idClienteGaz,$geografico,$tipoRiferimento,$gruppo,$livelloGruppo,$idLingua,$abilitato,$dtAbilitato,$codiceStab){

$stringSql = "INSERT INTO serverdb.anagrafe_macchina (
                                                id_macchina,
                                                id_cliente_gaz,
                                                geografico,
                                                tipo_riferimento,
                                                gruppo,
                                                livello_gruppo,
                                                id_lingua,
                                                abilitato,
                                                dt_abilitato) 
					SELECT
                                                    id_macchina,
                                                    '" . $idClienteGaz . "',
                                                    '" . $geografico . "',
                                                    '" . $tipoRiferimento . "',
                                                    '" . $gruppo . "',
                                                    '" . $livelloGruppo . "',
                                                    " . $idLingua . ",
                                                    " . $abilitato . ",
                                                    '" . $dtAbilitato . "'
						FROM
							serverdb.macchina
						WHERE 
							cod_stab='" . $codiceStab . "'";
                                
$sql = mysql_query($stringSql);
//	or die("ERROR IN script_anagrafe_macchina - FUNCTION insertNewAnMac - ".$stringSql ." ". mysql_error());
	return $sql;
}

/**
 * Seleziona dalla tabella anagrafe_macchina i gruppi delle macchine visibili 
 * @param type $stringUtentiAziende
 * @return type
 */
function selectGruppiFromAnMac($stringUtentiAziende) {

    $stringSql = "SELECT gruppo FROM serverdb.anagrafe_macchina a
                    JOIN 
                        serverdb.macchina m ON m.id_macchina=a.id_macchina
                    WHERE 
                        a.abilitato=1 
                    AND 
                        (m.id_utente,m.id_azienda) IN ".$stringUtentiAziende." 
                    GROUP BY gruppo 
                    ORDER BY gruppo"; 
                  
  $sql = mysql_query($stringSql)
 or die("ERROR IN script_anagrafe_macchina - FUNCTION selectGruppiFromAnMac - ".$stringSql ." ". mysql_error());
  return $sql;
}

/**
 * Seleziona i rif geografici delle macchine visibili
 * @param type $stringUtentiAziende
 * @return type
 */
function selectGeoFromAnMac($stringUtentiAziende) {

 $stringSql = "SELECT geografico FROM serverdb.anagrafe_macchina a
                    JOIN 
                        serverdb.macchina m ON m.id_macchina=a.id_macchina
                    WHERE 
                        a.abilitato=1 
                    AND 
                        (m.id_utente,m.id_azienda) IN ".$stringUtentiAziende."    
                    GROUP BY geografico 
                    ORDER BY geografico";
         $sql = mysql_query($stringSql)
                  or die("ERROR IN script_anagrafe_macchina - FUNCTION selectGeoFromAnMac - ".$stringSql ." ". mysql_error());
  
  return $sql;
}




/**
 * Seleziona alcuni campi del record della tabella anagrafe_macchina 
 * del db server con primo_livello selezionato
 * @param unknown $livello_1_old
 * @param unknown $connessione
 * @return resource
 */
function selectAnMacchinaByLivAndGruppo($gruppo,$livelloGruppo){
	$strinSql="SELECT * FROM
            		serverdb.anagrafe_macchina
                    WHERE
			(livello_gruppo='".$livelloGruppo."' 
                        AND 
                        gruppo='".$gruppo."')";
	$sql=mysql_query($strinSql)
	or die("ERROR IN script_anagrafe_macchina.php - FUNCTION selectAnagrafeMacchinaByLiv - " .$strinSql." - " . mysql_error());
	return $sql;
}


/**
 * Seleziona alcuni campi del record della tabella anagrafe_macchina del db server con comune selezionato
 * @param unknown $comune_old
 * @param unknown $connessione
 * @return resource
 * @author FR
 */
function selectAnagrafeMacchinaByComune($comune_old){
	$strinSql="SELECT * FROM
                        serverdb.anagrafe_macchina
                WHERE 
                        (tipo_riferimento='Comune' 
                        AND 
                        geografico='".$comune_old."')";
	$sql=mysql_query($strinSql)
	or die("ERROR IN script_anagrafe_macchina.php - FUNCTION selectAnagrafeMacchinaByComune - " .$strinSql." - " . mysql_error());
	return $sql;
}

/**
 * Seleziona alcuni campi della tabella anagrafe_macchina del db server per livelli superiori al primo
 * @param unknown $livello_2_old
 * @param unknown $livello_3_old
 * @param unknown $livello_4_old
 * @param unknown $livello_5_old
 * @param unknown $livello_6_old
 * @param unknown $connessione
 * @return resource
 */
function selectAnagrafeMacchinaByLivelliSuperiori($livello_2_old, $livello_3_old, $livello_4_old,
												 $livello_5_old, $livello_6_old, $connessione){
	$strinSql="SELECT *
                        FROM
                                serverdb.anagrafe_macchina
                        WHERE 
                                        (livello_gruppo='SecondoLivello' AND gruppo='".$livello_2_old."')
                                OR
                                        (livello_gruppo='TerzoLivello' AND gruppo='".$livello_3_old."')
                                OR
                                        (livello_gruppo='QuartoLivello' AND gruppo='".$livello_4_old."')
                                OR
                                        (livello_gruppo='QuintoLivello' AND gruppo='".$livello_5_old."')
                                OR
                                        (livello_gruppo='SestoLivello' AND gruppo='".$livello_6_old."')";
	$sql=mysql_query($strinSql, $connessione)
	or die("ERROR IN script_anagrafe_macchina.php - FUNCTION selectAnagrafeMacchinaByLivelliSuperiori - " .$strinSql." - " . mysql_error());
	return $sql;
}


/**
 * Modifico il campo gruppo nella tabella anagrafe_macchina di serverdb avente dato livello
 * @param unknown $gruppo
 * @param unknown $gruppoOld
 * @param unknown $livelloGruppo
 * @return resource
 */
function updateAnMacchinaGruppo($gruppo, $gruppoOld,$livelloGruppo, $dataCorrente){
	$strinSql="UPDATE serverdb.anagrafe_macchina
                            SET 
                                    gruppo ='".$gruppo."',
                                    dt_abilitato='".$dataCorrente."'
                            WHERE 
                                    livello_gruppo='".$livelloGruppo."' 
                            AND 
                                    gruppo='".$gruppoOld."'";
	$sql=mysql_query($strinSql);
//	or die("ERROR IN script_anagrafe_macchina.php - FUNCTION updateServerDBAnagrafeMacchina - " .$strinSql." - " . mysql_error());
	return $sql;
}

/**
 * Seleziona alcuni campi del record della tabella anagrafe_macchina del db server con filtro su provincia,regione,stato,continente,mondo
 * @param unknown $provincia_old
 * @param unknown $regione_old
 * @param unknown $stato_old
 * @param unknown $continente_old
 * @param unknown $mondo_old
 * @param unknown $connessione
 * @return resource
 */
function selectAnagrafeMacchinaByRiferimentiSuperiori($provincia, $regione, $stato,
		$continente, $mondo){
	$strinSql="SELECT *	FROM
							serverdb.anagrafe_macchina
						WHERE 
								(tipo_riferimento='Provincia' AND geografico='".$provincia."')
							OR
								(tipo_riferimento='Regione' AND geografico='".$regione."')
							OR
								(tipo_riferimento='Stato' AND geografico='".$stato."')
							OR
								(tipo_riferimento='Continente' AND geografico='".$continente."')
							OR
								(tipo_riferimento='Mondo' AND geografico='".$mondo."')";
	$sql=mysql_query($strinSql);
//	or die("ERROR IN script_anagrafe_macchina.php - FUNCTION selectAnagrafeMacchinaByRiferimentiSuperiori - " .$strinSql." - " . mysql_error());
	return $sql;
}



/**
 * Aggiorna il campo geografico  della tabella anagrafe_prodotto del db server
 * @param unknown $comune
 * @param unknown $comune_old
 * @param unknown $dataCorrente
 */
function updateGeograficoAnMacchina($geografico, $geograficoOld, $tipoRifer,  $dataCorrente ){

	 $stringSql = "UPDATE serverdb.anagrafe_macchina
                        SET 
                                geografico ='".$geografico."',
                                dt_abilitato='".$dataCorrente."'
                        WHERE 
                                tipo_riferimento='".$tipoRifer."' 
                        AND 
                                geografico='".$geograficoOld."'";
	$sql = mysql_query($stringSql);
        //or die("ERROR IN script_anagrafe_macchina.php - FUNCTION updateGeograficoAnMacchina - ".$stringSql ." ". mysql_error());
        return $sql;

}

/**
 * Modifica l'anagrafe di una macchina nella tabella anagrafe_macchina di serverdb
 * solo se le informazioni sono variate
 * @param type $idClienteGaz
 * @param type $lingua
 * @param type $geografico
 * @param type $tipoRiferimento
 * @param type $gruppo
 * @param type $livelloGruppo
 * @param type $abilitato
 * @param type $idMacchina
 * @return type
 */
function modificaAnagrafeMacchina($idClienteGaz,$lingua,$geografico,$tipoRiferimento,$gruppo,$livelloGruppo,$abilitato,$idMacchina){
$stringSql = "UPDATE serverdb.anagrafe_macchina 
              SET 
                id_cliente_gaz=if(id_cliente_gaz != '" . $idClienteGaz . "','" . $idClienteGaz . "',id_cliente_gaz),
                id_lingua=if(id_lingua != '" . $lingua . "','" . $lingua . "',id_lingua),  
                geografico=if(geografico != '" . $geografico . "','" . $geografico . "',geografico), 
                tipo_riferimento=if(tipo_riferimento != '" . $tipoRiferimento . "','" . $tipoRiferimento . "',tipo_riferimento), 
                gruppo=if(gruppo != '" . $gruppo . "','" . $gruppo . "',gruppo), 
                livello_gruppo=if(livello_gruppo != '" . $livelloGruppo . "','" . $livelloGruppo . "',livello_gruppo),     
                abilitato='" . $abilitato . "'
            WHERE 
                 id_macchina=" . $idMacchina;
$sql = mysql_query($stringSql);
//        or die("ERROR IN script_anagrafe_macchina.php - FUNCTION modificaAnagrafeMacchina - ".$stringSql ." ". mysql_error());
        return $sql;
}

//##############################################################################
//######################### STORICO ############################################
//##############################################################################



/**
 * Inserisco nello storico dell'anagrafe_macchina i valori appena memorizzati del  record contenente il vecchio comune	
 * @param unknown $id_macchina
 * @param unknown $id_lingua
 * @param unknown $id_cliente_gaz
 * @param unknown $geografico
 * @param unknown $tipo_riferimento
 * @param unknown $gruppo
 * @param unknown $livello_gruppo
 * @param unknown $abilitato
 * @param unknown $dt_abilitato
 * @return resource
 * @author FR
 */
function insertStoricoAnMacchina($id_macchina, $id_lingua, $id_cliente_gaz, $geografico, $tipo_riferimento, $gruppo,
 	$livello_gruppo, $abilitato, $dt_abilitato ){
	$strinSql="INSERT INTO storico.anagrafe_macchina 
							(   id_macchina,
								id_lingua,
								id_cliente_gaz,
								geografico,
								tipo_riferimento,
								gruppo,
								livello_gruppo,
								abilitato,
								dt_abilitato) 
							VALUES(
									   ".$id_macchina.",
									   '".$id_lingua."',
									   ".$id_cliente_gaz.",
									   '".$geografico."',
									   '".$tipo_riferimento."',
									   '".$gruppo."',
									   '".$livello_gruppo."',
									   ".$abilitato.",
									   '".$dt_abilitato."')";
	$sql=mysql_query($strinSql);
	//or die("ERROR IN script_anagrafe_macchina.php - FUNCTION insertStoricoAnagrafeMacchina - " .$strinSql." - " . mysql_error());
	return $sql;
}


/**
 * Seleziona le informazioni anagrafiche di una macchina dalla tabella anagrafe_macchina di serverdb e 
 * le inserisce nella tabella anagrafe_macchina del database storico
 * @param type $idMacchina
 * @return type
 */
function storicizzaAnagrafeMacchina($idMacchina) {


    $stringSql = "INSERT INTO storico.anagrafe_macchina 
                                (id_macchina,
                                    id_cliente_gaz,
                                    geografico,
                                    tipo_riferimento,
                                    gruppo,
                                    livello_gruppo,
                                    id_lingua,
                                    abilitato,
                                    dt_abilitato) 
                       SELECT 			
                                        id_macchina,
                                        id_cliente_gaz,
                                        geografico,
                                        tipo_riferimento,
                                        gruppo,
                                        livello_gruppo,
                                        id_lingua,
                                        abilitato,
                                        dt_abilitato
                                FROM
                                        serverdb.anagrafe_macchina
                                WHERE 
                                        id_macchina=" . $idMacchina;

    $sql = mysql_query($stringSql);
    //or die("ERROR IN script_macchina - FUNCTION storicizzaAnagrafeMacchina - ".$sqlString ." ". mysql_error());
    return $sql;
}



/**
 * Inserisco nello storico dell'anagrafe_macchina i valori appena memorizzati del  record contenente il vecchio comune	
 * @param unknown $id_macchina
 * @param unknown $id_lingua
 * @param unknown $id_cliente_gaz
 * @param unknown $geografico
 * @param unknown $tipo_riferimento
 * @param unknown $gruppo
 * @param unknown $livello_gruppo
 * @param unknown $abilitato
 * @param unknown $dt_abilitato
 * @return resource
 */
function insertStoricoAnagrafeMacchina($id_macchina, $id_lingua, $id_cliente_gaz, $geografico, $tipo_riferimento, $gruppo,
 	$livello_gruppo, $abilitato, $dt_abilitato ){
	$strinSql="INSERT INTO storico.anagrafe_macchina 
							(   id_macchina,
								id_lingua,
								id_cliente_gaz,
								geografico,
								tipo_riferimento,
								gruppo,
								livello_gruppo,
								abilitato,
								dt_abilitato) 
							VALUES(
									   ".$id_macchina.",
									   '".$id_lingua."',
									   ".$id_cliente_gaz.",
									   '".$geografico."',
									   '".$tipo_riferimento."',
									   '".$gruppo."',
									   '".$livello_gruppo."',
									   ".$abilitato.",
									   '".$dt_abilitato."')";
	$sql=mysql_query($strinSql)
	or die("ERROR IN script_anagrafe_macchina.php - FUNCTION insertStoricoAnagrafeMacchina - " .$strinSql." - " . mysql_error());
	return $sql;
}

?>
