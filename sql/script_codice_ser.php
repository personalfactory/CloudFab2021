<?
/**
 * Seleziona tutti i tipi di codici dalla tabella codice
 * @return type
 */
function findAllCodice($campoOrdine){

$sql = mysql_query("SELECT * FROM serverdb.codice ORDER BY ".$campoOrdine) 
        or die("ERROR IN script_codice.php - FUNCTION findAllCodice - SELECT FROM serverdb.codice : " . mysql_error());

return $sql;
}
?>
