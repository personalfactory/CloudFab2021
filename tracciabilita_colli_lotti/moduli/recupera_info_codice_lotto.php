<?php 
	include('../../Connessioni/serverdb.php'); 
	include("../../tracciabilita_colli_lotti/sql/query.php");

    $codiceProdotto = $_GET['codLotto'];    
	$qres = "";
	$result = recuperaIdProdottoByCodice($codiceProdotto);
	while($row = mysql_fetch_array($result)) {  
					$qres = $row['id_prodotto']; 
	} 
	$vocabolo = "";
    if ($qres!==""){   
		$result = recuperaDizionarioByIdProdotto($qres);
			while($row = mysql_fetch_array($result)) {  
							$vocabolo = $row['vocabolo'];  
			}  
	}
 
    //echo json_encode($qres." - ".$vocabolo);
	echo json_encode($vocabolo);
 
?>
