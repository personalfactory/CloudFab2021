<?php

function validaUtente($username, $password) {

  $sql = mysql_query("SELECT * FROM utente WHERE username = '" . $username . "'AND pswd = '" . $password . "'") or die("ERROR IN script_utente - FUNCTION  validaUtente - SELECT FROM serverdb.utente : " . mysql_error());
  return $sql;
}

function verificaEsistenzaSessione($idUtente) {
  $sql = mysql_query("SELECT id_sessione FROM serverdb.utente_sessione  WHERE id_utente=" . $idUtente) or die("ERROR IN script_utente -FUNCTION verificaEsistenzaSessione - SELECT FROM serverdb.utente : " . mysql_error());
  return $sql;
}

function verificaTempoSessione($idUtente) {
  $sql = mysql_query("SELECT 
                (TO_DAYS(NOW())*86400+TIME_TO_SEC(NOW())-TO_DAYS(dt_ultima_modifica)*86400-TIME_TO_SEC(dt_ultima_modifica)) AS tempo_inattivita,
                dt_ultima_modifica,
                NOW() AS now 
                FROM 
                  utente_sessione 
                WHERE 
                  id_utente = " . $idUtente) or die("ERROR IN script_utente -FUNCTION verificaTempoSessione - SELECT FROM serverdb.utente : " . mysql_error());

  return $sql;
}

function eliminaSessioneOldDb($idUtente) {
  $sql = mysql_query("SELECT * FROM utente_sessione WHERE id_utente=" . $idUtente) or die("ERROR IN script_utente -FUNCTION eliminaSessioneOldDb - SELECT FROM serverdb.utente_sessione : " . mysql_error());
  if (mysql_num_rows($sql) > 0) {
    mysql_query("DELETE FROM utente_sessione WHERE id_utente=" . $idUtente) or die("ERROR IN script_utente -FUNCTION eliminaSessioneOldDb - DELETE FROM serverdb.utente_sessione : " . mysql_error());
  }
}

function findSessioneById($idSessioneCorrente) {

  $sql = mysql_query("SELECT * FROM serverdb.utente_sessione  WHERE id_sessione='" . $idSessioneCorrente . "'") or die("ERROR IN script_utente -FUNCTION findSessioneById - SELECT serverdb.utente_sessione : " . mysql_error());

  return $sql;
}

function aggiornaDataSessioneDb($idUtente) {
  $sql = mysql_query("UPDATE utente_sessione SET dt_ultima_modifica=NOW()                         
                    WHERE id_utente=" . $idUtente) or die("ERROR IN script_utente - FUNCTION aggiornaDataSessioneDb - UPDATE serverdb.utente_sessione : " . mysql_error());
  return $sql;
}

function findGruppoUtenteByIdUtente($idUtente) {
  $sql = mysql_query("SELECT 
                              utente.id_gruppo_utente, 
                              utente_gruppo.nome_gruppo_utente
                              FROM 
                                      utente 
                              INNER JOIN
                                      utente_gruppo
                              ON utente.id_gruppo_utente=utente_gruppo.id_gruppo_utente
                              WHERE 
                                      utente.id_utente=" . $idUtente) or die("ERROR IN script_utente - FUNCTION findGruppoUtenteByIdUtente - SELECT FROM utente : " . mysql_error());
  return $sql;
}

function inserisciNuovaSessioneDb($idUtente, $idSessioneCorrente) {

  $sql = mysql_query("INSERT INTO utente_sessione (id_utente,id_sessione,dt_ultima_modifica) 
              VALUES (" . $idUtente . ",'" . $idSessioneCorrente . "',NOW())") or die("ERROR IN script_utente - FUNCTION inserisciNuovaSessioneDb - INSERT serverdb.utente_sessione : " . mysql_error());
  return $sql;
}

?>
