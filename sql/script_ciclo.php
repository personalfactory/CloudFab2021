<?php

function findInfoCicloByIdProcessoIdMacchina($idProcesso,$idMacchina) {
   $stringSql = "SELECT * FROM 
                            serverdb.ciclo c JOIN serverdb.ciclo_processo p ON c.id_ciclo=p.id_ciclo  
                            JOIN serverdb.categoria cat ON c.id_cat=cat.id_cat
                        WHERE 
                            id_processo=".$idProcesso."
                        AND
                            c.id_macchina=".$idMacchina;
                       
                            
    $sql = mysql_query($stringSql) or die("ERROR IN script_ciclo - FUNCTION findInfoCicloByIdMacchina - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}



function findMaxNumSacchiInCiclo($idMacchina,$dataInf,$dataSup) {
    $stringSql = "SELECT MAX(num_sacchi) as num_sacchi_max FROM 
                            serverdb.ciclo c 
                        WHERE 
                           (substring(dt_abilitato,1,10)>='".$dataInf."' AND substring(dt_abilitato,1,10)<='".$dataSup."')
                        AND
                           c.id_macchina=".$idMacchina;
                       
                            
    $sql = mysql_query($stringSql) or die("ERROR IN script_ciclo - FUNCTION findMaxNumSacchiInCiclo - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}