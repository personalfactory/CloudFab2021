<?php
function inserisciNuovoAllegatoMov($idMacchina, $idMov,$link) {

    $stringSql="INSERT INTO serverdb.allegato_mov_ori (id_macchina,id_mov_inephos,link,dt_abilitato) 
                                     
                            VALUES ( 
                                    " . $idMacchina . ",
                                        " . $idMov . ",
                                    '" . $link . "',
                                    NOW())";
    
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_allegato_mov_ori - FUNCTION inserisciNuovoAllegatoMov - ".$stringSql." - " . mysql_error());
    return $sql;
}



function findAllegatiByIdMov($idMov) {

    $stringSql="SELECT* FROM serverdb.allegato_mov_ori WHERE id_mov_inephos=".$idMov;                            
                          
    
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_allegato_mov_ori - FUNCTION findAllegatiByIdMov - ".$stringSql." - " . mysql_error());
    return $sql;
}