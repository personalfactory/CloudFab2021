<?php

function deleteMacchinaOri() {
   
    
    $sqlString = "DELETE FROM origamidb.macchina_ori";
    $sql = mysql_query($sqlString);
    //or die("ERROR IN script_macchina_ori - FUNCTION deleteMacchinaOri - ".$sqlString ." ". mysql_error());
    return $sql;
}

function inizializzaNewMacchinaOri($idMacchina, $codiceStab, $descriStab, $ragso1, $abilitato, $dtAbilitato, $userOrigami, $userServer, $passOrigami, $passServer, $userFtp, $passFtp, $passZip) {
   
    
    $sqlString = "INSERT INTO origamidb.macchina_ori (
                          id_macchina,  
                          cod_stab,
                          descri_stab,
                          ragso1,
                          abilitato,
                          dt_abilitato,
                          user_origami,
                          user_server,
                          pass_origami,
                          pass_server,
                          ftp_user,
                          ftp_password,
                          zip_password) 
					VALUES (" . $idMacchina . ",
                                                '" . $codiceStab . "',
                                                '" . $descriStab . "',
                                                '" . $ragso1 . "',
                                                " . $abilitato . ",
                                                '" . $dtAbilitato . "',
                                                '" . $userOrigami . "',
                                                '" . $userServer . "',
                                                '" . $passOrigami . "',
                                                '" . $passServer . "',
                                                '" . $userFtp . "',
						'" . $passFtp . "',
                                                '" . $passZip . "')";
    $sql = mysql_query($sqlString);
    //or die("ERROR IN script_macchina_ori - FUNCTION inizializzaNewMacchinaOri - ".$sqlString ." ". mysql_error());
    return $sql;
}


