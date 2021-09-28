<?php
/**
 * Seleziona tutti i campi della tabella lab_bilancia di una data macchina
 * @param type $idLabMacchina
 * @return type
 */
function findBilanciaByIdMacchina($idLabMacchina){
    
    $stringSql="SELECT * FROM serverdb.lab_bilancia 
                                            WHERE 
                                              id_lab_macchina= " . $idLabMacchina;
  $sql=mysql_query($stringSql) 
          or die("ERROR IN script_lab_bilancia - FUNCTION findBilanciaByIdMacchina -  " .$stringSql." - ". mysql_error());
  
  return $sql;
    
    
}
?>
