<?php
//Tabelle coinvolte 
//comune
/*
//############# VERIFICA PERMESSO VISUALIZZAZIONE ##############################
//verificaPermessoVisualizzazione($_SESSION['objPermessiVis'], 'comune');
//Stringa contenente l'elenco degli id degli utenti prop visibili dall'utente loggato
echo "</br>Utenti proprietari visibili tab comune: ".
        $_SESSION['strUtentiVis']=getUtentiPropVisib($_SESSION['objPermessiVis'], 'comune');
        
//Stringa contenente l'elenco degli id delle aziende visibili dall'utente loggato
echo "</br>Aziende visibili tab comune : ". 
        $_SESSION['strAziendeVis']=getAziendeVisib($_SESSION['objPermessiVis'], 'comune');
//##############################################################################
*/


/**
 * Seleziona tutti i record della tabella comune
 * @return resource
 */
function findAllFromComuni() {
    $sqlString = "SELECT * FROM serverdb.comune";

    $sql = mysql_query($sqlString) or die("ERROR IN script_comune.php - FUNCTION findAllFromGruppi - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Selezione il record dalla tabella comune con comune=$comune
 * @param unknown $comune
 * @param unknown $connessione
 * @return resource
 */
function findComuneByNome($comune) {
    $sqlString = "SELECT * FROM serverdb.comune WHERE comune = '" . $comune . "'";

    $sql = mysql_query($sqlString) or die("ERROR IN script_comune.php - FUNCTION findComuneByNome - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 *  Inserisce un record nella tabella comune tramite tutti i suoi campi
 * @param unknown $Cap
 * @param unknown $CodiceCatastale
 * @param unknown $CodiceIstat
 * @param unknown $Comune
 * @param unknown $CodiceProvincia
 * @param unknown $Provincia
 * @param unknown $CodiceRegione
 * @param unknown $Regione
 * @param unknown $CodiceStato
 * @param unknown $Stato
 * @param unknown $Continente
 * @param unknown $dataCorrenteInserimento
 * @param unknown $connessione
 * @return resource
 */
function inserisciComune($Cap, $CodiceCatastale, $CodiceIstat, $Comune, $CodiceProvincia, $Provincia, $CodiceRegione, $Regione, $CodiceStato, $Stato, $Continente, $dataCorrenteInserimento) {
    $sqlString = "INSERT INTO serverdb.comune (cap,cod_cat,cod_istat,comune,cod_prov,provincia,cod_reg,regione,cod_stat,stato,continente,mondo,abilitato,dt_abilitato) 
				VALUES ( '" . $Cap .
            "','" . $CodiceCatastale .
            "','" . $CodiceIstat .
            "','" . $Comune .
            "','" . $CodiceProvincia .
            "','" . $Provincia .
            "','" . $CodiceRegione .
            "','" . $Regione .
            "','" . $CodiceStato .
            "','" . $Stato .
            "','" . $Continente .
            "','Mondo',
						1,
						'" . $dataCorrenteInserimento . "')";

    $sql = mysql_query($sqlString);
    // or die("ERROR IN script_comune.php - FUNCTION inserisciComune - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Selezione il record dalla tabella comune con id_comune=$idComune
 * @param unknown $idComune
 * @return resource
 */
function findComuneById($idComune) {
    $sqlString = "SELECT * FROM serverdb.comune WHERE id_comune=" . $idComune;

    $sql = mysql_query($sqlString) or die("ERROR IN script_comune.php - FUNCTION findComuneById - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Selezione il record dalla tabella comune con comune=$comune e id_comune<>$idComune
 * @param unknown $idComune
 * @param unknown $comune
 * @param unknown $connessione
 * @return resource
 * @author FR
 */
function findComuneByNomeNonId($idComune, $comune, $provincia) {
    $sqlString = "SELECT * FROM serverdb.comune WHERE comune = '" . $comune . "'
						AND
                                                provincia='".$provincia."'
                                                AND
						id_comune<>" . $idComune;

    $sql = mysql_query($sqlString) or die("ERROR IN script_comune.php - FUNCTION findComuneByNomeNonId - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Seleziona dei campi del record dalla tabella comune selezionato per id
 * @param unknown $idComune
 * @param unknown $connessione
 * @return resource
 * @author FR
 */
function selectComuneById($idComune) {
    $sqlString = "SELECT 
						id_comune,
						cap,
						cod_cat,
						cod_istat,
						comune,
						cod_prov,
						provincia,
						cod_reg,
						regione,
						cod_stat,
						stato,
						continente,
						mondo,
						abilitato,
						dt_abilitato
					FROM 
						serverdb.comune
					WHERE 
						id_comune='" . $idComune . "'";

    $sql = mysql_query($sqlString) or die("ERROR IN script_comune.php - FUNCTION selectComuneById - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Inserisce i vecchi campi in un nuovo record della tabella comune del db storico
 * @param unknown $id_comune_old
 * @param unknown $cap_old
 * @param unknown $cod_cat_old
 * @param unknown $cod_istat_old
 * @param unknown $comune_old
 * @param unknown $cod_prov_old
 * @param unknown $provincia_old
 * @param unknown $cod_reg_old
 * @param unknown $regione_old
 * @param unknown $cod_stat_old
 * @param unknown $stato_old
 * @param unknown $continente_old
 * @param unknown $mondo_old
 * @param unknown $abilitato
 * @param unknown $dataCorrente
 * @return resource
 * @author FR
 */
function insertStoricoComune($id_comune_old, $cap_old, $cod_cat_old, $cod_istat_old, $comune_old, $cod_prov_old, $provincia_old, $cod_reg_old, $regione_old, $cod_stat_old, $stato_old, $continente_old, $mondo_old, $abilitato, $dataCorrente) {
    $sqlString = "INSERT INTO storico.comune (id_comune,cap,cod_cat,cod_istat,comune,cod_prov,provincia,cod_reg,regione,cod_stat,stato,continente,mondo,abilitato, dt_abilitato)
						VALUES(" . $id_comune_old . ",
							   '" . $cap_old . "',
							   '" . $cod_cat_old . "',
							   '" . $cod_istat_old . "',
							   '" . $comune_old . "',
							   '" . $cod_prov_old . "',
							   '" . $provincia_old . "',
							   '" . $cod_reg_old . "',
							   '" . $regione_old . "',
							   '" . $cod_stat_old . "',
							   '" . $stato_old . "',
							   '" . $continente_old . "',
							   '" . $mondo_old . "',
							   '" . $abilitato . "',
							   '" . $dataCorrente . "')";

    $sql = mysql_query($sqlString);
    // or die("ERROR IN script_comune.php - FUNCTION insertStoricoComune - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Aggiorna i campi provincia e codice provincia del record della tabella comune del server db
 * @param unknown $codiceProvincia
 * @param unknown $provincia
 * @param unknown $provincia_old
 * @author FR
 */
function updateProvinciaServerDBComune($codiceProvincia, $provincia, $provinciaOld) {
   $stringSql = "UPDATE serverdb.comune
						SET 
							cod_prov='" . $codiceProvincia . "',
							provincia='" . $provincia . "'
						WHERE 
							provincia='" . $provinciaOld . "'";
    $sql = mysql_query($stringSql);
   //  or die("ERROR IN script_comune.php - FUNCTION updateProvinciaServerDBComune - " . $stringSql . " " . mysql_error());
   return $sql;
}

/**
 * Aggiorna i campi regione e codice regione del record della tabella comune del server db
 * @param unknown $codiceRegione
 * @param unknown $regione
 * @param unknown $regione_old
 * @author FR
 */
function updateRegioneServerDBComune($codiceRegione, $regione, $regioneOld) {
    $stringSql = "UPDATE serverdb.comune
						SET 
							cod_reg='" . $codiceRegione . "',
							regione='" . $regione . "'
						WHERE 
							regione='" . $regioneOld . "'";
    $sql = mysql_query($stringSql);
    // or die("ERROR IN script_comune.php - FUNCTION updateRegioneServerDBComune - " . $stringSql . " " . mysql_error());
    return $sql;
}

/**
 * Aggiorna i campi stato e codice stato del record della tabella comune del server db
 * @param unknown $codiceStato
 * @param unknown $stato
 * @param unknown $stato_old
 * @author FR
 */
function updateStatoServerDBComune($codiceStato, $stato, $statoOld) {
    $stringSql = "UPDATE serverdb.comune
						SET 
							cod_stat='" . $codiceStato . "',
							stato='" . $stato . "'
						WHERE 
							stato='" . $statoOld . "'";
    $sql = mysql_query($stringSql);
    // or die("ERROR IN script_comune.php - FUNCTION updateStatoServerDBComune - " . $stringSql . " " . mysql_error());
    return $sql;
}
/**
 * Aggiorna il campo continente del record della tabella comune del server db
 * @param unknown $continente
 * @param unknown $continente_old
 * @author FR
 */
function updateContinenteServerDBComune($continente, $continenteOld) {
    $stringSql = "UPDATE serverdb.comune
						SET 
							continente='" . $continente . "'
						WHERE 
							continente='" . $continenteOld . "'";
    $sql = mysql_query($stringSql);
    // or die("ERROR IN script_comune.php - FUNCTION updateContinenteServerDBComune - " . $stringSql . " " . mysql_error());
    return $sql;
}

/**
 * Aggiorna tutti i campi del record della tabella comune di serverdb selezionato per id
 * @param unknown $Cap
 * @param unknown $CodiceCatastale
 * @param unknown $CodiceIstat
 * @param unknown $Comune
 * @param unknown $CodiceProvincia
 * @param unknown $Provincia
 * @param unknown $CodiceRegione
 * @param unknown $Regione
 * @param unknown $CodiceStato
 * @param unknown $Stato
 * @param unknown $Continente
 * @param unknown $Mondo
 * @param unknown $dataCorrente
 * @param unknown $IdComune
 * @return resource
 * @author FR
 */
function updateServerDBComuneById($Cap, $CodiceCatastale, $CodiceIstat, $Comune, $CodiceProvincia, $Provincia, $CodiceRegione, $Regione, $CodiceStato, $Stato, $Continente, $Mondo, $dataCorrente, $IdComune) {
    $sqlString = "UPDATE serverdb.comune
						SET 
							cap='" . $Cap . "',
							cod_cat='" . $CodiceCatastale . "',
							cod_istat='" . $CodiceIstat . "',
							comune='" . $Comune . "',
							cod_prov='" . $CodiceProvincia . "',
							provincia='" . $Provincia . "',
							cod_reg='" . $CodiceRegione . "',
							regione='" . $Regione . "',
							cod_stat='" . $CodiceStato . "',
							stato='" . $Stato . "',
							continente='" . $Continente . "',
							Mondo='" . $Mondo . "',
							dt_abilitato='" . $dataCorrente . "'
						WHERE
							id_comune='" . $IdComune . "'";

    $sql = mysql_query($sqlString);
    // or die("ERROR IN script_comune.php - FUNCTION updateServerDBComuneById - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Seleziona un particolare campo della tabella comune raggruppando
 * @param type $campo
 * @param type $alias
 * @return type
 */
function selectDistinctCampoByNome($campo, $alias) {
   
    $stringSql = "SELECT DISTINCT (" . $campo . ") AS " . $alias . " 
                    FROM 
                            serverdb.comune 
                    WHERE 
                            " . $campo . " IS NOT NULL 
                          AND 
                            " . $campo . "<>'' 
                    ORDER BY " . $campo;
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_comune.php - FUNCTION selectDistinctCampoByNome - " . $sqlString . " " . mysql_error());
    return $sql;
}

?>