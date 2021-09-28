<?php

function inserisciOrdine($idMacchina, $dtOrdine,$dtProgrammata,$costo, $stato, $descriStato,$note, $abilitato, $dtAbilitato,$idUtente,$idAzienda) {

      $stringSql = "INSERT INTO serverdb.ordine_elenco (id_macchina,dt_ordine,dt_programmata,costo,stato,descri_stato,note,abilitato,dt_abilitato,id_utente,id_azienda) 
                        VALUES(
                              " . $idMacchina . ",                              
                              '" . $dtOrdine . "',
                              '" . $dtProgrammata . "',
                              " . $costo . ","
                            . "'" . $stato . "',"
                            . "'" . $descriStato . "',"
                            . "'" . $note . "',"
                            . "'" . $abilitato . "',"
                            . "'" . $dtAbilitato . "',"
                            . "" . $idUtente . ","
                            . "" . $idAzienda . ")";

    $sql = mysql_query($stringSql)
               or die("ERROR IN script_ordine_elenco.php - FUNCTION inserisciOrdine - ". $stringSql." - ". mysql_error());
    return $sql;

}

function findLastIdOrdine($idMacchina,$idUtente,$idAzienda) {

     $stringSql = "SELECT * FROM serverdb.ordine_elenco WHERE id_macchina=".$idMacchina." AND id_utente=".$idUtente." AND id_azienda= ".$idAzienda ;

    $sql = mysql_query($stringSql);
//     or die("ERROR IN script_ordine_elenco.php - FUNCTION findLastIdOrdine - ". $stringSql." - ". mysql_error());
return $sql;
}


function findOrdineById($idOrdine){
    
    $strinSql="SELECT * FROM serverdb.ordine_elenco WHERE id_ordine=" . $idOrdine;
    $sql=mysql_query($strinSql) or die("ERROR IN script_ordine_elenco.php - FUNCTION findOrdineById - " .$strinSql." - " . mysql_error());
    return $sql;
}

?>