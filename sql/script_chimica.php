<?php

/**
 * Seleziona 
 * @param type $codiceLotto
 * @return type
 */
function findChimicaLottoByCodChimica($codiceChimica){
 $stringSql = "SELECT
				   						
                      chimica.descri_formula,
                      chimica.cod_lotto,
                      chimica.descri_formula,
                      lotto.descri_lotto,
                      lotto.dt_lotto,
                      chimica.dt_abilitato,
                      lotto.num_bolla,
                      lotto.dt_bolla                 
				
            FROM
                serverdb.chimica 
            JOIN             
                serverdb.lotto ON lotto.cod_lotto = chimica.cod_lotto

            WHERE 
                chimica.cod_chimica='" . $codiceChimica . "'";
 
 $sql=mysql_query($stringSql) 
 or die("ERROR IN script_chimica.php - FUNCTION findChimicaLottoByCodChimica - ".$stringSql ." ". mysql_error());
 return $sql;
}


function findChimicaByCodice($CodiceChimica){
    $stringSql="SELECT *
                         FROM 
                            serverdb.chimica 
                         WHERE 
                          cod_chimica='" . $CodiceChimica. "'";
    $sql = mysql_query($stringSql) or die("ERROR IN script_chimica.php - FUNCTION findChimicaByCodice - ".$stringSql ." ". mysql_error());
return $sql;
}

/**
 * Seleziona tutti i codici chimica associati ad un dato lotto
 * @param type $codiceLotto
 * @return type
 */
function findKitChimiciByCodLotto($codiceLotto){
 $stringSql = "SELECT
                            chimica.cod_lotto,
                            chimica.cod_chimica,
                            chimica.cod_prodotto,
                            chimica.descri_formula,
                            chimica.data,
                            chimica.dt_abilitato
                        FROM
                            serverdb.chimica
                        WHERE 
                            cod_lotto='" . $codiceLotto . "'" ;
 
 $sql=mysql_query($stringSql) 
 or die("ERROR IN script_chimica.php - FUNCTION findKitChimiciByCodLotto - ".$stringSql ." ". mysql_error());
 return $sql;
}

/**
 * Seleziona tutti i record della tabella chimica tenendo conto dei vari filtri
 * @param type $campoOrdine
 * @param type $campoGroupBy
 * @param type $codChimica
 * @param type $codProd
 * @param type $codLotto
 * @param type $descriFormula
 * @param type $data
 * @param type $dtAbilitato
 * @return type
 */
function findChimicaByFiltri($offset,$rowsPerPage,$campoOrdine,$campoGroupBy,$codChimica,$codProd,$codLotto,$descriFormula,$data,$dtAbilitato){

    $stringSql="SELECT * FROM
                    serverdb.chimica c
                WHERE 
                     cod_chimica LIKE '%" . $codChimica . "%'
                   AND
                    cod_prodotto LIKE '%" . $codProd . "%'
                   AND
                    cod_lotto LIKE '%" . $codLotto . "%'
                   AND
                    descri_formula LIKE '%" . $descriFormula . "%'
                   AND
                    data LIKE '%" . $data . "%'
                   AND
                    dt_abilitato LIKE '%" . $dtAbilitato . "%' 
                   GROUP BY ".$campoGroupBy."
                   ORDER BY ".$campoOrdine."
                   LIMIT ".$rowsPerPage." OFFSET ".$offset;
    $sql = mysql_query($stringSql) 
or die("ERROR IN script_chimica.php - FUNCTION findChimicaByFiltri - " .$stringSql." ". mysql_error());


return $sql;
}

function findChimicaByFiltriTot($campoOrdine,$campoGroupBy,$codChimica,$codProd,$codLotto,$descriFormula,$data,$dtAbilitato){

   $stringSql="SELECT * FROM
                    serverdb.chimica c
                WHERE 
                     cod_chimica LIKE '%" . $codChimica . "%'
                   AND
                    cod_prodotto LIKE '%" . $codProd . "%'
                   AND
                    cod_lotto LIKE '%" . $codLotto . "%'
                   AND
                    descri_formula LIKE '%" . $descriFormula . "%'
                   AND
                    data LIKE '%" . $data . "%'
                   AND
                    dt_abilitato LIKE '%" . $dtAbilitato . "%' 
                   GROUP BY ".$campoGroupBy."
                   ORDER BY ".$campoOrdine;
                   
    $sql = mysql_query($stringSql) 
or die("ERROR IN script_chimica.php - FUNCTION findChimicaByFiltriTot - " .$stringSql." ". mysql_error());


return $sql;
}






