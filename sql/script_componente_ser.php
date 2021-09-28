<?php

function selectComponenti(){
$sql = mysql_query("SELECT * FROM serverdb.componente ORDER BY descri_componente") 
        or die("ERROR IN script_componente - FUNCTION selectComponenti - SELECT * FROM componente : " . mysql_error());

return $sql;
}

/**
 * Seleziona un componente dalla tabella componntetramite il suo codice
 * @param type $codice
 * @return type
 */
function findComponenteByCod($codice){
     $stringSql = "SELECT * FROM serverdb.componente 
                            WHERE 
                                cod_componente = '" . $codice . "'";
    
    $sql = mysql_query($stringSql) 
    or die("ERROR IN script_componente - FUNCTION findComponenteByCod - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}

/**
 * Inserisce un nuovo componente nella tabella componente
 * @param type $codice
 * @param type $descrizione
 * @param type $abilitato
 * @return type
 */
function inserisciComponente($codice,$descrizione,$abilitato){
    
       $stringSql = "INSERT INTO componente(cod_componente,descri_componente,abilitato) 
                                VALUES ( '" . $codice . "',
                                         '" . $descrizione . "',
                                         " . $abilitato . ")";
       
       $sql = mysql_query($stringSql);
    //or die("ERROR IN script_componente - FUNCTION inserisciComponente - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}
?>
