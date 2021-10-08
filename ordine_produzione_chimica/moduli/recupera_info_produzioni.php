<?php 
	include('../../Connessioni/serverdb.php'); 
	include("../../ordine_produzione_chimica/sql/query.php");
 
	$qres = array();
	$sqlres = recuperaElencoProdottiChimica(); 
			while ($res = mysql_fetch_array($sqlres)) {   
				array_push($qres, $res['codice'] . "-" . $res['descri']);
			}
   
	echo json_encode($qres);
 
?>