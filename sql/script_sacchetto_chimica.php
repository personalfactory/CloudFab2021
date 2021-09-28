<?php
/**
 * Seleziona i ddt di una data miscela
 * @param type $idMiscela
 * @return type
 */
function findBolleByMiscela($idMiscela){
    $stringSql="SELECT * FROM serverdb.sacchetto_chimica  s
        INNER JOIN serverdb.chimica c ON s.cod_chimica=c.cod_chimica 
        INNER JOIN serverdb.lotto l ON c.cod_lotto=l.cod_lotto
        INNER JOIN serverdb.bolla b ON (b.num_bolla=l.num_bolla AND b.dt_bolla=l.dt_bolla)
        INNER JOIN serverdb.macchina m ON m.id_macchina=b.id_macchina
        WHERE id_miscela = " . $idMiscela."
        GROUP BY l.num_bolla,l.dt_bolla" ;
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_sacchetto_chimica - FUNCTION  findBolleByMiscela - ". $stringSql." - ". mysql_error());
  return $sql;
    
}

/**
 * Seleziona i lotti di una data miscela
 * @param type $idMiscela
 * @return type
 */
function findCodLottoByMiscela($idMiscela){
    $stringSql="SELECT * FROM serverdb.sacchetto_chimica  s
        INNER JOIN serverdb.chimica c ON s.cod_chimica=c.cod_chimica 
        WHERE id_miscela = " . $idMiscela."
       GROUP BY cod_lotto" ;
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_sacchetto_chimica - FUNCTION  findCodLottoByMiscela - ". $stringSql." - ". mysql_error());
  return $sql;
    
}


/**
 * Seleziona la miscela di origine di un dato kit
 * @param type $codiceChimica
 * @return type
 */
function findMiscelaByCodKit($codiceChimica){
    
     $stringSql = "SELECT * FROM serverdb.sacchetto_chimica
                               WHERE cod_chimica='" . $codiceChimica . "'";
     $sql = mysql_query($stringSql) 
            or die("ERROR IN script_sacchetto_chimica - FUNCTION  findMiscelaByCodKit - ". $stringSql." - ". mysql_error());
  return $sql;
}

/**
 * Inserisce un nuovo sacchetto nella tabella sacchetto_chimica di serverdb 
 * associandolo alla miscela
 * @param type $codiceChimica
 * @param type $idMiscela
 * @return type
 */
function inserisciSacchettoChimica($codiceChimica,$idMiscela){
        
    $stringSql="INSERT INTO serverdb.sacchetto_chimica						 										
                          (cod_chimica,
                          id_miscela) 
                      VALUES(
                        '" . $codiceChimica . "',
                        '" . $idMiscela . "')";
    
$sql = mysql_query($stringSql);
//        or die("ERROR IN script_sacchetto_chimica - FUNCTION  findMiscelaByCodKit - ". $stringSql." - ". mysql_error());
  return $sql;
}



//function findInfoMiscelaByKit($codiceChimica){
//    
//     $stringSql = "SELECT * FROM serverdb.sacchetto_chimica s JOIN serverdb.miscela m ON s.id_miscela=m.id_miscela 
//                               WHERE s.cod_chimica='" . $codiceChimica . "'";
//     $sql = mysql_query($stringSql) 
//            or die("ERROR IN script_sacchetto_chimica - FUNCTION  findInfoMiscelaByKit - ". $stringSql." - ". mysql_error());
//  return $sql;
//}
?>
