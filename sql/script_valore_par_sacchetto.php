<?php

function selectValParSacchettoByFiltri(
$idValParSac, $idParSac, $nomeVariabile, $nomeCategoria, $numSacchetti, $dtAbilitato, $filtro, $var) {
    mysql_query("SET @var='" . $var . "'");
    $sql = mysql_query("SELECT
                           v.id_val_par_sac,
                           p.id_par_sac,
                           p.nome_variabile,
                           p.descri_variabile,
                           n.num_sacchetti, 
                           v.id_cat,
                           c.nome_categoria,
                           v.sacchetto,
                           v.dt_abilitato
                       FROM
                            serverdb.valore_par_sacchetto v
                        INNER JOIN serverdb.categoria c
                              ON 
                                v.id_cat = c.id_cat
                        INNER JOIN serverdb.parametro_sacchetto p
                             ON 
                                v.id_par_sac = p.id_par_sac
                        INNER JOIN serverdb.num_sacchetto n
                             ON 
                                v.id_num_sac = n.id_num_sac	
                        WHERE
                          v.id_val_par_sac LIKE '%" . $idValParSac . "%' 
                          AND
                           p.id_par_sac LIKE '%" . $idParSac . "%' 
                           AND
                           p.nome_variabile LIKE '%" . $nomeVariabile . "%'
                           AND
                           c.nome_categoria LIKE '%" . $nomeCategoria . "%'
                           AND
                           n.num_sacchetti LIKE '%" . $numSacchetti . "%'
                           AND
                           v.dt_abilitato  LIKE '%" . $dtAbilitato . "%'
                         GROUP BY 
                          CASE WHEN @var='id_val_par_sac' THEN v.id_val_par_sac END ,
                          CASE WHEN @var='id_par_sac' THEN v.id_par_sac END ,
                          CASE WHEN @var='nome_variabile' THEN p.nome_variabile END ,
                          CASE WHEN @var='nome_categoria' THEN c.nome_categoria END ,
                          CASE WHEN @var='num_sacchetti' THEN n.num_sacchetti END ,
                          CASE WHEN @var='dt_abilitato' THEN v.dt_abilitato END
                        ORDER BY " . $filtro) or die("ERROR IN script_valore_par_sacchetto - FUNCTION selectValParSacchettoByFiltri - SELECT * FROM valore_par_sacchetto : " . mysql_error());
    return $sql;
}

/**
 * Restituisce id,nome e descri dei parametri di insacco associati ad una categoria
 * @param type $IdCategoria
 * @return type
 */
function findParametriByCat($IdCategoria) {

    $sql = mysql_query("SELECT 
                            parametro_sacchetto.nome_variabile,
                            parametro_sacchetto.descri_variabile,
                            valore_par_sacchetto.id_par_sac
                        FROM
                                serverdb.valore_par_sacchetto
                        INNER JOIN serverdb.parametro_sacchetto 
                        ON 
                                valore_par_sacchetto.id_par_sac = parametro_sacchetto.id_par_sac
                        WHERE 
                                valore_par_sacchetto.id_cat=" . $IdCategoria . "
                        GROUP BY 
                            valore_par_sacchetto.id_par_sac
                        ORDER BY 
                                parametro_sacchetto.nome_variabile") 
            or die("ERROR IN script_valore_par_sacchetto - FUNCTION findParametriByCat - SELECT FROM valore_par_sacchetto : " . mysql_error());

    return $sql;
}


/**
 * Restituisce i valori relativi ad un parametro di una categoria
 * @param type $idParametro
 * @param type $idCategoria
 * @return type
 */
function findValSacByParCat($idParametro, $idCategoria) {

      $sql=mysql_query("SELECT 
            valore_par_sacchetto.id_val_par_sac,
            valore_par_sacchetto.id_par_sac,
            valore_par_sacchetto.id_cat,
            valore_par_sacchetto.id_num_sac,
            valore_par_sacchetto.sacchetto,
            valore_par_sacchetto.valore_variabile,
            valore_par_sacchetto.abilitato,
            valore_par_sacchetto.dt_abilitato,
            num_sacchetto.num_sacchetti	
            FROM
               serverdb.valore_par_sacchetto
            INNER JOIN
                    serverdb.num_sacchetto
            ON
                    valore_par_sacchetto.id_num_sac=num_sacchetto.id_num_sac
            WHERE 
                    valore_par_sacchetto.id_par_sac=" . $idParametro . "
             AND
                    valore_par_sacchetto.id_cat=" . $idCategoria . "
            ORDER BY 
                    num_sacchetto.num_sacchetti, valore_par_sacchetto.sacchetto") 
            or die("ERROR IN script_valore_par_sacchetto - FUNCTION findValSacByParCat - SELECT FROM valore_par_sacchetto : " . mysql_error());
    return $sql;
}


function findCategoriaFromValParSac($idCategoria){
    $sql=mysql_query("SELECT
                                            valore_par_sacchetto.id_cat,
                                            categoria.nome_categoria,
                                            categoria.descri_categoria,
                                            categoria.dt_abilitato
                                    FROM
                                            serverdb.valore_par_sacchetto
                                    INNER JOIN serverdb.categoria 
                                            ON valore_par_sacchetto.id_cat = categoria.id_cat
                                    WHERE 
                                            valore_par_sacchetto.id_cat=" . $idCategoria."
                                    GROUP BY 
                                            valore_par_sacchetto.id_cat")
            or die("ERROR IN script_valore_par_sacchetto - FUNCTION findCategoriaFromValParSac - SELECT FROM valore_par_sacchetto : " . mysql_error());
            
            
          return $sql;  
    
}








/**
 * Seleziona alcuni campi dalla tabella valore_par_sacchetto per id
 * @param unknown $idValPar
 * @return resource
 */
function selectValoreParSacById($idValPar){
	$sqlString= "SELECT
                                    valore_par_sacchetto.id_val_par_sac,
                                    valore_par_sacchetto.id_par_sac,
                                    parametro_sacchetto.nome_variabile,
                                    parametro_sacchetto.descri_variabile,
                                    parametro_sacchetto.valore_base,
                                    parametro_sacchetto.dt_abilitato
                            FROM
                                    serverdb.valore_par_sacchetto
                            INNER JOIN serverdb.parametro_sacchetto 
                                    ON valore_par_sacchetto.id_par_sac = parametro_sacchetto.id_par_sac
                            WHERE 
                                    valore_par_sacchetto.id_val_par_sac=" . $idValPar;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_sacchetto - FUNCTION selectValoreParSacById - ".$sqlString ." ". mysql_error());
	return $sql;
}






/**
 * Seleziona i campi categoria.nome_categoria,valore_par_sacchetto.id_cat per id_par_sac
 * @param unknown $idParametro
 * @return resource
 */
function selectNomeIdCatByIdPar($idParametro){
	$sqlString= "SELECT 
                            categoria.nome_categoria,
                            valore_par_sacchetto.id_cat
                        FROM
                                    serverdb.valore_par_sacchetto
                        INNER JOIN serverdb.categoria 
                        ON 
                                valore_par_sacchetto.id_cat = categoria.id_cat
                        WHERE 
                                valore_par_sacchetto.id_par_sac=" . $idParametro . "
                        GROUP BY 
                                categoria.nome_categoria
                        ORDER BY 
                                categoria.nome_categoria";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_sacchetto - FUNCTION selectNomeIdCatByIdPar - ".$sqlString ." ". mysql_error());
	return $sql;
}




/**
 * Seleziona alcuni campi per id_par_sac e valore_par_sacchetto.id_cat
 * @param unknown $idParametro
 * @param unknown $idCat
 * @return resource
 */
function selectValoreByIdParAndIdCat($idParametro, $idCat){
	$sqlString= "SELECT 
                                    valore_par_sacchetto.sacchetto,
                                    num_sacchetto.num_sacchetti,
                                    valore_par_sacchetto.valore_variabile,
                                    valore_par_sacchetto.dt_abilitato
                                FROM
                                    serverdb.valore_par_sacchetto
                                INNER JOIN
                                        serverdb.num_sacchetto
                                        ON
                                                valore_par_sacchetto.id_num_sac=num_sacchetto.id_num_sac
                                WHERE 
                                    valore_par_sacchetto.id_par_sac=" . $idParametro . "
                                    AND
                                    valore_par_sacchetto.id_cat=" . $idCat . "
                                ORDER BY 
                                        num_sacchetto.num_sacchetti, valore_par_sacchetto.sacchetto";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_sacchetto - FUNCTION selectValoreByIdParAndIdCat - ".$sqlString ." ". mysql_error());
	return $sql;
}











/**
 * Seleziona alcuni campi per valore_par_sacchetto.id_par_sac e 
 * @param unknown $idParametro
 * @return resource
 */
function selectValoreAndNomeCatByIdPar($idParametro){
	$sqlString= "SELECT 
                                valore_par_sacchetto.id_cat,
                                categoria.nome_categoria
                    FROM
                            serverdb.valore_par_sacchetto
                    INNER JOIN serverdb.categoria 
                    ON 
                            valore_par_sacchetto.id_cat = categoria.id_cat
                    WHERE 
                            valore_par_sacchetto.id_par_sac=" . $idParametro . "
                    GROUP BY
                                categoria.nome_categoria
                    ORDER BY 
                                categoria.nome_categoria";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_sacchetto - FUNCTION selectValoreAndNomeCatByIdPar - ".$sqlString ." ". mysql_error());
	return $sql;
}







