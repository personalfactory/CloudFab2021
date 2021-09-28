<?php

/**
 * Seleziona le informazioni di un utente
 * @param type $idUtente
 * @return type
 */
function findUtenteById($idUtente) {
    mysql_query("USE serverdb" . mysql_error());
    $stringSql = "SELECT * FROM utente WHERE id_utente = " . $idUtente;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_utente - FUNCTION  findUtenteById - " . $stringSql . " - " . mysql_error());
    return $sql;
}

/**
 * Seleziona tutti gli utenti
 * @param type $campoOrderBy
 * @return type
 */
function findAllUtenti($campoOrderBy) {
    mysql_query("USE serverdb" . mysql_error());
    $stringSql = "SELECT * FROM utente ORDER BY " . $campoOrderBy;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_utente - FUNCTION  findAllUtenti - " . $stringSql . " - " . mysql_error());
    return $sql;
}

/**
 * Verifica username e password di un utente abilitato
 * @param type $username
 * @param type $password
 * @return type
 */
function validaUtente($username, $password) {
    mysql_query("USE serverdb" . mysql_error());
    $sql = mysql_query("SELECT * FROM utente WHERE username = '" . $username . "'AND pswd = '" . $password . "' AND abilitato=1")
            or die("ERROR IN script_utente - FUNCTION  validaUtente - SELECT FROM serverdb.utente : " . mysql_error());
    return $sql;
}

function verificaEsistenzaSessione($idUtente) {
    mysql_query("USE serverdb" . mysql_error());
    $stringSql = "SELECT id_sessione FROM utente_sessione  WHERE id_utente=" . $idUtente;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_utente -FUNCTION verificaEsistenzaSessione - " . $stringSql . " - " . mysql_error());
    return $sql;
}

function verificaTempoSessione($idUtente) {
    mysql_query("USE serverdb" . mysql_error());
    $stringSql = "SELECT 
                (TO_DAYS(NOW())*86400+TIME_TO_SEC(NOW())-TO_DAYS(dt_ultima_modifica)*86400-TIME_TO_SEC(dt_ultima_modifica)) AS tempo_inattivita,
                dt_ultima_modifica,
                NOW() AS now 
                FROM 
                  utente_sessione 
                WHERE 
                  id_utente = " . $idUtente;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_utente -FUNCTION verificaTempoSessione - " . $stringSql . " - " . mysql_error());

    return $sql;
}

function eliminaSessioneOldDb($idUtente) {
    mysql_query("USE serverdb" . mysql_error());
    $sql = mysql_query("SELECT * FROM utente_sessione WHERE id_utente=" . $idUtente);
//          or die("ERROR IN script_utente -FUNCTION eliminaSessioneOldDb - SELECT FROM serverdb.utente_sessione : " . mysql_error());
    if (mysql_num_rows($sql) > 0) {
        $result = mysql_query("DELETE FROM utente_sessione WHERE id_utente=" . $idUtente);
//    or die("ERROR IN script_utente -FUNCTION eliminaSessioneOldDb - DELETE FROM serverdb.utente_sessione : " . mysql_error());
    }
    return $result;
}

function findSessioneById($idSessioneCorrente) {
    mysql_query("USE serverdb" . mysql_error());
    $stringSql = "SELECT * FROM utente_sessione  WHERE id_sessione='" . $idSessioneCorrente . "'";
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_utente -FUNCTION findSessioneById - " . $stringSql . " - " . mysql_error());

    return $sql;
}

function aggiornaDataSessioneDb($idUtente) {
    mysql_query("USE serverdb" . mysql_error());
    $stringSql = "UPDATE utente_sessione SET dt_ultima_modifica=NOW()                         
                    WHERE id_utente=" . $idUtente;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_utente - FUNCTION aggiornaDataSessioneDb - " . $stringSql . " - " . mysql_error());
    return $sql;
}

