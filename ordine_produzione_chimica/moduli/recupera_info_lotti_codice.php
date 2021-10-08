<?php 
	include('../../Connessioni/serverdb.php'); 
	include("../../ordine_produzione_chimica/sql/query.php");
 
	$arrayCodici = [];  
 	$codiceFormula = $_GET['codFormula'];    
  
	$qres = [];   
	$sqlres = recuperaLottiCodice($codiceFormula); 

	while ($res = mysql_fetch_array($sqlres)) {  
		array_push($qres, $res['cod_lotto']);
	} 

	echo json_encode($qres);
	
 
?>
