<?php

function selectParGlobaliByFiltri($idParGm,$nomeVariabile,$descriVariabile,$valore,$abilitato,$dtAbilitato,$filtro){
  
  
  
   $sql = mysql_query("SELECT * FROM serverdb.parametro_glob_mac  
              WHERE
                  id_par_gm LIKE '%".$idParGm."%' 
                AND 
                  nome_variabile LIKE '%".$nomeVariabile."%'
                AND
                  descri_variabile LIKE '%".$descriVariabile."%'
                AND
                  valore_variabile LIKE '%".$valore."%'
                AND
                  abilitato LIKE '%".$abilitato."%'
                AND
                dt_abilitato LIKE '%".$dtAbilitato."%'
          
              ORDER BY ".$filtro)  or die("ERROR IN script_parametro_glob_mac - FUNCTION selectParGlobaliByFiltri - SELECT * FROM parametro_glob_mac : " . mysql_error());
  return $sql;
}





/**
 * Seleziona un record per id
 * @param unknown $idParametro
 * @return resource
 */
function findParGlobMacById($idParametro){
	$sqlString="SELECT * FROM serverdb.parametro_glob_mac WHERE id_par_gm=" . $idParametro;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_glob_mac - FUNCTION findParGlobMacById - ".$sqlString ." ". mysql_error());
	return $sql;
}




/**
 * Seleziona un record per id, nome, valore e descrizione
 * @param unknown $idParametro
 * @param unknown $nomeVariabile
 * @param unknown $valoreVariabile
 * @param unknown $descriVariabile
 * @param unknown $connessione
 * @return resource
 */
function findParGlobMacByIdNomeValDescri($idParametro, $nomeVariabile, $valoreVariabile, $descriVariabile, $connessione){
	$sqlString="SELECT * FROM serverdb.parametro_glob_mac 
                     WHERE       
                        id_par_gm = " . $idParametro . " 
                    AND  
                        nome_variabile='" . $nomeVariabile . "'
                    AND 
                        valore_variabile='" . $valoreVariabile . "'
		   AND 
                        descri_variabile='" . $descriVariabile . "'";

	$sql = mysql_query($sqlString, $connessione)
	or die("ERROR IN script_parametro_glob_mac - FUNCTION findParGlobMacByIdNomeValDescri - ".$sqlString ." ". mysql_error());
	return $sql;
}






/**
 * Inserisce un valore nello storico
 * @param unknown $idParametro
 * @return resource
 */
function insertStoricoParGlobMac($idParametro){
	$sqlString="INSERT INTO storico.parametro_glob_mac 						 										
                                (id_par_gm,
                                nome_variabile,
                                descri_variabile,
                                valore_variabile,
                                abilitato,
                                dt_abilitato) 
                        SELECT 
                                id_par_gm,
                                nome_variabile,
                                descri_variabile,
                                valore_variabile,
                                abilitato,
                                dt_abilitato
                        FROM 
                                serverdb.parametro_glob_mac
                        WHERE 
                                id_par_gm=" . $idParametro;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_glob_mac - FUNCTION insertStoricoParGlobMac - ".$sqlString ." ". mysql_error());
	return $sql;
}







/**
 * Aggiorna un record in serverdb.parametro_glob_mac 
 * @param unknown $idParametro
 * @param unknown $nomeVariabile
 * @param unknown $valoreVariabile
 * @param unknown $descriVariabile
 * @param unknown $idParametroOld
 * @return resource
 */
function updateServerDBParGlobMac($idParametro, $nomeVariabile, $valoreVariabile, $descriVariabile, $idParametroOld){
	$sqlString="UPDATE serverdb.parametro_glob_mac 
					SET 
                                        id_par_gm=if(id_par_gm != '" . $idParametro . "',
                                                    '" . $idParametro . "',
                                                    id_par_gm),
                                        nome_variabile=if(nome_variabile != '" . $nomeVariabile . "',
                                                        '" . $nomeVariabile . "',
                                                        nome_variabile),
                                        descri_variabile=if(descri_variabile != '" . $descriVariabile . "',
                                                        '" . $descriVariabile . "',
                                                            descri_variabile),							
                                        valore_variabile=if(valore_variabile != '" . $valoreVariabile . "',
                                                        '" . $valoreVariabile . "',
                                                            valore_variabile)
                                        WHERE 
                                            id_par_gm='" . $idParametroOld . "'";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_glob_mac - FUNCTION updateServerDBParGlobMac - ".$sqlString ." ". mysql_error());
	return $sql;
}








/**
 * Seleziona un campo per id o nome
 * @param unknown $idParametro
 * @param unknown $nomeVariabile
 * @param unknown $connessione
 * @return resource
 */
function findParGlobMacByIdOrNome($idParametro, $nomeVariabile, $connessione){
	$sqlString="SELECT * FROM serverdb.parametro_glob_mac 
                WHERE 
                  id_par_gm=" . $idParametro . " 
                OR 
                  nome_variabile = '" . $nomeVariabile . "'";

	$sql = mysql_query($sqlString, $connessione)
	or die("ERROR IN script_parametro_glob_mac - FUNCTION findParGlobMacByIdOrNome - ".$sqlString ." ". mysql_error());
	return $sql;
}







/**
 * Inserisce un nuovo record
 * @param unknown $idParametro
 * @param unknown $nomeVariabile
 * @param unknown $descriVariabile
 * @param unknown $valore
 * @param unknown $dataCorrente
 * @return resource
 */
function insertNewParGlobMac($idParametro, $nomeVariabile, $descriVariabile, $valore, $dataCorrente ){
	$sqlString="INSERT INTO serverdb.parametro_glob_mac (id_par_gm,nome_variabile,descri_variabile,valore_variabile,abilitato,dt_abilitato) 
				VALUES ( 
                " . $idParametro . ",
                '" . $nomeVariabile .
                "','" . $descriVariabile .
                "','" . $valore .
                "',1,
		'" . $dataCorrente . "')";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_glob_mac - FUNCTION insertNewParGlobMac - ".$sqlString ." ". mysql_error());
	return $sql;
}


function findParGlobMac(){
	$sqlString="SELECT * FROM serverdb.parametro_glob_mac";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_glob_mac - FUNCTION findParGlobMac - ".$sqlString ." ". mysql_error());
	return $sql;
}



?>
