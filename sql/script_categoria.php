<?php
//Tabelle coinvolte
//categoria
//num_sacchetto (da spostare)

/**
 * Seleziona tutti i record dalla tabella categoria ordinati per $filtroOrdinamento
 * visibili all'utente
 * @param unknown $filtroOrdinamento
 * @return resource
 */
function findAllCategorieVis($filtroOrdinamento,$strUtentiAziende){
	$sqlString="SELECT * FROM serverdb.categoria 
                        WHERE 
                                (id_utente,id_azienda) IN ".  $strUtentiAziende."
                        ORDER BY ".$filtroOrdinamento;
	
	$sql = mysql_query($sqlString)
	or die("ERROR IN script_categoria.php - FUNCTION findAllCategorieVis - ".$sqlString ." ". mysql_error());
 return $sql;
}

/**
 * Seleziona tutte le categorie visibili 
 * @param type $filtroOrdinamento
 * @param type $strUtentiAziende
 * @param type $idCat
 * @param type $nomeCat
 * @param type $descriCat
 * @param type $abilitato
 * @param type $dtAbilitato
 * @return type
 */
function findCategorieVisByFiltri($campoGroupBy,$filtroOrdinamento,$strUtentiAziende,$idCat,$nomeCat,$descriCat,$abilitato,$dtAbilitato){
	$sqlString="SELECT * FROM serverdb.categoria 
                        WHERE 
                            id_cat LIKE '%".$idCat."%'
                        AND 
                            nome_categoria LIKE '%".$nomeCat."%'
                        AND 
                            descri_categoria LIKE '%".$descriCat."%'
                        AND 
                            abilitato LIKE '%" . $abilitato . "%'
                        AND 
                            dt_abilitato LIKE '%" . $dtAbilitato . "%'
                        AND
                            (id_utente,id_azienda) IN ".  $strUtentiAziende."
                        GROUP BY ".$campoGroupBy."                            
                        ORDER BY ".$filtroOrdinamento;
	
	$sql = mysql_query($sqlString)
	or die("ERROR IN script_categoria.php - FUNCTION findCategorieVisByFiltri - ".$sqlString ." ". mysql_error());
 return $sql;
}
/**
 * Seleziona i record dalla tabella categoria con nome=$nomeCategoria
 *  o descrizione=$descriCategoria
 * @param unknown $nomeCategoria
 * @param unknown $descriCategoria
 * @return resource
 */
function findCatByNomeOrDescr($nomeCategoria, $descriCategoria){
	$sqlString="SELECT * FROM serverdb.categoria WHERE nome_categoria = '" . $nomeCategoria . "' OR descri_categoria = '" . $descriCategoria . "'";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_categoria.php - FUNCTION findCatByNomeOrDescr - ".$sqlString ." ". mysql_error());
	return $sql;
}

/**
 * Inserisce un nuovo record nella tabella categoria
 * @param unknown $nomeCategoria
 * @param unknown $descriCategoria
 * @return resource
 */
function insertCategoria($nomeCategoria, $descriCategoria,$idUtente,$idAzienda){
	$sqlString="INSERT INTO serverdb.categoria 
                                    (nome_categoria,
                                    descri_categoria,
                                    abilitato,
                                    id_utente,
                                    id_azienda) 
                                VALUES 
                                    ( '" . $nomeCategoria . "',
                                      '" . $descriCategoria . "',
                                      1,
                                      ".$idUtente.",
                                      ".$idAzienda.")";

	$sql = mysql_query($sqlString);
//	or die("ERROR IN script_categoria.php - FUNCTION insertCategoria - ".$sqlString ." ". mysql_error());
	return $sql;
}


/**
 * Seleziona l'id con valore massimo dalla tabella categoria
 * @return resource
 */
function selectMaxIdCategoria(){
	$sqlString="SELECT MAX(id_cat) AS id_cat FROM serverdb.categoria ";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_categoria.php - selectMaxIdCategoria - ".$sqlString ." ". mysql_error());
	return $sql;
}









/**
 * Trova il record dalla tabella categoria con id scelto
 * @param unknown $idCategoria
 * @return resource
 */