/**
 * Seleziona alcuni campi per id_par_sac e valore_par_sacchetto.id_cat
 * @param unknown $idParametro
 * @param unknown $idCat
 * @return resource
 */
function selectValoreParSacchettoCatByIdParAndIdCat($idParametro, $idCat){
	$sqlString= "SELECT   
                                                        valore_par_sacchetto.id_val_par_sac,
                                                        valore_par_sacchetto.id_par_sac,
                                                        valore_par_sacchetto.id_cat,
                                                        valore_par_sacchetto.id_num_sac,
                                                        valore_par_sacchetto.sacchetto,
                                                        valore_par_sacchetto.valore_variabile,
                                                        valore_par_sacchetto.abilitato,
                                                        valore_par_sacchetto.dt_abilitato,
                                                        num_sacchetto.num_sacchetti									
                                                FROM 
                                                        serverdb.valore_par_sacchetto
                                                INNER JOIN serverdb.num_sacchetto
                                                ON
                                                        valore_par_sacchetto.id_num_sac=num_sacchetto.id_num_sac
                                                WHERE
                                                        valore_par_sacchetto.id_par_sac=" . $idParametro . "
                                                AND
                                                        valore_par_sacchetto.id_cat=" . $idCat . "
                                                ORDER BY 
                                        num_sacchetto.num_sacchetti, valore_par_sacchetto.sacchetto	";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_sacchetto - FUNCTION selectValoreParSacchettoCatByIdParAndIdCat - ".$sqlString ." ". mysql_error());
	return $sql;
}






