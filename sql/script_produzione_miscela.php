<?php

/**
 * Elimina i dati relativi ad un dato contenitore
 * @param type $contenitore
 * @return type
 */
function deleteProdMiscela($contenitore) {

    $stringSql = "DELETE FROM serverdb.produzione_miscela 
        WHERE cod_contenitore='" . $contenitore . "'";
    $sql = mysql_query($stringSql);
//    or die("ERROR IN script_produzione_miscela.php - FUNCTION deleteProdMiscela - " . $stringSql." - ".mysql_error());

    return $sql;
}

function selectProdMiscelaByContenitore($contenitore) {

    $stringSql = "SELECT 
                      produzione_miscela.id_miscela,
                      miscela.dt_miscela,
                      produzione_miscela.cod_formula,
                      formula.descri_formula,
                      miscela.peso_reale
                    FROM 
                      serverdb.produzione_miscela 
                    INNER JOIN 
                      serverdb.miscela
                    ON 
                      produzione_miscela.id_miscela=miscela.id_miscela
                    INNER JOIN 
                      serverdb.formula
                    ON 
                      produzione_miscela.cod_formula=formula.cod_formula
                    WHERE 
                      produzione_miscela.cod_contenitore='" . $contenitore . "' 
                    GROUP BY 
                      produzione_miscela.cod_contenitore";

   $sql = mysql_query($stringSql);
//    or die("ERROR IN script_produzione_miscela.php - FUNCTION selectProdMiscelaByContenitore - " . $stringSql." - ".mysql_error());

    return $sql;
}


/**
 * Elimina i dati relativi ad una data miscela nella tabella produzione_miscela
 * @param type $idMiscela
 * @return type
 */
function deleteProdMiscelaById($idMiscela) {

    $stringSql = "DELETE FROM serverdb.produzione_miscela 
        WHERE id_miscela='" . $idMiscela . "'";
    $sql = mysql_query($stringSql);
//    or die("ERROR IN script_produzione_miscela.php - FUNCTION deleteProdMiscela - " . $stringSql." - ".mysql_error());

    return $sql;
}
?>
