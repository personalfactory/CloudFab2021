<?php 
	include('../../Connessioni/serverdb.php'); 
	include("../../ordine_produzione_chimica/sql/query.php");
 
	$arrayCodici = [];  
 	$codiciFormula = $_GET['codFormula'];   
	$arrayQuantita = [];
	$quantita = $_GET['quantita'];  

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

	$temp="";
	for ($i = 0; $i<strlen($quantita); $i++) { 
		if($quantita[$i]===','){ 
			array_push($arrayQuantita, $temp); 
			$temp = "";
		} else {
			$temp = $temp.$quantita[$i];   
		}
	} 
   	array_push($arrayQuantita, $temp);

 
	$qres = array();
	for ($j = 0; $j<count($arrayCodici); $j++) { 
		$sqlres = recuperaDatiFormulaProdotti($arrayCodici[$j]); 
			while ($res = mysql_fetch_array($sqlres)) {   
				$q = $res['quantita'] * $arrayQuantita[$j]; 
				$p = $res['pre_acq'];
				array_push($qres, $res['cod_mat'] . "%" . $res['descri_mat']. "%" . $res['giacenza_attuale']. "%" . $q . "%" . $p . "%" . $res['scorta_minima']. "%" . $res['num_lotti']. "%" . $res['fornitore']);
			} 
	}
	echo json_encode($qres);
	
 
?>
