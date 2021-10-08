<?php 
	include('../../Connessioni/serverdb.php'); 
	include("../../ordine_produzione_chimica/sql/query.php");
 
	$arrayCodici = [];  
	$sqlres = [];
 	$codiciLotto = json_decode($_GET['codiciLotto']);  

  	date_default_timezone_set('UTC');
	$dataBolla = date('Y-m-d'); 
    
	for ($i=0; $i<count($codiciLotto); $i++){
		echo $codiciLotto[$i];
		array_push($sqlres,disabilitaCodiceLotto($codiciLotto[$i],$dataBolla)); 
	}	
 
	echo json_encode($sqlres);
	
 
?>
