<?php
/**
 * Seleziona tutti i contenitori della tabella miscela_contenitore 
 * unita a produzione_miscela, unita a miscela, unita a formula
 * @return type
 */

function findAllContenitori(){
    
    $stringSql="SELECT c.cod_contenitore AS contenitore,stato,p.cod_formula,
                        m.id_miscela,dt_miscela,peso_reale,f.descri_formula                           
                        FROM 
                            serverdb.miscela_contenitore c
                        LEFT JOIN 
                            serverdb.produzione_miscela p ON c.cod_contenitore=p.cod_contenitore
                        LEFT JOIN 
                            serverdb.miscela m ON m.id_miscela=p.id_miscela
                        LEFT JOIN 
                            serverdb.formula f ON f.cod_formula=m.cod_formula
                        GROUP BY c.cod_contenitore
                        ORDER BY c.cod_contenitore";
    $sql = mysql_query($stringSql) 
    or die("ERROR IN script_miscela_contenitore.php - FUNCTION findAllContenitori - ".$stringSql ." - ". mysql_error());
    return $sql;
    
}

/**
 * Modifica lo stato di un contenitore
 * @param type $stato
 * @param type $contenitore
 * @return type
 */
function updateContenitore($stato,$contenitore){
    
    $stringSql="UPDATE serverdb.miscela_contenitore SET stato=".$stato." WHERE cod_contenitore='".$contenitore."'";
    
    $sql=mysql_query($stringSql);
//   or die("ERROR IN script_miscela_contenitore.php - FUNCTION updateContenitore - " .$stringSql. " - " .mysql_error());
    return $sql;
}

/**
 * Seleziona i contenitore con un dato stato (1- libero / 0- impegnato)
 * @param type $stato
 */
function selectContenitoreByStato($stato){
    $stringSql="SELECT cod_contenitore FROM serverdb.miscela_contenitore WHERE stato=".$stato." ORDER BY cod_contenitore";
    $sql=mysql_query($stringSql);
// or die("ERROR IN script_miscela_contenitore - FUNCTION selectContenitoreByStato - ".$stringSql ." - ". mysql_error());
    return $sql;
}

?>