/**
 * Inserisce un nuovo record nello storico
 * @param unknown $id_val_par_sac
 * @param unknown $idParametro
 * @param unknown $idCat
 * @param unknown $id_num_sac
 * @param unknown $sacchetto
 * @param unknown $valore_variabile
 * @param unknown $abilitato
 * @param unknown $dt_abilitato
 * @return resource
 */
function insertStoricoValoreParSac($id_val_par_sac, $idParametro, $idCat, $id_num_sac, $sacchetto, $valore_variabile, $abilitato, $dt_abilitato ){
	$sqlString= "INSERT INTO storico.valore_par_sacchetto	
                                                        (id_val_par_sac,
                                                            id_par_sac,
                                                            id_cat,
                                                            id_num_sac,
                                                            sacchetto,
                                                            valore_variabile,
                                                            abilitato,
                                                            dt_abilitato)
                                                VALUES(
                                                                " . $id_val_par_sac . ",
                                                                " . $idParametro . ",
                                                                " . $idCat . ",
                                                                '" . $id_num_sac . "',
                                                                '" . $sacchetto . "',
                                                                " . $valore_variabile . ",
                                                                " . $abilitato  . ",
                                                                '" . $dt_abilitato . "')";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_sacchetto - FUNCTION insertStoricoValoreParSac - ".$sqlString ." ". mysql_error());
	return $sql;
}








/**
 * Aggiorna i campi valore_variabile e data in serverdb.valore_par_sacchetto
 * @param unknown $idParametro
 * @param unknown $idCat
 * @param unknown $id_num_sac
 * @param unknown $sacchetto
 * @param unknown $valore
 * @param unknown $dataCorrente
 * @return resource
 */
