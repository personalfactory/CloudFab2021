<?php

function deleteAggiornamentoConfigOri(){
   
    
    $sqlString = "DELETE FROM origamidb.aggiornamento_config_ori";
            
    $sql = mysql_query($sqlString);
    //or die("ERROR IN script_aggiornamento_config_ori - FUNCTION deleteAggiornamentoConfigOri - ".$sqlString ." ". mysql_error());
    return $sql;
}

function setAutoincrementAggConfigOri(){   
    
    $sqlString = "ALTER TABLE origamidb.aggiornamento_config_ori AUTO_INCREMENT=1";
            
    $sql = mysql_query($sqlString);
    //or die("ERROR IN script_aggiornamento_config_ori - FUNCTION setAutoincrementAggConfigOri - ".$sqlString ." ". mysql_error());
    return $sql;
}

function inizializzaAggiornamentoConfigOri(){
   
    $sqlString = "INSERT INTO origamidb.aggiornamento_config_ori SELECT * FROM serverdb.aggiornamento_config";
    $sql = mysql_query($sqlString);
    //or die("ERROR IN script_macchina_ori - FUNCTION inizializzaNewMacchinaOri - ".$sqlString ." ". mysql_error());
    return $sql;
}
