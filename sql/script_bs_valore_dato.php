<?php

function findValoriDatiByCliente($idCliente,$campoOrdine,$lingua) {
   $stringSql = "SELECT v.id_dato AS id_dato,nome_visibile_".$lingua.",nome_dato,v.valore AS valore,uni_mis,d.tipo1 
                        FROM 
                            serverdb.bs_valore_dato v JOIN serverdb.bs_dato d
                            ON v.id_dato=d.id_dato
                        WHERE 
                            v.id_cliente=".$idCliente."
                        ORDER BY 
                            ".$campoOrdine;
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_valore_dato - FUNCTION findValoriDatiByCliente - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}

function eliminaValoriDatiByCliente($idCliente) {
   $stringSql = "DELETE 
                        FROM 
                            serverdb.bs_valore_dato 
                        WHERE                        
                            id_cliente=".$idCliente;
                        
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_valore_dato - FUNCTION eliminaValoriDatiByCliente - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}

function findValoriDati($campoOrdine,$idCliente) {
   $stringSql = "SELECT * 
                        FROM 
                            serverdb.bs_valore_dato v JOIN serverdb.bs_dato d
                            ON v.id_dato=d.id_dato
                        WHERE 
                            v.id_cliente=".$idCliente."
                        ORDER BY 
                            ".$campoOrdine;
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_valore_dato - FUNCTION findValoriDati - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}


function findValoriDatiByTipo( $campoOrdine,$strUtentiAziendeVis,$tipo) {
   $stringSql = "SELECT * 
                        FROM 
                            serverdb.bs_valore_dato v JOIN serverdb.bs_dato d
                            ON v.id_dato=d.id_dato
                        WHERE 
                            (d.id_utente,d.id_azienda ) IN ".$strUtentiAziendeVis."
                        AND d.tipo= '".$tipo."'       
                        ORDER BY 
                            ".$campoOrdine;
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_valore_dato - FUNCTION findValoriDatiByTipo - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}

function inserisciValoriDati( $idDato,$valore,$idCliente,$anno) {
    $stringSql = "INSERT INTO serverdb.bs_valore_dato (id_dato,valore,id_cliente,anno)
                        VALUES (".$idDato.",
                            '".$valore."',
                                ".$idCliente.",
                                    '".$anno."')";
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_valore_dato - FUNCTION inserisciValoriDati - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}





?>