function findCategoriaByID($idCategoria){
	$sqlString="SELECT * FROM serverdb.categoria WHERE id_cat=" . $idCategoria;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_categoria.php - FUNCTION findCategoriaByID - ".$sqlString ." ". mysql_error());
	return $sql;
}

function findCategoriaByNome($nomeCategoria){
	$sqlString="SELECT * FROM serverdb.categoria WHERE nome_categoria='" . $nomeCategoria."'";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_categoria.php - FUNCTION findCategoriaByNome - ".$sqlString ." ". mysql_error());
	return $sql;
}

/**
 * Conta il numero di sacchetti per la categoria selezionata per id
 * @param unknown $idCategoria
 * @return resource
 */
function countNumSacchetti($idCategoria){
//  $sqlSolSac = mysql_query("SELECT COUNT(num_sacchetti) AS sol_sacchetti
//                  FROM
//                  num_sacchetto
//                  WHERE
//                  id_cat=" . $IdCategoria)
//                  or die("ERRORE SELECT COUNT FROM num_sacchetto: " . mysql_error());	
    
    
    $sqlString="SELECT COUNT(num_sacchetti) AS sol_sacchetti
                                        FROM 
                                              serverdb.num_sacchetto 
                                        WHERE 
                                            id_cat=" . $idCategoria;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_categoria.php - FUNCTION countNumSacchetti - ".$sqlString ." ". mysql_error());
	return $sql;
}

/**
 * Seleziona le soluzioni di insacco per una categoria dalla tabella num_sacchetto
 * @param unknown $idCategoria
 * @return resource
 */
function findNumSacByIdCat($idCategoria){
	$sqlString="SELECT id_num_sac,num_sacchetti 
                    FROM 
                            serverdb.num_sacchetto 
                    WHERE 
                            id_cat=" . $idCategoria . " 
                    ORDER BY 
                            num_sacchetti";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_categoria.php - FUNCTION findIdNumSacByIdCat - ".$sqlString ." ". mysql_error());
	return $sql;
}





/**
 * Trova num_sacchetti per la categoria scelta per id
 * @param unknown $idCategoria
 * @return resource
 */
function findNumSacchettiByIdCat($idCategoria){
//$sqlSac = mysql_query("SELECT num_sacchetti FROM serverdb.num_sacchetto 
//                            WHERE 
//                                id_cat=" . $IdCategoria . " 
//                            ORDER BY 
//                                num_sacchetti")
//              or die("Errore 0 : SELECT FROM serverdb.num_sacchetto  " . mysql_error());	
//    
    $sqlString="SELECT num_sacchetti FROM serverdb.num_sacchetto 
                            WHERE 
                                id_cat=" . $idCategoria . " 
                            ORDER BY 
                                num_sacchetti";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_categoria.php - FUNCTION findNumSacchettiByIdCat - ".$sqlString ." ". mysql_error());
	return $sql;
}



/**
 * Trova i record di serverdb.categoria con nome uguale e id diverso da quelli passati
 * @param unknown $idCategoria
 * @param unknown $nomeCategoria
 * @param unknown $connessione
 * @return resource
 */
function findCatByNomeAndID($idCategoria, $nomeCategoria){
 
    
    $sqlString="SELECT * FROM serverdb.categoria 
                WHERE 
                        nome_categoria = '" . $nomeCategoria . "' 
                AND 
                        id_cat<>" . $idCategoria;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_categoria.php - FUNCTION findCatByNomeAndID - ".$sqlString ." ". mysql_error());
	return $sql;
}






/**
 * Inserisce un nuovo record nel db storico
 * @param unknown $idCategoria
 * @return resource
 * @author FR
 */
