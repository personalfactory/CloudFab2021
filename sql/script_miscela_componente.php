<?php
/**
 * Seleziona le materie prime di una data miscela
 * @param type $idMiscela
 * @return type
 */
function findMatPrimeByIdMiscela($idMiscela) {
    $stringSql = "SELECT
                                    *                                    
				FROM
                                    serverdb.miscela_componente
                                JOIN 
                                    serverdb.miscela
                                ON 
                                    miscela.id_miscela=miscela_componente.id_miscela
                                JOIN materia_prima 
                                WHERE  
                                    materia_prima.cod_mat= SUBSTRING_INDEX(cod_mov, '.', 1)
                                AND
                                    miscela_componente.id_miscela='" . $idMiscela . "'"; 
        
     $sql = mysql_query($stringSql) 
             or die("ERROR IN script_miscela_componente.php - FUNCTION findMatPrimeByIdMiscela - " . $stringSql . " " . mysql_error());


    return $sql;
}


/**
 * Seleziona le materie prime di una data miscela
 * @param type $idMiscela
 * @return type
 */
function findGeneraFormulaByMiscela($idMiscela,$codiceFormula) {
    $stringSql = "SELECT  * FROM 
                                    serverdb.miscela_componente mc
                                JOIN 
                                    serverdb.miscela m
                                ON 
                                    m.id_miscela=mc.id_miscela
                                JOIN serverdb.materia_prima mt
                                JOIN serverdb.generazione_formula g
                                ON mt.cod_mat=g.cod_mat
                                WHERE  
                                    mt.cod_mat= SUBSTRING_INDEX(cod_mov, '.', 1)
                                AND
                                    g.cod_formula='".$codiceFormula."'
                                AND
                                    mc.id_miscela='" . $idMiscela . "'"; 
        
     $sql = mysql_query($stringSql) 
             or die("ERROR IN script_miscela_componente.php - FUNCTION findGeneraFormulaByMiscela - " . $stringSql . " " . mysql_error());


    return $sql;
}


function findMisceleByIdMov($idMov) {
     $stringSql = "SELECT  * FROM 
                                    serverdb.miscela_componente mc
                                JOIN 
                                    serverdb.miscela m
                                ON 
                                    m.id_miscela=mc.id_miscela
                                JOIN 
                                    serverdb.formula f
                                ON 
                                    m.cod_formula=f.cod_formula
                                WHERE  
                                   cod_mov LIKE '%." . $idMov . ".%'"; 
        
     $sql = mysql_query($stringSql) 
             or die("ERROR IN script_miscela_componente.php - FUNCTION findMisceleByIdMov - " . $stringSql . " " . mysql_error());


    return $sql;
}

?>
