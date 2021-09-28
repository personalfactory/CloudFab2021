<?php
/**
 * Seleziona tutti i parametri componente 
 * @param type $campoOrdine
 * @return type
 */
function findAllParametriComp($campoOrdine){
    $sqlString="SELECT * FROM serverdb.parametro_comp_prod ORDER BY ".$campoOrdine;

   $sql = mysql_query($sqlString) 
           or die("ERROR IN script_parametro_comp_prod - FUNCTION findAllParametriComp - ".$sqlString ." ". mysql_error());
   return $sql;
}



/**
 * Seleziona tutti i parametri dalla tabella parametro_comp_prod in base ai filtri
 * @param type $idParComp
 * @param type $nomeVariabile
 * @param type $descriVariabile
 * @param type $valore
 * @param type $abilitato
 * @param type $dtAbilitato
 * @param type $filtro
 * @return type
 */
function selectParCompByFiltri($idParComp,$nomeVariabile,$descriVariabile,$valore,$abilitato,$dtAbilitato,$filtro){
    
  
   $sql = mysql_query("SELECT * FROM serverdb.parametro_comp_prod  
              WHERE
                  id_par_comp LIKE '%".$idParComp."%' 
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
           or die("ERROR IN script_parametro_componente - FUNCTION selectParCompByFiltri - SELECT * FROM parametro_comp_prod : " . mysql_error());
  return $sql;
}



/**
 * Seleziona un record per id o nome
 * @param unknown $idParametro
 * @param unknown $nomeParametro
 * @return resource
 */
function findParCompByIdOrNome($idParametro, $nomeParametro, $connessione){
	$sqlString= "SELECT * FROM serverdb.parametro_comp_prod 
                WHERE 
                  id_par_comp=" . $idParametro . " 
                OR 
                  nome_variabile = '" . $nomeParametro . "'";

	$sql = mysql_query($sqlString, $connessione)
	or die("ERROR IN script_parametro_componente - FUNCTION findParCompByIdOrNome - ".$sqlString ." ". mysql_error());
	return $sql;
}





/**
 * Inserisce un nuovo record in parametro_comp_prod
 * @param unknown $idParametro
 * @param unknown $nomeParametro
 * @param unknown $descriParametro
 * @param unknown $valoreBase
 * @param unknown $dataCorrente
 * @return resource
 */
function insertNewParComp($idParametro, $nomeParametro, $descriParametro, $valoreBase, $dataCorrente){
	$sqlString= "INSERT INTO serverdb.parametro_comp_prod 
                                    (id_par_comp,
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

	$sql = mysql_query($sqlString);
	//(or die("ERROR IN script_parametro_componente - FUNCTION insertNewParComp - ".$sqlString ." ". mysql_error());
	return $sql;
}



/**
 * Seleziona un record per id 
 * @param unknown $idParametro
 * @return resource
 */
function findParCompById($idParametro){
	$sqlString= "SELECT * FROM serverdb.parametro_comp_prod WHERE id_par_comp=" . $idParametro;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_componente - FUNCTION findParCompById - ".$sqlString ." ". mysql_error());
	return $sql;
}







/**
 * Seleziona un record per id, nome, descrizione e valore
 * @param unknown $idParametro
 * @param unknown $nomeVariabile
 * @param unknown $descriVariabile
 * @param unknown $valoreBase
 * @param unknown $connessione
 * @return resource
 */
function findParCompByIdNomeDescriValore($idParametro, $nomeVariabile, $descriVariabile, $valoreBase, $connessione){
	$sqlString= "SELECT * FROM serverdb.parametro_comp_prod 
		WHERE       
                    id_par_comp = " . $idParametro . "
                AND 
                    nome_variabile ='" . $nomeVariabile . "'
                AND
                    descri_variabile='" . $descriVariabile . "'
                AND
                    valore_base='" . $valoreBase . "'";

	$sql = mysql_query($sqlString, $connessione)
	or die("ERROR IN script_parametro_componente - FUNCTION findParCompByIdNomeDescriValore - ".$sqlString ." ". mysql_error());
	return $sql;
}






/**
 * Inserisce un nuovo record nello storico
 * @param unknown $idParametro
 * @return resource
 */
function insertStoricoParComponente($idParametro){
	$sqlString= "INSERT INTO storico.parametro_comp_prod					 										
                            (id_par_comp,
                            nome_variabile,
                            descri_variabile,
                            valore_base,
                            abilitato,
                            dt_abilitato) 
                    SELECT 
                            id_par_comp,
                            nome_variabile,
                            descri_variabile,
                            valore_base,
                            abilitato,
                            dt_abilitato
                    FROM 
                            serverdb.parametro_comp_prod
                    WHERE 
                            id_par_comp='" . $idParametro . "'";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_componente - FUNCTION insertStoricoParComponente - ".$sqlString ." ". mysql_error());
	return $sql;
}





/**
 * Aggiorna un record in serverdb.parametro_comp_prod 
 * @param unknown $idParametro
 * @param unknown $nomeVariabile
 * @param unknown $descriVariabile
 * @param unknown $valoreBase
 * @param unknown $idParametroOld
 * @return resource
 */
function updateServerDBParComponente($idParametro, $nomeVariabile, $descriVariabile, $valoreBase, $idParametroOld){
	$sqlString= "UPDATE serverdb.parametro_comp_prod 
					SET 
                                        id_par_comp=if(id_par_comp != '" . $idParametro . "',
                                                    '" . $idParametro . "',
                                                    id_par_comp),
                                        nome_variabile=if(nome_variabile != '" . $nomeVariabile . "',
                                                        '" . $nomeVariabile . "',
                                                        nome_variabile),
                                        descri_variabile=if(descri_variabile != '" . $descriVariabile . "',
                                                        '" . $descriVariabile . "',
                                                            descri_variabile),							
                                        valore_base=if(valore_base != '" . $valoreBase . "',
                                                        '" . $valoreBase . "',
                                                            valore_base)
                                        WHERE 
                                            id_par_comp='" . $idParametroOld . "'";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_componente - FUNCTION updateServerDBParComponente - ".$sqlString ." ". mysql_error());
	return $sql;
}
?>

