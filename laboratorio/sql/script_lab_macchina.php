<?php

/**
  * Seleziona una macchina per nome 
  * @param type $campoOrdine
  * @return type
  */
function findRosettaByNome($nome){
    $stringSql="SELECT * FROM serverdb.lab_macchina WHERE nome='".$nome."'";
    $sql=mysql_query($stringSql)
         or 
            die("ERROR IN script_lab_macchina - FUNCTION findRosettaByNome - " .$stringSql." - ". mysql_error());
return $sql;
            
}

/**
  * Seleziona tutte le rosette 
  * @param type $campoOrdine
  * @return type
  */
function findAllRosette($campoOrdine){
    $stringSql="SELECT * FROM serverdb.lab_macchina ORDER BY ".$campoOrdine;
    $sql=mysql_query($stringSql)
         or 
            die("ERROR IN script_lab_macchina - FUNCTION findAllRosette - " .$stringSql." - ". mysql_error());
return $sql;
            
}

/**
  * Seleziona tutte le rosette visibili all'utente
  * @param type $campoOrdine
  * @param type $strUtentiAziende
  * @return type
  */
function findAllRosetteVis($campoOrdine,$strUtentiAziende){
    $stringSql="SELECT * FROM serverdb.lab_macchina WHERE (id_utente,id_azienda) IN ".$strUtentiAziende." ORDER BY ".$campoOrdine;
    $sql=mysql_query($stringSql)
         or 
            die("ERROR IN script_lab_macchina - FUNCTION findAllRosette - " .$stringSql." - ". mysql_error());
return $sql;
            
}

/**
 * Modifica lo stato di una Rosetta
 * @param type $idLabMac
 * @param type $stato
 * @return type
 */
function modificaStatoRosetta($idLabMac ,$stato){
 $stringSql = "UPDATE serverdb.lab_macchina 
                SET   
                  disponibile='".$stato."'
                WHERE 
                  id_lab_macchina =" . $idLabMac; 
         
  $sql=mysql_query($stringSql);
//         or die("ERROR IN script_lab_macchina - FUNCTION modificaStatoRosetta - " .$stringSql." - ". mysql_error());
return $sql;
}
 /**
  * Seleziona tutte le rosette  in dato stato (libero/impegnato)
  * @param type $stato
  * @param type $campoOrdine
  * @return type
  */
function findAllRosetteByStato($stato,$campoOrdine,$strUtentiAziende){
    $stringSql="SELECT * FROM 
                           serverdb.lab_macchina
                      WHERE disponibile='".$stato."'
                          AND
                    (id_utente,id_azienda) IN ".  $strUtentiAziende."
                  ORDER BY ".$campoOrdine;
    $sql=mysql_query($stringSql)
         or 
            die("ERROR IN script_lab_macchina - FUNCTION findAllRosetteByStato - " .$stringSql." - ". mysql_error());
return $sql;
            
}
 
 
 function modificaUtenteMacchina($idLabMac,$utente){
  $stringSql = "UPDATE serverdb.lab_macchina 
                SET   
                  utente='".$utente."'
                WHERE 
                  id_lab_macchina =" . $idLabMac; 
         
  $sql=mysql_query($stringSql);
//         or die("ERROR IN script_lab_macchina - FUNCTION modificaUtenteMacchina - " .$stringSql." - ". mysql_error());
return $sql;
}
 
/**
 * Inserisce una nuova macchina
 * @param type $nome
 * @param type $descri
 * @param type $abilitato
 * @param type $disponibile
 * @param type $utente
 * @param type $dtAbil
 * @param type $idUtente
 * @param type $idAzienda
 * @return type
 */
 function inserisciNuovaMacchina($nome,$descri,$abilitato,$disponibile,$utente,$dtAbil,$idUtente,$idAzienda){
  $stringSql = "INSERT INTO lab_macchina 
                    (nome,descrizione,abilitato,disponibile,utente,dt_abilitato,id_utente,id_azienda) 
				VALUES ( '".$nome."',
                                         '".$descri."',
                                         '".$abilitato."',
                                         '".$disponibile."',
                                         '".$utente."',
                                         '".$dtAbil."',
                                         ".$idUtente.",
                                         ".$idAzienda.")";
         
  $sql=mysql_query($stringSql);
//         or die("ERROR IN script_lab_macchina - FUNCTION inserisciNuovaMacchina - " .$stringSql." - ". mysql_error());
return $sql;
}
 
 ?>
