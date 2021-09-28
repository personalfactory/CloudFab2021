<?php

function selectValParProdottoByFiltri($idValParProd,$idParProd,$nomeVariabile,$nomeCategoria,$valoreVariabile,$dtAbilitato,$filtro,$var){
mysql_query("SET @var='".$var."'");
  $sql = mysql_query("SELECT
                           v.id_val_par_pr,
                           p.id_par_prod,
                           p.nome_variabile,
                           p.descri_variabile,
                           v.id_cat,
                           c.nome_categoria,
                           c.descri_categoria,
                           v.valore_variabile,
                           v.dt_abilitato
                        FROM
                            serverdb.valore_par_prod v
                        INNER JOIN serverdb.categoria c
                        ON 
                            v.id_cat = c.id_cat
                        INNER JOIN serverdb.parametro_prodotto p
                        ON 
                            v.id_par_prod = p.id_par_prod
                        WHERE
                          v.id_val_par_pr LIKE '%".$idValParProd."%'
                        AND
                           p.id_par_prod LIKE '%".$idParProd."%'
                        AND
                          p.nome_variabile LIKE '%".$nomeVariabile."%'
                        AND
                          c.nome_categoria LIKE '%".$nomeCategoria."%'    
                        AND
                          v.valore_variabile LIKE '%".$valoreVariabile."%'
                        AND
                          v.dt_abilitato LIKE '%".$dtAbilitato."%'    
                        GROUP BY 
                          CASE WHEN @var='id_val_par_pr' THEN v.id_val_par_pr END ,
                          CASE WHEN @var='id_par_prod' THEN v.id_par_prod END ,
                          CASE WHEN @var='nome_variabile' THEN p.nome_variabile END ,
                          CASE WHEN @var='nome_categoria' THEN c.nome_categoria END ,
                          CASE WHEN @var='valore_variabile' THEN v.valore_variabile END ,
                          CASE WHEN @var='dt_abilitato' THEN v.dt_abilitato END
                        ORDER BY 
                            ".$filtro)  
        or die("ERROR IN script_valore_par_prod - FUNCTION selectValParProdottoByFiltri - SELECT FROM valore_par_prod : " . mysql_error());
  
  return $sql;
}


/**
 * Seleziona i valori par prod raggruppandoli in base alla variabile passata come parametro alla funzione
 * @return type
 */
function selectValParProd($idValParProd,$idParProd,$nomeVariabile,$nomeCategoria,$valoreVariabile,$dtAbilitato,$filtro,$var){
  mysql_query("SET @var='".$var."'");
  $sql = mysql_query("SELECT
                           v.id_val_par_pr,
                           p.id_par_prod,
                           p.nome_variabile,
                           p.descri_variabile,
                           v.id_cat,
                           c.nome_categoria,
                           c.descri_categoria,
                           v.valore_variabile,
                           v.dt_abilitato
                        FROM
                            serverdb.valore_par_prod v
                        INNER JOIN serverdb.categoria c
                        ON 
                            v.id_cat = c.id_cat
                        INNER JOIN serverdb.parametro_prodotto p
                        ON 
                            v.id_par_prod = p.id_par_prod
                        WHERE
                          v.id_val_par_pr LIKE '%".$idValParProd."%'
                        AND
                           p.id_par_prod LIKE '%".$idParProd."%'
                        AND
                          p.nome_variabile LIKE '%".$nomeVariabile."%'
                        AND
                          c.nome_categoria LIKE '%".$nomeCategoria."%'    
                        AND
                          v.valore_variabile LIKE '%".$valoreVariabile."%'
                        AND
                          v.dt_abilitato LIKE '%".$dtAbilitato."%'    
                        GROUP BY 
                          CASE WHEN @var='id_val_par_pr' THEN v.id_val_par_pr END ,
                          CASE WHEN @var='id_par_prod' THEN v.id_par_prod END ,
                          CASE WHEN @var='nome_variabile' THEN p.nome_variabile END ,
                          CASE WHEN @var='nome_categoria' THEN c.nome_categoria END ,
                          CASE WHEN @var='valore_variabile' THEN v.valore_variabile END ,
                          CASE WHEN @var='dt_abilitato' THEN v.dt_abilitato END 
                        ORDER BY ".$filtro)  
        or die("ERROR script_valore_par_prod - FUNCTION  selectValParProd SELECT FROM valore_par_prod : " . mysql_error());
  
  return $sql;
  
}




/**
 * Seleziona per id_cat dalla tabella valore_par_prod
 * @param unknown $idCategoria
 * @param unknown $connessione
 * @return resource
 */
function findValoreParProdByIdCat($idCategoria, $connessione){
	$sqlString= "SELECT * FROM serverdb.valore_par_prod 
                WHERE 
                        id_cat = " . $idCategoria;

	$sql = mysql_query($sqlString, $connessione)
	or die("ERROR IN script_valore_par_prod - FUNCTION findValoreParProdByIdCat - ".$sqlString ." ". mysql_error());
	return $sql;
}






/**
 * Inserisce un nuovo record nella tabella valore_par_prod
 * @param unknown $idParProd
 * @param unknown $idCategoria
 * @param unknown $valore
 * @param unknown $dataCorrente
 * @return resource
 */
function insertValoreParProd($idParProd, $idCategoria, $valore, $dataCorrente){
	$sqlString= "INSERT INTO serverdb.valore_par_prod 
                                                        (id_par_prod,id_cat,valore_variabile,abilitato,dt_abilitato) 
                                                        VALUES("
                                . $idParProd. ","
                                . $idCategoria . ",'"                
                                . $valore . "',1,'"
                                . $dataCorrente . "')";

	$sql = mysql_query($sqlString);
	//or die("ERROR IN script_valore_par_prod - FUNCTION insertValoreParProd - ".$sqlString ." ". mysql_error());
	return $sql;
}





/**
 * 
 * @param unknown $idParametro
 * @return resource
 */
function selectValoreParByIdPar($idParametro){
	$sqlString= "SELECT
                            valore_par_prod.id_par_prod,
                            parametro_prodotto.nome_variabile,
                            parametro_prodotto.descri_variabile,
                            parametro_prodotto.valore_base,
                            categoria.id_cat,
                            categoria.nome_categoria,
                            valore_par_prod.valore_variabile,
                            valore_par_prod.dt_abilitato,
                            parametro_prodotto.dt_abilitato AS data
                        FROM
                            serverdb.valore_par_prod
                        INNER JOIN 
                            serverdb.parametro_prodotto 
                        ON 
                            valore_par_prod.id_par_prod = parametro_prodotto.id_par_prod
                        INNER JOIN 
                            serverdb.categoria 
                        ON 
                            valore_par_prod.id_cat = categoria.id_cat
                        WHERE 
                            valore_par_prod.id_par_prod=".$idParametro;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_prod - FUNCTION selectValoreParByIdPar - ".$sqlString ." ". mysql_error());
	return $sql;
}





/**
 * 
 * @param unknown $idParametro
 * @return resource
 */
function selectCategoriaValoreByIdPar($idParametro){
	$sqlString= "SELECT 
            	    	                    categoria.id_cat,
                                            categoria.nome_categoria,
                                            categoria.descri_categoria,
                                            valore_par_prod.valore_variabile,
                                            valore_par_prod.dt_abilitato 
                                       FROM
                                            serverdb.valore_par_prod
                                       INNER JOIN 
                                            serverdb.categoria 
                                          ON 
                                            valore_par_prod.id_cat = categoria.id_cat
                                       INNER JOIN 
                                            serverdb.parametro_prodotto 
                                          ON 
                                            valore_par_prod.id_par_prod = parametro_prodotto.id_par_prod
                                       WHERE 
                                            valore_par_prod.id_par_prod=".$idParametro."
                                       ORDER BY 
                                            nome_categoria";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_prod - FUNCTION selectCategoriaValoreByIdPar - ".$sqlString ." ". mysql_error());
	return $sql;
}







/**
 * 
 * @param unknown $idParametro
 * @return resource
 */
function selectValoreParProdCategoriaByIdPar($idParametro){
	$sqlString= "SELECT 
                                            valore_par_prod.id_val_par_pr,
                                            valore_par_prod.id_par_prod,
            	    	                    categoria.id_cat,
                                            categoria.nome_categoria,
                                            categoria.descri_categoria,
                                            valore_par_prod.valore_variabile,
                                            valore_par_prod.dt_abilitato 
                                       FROM
                                            serverdb.valore_par_prod
                                       INNER JOIN 
                                            serverdb.categoria 
                                          ON 
                                            valore_par_prod.id_cat = categoria.id_cat
                                       INNER JOIN 
                                            serverdb.parametro_prodotto 
                                          ON 
                                            valore_par_prod.id_par_prod = parametro_prodotto.id_par_prod
                                       WHERE 
                                            valore_par_prod.id_par_prod=".$idParametro."
                                       ORDER BY 
                                            nome_categoria";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_prod - FUNCTION selectValoreParProdCategoriaByIdPar - ".$sqlString ." ". mysql_error());
	return $sql;
}