/**
 * Seleziona tutti i codici kit relativi ai lotti non ancora associati in base ai vari filtri
 * @param type $campoOrdine
 * @param type $campoGroupBy
 * @param type $codChimica
 * @param type $codProd
 * @param type $codLotto
 * @param type $descriFormula
 * @param type $data
 * @param type $dtAbilitato
 * @return type
 */
function findChimicaDisponibileByFiltri($offset,$rowsPerPage,$campoOrdine,$campoGroupBy,$codChimica,$codProd,$codLotto,$descriFormula,$data,$dtAbilitato){

    $stringSql="SELECT * FROM
                    serverdb.chimica
                WHERE 
                    cod_chimica LIKE '%" . $codChimica . "%'
                   AND
                    cod_prodotto LIKE '%" . $codProd . "%'
                   AND
                    cod_lotto LIKE '%" . $codLotto . "%'
                   AND
                    descri_formula LIKE '%" . $descriFormula . "%'
                   AND
                    data LIKE '%" . $data . "%'
                   AND
                    dt_abilitato LIKE '%" . $dtAbilitato . "%'
                   AND  cod_lotto IN (SELECT cod_lotto FROM serverdb.lotto WHERE num_bolla IS NULL)
                   GROUP BY ".$campoGroupBy."
                   ORDER BY ".$campoOrdine."
                   LIMIT ".$rowsPerPage." OFFSET ".$offset;
    $sql = mysql_query($stringSql) 
or die("ERROR IN script_chimica.php - FUNCTION findChimicaDisponibileByFiltri - " .$stringSql." ". mysql_error());


return $sql;
}


/**
 * Seleziona il numero di tutti i codici kit relativi ai lotti non ancora associati in base ai vari filtri
 * @param type $campoOrdine
 * @param type $campoGroupBy
 * @param type $codChimica
 * @param type $codProd
 * @param type $codLotto
 * @param type $descriFormula
 * @param type $data
 * @param type $dtAbilitato
 * @return type
 */
function findChimicaDisponibileByFiltriTot($campoOrdine,$campoGroupBy,$codChimica,$codProd,$codLotto,$descriFormula,$data,$dtAbilitato){

     $stringSql="SELECT * FROM
                    serverdb.chimica
                WHERE 
                    cod_chimica LIKE '%" . $codChimica . "%'
                   AND
                    cod_prodotto LIKE '%" . $codProd . "%'
                   AND
                    cod_lotto LIKE '%" . $codLotto . "%'
                   AND
                    descri_formula LIKE '%" . $descriFormula . "%'
                   AND
                    data LIKE '%" . $data . "%'
                   AND
                    dt_abilitato LIKE '%" . $dtAbilitato . "%'
                   AND  cod_lotto IN (SELECT cod_lotto FROM serverdb.lotto WHERE num_bolla IS NULL)
                   GROUP BY ".$campoGroupBy."
                   ORDER BY ".$campoOrdine;
          $sql = mysql_query($stringSql) 
or die("ERROR IN script_chimica.php - FUNCTION findChimicaDisponibileByFiltriBis - " .$stringSql." ". mysql_error());


return $sql;
}

/**
 * Seleziona le  informazioni di un dato kit chimico
 * @param type $codiceChimica
 * @return type
 */
function findKitByCodice($codiceChimica){
 $stringSql = "SELECT * FROM serverdb.chimica 
                INNER JOIN serverdb.lotto 
                ON 
                    chimica.cod_lotto=lotto.cod_lotto
                WHERE cod_chimica='" . $codiceChimica . "'";
                    
  $sql = mysql_query($stringSql) 
or die("ERROR IN script_chimica.php - FUNCTION findLottoKitByCodKit - " .$stringSql." ". mysql_error());


return $sql;
}


