<?php

/**
 * Seleziona dalla tabella lotto le informazioni di un dato lotto di chimica
 * @param type $codiceLotto
 * @return type
 */
function findLottoByCodLotto($codiceLotto) {
    $stringSql = "SELECT  * FROM serverdb.lotto
                        WHERE
                                lotto.cod_lotto='" . $codiceLotto . "'";
    $sql = mysql_query($stringSql) or die("ERROR IN script_lotto.php - FUNCTION findLottoByCodLotto - " . $stringSql . " " . mysql_error());
    return $sql;
}


function findLottiByIdMiscela($idMiscela) {
    
    $stringSql = "SELECT lotto.cod_lotto
                     FROM
                        serverdb.lotto
                      INNER JOIN serverdb.chimica 
                      ON 
                         lotto.cod_lotto = chimica.cod_lotto
                      INNER JOIN serverdb. sacchetto_chimica 
                      ON 
                         chimica.cod_chimica = sacchetto_chimica.cod_chimica
                      WHERE 
                         sacchetto_chimica.id_miscela=" . $idMiscela . "
                      GROUP BY 
                            lotto.cod_lotto";
    $sql = mysql_query($stringSql) or die("ERROR IN script_lotto.php - FUNCTION findLottoByCodLotto - " . $stringSql . " " . mysql_error());
    return $sql;
    
    
}

/**
 * Inserisce un nuovo lotto nella tabella lotto di serverdb
 * @param type $codLotto
 * @param type $descriLotto
 * @param type $dataLotto
 * @return type
 */
function inserisciNuovoLotto($codLotto,$descriLotto,$dataLotto,$stato){
    
    $stringSql="INSERT INTO serverdb.lotto						 										
				(cod_lotto, descri_lotto,dt_lotto,parent) 
					VALUES(
          '" . $codLotto . "','" . $descriLotto . "','" . $dataLotto . "','".$stato."')";
    $sql = mysql_query($stringSql);
//    or die("ERROR IN script_lotto.php - FUNCTION inserisciNuovoLotto - " . $stringSql . " " . mysql_error());
    
    return $sql;
}



function modificaCodLotto($codiceOld,$codiceNew){
  
    $sql=   mysql_query("UPDATE serverdb.lotto SET 
                            cod_lotto= if(cod_lotto != '" . $codiceNew . "','" . $codiceNew . "',codice),
                           
                        WHERE cod_lotto ='".$codiceOld."'")
     or  die("ERROR IN script_lotto.php - FUNCTION modificaCodLotto - UPDATE serverdb.lotto  : " . mysql_error());
    return $sql;
    
    
}


function findLottiNonAssociatiInLotto(){
    
    $stringSql="SELECT * FROM serverdb.lotto WHERE lotto.id_bolla is null";
       
    $sql = mysql_query($stringSql)
    or die("ERROR IN script_lotto.php - FUNCTION findLottiNonAssociati - " . $stringSql . " " . mysql_error());
    
    return $sql;
}


function updateLottoAssociaDdt($idBolla,$numDdt,$dataEmi,$codiceLotto,$valParent){

$stringSql = "UPDATE serverdb.lotto 
                      SET 
                        id_bolla=" . $idBolla . ",
                        num_bolla='" . $numDdt . "',
                        dt_bolla='" . $dataEmi . "',
                        parent='".$valParent."'    
                      WHERE 
                        cod_lotto = '" . $codiceLotto . "'
                      AND 
                        id_bolla is null
                      AND 
                        num_bolla is null
                      AND 
                        dt_bolla is null";
                  
echo $stringSql;
$sql = mysql_query($stringSql);
//    or die("ERROR IN script_lotto.php - FUNCTION updateLottoAssociaDdt - " . $stringSql . " " . mysql_error());
    
    return $sql;

}



function findLottiVenduti($codiceLotto,$dtBolla) {
    $stringSql = "SELECT  COUNT(*) as lotti_venduti FROM serverdb.lotto
                        WHERE
                                cod_lotto LIKE '" . $codiceLotto . "%' "
            . "AND dt_bolla LIKE '%".$dtBolla."%'"
            . "AND id_bolla IS NOT NULL";
    $sql = mysql_query($stringSql) or die("ERROR IN script_lotto.php - FUNCTION findLottiVenduti - " . $stringSql . " " . mysql_error());
    return $sql;
}



function updateStatoLotto($codiceLotto,$stato){
    
    $stringSql="UPDATE serverdb.lotto SET 
                            parent='".$stato."',
                            dt_bolla=NOW()    
                        WHERE cod_lotto ='".$codiceLotto."'";
    $sql=   mysql_query($stringSql)
     or  die('ERROR IN script_lotto.php - FUNCTION updateStatoLotto -  : ' .$stringSql.' '. mysql_error());
    return $sql;
    
    
}


function findLottoByStato($codiceLotto,$stato) {
    $stringSql = "SELECT  * FROM serverdb.lotto
                        WHERE
                            cod_lotto='" . $codiceLotto . "'"
                 . " AND parent='".$stato."'";
    $sql = mysql_query($stringSql) or die("ERROR IN script_lotto.php - FUNCTION findLottoByCodLotto - " . $stringSql . " " . mysql_error());
    return $sql;
}


?>
