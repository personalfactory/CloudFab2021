<?php 
	include('../../Connessioni/serverdb.php'); 
	include("../../ordine_produzione_chimica/sql/query.php");
 
	$arrayCodici = [];  
 	$codiciFormula = $_GET['codFormula'];     

	//decodifca array
	for ($i = 0; $i<strlen($codiciFormula); $i++) { 
		if($codiciFormula[$i]===','){ 
			array_push($arrayCodici, $temp); 
			$temp = "";
		} else {
			$temp = $temp.$codiciFormula[$i];   
		}
	} 
   	array_push($arrayCodici, $temp);  
  
	$qres = array();
	for ($j = 0; $j<count($arrayCodici); $j++) { 
		$sqlres = recuperaNumeroLottiCodice($arrayCodici[$j]); 
	 
		while ($res = mysql_fetch_array($sqlres)) {  
			array_push($qres, $res['Count(*)']);
		} 
		 
	}
	echo json_encode($qres);
	
 
?>
