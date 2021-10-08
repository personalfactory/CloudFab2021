<?php 
	
	include('../../Connessioni/serverdb.php'); 
	include("../../ordine_produzione_chimica/sql/query.php");

 	$datiAbilita = json_decode($_GET['dati_abilita']); 
	 
	date_default_timezone_set('UTC');
	$dt_abilitato = date('Y-m-d H:i:s');

	updateAbilita($datiAbilita[0],$datiAbilita[1],$datiAbilita[2],$dt_abilitato);
 

?>