function findGruppoUtenteByIdUtente($idUtente) {
    mysql_query("USE serverdb" . mysql_error());
    $stringSql = "SELECT 
                              utente.id_gruppo_utente, 
                              utente_gruppo.nome_gruppo_utente
                              FROM 
                                      utente 
                              INNER JOIN
                                      utente_gruppo
                              ON utente.id_gruppo_utente=utente_gruppo.id_gruppo_utente
                              WHERE 
                                      utente.id_utente=" . $idUtente;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_utente - FUNCTION findGruppoUtenteByIdUtente - " . $stringSql . " - " . mysql_error());
    return $sql;
}

function inserisciNuovaSessioneDb($idUtente, $idSessioneCorrente) {
    mysql_query("USE serverdb" . mysql_error());
    $stringSql = "INSERT INTO utente_sessione (id_utente,id_sessione,dt_ultima_modifica) 
              VALUES (" . $idUtente . ",'" . $idSessioneCorrente . "',NOW())";
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_utente - FUNCTION inserisciNuovaSessioneDb -" . $stringSql . " - " . mysql_error());
    return $sql;
}

function selectNumAccessoByUtente($idUtente) {
    mysql_query("USE serverdb" . mysql_error());
    $stringSql = "SELECT num_accesso FROM utente WHERE id_utente=" . $idUtente;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_utente - FUNCTION selectNumAccessoByUtente -" . $stringSql . " - " . mysql_error());
    return $sql;
}



function aggiornaNumAccesso($idUtente,$numAccesso) {
    mysql_query("USE serverdb" . mysql_error());
    $stringSql = "UPDATE utente SET num_accesso=".$numAccesso.", dt_ultimo_accesso=NOW()                         
                    WHERE id_utente=" . $idUtente;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_utente - FUNCTION aggiornaDataSessioneDb - " . $stringSql . " - " . mysql_error());
    return $sql;
}


//$_SESSION['IdUtente'] = "";
//        $_SESSION['Gruppo'] = "";
//        $_SESSION['Tipo'] = "";
//        $_SESSION['Cognome'] = "";
//        $_SESSION['Nome'] = "";
//        $_SESSION['Username'] = "";
//        $_SESSION['Accessi'] = "";
//        $_SESSION['UltimoAccesso'] = "";
//        $_SESSION['Abilitato'] = "";
//        $_SESSION['DtAbilitato'] = "";



function findUtentiByFiltri($idUtente,$cognome,$nome,$gruppo,$tipo,$username,$abilitato,$dtAbilitato,$numAccesso,$dtUltimoAccesso,$campoOrderBy) {
    mysql_query("USE serverdb" . mysql_error());
    $stringSql = "SELECT
                            u.id_utente,
                            u.cognome,
                            u.nome,
                            ug.nome_gruppo_utente,
                            ug.tipo_gruppo_utente,
                            u.username,
                            u.abilitato,
                            u.dt_abilitato,
                            u.num_accesso,
                            u.dt_ultimo_accesso
                        FROM
                            utente u
                        JOIN
                            utente_gruppo ug
                        ON u.id_gruppo_utente=ug.id_gruppo_utente
                        WHERE
                            u.id_utente LIKE '%".$idUtente."%'
                        AND
                            u.cognome LIKE '%".$cognome."%'
                        AND
                            u.nome LIKE '%".$nome."%' 
                        AND
                            ug.nome_gruppo_utente LIKE '%".$gruppo."%' 
                        AND
                            ug.tipo_gruppo_utente LIKE '%".$tipo."%' 
                        AND
                            u.username LIKE '%".$username."%'
                        AND
                            u.abilitato LIKE '%".$abilitato."%'
                        AND
                            u.dt_abilitato LIKE '%".$dtAbilitato."%'        
                        AND
                            u.num_accesso LIKE '%".$numAccesso."%'
                        AND
                            u.dt_ultimo_accesso LIKE '%".$dtUltimoAccesso."%'       
                        ORDER BY " . $campoOrderBy;
    
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_utente - FUNCTION  findUtentiByFiltri - " . $stringSql . " - " . mysql_error());
    return $sql;
}
?>
