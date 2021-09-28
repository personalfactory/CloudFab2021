<?php

/**
 * Verifica se è presente in tabella una data soluzione di insacco per una categoria
 * @param unknown $idCat
 * @return resource
 */
function findSoluzioneByIdCat($idCat,$numSac){
	$sqlString="SELECT * FROM serverdb.num_sacchetto 
                        WHERE 
                            id_cat = " . $idCat . "
                        AND
                            num_sacchetti=" . $numSac;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_num_sacchetto.php - FUNCTION findSoluzioneByIdCat - ".$sqlString ." ". mysql_error());
	return $sql;
}


/**
 * Seleziona un campo per id
 * @param unknown $idCat
 * @return resource
 */
function findNumSaccByIdCat($idCat){
	$sqlString="SELECT num_sacchetti	
                        FROM 
                                serverdb.num_sacchetto 
                        WHERE  	
                                id_cat='" . $idCat . "'
                        ORDER BY num_sacchetti";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_num_sacchetto.php - FUNCTION findNumSaccByIdCat - ".$sqlString ." ". mysql_error());
	return $sql;
}


function findSoluzioniByIdCat($idCat,$orderBy){
	$sqlString="SELECT * FROM 
                            serverdb.num_sacchetto 
                        WHERE  	
                                id_cat='" . $idCat . "'
                        ORDER BY ".$orderBy;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_num_sacchetto.php - FUNCTION findSoluzioniByIdCat - ".$sqlString ." ". mysql_error());
	return $sql;
}


/**
 * 
 * @param unknown $idCat
 * @return resource
 */
function selectIdNumSacByIdCat($idCat){
	$sqlString= "SELECT id_num_sac,num_sacchetti FROM serverdb.num_sacchetto 
                                            INNER JOIN 
                                                            serverdb.categoria 
                                                    ON num_sacchetto.id_cat=categoria.id_cat
                                            WHERE 
                                                    num_sacchetto.id_cat='" . $idCat . "'
                                            ORDER BY num_sacchetti";

	$sql = mysql_query($sqlString);
	//or die("ERROR IN script_num_sacchetto.php - FUNCTION selectIdNumSacByIdCat - ".$sqlString ." ". mysql_error());
	return $sql;
}


/**
 * Inserisco un nuovo record in num_sacchetto
 * @param unknown $idCategoria
 * @param unknown $soluzione
 * @return resource
 */
function insertNumSacchetto($idCategoria, $soluzione){
	$sqlString="INSERT INTO serverdb.num_sacchetto 
                (num_sacchetti,id_cat,abilitato) 
                  VALUES 
                 ( '" . $soluzione . "',
                   '" . $idCategoria . "',
                 1)";

	$sql = mysql_query($sqlString);
//	or die("ERROR IN script_categoria.php - FUNCTION insertNumSacchetto - ".$sqlString ." ". mysql_error());
	return $sql;
}


function duplicaNumSacchettoByIdCat($idCatOld,$idCatNew){
     $sqlString="INSERT INTO serverdb.num_sacchetto (num_sacchetti,id_cat,abilitato)
        SELECT num_sacchetti,".$idCatNew.",1 FROM serverdb.num_sacchetto WHERE id_cat=".$idCatOld;
    
    $sql = mysql_query($sqlString);
//	or die("ERROR IN script_categoria.php - FUNCTION duplicaNumSacchettoByIdCat - ".$sqlString ." ". mysql_error());
	return $sql;
    
    
}

?>