function insertStoricoCategoria($idCategoria){
    
      
	$sqlString="INSERT INTO storico.categoria 						 										
                                        (id_cat,
                                        nome_categoria,
                                        descri_categoria,
                                        abilitato,
                                        dt_abilitato) 
                                SELECT 
                                        id_cat,
                                        nome_categoria,
                                        descri_categoria,
                                        abilitato,
                                        dt_abilitato
                                FROM 
                                        serverdb.categoria
                                WHERE 
                                        id_cat='" . $idCategoria . "'";

	$sql = mysql_query($sqlString);
//	or die("ERROR IN script_categoria.php - FUNCTION insertStoricoCategoria - ".$sqlString ." ". mysql_error());
	return $sql;
}






/**
 * Aggiorna il record della tabella categoria server db selezionandolo per id
 * @param unknown $idCategoria
 * @param unknown $nomeCategoria
 * @param unknown $descriCategoria
 * @param unknown $idAzienda
 * @return resource
 * @author FR
 */
function updateServerDBCategoria($idCategoria, $nomeCategoria, $descriCategoria,$idAzienda){
    
    
	$sqlString="UPDATE serverdb.categoria 
                            SET 
                                    nome_categoria=if(nome_categoria!='" . $nomeCategoria . "','" . $nomeCategoria . "',nome_categoria),
                                    descri_categoria=if(descri_categoria!='" . $descriCategoria . "','" . $descriCategoria . "',descri_categoria),
                                    id_azienda=if(id_azienda!='" . $idAzienda . "','" . $idAzienda . "',id_azienda)    
                            WHERE 
                                    id_cat='" . $idCategoria . "'";

	$sql = mysql_query($sqlString);
//	or die("ERROR IN script_categoria.php - FUNCTION updateServerDBCategoria - ".$sqlString ." ". mysql_error());
	return $sql;
}




/**
 * Seleziona tutti i record della tabella categoria ordinati per nome
 * @return resource
 */
function findAllCategoriaOrderByNome(){
	$sqlString= "SELECT * FROM serverdb.categoria ORDER BY nome_categoria";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_categoria.php - FUNCTION findAllCategoriaOrderByNome - ".$sqlString ." ". mysql_error());
	return $sql;
}




/**
 * 
 * @return resource
 */
function findCategoriaWhereIdCatNotIn(){
	$sqlString= "SELECT * FROM serverdb.categoria 
                                            WHERE 
                                                id_cat NOT IN (SELECT id_cat FROM valore_par_prod)
                                                ORDER BY nome_categoria";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_categoria.php - FUNCTION findCategoriaWhereIdCatNotIn - ".$sqlString ." ". mysql_error());
	return $sql;
}





/**
 * Seleziona alcuni campi della tabella categoria per id
 * @param unknown $idCategoria
 * @return resource
 */
function selectNomeDescriCatById($idCategoria){
	$sqlString= "SELECT
                                            nome_categoria,
                                            descri_categoria,
                                            dt_abilitato
                                      FROM
                                            serverdb.categoria
                                      WHERE 
                                            id_cat=" . $idCategoria;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_categoria.php - FUNCTION selectNomeDescriCatById - ".$sqlString ." ". mysql_error());
	return $sql;
}




/**
 * Conta il numero di record
 * @return resource
 */
function selectCountCategorie(){
	$sqlString= "SELECT COUNT(id_cat) AS num_cat 
                                            FROM 
                                                serverdb.categoria ";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_categoria.php - FUNCTION selectCountCategorie - ".$sqlString ." ". mysql_error());
	return $sql;
}



/**
 * Seleziona tutte le categorie visibili all'utente aventi un nome diverso da quello dato
 * @param type $nomeCat
 * @param type $filtroOrdinamento
 * @param type $strUtentiAziende
 * @return type
 */
function findAllCategorieDiverseDa($nomeCat,$filtroOrdinamento,$strUtentiAziende){
	$sqlString="SELECT * FROM serverdb.categoria 
                            WHERE 
                                nome_categoria <>'" . $nomeCat . "' 
                            AND 
                                (id_utente,id_azienda) IN ".$strUtentiAziende."
                            ORDER BY ".$filtroOrdinamento;
	
	$sql = mysql_query($sqlString)
	or die("ERROR IN script_categoria.php - FUNCTION findAllCategorieDiverseDa - ".$sqlString ." ". mysql_error());
 return $sql;
}



?>