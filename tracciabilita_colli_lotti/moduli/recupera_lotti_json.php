<?php 
	include('../../Connessioni/serverdb.php'); 
	include("../../tracciabilita_colli_lotti/sql/query.php");

    $codiceCollo = $_GET['codCollo']; 
	$index=0; 
	$qres = [];
	$result = recuperaLottiColloCodice($codiceCollo);
	while($row = mysql_fetch_array($result)) {  
					//$qres = $qres.($row['cod_lotto'])."-";
					$qres[$index] = $row['cod_lotto'];
					$index++;  
	} 

   echo json_encode($qres);
 
?>