/**
 * Inserisce un nuovo kit nella tabella chimica di serverdb
 * @param type $codLotto
 * @param type $descriLotto
 * @param type $dataLotto
 * @return type
 */
function inserisciNuovoKit($codiceChimica,$descriFormula,$dataAttuale,$codProdotto,$codLotto){
        
    $stringSql="INSERT INTO serverdb.chimica						 										
                          (cod_chimica,
                          descri_formula,
                          data,
                          cod_prodotto,
                          cod_lotto) 
                      VALUES(
                        '" . $codiceChimica . "',
                        '" . $descriFormula . "',
                        '" . $dataAttuale . "',
                        '" . $codProdotto . "',
                        '" . $codLotto . "')";
    
    $sql = mysql_query($stringSql);
//    or die("ERROR IN script_lotto.php - FUNCTION inserisciNuovoKit - " . $stringSql . " " . mysql_error());
    return $sql;
}



function countTotKitByFiltri($codChimica,$codProd,$codLotto,$descriFormula,$data,$dtAbilitato){

   $stringSql="SELECT COUNT(*) AS num_kit FROM
                    serverdb.chimica c
                WHERE 
                     cod_chimica LIKE '%" . $codChimica . "%'
                   AND
                    cod_prodotto LIKE '%" . $codProd . "%'
                   AND
                    cod_lotto LIKE '%" . $codLotto . "%'
                   AND
                    descri_formula LIKE '%" . $descriFormula . "%'
                   AND
                    data LIKE '%" . $data . "%'
                   AND
                    dt_abilitato LIKE '%" . $dtAbilitato . "%' 
                   AND
                    LENGTH(cod_chimica)=17";
                   
    $sql = mysql_query($stringSql) 
or die("ERROR IN script_chimica.php - FUNCTION countTotKitByFiltri - " .$stringSql." ". mysql_error());


return $sql;
}
//function countTotKitInSfusaByFiltri($codChimica,$codProd,$codLotto,$descriFormula,$data,$dtAbilitato){
//
//   $stringSql="SELECT SUM(SUBSTRING_INDEX(cod_chimica, '.', -1)) AS num_kit_sfusa FROM
//                    serverdb.chimica c
//                WHERE 
//                     cod_chimica LIKE '%" . $codChimica . "%'
//                   AND
//                    cod_prodotto LIKE '%" . $codProd . "%'
//                   AND
//                    cod_lotto LIKE '%" . $codLotto . "%'
//                   AND
//                    descri_formula LIKE '%" . $descriFormula . "%'
//                   AND
//                    data LIKE '%" . $data . "%'
//                   AND
//                    dt_abilitato LIKE '%" . $dtAbilitato . "%' 
//                   AND
//                     cod_chimica LIKE '%.%'";
//                   
//    $sql = mysql_query($stringSql) 
//or die("ERROR IN script_chimica.php - FUNCTION countTotKitInSfusaByFiltri - " .$stringSql." ". mysql_error());
//
//
//return $sql;
//}

function countTotKitInSfusaByFiltri($codChimica,$codProd,$codLotto,$descriFormula,$data,$dtAbilitato){

   $stringSql="SELECT COUNT(*) AS num_kit_sfusa FROM
                    serverdb.chimica c
                WHERE 
                     cod_chimica LIKE '%" . $codChimica . "%'
                   AND
                    cod_prodotto LIKE '%" . $codProd . "%'
                   AND
                    cod_lotto LIKE '%" . $codLotto . "%'
                   AND
                    descri_formula LIKE '%" . $descriFormula . "%'
                   AND
                    data LIKE '%" . $data . "%'
                   AND
                    dt_abilitato LIKE '%" . $dtAbilitato . "%' 
                   AND
                     cod_chimica LIKE '%.%'";
                   
    $sql = mysql_query($stringSql) 
or die("ERROR IN script_chimica.php - FUNCTION countTotKitInSfusaByFiltri - " .$stringSql." ". mysql_error());


return $sql;
}
?>
