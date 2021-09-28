<?php

function findDatiDefaultBs($campoOrdine,$strUtentiAziendeVis,$tipo) {
   $stringSql = "SELECT * 
                        FROM 
                            serverdb.bs_dato                             
                        WHERE 
                            tipo='".$tipo."'
                        AND
                            (id_utente,id_azienda) IN ".$strUtentiAziendeVis."
                        ORDER BY 
                            ".$campoOrdine;
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_dati - FUNCTION findDatiDefaultBs - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}
?>
