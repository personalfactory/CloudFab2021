<?php

/**
 * Seleziona tutti i parametri prod mac
 * @param type $campoOrdine
 * @return type
 */
function findAllParametriProdMac($campoOrdine){
    $sqlString="SELECT * FROM serverdb.parametro_prod_mac ORDER BY ".$campoOrdine;

   $sql = mysql_query($sqlString) 
           or die("ERROR IN script_parametro_prod_mac - FUNCTION findAllParametriProdMac - ".$sqlString ." ". mysql_error());
   return $sql;
}


function findParProdMacByIdOrNome($idParametro, $nomeParametro){
	$sqlString= "SELECT * FROM serverdb.parametro_prod_mac
                WHERE 
                  id_par_pm=" . $idParametro . " 
                OR 
                  nome_variabile = '" . $nomeParametro . "'";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_prod_mac - FUNCTION findParProdMacByIdOrNome - ".$sqlString ." ". mysql_error());
	return $sql;
}

function insertNewParProdMac($idParametro, $nomeParametro, $descriParametro, $valoreBase, $dataCorrente){
	$sqlString= "INSERT INTO serverdb.parametro_prod_mac 
                                    (id_par_pm,
                                    nome_variabile,
                                    descri_variabile,
                                    valore_base,
                                    abilitato,
                                    dt_abilitato) 
				VALUES ( 
                                        " . $idParametro . ",
                                        '" . $nomeParametro . "',
                                        '" . $descriParametro . "',
                                        '" . $valoreBase . "',
                                        1,
                                        '" . $dataCorrente . "')";

	$sql = mysql_query($sqlString) ;
//	or die("ERROR IN script_parametro_prod_mac - FUNCTION insertNewParProdMac - ".$sqlString ." ". mysql_error());
	return $sql;
}


function selectParProdMacByFiltri($idParPM,$nomeVariabile,$descriVariabile,$valore,$abilitato,$dtAbilitato,$filtro){
    
  
   $sql = mysql_query("SELECT * FROM serverdb.parametro_prod_mac  
              WHERE
                  id_par_pm LIKE '%".$idParPM."%' 
                AND 
                  nome_variabile LIKE '%".$nomeVariabile."%'
                AND
                  descri_variabile LIKE '%".$descriVariabile."%'
                AND
                  valore_base LIKE '%".$valore."%'
                AND
                  abilitato LIKE '%".$abilitato."%'
                AND
                dt_abilitato LIKE '%".$dtAbilitato."%'
          
              ORDER BY ".$filtro)  
           or die("ERROR IN script_parametro_parametro_prod_mac - FUNCTION selectParProdMacByFiltri - SELECT * FROM parametro_comp_prod : " . mysql_error());
  return $sql;
}
