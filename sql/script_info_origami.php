<?php

/**
 * Seleziona tutte le informazioni dalla tabella info origami in base ai filtri
 * @param type $campoOrdine
 * @param type $campoGroupBy
 * @param type $priorita
 * @param type $descriStab
 * @param type $tipoInfo
 * @param type $sottoTipoInfo
 * @param type $posizione
 * @param type $info
 * @param type $dtAbilitato
 * @param type $utente
 * @param type $strUtentiAziende
 * @return type
 */
 
function selectInfoOrigamiByFiltri($campoOrdine, $campoGroupBy, $priorita, $descriStab, $tipoInfo, $sottoTipoInfo, $posizione, $info,$dtAbilitato,$utente,$strUtentiAziende) {
    $stringSql="SELECT *,i.dt_abilitato AS dt_abil FROM serverdb.info_origami i
        INNER JOIN serverdb.macchina m ON  m.id_macchina=i.id_macchina
        WHERE 
            i.priorita LIKE '%" . $priorita . "%'
         AND 
            descri_stab LIKE '%" . $descriStab . "%'
         AND
            tipo_info LIKE '%" . $tipoInfo . "%'
         AND 
            sotto_tipo LIKE '%" . $sottoTipoInfo . "%'
         AND 
            posizione LIKE '%" . $posizione . "%'
         AND 
            info LIKE '%" . $info . "%'
         AND 
            i.dt_abilitato LIKE '%" . $dtAbilitato . "%'
         AND 
            utente LIKE '%" . $utente . "%'   
         AND 
            (m.id_utente,m.id_azienda) IN ".$strUtentiAziende."
         GROUP BY " . $campoGroupBy . "       
         ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_info_origami - FUNCTION selectInfoOrigamiByFiltri - ". $stringSql." - ". mysql_error());

    return $sql;
}


/**
 * Seleziona tutti i dati dalla tabella info_origami
 * @param type $campoGroupBy
 * @return type
 */
function selectAllInfoGroupBy($campoGroupBy,$strUtentiAziende){
    
    
    $stringSql="SELECT * FROM serverdb.info_origami i JOIN  serverdb.macchina m 
                    ON i.id_macchina=m.id_macchina
                WHERE 
                    (m.id_utente,m.id_azienda) IN ".$strUtentiAziende."
                    GROUP BY " . $campoGroupBy ;      
         
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_info_origami - FUNCTION selectAllInfoGroupBy - ". $stringSql." - ". mysql_error());

    return $sql;
    
    
}

/**
 * Inserisce una nuova informazone nella tabella info_origami
 * @param type $idMacchina
 * @param type $tipo
 * @param type $sottoTipo
 * @param type $info
 * @param type $stato
 * @param type $note
 * @param type $dtAbilitato
 * @param type $utente
 * @param $posizione
 * @param $dtApertura
 * @param $dtChiusura
 * @param $operChiusura
 * @return type
 */
function insertInfoOrigami($idMacchina,$tipo,$sottoTipo,$info,$stato,$note,$dtAbilitato,$utente,$posizione,$dtApertura,$dtChiusura,$priorita,$operChiusura){
    
    
    $stringSql="INSERT INTO serverdb.info_origami (id_macchina,tipo_info,sotto_tipo,info,stato,note,dt_abilitato,utente,posizione,dt_apertura,dt_chiusura,priorita,operatore_chiusura)
        VALUES (".$idMacchina.",'".$tipo."','".$sottoTipo."',
            '".$info."','".$stato."','".$note."','".$dtAbilitato."','".$utente."','".$posizione."','".$dtApertura."','".$dtChiusura."','".$priorita."','".$operChiusura."')";
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_info_origami - FUNCTION insertInfoOrigami - ". $stringSql." - ". mysql_error());

    return $sql;
    
    
}

/**
 * Modifica una informazione/un record avente un dato id nella tabella info_origami
 * @param type $id
 * @param type $idMacchina
 * @param type $tipo
 * @param type $sottoTipo
 * @param type $info
 * @param type $stato
 * @param type $note
 * @param type $dtAbilitato
 * @param type $utente
 * @param type $posizione
 * @param type $dtApertura
 * @param type $dtChiusura
 * @param type $priorita
 * @param type $operChiusura
 * 
 * @return type
 */
function updateInfoOrigami($id,$idMacchina,$tipo,$sottoTipo,$info,$stato,$note,$dtAbilitato,$utente,
        $posizione,$dtChiusura,$priorita,$operChiusura){
    
    
    $stringSql="UPDATE serverdb.info_origami 
        SET id_macchina=".$idMacchina.",
            tipo_info='".$tipo."',
                sotto_tipo='".$sottoTipo."',
                    info='".$info."',
                        stato='".$stato."',
                            note='".$note."',
                                dt_abilitato='".$dtAbilitato."',
                                    utente='".$utente."',
                                        posizione='".$posizione."',
                                            dt_chiusura='".$dtChiusura."',
                                                    priorita='".$priorita."',
                                                        operatore_chiusura='".$operChiusura."'
                                        WHERE id=".$id;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_info_origami - FUNCTION updateInfoOrigami - ". $stringSql." - ". mysql_error());

    return $sql;
    
    
}

/**
 * Seleziona una particolare informazione dalla tabella info_origami
 * @param type $Id
 * @return type
 */
function findInfoById($Id){    
    
    $stringSql="SELECT * FROM serverdb.info_origami   
         WHERE id= " . $Id ;      
         
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_info_origami - FUNCTION findInfoById - ". $stringSql." - ". mysql_error());

    return $sql;
    
    
}
?>