/**
 * Inserisce un nuovo record nella tabella valore_par_prod del db storico
 * @param unknown $IdValParProd
 * @param unknown $idParametro
 * @param unknown $idCat
 * @param unknown $valVariabile
 * @param unknown $dtAbilitato
 * @return resource
 */
function insertStoricoValoreParProd($idValParProd, $idParametro, $idCat, $valVariabile, $dtAbilitato){
	$sqlString= "INSERT INTO storico.valore_par_prod	
							(id_val_par_pr,id_par_prod,id_cat,valore_variabile,abilitato,dt_abilitato)
                                                    VALUES(
                                                            " . $idValParProd . ",
                                                            " . $idParametro . ",
                                                            '" . $idCat . "',
                                                            '" . $valVariabile . "',
                                                            1,
                                                            '" . $dtAbilitato . "')";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_prod - FUNCTION insertStoricoValoreParProd - ".$sqlString ." ". mysql_error());
	return $sql;
}






/**
 * Aggiorna dt_abilitato e valore_variabile nel record selezionato per id_par_prod e id_cat
 * @param unknown $idParametro
 * @param unknown $idCat
 * @param unknown $valore
 * @param unknown $dataCorrente
 * @return resource
 */
function updateDtValoreParProd($idParametro, $idCat, $valore, $dataCorrente){
	$sqlString= "UPDATE serverdb.valore_par_prod 
                                                SET 
                                                    dt_abilitato=if(valore_variabile != '" . $valore . "','" . $dataCorrente . "',dt_abilitato),
                                                    valore_variabile=if(valore_variabile != '" . $valore . "','" . $valore . "',valore_variabile)
                                                WHERE
                                                        id_par_prod=" . $idParametro . "
                                                AND
                                                        id_cat=" . $idCat;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_prod - FUNCTION updateDtValoreParProd - ".$sqlString ." ". mysql_error());
	return $sql;
}