function updateValoreVarValoreParSacchetto($idParametro, $idCat, $id_num_sac, $sacchetto, $valore, $dataCorrente ){
	$sqlString= "UPDATE serverdb.valore_par_sacchetto 
							SET 
							dt_abilitato=if(valore_variabile != '" . $valore . "','" . $dataCorrente . "',dt_abilitato),
                                                        valore_variabile=if(valore_variabile != '" . $valore . "','" . $valore . "',valore_variabile)
							WHERE
                                                                id_par_sac=" . $idParametro . "
                                                        AND
                                                                id_cat=" . $idCat . "
                                                        AND
                                                                id_num_sac=" . $id_num_sac . "
                                                        AND
                                                                sacchetto='" . $sacchetto . "'";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_sacchetto - FUNCTION updateValoreVarValoreParSacchetto - ".$sqlString ." ". mysql_error());
	return $sql;
}




/**
 * Aggiorna il campo valore_variabile  in serverdb.valore_par_sacchetto
 * @param unknown $idParametro
 * @param unknown $idCat
 * @param unknown $id_num_sac
 * @param unknown $sacchetto
 * @param unknown $valore
 * @return resource
 */
function updateServerdbValSac($idParametro, $idCat, $id_num_sac, $sacchetto, $valore){
	$sqlString= "UPDATE serverdb.valore_par_sacchetto 
                                SET 
                                        valore_variabile=if(valore_variabile!='" . $valore . "','" . $valore . "',valore_variabile)
                                WHERE
                                        id_par_sac=" . $idParametro . "
                                AND
                                        id_cat=" . $idCat . "
                                AND
                                        id_num_sac=" . $id_num_sac . "
                                AND
                                        sacchetto='" . $sacchetto . "'";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_sacchetto - FUNCTION updateServerdbValSac - ".$sqlString ." ". mysql_error());
	return $sql;
}






/**
 * Seleziona alcuni campi per id
 * @param unknown $idParametro
 * @return resource
 */
function selectValoreParSacByIdParSac($idParametro){
	$sqlString= "SELECT   
									valore_par_sacchetto.id_val_par_sac,
									valore_par_sacchetto.id_par_sac,
									valore_par_sacchetto.id_num_sac,
									valore_par_sacchetto.sacchetto,
									valore_par_sacchetto.id_cat,
									valore_par_sacchetto.valore_variabile,
									valore_par_sacchetto.dt_abilitato								
								FROM 
									serverdb.valore_par_sacchetto 
								WHERE 
									id_par_sac=" . $idParametro;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_sacchetto - FUNCTION selectValoreParSacByIdParSac - ".$sqlString ." ". mysql_error());
	return $sql;
}







/**
 * Aggiorna il campo id_par_sac del record di serverdb.valore_par_sacchetto selezionato per id
 * @param unknown $idParametro
 * @param unknown $idParametroOld
 * @return resource
 */
function updateIdParSacValSac($idParametro, $idParametroOld){
	$sqlString= "UPDATE serverdb.valore_par_sacchetto 
						SET 
              id_par_sac = " . $idParametro . "
						WHERE 
							id_par_sac='" . $idParametroOld . "'";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_sacchetto - FUNCTION updateIdParSacValSac - ".$sqlString ." ". mysql_error());
	return $sql;
}






/**
 * Conta il numero di record associati al parametro
 * @param unknown $idParametro
 * @return resource
 */
function selectCountValParSaccByIdPar($idParametro){
	$sqlString= "SELECT COUNT(id_cat) AS num_cat_ass
                                            FROM 
                                                serverdb.valore_par_sacchetto 
                                            WHERE 
						id_par_sac='" . $idParametro . "'
                                            GROUP BY 
                                                id_cat";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_sacchetto - FUNCTION selectCountValParSaccByIdPar - ".$sqlString ." ". mysql_error());
	return $sql;
}


/**
 * Conta il numero di record associati alla categoria
 * @param unknown $idCategoria
 * @return resource
 */
function selectCountValParSaccByIdCat($idCategoria){
	$sqlString= "SELECT COUNT(id_par_sac) AS num_par_ass
                                            FROM 
                                                serverdb.valore_par_sacchetto 
                                            WHERE 
						id_cat='" . $idCategoria . "'
                                            GROUP BY 
                                                id_par_sac";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_sacchetto - FUNCTION selectCountValParSaccByIdCat - ".$sqlString ." ". mysql_error());
	return $sql;
}


