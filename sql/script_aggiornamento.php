<?php

/**
 * Seleziona l'ultima versione di aggiornamento di un dato tipo 
 * di una data macchina
 * @param type $tipo
 * @param type $idMacchina
 * @return type
 */
function findMaxVersioneAggByTipoIdMac($tipo, $idMacchina) {

    $stringSql = "SELECT MAX(versione) AS versione FROM serverdb.aggiornamento 
                WHERE 
                    tipo='" . $tipo . "' 
                AND 
                    id_macchina=" . $idMacchina;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_aggiornamento - FUNCTION findMaxVersioneAggByTipoIdMac - " . $stringSql . " - " . mysql_error());
    return $sql;
}

function findAggByTipoIdMacVersione($tipo, $idMacchina, $versione) {

    $stringSql = "SELECT * 
                  FROM 
                    serverdb.aggiornamento a
                  INNER JOIN 
                    serverdb.macchina m
                  ON 
                    a.id_macchina=m.id_macchina
                  WHERE 
                    tipo='" . $tipo . "' 
                  AND 
                    versione =" . $versione . "
                  AND 
                    a.id_macchina=" . $idMacchina;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_aggiornamento - FUNCTION findAggByTipoIdMacVersione - " . $stringSql . " - " . mysql_error());
    return $sql;
}

/**
 * Seleziona tutti gli aggiornamenti di un dato tipo successivi ad una certa data
 * @param type $tipo
 * @param type $dtUltAgg
 * @return type
 */
function findAggByTipoDtUltAgg($tipo, $dtUltAgg) {

    $stringSql = "SELECT * 
                  FROM 
                    serverdb.aggiornamento a
                  INNER JOIN 
                    serverdb.macchina m
                  ON 
                    a.id_macchina=m.id_macchina
                  WHERE 
                    tipo='" . $tipo . "' 
                 AND 
                    dt_aggiornamento>'" . $dtUltAgg . "'";
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_aggiornamento - FUNCTION findAggByTipoDtUltAgg - " . $stringSql . " - " . mysql_error());
    return $sql;
}

/**
 * Conta gli aggiornamenti di un dato tipo e l'ultima data
 * @param type $tipo
 * @return type
 */
function countAgg($tipo) {

    $stringSql = "SELECT COUNT(*) AS num_agg_out, MAX(dt_aggiornamento) AS dt_ult_agg FROM aggiornamento WHERE tipo='" . $tipo . "'";

    $sql = mysql_query($stringSql)
            or die("ERROR IN script_aggiornamento - FUNCTION countAgg - " . $stringSql . " - " . mysql_error());
    return $sql;
}

function findAllFileByFiltri($campoOrdine, $campoGroupBy, $idMacchina, $descriStab, $tipo, $nomeFile, $versione, $dtAggiornamento) {

    $stringSql = "SELECT * 
                  FROM 
                    serverdb.aggiornamento a
                  JOIN 
                    serverdb.macchina m
                  ON 
                    a.id_macchina=m.id_macchina
                  WHERE 
                    tipo LIKE '%" . $tipo . "%' 
                  AND 
                    a.id_macchina LIKE '%" . $idMacchina . "%'
                  AND 
                    m.descri_stab LIKE '%" . $descriStab . "%'  
                  AND 
                    tipo LIKE '%" . $tipo . "%'
                  AND                                  
                    nome_file LIKE '%" . $nomeFile . "%'
                  AND       
                    versione LIKE '%" . $versione . "%'
                  AND 
                    dt_aggiornamento LIKE '%" . $dtAggiornamento . "%' GROUP BY " . $campoGroupBy . " ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_aggiornamento - FUNCTION findAllFileByFiltri - " . $stringSql . " - " . mysql_error());
    return $sql;
}




function deleteAggiornamentoById($idRecord) {

    $stringSql = "DELETE FROM serverdb.aggiornamento WHERE id=" . $idRecord;


    $sql = mysql_query($stringSql)
            or die("ERROR IN script_aggiornamento - FUNCTION deleteAggiornamentoById - " . $stringSql . " - " . mysql_error());

    return $sql;
}

?>
