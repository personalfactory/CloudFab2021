<?php
/**
 * Seleziona tutti i codici dei kit di una data macchina
 * non presenti nella tabella processo
 * @param type $idMacchina
 * @return type
 */
function selectMagOriByIdMac($campoOrdine,$idMacchina,$codProdtto,$nomeProdotto,$codChimica,$codLotto,$numDdt,$dtDdt){
    
    
    $stringSql="SELECT * FROM serverdb.bolla b
                            INNER JOIN lotto l ON b.id_bolla = l.id_bolla
                            INNER JOIN chimica c ON l.cod_lotto = c.cod_lotto
                         WHERE 
                            b.id_macchina=" . $idMacchina . "
                         AND           
                            cod_prodotto LIKE '%".$codProdtto."%'
                         AND           
                            descri_formula LIKE '%".$nomeProdotto."%'
                         AND           
                            c.cod_chimica LIKE '%".$codChimica."%'
                         AND           
                            l.cod_lotto LIKE '%".$codLotto."%'
                         AND 
                            b.num_bolla LIKE '%".$numDdt."%'
                         AND 
                            b.dt_bolla LIKE '%".$dtDdt."%'
                         AND 
                            c.cod_chimica NOT IN 
                         (SELECT cod_chimica FROM serverdb.processo WHERE id_macchina=" . $idMacchina . " )
                             ORDER BY ".$campoOrdine ;      
         
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_bolla.php - FUNCTION selectMagOriByIdMac - ". $stringSql." - ". mysql_error());

    return $sql;
    
    
}


function findDdtInBolla($numDdt,$dataEmi){
    $stringSql="SELECT * FROM serverdb.bolla
                                      WHERE
                                        num_bolla='" . $numDdt . "' 
                                      AND 
                                        dt_bolla='" . $dataEmi . "'";
    
     $sql = mysql_query($stringSql)
               or die("ERROR IN script_bolla.php - FUNCTION findDdtInBolla - ". $stringSql." - ". mysql_error());
     return $sql;
}


function inserisciDdtInBolla($numDdt,$dataEmi,$codStab,$idMacchina){

  $stringSql = "INSERT INTO serverdb.bolla (num_bolla,dt_bolla,cod_stab,id_macchina) 
                        VALUES(
                              '" . $numDdt . "',
                              '" . $dataEmi . "',
                              '" . $codStab . "',
                              '" . $idMacchina . "')";
  
  $sql = mysql_query($stringSql);
//               or die("ERROR IN script_bolla.php - FUNCTION inserisciDdtInBolla - ". $stringSql." - ". mysql_error());

  
  return $sql;
}

?>