/**
 * Inserisce un nuovo record
 * @param unknown $idParametro
 * @param unknown $idCat
 * @param unknown $id_num_sac
 * @param unknown $i
 * @param unknown $valoreBase
 * @param unknown $dataCorrente
 * @return resource
 */
function insertNewValoreParSac($idParametro, $idCat, $id_num_sac, $i, $valoreBase, $dataCorrente){
	$sqlString= "INSERT INTO serverdb.valore_par_sacchetto
								(	
							 	id_par_sac,
								id_cat,
								id_num_sac,
								sacchetto,
								valore_variabile,
								abilitato,
								dt_abilitato)
							VALUES(
								   " . $idParametro . ",
									" . $idCat . ",
									" . $id_num_sac . ",
									" . $i . ",
									'" . $valoreBase . "',
									1,
									'" . $dataCorrente . "')";

	$sql = mysql_query($sqlString);
	//or die("ERROR IN script_valore_par_sacchetto - FUNCTION insertNewValoreParSac - ".$sqlString ." ". mysql_error());
	return $sql;
}









/**
 * Seleziona un record per idParametro e idCategoria
 * @param unknown $idParametro
 * @param unknown $idCat
 * @return resource
 */
function findValoreParSacByIdParIdCat($idParametro, $idCat){
	$sqlString= "SELECT * FROM serverdb.valore_par_sacchetto
								WHERE
							 	id_par_sac=" . $idParametro . "
                                                                    AND 
                                                                	id_cat=" . $idCat;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_sacchetto - FUNCTION findValoreParSacByIdParIdCat - ".$sqlString ." ". mysql_error());
	return $sql;
}

function duplicaSoluzioneInsaccoPerCategoria($idCatOld,$idNumSacOld,$idCatNew,$idNumSacNew){
    
$sqlString="INSERT INTO serverdb.valore_par_sacchetto (id_par_sac,id_cat,id_num_sac,sacchetto,valore_variabile,abilitato)
SELECT id_par_sac,".$idCatNew.",".$idNumSacNew.",sacchetto,valore_variabile,1 FROM serverdb.valore_par_sacchetto WHERE id_cat=".$idCatOld." AND id_num_sac=".$idNumSacOld;


$sql = mysql_query($sqlString);
//	or die("ERROR IN script_valore_par_sacchetto - FUNCTION duplicaSoluzioneInsaccoPerCategoria - ".$sqlString ." ". mysql_error());
	return $sql;
}


//function selectNomeIdCatByIdPar($idParametro){
//	$sqlString= "SELECT 
//                            categoria.nome_categoria,
//                            valore_par_sacchetto.id_cat
//                        FROM
//                                    serverdb.valore_par_sacchetto
//                        INNER JOIN serverdb.categoria 
//                        ON 
//                                valore_par_sacchetto.id_cat = categoria.id_cat
//                        WHERE 
//                                valore_par_sacchetto.id_par_sac=" . $idParametro . "
//                        GROUP BY 
//                                categoria.nome_categoria
//                        ORDER BY 
//                                categoria.nome_categoria";
//
//	$sql = mysql_query($sqlString)
//	or die("ERROR IN script_valore_par_sacchetto - FUNCTION selectNomeIdCatByIdPar - ".$sqlString ." ". mysql_error());
//	return $sql;
//}


function selectValoriByIdCatNumSacchi($idCategoria,$numSacchi){
	$sqlString= "SELECT 
                                *
                        FROM
                            serverdb.valore_par_sacchetto v
                        JOIN serverdb.num_sacchetto n
                        ON 
                                        v.id_num_sac =n.id_num_sac 
                        JOIN serverdb.parametro_sacchetto p
                        ON 
                                        p.id_par_sac=v.id_par_sac                 
                        WHERE 
                                        v.id_cat=".$idCategoria."
                        AND
                                        n.num_sacchetti=".$numSacchi."
                        
                        ORDER BY sacchetto,p.ordine";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_sacchetto - FUNCTION selectValoriByIdCatNumSacchi - ".$sqlString ." ". mysql_error());
	return $sql;
}


