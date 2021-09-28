<?php
/**
 * Inserisce un nuovo allegato nella tabella lab_allegato
 * @param type $idCarat
 * @param type $idRif
 * @param type $descri
 * @param type $link
 * @param type $tipoRif
 * @param type $note
 * @param type $dtAbilitato
 * @return type
 */
function inserisciNuovoAllegato($idCarat, $idRif, $descri, $link, $tipoRif,$note) {

    $stringSql="INSERT INTO serverdb.lab_allegato (
                                    id_carat, 
                                    id_rif,
                                    descri,
                                    link,
                                    tipo_rif,
                                    note) 
                            VALUES ( 
                                    " . $idCarat . ",
                                    " . $idRif . ",
                                    '" . $descri . "',
                                    '" . $link . "',
                                    '" . $tipoRif . "',
                                    '" . $note . "'
                                   )";
    
    $sql = mysql_query($stringSql);
//            or die("ERROR IN script_lab_allegato - FUNCTION inserisciNuovoAllegato - ".$stringSql." - " . mysql_error());
    return $sql;
}


/**
 * Seleziona tutti i file allegati ad un dato esperimento/materia prima e di una data caratteristica
 * @param type $idRif
 * @param type $idCar
 * @param type $tipoRif
 * @param type $nomeTabCar
 */
function findAllegatiByIdRifCar($idRif,$idCar,$tipoRif,$nomeTabCar){
        
    $stringSql="SELECT *,a.dt_abilitato AS data_caricato 
        FROM  serverdb.lab_allegato a 
        INNER JOIN serverdb.".$nomeTabCar." c 
        ON a.id_carat=c.id_carat
        WHERE 
            id_rif=" . $idRif . " 
        AND 
            a.id_carat=".$idCar." 
        AND
            a.tipo_rif='".$tipoRif."'
        ORDER BY link";
    
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_lab_allegato - FUNCTION findAllegatiByIdEsp - ".$stringSql." - " . mysql_error());
    return $sql;
    
}

/**
 * Seleziona tutti gli allegati di un esperimento associato a caratteristiche 
 * che non sono presenti nella tabella lab_risultato_car
 * @param type $idRif
 * @param type $tipoRif
 * @return type
 */
function findAllegatiCarByIdRif($idRif,$tipoRif){
    
   $stringSql="SELECT *,a.dt_abilitato AS data_caricato 
        FROM  serverdb.lab_allegato a 
        INNER JOIN serverdb.lab_caratteristica c 
        ON a.id_carat=c.id_carat
        WHERE id_rif= " . $idRif . " 
            AND
            a.tipo_rif='".$tipoRif."'
            AND a.id_carat 
            NOT IN 
                (SELECT id_carat FROM serverdb.lab_risultato_car WHERE id_esperimento= " . $idRif . " )
        GROUP BY caratteristica 
        ORDER BY caratteristica";
    
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_lab_allegato - FUNCTION findAllegatiCarByIdRif - ".$stringSql." - " . mysql_error());
    return $sql;
    
    
}


/**
 * Seleziona tutti gli allegati di una materia prima associato a caratteristiche 
 * che non sono presenti nella tabella lab_matpri_car
 * @param type $idRif
 * @param type $tipoRif
 * @return type
 */
function findAllegatiPropByIdRif($idRif,$tipoRif){
    
    $stringSql="SELECT *,a.dt_abilitato AS data_caricato 
        FROM  serverdb.lab_allegato a 
        INNER JOIN serverdb.lab_caratteristica_mt c 
        ON a.id_carat=c.id_carat
        WHERE id_rif= " . $idRif . " 
            AND
            a.tipo_rif='".$tipoRif."'
            AND a.id_carat 
            NOT IN 
                (SELECT id_carat FROM serverdb.lab_matpri_car WHERE id_mat= " . $idRif . " )
        GROUP BY caratteristica 
        ORDER BY caratteristica";
    
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_lab_allegato - FUNCTION findAllegatiPropByIdRif - ".$stringSql." - " . mysql_error());
    return $sql;
    
    
}

/**
 * Elimina un allegato
 * @param type $idRif
 * @param type $idCar
 * @param type $tipoRif
 */
function deleteAllegatoByIdRifCar($idRif,$idCar,$tipoRif){
    
    
    $stringSql="DELETE FROM serverdb.lab_allegato
        WHERE 
            id_rif= " . $idRif . " 
        AND 
            id_carat=".$idCar." 
        AND
            tipo_rif='".$tipoRif."'
        ORDER BY link";
    
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_lab_allegato - FUNCTION deleteAllegatoByIdRifCar - ".$stringSql." - " . mysql_error());
    return $sql;
    
}

/**
 * Seleziona tutti gli allegati di un dato esperimento/materia_prima
 * @param type $idRif
 * @param type $tipoRif
 * @param type $campoOrdine
 * @return type
 */
//function findAllegatiByIdRif($idRif,$tipoRif,$campoOrdine){
//    
//    $stringSql="SELECT * FROM serverdb.lab_allegato 
//                WHERE 
//                    id_rif= " . $idRif . " 
//                AND
//                    tipo_rif='".$tipoRif."' 
//                ORDER BY ".$campoOrdine;
//    
//    $sql = mysql_query($stringSql)
//            or die("ERROR IN script_lab_allegato - FUNCTION findAllegatiByIdRif - ".$stringSql." - " . mysql_error());
//    return $sql;
    
    
//}



?>
