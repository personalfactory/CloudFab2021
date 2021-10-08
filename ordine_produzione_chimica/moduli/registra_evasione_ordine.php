<?php 
	
	include('../../Connessioni/serverdb.php'); 
	include("../../ordine_produzione_chimica/sql/query.php");

 	$datiEvasione = json_decode($_GET['dati_evasione']); 
	
	echo $datiEvasione[0]; 

	updateEvasione($datiEvasione[0],$datiEvasione[1],$datiEvasione[2],$datiEvasione[3]);
 

?>