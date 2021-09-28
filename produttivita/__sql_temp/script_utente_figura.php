<?php
/**
 * Crea l'associazione operatore macchina con l'utente di inephos
 * inserendo un record nella tabella utente_figura
 * @param type $idFigura
 * @param type $utenteInephos
 * @return type
 */
function insertNuovoUtenteFigura($idFigura,$utenteInephos){
    
   $sql = mysql_query("INSERT INTO utente_figura (id_figura,
                                           id_utente) 
                        VALUES ( " . $idFigura . ",
                                 '" . $utenteInephos . "') ") 
           or die("ERROR IN script_utente_figura - FUNCTION insertNuovUtenteFigura - INSERT INTO utente_figura" . mysql_error());
  
  
  return $sql;
}

/**
 * Seleziono l' operatore associato ad un dato utente inephos
 * @param type $idUtenteInephos
 * @return type
 */
function selectOperByIdUtente($idUtenteInephos){
     $sql = mysql_query("SELECT * FROM utente_figura WHERE id_utente=".$idUtenteInephos )
           or die("ERROR IN script_utente_figura - FUNCTION selectOperByIdUtente - SELECT * FROM utente_figura " . mysql_error());
  
  
  return $sql;
    
}

?>
