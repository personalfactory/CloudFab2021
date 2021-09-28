<?php

function insertValoreParOrdine($idPar, $idMacchina,$idOrdineSm,$valore, $abilitato, $dtAbilitato){
    
     $stringSql = "INSERT INTO serverdb.valore_par_ordine (
                                                        id_par_ordine,
                                                        id_macchina,
                                                        id_ordine_sm,
                                                        valore,
                                                        abilitato,
                                                        dt_abilitato)
                                                        VALUES (
                                                        " . $idPar . ", 
                                                        " . $idMacchina . ",
                                                        " . $idOrdineSm . ",
                                                        '" . $valore . "',
                                                        " . $abilitato . ", 
                                                        '" . $dtAbilitato . "')";
    $sql = mysql_query($stringSql)
    or die("ERROR IN script_valore_par_ordine - FUNCTION insertValoreParOrdine - " . $stringSql . " " . mysql_error());
    return $sql;
}



function findValoreOrdineByIdOrdineSm($idOrdineSm,$idMacchina){
	$sqlString= "SELECT * FROM serverdb.valore_par_ordine
                                WHERE id_ordine_sm=" . $idOrdineSm." AND id_macchina=".$idMacchina;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_ordine - FUNCTION findValoreOrdineByIdOrdineSm - ".$sqlString ." ". mysql_error());
	return $sql;
}