/**
 * 
 * @param unknown $idCategoria
 * @return resource
 */
function selectValoreParByIdCat($idCategoria){
    
    
//     $sqlPar = mysql_query("SELECT 
//                                                        valore_par_prod.id_val_par_pr,
//                                                        parametro_prodotto.id_par_prod,
//                                                        parametro_prodotto.nome_variabile,
//                                                        parametro_prodotto.descri_variabile,
//                                                        categoria.id_cat,
//                                                        categoria.nome_categoria,
//                                                        valore_par_prod.valore_variabile,
//                                                        valore_par_prod.abilitato,
//                                                        valore_par_prod.dt_abilitato 
//                                                    FROM
//                                                        serverdb.valore_par_prod
//                                                    INNER JOIN serverdb.categoria 
//                                                    ON 
//                                                        valore_par_prod.id_cat = categoria.id_cat
//                                                    INNER JOIN 
//                                                        serverdb.parametro_prodotto 
//                                                    ON 
//                                                        valore_par_prod.id_par_prod = parametro_prodotto.id_par_prod
//                                                    WHERE 
//                                                        valore_par_prod.id_cat=" . $IdCategoria . "
//                                                    ORDER BY 
//                                                        nome_variabile")
    
	$sqlString= "SELECT 
                                                        valore_par_prod.id_val_par_pr,
                                                        parametro_prodotto.id_par_prod,
                                                        parametro_prodotto.nome_variabile,
                                                        parametro_prodotto.descri_variabile,
                                                        parametro_prodotto.uni_mis,
                                                        categoria.id_cat,
                                                        categoria.nome_categoria,
                                                        valore_par_prod.valore_variabile,
                                                        valore_par_prod.abilitato,
                                                        valore_par_prod.dt_abilitato 
                                                    FROM
                                                        serverdb.valore_par_prod
                                                    INNER JOIN serverdb.categoria 
                                                    ON 
                                                        valore_par_prod.id_cat = categoria.id_cat
                                                    INNER JOIN 
                                                        serverdb.parametro_prodotto 
                                                    ON 
                                                        valore_par_prod.id_par_prod = parametro_prodotto.id_par_prod
                                                    WHERE 
                                                        valore_par_prod.id_cat=" . $idCategoria . "
                                                    ORDER BY 
                                                        nome_variabile";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_prod - FUNCTION selectValoreParByIdCat - ".$sqlString ." ". mysql_error());
	return $sql;
}





