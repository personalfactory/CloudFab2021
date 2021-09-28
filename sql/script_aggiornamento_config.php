<?php

function selectParametroById($idParametro) {

    $sqlString = "SELECT * FROM serverdb.aggiornamento_config WHERE id=" . $idParametro;

    $sql = mysql_query($sqlString);
    //or die("ERROR IN script_aggiornamento_config - FUNCTION selectParametroById - ".$sqlString ." ". mysql_error());
    return $sql;
}

function verificaEsistenzaParametro($id, $nomeParametro) {

    $sqlString = "SELECT * FROM serverdb.aggiornamento_config WHERE parametro='" . $nomeParametro . "' AND id <>" . $id;

    $sql = mysql_query($sqlString);
    //or die("ERROR IN script_aggiornamento_config - FUNCTION verificaEsistenzaParametro - ".$sqlString ." ". mysql_error());
    return $sql;
}

function selectAllAggConfig($campoOrdine) {

    $sqlString = "SELECT * FROM serverdb.aggiornamento_config ORDER BY " . $campoOrdine;

    $sql = mysql_query($sqlString);
    //or die("ERROR IN script_aggiornamento_config - FUNCTION selectAllAggConfig - ".$sqlString ." ". mysql_error());
    return $sql;
}

function findAllAggCongifByFiltri($campoOrdine, $campoGroupBy, $id, $parametro, $valore, $tipo, $descrizione, $abilitato, $dtAbilitato) {

    $stringSql = "SELECT * FROM 
                    serverdb.aggiornamento_config a
                  WHERE 
                    id LIKE '%" . $id . "%'
                  AND     
                    tipo LIKE '%" . $tipo . "%' 
                  AND 
                    parametro LIKE '%" . $parametro . "%'  
                  AND 
                    valore LIKE '%" . $valore . "%'
                  AND                                  
                    descrizione LIKE '%" . $descrizione . "%'
                  AND       
                    abilitato LIKE '%" . $abilitato . "%'
                  AND 
                    dt_abilitato LIKE '%" . $dtAbilitato . "%' GROUP BY " . $campoGroupBy . " ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_aggiornamento - FUNCTION findAllAggCongifByFiltri - " . $stringSql . " - " . mysql_error());
    return $sql;
}



function updateAggConfig($id, $parametro, $valore, $tipo, $descrizione, $abilitato) {

    $sqlString = "UPDATE serverdb.aggiornamento_config SET "
            . "parametro='$parametro', "
            . "valore='$valore', "
            . "tipo='$tipo', "
            . "descrizione='$descrizione',"
            . "abilitato='$abilitato'
                WHERE id=$id ";

    $sql = mysql_query($sqlString);
    //or die("ERROR IN script_aggiornamento_config - FUNCTION updateAggConfig - ".$sqlString ." ". mysql_error());
    return $sql;
}
