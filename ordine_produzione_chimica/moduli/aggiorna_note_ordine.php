<?php 
	
	include('../../Connessioni/serverdb.php'); 
	include("../../ordine_produzione_chimica/sql/query.php");

 	$datiNoteOrdine = json_decode($_GET['dati_aggiorna_ordine']); 
	 
	updateNote($datiNoteOrdine);
 

?>