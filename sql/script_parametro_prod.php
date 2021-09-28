<?php

/**
 * Seleziona tutti i parametri prod 
 * @param type $campoOrdine
 * @return type
 */
function findAllParametriProd($campoOrdine){
    $sqlString="SELECT * FROM serverdb.parametro_prod ORDER BY ".$campoOrdine;
    
    $sql = mysql_query($sqlString) 
                or die("ERROR IN script_parametro_prod - FUNCTION findAllParametriProd - ".$sqlString ." ". mysql_error());
    return $sql;
}


function insertNewParametroProd($idParametro, $nomeVariabile, $descriVariabile, $valoreBase, $dataCorrente){
	$sqlString= "INSERT INTO serverdb.parametro_prod 
        (id_par_prod,nome_variabile,descri_variabile,valore_base,abilitato,dt_abilitato) 
	VALUES (" . $idParametro . ",
                '" . $nomeVariabile. "',
                '" . $descriVariabile . "',
                '" . $valoreBase . "',
                1,
		'" . $dataCorrente . "')";

	$sql = mysql_query($sqlString);
//	or die("ERROR IN script_parametro_prod.php - insertNewParametroProd - ".$sqlString ." ". mysql_error());
	return $sql;
}

function findParametroProdByIdOrNome($idParametro, $nomeParametro){
	$sqlString= "SELECT * FROM serverdb.parametro_prod WHERE id_par_prod=" . $idParametro . " 
          OR nome_variabile = '" . $nomeParametro . "'";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_prodotto.php - findParProdByIdOrNome - ".$sqlString ." ". mysql_error());
	return $sql;
}



function findParametroProdByIdNomeDescriVal($idParametro, $nomeVariabile, $descriVariabile, $valoreBase){
	$sqlString= "SELECT * FROM serverdb.parametro_prod 
                WHERE 
                    id_par_prod = " . $idParametro . "
                AND
                    nome_variabile ='" . $nomeVariabile . "'
                AND
                    descri_variabile='" . $descriVariabile ."'
                AND
                    valore_base='" . $valoreBase ."'";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_prod.php - findParametroProdByIdNomeDescriVal - ".$sqlString ." ". mysql_error());
	return $sql;
}


function insertStoricoParametroProd($idParametro,$abilitato){
	$sqlString= "INSERT INTO storico.parametro_prod 						 										
                                (id_par_prod,
                                nome_variabile,
                                descri_variabile,
                                valore_base,
                                abilitato,
                                dt_abilitato) 
                        SELECT 
                                id_par_prod,
                                nome_variabile,
                                descri_variabile,
                                valore_base,
                                ".$abilitato.",
                                dt_abilitato
                        FROM 
                                serverdb.parametro_prod
                        WHERE 
                                id_par_prod='" . $idParametro. "'";

	$sql = mysql_query($sqlString);
//	or die("ERROR IN script_parametro_prodotto.php - insertStoricoParProd - ".$sqlString ." ". mysql_error());
	return $sql;
}



function updateServerdbParametroProd($idParametro, $nomeVariabile, $descriVariabile, $valoreBase, $dataCorrente, $idParametroOld){
	$sqlString= "UPDATE serverdb.parametro_prod 
			SET 
                                id_par_prod = " . $idParametro . ",
                                nome_variabile='" . $nomeVariabile . "',
                                descri_variabile='" . $descriVariabile . "',
                                valore_base='" . $valoreBase . "',
                                dt_abilitato='" . $dataCorrente . "'
                        WHERE 
                                id_par_prod='" . $idParametroOld . "'";

	$sql = mysql_query($sqlString);
//	or die("ERROR IN script_parametro_prod.php - updateServerdbParametroProd - ".$sqlString ." ". mysql_error());
	return $sql;
}



function selectParametroProdByFiltri($idParProd,$nomeVariabile,$descriVariabile,$valore,$abilitato,$dtAbilitato,$filtro){
    
  
   $sql = mysql_query("SELECT * FROM serverdb.parametro_prod
              WHERE
                  id_par_prod LIKE '%".$idParProd."%' 
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
           or die("ERROR IN script_parametro_prod - FUNCTION selectParametroProdByFiltri - SELECT * FROM parametro_prodotto : " . mysql_error());
  return $sql;
}

function findParametroProdById($idParametro){
	$sqlString= "SELECT * FROM serverdb.parametro_prod WHERE id_par_prod=" . $idParametro;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_prod.php - findParProdById - ".$sqlString ." ". mysql_error());
	return $sql;
}



