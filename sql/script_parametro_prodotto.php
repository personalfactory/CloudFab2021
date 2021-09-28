<?php


function selectParProdByFiltri($idParProd,$nomeVariabile,$descriVariabile,$valore,$abilitato,$dtAbilitato,$filtro){
    
  
   $sql = mysql_query("SELECT * FROM serverdb.parametro_prodotto 
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
           or die("ERROR IN script_parametro_prodotto - FUNCTION selectParProdByFiltri - SELECT * FROM parametro_prodotto : " . mysql_error());
  return $sql;
}




/**
 * 
 * @return resource
 */
function findParametroProdottoWhereIDNotIn(){
	$sqlString="SELECT * FROM serverdb.parametro_prodotto  
                                                                WHERE 
                                                                    id_par_prod NOT IN 
                                                                (SELECT id_par_prod FROM valore_par_prod) 
                                                                ORDER BY descri_variabile";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_prodotto.php - findParametroProdottoWhereIDNotIn - ".$sqlString ." ". mysql_error());
	return $sql;
}





/**
 * Seleziona il campo valore base dal record selezionato per id_par_prod
 * @param unknown $idParametro
 * @return resource
 */
function findValoreBaseByIdParProd($idParametro){
	$sqlString= "SELECT valore_base FROM serverdb.parametro_prodotto  
							WHERE 
                      id_par_prod=". $idParametro;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_prodotto.php - findValoreBaseByIdParProd - ".$sqlString ." ". mysql_error());
	return $sql;
}




/**
 * 
 * @return resource
 */
function findParametroProdottoWhereIDNotInOrdByNome(){
	$sqlString= "SELECT * FROM serverdb.parametro_prodotto  
							WHERE 
                                                            id_par_prod NOT IN 
							(SELECT id_par_prod FROM valore_par_prod)
                                                        ORDER BY nome_variabile";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_prodotto.php - findParametroProdottoWhereIDNotInOrdByNome - ".$sqlString ." ". mysql_error());
	return $sql;
}



/**
 * Seleziona tutti i record della tabella parametro_prodotto ordinati per nome
 * @return resource
 */
function findAllParametroProdottoOrderByNome(){
	$sqlString= "SELECT * FROM serverdb.parametro_prodotto ORDER BY nome_variabile";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_prodotto.php - findAllParametroProdottoOrderByNome - ".$sqlString ." ". mysql_error());
	return $sql;
}






/**
 * Seleziona un record per id
 * @param unknown $idParametro
 * @return resource
 */
function findParProdById($idParametro){
	$sqlString= "SELECT * FROM serverdb.parametro_prodotto WHERE id_par_prod=" . $idParametro;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_prodotto.php - findParProdById - ".$sqlString ." ". mysql_error());
	return $sql;
}








/**
 * Seleziona un record per id, nome, descrizione e valore_base
 * @param unknown $idParametro
 * @param unknown $nomeVariabile
 * @param unknown $descriVariabile
 * @param unknown $valoreBase
 * @param unknown $connessione
 * @return resource
 */
function findParProdByIdNomeDescriVal($idParametro, $nomeVariabile, $descriVariabile, $valoreBase, $connessione){
	$sqlString= "SELECT * FROM serverdb.parametro_prodotto 
                WHERE 
                    id_par_prod = " . $idParametro . "
                AND
                    nome_variabile ='" . $nomeVariabile . "'
                AND
                    descri_variabile='" . $descriVariabile ."'
                AND
                    valore_base='" . $valoreBase ."'";

	$sql = mysql_query($sqlString, $connessione)
	or die("ERROR IN script_parametro_prodotto.php - findParProdByIdNomeDescriVal - ".$sqlString ." ". mysql_error());
	return $sql;
}







/**
 * Inserisce un record nello storico
 * @param unknown $idParametro
 * @return resource
 */
function insertStoricoParProd($idParametro){
	$sqlString= "INSERT INTO storico.parametro_prodotto 						 										
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
                                abilitato,
                                dt_abilitato
                        FROM 
                                serverdb.parametro_prodotto
                        WHERE 
                                id_par_prod='" . $idParametro. "'";

	$sql = mysql_query($sqlString);
//	or die("ERROR IN script_parametro_prodotto.php - insertStoricoParProd - ".$sqlString ." ". mysql_error());
	return $sql;
}




/**
 * Aggiorna un record in serverdb.parametro_prodotto
 * @param unknown $idParametro
 * @param unknown $nomeVariabile
 * @param unknown $descriVariabile
 * @param unknown $valoreBase
 * @param unknown $dataCorrente
 * @param unknown $idParametroOld
 * @return resource
 */
function updateServerDBParProdotto($idParametro, $nomeVariabile, $descriVariabile, $valoreBase, $dataCorrente, $idParametroOld){
	$sqlString= "UPDATE serverdb.parametro_prodotto 
			SET 
                                id_par_prod = " . $idParametro . ",
                                nome_variabile='" . $nomeVariabile . "',
                                descri_variabile='" . $descriVariabile . "',
                                valore_base='" . $valoreBase . "',
                                dt_abilitato='" . $dataCorrente . "'
                        WHERE 
                                id_par_prod='" . $idParametroOld . "'";

	$sql = mysql_query($sqlString);
//	or die("ERROR IN script_parametro_prodotto.php - updateServerDBParProdotto - ".$sqlString ." ". mysql_error());
	return $sql;
}



/**
 * Seleziona un record per id o nome
 * @param unknown $idParametro
 * @param unknown $nomeParametro
 * @param unknown $connessione
 * @return resource
 */
function findParProdByIdOrNome($idParametro, $nomeParametro, $connessione){
	$sqlString= "SELECT * FROM serverdb.parametro_prodotto WHERE id_par_prod=" . $idParametro . " 
          OR nome_variabile = '" . $nomeParametro . "'";

	$sql = mysql_query($sqlString, $connessione)
	or die("ERROR IN script_parametro_prodotto.php - findParProdByIdOrNome - ".$sqlString ." ". mysql_error());
	return $sql;
}





/**
 * Inserisce un nuovo record
 * @param unknown $idParametro
 * @param unknown $nomeVariabile
 * @param unknown $descriVariabile
 * @param unknown $valoreBase
 * @param unknown $dataCorrente
 * @return resource
 */
function insertNewParProdotto($idParametro, $nomeVariabile, $descriVariabile, $valoreBase, $dataCorrente){
	$sqlString= "INSERT INTO serverdb.parametro_prodotto 
          (id_par_prod,nome_variabile,descri_variabile,valore_base,abilitato,dt_abilitato) 
				VALUES (             
                 " . $idParametro . ",
                '" . $nomeVariabile. "',
                '" . $descriVariabile . "',
                '" . $valoreBase . "',
                1,
		'" . $dataCorrente . "')";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_parametro_prodotto.php - insertNewParProdotto - ".$sqlString ." ". mysql_error());
	return $sql;
}








function findAllParametroProdottoAbilitatoOrderById(){
	$sqlString= "SELECT * FROM serverdb.parametro_prodotto WHERE abilitato=1 ORDER BY id_par_prod";
	$sql = mysql_query($sqlString);
	//or die("ERROR IN script_parametro_prodotto.php - findAllParametroProdottoAbilitatoOrderById - ".$sqlString ." ". mysql_error());
	return $sql;
}

?>

