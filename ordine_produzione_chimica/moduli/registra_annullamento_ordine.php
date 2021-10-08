<?php 
	
	include('../../Connessioni/serverdb.php'); 
	include("../../ordine_produzione_chimica/sql/query.php");

 	$datiAnnullamento= json_decode($_GET['dati_annullamento']); 
	 	
	updateAnnullamento($datiAnnullamento[0],$datiAnnullamento[1],$datiAnnullamento[2],$datiAnnullamento[3]);
 

?>