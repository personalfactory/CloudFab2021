<?php

//Tabelle coinvolte
//mazzetta
//mazzetta_colorata (valutare se spostare)
//colore_base
//colore

/**
 * Seleziona tutti i record definiti della tabella mazzetta ordinati per codice
 * diversi dalla mazzetta non definita, visibili all'utente
 * @param type $strUtentiVis
 * @param type $strAziendeVis
 * @return type
 */
function findAllMazzettaDefiniteVis($strUtentiAziende) {
    $sqlString = "SELECT * FROM serverdb.mazzetta 
            WHERE nome_mazzetta <>'Non definita' 
              AND (id_utente,id_azienda) IN ".  $strUtentiAziende."
             ORDER BY cod_mazzetta";

    $sql = mysql_query($sqlString) or die("ERROR IN script_mazzetta.php - FUNCTION findAllMazzettaDefiniteVis - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Seleziona tutti i record definiti della tabella mazzetta ordinati per codice
 * diversi dalla mazzetta non definita
 * @param type $nomeMazzetta
 * @param type $strUtentiAziendeVis
 * @param type $campoOrdine
 * @return type
 */
function findAllMazzettaVisDiverseDa($nomeMazzetta,$strUtentiAziendeVis,$campoOrdine) {
    $sqlString = "SELECT * FROM serverdb.mazzetta 
            WHERE 
                nome_mazzetta <>'".$nomeMazzetta."' 
            AND
                (id_utente,id_azienda) IN ".$strUtentiAziendeVis."
            
            ORDER BY ".$campoOrdine;

    $sql = mysql_query($sqlString) or die("ERROR IN script_mazzetta.php - FUNCTION findAllMazzettaVisDiverseDa - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Seleziona una mazzetta dal nome
 * @param type $nomeMazzetta
 * @return type
 */
function findMazzettaByNome($nomeMazzetta) {
    $sqlString = "SELECT * FROM serverdb.mazzetta WHERE nome_mazzetta='" . $nomeMazzetta . "'";

    $sql = mysql_query($sqlString) or die("ERROR IN script_mazzetta.php - FUNCTION findMazzettaByNome - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Seleziona il record della tabella mazzetta con id desiderato
 * @param unknown $idMazzetta
 * @return resource
 */
function findMazzettaByID($idMazzetta) {
    $sqlString = "SELECT * FROM serverdb.mazzetta WHERE id_mazzetta=" . $idMazzetta;

    $sql = mysql_query($sqlString) or die("ERROR IN script_mazzetta.php - FUNCTION findMazzettaByID - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Inserisce un nuovo record nella tabella mazzetta del db storico
 * @param unknown $idMazzetta
 * @return resource
 */
function insertStoricoMazzetta($idMazzetta) {
    $sqlString = "INSERT INTO storico.mazzetta 						 										
				(id_mazzetta,cod_mazzetta,nome_mazzetta,abilitato,dt_abilitato) 
					SELECT 
						id_mazzetta,
						cod_mazzetta,
						nome_mazzetta,
						abilitato,
						dt_abilitato
					FROM 
						serverdb.mazzetta
					WHERE
						id_mazzetta='" . $idMazzetta . "'";

    $sql = mysql_query($sqlString);
    // or die("ERROR IN script_mazzetta.php - FUNCTION insertStoricoMazzetta - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Seleziona un record della tabella mazzetta con nome e codice desiderati
 * @param unknown $nomeMazzetta
 * @param unknown $codiceMazzetta
 * @param unknown $connessione
 * @return resource
 */
function findMazzettaByNomeORCod($nomeMazzetta, $codiceMazzetta) {
    $sqlString = "SELECT * FROM serverdb.mazzetta WHERE nome_mazzetta = '" . $nomeMazzetta . "' 
            OR cod_mazzetta = '" . $codiceMazzetta . "'";

    $sql = mysql_query($sqlString) or die("ERROR IN script_mazzetta.php - FUNCTION findMazzettaByNomeORCod- " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Seleziona il campo id_mazzetta dal record della tabella mazzetta che ha codice e nome desiderati
 * @param unknown $nomeMazzetta
 * @param unknown $codiceMazzetta
 * @return resource
 */
function selectIDMazzetta($nomeMazzetta, $codiceMazzetta) {
    $sqlString = "SELECT id_mazzetta 
               FROM serverdb.mazzetta
              WHERE cod_mazzetta='" . $codiceMazzetta . "'
              AND  nome_mazzetta='" . $nomeMazzetta . "'";

    $sql = mysql_query($sqlString) or die("ERROR IN script_mazzetta.php - FUNCTION selectIDMazzetta - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Inserisce un nuovo record nella tabella mazzetta
 * @param unknown $codiceMazzetta
 * @param unknown $nomeMazzetta
 * @param unknown $dataCorrente
 * @return resource
 */
function insertMazzetta($codiceMazzetta, $nomeMazzetta, $dataCorrente, $idUtente, $idAzienda) {
    $sqlString = "INSERT INTO serverdb.mazzetta (
                                cod_mazzetta, 
                                nome_mazzetta,
                                abilitato,
                                dt_abilitato,
                                id_utente,
                                id_azienda) 
		VALUES ( '" . $codiceMazzetta .
                        "','" . $nomeMazzetta .
                        "',1,
                        '" . $dataCorrente . "',
                        " . $idUtente . ",
                        " . $idAzienda . ")";

    $sql = mysql_query($sqlString) or die("ERROR IN script_mazzetta.php - FUNCTION insertMazzetta - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Seleziona il record della tabella mazzetta con codice e nome uguali 
 * ai parametri e id diverso
 * @param unknown $idMazzetta
 * @param unknown $codiceMazzetta
 * @param unknown $nomeMazzetta
 * @param unknown $connessione
 * @return resource
 */
function findMazzettaByCodAndNameAndID($idMazzetta, $codiceMazzetta, $nomeMazzetta) {
    $sqlString = "SELECT * FROM serverdb.mazzetta 
				WHERE 
					cod_mazzetta = '" . $codiceMazzetta . "' 
				AND 
					nome_mazzetta = '" . $nomeMazzetta . "'
				AND 
					id_mazzetta<>" . $idMazzetta;

    $sql = mysql_query($sqlString) 
            or die("ERROR IN script_mazzetta.php - FUNCTION findMazzettaByCodAndNameAndID - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Seleziona tutte le mazzette visibili all'utente 
 * aventi un codice diverso da quello dato
 * @param type $codMazzetta
 * @param type $filtroOrdinamento
 * @param type $strUtentiVis
 * @param type $strAziendeVis
 * @return type
 */
function findAllMazzetteDiverseDa($codMazzetta, $filtroOrdinamento, $strUtentiAziende) {
    $sqlString = "SELECT * FROM serverdb.mazzetta 
                        WHERE 
                                cod_mazzetta <>'" . $codMazzetta . "' 
                        AND
                            (id_utente,id_azienda) IN " . $strUtentiAziende . "
                        ORDER BY " . $filtroOrdinamento;

    $sql = mysql_query($sqlString) or die("ERROR IN script_mazzetta.php - FUNCTION findAllMazzetteDiverseDa - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Aggiorna il record della tabella mazzetta di serverdb
 * @param unknown $idMazzetta
 * @param unknown $codiceMazzetta
 * @param unknown $nomeMazzetta
 * @param $idAzienda
 * @return resource
 */
function updateMazzetta($idMazzetta, $codiceMazzetta, $nomeMazzetta, $idAzienda) {
    $sqlString = "UPDATE serverdb.mazzetta
                            SET
                             cod_mazzetta=if(cod_mazzetta!='" . $codiceMazzetta . "','" . $codiceMazzetta . "',cod_mazzetta),
                             nome_mazzetta=if(nome_mazzetta!='" . $nomeMazzetta . "','" . $nomeMazzetta . "',nome_mazzetta),
                             id_azienda=if(id_azienda!='" . $idAzienda . "','" . $idAzienda . "',id_azienda)    
                            WHERE id_mazzetta='" . $idMazzetta . "'";

    $sql = mysql_query($sqlString);
    // or die("ERROR IN script_mazzetta.php - FUNCTION updateMazzetta - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Seleziona le mazzette colorate visibili all'utente
 * @param type $strUtentiAziendeVis
 * @return type
 */
function findAllMazzetteColorataVis($strUtentiAziendeVis) {
    $sqlString = "SELECT
                    mc.id_maz_col,
                    m.id_mazzetta,
                    m.cod_mazzetta,
                    m.nome_mazzetta,
                    c.nome_colore,
                    mc.dt_abilitato
            FROM
                    serverdb.mazzetta m
            LEFT JOIN serverdb.mazzetta_colorata mc ON mc.id_mazzetta = m.id_mazzetta
            LEFT JOIN serverdb.colore c ON mc.id_colore = c.id_colore
            WHERE 
                   (m.id_utente,m.id_azienda) IN " . $strUtentiAziendeVis . "
            GROUP BY
                    m.id_mazzetta
            ORDER BY 
                    m.nome_mazzetta";

    $sql = mysql_query($sqlString) or die("ERROR IN script_mazzetta.php - FUNCTION findAllMazzetteColorataVis - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * 
 * @param unknown $idMazzetta
 * @return resource
 */
function innerJoinMazzettaColore($idMazzetta) {
    $sqlString = "SELECT
                    mazzetta.id_mazzetta,
                    mazzetta.cod_mazzetta,
                    mazzetta.nome_mazzetta,
                    colore.id_colore,
                    colore.cod_colore,
                    colore.nome_colore,
                    mazzetta_colorata.dt_abilitato,
                    mazzetta.id_utente,
                    mazzetta.id_azienda
                FROM
                    serverdb.mazzetta_colorata
                JOIN 
                    serverdb.mazzetta 
                ON mazzetta_colorata.id_mazzetta = mazzetta.id_mazzetta
                JOIN 
                    serverdb.colore_base 
                ON mazzetta_colorata.id_colore_base = colore_base.id_colore_base
                JOIN 
                    serverdb.colore 
                ON mazzetta_colorata.id_colore = colore.id_colore
                WHERE 
                    mazzetta_colorata.id_mazzetta=" . $idMazzetta;

    $sql = mysql_query($sqlString) or die("ERROR IN script_mazzetta.php - FUNCTION innerJoinMazzettaColore - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * 
 * @param unknown $idMazzetta
 * @return resource
 */
function innerJoinColoreMazzettaColorata($idMazzetta) {
    $sqlString = "SELECT 
                colore.id_colore,
                colore.nome_colore,
                mazzetta_colorata.id_colore
                FROM
                serverdb.mazzetta_colorata
                INNER JOIN serverdb.colore 
                ON 
                mazzetta_colorata.id_colore = colore.id_colore
                WHERE 
                mazzetta_colorata.id_mazzetta=" . $idMazzetta . "
                GROUP BY 
                colore.nome_colore
                ORDER BY 
                colore.nome_colore";

    $sql = mysql_query($sqlString) or die("ERROR IN script_mazzetta.php - FUNCTION innerJoinColoreMazzettaColorata - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * 
 * @param unknown $idMazzetta
 * @param unknown $rowColor
 * @return resource
 */
function innerJoinColoreBaseMazzettaColorata($idMazzetta, $rowColor) {
    $sqlString = "SELECT 
              	 colore_base.cod_colore_base,
                 colore_base.nome_colore_base,
                 colore_base.costo_colore_base,
                 mazzetta_colorata.quantita,
                 mazzetta_colorata.dt_abilitato 
                 FROM
                 serverdb.mazzetta_colorata
                 INNER JOIN serverdb.colore_base 
                 ON 
                  mazzetta_colorata.id_colore_base = colore_base.id_colore_base
                  INNER JOIN serverdb.colore 
                    ON 
                   mazzetta_colorata.id_colore = colore.id_colore
                   WHERE 
                  mazzetta_colorata.id_mazzetta=" . $idMazzetta . "
                  AND
                 mazzetta_colorata.id_colore=" . $rowColor . "
                  ORDER BY 
               nome_colore_base";

    $sql = mysql_query($sqlString) or die("ERROR IN script_mazzetta.php - FUNCTION innerJoinColoreBaseMazzettaColorata - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Seleziono dalla tabella mazzetta_colorata i Colori associati alla mazzetta da modificare ai quali devo modificare la composizione
 * @param unknown $idMazzetta
 * @return resource
 */
function innerJoinMazzettaColorataColore($idMazzetta) {
    $sqlString = "SELECT 
                                    mazzetta_colorata.id_colore,
                                    colore.nome_colore
                        FROM
                                serverdb.mazzetta_colorata
                        INNER JOIN serverdb.colore 
                        ON 
                                mazzetta_colorata.id_colore = colore.id_colore
                        WHERE 
                                mazzetta_colorata.id_mazzetta=" . $idMazzetta . "
                        GROUP BY
                                    colore.nome_colore
                        ORDER BY 
                                    colore.nome_colore";

    $sql = mysql_query($sqlString) or die("ERROR IN script_mazzetta.php - FUNCTION innerJoinMazzettaColorataColore - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Seleziono i colori_base associati a questo id_colore ed alla mazzetta che si sta modificando
 * @param unknown $idMazzetta
 * @param unknown $idColore
 * @return resource
 */
function selectMazzettaColoreBaseLeft($idMazzetta, $idColore) {
    $sqlString = "SELECT   
                                                            mazzetta_colorata.id_maz_col,
                                                            mazzetta_colorata.id_mazzetta,
                                                            mazzetta_colorata.id_colore,
                                                            mazzetta_colorata.id_colore_base,
                                                            mazzetta_colorata.quantita,
                                                            mazzetta_colorata.abilitato,
                                                            mazzetta_colorata.dt_abilitato,
                                                            colore_base.nome_colore_base									
                                                    FROM 
                                                            serverdb.mazzetta_colorata
                                                    LEFT JOIN serverdb.colore_base
                                                    ON
                                                            mazzetta_colorata.id_colore_base=colore_base.id_colore_base
                                                    WHERE
                                                            mazzetta_colorata.id_mazzetta=" . $idMazzetta . "
                                                    AND
                                                            mazzetta_colorata.id_colore=" . $idColore . "
                                                    ORDER BY 
                                                            colore_base.nome_colore_base";

    $sql = mysql_query($sqlString) or die("ERROR IN script_mazzetta.php - FUNCTION selectMazzettaColoreBase - " . $sqlString . " " . mysql_error());
    return $sql;
}

//#####################################################################
//######################### MAZZETTA COLORATA #########################
//######################################################################

/**
 * Seleziona i vecchi record presenti nella tabella [mazzetta_colorata] relativi all'id_mazzetta da modificare
 * @param unknown $idMazzetta
 * @return resource
 */
function selectOldRecordMazzettaColorata($idMazzetta) {
    $sqlString = "SELECT   
				mazzetta_colorata.id_maz_col,
				mazzetta_colorata.id_mazzetta,
				mazzetta_colorata.id_colore,
				mazzetta_colorata.id_colore_base,
				mazzetta_colorata.quantita,
				mazzetta_colorata.dt_abilitato								
				FROM 
				serverdb.mazzetta_colorata 
				WHERE 
				id_mazzetta=" . $idMazzetta;

    $sql = mysql_query($sqlString) or die("ERROR IN script_mazzetta.php - FUNCTION selectOldRecordMazzettaColorata - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Inserisco nello storico i vecchi record relativi all'associazione mazzetta-colore che si sta modificando 
 * @param unknown $idMazzettaCol
 * @param unknown $idMazzetta
 * @param unknown $idColore
 * @param unknown $idColoreBase
 * @param unknown $quantita
 * @param unknown $abilitato
 * @param unknown $dataAbilitato
 * @return resource
 */
function insertStoricoAssociaMazzettaColore($idMazzettaCol, $idMazzetta, $idColore, $idColoreBase, $quantita, $abilitato, $dataAbilitato) {
    $sqlString = "INSERT INTO storico.mazzetta_colorata 	
                                                    (id_maz_col,
                                                        id_mazzetta,
                                                        id_colore,
                                                        id_colore_base,
                                                        quantita,
                                                        abilitato,
                                                        dt_abilitato)
                                            VALUES(
                                                            " . $idMazzettaCol . ",
                                                            " . $idMazzetta . ",
                                                            " . $idColore . ",
                                                            '" . $idColoreBase . "',
                                                            " . $quantita . ",
                                                            " . $abilitato . ",
                                                            '" . $dataAbilitato . "')";

    $sql = mysql_query($sqlString) or die("ERROR IN script_mazzetta.php - FUNCTION insertStoricoAssociaMazzettaColore - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Aggiorno il campo quantità del record selezionato per id della tabella mazzetta colorata del db server
 * @param unknown $idMazzetta
 * @param unknown $idColore
 * @param unknown $idColBase
 * @param unknown $quantitaDaInserire
 * @return resource
 */
function updateServerMazzettaColorata($idMazzetta, $idColore, $idColBase, $quantitaDaInserire) {
    $sqlString = "UPDATE serverdb.mazzetta_colorata 
                                        SET 
                                    quantita=if(quantita!=" . $quantitaDaInserire . "," . $quantitaDaInserire . ",quantita)
                                               
                                        WHERE
                                                id_mazzetta=" . $idMazzetta . "
                                        AND
                                                id_colore=" . $idColore . "
                                        AND
                                                id_colore_base=" . $idColBase;

    $sql = mysql_query($sqlString) or die("ERROR IN script_mazzetta.php - FUNCTION updateServerMazzettaColorata - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Seleziono i colori_base associati a questo id_colore ed alla mazzetta che si sta modificando
 * @param unknown $idMazzetta
 * @param unknown $idColore
 * @return resource
 */
function selectMazzettaColorataColoreBaseInner($idMazzetta, $idColore) {
    $sqlString = "SELECT   
                                                            mazzetta_colorata.id_maz_col,
                                                            mazzetta_colorata.id_mazzetta,
                                                            mazzetta_colorata.id_colore,
                                                            mazzetta_colorata.id_colore_base,
                                                            mazzetta_colorata.quantita,
                                                            mazzetta_colorata.abilitato,
                                                            mazzetta_colorata.dt_abilitato,
                                                            colore_base.nome_colore_base									
                                                    FROM 
                                                            serverdb.mazzetta_colorata
                                                    INNER JOIN serverdb.colore_base
                                                    ON
                                                            mazzetta_colorata.id_colore_base=colore_base.id_colore_base
                                                    WHERE
                                                            mazzetta_colorata.id_mazzetta=" . $idMazzetta . "
                                                    AND
                                                            mazzetta_colorata.id_colore=" . $idColore . "
                                                    ORDER BY 
                                                            colore_base.nome_colore_base";

    $sql = mysql_query($sqlString) or die("ERROR IN script_mazzetta.php - FUNCTION selectMazzettaColorataColoreBaseInner - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Seleziono dalla tabella mazzetta_colorata i Colori associati ala mazzetta da modificare ai quali devo modificare la composizione.
 * @param unknown $idMazzetta
 * @return resource
 */
function selectMazzettaColorataColore($idMazzetta) {
    $sqlString = "SELECT 
							 	mazzetta_colorata.id_colore,
								colore.nome_colore
						   FROM
							   serverdb.mazzetta_colorata
						   INNER JOIN serverdb.colore 
						   ON 
							 mazzetta_colorata.id_colore = colore.id_colore
						   WHERE 
							   mazzetta_colorata.id_mazzetta=" . $idMazzetta . "
						   GROUP BY
						   		colore.nome_colore
						   ORDER BY 
                                                   colore.nome_colore";

    $sql = mysql_query($sqlString) or die("ERROR IN script_mazzetta.php - FUNCTION selectMazzettaColorataColore - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Seleziona il record della tabella mazzetta_colorata con id_mazzetta e id_colore desiderati
 * @param unknown $idMazzetta
 * @param unknown $idColore
 * @param unknown $connessione
 * @return resource
 * @author FR
 */
function findMazColorataByIdColoreAndIdMazzetta($idMazzetta, $idColore) {
    $sqlString = "SELECT * FROM serverdb.mazzetta_colorata 
				WHERE 
						id_mazzetta = " . $idMazzetta . " 
					AND 
						id_colore = " . $idColore;

    $sql = mysql_query($sqlString);
    // or die("ERROR IN script_mazzetta.php - FUNCTION findMazzettaColorataByIdColoreAndIdMazzetta - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Inserisce un nuovo record nella tabella mazzetta_colorata
 * @param unknown $idMazzetta
 * @param unknown $idColore
 * @param unknown $rowColor
 * @param unknown $quantita
 * @param unknown $dataCorrente
 * @param unknown $connessione
 * @return resource
 */
function insertMazzettaColorata($idMazzetta, $idColore, $rowColor, $quantita, $dataCorrente) {
    $sqlString = "INSERT INTO serverdb.mazzetta_colorata 
							(id_mazzetta,id_colore,id_colore_base,quantita,abilitato,dt_abilitato) 
							VALUES("
            . $idMazzetta . ","
            . $idColore . ","
            . $rowColor . ","
            . $quantita . ",1,'"
            . $dataCorrente . "')";

    $sql = mysql_query($sqlString);
    // or die("ERROR IN script_mazzetta.php - FUNCTION insertMazzettaColorata - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Inserisco i vecchi record selezionati nello storico della tabella [mazzetta_colorata]
 * @param unknown $IdMazzettaCol
 * @param unknown $IdMazzetta
 * @param unknown $IdColore
 * @param unknown $IdColoreBase
 * @param unknown $Quantita
 * @param unknown $DataAbilitato
 * @return resource
 * @author FR
 */
function insertStoricoMazzettaColorata($idMazzettaCol, $idMazzetta, $idColore, $idColoreBase, $quantita, $dataAbilitato) {
    $sqlString = "INSERT INTO storico.mazzetta_colorata 	
								(id_maz_col,id_mazzetta,id_colore,id_colore_base,quantita,dt_abilitato)
							VALUES(
								   " . $idMazzettaCol . ",
									" . $idMazzetta . ",
									" . $idColore . ",
									" . $idColoreBase . ",
									" . $quantita . ",
									'" . $dataAbilitato . "')";

    $sql = mysql_query($sqlString);
    // or die("ERROR IN script_mazzetta.php - FUNCTION insertStoricoMazzettaColorata - " . $sqlString . " " . mysql_error());
    return $sql;
}
?>

