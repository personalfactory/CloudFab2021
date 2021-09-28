<?php

/**
 * Cerca un dato codice movimento nella tabella mov_magazzino
 * @param type $codMov
 * @return type
 */
function findMovMagazzinoByCodMov($codMov){
    
$sql=mysql_query("SELECT * FROM serverdb.mov_magazzino
                 WHERE cod_mov='".$codMov."'")
        or die("ERROR IN script_mov_magazzino - FUNCTION findMovMagazzinoByCodMov -SELECT * FROM serverdb.mov_magazzino : " . mysql_error());
    return $sql;
}


/**
 * Inserisce un nuovo record nella tabela mov_magazzino
 * @param type $codMov
 * @param type $stato
 */
function inserisciCodMov($codMov,$stato){
    
    $sql=mysql_query("INSERT INTO serverdb.mov_magazzino 
                           (cod_mov,stato,dt_inser)
                        VALUES 
                            ('".$codMov."',".$stato.",NOW())")
or die("ERROR IN script_mov_magazzino - FUNCTION inserisciCodMov - INSERT INTO serverdb.mov_magazzino : " . mysql_error());
    
    return $sql;
}

/**
 * Seleziona tutti i codici mov dalla tabella serverdb.mov_magazzino
 * @return type
 */
function findAllCodMovimento(){
$sql = mysql_query("SELECT * FROM serverdb.mov_magazzino") 
        or die("ERROR IN script_mov_magazzino - FUNCTION findAllCodMovimento - SELECT * FROM mov_magazzino " . mysql_error());
return $sql;
}

?>