function selectValoriBySoluzione($idCategoria,$numSacchi,$tipo,$sacco){
	 $sqlString= "SELECT 
                                *
                        FROM
                            serverdb.valore_par_sacchetto v
                        JOIN serverdb.num_sacchetto n
                        ON 
                            v.id_num_sac =n.id_num_sac 
                        JOIN serverdb.parametro_sacchetto p
                        ON 
                            p.id_par_sac=v.id_par_sac                 
                        WHERE 
                            v.id_cat=".$idCategoria."
                        AND
                            n.num_sacchetti=".$numSacchi."
                        AND 
                            sacchetto=".$sacco."
                        AND 
                            p.tipo = '".$tipo."'               
                        ORDER BY sacchetto,p.ordine";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_sacchetto - FUNCTION selectValoriByIdCatNumSacchi - ".$sqlString ." ". mysql_error());
	return $sql;
}


function updateServerdbValSacByIdVal($idValParSac, $valore){
	$sqlString= "UPDATE serverdb.valore_par_sacchetto  
                                SET 
                                        dt_abilitato=if(valore_variabile!='" . $valore . "',NOW(),dt_abilitato),    
                                        valore_variabile=if(valore_variabile!='" . $valore . "','" . $valore . "',valore_variabile)
                                WHERE
                                        id_val_par_sac=" . $idValParSac ;

	$sql = mysql_query($sqlString);
//	or die("ERROR IN script_valore_par_sacchetto - FUNCTION updateServerdbValSacByIdVal - ".$sqlString ." ". mysql_error());
	return $sql;
}



function storicizzaValoreParSac($idValParSac){
	$sqlString= "INSERT INTO storico.valore_par_sacchetto	
                                (id_val_par_sac,
                                    id_par_sac,
                                    id_cat,
                                    id_num_sac,
                                    sacchetto,
                                    valore_variabile,
                                    abilitato,
                                    dt_abilitato)
                        SELECT id_val_par_sac,
                            id_par_sac,
                            id_cat,
                            id_num_sac,
                            sacchetto,
                            valore_variabile,
                            abilitato,
                            NOW() FROM serverdb.valore_par_sacchetto
                        WHERE id_val_par_sac=".$idValParSac;

	$sql = mysql_query($sqlString);
//	or die("ERROR IN script_valore_par_sacchetto - FUNCTION storicizzaValoreParSac - ".$sqlString ." ". mysql_error());
	return $sql;
}





function selectValoriSaccoBySoluzioneCat($idCategoria,$numSacchi,$sacco){
	 $sqlString= "SELECT 
                                v.id_val_par_sac,v.id_par_sac,v.valore_variabile,p.tipo
                        FROM
                            serverdb.valore_par_sacchetto v
                        JOIN serverdb.num_sacchetto n
                        ON 
                            v.id_num_sac =n.id_num_sac 
                        JOIN serverdb.parametro_sacchetto p
                        ON 
                            p.id_par_sac =v.id_par_sac
                                         
                        WHERE 
                            v.id_cat=".$idCategoria."
                        AND
                            n.num_sacchetti=".$numSacchi."
                        AND 
                            sacchetto=".$sacco."
                                   
                        ORDER BY p.ordine";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_sacchetto - FUNCTION selectValoriSaccoBySoluzioneCat - ".$sqlString ." ". mysql_error());
	return $sql;
}

function updateServerdbValoriSacco($idCategoria,$numSacchi,$idParametro, $sacco, $valore){
	$sqlString= "UPDATE serverdb.valore_par_sacchetto v
                        JOIN serverdb.num_sacchetto n
                        ON 
                            v.id_num_sac =n.id_num_sac 
                                SET 
                                        v.valore_variabile=if(v.valore_variabile!='" . $valore . "','" . $valore . "',v.valore_variabile),
                                        v.dt_abilitato=if(v.valore_variabile!='" . $valore . "',NOW(),v.dt_abilitato)    
                                WHERE 
                                    v.id_cat=".$idCategoria."
                                AND
                                    n.num_sacchetti=".$numSacchi."
                                AND
                                    v.id_par_sac=".$idParametro."
                                AND 
                                    sacchetto=".$sacco;

	$sql = mysql_query($sqlString);
//	or die("ERROR IN script_valore_par_sacchetto - FUNCTION updateServerdbValoriSacco - ".$sqlString ." ". mysql_error());
	return $sql;
}

?>