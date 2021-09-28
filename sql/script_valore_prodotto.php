<?php

function generaValoriProdDaProdotto($idParametro,$valoreBase) {
    
    $stringSql = "INSERT INTO serverdb.valore_prodotto 
                    (id_par_prod,
                    id_prodotto,
                    valore_variabile,
                    abilitato,
                    dt_abilitato) 
                SELECT 
                    " . $idParametro . ",
                    id_prodotto,
                    '" . $valoreBase . "',
                    1,
                    NOW()
                FROM
                    serverdb.prodotto";

    $sql = mysql_query($stringSql);
    //or die("ERROR IN script_valore_prodotto.php - FUNCTION generaValoriProdDaProdotto - ".$stringSql ." ". mysql_error());
    return $sql;
}


function insertValoriProdotto($idParProd,$idProdotto,$valore) {
    
    $stringSql = "INSERT INTO serverdb.valore_prodotto 
                    (id_par_prod,
                    id_prodotto,
                    valore_variabile,
                    abilitato,
                    dt_abilitato) 
           VALUES (".$idParProd.",
                    " . $idProdotto . ",
                    '".$valore."',
                    1,
                    NOW())";

    $sql = mysql_query($stringSql);
    //or die("ERROR IN script_valore_prodotto.php - FUNCTION insertValoriProdotto - ".$stringSql ." ". mysql_error());
    return $sql;
}


function selectValoriProdottoByIdProd($idProdotto,$campoOrdine) {
    
    $stringSql = "SELECT * FROM serverdb.valore_prodotto v JOIN serverdb.parametro_prod p ON v.id_par_prod=p.id_par_prod"
            . " WHERE id_prodotto=".$idProdotto." ORDER BY ".$campoOrdine;
    

    $sql = mysql_query($stringSql);
    //or die("ERROR IN script_valore_prodotto.php - FUNCTION insertValoriProdotto - ".$stringSql ." ". mysql_error());
    return $sql;
}


function updateValoriProdotto($idValPr,$valore) {
    
    $stringSql = "UPDATE serverdb.valore_prodotto SET valore_variabile='".$valore."', dt_abilitato=NOW() WHERE id_val_pr=".$idValPr;

    $sql = mysql_query($stringSql);
    //or die("ERROR IN script_valore_prodotto.php - FUNCTION updateValoriProdotto - ".$stringSql ." ". mysql_error());
    return $sql;
}

/**
 * Aggiorna il campo id_par_prod e dt_abilitato in serverdb.valore_prodotto
 * @param unknown $idParametro
 * @param unknown $idParametroOld
 * @return resource
 */
function updateParametroProdData($idParametro, $idParametroOld){
	 $sqlString= "UPDATE serverdb.valore_prodotto 
                     SET 
                        dt_abilitato=if(id_par_prod != " . $idParametro . ",NOW(),dt_abilitato)                        
                    WHERE 
                        id_par_prod=" . $idParametroOld;

	$sql = mysql_query($sqlString);
//	or die("ERROR IN script_valore_prodotto - FUNCTION updateParametroProdData - ".$sqlString ." ". mysql_error());
	return $sql;
}


function insertStoricoValoreParProdotto($idProdotto,$abilitato){
	$sqlString= "INSERT INTO storico.valore_prodotto 						 										
                                (id_val_pr,
                                id_par_prod,
                                id_prodotto,
                                valore_variabile,
                                abilitato,
                                dt_abilitato) 
                        SELECT 
                                id_val_pr,
                                id_par_prod,
                                id_prodotto,
                                valore_variabile,
                                ".$abilitato.",
                                dt_abilitato
                        FROM 
                                serverdb.valore_prodotto
                        WHERE 
                                id_prodotto =".$idProdotto;

	$sql = mysql_query($sqlString);
//	or die("ERROR IN script_valore_prodotto.php - insertStoricoValoreParProdotto - ".$sqlString ." ". mysql_error());
	return $sql;
}