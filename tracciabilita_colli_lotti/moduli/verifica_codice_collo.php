<?php 
	include('../../Connessioni/serverdb.php'); 
	include("../../tracciabilita_colli_lotti/sql/query.php");

    $codiceColloInserito = $_GET['codCollo']; 
	$index=0; 
	$qres = "";
	$result = verificaCollo($codiceColloInserito);
	while($row = mysql_fetch_array($result)) {  
					$qres = $row['codice_collo'];
					$index++;  
	} 

	 echo json_encode($qres);
 
?>
