<?php
/**
 * Seleziona tutti i tipi di figure dalla tabella figura_tipo
 * @param type $filtroOrdinamento
 * @param type $abilitato
 * @return type
 */
function findAllTipoFigure($filtroOrdinamento,$abilitato){
	$sqlString="SELECT * FROM serverdb.figura_tipo 
                        WHERE 
                                abilitato=".$abilitato."
                        ORDER BY ".$filtroOrdinamento;
	
	$sql = mysql_query($sqlString)
	or die("ERROR IN script_figura_tipo.php - FUNCTION findAllTipoFigure - ".$sqlString ." ". mysql_error());
 return $sql;
}
?>