/**
 * Inserisce un nuovo valore nel db storico
 * @param unknown $idValParProd
 * @param unknown $idParametro
 * @param unknown $idCat
 * @param unknown $valVariabile
 * @param unknown $abilitato
 * @param unknown $dtAbilitato
 * @return resource
 */
function insertStoricoValoreParProdConAbilitazione($idValParProd, $idParametro, $idCat, $valVariabile, $abilitato, $dtAbilitato){
	$sqlString= "INSERT INTO storico.valore_par_prod	
				(id_val_par_pr,id_par_prod,id_cat,valore_variabile,abilitato,dt_abilitato)
                            VALUES(
                                    " . $idValParProd . ",
                                    " . $idParametro . ",
                                    '" . $idCat . "',
                                    " . $valVariabile . ",
                                    " . $abilitato . ",
                                    '" . $dtAbilitato . "')";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_prod - FUNCTION insertStoricoValoreParProdConAbilitazione - ".$sqlString ." ". mysql_error());
	return $sql;
}






/**
 * Seleziona alcuni campi per id_par_prod
 * @param unknown $idParametro
 * @return resource
 */
function findValoreParProdByIdParProd($idParametro){
	$sqlString= "SELECT   
                                        valore_par_prod.id_val_par_pr,
                                        valore_par_prod.id_par_prod,
                                        valore_par_prod.id_cat,
                                        valore_par_prod.valore_variabile,
                                        valore_par_prod.dt_abilitato								
                                FROM 
                                        serverdb.valore_par_prod 
                                WHERE 
                                        id_par_prod=" . $idParametro;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_prod - FUNCTION findValoreParProdByIdParProd - ".$sqlString ." ". mysql_error());
	return $sql;
}






/**
 * Aggiorna il campo id_par_prod e dt_abilitato in serverdb.valore_par_prod
 * @param unknown $idParametro
 * @param unknown $idParametroOld
 * @return resource
 */
function updateDaraParProd($idParametro, $idParametroOld){
	$sqlString= "UPDATE serverdb.valore_par_prod 
                     SET 
                        dt_abilitato=if(id_par_prod != " . $idParametro . ",NOW(),dt_abilitato)                     
                    WHERE 
                        id_par_prod=" . $idParametroOld ;

	$sql = mysql_query($sqlString);
//	or die("ERROR IN script_valore_par_prod - FUNCTION updateIdParProd - ".$sqlString ." ". mysql_error());
	return $sql;
}




/**
 * Seleziona un record per id parametro
 * @param unknown $idParametro
 * @param unknown $connessione
 * @return resource
 */
function findValoreParProdByIdPar($idParametro, $connessione){
	$sqlString= "SELECT * FROM serverdb.valore_par_prod 
				WHERE 
					id_par_prod = " . $idParametro;

	$sql = mysql_query($sqlString, $connessione)
	or die("ERROR IN script_valore_par_prod - FUNCTION findValoreParProdByIdPar - ".$sqlString ." ". mysql_error());
	return $sql;
}


function duplicaValoriParProdByCategoria($idCatOld,$idCatNew){

$sqlString="INSERT INTO serverdb.valore_par_prod (id_par_prod,id_cat,valore_variabile,abilitato)
            SELECT id_par_prod,".$idCatNew.",valore_variabile,1 FROM serverdb.valore_par_prod WHERE id_cat=".$idCatOld;

$sql = mysql_query($sqlString);
//	or die("ERROR IN script_valore_par_prod - FUNCTION duplicaValoriParProdByCategoria - ".$sqlString ." ". mysql_error());
	return $sql;
}


?>
